<?php
/**
 * Grid Accordion admin class.
 * 
 * @since 1.0.0
 */
class BQW_Grid_Accordion_Admin {

	/**
	 * Current class instance.
	 * 
	 * @since 1.0.0
	 * 
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Stores the hook suffixes for the plugin's admin pages.
	 * 
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected $plugin_screen_hook_suffixes = null;

	/**
	 * Current class instance of the public Grid Accordion class.
	 * 
	 * @since 1.0.0
	 * 
	 * @var object
	 */
	protected $plugin = null;

	/**
	 * Plugin class.
	 * 
	 * @since 1.0.0
	 * 
	 * @var object
	 */
	protected $plugin_slug = null;

	/**
	 * Initialize the admin by registering the required actions.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->plugin = BQW_Grid_Accordion::get_instance();
		$this->plugin_slug = $this->plugin->get_plugin_slug();

		// load the admin CSS and JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		add_action( 'wp_ajax_grid_accordion_get_accordion_data', array( $this, 'ajax_get_accordion_data' ) );
		add_action( 'wp_ajax_grid_accordion_save_accordion', array( $this, 'ajax_save_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_preview_accordion', array( $this, 'ajax_preview_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_delete_accordion', array( $this, 'ajax_delete_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_duplicate_accordion', array( $this, 'ajax_duplicate_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_export_accordion', array( $this, 'ajax_export_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_import_accordion', array( $this, 'ajax_import_accordion' ) );
		add_action( 'wp_ajax_grid_accordion_add_panels', array( $this, 'ajax_add_panels' ) );
		add_action( 'wp_ajax_grid_accordion_load_background_image_editor', array( $this, 'ajax_load_background_image_editor' ) );
		add_action( 'wp_ajax_grid_accordion_load_html_editor', array( $this, 'ajax_load_html_editor' ) );
		add_action( 'wp_ajax_grid_accordion_load_layers_editor', array( $this, 'ajax_load_layers_editor' ) );
		add_action( 'wp_ajax_grid_accordion_add_layer_settings', array( $this, 'ajax_add_layer_settings' ) );
		add_action( 'wp_ajax_grid_accordion_load_settings_editor', array( $this, 'ajax_load_settings_editor' ) );
		add_action( 'wp_ajax_grid_accordion_load_content_type_settings', array( $this, 'ajax_load_content_type_settings' ) );
		add_action( 'wp_ajax_grid_accordion_add_breakpoint', array( $this, 'ajax_add_breakpoint' ) );
		add_action( 'wp_ajax_grid_accordion_add_breakpoint_setting', array( $this, 'ajax_add_breakpoint_setting' ) );
		add_action( 'wp_ajax_grid_accordion_get_taxonomies', array( $this, 'ajax_get_taxonomies' ) );
		add_action( 'wp_ajax_grid_accordion_clear_all_cache', array( $this, 'ajax_clear_all_cache' ) );
		add_action( 'wp_ajax_grid_accordion_getting_started_close', array( $this, 'ajax_getting_started_close' ) );
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
	 * Loads the admin CSS files.
	 *
	 * It loads the public and admin CSS, and also the public custom CSS.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffixes ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->plugin_screen_hook_suffixes ) ) {
			if ( get_option( 'grid_accordion_load_unminified_scripts' ) == true ) {
				wp_enqueue_style( $this->plugin_slug . '-admin-style', plugins_url( 'grid-accordion/admin/assets/css/grid-accordion-admin.css' ), array(), BQW_Grid_Accordion::VERSION );
				wp_enqueue_style( $this->plugin_slug . '-plugin-style', plugins_url( 'grid-accordion/public/assets/css/grid-accordion.css' ), array(), BQW_Grid_Accordion::VERSION );
			} else {
				wp_enqueue_style( $this->plugin_slug . '-admin-style', plugins_url( 'grid-accordion/admin/assets/css/grid-accordion-admin.min.css' ), array(), BQW_Grid_Accordion::VERSION );
				wp_enqueue_style( $this->plugin_slug . '-plugin-style', plugins_url( 'grid-accordion/public/assets/css/grid-accordion.min.css' ), array(), BQW_Grid_Accordion::VERSION );
			}

			wp_enqueue_style( $this->plugin_slug . '-lightbox-style', plugins_url( 'grid-accordion/public/assets/libs/fancybox/jquery.fancybox.css' ), array(), BQW_Grid_Accordion::VERSION );
			wp_enqueue_style( $this->plugin_slug . '-video-js-style', plugins_url( 'grid-accordion/public/assets/libs/video-js/video-js.min.css' ), array(), BQW_Grid_Accordion::VERSION );

			if ( get_option( 'grid_accordion_is_custom_css') == true ) {
				if ( get_option( 'grid_accordion_load_custom_css_js' ) === 'in_files' ) {
					global $blog_id;
					$file_suffix = '';

					if ( ! is_main_site( $blog_id ) ) {
						$file_suffix = '-' . $blog_id;
					}

					$custom_css_path = plugins_url( 'grid-accordion-custom/custom' . $file_suffix . '.css' );
					$custom_css_dir_path = WP_PLUGIN_DIR . '/grid-accordion-custom/custom' . $file_suffix . '.css';

					if ( file_exists( $custom_css_dir_path ) ) {
						wp_enqueue_style( $this->plugin_slug . '-plugin-custom-style', $custom_css_path, array(), BQW_Grid_Accordion::VERSION );
					}
				} else {
					wp_add_inline_style( $this->plugin_slug . '-plugin-style', stripslashes( get_option( 'grid_accordion_custom_css' ) ) );
				}
			}
		}
	}

	/**
	 * Loads the admin JS files.
	 *
	 * It loads the public and admin JS, and also the public custom JS.
	 * Also, it passes the PHP variables to the admin JS file.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffixes ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->plugin_screen_hook_suffixes ) ) {
			if ( function_exists( 'wp_enqueue_media' ) ) {
		    	wp_enqueue_media();
			}
			
			if ( get_option( 'grid_accordion_load_unminified_scripts' ) == true ) {
				wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'grid-accordion/admin/assets/js/grid-accordion-admin.js' ), array( 'jquery' ), BQW_Grid_Accordion::VERSION );
				wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'grid-accordion/public/assets/js/jquery.gridAccordion.js' ), array( 'jquery' ), BQW_Grid_Accordion::VERSION );
			} else {
				wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'grid-accordion/admin/assets/js/grid-accordion-admin.min.js' ), array( 'jquery' ), BQW_Grid_Accordion::VERSION );
				wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'grid-accordion/public/assets/js/jquery.gridAccordion.min.js' ), array( 'jquery' ), BQW_Grid_Accordion::VERSION );
			}

			wp_enqueue_script( $this->plugin_slug . '-easing-script', plugins_url( 'grid-accordion/public/assets/libs/easing/jquery.easing.1.3.min.js' ), array(), BQW_Grid_Accordion::VERSION );
			wp_enqueue_script( $this->plugin_slug . '-lightbox-script', plugins_url( 'grid-accordion/public/assets/libs/fancybox/jquery.fancybox.pack.js' ), array(), BQW_Grid_Accordion::VERSION );
			wp_enqueue_script( $this->plugin_slug . '-video-js-script', plugins_url( 'grid-accordion/public/assets/libs/video-js/video.js' ), array(), BQW_Grid_Accordion::VERSION );

			if ( get_option( 'grid_accordion_is_custom_js' ) == true && get_option( 'grid_accordion_load_custom_css_js' ) === 'in_files' ) {
				global $blog_id;
				$file_suffix = '';

				if ( ! is_main_site( $blog_id ) ) {
					$file_suffix = '-' . $blog_id;
				}

				$custom_js_path = plugins_url( 'grid-accordion-custom/custom' . $file_suffix . '.js' );
				$custom_js_dir_path = WP_PLUGIN_DIR . '/grid-accordion-custom/custom' . $file_suffix . '.js';

				if ( file_exists( $custom_js_dir_path ) ) {
					wp_enqueue_script( $this->plugin_slug . '-plugin-custom-script', $custom_js_path, array(), BQW_Grid_Accordion::VERSION );
				}
			}

			$id = isset( $_GET['id'] ) ? $_GET['id'] : -1;

			wp_localize_script( $this->plugin_slug . '-admin-script', 'ga_js_vars', array(
				'admin' => admin_url( 'admin.php' ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin' => plugins_url( 'grid-accordion' ),
				'page' => isset( $_GET['page'] ) && ( $_GET['page'] === 'grid-accordion-new' || ( isset( $_GET['id'] ) && isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) ) ? 'single' : 'all',
				'id' => $id,
				'lad_nonce' => wp_create_nonce( 'load-accordion-data' . $id ),
				'sa_nonce' => wp_create_nonce( 'save-accordion' . $id ),
				'no_image' => __( 'Click to add image', 'grid-accordion' ),
				'posts_panels' => __( 'Posts panels', 'grid-accordion' ),
				'gallery_panels' => __( 'Gallery panels', 'grid-accordion' ),
				'flickr_panels' => __( 'Flickr panels', 'grid-accordion' ),
				'accordion_delete' => __( 'Are you sure you want to delete this accordion?', 'grid-accordion' ),
				'panel_delete' => __( 'Are you sure you want to delete this panel?', 'grid-accordion' ),
				'yes' => __( 'Yes', 'grid-accordion' ),
				'cancel' => __( 'Cancel', 'grid-accordion' ),
				'accordion_update' => __( 'Grid accordion updated.', 'grid-accordion' ),
				'accordion_create' => __( 'Grid accordion created.', 'grid-accordion' )
			) );
		}
	}

	/**
	 * Create the plugin menu.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_menu() {
		$plugin_settings = BQW_Grid_Accordion_Settings::getPluginSettings();
		$access = get_option( 'grid_accordion_access', $plugin_settings['access']['default_value'] );

		add_menu_page(
			'Grid Accordion',
			'Grid Accordion',
			$access,
			$this->plugin_slug,
			array( $this, 'render_accordion_page' ),
			plugins_url( '/grid-accordion/admin/assets/css/images/ga-icon.png' )
		);

		$this->plugin_screen_hook_suffixes[] = add_submenu_page(
			$this->plugin_slug,
			__( 'Grid Accordion', $this->plugin_slug ),
			__( 'All Accordions', $this->plugin_slug ),
			$access,
			$this->plugin_slug,
			array( $this, 'render_accordion_page' )
		);

		$this->plugin_screen_hook_suffixes[] = add_submenu_page(
			$this->plugin_slug,
			__( 'Add New Accordion', $this->plugin_slug ),
			__( 'Add New', $this->plugin_slug ),
			$access,
			$this->plugin_slug . '-new',
			array( $this, 'render_new_accordion_page' )
		);

		$this->plugin_screen_hook_suffixes[] = add_submenu_page(
			$this->plugin_slug,
			__( 'Custom CSS and JavaScript', $this->plugin_slug ),
			__( 'Custom CSS & JS', $this->plugin_slug ),
			$access,
			$this->plugin_slug . '-custom',
			array( $this, 'render_custom_css_js_page' )
		);

		$this->plugin_screen_hook_suffixes[] = add_submenu_page(
			$this->plugin_slug,
			__( 'Plugin Settings', $this->plugin_slug ),
			__( 'Plugin Settings', $this->plugin_slug ),
			$access,
			$this->plugin_slug . '-settings',
			array( $this, 'render_plugin_settings_page' )
		);

		$this->plugin_screen_hook_suffixes[] = add_submenu_page(
			$this->plugin_slug,
			__( 'Documentation', $this->plugin_slug ),
			__( 'Documentation', $this->plugin_slug ),
			$access,
			$this->plugin_slug . '-documentation',
			array( $this, 'render_documentation_page' )
		);
	}

	/**
	 * Renders the accordion page.
	 *
	 * Based on the 'action' parameter, it will render
	 * either an individual accordion page or the list
	 * of all the accordions.
	 *
	 * If an individual accordion page is rendered, delete
	 * the transients that store the post names and posts data,
	 * in order to trigger a new fetching of them.
	 * 
	 * @since 1.0.0
	 */
	public function render_accordion_page() {
		if ( isset( $_GET['id'] ) && isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
			$accordion = $this->plugin->get_accordion( $_GET['id'] );

			if ( $accordion !== false ) {
				$accordion_id = $accordion['id'];
				$accordion_name = $accordion['name'];
				$accordion_settings = $accordion['settings'];
				$accordion_panels_state = $accordion['panels_state'];

				$panels = isset( $accordion['panels'] ) ? $accordion['panels'] : false;

				delete_transient( 'grid_accordion_post_names' );
				delete_transient( 'grid_accordion_posts_data' );

				include_once( 'views/accordion.php' );
			} else {
				include_once( 'views/accordions.php' );
			}
		} else {
			include_once( 'views/accordions.php' );
		}
	}

