<?php

/* You can add custom functions below, in the empty area
=========================================================== */

/* Script Loading
 * ---------------
 * Load /all/ the things! */

function tuairisc_scripts() {
    /* This handles loading for all of the custom scripts used in the theme. 
     * 
     * tuairisc_scripts doesn't return anything, and is loaded at the bottom. */

    // Some styling isn't handled correctly by CSS.
    wp_enqueue_script('tuairisc-styling', get_stylesheet_directory_uri() . '/tuairisc_styling.js', array('jquery'), '1.0', true);
    // Styling and loading for jQuery scripts.
    wp_enqueue_script('tuairisc-adrotate', get_stylesheet_directory_uri() . '/tuairisc_adrotate.js', array('jquery'), '1.0', true);
    // Sharing links popout. 
    wp_enqueue_script('tuairisc-share-popout', get_stylesheet_directory_uri() . '/tuairisc_share_popout.js', array('jquery'), '1.0', true);
}

function tuairisc_styles() {
    /* This handles loading for all of the custom stylesheets used in the theme. 
     * 
     * tuairisc_styles doesn't return anything, and is loaded at the bottom. */

    // TODO/testing. Vertical sharing links.
    // wp_enqueue_style('tuairisc-vertical-sharing', get_stylesheet_directory_uri() . '/mshare-vertical.css');
}

/* Breadcrumb Banners
 * ------------------
 * These were a requested feature on the site. */

function get_parent_id($cat_id = null) {
    /* Return the ID of the top parent of any category.
     *
     * get_parent_id returns the id of the parent category. */

    if ($cat_id == '')
        $cat_id = get_query_var('cat');

    $parent = get_category_parents($cat_id, false, '/'); 
    $parent = preg_replace('/\/.*/', '', $parent); 
    return get_cat_id($parent); 
}

function get_breadcrumb() {
    /* This returns the appropriate set of breadcrumb links for the given category/single post.
     * Not much exciting here. */

    if (!is_foluntais()) {
        $id = get_the_category();
        return get_category_parents($id[0]->cat_ID, true, '&nbsp;');
    } else {
        // Get ID of the custom post's taxonomies.
        return get_foluntais_category_link(get_the_ID(), '&nbsp;');
    }
}

function unique_breadcrumb($cat_id = null) {
    /* The Greann category has a unique breadcrumb style, to differentiate it with 
     * other, more serious, segments of the website. 
     * 
     * unique_breacrumb return true if the cat_id == 158. */

    if (is_category()) {
        if ($cat_id == '')
            $cat_id = get_parent_id(get_query_var('cat'));

        if ($cat_id == 158)
            return true;
    }

    return false;
}

function get_id($id = null) {
    /* Three objects have banners:
     *
     * 1. Single posts
     * 2. Single foluntais listings
     * 3. Category archives
     *
     * get_id figures out which is which and returns the appropriate ID. Dirty shorthand
     * until I have a better solution. */

    if (is_single()) {
        $id = 899;
    } else if (is_category()) {
        if ($id == '')
            $id = get_query_var('cat');
    } else if (is_foluntais()) {
        $id = 799;
    } else {
        return;
    }

    return $id;
}

function banner_color($id = null) {
    /* Return a unique colour for each given parent category.
     * 
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
     *
     * get_banner_style returns the hex color as a string. */

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
        // Foluntais
        799 => '#424045',
        // Single posts
        899 => '#000',
        // Fallback
        999 => '#c7c009',
    );

    $color = '';

    if ($id == '')
        $id = get_ID();

    if (array_key_exists($id, $banner_colors))
        $color = $banner_colors[$id];
    else
        $color = $banner_colors[999];

    echo 'background-color: ' . $color . ';';
}

function banner_class($id = null) {
    /* Some banners have custom CSS styles attached. 
     * This function looks at the ID and type of object and returns
     * the custom class, should it exist. 
     * 
     * banner_class() returns the class, if it exists. */

    $classes = array(
        158 => 'greann',
        899 => 'banner-post',
    );

    $class = '';

    if ($id == '')
        $id = get_id();

    if (is_single()) 
        $class = $classes[899];
    else if (is_category() && array_key_exists($id, $classes))
        $class = $classes[$id];
    else if (is_foluntais())
        $class = $classes[899];

    echo $class;
}

/* 'Hero'-style Posts 
 * ------------------
 * The first post on the each page of the category display has a different, custom
 * style. */

function hero_post_class() {
    /* If the lead post has thumbnail images, mark it as a 'hero' post, whose 
     * style is very different than other posts in the cateory loop. 
     *
     * hero_post_class returns the correct class as string. */

    return (has_post_thumbnail()) ? 'hero-post' : '';
}

function show_hero($current_post) {
    /* The first page in the category loop has a unique and different style. 
    The image is hero-sized and flipped in position with the text. This is to 
    be shown on all categories except the job listings. 

    show_hero returns true or false. */

    if ($current_post == 0 && !is_paged())
        return true;

    if (is_excluded_category())
        return false;

    return false;
}

