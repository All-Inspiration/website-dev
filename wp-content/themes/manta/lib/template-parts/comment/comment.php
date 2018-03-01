<?php
/**
 * The template part for displaying post comment.
 *
 * @link https://themeshaper.com/2012/11/04/the-wordpress-theme-comments-template/
 *
 * @package Manta
 * @since 1.0.0
 */

$manta_url = get_comment_author_url();
$manta_author = get_comment_author();

?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

	<article id="comment-<?php comment_ID(); ?>"<?php manta_attr( 'comment-inner' ) ?>>

		<header<?php manta_attr( 'comment-header' )?>>

			<?php if ( '0' === $comment->comment_approved ) : ?>
				<em><?php printf( esc_html__( 'Your comment is awaiting moderation.', 'manta' ) );?></em><br />
			<?php endif;?>

			<div<?php manta_attr( 'comment-author' ); ?>>
				<?php echo get_avatar( $comment, 56 );?>

				<?php if ( empty( $manta_url ) ) :?>
					<span<?php manta_attr( 'name' ) ?>><?php echo esc_html( $manta_author );?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $manta_url ); ?>"<?php manta_attr( 'url' )?>><span<?php manta_attr( 'name' ) ?>><?php echo esc_html( $manta_author );?></span></a>
				<?php endif; ?>

			</div><!-- .comment-author .vcard -->

			<div<?php manta_attr( 'comment-meta' ); ?>>
				<time datetime="<?php echo esc_attr( get_comment_time( 'c' ) ); ?>"<?php manta_attr( 'comment-time' ); ?>>
					<?php echo esc_html( human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
					printf( esc_html__( ' ago', 'manta' ) );?>
				</time>
			</div>

		</header>

		<div<?php manta_attr( 'comment-content' )?>><?php comment_text();?></div>

		<div<?php manta_attr( 'comment-footer' ) ?>>
			<?php comment_reply_link(
				array(
					'depth'     => intval( $GLOBALS['comment_depth'] ),
					'max_depth' => get_option( 'thread_comments_depth' ),
				)
			);
			edit_comment_link( esc_html__( '(Edit)', 'manta' ) );?>
		</div>

	</article><!-- #comment-## -->

<?php // No closing 'li' is needed.  WordPress will know where to add it.
