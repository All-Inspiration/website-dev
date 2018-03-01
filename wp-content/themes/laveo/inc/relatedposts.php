<div id="archived-posts" class="clear"><!-- Begin archived posts -->
	<h5 class="widget-head"><?php echo esc_html__( 'Related', 'laveo' ); ?></h5>
	<?php // Get Related Portfolio by Category
	$related = laveo_get_related_posts( get_the_ID(), 2 );
	if ( $related->have_posts() ) {
		echo '<ul class="archived-posts">';
		while ( $related->have_posts() ) {
			$related->the_post();
			?>
			<li>
				<div class="category-posts clear">
					<div class="post-img">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php echo laveo_img( 60, 60 ) ?>
						</a>
					</div>
					<div class="rel-post-text">
						<h4>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h4>

						<p><?php the_time( 'F d, Y' ); ?></p>

						<p><?php esc_html_e( 'Posted in', 'laveo' ); ?><?php the_category( ', ' ); ?></p>
					</div>
				</div>
			</li>
			<?php
		}
		wp_reset_postdata();
		echo '</ul>';
	} else {
		echo '<div id="archive-error"><p class="error-message">' . esc_html__( 'Sorry. There are no related articles at this time.', 'laveo' ) . '</p></div>';
	}
	?>
</div><!-- End archived posts -->