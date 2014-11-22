<ul class="mshare">
    <?php $share = array(
        'blog'  => urlencode(get_bloginfo('name')),
        'url'   => urlencode(get_the_permalink()),
        'title' => rawurlencode(get_the_title()),
        'tuser' => urlencode('tuairiscnuacht')
    ); ?> 

    <li>
        <a class="email" 
        href="mailto:?subject=<?php echo $share['title']; ?>&amp;body=<?php echo $share['url']; ?>" 
        data-rel="0" 
        target="_blank"  
        title="Email '<?php the_title(); ?>'"></a>
    </li>
    <li>
        <a class="facebook" 
        href="//facebook.com/sharer.php?u=<?php echo $share['url'] ?>" 
        data-rel="1" 
        target="_blank" 
        title="Share '<?php the_title(); ?>' on Facebook"></a>
    </li>
    <li>
        <a class="google"
        href="//plus.google.com/share?url=<?php echo $share['url']; ?>" 
        data-rel="2" 
        target="_blank"
        title="+1 '<?php the_title(); ?>"></a>
    </li>
    <li>
        <a class="twitter"
        href="//twitter.com/share?via=<?php echo $share['tuser']; ?>&text=<?php echo $share['title']; ?>&url=<?php echo $share['url']; ?>"
        data-rel="3"
        target="_blank"
        title="Tweet about '<?php the_title(); ?>'"></a>
    </li>
    <li>
        <a class="reddit" 
        href="//reddit.com/submit?url=<?php echo $share['url']; ?>&title=<?php echo $share['title']; ?>" 
        data-rel="5"
        target="_blank"
        title="Upvote '<?php the_title(); ?>' on Reddit"></a>
    </li>
    <?php if (is_single() && option::get('post_comments') == 'on') : ?>
        <li>
            <a class="comments"
            href="#comments" 
            data-rel="-1" 
            title="Read comments on <?php echo $post->post_title; ?>"></a>
        </li>
    <?php endif; ?>
</ul>