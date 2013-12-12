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

		$title        = apply_filters( 'widget_title', $instance['title'] );
		$post_type    = $instance['post_type'];
		$taxonomy     = $instance['taxonomy'];
		$term         = $instance['term'];
		$per_page     = $instance['per_page'];
		$offset       = $instance['offset'];
		$thumb        = $instance['thumb'];
		$thumb_width  = $instance['thumb_width'];
		$thumb_height = $instance['thumb_height'];
		$more         = $instance['more'];
		$meta         = $instance['meta'];
		$format       = $instance['format'];

		echo $before_widget;

		if ( $title ) :
			echo $before_title; ?>

			<h3><?php echo $title; ?></h3>

			<?php if ( $more ) : ?>
				<div class="widget-more hover-text">
					<?php _e( 'See All', 'shoestrap_nw' ); ?>
				</div>
				<a class="hover-link" href="<?php echo $morelink; ?>"></a>
			<?php endif;
			echo $after_title;
		endif;
		?>

		<div class="post-list list clearfix">
			<?php shoestrap_nw_posts_loop( $instance['post_type'], $instance['taxonomy'], $instance['term'], $instance['per_page'], $instance['offset'], $instance['format'], $instance['thumb'], $instance['thumb_width'], $instance['thumb_height'] ); ?>
		</div>
		<?php

		wp_reset_query();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip terms (if needed) and update the widget settings. */
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['post_type']    = strip_tags( $new_instance['post_type'] );
		$instance['taxonomy']     = strip_tags( $new_instance['taxonomy'] );
		$instance['term']         = strip_tags( $new_instance['term'] );
		$instance['per_page']     = strip_tags( $new_instance['per_page'] );
		$instance['offset']       = strip_tags( $new_instance['offset'] );
		$instance['thumb']        = isset( $new_instance['thumb'] );
		$instance['thumb_width']  = strip_tags( $new_instance['thumb_width'] );
		$instance['thumb_height'] = strip_tags( $new_instance['thumb_height'] );
		$instance['meta']         = isset( $new_instance['meta'] );
		$instance['more']         = isset( $new_instance['more'] );
		$instance['format']       = strip_tags( $new_instance['format'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array(
			'title'        => 'Latest Articles',
			'post_type'    => 'post',
			'taxonomy'     => 'category',
			'term'         => 'shoestrap_nw_all_terms',
			'per_page'     => 5,
			'offset'       => 0,
			'thumb'        => true,
			'thumb_width'  => 150,
			'thumb_height' => 100,
			'more'         => true,
			'meta'         => true,
			'overlay'      => false,
			'format'       => 'first'
		);

		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<?php _e( 'Title:','shoestrap_nw'); ?>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" /></td>

		<table style="margin-top: 10px;">
			<tr>
				<td><?php _e( 'Format:','shoestrap_nw'); ?></td>
				<td>
					<input class="radio" type="radio" <?php if($instance['format']=='small') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="small" id="<?php echo $this->get_field_id( 'format' ); ?>_small" /><?php _e( 'Small','shoestrap_nw'); ?>
					<br />
					<input class="radio" type="radio" <?php if($instance['format']=='large') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="large" id="<?php echo $this->get_field_id( 'format' ); ?>_large" /><?php _e( 'Large','shoestrap_nw'); ?>
					<br />
					<input class="radio" type="radio" <?php if($instance['format']=='first') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'format' ); ?>" value="first" id="<?php echo $this->get_field_id( 'format' ); ?>_first" /><?php _e( 'Large First Article','shoestrap_nw'); ?>
					<br />
				</td>
			</tr>

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

			<tr>
				<td colspan="2">
					<input class="checkbox" type="checkbox" <?php checked( isset( $instance['more'] ) ? $instance['more'] : 0  ); ?> id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" />
					<?php _e( 'Display "See All" link in header','shoestrap_nw'); ?>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumb']) ? $instance['thumb'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" />
					<?php _e( 'Display thumbs','shoestrap_nw'); ?>
				</td>
			</tr>

			<?php if ( $instance['thumb'] ) : ?>
				<tr>
					<td><?php _e( 'Thumbnail Width','shoestrap_nw'); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" type="number" /></td>
				</tr>

				<tr>
					<td><?php _e( 'Thumbnail Height','shoestrap_nw'); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo $instance['thumb_height']; ?>" type="number" /></td>
				</tr>
			<?php endif; ?>

			<tr>
				<td colspan="2">
					<input class="checkbox" type="checkbox" <?php checked(isset( $instance['meta']) ? $instance['meta'] : 0  ); ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />
					<?php _e( 'Display meta','shoestrap_nw'); ?>
				</td>
			</tr>
		</table>
		<?php
	}
}

function shoestrap_nw_posts_loop( $post_type = 'post', $taxonomy = '', $term = '', $posts_per_page = 5, $offset = 0, $format = 'titles', $thumb = false, $thumb_width = 150, $thumb_height = 100 ) {

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
				<a class="pull-left" href="<?php the_permalink(); ?>">
					<img class="media-object" src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>">
				</a>
			<?php endif; ?>
			<div class="media-body">
				<h4 class="media-heading"><?php the_title(); ?></h4>
				<?php the_excerpt(); ?>
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