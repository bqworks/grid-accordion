<div class="wrap grid-accordion-admin">
	<h2><?php _e( 'All Accordions' ); ?></h2>
	
	<?php
		$hide_info = get_option( 'grid_accordion_hide_getting_started_info' );

		if ( $hide_info != true ) {
	?>
	    <div class="inline-info getting-started-info">
			<h3><?php _e( '1. Getting started', 'grid-accordion' ); ?></h3>
			<p><?php _e( 'If you want to reproduce one of the examples showcased online, you can easily import those examples into your own Grid Accordion installation.', 'grid-accordion' ); ?></p>
			<p><?php _e( 'The examples can be found in the <i>examples</i> folder, which is included in the plugin\'s folder, and can be imported using the <i>Import Accordion</i> button below.', 'grid-accordion' ); ?></p>
			<p><?php _e( 'For quick usage instructions, please see the video tutorials below. For more detailed instructions, please see the', 'grid-accordion' ); ?> <a href="<?php echo admin_url('admin.php?page=grid-accordion-documentation'); ?>"><?php _e( 'Documentation', 'grid-accordion' ); ?></a> <?php _e( 'page.', 'grid-accordion' ); ?></p>
			<ul class="video-tutorials-list">
				<li><a href="https://www.youtube.com/watch?v=XqeHLv052Bc&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '1. Create and publish accordions', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=00SK6lwTlBg&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '2. Create accordions from posts', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=y1hr3PSJdGQ&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '3. Create accordions from galleries', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=T0gvsDDnzqw&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '4. Working with layers', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=UUruvGnrIWk&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '5. Adding custom CSS', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=4hJac-xPQ5M&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '6. Working with breakpoints', 'grid-accordion' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=HtLvqSPxVQE&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( '7. Import and Export accordions', 'grid-accordion' ); ?></a></li>
			</ul>

			<h3><?php _e( '2. Support', 'grid-accordion' ); ?></h3>
			<p><?php _e( 'When you need support, please contact us at our support center:', 'grid-accordion' ); ?> <a href="http://support.bqworks.com">support.bqworks.com</a>.</p>
			
			<?php
				$purchase_code_status = get_option( 'grid_accordion_purchase_code_status', '0' );

				if ( $purchase_code_status !== '1' ) {
			?>
					<h3><?php _e( '3. Updates', 'grid-accordion' ); ?></h3>
					<p><?php _e( 'In order to have access to automatic updates, please enter your purchase code', 'grid-accordion' ); ?> <a href="<?php echo admin_url('admin.php?page=grid-accordion-settings'); ?>"><?php _e( 'here', 'grid-accordion' ); ?></a>.</p>
			<?php
				}
			?>

			<a href="#" class="getting-started-close">Close</a>
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