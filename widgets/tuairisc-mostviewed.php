<?php

/**
 * Popular Posts by View Counter
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

class tuairisc_popular extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_popular', TTD),
            __('Tuairisc\'s Popular Posts', TTD),
            array(
                'description' => __('An ordered list of popular Tuairisc posts sorted by view count.', TTD),
            )
        );
    }

    /**
     * Widget Administrative Form
     * -------------------------------------------------------------------------
     * @param array     $instance       Widget instance.
     */

    public function form($instance) {
        $instance = wp_parse_args($instance, $defaults);

        $options = array(
            // Post duration options.
            '36500' => 'All Time',
            '365' => 'This Year',
            '28' => 'This Month',
            '14' => 'Two Weeks',
            '7' => 'Seven Days',
            '6' => 'Six Days',
            '5' => 'Five Days',
            '4' => 'Four Days',
            '3' => 'Three Days',
            '2' => 'Two Days',
            '1' => 'Today',
        );

        $defaults = array(
            // Widget defaults.
            'widget_title' => __('Most Viewed', TTD),
            'max_posts' => 10,
            'elapsed_days' => '7'
        ); ?>

        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery(function($) {
                // Set 'elapsed_days' selected option.
                $('<?php printf('#%s', $this->get_field_id("elapsed_days")); ?>').val('<?php printf($instance["elapsed_days"]); ?>');
                // Set 'max_posts' selected option. 
                $('<?php printf('#%s', $this->get_field_id("max_posts")); ?>').val('<?php printf($instance["max_posts"]); ?>');
            });
        </script>
        
        <p>
            <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Title:', TTD); ?></label><br />
            <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
        </p>
        <p>
            <label for="<?php printf($this->get_field_id('elapsed_days')); ?>"><?php _e('Since:', TTD); ?></label><br />
            <select id="<?php printf($this->get_field_id('elapsed_days')); ?>" name="<?php printf($this->get_field_name('elapsed_days')); ?>">
                <?php foreach ($options as $key => $value) {
                    printf('<option value="%s">%s</option>', $key, $value);
                }  ?>
            </select>
        </p>
        <p>
            <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Posts To Display:', TTD); ?></label><br />
            <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value="<?php printf($i); ?>"><?php printf($i); ?></option>
                <?php endfor; ?>
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
        $args['elapsed_days'] = $new_args['elapsed_days'];
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
        $start_date = new DateTime();
        $start_date = $start_date->sub(new DateInterval('P' . $instance['elapsed_days'] . 'D'));

        $popular_posts = get_posts(array(
            'post_type' => 'post',
            'meta_key' => $key, 
            'orderby' => 'meta_value_num',
            'posts_per_page' => $instance['max_posts'],
            'order' => 'ASC',
            'date_query' => array(
                'after' => $start_date->format('Y-m-d'),
                'before' => date('Y-m-d'),
                'inclusive' => true
            )
        ));

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . apply_filters('widget_title', $instance['widget_title']) . $defaults['after_title']);
        }

        printf('<div class="popular-widget">');

        foreach ($popular_posts as $popular) {
            printf('<ul>');
            printf('<li>%s</li>', $popular->post_title);
            printf('<li>%s</li>', get_post_image($popular->ID));
            printf('<li>%s</li>', get_the_date_strftime(get_option('tuairisc_strftime_date_format'), $popular->ID));
            printf('<li>%s</li>', get_post_meta($popular->ID, $key, true));
            printf('</ul>');
        }

        printf('</div>');
        printf($defaults['after_widget']);
        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_popular");'));

?>
