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
    if (post_password_required()) {
        printf('<h4 class="reply-title">%s</h4>',
            __('This post is password protected. Enter the password to view comments.', TTD)
        );

        return;
    }

    printf('<div class="article-comments" id="comments">');
        printf('<h4 class="comments-title subtitle">%s \'%s:\'</h4>',
            'Fág freagra ar',
            get_the_title()
        );
            // (get_comments_number() === 1) ? '' : 's',

    if (have_comments()) {
        // Iterate comments.
        printf('<h4 class="reply-title">%d %s "%s":</h4>',
            get_comments_number(),
            __('nóta tráchta ar', TTD),
            get_the_title()
        );

        printf('<ul>');

        wp_list_comments(array(
            'callback' => 'theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul>');
    }

    printf('<div id="comment-entry">');

    // Template input for name, email and URL.
    $input = '<input class="%s-name" id="%s" name="%s" placeholder="%s" type="text" required="required">';
    $textarea = '<textarea class="comment-form-comment" id="comment" name="comment" required="required"></textarea>';

    $fields = array(
        // Name, author and email fields.
        'author' => sprintf($input, 'author', 'author', 'author', __('D\'ainm*', TTD)), 
        'email' => sprintf($input, 'email', 'email', 'email', __('Ríomhphoist*', TTD)), 
        'url' => sprintf($input, 'url', 'url', 'url', __('Láithreán gréasáin', TTD))
    );

    $comment_notes = array(
        // We will not publish your email.
        'before' => sprintf('<p class="comment-notes">%s</p>',
            __('Ní bheidh muid a fhoilsiú do sheoladh r-phoist.', TTD)
        ),
        // Allowed tags.
        'after' => sprintf('<p class="form-allowed-tags">%s <code>%s</code></p>',
            __('Is féidir leat úsáid a bhaint ', TTD),
            allowed_tags()
        )
    );

    comment_form(array(
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        // 'title_reply' => __('Fág freagra:', TTD),
        'title_reply' => '',
        'comment_field' => sprintf('<p id="textarea">%s</p>', $textarea),
        'comment_form_before_fields' => '<div class="comment-form">',
        'comment_form_after_fields' =>'</div>',
        'comment_notes_before' => $comment_notes['before'],
        'comment_notes_after' => $comment_notes['after'],
        'label_submit' => __('Seol', TTD),
        'fields' => $fields,
    ));

    printf('</div>');
    printf('</div>');
}

?>
