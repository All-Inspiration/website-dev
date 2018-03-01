<?php
/**
 * SVG icons related functions and filters
 *
 * This file incorporates code from Twenty Seventeen WordPress Theme,
 * Copyright 2017-18 WordPress.org & Automattic.com Twenty Seventeen is
 * distributed under the terms of the GNU GPL.
 *
 * @package Manta
 * @since 1.0.1
 */

/**
 * Add SVG definitions to the footer.
 */
function manta_include_svg_icons() {
	$manta_dir = trailingslashit( get_template_directory() );
	// Define SVG sprite file.
	$svg_icons = "{$manta_dir}assets/front/images/svg-icons-bare.svg";

	// Load extra svg images for social menu.
	if ( has_nav_menu( 'social' ) ) {
		$svg_icons = "{$manta_dir}assets/front/images/svg-icons.svg";
	}

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'manta_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param string $svg SVG HTML markup.
 * @param array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function manta_get_svg( $svg, $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'manta' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'manta' );
	}

	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'fallback'    => false,
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * Manta doesn't use the SVG title or description attributes; non-decorative icons are
	 * described with .screen-reader-text. However, child themes can use the title and description
	 * to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php echo manta_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php echo manta_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img" focusable="false">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * There is a bug in versions prior WordPress 4.7, where inline SVG icons are not visible in Customizer
	 * preview window. External svg link has been used as work around to fix this bug. This should be removed
	 * once we stop supporting those versions. However, this work around won't work on IE 11.
	 *
	 * See https://core.trac.wordpress.org/ticket/35824 .
	 */

	$manta_dir = get_template_directory_uri();
	$svg_icons = '';
	if( is_customize_preview() && version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
		// Define SVG sprite file.
		$svg_icons = "{$manta_dir}/assets/images/svg-icons-bare.svg";

		// Load extra svg images for social menu.
		if ( has_nav_menu( 'social' ) ) {
			$svg_icons = "{$manta_dir}/assets/images/svg-icons.svg";
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="'. $svg_icons .'#icon-' . esc_html( $args['icon'] ) . '" xlink:href="'. $svg_icons .'#icon-' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}
add_filter( 'manta_get_icon', 'manta_get_svg', 10, 2 );

/**
 * Check for social menu in class-wp-nav-menu-widget.
 *
 * Check for social menu in widget and return appropriate social nav menu args.
 *
 * @since 1.0.1
 *
 * @param array    $nav_menu_args {
 *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
 *
 *     @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
 *     @type mixed         $menu        Menu ID, slug, or name.
 * }
 * @param stdClass $nav_menu      Nav menu object for the current menu.
 * @param array    $args          Display arguments for the current widget.
 * @param array    $instance      Array of settings for the current widget.
 * @return array $nav_menu_args.
 */
function manta_social_menu_widget( $nav_menu_args, $nav_menu, $args, $instance ) {

	$menu_arr = get_nav_menu_locations();

	if ( isset( $menu_arr['social'] ) && $menu_arr['social'] === $instance['nav_menu'] ) {

		$nav_menu_args = array(
			'depth'          => 1,
			'theme_location' => 'social',
			'menu_id'        => 'social-nav',
			'menu_class'     => 'social-icons-menu',
			'container'      => false,
			'link_before'    => '<span class="screen-reader-text" itemprop="name">',
			'link_after'     => '</span>',
			'items_wrap'     => '<nav id="social-menu" role="navigation" aria-label="Social Menu"' . manta_get_attr( 'social-menu' ) . '><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
		);

	}

	return $nav_menu_args;

}
add_filter( 'widget_nav_menu_args', 'manta_social_menu_widget', 10, 4 );

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function manta_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = manta_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . manta_get_svg( '', array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'manta_nav_menu_social_icons', 10, 4 );

/**
 * Add dropdown icon if menu item has children.
 *
 * @param  string $title The menu item's title.
 * @param  object $item  The current menu item.
 * @param  array  $args  An array of wp_nav_menu() arguments.
 * @param  int    $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function manta_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location || 'header' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title = $title . manta_get_svg( '', array( 'icon' => 'angle-down' ) );
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'manta_dropdown_icon_to_menu_link', 10, 4 );

/**
 * Font SVG icon specific inline css.
 *
 * @since 1.0
 *
 * @param str $output Css string.
 * @return string $output css string.
 */
function manta_icons_css( $output ) {
	$output .= '
		.icon {
			position: relative;
			top: -0.0625em;
			display: inline-block;
			width: 1em;
			height: 1em;
			vertical-align: middle;
			stroke-width: 0;
			stroke: currentColor;
			fill: currentColor;
		}

		.menu-toggle .icon {
			top: -0.0825em;
			margin-right: 5px;
		}

		.menu-toggle .icon-close {
			display: none;
		}

		.toggled-on .menu-toggle .icon-close {
			display: inline-block;
		}

		.toggled-on .menu-toggle .icon-bars {
			display: none;
		}

		.sub-menu-toggle .icon {
			width: 24px;
			height: 24px;
			-webkit-transition: transform 0.25s ease-in-out;
				-ms-transition: transform 0.25s ease-in-out;
					transition: transform 0.25s ease-in-out;
			-webkit-transform: rotate( 0 );
				-ms-transform: rotate( 0 );
					transform: rotate( 0 );
		}

		.nav-menu .menu-item-has-children > a .icon,
		.nav-menu .page_item_has_children > a .icon {
			display: none;
		}

		.sub-menu-toggle.toggled-on .icon {
			-webkit-transform: rotate( 180deg );
				-ms-transform: rotate( 180deg );
					transform: rotate( 180deg );
		}

		.post:not(.sticky) .icon-thumb-tack {
			display: none;
		}

		.sticky .icon-thumb-tack {
			position: absolute;
			top: 1em;
			right: 1em;
			display: block;
			width: 20px;
			height: 20px;
		}

		@media only screen and (min-width: 1024px) {
			.nav-menu .menu-item-has-children > a .icon,
			.nav-menu .page_item_has_children > a .icon {
				display: inline;
			}

			.nav-menu .sub-menu .icon {
				position: absolute;
				top: 50%;
				right: 1em;
				left: auto;
				margin-top: -9px;
				-webkit-transform: rotate(-90deg);
						transform: rotate(-90deg);
			}

			.left #header-nav .sub-menu .icon,
			.right #primary-menu .sub-menu .icon {
				-webkit-transform: rotate(90deg);
						transform: rotate(90deg);
			}
		}

		.svg-fallback {
			display: none;
		}

		.no-svg .svg-fallback {
			display: inline-block;
		}

		.no-svg .sub-menu-toggle {
			right: 0;
			width: 2em;
			padding: 0.5em 0 0;
			text-align: center;
		}

		.no-svg .sub-menu-toggle .svg-fallback.icon-angle-down {
			font-size: 20px;
			font-weight: 400;
			line-height: 1;
			-webkit-transform: rotate(180deg); /* Chrome, Safari, Opera */
			        transform: rotate(180deg);
		}

		.no-svg .sub-menu-toggle.toggled-on .svg-fallback.icon-angle-down {
			-webkit-transform: rotate(0); /* Chrome, Safari, Opera */
			        transform: rotate(0);
		}

		.no-svg .sub-menu-toggle .svg-fallback.icon-angle-down:before {
			content: \'\005E\';
		}
	';

	return $output;
}
add_filter( 'manta_get_inline_style', 'manta_icons_css' );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function manta_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope-o',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Manta social links icons.
	 *
	 * @since 0.2.5
	 *
	 * @param array $social_links_icons
	 */
	return apply_filters( 'manta_social_links_icons', $social_links_icons );
}
