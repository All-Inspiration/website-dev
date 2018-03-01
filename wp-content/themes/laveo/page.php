<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
					get_template_part( 'template-parts/content', 'page' );
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
