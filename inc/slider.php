<?php
/**
 * Carousel template
 *
 * @package Oria
 */

	//Scripts
	function oria_slider_scripts() {
			wp_enqueue_script( 'oria-owl-script', get_template_directory_uri() .  '/js/owl.carousel.min.js', array( 'jquery' ), true );	
			wp_enqueue_script( 'oria-slider-init', get_template_directory_uri() .  '/js/slider-init.js', array( 'jquery' ), true );
			
			//Slider speed options
			if ( ! get_theme_mod('carousel_speed') ) {
				$slideshowspeed = 4000;
			} else {
				$slideshowspeed = intval(get_theme_mod('carousel_speed'));
			}			
			$slider_options = array(
				'slideshowspeed' => $slideshowspeed,
			);			
			wp_localize_script('oria-slider-init', 'sliderOptions', $slider_options);			
	}
	add_action( 'wp_enqueue_scripts', 'oria_slider_scripts' );

	//Template
	if ( ! function_exists( 'oria_slider_template' ) ) {
		function oria_slider_template() {
	       
	       	//Get the user choices
	        $number     = get_theme_mod('carousel_number');
	        $cat        = get_theme_mod('carousel_cat');
	        $number     = ( ! empty( $number ) ) ? intval( $number ) : 6;
	        $cat        = ( ! empty( $cat ) ) ? intval( $cat ) : '';

			$args = array(
				'posts_per_page'		=> $number,
				'post_status'   		=> 'publish',
	            'cat'                   => $cat,
	            'ignore_sticky_posts'   => true			
			);
			$query = new WP_Query( $args );	
			if ( $query->have_posts() ) {
			?>
			<div class="oria-slider slider-loader">
				<div class="featured-inner clearfix">
					<div class="slider-inner">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<div class="slide">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'oria-carousel' ); ?>
							<?php else : ?>
								<?php echo '<img src="' . get_stylesheet_directory_uri() . '/images/placeholder.png"/>'; ?>
							<?php endif; ?>
							<?php the_title( sprintf( '<h3 class="slide-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
						</div>
					<?php endwhile; ?>
					</div>
				</div>
			</div>
			<?php }
			wp_reset_postdata();
		}
	}