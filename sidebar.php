<section id="sidebar">
    
    <?php if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'Before widgets') { ?>
        <div class="side_ad">
        
            <?php if ( option::get('banner_sidebar_html') <> "") { 
                echo stripslashes(option::get('banner_sidebar_html'));             
            } else { ?>
                <a href="<?php echo option::get('banner_sidebar_url'); ?>"><img src="<?php echo option::get('banner_sidebar'); ?>" alt="<?php echo option::get('banner_sidebar_alt'); ?>" /></a>
            <?php } ?>               
                
        </div><!-- /.side_ad -->
    <?php } ?>
    
     <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('Sidebar'); } ?>
     
     <?php if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'After widgets') { ?>
        <div class="side_ad">
        
            <?php if ( option::get('banner_sidebar_html') <> "") { 
                echo stripslashes(option::get('banner_sidebar_html'));             
            } else { ?>
                <a href="<?php echo option::get('banner_sidebar_url'); ?>"><img src="<?php echo option::get('banner_sidebar'); ?>" alt="<?php echo option::get('banner_sidebar_alt'); ?>" /></a>
            <?php } ?>               
                
        </div><!-- /#side_ad -->
    <?php } ?>

    <?php // AdRotate groups 2, 4 and 5 
    if (function_exists('adrotate_group')) {
        printf('<div class="sidebar-adverts">');
        printf('%s', adrotate_group(2));
        printf('%s', adrotate_group(4));
        printf('%s', adrotate_group(5));
        printf('</div>');
    } ?>
    
    <div class="clear"></div>
</section> 
<div class="clear"></div>