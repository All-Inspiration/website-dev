<?php
/**
 * Create front end css based on Theme Customizer options.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Manta
 * @since 1.1
 */

/**
 * Create front end css based on Theme Customizer options.
 *
 * @since 1.1
 */
class Manta_Customizer_Front_Css extends Manta_Customizer_Front_Base {

	/**
	 * Hold theme customized CSS.
	 *
	 * @since  1.1
	 * @access public
	 * @var    string
	 */
	public $css;

	/**
	 * Returns theme customized CSS.
	 *
	 * @since 1.1
	 *
	 * @param  string $output Manta inline css.
	 * @return string Manta modified inline css.
	 */
	public function customized_css( $output ) {

		$this->css = $output;
		$this->title_tagline();
		$this->color_css();
		$this->typography_css();
		$this->dimension_css();

		return $this->css;
	}

	/**
	 * Hide/Display title tagline customized CSS.
	 *
	 * @since 1.1
	 */
	public function title_tagline() {

		if ( ! $this->get_mod( 'manta_display_site_title', 'none' ) ) {
			$this->css .= sprintf( '.site-title{position:absolute;clip: rect(1px, 1px, 1px, 1px)}' );
		}

		if ( ! $this->get_mod( 'manta_display_site_desc', 'none' ) ) {
			$this->css .= sprintf( '.site-description{position:absolute;clip: rect(1px, 1px, 1px, 1px)}' );
		}
	}

	/**
	 * Colors customized CSS.
	 *
	 * @since 1.1
	 */
	public function color_css() {
		$colors = array(
			'manta_site_title_color'       => '.site-title a{color:%s}',
			'manta_link_color'             => 'a{color: %1$s}',
			'manta_post_title_color'       => '#main .entry-title,.entry-title a{color:%s}',
			'manta_post_title_hover_color' => '.entry-title a:hover,.entry-title a:focus{color:%s}',
			'manta_content_text_color'     => 'body,.nav-menu a,.nav-links a{color:%s}',
			'manta_link_hover_color'       => 'a:hover,a:focus,.nav-menu a:hover,.nav-menu a:focus,.nav-links a:hover,.nav-links a:focus,.menu-toggle:hover,.menu-toggle:focus,.sub-menu-toggle:hover,.sub-menu-toggle:focus{color: %1$s}input:focus,textarea:focus{border-color: %1$s}input[type="button"]:hover,input[type="button"]:focus,input[type="reset"]:hover,input[type="reset"]:focus,input[type="submit"]:hover,input[type="submit"]:focus{background-color: %1$s}',
		);

		foreach ( $colors as $id => $css ) {
			$color = $this->get_mod( $id, 'color' );
			if ( $color && manta_get_theme_defaults( $id ) !== $color ) {
				$this->css .= sprintf( $css, $color );
			}
		}
	}

	/**
	 * Typography customized CSS.
	 *
	 * @since 1.1
	 */
	public function typography_css() {
		$typography = array(
			'manta_body_font_family'    => 'body{font-family:%s}',
			'manta_heading_font_family' => 'h1,h2,h3,h4,h5,h6,h1.site-title,p.site-title{font-family:%s}',
		);

		foreach ( $typography as $id => $css ) {
			$ff = $this->get_mod( $id );
			if ( $ff && manta_get_theme_defaults( $id ) !== $ff ) {
				if ( $this->is_google_sans_font( $ff ) ) {
					$ff = $ff . ',sans-serif';
				} elseif ( $this->is_google_serif_font( $ff ) ) {
					$ff = $ff . ',serif';
				} elseif ( $this->is_web_safe_font( $ff ) ) {
					$ff = Manta_Customizer_Data::get_web_safe_fonts_stack( $ff );
				}

				$this->css .= sprintf( $css, $ff );
			}
		}

		$small_font  = $this->get_mod( 'manta_small_base_font_size', 'integer' );
		$large_font  = $this->get_mod( 'manta_large_base_font_size', 'integer' );
		$line_height = $this->get_mod( 'manta_base_line_height', 'float' );

		if ( $small_font && 16 !== $small_font ) {
			$this->css .= sprintf( '@media only screen and (max-width: 640px){html{font-size: %spx}}', $small_font );
		}

		if ( $large_font && 18 !== $large_font ) {
			$this->css .= sprintf( '@media only screen and (min-width: 640px){html{font-size: %spx}}', $large_font );
		}

		if ( $line_height && 1.75 !== $line_height ) {
			$this->css .= sprintf( 'body{line-height: %s}', $line_height );
		}
	}

	/**
	 * Site dimension customized CSS.
	 *
	 * @since 1.0.0
	 */
	public function dimension_css() {

		$min_width       = 1024;
		$site_width      = $this->get_mod( 'manta_overall_site_width', 'integer' );
		$secondary_width = $this->get_mod( 'manta_primary_sidebar_width', 'integer' );
		$tertiary_width  = $this->get_mod( 'manta_secondary_sidebar_width', 'integer' );

		if ( is_active_sidebar( 'sidebar-1' ) ) {
			if ( $secondary_width ) {
				$this->css .= sprintf( '@media only screen and (min-width: %1$spx){#secondary{width: %2$spx}}', $min_width, $secondary_width );
			}
		}

		if ( $tertiary_width ) {
			if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
				$this->css .= sprintf( '@media only screen and (min-width: %1$spx){#tertiary{width: %2$spx}}', $min_width, $tertiary_width );
			}
		}

		if ( $site_width ) {

			// Applicable screen size for full width layout to keep at least 20px space on either side.
			$screen_width = $site_width + 40;

			// Maintain 40px padding on both sides for boxed layout.
			$inner_width = $site_width - 80;

			// Calculate height of three featured posts to match with its width (refer featured posts css).
			$three_featured_height = ( $site_width - 81 ) * 0.33334;

			// Calculate height of three featured posts to match with its width (refer featured posts css).
			$three_featured_boxed = ( $inner_width - 81 ) * 0.33334;

			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){#main-navigation .wrap,#header-nav,.header-items,#colophon > .wrap,.site-content,.footer-widgets .wrap,.widget-wrapper{max-width: %2$spx}}', $screen_width, $site_width );
			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){.boxed .site-header,.boxed .site-footer,.boxed .footer-widgets,.boxed .site-content{max-width: %1$spx}.boxed .wrap,.boxed #main-navigation .wrap,.boxed .header-items,.boxed .footer-widget > .wrap,.boxed #colophon > .wrap{max-width: %2$spx}}', $site_width, $inner_width );
			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){.three-featured .featured-posts{height:%2$spx;max-height:%2$spx}}', $screen_width, $three_featured_height );
			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){.boxed .three-featured .featured-posts{height:%2$spx;max-height:%2$spx}}', $site_width, $three_featured_boxed );
			$this->css .= sprintf( '@media only screen and (min-width: 1680px){.wp-custom-header{max-width: %1$spx}}', $site_width );
		}
	}
}
