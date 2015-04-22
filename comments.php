<div id="comments">
<?php if (post_password_required()) : ?>
    <p class="nopassword"><?php _e('Tá pasfhocal ag teastáil le haghaidh na postála seo. Cuir isteach an pasfhocal chun na tráchtanna a fheiceáil.', 'wpzoom'); ?></p>
    <?php return; ?>
<?php endif; ?>

<?php if (have_comments()) : ?>

    <h6><?php comments_number(__('Gan Tráchtanna','wpzoom'), __('Trácht Amháin','wpzoom'), __('% Nóta Tráchta','wpzoom'));?></h6>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <div class="navigation">
            <?php paginate_comments_links(array('prev_text' => ''.__('<span class="meta-nav">&larr;</span> Older Comments', 'wpzoom').'', 'next_text' => ''.__('Newer Comments <span class="meta-nav">&rarr;</span>', 'wpzoom').''));?>
        </div>
    <?php endif; ?>

    <ol class="commentlist"><?php wp_list_comments(array('callback' => 'wpzoom_comment')); ?></ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <div class="navigation">
            <?php paginate_comments_links(array('prev_text' => ''.__('<span class="meta-nav">&larr;</span> Older Comments', 'wpzoom').'', 'next_text' => ''.__('Newer Comments <span class="meta-nav">&rarr;</span>', 'wpzoom').''));?>
        </div>
    <?php endif;
 
elseif (!comments_open()) :
    echo '<p class="nocomments">' . _e('Tá fóram na dtráchtanna dúnta.', 'wpzoom') . '</p>';
endif;

$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ($req ? " aria-required='true'" : '');

$custom_comment_form = array(
    'fields' => apply_filters('comment_form_default_fields', array(
        'author' => '<div class="form_fields"><p class="comment-form-author">' . '<label for="author">' . __('D’ainm' , 'wpzoom') . '</label> '
            . ($req ? '<span class="required_lab">*</span>' : '') . '<input id="author" name="author" type="text" value="' .
            esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="required" />' . '</p>',
        'email' => '<p class="comment-form-email">' .
            '<label for="email">' . __('Do sheoladh ríomhphoist' , 'wpzoom') . '</label> ' .
            ($req ? '<span class="required_lab">*</span>' : '') .
            '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . 
            ' class="required email" />' . '</p>',
        'url' => '<p class="comment-form-url">' .
            '<label for="url">' . __('An suíomh gréasáin lena mbaineann tú' , 'wpzoom') . '</label> ' .
            '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30"' . $aria_req . ' />' .
            '</p></div><div class="clear"></div>')
        ),
    'comment_field' => '<p class="comment-form-comment">' .
        '<label for="comment">' . __('Fág trácht' , 'wpzoom') . '</label> ' .
        '<textarea id="comment" name="comment" cols="35" rows="5" aria-required="true" class="required"></textarea>' .
        '</p><div class="clear"></div>',
    'logged_in_as' => '<p class="logged-in-as">' . 
        sprintf(__('Logáilte isteach mar <a href="%1$s">%2$s</a>. <a href="%3$s">Logáil amach?</a>'), 
        admin_url('profile.php'),
        $user_identity,
        wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
    'title_reply' => __('Fág freagra' , 'wpzoom'),
    'cancel_reply_link' => __('Cuir ar ceal' , 'wpzoom'),
    'label_submit' => __('Seol' , 'wpzoom'),
    'comment_form_after' => '<div class="clear"></div>',
);

comment_form($custom_comment_form); 
?>
 
</div><!-- #comments -->