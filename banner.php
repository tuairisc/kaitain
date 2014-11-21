<div class="breadcrumb-banner <?php banner_class(); ?>" style="<?php banner_color(); ?>">
        <?php if (is_category()) : ?>

            <?php if (unique_breadcrumb()) : ?>
                <?php echo '<script>console.log("special category");</script>'; ?>
            <?php else : ?>
                <?php echo get_breadcrumb(); ?>
            <?php endif; ?>

        <?php elseif (is_foluntais()) : ?>

            <?php echo get_breadcrumb(); ?>

        <?php elseif (is_single()) : ?>

            <?php echo get_breadcrumb(); ?>

        <?php endif; ?>
</div>