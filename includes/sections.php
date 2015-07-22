<?php 
/**
 * Site Sections
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */ 

/**
 * Sections
 * -----------------------------------------------------------------------------
 * The eight sections of the Tuairisc site, with a ninth fallback class for
 * every other thing that does not fit neatly into these. The order of these 
 * elements is important, because this is the order in which the menu is output.
 */

class Section_Manager {
    static $instantiated = false;

    // Current site section.
    public $section = null;

    private $keys = array(
        'sections' => 'section_manager_sections',
        'menus' => 'section_manager_menus'
    );

    public function __construct($categories) {
        if (self::$instantiated) {
            // More than one running instance can lead to strange things.
            throw new Exception('Error: Section Manager can only be instantiated once.');
        }
        
        self::$instantiated = true;

        if (!is_array($categories) || empty($categories)) {
            throw new Exception('Error: An array of categories must be passed to Section Manager.');
        }

        $sections = get_option($this->keys['sections']);

        if ($categories['categories'] !== $sections['id'] || $categories['home'] !== $sections['home'] || WP_DEBUG) {
            // Update generated options and menu if sctions have changed.
            $this->sections_option_setup($categories);
            // $this->sections_menus_setup();
        }

        add_action('wp_head', array($this, 'set_current_section'));
        // add_filter('body_class', array($this, 'set_section_body_class'));
    }

    /**
     * Determine Current Section
     * -----------------------------------------------------------------------------
     * The site is segmented into n primary sections. This generates the WordPress
     * options for the site sections if the array of sections changes.
     */

    private function sections_option_setup($categories = null) {
        $sections = array(
            'id' => array(),
            'section' => array()
        );

        foreach ($categories['categories'] as $cat) {
            $category = get_category($cat);

            if (!$category) {
                if (WP_DEBUG) {
                    trigger_error(sprintf('"%s" is not a valid category and will be skipped', $cat), E_USER_WARNING);
                }

                continue;
            }

            if ($category->category_parent) {
                if (WP_DEBUG) {
                    trigger_error(sprintf('"%s" is a child category and will be skipped', $cat), E_USER_WARNING);
                }

                continue;
            }

            $sections['id'][] = $category->cat_ID;
            $sections['section'][$category->cat_ID] = $category->slug;
        }

        if (isset($categories['home']) && get_category($categories['home'])) {
            // If home is set, use it, otherwise, pick first passed category.
            $sections['home'] = $categories['home'];
        } else {
            $sections['home'] = $sections['id'][0];
        }

        update_option($this->keys['sections'], $sections);
        return $sections;
    }

    /**
     * Determine Current Section on Page Load
     * -----------------------------------------------------------------------------
     * Get the ID of the section of the site. The site is broken up into sections 
     * defined by category-one each for major categories, with a final fallback 
     * section for everything else.
     * 
     * @return  array       $current_section        ID and slug of current section.
     */

    public function set_current_section() {
        $sections = get_option($this->keys['sections']);
        $current_id = 999;

        if (is_home() || is_front_page()) {
            // 1. If home page or main index, default to first item.
            $current_id = $sections['home'];
        } else if (is_category() || is_single()) {
            // 2. Else set categroy by the parent category.
            if (is_category()) {
                $category = get_query_var('cat');
            } else if (is_single()) {
                $category = get_the_category($post->ID)[0]->cat_ID;
            }

            $category = $this->category_parent_id($category);

            if ($this->is_section_category($category)) {
                $current_id = $category;
            }

            // 3. Add more sections here if they need to be evaluated.
        } 

        $current_section = array(
            'id' => $current_id,
            'slug' => get_section_slug($current_id)
        );

        error_log(print_r($section, true));

        return $current_section;
    }

    /**
     * Is Current Category a Section?
     * -----------------------------------------------------------------------------
     * Only matches top-level categories, as it is used in circumstances where parent
     * has been already determined.
     * 
     * @param   object/id       $category       Category ID or object.
     * @return  bool                            Category is section, true/false.
     */

    private function is_section_category($category) {
        $category = get_category($category);

        if (!$category) {
            return false;
        }
        
        return (in_array($category->cat_ID, get_option($this->keys['sections'])['id']));
    }
}

