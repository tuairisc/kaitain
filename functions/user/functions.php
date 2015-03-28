<?php

/* You can add custom functions below, in the empty area
=========================================================== */

// Load custom Tuairisc widgets.
$widget_path = get_template_directory() . '/functions/user/';
require_once $widget_path . 'tuairisc-authors.php';
require_once $widget_path . 'tuairisc-mostviewed.php';
// Load jobs
require_once $widget_path . 'tuairisc-jobs.php';

/* 
 * # Category Name   Hex Colour  Category ID
 * -----------------------------------------
 * 1 Nuacht          #516671     191  
 * 2 Tuairmíocht     #8eb2d3     154   
 * 3 Spoirt          #c54b54     155
 * 4 Cultúr          #96c381     156
 * 5 Saol            #e04184     157
 * 6 Pobal           #7d5e90     159
 * 7 Greann          #e6192a     158
 * 8 Foghlaimeoirí   #d4bb85     187 
 */

$banner_colors = array(
    // Categories
    154 => '#8eb2d3',
    155 => '#c54b54',
    156 => '#96c381',
    157 => '#e04184',
    158 => '#e6192a',
    159 => '#7d5e90',
    187 => '#424045',
    191 => '#516671',
    // Custom foluntais
    224 => '#9ac485',
    225 => '#90b5d2',
    // Foluntais fallback
    799 => '#424045',
    // Single posts
    899 => '#000',
    // Fallback
    999 => '#c7c009',
);

/* Script Loading
 * ---------------
 * Load /all/ the things! */

function tuairisc_scripts() {
    /* This handles loading for all of the custom scripts used in the theme. */
    // Über-crude operating system and browser detection using user agent strins.
    wp_enqueue_script('tuairisc-browser-detect', get_stylesheet_directory_uri() . '/js/tuairisc_browser_detect.js', array(), '1.0', true);
    // Styling and loading for jQuery scripts.
    wp_enqueue_script('tuairisc-adrotate', get_stylesheet_directory_uri() . '/js/tuairisc_adrotate.js', array('jquery'), '1.0', true);
    // Event parser.
    wp_enqueue_script('tuairisc-eventdrop', get_stylesheet_directory_uri() . '/js/tuairisc_eventdrop.js', array('jquery'), '1.0', true);
    // Some styling isn't handled correctly by CSS.
    wp_enqueue_script('tuairisc-functions', get_stylesheet_directory_uri() . '/js/tuairisc_functions.js', array('jquery'), '1.0', true);
    // Modernizr, for menu touch events.
    wp_enqueue_script('tuairisc-modernizr', get_stylesheet_directory_uri() . '/js/tuairisc_modernizr_touch.js', array('jquery'), '1.0', true);
    // Emer's author report
    wp_enqueue_script('tuairisc-author-report', get_stylesheet_directory_uri() . '/js/tuairisc_author_report.js', array('jquery'), '1.0', true);
}

function tuairisc_styles() {
    /* This handles loading for all of the custom stylesheets used 
     * throughout the theme. */ 
}

/* Breadcrumb Banners
 * ------------------
 * These were a requested feature on the site. */

function get_parent_id($cat_id = null) {
    /* Return the ID of the top parent of any category. */

    if ('' == $cat_id) {
        $cat_id = get_query_var('cat');
    }

    $parent = get_category_parents($cat_id, false, '/'); 
    $parent = preg_replace('/\/.*/', '', $parent); 
    return get_cat_id($parent); 
}

function get_breadcrumb() {
    /* This returns the appropriate set of breadcrumb links for the given 
     * category/single post. Breadcrumb links are created in three different 
     * ways:
     * 
     * 1. Single, categorized posts and archive pages use get_category_parents
     * 2. The Greann category archive pages uses the category's description. 
     * 3. Foluntais posts use get_job_category_link. */

    if (is_category() && !is_greann() || is_singular('post') && has_category()) {
        $id = get_the_category();
        echo get_category_parents($id[0]->cat_ID, true, '&nbsp;');
    } else if (is_category() && is_greann()) {
        echo '<span>' . category_description() . '</span>';
    } else if (is_singular('foluntais')) {
        get_job_category_link($post_id, true, '&nbsp;');
    } else if (is_job()) {
        get_job_category_link($post_id, false, '&nbsp;');
    }
}

