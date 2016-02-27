<?php

/**
 * Set up for the featured image widget.
 *
 * @package   ng-sidebar-featured-image
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class NG_Featured_Image_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {

		parent::__construct(
			'ng_featured_image_widget', // Base ID
			__( 'NG Featured Image', 'ng-featured-image-widget' ), // Name
			array( 'description' => __( 'Displays the featured image of the current post.', 'ng-featured-image-widget' ), ) // Args
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see    WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function widget( $args, $instance ) {

		// If we're not on a single post, bail.
		if ( ! is_single() || get_post_type() != 'post' ) {
			return;
		}

		// If the current post doesn't have a featured image, bail.
		if ( ! has_post_thumbnail() ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		the_post_thumbnail( strip_tags( $instance['size'] ) );

		echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see    WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function form( $instance ) {
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$size          = ! empty( $instance['size'] ) ? $instance['size'] : 'full';
		$allowed_sizes = $this->get_sizes();
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ng-featured-image-widget' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image Size:', 'ng-featured-image-widget' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<?php foreach ( $allowed_sizes as $value => $name ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $size, $value ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['size']  = ( ! empty( $new_instance['size'] ) && array_key_exists( $new_instance['size'], $this->get_sizes() ) ) ? strip_tags( $new_instance['size'] ) : 'full';

		return $instance;
	}

	/**
	 * Get valid thumbnail sizes.
	 *
	 * @access public
	 * @since  1.0
	 * @return array
	 */
	public function get_sizes() {
		$sizes = array(
			'thumbnail' => __( 'Thumbnail', 'ng-featured-image-widget' ),
			'medium'    => __( 'Medium', 'ng-featured-image-widget' ),
			'large'     => __( 'Large', 'ng-featured-image-widget' ),
			'full'      => __( 'Full', 'ng-featured-image-widget' )
		);

		return apply_filters( 'ng-featured-image-widget/image-sizes', $sizes );
	}

}
