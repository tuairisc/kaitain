<article id="post-<?php the_ID(); ?>" <?php post_class('article-full'); ?>>

    <header>
        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tuairisc' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<span>', '</span>'); ?>
    </header> 

    <div class="article-body">
        <?php the_content();

        wp_link_pages(array(
            'before' => '<div class="page-link"><span>' . __('Pages:', 'tuairisc') . '</span>', 
            'after' => '</div>'
        ));

        the_tags('<div class="tag-list"><strong>' . __('Tags:', 'tuairisc') . '</strong> ', ', ', '</div>'); ?>
     </div>
</article>