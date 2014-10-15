<?php
    $loop = new WP_Query(
    array(
        'post__not_in' => get_option( 'sticky_posts' ),
        'posts_per_page' => option::get('featured_number'),
        'meta_key' => 'wpzoom_is_featured',
        'meta_value' => 1
    ) );
?>

<div id="slider"<?php if (option::get('featured_full') == 'on') echo ' class="full"';?>>
 
    <div id="slides">

        <?php
        $i = 0;
        if ( $loop->have_posts() ) : ?>

        <ul class="slides">

            <?php rewind_posts();
            while ( $loop->have_posts() ) : $loop->the_post(); $i++; 
            $video = get_post_meta( $post->ID, 'wpzoom_post_embed_code', true ); ?>

               <li class="post-<?php the_ID(); ?>">

                <?php 
                     if (option::get('featured_full') == 'on') { 

                        if ( strlen( $video ) > 1 ) {
                            echo '<div class="video_cover">' . embed_fix( $video, 800, 475 ) . '</div>'; 
                        } 
                        else {
                            get_the_image( array( 'size' => 'slider-full', 'width' => 800, 'height' => 475) );
                        }

                    } else {

                        if ( strlen( $video ) > 1 ) {
                            echo '<div class="video_cover">' . embed_fix( $video, 520, 293 ) . '</div>'; 
                        } 
                        else {
                             get_the_image( array( 'size' => 'slider', 'width' => 520, 'height' => 475) );
                         }
                     }
                ?>

                <div class="slide_content<?php if ( strlen( $video ) > 1 ) { echo "_video-enabled"; } ?>">
                    <div class="slide_content_holder">
                        <!--<span class="date"><?php echo get_the_date(); ?></span>-->
                        <div class="clear"></div>
                        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                     </div>
                 </div>

            </li><?php endwhile; ?>
            <div class="clear"></div>

         </ul><!-- /.slides -->

        <?php else : ?>

        <div class="notice">
            There are no featured posts. Start marking posts as featured, or disable the slider from <strong><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpzoom_options">Theme Options</a></strong>. <br />
            For more information please <strong><a href="http://www.wpzoom.com/documentation/gazeti/">read the documentation</a></strong>.
        </div><!-- /.notice -->

         <?php endif; ?>

    </div><!-- /#slides -->

    <?php
    $i = 0;
    if ( $loop->have_posts() ) : ?>

    <div id="slider_nav">
        <div class="tiles">
            <?php
            $first = true;
            while ( $loop->have_posts() ) : $loop->the_post();  ?>

                <div class="item<?php echo $first ? ' current' : ''; ?> post-<?php the_ID(); ?>">
                     <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                        <?php if( has_post_format('video')){ echo '<span class="video-icon"></span>'; }?>
                    </a>
                    <div class="clear"></div>

                </div>
            <?php
            $first = false;
            endwhile; ?>
        </div>
    </div>

    <?php endif; ?>
  
     <div class="clear"></div>
 
</div><!-- /#slider -->
<div class="clear"></div>

<?php wp_reset_query(); ?>