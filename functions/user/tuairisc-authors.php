<?php class tuairisc_author_list extends WP_Widget {
    /* tuairisc_author_list Widget
     * -----------------------
     * This widget displays an ordered horizontal lists of selected Tuairisc 
     * authors and other contributors. 
     */ 
    public function __construct() {
        parent::__construct(
            'tuairisc_author_list',
            'Tuairisc Authors',
            array(
                'description' => 'A horizontal ordered list of selected Tuairisc authors.',
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
        $instance['authors'] = $new_instance['authors'];
        return $instance;
    }

    public function console_log($msg) {
        echo '<script>console.log("' . $msg . '");</script>';
    }

    public function form($instance) {
        $defaults = array(
            'title' => 'Site Authors',
        );

        $instance = wp_parse_args($instance, $defaults);

        $author_list = get_users(array(
            'orderby' => 'nicename',
        ));

        foreach($instance['authors'] as $argh) {
            $this->console_log($argh);
        }
        
        ?>
        <style>
            .argh {
                border: 1px solid #DFDFDF;
                box-sizing: border-box;
                height: 150px;
                overflow-y: scroll;
                padding: 5px;
            }
        </style>
        <script>
            jQuery(function($) {
                $('.argh input[type=checkbox]').each(function() {
                    // $(this).prop('checked', true);
                }); 
            });
        </script>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label><br />
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text"  class="widefat" />
        </p>
        <p class="ugh">
            <label for="<?php echo $this->get_field_id('authors'); ?>"><?php _e('Authors:', 'wpzoom'); ?></label><br />
            <div class="argh">
                <?php foreach ($author_list as $author) : ?>
                    <?php $id = $this->get_field_id('authors') . '-' . $author->ID; ?>
                    <?php // Input. ?>
                    <input 
                        class="checkbox" 
                        id="<?php echo $id; ?>" 
                        name="<?php echo $id; ?>" 
                        type="checkbox" 
                        value="<?php echo $author->ID; ?>" 
                    />
                    <?php // Label and break. ?>
                    <label for="<?php echo $id; ?>">
                        <?php echo $author->display_name; ?>
                    </label>
                    <br />
                <?php endforeach; ?>
            </div>
        </p>
        <?php
    }
}

add_action('widgets_init',
    create_function('', 'return register_widget("tuairisc_author_list");')
);
?>