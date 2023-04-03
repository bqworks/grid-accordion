=== Grid Accordion ===
Contributors: bqworks
Donate link: https://bqworks.net/premium-add-ons/
Tags: grid accordion, responsive grid, post grid, image grid, grid plugin, grid widget, lightbox grid,
Requires at least: 4.0
Tested up to: 6.2
Stable tag: 1.9.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Grid Accordion is a responsive gallery plugin that includes Premium features for FREE, like animated layers, lightbox support, post content and more.

== Description ==

Grid Accordion combines the look and functionality of a grid with that of an accordion, allowing you to create image grids which are fully responsive and mobile-friendly.

Features:

* Fully responsive on any device
* Touch support for touch-enabled screens
* Customizable number of columns
* Possibility to change the aspect and configuration of the grid based on screen size
* Animated and static layers, which can contain text, images or any HTML content
* Keyboard navigation
* Mouse wheel navigation
* Pagination for the panels
* Retina support
* Lazy loading for images
* Deep linking (link to specific slide inside the accordion)
* Lightbox integration
* Swap image when the panel is opened
* Clean and intuitive admin interface
* Preview grid accordions directly in the admin area
* Drag and drop panel sorting
* Publish grid accordions in any post (including pages and custom post types), in PHP code, and widget areas
* Caching system for quick loading times
* Optimized file loading. The JavaScript and CSS files are loaded only in pages where there are grid accordions
* Load images (e.g., featured images) and content dynamically, from posts (including custom post types), WordPress galleries and Flickr
* Action and filter hooks to add to the functionality of the plugin
* Import and export grid accordions

[These videos](https://bqworks.net/grid-accordion/screencasts/) demonstrate the full capabilities of the plugin.

[Premium Add-ons](https://bqworks.net/premium-add-ons/#grid-accordion) allow you to further extend the functionality of the grid accordion:

* [Custom CSS and JavaScript](https://bqworks.net/premium-add-ons/#custom-css-js-for-grid-accordion): Allows you to add custom CSS and JavaScript code to your grid accordions in a syntax highlighting code editor. It also features a revisions system that will backup all your code edits, allow you to compare between multiple revisions and restore a certain revision.
* [Revisions](https://bqworks.net/premium-add-ons/#revisions-for-grid-accordion): Automatically stores a record of each edit/update of your accordions, for comparison or backup purposes. Each accordion will have its own list of revisions, allowing you to easily preview a revision, analyze its settings, compare it to other revisions or restore it.


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

= 1.9.6 =
* improve support for gallery slides
* add support for deferred loading of scripts

= 1.9.5 =
* fix layers' admin settings bug
* modify user capability requirements for editing accordions

= 1.9.4 =
* add possibility to extend the sidebar settings panels
* other fixes and improvements

= 1.9.3 =
* add Gutenberg block

= 1.9.2 =
* some fixes and improvements

= 1.9.1 =
* added code mirror editor to HTML textareas
* add filter for allowed HTML tags
* other fixes and improvements

= 1.9.0 =
* added the add-on installation interface

= 1.8.2 =
* added the possibility to remove the existing custom CSS and JavaScript

= 1.8.1 =
* fixed the inline CSS widht and height of the grid accordion

= 1.8.0 =
* initial release on WordPress.org
* fix styling for sidebar panels