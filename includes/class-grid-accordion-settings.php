<?php
/**
 * Contains the default settings for the accordion, panels, layers etc.
 * 
 * @since 1.0.0
 */
class BQW_Grid_Accordion_Settings {

	/**
	 * The accordion's settings.
	 * 
	 * The array contains the name, label, type, default value, 
	 * JavaScript name and description of the setting.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $settings = array();

	/**
	 * The groups of settings.
	 *
	 * The settings are grouped for the purpose of generating
	 * the accordion's admin sidebar.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $setting_groups = array();

	/**
	 * Layer settings.
	 *
	 * The array contains the name, label, type, default value
	 * and description of the setting.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $layer_settings = array();

	/**
	 * Panel settings.
	 *
	 * The array contains the name, label, type, default value
	 * and description of the setting.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $panel_settings = array();

	/**
	 * List of settings that can be used for breakpoints.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $breakpoint_settings = array(
		'width',
		'height',
		'columns',
		'rows',
		'responsive',
		'responsive_mode',
		'aspect_ratio',
		'orientation',
		'panel_distance'
	);

	/**
	 * Hold the state (opened or closed) of the sidebar panels.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $panels_state = array(
		'appearance' => '',
		'animations' => 'closed',
		'autoplay' => 'closed',
		'mouse_wheel' => 'closed',
		'keyboard' => 'closed',
		'swap_background' => 'closed',
		'touch_swipe' => 'closed',
		'lightbox' => 'closed',
		'video' => 'closed',
		'miscellaneous' => 'closed',
		'breakpoints'  => 'closed'
	);

	/**
	 * Holds the plugin settings.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	protected static $plugin_settings = array();

	/**
	 * Return the accordion settings.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string      $name The name of the setting. Optional.
	 * @return array|mixed       The array of settings or the value of the setting.
	 */
	public static function getSettings( $name = null ) {
		if ( empty( self::$settings ) ) {
			self::$settings = array(
				'width' => array(
					'js_name' => 'width',
					'label' => __( 'Width', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 800,
					'description' => __( 'Sets the width of the accordion. Can be set to a fixed value, like 900 (indicating 900 pixels), or to a percentage value, like 100%. In order to make the accordion responsive, it\'s not necessary to use percentage values. More about this in the description of the Responsive option.', 'grid-accordion' )
				),
				'height' => array(
					'js_name' => 'height',
					'label' => __( 'Height', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 400,
					'description' => __( 'Sets the height of the accordion. Can be set to a fixed value, like 400 (indicating 400 pixels). It\'s not recommended to set this to a percentage value, and it\'s not usually needed, as the accordion will be responsive even with a fixed value set for the height.', 'grid-accordion' )
				),
				'columns' => array(
					'js_name' => 'columns',
					'label' => __( 'Columns', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 4,
					'description' => __( 'Sets the number of columns. If it\'s set to -1, the number of columns will be determined automatically, based on the number of rows. <br/> Note: The \'columns\' the \'rows\' can\'t be set to -1 at the same time; one must have a specific value. Also, when either is set to -1, all the panels will be contained in a single page.', 'grid-accordion' )
				),
				'rows' => array(
					'js_name' => 'rows',
					'label' => __( 'Rows', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 3,
					'description' => __( 'Sets the number of rows. If it\'s set to -1, the number of rows will be determined automatically, based on the number of columns. <br/> Note: The \'columns\' the \'rows\' can\'t be set to -1 at the same time; one must have a specific value. Also, when either is set to -1, all the panels will be contained in a single page.', 'grid-accordion' )
				),
				'responsive' => array(
					'js_name' => 'responsive',
					'label' => __( 'Responsive', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Makes the accordion responsive. The accordion can be responsive even if the Width and/or Height options are set to fixed values. In this situation, the Width and Height will act as the maximum width and height of the accordion.', 'grid-accordion' )
				),
				'responsive_mode' => array(
					'js_name' => 'responsiveMode',
					'label' => __( 'Responsive Mode', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'auto',
					'available_values' => array(
						'auto' => __( 'Auto', 'grid-accordion' ),
						'custom' => __( 'Custom', 'grid-accordion' )
					),
					'description' => __( '\'Auto\' resizes the accordion and all of its elements (e.g., layers, videos) automatically, while \'Custom\' resizes only the accordion container and panels, and you are given flexibility over the way inner elements (e.g., layers, videos) will respond to smaller sizes. For example, you could use CSS media queries to define different text sizes or to hide certain elements when the accordion becomes smaller, ensuring that all content remains readable without having to zoom in. It\'s important to note that, if \'Auto\' responsiveness is used, the \'Width\' and \'Height\' need to be set to fixed values, so that the accordion can calculate correctly how much it needs to scale.', 'grid-accordion' )
				),
				'aspect_ratio' => array(
					'js_name' => 'aspectRatio',
					'label' => __( 'Aspect Ratio', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => -1,
					'description' => __( 'Sets the aspect ratio of the accordion. The accordion will set its height depending on what value its width has, so that this ratio is maintained. For this reason, the set \'Height\' might be overridden. This property can be used only when \'Responsive Mode\' is set to \'Custom\'. When it\'s set to \'Auto\', the \'Aspect Ratio\' needs to remain -1.', 'grid-accordion' )
				),
				'orientation' => array(
					'js_name' => 'orientation',
					'label' => __( 'Orientation', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'horizontal',
					'available_values' => array(
						'horizontal' => __( 'Horizontal', 'grid-accordion' ),
						'vertical' => __( 'Vertical', 'grid-accordion' )
					),
					'description' => __( 'Sets the orientation of the panels.', 'grid-accordion' )
				),
				'shadow' => array(
					'js_name' => 'shadow',
					'label' => __( 'Shadow', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the panels will have a drop shadow effect.', 'grid-accordion' )
				),
				'panel_distance' => array(
					'js_name' => 'panelDistance',
					'label' => __( 'Panel Distance', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => __( 'Sets the distance between consecutive panels. Can be set to a percentage or fixed value.', 'grid-accordion' )
				),
				'start_panel' => array(
					'js_name' => 'startPanel',
					'label' => __( 'Start Panel', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => -1,
					'description' => __( 'Indicates which panel will be opened when the accordion loads (0 for the first panel, 1 for the second panel, etc.). If set to -1, no panel will be opened.', 'grid-accordion' )
				),
				'start_page' => array(
					'js_name' => 'startPage',
					'label' => __( 'Start Page', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 0,
					'description' => __( 'Indicates which page will be opened when the accordion loads, if the panels are displayed on more than one page.', 'grid-accordion' )
				),
				'shuffle' => array(
					'js_name' => 'shuffle',
					'label' => __( 'Shuffle', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the panels will be randomized.', 'grid-accordion' )
				),
				'custom_class' => array(
					'label' => __( 'Custom Class', 'grid-accordion' ),
					'type' => 'text',
					'default_value' => '',
					'description' => __( 'Adds a custom class to the accordion, for use in custom CSS. Add the class name without the dot, i.e., you need to add <i>my-accordion</i>, not <i>.my-accordion</i>.', 'grid-accordion' )
				),
				'opened_panel_width' => array(
					'js_name' => 'openedPanelWidth',
					'label' => __( 'Opened Panel Width', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 'max',
					'description' => __( 'Sets the width of the opened panel. Possible values are: \'max\', which will open the panel to its maximum width, so that all the inner content is visible, a percentage value, like \'50%\', which indicates the percentage of the total width of the accordion, a fixed value, or \'auto\'. If it\'s set to \'auto\', all panels opened on the vertical axis will have the same width without any of these panels opening more than their size.', 'grid-accordion' )
				),
				'opened_panel_height' => array(
					'js_name' => 'openedPanelHeight',
					'label' => __( 'Opened Panel Height', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 'max',
					'description' => __( 'Sets the height of the opened panel. Possible values are: \'max\', which will open the panel to its maximum height, so that all the inner content is visible, a percentage value, like \'50%\', which indicates the percentage of the total height of the accordion, a fixed value, or \'auto\'. If it\'s set to \'auto\', all panels opened on the vertical axis will have the same height without any of these panels opening more than their size.', 'grid-accordion' )
				),
				'max_opened_panel_width' => array(
					'js_name' => 'maxOpenedPanelWidth',
					'label' => __( 'Max Opened Panel Width', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => '70%',
					'description' => __( 'Sets the maximum allowed width of the opened panel. This should be used when the \'Opened Panel Width\' setting is set to \'max\', because sometimes the maximum width of the panel might be too big and we want to set a limit. The property can be set to a percentage (of the total width of the accordion) or to a fixed value.', 'grid-accordion' )
				),
				'max_opened_panel_height' => array(
					'js_name' => 'maxOpenedPanelHeight',
					'label' => __( 'Max Opened Panel Height', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => '70%',
					'description' => __( 'Sets the maximum allowed height of the opened panel. This should be used when the \'Opened Panel Width\' setting is set to \'max\', because sometimes the maximum height of the panel might be too big and we want to set a limit. The property can be set to a percentage (of the total height of the accordion) or to a fixed value.', 'grid-accordion' )
				),
				'open_panel_on' => array(
					'js_name' => 'openPanelOn',
					'label' => __( 'Open Panel On', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'hover',
					'available_values' => array(
						'hover' => __( 'Hover', 'grid-accordion' ),
						'click' => __( 'Click', 'grid-accordion' ),
						'never' => __( 'Never', 'grid-accordion' )
					),
					'description' => __( 'If set to \'Hover\', the panels will be opened by moving the mouse pointer over them; if set to \'Click\', the panels will open when clicked. Can also be set to \'never\' to disable the opening of the panels.', 'grid-accordion' )
				),
				'close_panels_on_mouse_out' => array(
					'js_name' => 'closePanelsOnMouseOut',
					'label' => __( 'Close Panels On Mouse Out', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Determines whether the opened panel closes or remains open when the mouse pointer is moved away.', 'grid-accordion' )
				),
				'mouse_delay' => array(
					'js_name' => 'mouseDelay',
					'label' => __( 'Mouse Delay', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 200,
					'description' => __( 'Sets the delay in milliseconds between the movement of the mouse pointer and the opening of the panel. Setting a delay ensures that panels are not opened if the mouse pointer only moves over them without an intent to open the panel.', 'grid-accordion' )
				),
				'open_panel_duration' => array(
					'js_name' => 'openPanelDuration',
					'label' => __( 'Open Panel Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 700,
					'description' => __( 'Determines the duration in milliseconds for the opening animation of the panel.', 'grid-accordion' )
				),
				'close_panel_duration' => array(
					'js_name' => 'closePanelDuration',
					'label' => __( 'Close Panel Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 700,
					'description' => __( 'Determines the duration in milliseconds for the closing animation of the panel.', 'grid-accordion' )
				),
				'page_scroll_duration' => array(
					'js_name' => 'pageScrollDuration',
					'label' => __( 'Page Scroll Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 500,
					'description' => __( 'Indicates the duration of the page scrolling animation.', 'grid-accordion' )
				),
				'page_scroll_easing' => array(
					'js_name' => 'pageScrollEasing',
					'label' => __( 'Page Scroll Easing', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'swing',
					'available_values' => array(
						'swing' => 'Swing',
						'easeInQuad' => 'Quad In',
						'easeOutQuad' => 'Quad Out',
						'easeInOutQuad' => 'Quad In Out',
						'easeInCubic' => 'Cubic In',
						'easeOutCubic' => 'Cubic Out',
						'easeInOutCubic' => 'Cubic In Out',
						'easeInQuart' => 'Quart In',
						'easeOutQuart' => 'Quart Out',
						'easeInOutQuart' => 'Quart In Out',
						'easeInQuint' => 'Quint In',
						'easeOutQuint' => 'Quint Out',
						'easeInOutQuint' => 'Quint In Out',
						'easeInSine' => 'Sine In',
						'easeOutSine' => 'Sine Out',
						'easeInOutSine' => 'Sine In Out',
						'easeInExpo' => 'Expo In',
						'easeOutExpo' => 'Expo Out',
						'easeInOutExpo' => 'Expo In Out',
						'easeInCirc' => 'Circ In',
						'easeOutCirc' => 'Circ Out',
						'easeInOutCirc' => 'Circ In Out',
						'easeInElastic' => 'Elastic In',
						'easeOutElastic' => 'Elastic Out',
						'easeInOutElastic' => 'Elastic In Out',
						'easeInBack' => 'Back In',
						'easeOutBack' => 'Back Out',
						'easeInOutBack' => 'Back In Out',
						'easeInBounce' => 'Bounce In',
						'easeOutBounce' => 'Bounce Out',
						'easeInOutBounce' => 'Bounce In Out'
					),
					'description' => __( 'Indicates the easing type of the page scrolling animation.', 'grid-accordion' )
				),

				'autoplay' => array(
					'js_name' => 'autoplay',
					'label' => __( 'Autoplay', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the autoplay will be enabled.', 'grid-accordion' )
				),
				'autoplay_delay' => array(
					'js_name' => 'autoplayDelay',
					'label' => __( 'Autoplay Delay', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 5000,
					'description' => __( 'Sets the delay, in milliseconds, of the autoplay cycle.', 'grid-accordion' )
				),
				'autoplay_direction' => array(
					'js_name' => 'autoplayDirection',
					'label' => __( 'Autoplay Direction', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'normal',
					'available_values' => array(
						'normal' =>  __( 'Normal', 'grid-accordion' ),
						'backwards' =>  __( 'Backwards', 'grid-accordion' )
					),
					'description' => __( 'Sets the direction in which the panels will be opened. Can be set to \'Normal\' (ascending order) or \'Backwards\' (descending order).', 'grid-accordion' )
				),
				'autoplay_on_hover' => array(
					'js_name' => 'autoplayOnHover',
					'label' => __( 'Autoplay On Hover', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'pause',
					'available_values' => array(
						'pause' => __( 'Pause', 'grid-accordion' ),
						'stop' => __( 'Stop', 'grid-accordion' ),
						'none' => __( 'None', 'grid-accordion' )
					),
					'description' => __( 'Indicates if the autoplay will be paused when the accordion is hovered.', 'grid-accordion' )
				),

				'mouse_wheel' => array(
					'js_name' => 'mouseWheel',
					'label' => __( 'Mouse Wheel', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the accordion will respond to mouse wheel input.', 'grid-accordion' )
				),
				'mouse_wheel_sensitivity' => array(
					'js_name' => 'mouseWheelSensitivity',
					'label' => __( 'Mouse Wheel Sensitivity', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => __( 'Sets how sensitive the accordion will be to mouse wheel input. Lower values indicate stronger sensitivity.', 'grid-accordion' )
				),
				'mouse_wheel_target' => array(
					'js_name' => 'mouseWheelTarget',
					'label' => __( 'Mouse Wheel Target', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'panel',
					'available_values' => array(
						'panel' => __( 'Panel', 'grid-accordion' ),
						'page' => __( 'Page', 'grid-accordion' )
					),
					'description' => __( 'Sets what elements will be targeted by the mouse wheel input. Can be set to \'Panel\' or \'Page\'. Setting it to \'Panel\' will indicate that the panels will be scrolled, while setting it to \'Page\' indicate that the pages will be scrolled.', 'grid-accordion' )
				),

				'keyboard' => array(
					'js_name' => 'keyboard',
					'label' => __( 'Keyboard', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the accordion will respond to keyboard input.', 'grid-accordion' )
				),

				'keyboard_only_on_focus' => array(
					'js_name' => 'keyboardOnlyOnFocus',
					'label' => __( 'Keyboard Only On Focus', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the accordion will respond to keyboard input only if the accordion has focus.', 'grid-accordion' )
				),

				'keyboard_target' => array(
					'js_name' => 'keyboardTarget',
					'label' => __( 'Keyboard Target', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'panel',
					'available_values' => array(
						'panel' => __( 'Panel', 'grid-accordion' ),
						'page' => __( 'Page', 'grid-accordion' )
					),
					'description' => __( 'Sets what elements will be targeted by the keyboard input. Can be set to \'Panel\' or \'Page\'. Setting it to \'Panel\' will indicate that the panels will be scrolled, while setting it to \'Page\' indicate that the pages will be scrolled.', 'grid-accordion' )
				),

				'swap_background_duration' => array(
					'js_name' => 'swapBackgroundDuration',
					'label' => __( 'Swap Background Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 700,
					'description' => __( 'Sets the duration, in milliseconds, of the transition effect.', 'grid-accordion' )
				),
				'fade_out_background' => array(
					'js_name' => 'fadeOutBackground',
					'label' => __( 'Fade Out Background', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the main image background will be faded out when the opened/alternative background fades in.', 'grid-accordion' )
				),

				'touch_swipe' => array(
					'js_name' => 'touchSwipe',
					'label' => __( 'Touch Swipe', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the touch swipe functionality will be enabled.', 'grid-accordion' )
				),
				'touch_swipe_threshold' => array(
					'js_name' => 'touchSwipeThreshold',
					'label' => __( 'Touch Swipe Threshold', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => __( 'Sets how many pixels the distance of the swipe gesture needs to be in order to trigger a page change.', 'grid-accordion' )
				),

				'lightbox' => array(
					'js_name' => 'lightbox',
					'label' => __( 'Lightbox', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the links specified to the background images will be opened in a lightbox.', 'grid-accordion' )
				),

				'open_panel_video_action' => array(
					'js_name' => 'openPanelVideoAction',
					'label' => __( 'Open Panel Video Action', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'playVideo',
					'available_values' => array(
						'playVideo' => __( 'Play Video', 'grid-accordion' ),
						'none' => __( 'None', 'grid-accordion' )
					),
					'description' => __( 'Sets what the video will do when the panel is opened. Can be set to \'Play Video\' or \'None\'.', 'grid-accordion' )
				),
				'close_panel_video_action' => array(
					'js_name' => 'closePanelVideoAction',
					'label' => __( 'Close Panel Video Action', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'pauseVideo',
					'available_values' => array(
						'pauseVideo' => __( 'Pause Video', 'grid-accordion' ),
						'stopVideo' => __( 'Stop Video', 'grid-accordion' )
					),
					'description' => __( 'Sets what the video will do when the panel is closed. Can be set to \'Pause Video\' or \'Stop Video\'.', 'grid-accordion' )
				),
				'play_video_action' => array(
					'js_name' => 'playVideoAction',
					'label' => __( 'Play Video Action', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'stopAutoplay',
					'available_values' => array(
						'stopAutoplay' => __( 'Stop Autoplay', 'grid-accordion' ),
						'none' => __( 'None', 'grid-accordion' )
					),
					'description' => __( 'Sets what the accordion will do when a video starts playing. Can be set to \'Stop Autoplay\' or \'None\'.', 'grid-accordion' )
				),
				'pause_video_action' => array(
					'js_name' => 'pauseVideoAction',
					'label' => __( 'Pause Video Action', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'startAutoplay' => __( 'Start Autoplay', 'grid-accordion' ),
						'none' => 'None'
					),
					'description' => __( 'Sets what the accordion will do when a video is paused. Can be set to \'Start Autoplay\' or \'None\'.', 'grid-accordion' )
				),
				'end_video_action' => array(
					'js_name' => 'endVideoAction',
					'label' => __( 'End Video Action', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'startAutoplay' => __( 'Start Autoplay', 'grid-accordion' ),
						'nextPanel' => __( 'Next Panel', 'grid-accordion' ),
						'replayVideo' => __( 'Replay Video', 'grid-accordion' ),
						'none' => 'None'
					),
					'description' => __( 'Sets what the accordion will do when a video ends. Can be set to \'Start Autoplay\', \'Next Panel\', \'Replay Video\' or \'None\'.', 'grid-accordion' )
				),

				'lazy_loading' => array(
					'label' => __( 'Lazy Loading', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the background images will be loaded only when they are visible. Images from accordion pages that are not visible, will not be loaded.', 'grid-accordion' )
				),
				'hide_image_title' => array(
					'label' => __( 'Hide Image Title', 'grid-accordion' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the title tag will be removed from images in order to prevent the title to show up in a tooltip when the image is hovered.', 'grid-accordion' )
				),
				'link_target' => array(
					'js_name' => 'linkTarget',
					'label' => __( 'Link Target', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => '_self',
					'available_values' => array(
						'_self' => __( 'Self', 'grid-accordion' ),
						'_blank' => __( 'Blank', 'grid-accordion' ),
						'_parent' => __( 'Parent', 'grid-accordion' ),
						'_top' => __( 'Top', 'grid-accordion' )
					),
					'description' => __( 'Sets the location where the slide links will be opened.', 'grid-accordion' )
				)
			);

			self::$settings = apply_filters( 'grid_accordion_default_settings', self::$settings );
		}

		if ( ! is_null( $name ) ) {
			return self::$settings[ $name ];
		}

		return self::$settings;
	}

	/**
	 * Return the setting groups.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of setting groups.
	 */
	public static function getSettingGroups() {
		if ( empty( self::$setting_groups ) ) {
			self::$setting_groups = array(
				'appearance' => array(
					'label' => __( 'Appearance', 'grid-accordion' ),
					'list' => array(
						'width',
						'height',
						'columns',
						'rows',
						'responsive',
						'responsive_mode',
						'aspect_ratio',
						'orientation',
						'shadow',
						'panel_distance',
						'start_panel',
						'start_page',
						'shuffle',
						'custom_class'
					)
				),

				'animations' => array(
					'label' => __( 'Animations', 'grid-accordion' ),
					'list' => array(
						'opened_panel_width',
						'opened_panel_height',
						'max_opened_panel_width',
						'max_opened_panel_height',
						'open_panel_on',
						'close_panels_on_mouse_out',
						'mouse_delay',
						'open_panel_duration',
						'close_panel_duration',
						'page_scroll_duration',
						'page_scroll_easing'
					)
				),

				'autoplay' => array(
					'label' => __( 'Autoplay', 'grid-accordion' ),
					'list' => array(
						'autoplay',
						'autoplay_delay',
						'autoplay_direction',
						'autoplay_on_hover'
					)
				),

				'mouse_wheel' => array(
					'label' => __( 'Mouse Wheel', 'grid-accordion' ),
					'list' => array(
						'mouse_wheel',
						'mouse_wheel_sensitivity',
						'mouse_wheel_target'
					)
				),

				'keyboard' => array(
					'label' => __( 'Keyboard', 'grid-accordion' ),
					'list' => array(
						'keyboard',
						'keyboard_only_on_focus',
						'keyboard_target'
					)
				),

				'swap_background' => array(
					'label' => __( 'Swap Background', 'grid-accordion' ),
					'list' => array(
						'swap_background_duration',
						'fade_out_background'
					)
				),

				'touch_swipe' => array(
					'label' => __( 'Touch Swipe', 'grid-accordion' ),
					'list' => array(
						'touch_swipe',
						'touch_swipe_threshold'
					)
				),

				'lightbox' => array(
					'label' => __( 'Lightbox', 'grid-accordion' ),
					'list' => array(
						'lightbox'
					),
					'inline_info' => array(
						__( 'By default, the accordion will open the background image in the lightbox, but at its full size.' , 'grid-accordion' ),
						__( 'If you want to open a different image or other content, you need to specify the custom content in the <i>Background Image</i> editor, in the <i>Link</i> field.' , 'grid-accordion' )
					)
				),

				'video' => array(
					'label' => __( 'Video', 'grid-accordion' ),
					'list' => array(
						'open_panel_video_action',
						'close_panel_video_action',
						'play_video_action',
						'pause_video_action',
						'end_video_action'
					)
				),

				'miscellaneous' => array(
					'label' => __( 'Miscellaneous', 'grid-accordion' ),
					'list' => array(
						'lazy_loading',
						'hide_image_title',
						'link_target'
					)
				)
			);
		}

		return self::$setting_groups;
	}
	
	/**
	 * Return the breakpoint settings.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of breakpoint settings.
	 */
	public static function getBreakpointSettings() {
		return apply_filters( 'grid_accordion_breakpoint_settings', self::$breakpoint_settings );
	}

	/**
	 * Return the default panels state.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of panels state.
	 */
	public static function getPanelsState() {
		return self::$panels_state;
	}

	/**
	 * Return the layer settings.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of layer settings.
	 */
	public static function getLayerSettings() {
		if ( empty( self::$layer_settings ) ) {
			self::$layer_settings = array(
				'type' => array(
					'label' => __( 'Type', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'div',
					'available_values' => array(
						'paragraph' => __( 'Paragraph', 'grid-accordion' ),
						'heading' => __( 'Heading', 'grid-accordion' ),
						'image' => __( 'Image', 'grid-accordion' ),
						'video' => __( 'Video', 'grid-accordion' ),
						'div' => __( 'DIV', 'grid-accordion' )
					),
					'description' => ''
				),
				'heading_type' => array(
					'label' => __( 'Heading Type', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'h3',
					'available_values' => array(
						'h1' => __( 'H1', 'grid-accordion' ),
						'h2' => __( 'H2', 'grid-accordion' ),
						'h3' => __( 'H3', 'grid-accordion' ),
						'h4' => __( 'H4', 'grid-accordion' ),
						'h5' => __( 'H5', 'grid-accordion' ),
						'h6' => __( 'H6', 'grid-accordion' )
					),
					'description' => ''
				),
				'display' => array(
					'label' => __( 'Display', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'always',
					'available_values' => array(
						'always' => __( 'Always', 'grid-accordion' ),
						'opened' => __( 'When opened', 'grid-accordion' ),
						'closed' => __( 'When closed', 'grid-accordion' )
					),
					'description' => ''
				),
				'position' => array(
					'label' => __( 'Position', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'topLeft',
					'available_values' => array(
						'topLeft' => __( 'Top Left', 'grid-accordion' ),
						'topRight' => __( 'Top Right', 'grid-accordion' ),
						'bottomLeft' => __( 'Bottom Left', 'grid-accordion' ),
						'bottomRight' => __( 'Bottom Right', 'grid-accordion' )
					),
					'description' => ''
				),
				'width' => array(
					'label' => __( 'Width', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 'auto',
					'description' => ''
				),
				'height' => array(
					'label' => __( 'Height', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => 'auto',
					'description' => ''
				),
				'horizontal' => array(
					'label' => __( 'Horizontal', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => '0',
					'description' => ''
				),
				'vertical' => array(
					'label' => __( 'Vertical', 'grid-accordion' ),
					'type' => 'mixed',
					'default_value' => '0',
					'description' => ''
				),
				'preset_styles' => array(
					'label' => __( 'Preset Styles', 'grid-accordion' ),
					'type' => 'multiselect',
					'default_value' => array( 'ga-black', 'ga-padding' ),
					'available_values' => array(
						'ga-black' => __( 'Black', 'grid-accordion' ),
						'ga-white' => __( 'White', 'grid-accordion' ),
						'ga-padding' => __( 'Padding', 'grid-accordion' ),
						'ga-rounded' => __( 'Round Corners', 'grid-accordion' )
					),
					'description' => ''
				),
				'custom_class' => array(
					'label' => __( 'Custom Class', 'grid-accordion' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'show_transition' => array(
					'label' => __( 'Show Transition', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'fade',
					'available_values' => array(
						'fade' => __( 'Fade', 'grid-accordion' ),
						'left' => __( 'Left', 'grid-accordion' ),
						'right' => __( 'Right', 'grid-accordion' ),
						'up' => __( 'Up', 'grid-accordion' ),
						'down' => __( 'Down', 'grid-accordion' )
					),
					'description' => ''
				),
				'show_offset' => array(
					'label' => __( 'Show Offset', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => ''
				),
				'show_delay' => array(
					'label' => __( 'Show Delay', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'show_duration' => array(
					'label' => __( 'Show Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 400,
					'description' => ''
				),
				'hide_transition' => array(
					'label' => __( 'Hide Transition', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'fade',
					'available_values' => array(
						'fade' => __( 'Fade', 'grid-accordion' ),
						'left' => __( 'Left', 'grid-accordion' ),
						'right' => __( 'Right', 'grid-accordion' ),
						'up' => __( 'Up', 'grid-accordion' ),
						'down' => __( 'Down', 'grid-accordion' )
					),
					'description' => ''
				),
				'hide_offset' => array(
					'label' => __( 'Hide Offset', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => ''
				),
				'hide_delay' => array(
					'label' => __( 'Hide Delay', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'hide_duration' => array(
					'label' => __( 'Hide Duration', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 400,
					'description' => ''
				)
			);

			self::$layer_settings = apply_filters( 'grid_accordion_default_layer_settings', self::$layer_settings );
		}

		return self::$layer_settings;
	}

	/**
	 * Return the panel settings.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of panel settings.
	 */
	public static function getPanelSettings() {
		if ( empty( self::$panel_settings ) ) {
			self::$panel_settings = array(
				'content_type' => array(
					'label' => __( 'Content Type', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'custom',
					'available_values' => array(
						'custom' => __( 'Custom Content', 'grid-accordion' ),
						'posts' => __( 'Content from posts', 'grid-accordion' ),
						'gallery' => __( 'Images from post\'s gallery', 'grid-accordion' ),
						'flickr' => __( 'Flickr images', 'grid-accordion' )
					),
					'description' => ''
				),
				'posts_post_types' => array(
					'label' => __( 'Post Types', 'grid-accordion' ),
					'type' => 'multiselect',
					'default_value' => array( 'post' ),
					'description' => ''
				),
				'posts_taxonomies' => array(
					'label' => __( 'Taxonomies', 'grid-accordion' ),
					'type' => 'multiselect',
					'default_value' => array(),
					'description' => ''
				),
				'posts_relation' => array(
					'label' => __( 'Match', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'OR',
					'available_values' => array(
						'OR' => __( 'At least one', 'grid-accordion' ),
						'AND' => __( 'All', 'grid-accordion' )
					),
					'description' => ''
				),
				'posts_operator' => array(
					'label' => __( 'With selected', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'IN',
					'available_values' => array(
						'IN' => __( 'Include', 'grid-accordion' ),
						'NOT IN' => __( 'Exclude', 'grid-accordion' )
					),
					'description' => ''
				),
				'posts_order_by' => array(
					'label' => __( 'Order By', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'date',
					'available_values' => array(
						'date' => __( 'Date', 'grid-accordion' ),
						'comment_count' => __( 'Comments', 'grid-accordion' ),
						'title' => __( 'Title', 'grid-accordion' ),
						'rand' => __( 'Random', 'grid-accordion' )
					),
					'description' => ''
				),
				'posts_order' => array(
					'label' => __( 'Order', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'DESC',
					'available_values' => array(
						'DESC' => __( 'Descending', 'grid-accordion' ),
						'ASC' => __( 'Ascending', 'grid-accordion' )
					),
					'description' => ''
				),
				'posts_maximum' => array(
					'label' => __( 'Limit', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'flickr_api_key' => array(
					'label' => __( 'API Key', 'grid-accordion' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'flickr_load_by' => array(
					'label' => __( 'Load By', 'grid-accordion' ),
					'type' => 'select',
					'default_value' => 'set_id',
					'available_values' => array(
						'set_id' => __( 'Set ID', 'grid-accordion' ),
						'user_id' => __( 'User ID', 'grid-accordion' )
					),
					'description' => ''
				),
				'flickr_id' => array(
					'label' => __( 'ID', 'grid-accordion' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'flickr_per_page' => array(
					'label' => __( 'Limit', 'grid-accordion' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				)
			);

			self::$panel_settings = apply_filters( 'grid_accordion_default_panel_settings', self::$panel_settings );
		}

		return self::$panel_settings;
	}

	/**
	 * Return the plugin settings.
	 *
	 * @since 1.0.0
	 * 
	 * @return array The array of plugin settings.
	 */
	public static function getPluginSettings() {
		if ( empty( self::$plugin_settings ) ) {
			self::$plugin_settings = array(
				'load_stylesheets' => array(
					'label' => __( 'Load stylesheets', 'grid-accordion' ),
					'default_value' => 'automatically',
					'available_values' => array(
						'automatically' => __( 'Automatically', 'grid-accordion' ),
						'homepage' => __( 'On homepage', 'grid-accordion' ),
						'all' => __( 'On all pages', 'grid-accordion' )
					),
					'description' => __( 'The plugin can detect the presence of the accordion in a post, page or widget, and will automatically load the necessary stylesheets. However, when the accordion is loaded in PHP code, like in the theme\'s header or another template file, you need to manually specify where the stylesheets should load. If you load the accordion only on the homepage, select <i>On homepage</i>, or if you load it in the header or another section that is visible on multiple pages, select <i>On all pages</i>.' , 'grid-accordion' )
				),
				'load_unminified_scripts' => array(
					'label' => __( 'Load unminified scripts', 'grid-accordion' ),
					'default_value' => false,
					'description' => __( 'Check this option if you want to load the unminified/uncompressed CSS and JavaScript files for the accordion. This is useful for debugging purposes.', 'grid-accordion' )
				),
				'cache_expiry_interval' => array(
					'label' => __( 'Cache expiry interval', 'grid-accordion' ),
					'default_value' => 24,
					'description' => __( 'Indicates the time interval after which a grid\'s cache will expire. If the cache of a grid has expired, the grid will be rendered again and cached the next time it is viewed.', 'grid-accordion' )
				),
				'hide_inline_info' => array(
					'label' => __( 'Hide inline info', 'grid-accordion' ),
					'default_value' => false,
					'description' => __( 'Indicates whether the inline information will be displayed in admin panels and wherever it\'s available.', 'grid-accordion' )
				),
				'hide_getting_started_info' => array(
					'label' => __( 'Hide <i>Getting Started</i> info', 'grid-accordion' ),
					'default_value' => false,
					'description' => __( 'Indicates whether the <i>Getting Started</i> information will be displayed in the <i>All Accordions</i> page, above the list of accordions. This setting will be disabled if the <i>Close</i> button is clicked in the information box.', 'grid-accordion' )
				),
				'access' => array(
					'label' => __( 'Access', 'grid-accordion' ),
					'default_value' => 'manage_options',
					'available_values' => array(
						'manage_options' => __( 'Administrator', 'grid-accordion' ),
						'publish_pages' => __( 'Editor', 'grid-accordion '),
						'publish_posts' => __( 'Author', 'grid-accordion' ),
						'edit_posts' => __( 'Contributor', 'grid-accordion' )
					),
					'description' => __( 'Sets what category of users will have access to the plugin\'s admin area.', 'grid-accordion' )
				)
			);
		}

		return self::$plugin_settings;
	}
}