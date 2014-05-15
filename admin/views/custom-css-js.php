<div class="wrap grid-accordion-admin">
	<h2><?php _e( 'Custom CSS and JavaScript', 'grid-accordion' ); ?></h2>
    
    <?php
        $show_info = get_option( 'grid_accordion_show_inline_info', true );

        if ( $show_info == true ) {
    ?>
        <div class="inline-info custom-css-js-info">
            <input type="checkbox" id="show-hide-info" class="show-hide-info">
            <label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
            <label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
            
            <div class="info-content">
                <p><?php _e( 'The fields below can be used for all your custom CSS or JavaScript code.', 'grid-accordion' ); ?></p>
                <p><?php _e( 'If you want to target a specific accordion, you need to assign a <i>Custom Class</i> to the accordion, in the accordion\'s settings, and then use that custom class in the <i>Custom CSS</i> or <i>Custom JavaScript</i> fields below.', 'grid-accordion' ); ?></p>
                <p><?php _e( 'By default, the custom CSS and JavaScript code will be loaded inline, but in the', 'grid-accordion' ); ?> <a href="<?php echo admin_url('admin.php?page=grid-accordion-settings') ?>"><?php _e( 'Plugin Settings', 'grid-accordion' ); ?></a> <?php _e( 'page you can set to load the code in files instead of inline.', 'grid-accordion' ); ?></p>
                <p><a href="https://www.youtube.com/watch?v=UUruvGnrIWk&list=PLh-6IaZNuPo7Skwefhb9T2CSazDjC56Lg" target="_blank"><?php _e( 'See the video tutorial', 'grid-accordion' ); ?> &rarr;</a></p>
            </div>
        </div>
    <?php
        }
    ?>

	<form action="" method="post">
        <?php wp_nonce_field( 'custom-css-js-update', 'custom-css-js-nonce' ); ?>

        <h3><?php _e( 'Custom CSS', 'grid-accordion' ); ?></h3>
        <textarea class="custom-css" name="custom_css" cols="80" rows="20"><?php echo isset( $custom_css ) ? stripslashes( esc_textarea( $custom_css ) ) : ''; ?></textarea>
        
        <input type="submit" name="custom_css_update" class="button-primary custom-css-js-update" value="Update CSS" />

        <h3><?php _e( 'Custom JavaScript', 'grid-accordion' ); ?></h3>
        <textarea class="custom-js" name="custom_js" cols="80" rows="20"><?php echo isset( $custom_js ) ? stripslashes( esc_textarea( $custom_js ) ) : ''; ?></textarea>

    	<input type="submit" name="custom_js_update" class="button-primary custom-css-js-update" value="Update JavaScript" />
	</form>
</div>