function is_greann() {
    /* The Greann category has a unique breadcrumb style, to differentiate it 
     * with other, more serious, segments of the website. */

    if (is_category()) {
        $cat_id = get_parent_id(get_query_var('cat'));
    } else if (is_single() && has_category()) {
        $cat_id = get_the_category();
        $cat_id = $cat[0]->cat_ID;
    }

    return ($cat_id == 158) ? true : false;
}

function breadcrumbs_get_id() {
    /* Three objects have banners:
     *
     * 1. Single posts
     * 2. Single foluntais listings
     * 3. Category archives
     *
     * get_id figures out which is which and returns the appropriate ID. Dirty 
     * shorthand until I have a better solution. */

    if (is_singular('post') && has_category()) {
        $id = get_the_category();
        $id = $id[0]->cat_ID;

        if ($id == 158) {
            return $id;
        } else {
            $id = 899;
        }
    } else if (is_category()) {
        $id = get_parent_id(get_query_var('cat'));
    } else if (is_job()) {
        $id = 799;
    } else {
        return;
    }

    return $id;
}

function get_banner_color() {
    /* Return a unique colour for each given parent category. */

    global $banner_colors;
    $color = '';
    $id = breadcrumbs_get_id();

    if (array_key_exists($id, $banner_colors)) {
        $color = $banner_colors[$id];
    } else {
        $color = $banner_colors[999];
    }

    echo 'background-color: ' . $color . ';';
}

function banner_class() {
    /* Some banners have custom CSS styles attached. 
     * This function looks at the ID and type of object and returns
     * the custom class, should it exist. */

    $classes = array(
        158 => 'greann',
        899 => 'banner-post',
    );

    $class = '';
    $id = breadcrumbs_get_id();

    if (is_greann() && array_key_exists($id, $classes)) {
        $class = $classes[$id];
    } else {
        $class = $classes[899];
    }

    echo $class;
}

/* 'Hero'-style Posts 
 * ------------------
 * The first post on the each page of the category display has a different, custom
 * style. */

function hero_post_class() {
    /* If the lead post has thumbnail images, mark it as a 'hero' post, whose 
     * style is very different than other posts in the cateory loop. */

    return (has_post_thumbnail()) ? 'hero-post' : '';
}

function get_thumbnail_url($post_id = null, $size = null, $arr = false) {
    /* Code snippet from http://goo.gl/NhcEU6
     * get_thumbnail_url returns the anchor url for the requested thumbnail. */

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if ('' == $size) {
        $size = 'large';
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id, $size, true);
    return ($arr) ? $thumb_url : $thumb_url[0];
}

