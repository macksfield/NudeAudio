=== Simple Backup ===
Name: Simple Backup
Contributors: MyWebsiteAdvisor, ChrisHurst
Tags: Backup, Archive, Restore, Recover, Recovery, Optimize, Admin, Administration
Requires at least: 3.3
Tested up to: 3.6
Stable tag: 2.7.7
Donate link: http://MyWebsiteAdvisor.com/donations/


Simple Tools to Optimize and Backup Your WordPress Website.


== Description ==

Simple Backup Plugin for WordPress create and download backups of your WordPress website.
Plugin can also optionally perform many common optimizations to wordpress and MySQL Database before backup.

Requires linux style server with tar, gzip, bzip or zip for backup file creation.
The plugin uses mysqldump for consistent and reliable database backups.

This plugin will create a directory in the root of your WordPress directory called 'simple-backup' to store the backup files.
If the plugin can not locate or create the directory you will receive an error message and may have to create the directory manually, the directory will also need to be writeable by the web server so you may need to chmod it.


<a href="http://mywebsiteadvisor.com/products-page/premium-wordpress-plugins/simple-backup-ultra/">**Upgrade to Simple Backup Ultra**</a> for advanced features including:

* Schedule Automatic WordPress Backups
* Scheduled Automatic WordPress and Database Optimizations
* Receive email notification of the scheduled backup status
* Lifetime Priority Support and Update License




Check out the [Simple Backup Plugin for WordPress Video Tutorial](http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1):

http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1



Developer Website: http://MyWebsiteAdvisor.com/

Plugin Support: http://MyWebsiteAdvisor.com/support/

Plugin Page: http://MyWebsiteAdvisor.com/tools/wordpress-plugins/simple-backup/

Tutorial: http://mywebsiteadvisor.com/learning/video-tutorials/simple-backup-tutorial/

Restoring WordPress Backups Tutorial: http://mywebsiteadvisor.com/learning/software-tutorials/restoring-wordpress-backups/



Requirements:

* PHP 5.2+
* WordPress 3.3+
* Linux Style Server
* mysqldump (for DB backup)
* tar, zip, gzip, or bzip (for backup file compression)
* exec and passthru functions (to call the linux backup commands)


To-do:





== Installation ==

1. Upload `simple-backup/` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Simple Backup Plugin settings and enable Simple Backup Plugin.


Check out the [Simple Backup Plugin for WordPress Video Tutorial](http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1):

http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1






== Frequently Asked Questions ==

= Plugin doesn't work ... =

Please specify as much information as you can to help us debug the problem. 
Check in your error_log or debug.log if you can. 
Please send screenshots as well as a detailed description of the problem.



= FTP Server Setup =

The FTP options are a common point of confusion for many people.
The FTP System is Optional and only necessary if you have an FTP server which is separate from your website.
Some Web Hosting providers provide an FTP Backup server, or you could setup an FTP on your Home Computer and setup the plugin to transfer the backup files to that FTP Server.



= Restoring Backups =

This plugin does not contain any features to restore the backup files which it creates.

Most likely if you should need to restore backups you will not have access to your website or the plugin.
For that reason the plugin creates the backup files in standard, commonly used formats.

More information on how to restore backup files can be found here:
Restoring WordPress Backups Tutorial: http://mywebsiteadvisor.com/learning/software-tutorials/restoring-wordpress-backups/



= How can I setup Automatic Weekly or Monthly Backups? =

We offer a premium version of the plugin which includes advanced features such as Automatic Scheduled Backups!

<a href="http://mywebsiteadvisor.com/products-page/premium-wordpress-plugins/simple-backup-ultra/">**Upgrade to Simple Backup Ultra**</a> for advanced features including:

* Schedule Automatic WordPress Backups
* Scheduled Automatic WordPress and Database Optimizations
* Receive email notification of the scheduled backup status
* Lifetime Priority Support and Update License




Check out the [Simple Backup Plugin for WordPress Video Tutorial](http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1):

http://www.youtube.com/watch?v=W2YoEneu8H0&hd=1




Developer Website: http://MyWebsiteAdvisor.com/

Plugin Support: http://MyWebsiteAdvisor.com/support/

Plugin Page: http://MyWebsiteAdvisor.com/tools/wordpress-plugins/simple-backup/

Tutorial: http://mywebsiteadvisor.com/learning/video-tutorials/simple-backup-tutorial/

Restoring WordPress Backups Tutorial: http://mywebsiteadvisor.com/learning/software-tutorials/restoring-wordpress-backups/






== Screenshots ==

1. Basic Backup Settings Page
2. WordPress Optimizations Settings Page
3. MySQL Database Management Settings Page
4. Simple Backup File Manager
5. FTP Storage Settings Page






== Changelog ==

= 2.7.7 =
* added check for php exec() function around the exec('du') which calculates the size of the WP install
* updated requirements section in readme to indicate that exec and passthru functions are required for the plugin to work properly.


= 2.7.6 =
* fixed version number

= 2.7.5 =
* improved the backup directory creation and .htaccess creation systems
* updated the timezone to work with timezone offsets, however named timezones are still preferred because timezone offsets are not as accurate.


