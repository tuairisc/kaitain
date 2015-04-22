<?php get_header(); ?>
    <div id="content">
        <?php if (is_home() && $paged < 2) : ?>
            <?php get_template_part('featured'); ?>

            <div class="home-widgets">
                <?php dynamic_sidebar('home-main') ?>
            </div>
            <div class="home-widgets three-columns">
                <?php dynamic_sidebar('home-columns') ?>
            </div>
        <?php endif; ?>
    </div> <?php // End #content ?>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>