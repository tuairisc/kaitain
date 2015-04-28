<?php 
/**
 * Header Social Meta Information
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 * ------------------------------
 * We tried a few different existing plugins for this, but:
 * 
 * 1. They were overly-complex for lay users to configure.
 * 2. They worked in an inconsistent and buggy manner, at best.
 * 3. The chosen one occasionally inserted annoying upsell banners. 
 */

$fallback = array(
    /* Social media (Open Graph, Twitter Cards) fallback information in cases 
     * where it may be missing. */
    'publisher' => 'https://www.facebook.com/tuairisc.ie',
    'image' => get_template_directory_uri() . '/images/tuairisc_fallback.jpg',
    'twitter' => '@tuairiscnuacht',
    'description' => 'Cuireann Tuairisc.ie seirbhís nuachta Gaeilge '
        . 'ar fáil do phobal uile na Gaeilge, in Éirinn agus thar lear. Té sé '
        . 'mar aidhm againn oibriú i gcónaí ar leas an phobail trí nuacht, '
        . 'eolas, anailís agus siamsaíocht ar ardchaighdeán a bhailiú, a '
        . 'fhoilsiú agus a chur sa chúrsaíocht.',
);

function social_meta() {
    /**
     * Output Social Meta Information 
     * ------------------------------
     * @param {none}
     * @return {none}
     */

    open_graph_meta();
    twitter_card_meta();
}

function twitter_card_meta() {
    /**
     * Output Twitter Card
     * -------------------
     * This /should/ be all of the relevant information for Twitter. 
     * 
     * @param {none}
     * @return {string} Twitter Card header meta information.
     */

    global $fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);

    $site_meta = array(
        'twitter:card' => 'summary',
        'twitter:site' => $fallback['twitter'],
        'twitter:title' => get_the_title(),
        'twitter:description' => (is_single()) ? get_the_excerpt() : $fallback['description'],
        'twitter:image:src' => (is_single()) ? get_thumbnail_url() : $fallback['image'],
        'twitter:url' => get_site_url() . $_SERVER['REQUEST_URI'],
    );

    foreach ($site_meta as $key => $value) {
        printf('<meta name="%s" content="%s">', $key, $value);
    }
}

function open_graph_meta() {
    /**
     * Output Open Graph
     * -----------------
     * This /should/ be all of the relevant information for an Open Graph 
     * scraper.
     * 
     * @param {none}
     * @return {string} Open Graph header meta information.
     */

    global $fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);
    $thumb = get_thumbnail_url($post->ID, 'full', true);

    $site_meta = array(
        'og:title' => get_the_title(),
        'og:site_name' => get_bloginfo('name'),
        'og:url' => get_site_url() . $_SERVER['REQUEST_URI'],
        'og:description' => (is_single()) ? get_the_excerpt() : $fallback['description'],
        'og:image' => (is_single()) ? $thumb[0] : $fallback['image'],
        'og:image:width' => $thumb[1],
        'og:image:height' => $thumb[2],
        'og:type' => (is_single()) ? 'article' : 'website',
        'og:locale' => get_locale(),
    );

    if (is_single()) {
        $category = get_the_category($post->ID);
        $tags = get_the_tags();
        $taglist = '';
        $i = 0;

        if (!empty($tags)) {
            foreach ($tags as $the_tag) {
                if ($i > 0) {
                    $taglist .= ', ';
                }

                $taglist .= $the_tag->name;
                $i++;
            }
        }

        $article_meta = array(
            'article:section' => $category[0]->cat_name,
            'article:publisher' => $fallback['publisher'],
            'article:tag' => $taglist,
        );

        $site_meta = array_merge($site_meta, $article_meta);
    }

    foreach ($site_meta as $key => $value) {
        printf('<meta property="%s" content="%s">', $key, $value);
    }
} ?>