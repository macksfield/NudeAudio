<?php
/*
Plugin Name: WP Category Post List Widget
Plugin URI: http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/
Description: Lists down Posts filtered by category. You can show thumbnail, modify the HTML structure of the widget and do almost whatever you want. Access it from the Widgets option under the Appearance. The shortcode is [wp_cpl_sc] Check the settings page for more info or check the documentation <a href="http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/">here</a>
Version: 2.0.3
Author: Swashata
Author URI: http://www.swashata.com/
License: GPL2
*/

/*  Copyright 2010-2012  Swashata Ghosh  (email : swashata4u@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/** To do list as of development 1.1.0
 * @todo Add shortcode support DONE
 * @todo Add multiple category selection support for short tags
 * @todo Post date and author DONE
 * @todo Add excerpt support DONE
 * @todo Add hyperlink to title DONE
 * @todo Add Current post category selection support DONE
 * @todo Efficient read more and feed link with html support DONE
 * @todo Add tabbed widget support 2 | 3 tab
 * @todo Add multiple category to shortcode
 * @todo add filters for custom css theme DONE
 */

/** Todo list as of development 2.1.0
 * @todo Fix strip shortcode from the custom excerpt
 * @todo Add tabbed widget support
 * @todo Add multiple category selection support
 * @todo Add CSS3 themes (5)
 * @todo Add pagination support for shortcode
 * @todo Add custom field sorting
 */



/**
 * Include the loader
 */
include_once dirname(__FILE__) . '/classes/loader.php';
$itgdb_wp_cpl_plugin = new itgdb_wp_cpl_loader(__FILE__, $text_domain);

/**
 * Include common files
 */
include_once itgdb_wp_cpl_loader::$abs_path . '/includes/wp_cpl_css_filters.php';
include_once itgdb_wp_cpl_loader::$abs_path . '/includes/wp_cpl_widget.php';

/**
 * Ignite
 */
$itgdb_wp_cpl_plugin->load();

