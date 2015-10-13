<?php

/**
 * Featured Posts Widget
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

class Kaitain_Featured_Post_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_featured', 'kaitain'),
            __('Tuairisc: Featured and Sticky Posts', 'kaitain'),
            array(
                'description' => __('The frontpiece of the home page: An ordered list of featured and sticky posts.', 'kaitain'),
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
            'show_sticky' => true
        ); 

        $featured_rows_limit = 16;
        $instance = wp_parse_args($instance, $defaults);
        
        ?>

        <ul>
            <li>
                <input id="<?php printf($this->get_field_id('show_sticky')); ?>" type="checkbox" name="<?php printf($this->get_field_name('show_sticky')); ?>" />
                <label for="<?php printf($this->get_field_id('show_sticky')); ?>"><?php _e('Show Sticky Post', 'kaitain'); ?></label>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('count')); ?>"><?php _e('Number of posts to display: ', 'kaitain'); ?></label>
                <select id="<?php printf($this->get_field_id('count')); ?>" name="<?php printf($this->get_field_name('count')); ?>">
                    <?php for ($i = 0; $i < $featured_rows_limit; $i += 4) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
        </ul>
        <?php
            $count = $instance['count'];    
            $show_sticky = $instance['show_sticky'] ? 'true' : 'false';
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
     * @param  array    $new_instance      New instance variables.
     * @param  array    $old_instance      Old instance variables.
     * @return array    $instance          New widget settings.
     */

    public function update($new_instance, $old_instance) {
        $instance = array();

        $instance['show_sticky'] = (
            isset($new_instance['show_sticky']) 
            && $new_instance['show_sticky'] === 'on'
        );

        $instance['count'] = $new_instance['count'];
        return $instance;
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

        $classes = array(
            'widget' => 'widget widget--featured',
            'post_row' => 'flex--four-col--article vspace--half widget--featured__row'
        );
        
        // Array of featured and sticky posts.
        $featured = array();

        if ($instance['show_sticky']) {
            /* If sticky was checked, see if it is available to use. Otherwise
             * grab the last featured post. */

            if (kaitain_has_sticky_been_set()) {
                $featured[] = kaitain_get_sticky_post();
            } else {
                /* If no stick is set, but was asked to display, increment
                 * count to fill. */
                $instance['count']++;
            }
        }

        // Show other featured posts if they were elected ot be shown.
        $featured = array_merge($featured, kaitain_get_featured($instance['count'], true));

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }

        printf('<div class="%s">', $classes['widget']);

        // Number modifier for when sticky posts are selected.
        $mod = $instance['show_sticky'] ? 0 : 1;

        foreach ($featured as $number => $post) {
            if (!empty($post)) {
                setup_postdata($post);

                if ($instance['show_sticky'] && $number === 0) {
                   kaitain_partial('article', 'lead');
                }

                if (($number + $mod) % 4 === 1) {
                    printf('<div class="%s">', $classes['post_row']);
                }

                if (!$instance['show_sticky'] || $number > 0) {
                    kaitain_partial('article', 'small');
                }

                if ($number > 0 && ($number + $mod) % 4 === 0) {
                    printf('</div>');
                }
            }
        }

        printf('</div>');

        if ($instance['count'] > 1) {
            printf('<hr>');
        }

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Featured_Post_Widget");'));

?>
