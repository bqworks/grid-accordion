<?php

/*
	Plugin Name: Grid Accordion
	Plugin URI:  https://bqworks.net/grid-accordion/
	Description: Responsive and touch-enabled grid accordion.
	Version:     1.9.11
	Author:      bqworks
	Author URI:  https://bqworks.net
*/

// if the file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'GRID_ACCORDION_DIR_PATH', plugin_dir_path( __FILE__ ) );

require_once( GRID_ACCORDION_DIR_PATH . 'public/class-grid-accordion.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-accordion-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-panel-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-panel-renderer-factory.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-dynamic-panel-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-posts-panel-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-gallery-panel-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-flickr-panel-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-layer-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-layer-renderer-factory.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-paragraph-layer-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-heading-layer-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-image-layer-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-div-layer-renderer.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'public/class-video-layer-renderer.php' );

require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-grid-accordion-activation.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-grid-accordion-widget.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-grid-accordion-settings.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-grid-accordion-validation.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-flickr.php' );
require_once( GRID_ACCORDION_DIR_PATH . 'includes/class-hideable-gallery.php' );

register_activation_hook( __FILE__, array( 'BQW_Grid_Accordion_Activation', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BQW_Grid_Accordion_Activation', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Activation', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_Hideable_Gallery', 'get_instance' ) );

// register the widget
add_action( 'widgets_init', 'bqw_ga_register_widget' );

// Gutenberg block
require_once( GRID_ACCORDION_DIR_PATH . 'gutenberg/class-grid-accordion-block.php' );
add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Block', 'get_instance' ) );

if ( is_admin() ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
	require_once( GRID_ACCORDION_DIR_PATH . 'admin/class-grid-accordion-admin.php' );
	require_once( GRID_ACCORDION_DIR_PATH . 'admin/class-grid-accordion-add-ons.php' );
	require_once( GRID_ACCORDION_DIR_PATH . 'admin/class-grid-accordion-updates.php' );
	add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Admin', 'get_instance' ) );
	add_action( 'plugins_loaded', array( 'BQW_Grid_Accordion_Add_Ons', 'get_instance' ) );
	add_action( 'admin_init', array( 'BQW_Grid_Accordion_Updates', 'get_instance' ) );
}