<?php $share = array(
    'blog'  => urlencode(get_bloginfo('name')),
    'url'   => urlencode(get_the_permalink()),
    'title' => rawurlencode(get_the_title()),
    'via' => urlencode('tuairiscnuacht')
); ?> 

<div class="msv">
    <ul>
        <li><a 
            class="email" 
            href="mailto:?subject=<?php echo $share['title']; ?>&amp;body=<?php echo $share['url']; ?>" 
            rel="0" 
            target="_blank"  
            title="Email '<?php the_title(); ?>'"
        ></a></li>

        <li><a 
            class="facebook" 
            href="https://www.facebook.com/sharer.php?u=<?php echo $share['url'] ?>" 
            rel="1" 
            target="_blank" 
            title="Share '<?php the_title(); ?>' on Facebook"
        ></a></li>

        <li><a
            class="twitter"
            href="https://twitter.com/share?via=<?php echo $share['via']; ?>&text=<?php echo $share['title']; ?>&url=<?php echo $share['url']; ?>"
            rel="2"
            target="_blank"
            title="Tweet about '<?php the_title(); ?>"
        ></a></li>

        <li><a class="pinterest"></a></li>
        <li><a class="tumblr"></a></li>
    </ul>
</div>