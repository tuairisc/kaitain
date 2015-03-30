<div id="sidebar">
    <?php if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'Before widgets') {
        printf('<div class="side_ad">');
        
        if ( option::get('banner_sidebar_html') <> "") { 
            printf(stripslashes(option::get('banner_sidebar_html')));
        } else {
            printf('<a href="%s"><img src="%s" alt="%s" /></a>', option::get('banner_sidebar_url'), option::get('banner_sidebar'), option::get('banner_sidebar_alt'));
        }               
                
        printf('</div>');
    }
    
    if (function_exists('dynamic_sidebar')) { 
        dynamic_sidebar('Sidebar');
    }
     
    if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'Before widgets') {
        printf('<div class="side_ad">');
        
        if ( option::get('banner_sidebar_html') <> "") { 
            printf(stripslashes(option::get('banner_sidebar_html')));
        } else {
            printf('<a href="%s"><img src="%s" alt="%s" /></a>', option::get('banner_sidebar_url'), option::get('banner_sidebar'), option::get('banner_sidebar_alt'));
        }               
                
        printf('</div>');
    }

    // AdRotate groups 2, 4 and 5 
    if (function_exists('adrotate_group')) {
        printf('<div class="sidebar-adverts">');
        printf('%s', adrotate_group(3));
        printf('%s', adrotate_group(4));
        printf('%s', adrotate_group(5));
        printf('</div>');
    } ?>
</div> 