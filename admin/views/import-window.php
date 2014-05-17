<div class="modal-overlay"></div>
<div class="modal-window-container import-window">
	<div class="modal-window">
		<span class="close-x"></span>
		
		<textarea></textarea>

		<div class="buttons ga-clearfix">
			<a class="button-secondary save" href="#"><?php _e( 'Import', 'grid-accordion' ); ?></a>
		</div>
		
		<?php
            $hide_info = get_option( 'grid_accordion_hide_inline_info' );

            if ( $hide_info != true ) {
        ?>
				<div class="inline-info import-info">
		            <input type="checkbox" id="show-hide-info" class="show-hide-info">
		            <label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
		            <label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
		            
		            <div class="info-content">
		                <p><?php _e( 'In the field above you need to copy the new accordion\'s data, as it was exported. Then, click in the <i>Import</i> button.', 'grid-accordion' ); ?></p>
		            	<p><a href="https://www.youtube.com/watch?v=HtLvqSPxVQE&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( 'See the video tutorial', 'grid-accordion' ); ?> &rarr;</a></p>
		            </div>
		        </div>
		<?php
            }
        ?>
	</div>
</div>