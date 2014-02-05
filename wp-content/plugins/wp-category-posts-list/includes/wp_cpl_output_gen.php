<?php
/**
 * The Output Generator Class
 * This common class used by widget and shortcode
 * @author Swashata <swashata4u@gmail.com>
 * @package WordPress
 * @subpackage WP Category Post List Plugin
 * @version 2.0.0
 */
class itgdb_wp_cpl_output_gen {

    private function get_posts($op, $cat_id = null) {
        $arg = array();

        //check if sticky
        if(isset($op['post__in']) && !empty ($op['post__in']) && $cat_id === null) {
            $arg['post__in'] = $op['post__in'];

            return get_posts($arg);
        }

        //not sticky... so single category
        /** Set the shortcut array for the order type **/
        //1 => 'Date', 2 => 'Comment', 3 => 'ID', 4 => 'Title', 5 => 'Random'
        $wp_cpl_sort_array = array(
            1 => 'date',
            2 => 'comment_count',
            3 => 'ID',
            4 => 'title',
            5 => 'rand'
        );

        $arg = array(
            'cat' => $cat_id,
            'numberposts' => $op['list_num'],
            'orderby' => $wp_cpl_sort_array[$op['sort_using']],
            'order' => ((true == $op['sort_order'])? 'ASC' : 'DESC'),
            'post__not_in' => $op['exclude']
        );

        return get_posts($arg);
    }

