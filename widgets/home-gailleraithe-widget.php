<?php

/**
 * Recent Website Posts
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

class Kaitain_Gailleraithe_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_gailleraithe_widget', 'kaitain'),
            __('Tuairisc: Gailleraithe Widget', 'kaitain'),
            array(
                'description' => __('An list of recent Gailleraithe posts by date. Optionally show Featured Posts from Gailleraithe section.', 'kaitain'),
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
            'widget_title' => __('Gailleraithe Widget', 'kaitain'),
            'max_posts' => 10,
            'category' => 150,
            'display_featured' => true
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
            // This jQuery is easier for me to parse and debug than inline PHP.
            jQuery(function($) {
                // Set 'category' selected option.
                $('<?php printf('#%s', $this->get_field_id("category")); ?>').val('<?php printf($instance["category"]); ?>');
                // Set 'max_posts' selected option. 
                $('<?php printf('#%s', $this->get_field_id("max_posts")); ?>').val('<?php printf($instance["max_posts"]); ?>');
                $('<?php printf('#%s', $this->get_field_id('display_featured')); ?>').prop('checked', <?php printf(($instance['display_featured']) ? 'true' : 'false'); ?>);
            });
        </script>
        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Widget title:', 'kaitain'); ?></label>
                <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('category')); ?>"><?php _e('Category:', 'kaitain'); ?></label>
                <select id="<?php printf($this->get_field_id('category')); ?>" name="<?php printf($this->get_field_name('category')); ?>">
                    <option value="0"><?php _e('All', 'kaitain'); ?></option>

                    <?php foreach ($categories as $category) {
                        // Iterate through all caterories. 
                        printf('<option value="%d">%s (%d)</option>', $category->cat_ID, $category->cat_name, $category->category_count);
                    }  ?>
                </select>
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Number of posts to display:', 'kaitain'); ?></label>
                <select id="<?php printf($this->get_field_id('max_posts')); ?>" name="<?php printf($this->get_field_name('max_posts')); ?>">
                    <?php for ($i = 1; $i <= $defaults['max_posts']; $i++) {
                        printf('<option value="%d">%d</option>', $i, $i);
                    } ?>
                </select>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('display_featured')); ?>" type="checkbox" name="<?php printf($this->get_field_name('display_featured')); ?>" />
                <label for="<?php printf($this->get_field_id('display_featured')); ?>"><?php _e('Display Featured Posts', 'kaitain'); ?></label>
            </li>

        </ul>
        <?php
    }

    /**
     * Widget Update
     * -------------------------------------------------------------------------
     * @param  array    $new_args       New options variables.
     * @param  array    $old_args       Old options variables.
     * @return array    $options           New widget settings.
     */

    function update($new_args, $old_args) {
        $options = array();
        $options['widget_title'] = strip_tags($new_args['widget_title']);
        $options['max_posts'] = $new_args['max_posts'];
        $options['category'] = $new_args['category'];
        $options['display_featured'] = ($new_args['display_featured'] == 'on'); // returns true or false
        return $options;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        global $post;
        $trans_name = 'gailleraithe_posts_widget';

        $key = get_option('kaitain_view_counter_key');
        $title = apply_filters('widget_title', $instance['widget_title']);
	
		// In progress
		// Find all posts in category with 'featured' custom field option.
		//		make generic or stick to hard coded category? (Generic is best)
		if ( $instance['display_featured'] ) {
			$featured = get_posts(array(
                // 'post_type' => 'post',
                // 'numberposts' => $instance['max_posts'],
                // 'order' => 'DESC',
                // 'category' => ($instance['category']) ? $instance['category'] : ''
            ));
		}

		// Default get recent posts from category
        if (!($recent = get_transient($trans_name))) {
            
            $recent = get_posts(array(
                'post_type' => 'post',
                'numberposts' => $instance['max_posts'],
                'order' => 'DESC',
                'category' => ($instance['category']) ? $instance['category'] : ''
            ));

            set_transient($trans_name, $recent, get_option('kaitain_transient_timeout')); 
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . $title . $defaults['after_title']);
        }

        printf('<div class="gailleraithe-widget tuairisc-post-widget">');

        foreach ($recent as $post) {
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

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Gailleraithe_Widget");'));

?>
