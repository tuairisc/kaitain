<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?>>

    <?php if (is_columnist_article() && has_local_avatar()) {
        $thumbnail_url = get_avatar_url(get_the_author_meta('ID'), 200);
    } else {
        $thumbnail_url = get_thumbnail_url();
    } ?>

    <div class="article-thumb" style="background-image: url('<?php printf($thumbnail_url); ?>');">
        <a href="<?php the_permalink(); ?>" title="<?php __('Permalink to', 'tuairisc'); the_title_attribute('echo=0'); ?>" rel="bookmark"><?php the_title(); ?></a>
    </div>

    <div class="article-body">                     
        <header>
            <h2 class="title">
                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('%s', 'tuairisc'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="text">
                    <?php if (!is_default_author()) { 
                        printf(
                            '<h6 class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></h6>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            get_the_author_meta('display_name'),
                            get_the_author_meta('display_name')
                        );
                    } ?>

                <span class="header-date">
                    <?php the_date(); ?> ag <?php the_time(); ?>
                </span>
            </div> 
        </header>
        <div class="exerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<span>', '</span>'); ?>
    </div>
</article>
