<?php
/**
 * The template part for displaying current post author name
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<span<?php manta_attr( 'byline' ) ?>>
	<span<?php manta_attr( 'author' ) ?>>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"<?php manta_attr( 'url' ) ?>>
			<?php esc_html_e( 'By', 'manta' ); ?>
			<span<?php manta_attr( 'name' ) ?>> <?php the_author(); ?></span>
		</a>
	</span>
</span>
