<?php
/**
 * Template part for displaying footer items
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<div<?php manta_attr( 'footer-items' ); ?>>

	<div<?php manta_attr( 'wrap' ); ?>>

		<?php // Display Copyright text. ?>
		<div<?php manta_attr( 'footer-text' ); ?>>
			<?php echo manta_render_copyright_info(); ?>
			<span class="sep"> | </span>
			<?php
			printf(
				esc_html__( 'Powered by %1$s', 'manta' ),
				'<a href="' . esc_url( __( 'https://wordpress.org/', 'manta' ) ) . '">WordPress</a>'
			);
			?>
			<span class="sep"> | </span>
			<?php
			printf(
				esc_html__( 'Theme by %1$s', 'manta' ),
				// Note: URI is escaped via `WP_Theme::markup_header()`.
				'<a href="' . wp_get_theme( get_template() )->display( 'AuthorURI' ) . '" rel="designer">PremiumWP</a>'
			);
			?>
		</div><!-- .copyright-text -->

	</div><!-- .wrap -->

</div><!-- .footer-items -->
