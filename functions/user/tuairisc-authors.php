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
        $title = apply_filters('widget_title', $instance['widget_title']);

        $author_query = get_users(array(
            'orderby' => 'post_count',
            'order' => 'DESC',
            'include' => $instance['author_list'],
        ));

        if (!empty($args['before_widget'])) {
            echo $before_widget;
        } ?>

        <div class="tuairisc-author-list self-clear">
            <?php printf('<h2>%s</h2>', apply_filters('widget_title', $instance['widget_title']));
            
            foreach ($author_query as $author) {
                printf('<div class="tuairisc-author">');
                printf('<div class="avatar" style="background-image: url(%s);"></div>', get_avatar_url($author->ID));
                printf('<h6>%s</h6>', $author->display_name);
                printf('</div>');
            } ?>
        </div>

        <?php echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['widget_title'] = strip_tags($new_instance['widget_title']);
        $instance['author_list'] = $new_instance['author_list'];
        return $instance;
    }

    public function form($instance) {
        $defaults = array(
            'widget_title' => 'Site Authors',
            'author_list' => array(),
        );

        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
        $author_query = get_users(array('orderby' => 'nicename'));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label><br />
            <input id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $instance['widget_title']; ?>" type="text"  class="widefat" />
        </p>
        <?php for ($i = 0; $i < 4;  $i++) : ?>
            <p>
                <label for="<?php echo $this->get_field_id('author_list'); ?>"><?php _e('Author #' . ($i + 1), 'wpzoom'); ?></label><br />
                <select class="author-widget-admin" name="<?php echo $this->get_field_name('author_list') . '[]'; ?>">
                    <option disabled <?php echo ($author_list[$i] === '') ? 'selected' : ''; ?>>

                    <?php foreach ($author_query as $author) : ?>
                        <option value="<?php echo $author->id; ?>" <?php echo ($author_list[$i] == $author->id) ? 'selected' : ''; ?>>
                            <?php echo $author->display_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
        <?php endfor; ?>
        <style>
            .author-widget-admin {
                border: 1px solid #DFDFDF;
                box-sizing: border-box;
                height: 150px;
                overflow-y: scroll;
                padding: 5px;
            }
        </style>
        <?php
    }
}

add_action('widgets_init',
    create_function('', 'return register_widget("tuairisc_author_list");')
);
?>