function get_thumbnail_url($post_id = null) {
    /* Code snippet from http://goo.gl/NhcEU6
     * get_thumbnail_url returns the anchor url for the requested thumbnail. */

    if ($post_id == '') 
        $post_id = get_the_ID();

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
    return $thumb_url[0];
}

function remove_read_more($excerpt) {
    /* Remove the read more link from page and post excerpts.
     *
     * remove_read_more returns the excerpt. */

    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

function replace_breaks($excerpt) {
    /* Replace <br /> tags in excerpts with <p>. 
     * Excerpt are used site-wide as a 'blurb' for posts.
     * 
     * replace_breaks returns the exerpt. */ 

    return str_replace('<br />', '</p><p>', $excerpt);
}

function get_avatar_url($size) {
    /* Return the hyperlink for the given avatar size without the <img /> code.
     * 
     * get_avatar_url returns the URL string. */

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
     * site. 
     * 
     * has_local_avatar returns true if the avatar is hosted on the site. */

    $user_id = get_the_author_meta('ID');
    $home_url = site_url();
    $avatar_url = get_avatar_url($user_id, 200);
    return (strpos($avatar_url, $home_url) === false) ? false : true;
}

function day_to_irish($day) {
    /* See date to Irish below.
     * 
     * day_to_irish returns the Irish translation of the day. */

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
     * 'site', then neither Ciaran nor Sean want the author's name to appear.
     *
     * default_author returns true if the author was the default account. */

    $default_author = 37;
    
    if (get_the_author_meta('ID') == $default_author)
        return true;

    return false;
}

function month_to_irish($month) {
    /* See date to Irish below.
     * 
     * month_to_irish returns the Irish translation of the month. */

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
     * the server.
     * 
     * date_to_irish returns the translated date. */

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
     * know the actual category.
     * 
     * education_category_id returns proper id or a fallback id. */

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
     * These are big boxy clickable boxes complete with title and description. 
     * 
     * education_landing_shortcode returns the div as a string. */

    $a = shortcode_atts(array(
        'id' => 0,
    ), $atts);

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
    /* These are shortcodes to use on the education page to deliniate sections and 
     * subsections of the page. 
     * 
     * education_banneoning. */

    $head = 'edu-heading';
    $sub  = 'edu-subheading';

    $a = shortcode_atts(array(
        'type' => 'main',
    ), $atts);

    if ($content == '') {
        $content = 'Did you forget to include text?';
    }

    if ($a['type'] == 'main') {
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
     * This function takes the string 'yes' or no' and parses it. 
     * I probably go overboard in sanitization, but I've seen the dedication
     * of our local users. 
     *
     * parse_columnist_role returns true if the string parses to 'yes' */

    $meta_tag = get_the_author_meta('columnist', $author_id);

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);

        if ($meta_tag === 'yes')
            return true;
    } 

    return false;
}

function author_is_columnist() {
    /* We've (currently unused) added a flag to each user in order to indicate
     * that they have a serial column. 
     * 
     * parse_columnist_role parses the variable string.
     * author_is_columnist returns true or false. */

    $id = get_the_author_meta('ID');
    return parse_columnist_role($id);
}

function is_columnist_article() {
    /* We've added a 'is_column' flag in extended post fields in order to 
     * indicate whether a post is part of an ongoing column. 
     *
     * is_columnist_article parses the value and returns true or false. */

    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);

    if ($col_article === '1') 
        return true;

    return false;;
}

function tweak_title($title, $sep) {
    /* Customize the title format so it looks like:
     * 
     *  site_title | section_title
     *
     * tweak_title returns the title. */

    $title = str_replace($sep, '', $title); 

    if (!is_home()) {
        $title = preg_replace('/^/', ' ' . $sep . ' ', $title);
        $title = preg_replace('/^/', bloginfo('name'), $title);
    }

    return $title;
}

function get_view_count($post_id = null) {
    /* Return the view count for the specified post.
     * Used for a report on posts. 
     * This should be used for quick estimates only.
     * You should /not/ consider this canonical. 
     * 
     * get_view_count returns the integer count. */

    if ($post_id == '')
        return;

    $key = 'tuairisc_view_counter';
    $count = (int) get_post_meta($post_id, $key, true);

    if ($count == '') {
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
     * categories are styled in the loop or exclude it entirely.
     *
     * is_excluded_category returns true or false. */

    $excluded_categories = array(216, 182);

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $excluded_categories))
            return true;
    }

    return false;
}

