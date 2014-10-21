<?php $share = array(
    'blog'  => urlencode(get_bloginfo('name')),
    'title' => rawurlencode(get_the_title()),
    'thumb' => urlencode(get_thumbnail_url()),
    'url'   => urlencode(get_the_permalink()),
    'via'   => urlencode('tuairiscnuacht')
); ?> 

<script>console.log('<?php echo $share["thumb"]; ?>');</script>

<div class="msv">
    <ul>
        <li><a 
            class="email" 
            href="mailto:?subject=<?php echo $share['title']; ?>&body=<?php echo $share['url']; ?>" 
            rel="0" 
            target="_blank"  
            title="Email '<?php the_title(); ?>'"
        ></a></li>

        <li><a 
            class="facebook" 
            href="//facebook.com/sharer.php?u=<?php echo $share['url'] ?>" 
            rel="1" 
            target="_blank" 
            title="Share '<?php the_title(); ?>' on Facebook"
        ></a></li>

        <li><a
            class="twitter"
            href="//twitter.com/share?url=<?php echo $share['url']; ?>&text=<?php echo $share['title']; ?>&via=<?php echo $share['via']; ?>"
            rel="2"
            target="_blank"
            title="Tweet about '<?php the_title(); ?>"
        ></a></li>

        <li><a
            class="pinterest"
            href="http://www.pinterest.com/pin/create/button/?url=<?php echo $share['url']; ?>&media=<?php echo $share['thumb']; ?>&description=abcdefg"
            rel="3"
            target="_blank"
            title="Pin '<?php the_title(); ?>' on Pinterest!"
        ></a></li>

        <li><a 
            class="reddit" 
            href="//reddit.com/submit?url=<?php echo $share['url']; ?>&title=<?php echo $share['title']; ?>" 
            rel="4"
            target="_blank"
            title="Upvote '<?php the_title(); ?>' on Reddit"
        ></a></li>

        <li><a 
            class="tumblr" 
            href="//tumblr.com/share/link?url=<?php echo $share['url']; ?>&name=<?php echo $share['title']; ?>" 
            rel="5"
            target="_blank"
            title="Tumblog '<?php the_title(); ?>' on Tumblr"
        ></a></li>
    </ul>
</div>