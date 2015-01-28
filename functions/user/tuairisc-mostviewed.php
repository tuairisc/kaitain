<?php class tuairisc_popular extends WP_Widget {
    /* tuairisc_popular Widget
     * -----------------------
     * This widget uses the tuairisc_view_counter meta key of posts. The view 
     * counter was a requested way to quickly and non-canonically determine the
     * most popular posts on the site. The stock widget directly accessed
     * the database, and a good deal of the code was tied to parsing this. 
     */ 
    public function __construct() {
        parent::__construct(
            'tuairisc_popular',
            'Tuairisc\'s Popular Posts',
            array(
                'description' => 'An ordered list of popular Tuairisc posts sorted by view count.',
            )
        );
    }

    public function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['widget_title']);

        // Get current date and subtract $instance['elapsed_days'] days from it. 
        $end_date = new DateTime();
        $start_date = new DateTime();
        $start_date = $start_date->sub(new DateInterval('P' . $instance['elapsed_days'] . 'D'));

        $popular_query = new WP_Query(array(
            'cat' => -184,
            'post_type' => 'post',
            'meta_key' => 'tuairisc_view_counter', 
            'posts_per_page' => $instance['max_posts'],
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'date_query' => array(
                'after' => array(
                    /* I had a devil of a time in getting strtotime to work so I
                     * fell back to passing YMD individually. */
                    'year' => $start_date->format('Y'),
                    'month' => $start_date->format('m'),
                    'day' => $start_date->format('d'),
                ),
                'before' => array(
                    'year' => $end_date->format('Y'),
                    'month' => $end_date->format('m'),
                    'day' => $end_date->format('d')                        
                ),
                'inclusive' => true
            )
        ));

        if (!empty($args['before_widget'])) {
            // Widget container and title.
            echo $before_widget;
            echo $before_title . apply_filters('widget_title', $instance['widget_title']) . $after_title;
        }

        echo '<ul class="tuairisc-popular-list">';

        if ($popular_query->have_posts()) {
            while ($popular_query->have_posts()) {
                $popular_query->the_post();

                ?>
                <li class="self-clear">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="popular-thumb" style="background-image: url('<?php echo get_thumbnail_url(); ?>')">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
                        </div>
                        <div class="popular-text">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            <br />
                            <small><?php the_date(); ?></small>
                        </div>
                    <?php endif; ?>
                </li>
                <?php
            }
        } else {
            echo __('Níor fágadh aon nóta tráchta fós', 'wpzoom');
        }

        echo '</ul>';

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['widget_title'] = strip_tags($new_instance['widget_title']);
        $instance['max_posts'] = $new_instance['max_posts'];
        $instance['elapsed_days'] = $new_instance['elapsed_days'];
        return $instance;
    }

    public function form($instance) {
        $defaults = array(
            'widget_title' => 'Most Viewed',
            'max_posts' => 10,
            'elapsed_days' => '7'
        );

        $instance = wp_parse_args($instance, $defaults);
        
        ?>
            <script>
                /* The default widget used a mess of inline PHP to set the
                 * default selected options for both select values. This proved 
                 * difficult for me to pick apart, parse and edit. */
                jQuery(function($) {
                    // Set 'elapsed_days' selected option.
                    $('<?php echo "#" . $this->get_field_id("elapsed_days"); ?>').val('<?php echo $instance["elapsed_days"]; ?>');
                    // Set 'max_posts' selected option. 
                    $('<?php echo "#" . $this->get_field_id("max_posts"); ?>').val('<?php echo $instance["max_posts"]; ?>');
                });
            </script>

            <p>
                <label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label><br />
                <input id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $instance['widget_title']; ?>" type="text"  class="widefat" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('elapsed_days'); ?>"><?php _e('Since:', 'wpzoom'); ?></label><br />
                <select id="<?php echo $this->get_field_id('elapsed_days'); ?>" name="<?php echo $this->get_field_name('elapsed_days'); ?>">
                    <option value="36500">All Time</option>
                    <option value="365">This Year</option>
                    <option value="28">This Month</option>
                    <option value="7">This Week</option>
                    <option value="1">Today</option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('max_posts'); ?>"><?php _e('Posts To Display:', 'wpzoom'); ?></label><br />
                <select id="<?php echo $this->get_field_id('max_posts'); ?>" name="<?php echo $this->get_field_name('max_posts'); ?>">
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </p>
        <?php
    }
}

add_action('widgets_init',
    create_function('', 'return register_widget("tuairisc_popular");')
);
?>