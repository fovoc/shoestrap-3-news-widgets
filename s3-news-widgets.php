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
if ( ! defined( 'S3NW_PLUGIN_URL' ) ) {
	define( 'S3NW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// plugin folder path
if ( ! defined( 'S3NW_PLUGIN_DIR' ) ) {
	define( 'S3NW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// plugin root file
if ( ! defined( 'S3NW_PLUGIN_FILE' ) ) {
	define( 'S3NW_PLUGIN_FILE', __FILE__ );
}

/**
 * Include plugin files
 */
function ssnw_include_files() {
	include_once( S3NW_PLUGIN_DIR . 'includes/widget.posts-query.php' );
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.loop.php' );
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.excerpts.php' );
}
add_action( 'shoestrap_include_files', 'ssnw_include_files' );

function shoestrap_news_widgets() {
	register_widget( 'shoestrap_news_widget_latest_articles' );
}
add_action( 'widgets_init', 'shoestrap_news_widgets' );
