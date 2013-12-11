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
endif;