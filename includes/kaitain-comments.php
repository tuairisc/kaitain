<?php

/**
 * Comment Functions and Actions
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

/**
 * Custom Comment Template
 * -----------------------------------------------------------------------------
 * @param   string  $comment    The comment.
 * @param   array   $args       Array argument
 * @param   int     $depth      Depth of the comments thread.
 */

function kaitain_theme_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    $comment_classes = array(
        'comments__comment', 'vspace--full'
    );

    ?>

    <li <?php comment_class($comment_classes); ?> id="comments__comment--<?php comment_ID() ?>">
        <div class="comments__photo avatar">
            <?php kaitain_avatar_background_html($comment, 'tc_post_avatar', 'author-photo'); ?>
        </div>
        <div class="comments__body">
            <header class="comments__header vspace--quarter">
                <h5 class="comments__meta">
                    <span class="comments__author-website"><?php comment_author_link(); ?></span>
                    <?php printf('<span class="%s"><time datetime="%s">%s ag %s</time>/span>',
                        'post-date',
                        get_comment_date('Y-M-d H:i'),
                        get_comment_time('l, F j Y'),
                        get_comment_time('g:i a')
                    ); ?>
                </h5>
            </header>

            <div class="comments__comment-body vspace--quarter">
                <?php if (!$comment->comment_approved) {
                    printf('<p class="%s">%s</p>',
                        'comments__unapproved',
                        __('Tá do thrácht á mheas.', 'kaitain')
                    );
                } else {
                    comment_text();
                } ?>
            </div>

            <?php if (is_user_logged_in()) : ?>
                <footer class="comments__footer">
                    <h5 class="comments_edit-link">
                        <?php edit_comment_link(__('edit', 'kaitain'),'', ''); ?>
                    </h5>
                </footer>
            <?php endif; ?>
        </div>
    </li>

    <?php
}

/**
 * Wrap Comment Fields in Elements
 * -------------------------------------------------------------------------
 *  Wrap comment form fields in <div></div> tags.
 * 
 * @link http://wordpress.stackexchange.com/a/172055
 */

function kaitain_wrap_comment_fields_before() {
    printf('<fieldset class="comments__inputs">');
}

function kaitain_wrap_comment_fields_after() {
    printf('</fieldset>');
}

add_action('comment_form_before_fields', 'kaitain_wrap_comment_fields_before');
add_action('comment_form_after_fields', 'kaitain_wrap_comment_fields_after');

?>
