<?php get_header(); ?>
<div id="main" role="main">
    <div id="content"> 
          <div class="post">
            <div class="entry">
                <?php if (have_posts()) the_post(); ?>
                <h1><?php _e('Aistear amú – tada anseo', 'wpzoom'); ?></h1> 
                <h3><?php _e('Ní bhfuarthas an leathanach atá á lorg agat.', 'wpzoom');?> </h3>
            </div><!-- / .entry -->
        </div><!-- /.post -->
    </div><!-- /#content -->
 
    <?php get_sidebar(); ?>
               
</div> <!-- /#main -->
<?php get_footer(); ?>