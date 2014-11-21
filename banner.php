<div class="breadcrumb-banner <?php banner_class(); ?>" style="<?php banner_color(); ?>">
        <?php if (is_category()) : ?>

            <?php if (unique_breadcrumb()) : ?>
                <span><?php echo category_description(); ?></span>
            <?php else : ?>
                <?php echo get_breadcrumb(); ?>
            <?php endif; ?>

        <?php elseif (is_foluntais() || is_single()) : ?>
            <?php echo get_breadcrumb(); ?>
        <?php endif; ?>
</div>