<?php
/**
 * Create and define the shortcodes
 *
 * @package MThemes Shortcodes
 * @since  1.0
 */

/**
 * Add shortcode support for widgets and excerpt areas.
 */
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'the_excerpt', 'do_shortcode' );

/**
 * Custom walker for portfolio wp_list_categories
 */
class MTSC_Portfolio_Walker extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract( $args );
		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$cat_slug = esc_attr( $category->slug );
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$link = '<a href="#" data-filter=".' . strtolower( preg_replace( '/\s+/', '-', $cat_slug ) ) . '" ';
		$link .= '>';
		$link .= $cat_name;
		$link .= '</a>';
		if ( isset( $current_category ) && $current_category )
			$_current_category = get_category( $current_category );
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( ! empty( $current_category ) ) {
				$_current_category = get_term( $current_category, $category->taxonomy );
			if ( $category->term_id == $current_category )
				$class .=  ' current-cat';
			elseif ( $category->term_id == $_current_category->parent )
				$class .=  ' current-cat-parent';
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

/**
 * Remove empty p and br tags
 */
add_filter( "the_content", "the_content_filter" );
function the_content_filter( $content ) {
	// array of custom shortcodes requiring the fix
	$block = join( "|", array(
		'mt-accordion',
		'mt-accordion-panel',
		'mt-alert',
		'mt-column',
		'mt-dropcap',
		'mt-gallery-carousel',
		'mt-gallery-masonry',
		'mt-gallery-justified',
		'mt-gallery-slider',
		'mt-heading',
		'mt-milestone',
		'mt-pricing',
		'mt-row',
		'mt-section',
		'mt-section-video',
		'mt-service',
		'mt-tab',
		'mt-tabs',
		'mt-testimonial',
	) );
	// opening tag
	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
	// closing tag
	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );
	return $rep;
}


/**
 * Add shortcode
 */
add_shortcode( 'mt-accordion', 'mt_accordion' );
add_shortcode( 'mt-accordion-panel', 'mt_accordion_panel' );
add_shortcode( 'mt-alert', 'mt_alert' );
add_shortcode( 'mt-button', 'mt_button' );
add_shortcode( 'mt-column', 'mt_column' );
add_shortcode( 'mt-dropcap', 'mt_dropcap' );
add_shortcode( 'mt-gallery-carousel', 'mt_gallery_carousel' );
add_shortcode( 'mt-gallery-masonry', 'mt_gallery_masonry' );
add_shortcode( 'mt-gallery-justified', 'mt_gallery_justified' );
add_shortcode( 'mt-gallery-slider', 'mt_gallery_slider' );
add_shortcode( 'mt-heading', 'mt_heading' );
add_shortcode( 'mt-highlight', 'mt_highlight' );
add_shortcode( 'mt-milestone', 'mt_milestone' );
add_shortcode( 'mt-pricing', 'mt_pricing' );
add_shortcode( 'mt-row', 'mt_row' );
add_shortcode( 'mt-section', 'mt_section' );
add_shortcode( 'mt-section-video', 'mt_section_video' );
add_shortcode( 'mt-service', 'mt_service' );
add_shortcode( 'mt-tab', 'mt_tab' );
add_shortcode( 'mt-tabs', 'mt_tabs' );
add_shortcode( 'mt-testimonial', 'mt_testimonial' );

/**
 * Accordion
 */
function mt_accordion( $atts, $content = null ) {
	return '<div class="mt-accordion js-mt-accordion">' . do_shortcode( $content ) . '</div>';
}
function mt_accordion_panel( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title" => false,
	), $atts );

	/* Generate unique ID */
	$id = get_the_ID();
	STATIC $i = 0;
	$i++;
	$rand = $id .'-'. $i;

	/* HTML Markup */
	$html  = '<h2 id="accordion-header-' . esc_attr( $rand ) . '" class="mt-accordion-header js-mt-accordion-header">';
		$html .= esc_html( $atts['title'] );
	$html .= '</h2>';
	$html .= '<div id="accordion-panel-' . esc_attr( $rand ) . '" class="mt-accordion-panel js-mt-accordion-panel"><div class="mt-accordion-inner">';
		$html .= do_shortcode( $content );
	$html .= '</div></div>';

	return $html;
}

/**
 * Alert
 */
function mt_alert( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"type"   => false,
		"title"  => false,
		"xclass" => false,
	), $atts );

	// CSS classes
	$class  = 'mt-alert';
	$class .= ( $atts['type'] ) ? ' mt-alert-' . $atts['type'] : ' mt-alert-default';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	/* HTML Markup */
	$html  = '<div class="' . esc_attr( trim( $class ) ) . '"><button class="mt-alert-dismiss"><i class="mt-icon-cross"></i></button>';
		if ( ! empty( $atts['title'] ) ) {
			$html .= '<h6 class="mt-alert-title">' . $atts['title'] . '</h6>';
		}
		$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}

/**
 * Button
 */
