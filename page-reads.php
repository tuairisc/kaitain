<?php
/*
Template Name: Most Read Posts
*/
?>
<?php get_header(); ?>
<div id="main">
    <style type="text/css">
        div#content {
            width: 100%;
        }
    </style>
    <div id="content">

        <?php 
            $key = 'tuairisc_view_counter';

            $viewed_query = new WP_Query(array(
                // Gallery category. The crappy gallery plugin reloads the article every time you view a different image.
                // The end result is that gallery posts have a vastly inflated count.
                'cat'            => -184,
                'post_type'      => 'post',
                'meta_key'       => $key, 
                'posts_per_page' => 50,
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            )); 

            $n = 1;
        ?>

        <?php if ($viewed_query->have_posts()) : ?>
            <table class="tg">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Post Date</th>
                    <th>Views</th>
                    <th>Edit</th>
                </tr>
                <?php while ($viewed_query->have_posts()) : ?>
                    <?php $viewed_query->the_post(); ?>
                    <tr>
                        <td><?php echo $n++; ?></td>
                        <td><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td><?php the_author_posts_link(); ?></td>     
                        <td><?php echo get_the_date(); ?></td>     
                        <td><?php echo get_post_meta(get_the_ID(), $key, true); ?></td>
                        <?php edit_post_link( __('Edit', 'wpzoom'), '<td>', '</td>'); ?>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
        
        <?php wp_reset_query(); ?>

        <div class="post clearfix">
            <div class="entry"></div><!-- / .entry -->
        </div><!-- /.post -->
    </div><!-- /#content -->
</div><!-- /#main -->
<?php get_footer(); ?>