function increment_view_counter($post_id = null) {
    /* This a crude incrementing view counter. I'll parse the values 
     * every day or so for a few days to see if results are even moderately 
     * accurate.
     * 
     * increment_view_counter does not return anything. */

    if ($post_id == '')
        $post_id = get_the_ID();

    if (is_foluntais() || is_single() && !is_user_logged_in()) {
        $key = 'tuairisc_view_counter';
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

function list_post_types() {
    /* This has been helpful in debugging-output a list of all custom post types
     * to the JavaScript console.
     * 
     * list_post_type doesn't return anything. */
    
    $args = array('public' => true, '_builtin' => false);
    $output = 'names';
    $operator = 'and';
    $post_types = get_post_types($args, $output, $operator); 

    foreach ($post_types as $post_type)
        echo '<script>console.log("' . $post_type . '");</script>';
}

/*
 * Foluntais Custom Post Type
 * --------------------------
 * This custom post type is used to highlight and differentiate jobs across the 
 * Tuairisc website. 
*/

function register_foluntais() {
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
        'taxonomies'    => array('job_types','job_tags'),
    );

    register_post_type('foluntais', $args);
    flush_rewrite_rules();
}

function register_foluntais_taxonomies() {
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
        'rewrite'           => array('slug' => 'job-types'),
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

    register_taxonomy('job_types', array('foluntais'), $cat_args);
    register_taxonomy('job_tags', array('foluntais'), $tag_args);
}

function is_foluntais() {
    /* Test if the article in question is of the custom 'foluntais' type.
     * is_folunttais returns true or false. */

    $job = 'foluntais';

    if (get_post_type() == $job)
        return true;

    return false;
}

function foluntais_messages($messages) {
    /* Error and help messages related to foluntais post types. */

    global $post, $post_ID;
    
    $messages['foluntais'] = array(
        0 => '', 
        1 => sprintf( __('Job updated. <a href="%s">View job</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Job updated.'),
        5 => isset($_GET['revision']) ? sprintf( __('Job restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Job published. <a href="%s">View job</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Product saved.'),
        8 => sprintf( __('Job submitted. <a target="_blank" href="%s">Preview job</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Job draft updated. <a target="_blank" href="%s">Preview job</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}

function foluntais_help($contextual_help, $screen_id, $screen) { 
    /* Foluntais help message. */

    if ('product' == $screen->id)
        $help = 'TODO';
    elseif ('edit-foluntais' == $screen->id)
        $help = 'TODO';

    return $contextual_help;
}

function foluntais_category_id($post_id = null) {
    // Return the ID for the given foluntais post type.
    if ($post_id == '') 
        $post_id = get_the_ID();

    $id = wp_get_post_terms($post_id, 'job_types', array('fields' => 'ids'));
    return $id[0];
}

function foluntais_category_name($post_id = null) {
    // Return the name for the given foluntais post type.
    if ($post_id == '')
        $post_id = get_the_ID();

    $term = get_term(foluntais_category_id($post_id), 'job_types');
    return $term->name;
}

function foluntais_category_link($post_id = null) {
    // Return the link to the given foluntais post type.
    if ($post_id == '')
        $post_id = get_the_ID();

    $term = get_term(foluntais_category_id($post_id), 'job_types');    
    return get_term_link($term);
}
 
function get_foluntais_category_link($post_id = null, $separator = '/') {
    /* This mirrors the function of get_category_parents(), except for foluntais
     * postings. */

    if ($post_id == '')
        return;

    // Totally ghetto, but I'm drunk.
    $term_name = foluntais_category_name($post_id);
    $term_link = foluntais_category_link($post_id);
    $parent_link = get_post_type_archive_link('foluntais'); 
    $parent_name = get_post_type($post_id);
    return '<a href="' . $parent_link . '">' . $parent_name . '</a>' . $separator . '<a href="' . $term_link . '">'. $term_name . '</a>';
}

function foluntais_category_color($post_id = null) {
    if ($post_id == '')
        $post_id = get_the_ID();

    $id = foluntais_category_id($post_id);

    $category_colors = array(
        // Place holder.
        223 => '#90b5d2',
        226 => '#9ac485',
        // Fallback
        999 => '#000'
    );

    if (array_key_exists($id, $category_colors))
        return $category_colors[$id];
    else 
        return $category_colors[999];
}

// START TODO/FIXME

function foluntais_meta_box_content($post) {
    wp_nonce_field(plugin_basename(__FILE__), 'foluntais_meta_box_nonce'); 

    ?>
        <span>Location:</span><br />
        <label for="foluntais_box"></label>
        <input class="newtag" type="text" name="foluntais_input" placeholder="Job location" />
        <input class="button" type="button" name="foluntais_button" Value="Add" />
    <?php
}

function foluntais_meta_box() {
    add_meta_box( 
        // Unique box name/ID
        'tuairisc_foluntais_meta',
        // Title of the text box
        __('Job Information','wpzoom'),
        // Callback function to display box contents
        'foluntais_meta_box_content',
        // Post type this belongs to
        'foluntais',
        // Context/placement of the box on the admin page
        'side',
        // Placement priority of the box if other boxes shuffle it aside
        'high',
        // Callback array
        null
    );
}

add_action('add_meta_boxes', 'foluntais_meta_box', 10, 0);

// END TODO/FIXME

// Add custom post type for job listings.
add_action('init', 'register_foluntais');
add_action('init', 'register_foluntais_taxonomies', 0);
add_filter('post_updated_messages', 'foluntais_messages');
add_action('contextual_help', 'foluntais_help', 10, 3);
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