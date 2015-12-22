<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Oria
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area <?php oria_sidebar_mode(); ?>" role="complementary">
	<span class="sidebar-close"><i class="fa fa-times"></i></span>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
