<?php
/**
 * Theme customizer selective refresh render callback functions.
 *
 * @package	 Manta
 * @since 1.1
 */

/**
 * Render the content sidebar wrap for the selective refresh partial.
 *
 * @since 1.1
 *
 * @return void
 */
function manta_customize_partial_cs_wrap() {?>
	<div<?php manta_attr( 'content-sidebar-wrap' ); ?>>

		<div id="primary"<?php manta_attr( 'content-area' ); ?>>

			<?php do_action( 'manta_hook_before_main_content' ); ?>

			<main id="main" role="main"<?php manta_attr( 'site-main' ); ?>>

				<?php
				if ( have_posts() ) :
					do_action( 'manta_hook_for_main_loop' );
				else :
					get_template_part( 'lib/template-parts/content/none' );
				endif;
				?>

			</main><!-- #main -->

			<?php do_action( 'manta_hook_after_main_content' ); ?>

		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
<?php
}

/**
 * Render the site main content for the selective refresh partial.
 *
 * @since 1.1
 *
 * @return void
 */
function manta_customize_partial_main_content() {
	if ( have_posts() ) :
		do_action( 'manta_hook_for_main_loop' );
	else :
		get_template_part( 'lib/template-parts/content/none' );
	endif;
}

/**
 * Render the copyright text for the selective refresh partial.
 *
 * @since 1.1.1
 *
 * @return void
 */
function manta_customize_partial_copyright() {
	?>
	<div<?php manta_attr( 'copyright-text' ); ?>>
		<?php echo manta_render_copyright_info(); ?>
	</div><!-- .copyright-text -->
	<?php
}

/**
 * Hide Customizer Shortcut Controls for main content
 *
 * @since 1.1
 *
 * @param  string $css Manta inline css.
 */
function manta_disable_main_customizer_shortcuts( $css ) {
	if ( is_customize_preview() ) {
		$css .= '#main .customize-partial-edit-shortcut{display: none!important;}';
	}

	return $css;
}
add_action( 'manta_get_inline_style', 'manta_disable_main_customizer_shortcuts' );
