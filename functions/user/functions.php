<?php

/* You can add custom functions below, in the empty area
=========================================================== */

function get_parent_id($cat) {
    // Return the ID of the top parent of any category.
    $parent = get_category_parents($cat, false, '/'); 
    $parent = preg_replace('/\/.*/', '', $parent); 
    return get_cat_id($parent); 
}

function get_cat_color($cat) {
    // Return a unique colour for each given parent category.

    /*
    # Category Name   Hex Colour  Category ID
    -----------------------------------------
    1 Nuacht          #516671     191  
    2 Tuairmíocht     #8eb2d3     154   
    3 Spoirt          #f1db81     155
    4 Cultúr          #96c381     156
    5 Saol            #e04184     157
    6 Pobal           #7d5e90     159
    7 Greann          #c54b54     158
    8 Foghlaimeoirí   #d4bb85     187
    */

    $cat = get_parent_id($cat);

    $cat_colors = array(
        154 => '#8eb2d3',
        155 => '#f1db81',
        156 => '#96c381',
        157 => '#e04184',
        158 => '#c54b54',
        159 => '#7d5e90',
        187 => '#d4bb85',
        191 => '#516671',
        // Fallback mustard yellow
        999 => '#c7c009',
    );

    switch($cat) {
        case 154: $color = $cat_colors[$cat]; break;
        case 155: $color = $cat_colors[$cat]; break;
        case 156: $color = $cat_colors[$cat]; break;
        case 157: $color = $cat_colors[$cat]; break;
        case 158: $color = $cat_colors[$cat]; break;
        case 159: $color = $cat_colors[$cat]; break;
        case 187: $color = $cat_colors[$cat]; break;
        case 187: $color = $cat_colors[$cat]; break;
        case 191: $color = $cat_colors[$cat]; break;
        default: $color = $cat_colors[999]; break;
    }

    return $color;
}

function get_thumbnail_url($post_ID) {
    // Code snippet from http://www.wpbeginner.com/wp-themes/how-to-get-the-post-thumbnail-url-in-wordpress/
    $thumb_id = get_post_thumbnail_id($post_ID);
    $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
    return $thumb_url[0];
}

function get_excerpt($count){
    // Returns a shortened excerpt of $count characters.
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
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
 
/*  Don't add any code below here or the sky will fall down
=========================================================== */

?>