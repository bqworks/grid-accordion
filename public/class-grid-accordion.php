<?php
/**
 * Grid Accordion public class.
 * 
 * @since 1.0.0
 */
class BQW_Grid_Accordion {

	/**
	 * Current version of the Grid Accordion plugin.
	 * 
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	const VERSION = '1.9.13';

	/**
	 * Plugin slug.
	 * 
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	protected $plugin_slug = 'grid-accordion';

	/**
	 * Current class instance.
	 * 
	 * @since 1.0.0
	 * 
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Scripts to load.
	 *
	 * Script id's are added to this array when the accordion is rendered,
	 * and then the list of scripts is enqueued when the wp_footer action is called.
	 * 
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected $scripts_to_load = array();

	/**
	 * JavaScript output.
	 *
	 * The JavaScript output of all accordions loaded on the page is stored
	 * in this variable, and when wp_footer is called, the result is printed.
	 * 
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	protected $js_output = '';

	/**
	 * Indicates if stylesheets need to be loaded.
	 * 
	 * @since 1.0.0
	 * 
	 * @var bool
	 */
	protected $styles_loaded = false;

	/**
	 * Indicates if stylesheets were checked.
	 * 
	 * @since 1.0.0
	 * 
	 * @var bool
	 */
	protected $styles_checked = false;

