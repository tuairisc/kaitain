<?php

/**
 * Sidebar Featured Category
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

class Kaitain_Sidebar_Category_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_sidebar_category', 'kaitain'),
            __('Tuairisc: Featured Sidebar Category', 'kaitain'),
            array(
                'description' => __('A featured sidebar category list with optional lead image display.', 'kaitain'),
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
                <label for="<?php printf($this->get_field_id('category')); ?>"><?php _e('Category:', 'kaitain'); ?></label>
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
                <label for="<?php printf($this->get_field_id('max_posts')); ?>"><?php _e('Number of posts to display:', 'kaitain'); ?></label>
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
                <label for="<?php printf($this->get_field_id('show_image')); ?>"><?php _e('Show large thumbnail for the lead post.', 'kaitain'); ?></label>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('use_section_trim')); ?>" name="<?php printf($this->get_field_name('use_section_trim')); ?>" type="checkbox"  />
                <label for="<?php printf($this->get_field_id('use_section_trim')); ?>"><?php _e('Use section trim colour instead of a grey background.', 'kaitain'); ?></label>
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

        $defaults['show_image'] = (array_key_exists('show_image', $new_defaults) 
            && $new_defaults['show_image'] === 'on');

        $defaults['use_section_trim'] = (array_key_exists('use_section_trim', $new_defaults) 
            && $new_defaults['use_section_trim'] === 'on');

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

        // Site section information.
        $section = kaitain_current_section_category();
        $trim = kaitain_section_css(get_the_category()[0]);
        $section_slug = $sections->get_category_section_slug(get_the_category()[0]);

        $classes = array(
            'widget' => 'widget--sidebarcat vspace--full',
            'trim_bg' => 'widget--sidebarcat__bg',
            'trim_text' => $trim['texthover']
        );

        if ($instance['use_section_trim']) {
            // Override grey background with appropriate section trim.
            $classes['trim_bg'] = $trim['bg'];
        }

        if (!($category_posts = get_transient($trans))) {
            // Transient: fetch posts.
            $category_posts = get_posts(array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => $instance['max_posts'],
                'category' => $instance['category'],
                'order' => 'DESC',
            ));

            set_transient($trans, $category_posts, get_option('kaitain_transient_timeout')); 
        }

        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
        }

        // Widget interior.
        printf('<div class="%s %s">', $classes['widget'], $classes['trim_bg']);

        printf('%s<a class="%s" href="%s">%s</a>%s',
            $defaults['before_title'],
            $classes['trim_text'],
            get_category_link($category),
            $title,
            $defaults['after_title']
        );

        foreach ($category_posts as $index => $post) {
            setup_postdata($post);

            if ($instance['show_image'] && $index === 0) {
                kaitain_partial('article', 'sidebarcatlead');
            } else {
                kaitain_partial('article', 'sidebarcat');
            }
        }
                
        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Sidebar_Category_Widget");'));

?>
