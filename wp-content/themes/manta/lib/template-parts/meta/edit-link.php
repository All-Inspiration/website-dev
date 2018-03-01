<?php
/**
 * The template part for displaying link to edit current post
 *
 * @package Manta
 * @since 1.0.0
 */

edit_post_link(
	sprintf(
		/* translators: %s: Name of current post */
		__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'manta' ),
		get_the_title()
	),
	'<span' . manta_get_attr( 'edit-link' ) . '>',
	'</span>'
);
