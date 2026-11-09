<?php
/**
 * Define the shortcode parameters
 *
 * @package MThemes Shortcodes
 * @since 1.0
 */

// Include helpers file
require_once( MTSC_PLUGIN_DIR . 'includes/helpers.php' );

/*------------------------*/
/*	Accordion
/*------------------------*/
$mthemes_shortcodes['mt-accordion'] = array(
	'title'           => esc_html__( 'Accordion', 'mt-dosei-core' ),
	'notes'           => esc_html__( 'You can use drag and drop to reorder items', 'mt-dosei-core' ),
	'id'              => 'mtsc_accordion',
	'template'        => '[mt-accordion] {{child_shortcode}} [/mt-accordion]',
	'params'          => array(),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'label' => esc_html__( 'Panel title', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter the name of the panel', 'mt-dosei-core' ),
				'std'   => 'Title',
				'type'  => 'text',
			),
			'content' => array(
				'label' => esc_html__( 'Content', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter here your content', 'mt-dosei-core' ),
				'std'   => 'Your content goes here',
				'type'  => 'textarea',
			)
		),
		'template'     => '<p>[mt-accordion-panel {{attributes}}]<p>{{content}}</p>[/mt-accordion-panel]</p>',
		'clone_button' => esc_html__( 'Add Panel', 'mt-dosei-core' )
	)
);

