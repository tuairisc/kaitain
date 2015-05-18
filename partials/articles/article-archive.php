<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?>>
    <div class="article-thumb">
        <?php get_the_image(array(
            'meta_key' => 'thumbnail',
            'size' => 'medium',
            'width' => 10
        )); ?>
    </div>

    <div class="article-body">                     
        <header>
            <h2 class="title">
                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="text">
                <?php if (!is_default_author()) { 
                    printf('<h6 class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></h6>',
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

        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<span>', '</span>'); ?>
    </div>
</article>