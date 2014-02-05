<?php
/**
 * shortcode
 * The library of shortcode class
 * @author Swashata <swashata4u@gmail.com>
 * @subpackage WP Category Post List Plugin
 * @version 2.0.0
 */

/**
 * The WP CPL shorttag support
 * @since 1.1.0
 * This was started from the version 1.1.0 and was finished by 2.0.0
 */
class itgdb_wp_cpl_shortcode {
    /**
     * The wp_cpl_shortcode_handler function
     * This function is responsible for converting shortcodes into dynamic contents
     * @package WordPress
     * @subpackage WordPress Category Post List plugin
     * @since 1.1.0
     * @param array $atts The attributes passed through the shortcode
     * @param string $content The string passed through the shortcode. Used for generating title
     * @return string The modified content
     */
    public function wp_cpl_shortcode_handler($atts, $content = null) {
        /** first extract the attributes */
        $op = shortcode_atts(array(
	    'cat_id'			=> 1,
            'css_theme'                 => 0,
	    'is_thumb'			=> 'true',
	    'list_num'			=> 10,
	    'show_comments'		=> 'true',
	    'sort_using'		=> 1,
	    'sort_order'		=> 'asc',
	    'exclude_post'		=> '',
	    'sticky_post'		=> '',
            'show_date'                 => 'true',
            'show_author'               => 'true',
            'show_excerpt'              => 'true',
            'excerpt_length'            => 150,
            'optional_excerpt'          => 'false',
            'read_more'                 => __('Continue Reading', itgdb_wp_cpl_loader::$text_domain),
        ), $atts);

        /** Sanitize some of the user datas */
        $cat_id = (int) $op['cat_id'];
        $i = 0;
        /** Done, now the main thing */
        include_once itgdb_wp_cpl_loader::$abs_path . '/includes/wp_cpl_output_gen.php';
        $output_gen = new itgdb_wp_cpl_output_gen();
        return $output_gen->shortcode_output_gen($op);
    }
}
