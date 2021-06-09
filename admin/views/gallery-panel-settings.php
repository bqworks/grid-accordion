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
                    <p><?php _e( 'One <i>Gallery</i> panel in the admin area will dynamically generate multiple panels in the published accordion (one panel for each image from the <i>[gallery]</i> shortcode).', 'grid-accordion' ); ?></p>
                    <p><?php _e( 'You just need to drop the grid accordion shortcode in a post that contains a <i>[gallery]</i> shortcode, and the images from the <i>[gallery]</i> will automatically be loaded in the accordion. Then, if you want to hide the original gallery, you can add the <i>hide</i> attribute to the <i>[gallery]</i> shortcode: <i>[gallery ids="1,2,3" hide="true"]</i>.', 'grid-accordion' ); ?></p>
                    <p><?php _e( 'The images and their data can be fetched through <i>dynamic tags</i>, which are enumerated in the Background, Layers and HTML editors.', 'grid-accordion' ); ?></p>
                    <p><a href="http://bqworks.net/grid-accordion/screencasts/#accordion-from-gallery" target="_blank"><?php _e( 'See the video tutorial', 'grid-accordion' ); ?> &rarr;</a></p>
                </div>
            </div>
        <?php
            }
        ?>
	</td>
</tr>