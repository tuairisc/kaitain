<div id="recent-posts">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    while (have_posts()) {
        the_post();
        
        if (is_custom_type()) {
            get_template_part('article', 'jobarchive');
        } else {
            get_template_part('article', 'archive');
        }
    } ?>
</div>

<?php get_template_part('pagination'); ?>
<?php wp_reset_query(); ?>