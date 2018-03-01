<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package laveo
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="sidebars" class="widget-area" role="complementary">
	<div class="sidebar" id="sidebar_1">
		<div class="sidebar_list">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div>
</div><!-- #secondary -->