function remove_read_more($excerpt) {
    /* Remove the read more link from page and post excerpts. */

    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

function replace_breaks($excerpt) {
    /* Replace <br /> tags in excerpts with <p>. 
     * Excerpt are used site-wide as a 'blurb' for posts. */

    return str_replace('<br />', '</p><p>', $excerpt);
}

function get_avatar_url($user_id = null, $size = null) {
    /* Return the hyperlink for the given avatar, without the <img /> code. */

    if ('' == $user_id) {
        $user_id = get_the_author_meta('ID');
    }

    if ('' == $size) {
        $size = 100;
    }

    $avatar_url = get_avatar($user_id, $size);
    return preg_replace('/(^.*src="|".*$)/', '', $avatar_url);
}

function has_local_avatar($user_id = null) {
    /* This site uses 'WP USer Avatar' for avatar control.
     * It serves avatars in this priority:
     *  
     * 1. Local user avatar
     * 2. Gravatar user avatar
     * 3. Gravatar stock avatar
     * 
     * I need to see if a local avatar is served and switch based on it.
     * This function checks to see if the avatar is being served from the local 
     * site. */

    if ('' == $user_id) {
        $user_id = get_the_author_meta('ID');
    }

    return (strpos(get_avatar_url($user_id), 'gravatar') == false);
}

function day_to_irish($day) {
    /* day_to_irish returns the Irish translation of the day. */

    $irish_days = array(
        'Dé Luain', 'Dé Máirt', 'Dé Céadaoin', 'Déardaoin', 
        'Dé hAoine', 'Dé Sathairn', 'Dé Domhnaigh'
    ); 

    switch ($day) {
        case 'Monday': 
            $day = $irish_days[0]; break;
        case 'Tuesday': 
            $day = $irish_days[1]; break;
        case 'Wednesday': 
            $day = $irish_days[2]; break;
        case 'Thursday': 
            $day = $irish_days[3]; break;
        case 'Friday': 
            $day = $irish_days[4]; break;
        case 'Saturday': 
            $day = $irish_days[5]; break;
        case 'Sunday': 
            $day = $irish_days[6]; break;
        default: break;
    }

    return $day;
}

function default_author($author_id = null) {
    /* The UID for the admin account is 37. If the article's author is the
     * 'site', then neither Ciaran nor Sean want the author's name to appear. */

    if ('' == $author_id) {
        $author_id = get_the_author_meta('ID');
    }

    $default_author = 37;
    return ($author_id == $default_author);
}

function month_to_irish($month) {
    /* month_to_irish returns the Irish translation of the month. */

    $irish_months = array(
        'Eanáir', 'Feabhra', 'Márta', 'Aibreán', 
        'Bealtaine', 'Meitheamh', 'Iúil', 'Lúnasa', 
        'Meán Fómhair', 'Deireadh Fómhair', 'Samhain', 'Nollaig'
    );

    switch ($month) {
        case 'January': 
            $month = $irish_months[0]; break;
        case 'February': 
            $month = $irish_months[1]; break;
        case 'March': 
            $month = $irish_months[2]; break;
        case 'April': 
            $month = $irish_months[3]; break;
        case 'May': 
            $month = $irish_months[4]; break;
        case 'June': 
            $month = $irish_months[5]; break;
        case 'July': 
            $month = $irish_months[6]; break;
        case 'August': 
            $month = $irish_months[7]; break;
        case 'September': 
            $month = $irish_months[8]; break;
        case 'October': 
            $month = $irish_months[9]; break;
        case 'November': 
            $month = $irish_months[10]; break;
        case 'December': 
            $month = $irish_months[11]; break;
        default: 
            break;
    }

    return $month;
}

function date_to_irish($the_date) {
    /* Localization attempts fell short as date localization requires files on 
     * the server. */

    $day_regex = '/(,.*)/';
    $month_regex = '/(^.*, | [0-9].*$)/'; 

    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);
    $irish_day = day_to_irish($english_day);
    $irish_month = month_to_irish($english_month);

    $the_date = str_replace($english_day, $irish_day, $the_date);
    $the_date = str_replace($english_month, $irish_month, $the_date);
    return $the_date;
}

function education_category_id($id) {
    /* Used for eduation_landing_shortcode below. Users cannot be expected to 
     * know the actual category. */

    switch ($id) {
        case 1: 
            $id = 202; break;
        case 2: 
            $id = 203; break;
        case 3: 
            $id = 204; break;
        case 4: 
            $id = 205; break;
        case 5: 
            $id = 206; break;
        default: 
            $id = 187; break;
    }

    return $id;
}

function education_landing_shortcode($atts) {
    /* The education landing page links through to the five different segments. 
     * These are boxy clickable boxes complete with title and description. */

    $a = shortcode_atts(array('id' => 0), $atts);
    // Change $id to 0 if it falls outside 0-5 range. 
    $id = ($a['id'] < 0 || $a['id'] > 5) ? 0 : $a['id'];
    $cat_id = education_category_id($id);

    return 
        '<div class="education-box education-' . 
        $id . '"><a href="' . get_category_link($cat_id) . '
        "><p><span>' . get_cat_name($cat_id) . '</span><br />' . 
        category_description($cat_id) . '</a></p></div>';
}

function education_banner_shortcode($atts, $content = null) {
    /* These are shortcodes to use on the education page to deliniate sections 
     * and subsections of the page. */

    $head = 'edu-heading';
    $sub  = 'edu-subheading';
    $a = shortcode_atts(array('type' => 'main'), $atts);

    if ('' == $content) {
        $content = 'Did you forget to include text?';
    }

    if ('main' == $a['type']) {
        $open = '<h2 class="' . $head . '">';
        $close = '</h2>';
    } else {
        $open = '<h3 class="' . $sub . '">';
        $close = '</h3>';
    }

    return $open . $content . $close;
}

function parse_columnist_role($author_id) {
    /* See author_is_columnist, below.
     * 
     * This function takes the string 'yes' or no' and parses it. I probably go 
     * overboard in sanitization, but I've seen the dedication of our local 
     * users. */

    $meta_tag = get_the_author_meta('columnist', $author_id);

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);

        if ($meta_tag === 'yes') {
            return true;
        }
    } 

    return false;
}

function author_is_columnist() {
    /* We've (currently unused) added a flag to each user in order to indicate
     * that they have a serial column. */

    $id = get_the_author_meta('ID');
    return parse_columnist_role($id);
}

