<?php
/**
 * admin-classes
 * The library of all the administration classes
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.2
 */

/**
 * The main settings class
 * admin backend
 */
class itgdb_wp_cpl_settings extends itgdb_wp_cpl_admin_base {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * On post save option
     */
    public function save_post() {
        //master reset
        if(isset($this->post['master_reset']) && $this->post['master_reset'] == 'do') {
            $wp_cpl_op = array(
                'wp_cpl_version' => itgdb_wp_cpl_loader::$version,
                'wp_cpl_use_def_css' => true,
                'wp_cpl_thumb_size' => array(50,50),
                'wp_cpl_sc_thumb_size' => array(150,150),
                'wp_cpl_css_theme' => array(0,1,2,3),
            );
            update_option('wp-cpl-itg-op', $wp_cpl_op);
            return 1;
        }
        if(!is_array($this->post['css_list']))
                $this->post['css_list'] = array();
        $wp_cpl_op = array(
            'wp_cpl_version' => itgdb_wp_cpl_loader::$version,
            'wp_cpl_use_def_css' => (bool) $this->post['wp-cpl-def-css'],
            'wp_cpl_thumb_size' => array((int) $this->post['wp-cpl-thumb-sizew'], (int) $this->post['wp-cpl-thumb-sizeh']),
            'wp_cpl_sc_thumb_size' => array((int) $this->post['wp-cpl-sc-thumb-sizew'], (int) $this->post['wp-cpl-sc-thumb-sizeh']),
            'wp_cpl_css_theme' => array_merge(array(), $this->post['css_list']),
        );
        if(update_option('wp-cpl-itg-op', $wp_cpl_op))
            return true;
        else
            return false;
    }
    
    /**
     * Settings page
     */
    public function gen_set_page() {
        /**
         * If the user has got the permission
         */
        if (!current_user_can('manage_options'))  {
            wp_die( __('You do not have sufficient permissions to access this page.', itgdb_wp_cpl_loader::$text_domain) );
        }
        
        $wp_cpl_css = new itgdb_wp_cpl_css_filter();

        /**
         * Update options on POST
         */
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $r = $this->save_post();
            if(true === $r) {
                $this->print_update('Options Saved');
            }
            else if(1 === $r) {
                $this->print_update('Master Reset successful');
            }
            else {
                $this->print_error('You did not change anything to save. If this is not the case, please contact developer - <a href="mailto:swashata@intechgrity.com">Swashata</a>');
            }
        }