    public function shortcode_output_gen($op) {
        $trans = itgdb_wp_cpl_loader::$text_domain;
        $cat_id = (int) $op['cat_id'];
        /** Calculate stick posts and excluded posts */
        $wp_cpl_sticky = wp_parse_id_list($op['sticky_post']);
        $wp_cpl_exclude = wp_parse_id_list($op['exclude_post']);

        /** Hold the output to catch it */
        ob_start();
        ?>
<div class="wp-cpl-sc-wrap wp-cpl-sc-theme-<?php echo $op['css_theme']; ?>">
        <?php
        if(count($wp_cpl_sticky)) {
            $wp_cpl_post_sticky = $this->get_posts(array('post__in' => $wp_cpl_sticky));

            foreach($wp_cpl_post_sticky as $post) {
                ?>
    <div class="wp-cpl-sc-post wp-cpl-sc-sticky">
        <?php if('true' == $op['is_thumb'] && ('' != ($thumb = get_the_post_thumbnail($post->ID, 'wp-cpl-sc-thumb', array('class' => 'wp-cpl-sc-thumb', 'title' => __('Permalink to: ', $trans) . $post->post_title))))) : ?>
        <?php echo '<a  class="wp-cpl-sc-thumba" href="' . get_permalink($post->ID) . '">' . $thumb . '</a>'; ?>
        <?php endif; ?>
        <h2><a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo __('Permalink to: ', $trans) . $post->post_title; ?>"><?php echo get_the_title($post->ID); ?></a></h2>
        <?php if($op['show_date'] == 'true' || $op['show_author'] == 'true' || $op['show_comments'] == 'true') : ?>
        <div class="wp-cpl-sc-meta">
            <p>
                <?php if($op['show_date'] == 'true') : ?>
                <span class="wp-cpl-sc-date"><?php echo __('Posted on ', $trans) . date('M jS, Y', strtotime($post->post_date)) . ' '; ?></span>
                <?php endif; ?>
                <?php if($op['show_author'] == 'true') : ?>
                <span class="wp-cpl-sc-author"><?php echo __('By ', $trans) . '<a href="' . get_the_author_meta('user_url', $post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a> '; ?></span>
                <?php endif; ?>
                <?php if($op['show_comments'] == 'true') : ?>
                <span class="wp-cpl-sc-comment"><?php echo '<a href="' . get_comments_link($post->ID) . '">' . $post->comment_count . ' ' . __ngettext('Comment', 'Comments', $post->comment_count, $trans) . '</a>' ?></span>
                <?php endif; ?>
            </p>
        </div>
        <?php endif; ?>
        <?php if($op['show_excerpt'] == 'true') : ?>
        <div class="wp-cpl-sc-entry">
            <p>
                <?php echo (('true' == $op['optional_excerpt'] && $post->post_excerpt != '')? $post->post_excerpt : itgdb_wp_cpl_loader::shorten_string($post->post_content, $op['excerpt_length'])); ?>
            </p>
            <?php if('' != $op['read_more']) : ?>
            <p class="wp-cpl-sc-readmore">
                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $op['read_more']; ?></a>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
    <?php
            }
        }


        /**
         * Merge the sticky and exclude posts array
         * So no duplicate post is shown
         */
        $wp_cpl_exclude = array_merge($wp_cpl_sticky, $wp_cpl_exclude);
        $wp_cpl_exclude = array_unique($wp_cpl_exclude);


        /** Set the arguments of the get_posts function */
        $get_posts_args = array(
            'list_num' => $op['list_num'],
            'sort_using' => $op['sort_using'],
            'sort_order' => (($op['sort_order'] == 'asc')? true : false),
            'exclude' => $wp_cpl_exclude
        );

        /** Actually get the post */
        $wp_cpl_posts = $this->get_posts($get_posts_args, $cat_id);

        foreach($wp_cpl_posts as $post) {
            ?>
<div class="wp-cpl-sc-post">
    <?php if('true' == $op['is_thumb'] && ('' != ($thumb = get_the_post_thumbnail($post->ID, 'wp-cpl-sc-thumb', array('class' => 'wp-cpl-sc-thumb', 'title' => __('Permalink to: ', $trans) . $post->post_title))))) : ?>
    <?php echo '<a class="wp-cpl-sc-thumba" href="' . get_permalink($post->ID) . '">' . $thumb . '</a>'; ?>
    <?php endif; ?>
    <h2><a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo __('Permalink to: ', $trans) . $post->post_title; ?>"><?php echo get_the_title($post->ID); ?></a></h2>
    <?php if($op['show_date'] == 'true' || $op['show_author'] == 'true' || $op['show_comments'] == 'true') : ?>
    <div class="wp-cpl-sc-meta">
        <p>
            <?php if($op['show_date'] == 'true') : ?>
            <span class="wp-cpl-sc-date"><?php echo __('Posted on ', $trans) . date('M jS, Y', strtotime($post->post_date)) . ' '; ?></span>
            <?php endif; ?>
            <?php if($op['show_author'] == 'true') : ?>
            <span class="wp-cpl-sc-author"><?php echo __(' - By ', $trans) . '<a href="' . get_the_author_meta('user_url', $post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a> '; ?></span>
            <?php endif; ?>
            <?php if($op['show_comments'] == 'true') : ?>
            <span class="wp-cpl-sc-comment"><?php echo ' - <a href="' . get_comments_link($post->ID) . '">' . $post->comment_count . ' ' . __ngettext('Comment', 'Comments', $post->comment_count, $trans) . '</a>' ?></span>
            <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>
    <?php if($op['show_excerpt'] == 'true') : ?>
    <div class="wp-cpl-sc-entry">
        <p>
            <?php echo (('true' == $op['optional_excerpt'] && $post->post_excerpt != '')? $post->post_excerpt : itgdb_wp_cpl_loader::shorten_string($post->post_content, $op['excerpt_length'])); ?>
        </p>
        <?php if('' != $op['read_more']) : ?>
        <p class="wp-cpl-sc-readmore">
            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $op['read_more']; ?></a>
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php
        }
        ?>
</div>
<?php
        return ob_get_clean();
    }

    public function widget_output_gen($op, $cat_id, &$i) {

        $wp_cat_list_itg_tans = itgdb_wp_cpl_loader::$text_domain;
        $post_output = '';

        /**
         * Set the before post list HTML
         */
        $before_link = (true == $op['list_style'])? '<li class="%list_class%">' : $op['before_link'];
        $after_link = (true == $op['list_style'])? '</li>' : $op['after_link'];
        /** Calculate stick posts and excluded posts */
        $wp_cpl_sticky = wp_parse_id_list($op['sticky_post']);
        $wp_cpl_exclude = wp_parse_id_list($op['exclude_post']);

        /** First get the Sticky posts */
        if(count($wp_cpl_sticky)) {
            $wp_cpl_post_sticky = $this->get_posts(array('post__in' => $wp_cpl_sticky));

            /** Loop through the sticky posts */
            foreach($wp_cpl_post_sticky as $post) {
                /** Initiate the post list widget HTML */
                $default_class = 'wp-cpl-sticky';
                $post_output .= str_ireplace('%list_class%', "{$default_class}", $before_link);

                /** is thumbnail? */
                $post_output .= (((true == $op['is_thumb']) && ('' != ($wp_cpl_post_thumb = get_the_post_thumbnail($post->ID, 'wp-cpl-post-thumb'))))? '<span class="wp-thumb-overlay"><span class="' . $op['thumb_class'] . '"><a href="'. get_permalink($post->ID) . '">' . $wp_cpl_post_thumb . '</span></span>' : '');

                /** Add up the actual permalink and post title */
                $post_output .= '<a href="' . get_permalink($post->ID) . '" title="' . __('Permalink to: ', $wp_cat_list_itg_tans) . $post->post_title . '" target="' . ((false == $op['open_in'])? '_blank' : '_self') . '">' . $post->post_title . '</a>';

                /** Show comments? */
                $post_output .= ((true == $op['show_comments'])? ' <span class="wp-cpl-comment"><a href="' . get_comments_link($post->ID) . '">' . $post->comment_count . ' ' . __ngettext('Comment', 'Comments', $post->comment_count, $wp_cat_list_itg_tans) . '</a></span>' : '');

                /** Add date? */
                $post_output .= ((true == $op['show_date'])? ' <span class="wp-cpl-date">' . __('Posted on: ', $wp_cat_list_itg_tans) . date('M jS, Y', strtotime($post->post_date)) . '</span>' : '');

                /** Add author? */
                $post_output .= ((true == $op['show_author'])? ' <span class="wp-cpl-author">' . __('By ', $wp_cat_list_itg_tans) . '<a href="' . get_the_author_meta('user_url', $post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a></span>' : '');

                /** Add excerpt? */
                $post_output .= ((true == $op['show_excerpt'])? '<p class="wp-cpl-excerpt">' . ((true == $op['optional_excerpt'] && $post->post_excerpt != '')? $post->post_excerpt : itgdb_wp_cpl_loader::shorten_string($post->post_content, $op['excerpt_length'])) . '</p>' : '');

                /** Done. Now close the Widget */
                $post_output .= $after_link . "\n";
            }
        }



        /**
         * Merge the sticky and exclude posts array
         * So no duplicate post is shown
         */
        $wp_cpl_exclude = array_merge($wp_cpl_sticky, $wp_cpl_exclude);
        $wp_cpl_exclude = array_unique($wp_cpl_exclude);


        /** Set the arguments of the get_posts function */
        $get_posts_args = array(
            'list_num' => $op['list_num'],
            'sort_using' => $op['sort_using'],
            'sort_order' => $op['sort_order'],
            'exclude' => $wp_cpl_exclude
        );

        /** Actually get the post */
        $wp_cpl_posts = $this->get_posts($get_posts_args, $cat_id);

        /**
         * Free memory from unneeded variables
         * @since 1.1.0
         */
        unset($wp_cpl_sticky);
        unset($wp_cpl_exclude);
        unset($wp_cpl_post_sticky);
        unset($wp_cpl_sort_array);
        unset($get_posts_args);


        /** Loop through the posts */
        $i = 0;
        foreach($wp_cpl_posts as $post) {

                /** Initiate the post list widget HTML */
                $default_class = ((true == $op['alternate_list_css'])? (($i%2 == 0)? 'wp-cpl wp-cpl-even' : 'wp-cpl wp-cpl-odd') : 'wp-cpl');
                $post_output .= str_ireplace('%list_class%', "{$default_class}", $before_link);

                /** is thumbnail? */
                $post_output .= (((true == $op['is_thumb']) && ('' != ($wp_cpl_post_thumb = get_the_post_thumbnail($post->ID, 'wp-cpl-post-thumb'))))? '<span class="wp-thumb-overlay"><span class="' . $op['thumb_class'] . '"><a href="'. get_permalink($post->ID) . '">' . $wp_cpl_post_thumb . '</a></span></span>' : '');

                /** Add up the actual permalink and post title */
                $post_output .= '<a href="' . get_permalink($post->ID) . '" title="' . __('Permalink to: ', 'wp-cat-list-itg') . $post->post_title . '" target="' . ((false == $op['open_in'])? '_blank' : '_self') . '">' . $post->post_title . '</a>';

                /** Show comments? */
                $post_output .= ((true == $op['show_comments'])? ' <span class="wp-cpl-comment"><a href="' . get_comments_link($post->ID) . '">' . $post->comment_count . ' ' . __ngettext('Comment', 'Comments', $post->comment_count, 'wp-cat-list-itg') . '</a></span>' : '');

                /** Add date? */
                $post_output .= ((true == $op['show_date'])? ' <span class="wp-cpl-date">' . __('Posted on: ', $wp_cat_list_itg_tans) . date('M jS, Y', strtotime($post->post_date)) . '</span>' : '');

                /** Add author? */
                $post_output .= ((true == $op['show_author'])? ' <span class="wp-cpl-author">' . __('By ', $wp_cat_list_itg_tans) . '<a href="' . get_the_author_meta('user_url', $post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a></span>' : '');

                /** Add excerpt? */
                $post_output .= ((true == $op['show_excerpt'])? '<p class="wp-cpl-excerpt">' . ((true == $op['optional_excerpt'] && $post->post_excerpt != '')? $post->post_excerpt : itgdb_wp_cpl_loader::shorten_string($post->post_content, $op['excerpt_length']) ) . '</p>' : '');

                /** Done. Now close the Widget */
                $post_output .= $after_link . "\n";
                $i++;
        }
        return $post_output;
    }

}
