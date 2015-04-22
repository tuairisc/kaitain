<?php

/**
 * Foluntais Job Archive
 * ---------------------
 * Generate the archive list for the Foluntais category of the Tuairisc.ie site.
 *  
 * @category   WordPress File
 * @package    Tuairisc.ie Gazeti Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2014-2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('jobarchive'); ?>>
    <?php if (is_columnist_article() && has_local_avatar()) {
        $thumbnail_url = get_avatar_url(get_the_author_meta('ID'), 200);
    } else if (option::get('index_thumb') == 'on') {
        $thumbnail_url = get_thumbnail_url();
    } 
    
    $category = get_the_category();
    $category = $category[0]->name;
    ?>

    <div class="category">
        <span class="job-category"><?php printf($category); ?></span>

        <div class="article-thumb" style="background-image: url('<?php echo $thumbnail_url; ?>');">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
        </div>
    </div>

    <div class="article-body">                     
        <header>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('%s', 'tuairisc'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="text">
                <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') {
                    if (option::get('post_author') == 'on' && !is_default_author()) { 
                        $location = get_post_meta($post->ID, 'foluntais_location', true); 
                        printf('<h6 class="article-author">%s</h6>', get_post_meta($post->ID, 'foluntais_employer', true));
                    }

                    if (option::get('post_date') == 'on') {
                        printf('<span class="header-date">%s</span>', get_the_date());
                    }
                } ?>
            </div> 
        </header>
        <?php the_excerpt(); ?>
        <span class="more"><a href="<?php the_permalink(); ?>">Léigh Tuilleadh</a></span>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<br /><span>', '</span>'); ?>
    </div>
</article>