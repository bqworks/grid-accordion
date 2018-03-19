<?php

/*
	Plugin Name: Grid Accordion
	Plugin URI:  http://bqworks.com/grid-accordion/
	Description: Responsive and touch-enabled grid accordion.
	Version:     1.6.0
	Author:      bqworks
	Author URI:  http://bqworks.com
*/

// if the file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die();
}

require_once( plugin_dir_path( __FILE__ ) . 'public/class-grid-accordion.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-accordion-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-panel-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-panel-renderer-factory.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dynamic-panel-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-posts-panel-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-gallery-panel-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-flickr-panel-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-layer-renderer-factory.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-paragraph-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-heading-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-image-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-div-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-video-layer-renderer.php' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-grid-accordion-activation.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-grid-accordion-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-grid-accordion-settings.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-flickr.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-hideable-gallery.php' );

register_activation_hook( __FILE__, array( 'BQW_Grid_Accordion_Activation', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BQW_Grid_Accordion_Activation', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Activation', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_Hideable_Gallery', 'get_instance' ) );

// register the widget
add_action( 'widgets_init', 'bqw_ga_register_widget' );

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-grid-accordion-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-grid-accordion-updates.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-grid-accordion-api.php' );
	add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Admin', 'get_instance' ) );
	add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_API', 'get_instance' ) );
	add_action( 'admin_init', array( 'BQW_Grid_Accordion_Updates', 'get_instance' ) );
}