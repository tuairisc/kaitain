<article id="post-<?php the_ID(); ?>" <?php post_class('article-full'); ?>>

    <header>
        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
    </header> 

    <div class="article-body">
        <?php the_content(); ?>

        <?php wp_link_pages(array(
            'before' => '<div class="page-link"><span>' . __('Pages:', 'wpzoom') . '</span>', 
            'after' => '</div>'
        )); ?>

        <?php if (option::get('post_tags') == 'on') : ?>
            <?php the_tags('<div class="tag-list"><strong>' . __('Tags:', 'wpzoom') . '</strong> ', ', ', '</div>'); ?>
        <?php endif; ?>

     </div>
</article>