	/**
	 * Renders the page for a new accordion.
	 *
	 * Also, delete the transients that store
	 * the post names and posts data,
	 * in order to trigger a new fetching of them.
	 * 
	 * @since 1.0.0
	 */
	public function render_new_accordion_page() {
		$accordion_name = 'My Accordion';

		delete_transient( 'grid_accordion_post_names' );
		delete_transient( 'grid_accordion_posts_data' );

		include_once( 'views/accordion.php' );
	}

	/**
	 * Renders the custom CSS and JavaScript page.
	 *
	 * It also checks if new data was posted, and saves
	 * it in the options table.
	 * 
	 * @since 1.0.0
	 */
	public function render_custom_css_js_page() {
		$custom_css = get_option( 'grid_accordion_custom_css', '' );
		$custom_js = get_option( 'grid_accordion_custom_js', '' );

		if ( isset( $_POST['custom_css_update'] ) || isset( $_POST['custom_js_update'] ) ) {
			check_admin_referer( 'custom-css-js-update', 'custom-css-js-nonce' );

			if ( isset( $_POST['custom_css'] ) ) {
				$custom_css = $_POST['custom_css'];
				update_option( 'grid_accordion_custom_css', $custom_css );

				if ( $custom_css !== '' ) {
					update_option( 'grid_accordion_is_custom_css', true );
				} else {
					update_option( 'grid_accordion_is_custom_css', false );
				}
			}

			if ( isset( $_POST['custom_js'] ) ) {
				$custom_js = $_POST['custom_js'];
				update_option( 'grid_accordion_custom_js', $custom_js );

				if ( $custom_js !== '' ) {
					update_option( 'grid_accordion_is_custom_js', true );
				} else {
					update_option( 'grid_accordion_is_custom_js', false );
				}
			}

			if ( get_option( 'grid_accordion_load_custom_css_js' ) === 'in_files' ) {
				$this->save_custom_css_js_in_files( $custom_css, $custom_js );
			}
		}

		include_once( 'views/custom-css-js.php' );
	}

