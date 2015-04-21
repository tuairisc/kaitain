<article id="post-<?php the_ID(); ?>" <?php post_class('full'); ?>>
    <header>
        <h1 class="title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div>
        <div class="meta">
            <?php if (has_local_avatar()) : ?>
                <div class="avatar" style="background-image: url('<?php echo get_avatar_url(); ?>');"></div>
            <?php endif; ?>

            <div class="text<?php printf('%s', (is_custom_type()) ? ' jobtext' : ''); ?>">
                <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') {
                    if (option::get('post_author') == 'on' && !is_default_author() && !is_custom_type()) { 
                        printf(
                            '<span class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></span><br />',
                            get_author_posts_url(get_the_author_meta('ID')),
                            get_the_author_meta('display_name'),
                            get_the_author_meta('display_name')
                        );
                    }

                    if (option::get('post_date') == 'on') {
                        printf('<span class="header-date">%s ag %s</span>', get_the_date(), get_the_time());
                    }
                } 

                edit_post_link( __('Edit', 'wpzoom'), '<br /><span>', '</span>'); ?>
            </div>
            <?php get_template_part('/partials/sharing'); ?>
        </div>
    </header> 
    <div class="article-body">
        <?php the_content(); get_template_part('/partials/sharing'); ?>

        <?php wp_link_pages(array(
            'before' => '<div class="page-link"><span>' . __('Pages:', 'wpzoom') . '</span>', 
            'after' => '</div>'
        )); ?>

        <?php if (option::get('post_tags') == 'on') : ?>
            <?php the_tags('<div class="tag-list"><strong>' . __('Tags:', 'wpzoom') . '</strong> ', ', ', '</div>'); ?>
        <?php endif; ?>
     </div>
</article>
