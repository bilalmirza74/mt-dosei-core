<?php
/**
 * Convert legacy Dosei layout shortcodes into native Elementor elements.
 */

add_action( 'add_meta_boxes_page', 'mt_dosei_add_elementor_migration_box' );
add_action( 'admin_post_mt_dosei_convert_to_elementor', 'mt_dosei_convert_page_to_elementor' );
add_action( 'admin_post_mt_dosei_restore_elementor_backup', 'mt_dosei_restore_elementor_backup' );
add_action( 'admin_notices', 'mt_dosei_elementor_migration_notice' );
add_action( 'elementor/widgets/register', 'mt_dosei_register_elementor_widgets' );

function mt_dosei_register_elementor_widgets( $widgets_manager ) {
	require_once __DIR__ . '/widgets.php';

	$widgets_manager->register( new MT_Dosei_Elementor_Gallery_Carousel() );
	$widgets_manager->register( new MT_Dosei_Elementor_Accordion() );
	$widgets_manager->register( new MT_Dosei_Elementor_Button() );
}

function mt_dosei_add_elementor_migration_box( $post ) {
	if ( ! did_action( 'elementor/loaded' ) || ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	add_meta_box(
		'mt-dosei-elementor-migration',
		esc_html__( 'Dosei to Elementor', 'mt-dosei-core' ),
		'mt_dosei_render_elementor_migration_box',
		'page',
		'side',
		'default'
	);
}

function mt_dosei_render_elementor_migration_box( $post ) {
	if ( ! preg_match( '/\[mt-section(?:\s|\])/', $post->post_content ) ) {
		echo '<p>' . esc_html__( 'No Dosei section shortcodes were found in this page content. Restore the original page content from Revisions before converting it.', 'mt-dosei-core' ) . '</p>';
		return;
	}

	$has_elementor_data = 'builder' === get_post_meta( $post->ID, '_elementor_edit_mode', true )
		|| get_post_meta( $post->ID, '_elementor_data', true );
	if ( $has_elementor_data ) {
		echo '<p>' . esc_html__( 'This page already has Elementor data. Rebuilding will save a backup of its current Elementor layout first.', 'mt-dosei-core' ) . '</p>';
	} else {
		echo '<p>' . esc_html__( 'Convert the Dosei layout, gallery, accordion panels, and buttons into editable Elementor elements. The original page content will be kept.', 'mt-dosei-core' ) . '</p>';
	}

	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="mt_dosei_convert_to_elementor">';
	echo '<input type="hidden" name="post_id" value="' . esc_attr( $post->ID ) . '">';
	wp_nonce_field( 'mt_dosei_convert_to_elementor_' . $post->ID );
	$button_label = $has_elementor_data
		? esc_html__( 'Back up and rebuild Elementor layout', 'mt-dosei-core' )
		: esc_html__( 'Convert to Elementor', 'mt-dosei-core' );
	submit_button( $button_label, 'primary', 'submit', false );
	echo '</form>';

	$backups = get_post_meta( $post->ID, '_mt_dosei_elementor_backups', true );
	if ( is_array( $backups ) && ! empty( $backups ) ) {
		echo '<hr><p>' . esc_html__( 'A previous Elementor layout backup is available.', 'mt-dosei-core' ) . '</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		echo '<input type="hidden" name="action" value="mt_dosei_restore_elementor_backup">';
		echo '<input type="hidden" name="post_id" value="' . esc_attr( $post->ID ) . '">';
		wp_nonce_field( 'mt_dosei_restore_elementor_backup_' . $post->ID );
		submit_button( esc_html__( 'Restore previous Elementor layout', 'mt-dosei-core' ), 'secondary', 'submit', false );
		echo '</form>';
	}
}

function mt_dosei_convert_page_to_elementor() {
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You are not allowed to convert this page.', 'mt-dosei-core' ) );
	}

	check_admin_referer( 'mt_dosei_convert_to_elementor_' . $post_id );

	if ( 'page' !== get_post_type( $post_id ) ) {
		wp_die( esc_html__( 'Only pages can be converted with this tool.', 'mt-dosei-core' ) );
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		wp_die( esc_html__( 'Elementor must be active before converting this page.', 'mt-dosei-core' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || ! preg_match( '/\[mt-section(?:\s|\])/', $post->post_content ) ) {
		wp_die( esc_html__( 'No Dosei section shortcodes were found in this page content. Restore the original content from Revisions before converting it.', 'mt-dosei-core' ) );
	}

	$existing_elementor_data = get_post_meta( $post_id, '_elementor_data', true );
	$has_elementor_data = 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) || $existing_elementor_data;
	if ( $has_elementor_data ) {
		$backups = get_post_meta( $post_id, '_mt_dosei_elementor_backups', true );
		if ( ! is_array( $backups ) ) {
			$backups = array();
		}
		$backups[] = array(
			'data'       => $existing_elementor_data,
			'version'    => get_post_meta( $post_id, '_elementor_version', true ),
			'edit_mode'  => get_post_meta( $post_id, '_elementor_edit_mode', true ),
			'created_at' => current_time( 'mysql', true ),
		);
		update_post_meta( $post_id, '_mt_dosei_elementor_backups', array_slice( $backups, -5 ) );
		if ( get_post_meta( $post_id, '_mt_dosei_elementor_backups', true ) !== array_slice( $backups, -5 ) ) {
			wp_die( esc_html__( 'The existing Elementor layout could not be backed up, so the page was not changed.', 'mt-dosei-core' ) );
		}
	}

	$elements = mt_dosei_build_elementor_content( $post->post_content );
	if ( empty( $elements ) ) {
		wp_die( esc_html__( 'No editable Elementor elements could be created from this page.', 'mt-dosei-core' ) );
	}

	$encoded_elements = wp_json_encode( $elements );
	if ( false === $encoded_elements ) {
		wp_die( esc_html__( 'The Elementor content could not be encoded. The page was not changed.', 'mt-dosei-core' ) );
	}

	update_post_meta( $post_id, '_elementor_data', wp_slash( $encoded_elements ) );
	if ( $encoded_elements !== get_post_meta( $post_id, '_elementor_data', true ) ) {
		if ( $has_elementor_data ) {
			update_post_meta( $post_id, '_elementor_data', $existing_elementor_data );
		} else {
			delete_post_meta( $post_id, '_elementor_data' );
		}
		wp_die( esc_html__( 'Elementor content could not be saved. The original page content is unchanged.', 'mt-dosei-core' ) );
	}

	$existing_elementor_version = get_post_meta( $post_id, '_elementor_version', true );
	$existing_edit_mode = get_post_meta( $post_id, '_elementor_edit_mode', true );
	update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	if ( 'builder' !== get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
		if ( $has_elementor_data ) {
			update_post_meta( $post_id, '_elementor_data', $existing_elementor_data );
			update_post_meta( $post_id, '_elementor_version', $existing_elementor_version );
			update_post_meta( $post_id, '_elementor_edit_mode', $existing_edit_mode );
		} else {
			delete_post_meta( $post_id, '_elementor_data' );
			delete_post_meta( $post_id, '_elementor_version' );
			delete_post_meta( $post_id, '_elementor_edit_mode' );
		}
		wp_die( esc_html__( 'Elementor could not activate the converted content. The original page content is unchanged.', 'mt-dosei-core' ) );
	}
	clean_post_cache( $post_id );

	$edit_link = add_query_arg(
		array(
			'post'                  => $post_id,
			'action'                => 'edit',
			'mt_dosei_elementor'    => 'success',
		),
		admin_url( 'post.php' )
	);
	wp_safe_redirect( $edit_link );
	exit;
}

function mt_dosei_restore_elementor_backup() {
	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You are not allowed to restore this page.', 'mt-dosei-core' ) );
	}

	check_admin_referer( 'mt_dosei_restore_elementor_backup_' . $post_id );
	$backups = get_post_meta( $post_id, '_mt_dosei_elementor_backups', true );
	if ( ! is_array( $backups ) || empty( $backups ) ) {
		wp_die( esc_html__( 'No Elementor layout backup is available.', 'mt-dosei-core' ) );
	}

	$backup = array_pop( $backups );
	if ( ! is_array( $backup ) || ! array_key_exists( 'data', $backup ) ) {
		wp_die( esc_html__( 'The Elementor layout backup is invalid.', 'mt-dosei-core' ) );
	}

	if ( '' === $backup['data'] ) {
		delete_post_meta( $post_id, '_elementor_data' );
	} else {
		update_post_meta( $post_id, '_elementor_data', $backup['data'] );
	}
	if ( ! empty( $backup['version'] ) ) {
		update_post_meta( $post_id, '_elementor_version', $backup['version'] );
	} else {
		delete_post_meta( $post_id, '_elementor_version' );
	}
	if ( ! empty( $backup['edit_mode'] ) ) {
		update_post_meta( $post_id, '_elementor_edit_mode', $backup['edit_mode'] );
	} else {
		delete_post_meta( $post_id, '_elementor_edit_mode' );
	}
	update_post_meta( $post_id, '_mt_dosei_elementor_backups', $backups );
	clean_post_cache( $post_id );

	$edit_link = add_query_arg(
		array(
			'post'                  => $post_id,
			'action'                => 'edit',
			'mt_dosei_elementor'    => 'restored',
		),
		admin_url( 'post.php' )
	);
	wp_safe_redirect( $edit_link );
	exit;
}

