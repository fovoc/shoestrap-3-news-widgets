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
		$taxonomy = $instance['taxonomy'];
		$term      = $instance['term'];
		$num      = $instance['num'];
		$thumb    = $instance['thumb'];
		$more     = $instance['more'];
		$meta     = $instance['meta'];
		$format   = $instance['format'];

		// Hack for the 'All Categories' option
		if ( $taxonomy == 'All Categories' ) :
			$taxonomy = '';
		endif;
		
		// Hack for the 'All Tags' option
		if ( $term == 'All Tags' ) :
			$term = '';
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
					'cat'              => $taxonomy,
					'term_id'           => $term,
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

		/* Strip terms (if needed) and update the widget settings. */
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );
		$instance['term']     = strip_tags( $new_instance['term'] );
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
			'taxonomy' => 'category',
			'term'     => 'shoestrap_nw_all_terms',
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
				<td><?php _e( 'Taxonomy:','shoestrap_nw'); ?></td>
				<td>
					<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
						<?php $taxonomies = get_taxonomies( array( 'public' => true ), 'objects' ); ?>
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

			<tr>
				<td><?php _e( 'Number of Articles to display','shoestrap_nw'); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>"/></td>
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

function shoestrap_nw_posts_loop() {

}