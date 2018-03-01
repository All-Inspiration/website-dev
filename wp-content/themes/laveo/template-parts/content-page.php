<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */

?>
<article id="single_content" <?php post_class(); ?>>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'laveo' ),
			'after'  => '</div>'
		) ); ?>
		<?php edit_post_link( 'Edit this entry.', '<p class="clear">', '</p>' ); ?>
	</div>
	<!-- .entry-content -->
</article><!-- #post-## -->

