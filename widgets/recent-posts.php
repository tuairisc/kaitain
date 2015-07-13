<?php

/**
 * Recent Website Posts
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

class tuairisc_recent extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_recent', TTD),
            __('Tuairisc: Recent Posts', TTD),
            array(
                'description' => __('An ordered list of recent Tuairisc posts sorted by date. Choose from either one category, or all categories.', TTD),
            )
        );
    }

    /**
     * Widget Administrative Form
     * -------------------------------------------------------------------------
     * @param array     $instance       Widget instance.
     */

    public function form($instance) {
        $defaults = array(
            // Widget defaults.
            'widget_title' => __('Recent Posts', TTD),
            'max_posts' => 10,
            'category' => 0
        ); 

        $instance = wp_parse_args($instance, $defaults);
        
        $categories = get_categories(array(
            'type' => 'post',
            'orderby' => 'name',
            'order' => 'ASC',
            'pad_counts' => 'false'
        ));
        
        ?>

        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery(function($) {
                // Set 'category' selected option.
                $('<?php printf('#%s', $this->get_field_id("category")); ?>').val('<?php printf($instance["category"]); ?>');
                // Set 'max_posts' selected option. 
                $('<?php printf('#%s', $this->get_field_id("max_posts")); ?>').val('<?php printf($instance["max_posts"]); ?>');
            });
        </script>
        
        <p>
            <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Widget title:', TTD); ?></label><br />
            <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
        </p>

        <p>
            <label for="<?php printf($this->get_field_id('category')); ?>"><?php _e('Category:', TTD); ?></label><br />
            <select id="<?php printf($this->get_field_id('category')); ?>" name="<?php printf($this->get_field_name('category')); ?>">
                <option value="0"><?php _e('All', TTD); ?></option>

                <?php foreach ($categories as $category) {
                    // Iterate through all caterories. 
                    printf('<option value="%d">%s (%d)</option>', $category->cat_ID, $category->cat_name, $category->category_count);
                }  ?>
            </select>
        </p>
        <p>
            <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Number of posts to display:', TTD); ?></label><br />
            <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                <?php for ($i = 1; $i <= $defaults['max_posts']; $i++) {
                    printf('<option value="%d">%d</option>', $i, $i);
                } ?>
            </select>
        </p>

        <?php
    }

    /**
     * Widget Update
     * -------------------------------------------------------------------------
     * @param  array    $new_args       New args variables.
     * @param  array    $old_args       Old args variables.
     * @return array    $args           New args settings.
     */

    function update($new_args, $old_args) {
        $args = array();
        $args['widget_title'] = strip_tags($new_args['widget_title']);
        $args['max_posts'] = $new_args['max_posts'];
        $args['category'] = $new_args['category'];
        return $args;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        $key = get_option('tuairisc_view_counter_key');
        $title = apply_filters('widget_title', $instance['widget_title']);
        
        $recent_posts = array(
            'post_type' => 'post',
            'numberposts' => $instance['max_posts'],
            'order' => 'DESC',
        );

        if ($instance['category']) {
            $recent_posts['category'] = $instance['category'];
        }

        $recent_posts = get_posts($recent_posts);

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . apply_filters('widget_title', $instance['widget_title']) . $defaults['after_title']);
        }

        printf('<div class="recent-widget tuairisc-post-widget">');

        foreach ($recent_posts as $recent) {
            printf('<hr>');
            printf('<ul>');
            printf('<li>%s</li>', $recent->post_title);
            printf('<li>%s</li>', get_post_image($recent->ID));
            printf('<li>%s</li>', get_the_date_strftime(get_option('tuairisc_strftime_date_format'), $recent->ID));
            printf('</ul>');
        }

        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_recent");'));

?>
