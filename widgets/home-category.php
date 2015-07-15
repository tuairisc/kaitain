<?php 

/**
 * Home Index Featured Categories
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

/**
 * Category Widget Output
 * -----------------------------------------------------------------------------
 * Output the one-left-three right output of the category widget. This is in a 
 * separate function as it also used in archives.
 * 
 * @param   int/array/string        $cats           Categor{y,ies}.
 * @param   int                     $numberposts    Number of posts to output.
 */

function category_widget_output($cats, $show_title = true, $numberposts = 4)  {
    $categories = array();
    $current_post = 0;

    if (is_int($cats) || is_string($cats)) {
        $categories[] = intval($cats);
    } else if (is_array($cats)) {
        $categories = $cats;
    } else {
        return false;
    }

    printf('<br /><br /><br />');

    /* Double loop:
     * 1. Loop each supplied category.
     * 2. For each category, output $numberposts posts.
     * 
     * Order of output is 1 left, $numberposts - 1 right.
     * Left post has an excerpt. */

    foreach($categories as $category) {
        $category_posts = get_posts(array(
            'numberposts' => $numberposts,
            'order' => 'DESC',
            'category' => $category
        ));
        
        if ($show_title) {
            printf('<h2>%s</h2>', get_category($category)->cat_name);
        }

        printf('<div class="category-widget-display">');

        foreach ($category_posts as $cat_post) { 
            $post_classes = implode(' ', get_post_class($current_post === 0 ? 'left' : '', $cat_post->ID));

            printf('<article class="%s" id="%s">', $post_classes, $cat_post->ID);
            printf('%d %s<br />', $cat_post->ID, $cat_post->post_title);

            if ($current_post === 0) {
                printf('<p>%s</p>', $cat_post->post_excerpt);
            }

            printf('</article>');

            if ($current_post === 0) {
                printf('<div class="right">');
            }

            $current_post++;
        }
        
        $current_post = 0;    
        printf('</div></div>');
        printf('<br /><br /><br />');
    }

    wp_reset_postdata();
}

class tuairisc_home_category extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_home_category', TTD),
            __('Tuairisc: Home Page Category', TTD),
            array(
                'description' => __('Selected category to featured on the website home page', TTD),
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
            'category' => 0,
            'show_category_name' => false
        );

        $instance = wp_parse_args($instance, $defaults);

        $categories = get_categories(array(
            'type' => 'post',
            'order' => 'ASC',
            'orderby' => 'name',
            'hide_empty' => true,
        ));

        ?>

        <ul>
            <li>
                <input type="checkbox" id="<?php printf($this->get_field_id('show_category_name')); ?>" name="<?php printf($this->get_field_name('show_category_name')); ?>" />
                <label for="<?php printf($this->get_field_id('show_category_name')); ?>"><?php _e('Show category name', TTD); ?></label>
            </li>
            <li>
            </li>
            <select id="<?php printf($this->get_field_id('category')); ?>" name="<?php printf($this->get_field_name('category')); ?>">
                <?php foreach ($categories as $index => $category) {
                    printf('<option value="%s">%s (%d)</option>', $category->cat_ID, $category->name, $category->count);
                } ?>
            </select>
        </ul>
        <script>
            jQuery('<?php printf('#%s', $this->get_field_id('show_category_name')); ?>').prop('checked', <?php printf(($instance['show_category_name']) ? 'true' : 'false'); ?>);
        jQuery('<?php printf('#%s', $this->get_field_id('category')); ?>').val('<?php printf($instance['category']); ?>');
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

        $defaults['show_category_name'] = ($new_defaults['show_category_name'] === 'on');
        $defaults['category'] = intval($new_defaults['category']);

        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        $title = apply_filters('widget_title', $instance['widget_title']);

        if (!empty($defaults['before_widget'])) {
            printf('%s', $defaults['before_widget']);
        }
        
        category_widget_output($instance['category'], $instance['show_title'], 4);

        if (!empty($defaults['after_widget'])) {
            printf('%s', $defaults['after_widget']);
        }

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_home_category");'));

?>
