=== Simple Fullscreen Responsive Slider ===
Contributors: chrisstephens
Tags: slider, responsive, responsive slider, fullscreen, fullscreen slider, fullscreen gallery, slideshow, images, slider plugin, wordpress slider, retina display, 4k display, mobile display, media queries, nivo, flexslider, revolution slider, layerslider, image slider, image fader
Requires at least: 3.0.0
Tested up to: 3.9.1
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to add a simple, developer-friendly, fullscreen, responsive slider to your website's homepage.

== Description ==
Simple Fullscreen Responsive Slider (or Simple Slider) is exactly that—an easy-to-use, lightweight, developer-friendly, responsive slider plugin designed to add a fullscreen slideshow to your homepage. Users can choose from a fading or sliding transition (provided by Patrick Kunka's EasyFader jQuery plugins) and directly edit the default CSS to create any look they want. When combined with MultiPostThumbnails they can attach up to six additional images to each slide and have those images served according to the device being used (instead of sending large fullscreen images to mobile devices and comparably low resolution images to retina and 4K displays).

== Installation ==
1.	See <a href="http://codex.wordpress.org/Managing_Plugins">Managing Plugins</a> for details on installing this plugin. 
2.	If you wish to include multiple backgrounds, visit <a href="https://wordpress.org/plugins/multiple-post-thumbnails/">https://wordpress.org/plugins/multiple-post-thumbnails/</a> and install the MultiPostThumbnails plugin as well.
3.	Add the plugin code listed below to your theme (typically this can be added after your body or header markup).
4.	Navigate to "Settings > Slider Options" and, at a minimum, save the default options.

Plugin Code: 

<?php if ( shortcode_exists( 'simple-slider' ) ) : do_shortcode('[simple-slider]'); endif; ?>

== Frequently Asked Questions ==
Let us know if you have any questions!

== Screenshots ==
1. http://www.twirlingumbrellas.com/wp-content/uploads/2014/06/simple-slider-options-page.png

== Changelog ==
1.0.0 - Initial Release Tested to 3.9.1.

== Upgrade Notice ==
Upgrade Notice