function mt_dosei_elementor_migration_notice() {
	if ( ! isset( $_GET['mt_dosei_elementor'] ) || ! is_string( $_GET['mt_dosei_elementor'] ) ) {
		return;
	}

	$status = sanitize_key( $_GET['mt_dosei_elementor'] );
	if ( 'success' === $status ) {
		$message = esc_html__( 'Dosei content was converted. Open this page with Elementor to edit its sections and widgets.', 'mt-dosei-core' );
	} elseif ( 'restored' === $status ) {
		$message = esc_html__( 'The previous Elementor layout was restored.', 'mt-dosei-core' );
	} else {
		return;
	}

	echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
}

function mt_dosei_build_elementor_content( $content ) {
	$nodes = mt_dosei_parse_shortcode_nodes( $content );
	$sections = array();
	$loose_nodes = array();

	foreach ( $nodes as $node ) {
		if ( 'mt-section' === $node['tag'] ) {
			$section = mt_dosei_build_elementor_section( $node['children'], $node['attributes'] );
			if ( $section ) {
				$sections[] = $section;
			}
		} elseif ( 'mt-row' === $node['tag'] ) {
			$section = mt_dosei_build_elementor_section( array( $node ) );
			if ( $section ) {
				$sections[] = $section;
			}
		} else {
			$loose_nodes[] = $node;
		}
	}

	if ( ! empty( $loose_nodes ) ) {
		$section = mt_dosei_build_elementor_section( $loose_nodes );
		if ( $section ) {
			$sections[] = $section;
		}
	}

	return $sections;
}

