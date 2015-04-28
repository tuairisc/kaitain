<?php 
/**
 * Site Archive Template
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
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

<div id="content">
    <?php 
    if (is_author()) {
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    }

    if (!is_category() && !is_custom_type()) {
        printf('<h6>');

        if(is_tag()) {
            // Tag archive. 
            _e('Míreanna clibeáilte le:', 'tuairisc');
            single_tag_title();
        } else if (is_day()) { 
            // Daily archive. 
            _e('Cartlann do', 'tuairisc');
            the_time('F jS, Y'); 
        } else if (is_month()) { 
            // Monthly archive. 
            _e('Cartlann do', 'tuairisc');
            the_time('F, Y'); 
        } else if (is_year()) {
            // Yearly archive. 
            _e('Cartlann do', 'tuairisc'); 
            the_time('Y'); 
        } else if (is_author()) { 
            // Author archive. 
            _e('Altanna le: ', 'tuairisc');
            printf('<a href="%s">%s</a>', $curauth->user_url, $curauth->display_name);  
        }else if (isset($_GET['paged']) && !empty($_GET['paged'])) {
            // Paged archive. 
            _e('Mireanna', 'tuairisc'); 
        }

        printf('</h6>');
    } ?>
    
    <div id="recent-posts">

        <?php while (have_posts()) {
            the_post();
            
            if (is_custom_type()) {
                get_template_part('/partials/articles/article', 'jobarchive');
            } else {
                get_template_part('/partials/articles/article', 'archive');
            }
        } ?>
    </div>
</div>

<?php get_template_part('/partials/pagination');
get_sidebar();
get_footer(); ?>