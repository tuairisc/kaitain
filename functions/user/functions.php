<?php

/* You can add custom functions below, in the empty area
=========================================================== */

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

function has_unique_breadcrumb_style($cat_id = null) {
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
     * get_cat_color returns the hex color as a string. */

    $has_style = false;

    if (is_single())
        return $has_style;

    if ($cat_id == '')
        $cat_id = get_parent_id(get_query_var('cat'));

    switch ($cat_id) {
        case 158: 
            $has_style = true; break;
        default: 
            break;
    }

    return $has_style;
}

function get_breadcrumb_style($cat_id = null) {
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
     * get_breadcrumb_style returns the hex color as a string. */

    if (is_single())
        return;

    if ($cat_id == '')
        $cat_id = get_query_var('cat');

    $cat_id = get_parent_id($cat_id);

    $cat_colors = array(
        154 => '#8eb2d3',
        155 => '#c54b54',
        156 => '#96c381',
        157 => '#e04184',
        158 => '#e6192a',
        159 => '#7d5e90',
        187 => '#424045',
        191 => '#516671',
        // Fallback mustard yellow
        999 => '#c7c009',
    );

    switch($cat_id) {
        case 154: 
            $color = $cat_colors[$cat_id]; break;
        case 155: 
            $color = $cat_colors[$cat_id]; break;
        case 156: 
            $color = $cat_colors[$cat_id]; break;
        case 157: 
            $color = $cat_colors[$cat_id]; break;
        case 158: 
            $color = $cat_colors[$cat_id]; break;
        case 159: 
            $color = $cat_colors[$cat_id]; break;
        case 187: 
            $color = $cat_colors[$cat_id]; break;
        case 187: 
            $color = $cat_colors[$cat_id]; break;
        case 191: 
            $color = $cat_colors[$cat_id]; break;
        default: 
            $color = $cat_colors[999]; break;
    }

    echo 'background-color: ' . $color . ';';
}

function get_breadcrumb_class($cat_id = null) {
    $class = '';

    if (is_single()) {
        $class = 'breadcrumb-post';
    } else {
        if ($cat_id == '')
            $cat_id = get_parent_id(get_query_var('cat'));

        switch ($cat_id) {
            case 158:
                $class = 'greann'; break;
            default:
                break;
        }
    }

    return $class;
}

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

    $show = false;

    if ($current_post == 0 && !is_paged())
        $show = true;

    if (is_excluded_category())
        $show = false;

    return $show;
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
    $is_columnist = false;

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);

        if ($meta_tag === 'yes')
            $is_columnist = true;
    } 

    return $is_columnist;
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
    $is_column = false;
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);

    if ($col_article === '1') 
        $is_column = true;

    return $is_column;
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

    $is_excluded = false; 
    $excluded_categories = array(216, 182);

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $excluded_categories)) {
            $is_excluded = true;
            break;
        }
    }

    return $is_excluded;
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

function is_foluntais($post_id = null) {
    /* Test if the article in question is of the custom 'foluntais' type.
     * 
     * is_folunttais returns true or false. */
    if ($post_id == '')
        $post_id = get_the_ID();

    $job = 'foluntais';
    $is_job = false;

    if (get_post_type() == 'foluntais')
        $is_job = true;

    return $is_job;
}

function foluntais_post_type() {
    // Debug/test. Needs to be expanded upon.
    $labels = array(
        'name'               => _x('Jobs', 'post type general name'),
        'singlular_name'     => _x('Job', 'post type individual name'),
        'add_new'            => _x('Add New', 'job'),
        'add_new_item'       => __('Add New Product'),
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
        // Add custom job taxonomy here.
        'taxonomies'    => array(''),
    );

    register_post_type('foluntais', $args);
    flush_rewrite_rules();
}

function foluntais_messages($messages) {
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
    if ( 'product' == $screen->id ) {
        $help = 'TODO';
    } elseif ('edit-foluntais' == $screen->id) {
        $help = 'TODO';
    }

    return $contextual_help;
}

function foluntais_meta_box() {
    add_meta_box( 
        // Unique box name
        'foluntais_box',
        // Visible name of meta box
        __('Job Information', 'myplugin_textdomain'),
        // Function to display box contents
        'foluntais_box_content',
        // Post type this belongs to
        'foluntais',
        // Placement of the box
        'side',
        // Placement priority of the box if other boxes shuffle it aside.
        'high'
    );
}

function foluntais_box_content($post) {
    wp_nonce_field(plugin_basename(__FILE__), 'product_price_box_content_nonce');
    echo '<span>Location:</span><br />';
    echo '<label for="foluntais_box"></label>';
    echo '<input type="text" id="product_price" name="product_price" placeholder="Job location" />';
    echo '<input type="button" id="product_price" name="product_price" Value="Add" />';
}

// Add custom post type for job listings.
add_action('init', 'foluntais_post_type');
add_filter('post_updated_messages', 'foluntais_messages');
add_action('contextual_help', 'foluntais_help', 10, 3);
add_action('add_meta_boxes', 'foluntais_meta_box');

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