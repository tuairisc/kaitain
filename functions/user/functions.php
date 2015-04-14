<?php

/**
 * The Glorious Tuairisc Functions
 * -------------------------------
 * Except for the files included in the head, this represents most of the PHP 
 * work on the Tuairisc site. 
 * 
 * @category   WordPress File
 * @package    Tuairisc.ie Gazeti Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2014-2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

$banners = array(
    /* Classes and the current category ID for the Greann category, which has
     * a different banner style. */
    'classes' => array(
        /* See $banner_colours: If the correct colour-from-ID can't be 
         * determined by category ID, then consult this array for the ID to 
         * use. */
        'normal', 'greann'
    ),
    'greann_cat' => 158,
);

$irish_calendar_terms = array(
    'days' => array(
        'Dé Luain', 'Dé Máirt', 'Dé Céadaoin', 'Déardaoin', 'Dé hAoine', 
        'Dé Sathairn', 'Dé Domhnaigh'
    ),
    'months' => array(
        'Eanáir', 'Feabhra', 'Márta', 'Aibreán', 'Bealtaine', 'Meitheamh',
        'Iúil', 'Lúnasa', 'Meán Fómhair', 'Deireadh Fómhair', 'Samhain', 
        'Nollaig'
    )
);

/* This is the author account used for small or generic posts on the Tuairisc 
 * site. By default Sean does not want any attribution to appear for them. */
$default_author_id = 37;

$education_categories = array(
    /* There are five sub-categories within the education category, 187 being
     * the parent. */
    187, 202, 203, 204, 205, 206
);

$custom_post_types = array(
    // All custom post types declared and used in this theme.
    'foluntais'
);

$custom_post_fields = array(
    // All important custom fields.
    'tuairisc_view_counter'
);

$index_excluded_categories = array(
    // Categories specified for exclusion from index loop display.
    216, 182
);

$tuairisc_scripts = array(
    /* All JavaScript loaded by me for the theme.
     * Path is $theme_folder/js/tuairisc/ */
    'modernizr' => '/modernizr_touch.min.js',
    'tuairisc-browser-detect' => '/browser_detect.min.js',
    'tuairisc-adrotate-fallback' => '/adrotate.min.js',
    'tuairisc-eventdrop' => '/eventdrop.min.js',
    'tuairisc-functions' => '/functions.min.js',
    'tuairis-author-report' => '/author_report.min.js'
);

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

/*
 * Tuairisc Custom PHP Scripts and Widgets
 * ---------------------------------------
 */

$widget_path = get_template_directory() . '/functions/user/';
require_once($widget_path . 'tuairisc-authors.php');
require_once($widget_path . 'tuairisc-mostviewed.php');
require_once($widget_path . 'tuairisc-jobs.php');

/*
 * Functions
 * ---------
 */

function tuairisc_scripts() {
    /** 
     * Load Tuairisc JavaScript
     * ------------------------
     * Load all theme JavaScript.
     * 
     * @param {none}
     * @return {none}
     */

    global $tuairisc_scripts;
    $path = get_stylesheet_directory_uri() . '/js/tuairisc';

    foreach ($tuairisc_scripts as $key => $value) {
        wp_enqueue_script($key, $path . $value, array(), '1.0', true);
    }
}

function tuairisc_styles() {
    /**
     * Load Tuairisc Custom Styles
     * ---------------------------
     * Load all theme CSS.
     * 
     * @param {none}
     * @return {none}
     */
}

