<?php get_header(); ?> 
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

<div id="content">
    <?php 
    if (is_author()) {
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    }

    if (!is_category() && !is_custom_type()) {
        printf('<h6>');

        if(is_tag()) {
            // Tag archive. 
            _e('Míreanna clibeáilte le:', 'wpzoom');
            single_tag_title();
        } else if (is_day()) { 
            // Daily archive. 
            _e('Cartlann do', 'wpzoom');
            the_time('F jS, Y'); 
        } else if (is_month()) { 
            // Monthly archive. 
            _e('Cartlann do', 'wpzoom');
            the_time('F, Y'); 
        } else if (is_year()) {
            // Yearly archive. 
            _e('Cartlann do', 'wpzoom'); 
            the_time('Y'); 
        } else if (is_author()) { 
            // Author archive. 
            _e( 'Altanna le: ', 'wpzoom' );
            printf('<a href="%s">%s</a>', $curauth->user_url, $curauth->display_name);  
        }else if (isset($_GET['paged']) && !empty($_GET['paged'])) {
            // Paged archive. 
            _e('Mireanna', 'wpzoom'); 
        }

        printf('</h6>');
    }

    if (!is_author()) {
        get_template_part('/partials/banner');
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