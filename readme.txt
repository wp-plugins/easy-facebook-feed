=== Easy facebook feed ===
Contributors: timwass
Author: Tim Wassenburg
Donate link: http://stormware.nl
Tags: facebook, feed, widget, plugin, page, shortcode
Requires at least: 3.0.1
Tested up to: 4.2.3
Stable tag: 0.7
Version: 0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With this plugin you can get your facebook posts on your Wordpress website.

== Description ==

Get your facebook posts on your Wordpress website in a easy way. Features in Easy Facebook feed include:

*   Displays shared links, video's, status updates and photo's from your Facebook page.
*   Multiple feeds
*   Responsive layout.
*	Uses the colors of your theme.
*   Adjustable number of posts.
*   Usable as full page.
*   Usable as widget.
*	Easy to use.

== Installation ==

Display as page:
*   Upload `easy-facebook-feed` to the `/wp-content/plugins/` directory
*   Activate the plugin through the 'Plugins' menu in WordPress
*   Go to the Easy Facebook settings and add your own Facebook ID
*   Place `[easy_facebook_feed]` on your page
*   Optional: if you want to use different feeds on different pages you can add parameters to the shortcode,
for example: `[easy_facebook_feed id="bbcnews" limit="3"]`, 'id' the parameters will overwrite your default admin options

Display as widget:
*   Go to Appearance -> Widgets
*   Add the Easy Facebook Feed widget to your widget area

And thats it, you are done!

== Frequently Asked Questions ==

= Where can I find my facebook id? =

Your facebook id can be found in the url of your facebook page, for example: https://www.facebook.com/bbcnews, is this example 'bbcnews' is the facebook id.

== Screenshots ==

1. Example of how Easy Facebook feed looks in action.

== Changelog ==

= 0.7 =
* Added support for multiple Facebook feeds

= 0.6 =
* Facebook graph api update

= 0.5 =
* Added widget support
* Added settings shortcut on plugin page.

= 0.4 =
* Facebook made some graph changed causing errors in Easy Facebook Feed.

= 0.3 =
* Fixed a problem with the images because of a Facebook graph change. 
* Layout bugfix in the link type post.

= 0.2 =
* Solved a small bug that occurred with older php versions.

= 0.1 =
* First release
