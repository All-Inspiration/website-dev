<?php
/**
 * The template part for displaying post comment title
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<h2<?php manta_attr( 'comments-title' ) ?>>
	<?php
	printf(
	/* translators: 1: number of comments, 2: post title */
		_nx(
			'One reply to %2$s',
			'%1$s replies to %2$s',
			get_comments_number(),
			'comments title',
			'manta'
		),
		number_format_i18n( get_comments_number() ),
		'<span class="post-title">' . get_the_title() . '</span>'
	);
	?>
</h2>
