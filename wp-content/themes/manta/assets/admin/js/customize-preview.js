/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function ( $ ) {
	var displayToggler = function ( value, selector, trueValue ) {
		if ( trueValue == value ) {
			$( selector ).css( {
				'position': 'absolute',
				'clip': 'rect(1px, 1px, 1px, 1px)'
			} );
		}
		else {
			$( selector ).css( {
				'position': 'static',
				'clip': 'auto'
			} );
		}
	}
	var addInlineCss = function ( id, css ) {
		if ( $( 'style#' + id ).length ) {
			$( 'style#' + id ).html( css );
		}
		else {
			$( 'head' ).append( '<style id="' + id + '">' + css + '</style>' );
			setTimeout( function () {
				$( 'style#' + id ).not( ':last' ).remove();
			}, 100 );
		}
	}
	var enqueGoogleFonts = function ( id, fontVal ) {
		var gfontUrl = [ '//fonts.googleapis.com/css?family=' ];
		var fonts = fontVal.split( ' ' ).join( '+' );
		gfontUrl.push( fonts );
		if ( 0 === $( 'link#' + id ).length ) {
			$gfontlink = $( '<link>', {
				id: id,
				href: gfontUrl.join( '' ),
				rel: 'stylesheet',
				type: 'text/css'
			} );
			$( 'link:last' ).after( $gfontlink );
		}
		else {
			$( 'link#' + id ).attr( 'href', gfontUrl.join( '' ) );
		}
	}
	wp.customize( 'manta_display_site_title', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-title', '' );
		} );
	} );
	wp.customize( 'manta_display_site_desc', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-description', '' );
		} );
	} );
	// Excerpt teaser text.
	wp.customize( 'manta_excerpt_teaser', function ( value ) {
		value.bind( function ( to ) {
			$( '.more-link' ).text( to );
		} );
	} );
	// Display footer credit information.
	wp.customize( 'manta_site_credit', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-credit', 1 );
		} );
	} );
	// Mobile/ tablet base font size.
	wp.customize( 'manta_small_base_font_size', function ( value ) {
		value.bind( function ( to ) {
			var css = '@media only screen and (max-width: 640px){html{font-size:' + to + 'px }}';
			addInlineCss( 'manta_small_base_font_size', css );
		} );
	} );
	// Desktop base font size.
	wp.customize( 'manta_large_base_font_size', function ( value ) {
		value.bind( function ( to ) {
			var css = '@media only screen and (min-width: 640px){html{font-size:' + to + 'px }}';
			addInlineCss( 'manta_large_base_font_size', css );
		} );
	} );
	// Line height.
	wp.customize( 'manta_base_line_height', function ( value ) {
		value.bind( function ( to ) {
			if ( to ) {
				$( document.body ).css( {
					'line-height': to
				} )
			}
		} );
	} );
	// Boxed Layout.
	wp.customize( 'manta_site_layout', function ( value ) {
		value.bind( function ( to ) {
			$( 'body' ).removeClass( 'boxed full-width' );
			if ( 'boxed' === to ) {
				$( 'body' ).addClass( 'boxed' );
			}
			else {
				$( 'body' ).addClass( 'full-width' );
			}
		} );
	} );
	// Header items alignment.
	wp.customize( 'manta_header_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '.header-items' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '.header-items' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '.header-items' ).addClass( 'aligned right' );
			}
		} );
	} );
	// Main menu alignment.
	wp.customize( 'manta_main_menu_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '#main-navigation' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '#main-navigation' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '#main-navigation' ).addClass( 'aligned right' );
			}
		} );
	} );
	// Footer alignment.
	wp.customize( 'manta_footer_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '#colophon' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '#colophon' ).addClass( 'aligned right' );
			}
		} );
	} );
	// Sticky main menu.
	wp.customize( 'manta_sticky_main_menu', function ( value ) {
		value.bind( function ( to ) {
			$( 'body' ).removeClass( 'fixed-elem' );
			if ( to ) {
				$( 'body' ).addClass( 'fixed-elem' );
			}
		} );
	} );
	// Overall link color
	wp.customize( 'manta_link_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'a{color:' + to + '}';
			addInlineCss( 'manta_link_color', css );
		} );
	} );
	// Overall link hover color
	wp.customize( 'manta_link_hover_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'a:hover,a:focus,.nav-menu a:hover,.nav-menu a:focus,.nav-links a:hover,.nav-links a:focus,.menu-toggle:hover,.menu-toggle:focus,.sub-menu-toggle:hover,.sub-menu-toggle:focus{color:' + to + '}';
			css += 'input:focus,textarea:focus{border-color:' + to + '}';
			css += 'input[type="button"]:hover,input[type="button"]:focus,input[type="reset"]:hover,input[type="reset"]:focus,input[type="submit"]:hover,input[type="submit"]:focus{background-color:' + to + '}';
			addInlineCss( 'manta_link_hover_color', css );
		} );
	} );
	// Site Title color
	wp.customize( 'manta_site_title_color', function ( value ) {
		value.bind( function ( to ) {
			var css = '.site-title a{color:' + to + '}';
			addInlineCss( 'manta_site_title_color', css );
		} );
	} );
	// Body text color
	wp.customize( 'manta_content_text_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'body,.nav-menu a,.nav-links a{color:' + to + '}';
			addInlineCss( 'manta_content_text_color', css );
		} );
	} );
	// Post Title color
	wp.customize( 'manta_post_title_color', function ( value ) {
		value.bind( function ( to ) {
			var css = '#main .entry-title,.entry-title a{color:' + to + '}';
			addInlineCss( 'manta_post_title_color', css );
		} );
	} );
	// Post Title hover color
	wp.customize( 'manta_post_title_hover_color', function ( value ) {
		value.bind( function ( to ) {
			var css = '.entry-title a:hover,.entry-title a:focus{color:' + to + '}';
			addInlineCss( 'manta_post_title_hover_color', css );
		} );
	} );
	// Body font family
	wp.customize( 'manta_body_font_family', function ( value ) {
		value.bind( function ( to ) {
			enqueGoogleFonts( 'manta_body_font_family', to );
			var css = 'body{font-family:' + to + '}';
			addInlineCss( 'manta_body_font_family', css );
		} );
	} );
	// Heading font family
	wp.customize( 'manta_heading_font_family', function ( value ) {
		value.bind( function ( to ) {
			enqueGoogleFonts( 'manta_heading_font_family', to );
			var css = 'h1,h2,h3,h4,h5,h6,h1.site-title,p.site-title{font-family:' + to + '}';
			addInlineCss( 'manta_heading_font_family', css );
		} );
	} );
	// Primary sidebar width.
	wp.customize( 'manta_primary_sidebar_width', function ( value ) {
		value.bind( function ( to ) {
			if ( '' !== to ) {
				var css = '@media only screen and (min-width: 1024px){#secondary{width:' + to + 'px}}';
				addInlineCss( 'manta_primary_sidebar_width', css );
			}
			else {
				var css = '@media only screen and (min-width: 1024px){#secondary{width: 300px}}';
				css += '@media only screen and (min-width: 1200px){#secondary{width: 380px}.both-sidebar #secondary{width: 300px}}';
				css += '@media only screen and (min-width: 1340px){.both-sidebar #secondary{width: 380px}}';
				addInlineCss( 'manta_primary_sidebar_width', css );
			}
		} );
	} );
	// Secondary sidebar width.
	wp.customize( 'manta_secondary_sidebar_width', function ( value ) {
		value.bind( function ( to ) {
			if ( '' !== to ) {
				var css = '@media only screen and (min-width: 1024px){#tertiary{width:' + to + 'px}}';
				addInlineCss( 'manta_secondary_sidebar_width', css );
			}
			else {
				var css = '@media only screen and (min-width: 1024px){#tertiary{width: 200px}}';
				css += '@media only screen and (min-width: 1200px){#tertiary{width: 240px}}';
				addInlineCss( 'manta_secondary_sidebar_width', css );
			}
		} );
	} );
	// Overall site width.
	wp.customize( 'manta_overall_site_width', function ( value ) {
		value.bind( function ( to ) {
			if ( '' === to ) {
				to = 1280;
			}
			var outer = +to + 40;
			var inner = +to - 80;
			var threeHeight = ( +to - 81 ) * 0.3334;
			var threeHeightBoxed = ( inner - 81 ) * 0.3334;
			var css = '@media only screen and (min-width:' + outer + 'px){#main-navigation .wrap,#header-nav,.header-items,#colophon > .wrap,.site-content,.footer-widgets .wrap,.widget-wrapper{max-width:' + to + 'px}.three-featured .featured-posts{height:' + threeHeight + 'px;max-height:' + threeHeight + 'px}}';
			css += '@media only screen and (min-width:1680px){.wp-custom-header{max-width:' + to + 'px}}';
			css += '@media only screen and (min-width:' + to + 'px){.boxed .site-header,.boxed .site-footer,.boxed .footer-widgets,.boxed .site-content{max-width:' + to + 'px}.boxed .wrap,.boxed #main-navigation .wrap,.boxed .header-items,.boxed .footer-widget > .wrap,.boxed #colophon > .wrap{max-width:' + inner + 'px}.boxed .three-featured .featured-posts{height:' + threeHeightBoxed + 'px;max-height:' + threeHeightBoxed + 'px}}';
			addInlineCss( 'manta_overall_site_width', css );
		} );
	} );
} )( jQuery );
