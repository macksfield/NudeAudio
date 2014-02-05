<?php
/**
 * The main Widget Class
 * This is used by the loader to hook to WP
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.3
 */
class WP_Category_Post_List_itg extends WP_Widget {

    /**
     * The constructor function
     */
    function WP_Category_Post_List_itg() {

        /** Widget option */
        $widget_ops = array('description' => 'List down your posts by category. With Thumbnail and more!!');

        /** Control Options */
        $control_ops = array('width' => 500);

	/** Call the parent constructor **/
	parent::WP_Widget( false, $name = 'WP Category Post List', $widget_ops, $control_ops );
    }

    /**
     * The main Widget
     * All the magic Happens here
     */

    function widget($args, $instance) {

        /** The translator */
        $wp_cat_list_itg_tans = 'wp-cat-list-itg';

	/** Extact default things */
	extract($args);

	/** Now lets start the main output */
	/**
	 * We are using wp_cache_get, wp_cache_set and wp_cache_delete for better caching of the complex query results
	 * Hat Tip: Most Commented Widget <http://plugins.trac.wordpress.org/browser/most-commented/trunk/most-commented.php?rev=248712#L56>
	 */
	if(!$output = wp_cache_get($widget_id)) {
		/**
		 * Initiate the output
		 * and the post_output
		 */
		$output = '';
		$post_output = '';

                /**
                 * We get the category here
                 * as of v1.1.0 we support current category
                 * If current category is selected and this is home page then no widget is shown
                 */
                if($instance['cat_id'] == -1) {

                    //We return if this is not a single post page. So, no widget for this
                    if(!is_single() && !is_category())
                        return;

                    if(is_single()) {
                        $wp_cpl_cat = get_the_category();

                        //Although there wont be such case, but still for safety.
                        if(! $wp_cpl_cat[0]->cat_ID)
                                return; //This returns the widget function. So no widget is created

                        $cat_id = (int) $wp_cpl_cat[0]->cat_ID;
                    } else {
                        $wp_cpl_cat = get_query_var('cat');
                        $cat_id = (int) $wp_cpl_cat;
                    }

                    unset($wp_cpl_cat);
                }
                else {
                    $cat_id = (int) $instance['cat_id'];
                }

                /**
                 * A new instance of the output class
                 */
                $i = 0;
                include_once itgdb_wp_cpl_loader::$abs_path . '/includes/wp_cpl_output_gen.php';
                $out_class = new itgdb_wp_cpl_output_gen();
                $post_output = $out_class->widget_output_gen($instance, $cat_id, $i);



		/**
		 * Done the Loop
		 * Now add the main widget data to the output
		 */

		/** The themes before widget */
		$output .= $before_widget;

		/** The title with parameters */
		//%widget_num%/%cat_count% of %cat_name%
		$wp_cpl_cat_info = get_category($cat_id);

		$title = str_ireplace(array('%widget_num%', '%cat_count%', '%cat_name%'), array($i, $wp_cpl_cat_info->count, $wp_cpl_cat_info->name), $instance['title']);
		$title = apply_filters('widget_title', $title);

                /** Add hyperlink to the title if active */
                if(true == $instance['title_hyper'])
                    $title = '<a href="' . get_category_link ($instance['cat_id']) . '">' . $title . '</a>';

		$output .= $before_title . $title . $after_title;

		/**
		 * Set the USER made before, after widget
		 */
		if(false == $instance['list_style']) {
			$before_main_widget = (('' != $instance['before_main_widget'])? $instance['before_main_widget'] : '<ul class="%widget_class%">');
			$after_main_widget = (('' != $instance['after_main_widget'])? $instance['after_main_widget'] : '</ul>');
		}
		else {
			$before_main_widget = '<ul class="%widget_class%">';
			$after_main_widget = '</ul>';
		}

		/**
		 * Now apply the class to the widget
		 */
		$wp_cpl_widget_class = (('' != $instance['widget_class'])? 'wp-cpl-widget '. $instance['widget_class'] . ' wp-cpl-theme-' . $instance['css_theme'] : 'wp-cpl-widget' . ' wp-cpl-theme-' . $instance['css_theme']);
		$before_main_widget = str_ireplace('%widget_class%', $wp_cpl_widget_class, $before_main_widget);

		/**
		 * Wrap the $post_output with the before and after user widget html
		 * for the $output we have upto the title
		 */
		$post_output = $before_main_widget . $post_output . $after_main_widget;

		/**
		 * Add the teaser if present
		 */
		if('' != $instance['teaser']) {
			$teaser = str_ireplace(array('%widget_num%', '%cat_count%', '%cat_name%'), array((int) $i, (int) itgdb_wp_cpl_loader::wp_get_postcount($cat_id), $wp_cpl_cat_info->name), $instance['teaser']);
			$post_output .= '<p class="wp-cpl-teaser">' . $teaser . '</p>';
		}

                /**
                 * Check to see if feed syndication is active
                 * Now, user can put their custom html
                 * @since v1.1.0
                 */
		if(true == $instance['show_feed'] && '' != $instance['feed_html']) {
                        $post_output .= '<p class="wp-cpl-feed-subs"><a href="' . get_category_feed_link($cat_id) . '">' . $instance['feed_html'] . '</a></p>';
		}

		/**
		 * Add the read more thing
                 * Here also user can select whether or not to show the link
                 * and provide custom html
                 * @since v1.1.0
		 */
		if(true == $instance['show_read_more'] && '' != $instance['read_more_html']) {
			$post_output .= '<p class="wp-cpl-read-more"><a href="' . get_category_link($cat_id) . '" title="' . $wp_cpl_cat_info->description . '">' . $instance['read_more_html'] . '</a></p>';
		}

		/**
		 * Done all the dynamic things
		 * Now add the post_output to output and close the theme's widget
		 */
		$output .= $post_output;
		$output .= $after_widget;

                /**
                 * Final free up of memory
                 */
                unset($post_output);
                unset($wp_cpl_cat_info);

		/**
		 * Cache it for future use
		 */
		wp_cache_set($widget_id, $output, '', 18);

	}
	echo $output;
    }
    /**
     * The save options function
     */
    function update($new_instance, $old_instance) {
	/** Set the previous value */
	$instance = $old_instance;

	/** Extract the current values for shortcut */
	extract($new_instance);

	/** Sanitize the inputs properly */
	$instance['title']		= strip_tags($title);
	$instance['teaser']		= strip_tags($teaser);
	$instance['cat_id']		= (int) $cat_id;
        $instance['css_theme']          = $css_theme;
	$instance['show_feed']		= (bool) $show_feed;
        $instance['show_read_more']     = (bool) $show_read_more;
	$instance['feed_html']  	= wp_kses_data($feed_html);
        $instance['read_more_html']     = wp_kses_data($read_more_html);
	$instance['is_thumb']		= (bool) $is_thumb;
	$instance['thumb_class']	= strip_tags($thumb_class);
	$instance['list_num']		= (int) $list_num;
	$instance['widget_class']	= strip_tags($widget_class);
	$instance['list_style']		= (bool) $list_style;
	$instance['show_comments']	= (bool) $show_comments;
	$instance['sort_using']		= (int) $sort_using;
	$instance['sort_order']		= (bool) $sort_order;
	$instance['before_main_widget']	= $before_main_widget;
	$instance['after_main_widget']	= $after_main_widget;
	$instance['before_link']	= $before_link;
	$instance['after_link']		= $after_link;
	$instance['exclude_post']	= strip_tags($exclude_post);
	$instance['sticky_post']	= strip_tags($sticky_post);
	$instance['open_in']		= (bool) $open_in;
	$instance['alternate_list_css']	= (bool) $alternate_list_css;
        $instance['show_date']          = (bool) $show_date;
        $instance['show_author']        = (bool) $show_author;
        $instance['show_excerpt']       = (bool) $show_excerpt;
        $instance['excerpt_length']     = (int) $excerpt_length;
        $instance['optional_excerpt']   = (bool) $optional_excerpt;
        $instance['title_hyper']        = (bool) $title_hyper;

        /**
         * Little negative fix for excerpt_length and list_num
         * @since 1.1.0
         */
        if($instance['list_num'] < 0)
            $instance['list_num'] = $instance['list_num']*(-1);
        if($instance['excerpt_length'] < 0)
            $instance['excerpt_length'] = $instance['excerpt_length']*(-1);

	/** Delete the previous cache */
	wp_cache_delete($this->id);

	/** Check for any error */

	/** Reset the error first */
	$instance['error'] = false;

	/** Now search for possibilities */
	if($instance['title'] == '')
		$instance_error .= '<li>&rarr;' . __('<strong style="color: red">Error</strong>: The Title field is empty', 'wp-cat-list-itg') . '</li>';

	if($instance['cat_id'] != -1 && !category_exists($instance['cat_id']))
		$instance_error .= '<li>&rarr;' . __('<strong style="color: red">Error</strong>: The category does not exists', 'wp-cat-list-itg') . '</li>';

	$form_cat_count = itgdb_wp_cpl_loader::wp_get_postcount($instance['cat_id']);
	if($instance['cat_id'] != -1 && 0 == $form_cat_count)
		$instance_error .= '<li>&rarr;' . __('<strong style="color: red">Error</strong>: The category is empty', 'wp-cat-list-itg') . '</li>';
	else if ($instance['cat_id'] != -1 && $instance['list_num'] > $form_cat_count)
		$instance_error .= '<li>&rarr;' . __('<strong style="color: #c3bc00">Warning</strong>: The number of posts is less than your entered number. No worries though! <em>Total number of posts', 'wp-cat-list-itg') .  $form_cat_count . '</em></li>';

	if(isset($instance_error)) {
		$instance_error = '<ul style="font-style: italic">' . $instance_error . '</ul>';
		$instance['error'] = $instance_error;
	}
	/** Return it */
	return $instance;
    }