	/**
	 * Renders the plugin settings page.
	 *
	 * It also checks if new data was posted, and saves
	 * it in the options table.
	 *
	 * It verifies the purchase code supplied and displays
	 * if it's valid.
	 * 
	 * @since 1.0.0
	 */
	public function render_plugin_settings_page() {
		$plugin_settings = BQW_Grid_Accordion_Settings::getPluginSettings();
		$load_stylesheets = get_option( 'grid_accordion_load_stylesheets', $plugin_settings['load_stylesheets']['default_value'] );
		$load_custom_css_js = get_option( 'grid_accordion_load_custom_css_js', $plugin_settings['load_custom_css_js']['default_value'] );
		$load_unminified_scripts = get_option( 'grid_accordion_load_unminified_scripts', $plugin_settings['load_unminified_scripts']['default_value'] );
		$cache_expiry_interval = get_option( 'grid_accordion_cache_expiry_interval', $plugin_settings['cache_expiry_interval']['default_value'] );
		$hide_inline_info = get_option( 'grid_accordion_hide_inline_info', $plugin_settings['hide_inline_info']['default_value'] );
		$hide_getting_started_info = get_option( 'grid_accordion_hide_getting_started_info', $plugin_settings['hide_getting_started_info']['default_value'] );
		$access = get_option( 'grid_accordion_access', $plugin_settings['access']['default_value'] );

		if ( isset( $_POST['plugin_settings_update'] ) ) {
			check_admin_referer( 'plugin-settings-update', 'plugin-settings-nonce' );

			if ( isset( $_POST['load_stylesheets'] ) ) {
				$load_stylesheets = $_POST['load_stylesheets'];
				update_option( 'grid_accordion_load_stylesheets', $load_stylesheets );
			}

			if ( isset( $_POST['load_custom_css_js'] ) ) {
				$load_custom_css_js = $_POST['load_custom_css_js'];
				update_option( 'grid_accordion_load_custom_css_js', $load_custom_css_js );
			}

			if ( isset( $_POST['load_unminified_scripts'] ) ) {
				$load_unminified_scripts = true;
				update_option( 'grid_accordion_load_unminified_scripts', true );
			} else {
				$load_unminified_scripts = false;
				update_option( 'grid_accordion_load_unminified_scripts', false );
			}

			if ( isset( $_POST['cache_expiry_interval'] ) ) {
				$cache_expiry_interval = $_POST['cache_expiry_interval'];
				update_option( 'grid_accordion_cache_expiry_interval', $cache_expiry_interval );
			}

			if ( isset( $_POST['hide_inline_info'] ) ) {
				$hide_inline_info = true;
				update_option( 'grid_accordion_hide_inline_info', true );
			} else {
				$hide_inline_info = false;
				update_option( 'grid_accordion_hide_inline_info', false );
			}

			if ( isset( $_POST['hide_getting_started_info'] ) ) {
				$hide_getting_started_info = true;
				update_option( 'grid_accordion_hide_getting_started_info', true );
			} else {
				$hide_getting_started_info = false;
				update_option( 'grid_accordion_hide_getting_started_info', false );
			}

			if ( isset( $_POST['access'] ) ) {
				$access = $_POST['access'];
				update_option( 'grid_accordion_access', $access );
			}
		}

		$purchase_code = get_option( 'grid_accordion_purchase_code', '' );
		$purchase_code_status = get_option( 'grid_accordion_purchase_code_status', '0' );
		
		if ( isset( $_POST['purchase_code_update'] ) ) {
			check_admin_referer( 'purchase-code-update', 'purchase-code-nonce' );

			if ( isset( $_POST['purchase_code'] ) ) {
				$purchase_code = $_POST['purchase_code'];
				update_option( 'grid_accordion_purchase_code', $purchase_code );

				if ( $_POST['purchase_code'] === '' ) {
					$purchase_code_status = '0';
				} else {
					$api = BQW_Grid_Accordion_API::get_instance();

					$verification_result = $api->verify_purchase_code( $purchase_code );

					if ( $verification_result === 'yes' ) {
						$purchase_code_status = '1';
					} else if ( $verification_result === 'no' ) {
						$purchase_code_status = '2';
					} else if ( $verification_result === 'error' ) {
						$purchase_code_status = '3';
					}
				}

				update_option( 'grid_accordion_purchase_code_status', $purchase_code_status );
			}
		}
		
		include_once( 'views/plugin-settings.php' );
	}

