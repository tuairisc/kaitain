<?php

/**
 * Archive Lead Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

global $sections;

$trim = $sections->get_section_slug(get_the_category()[0]);

$trim = array(
    'text' => sprintf('section-%s-text-hover', $trim),
    'background' => sprintf('section-%s-background', $trim)
);

?>

<article <?php post_class('archive-lead'); ?> id="archive-lead-<?php the_id(); ?>">
    <a class="archive-lead-link <?php printf($trim['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_home_feature_lead', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['background']); ?>"></div>
        </div>
        <h1 class="title archive-lead-title"><?php the_title(); ?></h1>
    </a>
    <header>
        <h4 class="attribution"><a href="<?php printf(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></h4>
        <span class="post-date"><small><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></small></span>
    </header>
    <p class="post-excerpt archive-lead-excerpt"><?php printf(get_the_excerpt()); ?></p>
</article>
<hr>
