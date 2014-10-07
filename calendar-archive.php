<?
    /*
    Template Name: Calendar Archive Template
    */
?>

<?php get_header(); ?>

<div id="main">

    <div id="content">
        <?php while (have_posts()) : the_post(); ?>

            <div class="post clearfix">

                <div class="entry">
                    <h1><? the_title(); ?></h1>
                    <h2>Browse by date</h2>

                    <?php // Call archive calendar
                        $args= array(
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
                    
                    <div class="clear"></div>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'wpzoom' ) . '</span>', 'after' => '</div>' ) ); ?>
                    <div class="clear"></div>
                    <?php edit_post_link( __('Edit', 'wpzoom'), '', ''); ?>
                </div><!-- / .entry -->
                <div class="clear"></div>
         
            </div><!-- /.post -->        
        <?php endwhile; ?>

    </div><!-- /#content -->
    
    <?php get_sidebar();  ?>

</div><!-- /#main -->
<?php get_footer(); ?>