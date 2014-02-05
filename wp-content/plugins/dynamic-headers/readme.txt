=== Dynamic Headers ===
Contributors: dcannon1
Donate link: http://nicasiodesign.com
Tags: header, images, dynamic, Post, posts, plugin, page, image, aesthetic, small, fast, custom
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 3.5.3

Dynamic Headers does just what you think it would based on the name - it allows you to create highly dynamic header space on your WordPress site.

== Description ==

Dynamic headers fills a void that has been present for a while in WordPress. It is a small, easy to use plugin that allows you to manage what header media is shown on each page/post. Unlike some other plugins however, this plugin allows you to use any image file OR a .swf Flash file. So you are no longer limited to a certain media type for your headers and you are no longer limited to one site-wide header. Enjoy.

**Features:**

-  Set different headers for each page and post.
-  Use different media types on each page (image files, flash files).
-  Cross browser compliant embed code automatically generated.
-  Can set default header for pages/posts without set header image.
-  Fails gracefully if no header media present for current page.
-  Random media for individual pages/posts and default media.
-  Alt / Title tag management for images.
-  Supports both built in browser uploader or FTP.
-  Quick and lightweight.
-  Simply add template tag to theme to pull dynamic media.
-  Tested and validated to work on WordPress version 2.3+ (Plugin Version < 2.7 Only!)
-  Ability to add links to your header images.
-  WordPress MU Compatible (As of 2.8)
-  Theme developer friendly with several template tags and functions for custom themes.
-  NOTE: The popular TwentyTen Weaver theme now includes native support for the Dynamic Headers plugin. If you are using this theme then just download Dynamic Headers and begin using it with no template or CSS mods required!

**Regarding Support:** This plugin is offered completely free of charge with no expressed or implied warranty. This plugin is open source and is to be used 'as-is' and at your own risk. Always remember to backup your WordPress database (and ideally your file structure) before using any new plugin for the first time. Most support requests we get (and we get dozens per week) have to do with changing a theme's CSS to accomodate the new headers. We simply don't have the man power to answer all of these questions on a case by case basis, but do try to answer some, for more popular themes, when we can. We do offer WordPress consulting, so if you really need some help and would like to hire Nicasio please let us know.

== Installation ==

These are the directions for the install. Be sure to read Directions for Use before using.

1. Upload 'the custom-header' directory to your plugins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create the directory `wp-content/header-images/` and make it writable (777). Don't worry if your wp-content directory is in an 
1. Read the Other Notes page for Directions for Use. These directions are also contained in the plugin.

== Frequently Asked Questions ==

= I upgraded from Version<2.7 to the current version, what's the problem?  =

If upgrading from Dynamic Headers 2.7 or lower: The image folder has moved. You will need to create the directory `/wp-content/header-images/` and make it writable. You will need to backup `/wp-content/plugins/dynamic-headers/header-images/` and move your header files to the new directory before upgrading.

= Does this plugin automatically resize my files? =

No. To keep the process simple for both us and you (and to insure you have a large amount of flexibility in the use of our template tags) we do not resize your media files. This could be an option on future release.

= Why am I seeing an image I didn't set on an archive page or the home page? =

Due to the way WordPress handles post ID's on an archive page, or the blog homepage, the first post is what will determine what dynamic media is pulled. You can overwrite the image for the homepage on the plugin's Settings page. We plan to add override support for the other archive pages on a future release.

= Does the template tag have to go in header.php? =

Absolutely not. You are limited only by your imagination (and theme editing abilities) on how/where you want to drop the dynamic media tag in your theme.

= Can I upload media via FTP instead of using the browser based uploader? =

Sure, just upload your media to `/wp-content/header-images/`.

== Directions for Use ==

1. After installing the plugin you will need to create `/wp-content/header-images/` and make it writable. If you are unsure on how to do this, consult your hosting company, your help files for your hosting, your FTP client documentation, etc. This process can vary from server to server. If the directory is not writable you should be seeing an error message at the top of the plugin admin pages.
1. Upload media (using the filtypes listed above) on the Add New File Page.
1. Go to the Settings Page (under the Headers menu created by the plugin) and set your default header image. If you do not set a default header image, no media will be shown for posts and pages that do not have a header image associated with it.Alternatively, you can also add images to the `/wp-content/header-images/` directory using your FTP client or other file manager.
1. Create or edit a post or page and at the bottom of the page you will see a new box called "Dynamic Header by Nicasio Design". Select from the drop down one of your uploaded media files. This media will be shown only on the page or posts you set it to appear on.
1. BACKUP YOUR THEME DIRECTORY BEFORE MAKING ANY MODIFICATIONS TO ANY THEME FILES
1. Now you will need to add the template tag created by the plugin to your theme file where you want your dynamic header to appear (this will usually be in `/wp-content/themes/your-theme-name/header.php`).

