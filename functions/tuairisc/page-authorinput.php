<?php
/**
 * Template Name: Better Author Report
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
*/

get_header();
$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
printf('<div id="main"%s>', ($template == 'full') ? ' class="full-width"' : '');
printf('<div id="content">');?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-full'); ?>>
    <header>
        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tuairisc' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<span>', '</span>'); ?>
    </header> 
    <div class="article-body">
        <?php  
        /* Author Report Input v2
        * ------------------------------
        * This report was requested by Emer for accounting purposes. 
        * In order to pay each author or contributor, Emer must see
        * articles posted in an inclusive period, along with word count
        * (and helpfully views) too. 
        * 
        * The author report currently outputs information in a tabulated 
        * manner:
        * 
        * Author Name
        * -----------
        * Article ID | Article Title | Article Date | Views | Word Count
        * 
        * page-authorreport.php takes its input from page-authorform.php
        * 
        */ 
        ?>
        <form id="author-report" method="post" action="<?php echo site_url() . '/author-output/'; ?>" novalidate>
            <p id="author-error"></p>
            <p>
                <strong>Start date:</strong><br />
                <input type="text" id="start-day" name="start_day" pattern="^([1-9]|[12]\d|3[01])$" placeholder="dd" size="2" width="2" required>
                <input type="text" id="start-month" name="start_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm" size="2" width="2" required>
                <input type="text" id="start-year" name="start_year" pattern="^(19|20)[0-9]{2}$" placeholder="yyyy" size="4" width="4" required>
            </p>
            <p>
                <strong>End date:</strong><br />
                <input type="text" id="end-day" name="end_day" pattern="^([1-9]|[12]\d|3[01])$" placeholder="dd" size="2" width="2" required>
                <input type="text" id="end-month" name="end_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm" size="2" width="2" required>
                <input type="text" id="end-year" name="end_year" pattern="^(19|20)[0-9]{2}$" placeholder="yyyy" size="4" width="4" required>
            </p>
            <input type="submit">
        </form>

        <?php wp_link_pages(array(
            'before' => '<div class="page-link"><span>' . __('Pages:', 'tuairisc') . '</span>', 
            'after' => '</div>'
        )); ?>

        <?php if (option::get('post_tags') == 'on') : ?>
            <?php the_tags('<div class="tag-list"><strong>' . __('Tags:', 'tuairisc') . '</strong> ', ', ', '</div>'); ?>
        <?php endif; ?>

     </div>
</article>

<?php printf('</div>');

if ($template != 'full') {
    get_sidebar();
} else {
    printf('<div class="clear"></div>');
}

printf('</div>');
get_footer(); ?>