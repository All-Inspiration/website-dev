<?php
/**
 * Template Name: Home Page
 *
 **/
get_header(); ?>
	<div class="full_width">
		<div class="container">
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
			?>
		</div>
	</div><!-- #main-content -->
<?php
//if ( is_active_sidebar( 'homepage_top_widget' ) ) {
//	echo '<div id="feature_area" class="full_width">';
//	echo '<div class="page">';
//	dynamic_sidebar( 'homepage_top_widget' );
//	echo '</div>';
//	echo '</div>';
//}
//?>
	<!---->
<?php
//if ( is_active_sidebar( 'homepage_main_widget' ) ) {
//	echo '<div id="content_area" class="full_width">
//		<div class="page"><div id="content_box"><div id="content">';
//	dynamic_sidebar( 'homepage_main_widget' );
//	echo '</div>';
//	get_sidebar();
//	echo '</div></div></div>';
//}
//?>
<?php get_footer(); ?>