/**
 * Get ID of Category's Ultimate Parent
 * -----------------------------------------------------------------------------
 * The site is sectioned into several parent categories with children and 
 * grandchildren beneath. Recursively ascend through parent categories until you
 * hit the top.
 * 
 * @param   int     $cat_id          Category ID
 * @param   int     $cat_id          ID of original category's ultimate parent.
 */

function category_parent_id($cat_id = null) {
    $category = get_category($cat_id);

    if ($category->category_parent) {
        $cat_id = category_parent_id($category->category_parent);
    }

    return $cat_id;
}

/**
 * Get Category Children IDs
 * -----------------------------------------------------------------------------
 * Return array of all category childen categories.
 *
 * @param   int/object      $category      The category.
 * @return  array           $children      Array of category children IDs.
 */

function category_children($category) {
    $category = get_category($category);

    if (!$category) {
        return null;
    }

    $children = array();
    $categories = get_categories(array('child_of' => $category->cat_ID));

    foreach($categories as $cat) {
        $children[] = $cat->cat_ID;
    }

    return $children;
}

/**
 * Get Section Slug
 * -----------------------------------------------------------------------------
 * @param   object/id       $category       Category ID or object.
 * @return  string          $slog           Slug for current section.
 */

function get_section_slug($category) {
    $slug = get_option('tuairisc_sections')['section'][$category];

    if (!$slug) {
        $slug = 'other';
    }

    return $slug;
}

/**
 * Set Body Classes
 * -----------------------------------------------------------------------------
 * Attaches to body_class. I think it's a bit mad like that WordPress doesn't
 * have an action for body_id.
 *
 * @param   array       $classes        Array of body classes.
 * @return  array       $classes        Array of body classes.
 */

function set_section_body_class($classes) {
    $section_opt = get_option('tuairisc_sections')['section'];
    $section_class = array();

    $section_class[] = 'section-';
    $section_class[] = $GLOBALS['tuairisc_section']['slug'];
    $classes[] = implode('', $section_class);

    return $classes;
}

/**
 * Setup Section Menus
 * -----------------------------------------------------------------------------
 * Save generated sections menu to site options.
 */

function sections_menus_setup() {
    $sections_opt = get_option('tuairisc_sections')['section'];
    $menus = array();

    foreach ($sections_opt as $id => $slug) {
        $menus['primary'][$slug] = generate_menu_item($id);
        
        foreach (category_children($id) as $child) {
            $menus['secondary'][$slug][] = generate_menu_item($child);
        }
    }

    update_option('tuairisc_sections_menus', $menus);
}

/**
 * Generate HTML Category List Item
 * -----------------------------------------------------------------------------
 * @param   object/int  $category       Category which needs a link.
 * @return  string  $ln                 Generated menu item.
 */

function generate_menu_item($category) {
    $category = get_category($category);

    if (!$category) {
        return;
    }

    $li = array();

    $li[] = '<li%s role="menuitem">';

    $li[] = sprintf('<a title="%s" href="%s">%s</a>',
        $category->cat_name,
        esc_url(get_category_link($category->cat_ID)),
        $category->cat_name
    );

    $li[] = '</li>';

    return implode('', $li);
}

/*
 * Output Section Menu
 * -----------------------------------------------------------------------------
 * @param   array       $args      Arguments for menu output (type and classes).
 */

function sections_menu($args) {
    $defaults = array(
        'type' => 'primary',
        'classes' => array()
    );

    $args = wp_parse_args($args, $defaults);
    // Current section.
    $section = $GLOBALS['tuairisc_section'];
    // Get menu from saved menu, and reduce secondary if called.
    $menu = get_option('tuairisc_sections_menus')[$args['type']];

    if ($args['type'] === 'secondary') {
        $menu = $menu[$section['slug']];
    }

    if (!empty($menu)) {
        foreach ($menu as $key => $item) {
            $class_attr = '';
            $classes = $args['classes'];

            if ($args['type'] === 'primary') {
                /* Primary menu items have hover and current section classes.
                 * Uncurrent-section only show section colour on hover. */
                $uncurrent = ($key !== $section['slug']) ? '-hover' : '';
                $classes[] = sprintf('section-%s-background%s', $key, $uncurrent);
            }
            
            if (!empty($classes)) {
                // Menu items are generated with '<li%s role=...'
                $class_attr = ' class="%s"';
            }

            // Put it all together and output.
            printf($item, sprintf($class_attr, implode(' ', $classes)));
        }
    }
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

?>
