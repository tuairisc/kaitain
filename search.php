<?php get_header();
$total_results = $wp_query->found_posts; ?>

<div id="content">
    <h1 class="archive-title">
        <?php _e('Torthaí cuardaigh le haghaidh','wpzoom');?> <strong>"<?php the_search_query(); ?>"</strong><?php printf(': %s ', $total_results); ?>
    </h1>

    <?php get_template_part('loop'); ?>
</div>
        
<?php get_sidebar(); ?>
<?php get_footer(); ?>