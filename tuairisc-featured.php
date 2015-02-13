<?php
$query = new WP_Query(array(
    'post__not_in' => get_option('sticky_posts'),
    'posts_per_page' => 9,
    'paged' => 0,
    'meta_key' => 'wpzoom_is_featured',
    'meta_value' => 1
));

$class = array(
    'parent' => 'tuairisc-featured',
    'row' => 'tuairisc-featured-row',
    'block' => 'tuairisc-featured-block'
);

if ($query->have_posts()) {
    printf('<div class="%s">', $class['parent']);

    while ($query->have_posts()) {
        $query->the_post();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ($query->current_post == 0 && $paged == 1) {
            // Call lead article.
            get_template_part('article', 'lead');
        } else {
            if ($query->current_post % 4 == 1) {
                printf('<div class="%s">', $class['row']);
            }
            
            if ($query->current_post % 2 == 1) {
                printf('<div class="%s">', $class['block']);
            }

            // Call secondary article.
            get_template_part('article', 'featured');

            if ($query->current_post % 2 == 0) {
                printf('</div>');
            }

            if ($query->current_post % 4 == 0) {
                printf('</div>');
            }
        }
    }

    printf('</div>');
} ?>