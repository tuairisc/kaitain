<?php

/**
 * Foluntais Custom Post Type
 * ---------------------------
 * The Tuairisc site has a subsection that advertises government and education
 * employment position. The particular needs included things such as: no 
 * comment support, banners and entirely separate admin listings.
 * 
 * It made sense to create a custom post type as they can fulfil all of these 
 * criteria.
 * 
 * Update April 14 2015: I ditched the custom terms (categories and tags), as 
 * they were a pain in the ass to manage. 
 *  
 * @category   WordPress File
 * @package    Tuairisc.ie Gazeti Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    1.2
 * @link       https://github.com/bhalash/tuairisc.ie
 */

$foluntais = array(
    // Condensed terms-type and taxonomy-for the job type.
    'type' => $custom_post_types[0],
);

$foluntais_options = array(
    // General arguments for the Foluntais custom post type. 
    'description' => __('Tuairisc.ie job listings'),
    'has_archive' => true,
    'labels' => array(
        // Job menu labels.
        'name' => _x('Jobs', 'post type general name'),
        'singlular_name' => _x('Job', 'post type individual name'),
        'add_new' => _x('Add New', 'job'),
        'add_new_item' => __('Add New Job'),
        'edit_item' => __('Edit Job'),
        'new_item' => __('New Job'),
        'menu_name' => __('Jobs'),
        'all_items' => __('All Jobs'),
        'search_items' => __('Search Jobs'),
        'not_found' => __('No jobs found'),
        'not_found_in_trash' => __('No jobs found in the Trash'),
        'parent_item_colon' => '',
    ),
    'menu_position' => 4,
    'public' => true,
    'supports' => array(
        'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'
    ),
    'taxonomies' => array(
        'category', 'post_tag'
    )
);

function register_job_type() {
    /**
     * Register Custom Foluntais Post Type
     * -----------------------------------
     * The site uses a custom post type for their Foluntais section, as the 
     * jobs needs to be differentiated in many ways. 
     * 
     * @param {none}
     * @return {none}
     */

    global $foluntais, $foluntais_options;
    register_post_type($foluntais['type'], $foluntais_options);
    flush_rewrite_rules();
    /* Explicitly remove support for comments because people wound up making
     * snide comments about renumeration. */
    remove_post_type_support($foluntais['type'],'comments');
}

function job_messages($messages) {
    /**
     * Foluntais Error and Update Messages
     * -----------------------------------
     * Error and help messages related to the jobs custom post type.
     *
     * @param {string} $messages
     * @return {string} $messages 
     */

    global $post, $post_ID, $foluntais;
    
    $messages[$foluntais['type']] = array(
        '', 
        sprintf(__('Job updated. <a href="%s">View job</a>', 'wpzoom'), esc_url(get_permalink($post_ID))),
        __('Custom field updated.', 'wpzoom'),
        __('Custom field deleted.', 'wpzoom'),
        __('Job updated.'),
        isset($_GET['revision']) ? sprintf( __('Job restored to revision from %s', 'wpzoom'), wp_post_revision_title( (int) $_GET['revision'], false)) : false,
        sprintf(__('Job published. <a href="%s">View job</a>', 'wpzoom'), esc_url(get_permalink($post_ID))),
        __('Product saved.', 'wpzoom'),
        sprintf(__('Job submitted. <a target="_blank" href="%s">Preview job</a>', 'wpzoom'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        sprintf(__('Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>', 'wpzoom'), date_i18n(__('M j, Y @ G:i',' wpzoom'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        sprintf(__('Job draft updated. <a target="_blank" href="%s">Preview job</a>','wpzoom'), esc_url(add_query_arg('preview','true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}

// Add custom post type for job listings.
add_action('init', 'register_job_type');
add_filter('post_updated_messages', 'job_messages');
?>