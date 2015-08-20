<?php

/**
 * Sidebar Featured Category
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
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
            'use_section_trim' => false,
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
            <li>
                <input id="<?php printf($this->get_field_id('use_section_trim')); ?>" name="<?php printf($this->get_field_name('use_section_trim')); ?>" type="checkbox"  />
                <label for="<?php printf($this->get_field_id('use_section_trim')); ?>"><?php _e('Use section trim colour instead of a grey background.', TTD); ?></label>
            </li>
        </ul>
        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery('#<?php printf($this->get_field_id('category')); ?>').val('<?php printf($instance['category']); ?>');
            jQuery('#<?php printf($this->get_field_id('max_posts')); ?>').val('<?php printf($instance['max_posts']); ?>');
            jQuery('#<?php printf($this->get_field_id('show_image')); ?>').prop('checked', <?php printf($instance['show_image'] ? 'true' : 'false'); ?>);
            jQuery('#<?php printf($this->get_field_id('use_section_trim')); ?>').prop('checked', <?php printf($instance['use_section_trim'] ? 'true' : 'false'); ?>);
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
        $defaults['use_section_trim'] = ($new_defaults['use_section_trim'] === 'on');
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
        global $sections, $post;

        if (!($category = get_category($instance['category']))) {
            return;
        }
        
        // Widget title.
        $title = apply_filters('widget_title', $category->cat_name);
        // Transient API name.
        $trans = 'sidebar_category_posts_' . $category->slug;
        // Default classname to set colour.
        $trim = 'grey'; 
        
        if (!($category_posts = get_transient($trans))) {
            $category_posts = get_posts(array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => $instance['max_posts'],
                'category' => $instance['category'],
                'order' => 'DESC',
            ));

            set_transient($trans, $category_posts, get_option('tuairisc_transient_timeout')); 
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }

        if ($instance['use_section_trim']) {
            $section_slug = $sections->get_section_slug(get_the_category()[0]);
            $trim = sprintf('section-%s-background', $section_slug);
        }

        printf('<div class="sidebar-category-widget-interior %s">', $trim);
        printf($defaults['before_title'] . $title . $defaults['after_title']);

        foreach ($category_posts as $index => $post) {
            setup_postdata($post);

            ?>

            <h5 class="title">
                <a class="green-link-hover" href="<?php the_permalink(); ?>">
                    <?php
                    if ($instance['show_image'] && $index === 0) {
                        the_post_thumbnail('tc_sidebar_category');
                        printf('<br />');
                    }

                    the_title();
                    ?>
                </a>
            </h5>

            <?php
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
