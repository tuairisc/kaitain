<?php

/**
 * Recent Website Posts Container Widget
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

class Kaitain_Recent_Posts_Container_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_recent_container', 'kaitain'),
            __('Tuairisc: Recent Posts Container', 'kaitain'),
            array(
                'description' => __('A container for recent post widgets.', 'kaitain'),
            )
        );
    }

    /**
     * Widget Administrative Form
     * -------------------------------------------------------------------------
     * @param array     $instance       Widget instance.
     */

    public function form($instance) {

        $widget_id = $this->number;
        $widget_string = "widget-kaitain_recent_container[".$widget_id."]";

        $defaults = array(
            // Widget defaults.
            'widget_title' => __('Recent Posts Container', 'kaitain'),
            'total_columns' => 1,
            'columns' => array(
                array(
                    'column_title' => __('Column Title', 'kaitain'),
                    'column_category' => 0,
                    'column_max_posts' => 1
                )
            ),
            'max_posts' => 10
        ); 
        $instance = wp_parse_args($instance, $defaults);

        $widget_title = $instance['widget_title'];
        $total_columns = $instance['total_columns'];
        $columns = $instance['columns'];

        // on (re)load,// if total_columns has been set height, push column(s) to array
        if (count($columns) < $instance['total_columns']) {
            $count = count($columns);
            $difference = $instance['total_columns'] - $count;
            for ($i = 1; $i <= $difference; $i++) {
                array_push(
                    $columns,
                    array (
                        'column_title' => __('Column Title', 'kaitain'),
                        'column_category' => 0,
                        'column_max_posts' => 1
                    )
                );
            }
        }
        // if total_columns has been set lower, pop columns from a array
        else if (count($columns) > $instance['total_columns']) {
            $count = count($columns);
            $difference = $count - $instance['total_columns'];
            for ($difference; $difference > 0; $difference--) {
                array_pop( $columns );
            }
        }

        // $instance['columns'] = $columns;


        $categories = get_categories(array(
            'type' => 'post',
            'orderby' => 'name',
            'order' => 'ASC',
            'pad_counts' => 'false'
        ));
        
        ?>

        <script>
            // This jQuery is easier for me to parse and debug than a mess of inline PHP.
            jQuery(function($) {
                // Set 'columns' selected option.
                //$('<?php printf('#%s', $this->get_field_id("columns")); ?>').val('<?php printf($instance["columns"]); ?>');

                <?php for ($i = 0; $i < count($columns); $i++) { ?>
                // Set 'category' selected option.
                $('<?php echo "#widget-kaitain_recent_container\\\\[".$widget_id."\\\\]\\\\[columns\\\\]\\\\[".$i."\\\\]\\\\[column_category\\\\]"; ?>').val('<?php
                    echo $columns[$i]["column_category"];
                    ?>');
                
                // Set 'column_max_posts' each selected option. 
                
                $('<?php echo "#widget-kaitain_recent_container\\\\[".$widget_id."\\\\]\\\\[columns\\\\]\\\\[".$i."\\\\]\\\\[column_max_posts\\\\]"; ?>').val('<?php
                    echo $instance['columns'][$i]['column_max_posts'];
                    ?>');
                <?php }; ?>
            });
        </script>

        <ul>
            <!-- widget title -->
            <li>
                <label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget title:', 'kaitain'); ?></label>
                <input id="<?php echo $this->get_field_id('widget_title'); ?>"
                    name="<?php echo $this->get_field_name('widget_title'); ?>"
                    value="<?php echo $instance['widget_title'];?>"
                    type="text"
                    class="widefat"
                    placeholder="Enter a title to display, empty is hidden"/>
            </li>
            <!-- number of columns to contain -->
            <li>
                <label for="<?php echo $this->get_field_id('total_columns'); ?>"><?php _e('Number of Columns:', 'kaitain'); ?></label>
                <br>
                <input id="<?php echo $this->get_field_id('total_columns'); ?>" name="<?php echo $this->get_field_name('total_columns'); ?>" value="<?php echo $instance['total_columns']; ?>" type="number" style="width:50%;" />
                <input type="submit" name="savewidget" id="<?php echo $widget_string."-savewidget"; ?>" class="button button-primary widget-control-save right" value="Update">
            </li>
        </ul>
        <ul>
<!--  
// for each column have following details
 -->
            <?php
            for ($i = 0 ; $i < count($columns); $i++) {
            ?>

                <div class="widget-title widget-top" style="margin-top: 8px;">
                    <h4><?php echo "Column #".($i+1);
                    echo ": ".$columns[$i]['column_title'];
                    ?></h4>
                </div>
                <div class="widget-inside" style="display:block;">
                    <!-- column title -->
                    <li>
                        <label for="<?php echo $widget_string."[columns][".$i."][column_title]"; ?>">
                            <?php _e('Column title:', 'kaitain'); ?>
                        </label>
                        <input  id="<?php echo $widget_string."[columns][".$i."][column_title]"; ?>"
                                name="<?php echo $widget_string."[columns][".$i."][column_title]"; ?>"
                                value="<?php echo $columns[$i]['column_title']; ?>"
                                type="text"
                                class="widefat" />
                    </li>

                    <!-- column category -->
                    <li>
                        <label for="<?php echo $widget_string."[columns][".$i."][column_category]"; ?>"><?php _e('Category:', 'kaitain'); ?></label>
                        <select id="<?php echo  $widget_string."[columns][".$i."][column_category]"; ?>" name="<?php echo  $widget_string."[columns][".$i."][column_category]"; ?>">
                            <option value="0"><?php _e('All', 'kaitain'); ?></option>

                            <?php foreach ($categories as $category) {
                                // Iterate through all caterories. 
                                printf('<option value="%d">%s (%d)</option>', $category->cat_ID, $category->cat_name, $category->category_count);
                            }  ?>
                        </select>
                    </li>

                    <!-- column posts to display -->
                    <li>
                        <label for="<?php echo $widget_string."[columns][".$i."][column_max_posts]"; ?>"><?php _e('Number of posts to display:', 'kaitain'); ?></label>
                        <select id="<?php echo $widget_string."[columns][".$i."][column_max_posts]"; ?>" name="<?php echo $widget_string."[columns][".$i."][column_max_posts]"; ?>">
                            <?php for ($j = 1; $j <= $defaults['max_posts']; $j++) {
                                printf('<option value="%d">%d</option>', $j, $j);
                            } ?>
                        </select>
                    </li>
                </div>
                <?php 
            }; // end foreach
            ?>

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
        $defaults['total_columns'] = $new_args['total_columns'];
        $defaults['columns'] = $new_args['columns'];
        $defaults['max_posts'] = $new_args['max_posts'];
        
        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
       
        $widget_id = $this->number;
        $widget_title = apply_filters('widget_title', $instance['widget_title']);
        $total_columns = $instance['total_columns'];
        $columns = $instance['columns'];


        if (!empty($defaults['before_widget'])) {
            printf($defaults['before_widget']);
            printf($defaults['before_title'] . $widget_title . $defaults['after_title']);
        }

        echo '<div class="recent-post-container-widget tuairisc-post-widget row">';

        // for loop for each column
        for ($i=0;$i<$total_columns;$i++) {
            global $post;
            $key = get_option('kaitain_view_counter_key');

            $category_link = get_category_link( $columns[$i]['column_category'] );
            $title = '<a href="'.esc_url( $category_link ).'" title="'.$columns[$i]['column_title'].'">'. $columns[$i]['column_title'] .'</a>';
                        
            // $trans_name = 'sidebar_recent_posts_container-'.($i+1);
            // check if its cached in transient
            // if (!($recent = get_transient($trans_name))) {
            //     $recent = get_posts(array(
            //         'post_type' => 'post',
            //         'numberposts' => $columns[$i]['column_max_posts'],
            //         'order' => 'DESC',
            //         'category' => ($columns[$i]['column_category']) ? printf($columns[$i]['column_category']) : ''
            //     ));
            //     set_transient($trans_name, $recent, get_option('kaitain_transient_timeout')); 
            // }

            $recent = get_posts(array(
                    'post_type' => 'post',
                    'numberposts' => $columns[$i]['column_max_posts'],
                    'order' => 'DESC',
                    'category' => ($columns[$i]['column_category']) ? $columns[$i]['column_category'] : ''
            ));

            echo '<div class="recent-post tuairisc-post-widget col-md-3 col-sm-3 col-xs-12 vspace--full">';

            $before_column = '<div id="kaitain_recent_container_'.$widget_id.'_column-'.($i+1).'" class="widget widget--home widget_kaitain_recent_container_column">';
            $before_column_title = '<h3 class="widget--home__title vspace--half">';

            if (!empty($defaults['before_widget'])) {
                echo $before_column;
                echo $before_column_title . $title . $defaults['after_title'];
            }

            foreach ($recent as $post) {
                setup_postdata($post);
                kaitain_partial('article', 'recent');
            }

            echo '</div></div>';
            wp_reset_postdata();
        }
        echo '</div>';

        if (!empty($defaults['after_widget'])) {
            printf($defaults['after_widget']);
        }

       
    }
}

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Recent_Posts_Container_Widget");'));

?>