function mt_button( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"href" 	 		 => "#",
		"size" 	 		 => false,
		"block"  		 => false,
		"radius"		 => false,
		"icon" 	 		 => false,
		"icon_align"     => false,
		"target" 		 => false,
		"xclass" 		 => false,
	), $atts );

	// CSS classes
	$class  = 'mt-btn';
	$class .= ( $atts['size'] ) ? ' mt-btn-' . $atts['size'] : '';
	$class .= ( $atts['block'] == 'yes' ) ? ' mt-btn-block' : '';
	$class .= ( $atts['radius'] ) ? ' mt-btn-' . $atts['radius'] : '';
	$class .= ( $atts['icon_align'] ) ? ' mt-btn-' . $atts['icon_align'] : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	/* HTML Markup */
	$html  = '<a href="' . esc_url( $atts['href'] ) . '"';
	$html .= ' class="' . esc_attr( trim( $class ) ) . '"';
	// Target
	if ( $atts['target'] != '' ) {
		$html .= ' target="' . esc_attr( $atts['target'] ) . '"';
	}
	$html .= '>';
		if ( $atts['icon'] != '' && $atts['icon_align'] != 'after' ) {
			$html .= '<i class="' . esc_attr( $atts['icon'] ) . '"></i> ';
		}
		$html .= do_shortcode( $content );
		if ( $atts['icon'] != '' && $atts['icon_align'] == 'after' ) {
			$html .= ' <i class="' . esc_attr( $atts['icon'] ) . '"></i>';
		}
	$html .= '</a>';

	return $html;
}

/**
 * Column
 */
function mt_column( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"size" 	 => "6",
		"offset" => "0",
		"xclass" => false,
	), $atts );

	/* CSS Classes */
	$class  = '';
	$class .= ( $atts['size'] ) ? ' col-md-' . $atts['size'] : ' col-md-12';
	$class .= ( $atts['offset'] ) ? ' col-md-offset-' . $atts['offset'] : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	/* HTML Markup */
	return '<div class="' . esc_attr( trim( $class ) ) . '">' . do_shortcode( $content ) . '</div>';
}

/**
 * Dropcap
 */
function mt_dropcap( $atts, $content = null ) {

	/* HTML Markup */
	return '<span class="mt-dropcap">' . do_shortcode( $content ) . '</span>';
}

/**
 * Gallery - Carousel
 */
function mt_gallery_carousel( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"id"         => false,
		"caption"    => false,
		"height"     => false,
		"margin"     => false,
		"effect"     => false,
		"exif"       => false
	), $atts );

	ob_start();

	// Loop args
	$gallery_loop = new WP_Query( array(
		'post_type'	=> 'gallery',
		'p' 		=> absint( $atts['id'] )
	) );

	// Loop start
	if( $gallery_loop->have_posts() ) :
		while( $gallery_loop->have_posts() ) : $gallery_loop->the_post();

			// Get content field
			$image_gallery = get_the_content();

			// CSS classes
			$class  = '';
			$class .= 'mt-pc mt-ps';
			$class .= ( $atts['height'] ) ? ' mt-pc-' . $atts['height'] : '';
			$class .= ( $atts['effect'] ) ? ' mt-pc-' . $atts['effect'] : '';

			// Margin setting
			$margin = floatval($atts['margin']) / 2;
			if ( ! empty( $atts['margin'] ) ) {
				$gallery_margin = ' style="margin: 0 ' . esc_attr( $margin ) . 'px;"';
			} else {
				$gallery_margin = '';
			}

			// Check if the content field has gallery added
			if( ! empty( $image_gallery ) ) {

				preg_match( '/\[gallery.*ids=.(.*).\]/', $image_gallery, $ids );

				$image_ids = explode( ",", $ids[1] ); // Get all image ids from short code
				?>

				<div class="portfolio-media portfolio-carousel">

					<div class="mt-pc-wrapper">

						<div class="<?php echo esc_attr( trim( $class ) ); ?>" itemscope itemtype="http://schema.org/ImageGallery">

							<?php
							foreach( $image_ids as $image_id ) {

								// Create different image sizes based on grid type
								$att_url    = wp_get_attachment_url( $image_id, 'full' );
								$thumb      = aq_resize( $att_url, 9999, 1200, false, false );
								$full       = wp_get_attachment_image_src( $image_id, 'full', true );
								$thumb_meta = wp_prepare_attachment_for_js( $image_id );
								$thumb_alt  = ! empty( $thumb_meta['alt'] ) ? $thumb_meta['alt'] : $thumb_meta['title'];
							?>

								<figure class="mt-pc-item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject"<?php echo $gallery_margin; ?>>
									<a href="<?php echo esc_url( $full[0] ); ?>" itemprop="contentUrl" data-size="<?php echo esc_attr( $full[1] ); ?>x<?php echo esc_attr( $full[2] ); ?>">
										<?php
										// Image
										echo sprintf(
											'<img src="%s" data-lazy="%s" alt="%s" itemprop="thumbnail">',
											esc_url( get_template_directory_uri() . '/images/pre-lazyload.png' ),
											esc_url( $thumb[0] ),
											esc_html( $thumb_alt )
										);
										?>
									</a>
									<?php if ( $atts['caption'] != 'no' ) { ?>
										<figcaption class="mt-ps-caption" itemprop="caption description">
											<h6><?php echo esc_html( $thumb_meta['title'] ); ?></h6>
											<?php
											if ( ! empty( $thumb_meta['caption'] ) ) {
												echo esc_html( $thumb_meta['caption'] );
											}
											?>
											<?php
											if ( $atts['exif'] != 'yes' ) {
												dosei_exif_data( $image_id );
											}
											?>
										</figcaption>
									<?php } ?>
								</figure>

							<?php } ?>

						</div><!-- .mt-pc -->

						<div class="mt-pcontrols">

							<a class="mt-pc-grid" href="#mt-pc-thumbs-modal">
								<i class="pe-7s-keypad"></i>
							</a>
							<div id="mt-pc-thumbs-modal" class="mt-pc-thumbs zoom-anim-dialog mfp-hide">
								<ul class="mt-pc-thumbs-list list-unstyled clearfix">
								<?php
								foreach( $image_ids as $image_id ) {

									// Thumb
									$thumb = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
									?>
									<li>
										<a href="#">
											<?php
											// Image
											echo sprintf(
												'<img class="lazyload" src="%s" data-src="%s" width="%s" height="%s" alt="%s">',
												esc_url( get_template_directory_uri() . '/images/pre-lazyload.png' ),
												esc_url( $thumb[0] ),
												esc_attr( $thumb[1] ),
												esc_attr( $thumb[2] ),
												esc_html( get_the_title() )
											); ?>
										</a>
									</li>
								<?php
								} // END foreach
								?>
								</ul>
							</div>

							<div class="mt-pc-autoplay" href="#">
								<div class="mt-pc-autoplay-inner">
									<a class="mt-pc-play" href="#"><i class="pe-7s-play"></i></a>
									<a class="mt-pc-pause" href="#"><span></span></a>
								</div>
							</div>

						</div><!-- .mt-pcontrols -->

					</div><!-- .mt-pc-wrapper -->

				</div><!-- .portfolio-media -->

				<?php get_template_part( 'template-parts/photoswipe' ); ?>

			<?php }

		endwhile;
	endif;

	wp_reset_query();

	$gallery_markup = ob_get_contents();

	ob_end_clean();

	return $gallery_markup;
}

