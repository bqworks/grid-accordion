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
                    <p><?php _e( '<i>Custom Content</i> panels allow you to manually specify the image(s), link and all the other data for the panel.', 'grid-accordion' ); ?></p>
                </div>
            </div>
        <?php
            }
        ?>
	</td>
</tr>