	/**
	 * Renders the documentation page.
	 * 
	 * @since 1.0.0
	 */
	public function render_documentation_page() {
		echo '<iframe class="grid-accordion-documentation" src="' . plugins_url( 'grid-accordion/documentation/documentation.html' ) . '" width="100%" height="100%"></iframe>';
	}

	/**
	 * Add the custom CSS and JS in files, using the WP Filesystem API.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $custom_css The custom CSS.
	 * @param  string $custom_js  The custom JavaScript.
	 */
	private function save_custom_css_js_in_files ( $custom_css, $custom_js ) {
		$url = wp_nonce_url( 'admin.php?page=grid-accordion-custom', 'custom-css-js-update', 'custom-css-js-nonce' );
		$context = WP_PLUGIN_DIR;

		// get the credentials and if there aren't any credentials stored,
		// display a form for the user to provide the credentials
		if ( ( $credentials = request_filesystem_credentials( $url, '', false, $context, null ) ) === false  ) {			
			return;
		}

		// check the credentials if they are valid
		// if they aren't, display the form again
		if ( ! WP_Filesystem( $credentials, $context ) ) {
			request_filesystem_credentials( $url, '', true, $context, null );
			return;
		}

		global $wp_filesystem;

		// create the 'grid-accordion-custom' folder if it doesn't exist
		if ( ! $wp_filesystem->exists( $context . '/grid-accordion-custom' ) ) {
			$wp_filesystem->mkdir( $context . '/grid-accordion-custom' );
		}

		global $blog_id;
		$file_suffix = '';

		if ( ! is_main_site( $blog_id ) ) {
			$file_suffix = '-' . $blog_id;
		}

		$wp_filesystem->put_contents( $context . '/grid-accordion-custom/custom' . $file_suffix . '.css', stripslashes( $custom_css ), FS_CHMOD_FILE );
		$wp_filesystem->put_contents( $context . '/grid-accordion-custom/custom' . $file_suffix . '.js', stripslashes( $custom_js ), FS_CHMOD_FILE );
	}