function get_banner_breadcrumb() {
    /** 
     * Get Post or Archive Banner
     * --------------------------
     * This returns the appropriate set of breadcrumb links for the given 
     * category/single post. Breadcrumb links are created in three different 
     * ways:
     * 
     * 1. Single, categorized posts and archive pages use get_category_parents
     * 2. The Greann category archive pages uses the category's description. 
     * 3. Foluntais posts use get_job_category_link. 
     * 
     * Breadcrumbs are a pain in the ass. 
     *
     * @param {none}
     * @return {none}
     */

    global $banners, $custom_post_types;
    $breadcrumb = '';
 
    if (has_category($banners['greann_cat'])) {
        // 1. Greann category post.
        $breadcrumb = '<span>' .  category_description($greann) . '</span>';
    } else if (!is_custom_type()) {
        // 2. Non-Foluntais posts and archives.
        $breadcrumb = generate_breadcrumbs();
    } else {
        // 3. Foluntais custom type archive, category archive and single posts.
        $breadcrumb = generate_job_breadcrumbs();
    }

    printf($breadcrumb);
}

function generate_breadcrumbs() {
    /** 
     * Generate Breadcrumbs
     * -------------------- 
     * Generate the breadcrumb trail for non-foluntais single posts and post 
     * archives.
     * 
     * @param {none}
     * @return {string} Breadcrumb trail for category-> parent category.
     */

    if (is_category()) {
        // Non-foluntais archive.
        $category = get_query_var('cat');
    } else {
        // Non-foluntais single.
        $category = get_the_category();
        $category = $category[0]->cat_ID;
    }

    return get_category_parents($category, true, '&nbsp;');
}

function banner_classes() {
    /**
     * Return Unique Banner Class
     * --------------------------
     * Despite different colours, there are only two CSS styles:
     * 
     * 1. Narrow width banner wih left-aligned breadcrumb.
     * 2. Wide Greann banner with the Greann logo.
     * 
     * This returns the correct CSS class.
     * 
     * @param {none}
     * @return {string} $banner_classes CSS classes for banner.
     */

    global $banners;

    $banner_classes = array(
        'breadcrumb-banner ',
        'banner-'
    );

    if (has_category($banners['greann_cat'])) {
        $banner_classes[] = $banners['classes'][1];
    } else {
        $banner_classes[] = $banners['classes'][0];
    }

    if (is_category()) {
        // Coloured banners only for categories.
        $category = get_category(get_query_var('cat'));
        $banner_classes[] = ' category-';

        if ($category->category_parent > 0) {
            $banner_classes[] = $category->category_parent;
        } else {
            $banner_classes[] = $category->cat_ID;
        }
    }

    return implode('', $banner_classes);
}

function get_thumbnail_url($post_id = null, $thumb_size = null, $return_arr = false) {
    /** 
     * Return Thumbnail Image URL
     * --------------------------
     * Taken from: http://goo.gl/NhcEU6
     * 
     * WordPress, by default, only has a handy function to return a glob of HTML
     * -an image inside an anchor-for a post thumbnail. This wrapper extracts
     * and returns only the URL.
     * 
     * @param {int} $post_id The ID of the post.
     * @param {int} $thumb_size The requested size of the thumbnail.
     * @param {bool} $return_arr Return either the entire thumbnail object or just the URL.
     * @return {string} $thumb_url[0] URL of the thumbnail.
     * @return {array} $thumb_url All information on the attachment.
     */

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    if (is_null($thumb_size)) {
        $size = 'large';
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id, $thumb_size, true);
    return ($return_arr) ? $thumb_url : $thumb_url[0];
}

