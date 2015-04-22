<?php global $post; ?>

<ul class="sharing">
    <?php sharing_links('print, facebook, twitter, google, email', true); ?>

    <?php if (is_singular('post') && comments_open()) {
        sharing_links('discuss', true);
    } ?>
</ul>