/**
 * Gallery - Masonry/Grid
 */
function mt_gallery_masonry( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"id"         => false,
		"caption"    => false,
		"type"       => false,
		"size"       => false,
		"margin"     => false,
		"exif"       => false
	), $atts );

	ob_start();

	// Loop args
	$gallery_loop = new WP_Query( array(
		'post_type'	=> 'gallery',
		'p' 		=> absint( $atts['id'] )
	) );

	// Loop start
	if( $gallery_loop->have_posts() ) :
		while( $gallery_loop->have_posts() ) : $gallery_loop->the_post();

			// Get content field
			$image_gallery = get_the_content();

			// CSS classes
			$class  = '';
			$class .= 'mt-pgrid mt-pgrid-gallery clearfix mt-ps no-transition';
			$class .= ( $atts['size'] ) ? ' mt-pgrid-col-' . $atts['size'] : ' mt-pgrid-col-3';

			// Get gallery settings
			$grid_type = ( $atts['type'] ) ? $atts['type'] : 'masonry';

			// Margin setting
			$margin = $atts['margin'] / 2;
			if ( ! empty( $atts['margin'] ) ) {
				$gallery_wrapper_margin = ' style="padding: ' . esc_attr( $margin ) . 'px"';
				$gallery_margin = ' style="padding: ' . esc_attr( $margin ) . 'px;"';
			} else {
				$gallery_wrapper_margin = '';
				$gallery_margin = '';
			}

			// Check if the content field has gallery added
			if( ! empty( $image_gallery ) ) {

				preg_match( '/\[gallery.*ids=.(.*).\]/', $image_gallery, $ids );

				$image_ids = explode( ",", $ids[1] ); // Get all image ids from short code
				?>

				<div class="portfolio-media portfolio-<?php echo esc_attr( $grid_type ); ?>"<?php echo $gallery_wrapper_margin; ?>>

					<div class="<?php echo esc_attr( trim( $class ) ); ?>" itemscope itemtype="http://schema.org/ImageGallery">

						<?php
						foreach( $image_ids as $image_id ) {

							// Create different image sizes based on grid type
							$att_url    = wp_get_attachment_url( $image_id, 'full' );
							if ( $atts['size'] == '2' ) {
								$thumb  = aq_resize( $att_url, 1200, 9999, false, false );
							} else {
								$thumb  = aq_resize( $att_url, 800, 9999, false, false );
							}
							$full       = wp_get_attachment_image_src( $image_id, 'full', true );
							$thumb_meta = wp_prepare_attachment_for_js( $image_id );
							$thumb_alt  = ! empty( $thumb_meta['alt'] ) ? $thumb_meta['alt'] : $thumb_meta['title'];
						?>

							<figure class="mt-pgrid-item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject"<?php echo $gallery_margin; ?>>
								<a class="mt-pgrid-link" href="<?php echo esc_url( $full[0] ); ?>" itemprop="contentUrl" data-size="<?php echo esc_attr( $full[1] ); ?>x<?php echo esc_attr( $full[2] ); ?>">
									<?php
									// Image
									echo sprintf(
										'<img class="lazyload" src="%s" data-src="%s" width="%s" height="%s" alt="%s" itemprop="thumbnail">',
										esc_url( get_template_directory_uri() . '/images/pre-lazyload.png' ),
										esc_url( $thumb[0] ),
										esc_attr( $thumb[1] ),
										esc_attr( $thumb[2] ),
										esc_html( $thumb_alt )
									);
									?>
									<div class="mt-gallery-overlay">
										<div class="mt-gallery-overlay-inner">
											<span class="mt-plus"></span>
										</div>
									</div>
								</a>
								<?php if ( $atts['caption'] != 'no' ) { ?>
									<figcaption class="mt-ps-caption" itemprop="caption description">
										<h6><?php echo esc_html( $thumb_meta['title'] ); ?></h6>
										<?php
										if ( ! empty( $thumb_meta['caption'] ) ) {
											echo esc_html( $thumb_meta['caption'] );
										}
										?>
										<?php
										if ( $atts['exif'] == 'yes' ) {
											dosei_exif_data( $image_id );
										}
										?>
									</figcaption>
								<?php } ?>
							</figure>

						<?php } ?>

					</div><!-- .mt-pgrid -->

				</div><!-- .portfolio-media -->

				<?php get_template_part( 'template-parts/photoswipe' ); ?>

			<?php }

		endwhile;
	endif;

	wp_reset_query();

	$gallery_markup = ob_get_contents();

	ob_end_clean();

	return $gallery_markup;
}