function mt_dosei_parse_shortcode_nodes( $content ) {
	preg_match_all(
		'/\[(\/?)(mt-section|mt-row|mt-column|mt-service|mt-gallery-carousel|mt-accordion|mt-accordion-panel|mt-dropcap|mt-button)(?=\s|\])([^\]]*)\]/i',
		$content,
		$matches,
		PREG_SET_ORDER | PREG_OFFSET_CAPTURE
	);

	$tokens = array();
	foreach ( $matches as $match ) {
		$tokens[] = array(
			'raw'        => $match[0][0],
			'closing'    => '/' === $match[1][0],
			'tag'        => strtolower( $match[2][0] ),
			'attributes' => trim( $match[3][0] ),
			'offset'     => $match[0][1],
			'end'        => $match[0][1] + strlen( $match[0][0] ),
		);
	}

	$index = 0;
	$position = 0;
	return mt_dosei_parse_shortcode_sequence( $content, $tokens, $index, $position );
}

function mt_dosei_parse_shortcode_sequence( $content, $tokens, &$index, &$position, $closing_tag = '' ) {
	$nodes = array();
	$content_length = strlen( $content );

	while ( $index < count( $tokens ) ) {
		$token = $tokens[ $index ];
		mt_dosei_append_text_node( $nodes, substr( $content, $position, $token['offset'] - $position ) );

		if ( $token['closing'] ) {
			if ( $closing_tag && $closing_tag === $token['tag'] ) {
				$index++;
				$position = $token['end'];
				return $nodes;
			}
			if ( $closing_tag ) {
				$position = $token['offset'];
				return $nodes;
			}
			$index++;
			$position = $token['end'];
			mt_dosei_append_text_node( $nodes, $token['raw'] );
			continue;
		}

		if ( $closing_tag && $closing_tag === $token['tag'] ) {
			$position = $token['offset'];
			return $nodes;
		}

		$attributes = shortcode_parse_atts( $token['attributes'] );
		if ( ! is_array( $attributes ) ) {
			$attributes = array();
		}
		$index++;
		$position = $token['end'];

		$is_self_closing = in_array( $token['tag'], array( 'mt-gallery-carousel', 'mt-dropcap' ), true )
			|| '/' === substr( rtrim( $token['attributes'] ), -1 );
		$children = $is_self_closing
			? array()
			: mt_dosei_parse_shortcode_sequence( $content, $tokens, $index, $position, $token['tag'] );

		$nodes[] = array(
			'tag'        => $token['tag'],
			'attributes' => $attributes,
			'children'   => $children,
		);
	}

	if ( $position < $content_length ) {
		mt_dosei_append_text_node( $nodes, substr( $content, $position ) );
		$position = $content_length;
	}

	return $nodes;
}

