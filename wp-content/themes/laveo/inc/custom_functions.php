<?php
//pannel Widget Group
function laveo_widget_group( $tabs ) {
	$tabs[] = array(
		'title'  => esc_html__( 'Physcode Widget', 'laveo' ),
		'filter' => array(
			'groups' => array( 'laveo_widget_group' )
		)
	);

	return $tabs;
}

add_filter( 'siteorigin_panels_widget_dialog_tabs', 'laveo_widget_group', 19 );
/********************************************************************
 * Get image attach
 ********************************************************************/
function laveo_img( $width, $height ) {
	global $post;
	if ( has_post_thumbnail() ) {
		$get_thumbnail = simplexml_load_string( get_the_post_thumbnail( $post->ID, 'full' ) );
		//$thumbnail_src = $get_thumbnail->attributes()->src;
		//var_dump($get_thumbnail);
		$img_url = $get_thumbnail['src'];
		$data    = @getimagesize( $img_url );

		$width_data  = $data[0];
		$height_data = $data[1];
		if ( !( $width_data > $width ) && !( $height_data > $height ) ) {
			return '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
		} else {
			$crop       = ( $height_data < $height ) ? false : true;
			$image_crop = aq_resize( $img_url[0], $width, $height, $crop );

			return '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
		}
	}
}

function laveo_img_slider( $width, $height, $title ) {
	global $post;
	if ( has_post_thumbnail() ) {
		$get_thumbnail = simplexml_load_string( get_the_post_thumbnail( $post->ID, 'full' ) );
		//$thumbnail_src = $get_thumbnail->attributes()->src;
		$img_url     = $get_thumbnail['src'];
		$data        = @getimagesize( $img_url );
		$width_data  = $data[0];
		$height_data = $data[1];
		if ( !( $width_data > $width ) && !( $height_data > $height ) ) {
			return '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . $title . '" data-thumb="' . $img_url[0] . '" />';
		} else {
			$crop       = ( $height_data < $height ) ? false : true;
			$image_crop = aq_resize( $img_url[0], $width, $height, $crop );
			$image_rel  = aq_resize( $img_url[0], 70, 55, true );

			return '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . $title . ' " data-thumb="' . $image_rel . '"/>';
		}
	}
}

function laveo_img_gallery( $width, $height ) {
	global $post;
	if ( has_post_thumbnail() ) {
		$domsxe       = simplexml_load_string( get_the_post_thumbnail( $post->ID, 'full' ) );
		$thumbnailsrc = $domsxe->attributes()->src;
		$img_url      = $thumbnailsrc;
		$data         = @getimagesize( $img_url );
		$width_data   = $data[0];
		$height_data  = $data[1];
		if ( !( $width_data > $width ) && !( $height_data > $height ) ) {
			print $img_url[0];
		} else {
			$crop       = ( $height_data < $height ) ? false : true;
			$image_crop = aq_resize( $img_url[0], $width, $height, $crop );
			print $image_crop;
		}
	}
}

/********************************************************************
 * Excerpt Word Limit
 ********************************************************************/
function laveo_excerpt( $num ) {
	$link    = get_permalink();
	$ending  = get_option( 'wl_excerpt_ending' );
	$limit   = $num + 1;
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	array_pop( $excerpt );
	$excerpt = implode( " ", $excerpt ) . $ending;
	echo ent2ncr( $excerpt );
	$readmore = get_option( 'wl_readmore_link' );
	if ( $readmore != "" ) {
		$readmore = '<p class="readmore"><a href="' . $link . '">' . $readmore . '</a></p>';
		echo ent2ncr( $readmore );
	}
}

/********************************************************************
 * Page navigation
 ********************************************************************/
function page_navi( $before = '', $after = '' ) {
	global $wpdb, $wp_query;

	$request        = $wp_query->request;
	$posts_per_page = intval( get_query_var( 'posts_per_page' ) );
	$paged          = intval( get_query_var( 'paged' ) );
	$numposts       = $wp_query->found_posts;
	$max_page       = $wp_query->max_num_pages;

	if ( empty( $paged ) || $paged == 0 ) {
		$paged = 1;
	}
	$pages_to_show         = 8;
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start       = floor( $pages_to_show_minus_1 / 2 );
	$half_page_end         = ceil( $pages_to_show_minus_1 / 2 );
	$start_page            = $paged - $half_page_start;
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if ( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page   = $max_page;
	}
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}

	echo ent2ncr( $before ) . '<div class="page_navi">' . "\n";
	if ( $start_page >= 2 && $pages_to_show < $max_page ) {
		$first_page_text = "First";
		echo '<a href="' . get_pagenum_link() . '" title="' . $first_page_text . '">' . $first_page_text . '</a>';
	}
	previous_posts_link( '<span>&laquo;Previous</span>' );
	for ( $i = $start_page; $i <= $end_page; $i ++ ) {
		if ( $i == $paged ) {
			echo '<span class="current">' . $i . '</span>';
		} else {
			echo '<a href="' . get_pagenum_link( $i ) . '"><span>' . $i . '</span></a>';
		}
	}
	next_posts_link( '<span>Next&raquo;</span>' );
	if ( $end_page < $max_page ) {
		$last_page_text = "Last";
		echo '<a href="' . get_pagenum_link( $max_page ) . '" title="' . $last_page_text . '">' . $last_page_text . '</a>';
	}
	echo '</div>' . $after . "\n";
}

/********************************************************************
 * Custom comment
 ********************************************************************/
function laveo_get_total_comments_by_author() {
	return count( get_comments( array(
		'author_email' => get_comment_author_email()
	) ) );
}

function laveo_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comclass">
		<div <?php comment_class(); ?>>
			<div class="abc">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment_moderated"><?php esc_html_e( 'Your comment is waiting for moderation.', 'laveo' ) ?></p>
				<?php endif; ?>
				<?php comment_text() ?>
				<?php comment_reply_link( array_merge( $args, array(
					'depth'     => $depth,
					'max_depth' => 4
				) ) ) ?> <?php edit_comment_link( esc_html__( ' | Edit', 'laveo' ), '  ', '' ) ?>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, $size = '80' ); ?>
					<cite class="fn"><?php printf( esc_html__( '%s', 'laveo' ), get_comment_author_link() ) ?></cite><!--<span class="c_count">(<?php echo laveo_get_total_comments_by_author(); ?>)</span>-->
					<br />
					<small>
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s', 'laveo' ), get_comment_date( esc_html__( 'd/m/Y', 'laveo' ) ) ) ?></a>
					</small>
				</div>
			</div>
			<div class="say"></div>
		</div>
	</div>
<?php }

// related post
function laveo_get_related_posts( $post_id, $number_posts = - 1 ) {
	$query = new WP_Query();
	$args  = '';
	if ( $number_posts == 0 ) {
		return $query;
	}
	$args = wp_parse_args( $args, array(
		'posts_per_page'      => $number_posts,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => 0,
		'meta_key'            => '_thumbnail_id',
		'category__in'        => wp_get_post_categories( $post_id )
	) );

	$query = new WP_Query( $args );

	return $query;
}

/********************************************************************
 * Custom ping
 ********************************************************************/
function laveo_ping( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

add_editor_style();
?>