=== WP Category Post List Widget ===
Contributors: swashata
Donate link: http://www.intechgrity.com/about/buy-us-some-beer/
Tags: wordpress, category, widget, category-post, post, list, thumbnail, category-post-list
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 2.0.3

Widget & Shortcode to list down posts filtered by Category, with Thumbnails, Custom HTML structure, Excerpt, CSS theme with API & much more

== Description ==

WP Category Posts List is a WordPress Widget & Shortcode plugin to show your posts filtered by category.

Built on the latest WP widget class, it has multiple widget instance support. Also you can modify the HTML structure of the widget in what ever manner you want.

Every thing is made simple from the widget options. It supports post thumbnails which would fetch thumbnails you have added from the wp editor. You can also set the CSS class, alternate list css style and much more. Also, you have complete control over the sorting method of the plugin.

New from Version 2 is the shortcode support using which you can make magazine style list of posts from a category. See the screenshots for more details.

###Documentation###

Check the Installation and FAQ page. For detailed documentation check [HERE at out blog](http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/)

###Widget Feature List###
* A total of 30 (new in V2) options to choose from. (For this version! It will increase over time).
* We have kept the basic and advanced sets of options seperately to not to overwhelm you with options. And hey, if you are an advanced user, just click the Toggle switch.
* **NEW** Use the *Current Category* to automatically fetch the main category of the currently displayed post and list down other posts from that category. Suspends widget output if no category is found.
* Ability to write custom tags on the widget title. Such as %widget_num% will get replaced by the number of posts on the category list.
* **NEW** Ability to show the original category as Read more button below the widget with full supported HTML
* **NEW** Ability to show category feed subscription link with full supported HTML.
* Of course the ability to specify the number of posts for each widget.
* Turn on/off post thumbnail.
* Add custom CSS class to the post thumbnail.
* Ability to specify sort using date, id, title, comment or random
* **NEW** Choose whether or not to display hardcoded/auto-generated post *excerpts*
* **NEW** Added options for displaying author name, publish date etc.
* Set the sorting order ascending or descending.
* Selecting the default HTML underordered list or set up your very own custom HTML structure
* Specify custom HTML tag before/after the list and each link. In shorty design your own HTML nest.
* Exclude post by ID, or even make some particular posts sticky
* Decide whether the links would be opened on a new tab or on the present tab.
* Apply alternate CSS classes to the link list, so you can design easily.
* Also, include/exclude the plugin's default CSS from the plugins Settings page.

###Shortcode Feature List###
`[wp_cpl_sc attr="val"]`
* 15 attributes to work with.
* Select CSS theme (bundled or your own via filters) for every instances of shortcodes
* All options to control all output aspects of shortcode, including blog style post-meta, excerpt, thumbnail etc...
Check the [documentation](www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/) for more information.

###Plugin Feature List###
* Added option to specify the thumbnail width & height of widgets and shortcodes individually.
* Added option to globally enable css themes which you can select from widget or shortcodes individually. So two widgets can easily have different themes now.
* Added filter API using which you can use your own CSS file inside this plugin. Check the [documentation](http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/) for more information.
* Added a Master Reset button to reset all the options to default. (useful in case of errors)

And many more features... Check the Plugins Setting page for FAQs.

**Version 2.0.3 Released. Bugfix**

**Version 2.0.2 Released. Immediate bugfix to some errors**

**Version 2.0.0 Released. The first release of shortcodes and automatic category selection widget**

== Installation ==

###Uploading The Plugin###

Extract all files from the ZIP file, **making sure to keep the file/folder structure intact**, and then upload it to `/wp-content/plugins/`.