function mt_dosei_append_text_node( &$nodes, $text ) {
	if ( '' === $text ) {
		return;
	}

	$last_index = count( $nodes ) - 1;
	if ( $last_index >= 0 && isset( $nodes[ $last_index ]['text'] ) ) {
		$nodes[ $last_index ]['text'] .= $text;
		return;
	}

	$nodes[] = array( 'text' => $text );
}

function mt_dosei_build_elementor_section( $nodes, $attributes = array() ) {
	$columns = array();
	$loose_nodes = array();

	foreach ( $nodes as $node ) {
		if ( isset( $node['text'] ) && '' === trim( $node['text'] ) ) {
			continue;
		}

		if ( isset( $node['tag'] ) && 'mt-row' === $node['tag'] ) {
			foreach ( $node['children'] as $row_node ) {
				if ( isset( $row_node['tag'] ) && 'mt-column' === $row_node['tag'] ) {
					$columns[] = mt_dosei_build_elementor_column( $row_node['children'], $row_node['attributes'] );
				} else {
					$loose_nodes[] = $row_node;
				}
			}
		} elseif ( isset( $node['tag'] ) && 'mt-column' === $node['tag'] ) {
			$columns[] = mt_dosei_build_elementor_column( $node['children'], $node['attributes'] );
		} else {
			$loose_nodes[] = $node;
		}
	}

	if ( ! empty( $loose_nodes ) ) {
		$loose_elements = mt_dosei_build_elementor_widgets( $loose_nodes );
		if ( ! empty( $loose_elements ) ) {
			$columns[] = mt_dosei_new_elementor_column( $loose_elements, 100 );
		}
	}

	if ( empty( $columns ) ) {
		return false;
	}

	$settings = array(
		'layout' => isset( $attributes['container'] ) && 'no' === $attributes['container'] ? 'full_width' : 'boxed',
		'css_classes' => trim( 'mt-section ' . ( isset( $attributes['xclass'] ) ? $attributes['xclass'] : '' ) ),
	);

	if ( ! empty( $attributes['bgcolor'] ) ) {
		$settings['background_background'] = 'classic';
		$settings['background_color'] = $attributes['bgcolor'];
	}
	if ( ! empty( $attributes['bgimage'] ) ) {
		$settings['background_background'] = 'classic';
		$settings['background_image'] = array( 'url' => $attributes['bgimage'], 'id' => '' );
	}
	if ( ! empty( $attributes['padding'] ) ) {
		$padding = mt_dosei_parse_elementor_padding( $attributes['padding'] );
		if ( $padding ) {
			$settings['padding'] = $padding;
		}
	}

	return array(
		'id'       => mt_dosei_elementor_id(),
		'elType'   => 'section',
		'settings' => $settings,
		'elements' => $columns,
		'isInner'  => false,
	);
}