function is_columnist_article() {
    /* We've added a 'is_column' flag in extended post fields in order to 
     * indicate whether a post is part of an ongoing column. */

    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);

    return ($col_article === '1');
}

function tweak_title($title, $sep) {
    /* Customize the title format so it looks like:
     * 
     *  site_title | section_title */

    $title = str_replace($sep, '', $title); 

    if (!is_home()) {
        $title = preg_replace('/^/', ' ' . $sep . ' ', $title);
        $title = preg_replace('/^/', bloginfo('name'), $title);
    }

    return $title;
}

function get_view_count($post_id = null) {
    /* Return the view count for the specified post. Used for a report on posts. 
     * This should be used for quick estimates only. You should /not/ consider 
     * this a canonical and absolute count of views on a post. */

    if ('' == $post_id) {
        return;
    }

    $key = 'tuairisc_view_counter';
    $count = (int) get_post_meta($post_id, $key, true);

    if ('' == $count) {
        update_post_meta($post_id, $key, 0);
        return 0;
    }

    return $count;
}

function is_excluded_category() {
    /* Global exclusion and different treatment of the job categories were 
     * requested by Ciaran and Sean. The currently excluded categories are: 
     * 
     * # Category Name               Category ID
     * -----------------------------------------
     * 1 Imeachtaí                   182  
     * 2 Fógraí Poiblí/Folúntais     216   
     * 
     * I can exclude categories from post display with WP_Query, but these
     * exclusions are more nuanced, in that we want to both change how the 
     * categories are styled in the loop or exclude it entirely. */

    $excluded_categories = array(216, 182);

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $excluded_categories)) {
            return true;
        }
    }

    return false;
}

function increment_view_counter($post_id = null) {
    /* This a crude incrementing view counter. I'll parse the values 
     * every day or so for a few days to see if results are even moderately 
     * accurate. */

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if (is_singular('foluntais') || is_singular('post') && !is_user_logged_in()) {
        $key = 'tuairisc_view_counter';
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

function list_post_types() {
    /* This has been helpful in debugging: output a list of all custom post 
     * types to the browser's JavaScript console. */
    
    $args = array('public' => true, '_builtin' => false);
    $output = 'names';
    $operator = 'and';
    $post_types = get_post_types($args, $output, $operator); 

    foreach ($post_types as $post_type) {
        echo '<script>console.log("' . $post_type . '");</script>';
    }
}

/*
 * Header Social Meta Information
 * ------------------------------
 * We tried a few different existing plugins for this, but:
 * 
 * 1. They were overly-complex for lay users to configure.
 * 2. They worked in an inconsistent and buggy manner, at best.
 * 3. They chosen one occasionally inserted annoying upsell banners on admin
 *    pages.
 */

function social_meta() {
    facebook_meta();
    twitter_meta();
}

$fallback = array(
    'publisher' => 'https://www.facebook.com/tuairisc.ie',
    'image' => get_template_directory_uri() . '/images/tuairisc_fallback.jpg',
    'twitter' => '@tuairiscnuacht',
    'description' => 'Cuireann Tuairisc.ie seirbhís nuachta Gaeilge '
        . 'ar fáil do phobal uile na Gaeilge, in Éirinn agus thar lear. Té sé '
        . 'mar aidhm againn oibriú i gcónaí ar leas an phobail trí nuacht, '
        . 'eolas, anailís agus siamsaíocht ar ardchaighdeán a bhailiú, a '
        . 'fhoilsiú agus a chur sa chúrsaíocht.',
);

function twitter_meta() {
    /* Social Meta Information for Twitter
     * ------------------------------------
     * This /should/ be all of the relevant information for Twitter. */
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

function facebook_meta() {
    /* Social Meta Information for Facebook
     * ------------------------------------
     * This /should/ be all of the relevant information for Facebook. */
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

        foreach ($tags as $the_tag) {
            if ($i > 0) {
                $taglist .= ', ';
            }

            $taglist .= $the_tag->name;
            $i++;
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
add_filter('the_excerpt', 'replace_breaks');
// Add shortcode for landing.
add_shortcode('landing', 'education_landing_shortcode');
// Add shortcode for education banners.
add_shortcode('banner', 'education_banner_shortcode');
// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));
// Filter date to return as Gaeilge.
add_filter('get_the_date', 'date_to_irish');
add_filter('get_comment_date', 'date_to_irish');

/*  Don't add any code below here or the sky will fall down
=========================================================== */

?>