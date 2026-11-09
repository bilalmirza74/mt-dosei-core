<?php
/**
 * Check if Visual Composer is installed and if it's not return nothing
 */
if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

/**
 * Define shortcode category for filtering
 */
$shortcode_cat = esc_html__( 'Dosei shortcodes', 'mt-dosei-core' );

/**
 * Define option arrays for reuse
 */
$yesno = array(
	esc_html__( 'Yes', 'mt-dosei-core' ) => 'yes',
	esc_html__( 'No', 'mt-dosei-core' )  => 'no'
);
$noyes = array(
	esc_html__( 'No', 'mt-dosei-core' )  => 'no',
	esc_html__( 'Yes', 'mt-dosei-core' ) => 'yes'
);
$radius = array(
	esc_html__( 'Default', 'mt-dosei-core' ) => '',
	esc_html__( 'Round', 'mt-dosei-core' )   => 'round'
);
$order = array(
	esc_html__( 'Descending order (3, 2, 1)', 'mt-dosei-core' ) => '',
	esc_html__( 'Ascending order (1, 2, 3)', 'mt-dosei-core' )  => 'ASC'
);
$orderby = array(
	esc_html__( 'By date', 'mt-dosei-core' )               => '',
	esc_html__( 'By title', 'mt-dosei-core' )              => 'title',
	esc_html__( 'By author', 'mt-dosei-core' )             => 'author',
	esc_html__( 'Random order', 'mt-dosei-core' )          => 'rand',
	esc_html__( 'By number of comments', 'mt-dosei-core' ) => 'comment_count'
);
$pp = array(
	esc_html__( 'Show all', 'mt-dosei-core' )                  => '',
	esc_html__( 'Show only protected items', 'mt-dosei-core' ) => 'yes',
	esc_html__( 'Hide all protected items', 'mt-dosei-core' )  => 'no'
);

/**
 * Alert
 */
vc_map( array(
	'name' 			=> esc_html__( 'Alert', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add alert shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-alert',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Alert type', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose alert type', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'type',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => 'default',
				esc_html__( 'Success', 'mt-dosei-core' ) => 'success',
				esc_html__( 'Info', 'mt-dosei-core' )    => 'info',
				esc_html__( 'Warning', 'mt-dosei-core' ) => 'warning',
				esc_html__( 'Error', 'mt-dosei-core' )   => 'error'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Alert title', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter alert title', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'title',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Title'
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Content', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter here your content', 'mt-dosei-core' ),
			'type' 			=> 'textarea_html',
			'param_name'	=> 'content',
			'value' 		=> 'Your content goes here'
		),
	),
) );

/**
 * Button
 */
