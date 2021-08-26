<?php
/**
 * Contains the validation functions for the grid accordion settings, panels, layers etc.
 * 
 * @since 1.8.0
 */
class BQW_Grid_Accordion_Validation {

	/**
	 * Validate the grid accordion's data and other saved data.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted grid accordion data.
	 * @return array       Validated grid accordion data.
	 */
	public static function validate_saved_data( $data ) {
		$sanitized_data = array(
			'nonce' => $data['nonce'],
			'action' => sanitize_text_field( $data['name'] ),
			'accordion_data' => self::validate_grid_accordion_data( $data )
		);

		return $sanitized_data;
	}

	/**
	 * Validate the grid accordion's data.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted grid accordion data.
	 * @return array       Validated grid accordion data.
	 */
	public static function validate_grid_accordion_data( $data ) {
		$accordion = array(
			'id' => intval( $data['id'] ),
			'name' => sanitize_text_field( $data['name'] ),
			'panels_state' => self::validate_grid_accordion_panels_state( $data['panels_state'] ),
			'settings' => self::validate_grid_accordion_settings( $data['settings'] ),
			'panels' => self::validate_grid_accordion_panels( $data['panels'] )
		);

		return $accordion;
	}

	/**
	 * Validate the grid accordion's panels state.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted grid accordion panels state.
	 * @return array       Validated grid accordion panels state.
	 */
	public static function validate_grid_accordion_panels_state( $data ) {
		$grid_accordion_panels_state = array();
		$default_panels_state = BQW_Grid_Accordion_Settings::getPanelsState();

		foreach ( $data as $panel_name => $panel_state) {
			if ( array_key_exists( $panel_name, $default_panels_state ) ) {
				$grid_accordion_panels_state[ $panel_name ] = ( $panel_state === 'closed' || $panel_state === '' ) ? $panel_state : 'closed';
			}
		}

		return $grid_accordion_panels_state;
	}

	/**
	 * Validate the grid accordion's settings.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted grid accordion settings.
	 * @return array       Validated grid accordion settings.
	 */
	public static function validate_grid_accordion_settings( $data ) {
		$grid_accordion_settings = array();
		$default_grid_accordion_settings = BQW_Grid_Accordion_Settings::getSettings();
		
		foreach ( $default_grid_accordion_settings as $name => $value ) {
			if ( isset( $data[ $name ] ) ) {
				$setting_value = $data[ $name ];
				$type = $default_grid_accordion_settings[ $name ][ 'type' ];

				if ( $type === 'boolean' ) {
					$grid_accordion_settings[ $name ] = is_bool( $setting_value ) ? $setting_value : $default_grid_accordion_settings[ $name ]['default_value'];
				} else if ( $type === 'number' ) {
					$grid_accordion_settings[ $name ] = floatval( $setting_value );
				} else if ( $type === 'mixed' || $type === 'text' ) {
					$grid_accordion_settings[ $name ] = sanitize_text_field( $setting_value );
				} else if ( $type === 'select' ) {
					if ( $name === 'thumbnail_image_size' ) {
						$grid_accordion_settings[ $name ] = sanitize_text_field( $setting_value );
					} else {
						$grid_accordion_settings[ $name ] = array_key_exists( $setting_value, $default_grid_accordion_settings[ $name ]['available_values'] ) ? $setting_value : $default_grid_accordion_settings[ $name ]['default_value'];
					}
				}
			}
		}

		if ( isset( $data['breakpoints'] ) ) {
			$grid_accordion_settings['breakpoints'] = self::validate_grid_accordion_breakpoint_settings( $data['breakpoints'] );
		}
		
		return $grid_accordion_settings;
	}

	/**
	 * Validate the grid accordion's breakpoint settings.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted breakpoint settings.
	 * @return array       Validated breakpoint settings.
	 */
	public static function validate_grid_accordion_breakpoint_settings( $breakpoints_data ) {
		$default_grid_accordion_settings = BQW_Grid_Accordion_Settings::getSettings();
		$default_breakpoint_settings = BQW_Grid_Accordion_Settings::getBreakpointSettings();
		$breakpoints = array();

		foreach ( $breakpoints_data as $breakpoint_data ) {
			$breakpoint = array(
				'breakpoint_width' => floatval( $breakpoint_data['breakpoint_width'] )
			);

			foreach ( $breakpoint_data as $name => $value ) {
				if ( in_array( $name, $default_breakpoint_settings ) ) {
					$type = $default_grid_accordion_settings[ $name ][ 'type' ];

					if ( $type === 'boolean' ) {
						$breakpoint[ $name ] = is_bool( $value ) ? $value : $default_grid_accordion_settings[ $name ]['default_value'];
					} else if ( $type === 'number' ) {
						$breakpoint[ $name ] = floatval( $value );
					} else if ( $type === 'mixed' ) {
						$breakpoint[ $name ] = sanitize_text_field( $value );
					} else if ( $type === 'select' ) {
						$breakpoint[ $name ] = array_key_exists( $value, $default_grid_accordion_settings[ $name ]['available_values'] ) ? $value : $default_grid_accordion_settings[ $name ]['default_value'];
					}
				}
			}

			array_push( $breakpoints, $breakpoint );
		}

		return $breakpoints;
	}

