<?php
/*
 * Plugin Name: NG Sidebar Featured Image
 * Plugin URI: https://www.nosegraze.com
 * Description: Widget that displays the featured image of the current post.
 * Version: 1.0
 * Author: Nose Graze
 * Author URI: https://www.nosegraze.com
 * License: GPL2
 * 
 * @package ng-sidebar-featured-image
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license GPL2+
*/

// Include the widget.
include_once plugin_dir_path( __FILE__ ) . 'class-featured-image-widget.php';

// Register the widget with WordPress.
add_action( 'widgets_init', function(){
	register_widget( 'NG_Featured_Image_Widget' );
});
