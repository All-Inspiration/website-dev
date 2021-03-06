<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */

get_header(); ?>

<div id="content_area" class="full_width">
	<div class="page">
		<div class="inline-active"></div>
		<div id="content_box">
			<div class="hfeed" id="content">
				<?php if ( have_posts() ) : ?>
					<?php /* Start the Loop */ ?>
					<ul class="category">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
							?>
						<?php endwhile; ?>
					</ul>
					<?php laveo_posts_navigation(); ?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