= 2.7.4 =
* fixed bug with the MyWebsiteAdvisor Plugin Installer Page.
* added option to the help menu, 'More Free Plugins' section to enable and disable the 'MyWebsiteAdvisor' Plugins installer menu. 


= 2.7.3 = 
* updated the MyWebsiteAdvisor Plugin Installer Page to include the option to remove the installer page and menu.
* updated links to the plugin installer to use the search by author feature when the plugin installer is disabled.
* updated readme file description and requirements.

= 2.7.2 =
* resolved issues with downloading large files


= 2.7.1 =
* resolved more issues with disk_free_space errors on 32 bit servers
* updated plugin FAQs
* updated readme file


= 2.7.0 =
* fixed filemtime warning when creating backup
* updated readme file
* updated FAQs in readme and in plugin help menu





= 2.6.9 =
* updated contextual help, removed deprecated filter and updated to preferred method
* updated plugin upgrades info tab on plugin settings page
* added uninstall and deactivation functions to clear plugin settings

= 2.6.8 =
* updated readme file
* added plugin upgrades tab on plugin settings page


= 2.6.7 =
* updated readme file

= 2.6.6 =
* created new tutorial vid, updated tutorial video links


= 2.6.5 =
* updated readme file, due to the add_help_tab() function, the plugin requires at least WordPress version 3.3
* added notification about required version if an older version of WP is installed


= 2.6.4 =
* updated backup manager FTP system to work better with large files (2+ GB)
* added tab for tutorial video on plugin settings tabs
* added a link for plugin tutorial page on our website on the plugin row meta links on plugins page



= 2.6.3 =
* updated readme file, added tutorial video.
* updated plugin help menu, added tutorial video.


= 2.6.2 =
* fixed issue with Simple_Backup_FTP_Tools::connection_test() method causing warnings.
* updated screenshots
* updated readme, added link to Restoring Backups Tutorial


= 2.6.1 =
* added ftp storage system
* added .htaccess security for local backup storage
* added secure file download system to compliment the .htaccess security
* updated admin interface with create backup button always at the top
* added to diagnostics, display estimated file and database backup sizes as well as disk free space


= 2.6 = 
* updated plugin to use WordPress settings API
* consolidated the plugin settings so they are all stored in one main setting, rather than individual settings in wp-options table
* updated plugin settings page with tabs, rather than scrolling down the page
* reorganized entire plugin file layout
* resolved issues with large file backups causing timeout errors



= 2.5.2 =
* added label elements around checkboxes to make the label text clickable.
* added function exists check for the sys_getloadavg function so it does not cause fatal errors on MS Windows Servers


= 2.5.1 =
* fixed plugin settings screen
* updated plugin to be compatible with PHP 5.2


= 2.5 =
* added Backup Manager under Tools Menu
* updated backup file display to use WP_List_Table class
* added check for timezone, if time zone is not set, the backup files do not display the correct time.
* updated settings page interface so it will display better on small screens.
* added check for PHP version 5.3 for compatibility with DateTime class



= 2.4.1 =
* fixed several issues causing notices in debug.log
* added plugin version number to debug info panel.
* updated the backup file display to show the local time and date.
* updated readme file.


= 2.4 =
* updated the filesystem backup function, resolved issue with backing up the excluded directory.


= 2.3.6 =
* tested and tagged for compatibility with WordPress version 3.5
* updated incorrect plugin link

= 2.3.5 =
* resolved array_merge function warning

= 2.3.4 =
* added rate this plugin link in plugin row meta links on plugin screen
* added upgrade plugin link in plugin row meta links on plugin screen
* resolved notices and warnings about undefined index

= 2.3.3 =
* added link to rate and review this plugin on WordPress.org.

= 2.3.2 =
* fixed readme file syntax

= 2.3.1 =
* updated plugin activation php version check which was causing out of place errors.

= 2.3 =
* added contextual help menu with faqs and support link
* fixed broken links


= 2.2 =
* added wordpress optimization functions
* added database table check and optimize functions
* added plugin screenshots


= 2.1 =
* added database optimization feature to compress DB before backup


= 2.0 =
* added additional links for support, other plugins, upgrades, etc.
* added error checking to see if PHP safe mode is enabled, or if exec functions are disabled.


= 1.8 =
* added --single-transaction option to mysqldump command


= 1.7 =
* minor bug fix, improper opening php tag, needs to be <?php rather than <? for compatibility.


= 1.6 =
* resolved timeout issues when making very large backups


= 1.5 =
* Added the -h (host name) option for 'mysqldump' data base backup to allow backup of remote DB servers.


= 1.4 =
* Added option to display the output generated by the backup commands for debugging purposes.


= 1.3 =
* Fixed re-direction glitch after backup files are deleted
* Added mysqldump command check to the plugin diagnostic


= 1.2 =
* Added support for alternative methods of backup and compression
* Added ability to back up wordpress database
* Improved plugin diagnostic functionality to check for backup and compression functions


= 1.1 =
* Fixed some of the links for support


= 1.0 =
* Initial release

