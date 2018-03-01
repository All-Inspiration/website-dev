<?php
/**
 * Defaults values for customizer options
 *
 * @package Manta
 * @since 1.0.0
 */

/**
 * Set default values for theme customization options.
 *
 * @since 1.0.0
 *
 * @param str $option name of the option.
 * @return mixed Returns integer, string or array option values.
 */
function manta_get_theme_defaults( $option ) {

	/**
	 * Filter default values for customizer options.
	 *
	 * @since 1.0.0
	 */
	$manta_defaults = apply_filters( 'manta_theme_defaults', array(
		'manta_post_title_color'       => '#333',
		'manta_post_title_hover_color' => '#333',
		'manta_site_title_color'       => '#333',
		'manta_content_text_color'     => '#333',
		'manta_link_color'             => '#0067ac',
		'manta_link_hover_color'       => '#0067ac',
		'manta_display_site_title'     => 1,
		'manta_display_site_desc'      => 1,
		'manta_body_font_family'       => 'Noto Sans',
		'manta_heading_font_family'    => 'Source Sans Pro',
		'manta_small_base_font_size'   => 16,
		'manta_large_base_font_size'   => 18,
		'manta_base_line_height'       => 1.75,
		'manta_site_layout'            => 'full_width',
		'manta_header_alignment'       => 'left',
		'manta_main_menu_alignment'    => 'left',
		'manta_nav_search'             => 1,
		'manta_footer_alignment'       => 'center',
		'manta_sticky_main_menu'       => 1,
		'manta_custom_header_position' => 'above-main-nav',
		'manta_excerpt_option'         => 'excerpt',
		'manta_excerpt_length'         => 40,
		'manta_excerpt_teaser'         => esc_html__( 'Read More', 'manta' ),
		'manta_thumbnails_display'     => 'large_above',
		'manta_copyright'              => '[site_title] [copy_symbol] [current_year]',
		'manta_show_date'              => 1,
		'manta_show_author'            => 1,
		'manta_show_comment_link'      => 1,
		'manta_show_cat'               => 1,
		'manta_show_tags'              => 1,
		'manta_show_author_box'        => 1,
		'manta_show_prevnext'          => 1,
	) );

	if ( 'all' === $option ) {
		return $manta_defaults;
	} elseif ( isset( $manta_defaults[ $option ] ) ) {
		return $manta_defaults[ $option ];
	}

	return '';
}
