<div class="wrap grid-accordion-admin plugin-settings">
	<h2><?php _e( 'Plugin Settings', 'grid-accordion' ); ?></h2>

	<form action="" method="post">
        <?php wp_nonce_field( 'plugin-settings-update', 'plugin-settings-nonce' ); ?>
        
        <table>
            <tr>
                <td>
                    <label for="load-stylesheets"><?php echo $plugin_settings['load_stylesheets']['label']; ?></label>
                </td>
                <td>
                    <select id="load-stylesheets" name="load_stylesheets">
                        <?php
                            foreach ( $plugin_settings['load_stylesheets']['available_values'] as $value_name => $value_label ) {
                                $selected = $value_name === $load_stylesheets ? ' selected="selected"' : '';
                                echo '<option value="' . $value_name . '"' . $selected . '>' . $value_label . '</option>';
                            }
                        ?>
                    </select>
                 </td>
                <td>
                    <?php echo $plugin_settings['load_stylesheets']['description']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="load-custom-css-js"><?php echo $plugin_settings['load_custom_css_js']['label']; ?></label>
                </td>
                <td>
                    <select id="load-custom-css-js" name="load_custom_css_js">
                        <?php
                            foreach ( $plugin_settings['load_custom_css_js']['available_values'] as $value_name => $value_label ) {
                                $selected = $value_name === $load_custom_css_js  ? ' selected="selected"' : '';
                                echo '<option value="' . $value_name . '"' . $selected . '>' . $value_label . '</option>';
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <?php echo $plugin_settings['load_custom_css_js']['description']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="load-unminified-scripts"><?php echo $plugin_settings['load_unminified_scripts']['label']; ?></label>
                </td>
                <td>
                    <input type="checkbox" id="load-unminified-scripts" name="load_unminified_scripts" <?php echo $load_unminified_scripts == true ? 'checked="checked"' : ''; ?>>
                </td>
                <td>
                    <?php echo $plugin_settings['load_unminified_scripts']['description']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="cache-expiry-interval"><?php echo $plugin_settings['cache_expiry_interval']['label']; ?></label>
                </td>
                <td>
                    <input type="text" id="cache-expiry-interval" name="cache_expiry_interval" value="<?php echo $cache_expiry_interval; ?>"><span>hours</span>
                </td>
                <td>
                    <?php echo $plugin_settings['cache_expiry_interval']['description']; ?>
                    <a class="button-secondary clear-all-cache" data-nonce="<?php echo wp_create_nonce( 'clear-all-cache' ); ?>"><?php _e( 'Clear all cache now', 'grid-accordion' ); ?></a>
                    <span class="spinner clear-cache-spinner"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="hide-inline-info"><?php echo $plugin_settings['hide_inline_info']['label']; ?></label>
                </td>
                <td>
                    <input type="checkbox" id="hide-inline-info" name="hide_inline_info" <?php echo $hide_inline_info == true ? 'checked="checked"' : ''; ?>>
                </td>
                <td>
                    <?php echo $plugin_settings['hide_inline_info']['description']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="hide-getting-started-info"><?php echo $plugin_settings['hide_getting_started_info']['label']; ?></label>
                </td>
                <td>
                    <input type="checkbox" id="hide-getting-started-info" name="hide_getting_started_info" <?php echo $hide_getting_started_info == true ? 'checked="checked"' : ''; ?>>
                </td>
                <td>
                    <?php echo $plugin_settings['hide_getting_started_info']['description']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="access"><?php echo $plugin_settings['access']['label']; ?></label>
                </td>
                <td>
                    <select id="access" name="access">
                        <?php
                            foreach ( $plugin_settings['access']['available_values'] as $value_name => $value_label ) {
                                $selected = $value_name === $access ? ' selected="selected"' : '';
                                echo '<option value="' . $value_name . '"' . $selected . '>' . $value_label . '</option>';
                            }
                        ?>
                    </select>
                 </td>
                <td>
                    <?php echo $plugin_settings['access']['description']; ?>
                </td>
            </tr>
        </table>

    	<input type="submit" name="plugin_settings_update" class="button-primary" value="Update Settings" />
	</form>

</div>