/**
 * Gallery - Justified
 */
function mt_gallery_justified( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"id"         => false,
		"caption"    => false,
		"margin"     => false,
		"height"     => false,
		"exif"       => false
	), $atts );

	ob_start();

	// Loop args
	$gallery_loop = new WP_Query( array(
		'post_type'	=> 'gallery',
		'p' 		=> absint( $atts['id'] )
	) );

	// Loop start
	if( $gallery_loop->have_posts() ) :
		while( $gallery_loop->have_posts() ) : $gallery_loop->the_post();

			// Get content field
			$image_gallery = get_the_content();

			// CSS classes
			$class  = '';
			$class .= 'mt-pj mt-pj-justified mt-ps';

			// Check if the content field has gallery added
			if( ! empty( $image_gallery ) ) {

				preg_match( '/\[gallery.*ids=.(.*).\]/', $image_gallery, $ids );

				$image_ids = explode( ",", $ids[1] ); // Get all image ids from short code
				?>

				<div class="portfolio-media portfolio-justified">

					<div class="<?php echo esc_attr( trim( $class ) ); ?>" itemscope itemtype="http://schema.org/ImageGallery" data-pj-margin="<?php echo esc_attr( $atts['margin'] ); ?>">

						<?php
						foreach( $image_ids as $image_id ) {

							// Create different image sizes based on grid type
							$att_url    = wp_get_attachment_url( $image_id, 'full' );
							if ( ! empty( $atts['height'] ) ) {
								$thumb  = aq_resize( $att_url, 9999, $atts['height'], false, false );
							} else {
								$thumb  = aq_resize( $att_url, 9999, 500, false, false );
							}
							$full       = wp_get_attachment_image_src( $image_id, 'full', true );
							$thumb_meta = wp_prepare_attachment_for_js( $image_id );
							$thumb_alt  = ! empty( $thumb_meta['alt'] ) ? $thumb_meta['alt'] : $thumb_meta['title'];
						?>

							<figure class="mt-pj-item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
								<a class="mt-pj-link" href="<?php echo esc_url( $full[0] ); ?>" itemprop="contentUrl" data-size="<?php echo esc_attr( $full[1] ); ?>x<?php echo esc_attr( $full[2] ); ?>">
									<?php
									// Image
									echo sprintf(
										'<img class="lazyload" src="%s" data-src="%s" width="%s" height="%s" alt="%s" itemprop="thumbnail">',
										esc_url( get_template_directory_uri() . '/images/pre-lazyload.png' ),
										esc_url( $thumb[0] ),
										esc_attr( $thumb[1] ),
										esc_attr( $thumb[2] ),
										esc_html( $thumb_alt )
									);
									?>
									<div class="mt-gallery-overlay">
										<div class="mt-gallery-overlay-inner">
											<span class="mt-plus"></span>
										</div>
									</div>
								</a>
								<?php if ( $atts['caption'] != 'no' ) { ?>
									<figcaption class="mt-ps-caption" itemprop="caption description">
										<h6><?php echo esc_html( $thumb_meta['title'] ); ?></h6>
										<?php
										if ( ! empty( $thumb_meta['caption'] ) ) {
											echo esc_html( $thumb_meta['caption'] );
										}
										?>
										<?php
										if ( $atts['exif'] == 'yes' ) {
											dosei_exif_data( $image_id );
										}
										?>
									</figcaption>
								<?php } ?>
							</figure>

						<?php } ?>

					</div><!-- .mt-pj -->

				</div><!-- .portfolio-media -->

				<?php if ( ! empty( $atts['margin'] ) ) { ?>
					<style>.mt-pj {padding: <?php echo esc_attr( $atts['margin'] ); ?>px;}.mt-pj-item {margin-bottom: <?php echo esc_attr( $atts['margin'] ); ?>px;}</style>
				<?php } ?>

				<?php get_template_part( 'template-parts/photoswipe' ); ?>

			<?php }

		endwhile;
	endif;

	wp_reset_query();

	$gallery_markup = ob_get_contents();

	ob_end_clean();

	return $gallery_markup;
}