function mt_dosei_build_elementor_column( $nodes, $attributes = array() ) {
	$size = isset( $attributes['size'] ) ? absint( $attributes['size'] ) : 6;
	$percentage = $size > 0 && $size <= 12 ? (int) round( $size * 100 / 12 ) : 100;
	return mt_dosei_new_elementor_column( mt_dosei_build_elementor_widgets( $nodes ), $percentage );
}

function mt_dosei_new_elementor_column( $elements, $percentage ) {
	return array(
		'id'       => mt_dosei_elementor_id(),
		'elType'   => 'column',
		'settings' => array( '_column_size' => $percentage ),
		'elements' => $elements,
		'isInner'  => false,
	);
}

function mt_dosei_build_elementor_widgets( $nodes ) {
	$elements = array();

	foreach ( $nodes as $node ) {
		if ( isset( $node['text'] ) ) {
			$elements = array_merge( $elements, mt_dosei_text_to_elementor_widgets( $node['text'] ) );
		} elseif ( 'mt-service' === $node['tag'] ) {
			$elements[] = mt_dosei_service_to_elementor_widget( $node );
		} elseif ( 'mt-gallery-carousel' === $node['tag'] ) {
			$elements[] = mt_dosei_new_elementor_widget(
				'dosei-gallery-carousel',
				array(
					'gallery_id' => isset( $node['attributes']['id'] ) ? absint( $node['attributes']['id'] ) : '',
					'height'     => isset( $node['attributes']['height'] ) ? $node['attributes']['height'] : '',
					'effect'     => isset( $node['attributes']['effect'] ) ? $node['attributes']['effect'] : '',
					'margin'     => isset( $node['attributes']['margin'] ) ? $node['attributes']['margin'] : '',
					'caption'    => isset( $node['attributes']['caption'] ) ? $node['attributes']['caption'] : '',
					'exif'       => isset( $node['attributes']['exif'] ) ? $node['attributes']['exif'] : '',
				)
			);
		} elseif ( 'mt-accordion' === $node['tag'] ) {
			$panels = array();
			foreach ( $node['children'] as $panel ) {
				if ( isset( $panel['tag'] ) && 'mt-accordion-panel' === $panel['tag'] ) {
					$panels[] = array(
						'_id'     => mt_dosei_elementor_id(),
						'title'   => isset( $panel['attributes']['title'] ) ? $panel['attributes']['title'] : '',
						'content' => mt_dosei_render_accordion_content( $panel['children'] ),
					);
				}
			}
			if ( ! empty( $panels ) ) {
				$elements[] = mt_dosei_new_elementor_widget( 'dosei-accordion', array( 'panels' => $panels ) );
			}
		} elseif ( 'mt-accordion-panel' === $node['tag'] ) {
			$elements[] = mt_dosei_new_elementor_widget(
				'dosei-accordion',
				array(
					'panels' => array(
						array(
							'_id'     => mt_dosei_elementor_id(),
							'title'   => isset( $node['attributes']['title'] ) ? $node['attributes']['title'] : '',
							'content' => mt_dosei_render_accordion_content( $node['children'] ),
						),
					),
				)
			);
		} elseif ( 'mt-button' === $node['tag'] ) {
			$elements[] = mt_dosei_new_elementor_widget(
				'dosei-button',
				array(
					'text'        => mt_dosei_node_text( $node['children'] ),
					'link'        => array(
						'url'         => isset( $node['attributes']['href'] ) ? $node['attributes']['href'] : '#',
						'is_external' => isset( $node['attributes']['target'] ) && '_blank' === $node['attributes']['target'],
						'nofollow'    => false,
					),
					'size'        => isset( $node['attributes']['size'] ) ? $node['attributes']['size'] : '',
					'radius'      => isset( $node['attributes']['radius'] ) ? $node['attributes']['radius'] : '',
					'block'       => isset( $node['attributes']['block'] ) ? $node['attributes']['block'] : '',
					'target'      => isset( $node['attributes']['target'] ) ? $node['attributes']['target'] : '',
					'icon'        => isset( $node['attributes']['icon'] ) ? $node['attributes']['icon'] : '',
					'icon_align'  => isset( $node['attributes']['icon_align'] ) ? $node['attributes']['icon_align'] : '',
				)
			);
		} elseif ( 'mt-dropcap' === $node['tag'] ) {
			$text = mt_dosei_node_text( $node['children'] );
			if ( '' !== trim( $text ) ) {
				$elements[] = mt_dosei_new_elementor_widget(
					'text-editor',
					array( 'editor' => '<span class="mt-dropcap">' . esc_html( trim( $text ) ) . '</span>' )
				);
			}
		} else {
			$elements = array_merge( $elements, mt_dosei_build_elementor_widgets( $node['children'] ) );
		}
	}

	return $elements;
}