/*------------------------*/
/*	Alert
/*------------------------*/
$mthemes_shortcodes['mt-alert'] = array(
	'title'    => esc_html__( 'Alert', 'mt-dosei-core' ),
	'id'       => 'mtsc_alert',
	'template' => '[mt-alert {{attributes}}]<p>{{content}}</p>[/mt-alert]',
	'params'   => array(
		'type' => array(
			'label'   => esc_html__( 'Alert type', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose alert type', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $item_types,
		),
		'title' => array(
			'label' => esc_html__( 'Alert title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter alert title', 'mt-dosei-core' ),
			'std'   => 'Title',
			'type'  => 'text',
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'content' => array(
			'label' => esc_html__( 'Content', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter here your content', 'mt-dosei-core' ),
			'std'   => 'Your content goes here',
			'type'  => 'textarea',
		)
	)
);

/*------------------------*/
/*	Button
/*------------------------*/
$mthemes_shortcodes['mt-button'] = array(
	'title'    => esc_html__( 'Button', 'mt-dosei-core' ),
	'id'       => 'mtsc_button',
	'template' => '[mt-button {{attributes}}]{{content}}[/mt-button]',
	'params'   => array(
		'content' => array(
			'label' => esc_html__( 'Button text', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter button text here', 'mt-dosei-core' ),
			'std'   => 'Button',
			'type'  => 'text',
		),
		'href' => array(
			'label' => esc_html__( 'Button link', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter button link e.g. http://google.com', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'size' => array(
			'label'   => esc_html__( 'Button size', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose button size', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	 => esc_html__( 'Default', 'mt-dosei-core' ),
				'lg' => esc_html__( 'Large', 'mt-dosei-core' ),
				'sm' => esc_html__( 'Small', 'mt-dosei-core' )
			),
		),
		'block' => array(
			'label'   => esc_html__( 'Button block', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Use block level button', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes
		),
		'radius' => array(
			'label'   => esc_html__( 'Button radius', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose button radius', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $radius
		),
		'icon' => array(
			'label'   => esc_html__( 'Icon', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon or enter your own class', 'mt-dosei-core' ),
			'type'    => 'iconpicker',
			'std'     => '',
			'options' => $icon_list
		),
		'icon_align' => array(
			'label'   => esc_html__( 'Icon align', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon align', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	    => esc_html__( 'Before text', 'mt-dosei-core' ),
				'after' => esc_html__( 'After text', 'mt-dosei-core' )
			),
		),
		'target' => array(
			'label'   => esc_html__( 'Link target', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose link target', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	     => esc_html__( 'Open link in the same window', 'mt-dosei-core' ),
				'_blank' => esc_html__( 'Open link in new window', 'mt-dosei-core' )
			),
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Column
/*------------------------*/
$mthemes_shortcodes['mt-column'] = array(
	'title'           => esc_html__( 'Column', 'mt-dosei-core' ),
	'id'              => 'mtsc_column',
	'template'        => '[mt-row] {{child_shortcode}} [/mt-row]',
	'params'          => array(),
	'child_shortcode' => array(
		'params' => array(
			'size' => array(
				'label'   => esc_html__( 'Column size', 'mt-dosei-core' ),
				'desc'    => '',
				'type'    => 'select',
				'options' => array(
					'' 	 => esc_html__( 'Default', 'mt-dosei-core' ),
					'1'  => esc_html__( '1/12 (8.3%)', 'mt-dosei-core' ),
					'2'  => esc_html__( '2/12 (16.6%)', 'mt-dosei-core' ),
					'3'  => esc_html__( '3/12 (25%)', 'mt-dosei-core' ),
					'4'  => esc_html__( '4/12 (33.3%)', 'mt-dosei-core' ),
					'5'  => esc_html__( '5/12 (41.6%)', 'mt-dosei-core' ),
					'6'  => esc_html__( '6/12 (50%)', 'mt-dosei-core' ),
					'7'  => esc_html__( '7/12 (58.3%)', 'mt-dosei-core' ),
					'8'  => esc_html__( '8/12 (66.6%)', 'mt-dosei-core' ),
					'9'  => esc_html__( '9/12 (75%)', 'mt-dosei-core' ),
					'10' => esc_html__( '10/12 (83.3%)', 'mt-dosei-core' ),
					'11' => esc_html__( '11/12 (91.6%)', 'mt-dosei-core' ),
					'12' => esc_html__( '12/12 (100%)', 'mt-dosei-core' )
				),
			),
			'offset' => array(
				'label'   => esc_html__( 'Column offset', 'mt-dosei-core' ),
				'desc'    => '',
				'type'    => 'select',
				'options' => array(
					'' 	 => esc_html__( 'Default', 'mt-dosei-core' ),
					'1'  => esc_html__( '1/12 (8.3%)', 'mt-dosei-core' ),
					'2'  => esc_html__( '2/12 (16.6%)', 'mt-dosei-core' ),
					'3'  => esc_html__( '3/12 (25%)', 'mt-dosei-core' ),
					'4'  => esc_html__( '4/12 (33.3%)', 'mt-dosei-core' ),
					'5'  => esc_html__( '5/12 (41.6%)', 'mt-dosei-core' ),
					'6'  => esc_html__( '6/12 (50%)', 'mt-dosei-core' ),
					'7'  => esc_html__( '7/12 (58.3%)', 'mt-dosei-core' ),
					'8'  => esc_html__( '8/12 (66.6%)', 'mt-dosei-core' ),
					'9'  => esc_html__( '9/12 (75%)', 'mt-dosei-core' ),
					'10' => esc_html__( '10/12 (83.3%)', 'mt-dosei-core' ),
					'11' => esc_html__( '11/12 (91.6%)', 'mt-dosei-core' ),
					'12' => esc_html__( '12/12 (100%)', 'mt-dosei-core' )
				),
			),
			'xclass' => array(
				'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
				'type'  => 'text',
				'std'   => '',
			)
		),
		'template'     => '<p>[mt-column {{attributes}}]<p>Content goes here</p>[/mt-column]</p>',
		'clone_button' => esc_html__( 'Add Column', 'mt-dosei-core' )
	)
);

/*------------------------*/
/*	Dropcap
/*------------------------*/
$mthemes_shortcodes['mt-dropcap'] = array(
	'title'    => esc_html__( 'Dropcap', 'mt-dosei-core' ),
	'id'       => 'mtsc_dropcap',
	'template' => '[mt-dropcap]{{content}}[/mt-dropcap]',
	'params'   => array(
		'content' => array(
			'label' => esc_html__( 'Dropcap letter', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter dropcap letter here', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'text',
		)
	)
);

/*------------------------*/
/*	Gallery
/*------------------------*/
$mthemes_shortcodes['mt-gallery-carousel'] = array(
	'title'    => esc_html__( 'Gallery - Carousel', 'mt-dosei-core' ),
	'id'       => 'mtsc_gallery_carousel',
	'template' => '[mt-gallery-carousel {{attributes}}]',
	'params'   => array(
		'id' => array(
			'label'   => esc_html__( 'Choose gallery', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery from the list', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => mt_get_posts( 'gallery' )
		),
		'height' => array(
			'label'   => esc_html__( 'Height', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose carousel height', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''    => esc_html__( '70% of window height', 'mt-dosei-core' ),
				'80'  => esc_html__( '80% of window height', 'mt-dosei-core' ),
				'90'  => esc_html__( '90% of window height', 'mt-dosei-core' ),
				'100' => esc_html__( '100% of window height', 'mt-dosei-core' ),
			),
		),
		'effect' => array(
			'label'   => esc_html__( 'Effect', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose carousel effect', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''         => esc_html__( 'Default', 'mt-dosei-core' ),
				'opacity'  => esc_html__( 'Opacity', 'mt-dosei-core' ),
				'opacityp' => esc_html__( 'Opacity (partial)', 'mt-dosei-core' ),
				'scale'    => esc_html__( 'Scale', 'mt-dosei-core' ),
				'opscale'  => esc_html__( 'Opacity and Scale', 'mt-dosei-core' ),
				'opscalep' => esc_html__( 'Opacity (partial) and Scale', 'mt-dosei-core' ),
			),
		),
		'margin' => array(
			'label' => esc_html__( 'Margin between items', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Set horizontal margin between items (in pixels)', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'number',
		),
		'caption' => array(
			'label'   => esc_html__( 'Caption', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show image caption inside lightbox', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'exif' => array(
			'label'   => esc_html__( 'EXIF data', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show EXIF image data inside lightbox. Caption must be enabled', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes
		),
	)
);

$mthemes_shortcodes['mt-gallery-masonry'] = array(
	'title'    => esc_html__( 'Gallery - Grid/Masonry', 'mt-dosei-core' ),
	'id'       => 'mtsc_gallery_masonry',
	'template' => '[mt-gallery-masonry {{attributes}}]',
	'params'   => array(
		'id' => array(
			'label'   => esc_html__( 'Choose gallery', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery from the list', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => mt_get_posts( 'gallery' )
		),
		'type' => array(
			'label'   => esc_html__( 'Gallery image type', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery image type', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''     => esc_html__( 'Masonry', 'mt-dosei-core' ),
				'grid' => esc_html__( 'Grid', 'mt-dosei-core' ),
			),
		),
		'size' => array(
			'label'   => esc_html__( 'Gallery size', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery grid size', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''  => esc_html__( '3 Columns', 'mt-dosei-core' ),
				'2' => esc_html__( '2 Columns', 'mt-dosei-core' ),
				'4' => esc_html__( '4 Columns', 'mt-dosei-core' ),
			),
		),
		'margin' => array(
			'label' => esc_html__( 'Margin between items', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Set margin between items (in pixels)', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'number',
		),
		'caption' => array(
			'label'   => esc_html__( 'Caption', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show image caption inside lightbox', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'exif' => array(
			'label'   => esc_html__( 'EXIF data', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show EXIF image data inside lightbox. Caption must be enabled', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes
		),
	)
);

$mthemes_shortcodes['mt-gallery-justified'] = array(
	'title'    => esc_html__( 'Gallery - Justified', 'mt-dosei-core' ),
	'id'       => 'mtsc_gallery_justified',
	'template' => '[mt-gallery-justified {{attributes}}]',
	'params'   => array(
		'id' => array(
			'label'   => esc_html__( 'Choose gallery', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery from the list', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => mt_get_posts( 'gallery' )
		),
		'margin' => array(
			'label' => esc_html__( 'Margin between items', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Set margin between items (in pixels)', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'number',
		),
		'height' => array(
			'label' => esc_html__( 'Image height', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Set custom image height. Default: 500', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'number',
		),
		'caption' => array(
			'label'   => esc_html__( 'Caption', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show image caption inside lightbox', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'exif' => array(
			'label'   => esc_html__( 'EXIF data', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Show EXIF image data inside lightbox. Caption must be enabled', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes
		),
	)
);

$mthemes_shortcodes['mt-gallery-slider'] = array(
	'title'    => esc_html__( 'Gallery - Slider', 'mt-dosei-core' ),
	'id'       => 'mtsc_gallery_slider',
	'template' => '[mt-gallery-slider {{attributes}}]',
	'params'   => array(
		'id' => array(
			'label'   => esc_html__( 'Choose gallery', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose gallery from the list', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => mt_get_posts( 'gallery' )
		),
		'autoplay' => array(
			'label'   => esc_html__( 'Play/pause button', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Enable play/pause button for this slider', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'scale' => array(
			'label'   => esc_html__( 'Scale effect', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Use scale effect in slider', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
	)
);

/*------------------------*/
/*	Heading
/*------------------------*/
$mthemes_shortcodes['mt-heading'] = array(
	'title'    => esc_html__( 'Heading', 'mt-dosei-core' ),
	'id'       => 'mtsc_heading',
	'template' => '[mt-heading {{attributes}}]{{content}}[/mt-heading]',
	'params'   => array(
		'content' => array(
			'label' => esc_html__( 'Heading text', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter heading text', 'mt-dosei-core' ),
			'std'   => 'Heading goes here',
			'type'  => 'text',
		),
		'size' => array(
			'label'   => esc_html__( 'Heading size', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose heading size', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''  => esc_html__( 'Heading 1', 'mt-dosei-core' ),
				'2' => esc_html__( 'Heading 2', 'mt-dosei-core' ),
				'3' => esc_html__( 'Heading 3', 'mt-dosei-core' ),
				'4' => esc_html__( 'Heading 4', 'mt-dosei-core' ),
				'5' => esc_html__( 'Heading 5', 'mt-dosei-core' ),
				'6' => esc_html__( 'Heading 6', 'mt-dosei-core' )
			),
		),
		'align' => array(
			'label'   => esc_html__( 'Heading align', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose heading text align', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''       => esc_html__( 'Left', 'mt-dosei-core' ),
				'center' => esc_html__( 'Center', 'mt-dosei-core' ),
				'right'  => esc_html__( 'Right', 'mt-dosei-core' )
			),
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Highlight
/*------------------------*/
$mthemes_shortcodes['mt-highlight'] = array(
	'title'    => esc_html__( 'Highlight', 'mt-dosei-core' ),
	'id'       => 'mtsc_highlight',
	'template' => '[mt-highlight]{{content}}[/mt-highlight]',
	'params'   => array(
		'content' => array(
			'label' => esc_html__( 'Highlighted text', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter highlighted text here', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'text',
		)
	)
);

/*------------------------*/
/*	Milestone
/*------------------------*/
$mthemes_shortcodes['mt-milestone'] = array(
	'title'    => esc_html__( 'Milestone', 'mt-dosei-core' ),
	'id'       => 'mtsc_milestone',
	'template' => '[mt-milestone {{attributes}}]',
	'params'   => array(
		'title' => array(
			'label' => esc_html__( 'Milestone title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter milestone title', 'mt-dosei-core' ),
			'std'   => 'Title',
			'type'  => 'text',
		),
		'number' => array(
			'label' => esc_html__( 'Milestone number', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter milestone number', 'mt-dosei-core' ),
			'std'   => '1',
			'type'  => 'number',
		),
		'from' => array(
			'label' => esc_html__( 'Count number from', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Choose number that you want to count from', 'mt-dosei-core' ),
			'std'   => '0',
			'type'  => 'number',
		),
		'duration' => array(
			'label' => esc_html__( 'Count duration', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Choose count duration time in ms. 1000ms = 1s', 'mt-dosei-core' ),
			'std'   => '2000',
			'type'  => 'number',
		),
		'before' => array(
			'label' => esc_html__( 'Text before a number', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter text that will be placed before a number. You can use here e.g. $', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'text',
		),
		'after' => array(
			'label' => esc_html__( 'Text after a number', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter text that will be placed after a number. You can use here e.g. % or +', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'text',
		),
		'style' => array(
			'label'   => esc_html__( 'Milestone style', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose milestone style', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''      => esc_html__( 'Default', 'mt-dosei-core' ),
				'light' => esc_html__( 'Light', 'mt-dosei-core' )
			),
		),
		'icon' => array(
			'label'   => esc_html__( 'Icon', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon or enter your own class', 'mt-dosei-core' ),
			'type'    => 'iconpicker',
			'std'     => '',
			'options' => $icon_list
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Pricing
/*------------------------*/
$mthemes_shortcodes['mt-pricing'] = array(
	'title'    => esc_html__( 'Pricing', 'mt-dosei-core' ),
	'id'       => 'mtsc_pricing',
	'template' => '[mt-pricing {{attributes}}]<ul><li>Pricing item 1</li><li>Pricing item 2</li><li>Pricing item 3</li><li>Pricing item 4</li></ul>[/mt-pricing]',
	'params'   => array(
		'title' => array(
			'label' => esc_html__( 'Pricing title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter pricing title', 'mt-dosei-core' ),
			'std'   => '',
			'type'  => 'text',
		),
		'icon' => array(
			'label'   => esc_html__( 'Icon', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon or enter your own class', 'mt-dosei-core' ),
			'type'    => 'iconpicker',
			'std'     => '',
			'options' => $icon_list
		),
		'price' => array(
			'label' => esc_html__( 'Price', 'mt-dosei-core' ),
			'desc'  => '',
			'type'  => 'text',
			'std'   => '',
		),
		'currency' => array(
			'label' => esc_html__( 'Currency', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Use currency sign or abbreviation here e.g. $', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'period' => array(
			'label' => esc_html__( 'Period', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add pricing period here e.g. /month', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'link' => array(
			'label' => esc_html__( 'Button link', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter button link e.g. http://google.com', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'link_title' => array(
			'label' => esc_html__( 'Button title', 'mt-dosei-core' ),
			'desc'  => '',
			'type'  => 'text',
			'std'   => '',
		),
		'style' => array(
			'label'   => esc_html__( 'Pricing style', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose pricing style', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''      => esc_html__( 'Default', 'mt-dosei-core' ),
				'light' => esc_html__( 'Light', 'mt-dosei-core' )
			),
		),
		'recommended' => array(
			'label'   => esc_html__( 'Recommended', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Add additional highlight for this pricing', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes,
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Section
/*------------------------*/
$mthemes_shortcodes['mt-section'] = array(
	'title'    => esc_html__( 'Section', 'mt-dosei-core' ),
	'id'       => 'mtsc_section',
	'template' => '[mt-section {{attributes}}]<p>Add columns here</p>[/mt-section]',
	'params'   => array(
		'container' => array(
			'label'   => esc_html__( 'Container', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Wrap section content with container. If set to "No" content inside section will be 100% of window width', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'bgcolor' => array(
			'label' => esc_html__( 'Background color', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Choose section background color', 'mt-dosei-core' ),
			'type'  => 'colorpicker',
			'std'   => '#ffffff',
		),
		'bgimage' => array(
			'label' => esc_html__( 'Background image', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url to background image e.g. http://yoursite.com/image.jpg', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'bgrepeat' => array(
			'label'   => esc_html__( 'Image repeat', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose background image repeat', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''         => esc_html__( 'No repeat', 'mt-dosei-core' ),
				'repeat'   => esc_html__( 'Repeat', 'mt-dosei-core' ),
				'repeat-x' => esc_html__( 'Repeat horizontally', 'mt-dosei-core' ),
				'repeat-y' => esc_html__( 'Repeat vertically', 'mt-dosei-core' )
			),
		),
		'bgposition' => array(
			'label'   => esc_html__( 'Image position', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose background image position', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''              => esc_html__( 'Center center', 'mt-dosei-core' ),
				'center top'    => esc_html__( 'Center top', 'mt-dosei-core' ),
				'center bottom' => esc_html__( 'Center bottom', 'mt-dosei-core' ),
				'left top'      => esc_html__( 'Left top', 'mt-dosei-core' ),
				'left center'   => esc_html__( 'Left center', 'mt-dosei-core' ),
				'left bottom'   => esc_html__( 'Left bottom', 'mt-dosei-core' ),
				'right top'     => esc_html__( 'Right top', 'mt-dosei-core' ),
				'right center'  => esc_html__( 'Right center', 'mt-dosei-core' ),
				'right bottom'  => esc_html__( 'Right bottom', 'mt-dosei-core' )
			),
		),
		'bgattachment' => array(
			'label'   => esc_html__( 'Image attachment', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose background image attachment', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''      => esc_html__( 'Scroll', 'mt-dosei-core' ),
				'fixed' => esc_html__( 'Fixed', 'mt-dosei-core' )
			),
		),
		'bgsize' => array(
			'label'   => esc_html__( 'Image size', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose background image size', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''     => esc_html__( 'Cover', 'mt-dosei-core' ),
				'auto' => esc_html__( 'Auto', 'mt-dosei-core' )
			),
		),
		'parallax' => array(
			'label'   => esc_html__( 'Parallax section', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Use parallax section', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes
		),
		'speed' => array(
			'label'   => esc_html__( 'Parallax speed', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Set parallax speed', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	  => '0.3',
				'0.1' => '0.1',
				'0.2' => '0.2',
				'0.4' => '0.4',
				'0.5' => '0.5',
				'0.6' => '0.6',
				'0.7' => '0.7',
				'0.8' => '0.8',
				'0.9' => '0.9'
			),
		),
		'padding' => array(
			'label' => esc_html__( 'Section padding', 'mt-dosei-core' ),
			'desc'  => __( 'Use exactly like CSS. You can see examples <a href="http://www.w3schools.com/css/css_padding.asp" target="_blank">here</a><br>or in the theme documentation', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

$mthemes_shortcodes['mt-section-video'] = array(
	'title'    => esc_html__( 'Section - Video', 'mt-dosei-core' ),
	'id'       => 'mtsc_section_video',
	'template' => '[mt-section-video {{attributes}}]<p>Add columns here</p>[/mt-section-video]',
	'params'   => array(
		'container' => array(
			'label'   => esc_html__( 'Container', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Wrap section content with container. If set to "No" content inside section will be 100% of window width', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $yesno
		),
		'mp4' => array(
			'label' => esc_html__( 'MP4 video file', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url to .mp4 video file', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'webm' => array(
			'label' => esc_html__( 'WEBM video file', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url to .webm video file', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'ogv' => array(
			'label' => esc_html__( 'OGV video file', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url to .ogv video file', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'loop' => array(
			'label'   => esc_html__( 'Loop', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'If set to YES, the video will start over again, every time it is finished', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => $noyes,
		),
		'poster' => array(
			'label' => esc_html__( 'Poster', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url video image poster. It is used before video is loaded and on mobile devices', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'bgcolor' => array(
			'label' => esc_html__( 'Background color', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Choose video overlay background color', 'mt-dosei-core' ),
			'type'  => 'colorpicker',
			'std'   => '#000',
		),
		'bgopacity' => array(
			'label' => esc_html__( 'Background color opacity', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Choose opacity for a background color', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	  => 'Default',
				'0.1' => '0.1',
				'0.2' => '0.2',
				'0.3' => '0.3',
				'0.4' => '0.4',
				'0.5' => '0.5',
				'0.6' => '0.6',
				'0.7' => '0.7',
				'0.8' => '0.8',
				'0.9' => '0.9'
			),
		),
		'padding' => array(
			'label' => esc_html__( 'Section padding', 'mt-dosei-core' ),
			'desc'  => __( 'Use exactly like CSS. You can see examples <a href="http://www.w3schools.com/css/css_padding.asp" target="_blank">here</a><br>or in the theme documentation', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Service
/*------------------------*/
$mthemes_shortcodes['mt-service'] = array(
	'title'    => esc_html__( 'Service', 'mt-dosei-core' ),
	'id'       => 'mtsc_service',
	'template' => '[mt-service {{attributes}}]<p>{{content}}</p>[/mt-service]',
	'params'   => array(
		'title' => array(
			'label' => esc_html__( 'Service title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter service title', 'mt-dosei-core' ),
			'std'   => 'Title',
			'type'  => 'text',
		),
		'type' => array(
			'label'   => esc_html__( 'Service type', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose service type', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''       => esc_html__( 'Left', 'mt-dosei-core' ),
				'top'    => esc_html__( 'Top', 'mt-dosei-core' ),
				'right'  => esc_html__( 'Right', 'mt-dosei-core' )
			),
		),
		'style' => array(
			'label'   => esc_html__( 'Service style', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose service style', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''      => esc_html__( 'Default', 'mt-dosei-core' ),
				'light' => esc_html__( 'Light', 'mt-dosei-core' )
			),
		),
		'icon' => array(
			'label'   => esc_html__( 'Icon', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon or enter your own class', 'mt-dosei-core' ),
			'type'    => 'iconpicker',
			'std'     => '',
			'options' => $icon_list
		),
		'icon_style' => array(
			'label'   => esc_html__( 'Icon style', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose icon style', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				'' 	     => esc_html__( 'Default', 'mt-dosei-core' ),
				'accent' => esc_html__( 'Accent color', 'mt-dosei-core' )
			),
		),
		'link' => array(
			'label' => esc_html__( 'Link', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter custom link', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'link_title' => array(
			'label' => esc_html__( 'Link title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter link title', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'content' => array(
			'label' => esc_html__( 'Service content', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter service content', 'mt-dosei-core' ),
			'std'   => 'Service content goes here',
			'type'  => 'textarea',
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		)
	)
);

/*------------------------*/
/*	Tabs
/*------------------------*/
$mthemes_shortcodes['mt-tabs'] = array(
	'title'           => esc_html__( 'Tabs', 'mt-dosei-core' ),
	'notes'           => esc_html__( 'You can use drag and drop to reorder items', 'mt-dosei-core' ),
	'id'              => 'mtsc_tabs',
	'template'        => '[mt-tabs] {{child_shortcode}} [/mt-tabs]',
	'params'          => array(),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'label' => esc_html__( 'Tab title', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter the name of the tab', 'mt-dosei-core' ),
				'std'   => 'Tab',
				'type'  => 'text',
			),
			'content' => array(
				'label' => esc_html__( 'Content', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter here your content', 'mt-dosei-core' ),
				'std'   => 'Your content goes here',
				'type'  => 'textarea',
			)
		),
		'template'     => '<p>[mt-tab {{attributes}}]<p>{{content}}</p>[/mt-tab]</p>',
		'clone_button' => esc_html__( 'Add Tab', 'mt-dosei-core' )
	)
);

$mthemes_shortcodes['mt-tabs-features'] = array(
	'title'           => esc_html__( 'Tabs - Features', 'mt-dosei-core' ),
	'notes'           => esc_html__( 'You can use drag and drop to reorder items', 'mt-dosei-core' ),
	'id'              => 'mtsc_tabs_features',
	'template'        => '[mt-tabs type="features"] {{child_shortcode}} [/mt-tabs]',
	'params'          => array(),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'label' => esc_html__( 'Tab title', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter the name of the tab', 'mt-dosei-core' ),
				'std'   => 'Tab',
				'type'  => 'text',
			),
			'content' => array(
				'label' => esc_html__( 'Content', 'mt-dosei-core' ),
				'desc'  => esc_html__( 'Enter here your content', 'mt-dosei-core' ),
				'std'   => 'Your content goes here',
				'type'  => 'textarea',
			)
		),
		'template'     => '<p>[mt-tab {{attributes}}]<p>{{content}}</p>[/mt-tab]</p>',
		'clone_button' => esc_html__( 'Add Tab', 'mt-dosei-core' )
	)
);

/*------------------------*/
/*	Testimonial
/*------------------------*/
$mthemes_shortcodes['mt-testimonial'] = array(
	'title'    => esc_html__( 'Testimonial', 'mt-dosei-core' ),
	'id'       => 'mtsc_testimonial',
	'template' => '[mt-testimonial {{attributes}}]<p>{{content}}</p>[/mt-testimonial]',
	'params'   => array(
		'title' => array(
			'label' => esc_html__( 'Testimonial title', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter testimonial title', 'mt-dosei-core' ),
			'std'   => 'Jon Doe',
			'type'  => 'text',
		),
		'subtitle' => array(
			'label' => esc_html__( 'Testimonial subtitle', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter testimonial subtitle', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'thumb' => array(
			'label' => esc_html__( 'Testimonial thumb', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter url to thumbnail e.g. http://yoursite.com/image.jpg', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'style' => array(
			'label'   => esc_html__( 'Testimonial style', 'mt-dosei-core' ),
			'desc'    => esc_html__( 'Choose testimonial style', 'mt-dosei-core' ),
			'type'    => 'select',
			'options' => array(
				''      => esc_html__( 'Default', 'mt-dosei-core' ),
				'light' => esc_html__( 'Light', 'mt-dosei-core' )
			),
		),
		'xclass' => array(
			'label' => esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type'  => 'text',
			'std'   => '',
		),
		'content' => array(
			'label' => esc_html__( 'Content', 'mt-dosei-core' ),
			'desc'  => esc_html__( 'Enter here your content', 'mt-dosei-core' ),
			'std'   => 'Testimonial text goes here',
			'type'  => 'textarea',
		)
	)
);
