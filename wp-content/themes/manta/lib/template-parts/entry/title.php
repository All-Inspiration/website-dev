<?php
/**
 * The template part for displaying entry title for current post
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<?php if ( is_singular() && ! is_page_template( 'page-template/page-portfolio.php' ) ) :
	the_title( sprintf( '<h1%1$s>', manta_get_attr( 'entry-title' ) ), '</h1>' ); ?>
<?php else :
	the_title( sprintf( '<h2%1$s><a href="%2$s" rel="bookmark">', manta_get_attr( 'entry-title' ), esc_url( get_permalink() ) ), '</a></h2>' ); ?>
<?php endif;
