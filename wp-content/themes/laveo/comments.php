<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package laveo
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
		<div class="wrappcomment clear">
			<h3 class="c_title">
				<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'Comment (%1$s) | %2$s', 'Comments (%1$s) | %2$s', get_comments_number(), 'comments title', 'laveo' ) ),
					number_format_i18n( get_comments_number() ),
					'<a href="#respond">' . esc_html__( "Leave a comment", "laveo" ) . '</a>'
				);
				?>
			</h3>
			<div class="commentwrap clear">
				<ol class="commentlist">
					<?php
					wp_list_comments( 'style=li&&type=comment&avatar_size=90&callback=laveo_comment' )
					?>
				</ol>
				<!-- .comment-list -->
			</div>
		</div>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'laveo' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'laveo' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'laveo' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'laveo' ); ?></p>
	<?php endif; ?>

	<?php
	$comments_args = array(
		// change the title of send button
		'label_submit'         => esc_html__( 'submit', 'laveo' ),
		'id_submit'            => 'submit',
		// change the title of the reply section
		'title_reply'          => '<h3 class="c_title clear">' . esc_html__( 'Leave a Comment', 'laveo' ) . '</h3>',
		// remove "Text or HTML to be displayed after the set of comment fields"
		'comment_notes_after'  => '',
		'comment_notes_before' => '<p class="comment-notes">' .
			esc_html__( 'Your email address will not be published.', 'laveo' ) /* . ( $req ? $required_text : '' ) */ .
			'</p>',
		'fields'               => apply_filters( 'comment_form_default_fields', array(
				'author' => '<div class="form-group"><label><input id="author" name="author" type="text" class="txt" value="" size="30" placeholder="' . esc_html__( "Name*", "laveo" ) . '"/></label>',
				'email'  => '<label><input id="email" name="email" type="text" class="txt" value="" size="30" placeholder="' . esc_html__( "Email*", "laveo" ) . '" /></label>',
				'url'    => '<label><input id="url" name="url" type="text" class="txt" value="" size="30"  placeholder="' . esc_html__( "Website", "laveo" ) . '"/></label></div>'
			)
		),
		'comment_field'        => '<textarea id="comment" class="text_area" name="comment" aria-required="true" placeholder="' . esc_html__( "Message*", "laveo" ) . '"></textarea>',
	);
	?>
	<?php comment_form( $comments_args ); ?>

</div><!-- #comments -->
