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

include_once( S3NW_PLUGIN_DIR . 'includes/widget.posts-query.php' );
include_once( S3NW_PLUGIN_DIR . 'includes/functions.loop.php' );
include_once( S3NW_PLUGIN_DIR . 'includes/functions.excerpts.php' );
include_once( S3NW_PLUGIN_DIR . 'includes/class-Shoestrap_Image.php' );

function shoestrap_news_widgets() {
	register_widget( 'shoestrap_news_widget_latest_articles' );
}
add_action( 'widgets_init', 'shoestrap_news_widgets' );

/**
 * Enqueue styles
 */
function shoestrap_news_widgets_styles() {
	wp_enqueue_style( 'style', S3NW_PLUGIN_URL . 'assets/style.css' );
}

add_action( 'wp_enqueue_scripts', 'shoestrap_news_widgets_styles' );

/**
 * Enqueue admin script
 */
function shoestrap_news_widgets_admin_script() {
	wp_enqueue_script( 'script', S3NW_PLUGIN_URL . 'assets/script.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'shoestrap_news_widgets_admin_script' );