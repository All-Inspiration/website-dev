<?php
add_action( 'widgets_init', array( 'laveo_Widget_Attributes', 'setup' ) );

class laveo_Widget_Attributes {
	const VERSION = '0.2.2';

	/**
	 * Initialize plugin
	 */
	public static function setup() {
		if ( is_admin() ) {
			// Add necessary input on widget configuration form
			add_action( 'in_widget_form', array( __CLASS__, '_input_fields' ), 10, 3 );
			// Save widget attributes
			add_filter( 'widget_update_callback', array( __CLASS__, '_save_attributes' ), 10, 4 );
		} else {
			// Insert attributes into widget markup
			add_filter( 'dynamic_sidebar_params', array( __CLASS__, '_insert_attributes' ) );
		}
	}


	/**
	 * Inject input fields into widget configuration form
	 *
	 * @since   0.1
	 * @wp_hook action in_widget_form
	 *
	 * @param object $widget Widget object
	 *
	 * @return NULL
	 */
	public static function _input_fields( $widget, $return, $instance ) {
		$instance = self::_get_attributes( $instance );
		?>
		<p>
			<?php printf(
				'<label for="%s">%s</label>',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_html__( 'Extra Class', 'laveo' )
			) ?>
			<?php
			printf(
				'<input type="text" class="widefat" id="%s" name="%s" value="%s" />',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_attr( $widget->get_field_name( 'widget-class' ) ),
				esc_attr( $instance['widget-class'] )
			);
			?>
		</p>
		<?php
		return null;
	}


	/**
	 * Get default attributes
	 *
	 * @since 0.1
	 *
	 * @param array $instance Widget instance configuration
	 *
	 * @return array
	 */
	private static function _get_attributes( $instance ) {
		$instance = wp_parse_args(
			$instance,
			array(
				'widget-class' => '',
			)
		);

		return $instance;
	}


	/**
	 * Save attributes upon widget saving
	 *
	 * @since   0.1
	 * @wp_hook filter widget_update_callback
	 *
	 * @param array  $instance     Current widget instance configuration
	 * @param array  $new_instance New widget instance configuration
	 * @param array  $old_instance Old Widget instance configuration
	 * @param object $widget       Widget object
	 *
	 * @return array
	 */
	public static function _save_attributes( $instance, $new_instance, $old_instance, $widget ) {
		$instance['widget-class'] = '';

		// Classes
		if ( !empty( $new_instance['widget-class'] ) ) {
			$instance['widget-class'] = apply_filters(
				'widget_attribute_classes',
				implode(
					' ',
					array_map(
						'sanitize_html_class',
						explode( ' ', $new_instance['widget-class'] )
					)
				)
			);
		} else {
			$instance['widget-class'] = '';
		}

		return $instance;
	}


	/**
	 * Insert attributes into widget markup
	 *
	 * @since  0.1
	 * @filter dynamic_sidebar_params
	 *
	 * @param array $params Widget parameters
	 *
	 * @return Array
	 */
	public static function _insert_attributes( $params ) {
		global $wp_registered_widgets;

		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[$widget_id];

		if (
			!isset( $widget_obj['callback'][0] )
			|| !is_object( $widget_obj['callback'][0] )
		) {
			return $params;
		}

		$widget_options = get_option( $widget_obj['callback'][0]->option_name );
		if ( empty( $widget_options ) ) {
			return $params;
		}

		$widget_num = $widget_obj['params'][0]['number'];
		if ( empty( $widget_options[$widget_num] ) ) {
			return $params;
		}

		$instance = $widget_options[$widget_num];

		// Classes
		if ( !empty( $instance['widget-class'] ) ) {
			$params[0]['before_widget'] = preg_replace(
				'/class="/',
				sprintf( 'class="%s ', $instance['widget-class'] ),
				$params[0]['before_widget'],
				1
			);
		}

		return $params;
	}
}

