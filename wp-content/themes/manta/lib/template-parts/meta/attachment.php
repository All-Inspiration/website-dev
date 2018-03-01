<?php
/**
 * The template part for displaying image attachment meta information
 *
 * @package Manta
 * @since 1.0.0
 */

if ( ! is_attachment() || ! wp_attachment_is_image() ) {
	return;
}

// Retrieve attachment metadata.
$manta_metadata = wp_get_attachment_metadata();
?>

<span class="full-size-link">
	<span class="screen-reader-text"><?php esc_html_e( 'Full size attachment link', 'manta' ); ?></span>
	<a href="<?php esc_url( wp_get_attachment_url() ); ?>">
		<?php $manta_metadata['width']; ?> &times; <?php $manta_metadata['height'] ?>
	</a>
</span><!-- .full-size-link -->
