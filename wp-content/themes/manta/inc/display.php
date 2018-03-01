<?php
/**
 * Display site contents
 *
 * Call appropriate WordPress built-in function or include theme template file
 * to display various site contents.
 *
 * @package Manta
 * @since 1.0.0
 */

/**
 * Conditionally call display function or include template.
 *
 * @since 1.0.0
 */
class Manta_Display {

	/**
	 * Constructor method intentionally left blank.
	 */
	private function __construct() {}

	/**
	 * Display functions.
	 *
	 * @since 1.0.0
	 */
	public static function initiate() {

		add_action( 'wp_head'                         , array( __CLASS__, 'head' ), 0 );

		// Items to be displayed on site header.
		add_action( 'manta_hook_for_site_header'      , array( __CLASS__, 'skip_link' ), 0 );
		add_action( 'manta_hook_for_header_items'     , array( __CLASS__, 'site_branding' ) );
		add_action( 'manta_hook_for_header_items'     , array( __CLASS__, 'header_extra' ) );
		add_action( 'manta_hook_for_site_branding'    , array( __CLASS__, 'header_logo' ) );
		add_action( 'manta_hook_for_site_branding'    , array( __CLASS__, 'header_text' ) );
		add_action( 'manta_hook_for_site_header'      , array( __CLASS__, 'header_items' ) );
		add_action( 'manta_hook_for_site_header'      , array( __CLASS__, 'custom_header_above_nav' ) );
		add_action( 'manta_hook_for_site_header'      , array( __CLASS__, 'menu_primary' ) );
		add_action( 'manta_hook_for_site_header'      , array( __CLASS__, 'custom_header_below_nav' ) );

		// Items to be displayed on site content.
		add_action( 'manta_hook_for_main_loop'        , array( __CLASS__, 'page_header' ) );
		add_action( 'manta_hook_for_main_loop'        , array( __CLASS__, 'loop' ), 15 );
		add_action( 'manta_hook_for_entry_header'     , array( __CLASS__, 'entry_title' ) );
		add_action( 'manta_hook_for_entry_header'     , array( __CLASS__, 'entry_meta_wrapper' ) );
		add_action( 'manta_hook_for_entry_meta'       , array( __CLASS__, 'entry_meta' ) );
		add_action( 'manta_hook_for_entry_content'    , array( __CLASS__, 'entry_attachment' ) );
		add_action( 'manta_hook_for_entry_content'    , array( __CLASS__, 'entry_content' ) );
		add_action( 'manta_hook_bottom_of_entry'      , array( __CLASS__, 'entry_footer_wrapper' ) );
		add_action( 'manta_hook_for_entry_footer'     , array( __CLASS__, 'entry_footer' ) );

		add_action( 'manta_hook_after_main_content'   , array( __CLASS__, 'post_pagination' ) );
		add_action( 'manta_hook_on_top_of_entry'      , array( __CLASS__, 'sticky_icon' ) );
		add_action( 'manta_hook_on_top_of_entry'      , array( __CLASS__, 'thumbnails' ) );
		add_action( 'manta_hook_on_top_of_entry'      , array( __CLASS__, 'postwrapper_open' ) );
		add_action( 'manta_hook_on_top_of_entry'      , array( __CLASS__, 'thumb_above_title' ) );
		add_action( 'manta_hook_before_entry_content' , array( __CLASS__, 'thumb_below_title' ) );
		add_action( 'manta_hook_bottom_of_entry'      , array( __CLASS__, 'postwrapper_close' ) );
		add_action( 'manta_hook_after_entry'          , array( __CLASS__, 'post_author' ) );
		add_action( 'manta_hook_after_entry'          , array( __CLASS__, 'post_navigation' ) );
		add_action( 'get_sidebar'                     , array( __CLASS__, 'sidebar2' ) );
		add_action( 'get_sidebar'                     , array( __CLASS__, 'sidebar1' ) );

		// Items to be displayed in post comments section.
		add_action( 'manta_hook_on_top_of_comments'   , array( __CLASS__, 'comment_title' ) );
		add_action( 'manta_hook_on_top_of_comments'   , array( __CLASS__, 'comment_navigation' ) );
		add_action( 'manta_hook_bottom_of_comments'   , array( __CLASS__, 'comment_navigation' ) );

		// Items to be displayed on site footer.
		add_action( 'manta_hook_before_footer'        , array( __CLASS__, 'footer_widgets' ) );
		add_action( 'manta_hook_for_footer_items'     , array( __CLASS__, 'menu_footer' ) );
		add_action( 'manta_hook_for_footer_items'     , array( __CLASS__, 'footer_items' ) );

		if ( is_active_sidebar( 'header' ) ) {
			add_action( 'manta_hook_for_header_extra' , array( __CLASS__, 'header_widget' ) );
		}

		if ( has_nav_menu( 'header' ) ) {
			add_action( 'manta_hook_for_header_extra' , array( __CLASS__, 'menu_header' ) );
		}
	}