class PopularRecentPost extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'widget popular recent post',
			'description'   => 'Popular Recent Post',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'widget_PopularRecentPost', 'Popular Recent Posts', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title  = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$number = empty( $instance['number'] ) ? '' : apply_filters( 'widget_number', $instance['number'] );
		echo ent2ncr( $before_widget );
		wp_enqueue_script( 'laveo-idTabs', get_template_directory_uri() . '/js/jquery.idTabs.min.js', array( 'jquery' ), '', true );
		?>

		<?php
		if ( $title ) {
			echo '<h4 class="widgettitle">' . $title . '</h4>';
		}
		?>

		<div class="tabs1">
			<ul class="tab idTabs">
				<li><a href="#tabs1" class="selected"><?php echo esc_html__( 'Recent', 'laveo' ) ?></a></li>
				<li><a href="#tabs2"><?php echo esc_html__( 'Popular', 'laveo' ) ?></a></li>
				<li><a href="#tabs3"><?php echo esc_html__( 'Tag cloud', 'laveo' ) ?></a></li>
			</ul>
			<br class="clear" />

			<div id="tabs1">
				<ul>
					<?php $latest = new WP_query();
					$latest->query( 'showposts=' . $number ); ?>
					<?php while ( $latest->have_posts() ) : $latest->the_post(); ?>
						<li>
							<?php echo laveo_img( 54, 54 ); ?>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>

							<p><?php laveo_excerpt( 15 ); ?></p>
						</li>
					<?php endwhile; ?>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="tabs2">
				<ul>

					<?php $popular = new WP_query();
					$popular->query( 'orderby=comment_count&order=DESC&showposts=' . $number ); ?>
					<?php while ( $popular->have_posts() ) : $popular->the_post(); ?>
						<li>
							<?php echo laveo_img( 54, 54 ); ?>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>

							<p><?php laveo_excerpt( 15 ); ?></p>
						</li>
					<?php endwhile; ?>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="tabs3">
				<?php wp_tag_cloud( 'smallest=8&largest=16&order=ASC' ); ?>
			</div>
		</div>
		<?php
		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['title']  = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Last Comments', 'number' => '5' ) );
		$title    = strip_tags( $instance['title'] );
		$number   = strip_tags( $instance['number'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title', 'laveo' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php echo esc_html__( 'Number of posts to show:', 'laveo' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $number ); ?>">
		</p>
		<?php
	}
}

register_widget( 'PopularRecentPost' );

