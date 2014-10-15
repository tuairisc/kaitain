<?php get_header(); 
     if (is_author()) { 
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    }
?>

<div id="main" role="main">

    <div id="content">
    
    <?php if (!is_category()) : ?>
        <h3 class="title"> 
            <?php /* All of these need better a better translation! */ ?>
            <?php if(is_tag()) : /* tag archive */ ?>
                <?php _e('Míreanna clibeáilte le:', 'wpzoom'); ?> "<?php single_tag_title(); ?>"
            <?php elseif (is_day()) : /* daily archive */ ?>
                <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('F jS, Y'); ?>
            <?php elseif (is_month()) : /* monthly archive */ ?>
                <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('F, Y'); ?>
            <?php elseif (is_year()) : /* yearly archive */ ?>
                <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('Y'); ?>
              <?php elseif (is_author()) : /* author archive */ ?>
                <?php _e( 'Altanna le: ', 'wpzoom' ); ?><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->display_name; ?></a>  
            <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : /* paged archive */ ?>
                <?php _e('Mireanna', 'wpzoom'); ?>
            <?php endif;?>
        </h3>
    <?php endif; ?>

    <?php if (is_category()) : ?> 
        <?php $cat_id = get_query_var('cat'); ?>
        <div class="category-banner <?php echo greann_banner(); ?>" style="<?php echo 'background-color: ' . get_cat_color($cat_id) . ';'; ?>">
            <?php // Sorry for magic number: 158 = the mock/funny column. ?>
            <?php if ($cat_id != 158) : ?>
                <?php echo get_category_parents($cat_id, true, '&nbsp;'); ?>
            <?php else : ?>
                <span><?php echo category_description($cat_id); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
       
    <?php get_template_part('loop'); ?>
             
    </div> <!-- /#content -->
    
    <?php get_sidebar(); ?> 

</div> <!-- /#main -->
<?php get_footer(); ?>