<?php
/**
 * Convert legacy Dosei layout shortcodes into native Elementor elements.
 */

add_action( 'add_meta_boxes_page', 'mt_dosei_add_elementor_migration_box' );
add_action( 'admin_post_mt_dosei_convert_to_elementor', 'mt_dosei_convert_page_to_elementor' );
add_action( 'admin_notices', 'mt_dosei_elementor_migration_notice' );

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
	if ( 'builder' === get_post_meta( $post->ID, '_elementor_edit_mode', true ) ) {
		echo '<p>' . esc_html__( 'This page already contains Elementor data. The migration will not overwrite it.', 'mt-dosei-core' ) . '</p>';
		return;
	}

	if ( ! preg_match( '/\[mt-section(?:\s|\])/', $post->post_content ) ) {
		echo '<p>' . esc_html__( 'This page does not contain a Dosei section shortcode to migrate.', 'mt-dosei-core' ) . '</p>';
		return;
	}

	echo '<p>' . esc_html__( 'Convert the Dosei sections and columns on this page into editable Elementor elements. The original page content will be kept.', 'mt-dosei-core' ) . '</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="mt_dosei_convert_to_elementor">';
	echo '<input type="hidden" name="post_id" value="' . esc_attr( $post->ID ) . '">';
	wp_nonce_field( 'mt_dosei_convert_to_elementor_' . $post->ID );
	submit_button( esc_html__( 'Convert to Elementor', 'mt-dosei-core' ), 'primary', 'submit', false );
	echo '</form>';
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

	if ( 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) || get_post_meta( $post_id, '_elementor_data', true ) ) {
		wp_die( esc_html__( 'This page already has Elementor data. It was not changed.', 'mt-dosei-core' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || ! preg_match( '/\[mt-section(?:\s|\])/', $post->post_content ) ) {
		wp_die( esc_html__( 'No Dosei section shortcodes were found on this page.', 'mt-dosei-core' ) );
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
		delete_post_meta( $post_id, '_elementor_data' );
		wp_die( esc_html__( 'Elementor content could not be saved. The original page content is unchanged.', 'mt-dosei-core' ) );
	}

	update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	if ( 'builder' !== get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
		delete_post_meta( $post_id, '_elementor_data' );
		delete_post_meta( $post_id, '_elementor_version' );
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

function mt_dosei_elementor_migration_notice() {
	if ( ! isset( $_GET['mt_dosei_elementor'] ) || ! is_string( $_GET['mt_dosei_elementor'] ) || 'success' !== sanitize_key( $_GET['mt_dosei_elementor'] ) ) {
		return;
	}

	echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Dosei content was converted. Open this page with Elementor to edit its sections and widgets.', 'mt-dosei-core' ) . '</p></div>';
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
		'/\[(\/?)(mt-section|mt-row|mt-column|mt-service)(?=\s|\])([^\]]*)\]/i',
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
		$position = $token['end'];

		if ( $token['closing'] ) {
			$index++;
			if ( $closing_tag && $closing_tag === $token['tag'] ) {
				return $nodes;
			}
			mt_dosei_append_text_node( $nodes, $token['raw'] );
			continue;
		}

		$attributes = shortcode_parse_atts( $token['attributes'] );
		if ( ! is_array( $attributes ) ) {
			$attributes = array();
		}
		$index++;

		$is_self_closing = '/' === substr( rtrim( $token['attributes'] ), -1 );
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
		} else {
			$elements = array_merge( $elements, mt_dosei_build_elementor_widgets( $node['children'] ) );
		}
	}

	return $elements;
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
