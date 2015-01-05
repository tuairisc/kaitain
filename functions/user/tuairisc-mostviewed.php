<?php class tuairisc_popular extends WP_Widget {
    /* tuairisc_popular Widget
     * -----------------------
     * This widget is a re-write of WPZOOM's popular post widget. Both the form 
     * and widget functions were re-written from almost the ground up; there's 
     * virtually no remaining original code. 
     * 
     * This widget uses the tuairisc_view_counter meta key of posts. The view 
     * counter was a requested way to quickly and non-canonically determine the
     * most popular posts on the site. The stock WPZOOM widget directly accessed
     * the database, and a good deal of the code was tied to parsing this. 
     * I instead use WP_Query to fetch posts.  
     */ 
    public function __construct() {
        parent::__construct(
            'tuairisc_popular',
            'Tuairisc Popular',
            array(
                'description' => 'An ordered list of popular Tuairisc posts sorted by view count.',
            )
        );
    }

    public function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $counter_meta_key = 'tuairisc_view_counter';

        // Get current date and subtract $instance['sincewhen'] days from it. 
        $end_date = new DateTime();
        $start_date = new DateTime();
        $start_date = $start_date->sub(new DateInterval('P' . $instance['sincewhen'] . 'D'));

        $popular_query = new WP_Query(array(
            'cat' => -184,
            'post_type' => 'post',
            'meta_key' => $counter_meta_key, 
            'posts_per_page' => $instance['maxposts'],
            'orderby' => $counter_meta_key,
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
            echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
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
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['maxposts'] = $new_instance['maxposts'];
        $instance['sincewhen'] = $new_instance['sincewhen'];
        return $instance;
    }

    public function form($instance) {
        $defaults = array(
            'title' => 'Most Viewed',
            'maxposts' => 10,
            'sincewhen' => '7'
        );

        $instance = wp_parse_args($instance, $defaults);
        
        ?>
            <script>
                /* The default widget used a mess of inline PHP to set the
                 * default selected options for both select values. This proved 
                 * difficult for me to pick apart, parse and edit. */
                jQuery(function($) {
                    // Set 'sincewhen' selected option.
                    $('<?php echo "#" . $this->get_field_id("sincewhen"); ?>').val('<?php echo $instance["sincewhen"]; ?>');
                    // Set 'maxposts' selected option. 
                    $('<?php echo "#" . $this->get_field_id("maxposts"); ?>').val('<?php echo $instance["maxposts"]; ?>');
                });
            </script>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label><br />
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text"  class="widefat" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('sincewhen'); ?>"><?php _e('Since:', 'wpzoom'); ?></label><br />
                <select id="<?php echo $this->get_field_id('sincewhen'); ?>" name="<?php echo $this->get_field_name('sincewhen'); ?>">
                    <option value="36500">All Time</option>
                    <option value="365">This Year</option>
                    <option value="28">This Month</option>
                    <option value="7">This Week</option>
                    <option value="1">Today</option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('maxposts'); ?>"><?php _e('Posts To Display:', 'wpzoom'); ?></label><br />
                <select id="<?php echo $this->get_field_id('maxposts'); ?>" name="<?php echo $this->get_field_name('maxposts'); ?>">
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