function remove_read_more($excerpt) {
    /** 
     * Remove Excerpt Read More Link
     * -----------------------------
     * @param {string} $excerpt The post excerpt.
     * @return {string} $excerpt THe post excerpt sans the read more link.
     */

    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

function replace_excerpt_breaks($excerpt) {
    /** 
     * Replace Excerpt Break Tags
     * --------------------------
     * Replace break tags in an excerpt with a paragaraph tag. The excerpt will
     * already have an opening and closing <p></p> tags.
     * 
     * @param {string} $excerpt The post excerpt.
     * @return {string} $excerpt The post excerpt.
     */

    return str_replace('<br />', '</p><p>', $excerpt);
}

function get_avatar_url($user_id = null, $avatar_size = null) {
    /**
     * Return URL of User Avatar 
     * -------------------------
     * WordPress does not provide an easy way to access only the URL of the 
     * user's avatar, hence this.
     * 
     * @param {int} $user_id The ID of the user.
     * @param {int} $avatar_size Size of the avatar to be returned.
     * @return {string} $avatar_url The URL of the avatar. 
     */

    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    if (is_null($avatar_size)) {
        $avatar_size = 100;
    }

    $avatar_url = get_avatar($user_id, $avatar_size);
    $avatar_url = preg_replace('/(^.*src="|".*$)/', '', $avatar_url);
    return $avatar_url;
}

function has_local_avatar($user_id = null) {
    /**
     * Check Avatar Source
     * -------------------
     * WordPress fetches avatars by sending the user's email to Gravatar. The 
     * plugin 'WP User Avatar' allows you to upload and serve avatars locally.
     * 
     * Gravatar is treated as a fallback from this. The preference from Sean is
     * that /only/ local avatars should be shown.
     * 
     * @param {int} $user_id
     * @return {bool} $avatar_is_local
     */

    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    $avatar_is_local = (strpos(get_avatar_url($user_id), 'gravatar') === false);

    return $avatar_is_local;
}

function is_default_author($author_id = null) {
    /**
     * Identify Site Default Author
     * ----------------------------
     * Certain articles are written on behalf of the site without attribution to
     * a specific author-recycled articles and press releases are typical of 
     * such posts.
     * 
     * Sean does not want any attribution for this account to appear at or above
     * these articles.
     * 
     * @param {int} $author_id
     * @return {bool} $is_default_account
     */

    global $default_author_id;

    if (is_null($author_id)) {
        $author_id = get_the_author_meta('ID');
    }

    $is_default_account = ($author_id === $default_author_id);
    return $is_default_account;
}

function translate_day_to_irish($day) {
    /**
     * Translate Day to Irish
     * ----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     * 
     * @param {string} $day The day in English.
     * @return {string} $day The day in Irish.
     */

    global $irish_calendar_terms;

    switch ($day) {
        case 'Monday': $day = $irish_calendar_terms['days'][0]; break;
        case 'Tuesday': $day = $irish_calendar_terms['days'][1]; break;
        case 'Wednesday': $day = $irish_calendar_terms['days'][2]; break;
        case 'Thursday': $day = $irish_calendar_terms['days'][3]; break;
        case 'Friday': $day = $irish_calendar_terms['days'][4]; break;
        case 'Saturday': $day = $irish_calendar_terms['days'][5]; break;
        case 'Sunday': $day = $irish_calendar_terms['days'][6]; break;
    }

    return $day;
}

function translate_month_to_irish($month) {
    /**
     * Translate Day to Irish
     * ----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     * 
     * @param {string} $month The month in English.
     * @return {string} $month The month in Irish.
     */

    global $irish_calendar_terms;

    switch ($month) {
        case 'January': $month = $irish_calendar_terms['months'][0]; break;
        case 'February': $month = $irish_calendar_terms['months'][1]; break;
        case 'March': $month = $irish_calendar_terms['months'][2]; break;
        case 'April': $month = $irish_calendar_terms['months'][3]; break;
        case 'May': $month = $irish_calendar_terms['months'][4]; break;
        case 'June': $month = $irish_calendar_terms['months'][5]; break;
        case 'July': $month = $irish_calendar_terms['months'][6]; break;
        case 'August': $month = $irish_calendar_terms['months'][7]; break;
        case 'September': $month = $irish_calendar_terms['months'][8]; break;
        case 'October': $month = $irish_calendar_terms['months'][9]; break;
        case 'November': $month = $irish_calendar_terms['months'][10]; break;
        case 'December': $month = $irish_calendar_terms['months'][11]; break;
    }

    return $month;
}

function translate_date_to_irish($the_date) {
    /**
     * Translate Date to Irish 
     * -----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     *
     * @param {string} $the_date
     * @return {string} $the_date
     */

    $english_month = '';
    $english_day = '';
    $irish_day = '';
    $irish_month = '';

    $day_regex = '/(,.*)/';
    $month_regex = '/(^.*, | [0-9].*$)/'; 


    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);

    $irish_day = translate_day_to_irish($english_day);
    $irish_month = translate_month_to_irish($english_month);

    $the_date = str_replace($english_day, $irish_day, $the_date);
    $the_date = str_replace($english_month, $irish_month, $the_date);
    return $the_date;
}

