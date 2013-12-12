<?php
/*
Plugin Name: Shoestrap 3 News Widgets
Plugin URI: http://wpmu.io
Description: Adds some extra widgets, primarily useful for News Sites.
Version: 0.1
Author: Aristeides Stathopoulos
Author URI:  http://aristeides.com
*/

// plugin folder url
if ( !defined( 'S3NW_PLUGIN_URL' ) ) :
	define( 'S3NW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
endif;

// plugin folder path
if ( !defined( 'S3NW_PLUGIN_DIR' ) ) :
	define( 'S3NW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
endif;

// plugin root file
if ( !defined( 'S3NW_PLUGIN_FILE' ) ) :
	define( 'S3NW_PLUGIN_FILE', __FILE__ );
endif;

if ( file_exists( get_template_directory() . '/lib/modules/load.modules.php' ) ) :
	require_once get_template_directory() . '/lib/modules/load.modules.php';
	include_once( S3NW_PLUGIN_DIR . 'includes/widget.posts-query.php' );
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.loop.php' );
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.excerpts.php' );
endif;

// Include the resizing script ig it's not already loaded
if ( !function_exists( 'matthewruddy_image_resize' ) ) :
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.resize.php' );
endif;

function shoestrap_news_widgets() {
	register_widget( 'shoestrap_news_widget_latest_articles' );
}
add_action( 'widgets_init', 'shoestrap_news_widgets' );
