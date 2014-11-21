<?php get_header(); ?> 

<?php if (is_author()) : ?> 
    <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
<?php endif; ?>

<div id="main" role="main">
    <div id="content">

        <?php if (!is_category()) : ?>
            <h3 class="title">
                <?php if(is_tag()) : ?>
                    <?php // Tag archive. ?>
                    <?php _e('Míreanna clibeáilte le:', 'wpzoom'); ?> "<?php single_tag_title(); ?>"
                <?php elseif (is_day()) : ?>
                    <?php // Daily archive. ?>
                    <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('F jS, Y'); ?>
                <?php elseif (is_month()) : ?>
                    <?php // Monthly archive. ?>
                    <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('F, Y'); ?>
                <?php elseif (is_year()) : ?>
                    <?php // Yearly archive. ?>
                    <?php _e('Cartlann do', 'wpzoom'); ?> <?php the_time('Y'); ?>
                  <?php elseif (is_author()) : ?>
                    <?php // Author archive. ?>
                    <?php _e( 'Altanna le: ', 'wpzoom' ); ?><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->display_name; ?></a>  
                <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
                    <?php // Paged archive. ?>
                    <?php _e('Mireanna', 'wpzoom'); ?>
                <?php endif; ?>
            </h3>
        <?php endif; ?>

        <?php get_template_part('banner'); ?>
           
        <?php if (is_foluntais())
            get_template_part('loop','foluntais');
        else
            get_template_part('loop'); ?>

    </div> <!-- /#content -->
    <?php get_sidebar(); ?> 
</div> <!-- /#main -->
<?php get_footer(); ?>