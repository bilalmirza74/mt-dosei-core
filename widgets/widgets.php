<?php
// Add function to widgets_init
add_action( 'widgets_init', 'mt_load_widgets' );

// Register widget
function mt_load_widgets() {
	register_widget( 'mt_LatestPosts_Widget' );
	register_widget( 'mt_LatestProjects_Widget' );
}

/**

	Latest posts widget

**/

// Widget class
class mt_LatestPosts_Widget extends WP_Widget {

/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/

	function __construct() {
		parent::__construct(
				'mt_latestposts_widget',
				__( 'MT Latest Posts',
				'mt-dosei-core' ),
				array( 'description' => __( 'Display latest posts', 'mt-dosei-core' ) )
		);
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings
		$title  = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		$cats   = esc_html( $instance['cats'] );

		// Before widget (defined by theme functions file)
		echo $before_widget;

		// Display the widget title if one was input
		if ( $title )
			echo $before_title . $title . $after_title;

			$args = array(
	            'posts_per_page'      => $number,
	            'ignore_sticky_posts' => 1,
	            'post_type'           => 'post',
	            'order'               => 'DESC',
	            'orderby'             => 'date',
	            'category_name'       => $cats,
	        );

	        $post_query = new WP_Query( $args );?>

			<ol class="lp-sidebar">

				<?php
				if( $post_query->have_posts() ) :
					while( $post_query->have_posts() ) : $post_query->the_post();
					?>

					<li>
						<a class="anim-link" href="<?php the_permalink() ?>">
							<h6><?php the_title(); ?></h6>
							<span><i class="mt-icon-calendar-o"></i> <?php echo get_the_date(); ?></span>
						</a>
					</li>

					<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>

	    	</ol>

		<?php

		// After widget (defined by theme functions file)
		echo $after_widget;

	}

/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		$instance['cats'] = $new_instance['cats'];

		return $instance;
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget Settings
/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		// Set up some default widget settings
		$defaults = array(
			'title'  => 'Latest posts',
			'number' => '3',
			'cats'   => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mt-dosei-core' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts:', 'mt-dosei-core' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'number' ] ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e( 'Category slugs:', 'mt-dosei-core' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'cats' ] ); ?>" />
			</label>
		</p>
		<p class="help">
			<?php _e( 'If you want to use one category you can paste category slug here. If you want to use multiple categories just divide them with comma like so: category1, category2', 'mt-dosei-core' ); ?>
		</p>

		<?php
	}
}


/**

	Latest projects widget

**/

// Widget class
class mt_LatestProjects_Widget extends WP_Widget {

/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/

	function __construct() {
		parent::__construct(
				'mt_latestprojects_widget',
				__( 'MT Latest Projects',
				'mt-dosei-core' ),
				array( 'description' => __( 'Display latest projects', 'mt-dosei-core' ) )
		);
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		$cats = esc_html( $instance['cats'] );

		// Before widget (defined by theme functions file)
		echo $before_widget;

		// Display the widget title if one was input
		if ( $title )
			echo $before_title . $title . $after_title;

			$args = array(
				'post_type'				=> 'portfolio',
				'posts_per_page' 		=> $number,
				'ignore_sticky_posts' 	=> 1,
				'order' 				=> 'DESC',
				'orderby' 				=> 'date',
				'portfolio-category' 	=> $cats,
				'has_password' 			=> false,
	        );

	        $portfolio_query = new WP_Query( $args );?>

			<?php
			if( $portfolio_query->have_posts() ) : while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

			// thumbnail
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium', true );
			?>
			<!-- BEGIN post -->
			<div class="project-widget" style="background-image: url(<?php echo esc_url( $thumb[0] ); ?>);">
				<a class="anim-link" href="<?php the_permalink() ?>"><i class="pe-7s-back"></i></a>
			</div>
			<!-- END post -->
			<?php endwhile; endif; wp_reset_postdata(); ?>

		<?php

		// After widget (defined by theme functions file)
		echo $after_widget;

	}

/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		$instance['cats']   = $new_instance['cats'];

		return $instance;
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget Settings
/*-----------------------------------------------------------------------------------*/

	function form( $instance ) {

		// Set up some default widget settings
		$defaults = array(
			'title'  => 'Latest projects',
			'number' => '3',
			'cats'   => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mt-dosei-core' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of projects:', 'mt-dosei-core' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'number' ] ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e( 'Category slugs:', 'mt-dosei-core' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'cats' ] ); ?>" />
			</label>
		</p>
		<p class="help">
			<?php _e( 'If you want to use one category you can paste category slug here. If you want to use multiple categories just divide them with comma like so: category1, category2', 'mt-dosei-core' ); ?>
		</p>

		<?php
	}
}
