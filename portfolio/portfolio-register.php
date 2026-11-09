<?php
add_action( 'init', 'mt_portfolio_cpt_init' );
/**
 * Register a portfolio post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mt_portfolio_cpt_init() {

	$labels = array(
		'name'					=> esc_html__( 'Portfolio', 'mt-dosei-core' ),
		'singular_name'			=> esc_html__( 'Portfolio Item', 'mt-dosei-core' ),
		'add_new'				=> esc_html__( 'Add New Item', 'mt-dosei-core' ),
		'add_new_item'			=> esc_html__( 'Add New Portfolio Item', 'mt-dosei-core' ),
		'edit_item'				=> esc_html__( 'Edit Portfolio Item', 'mt-dosei-core' ),
		'new_item'				=> esc_html__( 'Add New Portfolio Item', 'mt-dosei-core' ),
		'view_item'				=> esc_html__( 'View Item', 'mt-dosei-core' ),
		'search_items'			=> esc_html__( 'Search Portfolio', 'mt-dosei-core' ),
		'not_found'				=> esc_html__( 'No portfolio items found', 'mt-dosei-core' ),
		'not_found_in_trash'	=> esc_html__( 'No portfolio items found in trash', 'mt-dosei-core' )
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
		'labels'			=> $labels,
		'supports'			=> $supports,
		'public'			=> true,
		'capability_type'	=> 'post',
		'rewrite'			=> array( 'slug' => 'portfolio', ), // Permalinks format
		'menu_position'		=> 30,
		'menu_icon'			=> 'dashicons-schedule',
	); 
	
	register_post_type( 'portfolio', $args );

}


add_action( 'init', 'portfolio_tax_init' );
/**
 * Register a portfolio taxonomies
 *
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function portfolio_tax_init() {

	/**
	 * Register a taxonomy for Portfolio Categories
	 */
	$labels = array(
		'name'							=> esc_html__( 'Portfolio Categories', 'mt-dosei-core' ),
		'singular_name'					=> esc_html__( 'Portfolio Category', 'mt-dosei-core' ),
		'search_items'					=> esc_html__( 'Search Portfolio Categories', 'mt-dosei-core' ),
		'popular_items'					=> esc_html__( 'Popular Portfolio Categories', 'mt-dosei-core' ),
		'all_items'						=> esc_html__( 'All Portfolio Categories', 'mt-dosei-core' ),
		'parent_item'					=> esc_html__( 'Parent Portfolio Category', 'mt-dosei-core' ),
		'parent_item_colon'				=> esc_html__( 'Parent Portfolio Category:', 'mt-dosei-core' ),
		'edit_item'						=> esc_html__( 'Edit Portfolio Category', 'mt-dosei-core' ),
		'update_item'					=> esc_html__( 'Update Portfolio Category', 'mt-dosei-core' ),
		'add_new_item'					=> esc_html__( 'Add New Portfolio Category', 'mt-dosei-core' ),
		'new_item_name'					=> esc_html__( 'New Portfolio Category Name', 'mt-dosei-core' ),
		'separate_items_with_commas'	=> esc_html__( 'Separate portfolio categories with commas', 'mt-dosei-core' ),
		'add_or_remove_items'			=> esc_html__( 'Add or remove portfolio categories', 'mt-dosei-core' ),
		'choose_from_most_used'			=> esc_html__( 'Choose from the most used portfolio categories', 'mt-dosei-core' ),
		'menu_name'						=> esc_html__( 'Portfolio Categories', 'mt-dosei-core' ),
	);

	$args = array(
		'labels'			=> $labels,
		'public' 			=> true,
		'show_in_nav_menus'	=> true,
		'show_ui'			=> true,
		'show_tagcloud'		=> true,
		'hierarchical'		=> true,
		'rewrite'			=> array( 'slug' => 'portfolio-category' ),
		'show_admin_column'	=> true,
		'query_var'			=> true,
	);
	
	register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );
}


add_filter( 'manage_edit-portfolio_columns', 'edit_columns' );
add_action( 'manage_portfolio_posts_custom_column', 'column_display', 10, 2 );
/**
 * Add Columns to Portfolio Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */
function edit_columns( $columns ) {
	$columns['portfolio-thumbnail']	= esc_html__( 'Featured image', 'mt-dosei-core' );
	return $columns;
}
function column_display( $column, $post_id ) {
	switch ( $column ) {
		// Thumbnail
		case 'portfolio-thumbnail':
			echo get_the_post_thumbnail( get_the_ID(), array( 50, 50 ) );
		break;
	}
}

/**
 * Flushing rewrite on plugin activation
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mt_portfolio_rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry, 
	// when you add a post of this CPT.
	mt_portfolio_cpt_init();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mt_portfolio_rewrite_flush' );