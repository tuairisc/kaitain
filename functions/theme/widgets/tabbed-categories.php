<?php 
/**
 * Tabbed Categories Widget
 */
add_action('widgets_init', create_function('', 'return register_widget("Tabbed_Widget");'));

class Tabbed_Widget extends WP_Widget {
    function Tabbed_Widget() {
        $widgetOps = array(
            "classname"   => "wpzoom_tabbed",
            "description" => "An advanced widget that displays a featured block with posts in different styles.",
        );

        $controlOps = array(
            "width"   => 260,
            "height"  => 180,
            "id_base" => "wpzoom-tabbed-widget"
        );

        $this->WP_Widget("wpzoom-tabbed-widget", "WPZOOM: Tabbed Categories", $widgetOps, $controlOps);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters("widget_title", $instance["title"]);
        $category = $instance['category'];
        $count = $instance["count"];
        $category_link = null;
 
        if ($category) {
            $category_link = get_category_link($category);
        }
 
        $rnd = rand();
        ?>

        <div class="wztw-container">
             <?php if ($title) {
                echo '<h2>';
                
                if ($category) {
                    echo '<a href="' . $category_link . '">';
                }

                echo $title;

                if ($category_link) {
                    echo '</a>';
                }

                echo '</h2>'; 
            } ?>

            <ul class="tabs clearfix">
                <?php for ($i = 1; $i <= $instance["count"]; $i++) : ?>
                    <li>
                        <a href="#tab<?php echo $rnd . $i; ?>"><?php echo stripslashes($instance["tab" . $i . "-title"]); ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
            
            <?php for ($i = 1; $i <= $instance["count"]; $i++) :
                    if ($instance["tab" . $i . "-type"] == "tag") {
                        $postsq = $instance["tab" . $i . "-slugs"];
                    } else {
                        $postsq = implode(",", $instance["tab" . $i . "-category"]);
                    }

                    $posts = $instance["tab" . $i . "-posts"];
                    $type = $instance["tab" . $i . "-type"];

                    $sq = new WP_Query(array(
                        $type => $postsq,
                        'showposts' => $posts,
                        'orderby' => 'date',
                        'order' => 'DESC' 
                    ));

                    $x = 0; ?>
                
                <div id="tab<?php echo $rnd . $i; ?>" class="wztw-content">
                    <div class="column_1 col_3">
                        <?php if ($sq->have_posts()) : ?>
                            <?php while($sq->have_posts()) : 
                                $sq->the_post();  
                                $x++;
                                global $post;
                        
                                if ($x == 1) : ?> 
                                    <?php if (is_columnist_article() && has_local_avatar()) : ?>
                                        <a href="javascript:void(0)"><img class="featured-tab" src="<?php echo get_avatar_url(get_the_author_meta('ID'), 135); ?>" /></a>
                                    <?php else : ?>
                                        <?php get_the_image(array(
                                            'size' => 'featured-tab',
                                            'width' => 135,
                                            'height' => 135
                                        )); ?>
                                    <?php endif; ?>

                                    <div class="main_content">
                                        <h2>
                                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                                <!-- Begin optional portion. -->
                                                <?php if (is_columnist_article()) : ?>
                                                    <span><?php echo get_the_author(); ?></span><br />
                                                <?php endif; ?>
                                                <!-- End optional portion. -->
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>                        

                                        <?php the_excerpt(); ?>            

                                        <?php // category link here 
                                            $url = get_category_link($postsq);
                                            $name = get_cat_name($postsq);
                                            // $text = 'Leígh tuilleadh i ' . $name;
                                            $text = 'Léigh tuilleadh sa rannóg seo';
                                            $anchor = '<h6><a title="' . $text . '" href="' . $url . '">' . $text . '</a></h6>'; 
                                            echo $anchor;
                                        ?>
                                        </div>                    
                                    </div> <!-- /.1col -->

                                    <div class="column_2 col_3">
                                        <ul class="posts_med">
                                <?php else : ?>
                                    <li><h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3></li>
                                <?php endif; ?>    
                            <?php endwhile; //  ?>
                        <?php endif; ?>
                    </ul>  
                </div> <!-- /.2col -->
                  
                <?php wp_reset_query(); ?>

            </div>
        <?php endfor; // End of widget function. ?>

        </div><!-- end of .wztw-container -->
        <div class="clear"></div>
        <script>jQuery(function($){ $(".wztw-container").tabs(); });</script>  
    <?php }