        /**
         * Get the options for future use
         */
        extract(get_option('wp-cpl-itg-op'));
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.postbox').children('h3, .handlediv').click(function(){
                    $(this).siblings('.inside').toggle();
                });
            }); 
        </script>
        <div class="wrap">
            <h2><?php _e('Configure the Global options of WP CPL', itgdb_wp_cpl_loader::$text_domain); ?></h2>
            <p><small>Plugin developed by <a href="http://www.swashata.com/">Swashata</a> | View Blog - <a href="http://www.intechgrity.com">InTechgrity</a> | <a href="http://www.intechgrity.com/about/buy-us-some-beer/">Donate</a> | <a href="http://www.intechgrity.com/contct-us/">Hire</a> | <strong>Version:</strong> <?php echo itgdb_wp_cpl_loader::$version; ?></small></p>
            <div id="poststuff" class="metabox-holder">
            <div class="meta-box-sortables">
                <div class="wp-cpl-wrap">
                    <div class="wp-cpl-wrap-left">
                        <!--
                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"></h3>
                            <div class="inside">

                            </div>
                        </div>
                        -->
                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-op"><span></span><?php _e('Global Options', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                    <ul>
                                        <li>
                                            <label for="wp-cpl-def-css"><?php _e('Use Default CSS? &raquo;', itgdb_wp_cpl_loader::$text_domain); ?></label>
                                            <input type="checkbox" id="wp-cpl-def-css" name="wp-cpl-def-css"<?php if(true == $wp_cpl_use_def_css) { ?> checked="checked"<?php } ?> />
                                        </li>
                                        <li>
                                            <span class="description">
                                                <?php _e('This will add the default CSS file to your theme. Make sure your theme has something like <code>wp_head()</code> inside the header.php file.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </span>
                                        </li>
                                        <li>
                                            <label for="wp-cpl-thumb-sizew"><?php _e('Widget Thumbnail Size Width - Height: &raquo;', itgdb_wp_cpl_loader::$text_domain); ?></label>
                                            <input type="text" class="" id="wp-cpl-thumb-sizew" name="wp-cpl-thumb-sizew" value="<?php echo $wp_cpl_thumb_size[0]; ?>" /> - 
                                            <input type="text" class="" id="wp-cpl-thumb-sizeh" name="wp-cpl-thumb-sizeh" value="<?php echo $wp_cpl_thumb_size[1]; ?>" />
                                        </li>
                                        <li>
                                            <label for="wp-cpl-sc-thumb-size"><?php _e('Shortcode Thumbnail Size Width - Height: &raquo;', itgdb_wp_cpl_loader::$text_domain); ?></label>
                                            <input type="text" class="" id="wp-cpl-sc-thumb-sizew" name="wp-cpl-sc-thumb-sizew" value="<?php echo $wp_cpl_sc_thumb_size[0]; ?>" /> - 
                                            <input type="text" class="" id="wp-cpl-sc-thumb-sizeh" name="wp-cpl-sc-thumb-sizeh" value="<?php echo $wp_cpl_sc_thumb_size[1]; ?>" />
                                        </li>
                                        <li>
                                            <span class="description">
                                                <?php _e('Make sure to Run <a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/">Regenerate Thumbnail Plugin</a> After modifying the thumbnail size. This is necessary if the thumb size is not already generated.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </span>
                                        </li>
                                        <li>
                                            <label for="wp-cpl-css-theme"><?php _e('Select Theme: &raquo;', itgdb_wp_cpl_loader::$text_domain); ?></label>
                                        </li>
                                        <li>
                                            <ul class="ul-square">
                                                <?php $wp_cpl_css->list_admin_selectbox($wp_cpl_css_theme); ?>
                                            </ul>
                                        </li>
                                        <li>
                                            <div style="border: 1px solid #ff6666; background: #ffcccc; padding-left: 5px; padding-right: 5px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;"><p>
                                                <label for="master_reset">Do Master Reset?</label> 
                                                <input type="checkbox" id="master_reset" name="master_reset" value="do" />
                                                <span class="description"><?php _e('Warning! Everything will be reset to default. Do this if you are having errors in the admin section', itgdb_wp_cpl_loader::$text_domain); ?></span>
                                            </p></div>
                                        </li>
                                        <li>
                                            <input class="button-primary" type="submit" value="<?php _e('Save Options', itgdb_wp_cpl_loader::$text_domain); ?>" />
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-ins"><span></span><?php _e('Usage Instruction', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <p>
                                    <?php _e('The Wordpress Category Post Lists is a powerful Wordpress Widget & Shortcode plugin, giving you complete control over how your posts are displayed on your sidebar filtered by categories or directly on pages.', itgdb_wp_cpl_loader::$text_domain); ?>
                                    <br />
                                    <?php _e('The only options you need to set here are the global thumbnail sizes and whether you want to use the default CSS file provided with this plugin.', itgdb_wp_cpl_loader::$text_domain); ?>
                                    <br />
                                    <?php _e('Everything else can be set from the widgets options page. Here are all the information about the options, and the available parameters', itgdb_wp_cpl_loader::$text_domain); ?>
                                </p>
                                <h4>Widget Options</h4>
                                <table class="widefat fixed">
                                    <thead>
                                        <tr>
                                            <th width="14%" scope="col"><?php _e('Option', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th width="20%" scope="col"><?php _e('Description', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th width="30%" scope="col"><?php _e('Parameter', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th width="18%" scope="col"><?php _e('Default', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th width="18%" scope="col"><?php _e('Example', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th scope="col"><?php _e('Option', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th scope="col"><?php _e('Description', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th scope="col"><?php _e('Parameter', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th scope="col"><?php _e('Default', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <th scope="col"><?php _e('Example', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" align="right"><strong>
                                                <?php _e('Basic Options', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </strong></td>
                                        </tr>
                                        <tr>
                                            <th><?php _e('Title', itgdb_wp_cpl_loader::$text_domain); ?></th>
                                            <td>
                                                <?php _e('The Title of the widget. This will be displayed over the top of each widget', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('It has the following options paramter. You can insert them on the title and it will get replaced by the corresponding values', itgdb_wp_cpl_loader::$text_domain); ?>
                                                <ul class="wp-cpl-admin-ul">
                                                    <li>
                                                        <strong>%widget_num%</strong> :
                                                        <?php _e('The number of posts you want to display', itgdb_wp_cpl_loader::$text_domain); ?>
                                                    </li>
                                                    <li>
                                                        <strong>%cat_count%</strong> :
                                                        <?php _e('The total number of posts the category has', itgdb_wp_cpl_loader::$text_domain); ?>
                                                    </li>
                                                    <li>
                                                        <strong>%cat_name%</strong> :
                                                        <?php _e('The category name', itgdb_wp_cpl_loader::$text_domain); ?>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                Browse %cat_name%
                                            </td>
                                            <td>
                                                <?php _e('Be creative and form your own', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Teaser', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('A one liner shown below the widget, just above the Read More button(if present)', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Offers Same options as Title', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td colspan="2">
                                                Featuring Top %widget_num%/%cat_count% of %cat_name%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Category', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('The category you want to chose. Select one from the list', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('CSS Theme', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong>... Choose the CSS theme for this widget. Global themes are not applied to any widget anymore', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td colspan="3">
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Number of Posts', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('The total number of posts that would be shown on the widget. This excludes the number of sticky posts.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                10
                                            </td>
                                            <td>
                                                <?php _e('What ever you can imagine', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Comment count', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Whether you want to show comment count beside every posts.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unticked. Not shown by default', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show date', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> If ticked publish date will be placed below the post title.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unticked.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show author', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> If ticked author name hyperlinked to author archive will be placed below the post title.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unticked.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show excerpt', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> If ticked post excerpt will be placed below the post title.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unticked.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Excerpt', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> The length of characters of the excerpt', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('50', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Numerical value', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Post Excerpt', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> Gives preference to manually entered WP excerpts on posts. This will override the excerpt length.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unticked', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show Feed', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('If ticked a link will be placed before the title to the feed of the category.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Ticked. Attempts to show the feed', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show Readmore', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('If ticked this will show a <strong>Read More</strong> link at the end of the widget. This will link to the category', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('By default this is ticked', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Feed HTML/Text', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> This HTML or text will be wrapped inside an anchor text hyperlinked to the category feed.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('If you would like to use image then do it like <code>&lt;img src=&quot;http://path.to/img.jpg"&quot /&gt; or simply a Text <code>[Syndicate]</code>', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Readmore HTML/Text', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('<strong>NEW on V2</strong> This HTML or text will be wrapped inside an anchor text hyperlinked to the category link.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('If you would like to use image then do it like <code>&lt;img src=&quot;http://path.to/img.jpg"&quot /&gt; or simply a Text <code>[More...]</code>', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Show Thumbnail &amp; Thumb Class', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Whether you want to show thumbnail beside every post, and if showing then the css class applied to the thumbnail', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('The Structure of the thumbnail is as follows', itgdb_wp_cpl_loader::$text_domain); ?>
                                                <p>
                                                    <pre style="max-width: 200px; overflow: auto;"><code>
    &lt;span class=&quot;wp-thumb-overlay&quot;&gt;
            &lt;span class=&quot;thumb_lay or userclass&quot;&gt;
                    &lt;img width=&quot;40&quot; height=&quot;40&quot; title=&quot;Title&quot; alt=&quot;alt&quot; class=&quot;attachment-wp-cpl-post-thumb wp-post-image&quot; src=&quot;path/to/img.jpg&quot; /&gt;
            &lt;/span&gt;
    &lt;/span&gt;</code></pre>
                                                </p>
                                            </td>
                                            <td>
                                                thumb_lay
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Sorting', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Here you have two options. Sort Order and Sort Using. You can choose from a number of available options for the Sort Using, and make it ascending or descending', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Sort Using has ID, title, comment (count)<strong>NEW on V2</strong> , date, comment or random options.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Date -> Ascendng', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" align="right">
                                                <strong>
                                                    <?php _e('Advanced Options. Just Click to Toggle button to reveal', itgdb_wp_cpl_loader::$text_domain); ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('List Style', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('How the HTML list is formed. This is basically the HTML nesting', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Unordered list is the basic ul li type listing. You can select Custom Style to insert your own HTML tags before/after the list/links', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('HTML Unordered List', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Widget Style', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('The CSS class applied to the widget', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td colspan="3">
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Before/After List/Link', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('The HTML tag before the whole Widget List', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <p>
                                                <?php _e('Before List supports only one parameter.', itgdb_wp_cpl_loader::$text_domain); ?><br />
                                                <strong>%widget_class%</strong> :
                                                <?php _e('Gets replaced by system generated widget class and your own widget class', itgdb_wp_cpl_loader::$text_domain); ?>
                                                </p>
                                                <p>
                                                    <?php _e('Similarly Before Link supports one paramter', itgdb_wp_cpl_loader::$text_domain); ?><br />
                                                    <strong>%list_class%</strong> :
                                                    <?php _e('Gets replaced by system generated list class. This is needed if you are applying alternate list css classes', 'wp-cpl-list-itg'); ?>
                                                </p>
                                            </td>
                                            <td>
                                                <ul class="wp-cpl-admin-ul">
                                                    <li>
                                                        <strong><?php _e('Before List', itgdb_wp_cpl_loader::$text_domain); ?> :<code>&lt;ul class="%widget_class%"&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('After List', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;/ul&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('Before Link', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;li class="%list_class%"&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('After Link', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;/li&gt;</code></strong>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="wp-cpl-admin-ul">
                                                    <li>
                                                        <strong><?php _e('Before List', itgdb_wp_cpl_loader::$text_domain); ?> :<code>&lt;div class="my_class %widget_class%"&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('After List', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;/div&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('Before Link', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;p class="my_post class %list_class%"&gt;</code></strong>
                                                    </li>
                                                    <li>
                                                        <strong><?php _e('After Link', itgdb_wp_cpl_loader::$text_domain); ?> : <code>&lt;/p&gt;</code></strong>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Exclude Posts', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Comma Seperated values of IDs of posts to exclude', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('The following ID format will work', itgdb_wp_cpl_loader::$text_domain); ?>
                                                <br /><br />
                                                <code>12, 34,65 75,12 ,45</code>
                                            </td>
                                            <td colspan="2">
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Sticky Posts', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td colspan="4">
                                                <?php _e('Same as Exclude Posts. Only the posts will become sticky. This will not verify whether they belong to the selected category or not. They will be placed before the normal list and CSS class wp-cpl-sticky will be applied to them', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Open in', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Whether to open in the current tab or new tab', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Basically <code>_blank</code> or <code>_self</code> will be added to the anchor tag', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('Current Tab', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <?php _e('Alternate List CSS', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </th>
                                            <td>
                                                <?php _e('Applies Alternate Listing CSS classes to the list HTML tag.', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td>
                                                <?php _e('wp-cpl-odd or wp-cpl-even CSS classes will be added accordingly', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                            <td colspan="2">
                                                <?php _e('N/A', itgdb_wp_cpl_loader::$text_domain); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h4><?php _e('Shortcode usage:', itgdb_wp_cpl_loader::$text_domain); ?></h4>
                                <p>
                                    <?php _e('The basic shortcode is ',  itgdb_wp_cpl_loader::$text_domain); ?>
                                    <code>[wp_cpl_sc cat_id=40 list_num=4 css_theme=2 sticky_post="79"]</code>
                                    <?php _e(' where you edit the cat_id (main category ID), list_num (number of posts), css_theme (the id of the theme), sticky_post (ID list of posts) etc. For more information please check the <a target="_blank" href="http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/">Documentation</a>', itgdb_wp_cpl_loader::$text_domain); ?>
                                </p>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-faq"><span></span><?php _e('FAQs', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <h4>&iquest; 
                                    <?php
                                    _e('My Thumbnails are not showing up exactly as the size I have selected', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </h4>
                                <p>
                                    <?php
                                    _e('WP CPL uses the default Thumbnail or Featured Image Feature of WP 2.9+. So, the thumbs are created when you upload the picture. For older pictures, it is not generated automatically. In such case just install and run this <a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/">Regenerate Thumbnail Plugin</a>. After installing it first time or whenever you change the Thumb size, it is recommended that you run this plugin once', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                                <h4>&iquest; 
                                    <?php
                                    _e('Can I use different thumbnail for different widget?', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </h4>
                                <p>
                                    <?php
                                    _e('This is not yet supported and I really don\'t feel like using timthumb to generate thumbnails. However in future if I ever feel, then I will incorporate this feature', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                                <h4>&iquest; 
                                    <?php
                                    _e('How can I use my own CSS for the widget', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </h4>
                                <p>
                                    <?php
                                    _e('Now this can be done using our CSS Theme filter API. A detailed instruction can be found <a href="http://www.intechgrity.com/wp-plugins/wp-category-post-list-wordpress-plugin/">HERE</a>', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                                <h4>&iquest; 
                                    <?php
                                    _e('Is it possible to use different CSS for different widget?', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </h4>
                                <p>
                                    <?php _e('Technically & simply Yes. Now you can simply choose the css theme from the dropdown (widgets) or mention the id in shortcode.', itgdb_wp_cpl_loader::$text_domain); ?>
                                </p>
                                <h4>&iquest; 
                                    <?php
                                    _e('Okay, I dont have time or I want to you to setup my Wordpress with this and other widgets. Do you accept freelancing jobs?', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </h4>
                                <p>
                                    <?php
                                    _e('Yes we do. Just drop in a message from <a href="http://www.intechgrity.com/contct-us/">HERE</a> and we will get back to you.', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="wp-cpl-wrap-right">
                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-donate"><span></span><?php _e('Support Us', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <p>
                                    <?php _e('There\'s a lot of effort behind the development of this plugin. Please support us by doing any of the following :) ', itgdb_wp_cpl_loader::$text_domain); ?>
                                    <ul class="wp-cpl-admin-ul">
                                        <li><?php _e('Buy us some beer!', itgdb_wp_cpl_loader::$text_domain); ?></li>
                                        <li><?php _e('Write about this plugin on your blog. <a href="http://www.intechgrity.com/?p=714">Read about it here</a>', itgdb_wp_cpl_loader::$text_domain); ?></li>
                                        <li><?php _e('Help the community by translating the plugin.', itgdb_wp_cpl_loader::$text_domain); ?></li>
                                    </ul>
                                </p>
                                <p>
                                    <?php
                                    _e('If you like to donate, then please use the link below', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                                <a class="don_but" href="http://www.intechgrity.com/about/buy-us-some-beer/">
                                    <img src="<?php echo plugins_url('static/css/images/donate.png', itgdb_wp_cpl_loader::$abs_file); ?>" />
                                </a>
                                <p>
                                    <?php
                                    _e('Thanks you for your support', itgdb_wp_cpl_loader::$text_domain);
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-social"><span></span><?php _e('Get Social', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <ul>
                                    <li><a href="http://www.facebook.com/swashata"><img src="<?php echo plugins_url('static/css/images/facebook_add.png', itgdb_wp_cpl_loader::$abs_file); ?>" /></a></li>
                                    <li><a href="http://www.facebook.com/pages/inTechgrity-Amalgamating-Life-Technology/232884556318"><img src="<?php echo plugins_url('static/css/images/facebook_follow.png', itgdb_wp_cpl_loader::$abs_file); ?>" /></a></li>
                                    <li><a href="http://twitter.com/swashata"><img src="<?php echo plugins_url('static/css/images/twitter_follow.png', itgdb_wp_cpl_loader::$abs_file); ?>" /></a></li>
                                    <li>Badges from <a href="http://twitterbuttons.sociableblog.com/">Sociableblog</a> :)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-itg"><span></span><?php _e('InTechgrity', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <script src="http://feeds.feedburner.com/greentechspot?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/greentechspot"></a><br/>Powered by FeedBurner</p> </noscript>
                            <p><a href="http://feedburner.google.com/fb/a/mailverify?uri=greentechspot&amp;loc=en_US">Subscribe to inTechgrity by Email</a></p>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-proj"><span></span><?php _e('Projects', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <script src="http://feeds.feedburner.com/IntechgrityProjects?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/IntechgrityProjects"></a><br/>Powered by FeedBurner</p> </noscript>
                            </div>
                        </div>

                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to Toggle', itgdb_wp_cpl_loader::$text_domain); ?>"><br /></div>
                            <h3 class="hndle"><span class="wp-cpl-admin-spon"><span></span><?php _e('Sponsors', itgdb_wp_cpl_loader::$text_domain); ?></span></h3>
                            <div class="inside">
                                <a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=5226_0_1_3" target="_blank"><img border="0" src="<?php echo plugins_url('/static/css/images/et.gif', itgdb_wp_cpl_loader::$abs_file); ?>" width="125" height="125" /></a>
                                &nbsp;
                                <a href="http://www.flexihostnz.com/aff.php?aff=016"><img src="<?php echo plugins_url('/static/css/images/fh.gif', itgdb_wp_cpl_loader::$abs_file); ?>" width="125" height="125" border="0" /></a>
                                &nbsp;
                                <a href="http://codecanyon.net?ref=swashata"><img src="<?php echo plugins_url('/static/css/images/cc.gif', itgdb_wp_cpl_loader::$abs_file); ?>" width="125" height="125" border="0" /></a>
                                &nbsp;
                                <a href="http://themeforest.net?ref=swashata"><img src="<?php echo plugins_url('/static/css/images/tf.gif', itgdb_wp_cpl_loader::$abs_file); ?>" width="125" height="125" border="0" /></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php
    }
}

/**
 * The base admin class
 * @abstract
 */
abstract class itgdb_wp_cpl_admin_base {
    var $post = array();
    
    public function __construct() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->post = $_POST;
            
            if(get_magic_quotes_gpc())
                array_walk_recursive ($this->post, array($this, 'stripslashes_gpc'));
            
            array_walk_recursive ($this->post, array($this, 'htmlspecialchar_ify'));
        }
    }
    /**
     * Prints error msg in WP style
     * @param string $msg 
     */
    protected function print_error($msg = '', $echo = true) {
        $output = '<div class="error fade"><p>' . __($msg, itgdb_wp_cpl_loader::$text_domain) . '</p></div>';
        if($echo)
            echo $output;
        else
            return $output;
    }
    
    protected function print_update($msg = '', $echo = true) {
        $output = '<div class="updated fade"><p>' . __($msg, itgdb_wp_cpl_loader::$text_domain) . '</p></div>';
        if($echo)
            echo $output;
        else
            return $output;
    }
    
    /**
     * stripslashes gpc
     * Strips Slashes added by magic quotes gpc thingy
     * @access protected
     * @param string $value 
     */
    protected function stripslashes_gpc(&$value) {
        $value = stripslashes($value);
    }
    
    protected function htmlspecialchar_ify(&$value) {
        $value = htmlspecialchars($value);
    }
    
    /**
     * Shortens a string to a specified character length.
     * Also removes incomplete last word, if any
     * @param string $text The main string
     * @param string $char Character length
     * @param string $cont Continue character(…)
     * @return string 
     */
    public function shorten_string($text, $char, $cont = '…') {
        $text = strip_tags($text);
        $text = substr($text, 0, $char); //First chop the string to the given character length
        if(substr($text, 0, strrpos($text, ' '))!='') $text = substr($text, 0, strrpos($text, ' ')); //If there exists any space just before the end of the chopped string take upto that portion only.
        //In this way we remove any incomplete word from the paragraph
        $text = $text.$cont; //Add continuation ... sign
        return $text; //Return the value
    }
    
    /**
     * Get the first image from a string
     * @param string $html
     * @return mixed string|bool The src value on success or boolean false if no src found
     */
    public function get_first_image($html) {
        $matches = array();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $html, $matches);
        if(!$output) {
            return false;
        }
        else {
            $src = $matches[1][0];
            return trim($src);
        }
    }
}

//get the pagination
include_once itgdb_wp_cpl_loader::$abs_path . '/classes/pagination.class.php';
