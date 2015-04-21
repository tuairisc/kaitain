<?
/*
Template Name: Calendar Archive Template
*/
?>

<?php get_header(); ?>

<div id="content">
    <?php while (have_posts()) : the_post(); ?>
        <div class="post">
            <div class="entry">
                <h1><? the_title(); ?></h1>
                <h2>Browse by date</h2>

                <?php // Call archive calendar
                $args = array(
                    'next_text' => '>',
                    'prev_text' => '<',
                    'post_count' => true,
                    'month_view' => true
                ); ?>

                <?php archive_calendar($args); ?>

                <h2>Browse by keyword</h2>
                
                <?php if (option::get('searchform_enable') == 'on') { ?>
                    <div class="search_form">
                        <?php get_search_form(); ?>
                    </div>
                <?php } ?>
                
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'wpzoom' ) . '</span>', 'after' => '</div>' ) ); ?>
                <?php edit_post_link( __('Edit', 'wpzoom'), '', ''); ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>