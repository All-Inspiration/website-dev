<?php
/**
 * Display post content
 *
 * Template part file that contains the default Post content,
 * including Post header, Post entry, and Post footer.
 *
 * @package Manta
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php manta_attr( 'post' ); ?>>

	<header<?php manta_attr( 'entry-header' ); ?>>

		<?php the_title( sprintf( '<h2%1$s>', manta_get_attr( 'entry-title' ) ), '</h2>' );?>

	</header><!-- .entry-header -->

</article><!-- #post-## -->
