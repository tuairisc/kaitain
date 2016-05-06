<?php 

/**
 * Popular Posts by View Counter
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

class Kaitain_Columnist_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_authors', 'kaitain'),
            __('Tuairisc: Author Showcase', 'kaitain'),
            array(
                'description' => __('A display of four selected authors.', 'kaitain'),
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
            'widget_title' => 'Site Authors',
            'author_list' => array(),
            'all_authors_link' => 'http://example.com/authors'
        );

        $instance = wp_parse_args($instance, $defaults);

        $exclude_users = get_option('kaitain_verboten_users');

        $site_users = get_users(array(
            'orderby' => 'nicename',
            'exclude' => $exclude_users
        ));

        ?>

        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Title:', 'kaitain'); ?></label>
            </li>
            <li>
                <?php printf('<input id="%s" name="%s" value="%s" type="text" />',
                    $this->get_field_id('widget_title'),
                    $this->get_field_name('widget_title'),
                    $instance['widget_title']);
                ?>
            </li>

            <?php for ($i = 0; $i < 4;  $i++) :
                $id = $this->get_field_id('author_list') . '-' . $i;
                $name = $this->get_field_name('author_list') . '[]';
                ?>
                <li>
                    <label for="<?php printf($id); ?>"><?php printf('%s %d', __('Author # ', 'kaitain'), $i + 1); ?></label>
                </li>
                <li>
                    <select class="columnist-widget-admin" id="<?php printf($id); ?>" name="<?php printf($name); ?>">
                        <?php foreach ($site_users as $user) {
                            printf('<option value="%s">%s</option>', $user->ID, $user->display_name);
                        } ?>
                    </select>
                </li>
            <?php endfor; ?>

            <li>
                <label for="<?php printf($this->get_field_id('all_authors_link')); ?>"><?php _e('All authors page:', 'kaitain'); ?></label>
            </li>
            <li>
                <?php printf('<input id="%s" name="%s" value="%s" type="text" />',
                    $this->get_field_id('all_authors_link'),
                    $this->get_field_name('all_authors_link'),
                    $instance['all_authors_link']);
                ?>
            </li>

        </ul>
        <script>
            // Set selected users. Cleaner than inline PHP.
            var users = <?php printf(json_encode($instance['author_list'])); ?>;
            
            jQuery.each(users, function(i, v) {
                jQuery('<?php printf('#%s-', $this->get_field_id('author_list')); ?>' + i).val(v);
            });
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

        $defaults['widget_title'] = filter_var(
            $new_defaults['widget_title'],
            FILTER_SANITIZE_STRIPPED
        );

        $defaults['author_list'] = $new_defaults['author_list'];

	$defaults['all_authors_link'] = $new_defaults['all_authors_link'];

        return $defaults;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {
        $classes = array(
            // The HTML was a gorram mess so I separated classes.
            'container' => 'widget--authors flex--four-col--div',
            'anchor' => 'green-link--hover widget--authors__author',
            'author' => 'widget--authors__author',
            'author_name' => 'widget--authors__name', //text--bold
            'avatar' => 'author-photo widget--authors__photo vspace--half'
        );

        $title = apply_filters('widget_title', $instance['widget_title']);
	$link = $instance['all_authors_link'];

        $author_query = get_users(array(
            'include' => $instance['author_list'],
        ));

        if (!empty($defaults['before_widget'])) {
            printf('%s', $defaults['before_widget']);
        }

        printf('<a href="%s">%s</a>',
		$link,
		$defaults['before_title'] . $title . $defaults['after_title']
	);

        // Wrapping interior container.
        printf('<div class="%s">', $classes['container']);

        foreach ($author_query as $author) {
            printf('<div class="%s" id="%s">',
                $classes['author'],
                'widget--authors--' . $author->user_nicename
            );

            printf('<a class="%s" title="%s" href="%s">',
                // Wrapping anchor for avatar and author name.
                $classes['anchor'],
                $author->display_name,
                get_author_posts_url($author->ID),
                $author->display_name
            ); 

            // Avatar image.
            kaitain_avatar_background_html(
                $author->ID,
                'tc_home_avatar', 
                $classes['avatar']
            );

            printf('<h5 class="%s">%s</h5>',
                // Author name.
                $classes['author_name'],
                $author->display_name
            );

            printf('</a>');
            printf('</div>');
        }

        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf('%s', $defaults['after_widget']);
        }

        printf('<hr>');

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'register_widget("Kaitain_Columnist_Widget");'));
?>
