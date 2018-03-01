<?php
/**
 * Customizer Sanization
 *
 * @package 	laveo_customizer
 * @author		Devin Price, The Theme Foundry
 */

if ( ! function_exists( 'laveo_customizer_sanitize_text' ) ) :
/**
 * Sanitize a string to allow only tags in the allowedtags array.
 *
 * @since  1.0.0.
 *
 * @param  string    $string    The unsanitized string.
 * @return string               The sanitized string.
 */
function laveo_customizer_sanitize_text( $string ) {
	global $allowedtags;
	return wp_kses( $string , $allowedtags );
}
endif;

if ( ! function_exists( 'laveo_customizer_sanitize_checkbox' ) ) :
/**
 * Sanitize a checkbox to only allow 0 or 1
 *
 * @since  1.0.0.
 *
 * @param  boolean    $value    The unsanitized value.
 * @return boolean				The sanitized boolean.
 */
function laveo_customizer_sanitize_checkbox( $value ) {
	if ( $value == 1 ) {
		return 1;
    } else {
		return 0;
    }
}
endif;

if ( ! function_exists( 'laveo_customizer_sanitize_choices' ) ) :
/**
 * Sanitize a value from a list of allowed values.
 *
 * @since 1.0.0.
 *
 * @param  mixed    $value      The value to sanitize.
 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
 * @return mixed                The sanitized value.
 */
function laveo_customizer_sanitize_choices( $value, $setting ) {
	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$choices = laveo_customizer_get_choices( $setting );
	$allowed_choices = array_keys( $choices );

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = laveo_customizer_get_default( $setting );
	}

	return $value;
}
endif;

if ( ! function_exists( 'laveo_customizer_sanitize_file_url' ) ) :
/**
 * Sanitize the url of uploaded media.
 *
 * @since 1.0.0.
 *
 * @param  string    $value      The url to sanitize
 * @return string    $output     The sanitized url.
 */
function laveo_customizer_sanitize_file_url( $url ) {

	$output = '';

	$filetype = wp_check_filetype( $url );
	if ( $filetype["ext"] ) {
		$output = esc_url_raw( $url );
	}

	return $output;
}
endif;

if ( ! function_exists( 'sanitize_hex_color' ) ) :
/**
 * Sanitizes a hex color.
 *
 * Returns either '', a 3 or 6 digit hex color (with #), or null.
 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
 *
 * @since 3.4.0
 *
 * @param string $color
 * @return string|null
 */
function sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}
endif;

if ( ! function_exists( 'laveo_customizer_sanitize_range' ) ) :
/**
 * Sanitizes a range value
 *
 * @since 1.3.0
 *
 * @param string $color
 * @return string|null
 */
function laveo_customizer_sanitize_range( $value ) {

	if ( is_numeric( $value ) ) {
		return $value;
	}

	return 0;
}
endif;