/**
 * Gallery - Slider
 */
function mt_gallery_slider( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"id"       => false,
		"autoplay" => false,
		"scale"    => false
	), $atts );

	ob_start();

	// Loop args
	$gallery_loop = new WP_Query( array(
		'post_type'	=> 'gallery',
		'p' 		=> absint( $atts['id'] )
	) );

	// Loop start
	if( $gallery_loop->have_posts() ) :
		while( $gallery_loop->have_posts() ) : $gallery_loop->the_post();

			// Get content field
			$image_gallery = get_the_content();

			// CSS classes
			$class  = '';
			$class .= 'mt-pfp mt-ps';
			$class .= ( $atts['scale'] != 'no' ) ? ' mt-pfp-scale' : '';

			// Check if the content field has gallery added
			if( ! empty( $image_gallery ) ) {

				preg_match( '/\[gallery.*ids=.(.*).\]/', $image_gallery, $ids );

				$image_ids = explode( ",", $ids[1] ); // Get all image ids from short code
				?>

				<div class="mt-pc-wrapper">

					<div class="<?php echo esc_attr( trim( $class ) ); ?>" itemscope itemtype="http://schema.org/ImageGallery">

						<?php
						foreach( $image_ids as $image_id ) {

							// Create different image sizes based on grid type
							$att_url    = wp_get_attachment_url( $image_id, 'full' );
							$mobile     = aq_resize( $att_url, 800, 9999, false, false );
							$tablet     = aq_resize( $att_url, 1200, 9999, false, false );
							$desktop    = wp_get_attachment_image_src( $image_id, 'full', true );
							$thumb_meta = wp_prepare_attachment_for_js( $image_id );
							$thumb_alt  = ! empty( $thumb_meta['alt'] ) ? $thumb_meta['alt'] : $thumb_meta['title'];
						?>

							<figure class="mt-pfp-item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
								<div class="mt-preloader"></div>

								<?php
								// Image
								echo sprintf(
									'<div class="mt-pfp-image lazyload" data-sizes="auto" data-bgset="%s 600w, %s 1100w, %s 1200w"></div>',
									esc_url( $mobile[0] ),
									esc_url( $tablet[0] ),
									esc_url( $desktop[0] )
								);
								?>
								<a class="mt-pfp-count mt-gallery-count" href="#mt-pfp-thumbs-modal">
									<span class="mt-pfp-count-current"></span>/<span class="mt-pfp-count-total"></span>
								</a>
							</figure>

						<?php } ?>

					</div><!-- .mt-pfp -->

					<div id="mt-pfp-thumbs-modal" class="mt-pfp-thumbs zoom-anim-dialog mfp-hide">
						<ul class="mt-pfp-thumbs-list list-unstyled clearfix">
							<?php
							foreach( $image_ids as $image_id ) {

								// Thumb
								$thumb = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
								?>
								<li>
									<a href="#">
										<?php
										// Image
										echo sprintf(
											'<img class="lazyload" src="%s" data-src="%s" width="%s" height="%s" alt="%s">',
											esc_url( get_template_directory_uri() . '/images/pre-lazyload.png' ),
											esc_url( $thumb[0] ),
											esc_attr( $thumb[1] ),
											esc_attr( $thumb[2] ),
											esc_html( get_the_title() )
										); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div><!-- .mt-pfp-thumbs -->

					<?php if ( $atts['autoplay'] != 'no' ) { ?>
					<div class="mt-pcontrols mt-gallery-autoplay">
						<div class="mt-pc-autoplay" href="#">
							<div class="mt-pc-autoplay-inner">
								<a class="mt-pc-play" href="#"><i class="pe-7s-play"></i></a>
								<a class="mt-pc-pause" href="#"><span></span></a>
							</div>
						</div>
					</div>
					<?php } ?>

				</div><!-- .mt-pc-wrapper -->

			<?php }

		endwhile;
	endif;

	wp_reset_query();

	$gallery_markup = ob_get_contents();

	ob_end_clean();

	return $gallery_markup;
}

