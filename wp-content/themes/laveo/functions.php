<?php
/**
 * laveo functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package laveo
 */

define( 'LAVEO_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'UPLOADS_URL', trailingslashit( WP_CONTENT_URL ) . 'uploads/' );
if ( !function_exists( 'remove_wp_open_sans' ) ) :
	function remove_wp_open_sans() {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
	}

	add_action( 'wp_enqueue_scripts', 'remove_wp_open_sans' );
endif;

if ( !function_exists( 'laveo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function laveo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on laveo, use a find and replace
		 * to change 'laveo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'laveo', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'laveo' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'laveo_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-header', apply_filters( 'laveo_ustom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '000000'
		) ) );
	}
endif; // laveo_setup
add_action( 'after_setup_theme', 'laveo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function laveo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'laveo_content_width', 640 );
}

add_action( 'after_setup_theme', 'laveo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function laveo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'laveo' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Banner Widget Area', 'laveo' ),
		'id'            => 'top_banner_widget',
		'description'   => esc_html__( 'Top Banner widget area', 'laveo' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s top_banner_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'laveo' ),
		'id'            => 'footer_widget',
		'description'   => esc_html__( 'The footer widget area', 'laveo' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s footer-widget">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}

add_action( 'widgets_init', 'laveo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function laveo_scripts() {
	// Font options
	$fonts    = array(
		get_theme_mod( 'font_family_body', laveo_customizer_get_default( 'font_family_body' ) ),
		get_theme_mod( 'font_family_heading', laveo_customizer_get_default( 'font_family_heading' ) )
	);
	$font_uri = laveo_customizer_get_google_font_uri( $fonts );
	// Load Google Fonts
	wp_enqueue_style( 'google_fonts', $font_uri, array(), null, 'screen' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );
	if ( is_file( UPLOADS_FOLDER . 'laveo_custom.css' ) ) {
		wp_enqueue_style( 'custom-css', UPLOADS_URL . 'laveo_custom.css' );
	}
	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array( 'jquery' ), '20130115', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'opacityrollover', get_template_directory_uri() . '/js/jquery.opacityrollover.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'galleriffic', get_template_directory_uri() . '/js/jquery.galleriffic.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.min.js', array( 'jquery' ), '', true );
}

add_action( 'wp_enqueue_scripts', 'laveo_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require trailingslashit( get_template_directory() ) . '/inc/admin/customizer/customizer.php';
require trailingslashit( get_template_directory() ) . '/inc/admin/customizer/register-sections.php';
require get_template_directory() . '/inc/admin/sassphp/sass2css.php';
/*
 * require Plugin
 */
require get_template_directory() . '/inc/admin/required-plugins/plugins-require.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom Functions
 */
require get_template_directory() . '/inc/custom_functions.php';

/**
 * Register widgets
 */
require get_template_directory() . '/inc/aq_resizer.php';
/**
 * Register widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';