<?php

/**
 * Sidebar Recent Website Posts
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

class Kaitain_Recent_Posts_Sidebar_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_recent_sidebar_widget', 'kaitain'),
            __('Tuairisc: Recent Posts Sidebar', 'kaitain'),
            array(
                'description' => __('For sidebar - does not display on front page. An ordered list of recent Tuairisc posts sorted by date. Choose from either one category, or all categories. ', 'kaitain'),
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
            'widget_title' => __('Úrnua', 'kaitain'),
            'max_posts' => 10,
            'category' => 0,
            'word_limit' => 11,
            'widget_mode' => 'production'
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
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Widget title:', 'kaitain'); ?></label>
            </li>
            <li>
                <input id="<?php printf($this->get_field_id('widget_title')); ?>" name="<?php printf($this->get_field_name('widget_title')); ?>" value="<?php printf($instance['widget_title']); ?>" type="text" class="widefat" />
            </li>
            <li>
                <label for="<?php printf($this->get_field_id('category')); ?>"><?php _e('Category:', 'kaitain'); ?></label>
            </li>
            <li>
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
                <label for="<?php printf($this->get_field_id('word_limit')); ?>"><?php _e('Word limit for post titles:', 'kaitain'); ?></label>
                <input id="<?php printf($this->get_field_id('word_limit')); ?>" type="number" name="<?php printf($this->get_field_name('word_limit')); ?>">
            </li>
            <hr>
            <li style="font-size: smaller;">
                <input id="<?php printf($this->get_field_id('widget_mode').'-development'); ?>" type="radio" name="<?php printf($this->get_field_name('widget_mode')); ?>" value="development" />
                <label for="<?php printf($this->get_field_id('widget_mode')); ?>"><?php _e('Development Mode (No transients)', 'kaitain'); ?></label>
            </li>
            <li style="font-size: smaller;">
                <input id="<?php printf($this->get_field_id('widget_mode').'-production'); ?>" type="radio" name="<?php printf($this->get_field_name('widget_mode')); ?>" value="production" />
                <label for="<?php printf($this->get_field_id('widget_mode')); ?>"><?php _e('Production Mode', 'kaitain'); ?></label>
            </li>
        </ul>
        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery(function($) {
                // Set 'category' selected option.
                $('<?php printf('#%s', $this->get_field_id("category")); ?>').val('<?php printf($instance["category"]); ?>');
                // Set 'max_posts' selected option. 
                $('<?php printf('#%s', $this->get_field_id("max_posts")); ?>').val('<?php printf($instance["max_posts"]); ?>');
                $('<?php printf('#%s', $this->get_field_id("word_limit")); ?>').val('<?php printf($instance["word_limit"]); ?>');
                // Set development mode or production mode radio menu checked or unchecked.
                $('<?php printf('#%s-development', $this->get_field_id('widget_mode')); ?>').prop('checked', <?php printf(( 'development' === $instance['widget_mode'] ) ? 'true' : 'false'); ?>);
                $('<?php printf('#%s-production', $this->get_field_id('widget_mode')); ?>').prop('checked', <?php printf(( 'production' === $instance['widget_mode'] ) ? 'true' : 'false'); ?>);
            });
        </script>

        <?php
    }

    /**
     * Widget Update
     * -------------------------------------------------------------------------
     * @param  array    $new_args       New default variables.
     * @param  array    $old_args       Old default variables.
     * @return array    $options        New widget settings.
     */

    function update($new_args, $old_args) {
        $options = array();
        $options['widget_title'] = strip_tags($new_args['widget_title']);
        $options['max_posts'] = $new_args['max_posts'];
        $options['category'] = $new_args['category'];
        $options['word_limit'] = $new_args['word_limit'];
        $options['widget_mode'] = $new_args['widget_mode'];
        return $options;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        // Checks if the page is the homepage, if it isn't then render the widget
        if (!is_front_page()) {

            global $post;

            // Check widget mode
            if ( 'development' === $instance['widget_mode'] ) {
                if (function_exists('write_log')) {
                    write_log("Home Gallery Widget debug:");
                    write_log($instance);
                }
                $recent = get_posts(array(
                        'post_type' => 'post',
                        'numberposts' => $instance['max_posts'],
                        'order' => 'DESC',
                        'category' => ($instance['category']) ? $instance['category'] : ''
                ));
            }
            else if ( 'production' ===  $instance['widget_mode'] ) {
            // In production mode, set up transients for caching/speed.
                $trans_name = 'recent_posts_sidebar';
            
                if (!($recent = get_transient($trans_name))) {
                    $recent = get_posts(array(
                        'post_type' => 'post',
                        'numberposts' => $instance['max_posts'],
                        'order' => 'DESC',
                        'category' => ($instance['category']) ? $instance['category'] : ''
                    ));

                    set_transient($trans_name, $recent, get_option('kaitain_transient_timeout')); 
                }
            }

            $key = get_option('kaitain_view_counter_key');
            $title = apply_filters('widget_title', $instance['widget_title']);

            $widget_id = $this->number;
            $before_widget = '<div id="kaitain_recent_sidebar_'.$widget_id.'" class="widget widget_kaitain_recent_sidebar">';
            $before_widget_title = '<h3 class="widget--home__title vspace--half">';
            $widget_title = apply_filters('widget_title', $instance['widget_title']);

            if (!empty($defaults['before_widget'])) {
                // printf($defaults['before_widget']);
                echo $before_widget;
                //printf($defaults['before_title'] . $title . $defaults['after_title']);
                echo $before_widget_title . $title . $defaults['after_title'];
            }

            printf('<div class="recent-widget tuairisc-post-widget row">');

            foreach ($recent as $post) {
                setup_postdata($post);
               // kaitain_partial('article', 'sidebar');

                $trim = kaitain_section_css(get_the_category()[0]);

                $post_classes = array(
                    'article--sidebar', 'vspace--full', 'col-xs-12'
                );

                ?>
                <article <?php post_class($post_classes); ?> id="article--sidebar--<?php the_id(); ?>">
                    <a class="<?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                        <div class="thumbnail img-frame col-xs-4 col-sm-4 col-md-3">
                            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
                            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                        </div>
                        <div class="post-content article__postcontent col-xs-8 col-sm-8 col-md-9">
                            <header class="article--sidebar__header">
                                <h5 class="title article--sidebar__title vspace--quarter">
                                    <?php echo kaitain_excerpt( get_the_title(), $instance['word_limit'] ); ?>
                                </h5>
                                <h6 class="post-date article__postmeta">
                                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time>
                                </h6>
                            </header>
                        </div>
                    </a>
                </article>
                <?php
            }

            printf('</div>');

            if (!empty($defaults['after_widget'])) {
                printf($defaults['after_widget']);
            }

            wp_reset_postdata();
        }
    }
}

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Recent_Posts_Sidebar_Widget");'));

?>
