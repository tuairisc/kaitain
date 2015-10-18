<?php

/**
 * Comments Template
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

if (comments_open()) {
    if (post_password_required()) {
        return;
    }

    printf('<div class="comments" id="comments">');
        printf('<h4 class="comments__title subtitle">%s \'%s\'</h4>',
            'Fág freagra ar',
            get_the_title()
        );

    if (have_comments()) {
        printf('<ul class="%s">', 'comments__commentlist vspace--double');

        wp_list_comments(array(
            'callback' => 'kaitain_theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'type' =>'comment',
            'style' => 'ul'
        ));

        printf('</ul>');
    }

    if (get_comment_pages_count() > 1) {
        sheepie_partial('pagination', 'comment');
    }

    printf('<div class="comments__form" id="comments__form">');

    // Template input for name, email and URL.
    $input = '<input class="%s-name font--small vspace--full" id="%s" name="%s" placeholder="%s" type="text" required="required">';
    $textarea = '<textarea class="comments__textarea" id="comment" name="comment" required="required"></textarea>';

    $fields = array(
        // Name, author and email fields.
        'author' => sprintf($input,
            'author', 'author', 'author', __('D\'ainm*', 'kaitain')
        ), 
        'email' => sprintf($input,
            'email', 'email', 'email', __('Ríomhphoist*', 'kaitain')
        ), 
        'url' => sprintf($input,
            'url', 'url', 'url', __('Láithreán gréasáin', 'kaitain')
        )
    );

    $logged_in_as = sprintf('<p class="comments__loggedinas vspace--half logged-in-as">%s</p>',
        sprintf(__('Logáilte isteach mar <a href="%1$s">%2$s</a>. <a href="%3$s">Logáil amach?</a>', 'kaitain'), 
           admin_url('profile.php'),
           $user_identity,
           wp_logout_url(apply_filters('the_permalink', get_permalink()))
        )
    );

    comment_form(array(
        'id_form' => 'comments__form',
        'id_submit' => 'comments__submit',
        // 'title_reply' => __('Fág freagra:', 'kaitain'),
        'title_reply' => '',
        'comment_field' => sprintf('<p id="textarea">%s</p>', $textarea),
        // False removes them entirely.
        'comment_notes_before' => false,
        'comment_notes_after' => false,
        'label_submit' => __('Seol', 'kaitain'),
        'logged_in_as' => $logged_in_as,
        'fields' => $fields,
    ));

    printf('</div>');
    printf('</div>');
}

?>
