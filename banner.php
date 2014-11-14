<div class="breadcrumb-banner <?php banner_class(); ?>" style="<?php banner_color(); ?>">
    <?php if (is_single() || is_category() && !unique_breadcrumb()) {
        echo get_breadcrumb();
    } else if (unique_breadcrumb()) { ?>
        <a href="javascript:void(0)">yolo</a>
    <?php } ?>
</div>