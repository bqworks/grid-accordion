<tr>
	<td class="label-cell">
		<label for="flickr-api-key"><?php _e( 'API Key', 'grid-accordion' ); ?>:</label>
	</td>
	<td class="setting-cell">
		<input id="flickr-api-key" class="panel-setting" type="text" name="flickr_api_key" value="<?php echo isset( $panel_settings['flickr_api_key'] ) ? esc_attr( $panel_settings['flickr_api_key'] ) : $panel_default_settings['flickr_api_key']['default_value']; ?>" />
	</td>
</tr>
<tr>
	<td class="label-cell">
		<label for="flickr-load-by"><?php _e( 'Load By', 'grid-accordion' ); ?>:</label>
	</td>
	<td class="setting-cell">
		<select id="flickr-load-by" class="panel-setting" name="flickr_load_by">
			<?php
				foreach ( $panel_default_settings['flickr_load_by']['available_values'] as $value_name => $value_label ) {
					$selected = ( isset( $panel_settings['flickr_load_by'] ) && $value_name === $panel_settings['flickr_load_by'] ) || ( ! isset( $panel_settings['flickr_load_by'] ) && $value_name === $panel_default_settings['flickr_load_by']['default_value'] ) ? ' selected="selected"' : '';
					echo '<option value="' . $value_name . '"' . $selected . '>' . $value_label . '</option>';
	            }
			?>
		</select>
	</td>
</tr>
<tr>
	<td class="label-cell">
		<label for="flickr-id"><?php _e( 'ID', 'grid-accordion' ); ?>:</label>
	</td>
	<td class="setting-cell">
		<input id="flickr-id" class="panel-setting" type="text" name="flickr_id" value="<?php echo isset( $panel_settings['flickr_id'] ) ? esc_attr( $panel_settings['flickr_id'] ) : $panel_default_settings['flickr_id']['default_value']; ?>" />
	</td>
</tr>
<tr>
	<td class="label-cell">
		<label for="flickr-limit"><?php _e( 'Limit', 'grid-accordion' ); ?>:</label>
	</td>
	<td class="setting-cell">
		<input id="flickr-limit" class="panel-setting" type="text" name="flickr_maximum" value="<?php echo isset( $panel_settings['flickr_per_page'] ) ? esc_attr( $panel_settings['flickr_per_page'] ) : $panel_default_settings['flickr_per_page']['default_value']; ?>" />
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php
            $hide_info = get_option( 'grid_accordion_hide_inline_info' );

            if ( $hide_info != true ) {
        ?>
            <div class="inline-info panel-settings-info">
            	<input type="checkbox" id="show-hide-info" class="show-hide-info">
				<label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
				<label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
				
				<div class="info-content">
            		<p><?php _e( 'One <i>Flickr</i> panel in the admin area will dynamically generate multiple panels in the published accordion (one panel for each Flickr image loaded), based on the set parameters.', 'grid-accordion' ); ?></p>
                	<p><?php _e( 'First, you need to request an API key', 'grid-accordion' ); ?> <a href="https://www.flickr.com/services/apps/create/apply/"><?php _e( 'here', 'grid-accordion' ); ?></a> <?php _e( 'and then specify it in the <i>API Key</i> field above.', 'grid-accordion' ); ?></p>
                	<p><?php _e( 'In the <i>ID</i> field you need to enter the id of the set or the id of the username, depending on the <i>Load by</i> selection.', 'grid-accordion' ); ?></p>
                	<p><?php _e( 'The images and their data can be fetched through <i>dynamic tags</i>, which are enumerated in the Background, Layers and HTML editors.', 'grid-accordion' ); ?></p>
            	</div>
            </div>
        <?php
            }
        ?>
	</td>
</tr>