	/**
	 * Initialize the Grid Accordion plugin.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// load the translation
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// register the public CSS and JS files
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		// when the actions are called enqueue the necessary CSS and JS files
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );
		add_action( 'wp_footer', array( $this, 'load_scripts' ) );

		add_action( 'wp_print_footer_scripts', array( $this, 'print_inline_scripts' ) );

		// register the shortcodes
		add_shortcode( 'grid_accordion', array( $this, 'grid_accordion_shortcode' ) );
		add_shortcode( 'grid_accordion_panel', array( $this, 'grid_accordion_panel_shortcode' ) );
		add_shortcode( 'grid_accordion_panel_element', array( $this, 'grid_accordion_panel_element_shortcode' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since 1.0.0
	 * 
	 * @return string The plugin slug.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return the current class instance.
	 *
	 * @since 1.0.0
	 * 
	 * @return object The instance of the current class.
	 */
	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Return the current class instance.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, 'grid-accordion/languages/' );
	}

	/**
	 * Register the public CSS files.
	 *
	 * @since 1.0.0
	 */
	public function register_styles() {
		if ( get_option( 'grid_accordion_load_unminified_scripts' ) == true ) {
			wp_register_style( $this->plugin_slug . '-plugin-style', plugins_url( 'public/assets/css/grid-accordion.css', dirname( __FILE__ ) ), array(), self::VERSION );
			wp_register_style( $this->plugin_slug . '-lightbox-style', plugins_url( 'public/assets/libs/fancybox/jquery.fancybox.css', dirname( __FILE__ ) ), array(), self::VERSION );
		} else {
			wp_register_style( $this->plugin_slug . '-plugin-style', plugins_url( 'public/assets/css/grid-accordion.min.css', dirname( __FILE__ ) ), array(), self::VERSION );
			wp_register_style( $this->plugin_slug . '-lightbox-style', plugins_url( 'public/assets/libs/fancybox/jquery.fancybox.min.css', dirname( __FILE__ ) ), array(), self::VERSION );
		}
		
		wp_register_style( $this->plugin_slug . '-video-js-style', plugins_url( 'public/assets/libs/video-js/video-js.min.css', dirname( __FILE__ ) ), array(), self::VERSION );
	}

	/**
	 * Register the public JS files.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		if ( get_option( 'grid_accordion_load_unminified_scripts' ) == true ) {
			wp_register_script( $this->plugin_slug . '-plugin-script', plugins_url( 'public/assets/js/jquery.gridAccordion.js', dirname( __FILE__ ) ), array( 'jquery' ), self::VERSION );
			wp_register_script( $this->plugin_slug . '-lightbox-script', plugins_url( 'public/assets/libs/fancybox/jquery.fancybox.js', dirname( __FILE__ ) ), array(), self::VERSION );
		} else {
			wp_register_script( $this->plugin_slug . '-plugin-script', plugins_url( 'public/assets/js/jquery.gridAccordion.min.js', dirname( __FILE__ ) ), array( 'jquery' ), self::VERSION );
			wp_register_script( $this->plugin_slug . '-lightbox-script', plugins_url( 'public/assets/libs/fancybox/jquery.fancybox.min.js', dirname( __FILE__ ) ), array(), self::VERSION );
		}
		
		wp_register_script( $this->plugin_slug . '-easing-script', plugins_url( 'public/assets/libs/easing/jquery.easing.1.3.min.js', dirname( __FILE__ ) ), array(), self::VERSION );
		wp_register_script( $this->plugin_slug . '-video-js-script', plugins_url( 'public/assets/libs/video-js/video.js', dirname( __FILE__ ) ), array(), self::VERSION );
	}

	/**
	 * Add script id's to the list of scripts to be loaded when wp_footer is called.
	 *
	 * @since 1.0.0
	 * 
	 * @param string $handle An id of the script to load.
	 */
	public function add_script_to_load( $handle ) {
		if ( in_array( $handle, $this->scripts_to_load ) === false ) {
			$this->scripts_to_load[] = $handle;
		}
	}

	/**
	 * Load the accordion data from the database.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int        $id The id of the accordion.
	 * @return array|bool     An array containing the accordion data, or false, if the specified id doesn't exist in the database.
	 */
	public function load_accordion( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'gridaccordion_accordions';

		$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d ORDER BY id", $id ), ARRAY_A );

		if ( ! is_null( $result ) ) {
			return $result;
		} else {
			return false;	
		}
	}

	/**
	 * Load each panel's data from the database.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int        $id The id of the accordion.
	 * @return array|bool     An array containing each panel's data, or false, if the specified id doesn't exist in the database.
	 */
	public function load_panels( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'gridaccordion_panels';
		$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE accordion_id = %d ORDER BY position", $id ), ARRAY_A );

		if ( ! is_null( $result ) ) {
			return $result;
		} else {
			return false;	
		}
	}

	/**
	 * Load each layer's data from the database.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int        $id The id of the accordion.
	 * @return array|bool     An array containing each layer's data, or false, if the specified id doesn't exist in the database.
	 */
	public function load_layers( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'gridaccordion_layers';
		$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE panel_id = %d", $id ), ARRAY_A );

		if ( ! is_null( $result ) ) {
			return $result;
		} else {
			return false;	
		}
	}

	/**
	 * Return the data of the accordion.
	 *
	 * It loads the accordion, panels and layers data from the database and formats it into
	 * and a single array.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int   $id The id of the accordion.
	 * @return array     An array containing all the accordion's database data.
	 */
	public function get_accordion( $id ) {
		$accordion = array();
		$accordion_raw = $this->load_accordion( $id );

		if ( $accordion_raw === false ) {
			return false;
		}

		$accordion['id'] = $accordion_raw['id'];
		$accordion['name'] = $accordion_raw['name'];
		$accordion['settings'] = json_decode( stripslashes( $accordion_raw['settings'] ), true );
		$accordion['panels_state'] = json_decode( stripslashes( $accordion_raw['panels_state'] ), true );
		
		$panels_raw = $this->load_panels( $id );

		if ( $panels_raw !== false ) {
			$accordion['panels'] = array();

			foreach ( $panels_raw as $panel_raw ) {
				$panel = $panel_raw;
				$panel['settings'] = json_decode( stripslashes( $panel_raw['settings'] ), true );
				$layers_raw = $this->load_layers( $panel_raw['id'] );

				if ( $layers_raw !== false ) {
					$panel['layers'] = array();

					foreach ( $layers_raw as $layer_raw ) {
						$layer = $layer_raw;
						$layer['settings'] = json_decode( stripslashes( $layer_raw['settings'] ), true );

						array_push( $panel['layers'], $layer );
					}

					usort( $panel['layers'], array( $this, 'sort_layers_by_position' ) );
				}

				array_push( $accordion['panels'], $panel );
			}
		}

		return BQW_Grid_Accordion_Validation::validate_grid_accordion_data( $accordion );
	}

	/**
	 * Utility function for sorting a panel's layers
	 *
	 * @since 1.0.0
	 * 
	 * @param  array $layer1 A layer array.
	 * @param  array $layer2 Another layer array.
	 * @return int           The difference between the layers' position.
	 */
	public function sort_layers_by_position( $layer1, $layer2 ) {
		return $layer1['position'] - $layer2['position'];
	}

	/**
	 * Return the HTML markup of the accordion.
	 *
	 * Also, retrieves the JavaScript output of the accordion and CSS and JavaScript files that need to be loaded.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array   $accordion_data An array containing the accordion's data.
	 * @param  boolean $allow_cache    Indicates whether or not the output will be cached.
	 * @return string                  The HTML code that needs to be printed for the accordion.
	 */
	public function output_accordion( $accordion_data, $allow_cache = true ) {
		$accordion_data = apply_filters( 'grid_accordion_data', $accordion_data, $accordion_data['id'] );

		$accordion = new BQW_GA_Accordion_Renderer( $accordion_data );
		$html_output = $accordion->render();
		$js_output = $accordion->render_js();
		$this->js_output .= $js_output;

		$css_dependencies = $accordion->get_css_dependencies();
		$js_dependencies = $accordion->get_js_dependencies();

		foreach ( $css_dependencies as $css_dependency ) {
			wp_enqueue_style( $this->plugin_slug . '-' . $css_dependency . '-style' );
		}

		foreach ( $js_dependencies as $js_dependency ) {
			$this->add_script_to_load( $this->plugin_slug . '-' . $js_dependency . '-script' );
		}

		if ( $allow_cache === true ) {
			$accordion_cache = array(
				'html_output' => $html_output,
				'js_output' => $js_output,
				'css_dependencies' => $css_dependencies,
				'js_dependencies' => $js_dependencies
			);

			$plugin_settings = BQW_Grid_Accordion_Settings::getPluginSettings();
			$cache_time = 60 * 60 * floatval( get_option( 'grid_accordion_cache_expiry_interval', $plugin_settings['cache_expiry_interval']['default_value'] ) );
			
			set_transient( 'grid_accordion_cache_' . $accordion_data['id'], $accordion_cache, $cache_time );
		}

		return $html_output;
	}

	/**
	 * Load the necessary CSS files or inline code.
	 *
	 * It checks to see if the plugin is set to load the CSS in all pages or only on the homepage,
	 * then it checks to see if the accordion shortcode exists in the currently viewed post(s), then it checks
	 * if the accordion is added in a widget.
	 *
	 * If either of these checks return a positive result, the accordion's CSS file will be loaded.
	 *
	 * Then, it also loads the custom CSS.
	 * 
	 * @since 1.0.0
	 */
	public function load_styles() {
		if ( is_admin() ) {
			return;
		}

		$this->styles_checked = true;

		global $posts;
		
		if ( $this->styles_loaded === false && ( $load_stylesheets = get_option( 'grid_accordion_load_stylesheets' ) ) !== false ) {
			if ( ( $load_stylesheets === 'all' ) || ( $load_stylesheets === 'homepage' && ( is_home() || is_front_page() ) ) ) {
				$this->styles_loaded = true;
			}
		}

		if ( $this->styles_loaded === false && isset( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				if ( strpos( $post->post_content, '[grid_accordion' ) !== false ) {
					$this->styles_loaded = true;
				}
			}
		}

		if ( $this->styles_loaded === false && is_active_widget( false, false, 'bqw-grid-accordion-widget' ) ) {
			$this->styles_loaded = true;
		}

		if ( $this->styles_loaded === true ) {
			wp_enqueue_style( $this->plugin_slug . '-plugin-style' );

			if ( get_option( 'grid_accordion_is_custom_css') == true ) {
				wp_add_inline_style( $this->plugin_slug . '-plugin-style', stripslashes( get_option( 'grid_accordion_custom_css' ) ) );
			}

			do_action( 'grid_accordion_enqueue_styles', $this->plugin_slug . '-plugin-style' );
		}
	}

	/**
	 * Load the scripts added to the list of scripts that need to be loaded, enqueues them,
	 * and then it prints the inline JavaScrip code that instantiates all the accordions on the page.
	 * 
	 * @since 1.0.0
	 */
	public function load_scripts() {
		if ( empty( $this->scripts_to_load ) ) {
			return;
		}

		foreach ( $this->scripts_to_load as $key => $value ) {
			if ( is_numeric( $key ) ) {
				wp_enqueue_script( $value );
			} else if ( is_string( $key ) ) {
				wp_enqueue_script( $key, $value );
			}
		}

		do_action( 'grid_accordion_enqueue_scripts' );
	}

	/**
	 * Return the inline JavaScript code for all accordions on the page.
	 *
	 * @since 1.0.0
	 * 
	 * @return string The inline JavaScript.
	 */
	public function get_inline_scripts() {
		if ( $this->js_output === '' ) {
			return;
		}
		
		$inline_js = "\r\n" . '<script type="text/javascript">' .
					"\r\n" . 'if (window.jQuery && window.jQuery.fn.gridAccordion) {' .
					"\r\n" . '		initGridAccordion();' .
					"\r\n" . '} else {' .
					"\r\n" . '	const initGridAccordionTimer = setInterval(() => {' .
					"\r\n" . '		if (window.jQuery && window.jQuery.fn.gridAccordion) {' .
					"\r\n" . '			initGridAccordion();' .
					"\r\n" . '			clearInterval(initGridAccordionTimer);' .
					"\r\n" . '		}' .
					"\r\n" . '	}, 100);' .
					"\r\n" . '}' . "\r\n" .
	
					"\r\n" . 'function initGridAccordion() {' .
					"\r\n" . '	jQuery( document ).ready(function( $ ) {' .
					$this->js_output;

		if ( get_option( 'grid_accordion_is_custom_js' ) == true ) {
			$custom_js = "\r\n" . '	' . stripslashes( get_option( 'grid_accordion_custom_js' ) );

			$inline_js .= $custom_js;
		}

		$inline_js .= "\r\n" . '	});' .
					"\r\n" . '}' .
					"\r\n" . '</script>' . "\r\n\r\n";

		$inline_js = apply_filters( 'grid_accordion_javascript', $inline_js );

		return $inline_js;
	}

	/**
	 * Print the inline JavaScript code.
	 *
	 * @since 1.0.0
	 */
	public function print_inline_scripts() {
		echo $this->get_inline_scripts();
	}

	/**
	 * Parse the grid accordion shortcode and print the accordion.
	 * 
	 * @since 1.0.0
	 * 
	 * @param  array  $atts    The attributes specified in the shortcode.
	 * @param  string $content The content added inside the shortcode.
	 * @return string          The accordion's HTML.
	 */
	public function grid_accordion_shortcode( $atts, $content = null ) {
		
		// if the CSS file(s) were not enqueued, display a warning message
		$styles_warning = '<div class="ga-styles-warning" style="width: 450px; background-color: #FFF; color: #F00; border: 1px solid #F00; padding: 10px; font-size: 14px;">
			<span style="font-weight: bold;">Warning: The stylesheets were not loaded!</span> 
			You will need to change the <i>Load stylesheets</i> setting from <i>Automatically</i> to <i>On homepage</i> or <i>On all pages</i>. 
			You can set that <a style="text-decoration: underline; color: #F00;" href="' . admin_url( 'admin.php?page=grid-accordion-settings' ) . '">here</a>.
			</div>';

		// If styles were not checked, check them now.
		// This check is necessary because with some themes the shortcodes are parsed before the
		// 'wp_enqueue_script' action is called.
		if ( $this->styles_checked === false ) {
			$this->load_styles();
		}
 
		// don't show the warning if the styles are loaded
		if ( $this->styles_loaded === true || is_admin() === true ) {
			$styles_warning = '';
		}

		// get the id specified in the shortcode
		$id = isset( $atts['id'] ) ? intval( $atts['id'] ) : -1;

		// check whether cache is allowed
		$allow_cache = ( isset( $atts['allow_cache'] ) && $atts['allow_cache'] === 'false' ) ? false : true;
		$cache_transient_name = 'grid_accordion_cache_' . $id;

		// load the accordion from the cache
		if ( ( $accordion_cache = get_transient( $cache_transient_name ) ) !== false && $allow_cache !== false ) {
			$css_dependencies = $accordion_cache['css_dependencies'];
			$js_dependencies = $accordion_cache['js_dependencies'];

			foreach ( $css_dependencies as $css_dependency ) {
				wp_enqueue_style( $this->plugin_slug . '-' . $css_dependency . '-style' );
			}

			foreach ( $js_dependencies as $js_dependency ) {
				$this->add_script_to_load( $this->plugin_slug . '-' . $js_dependency . '-script' );
			}

			$this->js_output .= $accordion_cache['js_output'];
			
			return $styles_warning . $accordion_cache['html_output'];
		}

		// parse the inner content of the shortcode
		$content = do_shortcode( $content );

		// get the accordion's database data
		$accordion = $this->get_accordion( $id );

		// if the specified id doesn't return a result, either the accordion doesn't exist, or, if
		// there is inner content added to the shortcode, try to create the accordion from scratch
		if ( $accordion === false ) {
			if ( empty( $content ) ) {
				return 'A grid accordion with the ID of ' . $id . ' doesn\'t exist.';
			}

			$accordion['name'] = isset( $atts['name'] ) ? $atts['name'] : '';
		}

		// add the if of the accordion to the array of accordion data
		if ( ! isset( $accordion['id'] ) ) {
			$accordion['id'] = $id;
		}

		// override the accordion's settings with those specified in the shortcode
		foreach ( $atts as $key => $value ) {
			if ( $key === 'breakpoints' ) {
				$value = json_decode( stripslashes( $value ), true );
			} else if ( $value === 'true' ) {
				$value = true;
			} else if ( $value === 'false' ) {
				$value = false;
			}

			$accordion['settings'][ $key ] = $value;
		}

		// analyze the shortcode's content, if any
		if ( ! empty( $content ) ) {

			// create an array that will hold additional extra
			$panels_extra = array();
			
			// counter for the panels for which an index was not specified and will be added at the end of the other panels
			$end_counter = 1;
			
			// get all the added panels
			$panels_shortcode = do_shortcode( $content );
			$panels_shortcode = str_replace( '<br />', '', $panels_shortcode );		
			$panels_shortcode = explode( '%as_sep%', $panels_shortcode );
			
			// loop through all the panels added within the shortcode 
			// and add the panel to the panels_extra array
			foreach ( $panels_shortcode as $panel_shortcode ) {
				$panel_shortcode = json_decode( stripslashes( trim( $panel_shortcode ) ), true );

				if ( ! empty( $panel_shortcode ) ) {
					$index = $panel_shortcode['settings']['index'];
					
					if ( ! is_numeric( $index ) ) {
						$index .= '_' . $end_counter;
						$end_counter++;
					}
					
					$panels_extra[ $index ] = $panel_shortcode;
				}
			}
			
			// loop through the panels added in the database and override the content with that
			// specified through shortcodes
			if ( isset( $accordion['panels'] ) ) {
				foreach ( $accordion['panels'] as $index => &$panel ) {
					if ( isset( $panels_extra[ $index ] ) ) {
						$panel_extra = $panels_extra[ $index ];

						foreach ( $panel_extra as $key => $value ) {
							if ( $key === 'settings' || $key === 'layers' ) {
								$panel[ $key ] = array_merge( $panel[ $key ], $panel_extra[ $key ] );
							} else {
								$panel[ $key ] = $value;
							}
						}
						
						unset( $panels_extra[ $index ] );
					}
				}
			}

			// add the remaining panels, added through shortcodes, to the end of the accordion
			if ( ! empty( $panels_extra ) ) {
				if ( ! isset( $accordion['panels'] ) ) {
					$accordion['panels'] = array();
				}

				foreach ( $panels_extra as $panel_end ) {
					array_push( $accordion['panels'], $panel_end );
				}
			}
		}
		
		return $styles_warning . $this->output_accordion( $accordion );
	}

	/**
	 * Parse the accordion panel shortcode and return the data.
	 * 
	 * @since 1.0.0
	 * 
	 * @param  array  $atts    The attributes specified in the shortcode.
	 * @param  string $content The content added inside the shortcode.
	 * @return string          JSON-encoded data for the panel.
	 */
	public function grid_accordion_panel_shortcode( $atts, $content = null ) {
		// initialize the settings
		$panel = array( 'settings' => array( 'index' => 'end' ) );

		// parse the attributes passed
		if ( ! empty( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				if ( $key === 'posts_post_types' || $key === 'posts_taxonomies' ) {
					$value = explode( ',', $value );
				}

				$panel['settings'][ $key ] = $value;
			}
		}
		
		$panel_content = do_shortcode( $content );	
		$panel_content = str_replace( '<br />', '', $panel_content );	
		$panel_content_elements = explode( '%as_sep%', $panel_content );

		// get the content of the panel
		foreach ( $panel_content_elements as $element ) {
			$element = json_decode( stripslashes( trim( $element ) ), true );

			if ( ! empty( $element ) ) {
				foreach ( $element as $key => $value ) {
					
					// check if the element is a layer or a different type
					if ( $key === 'layer' ) {
						$layer = array( 'text' => $value );

						if ( isset( $element['layer_settings'] ) ) {
							foreach ( $element['layer_settings'] as $layer_setting => $layer_setting_value ) {
								$layer[ $layer_setting ] = $layer_setting_value;
							}
						}

						if ( ! isset( $panel['layers'] ) ) {
							$panel['layers'] = array();
						}

						array_push( $panel['layers'], $layer );
					} else if ( $key !== 'layer_settings' ) {
						$panel[ $key ] = $value;
					}
				}
			}
		}

		return json_encode( $panel ) . '%as_sep%';
	}

	/**
	 * Parse the accordion panel element shortcode and return the data.
	 * 
	 * @since 1.0.0
	 * 
	 * @param  array  $atts    The attributes specified in the shortcode.
	 * @param  string $content The content added inside the shortcode.
	 * @return string          JSON-encoded data for the panel element.
	 */
	public function grid_accordion_panel_element_shortcode( $atts, $content = null ) {
		$content = do_shortcode( $content );

		$attributes = array( 'layer_settings' => array() );

		foreach ( $atts as $key => $value ) {
			if ( $key === 'name' ) {
				$attributes[ $atts['name'] ] = $content;
			} else if ( isset( $atts['name'] ) && $atts['name'] === 'layer' ) {
				if ( $value === 'true' ) {
					$value = true;
				} else if ( $value === 'false' ) {
					$value = false;
				} else if ( $key === 'preset_styles' ) {
					$value = explode( ',', $value );
				}

				$attributes['layer_settings'][ $key ] = $value;
			}
		}

		return json_encode( $attributes ) . '%as_sep%';
	}
}