<div class="modal-overlay"></div>
<div class="modal-window-container export-window">
	<div class="modal-window">
		<span class="close-x"></span>
		
		<textarea><?php echo isset( $export_string ) ? esc_textarea( $export_string ) : ''; ?></textarea>
        
        <?php
            $hide_info = get_option( 'grid_accordion_hide_inline_info' );

            if ( $hide_info != true ) {
        ?>
        		<div class="inline-info export-info">
                    <input type="checkbox" id="show-hide-info" class="show-hide-info">
                    <label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
                    <label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
                    
                    <div class="info-content">
                        <p><?php _e( 'The text above represents the data of the accordion. Please copy the text and then paste it in the import accordion window, by clicking on the <i>Import Accordion</i> button in the <i>Grid Accordion</i> installation where you want to import the accordion.', 'grid-accordion' ); ?></p>
                        <p><a href="http://bqworks.net/grid-accordion/screencasts/#import-export" target="_blank"><?php _e( 'See the video tutorial', 'grid-accordion' ); ?> &rarr;</a></p>
                    </div>
                </div>
        <?php
            }
        ?>
	</div>
</div>