function education_landing_shortcode($atts) {
    /**
     * Education Landing Shortcode
     * ---------------------------
     * The education landing page links through to the five different segments. 
     * These are boxy clickable boxes complete with title and description.
     *
     * @param {array} $attributes Shortcode values.
     * @return {string} $education
     */

    global $education_categories;
    $shortcode_atts = shortcode_atts(array('id' => 0), $atts);
    $category_id = '';
    $education_html = '';

    // Change $id to 0 if it falls outside 0-5 range. 
    if ($shortcode_atts['id'] < 0 || $shortcode_atts['id'] > 5) {
        $category_id = $education_categories[0];
    } else {
        $category_id = $education_categories[$shortcode_atts['id']];
    }

    $education_html = '<div class="education-box education-'
        . $category_id . '"><a href="' . get_category_link($category_id) 
        . '"><p><span>' . get_cat_name($category_id) . '</span><br />' 
        . category_description($category_id) . '</a></p></div>';

    return $education_html;
}

function education_banner_shortcode($attributes, $content = null) {
    /**
     * Education Banner Shortcode
     * --------------------------
     * Generate either a tall or short dividing subheading banners for within 
     * education section posts.
     * 
     * @param {array} $attributes Shortcode attributes.
     * @param {string} $content Banner message.
     * @return {string} $banner Dividing banner.
     */

    $banner = array();
    // h2
    $headline_type = 2;
    $headline_class = 'edu-heading';
    $shortcode_atts = shortcode_atts(array('type' => 'main'), $attributes);

    if (is_null($content)) {
        $content = 'Did you forget to include text?';
    }

    if ('main' !== $shortcode_atts['type']) {
        // If the banner is not 'main', change h2 to h2 and heading to subheading.
        $headline_type = 3;
        $headline_class = str_replace('-h', '-subh', $headline_class);
    }

    $banner[] = '<h' . $headline_type . ' class="' . $headline_class . '">';
    $banner[] = $content;
    $banner[] = '</h' . $headline_type . '>';

    return implode('', $banner);
}

function author_is_columnist($author_id = null) {
    /**
     * Parse User Role
     * ---------------
     * Sean wished to flag certain users are site columnists. This flag is set
     * as a 'yes' through extra user fields.
     * 
     * @param {int} $author_id ID of the author.
     * @return {bool} $is_columnist Is user a columnist true/false.
      */

    if (is_null($author_id)) {
       $author_id = get_the_author_meta('id');
    }

    $meta_tag = get_the_author_meta('columnist', $author_id);
    $is_columnist = false;

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);
        $is_columnist = ($meta_tag === 'yes');
    } 

    return $is_columnist;
}

function is_columnist_article() {
    /**
     * Article-is-Column
     * -----------------
     * Identiy whether an article is part of an ongoing column, as set through
     * post custom fields.
     * 
     * @param {none}
     * @return {bool} $is_column Is article a column piece true/false.
     */

    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);
    $is_column = ($col_article === '1');

    return $is_column;
}

function tweak_title($title, $sep) {
    /**
     * Title Tweak
     * -------------
     * Customize the title format so it looks like:
     *  site_title | section_title 
     * 
     * @param {string} $title Item title.
     * @param {string} $sep Separator between title words.
     * @return {string} $title
     */

    $title = str_replace($sep, '', $title); 

    if (!is_home()) {
        $title = preg_replace('/^/', ' ' . $sep . ' ', $title);
        $title = preg_replace('/^/', bloginfo('name'), $title);
    }

    return $title;
}

