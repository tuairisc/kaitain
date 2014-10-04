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
    $asnc_cat = 158;
    $asnc_banner = 'asnc-category-banner';
    return ($cat_id == $asnc_cat) ? $asnc_banner : '';
}

function get_thumbnail_url($post_ID) {
    // Code snippet from http://www.wpbeginner.com/wp-themes/how-to-get-the-post-thumbnail-url-in-wordpress/
    $thumb_id = get_post_thumbnail_id($post_ID);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
    return $thumb_url[0];
}

function get_excerpt($count) {
    // Returns a shortened excerpt of $count characters.
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_excerpt();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
    $excerpt = $excerpt . '<a class="more-link" href="' . $permalink . '">Read More</a>';
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
    $month_regex = '/(^.*, | [0-9].*)/'; 
    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);
    $the_date = str_replace($english_day, day_to_irish($english_day), $the_date);
    $the_date = str_replace($english_month, month_to_irish($english_month), $the_date);
    return $the_date;
}

add_filter('get_the_date', 'date_to_irish');

/*  Don't add any code below here or the sky will fall down
=========================================================== */

?>