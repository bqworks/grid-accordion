<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	global $wpdb;			
	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	
	if ( $blog_ids !== false ) {
		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			bqw_grid_accordion_delete_all_data();
		}

		restore_current_blog();
	}
} else {
	bqw_grid_accordion_delete_all_data();
}

function bqw_grid_accordion_delete_all_data() {
	global $wpdb;
	$prefix = $wpdb->prefix;

	$accordions_table = $prefix . 'gridaccordion_accordions';
	$panels_table = $prefix . 'gridaccordion_panels';
	$layers_table = $prefix . 'gridaccordion_layers';

	$wpdb->query( "DROP TABLE $accordions_table, $panels_table, $layers_table" );

	delete_option( 'grid_accordion_custom_css' );
	delete_option( 'grid_accordion_custom_js' );
	delete_option( 'grid_accordion_is_custom_css' );
	delete_option( 'grid_accordion_is_custom_js' );
	delete_option( 'grid_accordion_load_stylesheets' );
	delete_option( 'grid_accordion_load_custom_css_js' );
	delete_option( 'grid_accordion_load_unminified_scripts' );
	delete_option( 'grid_accordion_purchase_code' );
	delete_option( 'grid_accordion_purchase_code_message' );
	delete_option( 'grid_accordion_purchase_code_status' );
	delete_option( 'grid_accordion_hide_inline_info' );
	delete_option( 'grid_accordion_hide_getting_started_info' );
	delete_option( 'grid_accordion_access' );
	delete_option( 'grid_accordion_version' );

	delete_transient( 'grid_accordion_post_names' );
	delete_transient( 'grid_accordion_posts_data' );
	delete_transient( 'grid_accordion_update_notification_message' );
	
	$wpdb->query( "DELETE FROM " . $prefix . "options WHERE option_name LIKE '%grid_accordion_cache%'" );
}