function mt_dosei_node_text( $nodes ) {
	$text = '';
	foreach ( $nodes as $node ) {
		if ( isset( $node['text'] ) ) {
			$text .= $node['text'];
		} elseif ( ! empty( $node['children'] ) ) {
			$text .= mt_dosei_node_text( $node['children'] );
		}
	}
	return trim( $text );
}

function mt_dosei_render_accordion_content( $nodes ) {
	$html = '';
	foreach ( $nodes as $node ) {
		if ( isset( $node['text'] ) ) {
			$html .= wpautop( trim( $node['text'] ) );
		} elseif ( 'mt-button' === $node['tag'] ) {
			$atts = $node['attributes'];
			$classes = array( 'mt-btn' );
			if ( ! empty( $atts['size'] ) ) {
				$classes[] = 'mt-btn-' . sanitize_html_class( $atts['size'] );
			}
			if ( isset( $atts['block'] ) && 'yes' === $atts['block'] ) {
				$classes[] = 'mt-btn-block';
			}
			if ( ! empty( $atts['radius'] ) ) {
				$classes[] = 'mt-btn-' . sanitize_html_class( $atts['radius'] );
			}
			$class_attribute = implode( ' ', $classes );
			$link = isset( $atts['href'] ) ? esc_url( $atts['href'] ) : '#';
			$target = isset( $atts['target'] ) && '_blank' === $atts['target'] ? ' target="_blank" rel="noopener noreferrer"' : '';
			$html .= '<p><a class="' . esc_attr( $class_attribute ) . '" href="' . $link . '"' . $target . '>' . esc_html( mt_dosei_node_text( $node['children'] ) ) . '</a></p>';
		} elseif ( 'mt-dropcap' === $node['tag'] ) {
			$dropcap = mt_dosei_node_text( $node['children'] );
			if ( '' !== $dropcap ) {
				$html .= '<span class="mt-dropcap">' . esc_html( $dropcap ) . '</span>';
			}
		} else {
			$html .= mt_dosei_render_accordion_content( $node['children'] );
		}
	}
	return $html;
}

function mt_dosei_text_to_elementor_widgets( $text ) {
	$elements = array();
	preg_match_all( '/\[[^\]]+\]/', $text, $matches, PREG_OFFSET_CAPTURE );
	$position = 0;

	foreach ( $matches[0] as $match ) {
		$plain_text = substr( $text, $position, $match[1] - $position );
		$elements = array_merge( $elements, mt_dosei_plain_text_to_elementor_widgets( $plain_text ) );
		$elements[] = mt_dosei_new_elementor_widget( 'shortcode', array( 'shortcode' => $match[0] ) );
		$position = $match[1] + strlen( $match[0] );
	}

	$elements = array_merge( $elements, mt_dosei_plain_text_to_elementor_widgets( substr( $text, $position ) ) );
	return $elements;
}

