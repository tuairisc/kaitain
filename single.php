<?php get_header(); ?>

<div id="content">
    <?php while(have_posts()) {
        the_post();

        increment_view_counter(); 
        get_template_part('/partials/articles/article', 'full'); 

        if (!is_custom_type()) {
            get_template_part('related-posts'); 
        }

        if (comments_open()) {
            comments_template(); 
        }
    } ?>
</div>

<?php get_sidebar();
get_footer(); ?>