<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package laveo
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content_area"><?php esc_html_e( 'Skip to content', 'laveo' ); ?></a>
	<header id="header_area" class="site-header full_width" role="banner">
		<div class="page">
			<div id="header">
				<button data-activates="site-navigation" class="btn-menu">
					<span></span>
				</button>
				<div id="title-area">
					<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-logo">
						<?php else : ?>
						<p class="site-logo">
							<?php endif; ?>
							<?php
							if ( !get_theme_mod( 'laveo_logo' ) ) : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
							<?php else : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_theme_mod( 'laveo_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
							<?php endif; ?>

							<?php if ( is_front_page() && is_home() ) : ?>
					</h1>
				<?php else : ?>
					</p>
				<?php endif; ?>
				</div>
				<?php
				if ( is_active_sidebar( 'top_banner_widget' ) ) {
					echo '<div class="widget-area">';
					dynamic_sidebar( 'top_banner_widget' );
					echo '</div>';
				}
				?>
			</div>
			<!-- .site-branding -->

			<nav id="site-navigation" class="menu-main-menu-container" role="navigation">
				<ul class="nav" id="menu-main-menu">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
					} else {
						wp_nav_menu( array(
							'theme_location' => '',
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
					}
					if ( get_theme_mod( 'show_search' ) == '1' ) {
						echo '<li class="search-right">
							<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
								<div class="wrapper-search">
									 <input type="search" class="search-field" placeholder="' . esc_html__( 'Search ...', 'laveo' ) . '" value="" name="s">
 								</div>
 								<input type="submit" class="search-submit" value="&#xf002;">
							</form>
							</li>';
					}
					?>
				</ul>
			</nav>
			<!-- #site-navigation -->
		</div>
	</header>
	<!-- #masthead -->