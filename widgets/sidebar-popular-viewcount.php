<?php

/**
 * Popular Posts by View Counter
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

class Kaitain_Popular_Posts_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_popular', 'kaitain'),
            __('Tuairisc: Popular Posts', 'kaitain'),
            array(
                'description' => __('An ordered list of popular Tuairisc posts sorted by view count.', 'kaitain'),
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
            'widget_title' => __('Most Viewed', 'kaitain'),
            'max_posts' => 10,
            'elapsed_days' => '7'
        );

        $instance = wp_parse_args($instance, $defaults);

        $options = array(
            // Post duration options. Range (days) and label.
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

        ?>

        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery(function($) {
                // Set 'elapsed_days' selected option.
                $('<?php printf('#%s', $this->get_field_id("elapsed_days")); ?>').val('<?php printf($instance["elapsed_days"]); ?>');
                // Set 'max_posts' selected option. 
                $('<?php printf('#%s', $this->get_field_id("max_posts")); ?>').val('<?php printf($instance["max_posts"]); ?>');
            });
        </script>
        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Widget title:', 'kaitain'); ?></label>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('elapsed_days')); ?>"><?php _e('Show most viewed posts for:', 'kaitain'); ?></label>
            </li>
            <li>
                <select id="<?php printf($this->get_field_id('elapsed_days')); ?>" name="<?php printf($this->get_field_name('elapsed_days')); ?>">
                    <?php foreach ($options as $key => $value) {
                        printf('<option value="%d">%s</option>', $key, $value);
                    }  ?>
                </select>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Number of posts to display:', 'kaitain'); ?></label>
            </li>
            <li>
                <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                    <?php for ($i = 1; $i <= $defaults['max_posts']; $i++) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
        </ul>
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
        $defaults['widget_title'] = strip_tags($new_args['widget_title']);
        $defaults['max_posts'] = $new_args['max_posts'];
        $defaults['elapsed_days'] = $new_args['elapsed_days'];
        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        global $post;

        $key = get_option('kaitain_view_counter_key');
        $title = apply_filters('widget_title', $instance['widget_title']);
        $start_date = new DateTime();
        $start_date = $start_date->sub(new DateInterval('P' . $instance['elapsed_days'] . 'D'));

        if (!($popular = get_transient('sidebar_popular_posts'))) {
            $popular = get_posts(array(
                'post_type' => 'post',
                'meta_key' => $key, 
                'orderby' => 'meta_value_num',
                'numberposts' => $instance['max_posts'],
                'order' => 'DESC',
                'date_query' => array(
                    'after' => $start_date->format('Y-m-d'),
                    'before' => date('Y-m-d'),
                    'inclusive' => true
                )
            ));

            set_transient('sidebar_popular_posts', $popular, get_option('kaitain_transient_timeout')); 
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . $title . $defaults['after_title']);
        }

        printf('<div class="popular-widget tuairisc-post-widget">');

        foreach ($popular as $index => $post) {
            setup_postdata($post);
           kaitain_partial('article', 'sidebar');
        }

        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Kaitain_Popular_Posts_Widget");'));

?>
