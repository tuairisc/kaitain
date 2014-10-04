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

function translate_day($day) {
    $irish_days = array(
        'Dé Luain', 'Dé Máirt', 'Dé Céadaoin', 'Déardaoin', 
        'Dé hAoine', 'Dé Sathairn', 'Dé Domhnaigh'
    ); 

    switch ($day) {
        case 'Monday': return $irish_days[0];
        case 'Tuesday': return $irish_days[1];
        case 'Wednesday': return $irish_days[2];
        case 'Thursday': return $irish_days[3];
        case 'Friday': return $irish_days[4];
        case 'Saturday': return $irish_days[5];
        case 'Sunday': return $irish_days[6];
        default: return false;
    }
}

function translate_month($month) {
    $irish_months = array(
        'Eanáir', 'Feabhra', 'Márta', 'Aibreán', 'Bealtaine', 'Meitheamh',
        'Iúil', 'Lúnasa', 'Meán Fómhair', 'Deireadh Fómhair', 'Samhain', 'Nollaig'
    );

    switch ($month) {
        case 'January': return $irish_months[0];
        case 'February': return $irish_months[1];
        case 'March': return $irish_months[2];
        case 'April': return $irish_months[3];
        case 'May': return $irish_months[4];
        case 'June': return $irish_months[5];
        case 'July': return $irish_months[6];
        case 'August': return $irish_months[7];
        case 'September': return $irish_months[8];
        case 'October': return $irish_months[9];
        case 'November': return $irish_months[10];
        case 'December': return $irish_months[11];
        default: return false;
    }
}

function translate_date($d = '', $post = null) {
    $post = get_post($post);

    if (!$post) {
        return false;
    }

    if ('' == $d) {
        $the_date = mysql2date(get_option('date_format'), $post->post_date);
    } else {
        $the_date = mysql2date($d, $post->post_date);
    }

    // $post_day = mysql2date('l', $post->post_date);
    // $post_month = mysql2date('F', $post->post_date);
    // $the_date = str_replace($post_day, $translate_day($post_day), $the_date);
}

/*  Don't add any code below here or the sky will fall down
=========================================================== */

?>