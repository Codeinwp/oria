<?php
/**
 * The template for displaying search results pages.
 *
 * @package Oria
 */

get_header(); ?>

	<section id="primary" class="content-area fullwidth">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<h2 class="archive-title"><?php printf( esc_html__( 'Search Results for: %s', 'oria' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<div class="posts-layout">			
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php endwhile; ?>
			</div>			

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
