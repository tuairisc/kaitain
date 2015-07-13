<?php

/**
 * Sidebar Featured Category
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

class tuairisc_sidebar_category extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_sidebar_category', TTD),
            __('Tuairisc: Featured Sidebar Category', TTD),
            array(
                'description' => __('A featured sidebar category list with optional lead image display.', TTD),
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
            'widget_title' => __('Featued Category', TTD),
            'max_posts' => 10,
            'show_image' => false,
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

        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Widget title:', TTD); ?></label>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('category')); ?>"><?php _e('Category:', TTD); ?></label>
            </li>
            <li>
                <select id="<?php printf($this->get_field_id('category')); ?>" name="<?php printf($this->get_field_name('category')); ?>">
                    <?php foreach ($categories as $category) {
                        // Iterate through all caterories. 
                        printf('<option value="%d">%s (%d)</option>', $category->cat_ID, $category->cat_name, $category->category_count);
                    }  ?>
                </select>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Number of posts to display:', TTD); ?></label>
            </li>
            <li>
                <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                    <?php for ($i = 1; $i <= $defaults['max_posts']; $i++) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('show_image')); ?>" name="<?php printf($this->get_field_name('show_image')); ?>" type="checkbox"  />
                <label for="<?php printf($this->get_field_id('show_image')); ?>"><?php _e('Show thumbnail image for lead post', TTD); ?></label>
            </li>
        </ul>
        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery('#<?php printf($this->get_field_id('category')); ?>').val('<?php printf($instance['category']); ?>');
            jQuery('#<?php printf($this->get_field_id('max_posts')); ?>').val('<?php printf($instance['max_posts']); ?>');
            jQuery('#<?php printf($this->get_field_id('show_image')); ?>').prop('checked', <?php printf($instance['show_image'] ? 'true' : 'false'); ?>);
        </script>

        <?php
    }

    /**
     * Widget Update
     * -------------------------------------------------------------------------
     * @param  array    $new_default       New default variables.
     * @param  array    $old_default       Old default variables.
     * @return array    $default           New widget settings.
     */

    function update($new_defaults, $old_defaults) {
        $defaults = array();
        $defaults['widget_title'] = filter_var($new_defaults['widget_title'], FILTER_SANITIZE_STRIPPED);
        $defaults['show_image'] = ($new_defaults['show_image'] === 'on');
        $defaults['max_posts'] = $new_defaults['max_posts'];
        $defaults['category'] = $new_defaults['category'];
        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param   array     $defaults         Widget default values. 
     * @param   array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        $key = get_option('tuairisc_view_counter_key');
        $title = apply_filters('widget_title', $instance['widget_title']);
        
        $category_posts = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => $instance['max_posts'],
            'category' => $instance['category'],
            'order' => 'DESC',
        ));

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . apply_filters('widget_title', $instance['widget_title']) . $defaults['after_title']);
        }

        printf('<div class="recent-widget tuairisc-post-widget"></ul>');

        foreach ($category_posts as $index => $post) {
            printf('<li>%s', $post->post_title); 

            if ($instance['show_image'] && $index === 0) {
                printf('<br />%s<br />', get_post_image($post)); 
            } 
            printf('</li>');
        }
                
        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_sidebar_category");'));

?>
