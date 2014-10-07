<?php

/* You can add custom functions below, in the empty area
=========================================================== */

function get_parent_id($cat_id) {
    // Return the ID of the top parent of any category.
    $parent = get_category_parents($cat_id, false, '/'); 
    $parent = preg_replace('/\/.*/', '', $parent); 
    return get_cat_id($parent); 
}

function get_cat_color($cat_id) {
    // Return a unique colour for each given parent category.

    /*
    # Category Name   Hex Colour  Category ID
    -----------------------------------------
    1 Nuacht          #516671     191  
    2 Tuairmíocht     #8eb2d3     154   
    3 Spoirt          #c54b54     155
    4 Cultúr          #96c381     156
    5 Saol            #e04184     157
    6 Pobal           #7d5e90     159
    7 Greann          #e6192a     158
    8 Foghlaimeoirí   #d4bb85     187
    */

    // browser_console_log($cat_id);

    $cat_id = get_parent_id($cat_id);

    $cat_colors = array(
        154 => '#8eb2d3',
        155 => '#c54b54',
        156 => '#96c381',
        157 => '#e04184',
        158 => '#e6192a',
        159 => '#7d5e90',
        // 187 => '#d4bb85',
        187 => '#424045',
        191 => '#516671',
        // Fallback mustard yellow
        999 => '#c7c009',
    );

    switch($cat_id) {
        case 154: $color = $cat_colors[$cat_id]; break;
        case 155: $color = $cat_colors[$cat_id]; break;
        case 156: $color = $cat_colors[$cat_id]; break;
        case 157: $color = $cat_colors[$cat_id]; break;
        case 158: $color = $cat_colors[$cat_id]; break;
        case 159: $color = $cat_colors[$cat_id]; break;
        case 187: $color = $cat_colors[$cat_id]; break;
        case 187: $color = $cat_colors[$cat_id]; break;
        case 191: $color = $cat_colors[$cat_id]; break;
        default: $color = $cat_colors[999]; break;
    }

    return $color;
}

function asnc_banner($cat_id) {
    // The asnc category (179) must be taller in order to differentiate content.
    $cat = 158;
    $banner = 'asnc-category-banner';
    return ($cat_id == $cat) ? $banner : '';
}

function get_thumbnail_url($post_id) {
    /* Code snippet from http://www.wpbeginner.com/wp-themes/how-to-get-the-post-thumbnail-url-in-wordpress/
    get_thumbnail_url returns the url for the requested thumbnail, without the wrapped HTML code. */
    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
    return $thumb_url[0];
}

function excerpt_char_length($excerpt) {
    /* Overall excerpt length was a concern in spacing and organizing posts, as was the 
    presense of the 'Read More' link. This function strips the link and constrains the 
    excerpt length to $ex_length characters.

    excerpt_char_length is a filter for the_excerpt() and returns the excerpt. */

    $ex_length = 250;

    $excerpt = strip_tags($excerpt);
    $excerpt = preg_replace('/(Read More$)/', '', $excerpt);

    if (!is_single()) {
        $excerpt = substr($excerpt, 0, $ex_length);
        $excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
    }

    $excerpt = preg_replace('/^/', '<p>', $excerpt);
    $excerpt = preg_replace('/$/', '</p>', $excerpt);

    return $excerpt;
}

function get_avatar_url($user_id, $size) {
    // Return URL for user avatar.
    $avatar_url = get_avatar($user_id, $size);
    $regex = '/(^.*src="|" w.*$)/';
    return preg_replace($regex, '', $avatar_url);
}

function has_local_avatar($user_id) {
    /* This site uses 'WP USer Avatar' for avatar control.
    It serves avatars in this priority:
    
    1. Local user avatar
    2. Gravatar user avatar
    3. Gravatar stock avatar
    
    I need to see if a local avatar is served and switch based on it.
    This function checks to see if the avatar is being served from the local site. 

    has_local_avatar returns true if the avatar is hosted from the local server. */

    $home_url = site_url();
    $avatar_url = get_avatar_url($user_id, 200);
    $has_local_avatar = (strpos($avatar_url, $home_url) === false) ? false : true;
    return $has_local_avatar;
}

function day_to_irish($day) {
    /* See date to Irish below.

    day_to_irish takes an English day and uses lookup to return the Irish version. */
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

    month_to_irish takes an English month and uses lookup to return the Irish version. */
    $irish_months = array(
        'Eanáir', 'Feabhra', 'Márta', 'Aibreán', 'Bealtaine', 'Meitheamh',
        'Iúil', 'Lúnasa', 'Meán Fómhair', 'Deireadh Fómhair', 'Samhain', 'Nollaig'
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

function date_to_irish($the_date, $d) {
    /* Localization attempts fell short as date localization requires files on the server.

    date_to_irish filters the output English date and returns it with day-of-week and month-of-year 
    converted to Irish. */
    $day_regex = '/(,.*)/';
    $month_regex = '/(^.*, | [0-9].*$)/'; 
    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);
    $the_date = str_replace($english_day, day_to_irish($english_day), $the_date);
    $the_date = str_replace($english_month, month_to_irish($english_month), $the_date);
    return $the_date;
}

function education_category_id($id) {
    /* Used for eduation_landing_shortcode below. Users cannot be expected to know 
    the actual category. This returns the appropriate category based on 1-5.

    education_category_id returns proper id, and a fallback id. */
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
    These are big boxy clickable boxes complete with title and description. 

    education_landing_shortcode returns the div string when the shortcode is used.*/
    $a = shortcode_atts(array(
        'id' => 0,
    ), $atts);

    // Change it to default value if it falls outside 0-5 range. 
    $id = ($a['id'] < 0 || $a['id'] > 5) ? 0 : $a['id'];
    $cat_id = education_category_id($id);

    return '<div class="education-box education-' . $id . '"><a href="' . get_category_link($cat_id) . '"><p><span>' . get_cat_name($cat_id) . '</span><br />' . category_description($cat_id) . '</a></p></div>';
}

function parse_columnist_role($author_id) {
    /* See author_is_columnist, below.

    This function takes the string 'yes' or no' and parses it. 
    I probably go overboard in sanitization, but I've seen the dedication
    of our local users. 

    parse_columnist_role returns true if the string parses to 'yes' */
    $meta_tag = get_the_author_meta('columnist', $author_id);
    $is_columnist = false;

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);

        if (strpos('yes', $meta_tag) != -1) {
            $meta_tag = preg_replace('/([^yes].*$)/', '', $meta_tag);
        } else {
            $meta_tag = preg_replace('/([^no].*$)/', '', $meta_tag);
        }

        if ($meta_tag === 'yes') {
            $is_columnist = true;
        }
    } 

    return $is_columnist;
}

function author_is_columnist() {
    /* We've (currently unused) added a flag to each user in order to indicate
    that they have a serial column. 

    parse_columnist_role parses the variable string.
    author_is_columnist returns true or false. */
    $id = get_the_author_meta('ID');
    return parse_columnist_role($id);
}

function is_columnist_article() {
    /* We've added a 'is_column' flag in extended post fields in order to 
    indicate whether a post is part of an ongoing column. 

    is_columnist_article parses the value and returns true or false. */
    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $is_column = false;

    if ($col_article === '1') {
        $is_column = true;
    }

    return $is_column;
}

// Custom excerpt length limit.
add_filter('the_excerpt', 'excerpt_char_length');
// Add shortcode for landing.
add_shortcode('landing', 'education_landing_shortcode');
// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));
// Filter date to return as Gaeilge.
add_filter('get_the_date', 'date_to_irish');

/*  Don't add any code below here or the sky will fall down
=========================================================== */

?>