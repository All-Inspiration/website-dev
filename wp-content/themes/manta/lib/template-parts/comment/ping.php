<?php
/**
 * The template part for displaying post pingbacks and trackbacks
 *
 * @link https://themeshaper.com/2012/11/04/the-wordpress-theme-comments-template/
 *
 * @package Manta
 * @since 1.0.0
 */

$manta_url = get_comment_author_url();
$manta_author = get_comment_author();

?>

<li<?php manta_attr( 'pingback' ); ?>>
	<p>
		<?php printf( esc_html__( 'Pingback:', 'manta' ) ); ?>

		<?php if ( empty( $manta_url ) ) :?>
			<span<?php manta_attr( 'name' ) ?>><?php echo esc_html( $manta_author );?></span>
		<?php else : ?>
			<a href="<?php echo esc_url( $manta_url ); ?>"<?php manta_attr( 'url' )?>><span<?php manta_attr( 'name' ) ?>><?php echo esc_html( $manta_author );?></span></a>
		<?php endif; ?>

		<?php edit_comment_link( esc_html__( '(Edit)', 'manta' ) ); ?>
	</p>

<?php // No closing 'li' is needed.  WordPress will know where to add it.
