<?php
/*
Template Name: Monthly Author Report Output
*/
?>
<?php get_header(); ?>
<div id="main">
    <style type="text/css">
        div#content {
            width: 100%;
        }

        div.content-wrap {
            padding-top: 0;
        }
    </style>
    <div id="content">
            <div class="post clearfix">
                <div class="entry" id="author-report">
                    <h1>Author Posting Report</h1>
                    <?php 
                    /* Author Report Output v1.0
                    * -------------------------
                    * This report was requested by Emer for accounting purposes. 
                    * In order to pay each author or contributor, Emer must see
                    * articles posted in an inclusive period, along with word count
                    * (and helpfully views) too. 
                    * 
                    * The author report currently outputs information in a tabulated 
                    * manner:
                    * 
                    * Author Name
                    * -----------
                    * Article ID | Article Title | Article Date | Views | Word Count
                    * 
                    * page-authorreport.php takes its input from page-authorform.php
                    * 
                    */

                    // Sanitize input into array of start and end dates.
                    $dates = array();

                    foreach ($_POST as $key => $field) {
                        $dates[$key] = (int) sanitize_text_field($field);
                    }

                    // Get list of all site authors.
                    $author_list = get_users(array(
                        'blog_id' => $GLOBALS['blog_id'],
                        'orderby' => 'display_name',
                        'order'   => 'ASC',
                    ));
            
                    foreach ($author_list as $author) :
                        $id = $author->ID;

                        $author_query = new WP_Query(array(
                            'author'         => $id,
                            'posts_per_page' => -1,
                            'order'   => 'ASC',
                            'date_query'     => array(
                                'after'  => array(
                                    'year'  => $dates['start_year'],
                                    'month' => $dates['start_month'],
                                    'day'   => $dates['start_day'],
                                ),
                                'before' => array(
                                    'year'  => $dates['end_year'],
                                    'month' => $dates['end_month'],
                                    'day'   => $dates['end_day'],                                    
                                ),
                                'inclusive' => true,
                            ),
                        )); 

                        $counter = 1;

                        // If the author has posts in the period, output them in a tabulated manner.
                        if ($author_query->have_posts()) : ?>

                            <h2><a href="<?php echo get_author_posts_url($id); ?>"><?php echo $author->display_name; ?></a></h2>
                            <table class="tg" style="margin-bottom: 40px;">
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="54%">Title</th>
                                    <th width="15%">Post Date</th>
                                    <th width="10%">Views</th>
                                    <th width="15%">Word Count</th>
                                </tr>
                                <?php while ($author_query->have_posts()) : $author_query->the_post(); ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></td>
                                        <td><?php the_time('Y-m-d'); ?></td>
                                        <td><?php echo get_view_count(get_the_ID()); ?></td>
                                        <td><?php echo str_word_count(strip_tags(get_the_content()), 0); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        <?php endif;
                        // End of report. 
                        wp_reset_query();
                    endforeach; ?>
                </div><!-- / .entry -->
                <div class="clear"></div>
            </div><!-- /.post -->
    </div><!-- /#content -->
</div><!-- /#main -->
<?php get_footer(); ?>