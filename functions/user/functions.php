<?php

/* You can add custom functions below, in the empty area
=========================================================== */

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

$banner_colors = [
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
    227 => '#90b5d2',
    228 => '#9ac485',
    // Foluntais fallback
    799 => '#424045',
    // Single posts
    899 => '#000',
    // Fallback
    999 => '#c7c009',
];

/* Script Loading
 * ---------------
 * Load /all/ the things! */

function tuairisc_scripts() {
    /* This handles loading for all of the custom scripts used in the theme. */

    // Some styling isn't handled correctly by CSS.
    wp_enqueue_script('tuairisc-styling', get_stylesheet_directory_uri() . '/tuairisc_styling.js', array('jquery'), '1.0', true);
    // Styling and loading for jQuery scripts.
    wp_enqueue_script('tuairisc-adrotate', get_stylesheet_directory_uri() . '/tuairisc_adrotate.js', array('jquery'), '1.0', true);
    // Sharing links popout. 
    wp_enqueue_script('tuairisc-share-popout', get_stylesheet_directory_uri() . '/tuairisc_share_popout.js', array('jquery'), '1.0', true);
}

function tuairisc_styles() {
    /* This handles loading for all of the custom stylesheets used 
     * throughout the theme. */

    // TODO/testing. Vertical sharing links.
    // wp_enqueue_style('tuairisc-vertical-sharing', get_stylesheet_directory_uri() . '/mshare-vertical.css');
}

/* Breadcrumb Banners
 * ------------------
 * These were a requested feature on the site. */

