<div class="breakpoints">
    <?php
        if ( isset( $accordion_settings['breakpoints'] ) ) {
            $breakpoints = $accordion_settings['breakpoints'];

            foreach ( $breakpoints as $breakpoint_settings ) {
                include( GRID_ACCORDION_DIR_PATH . 'admin/views/accordion/breakpoint.php' );
            }
        }
    ?>
</div>
<a class="button add-breakpoint" href="#"><?php _e( 'Add Breakpoint', 'grid-accordion' ); ?></a>
<?php
    $hide_info = get_option( 'grid_accordion_hide_inline_info' );

    if ( $hide_info != true ) {
?>
    <div class="inline-info breakpoints-info">
        <input type="checkbox" id="show-hide-breakpoint-info" class="show-hide-info">
        <label for="show-hide-breakpoint-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
        <label for="show-hide-breakpoint-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
        
        <div class="info-content">
            <p><?php _e( 'Breakpoints allow you to modify the look of the accordion for different window sizes.', 'grid-accordion' ); ?></p>
            <p><?php _e( 'Each breakpoint allows you to set the width of the window for which the breakpoint will apply, and then add several settings which will override the global settings.', 'grid-accordion' ); ?></p>
            <p><a href="https://bqworks.net/grid-accordion/screencasts/#working-with-breakpoints" target="_blank"><?php _e( 'See the video tutorial', 'grid-accordion' ); ?> &rarr;</a></p>
        </div>
    </div>
<?php
    }
?>