<?php get_header();
$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
printf('<div id="content">');

while(have_posts()) {
    the_post();

    increment_view_counter(); 
    get_template_part('/partials/banner'); 
    get_template_part('/partials/articles/article', 'full'); 

    if (option::get('post_related') == 'on' && !is_custom_type()) {
        get_template_part('related-posts'); 
    }

    if (comments_open()) {
        comments_template(); 
    }
}

printf('</div>');
get_sidebar();
get_footer(); ?>