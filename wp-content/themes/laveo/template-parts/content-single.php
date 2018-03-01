<?php
/**
 * Template part for displaying single posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */
$class = "single-content format_text entry-content";
?>

<article id="single_content" <?php post_class( $class ); ?>>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<div class="date"><?php if ( function_exists( 'the_views' ) ): ?> // <?php esc_html_e( 'Views:', 'laveo' ) ?><?php the_views(); ?><?php endif; ?><?php esc_html_e( 'Categories:', 'laveo' ) ?> <?php the_category( ', ' ) ?><?php the_tags( ' // Tags: ', ', ', '' ); ?>.</div>
	<div class="top_img"><?php laveo_img( 575, 200 ) ?></div>
	<div class="published clear">
		<p><?php the_time( esc_html__( 'M j, Y', 'laveo' ) ) ?> // <?php echo esc_html__('By:','laveo')?><?php the_author() ?> // <?php comments_number( esc_html__( 'No Comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></p>
	</div>
 	<div class="entry-content-full">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'laveo' ),
			'after'  => '</div>'
		) ); ?>
		<?php edit_post_link( 'Edit this entry.', '<p class="clear">', '</p>' ); ?>
	</div>
	<!-- .entry-content -->

	<div id="author-box" class="clear">
		<h3><?php printf( esc_html__( 'About %s', 'laveo' ), get_the_author() ); ?></h3>

		<div class="post-gravatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'laveo_author_bio_avatar_size', 68 ) ); ?>
		</div>
		<div class="author-text"><p><?php the_author_meta( 'description' ); ?></p>
 			<p><?php echo esc_html__('Browse Archived Articles by','laveo')?> <span><a href="#"><?php the_author() ?></a></span></p>
		</div>
	</div>
	<?php
	get_template_part( 'inc/relatedposts', '' );
	?>
	<!-- #author-box -->
</article><!-- #post-## -->