class slider_homepage extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'slider_homepage',
			'description'   => 'Slider on homepage',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'widget_slider_homepage', 'Slider on homepage', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID  = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$post_number = empty( $instance['post_number'] ) ? '' : apply_filters( 'widget_post_number', $instance['post_number'] );
		echo ent2ncr( $before_widget );
		wp_enqueue_script( 'laveo-nivo.slider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array( 'jquery' ), '', true );
		?>
		<?php $slider_list = new WP_query();
		$post_number       = 2;
		$slider_list->query( 'showposts=' . $post_number . '&cat=' . $categoryID );
		$i = 1; ?>
		<div id="feature">
			<div class="wrap">
				<div id="slider" class="nivoSlider">
					<?php
					$i = 1;
					while ( $slider_list->have_posts() ) : $slider_list->the_post();
						echo laveo_img_slider( 1200, 440, '#caption' . $i );
						$i ++;
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php
				$i = 1;
				while ( $slider_list->have_posts() ) : $slider_list->the_post(); ?>
					<div id="caption<?php echo esc_attr( $i ); ?>" class="nivo-html-caption">
						<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>

						<div class="info">
							<span class="date"><?php the_time( esc_html__( 'M j, Y', 'laveo' ) ) ?></span><span> <?php comments_number( esc_html__( 'No comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></span>
						</div>
						<p><?php laveo_excerpt( 80 ) ?>...</p>
						<a class="readmore" href="<?php the_permalink() ?>"><?php echo esc_html__( 'Read More', 'laveo' ) ?></a>
					</div>
					<?php
					$i ++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php
		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['categoryID'] = strip_tags( $new_instance['categoryID'] );

		return $instance;
	}

	function form( $instance ) {
		$instance   = wp_parse_args( (array) $instance, array( 'categoryID' => '' ) );
		$categoryID = strip_tags( $instance['categoryID'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>"><?php echo esc_html__( 'Select Category', 'laveo' ) ?>
				<select name="<?php echo esc_attr( $this->get_field_name( 'categoryID' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>" style="width:170px">
					<?php $categories = get_categories();
					foreach ( $categories as $cat ) {
						if ( $categoryID == $cat->cat_ID ) {
							$selected = ' selected="selected"';
						} else {
							$selected = '';
						}
						$opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
						echo ent2ncr( $opt );
					} ?>
				</select>
		</p>

		<?php
	}
}

register_widget( 'slider_homepage' );

/********************************************************************
 * Hot News Widget
 ********************************************************************/
class hot_news extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'hot_news',
			'description'   => 'Headline News',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'widget_hot_news', 'Hot News Widget', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID  = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$title       = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$post_number = empty( $instance['post_number'] ) ? '' : apply_filters( 'widget_post_number', $instance['post_number'] );
		echo ent2ncr( $before_widget );
		?>
		<div id="headline">
			<div class="wrap">
				<div class="title">
					<h3><?php echo esc_attr( $title ); ?></h3>
					<span class="next">&nbsp;</span>
					<span class="prev">&nbsp;</span>
				</div>
				<div class="headline">
					<div>
						<ul>
							<?php $slider_list = new WP_query();
							$slider_list->query( 'showposts=' . $post_number . '&cat=' . $categoryID );
							$i = 1;
							while ( $slider_list->have_posts() ) : $slider_list->the_post(); ?>
								<li>
									<?php
									echo laveo_img( 185, 90 ) ?>
									<p><a href="<?php the_permalink() ?>"><?php the_title() ?></a></p>
								</li>
							<?php endwhile;
							wp_reset_postdata();
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['categoryID']  = strip_tags( $new_instance['categoryID'] );
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['post_number'] = strip_tags( $new_instance['post_number'] );

		return $instance;
	}

	function form( $instance ) {
		$instance    = wp_parse_args( (array) $instance, array(
			'categoryID'  => '',
			'title'       => 'Hot news',
			'post_number' => '6'
		) );
		$categoryID  = strip_tags( $instance['categoryID'] );
		$title       = strip_tags( $instance['title'] );
		$post_number = strip_tags( $instance['post_number'] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Hot news title', 'laveo' ) ?>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php echo esc_html__( 'Number Post', 'laveo' ) ?>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" value="<?php echo esc_attr( $post_number ); ?>"></label>
		</p>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>"><?php echo esc_html__( 'Select Category', 'laveo' ) ?>
				<select name="<?php echo esc_attr( $this->get_field_name( 'categoryID' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>" style="width:170px">
					<?php $categories = get_categories();
					foreach ( $categories as $cat ) {
						if ( $categoryID == $cat->cat_ID ) {
							$selected = ' selected="selected"';
						} else {
							$selected = '';
						}
						$opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
						echo ent2ncr( $opt );
					} ?>
				</select>
		</p>

		<?php
	}
}

register_widget( 'hot_news' );

/********************************************************************
 * Category news Widget
 ********************************************************************/
class category_news extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'category_news',
			'description'   => 'Category News Widget',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'widget_category_news', 'Category News Widget', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID   = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$other_number = empty( $instance['other_number'] ) ? '' : apply_filters( 'widget_other_number', $instance['other_number'] );
		$color        = empty( $instance['color'] ) ? '' : apply_filters( 'widget_color', $instance['color'] );
		$style        = empty( $instance['style'] ) ? '' : apply_filters( 'widget_style', $instance['style'] );
		echo ent2ncr( $before_widget );
		$number = $other_number;
		wp_enqueue_script( 'laveo-jcarousellite_1', get_template_directory_uri() . '/js/jcarousellite_1.0.1c4.min.js', array( 'jquery' ), '', true );
		?>
		<?php
		$i         = 0;
		$news_post = new WP_query();
		$news_post->query( "showposts=$number&cat=$categoryID" ); ?>

		<?php
		if ( $style == 'style2' ) {
			?>
			<div class="style2 category_news">
				<div class="hentry_widget <?php echo esc_attr( $color ); ?>">
					<h3>
						<a href="<?php echo get_category_link( $categoryID ); ?>"><?php echo get_cat_name( $categoryID ); ?></a>
					</h3>
					<ul>
						<?php while ( $news_post->have_posts() ) : $news_post->the_post(); ?>
							<li>
								<a class="thumb" href="<?php the_permalink() ?>" title="Permanent link to <?php the_title(); ?>"><?php echo laveo_img( 70, 70 ); ?></a>
								<h4>
									<a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a>
								</h4>
								<?php the_time( esc_html__( 'F j, Y', 'laveo' ) ) ?> | <?php comments_number( esc_html__( 'No Comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?>
							</li>
						<?php endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
			<?php
		} elseif ( $style == 'style3' ) {
			?>
			<div class="clear"></div>
			<div class="style3 category_news">
				<div class="hentry_widget1 <?php echo esc_attr( $color ); ?>">
					<h3>
						<a href="<?php echo get_category_link( $categoryID ); ?>"><?php echo get_cat_name( $categoryID ); ?></a>
					</h3>
					<ul>
						<?php while ( $news_post->have_posts() ) : $news_post->the_post(); ?>
							<li>
								<a class="thumb" title="<?php the_title(); ?>" rel="bookmark" href="<?php the_permalink() ?>"><?php echo laveo_img( 220, 136 ); ?></a>

								<p><?php the_time( esc_html__( 'M j, Y', 'laveo' ) ) ?><?php echo esc_html__( 'with', 'laveo' ) ?><?php comments_number( esc_html__( 'No comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></p>

								<h4>
									<a rel="bookmark" title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
								</h4>


							</li>
						<?php endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<?php
		} else {
			?>
			<div class="style1 category_news">
				<?php while ( $news_post->have_posts() ) :
				$news_post->the_post();
				if ( $i == 0 ) {
				?>
				<div class="hentry_widget <?php echo esc_attr( $color ); ?>">
					<h3>
						<a href="<?php echo get_category_link( $categoryID ); ?>"><?php echo get_cat_name( $categoryID ); ?></a>
					</h3>
					<?php echo laveo_img( 390, 220 ); ?>
					<div class="block-content">
						<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>

						<div class="info">
							<span class="date"><?php the_time( esc_html__( 'M j, Y', 'laveo' ) ) ?></span><span><?php comments_number( esc_html__( 'No comment', 'laveo' ), esc_html__( '1 comment', 'laveo' ), esc_html__( '% comments', 'laveo' ) ); ?></span>
						</div>

						<p><?php laveo_excerpt( 20 ); ?></p>
						<ul>
							<?php
							$i ++;
							} else {
								?>
								<li><span>&nbsp;</span><a href="<?php the_permalink() ?>"><?php the_title() ?>
										<?php $comments = comments_number( '', '1', '%' );
										if ( $comments > 0 ) {
											echo "(" . $comments . ")";
										}
										?></a></li>
								<?php
							}
							endwhile;
							wp_reset_postdata();
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
		?>


		<?php
		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['categoryID']   = strip_tags( $new_instance['categoryID'] );
		$instance['other_number'] = strip_tags( $new_instance['other_number'] );
		$instance['color']        = strip_tags( $new_instance['color'] );
		$instance['style']        = strip_tags( $new_instance['style'] );

		return $instance;
	}

	function form( $instance ) {
		$instance     = wp_parse_args( (array) $instance, array(
			'categoryID'   => '',
			'other_number' => '4',
			'color'        => 'color1',
			'style'        => 'style1'
		) );
		$categoryID   = strip_tags( $instance['categoryID'] );
		$other_number = strip_tags( $instance['other_number'] );
		$color        = strip_tags( $instance['color'] );
		$style        = strip_tags( $instance['style'] );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>"><?php echo esc_html__( 'Select Category', 'laveo' ) ?> </label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'categoryID' ) ); ?>">
				<?php $categories = get_categories();
				foreach ( $categories as $cat ) {
					if ( $categoryID == $cat->cat_ID ) {
						$selected = ' selected="selected"';
					} else {
						$selected = '';
					}
					$opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
					echo ent2ncr( $opt );
				} ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'other_number' ) ); ?>"><?php echo esc_html__( 'Total posts number', 'laveo' ) ?>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'other_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'other_number' ) ); ?>" value="<?php echo esc_attr( $other_number ); ?>"></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"><?php echo esc_html__( 'Color Scheme', 'laveo' ) ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>">
				<?php
				for ( $i = 1; $i <= 10; $i ++ ) {
					$color_name = 'color' . $i;
					if ( $color == $color_name ) {
						echo '<option value="color' . $i . '" selected="selected">Color' . $i . '</option>';
					} else {
						echo '<option value="color' . $i . '">Color' . $i . '</option>';
					}
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php echo esc_html__( 'Layout Style', 'laveo' ) ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
				<?php
				if ( $style == 'style1' ) {
					echo '<option value="style1" selected="selected">' . esc_html__( 'Style 1', 'laveo' ) . '</option>';
				} else {
					echo '<option value="style1">' . esc_html__( 'Style 1', 'laveo' ) . '</option>';
				}
				if ( $style == 'style2' ) {
					echo '<option value="style2" selected="selected">' . esc_html__( 'Style 2', 'laveo' ) . '</option>';
				} else {
					echo '<option value="style2">' . esc_html__( 'Style 2', 'laveo' ) . '</option>';
				}
				if ( $style == 'style3' ) {
					echo '<option value="style3" selected="selected">' . esc_html__( 'Style 3', 'laveo' ) . '</option>';
				} else {
					echo '<option value="style3">' . esc_html__( 'Style 3', 'laveo' ) . '</option>';
				}

				?>
			</select>
		</p>

		<?php
	}
}

register_widget( 'category_news' );


/********************************************************************
 * Recent comments with avatar
 ********************************************************************/
class recentCommentWidget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'recent-comments',
			'description'   => 'Recent comments with avatar',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'recentcommentwidget', 'Recent Comments', $widget_ops );
	}

	function widget( $args, $instance ) {
		// prints the widget
		global $wpdb;
		extract( $args, EXTR_SKIP );
		$title           = empty( $instance['title'] ) ? '&nbsp;' : apply_filters( 'widget_title', $instance['title'] );
		$number_comments = empty( $instance['number_comments'] ) ? '&nbsp;' : apply_filters( 'widget_number_comments', $instance['number_comments'] );
		$excerpt_length  = empty( $instance['excerpt_length'] ) ? '' : apply_filters( 'widget_excerpt_length', $instance['excerpt_length'] );
		$avatar_size     = empty( $instance['avatar_size'] ) ? '' : apply_filters( 'widget_avatar_size', $instance['avatar_size'] );

		$request = "SELECT ID, comment_ID, comment_content,
		comment_author, comment_author_url, comment_date,
		comment_author_email, comment_type, post_title FROM $wpdb->comments
		LEFT JOIN $wpdb->posts ON
		$wpdb->posts.ID=$wpdb->comments.comment_post_ID WHERE post_status IN
		('publish','static') ";
		$request .= "AND post_password ='' ";
		$request .= "AND comment_approved = '1' AND comment_type = '' ORDER
		BY comment_ID DESC LIMIT $number_comments";
		$comments = $wpdb->get_results( $request );
		$output   = '';
		if ( $comments ) {
			foreach ( $comments as $comment ) {
				$comment_author = stripslashes( $comment->comment_author );
				if ( $comment_author == "" ) {
					$comment_author = "anonymous";
				}
				$comment_content = strip_tags( $comment->comment_content );
				$comment_content = stripslashes( $comment_content );
//				$words           = split( " ", $comment_content );
//				$comment_excerpt = join( " ", array_slice( $words, 0, $excerpt_length ) );
				$comment_excerpt = explode( ' ', $comment_content, $excerpt_length );
				array_pop( $comment_excerpt );
				$comment_excerpt = implode( " ", $comment_excerpt );
				$permalink       = get_permalink( $comment->ID ) . "#comment-" . $comment->comment_ID;
				$post_title      = stripslashes( $comment->post_title );
				$url             = $comment->comment_author_url;
				$date            = mysql2date( 'd/m/Y', $comment->comment_date );
				if ( empty( $url ) || 'http://' == $url ) {
					$output .= '<li class="user_comments clear">' . get_avatar( $comment, $avatar_size ) . '<span>' . $comment_author . '</span>: <a href="' . $permalink . '">' . $comment_excerpt . ' ...</a></li>';
				} else {
					$output .= '<li	class="user_comments">' . get_avatar( $comment, $avatar_size ) . '<span>' . $comment_author . '</span>: <a href="' . $permalink . '">' . $comment_excerpt . '</a></li>';
				}
			}
			$output = convert_smilies( $output );
		} else {
			$output .= $before . "None found" . $after;
		}
		echo ent2ncr( $before_widget );
		if ( $title <> "" ) {
			echo ent2ncr( $before_title );
			echo esc_attr( $title );
			echo ent2ncr( $after_title );
		}
		echo '<ul>';
		echo ent2ncr( $output );
		echo '</ul>';
		echo ent2ncr( $after_widget );

	}

	function update( $new_instance, $old_instance ) {
		//save the widget
		$instance                    = $old_instance;
		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['number_comments'] = strip_tags( $new_instance['number_comments'] );
		$instance['excerpt_length']  = strip_tags( $new_instance['excerpt_length'] );
		$instance['avatar_size']     = strip_tags( $new_instance['avatar_size'] );

		return $instance;
	}

	function form( $instance ) {
		//widgetform in backend
		$instance        = wp_parse_args( (array) $instance, array(
			'title'           => 'Recent Comments',
			'number_comments' => '3',
			'excerpt_length'  => '10',
			'avatar_size'     => '40'
		) );
		$title           = strip_tags( $instance['title'] );
		$number_comments = strip_tags( $instance['number_comments'] );
		$excerpt_length  = strip_tags( $instance['excerpt_length'] );
		$avatar_size     = strip_tags( $instance['avatar_size'] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title', 'laveo' ) ?>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_comments' ) ); ?>"><?php echo esc_html__( 'Number Comments:', 'laveo' ) ?>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_comments' ) ); ?>" type="text" value="<?php echo esc_attr( $number_comments ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php echo esc_html__( 'Excerpt length:', 'laveo' ) ?>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="text" value="<?php echo esc_attr( $excerpt_length ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>"><?php echo esc_html__( 'Avatar Size:', 'laveo' ) ?>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar_size' ) ); ?>" type="text" value="<?php echo esc_attr( $avatar_size ); ?>" />
			</label>
		</p>

		<?php
	}
}

register_widget( 'recentCommentWidget' );


class img_gallery extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'     => 'gallery',
			'description'   => 'Images gallery',
			'panels_groups' => array( 'physcode_widget_group' )
		);
		parent::__construct( 'widget_img_gallery', 'Images Gallery', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$title      = empty( $instance['title'] ) ? '&nbsp;' : apply_filters( 'widget_title', $instance['title'] );
		echo ent2ncr( $before_widget );
		wp_enqueue_script( 'opacityrollover');
		wp_enqueue_script( 'galleriffic');
		?>
		<div class="gallery">
			<h3><?php echo esc_attr( $title ); ?></h3>
 			<div class="wrapper-gallery">
				<div id="gallery" class="content">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
						<?php $img_gallery = new WP_query();
						$img_gallery->query( 'showposts=6&cat=' . $categoryID ); ?>
						<?php while ( $img_gallery->have_posts() ) : $img_gallery->the_post(); ?>
							<li>
								<a class="thumb" href="<?php laveo_img_gallery( 390, 232 ) ?>" title="<?php the_title() ?>">
									<?php echo laveo_img( 120, 90 ) ?>
								</a>
							</li>
						<?php endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
 		</div>
		<?php
		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['categoryID'] = strip_tags( $new_instance['categoryID'] );
		$instance['title']      = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance   = wp_parse_args( (array) $instance, array(
			'title'      => 'Gallery',
			'categoryID' => ''
		) );
		$categoryID = strip_tags( $instance['categoryID'] );
		$title      = strip_tags( $instance['title'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Image gallery title', 'laveo' ) ?>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>"><?php echo esc_html__( 'Select Category', 'laveo' ) ?>
				<select name="<?php echo esc_attr( $this->get_field_name( 'categoryID' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'categoryID' ) ); ?>" style="width:170px">
					<?php $categories = get_categories();
					foreach ( $categories as $cat ) {
						if ( $categoryID == $cat->cat_ID ) {
							$selected = ' selected="selected"';
						} else {
							$selected = '';
						}
						$opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
						echo ent2ncr( $opt );
					} ?>
				</select>
		</p>

		<?php
	}
}

register_widget( 'img_gallery' );
?>