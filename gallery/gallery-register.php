<?php
add_action( 'init', 'mt_gallery_cpt_init' );
/**
 * Register a gallery post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mt_gallery_cpt_init() {

	$labels = array(
		'name'					=> esc_html__( 'Galleries', 'mt-dosei-core' ),
		'singular_name'			=> esc_html__( 'Gallery', 'mt-dosei-core' ),
		'add_new'				=> esc_html__( 'Add New', 'mt-dosei-core' ),
		'add_new_item'			=> esc_html__( 'Add New Gallery', 'mt-dosei-core' ),
		'edit_item'				=> esc_html__( 'Edit Gallery', 'mt-dosei-core' ),
		'new_item'				=> esc_html__( 'Add New Gallery', 'mt-dosei-core' ),
		'view_item'				=> esc_html__( 'View Item', 'mt-dosei-core' ),
		'search_items'			=> esc_html__( 'Search Galleries', 'mt-dosei-core' ),
		'not_found'				=> esc_html__( 'No galleries found', 'mt-dosei-core' ),
		'not_found_in_trash'	=> esc_html__( 'No galleries found in trash', 'mt-dosei-core' )
	);
	
	$supports = array(
		'comments',
		'editor',
		'excerpt',
		'thumbnail',
		'title',
		'custom-fields',
		'revisions'
	);

	$args = array(
		'labels'              => $labels,
		'supports'            => $supports,
		'public'              => true,
		'exclude_from_search' => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'gallery' ), // Permalinks format
		'menu_position'       => 30,
		'menu_icon'           => 'dashicons-images-alt2',
	); 
	
	register_post_type( 'gallery', $args );

}

// Add Taxonomy Columns Inside Gallery List View
add_filter( "manage_edit-gallery_columns", "add_new_columns_gallery" );  
add_action( "manage_posts_custom_column",  "add_column_data_gallery", 2, 10 );
/**
 * Add Columns to Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */
function add_new_columns_gallery( $defaults ) {
	$defaults['mt_gallery_show_id'] = esc_html__( 'Gallery ID', 'mt-dosei-core' );
	return $defaults;
}
function add_column_data_gallery( $column_name, $post_id ) {
	// Output for ID
	if( $column_name == 'mt_gallery_show_id' ) {
		echo 'Gallery ID: <code>' . $post_id . '</code>';
	}
}

/**
 * Flushing rewrite on plugin activation
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mt_gallery_rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry, 
	// when you add a post of this CPT.
	mt_gallery_cpt_init();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mt_gallery_rewrite_flush' );