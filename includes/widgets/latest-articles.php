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

		$title    = apply_filters( 'widget_title', $instance['title'] );
		$category = $instance['category'];
		$tag      = $instance['tag'];
		$num      = $instance['num'];
		$thumb    = $instance['thumb'];
		$more     = $instance['more'];
		$meta     = $instance['meta'];
		$format   = $instance['format'];

		// Hack for the 'All Categories' option
		if ( $category == 'All Categories' ) :
			$category = '';
		endif;
		
		// Hack for the 'All Tags' option
		if ( $tag == 'All Tags' ) :
			$tag = '';
		endif;

		$more = false;
		$post_types = array( 'post' );

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
			<?php
				$args = array(
					'suppress_filters' => true,
					'posts_per_page'   => $num,
					'order'            => 'DESC',
					'order_by'         => 'date',
					'post_type'        => $post_types,
					'cat'              => $category,
					'tag_id'           => $tag,
				);

				$format = array(
					'thumb'  => $thumb,
					'meta'   => $meta,
					'format' => $format,
					'width'  => 349,
					'height' => 240,
					'size'   => 'grid-post',
					'title'  => 180
				);

				// The results here
			?>
		</div>
		<?php

		wp_reset_query();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['tag']      = strip_tags( $new_instance['tag'] );
		$instance['num']      = strip_tags( $new_instance['num'] );
		$instance['thumb']    = isset( $new_instance['thumb'] );
		$instance['meta']     = isset( $new_instance['meta'] );
		$instance['more']     = isset( $new_instance['more'] );
		$instance['format']   = strip_tags( $new_instance['format'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array(
			'title'    => 'Latest Articles',
			'category' => 'All Categories',
			'tag'      => 'All Tags',
			'num'      => 5,
			'thumb'    => true,
			'more'     => true,
			'meta'     => true,
			'overlay'  => false,
			'format'   => 'first'
		);

		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<table class="shoestrap_3_news_widget_settings_table">
			<tr>
				<td><?php _e( 'Title:','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" /></td>
			</tr>

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
				<td><?php _e( 'Category:','shoestrap_nw'); ?></td>
				<td>
					<select name="<?php echo $this->get_field_name( 'category' ); ?>">
						<?php $selected = ( $instance['category'] == 'All Categories' ) ? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="All Categories"><?php _e( 'All Categories', 'shoestrap_nw' ); ?></option>
						<?php
							$category_args = array(
								'orderby'    => 'name',
								'order'      => 'ASC',
								'hide_empty' => 0
							);

							$categories = get_categories( $category_args );
							foreach ( $categories as $category ) :
								$selected = ( $instance['category'] == $category->term_id ) ? 'selected' : ''; ?>

								<option <?php echo $selected; ?> value="<?php echo $category->term_id; ?>">
									<?php echo $category->name; ?>
								</option>
							<?php endforeach;
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td><?php _e( 'Tag:','shoestrap_nw'); ?></td>
				<td>
					<select name="<?php echo $this->get_field_name( 'tag' ); ?>">
						<?php $selected = ( $instance['tag'] == 'All Tags' ) ? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="All Tags"><?php _e( 'All Tags', 'shoestrap_nw' ); ?></option>
						<?php
							$tags_args = array(
								'orderby'    => 'name',
								'order'      => 'ASC',
								'hide_empty' => 0
							);

							$tags = get_tags( $tags_args );

							foreach ( $tags as $tag ) : ?>
								<?php $selected = ( $instance['tag']==$tag->term_id ) ? 'selected' : ''; ?>
								<option <?php echo $selected; ?> value="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></option>
							<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<tr>
				<td><?php _e( 'Number of Articles to display','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>"/></td>
			</tr>

			<tr>
				<td><?php _e( 'Display "See All" link in header','shoestrap_nw'); ?></td>
				<td><input class="checkbox" type="checkbox" <?php checked( isset( $instance['more'] ) ? $instance['more'] : 0  ); ?> id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Display thumbs','shoestrap_nw'); ?></td>
				<td><input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumb']) ? $instance['thumb'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Display meta','shoestrap_nw'); ?></td>
				<td><input class="checkbox" type="checkbox" <?php checked(isset( $instance['meta']) ? $instance['meta'] : 0  ); ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" /></td>
			</tr>
		</table>
		<?php
	}
}