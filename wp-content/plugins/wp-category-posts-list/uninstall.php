<?php
/**
 * The uninstallation file
 * Used to delete
 * 1. The WP CPL Option
 * from the database
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.0
 */
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}
if ('uninstall.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('<h2>Direct File Access Prohibited</h2>');

delete_option('wp-cpl-itg-op');
//Requiescat in pace
