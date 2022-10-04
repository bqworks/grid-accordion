<div class="wrap grid-accordion-admin">
	<h2><?php echo isset( $_GET['action'] ) && $_GET['action'] === 'edit' ? __( 'Edit Accordion', 'grid-accordion' ) : __( 'Add New Accordion', 'grid-accordion' ); ?></h2>

	<form action="" method="post">
    	<div class="metabox-holder has-right-sidebar">
            <div class="editor-wrapper">
                <div class="editor-body">
                    <div id="titlediv">
                    	<input name="name" id="title" type="text" value="<?php echo esc_attr( $accordion_name ); ?>" />
                    </div>
					
					<div class="panels-container">
                    	<?php
                    		if ( isset( $panels ) ) {
                    			if ( $panels !== false ) {
                    				foreach ( $panels as $panel ) {
                    					$this->create_panel( $panel );
                    				}
                    			}
                    		} else {
                    			$this->create_panel( false );
                    		}
	                    ?>
                    </div>

                    <div class="add-panel-group">
                        <a class="button add-panel" href="#"><?php _e( 'Add Panels', 'grid-accordion' ); ?> <span class="add-panel-arrow">&#9660</span></a>
                        <ul class="panel-type">
                            <li><a href="#" data-type="image"><?php _e( 'Image Panels', 'grid-accordion' ); ?></a></li>
                            <li><a href="#" data-type="posts"><?php _e( 'Posts Panels', 'grid-accordion' ); ?></a></li>
                            <li><a href="#" data-type="gallery"><?php _e( 'Gallery Panels', 'grid-accordion' ); ?></a></li>
                            <li><a href="#" data-type="flickr"><?php _e( 'Flickr Panels', 'grid-accordion' ); ?></a></li>
                            <li><a href="#" data-type="empty"><?php _e( 'Empty Panel', 'grid-accordion' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="inner-sidebar meta-box-sortables ui-sortable">
				<div class="postbox action">
					<div class="inside">
						<input type="submit" name="submit" class="button-primary" value="<?php echo isset( $_GET['action'] ) && $_GET['action'] === 'edit' ? __( 'Update', 'grid-accordion' ) : __( 'Create', 'grid-accordion' ); ?>" />
                        <span class="spinner update-spinner"></span>
						<a class="button preview-accordion" href="#"><?php _e( 'Preview', 'grid-accordion' ); ?></a>
                        <span class="spinner preview-spinner"></span>
					</div>
				</div>
                
                <div class="sidebar-settings">
                    <?php 
                        $settings_panels = BQW_Grid_Accordion_Settings::getAccordionSettingsPanels();
                        $default_panels_state = BQW_Grid_Accordion_Settings::getPanelsState();

                        foreach ( $settings_panels as $panel_name => $panel ) {
                            $panel_state_class = isset( $panels_state ) && isset( $panels_state[ $panel_name ] ) ? $panels_state[ $panel_name ] : ( isset( $default_panels_state[ $panel_name ] ) ? $default_panels_state[ $panel_name ] : 'closed' );
                    ?>
                            <div class="postbox <?php echo esc_attr( $panel_name . '-panel' ) . ' ' . esc_attr( $panel_state_class ); ?>" data-name="<?php echo esc_attr( $panel_name ); ?>">
                                <div class="handlediv"></div>
                                <h3 class="hndle"><?php echo esc_html( $panel['label'] ); ?></h3>
                                <div class="inside">
                                    <?php  include( $panel['renderer'] ); ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
	</form>
</div>