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
    public function __construct() {
        parent::__construct(
            __('tuairisc_popular', TTD),
            __('Tuairisc\'s Popular Posts', TTD),
            array(
                'description' => __('An ordered list of popular Tuairisc posts sorted by view count.', TTD),
            )
        );
    }

    public function widget($args, $instance) {
        global $ghetto_counter_key;
        extract($args);

        $title = apply_filters('widget_title', $instance['widget_title']);
        $start_date = new DateTime();
        $start_date = $start_date->sub(new DateInterval('P' . $instance['elapsed_days'] . 'D'));

        $popular_query = new WP_Query(array(
            // Exclude the Greann category.
            'cat' => -184,
            'post_type' => 'post',
            'meta_key' => $ghetto_counter_key, 
            'posts_per_page' => $instance['max_posts'],
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'date_query' => array(
                 /* Search inclusively through the date range. */
                'after' => array(
                    'year' => $start_date->format('Y'),
                    'month' => $start_date->format('m'),
                    'day' => $start_date->format('d'),
                ),
                'before' => array(
                    'year' => date('Y'),
                    'month' => date('m'),
                    'day' => date('d')                        
                ),
                'inclusive' => true
            )
        ));

        if (!empty($args['before_widget'])) {
            // Widget container open and title.
            printf($before_widget);
            printf($before_title . apply_filters('widget_title', $instance['widget_title']) . $after_title);
        }

        printf('<ul class="tuairisc-popular-list">');

        if ($popular_query->have_posts()) {
            while ($popular_query->have_posts()) {
                $popular_query->the_post();

                ?>
                <li>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <img src="<?php printf(get_thumbnail_url(get_the_id(), array(75, 50))); ?>" alt="" />
                        </a>
                        <div class="feature-post-text">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            <br />
                            <small><?php the_date(); ?></small>
                        </div>
                    <?php endif; ?>
                </li>
                <?php
            }
        } else {
            _e('Níor fágadh aon nóta tráchta fós', TTD);
        }

        printf('</ul>');
        printf($after_widget);
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['widget_title'] = strip_tags($new_instance['widget_title']);
        $instance['max_posts'] = $new_instance['max_posts'];
        $instance['elapsed_days'] = $new_instance['elapsed_days'];
        return $instance;
    }

    public function form($instance) {
        $instance = wp_parse_args($instance, $defaults);

        $defaults = array(
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
            <label for="<?php printf($this->get_field_id('elapsed_days')); ?>"><?php _e('Since:', TTD)); ?></label><br />
            <select id="<?php printf($this->get_field_id('elapsed_days')); ?>" name="<?php printf($this->get_field_name('elapsed_days')); ?>">
                <option value="36500">All Time</option>
                <option value="365">This Year</option>
                <option value="28">This Month</option>
                <option value="14">Two Weeks</option>
                <option value="7">Seven Days</option>
                <option value="6">Six Days</option>
                <option value="5">Five Days</option>
                <option value="4">Four Days</option>
                <option value="3">Three Days</option>
                <option value="2">Two Days</option>
                <option value="1">Today</option>
            </select>
        </p>
        <p>
            <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Posts To Display:', TTD)); ?></label><br />
            <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </p>
        <?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_popular");'));
?>
