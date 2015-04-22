<article id="post-<?php the_ID(); ?>" <?php post_class('featured'); ?>>
    <header>
        <div class="tuairisc-featured-thumb" style="background-image: url('<?php echo get_thumbnail_url(get_the_ID(), 'medium'); ?>');">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> </a>
        </div>
        <h5 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
    </header>
</article>