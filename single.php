<?php get_header();
$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
printf('<div id="main"%s>', ($template == 'full') ? ' class="full-width"' : '');
printf('<div id="content">');

while(have_posts()) {
    the_post();

    increment_view_counter(); 
    get_template_part('banner'); 
    get_template_part('article', 'full'); 

    if (option::get('post_related') == 'on' && !is_job()) {
        get_template_part('related-posts'); 
    }

    if (comments_open()) {
        comments_template(); 
    }
}

printf('</div>');

if ($template != 'full') {
    get_sidebar();
} else {
    printf('<div class="clear"></div>');
}

printf('</div>');
get_footer(); ?>