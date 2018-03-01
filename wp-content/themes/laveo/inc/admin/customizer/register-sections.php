<?php
function remove_styles_sections() {
	global $wp_customize;
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
}

add_action( 'customize_register', 'remove_styles_sections', 20 );

function laveo_register_customizer_options() {
 	// Stores all the controls that will be added
	$options = $sections = $panels =array();
 	// Adds the sections to the $options array
	//$options['sections'] = $sections;
	// Logo
	include get_template_directory() . "/inc/admin/register-sections/logo.php";
	// color
	include get_template_directory() . "/inc/admin/register-sections/color.php";
	//typography
	include get_template_directory() . "/inc/admin/register-sections/typography.php";
  	//custom css
	include get_template_directory() . "/inc/admin/register-sections/custom-css.php";

	// Adds the sections to the $options array
	$options['sections'] = $sections;
	// Adds the panels to the $options array
	$options['panels']        = $panels;
	$laveo_customizer = laveo_customizer::Instance();
	$laveo_customizer->add_options( $options );
}

add_action( 'init', 'laveo_register_customizer_options' );