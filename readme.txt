=== Simple Fullscreen Responsive Slider ===
Contributors: chrisstephens
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DAAYWU24GLCHL
Tags: slider, responsive, responsive slider, fullscreen, fullscreen slider, fullscreen gallery, full screen, slideshow, images, slider plugin, wordpress slider, retina display, 4k display, mobile display, media queries, nivo, flexslider, revolution slider, multipostthumbnails, multiple post thumbnails, layerslider, image slider, image fader
Requires at least: 3.0.0
Tested up to: 3.9.1
Stable tag: 1.0.0
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Fullscreen Responsive Slider is an easy-to-use, lightweight, responsive, fullscreen slider that supports MultiPostThumbnails and custom CSS.

== Description ==

Simple Fullscreen Responsive Slider (or Simple Slider) is exactly that—an
easy-to-use, lightweight, responsive slider plugin designed to add a fullscreen
slide show to your front page. Visit <a href="http://www.twirlingumbrellas.com/wordpress/simple-slider-fullscreen-responsive-wordpress-slider-plugin/">our blog</a>
for more information.

**DEVELOPER-FRIENDLY**

The plugin is white box and features no branding on the slide editor or options
page. Our goal was to create a useful slider that developers would enjoy using
on client projects.

**CUSTOMIZABLE**

The plugin provides either a fading or sliding transition (with customizable
slide and effect durations), slide overlays, and allows developers to edit all
CSS directly from the options screen. Alternatively, you can leave the custom
CSS blank and add the required styles into your main stylesheet.

**RESPONSIVE DESIGN**

When combined with Chris Scott/VOCE Platform's awesome Multiple Post Thumbnails
plugin (see <a href="https://wordpress.org/plugins/multiple-post-thumbnails/">
Multiple Post Thumbnails</a>), users can attach up to six separate images for a
true responsive slider. The plugin will prompt for six different backgrounds and
use those images according to the device used (instead of sending large images
to mobile devices and comparably low resolution images to retina and 4K displays).

The slider uses Patrick Kunka's EasyFader jQuery plugin (visit
https://github.com/patrickkunka/easyfader for more information). 


== Installation ==

1. See <a href="http://codex.wordpress.org/Managing_Plugins">Managing Plugins</a> for instructions on installing this plugin. 
1. Or upload the unzipped plugin folder to your '/wp-content/plugins/' directory and activate it from your 'Plugins' menu.
1. If you wish to include multiple backgrounds, visit <a href="https://wordpress.org/plugins/multiple-post-thumbnails/">https://wordpress.org/plugins/multiple-post-thumbnails/</a> and install the MultiPostThumbnails plugin as well.
1. Add the code listed below to your theme (typically this can be added after your body or header markup).
1. Navigate to "Settings > Slider Options" and, at a minimum, save the default options.

`<?php if ( shortcode_exists( 'simple-slider' ) ) : do_shortcode('[simple-slider]'); endif; ?>`

== Frequently Asked Questions ==

Let us know if you have any questions!

== Screenshots ==

1. The options panel for Simple Slider. 

== Changelog ==

1.0.0 - Initial Release Tested to 3.9.1.

== Upgrade Notice ==

Upgrade Notice