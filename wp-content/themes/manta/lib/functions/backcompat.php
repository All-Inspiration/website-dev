<?php
/**
 * Defaults values for customizer options
 *
 * @package Manta
 * @since 1.0.0
 */

/**
 * Print the markup for a custom header.
 *
 * This function is to make theme compatible with versions prior to WordPress 4.7.
 * It should be removed once theme stop supporting versions prior to 4.7.
 *
 * @since 1.1.1
 *
 * @return void.
 */
function manta_custom_header_markup() {
	$custom_header = manta_get_custom_header_markup();
	if ( empty( $custom_header ) ) {
		return;
	}

	echo $custom_header;
}

/**
 * Retrieve the markup for a custom header.
 *
 * This function is to make theme compatible with versions prior to WordPress 4.7.
 * It should be removed once theme stop supporting versions prior to 4.7.
 *
 * @since 1.1.1
 *
 * @return string The markup for a custom header on success.
 */
function manta_get_custom_header_markup() {
	if ( ! get_header_image() && ! is_customize_preview() ) {
		return '';
	}

	return sprintf(
		'<div id="wp-custom-header" class="wp-custom-header">%s</div>',
		get_header_image_tag()
	);
}
