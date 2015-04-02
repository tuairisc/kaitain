<article id="post-<?php the_ID(); ?>" <?php post_class('jobarchive'); ?>>
    <?php if (is_columnist_article() && has_local_avatar()) {
        $thumbnail_url = get_avatar_url(get_the_author_meta('ID'), 200);
    } else if (option::get('index_thumb') == 'on') {
        $thumbnail_url = get_thumbnail_url();
    } ?>

    <div class="category">
        <span class="job-category" style="<?php job_category_color(); ?>"><?php echo job_category_name(); ?></span>

        <div class="article-thumb" style="background-image: url('<?php echo $thumbnail_url; ?>');">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
        </div>
    </div>

    <div class="article-body">                     
        <header>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('%s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="text">
                <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') {
                    if (option::get('post_author') == 'on' && !is_default_author()) { 
                        $location = get_post_meta($post->ID, 'foluntais_location', true); 
                        printf('<h3 class="article-author">%s</h3>', get_post_meta($post->ID, 'foluntais_employer', true));
                    }

                    if (option::get('post_date') == 'on') {
                        printf('<span class="header-date">%s</span>', get_the_date());
                    }
                } ?>
            </div> 
        </header>
        <?php the_excerpt(); ?>
        <span class="more"><a href="<?php the_permalink(); ?>">Léigh Tuilleadh</a></span>
        <?php edit_post_link( __('Edit', 'wpzoom'), '<br /><span>', '</span>'); ?>
    </div>
</article>
