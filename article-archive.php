<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?>>
    <?php if (is_columnist_article() && has_local_avatar()) {
        $thumbnail_url = get_avatar_url(get_the_author_meta('ID'), 200);
    } else if (option::get('index_thumb') == 'on') {
        $thumbnail_url = get_thumbnail_url();
    } ?>

    <div class="article-thumb" style="background-image: url('<?php echo $thumbnail_url; ?>');">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
    </div>

    <div class="article-body">                     
        <header>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('%s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="text">
                <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') {
                    if (option::get('post_author') == 'on' && !is_default_author()) { 
                        printf(
                            '<h3 class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></h3>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            get_the_author_meta('display_name'),
                            get_the_author_meta('display_name')
                        );
                    }

                    if (option::get('post_date') == 'on') {
                        printf('<span class="header-date">%s</span>', get_the_date());
                    }
                } ?>
            </div> 
        </header>
        <div class="exerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
    </div>
</article>