	/**
	 * AJAX call for getting the accordion's data.
	 *
	 * @since 1.0.0
	 * 
	 * @return string The accordion data, as JSON-encoded array.
	 */
	public function ajax_get_accordion_data() {
		$nonce = $_GET['nonce'];
		$id = $_GET['id'];

		if ( ! wp_verify_nonce( $nonce, 'load-accordion-data' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$accordion = $this->get_accordion_data( $_GET['id'] );

		echo json_encode( $accordion );

		die();
	}

	/**
	 * Return the accordion's data.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int   $id The id of the accordion.
	 * @return array     The accordion data.
	 */
	public function get_accordion_data( $id ) {
		return $this->plugin->get_accordion( $id );
	}

	/**
	 * AJAX call for saving the accordion.
	 *
	 * It can be called when the accordion is created, updated
	 * or when an accordion is imported. If the accordion is 
	 * imported, it returns a row in the list of accordions.
	 *
	 * @since 1.0.0
	 */
	public function ajax_save_accordion() {
		$accordion_data = json_decode( stripslashes( $_POST['data'] ), true );
		$nonce = $accordion_data['nonce'];
		$id = intval( $accordion_data['id'] );
		$action = $accordion_data['action'];

		if ( ! wp_verify_nonce( $nonce, 'save-accordion' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$accordion_id = $this->save_accordion( $accordion_data );

		if ( $action === 'save' ) {
			echo $accordion_id;
		} else if ( $action === 'import' ) {
			$accordion_name = $accordion_data['name'];
			$accordion_created = date( 'm-d-Y' );
			$accordion_modified = date( 'm-d-Y' );

			include( 'views/accordions-row.php' );
		}

		die();
	}

	/**
	 * Save the accordion.
	 *
	 * It either creates a new accordion or updates and existing one.
	 *
	 * For existing accordions, the panels and layers are deleted and 
	 * re-inserted in the database.
	 *
	 * The cached accordion is deleted every time the accordion is saved.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array $accordion_data The data of the accordion that's saved.
	 * @return int                   The id of the saved accordion.
	 */
	public function save_accordion( $accordion_data ) {
		global $wpdb;

		$id = intval( $accordion_data['id'] );
		$panels_data = $accordion_data['panels'];

		if ( $id === -1 ) {
			$wpdb->insert($wpdb->prefix . 'gridaccordion_accordions', array( 'name' => $accordion_data['name'],
																				'settings' => json_encode( $accordion_data['settings'] ),
																				'created' => date( 'm-d-Y' ),
																				'modified' => date( 'm-d-Y' ),
																				'panels_state' => json_encode( $accordion_data['panels_state'] ) ), 
																		array( '%s', '%s', '%s', '%s', '%s' ) );
			
			$id = $wpdb->insert_id;
		} else {
			$wpdb->update( $wpdb->prefix . 'gridaccordion_accordions', array( 'name' => $accordion_data['name'], 
																			 	'settings' => json_encode( $accordion_data['settings'] ),
																			 	'modified' => date( 'm-d-Y' ),
																				'panels_state' => json_encode( $accordion_data['panels_state'] ) ), 
																	   	array( 'id' => $id ), 
																	   	array( '%s', '%s', '%s', '%s' ), 
																	   	array( '%d' ) );
				
			$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "gridaccordion_panels WHERE accordion_id = %d", $id ) );

			$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "gridaccordion_layers WHERE accordion_id = %d", $id ) );
		}

		foreach ( $panels_data as $panel_data ) {
			$panel = array('accordion_id' => $id,
							'label' => isset( $panel_data['label'] ) ? $panel_data['label'] : '',
							'position' => isset( $panel_data['position'] ) ? $panel_data['position'] : '',
							'visibility' => isset( $panel_data['visibility'] ) ? $panel_data['visibility'] : '',
							'background_source' => isset( $panel_data['background_source'] ) ? $panel_data['background_source'] : '',
							'background_retina_source' => isset( $panel_data['background_retina_source'] ) ? $panel_data['background_retina_source'] : '',
							'background_alt' => isset( $panel_data['background_alt'] ) ? $panel_data['background_alt'] : '',
							'background_title' => isset( $panel_data['background_title'] ) ? $panel_data['background_title'] : '',
							'background_width' => isset( $panel_data['background_width'] ) ? $panel_data['background_width'] : '',
							'background_height' => isset( $panel_data['background_height'] ) ? $panel_data['background_height'] : '',
							'opened_background_source' => isset( $panel_data['opened_background_source'] ) ? $panel_data['opened_background_source'] : '',
							'opened_background_retina_source' => isset( $panel_data['opened_background_retina_source'] ) ? $panel_data['opened_background_retina_source'] : '',
							'opened_background_alt' => isset( $panel_data['opened_background_alt'] ) ? $panel_data['opened_background_alt'] : '',
							'opened_background_title' => isset( $panel_data['opened_background_title'] ) ? $panel_data['opened_background_title'] : '',
							'opened_background_width' => isset( $panel_data['opened_background_width'] ) ? $panel_data['opened_background_width'] : '',
							'opened_background_height' => isset( $panel_data['opened_background_height'] ) ? $panel_data['opened_background_height'] : '',
							'background_link' => isset( $panel_data['background_link'] ) ? $panel_data['background_link'] : '',
							'background_link_title' => isset( $panel_data['background_link_title'] ) ? $panel_data['background_link_title'] : '',
							'html' => isset( $panel_data['html'] ) ? $panel_data['html'] : '',
							'settings' => isset( $panel_data['settings'] ) ? json_encode( $panel_data['settings'] ) : '');

			$wpdb->insert( $wpdb->prefix . 'gridaccordion_panels', $panel, array( '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s' ) );

			if ( ! empty( $panel_data[ 'layers' ] ) ) {
				$panel_id = $wpdb->insert_id;
				$layers_data = $panel_data[ 'layers' ];

				foreach ( $layers_data as $layer_data ) {
					$layer = array('accordion_id' => $id,
									'panel_id' => $panel_id,
									'position' => isset( $layer_data['position'] ) ? $layer_data['position'] : 0,
									'name' => isset( $layer_data['name'] ) ? $layer_data['name'] : '',
									'type' => isset( $layer_data['type'] ) ? $layer_data['type'] : '',
									'text' => isset( $layer_data['text'] ) ? $layer_data['text'] : '',
									'heading_type' => isset( $layer_data['heading_type'] ) ? $layer_data['heading_type'] : '',
									'image_source' => isset( $layer_data['image_source'] ) ? $layer_data['image_source'] : '',
									'image_alt' => isset( $layer_data['image_alt'] ) ? $layer_data['image_alt'] : '',
									'image_link' => isset( $layer_data['image_link'] ) ? $layer_data['image_link'] : '',
									'image_retina' => isset( $layer_data['image_retina'] ) ? $layer_data['image_retina'] : '',
									'settings' =>  isset( $layer_data['settings'] ) ? json_encode( $layer_data['settings'] ) : ''
									);

					$wpdb->insert( $wpdb->prefix . 'gridaccordion_layers', $layer, array( '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );
				}
			}
		}
		
		delete_transient( 'grid_accordion_cache_' . $id );

		return $id;
	}

	/**
	 * AJAX call for previewing the accordion.
	 *
	 * Receives the current data from the database (in the accordions page)
	 * or from the current settings (in the accordion page) and prints the
	 * HTML markup and the inline JavaScript for the accordion.
	 *
	 * @since 1.0.0
	 */
	public function ajax_preview_accordion() {
		$accordion = json_decode( stripslashes( $_POST['data'] ), true );
		$accordion_name = $accordion['name'];
		$accordion_output = $this->plugin->output_accordion( $accordion, false ) . $this->plugin->get_inline_scripts();

		include( 'views/preview-window.php' );

		die();	
	}

	/**
	 * AJAX call for duplicating an accordion.
	 *
	 * Loads an accordion from the database and re-saves it with an id of -1, 
	 * which will determine the save function to add a new accordion in the 
	 * database.
	 *
	 * It returns a new accordion row in the list of all accordions.
	 *
	 * @since 1.0.0
	 */
	public function ajax_duplicate_accordion() {
		$nonce = $_POST['nonce'];
		$original_accordion_id = $_POST['id'];

		if ( ! wp_verify_nonce( $nonce, 'duplicate-accordion' . $original_accordion_id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		if ( ( $original_accordion = $this->plugin->get_accordion( $original_accordion_id ) ) !== false ) {
			$original_accordion['id'] = -1;
			$accordion_id = $this->save_accordion( $original_accordion );
			$accordion_name = $original_accordion['name'];
			$accordion_created = date( 'm-d-Y' );
			$accordion_modified = date( 'm-d-Y' );

			include( 'views/accordions-row.php' );
		}

		die();
	}

	/**
	 * AJAX call for deleting an accordion.
	 *
	 * It's called from the list of accordions, when the
	 * 'Delete' link is clicked.
	 *
	 * It calls the 'delete_accordion()' method and passes
	 * it the id of the accordion to be deleted.
	 *
	 * @since 1.0.0
	 */
	public function ajax_delete_accordion() {
		$nonce = $_POST['nonce'];
		$id = intval( $_POST['id'] );

		if ( ! wp_verify_nonce( $nonce, 'delete-accordion' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		echo $this->delete_accordion( $id ); 

		die();
	}

	/**
	 * Delete the accordion indicated by the id.
	 *
	 * @since 1.0.0
	 * 
	 * @param  int $id The id of the accordion to be deleted.
	 * @return int     The id of the accordion that was deleted.
	 */
	public function delete_accordion( $id ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "gridaccordion_panels WHERE accordion_id = %d", $id ) );

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "gridaccordion_accordions WHERE id = %d", $id ) );

		return $id;
	}

	/**
	 * AJAX call for exporting an accordion.
	 *
	 * It loads an accordion from the database and encodes 
	 * its data as JSON, after removing the id of the accordion.
	 *
	 * The JSON string created is presented in a modal window.
	 *
	 * @since 1.0.0
	 */
	public function ajax_export_accordion() {
		$nonce = $_POST['nonce'];
		$id = intval( $_POST['id'] );

		if ( ! wp_verify_nonce( $nonce, 'export-accordion' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$accordion = $this->plugin->get_accordion( $id );

		if ( $accordion !== false ) {
			unset( $accordion['id'] );
			$export_string = json_encode( $accordion );

			include( 'views/export-window.php' );
		}

		die();
	}

	/**
	 * AJAX call for displaying the modal window
	 * for importing an accordion.
	 *
	 * @since 1.0.0
	 */
	public function ajax_import_accordion() {
		include( 'views/import-window.php' );

		die();
	}

	/**
	 * Create a panel from the passed data.
	 *
	 * Receives some data, like the background image, or
	 * the panel's content type. A new panel is created by 
	 * passing 'false' instead of any data.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array|bool $data The data of the panel or false, if the panel is new.
	 */
	public function create_panel( $data ) {
		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		$panel_type = $panel_default_settings['content_type']['default_value'];
		$panel_image = '';

		if ( $data !== false ) {
			$panel_type = isset( $data['settings'] ) && isset( $data['settings']['content_type'] ) ? $data['settings']['content_type'] : $panel_type;
			$panel_image = isset( $data['background_source'] ) ? $data['background_source'] : $panel_image;
		}

		include( 'views/panel.php' );
	}
	
	/**
	 * AJAX call for adding multiple or a single panel.
	 *
	 * If it receives any data, it tries to create multiple
	 * panels by padding the data that was received, and if
	 * it doesn't receive any data it tries to create a
	 * single panel.
	 *
	 * @since 1.0.0
	 */
	public function ajax_add_panels() {
		if ( isset( $_POST['data'] ) ) {
			$panels_data = json_decode( stripslashes( $_POST['data'] ), true );

			foreach ( $panels_data as $panel_data ) {
				$this->create_panel( $panel_data );
			}
		} else {
			$this->create_panel( false );
		}

		die();
	}

	/**
	 * AJAX call for displaying the background image editor.
	 *
	 * The aspect of the editor will depend on the panel's
	 * content type. Dynamic panels will not have the possibility
	 * to load images from the library.
	 *
	 * @since 1.0.0
	 */
	public function ajax_load_background_image_editor() {
		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		$data = json_decode( stripslashes( $_POST['data'] ), true );
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $panel_default_settings['content_type']['default_value'];
		$content_class = $content_type === 'custom' ? 'custom' : 'dynamic';

		include( 'views/background-image-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the inline HTML editor.
	 *
	 * @since 1.0.0
	 */
	public function ajax_load_html_editor() {
		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		$html_content = $_POST['data'];
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $panel_default_settings['content_type']['default_value'];

		include( 'views/html-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the layers editor.
	 *
	 * @since 1.0.0
	 */
	public function ajax_load_layers_editor() {
		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();
		$layer_default_settings = BQW_Grid_Accordion_Settings::getLayerSettings();

		$layers = json_decode( stripslashes( $_POST['data'] ), true );
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $panel_default_settings['content_type']['default_value'];
		
		include( 'views/layers-editor.php' );

		die();
	}

	/**
	 * AJAX call for adding a new block of layer settings
	 *
	 * It receives the id and type of the layer, and creates 
	 * the appropriate setting fields.
	 *
	 * @since 1.0.0
	 */
	public function ajax_add_layer_settings() {
		$layer = array();
		$layer_id = $_POST['id'];
		$layer_type = $_POST['type'];
		$layer_settings;

		if ( isset( $_POST['settings'] ) ) {
			$layer_settings = json_decode( stripslashes( $_POST['settings'] ), true );
		}

		if ( isset( $_POST['text'] ) ) {
			$layer['text'] = $_POST['text'];
		}

		if ( isset( $_POST['heading_type'] ) ) {
			$layer['heading_type'] = $_POST['heading_type'];
		}

		if ( isset( $_POST['image_source'] ) ) {
			$layer['image_source'] = $_POST['image_source'];
		}

		if ( isset( $_POST['image_alt'] ) ) {
			$layer['image_alt'] = $_POST['image_alt'];
		}

		if ( isset( $_POST['image_link'] ) ) {
			$layer['image_link'] = $_POST['image_link'];
		}

		if ( isset( $_POST['image_retina'] ) ) {
			$layer['image_retina'] = $_POST['image_retina'];
		}

		$layer_default_settings = BQW_Grid_Accordion_Settings::getLayerSettings();

		include( 'views/layer-settings.php' );

		die();
	}

	/**
	 * AJAX call for displaying the panel's settings editor.
	 *
	 * @since 1.0.0
	 */
	public function ajax_load_settings_editor() {
		$panel_settings = json_decode( stripslashes( $_POST['data'] ), true );

		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		$content_type = isset( $panel_settings['content_type'] ) ? $panel_settings['content_type'] : $panel_default_settings['content_type']['default_value'];

		include( 'views/settings-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the setting fields associated 
	 * with the current content type of the panel.
	 *
	 * It's called when the content type is changed manually 
	 * in the panel's settings window
	 *
	 * @since 1.0.0
	 */
	public function ajax_load_content_type_settings() {
		$type = $_POST['type'];
		$panel_settings = json_decode( stripslashes( $_POST['data'] ), true );

		echo $this->load_content_type_settings( $type, $panel_settings );

		die();
	}

	/**
	 * Return the setting fields associated with the content type.
	 *
	 * If the content type is set to 'posts', the names of the
	 * registered post types will be loaded.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $type           The panel's content type.
	 * @param  array  $panel_settings The panel's settings.
	 */
	public function load_content_type_settings( $type, $panel_settings = NULL ) {
		$panel_default_settings = BQW_Grid_Accordion_Settings::getPanelSettings();

		if ( $type === 'posts' ) {
			$post_names = $this->get_post_names();

			include( 'views/posts-panel-settings.php' );
		} else if ( $type === 'gallery' ) {
			include( 'views/gallery-panel-settings.php' );
		} else if ( $type === 'flickr' ) {
			include( 'views/flickr-panel-settings.php' );
		} else {
			include( 'views/custom-panel-settings.php' );
		}
	}

	/**
	 * Return the names of all registered post types
	 *
	 * It arranges the data in an associative array that contains
	 * the name of the post type as the key and and an array, containing 
	 * both the post name and post value, as the value:
	 *
	 * name => ( name, label )
	 *
	 * After the data is fetched, it is stored in a transient for 5 minutes.
	 * Before fetching the data, the function tries to get the data
	 * from the transient.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The list of names for the registered post types.
	 */
	public function get_post_names() {
		$result = array();
		$post_names_transient = get_transient( 'grid_accordion_post_names' );

		if ( $post_names_transient === false ) {
			$post_types = get_post_types( '', 'objects' );

			unset( $post_types['attachment'] );
			unset( $post_types['revision'] );
			unset( $post_types['nav_menu_item'] );

			foreach ( $post_types as $post_type ) {
				$result[ $post_type->name ] = array( 'name' => $post_type->name , 'label' => $post_type->label );
			}

			set_transient( 'grid_accordion_post_names', $result, 5 * 60 );
		} else {
			$result = $post_names_transient;
		}

		return $result;
	}

	/**
	 * AJAX call for getting the registered taxonomies.
	 *
	 * It's called when the post names are selected manually
	 * in the panel's settings window.
	 *
	 * @since 1.0.0
	 */
	public function ajax_get_taxonomies() {
		$post_names = json_decode( stripslashes( $_GET['post_names'] ), true );

		echo json_encode( $this->get_taxonomies_for_posts( $post_names ) );

		die();
	}

	/**
	 * Loads the taxonomies associated with the selected post names.
	 *
	 * It tries to find cached data for post names and their taxonomies,
	 * stored in the 'grid_accordion_posts_data' transient. If there is any
	 * cached data and if selected post names are in the cached data, those
	 * post names and their taxonomy data are added to the result. Post names 
	 * that are not found in the transient are added to the list of posts to load.
	 * After these posts are loaded, the transient is updated to include the
	 * newly loaded post names, and their taxonomy data.
	 *
	 * While the transient will contain all the post names and taxonomies
	 * loaded in the past and those requested now, the result will include
	 * only post names and taxonomies requested now.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array $post_names The array of selected post names.
	 * @return array             The array of selected post names and their taxonomies.
	 */
	public function get_taxonomies_for_posts( $post_names ) {
		$result = array();
		$posts_to_load = array();

		$posts_data_transient = get_transient( 'grid_accordion_posts_data' );

		if ( $posts_data_transient === false || empty( $posts_data_transient ) === true ) {
			$posts_to_load = $post_names;
			$posts_data_transient = array();
		} else {
			foreach ( $post_names as $post_name ) {
				if ( array_key_exists( $post_name, $posts_data_transient ) === true ) {
					$result[ $post_name ] = $posts_data_transient[ $post_name ];
				} else {
					array_push( $posts_to_load, $post_name );
				}
			}
		}

		foreach ( $posts_to_load as $post_name ) {
			$taxonomies = get_object_taxonomies( $post_name, 'objects' );

			$result[ $post_name ] = array();

			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_terms( $taxonomy->name, 'objects' );

				if ( ! empty( $terms ) ) {
					$result[ $post_name ][ $taxonomy->name ] = array(
						'name' => $taxonomy->name,
						'label' => $taxonomy->label,
						'terms' => array()
					);

					foreach ( $terms as $term ) {
						$result[ $post_name ][ $taxonomy->name ]['terms'][ $term->name ] = array(
							'name' => $term->name,
							'slug' => $term->slug,
							'full' => $taxonomy->name . '|' . $term->name
						);
					}
				}
			}

			$posts_data_transient[ $post_name ] = $result[ $post_name ];
		}

		set_transient( 'grid_accordion_posts_data', $posts_data_transient, 5 * 60 );
		
		return $result;
	}

	/**
	 * AJAX call for adding a new breakpoint section.
	 *
	 * @since 1.0.0
	 */
	public function ajax_add_breakpoint() {
		$width = $_GET['data'];

		include( 'views/breakpoint.php' );

		die();
	}

	/**
	 * AJAX call for adding a new breakpoint setting.
	 *
	 * @since 1.0.0
	 */
	public function ajax_add_breakpoint_setting() {
		$setting_name = $_GET['data'];

		echo $this->create_breakpoint_setting( $setting_name, false );

		die();
	}

	/**
	 * Return the HTML markup for the breakpoint setting.
	 *
	 * Generates a unique number that will be attributed to
	 * the label and to the input/select field.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $name  The name of the setting.
	 * @param  mixed  $value The value of the setting. If false, the default setting value will be assigned.
	 * @return string        The HTML markup for the setting.
	 */
	public function create_breakpoint_setting( $name, $value ) {
		$setting = BQW_Grid_Accordion_Settings::getSettings( $name );
		$setting_value = $value !== false ? $value : $setting['default_value'];
		$setting_html = '';
		$uid = mt_rand();

		if ( $setting['type'] === 'number' || $setting['type'] === 'mixed' ) {
            $setting_html = '
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<input id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" type="text" name="' . $name . '" value="' . esc_attr( $setting_value ) . '" />
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        } else if ( $setting['type'] === 'boolean' ) {
            $setting_html = '
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<input id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" type="checkbox" name="' . $name . '"' . ( $setting_value === true ? ' checked="checked"' : '' ) . ' />
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        } else if ( $setting['type'] === 'select' ) {
            $setting_html ='
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<select id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" name="' . $name . '">';
            
            foreach ( $setting['available_values'] as $value_name => $value_label ) {
                $setting_html .= '<option value="' . $value_name . '"' . ( $setting_value == $value_name ? ' selected="selected"' : '' ) . '>' . $value_label . '</option>';
            }
            
            $setting_html .= '
            			</select>
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        }

        return $setting_html;
	}

	/**
	 * AJAX call for deleting the cached accordions
	 * stored using transients.
	 *
	 * It's called from the Plugin Settings page.
	 *
	 * @since 1.0.0
	 */
	public function ajax_clear_all_cache() {
		$nonce = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'clear-all-cache' ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		global $wpdb;

		$wpdb->query( "DELETE FROM " . $wpdb->prefix . "options WHERE option_name LIKE '%grid_accordion_cache%'" );

		echo true;

		die();
	}

	/**
	 * AJAX call for closing the Getting Started info box.
	 *
	 * @since 1.0.0
	 */
	public function ajax_getting_started_close() {
		update_option( 'grid_accordion_hide_getting_started_info', true );

		die();
	}
}