<?php get_header(); 
 	if (is_author()) { 
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
	}
?>

<div id="main" role="main">

	<div id="content">
	
	<?php if (!is_category()) : ?>
		<h3 class="title"> 
			<?php  /* tag archive */ if( is_tag() ) { ?><?php _e('Post Tagged with:', 'wpzoom'); ?> "<?php single_tag_title(); ?>"
			<?php /* daily archive */ } elseif (is_day()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('F jS, Y'); ?>
			<?php /* monthly archive */ } elseif (is_month()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('F, Y'); ?>
			<?php /* yearly archive */ } elseif (is_year()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('Y'); ?>
			<?php /* author archive */ } elseif (is_author()) { ?><?php _e( ' Articles by: ', 'wpzoom' ); ?><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->display_name; ?></a>  
			<?php /* paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?><?php _e('Archives', 'wpzoom'); } ?>
		</h3>
	<? else : ?>
		<?php 
            // Generic-ify the ASNC code to if (has_banner) or if (has_custom_branding)
            // How best to determine this??
            $cat_id = get_query_var('cat'); 
            $asnc_cat = 158;
        ?>
		<div class="category-banner <?php echo asnc_banner($cat_id); ?>" style="<?php echo 'background-color: ' . get_cat_color($cat_id) . ';'; ?>">
			<?php if ($cat_id != $asnc_cat) : ?>
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