**See Also:** ["Installing Plugins" article on the WP Codex](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

###Plugin Activation###

Go to the admin area of your WordPress install and click on the "Plugins" menu. Click on "Activate" for the "WP Category Post List Widget" plugin.

###Widget Usage###

This is pretty much straight forward...

* Go to **Appearance > Widgets**
* Drag and drop the WP Category Post List to your sidebar/footer wherever.
* Customize the options.
* Go to **Settings > Category Posts (WP CPL)** and set the global theming options and thumbnail sizes.

###Shortcode Usage###

The basic shortcode usage of the plugin is
`[wp_cpl_sc cat_id=1 css_theme=2 list_num=5]`
where you change the cat_id, list_num and css_theme values. For more information on attributes check the [documentation page](http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/)

###Upgrading the Plugin###

So far we have released a few versions of this plugin. You can just deactivate and delete old version and install the latest one from here.

Alternately you can use WordPress' own auto-update feature and forget about updating manually.

== Frequently Asked Questions ==

= My Thumbnails are not showing up exactly as the size I have selected =

WP CPL uses the default Thumbnail or Featured Image Feature of WP 2.9+. So, the thumbs are created when you upload the picture. For older pictures, it is not generated automatically. Not even when you change the thumb size. In such case just install and run this [Regenerate Thumbnail Plugin](http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/). After installing it first time or whenever you change the Thumb size, it is recommended that you run this plugin once

= Can I use different thumbnail for different widget? =

This is not yet supported and I really don't feel like using timthumb to generate thumbnails. However in future if I ever feel, then I will incorporate this feature

= How can I use my own CSS for the widget? =

Now this can be done using our CSS Theme filter API. A detailed instruction can be found [HERE](http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/)

= Is it possible to use different CSS for different widget/shortcode? =

Technically & simply Yes. Now you can simply choose the css theme from the dropdown (widgets) or mention the id in shortcode.

== Screenshots ==

1. Widget with basic options
2. Widget with Advanced options
3. The plugins settings page
4. Output of the widget
5. Output of the shortcode

== ChangeLog ==

= Version 2.0.3 =
* Bug fix: On wp_cpl_output_gen.php file
* Added: Current Post category is now current post/archive page category. So a category archive page will populate the widget.

= Version 2.0.2 =
* Bug fix to the occasion when no theme is selected
* Added a Reset button to reset all the options in case of corruption

= Version 2.0.1 =
* Immediate bug fix to the WordPress auto-update.

= Version 2.0.0 =
* Ability to select the category of the current post (Auto category detection)
* Shortcode support
* Post excerpt and other options like html enabled Readmore and subscription.
* Different height and width for widget and shortcode thumbnail
* Display author, date and other post meta.
* Added filter API to use your own CSS Theme with the plugin (both for widget and shortcode)

= Version 1.1.0 =
* **Not released in the WILD**
* Ability to select the category of the current post
* Shortcode support (proposed)
* Minor bug fixes
* Options to show post date, author and excerpt
* New interface for read more and feed link

= Version 1.0.0 =
* Public Release
* Several bugs fixed
* Fixed the Read More permalink bug
* Added 2 more themes
* Added Teaser Option

= Version 0.9.0 RC =
* Themeing Support
* Complete Widget Interface
* Stand alone support for Wordpress post thumbnail activation. Even if your theme does not support.
* All Documentation can be found in the Plugins Settings page

= Version 0.0.9 alpha =
* Added basic widget querying of posts
* Added thumbnail support etc.
* Still under development. Please dont install

= Version 0.0.8 alpha =
* Initial Upload to WP SVN
* Under development. Please dont't install

== Upgrade Notice ==

= 2.0.2 =
Immediate bugfix to some errors

= 2.0.1 =
Bugfix to WP auto upgrade

= 2.0.0 =
Upgrade to get Shortcode support, post excerpt, more control over thumbnail and CSS theme.

= 1.0.0 =
Public Release with several bug fixes and checked stability. Update and enjoy

= 0.0.9 alpha =
Designed the basic of the widget. Still needs heavy development. Please don't install.

= 0.0.8 alpha =
Development version. Don't Install.
