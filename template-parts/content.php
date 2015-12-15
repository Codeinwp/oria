<?php
/**
 * @package Oria
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="item-sizer">
	<?php if ( has_post_thumbnail() && ( get_theme_mod( 'index_feat_image' ) != 1 ) ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('oria-small-thumb'); ?></a>		
		</div>
	<?php endif; ?>

	<header class="entry-header blog-entry-header">
		<?php if ( 'post' == get_post_type() && get_theme_mod('hide_meta_index') != 1 ) : ?>		
		<div class="entry-data">
			<?php oria_index_data(); ?>
		</div>
		<?php endif; ?>	
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oria' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</div>
</article><!-- #post-## -->