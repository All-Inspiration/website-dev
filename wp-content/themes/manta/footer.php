<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Manta
 * @since 1.0.0
 */

?>
		
		</div><!-- #content -->

		<?php
		/**
		 * Fires immediately before site footer area.
		 *
		 * @since 1.0.0
		 */
		do_action( 'manta_hook_before_footer' ); ?>

		<footer id="colophon" role="contentinfo"<?php manta_attr( 'site-footer' ); ?>>
			<div<?php manta_attr( 'wrap' ); ?>>

				<?php
				/**
				 * Fires immediately after opening site footer tag.
				 *
				 * @since 1.0.0
				 */
				do_action( 'manta_hook_for_footer_items' );?>

			</div>

		</footer><!-- #colophon -->

		<?php
		/**
		 * Fires immediately after site footer area.
		 *
		 * @since 1.0.0
		 */
		do_action( 'manta_hook_after_footer' );?>

		</div><!-- #page -->

		<?php wp_footer(); ?>
	</body>
</html>