	/**
	 * Include head contents display template.
	 *
	 * @since 1.0.0
	 */
	public static function head() {
		get_template_part( 'lib/template-parts/head/head' );
	}

	/**
	 * Include skip link display template.
	 *
	 * @since 1.0.0
	 */
	public static function skip_link() {
		get_template_part( 'lib/template-parts/header/skiplink' );
	}

	/**
	 * Include site branding display template.
	 *
	 * @since 1.0.0
	 */
	public static function site_branding() {
		manta_markup( 'site-branding' );
	}

	/**
	 * Include custom logo display function.
	 *
	 * @since 1.0.0
	 */
	public static function header_logo() {
		the_custom_logo();
	}

	/**
	 * Include header text display template.
	 *
	 * @since 1.0.0
	 */
	public static function header_text() {
		get_template_part( 'lib/template-parts/header/text' );
	}

	/**
	 * Include header items display template.
	 *
	 * @since 1.0.0
	 */
	public static function header_items() {
		if ( has_action( 'manta_hook_for_header_items' ) ) {
			manta_markup( 'header-items' );
		}
	}

	/**
	 * Include header extra items display template.
	 *
	 * @since 1.0.0
	 */
	public static function header_extra() {
		if ( has_action( 'manta_hook_for_header_extra' ) ) {
			manta_markup( 'header-extra' );
		}
	}

	/**
	 * Include header widget display template.
	 *
	 * @since 1.0.0
	 */
	public static function header_widget() {
		if ( is_active_sidebar( 'header' ) ) {
			manta_markup( 'header-widget', 'dynamic_sidebar', 'header' );
		}
	}

	/**
	 * Conditionally include header image display template above primary navigation menu.
	 *
	 * @since 1.0.0
	 */
	public static function custom_header_above_nav() {
		if ( 'above-main-nav' !== get_theme_mod( 'manta_custom_header_position', manta_get_theme_defaults( 'manta_custom_header_position' ) ) ) {
			return;
		}

		if ( get_header_image() && is_front_page() ) {
			manta_custom_header_markup();
		}
	}

	/**
	 * Conditionally include header image display template below primary navigation menu.
	 *
	 * @since 1.0.0
	 */
	public static function custom_header_below_nav() {
		if ( 'below-main-nav' !== get_theme_mod( 'manta_custom_header_position', manta_get_theme_defaults( 'manta_custom_header_position' ) ) ) {
			return;
		}

		if ( get_header_image() && is_front_page() ) {
			manta_custom_header_markup();
		}
	}

	/**
	 * Include header menu display template.
	 *
	 * @since 1.0.0
	 */
	public static function menu_header() {
		manta_menu(
			'header-menu',
			'header-nav',
			esc_html__( 'Header Menu', 'manta' ),
			'header',
			true,
			array(
				'container' => false,
			)
		);
	}

	/**
	 * Conditionally include primary menu display template.
	 *
	 * @since 1.0.0
	 */
	public static function menu_primary() {
		if ( has_nav_menu( 'primary' ) ) {
			manta_menu(
				'main-navigation',
				'primary-menu',
				esc_html__( 'Main Navigation', 'manta' ),
				'primary',
				true,
				array(
					'container_class' => 'wrap',
				)
			);
		}
	}

	/**
	 * Conditionally include footer menu display template.
	 *
	 * @since 1.0.0
	 */
	public static function menu_footer() {
		if ( has_nav_menu( 'footer' ) ) {
			manta_menu(
				'footer-menu',
				'footer-nav',
				esc_html__( 'Footer Menu', 'manta' ),
				'footer',
				false,
				array(
					'container_class' => 'wrap',
					'depth'           => 1,
				)
			);
		}
	}

