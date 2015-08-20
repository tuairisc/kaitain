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
 */

if (comments_open()) {
    if (post_password_required()) {
        return;
    }

    printf('<div class="article-comments" id="comments">');
        printf('<h4 class="comments-title subtitle">%s \'%s\'</h4>',
            'Fág freagra ar',
            get_the_title()
        );

    if (have_comments()) {
        printf('<ul class="%s">', 'commentlist');

        wp_list_comments(array(
            'callback' => 'theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'type' =>'comment',
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
        'author' => sprintf($input,
            'author', 'author', 'author', __('D\'ainm*', TTD)
        ), 
        'email' => sprintf($input,
            'email', 'email', 'email', __('Ríomhphoist*', TTD)
        ), 
        'url' => sprintf($input,
            'url', 'url', 'url', __('Láithreán gréasáin', TTD)
        )
    );

    $comment_notes = array(
        // We will not publish your email.
        'before' => sprintf('<p class="comment-notes">%s</p>',
            __('Ní bheidh muid a fhoilsiú do sheoladh r-phoist!', TTD)
        ),
        // Allowed tags.
        'after' => sprintf('<p class="form-allowed-tags">%s <code>%s</code></p>',
            __('Is féidir leat úsáid a bhaint ', TTD),
            allowed_tags()
        )
    );

    $logged_in_as = sprintf('<p class="logged-in-as">%s</p>',
        sprintf(__('Logáilte isteach mar <a href="%1$s">%2$s</a>. <a href="%3$s">Logáil amach?</a>', TTD), 
           admin_url('profile.php'),
           $user_identity,
           wp_logout_url(apply_filters('the_permalink', get_permalink()))
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
        'logged_in_as' => $logged_in_as,
        'fields' => $fields,
    ));

    printf('</div>');
    printf('</div>');
}

?>
