<?php

/**
 * Comment Functions and Actions
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

/**
 * Custom Comment and Comment Form Output
 * -----------------------------------------------------------------------------
 * @param   string  $comment    The comment.
 * @param   array   $args       Array argument
 * @param   int     $depth      Depth of the comments thread.
 */

function theme_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>

    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <div class="avatar">
            <?php avatar_background($comment, 'tc_post_avatar', 'author-photo'); ?>
        </div>
        <div class="comment-body">
            <header>
                <p class="comment-meta">
                    <span class="comment-author-link"><?php comment_author_link(); ?></span>
                    <?php printf('<span class="%s"><time datetime="%s">%s</time></span>',
                        'post-date',
                        get_comment_date('Y-M-d H:i'),
                        get_comment_date_strftime()
                    ); ?>
                </p>
            </header>

            <div class="comment-body">
                <?php if (!$comment->comment_approved) {
                    printf('<p class="%s">%s</p>',
                        'comment-unapproved',
                        __('Tá do thrácht á mheas.', TTD)
                    );
                } else {
                    comment_text();
                } ?>
            </div>

            <?php if (is_user_logged_in()) : ?>
                <footer>
                    <p><?php edit_comment_link(__('edit', TTD),'', ''); ?></p>
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

function wrap_comment_fields_before() {
    printf('<div class="commentform-inputs">');
}

function wrap_comment_fields_after() {
    printf('</div>');
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('comment_form_before_fields', 'wrap_comment_fields_before');
add_action('comment_form_after_fields', 'wrap_comment_fields_after');

?>
