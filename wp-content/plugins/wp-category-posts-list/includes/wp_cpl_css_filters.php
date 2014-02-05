<?php
/**
 * css filter class
 * The common brain of the custom and predefined css classes
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.2
 */
class itgdb_wp_cpl_css_filter {
    /**
     * Get CSS List
     * returns the default css list with the applied ~wp_cpl_css_filter~ filter
     * @return array The array of CSS LIST
     */
    public function get_css_list() {
        $css_list = array(
            0 => array(
                'name' => __('Light Theme', itgdb_wp_cpl_loader::$text_domain),
                'css_url' => plugins_url('static/css/wp-cat-list-light.css', itgdb_wp_cpl_loader::$abs_file),
            ),
            1 => array(
                'name' => __('Dark Theme', itgdb_wp_cpl_loader::$text_domain),
                'css_url' => plugins_url('static/css/wp-cat-list-dark.css', itgdb_wp_cpl_loader::$abs_file),
            ),
            2 => array(
                'name' => __('Giant Gold Fish', itgdb_wp_cpl_loader::$text_domain),
                'css_url' => plugins_url('static/css/wp-cat-list-giant-gold-fish.css', itgdb_wp_cpl_loader::$abs_file),
            ),
            3 => array(
                'name' => __('Adrift in Dreams', itgdb_wp_cpl_loader::$text_domain),
                'css_url' => plugins_url('static/css/wp-cat-list-adrift-in-dreams.css', itgdb_wp_cpl_loader::$abs_file),
            ),
        );
        $css_list = apply_filters('wp_cpl_css_filter', $css_list);
        return $css_list;
    }
    
    /**
     * This lists the selecbox option for the widget
     * Used by the widget class
     * @param int|string $current 
     * @param array $active_list
     * @return string
     */
    public function list_widget_selectbox($current) {
        $css_list = $this->get_css_list();
        $op = get_option('wp-cpl-itg-op');
        $active_list = $op['wp_cpl_css_theme'];
        ob_start();
        foreach($active_list as $id) {
            ?>
<option value="<?php echo htmlspecialchars($id); ?>"<?php if($current == $id) echo ' selected="selected"'; ?>><?php echo htmlspecialchars($css_list[$id]['name']); ?></option>
<?php
        }
        
        $output = ob_get_clean();
        return $output;
    }
    
    /**
     * Used in the settings page to display a tickbox for active css themes
     * These themes are then displayed in widget area for selection
     * @param array $active_list 
     */
    public function list_admin_selectbox($active_list) {
        //fix for cases where no theme is selected
        //Although through the new admin backend, this case will not appear
        if(!is_array($active_list))
            $active_list = array();
        
        $css_list = $this->get_css_list();
        foreach($css_list as $id => $css) {
            ?>
<li>
    <label for="css_list_<?php echo $id; ?>">
        <input type="checkbox" name="css_list[]" id="css_list_<?php echo $id; ?>" value="<?php echo htmlspecialchars($id); ?>"<?php echo ((in_array($id, $active_list))? ' checked="checked"' : ''); ?> /> 
        <?php echo htmlspecialchars($css['name']); ?>
    </label>
</li>
<?php
        }
        //echo '<pre>' . var_dump($active_list) . ' <br />' . var_dump($css_list) . '</pre>';
    }
    
    /**
     * Enqueue Active CSS Styles
     * provides an API to the loader function
     */
    public function enqueue_css_style() {
        $css_list = $this->get_css_list();
        extract(get_option('wp-cpl-itg-op'));
        if(true !== $wp_cpl_use_def_css)
            return;
        wp_enqueue_style('wp-cpl-base-css', plugins_url('static/css/wp-cat-list-theme.css', itgdb_wp_cpl_loader::$abs_file), array(), itgdb_wp_cpl_loader::$version);
        if(!is_array($wp_cpl_css_theme) || empty($wp_cpl_css_theme))
            return;
        foreach($wp_cpl_css_theme as $i => $css_id) {
            if(isset($css_list[$css_id])) {
                wp_enqueue_style('wp_cpl_css_' . $css_id, $css_list[$css_id]['css_url'], array(), itgdb_wp_cpl_loader::$version);
            }
        }
    }
}
