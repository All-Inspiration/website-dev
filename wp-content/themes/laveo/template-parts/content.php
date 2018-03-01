<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */

?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="category-posts">
		<a class="informatic" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
			<?php echo laveo_img( 380, 176 ); ?></a>
		<?php
		the_title( '<h4><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
 		?>
		<div>
			<?php
			if(get_the_title(get_the_ID()) == ''){
				echo '<a href="' . esc_url( get_permalink() ) . '" >';
			}
			?>
			<span><?php the_time( esc_html__( 'F j, Y', 'laveo' ) ) ?></span>
			<?php
			if(get_the_title(get_the_ID()) == ''){
				echo '</a>';
			}
			?>

			<a class="informatic" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<span class="comment"><?php comments_number( esc_html__( 'No Comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></span></a>
		</div>

		<?php the_excerpt() ?>

		<p>
			<?php echo esc_html__( 'Posted in: ', 'laveo' ) ?><span class="comment"><?php the_category( ', ' ); ?></span>
		</p>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'laveo' ),
			'after'  => '</div>',
		) );

		?>
		<div class="clear"></div>
	</div>
</li><!-- #post-## -->
