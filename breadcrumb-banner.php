 <div class="breadcrumb-banner <?php echo get_breadcrumb_class(); ?>" style="<?php get_breadcrumb_style();?>">
    <?php if (has_unique_breadcrumb_style()) : ?>

        <?php if (is_single()) : ?>
            <?php // single post ?>
        <?php else : ?>
            <span><?php echo category_description(); ?></span>
        <?php endif; ?>

    <?php else : ?>

        <?php if (is_single()) : ?>            
            <?php // single post ?>
        <?php else : ?>
            <?php echo get_category_parents(get_query_var('cat'), true, '&nbsp;'); ?>
        <?php endif; ?> 

    <?php endif; ?>
</div>