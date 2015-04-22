<div id="comments">
    <?php if (post_password_required()) {
        printf('<p class="nopassword">%s</p>', _e('Tá pasfhocal ag teastáil le haghaidh na postála seo. Cuir isteach an pasfhocal chun na tráchtanna a fheiceáil.', 'tuairisc'));
        return;
    }

    if (have_comments()) { ?>

        <h6>
            <?php comments_number(__('Gan Tráchtanna','tuairisc:WPINC'), __('Trácht Amháin','tuairisc'), __('% Nóta Tráchta','tuairisc')); ?>
        </h6>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) {
            // TODO: Pagination
        } ?>

        <ol class="commentlist"><?php wp_list_comments(array('callback' => 'tuairisc_comment')); ?></ol>

    <?php } else if (!comments_open()) {
        printf('<p class="nocomments">%s</p>', _e('Tá fóram na dtráchtanna dúnta.', 'tuairisc'));
    }

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $custom_comment_form = array(
        'fields' => apply_filters('comment_form_default_fields', array(
            'author' => '<div class="form_fields"><p class="comment-form-author">' . '<label for="author">' . __('D’ainm' , 'tuairisc') . '</label> '
                . ($req ? '<span class="required_lab">*</span>' : '') . '<input id="author" name="author" type="text" value="' .
                esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="required" />' . '</p>',
            'email' => '<p class="comment-form-email">' .
                '<label for="email">' . __('Do sheoladh ríomhphoist' , 'tuairisc') . '</label> ' .
                ($req ? '<span class="required_lab">*</span>' : '') .
                '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . 
                ' class="required email" />' . '</p>',
            'url' => '<p class="comment-form-url">' .
                '<label for="url">' . __('An suíomh gréasáin lena mbaineann tú' , 'tuairisc') . '</label> ' .
                '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30"' . $aria_req . ' />' .
                '</p></div><div class="clear"></div>')
            ),
        'comment_field' => '<p class="comment-form-comment">' .
            '<label for="comment">' . __('Fág trácht' , 'tuairisc') . '</label> ' .
            '<textarea id="comment" name="comment" cols="35" rows="5" aria-required="true" class="required"></textarea>' .
            '</p><div class="clear"></div>',
        'logged_in_as' => '<p class="logged-in-as">' . 
            sprintf(__('Logáilte isteach mar <a href="%1$s">%2$s</a>. <a href="%3$s">Logáil amach?</a>'), 
            admin_url('profile.php'),
            $user_identity,
            wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
        'title_reply' => __('Fág freagra' , 'tuairisc'),
        'cancel_reply_link' => __('Cuir ar ceal' , 'tuairisc'),
        'label_submit' => __('Seol' , 'tuairisc'),
        'comment_form_after' => '<div class="clear"></div>',
    );

    comment_form($custom_comment_form); ?> 
</div>