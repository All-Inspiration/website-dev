<?php
/**
 * Customizer Utility Functions
 *
 * @package 	laveo_customizer
 * @author		Devin Price, The Theme Foundry
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function laveo_customizer_customize_preview_js() {
	wp_enqueue_script( 'laveo_customizer_customizer', get_template_directory_uri()  . '/inc/admin/customizer/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'laveo_customizer_customize_preview_js' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function laveo_customizer_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'laveo_customizer_customize_register' );