<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package laveo
 */

get_header(); ?>
<div id="content_area" class="full_width">
	<div class="page">
		<div class="inline-active"></div>
		<div id="content_box">
			<div class="hfeed" id="content">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'laveo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
 				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<ul class="category">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
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
