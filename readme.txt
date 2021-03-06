=== Grid Accordion ===
Contributors: bqworks
Tags: grid accordion, responsive grid, image grid, grid plugin, grid widget
Requires at least: 3.6
Tested up to: 5.8.1
Stable tag: 1.8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fully responsive and touch-enabled grid accordion plugin for WordPress.

== Description ==

Grid Accordion combines the look and functionality of a grid with that of an accordion, allowing you to create image grids which are fully responsive and mobile-friendly.

Features:

* Fully responsive
* Touch support
* Customizable number of columns
* Possibility to change the aspect and configuration of the grid based on screen size
* Animated and static layers, which can contain text, images or any HTML content
* Keyboard navigation
* Mouse wheel navigation
* Pagination for the panels
* Retina support
* Lazy loading
* Deep linking
* Lightbox integration
* Swap image when the panel is opened
* Clean and intuitive admin interface
* Preview grid accordions directly in the admin area
* Drag and drop panel sorting
* Publish grid accordions in any post (including pages and custom post types), in PHP code, and widget areas
* Caching system for quick loading times
* Optimized file loading. The JavaScript and CSS files are loaded only in pages where there are grid accordions
* Load images and content dynamically, from posts (including custom post types), WordPress galleries and Flickr
* Action and filter hooks
* Import and export grid accordions

[These videos](http://bqworks.net/grid-accordion/screencasts/) demonstrate the full capabilities of the plugin.

== Installation ==

To install the plugin:

1. Install the plugin through Plugins > Add New > Upload or by copying the unzipped package to wp-content/plugins/.
2. Activate the Grid Accordion plugin through the 'Plugins > Installed Plugins' menu in WordPress.

To create grid accordions:

1. Go to Grid Accordion > Add New and click the 'Add Panels' button.
2. Select one or more images from the Media Library and click 'Insert into post'. 
3. After you customized the grid accordion, click the 'Create' button.

To publish grid accordions:

Copy the [grid_accordion id="1"] shortcode in the post or page where you want the accordion to appear. You can also insert it in PHP code by using <?php do_shortcode( '[grid_accordion id="1"]' ); ?>, or in the widgets area by using the built-in Grid Accordion widget.

== Frequently Asked Questions ==

= How can I set the size of the images? =

When you select an image from the Media Library, in the right columns, under 'ATTACHMENT DISPLAY SETTINGS', you can use the 'Size' option to select the most appropriate size for the images.

== Screenshots ==

1. Grid accordion with text layers.
2. Simple grid accordion.
3. Grid accordion with mixed content.
4. The admin interface for creating and editing an accordion.
5. The preview window in the admin area.
6. The layer editor in the admin area.
7. The background image editor in the admin area.
8. Adding dynamic tags for accordions generated from posts.

== Changelog ==

= 1.8.0 =
* initial release on WordPress.org
* fix styling for sidebar panels