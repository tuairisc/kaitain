<?php

/**
 * Education Section Custom Output and Shortcodes
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

/**
 * Education Landing Page Section Panes
 * -----------------------------------------------------------------------------
 * Output the HTML for the education section landing page.
 *
 * @param   int/string      $category_id_or_slug
 * @param   string          $class_prefix           Class prefix.
 */

function kaitain_education_section_pane($category_id_or_slug, $class_prefix = null) {
    if (is_numeric($category_id_or_slug)) {
        $category = get_category($category_id_or_slug);
    } else {
        $category = get_category_by_slug($category_id_or_slug);
    }

    if (!$class_prefix) {
        $class_prefix = 'ed-pane';
    }

    printf('<a class="%s %s" href="%s">',
        $class_prefix,
        $class_prefix . '--' . $category->slug,
        get_category_link($category->cat_ID)
    );

    printf('<div class="%s">',
        $class_prefix . '__icon-wrapper'
    );

    printf('<div class="%s %s"></div>',
        $class_prefix . '__icon',
        $class_prefix . '__icon--' . $category->slug
    );

    printf('</div>'); // Close icon wrapper.

    printf('<div class="%s">',
        $class_prefix . '__content'
    );

    printf('<h1 class="%s">%s</h1>',
        $class_prefix . '__title',
        $category->cat_name
    );

    printf('<p class="%s">%s</p>',
        $class_prefix . '__desc',
        $category->category_description
    );

    printf('</div>'); // Close rightside container.
    printf('</a>'); // Close container.
}

/**
 * Education Banner Shortcode
 * -----------------------------------------------------------------------------
 * Generate either a tall or short dividing subheading banners for within 
 * education section posts.
 * 
 * @param   array       $attributes         Shortcode attributes.
 * @param   string      $content            Banner message.
 * @return  string      $banner             Dividing banner.
 */

function kaitain_education_banner_shortcode($args, $content = null) {
    $args = shortcode_atts(array('type' => 'main'), $args);

    // Headline, <h2> or <h3>
    $headline_type = ($args['type'] === 'main') ?  2 : 3;
    $headline_class = 'education-banner';

    if (!$content) {
        $content = __('Did you forget to include text?', 'kaitain');
    }

    if ($args['type'] !== 'main') {
        // If the banner is not 'main', change h2 to h2 and heading to subheading.
        $headline_class .= '-subheading';
    }

    $banner = sprintf('<h%s class="%s">%s</h%s>', 
        $headline_type,
        $headline_class,
        $content,
        $headline_type
    );

    return $banner;
}

add_shortcode('banner', 'kaitain_education_banner_shortcode');