/**
 * Heading
 */
function mt_heading( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"size"   => false,
		"align"  => false,
		"xclass" => false
	), $atts );

	// CSS classes
	$class  = 'mt-heading';
	$class .= ( $atts['align'] ) ? ' text-' . $atts['align'] : ' text-left';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	// Size
	$head_size = ( $atts['size'] ) ? 'h' . $atts['size'] : 'h1';

	// HTML Markup
	$html  = '<' . esc_attr( $head_size ) . ' class="' . esc_attr( trim( $class ) ) . '">';
		$html .= '<span class="mt-heading-title">' . do_shortcode( $content ) . '</span>';
	$html .= '</' . esc_attr( $head_size ) . '>';

	return $html;
}

/**
 * Highlight
 */
function mt_highlight( $atts, $content = null ) {

	/* HTML Markup */
	return '<span class="mt-highlight">' . do_shortcode( $content ) . '</span>';
}

/**
 * Milestone
 */
function mt_milestone( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title"  	 => false,
		"style"  	 => false,
		"number" 	 => false,
		"from" 	 	 => false,
		"duration" 	 => false,
		"before" 	 => false,
		"after" 	 => false,
		"icon" 	 	 => false,
		"xclass" 	 => false
	), $atts );

	// CSS classes
	$class  = 'mt-milestone';
	$class .= ( $atts['style'] ) ? ' mt-milestone-' . $atts['style'] : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	// Count
	$count_from     = ( $atts['from'] ) ? ' data-count-from="' . absint( $atts['from'] ) . '"' : ' data-count-from="0"';
	$count_to       = ( $atts['number'] ) ? ' data-count-to="' . absint( $atts['number'] ) . '"' : ' data-count-to="1"';
	$count_duration = ( $atts['duration'] ) ? ' data-count-duration="' . absint( $atts['duration'] ) . '"' : ' data-count-duration="2000"';

	// Before and after number
	$before_number = ( $atts['before'] ) ? $atts['before'] : '';
	$after_number  = ( $atts['after'] ) ? $atts['after'] : '';

	// HTML Markup
	$html  = '<div class="' . esc_attr( trim( $class ) ) . '">';
		if ( ! empty( $atts['icon'] ) ) {
			$html .= '<div class="mt-milestone-icon"><i class="' . esc_html( $atts['icon'] ) . '"></i></div>';
		}
		if ( ! empty( $atts['number'] ) ) {
			$html .= '<div class="mt-milestone-number"' . $count_to . '' . $count_from . '' . $count_duration . '>' . esc_html( $before_number ) . '<span>' . absint( $atts['from'] ) . '</span>' . esc_html( $after_number ) . '</div>';
		}
		if ( ! empty( $atts['title'] ) ) {
			$html .= '<h6 class="mt-milestone-title">' . esc_html( $atts['title'] ) . '</h6>';
		}
	$html .= '</div>';

	return $html;
}

/**
 * Pricing
 */
function mt_pricing( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title"       => false,
		"icon"        => false,
		"price"       => false,
		"currency"    => false,
		"period"      => false,
		"link"        => false,
		"link_title"  => false,
		"style"       => false,
		"recommended" => false,
		"xclass"      => false
	), $atts );

	// CSS classes
	$class  = 'mt-pricing';
	$class .= ( $atts['recommended'] ) ? ' mt-pricing-recommended' : '';
	$class .= ( $atts['style'] == 'light' ) ? ' mt-pricing-light' : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	// HTML Markup
	$html  = '<div class="' . esc_attr( trim( $class ) ) . '">';
		if ( $atts['icon'] ) {
			$html .= '<div class="mt-pricing-icon"><i class="' . esc_attr( $atts['icon'] ) . '"></i></div>';
		}
		if ( $atts['title'] ) {
			$html .= '<h3 class="mt-pricing-title">' . esc_html( $atts['title'] ) . '</h3>';
		}
		if ( $atts['price'] ) {
			$html .= '<div class="mt-pricing-value">';
			if ( $atts['currency'] ) {
				$html .= '<span class="mt-pricing-currency">' . esc_html( $atts['currency'] ) . '</span>';
			}
			$html .= esc_html( $atts['price'] );
			if ( $atts['period'] ) {
				$html .= '<span class="mt-pricing-period">' . esc_html( $atts['period'] ) . '</span>';
			}
			$html .= '</div>';
		}
		$html .= do_shortcode( $content );
		if ( $atts['link'] ) {
			$html .= '<a class="mt-btn mt-btn-round anim-link" href="' . esc_url( $atts['link'] ) . '">' . esc_html( $atts['link_title'] ) . '</a>';
		}
	$html .= '</div>';

	return $html;
}

/**
 * Row
 */
function mt_row( $atts, $content = null ) {

	/* HTML Markup */
	return '<div class="row">' . do_shortcode( $content ) . '</div>';
}

