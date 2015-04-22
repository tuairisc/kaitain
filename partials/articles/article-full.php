<article id="post-<?php the_ID(); ?>" <?php post_class('full'); ?>>
    <header>
        <h1 class="title">
            <a href="<?php the_permalink(); ?>" title="<?php __('Permalink to', 'tuairisc'); the_title_attribute('echo=0'); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1>
        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div>
        <div class="meta">
            <?php if (has_local_avatar()) : ?>
                <div class="avatar" style="background-image: url('<?php echo get_avatar_url(); ?>');"></div>
            <?php endif; ?>

            <div class="text<?php printf('%s', (is_custom_type()) ? ' jobtext' : ''); ?>">
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

                <?php edit_post_link( __('Edit', 'tuairisc'), '<br /><span>', '</span>'); ?>
            </div>
        </div>
    </header> 
    <div class="article-content">
        <div class="article-body">
            <?php the_content(); ?>

            <?php wp_link_pages(array(
                'before' => '<div class="page-link"><span>' . __('Pages:', 'tuairisc') . '</span>', 
                'after' => '</div>'
            )); ?>

            <?php the_tags('<div class="tag-list"><strong>' . __('Tags:', 'tuairisc') . '</strong> ', ', ', '</div>'); ?>
        </div>

        <?php get_template_part('/partials/sharing'); ?>
     </div>
</article>