You have 2 options for adding your dynamic header:

**Option 1 (Recommended)**: Simply drop the this snippet of code into your theme file that controls your header (usually header.php)

Note: The location to add this code can vary widely from theme to theme and depending on your theme's css settings you may have to use Option 2 and modify the CSS of your theme **BACKUP ANY THEME FILES BEFORE MODIFYING**

`<?php 
if(function_exists('show_media_header')){
show_media_header();
}
?>`

This will automatically determine what type of media you are using and generate the appropriate code to insert it. No other coding is required on your part.

**Option 2**: You can use this line of code to simply get the URL of the media for a particular post or page. This will allow you to do some more advanced things and embed the media yourself if you know what you are doing.

`<?php 
if(function_exists('dh_get_page_image_url')){
$dynamic_header_url = dh_get_page_image_url(); 
}
?>`

You can then use the variable `$dynamic_header_url` however you see fit. It will contain the full path to your media file.

It is advised that most users simply use Option 1 as it is significantly more simple.

**Note:** This function can return NULL or the string "None" if there are no headers for the current page.

**Important Notes**: On archive pages, the header media is controlled by the first post in the list. We plan to add control for archives pages separately in a future release, but for now, be aware that the first post on an archives page controls that page's header.

**Notes for Theme Developers**

There are several functions/template tags you can use to customize your theme using Dynamic Headers. These could be used in unique ways to build custom CSS code around Dynamic Headers, or use your imagination.

`dh_get_page_image_url()` - This function will return the full URL of the header file for the page. Will be replacing get_media_header_url()

`dh_get_page_link_url()` - Will return the full URL for a link assigned to a header file, or an empty string, '', if there is none.

`dh_get_page_link_target()` - Will return the link target associated with a header file, or an empty string, '', if there is none.

`dh_has_header()` - Conditional function. Will return TRUE if the current page has a header explicitly assigned to it (not counting default headers) or FALSE if not.

`dh_print_media_path()` - Will print the relative path to the directory where Dynamic Header media files are stored.

`dh_get_media_path()` - Will return the relative path to the directory where Dynamic Header media files are stored.

`dh_get_random_media_item()` - Will return the URL of a random media item contained in the Dynamic Headers media directory


== Screenshots ==

1. Add new media to be used as a dynamic header.
2. Settings page for the plugin.
3. The Dynamic Header box on the post/page editing page.

== Changelog ==

= 3.5.3 =
* Removed all donation references due to Paypal concerns

= 3.5.2 =
* Minor fixes, readme changes to announce TwentyTen Weaver theme support and new support policy.

= 3.5.0 =
* Fixed message bug on Manage page in admin
* Clarified some directions
* Added some new information to the about page
* Added donation link

= 3.5.0 =
* Made a function call to get flash dimensions reference the file by its server path rather than its URL which was causing an error to be thrown on hosts where URL file access is not allowed.
* Changed several path constants to use the formal WordPress path variables, insuring the plugin will work when the wp-content or plugins directory is moved from its normal place
* Changed directions to include an if function exists logic so disabling the plugin will not break a theme where that still contains the template tag
* Fixed a logic mistake from an older version that was causing the footer link to be opt-out instead of opt-in as it should be
* Several typo fixes and updates to clarify directions
* Update to the About page
* Optimized database calls where possible

= 3.4.7 =
* Fixed an issue caused by 3.4.6

= 3.4.6 =
* Fixed an issue causing some icons/images to not display correctly on sub-directory WordPress installations.
* Updated version compatibility
* Optimization fixes
* This is an advised upgrade and should not affect functionality on your site

= 3.4.5 =
* Internal changes.
* Advise all to upgrade - should not jeopardize any settings or functionality.

= 3.4.4 =
* Fixed a flash embed error.
* Tested with WP 2.8.4

= 3.4.3 =
* Database and file optimizations.

= 3.4.2 =
* Fixed an issue causing invalid javascript to be printed in the site header.

= 3.4 =  
* Incorporated the new changelog functionality into the readme file.

= 3.3 =
* Fixed an issue with the options page not working. **THIS IS A MUST DOWNLOAD UPDATE** if you are using WP 2.7 or higher.
   
= 3.2 =  
* Fixed bug causing headers to not save correctly on some WP installs
* Fixed a bug casuing an activation error with WordPress 2.6 and lower
* Fixed bug causing a stray `</a>` tag to sometimes be printed
* Fixed a bug causing the link target to sometimes print incorrectly
* Switched from using a javascript loader to load Flash and went with normal method instead due to some browser issues.
* Added several conditionals/template tags for theme developers to take advantage of. These are explored in more detail under Other Notes