<?php
/**
 * Header Template Part
 *
 * Template part file that contains the HTML document head and opening HTML
 * body elements as well as the site header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Manta
 * @since 1.0.0
 */

?><!DOCTYPE html>

<?php
/**
 * Fires immediately before site html tag.
 *
 * @since 1.0.0
 */
do_action( 'manta_hook_before_html' ); ?>

<html class="no-js no-svg" <?php language_attributes(); ?>>

<head<?php manta_attr( 'head' );?>>

	<?php
	// Fire the wp_head action.
	wp_head();?>

</head>

<body<?php manta_attr( 'body' ); ?> <?php body_class(); ?>>

	<?php
	/**
	 * Fires immediately after opening of main body tag.
	 *
	 * @since 1.0.0
	 */
	do_action( 'manta_hook_on_top_of_body' ); ?>

	<div id="page"<?php manta_attr( 'site' ); ?>>

		<?php
		/**
		 * Fires immediately before opening of main header tag.
		 *
		 * @since 1.0.0
		 */
		do_action( 'manta_hook_before_header' ); ?>

		<header id="masthead" role="banner"<?php manta_attr( 'site-header' ); ?>>

			<?php
			/**
			 * Fires immediately after opening of main header tag.
			 *
			 * @since 1.0.0
			 */
			do_action( 'manta_hook_for_site_header' ); ?>

		</header><!-- #masthead -->

		<?php
		/**
		 * Fires immediately after closing of header tag.
		 *
		 * @since 1.0.0
		 */
		do_action( 'manta_hook_after_header' );?>

		<div id="content"<?php manta_attr( 'site-content' ); ?>>

			<?php
			/**
			 * Fires immediately after opening of main content tag.
			 *
			 * @since 1.0.0
			 */
			do_action( 'manta_hook_on_top_of_site_content' );?>
