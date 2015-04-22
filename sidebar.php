<div id="sidebar">
    <?php if (function_exists('dynamic_sidebar')) { 
        dynamic_sidebar('Sidebar');
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