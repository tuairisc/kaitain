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

        $instance = wp_parse_args($instance, $defaults);
        
        ?>

        <ul>
            <li>
                <input id="<?php printf($this->get_field_id('sticky')); ?>" type="checkbox" name="<?php printf($this->get_field_name('sticky')); ?>" />
                <label for="<?php printf($this->get_field_id('sticky')); ?>"><?php _e('Show Sticky Post', TTD); ?></label>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('count')); ?>"><?php _e('Number of posts to display: ', TTD); ?></label>
                <select id="<?php printf($this->get_field_id('count')); ?>" name="<?php printf($this->get_field_name('count')); ?>">
                    <?php for ($i = 0; $i < 16; $i += 4) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
        </ul>
        <script>
            jQuery('#<?php printf($this->get_field_id('count')); ?>').val(<?php printf($instance['count']); ?>);
            jQuery('#<?php printf($this->get_field_id('sticky')); ?>').prop('checked', <?php printf($instance['sticky'] ? 'true' : 'false'); ?>);
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
        $defaults['sticky'] = ($new_args['sticky'] === 'on');
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

        $featured = array();

        // Show other featured posts if they were elected ot be shown.
        $featured = get_featured($instance['count'], $instance['sticky'], true);

        if ($instance['sticky']) {
            /* If sticky was checked, see if it is available to use. Otherwise
             * grab the last featured post. */
            $featured = array_unshift($featured, get_sticky(true));
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }

        printf('<div class="recent-widget tuairisc-post-widget">');

        foreach ($featured as $index => $post) {
            setup_postdata($post);

            if ($instance['sticky'] && $index === 0) {
                // 1. Show lead post.
                get_template_part(PARTIAL_ARTICLES, 'archivelead');
                printf('<hr>');
            }

            if ($instance['count'] > 0 && $index % 4 === 1 && $index !== 0) {
                // 1, 5, 9
                printf('<div class="featured-row home-flex-row">');
            }

            if (!$instance['sticky'] || $index > 0) {
                // 2. Show row posts.
                get_template_part(PARTIAL_ARTICLES, 'archivesmall');
            }

            if ($instance['count'] > 0 && $index % 4 === 0 && $index !== 0) {
                // 4, 8, 12
                printf('</div>');
            }
        }

        printf('</div>');

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
