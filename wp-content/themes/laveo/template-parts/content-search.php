<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */

?>
<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="category-posts">
		<a class="informatic" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
			<?php echo laveo_img( 380, 176 ); ?></a>
		<h4>
			<a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a>
		</h4>

		<div><span><?php the_time( esc_html__( 'F j, Y', 'laveo' ) ) ?></span>
			<a class="informatic" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<span class="comment"><?php comments_number( esc_html__( 'No Comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></span></a>
		</div>
		<p><?php //excerpt( 40 );
			the_excerpt()
			?></p>

		<p><?php echo esc_html__( 'Posted in', 'laveo' ) ?>
			<a href="<?php the_permalink(); ?>"><span class="comment"><?php the_category( ', ' ); ?></span></a></p>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'laveo' ),
			'after'  => '</div>',
		) );
 		?>
		<div class="clear"></div>
	</div>
</li><!-- #post-## -->

