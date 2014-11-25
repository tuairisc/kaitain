<?php get_header(); ?>
<div id="main">
    <div id="content">
          <?php while (have_posts()) : the_post(); ?>
            <div class="post clearfix">
                <div class="entry">
                    <?php the_content(); ?>
                    <div class="clear"></div>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'wpzoom' ) . '</span>', 'after' => '</div>' ) ); ?>
                    <div class="clear"></div>
                    <?php edit_post_link( __('Edit', 'wpzoom'), '', ''); ?>
                </div><!-- / .entry -->
                <div class="clear"></div>
            </div><!-- /.post -->

        <?php endwhile; ?>
    </div><!-- /#content -->
</div><!-- /#main -->
<?php get_footer(); ?>