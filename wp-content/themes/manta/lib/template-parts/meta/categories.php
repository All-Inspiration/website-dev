<?php
/**
 * The template part for displaying categories of current post
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<?php $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'manta' ) ); ?>
<?php if ( $categories_list ) : ?>
	<span<?php manta_attr( 'cat-links' ) ?>>
		<?php
		printf( esc_html__( 'Filed Under: ', 'manta' ) );
		echo $categories_list;
		?>
	</span>
<?php endif; ?>
