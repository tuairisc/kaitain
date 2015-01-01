<?php
    $featured_query = new WP_Query(array(
        'post__not_in' => get_option( 'sticky_posts' ),
        'posts_per_page' => option::get('featured_number'),
        'meta_key' => 'wpzoom_is_featured',
        'meta_value' => 1
    ));
?>

<div id="slider" <?php if (option::get('featured_full') == 'on') echo ' class="full"'; ?>> 
    <div id="slides">
        
        <?php if ($featured_query->have_posts()) : ?>
            <?php $i = 0; ?>
            <ul class="slides">

                <?php rewind_posts();

                while ($featured_query->have_posts()) : ?>
                
                    <?php $featured_query->the_post(); 
                    $i++; 
                    $video = get_post_meta($post->ID, 'wpzoom_post_embed_code', true); ?>

                    <li class="post-<?php the_ID(); ?>">

                        <?php if (option::get('featured_full') == 'on') :
                            if (strlen($video) > 1) {
                                echo '<div class="video_cover">' . embed_fix($video, 800, 475) . '</div>'; 
                            } else {
                                get_the_image(array(
                                    'size' => 'slider-full',
                                    'width' => 800, 
                                    'height' => 475
                                ));
                            }
                        else : 
                            if ( strlen($video) > 1) {
                                echo '<div class="video_cover">' . embed_fix($video, 520, 293) . '</div>'; 
                            } 
                            else {
                                get_the_image(array(
                                    'size' => 'slider',
                                    'width' => 520,
                                    'height' => 475
                                ));
                            }
                        endif; ?>

                        <div class="slide_content<?php if (strlen($video) > 1) echo '_video-enabled'; ?>">
                            <div class="slide_content_holder">
                                <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            </div>
                        </div>
                    </li>

                <?php endwhile; ?>

            </ul>
        <?php endif; ?>
    </div>

    <?php if ($featured_query->have_posts()) : ?>
        <?php $i = 0; ?>

        <div id="slider_nav">
            <div class="tiles">
                <?php $first = true;

                while ($featured_query->have_posts()) : 

                    $featured_query->the_post(); ?>
                    <div class="item<?php echo $first ? ' current' : ''; ?> post-<?php the_ID(); ?>">
                         <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_title(); ?>
                            <?php if (has_post_format('video')) echo '<span class="video-icon"></span>'; ?>
                        </a>
                        <div class="clear"></div>
                    </div>
                    <?php $first = false;

                endwhile; ?>
            </div>
        </div>

    <?php endif; ?> 
</div>
<?php wp_reset_query(); ?>