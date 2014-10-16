<div class="breadcrumb-banner <?php echo get_breadcrumb_class(); ?>" style="<?php get_breadcrumb_style();?>">
    <?php if (has_unique_breadcrumb_style()) : ?>
        <span><?php echo category_description(); ?></span>
    <?php else : ?>
        <?php echo get_category_parents(get_query_var('cat'), true, '&nbsp;'); ?>
    <?php endif; ?>
</div>