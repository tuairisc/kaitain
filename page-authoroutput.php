<?php 
/*
Template Name: Author Report Output
*/

/* Author Report Output v2
* -------------------------
* This report was requested by Emer for accounting purposes. 
* In order to pay each author or contributor, Emer must see
* articles posted in an inclusive period, along with word count
* (and helpfully views) too. 
* 
* The author report currently outputs information in a tabulated 
* manner:
* 
* Author Name
* -----------
* Article ID | Article Title | Article Date | Views | Word Count
* 
*/

// Sanitize input into array of start and end dates.
if (empty($_POST)) {
    printf('<script>window.location = %s;</script>', get_site_url());
    return;
}

$dates = array();

$all_author_info = array(
    array(
        0 => 'Author Name',
        1 => 'Post Title',
        2 => 'Post Category',
        3 => 'Post Date',
        4 => 'Post Time',
        5 => 'View Count',
        6 => 'Word Count'
    )
);

foreach ($_POST as $key => $field) {
    $dates[$key] = filter_var($field, FILTER_SANITIZE_NUMBER_INT);
}

// Get list of all site authors.
$author_list = get_users(array(
    'blog_id' => $GLOBALS['blog_id'],
    'orderby' => 'display_name',
    'order' => 'ASC',
));

foreach ($author_list as $author) {
    $id = $author->ID;

    $author_query = new WP_Query(array(
        'author' => $id,
        'posts_per_page' => -1,
        'order' => 'ASC',
        'date_query' => array(
            'after' => array(
                'year' => $dates['start_year'],
                'month' => $dates['start_month'],
                'day' => $dates['start_day'],
            ),
            'before' => array(
                'year' => $dates['end_year'],
                'month' => $dates['end_month'],
                'day' => $dates['end_day'],                                    
            ),
            'inclusive' => true,
        ),
    )); 

    $counter = 1;

    // If the author has posts in the period, output them in a tabulated manner.
    if ($author_query->have_posts()) {
        while ($author_query->have_posts()) {
            $author_query->the_post();
            $category = get_the_category();
            $category = $category[0]->cat_name;

            array_push($all_author_info, array(
                'author_name' => $author->display_name,
                'post_title' => $post->post_title,
                'post_category' => $category,
                'post_date' => get_the_time('Y-m-d'),
                'post_time' => get_the_time('H:i:s'),
                'view_count' => get_view_count(get_the_ID()),
                'word_count' => str_word_count(strip_tags(get_the_content()), 0)
            ));
        }
    }

    wp_reset_query();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=author_report_' . date('YmdHis') . '_.csv');
$output = fopen('php://output', 'w');

foreach ($all_author_info as $field) {
    fputcsv($output, $field);
}
?>