function is_excluded_category() {
    /** 
     * Index Category Exclusion
     * ------------------------
     * Global exclusion and different treatment of the job categories were 
     * requested by Ciaran and Sean. The currently excluded categories are: 
     * 
     * # Category Name               Category ID
     * -----------------------------------------
     * 1 Imeachtaí                   182  
     * 2 Fógraí Poiblí/Folúntais     216   
     * 
     * I can exclude categories from post display with WP_Query, but these
     * exclusions are more nuanced, in that we want to both change how the 
     * categories are styled in the loop or exclude it entirely.
     * 
     * @param {none}
     * @return {bool} Article is in excluded category true/false.
     */

    global $index_excluded_categories;

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $index_excluded_categories)) {
            return true;
        }
    }

    return false;;
}

function get_view_count($post_id = null) {
    /**
     * Fetch Article View Count
     * ------------------------
     * @param {int} $post_id
     * @return {int} $count Post view count.
     */

    global $custom_post_fields;

    if (is_null($post_id)) {
        return;
    }

    $key = $custom_post_fields[0];
    $count = (int) get_post_meta($post_id, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post_id, $key, 0);
        return 0;
    }

    return $count;
}

function increment_view_counter($post_id = null) {
    /**
     * Increment Post View Count
     * -------------------------
     * Requested by Sean. If post is not of custom type and viewer is not logged
     * in, then increment counter by +1.
     *  
     * @param {int} $post_id
     * @return {none}
     */

    global $custom_post_fields;

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    if (!is_custom_type() && !is_user_logged_in()) {
        $key = $custom_post_fields[0];
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

/*
 * Debug and Helpers
 * -----------------
 */

function list_post_types() {
    /**
     * Dump Post Types to JavaScript Console
     * -------------------------------------
     * Useful for debug on occasion. 
     * 
     * @param {none}
     * @return {none}
     */
    
    $type_args = array(
        'public' => true,
        '_builtin' => false
    );

    $output = 'names';
    $operator = 'and';
    $post_types = get_post_types($type_args, $output, $operator); 

    foreach ($post_types as $post_type) {
        printf('<script>console.log("%s");</script>', $post_type);
    }
}

function is_custom_type() {
    /**
     * Evaluate Post Type 
     * ------------------
     * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
     * type.
     * 
     * @param {none}
     * @return {bool} Whether the post is of a custom type true/false.
     */

    global $custom_post_types;
    return (in_array(get_post_type(), $custom_post_types));
}

function is_custom_type_singular() {
    /**
     * Evaluate Post Type 
     * ------------------
     * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
     * type.
     * 
     * @param {none}
     * @return {bool} Whether the post is of a custom type true/false.
     */

    global $custom_post_types;
    return (in_array(get_post_type(), $custom_post_types) && is_singular($custom_post_types));
}

/*
 * Header Social Meta Information
 * ------------------------------
 * We tried a few different existing plugins for this, but:
 * 
 * 1. They were overly-complex for lay users to configure.
 * 2. They worked in an inconsistent and buggy manner, at best.
 * 3. The chosen one occasionally inserted annoying upsell banners. 
 */

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
}

// Change large size to match post content width.
update_option('large_size_w', 770);
// Load JavaScript scripts. 
add_action('wp_enqueue_scripts', 'tuairisc_scripts');
add_action('wp_enqueue_scripts', 'tuairisc_styles');
// Rearrange title.
add_filter('wp_title', 'tweak_title', 10, 2);
// Remove read more links from excerpts.
add_filter('the_excerpt', 'remove_read_more');
add_filter('the_excerpt', 'replace_excerpt_breaks');
// Add shortcode for landing.
add_shortcode('landing', 'education_landing_shortcode');
// Add shortcode for education banners.
add_shortcode('banner', 'education_banner_shortcode');
// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));
// Filter date to return as Gaeilge.
add_filter('get_the_date', 'translate_date_to_irish');
add_filter('get_comment_date', 'translate_date_to_irish');

?>