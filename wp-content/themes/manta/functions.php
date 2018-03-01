<?php
/**
 * Manta theme functions and definitions
 *
 * This file defines content width, add theme support for various wordpress
 * features, load required stylesheets and scripts, register menus and widget
 * areas and load other required files to extend theme functionality.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Manta
 * @since 1.0.0
 */

/**
 * Manta only works in WordPress 4.5 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.5', '<' ) ) {
	require get_template_directory() . '/lib/classes/back-compat.php';
	return;
}

/**
 * Register theme features.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
function manta_setup() {
	$manta_dir = trailingslashit( get_template_directory() );

	// Load theme specific filters.
	require_once( "{$manta_dir}inc/defaults.php" );
	require_once( "{$manta_dir}inc/filters.php" );
	require_once( "{$manta_dir}inc/customizer/data.php" );

	// Make theme available for translation.
	load_theme_textdomain( 'manta' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 880, 540, true );
	add_image_size( 'manta-small-thumb', 640, 392, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 880;

	// Allows the use of valid HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add custom styles for visual editor to resemble the theme style.
	add_editor_style( array( 'assets/admin/css/editor-style.css', manta_font_url() ) );

	/**
	 * Filter nav menus.
	 *
	 * @since 1.0.0
	 */
	$manta_nav_menus = apply_filters( 'manta_nav_menus', array() );

	// Register theme navigation menu locations.
	register_nav_menus( $manta_nav_menus );

	/**
	 * Filter custom background args.
	 *
	 * @since 1.0.0
	 */
	$manta_custom_background_args = apply_filters(
		'manta_custom_background_args', array(
			'default-color' => 'f2f2f2',
			'default-image' => '',
		)
	);
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', $manta_custom_background_args );

	/**
	 * Filter custom logo args.
	 *
	 * @since 1.0.0
	 */
	$manta_custom_logo_args = apply_filters(
		'manta_custom_logo_args', array(
			'flex-width'             => true,
			'flex-height'            => true,
			'width'                  => 56,
			'height'                 => 56,
		)
	);
	// Set up the WordPress core custom logo feature.
	add_theme_support( 'custom-logo', $manta_custom_logo_args );

	/**
	 * Filter custom header args.
	 *
	 * @since 1.0.0
	 */
	$manta_custom_header_args = apply_filters(
		'manta_custom_header_args', array(
			'default-image'          => '',
			'width'                  => 1680,
			'height'                 => 440,
			'flex-width'             => false,
			'flex-height'            => true,
			'header-text'            => false,
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		)
	);
	// Set up the WordPress core custom header feature.
	add_theme_support( 'custom-header', $manta_custom_header_args );

	/**
	 * Filter support for manta theme specific features.
	 *
	 * @since 1.0.0
	 */
	$manta_theme_support = apply_filters( 'manta_theme_support', array( 'schema', 'featured', 'fonticons', 'google-fonts' ) );

	// Load theme specific files.
	require_once( "{$manta_dir}inc/display.php" );
	require_once( "{$manta_dir}inc/customizer/active-callback.php" );
	require_once( "{$manta_dir}inc/customizer/front/front.php" );
	require_once( "{$manta_dir}inc/customizer/front/front-css.php" );
	require_once( "{$manta_dir}inc/customizer/front/front-php.php" );
	require_once( "{$manta_dir}inc/customizer/refresh/selective-refresh.php" );

	// Load theme specific functions files.
	require_once( "{$manta_dir}lib/functions/markup.php" );
	require_once( "{$manta_dir}lib/functions/inline-css.php" );
	require_once( "{$manta_dir}lib/functions/backcompat.php" );
	require_once( "{$manta_dir}lib/functions/template-tags.php" );

	// Load theme specific classes files.
	require_once( "{$manta_dir}lib/classes/plugin-support.php" );
	require_once( "{$manta_dir}lib/classes/layouts.php" );
	require_once( "{$manta_dir}lib/classes/recent-posts.php" );

	// Load theme customizer files.
	require_once( "{$manta_dir}lib/customizer/sanitization.php" );
	require_once( "{$manta_dir}lib/customizer/core-selective-refresh.php" );

	// Load optional files for theme's addon functionality.
	foreach ( $manta_theme_support as $addon ) {
		if( file_exists( "{$manta_dir}addon/{$addon}/{$addon}.php" ) ) {
			add_theme_support( "manta_{$addon}" );
			require_once( "{$manta_dir}addon/{$addon}/{$addon}.php" );
		}
	}

	// Load theme customizer initiation file at last.
	require_once( "{$manta_dir}lib/customizer/init.php" );
}
add_action( 'after_setup_theme' , 'manta_setup', 5 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 *
 * @global int $content_width
 */
function manta_content_width() {

	$content_width = $GLOBALS['content_width'];

	/**
	 * Filter content width of the theme.
	 *
	 * @since 1.0.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'manta_content_width', $content_width );
}
add_action( 'template_redirect' , 'manta_content_width', 0 );

/**
 * Register widget area.
 *
 * @since 1.0.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function manta_widgets_init() {

	/**
	 * Filter register widgets args.
	 *
	 * @since 1.0.0
	 */
	$widgets = apply_filters( 'manta_register_sidebar', array() );

	$defaults = array(
		'description'   => esc_html__( 'Add widgets here.', 'manta' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3' . manta_get_attr( 'widget-title' ) . '><span>',
		'after_title'   => '</span></h3>',
	);

	foreach ( $widgets as $widget ) {
		register_sidebar( wp_parse_args( $widget, $defaults ) );
	}
}
add_action( 'widgets_init', 'manta_widgets_init' );

/**
 * Get Google fonts url to register and enqueue.
 *
 * This function incorporates code from Twenty Fifteen WordPress Theme,
 * Copyright 2014-2016 WordPress.org & Automattic.com Twenty Fifteen is
 * distributed under the terms of the GNU GPL.
 *
 * @since 1.0.0
 *
 * @return string Google fonts URL for the theme.
 */
function manta_font_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'manta' ) ) {
		$fonts[] = 'Noto Sans:400,700,400italic,700italic';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Source Sans Pro, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'manta' ) ) {
		$fonts[] = 'Source Sans Pro:400,700,400italic,700italic';
	}

	$fonts = apply_filters( 'manta_fonts', $fonts );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	/**
	 * Filter google font url.
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'manta_font_url', $fonts_url );
}

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * This function incorporates code from Twenty Seventeen WordPress Theme,
 * Copyright 2016-2017 WordPress.org. Twenty Seventeen is distributed
 * under the terms of the GNU GPL.
 *
 * @since 1.0.0
 */
function manta_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'manta_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function manta_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'manta-style', get_stylesheet_uri() );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'manta-fonts', esc_url( manta_font_url() ), array(), null );

	// Skip link focus fix script.
	wp_enqueue_script( 'manta-skip-link-focus-fix', get_template_directory_uri() . '/assets/front/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	// Theme navigation.
	if ( has_nav_menu( 'primary' ) || has_nav_menu( 'header' ) ) {
		$manta_l10n = apply_filters( 'manta_localize_script_data', array() );
		wp_enqueue_script( 'manta-navigation', get_template_directory_uri() . '/assets/front/js/navigation.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'manta-navigation', 'mantaScreenReaderText', $manta_l10n );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'manta_scripts' );

/**
 * Add preconnect for Google Fonts.
 *
 * This function incorporates code from Twenty Seventeen WordPress Theme,
 * Copyright 2016-2017 WordPress.org. Twenty Seventeen is distributed
 * under the terms of the GNU GPL.
 *
 * @since 1.0.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function manta_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'manta-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints' , 'manta_resource_hints', 10, 2 );
