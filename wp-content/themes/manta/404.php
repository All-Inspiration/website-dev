<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Manta
 * @since 1.0.0
 */

get_header(); ?>

	<div<?php manta_attr( 'content-sidebar-wrap' ); ?>>
		<div id="primary"<?php manta_attr( 'content-area' ); ?>>
			<main id="main" role="main"<?php manta_attr( 'site-main' ); ?>>

				<section<?php manta_attr( 'error-404' ); ?>>
					<header<?php manta_attr( 'page-header' ); ?>>
						<h1<?php manta_attr( 'page-title' ); ?>>
							<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'manta' ); ?>
						</h1>
					</header><!-- .page-header -->

					<div<?php manta_attr( 'page-content' ); ?>>
						<h2><?php esc_html_e( 'We tried to find it, but it\'s just not to be found.', 'manta' ); ?></h2>
						<p><?php esc_html_e( 'You might ensure the URL is spelled correctly, or if you followed a link here please let us know. Please try a search to reach your desired destination.', 'manta' ); ?></p>
						<?php get_search_form();?>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
		
		<?php get_sidebar(); ?>
		
	</div><!-- .content-sidebar-wrap -->

<?php
get_footer();
