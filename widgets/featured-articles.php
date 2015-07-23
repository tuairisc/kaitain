<?php

/**
 * Featured Posts Widget
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

class tuairisc_featured extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_featured', TTD),
            __('Tuairisc: Featured and Sticky Posts', TTD),
            array(
                'description' => __('The frontpiece of the home page: An ordered list of featured and sticky posts.', TTD),
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
            'number_posts' => 4,
            'show_sticky' => true
        ); 

        $instance = wp_parse_args($instance, $defaults);
        
        ?>

        <ul>
            <li>
                <input id="<?php printf($this->get_field_id('show_sticky')); ?>" type="checkbox" name="<?php printf($this->get_field_name('show_sticky')); ?>" />
                <label for="<?php printf($this->get_field_id('show_sticky')); ?>"><?php _e('Show Sticky Post', TTD); ?></label>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('number_posts')); ?>"><?php _e('Number of posts to display: ', TTD); ?></label>
                <select id="<?php printf($this->get_field_id('number_posts')); ?>" name="<?php printf($this->get_field_name('number_posts')); ?>">
                    <?php for ($i = 0; $i < 16; $i += 4) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    }  ?>
                </select>
            </li>
        </ul>
        <script>
            jQuery('#<?php printf($this->get_field_id('number_posts')); ?>').val(<?php printf($instance['number_posts']); ?>);
            jQuery('#<?php printf($this->get_field_id('show_sticky')); ?>').prop('checked', <?php printf($instance['show_sticky'] ? 'true' : 'false'); ?>);
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

    function update($new_args, $old_args) {
        $defaults = array();
        $defaults['show_sticky'] = ($new_args['show_sticky'] === 'on');
        $defaults['number_posts'] = $new_args['number_posts'];
        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        $featured_key = get_option('tuairisc_featured_post_key');
        $sticky_id = -1;
        $featured_posts = array();

        if ($instance['show_sticky']) {
            /* If sticky was checked, see if it is available to use. If so, use it.
             * Otherwise grab the last featured post. */
            if (tuairisc_sticky_expired()) {
                reset_tuairisc_sticky();

                $featured_posts[] = get_posts(array(
                    'numberposts' => 1,
                    'meta_key' => $featured_key,
                    'post_status' => 'publish',
                    'meta_value' => 'on',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
            } else {
                $featured_posts[] = get_post(get_option('tuairisc_sticky_post')['id']);
            }

            $sticky_id = $featured_posts[0]->ID;
        }

        if ((int) $instance['number_posts'] > 0) {
            // Grab top n featured posts if n > 0
            $other_featured_posts = get_posts(array(
                'numberposts' => $instance['number_posts'],
                'meta_key' => $featured_key,
                'post_status' => 'publish',
                'meta_value' => true,
                'orderby' => 'date',
                'order' => 'DESC',
                'exclude' => array($sticky_id)
            ));

            $featured_posts = array_merge($featured_posts, $other_featured_posts);
        }

        if ($instance['show_sticky'] && sizeof($featured_posts) < $instance['number_posts'] + 1 || sizeof($featured_posts) < $instance['number_posts']) {
            // Fetch recent posts as filler if there is a shortfall.
            $filler_posts = get_posts(array(
                'numberposts' => $instance['number_posts'] - sizeof($featured_posts),
                'order' => 'DESC',
                'orderby' => 'date',
                'meta_key' => $featured_key,
                'meta_compare' => '!=',
                'meta_value' => true,
                'post_status' => 'publish',
            ));

            $featured_posts = array_merge($featured_posts, $filler_posts);
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }
        ?>

        <div class="recent-widget tuairisc-post-widget">
            <?php foreach ($featured_posts as $index => $post) {
                if ($instance['show_sticky'] && $index === 0) {
                    get_template_part(PARTIAL_ARTICLES, 'archivelead');
                } else {
                    get_template_part(PARTIAL_ARTICLES, 'archive');
                }
            } ?>
        </div>

        <?php

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_featured");'));

?>
