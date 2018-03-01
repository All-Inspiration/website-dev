<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sass2css
 *
 * @author tuannv
 */
require_once LAVEO_THEME_DIR . "/inc/admin/sassphp/scss.inc.php";

define( 'UPLOADS_FOLDER', trailingslashit( WP_CONTENT_DIR ) . 'uploads/' );

class sass2css {
	function __construct() {
		add_action( 'customize_save_after', array( $this, 'sass_to_css' ) );
	}

	function sass_to_css() {
		WP_Filesystem();
		global $wp_filesystem; /* already initialised the Filesystem API previously */
		$scss = new scssc();
		$scss->setImportPaths( __DIR__ . "../../sass/" );

		$fileout            = LAVEO_THEME_DIR . "sass/_config.scss";
		$theme_options_data = '';
		// font family body
		$font_family_body = get_theme_mod( 'font_family_body', laveo_customizer_get_default( 'font_family_body' ) );
		$font_body        = laveo_customizer_get_font_stack( $font_family_body );
		if ( $font_family_body != laveo_customizer_get_default( 'font_family_body' ) ) {
			$theme_options_data .= "\$font_family_body: {$font_body}!default;\n";
		}
		// font heading
		$font_family_heading = get_theme_mod( 'font_family_heading', laveo_customizer_get_default( 'font_family_heading' ) );
		$font_heading        = laveo_customizer_get_font_stack( $font_family_heading );
		if ( $font_family_heading != laveo_customizer_get_default( 'font_family_heading' ) ) {
			$theme_options_data .= "\$font_family_heading: {$font_heading}!default;\n";
		}

		// put content
		$color_default = array( '#ef4d4e', '#ff9c31', '#a9c053', '#27aac5', '#1e73be', '#8224e3', '#3f6338','14px' );
		$theme_options = array(
			'color1',
			'color2',
			'color3',
			'color4',
			'color5',
			'color6',
			'color7',
			'font_size_body'
		);
		$i             = 0;
		foreach ( $theme_options AS $key ) {
			$data = get_theme_mod( $key, $color_default[ $i ] );
			$theme_options_data .= "\${$key}: {$data}!default;\n";
			$i ++;
		}
		$theme_options_data .= $wp_filesystem->get_contents( $fileout );

		$css = $scss->compile( $theme_options_data );
		// custom css
		$css .= get_theme_mod( 'laveo_custom_css' );

		if ( ! $wp_filesystem->put_contents( UPLOADS_FOLDER . 'laveo_custom.css', $css, FS_CHMOD_FILE ) ) {
			@chmod( UPLOADS_FOLDER . 'laveo_custom.css', 0777 );
			$wp_filesystem->put_contents( UPLOADS_FOLDER . 'laveo_custom.css', $css, FS_CHMOD_FILE );
		}

	}
}

new sass2css();