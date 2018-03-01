<?php
/**
 * Teplate tags for manta theme
 *
 * @package Manta
 * @since 1.2
 */

/**
 * Render footer credit information.
 *
 * @since 1.2
 *
 * @return str copyright information markup.
 */
function manta_render_copyright_info() {
	$copyright_info = get_theme_mod( 'manta_copyright', manta_get_theme_defaults( 'manta_copyright' ) );
	if ( '' === $copyright_info ) {
		$copyright_info = manta_get_theme_defaults( 'manta_copyright' );
	}

	$copyright_info = implode( '<br/>', array_map( 'esc_textarea', explode( "\n", $copyright_info ) ) );

	$output = str_replace( '[current_year]', date_i18n( __( 'Y', 'manta' ) ), $copyright_info );
	$output = str_replace( '[site_title]', get_bloginfo('name'), $output );
	$output = str_replace( '[copy_symbol]', '&copy;', $output );

	$output = sprintf( '<span>%s</span>', $output );
	return $output;
}

/**
 * Get navigation menu markup.
 *
 * Create navigation menu markup based on arguments provided.
 *
 * @since 1.0.0
 *
 * @param string $nav_id    Menu container ID.
 * @param string $menu_id   Menu ID.
 * @param string $label     Menu label.
 * @param string $location  Menu theme location.
 * @param bool   $is_toggle Is toggle button required.
 * @param int    $args      Additional wp_nav_menu args.
 */
function manta_menu( $nav_id, $menu_id, $label, $location, $is_toggle = false, $args = array() ) {
	$menu = sprintf( '<h2 class="screen-reader-text">%s</h2>', $label );

	if ( $is_toggle ) {
		$menu .= sprintf(
			'<button aria-controls="%1$s" aria-expanded="false" %2$s>%3$s%4$s%5$s</button>',
			$menu_id,
			manta_get_attr( 'menu-toggle' ),
			manta_get_icon( array( 'icon' => 'bars'  ) ),
			manta_get_icon( array( 'icon' => 'close' ) ),
			esc_html__( 'Menu', 'manta' )
		);
	}

	$menu .= wp_nav_menu(
		array_merge( $args, array(
			'theme_location' => $location,
			'menu_id'        => $menu_id,
			'menu_class'     => 'nav-menu nav-menu--' . $location,
			'echo'           => false,
		) )
	);

	$menu_markup = printf( '<nav id="%1$s"%2$s aria-label="%3$s">%4$s</nav>', $nav_id, manta_get_attr( $nav_id ), $label, $menu );
}

function manta_widgets( $id, $class, $label, $widgets = array(), $wrapper_class = '' ) {
	printf( '<aside id=%1$s%2$s area-label=%3$s>', $id, manta_get_attr( $class ), $label );
	printf( '<h2 class="screen-reader-text">%s</h2>', $label );
	if ( $wrapper_class ) {
		printf( '<div%s>', manta_get_attr( $wrapper_class ) );
	}
	foreach( $widgets as $widget ) {
		if ( is_active_sidebar( $widget ) ) {
			printf( '<div%s>', manta_get_attr( 'widget-wrapper' ) );
			dynamic_sidebar( $widget );
			printf( '</div>' );
		}
	}
	if ( $wrapper_class ) {
		printf( '</div>' );
	}
	printf( '</aside>' );
}