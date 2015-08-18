<?php 

/**
 * Popular Posts by View Counter
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

class tuairisc_authors extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('tuairisc_authors', TTD),
            __('Tuairisc: Author Showcase', TTD),
            array(
                'description' => __('A display of four selected Tuairisc authors.', TTD),
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
        );

        $instance = wp_parse_args($instance, $defaults);

        $site_users = get_users(array(
            'orderby' => 'nicename',
            'exclude' => array(4, 37)
        ));

        ?>

        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('widget_title')); ?>"><?php _e('Title:', TTD); ?></label>
            </li>
            <li>
                <?php printf('<input id="%s" name="%s" value="%s" type="text" />', $this->get_field_id('widget_title'), $this->get_field_name('widget_title'), $instance['widget_title']); ?>
            </li>

            <?php for ($i = 0; $i < 4;  $i++) :
                $id = $this->get_field_id('author_list') . '-' . $i;
                $name = $this->get_field_name('author_list') . '[]';
                ?>
                <li>
                    <label for="<?php printf($id); ?>"><?php _e('Author #' . ($i + 1), TTD); ?></label>
                </li>
                <li>
                    <select class="author-widget-admin" id="<?php printf($id); ?>" name="<?php printf($name); ?>">
                        <?php foreach ($site_users as $user) {
                            printf('<option value="%s">%s</option>', $user->ID, $user->display_name);
                        } ?>
                    </select>
                </li>
            <?php endfor; ?>
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

        $defaults['widget_title'] = filter_var($new_defaults['widget_title'], FILTER_SANITIZE_STRIPPED);
        $defaults['author_list'] = $new_defaults['author_list'];

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

        $author_query = get_users(array(
            'include' => $instance['author_list'],
        ));

        if (!empty($defaults['before_widget'])) {
            printf('%s', $defaults['before_widget']);
        }

        $avatar = get_avatar_background($author, 'tc_home_author');

        $classes = array(
            // The HTML was a gorram mess so I separated classes.
            'anchor' => array(
                'green-link-hover',
                'tuairisc-author',
            ),
            'div' => array(
                'tuairisc-author-list',
                'home-flex-row'
            ),
            'title' => array(
                'widget-title'
            ),
            'author' => array(
                'author-name'
            )
        );

        printf('<h3 class="%s">%s</h3>',
            implode(' ', $classes['title']),
            apply_filters('widget_title', $instance['widget_title'])
        );

        // Wrapping interior container.
        printf('<div class="%s">', implode(' ', $classes['div']));


        foreach ($author_query as $author) {
            avatar_background($author->ID, 'tc_home_avatar', 'author-photo');

            printf('<a class="%s" title="%s" href="%s" id="%s">',
                // Wrapping anchor for avatar and author name.
                implode(' ', $classes['anchor']),
                $author->display_name,
                $author->ID,
                $author->user_nicename
            ); 

            printf('<h6 class="%s">%s</h6>',
                // Author name.
                implode(' ', $classes['author']),
                $author->display_name
            );

            printf('</a>');
        }

        printf('</div>');

        if (!empty($defaults['after_widget'])) {
            printf('%s', $defaults['after_widget']);
        }

        printf('<hr>');

        wp_reset_postdata();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("tuairisc_authors");'));

?>
