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

function kaitain_education_section_pane($category_id_or_slug) {
    if (is_numeric($category_id_or_slug)) {
        $category = get_category($category_id_or_slug);
    } else {
        $category = get_category_by_slug($category_id_or_slug);
    }

    printf('<a class="%s %s" id="%s" href="%s">',
        'education-landing-section',
        'education-' . $category->slug,
        'education-' . $category->slug,
        get_category_link($category->cat_ID)
    );

    printf('<div class="%s">',
        'education-icon-wrapper'
    );

    printf('<div class="%s %s"></div>',
        'education-icon',
        'education-icon-' . $category->slug
    );

    printf('</div>'); // Close icon wrapper.

    printf('<div class="%s">', 'education-category-content');

    printf('<h1 class="%s">%s</h1>',
        'education-name',
        $category->cat_name
    );

    printf('<p class="%s">%s</p>',
        'education-description',
        $category->category_description
    );

    printf('</div>'); // Close rightside container.
    printf('</a>'); // Close container.
}
