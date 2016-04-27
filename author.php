<?php

/**
 * Auhor Template
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

get_header();

$page_number = intval(get_query_var('paged'));
$author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

?>

<div class="author author__profile">
    <div class="avatar">
        <?php kaitain_avatar_background_html($author->ID, 'tc_post_avatar', 'author__photo author-photo'); ?>
    </div>
    <div class="author__wrap">
        <h1 class="author__name">
            <span class="author-link">
                <a class="green-link--hover" href="<?php printf(get_author_posts_url($author->ID)); ?>"><?php printf($author->display_name); ?></a>
            </span>
    </div>
</div>
<hr>

<?php

if (have_posts()) {
    while (have_posts()) {
        the_post();
       kaitain_partial('article', 'archive');
    }
}

kaitain_partial('pagination', 'site');
get_footer();

?>
