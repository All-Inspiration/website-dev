<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package laveo
 */

get_header(); ?>
<div id="content_area" class="full_width">
	<div class="page">
		<div class="inline-active"></div>
		<div id="content_box">
			<div class="hfeed" id="content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					get_template_part( 'template-parts/content', 'single' );
					?>
				<?php endwhile; ?>
				<div class="clear"></div>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
 			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