/**
 * Section
 */
function mt_section( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"container"    => false,
		"bgcolor" 	   => false,
		"bgimage"      => false,
		"bgrepeat"     => "no-repeat",
		"bgposition"   => "center",
		"bgattachment" => "scroll",
		"bgsize"       => "cover",
		"parallax"     => false,
		"speed"        => false,
		"padding"      => false,
		"xclass"       => false
	), $atts );

	// Generate unique ID
	$id = get_the_ID();
	STATIC $i = 0;
	$i++;
	$rand = $id .'-'. $i;

	// CSS classes
	$class  = 'mt-section';
	$class .= ( $atts['parallax'] == 'yes' ) ? ' mt-section-parallax' : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	// Styles
	$styles = '';
	// Start of styles
	if ( $atts['bgcolor'] != '' || $atts['bgimage'] != '' || $atts['padding'] != '' ) {
		$styles .= ' style="';

			// Background color
			if ( $atts['bgcolor'] != '' ) {
				$styles .= 'background-color: ' . esc_attr( $atts['bgcolor'] ) . ';';
			}
			// Background image
			if ( $atts['bgimage'] != '' ) {
				$styles .= 'background-image: url(' . esc_url( $atts['bgimage'] ) . ');';
				// Background repeat
				$styles .= 'background-repeat: ' . esc_attr( $atts['bgrepeat'] ) . ';';
				// Background position
				$styles .= 'background-position: ' . esc_attr( $atts['bgposition'] ) . ';';
				// Background attachment
				if ( $atts['parallax'] == 'yes' ) {
					$styles .= 'background-attachment: fixed;';
				} else {
					$styles .= 'background-attachment: ' . esc_attr( $atts['bgattachment'] ) . ';';
				}
				// Background size
				$styles .= 'background-size: ' . esc_attr( $atts['bgsize'] ) . ';';
			}

			// Padding
			if ( $atts['padding'] != '' ) {
				$styles .= 'padding: ' . esc_attr( $atts['padding'] ) . ';';
			}

		// End of styles
		$styles .= '"';
	}

	// Parallax speed
	$parallax_speed = ( $atts['speed'] ) ? ' data-parallax-speed="' . absint( $atts['speed'] ) . '"' : '';

	// HTML Markup
	$html  = '<div id="mt-section-' . esc_attr( $rand ) . '" class="' . esc_attr( trim( $class ) ) . '"'; // CSS class
	$html .= $styles; // Styles, all escaped previously
	$html .= $parallax_speed; // Parallax speed
	$html .= '>'; // Close div
		if ( $atts['container'] != 'no' ) { $html .= '<div class="container">'; }
			$html .= do_shortcode( $content );
		if ( $atts['container'] != 'no' ) { $html .= '</div>'; }
	$html .= '</div>';

	return $html;
}

/**
 * Section - Video
 */
function mt_section_video( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"container" => false,
		"mp4"       => false,
		"webm"      => false,
		"ogv"       => false,
		"loop"      => false,
		"poster"    => false,
		"bgcolor"   => false,
		"bgopacity" => false,
		"padding"   => false,
		"xclass"    => false
	), $atts );

	// Generate unique ID
	$id = get_the_ID();
	STATIC $i = 0;
	$i++;
	$rand = $id .'-'. $i;

	// CSS classes
	$class  = 'mt-section mt-section-video';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	// Padding
	$padding = '';
	if ( $atts['padding'] != '' ) {
		$padding .= ' style="padding: ' . esc_attr( $atts['padding'] ) . ';"';
	}

	// Overlay
	$overlay = '';
	if ( $atts['bgcolor'] ) {
		$overlay .= '<div class="mt-section-overlay" style="background-color: ' . esc_attr( $atts['bgcolor'] ) . ';';
		if ( $atts['bgopacity'] ) {
			$overlay .= 'opacity: ' . esc_attr( $atts['bgopacity'] ) . ';';
		}
		$overlay .= '">';
		$overlay .= '</div>';
	}

	// Video
	$video = '';
	$video .= '<div class="mt-section-video-bg">';
		$video .= '<video preload="auto" autoplay muted';
		$video .= ( $atts['loop'] == 'yes' ) ? ' loop' : '';
		if ( $atts['poster'] ) {
			$video .= ' poster="' . $atts['poster'] . '"';
		}
		$video .= '>'; // Close <video>
			$video .= ( $atts['mp4'] ) ? '<source src="' . $atts['mp4'] . '" type="video/mp4">' : '';
			$video .= ( $atts['webm'] ) ? '<source src="' . $atts['webm'] . '" type="video/webm">' : '';
			$video .= ( $atts['ogv'] ) ? '<source src="' . $atts['ogv'] . '" type="video/ogv">' : '';
		$video .= '</video>';
	if ( $atts['poster'] ) {
		$video .= '<div class="mt-section-video-poster" style="background-image: url(' . $atts['poster'] . ');"></div>';
	}
	$video .= $overlay;
	$video .= '</div>';

	// HTML Markup
	$html  = '<div id="mt-section-' . esc_attr( $rand ) . '" class="' . esc_attr( trim( $class ) ) . '">'; // CSS class
		$html .= $video; // Video
		$html .= '<div class="mt-section-video-inner"' . $padding . '>';
			if ( $atts['container'] != 'no' ) { $html .= '<div class="container">'; }
				$html .= do_shortcode( $content );
			if ( $atts['container'] != 'no' ) { $html .= '</div>'; }
		$html .= '</div>';
	$html .= '</div>';

	return $html;
}

