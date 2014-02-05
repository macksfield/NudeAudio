<?php
/**
 * loader
 * The library of loader class
 * @author Swashata <swashata4u@gmail.com>
 * @subpackage WP Category Post List Plugin
 * @version 2.0.3
 */

/**
 * loader class
 * The class which loads every aspects of the plugin
 * @subpackage WP Category Post List Plugin
 * @version 2.0.3
 */
class itgdb_wp_cpl_loader {

    var $op;
    static $abs_path;
    static $abs_file;
    static $text_domain;
    static $version;


    public function __construct($file_loc, $text_domain) {
        //$this->op = get_option('itgdb_iwiform_op');
        self::$abs_path = dirname($file_loc);
        self::$abs_file = $file_loc;
        self::$text_domain = $text_domain;
        self::$version = '2.0.3';
    }

    public function load() {
        //activation hook
        register_activation_hook(self::$abs_file, array(&$this, 'plugin_install'));
        /** Load Text Domain For Translations */
        load_plugin_textdomain(self::$text_domain, null, self::$abs_path . '/translations');

        //admin area
        if(is_admin()) {
            //admin menu items
            add_action('admin_menu', array(&$this, 'gen_admin_menu'));

        }

        add_shortcode('wp_cpl_sc', array(&$this, 'shortcode_handler'));
        //add frontend script + style
        add_action('wp_print_styles', array(&$this, 'enqueue_script_style'));
        add_action('widgets_init', array(&$this, 'widget_init'));
        add_action('after_setup_theme', array(&$this, 'after_theme_setup_hook'));
        add_action('admin_print_scripts-widgets.php', array(&$this, 'wp_cpl_itg_adminaction_insert_js'));
        add_filter('plugin_action_links_' . plugin_basename(itgdb_wp_cpl_loader::$abs_file), array(&$this, 'wp_cpl_plugin_settings_op'), 10, 2);
    }

    public function after_theme_setup_hook() {
        if(function_exists('add_theme_support') && !function_exists('get_the_post_thumbnail')) {
            add_theme_support( 'post-thumbnails' );
        }

        if(function_exists('add_theme_support') && function_exists('add_image_size')) {
            extract(get_option('wp-cpl-itg-op'));
            add_image_size('wp-cpl-post-thumb', $wp_cpl_thumb_size[0], $wp_cpl_thumb_size[1], true);
            add_image_size('wp-cpl-sc-thumb', $wp_cpl_sc_thumb_size[0], $wp_cpl_sc_thumb_size[1], true);
        }
    }

    public function wp_cpl_itg_adminaction_insert_js() {
	wp_enqueue_script('wp-cpl-itg-js', plugins_url('static/admin/js/admin-jq.js', itgdb_wp_cpl_loader::$abs_file), array('jquery'));
    }

    /**
     * Provide a settings option from the plugin page
     * (Hat Tip - Event Espresso Lite - Event Registration and Management)
     */
    public function wp_cpl_plugin_settings_op($links) {
        $settings_link = '<a href="admin.php?page=wp_cpl_itg_page">' . __('Settings') . '</a>';
        $wid_link = '<a href="widgets.php">' . __('Widgets') . '</a>';
        array_unshift( $links, $settings_link, $wid_link ); // before other links
        return $links;
    }

    public function gen_admin_menu() {

        $admin_menus[] = add_options_page(__('WP Category Post List', itgdb_wp_cpl_loader::$text_domain), __('Category Posts (WP-CPL)', itgdb_wp_cpl_loader::$text_domain), 'manage_options', 'wp_cpl_itg_page', array(&$this, 'admin_setting'));

        foreach($admin_menus as $menu) {
            add_action('admin_print_styles-' . $menu, array(&$this, 'admin_enqueue_script_style'));
        }

    }

    /**
     * The main page callback function
     * @access public
     */
    public function admin_setting() {
        //use the API
        include_once self::$abs_path . '/classes/admin-class.php';
        $admin = new itgdb_wp_cpl_settings();
        $admin->gen_set_page();
    }

    public function admin_enqueue_script_style() {

        wp_enqueue_style('wp-cpl-admin-css', plugins_url('static/css/admin.css', self::$abs_file), array(), itgdb_wp_cpl_loader::$version);
    }

    public function enqueue_script_style() {
        include_once self::$abs_path . '/includes/wp_cpl_css_filters.php';
        $css_mng = new itgdb_wp_cpl_css_filter();
        $css_mng->enqueue_css_style();
    }

    public function widget_init() {
        return register_widget( "WP_Category_Post_List_itg" );
    }

    public function shortcode_handler($atts, $content = null) {
        include_once self::$abs_path . '/includes/wp_cpl_shortcode.php';
        $sc = new itgdb_wp_cpl_shortcode();
        return $sc->wp_cpl_shortcode_handler($atts, $content);
    }



    public function plugin_install() {
        include_once self::$abs_path . '/classes/install-class.php';

        $install = new itgdb_plugin_wp_cpl_install();
        $install->install();
    }

    /**
     * Shortens a string to a specified character length.
     * Also removes incomplete last word, if any
     * @param string $text The main string
     * @param string $char Character length
     * @param string $cont Continue character(…)
     * @return string
     */
    static function shorten_string($text, $char, $cont = '…') {
        $text = trim(strip_shortcodes(strip_tags($text)));
        $text = substr($text, 0, $char); //First chop the string to the given character length
        if(substr($text, 0, strrpos($text, ' '))!='') $text = substr($text, 0, strrpos($text, ' ')); //If there exists any space just before the end of the chopped string take upto that portion only.
        //In this way we remove any incomplete word from the paragraph
        $text = $text.$cont; //Add continuation ... sign
        return $text; //Return the value
    }

    /**
     * Get and return total number of posts under a category
     * This includes the sub categories or child categories as well
     *
     * @param int $id The category id
     * @return int Total post count
     */
    static function wp_get_postcount($id) {
        $cat = get_category($id);
        $count = $cat->count;
        $taxonomy = 'category';
        $args = array(
          'child_of' => $id,
        );
        $tax_terms = get_terms($taxonomy,$args);
        foreach ($tax_terms as $tax_term) {
            $count +=$tax_term->count;
        }
        return $count;
    }
}
