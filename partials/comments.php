<?php

/**
 * Comment Output Template
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

// $GLOBALS['comment'] = $comment;
// $comment = $GLOBALS['comment'];

?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div class="avatar-wrapper">
        <?php echo get_avatar($comment, 75); ?>
    </div>
    <div class="comment-interior">
        <header>
            <p class="author"><?php comment_author_link(); ?></p>
            <p class="date"><small><?php printf(__('%1$s at %2$s', TTD), get_comment_date(), get_comment_time()); ?></small></p>
        </header>

        <?php if ($comment->comment_approved === '0') {
            printf('<p>%s</p>', _e('Your comment has been held for moderation.', TTD));
        } ?>

        <div class="comment-body">
            <?php comment_text(); ?>
        </div>
        <?php if (is_user_logged_in()) : ?>
            <footer>
                <p><small>
                    <?php edit_comment_link(__('edit', TTD),'  ',''); ?>
                </small></p>
            </footer>
        <?php endif; ?>
    </div>
</li>
