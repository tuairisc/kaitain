<?php get_header(); ?>

<div id="content">
    <?php while(have_posts()) {
        the_post();
        increment_view_counter(); 
        get_template_part('/partials/articles/article', 'page'); 
    } ?>
</div>

<?php get_sidebar();
get_footer(); ?>