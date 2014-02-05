<?php
/**
 * install-classes
 * The library of all the installation class
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.2
 */

/**
 * admin install
 * The admin installation class
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.2
 */

class itgdb_plugin_wp_cpl_install {
    
    /**
     * install
     * Do the things
     */
    public function install() {
        //php version check
        if (version_compare(PHP_VERSION, '5.0.0', '<')) {
		deactivate_plugins(basename(itgdb_wp_cpl_loader::$abs_file));
		wp_die(__('WP Category List Wordpress plugin requires PHP5. Sorry!', itgdb_wp_cpl_loader::$text_domain));
		return;
	}
        $this->checkop();
    }
    
    
    /**
     * Creates the options
     */
    private function checkop() {
        //options
        if(!get_option('wp-cpl-itg-op')) {
            $wp_cpl_op = array(
                'wp_cpl_version' => itgdb_wp_cpl_loader::$version,
                'wp_cpl_use_def_css' => true,
                'wp_cpl_thumb_size' => array(50, 50),
                'wp_cpl_sc_thumb_size' => array(150, 150),
                'wp_cpl_css_theme' => array(0,1,2,3),
            );
            add_option('wp-cpl-itg-op', $wp_cpl_op, '', 'no');
        }
        else {
            extract(get_option('wp-cpl-itg-op'));
            //check for every occurance of the options
            //fixed @version 2.0.2
            if(!isset($wp_cpl_version))
                $wp_cpl_version = '1.0.0';
            if($wp_cpl_version != itgdb_wp_cpl_loader::$version) {
                if(!is_array($wp_cpl_thumb_size)) {
                    if(!is_int($wp_cpl_thumb_size) || $wp_cpl_thumb_size == 0)
                        $wp_cpl_thumb_size = 50;
                }
                if(is_array($wp_cpl_thumb_size)) {
                    if($wp_cpl_thumb_size[0] == 0)
                        $wp_cpl_thumb_size = 50;
                    if($wp_cpl_thumb_size[1] == 0)
                        $wp_cpl_thumb_size[1] = 50;
                }
                if(!isset($wp_cpl_sc_thumb_size)) {
                    $wp_cpl_sc_thumb_size = array(150, 150);
                }
                if(is_array($wp_cpl_sc_thumb_size)) {
                    if($wp_cpl_sc_thumb_size[0] == 0)
                        $wp_cpl_sc_thumb_size[0] = 150;
                    if($wp_cpl_sc_thumb_size[1] == 0)
                        $wp_cpl_sc_thumb_size[1] = 150;
                }
                if(!isset($wp_cpl_css_theme)) {
                    $wp_cpl_css_theme = array(0,1,2,3);
                }
                if(!isset($wp_cpl_use_def_css)) {
                    $wp_cpl_use_def_css = true;
                }
                $wp_cpl_op = array(
                    'wp_cpl_version' => itgdb_wp_cpl_loader::$version,
                    'wp_cpl_use_def_css' => $wp_cpl_use_def_css,
                    'wp_cpl_thumb_size' => ((is_array($wp_cpl_thumb_size))? $wp_cpl_thumb_size : array($wp_cpl_thumb_size, $wp_cpl_thumb_size)),
                    'wp_cpl_sc_thumb_size' => ((is_array($wp_cpl_sc_thumb_size))? $wp_cpl_sc_thumb_size : array(150, 150)),
                    'wp_cpl_css_theme' => ((is_array($wp_cpl_css_theme))? $wp_cpl_css_theme : array(0,1,2,3)),
                );
                update_option('wp-cpl-itg-op', $wp_cpl_op);
            }
        }
    }
}