    /**
     * The backend form
     * @param string $title The title of the widget
     * @param string $teaser The teaser to display below the list
     * @param int $cat_id The category id to list
     * @param bool $show_feed Link to the Feed of the category
     * @param string $feed_html html inside the feed link anchor
     * @param bool $show_read_more Show a read more button
     * @param string $read_more_html html inside the read more anchor tag
     * @param bool $is_thumb Whether or not to display thumbnail
     * @param string $thumb_class The CSS Class applied to the thumbnail
     * @param int $list_num The number of posts to list down
     * @param string $widget_class The CSS class of the widget <div class="blah"></div>
     * @param bool $list_style Whether or not ul li list style or custom
     * @param bool $show_comments Whether or not to show comment count
     * @param int $sort_using 1=>Date 2=>Comment 3=>ID 4=>Title 5=> Random
     * @param bool $sort_order TURE=>ASC FALSE=>DESC
     * @param string $before_main_widget HTML or whatever before the link list starts
     * @param string $before_link HTML before the <a> tag
     * @param strong $after_link HTML after the </a> tag
     * @param string $after_main_widget HTML or whatever after the link list ends
     * @param string $exclude_post CSV of posts to exclude
     * @param string $sticky_post CSV of posts to make sticky
     * @param bool $highlight_sticky to add custom class to sticky post X NOT USING
     * @param string $sticky_class Class added to sticky posts X NOT USING. As I thought giving a default class can save the user using custom CSS selector and also can save me by excluding a couple of options :)
     * @param bool $open_in New tab(false) or current tab(true)
     * @param bool $alternate_list_css YES(TRUE) NO(FALSE)
     * @param bool $show_date Show date to the list
     * @param bool $show_author link author url to the list
     * @param bool $show_excerpt add excerpt of the posts to the list
     * @param string $error If there exists any error
     */
    function form($instance) {
	/** The translator domain */
	$wp_cat_list_itg_tans = 'wp-cat-list-itg';

	/** Register the instance */

	$instance = wp_parse_args((array) $instance, array (
	    'title'			=> 'Browse %cat_name%',
	    'teaser'			=> 'Featuring Top %widget_num%/%cat_count% of %cat_name%',
	    'cat_id'			=> NULL,
            'css_theme'                 => 0,
	    'show_feed'			=> true,
            'show_read_more'            => true,
	    'feed_html' 		=> 'Subscribe',
            'read_more_html'            => 'Read more',
	    'is_thumb'			=> true,
	    'thumb_class'		=> 'thumb_lay',
	    'list_num'			=> 10,
	    'widget_class'		=> '',
	    'list_style'		=> true,
	    'show_comments'		=> false,
	    'sort_using'		=> 1,
	    'sort_order'		=> true,
	    'before_main_widget'	=> '<div class="%widget_class%">',
	    'before_link'		=> '<p class="%list_class%">',
	    'after_link'		=> '</p>',
	    'after_main_widget'		=> '</div>',
	    'exclude_post'		=> '',
	    'sticky_post'		=> '',
	    'open_in'			=> true,
	    'alternate_list_css'	=> true,
            'show_date'                 => false,
            'show_author'               => false,
            'show_excerpt'              => false,
            'excerpt_length'            => 50,
            'optional_excerpt'          => false,
            'title_hyper'               => false,
	    'error'			=> false
	));

        /** The css class */
        $wp_cpl_css = new itgdb_wp_cpl_css_filter();
	/** Parse the value */
	extract($instance);

        /** Category list */
        $cat_lists = get_categories(array('type' => 'post', 'hide_empty' => 0, 'orderby' => 'name', 'order' => 'ASC', 'taxonomy' => 'category'));

	/** Output the form */
	if($error) {
	    ?>
	<h4 style="color: #830000;"><strong><?php _e('The following errors have occured', $wp_cat_list_itg_tans); ?></strong></h4>
	<?php echo $error; ?>
	    <?php
	}
	?>

	<!-- Basic options -->
	<h3><?php _e('Basic Options &raquo;', $wp_cat_list_itg_tans); ?></h3>
	<p> <!-- Title -->
	    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title of Widget: ', $wp_cat_list_itg_tans); ?></label>
	    <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" />
            <br />
            <label for="<?php echo $this->get_field_id('title_hyper'); ?>"><?php _e('Hyperlink the title to the selected category: &raquo;', $wp_cat_list_itg_tans); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('title_hyper'); ?>" name="<?php echo $this->get_field_name('title_hyper'); ?>"<?php if(true == $title_hyper) { ?> checked="checked"<?php } ?> />
        </p>
	<p><!-- Teaser -->
	    <label for="<?php echo $this->get_field_id('teaser'); ?>"><?php _e('Teaser Text: &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <input type="text" id="<?php echo $this->get_field_id('teaser'); ?>" name="<?php echo $this->get_field_name('teaser'); ?>" value="<?php echo $teaser; ?>" class="widefat" />
	</p>
	<p>
            <span class="description">
                <?php
                _e('Title and Teaser supports the same dynamic tags/parameters. Leave teaser empty to hide it. For a list of available parameters go to <a href="options-general.php?page=wp_cpl_itg_page">WP CPL settings page</a>', $wp_cat_list_itg_tans);
                ?>
            </span>
	</p>
	<p> <!-- Category -->
	    <label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e('Category: ', $wp_cat_list_itg_tans); ?></label>
	    <select id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>">
                <option value="-1"<?php if(-1 == $cat_id) { ?> selected="selected"<?php } ?>>Current category of post</option>
                <?php
		foreach($cat_lists as $cat_list) {
		    ?>
		    <option value="<?php echo $cat_list->term_id; ?>"<?php if($cat_list->term_id == $cat_id) { ?> selected="selected"<?php } ?>><?php echo $cat_list->name.' ('.$cat_list->count.')'; ?></option>
		    <?php
		}
		?>
	    </select>
	</p>
        <p><!-- CSS Theme -->
            <label for="<?php echo $this->get_field_id('css_theme'); ?>"><?php _e('CSS Theme: ', $wp_cat_list_itg_tans); ?></label>
            <select id="<?php echo $this->get_field_id('css_theme'); ?>" name="<?php echo $this->get_field_name('css_theme'); ?>">
                <option value="no">No CSS Theme</option>
                <?php echo $wp_cpl_css->list_widget_selectbox($css_theme); ?>
            </select>
        </p>
        <p>
            <span class="description">
                <?php
                _e('Selecting the No CSS Theme will make the widget hold no special css class but just the default ones. So only the default formatting will get applied.', $wp_cat_list_itg_tans);
                ?>
            </span>
        </p>
	<p> <!-- Number | Comment -->
	    <label for="<?php echo $this->get_field_id('list_num'); ?>"><?php _e('Number of Posts to show: &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <input type="text" name="<?php echo $this->get_field_name('list_num'); ?>" id="<?php echo $this->get_field_id('list_num'); ?>" class="small-text code" value="<?php echo $list_num; ?>" />
        </p>
        <p> <!-- Comment | Date -->
	    <label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e('Show Comment count? &raquo; ', $wp_cat_list_itg_tans); ?></label>
	    <input type="checkbox" name="<?php echo $this->get_field_name('show_comments'); ?>" id="<?php echo $this->get_field_id('show_comments'); ?>"<?php if(true == $show_comments) { ?> checked="checked"<?php } ?> />
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show date: &raquo;', $wp_cat_list_itg_tans); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name('show_date'); ?>" id="<?php echo $this->get_field_id('show_date'); ?>"<?php if(true == $show_date) { ?> checked="checked"<?php } ?> />
        </p>
        <p> <!-- Author | Excerpt -->
            <label for="<?php echo $this->get_field_id('show_author'); ?>"><?php _e('Show Author: &raquo;', $wp_cat_list_itg_tans); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name('show_author'); ?>" id="<?php echo $this->get_field_id('show_author'); ?>"<?php if(true == $show_author) { ?> checked="checked"<?php } ?> />
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show Excerpt: &raquo', $wp_cat_list_itg_tans); ?> </label>
            <input type="checkbox" name="<?php echo $this->get_field_name('show_excerpt'); ?>" id="<?php echo $this->get_field_id('show_excerpt'); ?>"<?php if(true == $show_excerpt) { ?> checked="checked"<?php } ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt length: &raquo', $wp_cat_list_itg_tans); ?></label>
            <input type="text" class="small-text code" name="<?php echo $this->get_field_name('excerpt_length'); ?>" id="<?php echo $this->get_field_id('excerpt_length'); ?>" value="<?php echo $excerpt_length; ?>" />
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <label for="<?php echo $this->get_field_id('optional_excerpt'); ?>"><?php _e('Use post excerpt if available', $wp_cat_list_itg_tans); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name('optional_excerpt'); ?>" id="<?php echo $this->get_field_id('optional_excerpt'); ?>"<?php if(true == $optional_excerpt) { ?> checked="checked"<?php } ?> />
            <br />
            <span class="description"><?php _e(' Post content will be chopped off upto the entered character length. If you tick the Post Excerpt then it will be used if available, instead of chopping the original content', $wp_cat_list_itg_tans); ?> </span>
        </p>

	<p> <!-- Show Feed | Show Read More -->
	    <label for="<?php echo $this->get_field_id('show_feed'); ?>"><?php _e('Show Feed? &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <input type="checkbox" name="<?php echo $this->get_field_name('show_feed'); ?>" id="<?php echo $this->get_field_id('show_feed'); ?>"<?php if(true == $show_feed) { ?> checked="checked"<?php } ?> />
	    &nbsp;&nbsp;|&nbsp;&nbsp;
            <label for="<?php echo $this->get_field_id('show_read_more'); ?>"><?php _e('Show Read more? &raquo;', $wp_cat_list_itg_tans); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name('show_read_more'); ?>" id="<?php echo $this->get_field_id('show_read_more'); ?>"<?php if(true == $show_read_more) { ?> checked="checked"<?php } ?> />
            <br />
            <span class="description">
                <?php _e('Whether to or not to show feed link and read more link at the end of the widget(After the teaser)', $wp_cat_list_itg_tans); ?>
            </span>
        </p>
        <p> <!-- Feed HTML | Read More HTML -->
	    <label for="<?php echo $this->get_field_id('feed_html'); ?>"><?php _e('Feed HTML/Text &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <input type="text" name="<?php echo $this->get_field_name('feed_html'); ?>" id="<?php echo $this->get_field_id('feed_html'); ?>" value="<?php echo $feed_html; ?>" />
            <br />
            <label for="<?php echo $this->get_field_id('read_more_html'); ?>"><?php _e('Read more HTML/Text &raquo;', $wp_cat_list_itg_tans); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('read_more_html'); ?>" id="<?php echo $this->get_field_id('read_more_html'); ?>" value="<?php echo $read_more_html; ?>" />
	    <br />
	    <span class="description">
		<?php _e('Works only if Show Feed Link and/or Read more link is checked. Enter simple text or some HTML, preferably image code like &lt;img src=&quote;http://path/to/img/url.jpg&quote; /&gt;. They will be placed inside the anchor tag.', $wp_cat_list_itg_tans); ?>
	    </span>
	</p>
	<p> <!-- is thumb | Thumb class -->
	    <label for="<?php echo $this->get_field_id('is_thumb'); ?>"><?php _e('Show Thumbnail? &raquo; ', $wp_cat_list_itg_tans); ?></label>
	    <input type="checkbox" name="<?php echo $this->get_field_name('is_thumb'); ?>" id="<?php echo $this->get_field_id('is_thumb'); ?>"<?php if(true == $is_thumb) { ?> checked="checked"<?php } ?> />
	    &nbsp;&nbsp;|&nbsp;&nbsp;
	    <label for="<?php echo $this->get_field_id('thumb_class'); ?>"><?php _e('Thumbnail Class: &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <input type="text" name="<?php echo $this->get_field_name('thumb_class'); ?>" id="<?php echo $this->get_field_id('thumb_class'); ?>" value="<?php echo $thumb_class; ?>" />
	    <span class="description"><?php _e('Optional', $wp_cat_list_itg_tans); ?></span>
	</p>
	<p><!-- Sort Using | Sort Order -->
	    <label for="<?php echo $this->get_field_id('sort_using'); ?>"><?php _e('Sort Using: &raquo; ', $wp_cat_list_itg_tans); ?></label>
	    <select name="<?php echo $this->get_field_name('sort_using'); ?>" id="<?php echo $this->get_field_id('sort_using'); ?>">
		<?php
		$sort_using_ops = array(1 => 'Date', 2 => 'Comment', 3 => 'ID', 4 => 'Title', 5 => 'Random');
		foreach($sort_using_ops as $sort_using_op_key => $sort_using_op_value) {
		    ?>
		    <option value="<?php echo $sort_using_op_key; ?>"<?php if($sort_using == $sort_using_op_key) { ?> selected="selected"<?php } ?>><?php _e($sort_using_op_value, $wp_cat_list_itg_tans); ?></option>
		    <?php
		}
		?>
	    </select>
	    &nbsp;&nbsp;|&nbsp;&nbsp;
	    <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e('Sort Order &raquo;', $wp_cat_list_itg_tans); ?></label>
	    <select name="<?php echo $this->get_field_name('sort_order'); ?>" id="<?php echo $this->get_field_id('sort_order'); ?>">
		<option value="0"<?php if(false == $sort_order) echo ' selected="selected"'; ?>><?php _e('Descending', $wp_cat_list_itg_tans); ?></option>
		<option value="1"<?php if(true == $sort_order) echo ' selected="selected"'; ?>><?php _e('Ascending', $wp_cat_list_itg_tans); ?></option>
	    </select>
	</p>
	<!-- Advanced Options -->
	<h3><?php _e('Advance Options &raquo;', $wp_cat_list_itg_tans); ?></h3>
	<div>
	<a class="button-secondary wp-cpl-itg-but" href="#"><?php _e('Toggle Options', $wp_cat_list_itg_tans); ?></a>
	<div class="wp-cpl-itg-advop" style="display: none;">
		<br class="clear clearfix" style="height: 10px" />
		<p> <!-- list style | Widget Class -->
		    <label for="<?php echo $this->get_field_id('list_style'); ?>"><?php _e('List Style: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <select name="<?php echo $this->get_field_name('list_style'); ?>" id="<?php echo $this->get_field_id('list_style'); ?>">
			<option value="0"<?php if(false == $list_style) echo ' selected="selected"'; ?>>Custom Style</option>
			<option value="1"<?php if(true == $list_style) echo ' selected="selected"'; ?>>HTML unordered list</option>
		    </select>
		    &nbsp;&nbsp;|&nbsp;&nbsp;
		    <label for="<?php echo $this->get_field_id('widget_class'); ?>"><?php _e('Widget Class: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('widget_class'); ?>" id="<?php echo $this->get_field_id('widget_class'); ?>" value="<?php echo $widget_class; ?>" />
		    <br />
		    <span class="description"><?php _e('These classes will be added to the <code>&lt;ul class="your_class"&gt;</code> if using the default listing style. Else you should use options parameters for constructing your custom HTML structure. For example &lt;div class="your_class %widget_class%"&gt;. The %widget_class% will be replaced by the default class by the widget. For more read the FAQ from the plugins Settings page.', $wp_cat_list_itg_tans); ?></span>
		</p>
		<p> <!-- Before main widget | After main widget -->
		    <label for="<?php echo $this->get_field_id('before_main_widget'); ?>"><?php _e('Before List: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('before_main_widget'); ?>" id="<?php echo $this->get_field_id('before_main_widget'); ?>" value="<?php echo esc_html($before_main_widget); ?>" />
		    &nbsp;&nbsp;|&nbsp;&nbsp;
		    <label for="<?php echo $this->get_field_id('after_main_widget'); ?>"><?php _e('After List: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" value="<?php echo esc_html($after_main_widget); ?>" name="<?php echo $this->get_field_name('after_main_widget'); ?>" id="<?php echo $this->get_field_id('after_main_widget'); ?>" />
		</p>
		<p> <!-- Before Link | After Link -->
		    <label for="<?php echo $this->get_field_id('before_link'); ?>"><?php _e('Before Link: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('before_link'); ?>" id="<?php echo $this->get_field_id('before_link'); ?>" value="<?php echo esc_html($before_link); ?>" />
		    &nbsp;&nbsp;|&nbsp;&nbsp;
		    <label for="<?php echo $this->get_field_id('after_link'); ?>"><?php _e('After Link: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('after_link'); ?>" id="<?php echo $this->get_field_id('after_link'); ?>" value="<?php echo esc_html($after_link); ?>" />
		    <br />
		    <span class="description">
			<?php
			_e('Before link and after will appear before and after the &lt;a href="your_link.html"&gt;anchor_text&lt;/a&gt;. <br />Similarly, before list and after list will wrap the whole link list', $wp_cat_list_itg_tans);
			?>
		    </span>
		</p>
		<p> <!-- exclude post and sticky post -->
		    <label for="<?php echo $this->get_field_id('exclude_post'); ?>"><?php _e('Exclude: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('exclude_post'); ?>" id="<?php echo $this->get_field_id('exclude_post'); ?>" value="<?php echo $exclude_post; ?>" />
		    <label for="<?php echo $this->get_field_id('sticky_post'); ?>"><?php _e('Sticky: &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="text" name="<?php echo $this->get_field_name('sticky_post'); ?>" id="<?php echo $this->get_field_id('sticky_post'); ?>" value="<?php echo $sticky_post; ?>" />
		    <br />
		    <span class="description">
			    <?php _e('Comma seperated values of post ids. Eg: 34,56,98,13,54 etc. No white space no trailing comma', $wp_cat_list_itg_tans); ?>
		    </span>
		</p>
		<p> <!-- Open in option -->
		    <label for="<?php echo $this->get_field_id('open_in'); ?>"><?php _e('Open in? &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <select name="<?php echo $this->get_field_name('open_in'); ?>" id="<?php echo $this->get_field_id('open_in'); ?>">
			    <option value="0"<?php if(false == $open_in) echo ' selected="selected"'; ?>>New Tab or Window</option>
			    <option value="1"<?php if(true == $open_in) echo ' selected="selected"'; ?>>Current Tab or Window</option>
		    </select>
		</p>
		<p> <!-- Alternate listing style -->
		    <label for="<?php echo $this->get_field_id('alternate_list_css'); ?>"><?php _e('Apply alternate style? &raquo;', $wp_cat_list_itg_tans); ?></label>
		    <input type="checkbox" name="<?php echo $this->get_field_name('alternate_list_css'); ?>" id="<?php echo $this->get_field_id('alternate_list_css'); ?>"<?php if(true == $alternate_list_css) echo ' checked="checked"'; ?> />
		    <br />
		    <span class="description">
			    <?php _e('If checked, then the classes wp-cpl-odd or wp-cpl-even will be added to the respective odd or even items of the list', $wp_cat_list_itg_tans); ?>
		    </span>
		</p>
	</div>
	</div>
	<?php
    }
}