function get_parent_id($cat_id = null) {
    /* Return the ID of the top parent of any category. */

    if ('' = $cat_id) {
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

    if (is_category() && !is_greann() || is_single() && has_category()) {
        $id = get_the_category();
        echo get_category_parents($id[0]->cat_ID, true, '&nbsp;');
    } else if (is_category() && is_greann()) {
        echo '<span>' . category_description() . '</span>';
    } else if (is_singular('foluntais')) {
        get_job_category_link($post_id, true, '&nbsp;');
    }
}

function is_greann() {
    /* The Greann category has a unique breadcrumb style, to differentiate it 
     * with other, more serious, segments of the website. */

    if (is_category()) {
        $id = get_parent_id(get_query_var('cat'));
    } else if (is_single() && has_category()) {
        $id = get_the_category();
        $id = $cat[0]->cat_ID;
    }

    return ($id == 158) ? true : false;
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

    if (is_single() && has_category() && !is_singular('foluntais')) {
        $id = get_the_category();
        $id = $id[0]->cat_ID;

        if ($id == 158) {
            return $id;
        } else {
            $id = 899;
        }
    } else if (is_category()) {
        $id = get_parent_id(get_query_var('cat'));
    } else if (is_singular('foluntais')) {
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

function show_hero($current_post) {
    /* The first page in the category loop has a unique and different style. 
    The image is hero-sized and flipped in position with the text. This is to 
    be shown on all categories except the job listings. */

    return ($current_post == 0 && !is_paged()) ? true : false;
}

function get_thumbnail_url($post_id = null) {
    /* Code snippet from http://goo.gl/NhcEU6
     * get_thumbnail_url returns the anchor url for the requested thumbnail. */

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
    return $thumb_url[0];
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

function get_avatar_url($size) {
    /* Return the hyperlink for the given avatar, without the <img /> code. */

    $user_id = get_the_author_meta('ID');
    $avatar_url = get_avatar($user_id, $size);
    return preg_replace('/(^.*src="|" w.*$)/', '', $avatar_url);
}

function has_local_avatar() {
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

    $user_id = get_the_author_meta('ID');
    $home_url = site_url();
    $avatar_url = get_avatar_url($user_id, 200);
    return (strpos($avatar_url, $home_url) === false) ? false : true;
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

function default_author() {
    /* The UID for the admin account is 37. If the article's author is the
     * 'site', then neither Ciaran nor Sean want the author's name to appear. */

    $default_author = 37;    
    return (get_the_author_meta('ID') == $default_author) ? true : false;
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

    return ($col_article === '1') ? true : false;
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

    if (is_singular('foluntais') || is_single() && !is_user_logged_in()) {
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
 * Foluntais Custom Post Type
 * --------------------------
 * This custom post type is used to highlight and differentiate jobs across the 
 * Tuairisc website. 
*/

function register_job_type() {
    /* Register the foluntais custom post type, used for job listsings across 
     * the Tuairisc website. */

    $labels = array(
        'name'               => _x('Jobs', 'post type general name'),
        'singlular_name'     => _x('Job', 'post type individual name'),
        'add_new'            => _x('Add New', 'job'),
        'add_new_item'       => __('Add New Job'),
        'edit_item'          => __('Edit Job'),
        'new_item'           => __('New Job'),
        'menu_name'          => __('Jobs'),
        'all_items'          => __('All Jobs'),
        'search_items'       => __('Search Jobs'),
        'not_found'          => __('No jobs found'),
        'not_found_in_trash' => __('No jobs found in the Trash'),
        'parent_item_colon'  => '',
    );

    $args = array(
        'description'   => 'Tuairisc.ie job listings',
        'has_archive'   => true,
        'labels'        => $labels,
        'menu_position' => 4,
        'public'        => true,
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'    => array('job_categories','job_tags'),
    );

    register_post_type('foluntais', $args);
    flush_rewrite_rules();
}

function register_job_taxonomies() {
    /* Create the custom taxonomy for jobs. It was considered inappropraite to
     * include jobs in the common tags and categories, so therefore they have a 
     * separate, parallel scheme. */

    /* Job Categories
     * -------------- */

    $cat_labels = array(
        'name'              => _x('Job Categories', 'taxonomy general name'),
        'singular_name'     => _x('Job Category', 'taxonomy singular name'),
        'search_items'      => __('Search Job Categories'),
        'all_items'         => __('All Job Categories'),
        'parent_item'       => __('Parent Cateory'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item'         => __('Edit Category'),
        'update_item'       => __('Update Category'),
        'add_new_item'      => __('Add Category'),
        'new_item_name'     => __('New Category Name'),
        'menu_name'         => __('Job Categories'),
    );

    $cat_args = array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'job-categories'),
    );

    /* Job Tags
     * -------- */

    $tag_labels = array(
        'name'              => _x('Job Tags', 'taxonomy general name'),
        'singular_name'     => _x('Job Tag', 'taxonomy singular name'),
        'search_items'      => __('Search Tags'),
        'all_items'         => __('All Tags'),
        'edit_item'         => __('Edit Tags'),
        'update_item'       => __('Update Tag'),
        'add_new_item'      => __('Add New Tag'),
        'new_item_name'     => __('New Tag'),
        'menu_name'         => __('Job Tags'),
    );

    $tag_args = array(
        'hierarchical'      => false,
        'labels'            => $tag_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'job-tags'),
    );

    register_taxonomy('job_categories', array('foluntais'), $cat_args);
    register_taxonomy('job_tags', array('foluntais'), $tag_args);
}

function job_messages($messages) {
    /* Error and help messages related to the jobs custom post type. */

    global $post, $post_ID;
    
    $messages['foluntais'] = array(
        0  => '', 
        1  => sprintf(__('Job updated. <a href="%s">View job</a>', 'wpzoom'), esc_url(get_permalink($post_ID))),
        2  => __('Custom field updated.', 'wpzoom'),
        3  => __('Custom field deleted.', 'wpzoom'),
        4  => __('Job updated.'),
        5  => isset($_GET['revision']) ? sprintf( __('Job restored to revision from %s', 'wpzoom'), wp_post_revision_title( (int) $_GET['revision'], false)) : false,
        6  => sprintf(__('Job published. <a href="%s">View job</a>', 'wpzoom'), esc_url(get_permalink($post_ID))),
        7  => __('Product saved.', 'wpzoom'),
        8  => sprintf(__('Job submitted. <a target="_blank" href="%s">Preview job</a>', 'wpzoom'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9  => sprintf(__('Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>', 'wpzoom'), date_i18n(__('M j, Y @ G:i',' wpzoom'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Job draft updated. <a target="_blank" href="%s">Preview job</a>','wpzoom'), esc_url(add_query_arg('preview','true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}

function has_job_category($term = null, $post_id = null) {
    /* Test whether a post has any given term out of a given taxonomy. This
     * function parallels has_category() for the job_categories taxonomy. */

    $taxonomy = 'job_categories';

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if ('' == $term) {
        $term_list = get_terms($taxonomy);

        foreach ($term_list as $a) {
            array_push($term, $a->term_id);
        }
    }

    return (has_term($term, $taxonomy, $post_id)) ? true : false;
}

function job_category_id($post_id) {
    /* Shorthand function to return only the ID of a given term in the custom
     * taxonomy for job categories. */

    $taxonomy = 'job_categories';

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if (!has_job_category()) {
        return -1;
    }

    $cat_id = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));
    return $cat_id[0];
}

function job_category_name($post_id) {
    /* Shorthand function to return only the name of a given term in the custom
     * taxonomy for job categories. */

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if (!has_job_category()) {
        return -1;
    }

    $term = get_term(job_category_id($post_id), 'job_categories');
    return $term->name;
}

function job_category_link($id) {
    // Return the link to the given job post type.
    $term = get_term(job_category_id($id), 'job_categories');    
    return get_term_link($term);
}
 
function get_job_category_link($post_id = null, $use_parent = false, $sep = '/') {
    /* This functions mirrors the function of get_category_parents(), for job
     * postings. This function needs to be refactored. */

    if ('' == $post_id) {
        $post_id == get_the_ID();
    }

    if (!has_job_category()) {
        return;
    }

    // Totally ghetto, but I'm drunk.
    $term_name = job_category_name($post_id);
    $term_link = job_category_link($post_id);
    $anchor = '<a href="' . $term_link . '">'. $term_name . '</a>';

    if (true == $use_parent) {
        $parent_link = get_post_type_archive_link('foluntais'); 
        $parent_name = get_post_type($id);
        $parent_anchor = '<a href="' . $parent_link . '">' . $parent_name . '</a>' . $sep;
        $anchor = $parent_anchor . $anchor;
    }

    echo $anchor;
}

function job_category_color($post_id = null) {
    /* Used on the archive page for job categories. If the post has an assigned 
     * colour, show the colour.*/

    global $banner_colors;

    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    if (!has_job_category()) {
        // Hide the box if there's no valid category.
        echo 'display: none;';
        return;
    }

    $cat_id = job_category_id($post_id);
    $bg_open = 'background-color:';
    $bg_close = ';';

    if (array_key_exists($cat_id, $banner_colors)) {
        echo $bg_open . $banner_colors[$cat_id] . $bg_close;
    } else {
        echo $bg_open . $banner_colors[799] . $bg_close;
    }
}

// Add custom post type for job listings.
add_action('init', 'register_job_type');
add_action('init', 'register_job_taxonomies', 0);
add_filter('post_updated_messages', 'job_messages');
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