=== Plugin Name ===
Donate link: http://example.com/
Tags: instagram, slideshow, widget
Requires at least: 3.0.1
Tested up to: 3.8.1
Stable tag: 0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays latest Instagram images in a slideshow of configurable size.

== Description ==

This plugin displays your latest Instagram images in a slideshow widget. It is intentionally pretty bare-bones as most other plugins out the seem to offer dozens of bells and whistles. You can specify the following parameters:

* Width
* Height
* Amount of images
* Display of like numbers

== Installation ==

1. Unzip
2. Upload the folder `simple-instagram-slideshow` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Add the widget to a widget area
5. Provide the neccessary information

**Note:** You will need to register your own application on Instagram. You need to have an Instagram account in order to do that.

If you don't know how to do this, please follow a tutorial like the following: <http://darkwhispering.com/how-to/get-a-instagram-client_id-key>

== Frequently Asked Questions ==

= Cann you add a 'Like' function =

Unfortunately, the Instagram API does not allow that. You can just output the number of "hearts" or you could "heart" your own pictures. To be able to get a visitor to "heart" a picture right in the widget, the visitor would need to allow your website read/write access to their account. It is highly unlikely a visitor would do that – just to "heart" an image.

= Trouble generating images =

The plugin needs write access to its own folder (`/wp-content/plugins/simple-instagram-slideshow`). Please check that it does.

= Acknowledgements =

This plugin uses timthumb (GPLv2) and Basic jQuery Slider (GPLv3) functionality.

== Screenshots ==

1. Settings

== Changelog ==

= 0.7 =
* Initial release.