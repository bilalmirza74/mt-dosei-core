<?php
/**
 * Editable Elementor widgets that retain Dosei theme output.
 */

if ( ! defined( 'WPINC' ) || ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MT_Dosei_Elementor_Gallery_Carousel extends \Elementor\Widget_Base {
	public function get_name() {
		return 'dosei-gallery-carousel';
	}

	public function get_title() {
		return esc_html__( 'Dosei Gallery Carousel', 'mt-dosei-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array( 'label' => esc_html__( 'Gallery', 'mt-dosei-core' ) )
		);

		$this->add_control(
			'gallery_id',
			array(
				'label'       => esc_html__( 'Gallery ID', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'number',
				'default'     => '',
				'description' => esc_html__( 'Use the ID of a Dosei Gallery item.', 'mt-dosei-core' ),
			)
		);
		$this->add_control(
			'height',
			array(
				'label'   => esc_html__( 'Image height style', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Gallery effect', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$this->add_control(
			'margin',
			array(
				'label'   => esc_html__( 'Image spacing', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 10,
				'min'     => 0,
			)
		);
		$this->add_control(
			'caption',
			array(
				'label'   => esc_html__( 'Captions', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''    => esc_html__( 'Show', 'mt-dosei-core' ),
					'no'  => esc_html__( 'Hide', 'mt-dosei-core' ),
				),
				'default' => '',
			)
		);
		$this->add_control(
			'exif',
			array(
				'label'   => esc_html__( 'EXIF data', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''    => esc_html__( 'Show', 'mt-dosei-core' ),
					'yes' => esc_html__( 'Hide', 'mt-dosei-core' ),
				),
				'default' => '',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$attributes = array(
			'id'      => isset( $settings['gallery_id'] ) ? absint( $settings['gallery_id'] ) : 0,
			'height'  => isset( $settings['height'] ) ? sanitize_text_field( $settings['height'] ) : '',
			'effect'  => isset( $settings['effect'] ) ? sanitize_text_field( $settings['effect'] ) : '',
			'margin'  => isset( $settings['margin'] ) ? absint( $settings['margin'] ) : 10,
			'caption' => isset( $settings['caption'] ) && 'no' === $settings['caption'] ? 'no' : '',
			'exif'    => isset( $settings['exif'] ) && 'yes' === $settings['exif'] ? 'yes' : '',
		);
		echo mt_gallery_carousel( $attributes );
	}
}

class MT_Dosei_Elementor_Accordion extends \Elementor\Widget_Base {
	public function get_name() {
		return 'dosei-accordion';
	}

	public function get_title() {
		return esc_html__( 'Dosei Accordion', 'mt-dosei-core' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Panel title', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion title', 'mt-dosei-core' ),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Panel content', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
			)
		);

		$this->start_controls_section(
			'content_section',
			array( 'label' => esc_html__( 'Accordion panels', 'mt-dosei-core' ) )
		);
		$this->add_control(
			'panels',
			array(
				'label'       => esc_html__( 'Panels', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['panels'] ) || ! is_array( $settings['panels'] ) ) {
			return;
		}

		$content = '';
		foreach ( $settings['panels'] as $panel ) {
			$title = isset( $panel['title'] ) ? $panel['title'] : '';
			$panel_content = isset( $panel['content'] ) ? $panel['content'] : '';
			$content .= mt_accordion_panel( array( 'title' => $title ), $panel_content );
		}
		echo mt_accordion( array(), $content );
	}
}

class MT_Dosei_Elementor_Button extends \Elementor\Widget_Base {
	public function get_name() {
		return 'dosei-button';
	}

	public function get_title() {
		return esc_html__( 'Dosei Button', 'mt-dosei-core' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array( 'label' => esc_html__( 'Button', 'mt-dosei-core' ) )
		);
		$this->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click here', 'mt-dosei-core' ),
				'label_block' => true,
			)
		);
		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => array( 'url' => '#' ),
			)
		);
		$this->add_control(
			'size',
			array(
				'label'   => esc_html__( 'Size', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''   => esc_html__( 'Default', 'mt-dosei-core' ),
					'lg' => esc_html__( 'Large', 'mt-dosei-core' ),
					'sm' => esc_html__( 'Small', 'mt-dosei-core' ),
				),
				'default' => '',
			)
		);
		$this->add_control(
			'radius',
			array(
				'label'   => esc_html__( 'Shape', 'mt-dosei-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'Default', 'mt-dosei-core' ),
					'round' => esc_html__( 'Round', 'mt-dosei-core' ),
				),
				'default' => '',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$link = isset( $settings['link']['url'] ) ? esc_url( $settings['link']['url'] ) : '#';
		$target = ! empty( $settings['link']['is_external'] ) ? '_blank' : '';
		echo mt_button(
			array(
				'href'   => $link,
				'size'   => isset( $settings['size'] ) ? $settings['size'] : '',
				'radius' => isset( $settings['radius'] ) ? $settings['radius'] : '',
				'target' => $target,
			),
			isset( $settings['text'] ) ? $settings['text'] : ''
		);
	}
}

class MT_Dosei_Elementor_Contact_Form extends \Elementor\Widget_Base {
	public function get_name() {
		return 'dosei-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form 7 Form', 'mt-dosei-core' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$options = array();
		if ( post_type_exists( 'wpcf7_contact_form' ) ) {
			$forms = get_posts(
				array(
					'post_type'      => 'wpcf7_contact_form',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				)
			);
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
		}

		$this->start_controls_section(
			'content_section',
			array( 'label' => esc_html__( 'Contact form', 'mt-dosei-core' ) )
		);
		$this->add_control(
			'form_id',
			array(
				'label'       => esc_html__( 'Form', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => $options,
				'default'     => '',
				'description' => empty( $options ) ? esc_html__( 'Activate Contact Form 7 to choose a form.', 'mt-dosei-core' ) : '',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$form_id = isset( $settings['form_id'] ) ? absint( $settings['form_id'] ) : 0;
		if ( ! $form_id || ! shortcode_exists( 'contact-form-7' ) ) {
			return;
		}

		echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );
	}
}

class MT_Dosei_Elementor_Map extends \Elementor\Widget_Base {
	public function get_name() {
		return 'dosei-map';
	}

	public function get_title() {
		return esc_html__( 'Google Maps (WP Go Maps)', 'mt-dosei-core' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return array( 'general' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array( 'label' => esc_html__( 'Map', 'mt-dosei-core' ) )
		);
		$this->add_control(
			'map_id',
			array(
				'label'       => esc_html__( 'Map ID', 'mt-dosei-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 1,
				'min'         => 1,
				'description' => esc_html__( 'Use the ID of a map in WP Go Maps.', 'mt-dosei-core' ),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$map_id = isset( $settings['map_id'] ) ? absint( $settings['map_id'] ) : 0;
		if ( ! $map_id || ! shortcode_exists( 'wpgmza' ) ) {
			return;
		}

		echo do_shortcode( '[wpgmza id="' . $map_id . '"]' );
	}
}