	/**
	 * Validate the grid accordion's panels data.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted grid accordion panels data.
	 * @return array       Validated grid accordion panels.
	 */
	public static function validate_grid_accordion_panels( $panels_data ) {
		$panels = array();
		
		foreach ( $panels_data as $panel_data ) {
			$panel = array();

			foreach ( $panel_data as $name => $value ) {
				if ( $name === 'position' ) {
					$panel['position'] = intval( $value );
				} else if ( $name === 'settings' ) {
					$panel['settings'] = self::validate_panel_settings( $value );
				} else if ( $name === 'layers' ) {
					$panel['layers'] = self::validate_panel_layers( $value );
				} else if ( $name === 'html' ) {
					$panel[ $name ] = $value;
				} else {
					$panel[ $name ] = sanitize_text_field( $value );
				}
			}

			array_push( $panels, $panel );
		}

		return $panels;
	}

	/**
	 * Validate the panel settings.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted panel settings.
	 * @return array       Validated panel settings.
	 */
	public static function validate_panel_settings( $panel_settings_data ) {
		$panel_settings = array();
		$default_panel_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		if ( ! empty( $panel_settings_data ) ) {
			$panel_settings['content_type'] = array_key_exists( $panel_settings_data['content_type'], $default_panel_settings['content_type']['available_values'] ) ? $panel_settings_data['content_type'] : $default_panel_settings['content_type']['default_value'];
			
			foreach ( $panel_settings_data as $panel_setting_name => $panel_setting_value ) {
				if ( isset( $default_panel_settings[ $panel_setting_name ] ) ) {
					$type = $default_panel_settings[ $panel_setting_name ]['type'];

					if ( $type === 'number' ) {
						$panel_settings[ $panel_setting_name ] = floatval( $panel_setting_value );
					} else if ( $type === 'text' ) {
						$panel_settings[ $panel_setting_name ] = sanitize_text_field( $panel_setting_value );
					} else if ( $type === 'select' ) {
						$panel_settings[ $panel_setting_name ] = array_key_exists( $panel_setting_value, $default_panel_settings[ $panel_setting_name ]['available_values'] ) ? $panel_setting_value : $default_panel_settings[ $panel_setting_name ]['default_value'];
					} else if ( $type === 'multiselect' ) {
						$panel_settings[ $panel_setting_name ] = array();

						foreach ( $panel_setting_value as $option ) {
							array_push( $panel_settings[ $panel_setting_name ], wp_kses_post( $option ) );
						}
					}
				}
			}
		}

		return $panel_settings;
	}

	/**
	 * Validate the panel layers.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted panel layers.
	 * @return array       Validated panel layers.
	 */
	public static function validate_panel_layers( $layers_data ) {
		$layers = array();
		global $allowedposttags;

		foreach ( $layers_data as $layer_data ) {
			$layer = array();

			foreach ( $layer_data as $name => $value ) {
				if ( in_array( $name, array( 'id', 'accordion_id', 'panel_id', 'position' ) ) ) {
					$layer[ $name ] = intval( $value );
				} else if ( $name === 'settings' ) {
					$layer['settings'] = self::validate_layer_settings( $value );
				} else {

					// for other layer fields, like name, text, image source etc.
					$allowed_html = array_merge(
						$allowedposttags,
						array(
							'iframe' => array(
								'src' => true,
								'width' => true,
								'height' => true,
								'allow' => true,
								'allowfullscreen' => true,
								'class' => true,
								'id' => true,
								'data-*' => true
							),
							'source' => array(
								'src' => true,
								'type' => true
							)
						)
					);

					$layer[ $name ] = wp_kses( $value, $allowed_html );
				}
			}

			array_push( $layers, $layer );
		}

		return $layers;
	}

	/**
	 * Validate the layer settings.
	 *
	 * @since 1.8.0
	 * 
	 * @param array  $data Posted layer settings.
	 * @return array       Validated panel layers.
	 */
	public static function validate_layer_settings( $layer_settings_data ) {
		$layer_settings = array();
		$default_layer_settings = BQW_Grid_Accordion_Settings::getLayerSettings();

		foreach ( $layer_settings_data as $layer_setting_name => $layer_setting_value ) {
			if ( isset( $default_layer_settings[ $layer_setting_name ] ) ) {
				$type = $default_layer_settings[ $layer_setting_name ]['type'];

				if ( $type === 'number' ) {
					$layer_settings[ $layer_setting_name ] = floatval( $layer_setting_value );
				} else if ( $type === 'text' || $type === 'mixed' ) {
					$layer_settings[ $layer_setting_name ] = sanitize_text_field( $layer_setting_value );
				} else if ( $type === 'select' ) {
					$layer_settings[ $layer_setting_name ] = array_key_exists( $layer_setting_value, $default_layer_settings[ $layer_setting_name ]['available_values'] ) ? $layer_setting_value : $default_layer_settings[ $layer_setting_name ]['default_value'];
				} else if ( $type === 'multiselect' ) {
					$layer_settings[ $layer_setting_name ] = array();

					foreach ( $layer_setting_value as $option ) {
						array_push( $layer_settings[ $layer_setting_name ], wp_kses_post( $option ) );
					}
				}
			}
		}

		return $layer_settings;
	}
}