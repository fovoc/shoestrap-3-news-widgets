<?php

if ( !function_exists( 'shoestrap_nw_licensing' ) ) :
function shoestrap_nw_licensing($section) {
	$section['fields'][] = array( 
		'title'            => __( 'Shoestrap News Widgets Licence', 'shoestrap_nw' ),
		'id'              => 'shoestrap_nw_license_key',
		'default'         => '',
		'type'            => 'edd_license',
		'mode'            => 'plugin', // theme|plugin
		'path'            => S3NW_PLUGIN_FILE, // Path to the plugin/template main file
		'remote_api_url'  => 'http://shoestrap.org',    // our store URL that is running EDD
		'field_id'        => "shoestrap_license_key", // ID of the field used by EDD
	); 
	return $section;
}
endif;
add_filter( 'shoestrap_module_licencing_options_modifier', 'shoestrap_nw_licensing' );