/**
 * Service
 */
function mt_service( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title"      => false,
		"type"       => false,
		"style"      => false,
		"icon"       => false,
		"icon_style" => false,
		"link"       => false,
		"link_title" => false,
		"xclass"     => false,
	), $atts );

	// CSS classes
	$class  = 'mt-service';
	$class .= ( $atts['type'] ) ? ' mt-service-' . $atts['type'] : ' mt-service-left';
	$class .= ( $atts['style'] ) ? ' mt-service-' . $atts['style'] : '';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	/* HTML Markup */
	$html  = '<div class="' . esc_attr( trim( $class ) ) . '">';
		$html .= '<span class="mt-service-icon mt-service-icon-' . $atts['icon_style'] . '"><i class="' . esc_html( $atts['icon'] ) . '"></i></span>';
		$html .= '<div class="mt-service-content">';
			$html .= '<h6 class="mt-service-title">' . esc_html( $atts['title'] ) . '</h6>';
			$html .= '<div class="mt-service-text">' . do_shortcode( $content ) . '</div>';
			if ( $atts['link'] != '' && $atts['link_title'] != '' ) {
				$html .= '<a href="' . esc_url( $atts['link'] ) . '" class="mt-service-link anim-link">' . esc_html( $atts['link_title'] ) . '</a>';
			}
		$html .= '</div>';
	$html .= '</div>';

	return $html;
}

/**
 * Tabs
 */
function mt_tabs( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"type" => false,
	), $atts );

	/* Extract the tab titles from [mt-tab] */
	preg_match_all( '/mt-tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

	$tab_titles = array();
	if( isset( $matches[1] ) ) { $tab_titles = $matches[1]; }

	/* HTML Markup */
	$html = '';
	if ( $atts['type'] == 'features' ) {
		$html .= '<div class="mt-tabs mt-tabs-features js-mt-tabs">';
	} else {
		$html .= '<div class="mt-tabs js-mt-tabs">';
	}
		$html .= '<ul class="mt-tabs-tablist js-mt-tabs-tablist">';

		foreach( $tab_titles as $tab ) {

			/* Generate unique ID */
			$id = get_the_ID();
			STATIC $i = 0;
			$i++;
			$rand = $id .'-'. $i;

			$html .= '<li class="mt-tabs-tablist-item">';
				$html .= '<a class="mt-tabs-tab" id="tab' . esc_attr( $i ) . '" href="#panel' . esc_attr( $rand ) . '">';
					$html .= esc_html( $tab[0] );
				$html .= '</a>';
			$html .= '</li>';
		}

		$html .= '</ul>'; // .mt-tabs-tablist
		$html .= do_shortcode( $content );
	$html .= '</div>'; // .mt-tabs

	return $html;
}
function mt_tab( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title" => "Title",
	), $atts );

	/* Generate unique ID */
	$id = get_the_ID();
	STATIC $c = 0;
	$c++;
	$tabID = $id .'-'. $c;

	/* HTML Markup */
	return '<section class="mt-tabs-panel js-mt-tabs-panel" id="panel' . esc_attr( $tabID ) . '">' . do_shortcode( $content ) . '</section>';
}

/**
 * Testimonial
 */
function mt_testimonial( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		"title"    => false,
		"subtitle" => false,
		"thumb"    => false,
		"style"    => false,
		"xclass"   => false,
	), $atts );

	// CSS classes
	$class  = 'mt-testimonial';
	$class .= ( $atts['style'] ) ? ' mt-testimonial-' . $atts['style'] : ' mt-testimonial-default';
	$class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

	/* HTML Markup */
	$html  = '<div class="' . esc_attr( trim( $class ) ) . '">';
		if ( ! empty( $atts['thumb'] ) ) {
			$html .= '<img class="mt-testimonial-thumb" src="' . esc_url( $atts['thumb'] ) . '" alt="' . esc_html( $atts['title'] ) . '">';
		}
		if ( ! empty( $atts['title'] ) ) {
			$html .= '<h5 class="mt-testimonial-title">' . esc_html( $atts['title'] ) . '</h5>';
		}
		if ( ! empty( $atts['subtitle'] ) ) {
			$html .= '<h6 class="mt-testimonial-subtitle">' . esc_html( $atts['subtitle'] ) . '</h6>';
		}
		$html .= '<div class="mt-testimonial-text">' . do_shortcode( $content ) . '</div>';
	$html .= '</div>';

	return $html;
}