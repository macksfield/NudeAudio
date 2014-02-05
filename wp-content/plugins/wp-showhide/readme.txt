=== WP-ShowHide ===
Contributors: GamerZ
Donate link: http://lesterchan.net/site/donation/
Tags: show, hide, content, visibility, press release, toggle
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: trunk

Allows you to embed content within your blog post via WordPress ShortCode API and toggling the visibility of the cotent via a link.

== Description ==

By default the content is hidden and user will have to click on the "Show Content" link to toggle it. Similar to what Engadget is doing for their press releases. Example usage: `[showhide type="pressrelease"]Press Release goes in here.[/showhide]`

= Previous Versions =
* N/A

= Development =
* [http://dev.wp-plugins.org/browser/wp-showhide/](http://dev.wp-plugins.org/browser/wp-showhide/ "http://dev.wp-plugins.org/browser/wp-showhide/")

= Translations =
* [http://dev.wp-plugins.org/browser/wp-showhide/i18n/](http://dev.wp-plugins.org/browser/wp-showhide/i18n/ "http://dev.wp-plugins.org/browser/wp-showhide/i18n/")

= Support Forums =
* [http://forums.lesterchan.net/index.php?board=36.0](http://forums.lesterchan.net/index.php?board=36.0 "http://forums.lesterchan.net/index.php?board=36.0")

= Credits =
* N/A

= Donations =
* I spent most of my free time creating, updating, maintaining and supporting these plugins, if you really love my plugins and could spare me a couple of bucks, I will really appericiate it. If not feel free to use it without any obligations.

== Changelog ==

= Version 1.00 (01-05-2011) =
* FIXED: Initial Release

== Installation ==

1. Open `wp-content/plugins` Folder
2. Put: `Folder: wp-showhide`
3. Activate `WP-ShowHide` Plugin
4. No configuration is needed

= General Usage =
1. By default, content within the showhide shortcode will be hidden.
2. Example: `[showhide]Press release content goes in here.[/showhide]`
3. Default Values: `[showhide type="pressrelease" more_text="Show Press Release (%s More Words)" less_text="Hide Press Release (%s Less Words)" hidden="yes"]`

1. You can have multiple showhide content within a post or a page, just by having a new type.
2. Example: `[showhide type="links" more_text="Show Links (%s More Words)" less_text="Hide Links (%s More Words)"]Links will go in here.[/showhide]`

1. If you want to set the default visibility to display.
2. Example: `[showhide hidden="no"]Press release content goes in here.[/showhide]`

== Upgrading ==

1. Deactivate `WP-ShowHide` Plugin
2. Open `wp-content/plugins` Folder
3. Put/Overwrite: `Folder: wp-showhide`
4. Activate `WP-ShowHide` Plugin
5. No configuration is needed
	
== Upgrade Notice ==

N/A

== Screenshots ==

1. Show More - Press Release
2. Hide More - Press Release
3. Editor - Short Code

== Frequently Asked Questions ==

N/A