    function form($instance) {
        $defaults = array(
            "title" => "Categories (tabs)",
            "count" => "2",
            "category" => 0,
        );

        $instance = wp_parse_args((array) $instance, $defaults); ?>
        <!-- Widget Title -->
        <p>
            <label for="<?php echo $this->get_field_id("title"); ?>">Title</label>
            <input type="text" style="widefat" size="27" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" value="<?php echo $instance["title"]; ?>"   />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>">Title Links to Category:</label>
            <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
                <option value="0" <?php if (!$instance['category']) echo 'selected="selected"'; ?>>None</option>
                    <?php $categories = get_categories(array('type' => 'post'));
                        
                        foreach($categories as $cat) {
                            echo '<option value="' . $cat->cat_ID . '"';
                            
                            if ($cat->cat_ID == $instance['category']) {
                                echo  ' selected="selected"';
                            }
                            
                            echo '>' . $cat->cat_name . ' (' . $cat->category_count . ')';
                            echo '</option>';
                        } ?>
            </select>
        </p>
        <!-- Categories count -->
        <p>
            <label for="<?php echo $this->get_field_id("count"); ?>">Number of tabs</label>
            <select id="<?php echo $this->get_field_id("count"); ?>" name="<?php echo $this->get_field_name("count"); ?>" value="<?php echo $instance["count"]; ?>" style="width: 100%;">
                <?php for ($i = 2; $i <= 10; $i++) :
                    $active = "";

                    if ($instance["count"] == $i) {
                        $active = "selected=\"selected\"";
                    } ?>

                    <option <?php echo $active; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </p>
        <script>
        jQuery(function($) {
            var id = "#<?php echo $this->get_field_id("count"); ?>";
            $(id).change(function() {
                $(this).closest("form").find(".widget-control-save").click();
            });
        });
        </script>
     
        <?php for ($i = 1; $i <= $instance["count"]; $i++) : ?>
            <div class="widget wpzoom-inner-widget">
                <div class="widget-top">
                    <div class="widget-title-action">
                        <a class="widget-action"></a>
                    </div>
                    <div class="widget-title">
                        <h4>Tab #<?php echo $i; ?></h4>
                    </div>
                </div>
                <div class="widget-inside">
                    <p>
                        <label for="<?php echo $this->get_field_id("tab" . $i . "-title"); ?>"><strong>Title</strong></label>
                        <input id="<?php echo $this->get_field_id("tab" . $i . "-title"); ?>" name="<?php echo $this->get_field_name("tab" . $i . "-title"); ?>" value="<?php echo $instance["tab" . $i . "-title"]; ?>" type="text" size="27"/>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id("tab" . $i . "-type"); ?>"><?php _e('Posts source:', 'wpzoom'); ?></label>
                        <select id="<?php echo $this->get_field_id("tab" . $i . "-type"); ?>" name="<?php echo $this->get_field_name("tab" . $i . "-type"); ?>" style="width:90%;">
                            <option value="cat"<?php if ($instance["tab" . $i . "-type"] == 'cat') echo ' selected="selected"'; ?>>Category(s)</option>
                            <option value="tag"<?php if ($instance["tab" . $i . "-type"] == 'tag') echo ' selected="selected"'; ?>>Tag(s)</option>
                        </select>
                    </p>
                    <p class="wpzoom_forcat">
                        <label for="<?php echo $this->get_field_id("tab" . $i . "-category"); ?>"><?php _e('Category (if selected above):', 'wpzoom'); ?></label>
                        <?php $activeoptions = $instance["tab" . $i . "-category"];

                        if (!$activeoptions) {
                            $activeoptions = array();
                        } ?>

                    <select multiple="true" id="<?php echo $this->get_field_id("tab" . $i . "-category"); ?>" name="<?php echo $this->get_field_name("tab" . $i . "-category"); ?>[]" style="width:90%; height: 100px;">
                        <?php $cats = get_categories('hide_empty=0');

                        foreach ($cats as $cat) {
                            $option = '<option value="' . $cat->term_id;

                            if (in_array($cat->term_id,$activeoptions)) {
                                $option .='" selected="selected';
                            }

                            $option .= '">';
                            $option .= $cat->cat_name;
                            $option .= ' ('.$cat->category_count.')';
                            $option .= '</option>';
                            echo $option;
                        } ?>
                    </select>
                </p>
                <p class="wpzoom_fortag">
                    <label for="<?php echo $this->get_field_id("tab" . $i . "-slugs"); ?>"><?php _e('Tag slugs (if selected above):', 'wpzoom'); ?></label>
                    <input type="text" size="27" id="<?php echo $this->get_field_id("tab" . $i . "-slugs"); ?>" name="<?php echo $this->get_field_name("tab" . $i . "-slugs"); ?>" value="<?php echo $instance["tab" . $i . "-slugs"]; ?>"  />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("tab" . $i . "-posts"); ?>"><?php _e('Posts to show:', 'wpzoom'); ?></label>
                    <select id="<?php echo $this->get_field_id("tab" . $i . "-posts"); ?>" name="<?php echo $this->get_field_name("tab" . $i . "-posts"); ?>" style="width:90%;">
                        <?php $m = 0;

                        while ($m < 20) :
                            $m++;
                            $option = '<option value="'.$m;

                            if ($m == $instance["tab" . $i . "-posts"]) {
                                $option .='" selected="selected';
                            }

                            $option .= '">';
                            $option .= $m;
                            $option .= '</option>';
                            echo $option;
                        endwhile; ?>
                    </select>
                </p>
                </div>
            </div>
        <?php endfor; 
    }
} ?>