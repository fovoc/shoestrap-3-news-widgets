<?php


class shoestrap_news_widget_latest_articles extends WP_Widget {
	function shoestrap_news_widget_latest_articles() {
		
		$widget_ops = array(
			'classname'   => 'S3 Latest Articles',
			'description' => ''
		);

		$control_ops = array(
			'width'   => 250,
			'height'  => 350,
			'id_base' => 'shoestrap_news_widget_latest_articles'
		);

		$this->WP_Widget(
			'shoestrap_news_widget_latest_articles',
			'S3 Latest Articles',
			$widget_ops,
			$control_ops
		);
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title           = apply_filters( 'widget_title', $instance['title'] );
		$post_type       = $instance['post_type'];
		$taxonomy        = $instance['taxonomy'];
		$term            = $instance['term'];
		$per_page        = $instance['per_page'];
		$offset          = $instance['offset'];
		$thumb           = $instance['thumb'];
		$thumb_float     = $instance['thumb_float'];
		$thumb_width     = $instance['thumb_width'];
		$thumb_height    = $instance['thumb_height'];
		$excerpt_length  = $instance['excerpt_length'];
		$more_text       = $instance['more_text'];
		$post_title_size = $instance['post_title_size'];

		echo $before_widget;

		if ( $title ) :
			echo $before_title; ?>

			<h3><?php echo $title; ?></h3>

			<?php echo $after_title;
		endif;
		?>

		<div class="post-list list clearfix">
			<?php
				// Call our custom Loop Function and pass all the arguments from the widget options.

				shoestrap_nw_posts_loop(
					$instance['post_type'],
					$instance['taxonomy'],
					$instance['term'],
					$instance['per_page'],
					$instance['offset'],
					$instance['thumb'],
					$instance['thumb_float'],
					$instance['thumb_width'],
					$instance['thumb_height'],
					$instance['excerpt_length'],
					$instance['more_text'],
					$instance['post_title_size']
				);
			?>
		</div>
		<?php wp_reset_query(); ?>
		<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip terms (if needed) and update the widget settings. */
		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['post_type']       = strip_tags( $new_instance['post_type'] );
		$instance['taxonomy']        = strip_tags( $new_instance['taxonomy'] );
		$instance['term']            = strip_tags( $new_instance['term'] );
		$instance['per_page']        = strip_tags( $new_instance['per_page'] );
		$instance['offset']          = strip_tags( $new_instance['offset'] );
		$instance['thumb']           = isset( $new_instance['thumb'] );
		$instance['thumb_float']     = isset( $new_instance['thumb_float'] );
		$instance['thumb_width']     = strip_tags( $new_instance['thumb_width'] );
		$instance['thumb_height']    = strip_tags( $new_instance['thumb_height'] );
		$instance['excerpt_length']  = strip_tags( $new_instance['excerpt_length'] );
		$instance['more_text']       = strip_tags( $new_instance['more_text'] );
		$instance['post_title_size'] = strip_tags( $new_instance['post_title_size'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array(
			'title'           => 'Latest Articles',
			'post_type'       => 'post',
			'taxonomy'        => 'category',
			'term'            => 'shoestrap_nw_all_terms',
			'per_page'        => 5,
			'offset'          => 0,
			'thumb'           => true,
			'thumb_float'     => 1,
			'thumb_width'     => 150,
			'thumb_height'    => 100,
			'excerpt_length'  => 20,
			'more_text'       => __( 'Read More', 'shoestrap_nw' ),
			'post_title_size' => 'h4'
		);

		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<?php _e( 'Title:','shoestrap_nw'); ?>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" /></td>

		<table style="margin-top: 10px;">
			<tr>
				<td><?php _e( 'Post Type:','shoestrap_nw'); ?></td>
				<td>
					<select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
						<?php $post_types = get_post_types( array( 'public' => true, ), 'names' ); ?>
						<?php foreach ( $post_types as $post_type ) : ?>
							<?php $selected = ( $instance['post_type'] == $post_type ) ? 'selected' : ''; ?>
							<option <?php echo $selected; ?> value="<?php echo $post_type; ?>">
								<?php echo $post_type; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<?php $taxonomies = get_object_taxonomies( $instance['post_type'], 'objects' ); ?>
			<?php if ( $taxonomies ) : ?>
				<tr>
					<td><?php _e( 'Taxonomy:','shoestrap_nw'); ?></td>
					<td>
						<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
							<?php foreach ( $taxonomies as $taxonomy ) : ?>
								<?php $selected = ( $instance['taxonomy'] == $taxonomy->name ) ? 'selected' : ''; ?>
								<option <?php echo $selected; ?> value="<?php echo $taxonomy->name; ?>">
									<?php echo $taxonomy->name; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>

				<tr>
					<td><?php _e( 'Term:','shoestrap_nw' ); ?></td>
					<td>
						<select name="<?php echo $this->get_field_name( 'term' ); ?>">
							<?php $selected = ( $instance['term'] == 'shoestrap_nw_all_terms' ) ? 'selected' : ''; ?>
							<option <?php echo $selected; ?> value="shoestrap_nw_all_terms"><?php _e( 'All Terms', 'shoestrap_nw' ); ?></option>
							<?php
								$terms_args = array(
									'orderby'    => 'name',
									'order'      => 'ASC',
									'hide_empty' => 0
								);

								$terms = get_terms( $instance['taxonomy'], $terms_args );

								foreach ( $terms as $term ) : ?>
									<?php $selected = ( $instance['term']==$term->term_id ) ? 'selected' : ''; ?>
									<option <?php echo $selected; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
								<?php endforeach; ?>
						</select>
					</td>
				</tr>
			<?php endif; ?>

			<tr>
				<td><?php _e( 'Number of Posts to display','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'per_page' ); ?>" value="<?php echo $instance['per_page']; ?>" type="number" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Offset','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo $instance['offset']; ?>" type="number" /></td>
			</tr>

			<tr style="margin: 10px 0;">
				<td><?php _e( 'Post Title Size:','shoestrap_nw'); ?></td>
				<td>
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h3') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h3" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h3" />
					<?php _e( 'Large (H3)', 'shoestrap_nw' ); ?>
					<br />
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h4') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h4" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h4" />
					<?php _e( 'Normal (H4)', 'shoestrap_nw' ); ?>
					<br />
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h5') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h5" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h5" />
					<?php _e( 'Small (H5)', 'shoestrap_nw' ); ?>
					<br />
			</tr>

			<tr>
				<td><?php _e( 'Excerpt Length','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" value="<?php echo $instance['excerpt_length']; ?>" type="number" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Read More text:','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo $instance['more_text']; ?>" class="widefat" type="text" /></td>
			</tr>

			<tr>
				<td colspan="2">
					<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumb']) ? $instance['thumb'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" />
					<?php _e( 'Display thumbs','shoestrap_nw'); ?>
				</td>
			</tr>

			<?php if ( $instance['thumb'] ) : ?>

				<tr>
					<td colspan="2">
						<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumb_float']) ? $instance['thumb_float'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb_float' ); ?>" name="<?php echo $this->get_field_name( 'thumb_float' ); ?>" />
						<?php _e( 'Float Tumbnails Left','shoestrap_nw'); ?>
					</td>
				</tr>

				<tr>
					<td><?php _e( 'Thumbnail Width','shoestrap_nw'); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" type="number" /></td>
				</tr>

				<tr>
					<td><?php _e( 'Thumbnail Height','shoestrap_nw'); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo $instance['thumb_height']; ?>" type="number" /></td>
				</tr>
			<?php endif; ?>

		</table>
		<?php
	}
}

function shoestrap_nw_posts_loop( $post_type = 'post', $taxonomy = '', $term = '', $posts_per_page = 5, $offset = 0, $thumb = false, $thumb_float = true, $thumb_width = 150, $thumb_height = 100, $excerpt_length = 20, $read_more_text = '...', $post_title_size = 'h4' ) {

	// Set-Up the taxonomy query
	if ( $term != 'shoestrap_nw_all_terms' ) :
		$tax_query = array( array(
			'taxonomy' => $taxonomy,
			'field'    => 'id',
			'terms'    => array( $term ),
		) );
	else :
		$tax_query = '';
	endif;

	// Start the arguments
	$args = array(
		'post_type'      => $post_type,
		'tax_query'      => $tax_query,
		'taxonomy'       => $taxonomy,
		'terms'          => $term,
		'posts_per_page' => $posts_per_page,
		'offset'         => $offset,
	);

	$thumb_class = ( $thumb_float ) ? 'class="pull-left"' : '';

	// The Query
	$the_query = new WP_Query( $args );

	// The Loop
	$i = 0;
	while ( $the_query->have_posts() ) : $i++;
		$the_query->the_post();

		$image_args['width']  = $thumb_width;
		$image_args['url']    = wp_get_attachment_url( get_post_thumbnail_id() );
		$image_args['height'] = $thumb_height;

		$image = shoestrap_image_resize( $image_args );
		?>

		<div class="media">
			<?php if ( $thumb && has_post_thumbnail() ) : ?>
				<?php if ( !$thumb_float ) : ?>
					<div class="media-body">
						<a href="<?php the_permalink(); ?>">
							<?php if ( $post_title_size == 'h3' ) : ?>
								<h3 class="media-heading">
							<?php elseif ( $post_title_size == 'h4' ) : ?>
								<h4 class="media-heading">
							<?php else : ?>
								<strong class="media-heading">
							<?php endif; ?>
								<?php the_title(); ?></h4>
							<?php if ( $post_title_size == 'h3' ) : ?>
								</h3>
							<?php elseif ( $post_title_size == 'h4' ) : ?>
								</h4>
							<?php else : ?>
								</strong><br />
							<?php endif; ?>
						</a>
				<?php endif; ?>
				<a <?php echo $thumb_class; ?> href="<?php the_permalink(); ?>">
					<img class="media-object" src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>">
				</a>
			<?php endif; ?>
			<?php if ( $thumb && has_post_thumbnail() && !$thumb_float ) : ?>
				<?php echo shoestrap_nw_excerpt( $excerpt_length, $read_more_text ); ?>
			<?php else : ?>
				<div class="media-body">
					<a href="<?php the_permalink(); ?>">
						<?php if ( $post_title_size == 'h3' ) : ?>
							<h3 class="media-heading">
						<?php elseif ( $post_title_size == 'h4' ) : ?>
							<h4 class="media-heading">
						<?php else : ?>
							<strong class="media-heading">
						<?php endif; ?>
							<?php the_title(); ?></h4>
						<?php if ( $post_title_size == 'h3' ) : ?>
							</h3>
						<?php elseif ( $post_title_size == 'h4' ) : ?>
							</h4>
						<?php else : ?>
							</strong><br />
						<?php endif; ?>
					</a>
					<?php echo shoestrap_nw_excerpt( $excerpt_length, $read_more_text ); ?>
			<?php endif; ?>
			</div>
		</div>
		<?php
	endwhile;

	/* Restore original Post Data 
	 * NB: Because we are using new WP_Query we aren't stomping on the 
	 * original $wp_query and it does not need to be reset.
	*/
	wp_reset_postdata();
}


function shoestrap_nw_excerpt( $limit = 20, $read_more_text ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) :
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . ' <a href="' . get_post_permalink() . '">' . $read_more_text . '</a>';
	else :
		$excerpt = implode( ' ', $excerpt );
	endif;

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
	return $excerpt;
}

function shoestrap_nw_content( $limit, $read_more_text ) {
	$content = explode( ' ', get_the_content(), $limit );

	if ( count( $content ) >= $limit ) :
		array_pop( $content );
		$content = implode( ' ', $content ) . ' <a href="' . get_post_permalink() . '">' . $read_more_text . '</a>';
	else :
		$content = implode( ' ', $content );
	endif;

	$content = preg_replace( '/\[.+\]/', '', $content );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	return $content;
}