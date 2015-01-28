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
        <div class="g g-2">
            <div class="g-dyn a-4 c-1">
                <div class="tuairisc-advert" style="background-image: url('http://kaitain.bhalash.com/wp-content/uploads/Mary-IDF14.jpg');">
                    <a data-track="NCwyLDAsMQ==" class="gofollow" href="http://www.mic.ul.ie" target="_blank" title="Mary I"></a>
                </div>
            </div>
            <div class="g-dyn a-2 c-2">
                <div class="tuairisc-advert" style="background-image: url('http://kaitain.bhalash.com/wp-content/uploads/An-Coimisineir-teanga-DF14.jpg');">
                    <a data-track="MiwyLDAsMQ==" class="gofollow" href="http://www.coimisineir.ie" target="_blank" title="Coimisinar Teanga"></a>
                </div>
            </div>
            <div class="g-dyn a-23 c-3">
                <div class="tuairisc-advert" style="background-image: url('http://kaitain.bhalash.com/wp-content/uploads/Europus2.jpg');">
                    <a href="http://www.europus.ie/" target="_blank" title="Europus"></a>
                </div>
            </div>
            <div class="g-dyn a-10 c-4">
                <div class="tuairisc-advert" style="background-image: url('http://kaitain.bhalash.com/wp-content/uploads/CIC-WEB-AD-300sq.gif');">
                    <a data-track="MTAsMiwwLDE=" class="gofollow" href="http://www.cic.ie" target="_blank" title="Cló lar Chonnachta"></a>
                </div>
            </div>
        </div>
    
    <?php // AdRotate groups 2, 4 and 5 ?>
    <?php // echo adrotate_group(2); ?>    
    <?php // echo adrotate_group(4); ?>    
    <?php // echo adrotate_group(5); ?>    

    <div class="clear"></div>
</section> 
<div class="clear"></div>