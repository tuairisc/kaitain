<?php

/**
 * Comments Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

if (comments_open()) {
    printf('<div class="article-comments" id="comments">');

    if (post_password_required()) {
        printf('<h5 class="reply-title">%s</h5>', __('This post is password protected. Enter the password to view comments.', TTD));
        return;
    }

    if (have_comments()) {
        $plural = (get_comments_number() === 1) ? '' : 's';

        printf('<hr>');
        printf(__('<h5 class="reply-title">%d comment%s on \'%s\':</h5>', TTD), get_comments_number(), $plural, get_the_title());
        printf('<ul>');

        wp_list_comments(array(
            'callback' => 'theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul></div>');
    }

    printf('<hr><div id="comment-entry">');
    printf('<h5 class="reply-title">%s on \'%s\':</h5>', __('Have your own say', TTD), get_the_title());

    comment_form(array(
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => __('Have your say:', TTD),
        'comment_field' => '<p id="textarea"><textarea autocomplete="off" class="comment-form-comment" id="comment" name="comment" required="required"></textarea></p>',
        'comment_form_before_fields' => '<div class="comment-form">',
        'comment_form_after_fields' =>'</div>',
        'fields' => array(
            'author' => '<input class="author-name" id="author" name="author" placeholder="' . __('Name*', TTD) . '" type="text" required="required">',
            'email' => '<input class="author-email" id="email" name="email" placeholder="' . __('Email*', TTD) . '" type="text" required="required">',
            'url' => '<input class="author-url" id="url" name="url" placeholder="' . __('Website', TTD) . '" type="text">'
        )
    ));

    printf('</div>');
}

?>