function mt_dosei_plain_text_to_elementor_widgets( $text ) {
	$elements = array();
	$paragraph = array();
	$lines = preg_split( '/\r\n|\r|\n/', trim( $text ) );

	foreach ( $lines as $line ) {
		if ( preg_match( '/^\s*(#{1,6})\s+(.+?)\s*$/', $line, $heading ) ) {
			if ( ! empty( $paragraph ) ) {
				$elements[] = mt_dosei_new_elementor_widget( 'text-editor', array( 'editor' => wpautop( implode( "\n", $paragraph ) ) ) );
				$paragraph = array();
			}
			$level = strlen( $heading[1] );
			$elements[] = mt_dosei_new_elementor_widget(
				'heading',
				array(
					'title'      => $heading[2],
					'header_size' => 'h' . $level,
				)
			);
		} elseif ( '' !== trim( $line ) ) {
			$paragraph[] = $line;
		} elseif ( ! empty( $paragraph ) ) {
			$paragraph[] = '';
		}
	}

	if ( ! empty( $paragraph ) ) {
		$elements[] = mt_dosei_new_elementor_widget( 'text-editor', array( 'editor' => wpautop( implode( "\n", $paragraph ) ) ) );
	}

	return $elements;
}

function mt_dosei_service_to_elementor_widget( $node ) {
	$description = '';
	foreach ( $node['children'] as $child ) {
		if ( isset( $child['text'] ) ) {
			$description .= $child['text'];
		}
	}

	$icon = isset( $node['attributes']['icon'] ) ? $node['attributes']['icon'] : '';
	$icon_class = 'fas fa-info-circle';
	$icon_library = 'fa-solid';
	if ( false !== strpos( $icon, 'map-marker' ) ) {
		$icon_class = 'fas fa-map-marker-alt';
	} elseif ( false !== strpos( $icon, 'call' ) || false !== strpos( $icon, 'phone' ) ) {
		$icon_class = 'fas fa-phone';
	} elseif ( false !== strpos( $icon, 'mail' ) ) {
		$icon_class = 'far fa-envelope';
		$icon_library = 'fa-regular';
	}

	return mt_dosei_new_elementor_widget(
		'icon-box',
		array(
			'title_text'       => isset( $node['attributes']['title'] ) ? $node['attributes']['title'] : '',
			'description_text' => wpautop( trim( $description ) ),
			'selected_icon'    => array( 'value' => $icon_class, 'library' => $icon_library ),
			'position'         => 'left',
			'title_size'       => 'h6',
		)
	);
}

function mt_dosei_parse_elementor_padding( $padding ) {
	$values = preg_split( '/\s+/', trim( $padding ) );
	if ( empty( $values ) || count( $values ) > 4 ) {
		return false;
	}

	$parsed = array();
	foreach ( $values as $value ) {
		if ( ! preg_match( '/^(-?\d+(?:\.\d+)?)(px|%|em|rem|vh|vw)?$/', $value, $match ) ) {
			return false;
		}
		$parsed[] = array( 'value' => $match[1], 'unit' => isset( $match[2] ) && $match[2] ? $match[2] : 'px' );
	}

	if ( 1 === count( $parsed ) ) {
		$expanded = array( $parsed[0], $parsed[0], $parsed[0], $parsed[0] );
	} elseif ( 2 === count( $parsed ) ) {
		$expanded = array( $parsed[0], $parsed[1], $parsed[0], $parsed[1] );
	} elseif ( 3 === count( $parsed ) ) {
		$expanded = array( $parsed[0], $parsed[1], $parsed[2], $parsed[1] );
	} else {
		$expanded = $parsed;
	}

	return array(
		'unit'      => $expanded[0]['unit'],
		'top'       => $expanded[0]['value'],
		'right'     => $expanded[1]['value'],
		'bottom'    => $expanded[2]['value'],
		'left'      => $expanded[3]['value'],
		'isLinked'  => false,
	);
}

function mt_dosei_new_elementor_widget( $widget_type, $settings ) {
	return array(
		'id'         => mt_dosei_elementor_id(),
		'elType'     => 'widget',
		'settings'   => $settings,
		'elements'   => array(),
		'widgetType' => $widget_type,
	);
}

function mt_dosei_elementor_id() {
	return strtolower( wp_generate_password( 7, false, false ) );
}
