<?php

/**
 * Featured Posts Widget
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
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
            'count' => 4,
            'sticky' => true
        ); 

        $featured_rows_limit = 16;
        $instance = wp_parse_args($instance, $defaults);
        
        ?>

        <ul>
            <li>
                <input id="<?php printf($this->get_field_id('show_sticky')); ?>" type="checkbox" name="<?php printf($this->get_field_name('show_sticky')); ?>" />
                <label for="<?php printf($this->get_field_id('show_sticky')); ?>"><?php _e('Show Sticky Post', TTD); ?></label>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('count')); ?>"><?php _e('Number of posts to display: ', TTD); ?></label>
                <select id="<?php printf($this->get_field_id('count')); ?>" name="<?php printf($this->get_field_name('count')); ?>">
                    <?php for ($i = 0; $i < $featured_rows_limit; $i += 4) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
        </ul>
        <?php
            $count = $instance['count'];    

            $show_sticky = 
                isset($instance['show_sticky']) && $instance['show_sticky']
                ? 'true' : 'false';
        ?>
        <script>
            jQuery('#<?php printf($this->get_field_id('count')); ?>').val(<?php printf($count); ?>);
            jQuery('#<?php printf($this->get_field_id('show_sticky')); ?>').prop('checked', <?php printf($show_sticky); ?>);
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

        $defaults['show_sticky'] = (
            isset($new_args['show_sticky']) 
            && $new_args['show_sticky'] === 'on'
        );

        $defaults['count'] = $new_args['count'];
        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        // $post object is needed in order to correctly run setup_postdata().
        global $post;
        
        // Array of featured and sticky posts.
        $featured = array();

        if ($instance['show_sticky']) {
            /* If sticky was checked, see if it is available to use. Otherwise
             * grab the last featured post. */

            if (has_sticky_been_set()) {
                $featured[] = get_sticky_post();
            } else {
                /* If no stick is set, but was asked to display, increment
                 * count to fill. */
                $instance['count']++;
            }
        }

        // Show other featured posts if they were elected ot be shown.
        $featured = array_merge($featured, get_featured($instance['count'], true));

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }

        printf('<div class="recent-widget tuairisc-post-widget">');

        $last_post = end($featured);

        foreach ($featured as $num => $post) {
            if (!empty($post)) {
                setup_postdata($post);

                if ($instance['show_sticky'] && $num === 0) {
                    // 1. Show lead post.
                    get_template_part(PARTIAL_ARTICLES, 'archivelead');
                }

                if ($instance['count'] > 0 && $num % 4 === 1 && $num !== 0) {
                    // 1, 5, 9
                    printf('<div class="featured-row home-flex-row">');
                }

                if (!$instance['show_sticky'] || $num > 0) {
                    // 2. Show row posts.
                    get_template_part(PARTIAL_ARTICLES, 'archivesmall');
                }

                if ($instance['count'] > 0 && $num % 4 === 0 && $num !== 0 
                || $post === $last_post) {
                    // 4, 8, 12, or last item.
                    printf('</div>');
                }
            }
        }

        printf('</div>');
        printf('<hr>');

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action(
    'widgets_init',
    create_function('', 'return register_widget("tuairisc_featured");')
);

?>
