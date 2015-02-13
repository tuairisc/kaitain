<div id="recent-posts">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    while (have_posts()) {
        the_post();
        
        if (is_job()) {
            get_template_part('article', 'jobarchive');
        } else {
            get_template_part('article', 'archive');
        }

        if ($wp_query->current_post == 0 && $paged == 1 && !is_job()) {
            // Change the first article in the stack to the hero type (image is bigger and the position reversed).
            ?><script>
                jQuery('#recent-posts').find('article').first().addClass('leadarchive');
            </script><?php
        }
    } ?>
</div>

<?php get_template_part('pagination'); ?>
<?php wp_reset_query(); ?>