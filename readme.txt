=== Simple Fullscreen Responsive Slider ===
Contributors: chrisstephens
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DAAYWU24GLCHL
Tags: slider, responsive, responsive slider, fullscreen, fullscreen slider, fullscreen gallery, full screen, slideshow, images, slider plugin, wordpress slider, retina display, 4k display, mobile display, media queries, nivo, flexslider, revolution slider, multipostthumbnails, multiple post thumbnails, layerslider, image slider, image fader
Requires at least: 3.0.0
Tested up to: 3.9.1
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Fullscreen Responsive Slider is an easy-to-use, lightweight, responsive, fullscreen slider that supports MultiPostThumbnails and custom CSS.

== Description ==

Simple Fullscreen Responsive Slider (or Simple Slider) is exactly that—an
easy-to-use, lightweight, responsive slider plugin designed to add a fullscreen
slide show to your front page. It supports multiple post thumbnails for slide
backgrounds, has no branding, and you can edit all the CSS directly from the
options page (or add it into your stylesheet and leave the custom CSS blank).

Visit <a href="http://www.twirlingumbrellas.com/wordpress/simple-slider-fullscreen-responsive-wordpress-slider-plugin/">http://www.twirlingumbrellas.com/wordpress/simple-slider-fullscreen-responsive-wordpress-slider-plugin/</a>
for more information.

**DEVELOPER-FRIENDLY**

Or perhaps this section should read "client-friendly" as the plugin has no
branding on the slide editor or options page. Our goal was to create a useful
slider that other developers would feel comfortable with and enjoy using on
client projects. Note: The plugin is intended for developers and changing its
appearance requires customizing the default CSS.

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
to mobile devices and/or low resolution images to retina and 4K displays). If
you leave a slot open, it will search subsequently smaller sized images so, at
a minimum, you must attach an image to the smallest slot.

The slider uses Patrick Kunka's EasyFader jQuery plugin (visit
https://github.com/patrickkunka/easyfader for more information). 


== Installation ==

**INSTALLING THE PLUGIN**

The plugin can be installed and activated in the usual fashion. See
<a href="http://codex.wordpress.org/Managing_Plugins" target="_blank">Managing
Plugins</a> if you need help with this.

**ADDING THE CODE**

Most users will need to edit their theme and manually insert the following code
to display the slider. This is typically added after your opening body or header
tag and only works on your front page.

`<?php if ( shortcode_exists( 'simple-slider' ) ) : do_shortcode('[simple-slider]'); endif; ?>`

Note: If your theme has a fullwidth template, you may be able to add the shortcode
`[simple-slider]` directly in the page editor or theme options panel. Results
may vary.

**SAVING THE OPTIONS**

Lastly, you will need to, at a minimum, save the default options. You can do
this from the newly created "Settings > Slider Options" page. From here, you
can style the slider by customizing the default CSS.


== Frequently Asked Questions ==

Let us know if you have any questions or suggestions!

Q.	What happens if I use MultiPostThumbnails but do not fill (attach) all of the image sizes?
A.	The plugin will search for subsequently smaller sized images and use them to construct the media queries. As a result, the first (and smallest) image slot is required.

Q.	What are the image sizes used by Simple Slider?
A.	On its own, Simple Slider provides one featured image slot for a "one size fits all" background. If you have Multiple Post Thumbnails installed, Simple Slider will instead prompt for:

1. Smartphones: 888px by 888px (max-width: 1136px)
1. Tablets: 1366px by 768px (max-width: 1599px)
1. Laptops: 1600px by 900px (max-width: 1919px)
1. Desktops: 1920px by 1080px (max-width: 2559px)
1. Retina Displays: 2560px by 1600px (max-width: 3839px)
1. 4K Displays: 3840px by 2160px (min-width: 3839px) 



== Screenshots ==

1. The options panel for Simple Slider. 

== Changelog ==

1.0.1 - Fixed a PHP Warning (Thanks @jonhurleydesign)

1.0.0 - Initial Release Tested to 3.9.1.

== Upgrade Notice ==

Upgrade Notice