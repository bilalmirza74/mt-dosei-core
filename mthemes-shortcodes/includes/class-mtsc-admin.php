<?php
/**
 * Creates the admin interface to add shortcodes to the editor
 *
 * @package MThemes Shortcodes
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * MTSC_Admin class
 */
class MTSC_Admin {

	/**
	 * __construct function
	 *
	 * @access public
	 * @return  void
	 */
	public function __construct() {
		add_action( 'media_buttons', array( $this, 'media_buttons' ), 20 );
		add_action( 'admin_footer', array( $this, 'mtsc_popup_html' ) );
	}

	/**
	 * media_buttons function
	 *
	 * @access public
	 * @return void
	 */
	public function media_buttons( $editor_id = 'content' ) {
		global $pagenow;

		// Only run on add/edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			$output = '<a href="#mtsc-choose-shortcode" class="mtsc-popup button" title="' . esc_html__( 'Insert Shortcode', 'mt-dosei-core' ) . '"><span class="dashicons dashicons-editor-code"></span> ' . esc_html__( 'Insert Shortcode', 'mt-dosei-core' ) . '</a>';
			echo $output;
		}
	}

	/**
	 * Build out the input fields for shortcode content
	 * @param  string $key
	 * @param  array $param the parameters of the input
	 * @return void
	 */
	public function mtsc_build_fields($key, $param) {
		$html = '<tr>';
		if ( ! empty( $param['label'] ) ) {
			$html .= '<td class="label">' . $param['label'] . '</td>';
		}
		switch( $param['type'] ) {
			case 'text' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="text" class="mtsc-form-text mtsc-input" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-default-value="' . $param['std'] . '" />' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'text_fixed' :

				// prepare
				$output = '<input type="hidden" class="mtsc-form-text mtsc-input mtsc-fixed-value" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-default-value="' . $param['std'] . '" />' . "\n";

				// append
				$html .= $output;

				break;

			case 'textarea' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<textarea rows="5" cols="30" name="' . $key . '" id="' . $key . '" class="mtsc-form-textarea mtsc-input" data-default-value="' . $param['std'] . '">' . $param['std'] . '</textarea>' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'number' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="number" class="mtsc-form-text mtsc-input" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-default-value="' . $param['std'] . '" />' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'select' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<select name="' . $key . '" id="' . $key . '" class="mtsc-form-select mtsc-input">' . "\n";

				foreach( $param['options'] as $value => $option ) {
					$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
				}

				$output .= '</select>' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'checkbox' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="checkbox" name="' . $key . '" id="' . $key . '" class="mtsc-form-checkbox mtsc-input"' . ( $param['default'] ? 'checked' : '' ) . '>' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>';

				$html .= $output;

				break;

			case 'colorpicker' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="text" class="mtsc-form-text mtsc-input wp-color-picker-field" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" />' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'iconpicker' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<div class="mtsc-iconpicker">';
					foreach( $param['options'] as $value => $option ) {
						$output .= '<span class="' . $value . '" data-name="' . $value . '"></span>';
					}
				$output .= '</div>';
				$output .= '<input type="text" class="mtsc-form-text mtsc-input mtsc-iconpicker-input" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" />' . "\n";
				$output .= '<span class="mtsc-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			default :
				break;
		}
		$html .= '</tr>';

		return $html;
	}

	/**
	 * Popup window
	 *
	 * Print the footer code needed for the Insert Shortcode Popup
	 *
	 * @since 2.0
	 * @global $pagenow
	 * @return void Prints HTML
	 */
	function mtsc_popup_html() {
		global $pagenow;
		include(MTSC_PLUGIN_DIR . 'includes/config.php');

		// Only run in add/edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) { ?>

			<div id="mtsc-choose-shortcode" class="mfp-hide mtsc-popup-window">

				<h3 id="mtsc-shortcode-title"><?php esc_html_e( 'Choose a shortcode', 'mt-dosei-core' ); ?></h3>

				<div id="mtsc-shortcode-wrap" class="mtsc-shortcode-wrap">

					<div class="mtsc-shortcode-select">
						<label for="mtsc-shortcode"><?php esc_html_e( 'Choose a shortcode', 'mt-dosei-core' ); ?></label>
						<select name="mtsc-shortcode" id="select-mtsc-shortcode">
							<option value=""><?php esc_html_e( 'Select a shortcode', 'mt-dosei-core' ); ?></option>
							<?php foreach( $mthemes_shortcodes as $shortcode ) {
								echo '<option data-title="' . $shortcode['title'] . '" value="' . $shortcode['id'] . '">' . $shortcode['title'] . '</option>';
							} ?>
						</select>
					</div>

				<?php

				$html = '';
				$clone_button = array( 'show' => false );

				// Loop through each shortcode building content
				foreach( $mthemes_shortcodes as $key => $shortcode ) {

					// Add shortcode templates to be used when building with JS
					$shortcode_template = ' data-shortcode-template="' . htmlspecialchars( $shortcode['template'] ) . '"';
					if( array_key_exists('child_shortcode', $shortcode ) ) {
						$shortcode_template .= ' data-shortcode-child-template="' . $shortcode['child_shortcode']['template'] . '"';
					}

					// Individual shortcode 'block'
					$html .= '<div id="' . $shortcode['id'] . '" class="mtsc-shortcode-type" ' . $shortcode_template . '>';

					// If shortcode has children, it can be cloned and is sortable.
					// Add a hidden clone template, and set clone button to be displayed.
					if( array_key_exists('child_shortcode', $shortcode ) ) {
						$html .= (isset($shortcode['child_shortcode']['shortcode']) ? $shortcode['child_shortcode']['shortcode'] : null);
						$shortcode['params'] = $shortcode['child_shortcode']['params'];
						$clone_button['show'] = true;
						$clone_button['text'] = $shortcode['child_shortcode']['clone_button'];
						$html .= '<div class="mtsc-sortable">';
						$html .= '<table id="clone-' . $shortcode['id'] . '" class="hidden mtsc-clone-template"><tbody>';
						foreach( $shortcode['params'] as $key => $param ) {
							$html .= $this->mtsc_build_fields($key, $param);
						}
						if( $clone_button['show'] ) {
							$html .= '<tr><td colspan="2"><a href="#" class="mtsc-remove button">' . esc_html__( 'Remove', 'mt-dosei-core' ) . '</a></td></tr>';
						}
						$html .= '</tbody></table>';
					}

					// Display notes if provided
					if( array_key_exists('intro_text', $shortcode) ) {
						$html .= '<p class="mtsc-notes">' . $shortcode['intro_text'] . '</p>';
					}
					// Build the actual shortcode input fields
					$html .= '<table><tbody>';
					foreach( $shortcode['params'] as $key => $param ) {
						$html .= $this->mtsc_build_fields($key, $param);
					}

					// Add a link to remove a content block
					if( $clone_button['show'] ) {
						$html .= '<tr><td colspan="2"><a href="#" class="mtsc-remove button">' . esc_html__( 'Remove', 'mt-dosei-core' ) . '</a></td></tr>';
					}
					$html .= '</tbody></table>';

					// Close out the sortable div and display the clone button as needed
					if( $clone_button['show'] ) {
						$html .= '</div>';
						$html .= '<a id="add-' . $shortcode['id'] . '" href="#" class="button-secondary clone-content">' . $clone_button['text'] . '</a>';
						$clone_button['show'] = false;
					}

					// Display notes if provided
					if( array_key_exists('notes', $shortcode) ) {
						$html .= '<p class="mtsc-notes">' . $shortcode['notes'] . '</p>';
					}
					$html .= '</div>';
				}

				echo $html;
				?>

				<p class="submit">
					<input type="button" id="mtsc-insert-shortcode" class="button-primary mtsc-popup-dismiss" value="<?php esc_html_e( 'Insert Shortcode', 'mt-dosei-core' ); ?>" onclick="mtscInsertShortcode();" />
					<a href="#" id="mtsc-cancel-shortcode-insert" class="button-secondary mtsc-popup-dismiss mtsc-cancel-shortcode-insert"><?php esc_html_e( 'Cancel', 'mt-dosei-core' ); ?></a>
				</p>
				</div>
			</div>

		<?php
		}
	}
}

new MTSC_Admin();
