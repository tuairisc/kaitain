<?php

/*
 * Most Viewed Posts
 * -----------------
 * This is based on the get_view_count increment_view_counter functions.
 */

class Most_Viewed_Articles extends WP_Widget {
    function Most_Viewed_Articles() {
        /* Widget settings. */
        $widget_ops = array('classname' => 'mostviewed-articles', 'description' => 'A list of the most popular posts based on view count.');
        /* Widget control settings. */
        $control_ops = array('id_base' => 'mostviewed-articles');
        /* Create the widget. */
        $this->WP_Widget('mostviewed-articles', 'Most Viewed Posts', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title']);
        $maxposts = $instance['maxposts'];
        $timeline = $instance['sincewhen'];

        // View counter meta key. 
        $views_meta_key = 'tuairisc_view_counter';

        /* Before widget (defined by themes). */
        echo $before_widget;

        /* Title of widget (before and after defined by themes). */
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        $start_date = new Date(date('Y-m-d'));

        // What's the chosen timeline?
        switch ($timeline) {
            case "thisday":
                date_sub($start_date, date_interval_create_from_date_string('1 day'));
                break;
            case "thisweek":
                date_sub($start_date, date_interval_create_from_date_string('7 days'));
                break;
            case "thismonth":
                date_sub($start_date, date_interval_create_from_date_string('28 days'));
                break;
            case "thisyear":
                date_sub($start_date, date_interval_create_from_date_string('1 year'));
                break;
            default:
                // Show a week? Show a week.
                date_sub($start_date, date_interval_create_from_date_string('28 days'));
        }

        $viewed_query = WP_query(array(
            // The old gallery plugin caused wildly inflated view counts. Each time the 
            // navigation links were clicked inside of a modal box, it refreshed the 
            // entire page. Sweet-ass design, bro.  
            // Photo Gallery - http://web-dorado.com/ 

            'cat' => -184,
            'post_type' => 'post',
            'meta_key' => $key, 
            'posts_per_page' => 50,
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'date_query' => array(
                'after' => array(
                    'year' => date('Y', $start_date),
                    'month' => date('m', $start_date),
                    'day' => date('d', $start_date)
               ),
                'before' => array(
                    'year' => date('Y'),
                    'month' => date('m'),
                    'day' => date('d')                        
               ),
                'inclusive' => true
           )
       ));

        // Make sure only integers are entered
        if (!ctype_digit($maxposts)) {
            $maxposts = 10;
        } else {
            // Reformat the submitted text value into an integer
            $maxposts = $maxposts + 0;
            // Only accept sane values
            if ($maxposts <= 0 or $maxposts > 10) {
                $maxposts = 10;
            }
        }

        if ($viewed_query->have_posts()) {
            echo '<ul class="popular">';

            while ($author_query->have_posts()) {
                $viewed_query->the_post();

                $cats = get_the_category($viewed_query->ID);
                $wrappeddate = $viewed_query->post_date;
                $wrappeddate = str_replace(" ", "-", $wrappeddate);
                $wrappeddate = str_replace(":", "-", $wrappeddate);
                $datearray = explode("-", $wrappeddate);
                $wrappeddate = date("F j, Y", mktime($datearray[3], $datearray[4], $datearray[5], $datearray[1], $datearray[2], $datearray[0]));
                ?>
                <li>
                    <a href="<?php get_permalink($r->ID); ?>" rel="bookmark"><?php htmlspecialchars($viewed_query->post_title, ENT_QUOTES); ?></a>
                    <br /><span class="comments" href="<?php get_permalink($r->ID); ?>"><?php htmlspecialchars($viewed_query->comment_count, ENT_QUOTES) . ' ' . __('comments','wpzoom'); ?></span>;
                </li>
                <?php
            }

            echo '</ul>';
        } else {
            echo "<li class='mcpitem mcpitem-0'>". __('Níor fágadh aon nóta tráchta fós', 'wpzoom') . "</li>\n";
        }

        /* After widget (defined by themes). */
        echo $after_widget;
    }

     function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title']     = strip_tags($new_instance['title']);
        $instance['maxposts']  = $new_instance['maxposts'];
        $instance['sincewhen'] = $new_instance['sincewhen'];
        return $instance;
    }

     function form($instance) {
        /* Set up some default widget settings. */
        $defaults = array('title' => 'Most Viewed', 'maxposts' => 10, 'sincewhen' => 'forever');
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label><br />
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text"  class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('sincewhen'); ?>"><?php _e('Since:', 'wpzoom'); ?></label><br />
            <select id="<?php echo $this->get_field_id('sincewhen'); ?>" name="<?php echo $this->get_field_name('sincewhen'); ?>">
                <option value="forever"   <?php echo $instance['sincewhen'] != 'thismonth' && $instance['sincewhen'] != 'thisyear' ? 'selected="selected"' : ''; ?>><?php _e('Forever', 'wpzoom'); ?></option>
                <option value="thisyear"  <?php echo $instance['sincewhen'] == 'thisyear' ? 'selected="selected"' : ''; ?>><?php _e('This Year', 'wpzoom'); ?></option>
                <option value="thismonth" <?php echo $instance['sincewhen'] == 'thismonth' ? 'selected="selected"' : ''; ?>><?php _e('This Month', 'wpzoom'); ?></option>
                <option value="thisweek"  <?php echo $instance['sincewhen'] == 'thisweek' ? 'selected="selected"' : ''; ?>><?php _e('This Week', 'wpzoom'); ?></option>
                <option value="thisday"   <?php echo $instance['sincewhen'] != 'thisday' && $instance['sincewhen'] != 'thisday' ? 'selected="selected"' : ''; ?>><?php _e('Today', 'wpzoom'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('maxposts'); ?>"><?php _e('Posts To Display:', 'wpzoom'); ?></label>
            <select id="<?php echo $this->get_field_id('maxposts'); ?>" name="<?php echo $this->get_field_name('maxposts'); ?>">
                <?php for ($i = 1; $i < 11; $i++) {
                    echo '<option' . ($i == $instance['maxposts'] ? ' selected="selected"' : '') . '>' . $i . '</option>';
                } ?>
            </select>
        </p>
        <?php
    }
}

function register_most_viewed() {
    register_widget('Most_Viewed_Articles');
}

add_action('widgets_init', 'register_most_viewed');
?>