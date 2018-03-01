<?php
/**
 * The template part for displaying tags of current post
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<?php $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'manta' ) ); ?>
<?php if ( $tags_list ) : ?>
	<span<?php manta_attr( 'tags-links' ) ?>>
		<?php
		printf( esc_html__( 'Tagged With: ', 'manta' ) );
		echo $tags_list;
		?>
	</span>
<?php endif;?>