	/**
	 * Display sticky icon for sticky post.
	 *
	 * @since 1.0.0
	 */
	public static function sticky_icon() {
		if ( is_sticky() && is_home() ) {
			manta_icon( array( 'icon' => 'thumb-tack' ) );
		}
	}

	/**
	 * Conditionally display hero thumbnail images.
	 *
	 * @since 1.1
	 */
	public static function thumbnails() {
		if ( 'large_above' === get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) ) {
			return;
		}

		if ( 'large_below' === get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) ) {
			return;
		}

		self::post_thumbnails();
	}

	/**
	 * Conditionally display thumbnails above post title.
	 *
	 * @since 1.1
	 */
	public static function thumb_above_title() {
		if ( 'large_above' !== get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) ) {
			return;
		}

		self::post_thumbnails();
	}

	/**
	 * Conditionally display thumbnails below post title.
	 *
	 * @since 1.1
	 */
	public static function thumb_below_title() {
		if ( 'large_below' !== get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) ) {
			return;
		}

		self::post_thumbnails();
	}

	/**
	 * Conditionally include post thumbnail display template.
	 *
	 * @since  1.0.0
	 */
	public static function post_thumbnails() {
		// Return if thumbnail is not available or not to be displayed at all.
		if ( ( 'none' === get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) )
			|| ! has_post_thumbnail()
			|| post_password_required() ) {
			return;
		}

		// Conditions where full post content is being displayed.
		if ( ( ( is_singular() && ! is_page_template( 'page-template/page-portfolio.php' ) )
			|| 'excerpt' !== get_theme_mod( 'manta_excerpt_option', manta_get_theme_defaults( 'manta_excerpt_option' ) )
			|| has_post_format( array( 'aside', 'quote', 'status', 'video', 'audio', 'gallery', 'image' ) ) ) ) {

			// Check whether thumbnail is to be displayed for full post content.
			if ( ( '' !== get_theme_mod( 'manta_thumbnails_on_single', manta_get_theme_defaults( 'manta_thumbnails_on_single' ) ) ) ) {

				// Include thumbnail display template for full post content.
				get_template_part( 'lib/template-parts/entry/thumbnail', 'single' );
			}
		} else { // Condition where post excerpt is being displayed.

			// Use thumbnail image as background image for center cropping (only if small thumbnail option selected).
			$manta_thumb_style = '';
			$manta_thumb_size  = 'post-thumbnail';
			if ( 'small' === get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) )
				|| 'small_right' === get_theme_mod( 'manta_thumbnails_display', manta_get_theme_defaults( 'manta_thumbnails_display' ) ) ) {
				$manta_thumbnail_url = get_the_post_thumbnail_url();
				if ( $manta_thumbnail_url ) {
					$manta_thumb_style = sprintf( ' style="background-image: url(%s)"', esc_url( $manta_thumbnail_url ) );
					$manta_thumb_size  = 'manta-small-thumb';
				}
				/*
				 * Even though post thumbnal link is a focusable element and screen-reader will
				 * announce as 'blank' if we have 'area-hidden= "true"' in it. But, here
				 * area-hidden is use as a non-verbose option to minimize repetition of data.
				 * https://core.trac.wordpress.org/ticket/30076#comment:13
				 */
				?>
				<a href="<?php the_permalink(); ?>" <?php manta_attr( 'post-thumbnail' ); ?> aria-hidden="true" <?php echo $manta_thumb_style ?>>

					<?php
					the_post_thumbnail( $manta_thumb_size, array(
							'alt'   => the_title_attribute( 'echo=0' ),
							'class' => 'thumbnails aligncenter',
					) );
					?>

				</a>
				<?php
			} else {
				// Include thumbnail display template for post excerpts.
				get_template_part( 'lib/template-parts/entry/thumbnail' );
			}
		}
	}

	/**
	 * Post Content Wrapper open.
	 *
	 * @since  1.0.0
	 */
	public static function postwrapper_open() {
		echo '<div class="post-wrapper">';
	}

	/**
	 * Post Content Wrapper close.
	 *
	 * @since  1.0.0
	 */
	public static function postwrapper_close() {
		echo '</div>';
	}

	/**
	 * Include page header display template.
	 *
	 * @since  1.0.0
	 */
	public static function page_header() {
		get_template_part( 'lib/template-parts/content/page-header' );
	}

	/**
	 * Include main loop display template.
	 *
	 * @since  1.0.0
	 */
	public static function loop() {
		get_template_part( 'lib/template-parts/content/loop' );
	}

	/**
	 * Conditionally include header post meta wrapper.
	 *
	 * @since  1.0.0
	 */
	public static function entry_meta_wrapper() {
		if ( 'post' === get_post_type() ) {
			manta_markup( 'entry-meta' );
		}
	}

	/**
	 * Conditionally include header post meta data.
	 *
	 * @since  1.0.0
	 */
	public static function entry_meta() {
		if ( 1 === get_theme_mod( 'manta_show_date', manta_get_theme_defaults( 'manta_show_date' ) ) ) {
			get_template_part( 'lib/template-parts/meta/date' );
		}

		if ( 1 === get_theme_mod( 'manta_show_author', manta_get_theme_defaults( 'manta_show_author' ) ) ) {
			get_template_part( 'lib/template-parts/meta/author' );
		}

		if ( 1 === get_theme_mod( 'manta_show_comment_link', manta_get_theme_defaults( 'manta_show_comment_link' ) ) ) {
			get_template_part( 'lib/template-parts/meta/comment-link' );
		}

		get_template_part( 'lib/template-parts/meta/edit-link' );
	}

	/**
	 * Include post entry title display template.
	 *
	 * @since  1.0.0
	 */
	public static function entry_title() {
		get_template_part( 'lib/template-parts/entry/title' );
	}

	/**
	 * Include attachment image display template.
	 *
	 * @since  1.0.0
	 */
	public static function entry_attachment() {
		if ( is_attachment() && wp_attachment_is_image() ) {
			get_template_part( 'lib/template-parts/entry/attachment' );
		}
	}

	/**
	 * Include post content display template.
	 *
	 * @since  1.0.0
	 */
	public static function entry_content() {
		/*
		 * Display excerpt if : It is home or archive page and show full content
		 * option is not selected from customizer options and post format is not
		 * aside, quote or status. Else display full content.
		 */
		if ( ( is_home() || is_archive() || is_search() ) && 'content' !== get_theme_mod( 'manta_excerpt_option', manta_get_theme_defaults( 'manta_excerpt_option' ) )
			&& ! has_post_format( array( 'aside', 'quote', 'status', 'video', 'audio', 'gallery', 'image' ) )
			&& ! post_password_required() ) {
			the_excerpt();
		} else {
			get_template_part( 'lib/template-parts/entry/content' );
		}
	}

	/**
	 * Conditionally include footer post meta wrapper.
	 *
	 * @since  1.0.0
	 */
	public static function entry_footer_wrapper() {
		if ( is_singular() ) {
			manta_markup( 'entry-footer' );
		}
	}

	/**
	 * Conditionally include footer post meta data.
	 *
	 * @since  1.0.0
	 */
	public static function entry_footer() {
		if ( is_singular( 'post' ) ) {
			if ( 1 === get_theme_mod( 'manta_show_cat', manta_get_theme_defaults( 'manta_show_cat' ) ) ) {
				get_template_part( 'lib/template-parts/meta/categories' );
			}

			if ( 1 === get_theme_mod( 'manta_show_tags', manta_get_theme_defaults( 'manta_show_tags' ) ) ) {
				get_template_part( 'lib/template-parts/meta/tags' );
			}
		} else {
			get_template_part( 'lib/template-parts/meta/edit-link' );
			get_template_part( 'lib/template-parts/meta/attachment' );
		}
	}

	/**
	 * Conditionally include post author display template.
	 *
	 * @since  1.0.0
	 */
	public static function post_author() {
		if ( 1 !== get_theme_mod( 'manta_show_author_box', manta_get_theme_defaults( 'manta_show_author_box' ) ) ) {
			return;
		} else if ( is_single() && '' !== get_the_author_meta( 'description' ) ) {
			get_template_part( 'lib/template-parts/entry/author' );
		}
	}

	/**
	 * Conditionally include post pagination display template.
	 *
	 * Display posts pagination on home, archive and search pages.
	 *
	 * @since  1.0.0
	 */
	public static function post_pagination() {
		if ( ! is_singular() ) {
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous', 'manta' ),
				'next_text'          => esc_html__( 'Next', 'manta' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'manta' ) . ' </span>',
			) );
		}
	}

	/**
	 * Conditionally include post navigation display template.
	 *
	 * Display next and previous post navigation for single posts.
	 *
	 * @since  1.0.0
	 */
	public static function post_navigation() {
		if ( is_singular( 'post' ) && ( 1 === get_theme_mod( 'manta_show_prevnext', manta_get_theme_defaults( 'manta_show_prevnext' ) ) ) ) {
			the_post_navigation( array(
				'next_text' => '<span' . manta_get_attr( 'meta-nav' ) . ' aria-hidden="true">' . esc_html__( 'Next', 'manta' ) . '</span>
					<span class="screen-reader-text">' . esc_html__( 'Next post:', 'manta' ) . '</span>
					<span' . manta_get_attr( 'post-title' ) . '>%title</span>',
				'prev_text' => '<span' . manta_get_attr( 'meta-nav' ) . ' aria-hidden="true">' . esc_html__( 'Previous', 'manta' ) . '</span>
					<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'manta' ) . '</span>
					<span' . manta_get_attr( 'post-title' ) . '>%title</span>',
			) );
		}
	}

	/**
	 * Conditionally include primary sidebar widgets display template.
	 *
	 * @since  1.0.0
	 */
	public static function sidebar1() {
		$layout_classes = Manta_Layouts::get_instance()->manta_layout_css_classes( array( 'class' => 'content-sidebar-wrap' ) );
		$no_col  = array( 'only-content', 'only-content-full' );
		$classes = explode( ' ', $layout_classes['class'] );

		// Conditionally display primary sidebar.
		if ( count( array_intersect( $classes, $no_col ) ) === 0 ) {
			manta_widgets(
				'secondary',
				'primary-sidebar',
				esc_html( 'Primary Sidebar', 'manta' ),
				array( 'sidebar-1' )
			);
		}
	}

	/**
	 * Conditionally include secondary sidebar widgets display template.
	 *
	 * @since  1.0.0
	 */
	public static function sidebar2() {
		$layout_classes = Manta_Layouts::get_instance()->manta_layout_css_classes( array( 'class' => 'content-sidebar-wrap' ) );
		$three_col = array( 'content-sidebar-sidebar', 'sidebar-sidebar-content', 'sidebar-content-sidebar' );
		$classes = explode( ' ', $layout_classes['class'] );

		// Return if secondary sidebar is not to be displayed.
		if ( count( array_intersect( $classes, $three_col ) ) === 0 ) {
			return;
		}

		// Display secondary sidebar.
		manta_widgets(
			'tertiary',
			'secondary-sidebar',
			esc_html( 'Secondary Sidebar', 'manta' ),
			array( 'sidebar-2' )
		);
	}

	/**
	 * Include comment title display template.
	 *
	 * @since  1.0.0
	 */
	public static function comment_title() {
		get_template_part( 'lib/template-parts/comment/title' );
	}

	/**
	 * Include template to display pingback, trackback or comment.
	 *
	 * @since  1.0.0
	 *
	 * @param object $comment comment object.
	 */
	public static function comments( $comment ) {
		$comment_type = get_comment_type( $comment->comment_ID );
		if ( 'pingback' === $comment_type || 'trackback' === $comment_type ) {
			get_template_part( 'lib/template-parts/comment/ping' );
		} else {
			get_template_part( 'lib/template-parts/comment/comment' );
		}
	}

	/**
	 * Conditionally include comments navigation display template.
	 *
	 * @since  1.0.0
	 */
	public static function comment_navigation() {
		the_comments_navigation();
	}

	/**
	 * Conditionally include footer widgets display template.
	 *
	 * @since  1.0.0
	 */
	public static function footer_widgets() {
		if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' )
			|| is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) {
				manta_widgets(
					'footer-widgets',
					'footer-widgets',
					esc_html( 'Footer Widgets', 'manta' ),
					array( 'footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5' ),
					'wrap'
				);
		}
	}

	/**
	 * Include template to display footer widgets
	 *
	 * @since  1.0.0
	 */
	public static function footer_items() {
		get_template_part( 'lib/template-parts/footer/items' );
	}
}

Manta_Display::initiate();
