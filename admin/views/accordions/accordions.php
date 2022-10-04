<div class="wrap grid-accordion-admin">
	<h2><?php _e( 'All Accordions' ); ?></h2>
	
	<?php
		$hide_info = get_option( 'grid_accordion_hide_getting_started_info' );

		if ( $hide_info != true ) {
	?>
	    <div class="inline-info getting-started-info">
			<div class="inline-info-section">
				<h3><?php _e( 'Getting started', 'grid-accordion' ); ?></h3>
				<p><?php _e( 'If you want to reproduce one of the examples showcased online, you can easily import those examples into your own Grid Accordion installation.', 'grid-accordion' ); ?></p>
				<p><?php _e( 'The examples can be found in the <i>examples</i> folder, which is included in the plugin\'s folder, and can be imported using the <i>Import Accordion</i> button below.', 'grid-accordion' ); ?></p>
				<p><?php _e( 'For quick usage instructions, please see the video tutorials below. For more detailed instructions, please see the', 'grid-accordion' ); ?> <a href="https://bqworks.net/grid-accordion/documentation/documentation.html"><?php _e( 'Documentation', 'grid-accordion' ); ?></a> <?php _e( 'page.', 'grid-accordion' ); ?></p>
				<ul class="video-tutorials-list">
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#simple-accordion" target="_blank"><?php _e( '1. Create and publish accordions', 'grid-accordion' ); ?></a></li>
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#accordion-from-posts" target="_blank"><?php _e( '2. Create accordions from posts', 'grid-accordion' ); ?></a></li>
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#accordion-from-gallery" target="_blank"><?php _e( '3. Create accordions from galleries', 'grid-accordion' ); ?></a></li>
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#working-with-layers" target="_blank"><?php _e( '4. Working with layers', 'grid-accordion' ); ?></a></li>
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#working-with-breakpoints" target="_blank"><?php _e( '5. Working with breakpoints', 'grid-accordion' ); ?></a></li>
					<li><a href="https://bqworks.net/grid-accordion/screencasts/#import-export" target="_blank"><?php _e( '6. Import and Export accordions', 'grid-accordion' ); ?></a></li>
				</ul>
			</div>
			<div class="inline-info-section">
				<h3><?php _e( 'Add-ons', 'grid-accordion' ); ?></h3>
				<p><?php printf( __( 'You can extend the functionality of the plugin with the use of add-ons. By acquiring <a href="%s">premium add-ons</a>, you also support the development of the plugin.', 'grid-accordion' ), admin_url('admin.php?page=grid-accordion-add-ons') ); ?></p>
			</div>
			<div class="inline-info-section">
				<h3><?php _e( 'Support', 'grid-accordion' ); ?></h3>
				<p><?php printf( __( 'If you need assistance with using the plugin, you can ask in the <a href="%s">plugin\'s public forum</a>. Private and priority support is available for users that have at least one valid add-on license.', 'grid-accordion' ), 'https://wordpress.org/support/plugin/grid-accordion/' ); ?></p>
			</div>
			<a href="#" class="getting-started-close">Close</a>
		</div>
	<?php
		}
		if ( ( get_option( 'grid_accordion_is_custom_css') == true || get_option( 'grid_accordion_is_custom_js') == true ) && get_option( 'grid_accordion_hide_custom_css_js_warning' ) != true ) {
	?>
		<div class="custom-css-js-warning">
			<h3><?php _e( 'Custom CSS & JS', 'grid-accordion' ); ?></h3>
			<p><?php _e( 'Your grid accordions contain custom CSS and/or JavaScript. The built-in CSS & JS editor was removed, but an add-on was created instead, with new features for working with custom code.', 'grid-accordion' )?></p>
			<?php
			if ( get_option( 'grid_accordion_is_custom_css') == true ) {
			?>
			<div class="custom-css-js-warning-code">
				<h4> <?php _e( 'Custom CSS', 'grid-accordion' ); ?></h4>
				<textarea><?php echo stripslashes( get_option( 'grid_accordion_custom_css' ) ); ?></textarea>
			</div>
			<?php
			}

			if ( get_option( 'grid_accordion_is_custom_js') == true ) {
			?>
			<div class="custom-css-js-warning-code">
				<h4><?php _e( 'Custom JS', 'grid-accordion' ); ?></h4>
				<textarea><?php echo stripslashes( get_option( 'grid_accordion_custom_js' ) ); ?></textarea>
			</div>
			<?php
			}
			?>
			<a href="#" class="custom-css-js-warning-close"><?php _e( 'Delete the custom CSS & JS, and remove this note.', 'grid-accordion' ); ?></a>
		</div>
	<?php
		}
	?>

	<table class="widefat accordions-list">
	<thead>
	<tr>
		<th><?php _e( 'ID', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Name', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Shortcode', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Created', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Modified', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Actions', 'grid-accordion' ); ?></th>
	</tr>
	</thead>
	
	<tbody>
		
	<?php
		global $wpdb;
		$prefix = $wpdb->prefix;

		$accordions = $wpdb->get_results( "SELECT * FROM " . $prefix . "gridaccordion_accordions ORDER BY id" );
		
		if ( count( $accordions ) === 0 ) {
			echo '<tr class="no-accordion-row">' .
					 '<td colspan="100%">' . __( 'You don\'t have saved accordions.', 'grid-accordion' ) . '</td>' .
				 '</tr>';
		} else {
			foreach ( $accordions as $accordion ) {
				$accordion_id = $accordion->id;
				$accordion_name = stripslashes( $accordion->name );
				$accordion_created = $accordion->created;
				$accordion_modified = $accordion->modified;

				include( 'accordions-row.php' );
			}
		}
	?>

	</tbody>
	
	<tfoot>
	<tr>
		<th><?php _e( 'ID', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Name', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Shortcode', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Created', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Modified', 'grid-accordion' ); ?></th>
		<th><?php _e( 'Actions', 'grid-accordion' ); ?></th>
	</tr>
	</tfoot>
	</table>
    
    <div class="new-accordion-buttons">    
		<a class="button-secondary" href="<?php echo admin_url( 'admin.php?page=grid-accordion-new' ); ?>"><?php _e( 'Create New Accordion', 'grid-accordion' ); ?></a>
        <a class="button-secondary import-accordion" href=""><?php _e( 'Import Accordion', 'grid-accordion' ); ?></a>
    </div>    
    
</div>