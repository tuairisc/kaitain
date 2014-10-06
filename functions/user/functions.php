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
        187 => '#d4bb85',
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

function get_thumbnail_url($post_ID) {
    // Code snippet from http://www.wpbeginner.com/wp-themes/how-to-get-the-post-thumbnail-url-in-wordpress/
    $thumb_id = get_post_thumbnail_id($post_ID);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
    return $thumb_url[0];
}

function excerpt_char_length($excerpt) {
    // Returns a shortened excerpt of $ex_length characters.
    // Optionally add 'read more' link.

    $ex_length = 350;

    $excerpt = strip_tags($excerpt);
    $excerpt = preg_replace('/(Read More$)/', '', $excerpt);

    if (!is_single()) {
        $excerpt = substr($excerpt, 0, $ex_length);
        $excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
    }

    $excerpt = preg_replace('/^/', '<p>', $excerpt);
    $excerpt = preg_replace('/$/', '</p>', $excerpt);

    // if (is_home()) {
    //     $excerpt = $excerpt . '<a class="more-link" href="' . get_permalink($post->ID) . '">Read More</a>';
    // }

    return $excerpt;
}

function get_avatar_url($user_id, $size) {
    // Return URL for user avatar.
    $avatar_url = get_avatar($user_id, $size);
    $regex = '/(^.*src="|" w.*$)/';
    return preg_replace($regex, '', $avatar_url);
}

function has_local_avatar($user_id) {
    // This site uses 'WP USer Avatar' for avatar control.
    // It serves avatars in this priority:
    // 
    // 1. Local user avatar
    // 2. Gravatar user avatar
    // 3. Gravatar stock avatar
    // 
    // I need to see if a local avatar is served and switch based on it.
    // This function checks to see if the avatar is being served from the local site. 
    $home_url = site_url();
    $avatar_url = get_avatar_url($user_id, 200);
    return (strpos($avatar_url, $home_url) === false) ? false : true;
}

function day_to_irish($day) {
    // Return given day of the week as Gaeilge.
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
    // Return given month of the year as Gaeilge.
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
    // Changes the day of the week and month of the year to their Irish versions.
    $day_regex = '/(,.*)/';
    $month_regex = '/(^.*, | [0-9].*$)/'; 
    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);
    $the_date = str_replace($english_day, day_to_irish($english_day), $the_date);
    $the_date = str_replace($english_month, month_to_irish($english_month), $the_date);
    return $the_date;
}

function education_category_id($id) {
    // The education category has five sub-categories.
    // Fallback is to retrive the parent ID.
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
    // Parse shortcude for the education landing lpage categories. 
    $a = shortcode_atts(array(
        'id' => 0,
    ), $atts);

    // Change it to default value if it falls outside 0-5 range. 
    $id = ($a['id'] < 0 || $a['id'] > 5) ? 0 : $a['id'];
    $cat_id = education_category_id($id);

    return '<div class="education-box education-' . $id . '"><p><span><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></span><br />' . category_description($cat_id) . '</p></div>';
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