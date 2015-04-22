<article id="post-<?php the_ID(); ?>" <?php post_class('lead'); ?>>
    <header>
        <?php if (has_post_thumbnail()) : ?>
            <div class="article-thumb" style="background-image: url('<?php echo get_thumbnail_url(); ?>'); ">
                <?php printf('<a href="%s" title="%s"></a>', get_the_permalink(), the_title_attribute('echo=0')); ?>
            </div>
        <?php endif; ?>
        <?php printf('<h2 class="title"><a href="%s" rel="bookmark" title="%s">%s</a></h2>',
            get_the_permalink(),
            the_title_attribute('echo=0'),
            get_the_title()
        );

        if (option::get('post_date') == 'on' || option::get('post_author') == 'on') {
            if (option::get('post_author') == 'on' && !is_default_author()) { 
                printf(
                    '<h6 class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></h6>',
                    get_author_posts_url(get_the_author_meta('ID')),
                    get_the_author_meta('display_name'),
                    get_the_author_meta('display_name')
                );
            }

            if (option::get('post_date') == 'on') {
                printf('<span class="header-date">%s</span>', get_the_date());
            }
        } ?>
    </header>

    <div class="article-body">
        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>
</article>
