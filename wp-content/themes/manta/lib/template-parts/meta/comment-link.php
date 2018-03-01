<?php
/**
 * The template part for displaying link to write comment in current post
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
	<span<?php manta_attr( 'comments-link' ) ?>>
		<?php comments_popup_link(
			sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'manta' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() )
		);?>
	</span>
<?php endif; ?>
