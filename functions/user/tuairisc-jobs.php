<?php
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
    remove_post_type_support('foluntais','comments');
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

function is_job() {
    /* Is the post type explicitly of the foluntais type? */
    return ('foluntais' == get_post_type());
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

    return (has_term($term, $taxonomy, $post_id));
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

function job_category_name($post_id = null) {
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

function job_category_link($post_id) {
    /* Return the link to the given job post type. */
    if ('' == $post_id) {
        $post_id = get_the_ID();
    }

    $term = get_term(job_category_id($post_id), 'job_categories');    
    return get_term_link($term);
}
 
function get_job_category_link($post_id = null, $use_child = false, $sep = '/') {
    /* This functions mirrors the function of get_category_parents(), for job
     * postings. This function needs to be refactored. */
    if ('' == $post_id) {
        $post_id == get_the_ID();
    }

    if (!has_job_category()) {
        return;
    }

    $parent_link   = get_post_type_archive_link('foluntais'); 
    $parent_name   = get_post_type($id);
    $anchor = '<a href="' . $parent_link . '">' . $parent_name . '</a>' . $sep;

    if (true == $use_child) {
        $child_name = job_category_name($post_id);
        $child_link = job_category_link($post_id);
        $anchor .= '<a href="' . $child_link . '">'. $child_name . '</a>';
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
?>