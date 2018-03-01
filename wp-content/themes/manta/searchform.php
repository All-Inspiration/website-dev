<?php
/**
 * Display search form
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<form role="search" method="get"<?php manta_attr( 'search-form' ); ?> action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label class="label-search">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'manta' ) ?></span>
		<input type="search"<?php manta_attr( 'search-field' ); ?> placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'manta' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'manta' ) ?>" />
	</label>
	<button type="submit" class="search-submit"><?php manta_icon( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'manta' ); ?></span></button>
</form>