vc_map( array(
	'name' 			=> esc_html__( 'Button', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add button shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-button',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Button text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter button text here', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'content',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Button'
		),
		array(
			'heading' 		=> esc_html__( 'Button link', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter button link e.g. http://google.com', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'link',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Button size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose button size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => '',
				esc_html__( 'Large', 'mt-dosei-core' )   => 'lg',
				esc_html__( 'Small', 'mt-dosei-core' )   => 'sm'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Button style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose button style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' )       => '',
				esc_html__( 'Ghost', 'mt-dosei-core' )         => 'ghost',
				esc_html__( 'Ghost - light', 'mt-dosei-core' ) => 'ghost mt-btn-light'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Button block', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Use block level button', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'block',
			'value' 		=> $noyes
		),
		array(
			'heading' 		=> esc_html__( 'Button radius', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose button radius', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'radius',
			'value' 		=> $radius
		),
		array(
			'heading' 		=> esc_html__( 'Icon', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter icon class here', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'icon',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Icon align', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose Icon align', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'icon_align',
			'value' 		=> array(
				esc_html__( 'Before text', 'mt-dosei-core' ) => '',
				esc_html__( 'After text', 'mt-dosei-core' )  => 'after'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Target', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose link target', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'target',
			'value' 		=> array(
				esc_html__( 'Open link in the same window', 'mt-dosei-core' ) => '',
				esc_html__( 'Open link in new window', 'mt-dosei-core' )      => '_blank'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
	),
) );

/**
 * Gallery
 */
vc_map( array(
	'name' 			=> esc_html__( 'Gallery', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add gallery shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-gallery',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Gallery ID', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter gallery ID', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'id',
			'value' 		=> '',
		),
		array(
			'heading' 		=> esc_html__( 'Gallery image type', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose gallery image type', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'type',
			'value' 		=> array(
				esc_html__( 'Grid: 800 / 500px', 'mt-dosei-core' )            => '',
				esc_html__( 'Masonry: 800px / 100%', 'mt-dosei-core' )        => 'masonry',
				esc_html__( 'Masonry large: large from media settings' ) => 'masonry-large'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Gallery size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose gallery size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( '4 Columns', 'mt-dosei-core' ) => '' ,
				esc_html__( '1 Column', 'mt-dosei-core' )  => '1',
				esc_html__( '2 Columns', 'mt-dosei-core' ) => '2',
				esc_html__( '3 Columns', 'mt-dosei-core' ) => '3',
				esc_html__( '5 Columns', 'mt-dosei-core' ) => '5',
				esc_html__( '6 Columns', 'mt-dosei-core' ) => '6',
				esc_html__( '7 Columns', 'mt-dosei-core' ) => '7',
				esc_html__( '8 Columns', 'mt-dosei-core' ) => '8',
				esc_html__( '9 Columns', 'mt-dosei-core' ) => '9'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Margin between items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Set margin between items (in pixels)', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'margin',
			'value' 		=> '',
		),
		array(
			'heading' 		=> esc_html__( 'Outer margin', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose to use gallery outer margin', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'out_margin',
			'value' 		=> $yesno,
		),
	),
) );

/**
 * Heading
 */
vc_map( array(
	'name' 			=> esc_html__( 'Heading', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add heading shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-heading',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Heading text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter heading text', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'content',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Heading goes here'
		),
		array(
			'heading' 		=> esc_html__( 'Heading size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose heading size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( 'Heading 1', 'mt-dosei-core' ) => '',
				esc_html__( 'Heading 2', 'mt-dosei-core' ) => '2',
				esc_html__( 'Heading 3', 'mt-dosei-core' ) => '3',
				esc_html__( 'Heading 4', 'mt-dosei-core' ) => '4',
				esc_html__( 'Heading 5', 'mt-dosei-core' ) => '5',
				esc_html__( 'Heading 6', 'mt-dosei-core' ) => '6'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Heading align', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose heading align', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'align',
			'value' 		=> array(
				esc_html__( 'Left', 'mt-dosei-core' )   => '',
				esc_html__( 'Center', 'mt-dosei-core' ) => 'center',
				esc_html__( 'Right', 'mt-dosei-core' )  => 'right'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
	),
) );

/**
 * Heading - Huge
 */
vc_map( array(
	'name' 			=> esc_html__( 'Heading - Huge', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add huge heading shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-heading-huge',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Heading text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter heading text', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'content',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Heading goes here'
		),
		array(
			'heading' 		=> esc_html__( 'Heading size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose heading size. It is used only for SEO purposes. Huge heading has fixed size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( 'Heading 1', 'mt-dosei-core' ) => '',
				esc_html__( 'Heading 2', 'mt-dosei-core' ) => '2',
				esc_html__( 'Heading 3', 'mt-dosei-core' ) => '3',
				esc_html__( 'Heading 4', 'mt-dosei-core' ) => '4',
				esc_html__( 'Heading 5', 'mt-dosei-core' ) => '5',
				esc_html__( 'Heading 6', 'mt-dosei-core' ) => '6'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Heading align', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose heading align', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'align',
			'value' 		=> array(
				esc_html__( 'Left', 'mt-dosei-core' )   => '',
				esc_html__( 'Center', 'mt-dosei-core' ) => 'center',
				esc_html__( 'Right', 'mt-dosei-core' )  => 'right'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
	),
) );

/**
 * Lead
 */
vc_map( array(
	'name' 			=> esc_html__( 'Lead', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add lead shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-lead',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Lead text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter lead text', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'content',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Lead text goes here'
		),
	),
) );

/**
 * Milestone
 */
vc_map( array(
	'name' 			=> esc_html__( 'Milestone', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add milestone shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-milestone',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Milestone title', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter milestone title', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'title',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Title',
		),
		array(
			'heading' 		=> esc_html__( 'Milestone number', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter milestone number', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'number',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> '1',
		),
		array(
			'heading' 		=> esc_html__( 'Count number from', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose number that you want to count from', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'from',
			'value' 		=> '0',
		),
		array(
			'heading' 		=> esc_html__( 'Count duration', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose count duration time in ms. 1000ms = 1s', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'duration',
			'value' 		=> '2000',
		),
		array(
			'heading' 		=> esc_html__( 'Text before a number', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter text that will be placed before a number. You can use here e.g. $', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'before',
			'value' 		=> '',
		),
		array(
			'heading' 		=> esc_html__( 'Text after a number', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter text that will be placed after a number. You can use here e.g. % or +', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name' 	=> 'after',
			'value' 		=> '',
		),
		array(
			'heading' 		=> esc_html__( 'Milestone style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose milestone style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => '',
				esc_html__( 'Light', 'mt-dosei-core' )   => 'light'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Icon', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter icon class here', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'icon',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
	),
) );

/**
 * Portfolio grid
 */
vc_map( array(
	'name' 			=> esc_html__( 'Portfolio - Grid', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add portfolio grid shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-portfolio-grid',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Type', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio grid type', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'type',
			'value' 		=> array(
				esc_html__( 'Grid', 'mt-dosei-core' )    => '',
				esc_html__( 'Masonry', 'mt-dosei-core' ) => 'masonry'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio grid size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( '3 Columns', 'mt-dosei-core' ) => '',
				esc_html__( '4 Columns', 'mt-dosei-core' ) => '4',
				esc_html__( '2 Columns', 'mt-dosei-core' ) => '2'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Margin', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose margin between items (in pixels)', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'margin',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Number of items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose number of items to show (default value: -1 to show all)', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'limit',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Order', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose posts order', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'order',
			'value' 		=> $order,
		),
		array(
			'heading' 		=> esc_html__( 'Order by', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how to sort retrieved posts', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'orderby',
			'value' 		=> $orderby,
		),
		array(
			'heading' 		=> esc_html__( 'Filter', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Show category filter', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'filter',
			'value' 		=> $yesno,
		),
		array(
			'heading' 		=> esc_html__( 'Filter align', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose filter align', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'filter_align',
			'value' 		=> array(
				esc_html__( 'Right', 'mt-dosei-core' )  => '',
				esc_html__( 'Left', 'mt-dosei-core' )   => 'left',
				esc_html__( 'Center', 'mt-dosei-core' ) => 'center'
			),
		),
		array(
			'heading' 		=> esc_html__( '"Show all" filter text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Change "Show all" filter text if needed', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'all_text',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Pagination', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Show pagination at the bottom of the portfolio. Works with limit option', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pagination',
			'value' 		=> $noyes,
		),
		array(
			'heading' 		=> esc_html__( 'Password protected items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how you want to show protected items', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pp',
			'value' 		=> $pp,
		),
		array(
			'heading' 		=> esc_html__( 'Category slug', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio category. Enter category slug here e.g. category-1', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'slug',
			'value' 		=> ''
		),
	),
) );

/**
 * Portfolio mosaic
 */
vc_map( array(
	'name' 			=> esc_html__( 'Portfolio - Mosaic', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add portfolio mosaic shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-portfolio-mosaic',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Size', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio grid size', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'size',
			'value' 		=> array(
				esc_html__( '3 Columns', 'mt-dosei-core' ) => '',
				esc_html__( '4 Columns', 'mt-dosei-core' ) => '4',
				esc_html__( '2 Columns', 'mt-dosei-core' ) => '2'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Number of items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose number of items to show (default value: -1 to show all)', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'limit',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Order', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose posts order', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'order',
			'value' 		=> $order,
		),
		array(
			'heading' 		=> esc_html__( 'Order by', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how to sort retrieved posts', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'orderby',
			'value' 		=> $orderby,
		),
		array(
			'heading' 		=> esc_html__( 'Filter', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Show category filter', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'filter',
			'value' 		=> $yesno,
		),
		array(
			'heading' 		=> esc_html__( 'Filter align', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose filter align', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'filter_align',
			'value' 		=> array(
				esc_html__( 'Right', 'mt-dosei-core' )  => '',
				esc_html__( 'Left', 'mt-dosei-core' )   => 'left',
				esc_html__( 'Center', 'mt-dosei-core' ) => 'center'
			),
		),
		array(
			'heading' 		=> esc_html__( '"Show all" filter text', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Change "Show all" filter text if needed', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'all_text',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Pagination', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Show pagination at the bottom of the portfolio. Works with limit option', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pagination',
			'value' 		=> $noyes,
		),
		array(
			'heading' 		=> esc_html__( 'Password protected items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how you want to show protected items', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pp',
			'value' 		=> $pp,
		),
		array(
			'heading' 		=> esc_html__( 'Category slug', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio category. Enter category slug here e.g. category-1', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'slug',
			'value' 		=> ''
		),
	),
) );

/**
 * Portfolio search
 */
vc_map( array(
	'name' 			=> esc_html__( 'Portfolio - Search', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add portfolio search shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-portfolio-search',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Placeholder', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Search field placeholder text', 'mt-dosei-core' ),
			'type' 			=> 'placeholder',
			'param_name'	=> 'slug',
			'admin_label'	=> true,
			'save_always' 	=> true,
			'value' 		=> 'Start typing...'
		),
	),
) );

/**
 * Portfolio sections
 */
vc_map( array(
	'name' 			=> esc_html__( 'Portfolio - Sections', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add portfolio sections shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-portfolio-sections',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Number of items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose number of items to show (default value: -1 to show all)', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'limit',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Order', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose posts order', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'order',
			'value' 		=> $order,
		),
		array(
			'heading' 		=> esc_html__( 'Order by', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how to sort retrieved posts', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'orderby',
			'value' 		=> $orderby,
		),
		array(
			'heading' 		=> esc_html__( 'Pagination', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Show pagination at the bottom of the portfolio. Works with limit option', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pagination',
			'value' 		=> $noyes,
		),
		array(
			'heading' 		=> esc_html__( 'Password protected items', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose how you want to show protected items', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'pp',
			'value' 		=> $pp,
		),
		array(
			'heading' 		=> esc_html__( 'Category slug', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose portfolio category. Enter category slug here e.g. category-1', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'slug',
			'value' 		=> ''
		),
	),
) );

/**
 * Pricing
 */
vc_map( array(
	'name' 			=> esc_html__( 'Pricing', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add pricing shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-pricing',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Pricing title', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter pricing title', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'title',
			'admin_label'	=> true,
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Icon', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter icon class here', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'icon',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Price', 'mt-dosei-core' ),
			'description' 	=> '',
			'type' 			=> 'textfield',
			'param_name'	=> 'price',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Currency', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Use currency sign or abbreviation here e.g. $', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'currency',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Period', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add pricing period here e.g. /month', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'period',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Button link', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter button link e.g. http://google.com', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'link',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Button title', 'mt-dosei-core' ),
			'description' 	=> '',
			'type' 			=> 'textfield',
			'param_name'	=> 'link_title',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Pricing style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose pricing style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => '',
				esc_html__( 'Light', 'mt-dosei-core' )   => 'light'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Recommended', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add additional highlight for this pricing', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'recommended',
			'value' 		=> $noyes,
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
	),
) );

/**
 * Service
 */
vc_map( array(
	'name' 			=> esc_html__( 'Service', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add service shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-service',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Service title', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter service title', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'title',
			'admin_label'	=> true,
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Service type', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose service type', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'type',
			'value' 		=> array(
				esc_html__( 'Left', 'mt-dosei-core' )  => '',
				esc_html__( 'Top', 'mt-dosei-core' )   => 'top',
				esc_html__( 'Right', 'mt-dosei-core' ) => 'right'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Service style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose service style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => '',
				esc_html__( 'Light', 'mt-dosei-core' )   => 'light'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Icon', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter icon class here', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'icon',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Icon style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose icon style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'icon_style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' )      => '',
				esc_html__( 'Accent color', 'mt-dosei-core' ) => 'accent'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Link', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter custom link', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'link',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Link title', 'mt-dosei-core' ),
			'description' 	=> '',
			'type' 			=> 'textfield',
			'param_name'	=> 'link_title',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Service content', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter service content', 'mt-dosei-core' ),
			'type' 			=> 'textarea_html',
			'param_name'	=> 'content',
			'value' 		=> 'Service content goes here'
		),
	),
) );

/**
 * Testimonial
 */
vc_map( array(
	'name' 			=> esc_html__( 'Testimonial', 'mt-dosei-core' ),
	'description' 	=> esc_html__( 'Add testimonial shortcode', 'mt-dosei-core' ),
	'category' 		=> $shortcode_cat,
	'base' 			=> 'mt-testimonial',
	'params' 		=> array(
		array(
			'heading' 		=> esc_html__( 'Testimonial title', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter testimonial title', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'title',
			'admin_label'	=> true,
			'value' 		=> 'Jon Doe'
		),
		array(
			'heading' 		=> esc_html__( 'Testimonial subtitle', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter testimonial subtitle', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'subtitle',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Testimonial thumb', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter url to thumbnail e.g. http://yoursite.com/image.jpg', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'thumb',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Testimonial style', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Choose testimonial style', 'mt-dosei-core' ),
			'type' 			=> 'dropdown',
			'param_name' 	=> 'style',
			'value' 		=> array(
				esc_html__( 'Default', 'mt-dosei-core' ) => '',
				esc_html__( 'Light', 'mt-dosei-core' )   => 'light'
			),
		),
		array(
			'heading' 		=> esc_html__( 'Extra css class', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Add custom css class', 'mt-dosei-core' ),
			'type' 			=> 'textfield',
			'param_name'	=> 'xclass',
			'value' 		=> ''
		),
		array(
			'heading' 		=> esc_html__( 'Testimonial content', 'mt-dosei-core' ),
			'description' 	=> esc_html__( 'Enter testimonial content', 'mt-dosei-core' ),
			'type' 			=> 'textarea_html',
			'param_name'	=> 'content',
			'value' 		=> 'Testimonial content goes here'
		),
	),
) );