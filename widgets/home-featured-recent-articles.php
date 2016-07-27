<?php

/**
 * Featured Posts Widget
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

class Kaitain_Featured_Recent_Post_Widget extends WP_Widget {
    /**
     * Widget Constructor
     * -------------------------------------------------------------------------
     */

    public function __construct() {
        parent::__construct(
            __('kaitain_featured_recent', 'kaitain'),
            __('Tuairisc: Featured Recent Posts', 'kaitain'),
            array(
                'description' => __('The frontpiece of the home page.', 'kaitain'),
            )
        );
    }

    /**
     * Widget Administrative Form
     * -------------------------------------------------------------------------
     * @param array     $instance       Widget instance.
     */

    public function form($instance) {
        $defaults = array(
            // Widget defaults.
            'count' => 8,
            'featured_post_actions' => 0
        ); 

        $instance = wp_parse_args($instance, $defaults);

        $featured = array();
        $featured_list = kaitain_get_featured_list(false);
        echo "<pre>";
        highlight_string( '<?php '. var_export($featured_list, true) . ' ');
        echo "</pre>";
        //$sticky_id = kaitain_get_sticky_id();
        $featured = get_posts(array(
                        'numberposts' => -1,
                        'post_status' => 'publish',
                        'post__in' => $featured_list,
                        'orderby' => 'date',
                        'order' => 'DESC',
                       // 'exclude' => array($sticky_id)
                    ));
        ?>
        <p>Enabling this widget will insert the Featured Recent Posts into the selected widget area.</p>
        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('count')); ?>"><?php _e('Number of posts to display: ', 'kaitain'); ?></label>
                <select id="<?php printf($this->get_field_id('count')); ?>" name="<?php printf($this->get_field_name('count')); ?>">
                    <?php printf('<option value="%s">%s</option>', $defaults['count'], $defaults['count']); ?>
                </select>
            </li>
        <?php
        if (!empty($featured)) { ?>
            <hr>
            <li>
                <table>
                    <caption>
                    <label for="<?php printf($this->get_field_id('featured_post_actions')); ?>" style="text-align:left;"><?php _e('<p>This table is a list of current featured posts.<br/>Select action and click Save to process.</p>', 'kaitain');?></label>
                    </caption>
                    <thead>
                        <tr>
                            <th>Pos.
                            </th>
                            <th>Post Title
                            </th>
                            <th>Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    $i = 0;
                    foreach ($featured as $post) {
                        setup_postdata($post);
                        echo '<tr><td>'.($i+1).'</td>';
                        echo '<td><a href="'.get_permalink($post->ID).'">'.kaitain_excerpt(get_the_title($post->ID), 5).'</a>';
                        echo '</td><td>';
                        ?>
                        <select id="<?php printf( $this->get_field_id('featured_post_actions') ); ?>" name="<?php printf($this->get_field_name('featured_post_actions'). '[%d]', $i ); ?>">
                            <option value="">No Action</option>
                            <option value="<?php echo $post->ID; ?>,remove">Remove</option>
                        </select><?php
                        echo "</td></tr>";
                        wp_reset_postdata();
                        $i++;
                    }
                    unset($i);

                    ?>
                    </tbody>
                </table>
            </li>
        <?php
        } else {
            echo "<em>No featured gallery posts found.</em><p>To enable from Posts menu:<ol><li>Open the Posts admin panel.</li><li>Select Gailearaithe category and click Filter.</li><li>Browse to desired post and click Edit.</li>Scroll to the Featured Gallery Post option and tick the checkbox.</li><li>Update the post.</li></ol>Any posts enabled using this method will display here, along with available options.</p>";
        } 

        ?>
        </ul>
        <?php
    }

    /**
     * Widget Update
     * -------------------------------------------------------------------------
     * @param  array    $new_instance      New instance variables.
     * @param  array    $old_instance      Old instance variables.
     * @return array    $instance          New widget settings.
     */

    public function update($new_instance, $old_instance) {
        $instance = array();

        // featured_post_actions - remove selected posts
        $featured_list = kaitain_get_featured_list(false);
        foreach ($new_instance['featured_post_actions'] as $featured_post) {
            $featured_post = explode(',', $featured_post);

            if ( 'remove' === $featured_post[1] ) {
                if( in_array($featured_post[0], $featured_list) ) {  
                    kaitain_update_featured_posts( $featured_post[0], false );
                }
            }   
        }

        return $instance;
    }

    /**
     * Widget Public Display
     * -------------------------------------------------------------------------
     * @param array     $defaults         Widget default values. 
     * @param array     $instance         Widget instance arguments.
     */

    public function widget($defaults, $instance) {

        global $post;
        

        // Array of featured and sticky posts.
        $featured = array();
        $featured = array_merge($featured, kaitain_get_featured(8, true));

        // Set trim colour for each post
        $trim = array();
        for ($i = 0; $i < count($featured); $i++) {
            $cat_id = get_the_category($featured[$i]->ID);
            $cat_id = $cat_id[0]->cat_ID;
            $trim[$i] = kaitain_section_css($cat_id);
        }
        unset($i);

        // 1st large article
         ?>
    <div class="container-fluid">
    <?php
    /////////////////////////////
    //  DEBUG
    /////////////////////////////
    //echo "<pre>";
    // print_r(kaitain_get_featured_list(false));
    // $test = kaitain_get_featured(8, true);
    // foreach ($test as $feature) {
    //     print_r($feature->ID." ".$feature->post_title);
    //     echo "\r\n";
    // }
    //echo "Featured Global: ";
    // print_r get_option( $GLOBALS['kaitain_featured_keys']['featured']);
    // print_r(kaitain_get_featured(8, true));
    //echo "</pre>";
    //highlight_string( '<?php ' . var_export( $featured[0], true ) . ' ');
    //foreach ($featured as $f) {
    //   print_r( $f->ID . ' ' );
    //}
    ?>
    <?php
    /////////////////////////////
    //  DEBUG END
    /////////////////////////////
    ?>
        <div class="featured-top-row-1 row">
            <div class="featured-top-70 col-sm-6 col-xs-12">
                <div class="col-xs-12">
                    <article <?php post_class('article--lead'); ?> id="article--lead--<?php printf($featured[0]->ID); ?>">
                        <a class="article--lead__link <?php printf($trim[0]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[0]->ID); ?>">
                            <div class="section-trim <?php printf($trim[0]['bg']); ?>"></div>
                            <div class="thumbnail article--lead__thumb img-frame">
                                <?php post_image_html($featured[0]->ID, 'tc_home_feature_lead', true); ?>
                            </div>
                        </a>
                            <div class="featured-top-70-text">
                                <a class="article--lead__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[0]->ID); ?>">
                                    <h1 class="title article--lead__title"><?php printf( kaitain_excerpt( $featured[0]->post_title, 55 )); ?></h1>
                                </a>
                            <!-- Author Meta -->
                            <header class="article--lead__header">
                                 <h4 class="article--lead__author">
                                    <?php if (!kaitain_is_verboten_user($featured[0]->post_author)) : ?>
                                        <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url($featured[0]->post_author)); ?>"><?php the_author_meta('display_name', $featured[0]->post_author); ?></a>
                                        <?php endif; ?>
                                </h4> 
                                <h5 class="post-meta article--lead__meta"><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php printf("%s ag %s", get_the_time('l, F j Y', $featured[0]->ID), get_the_time('g:i a', $featured[0]->ID)); ?></time></h5>
                            </header>
                            <p class="post-excerpt article--lead__excerpt"><?php printf( kaitain_excerpt( $featured[0]->post_excerpt, 55 )); ?></p>
                            </div>
                    </article>
                </div>
            </div>
            <?php
            // 2nd article 
            ?>
            <div class="featured-top-30 col-sm-6 col-xs-12">
                <div class="featured-side-100 col-md-12 col-sm-12 col-xs-12">
                    <article class="article--small" id="article--small--<?php printf($featured[1]->ID); ?>">
                        <a class="article--small__link <?php printf($trim[1]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[1]->ID); ?>">
                            <div class="section-trim <?php printf($trim[1]['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-sm-12 col-xs-4">
                                <?php post_image_html($featured[1]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                            </div>
                            <div class="title-container col-sm-12 col-xs-8">
                                <h5 class="title article--small__title"><?php printf( kaitain_excerpt( $featured[1]->post_title, 30 ) ); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 3rd article 
                ?>
                <div class="featured-top-30-middle">
                    <div class="featured-side-50 col-md-6 col-sm-12 col-xs-12">
                        <article class="article--small" id="article--small--<?php printf($featured[2]->ID); ?>">
                            <a class="article--small__link <?php printf($trim[2]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[2]->ID); ?>">
                                <div class="section-trim <?php printf($trim[2]['bg']); ?>"></div>
                                <div class="thumbnail article--small__thumb img-frame col-md-12 col-sm-4 col-xs-4">
                                    <?php post_image_html($featured[2]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                                </div>
                                <div class="title-container col-md-12 col-sm-8 col-xs-8">
                                    <h6 class="title article--small__title"><?php printf( kaitain_excerpt( $featured[2]->post_title, 20 )); ?></h6>
                                </div>
                            </a>
                        </article>
                    </div>
                    <?php
                    // 4th article 
                    ?>
                    <div class="featured-side-50 col-md-6 col-sm-12 col-xs-12">
                        <article class="article--small" id="article--small--<?php printf($featured[3]->ID); ?>">
                            <a class="article--small__link <?php printf($trim[3]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[3]->ID); ?>">
                                <div class="section-trim <?php printf($trim[3]['bg']); ?>"></div>
                                <div class="thumbnail article--small__thumb img-frame col-md-12 col-sm-4  col-xs-4">
                                    <?php post_image_html($featured[3]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                                </div>
                                <div class="title-container col-md-12 col-sm-8 col-xs-8">
                                    <h6 class="title article--small__title"><?php printf( kaitain_excerpt( $featured[3]->post_title, 20 )); ?></h6>
                                </div>
                            </a>
                        </article>
                    </div>
                </div>
                <?php
                // 5th article  
                ?>
                <div class="featured-top-33-container">
                    <div class="featured-top-33-inner-container col-md-12 col-sm-12 col-xs-12">
                        <article class="article--small" id="article--small--<?php the_id(); ?>">
                            <a class="article--small__link <?php printf($trim[4]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[4]->ID); ?>">
                                <div class="section-trim <?php printf($trim[4]['bg']); ?>"></div>
                                <div class="thumbnail article--small__thumb img-frame col-md-3 col-sm-4 col-xs-4">
                                    <?php post_image_html($featured[4]->ID, 'tc_home_feature_small', true); ?>
                                </div>
                                <div class="title-container col-md-9 col-sm-8 col-xs-8">
                                    <h6 class="title article--small__title"><?php printf( kaitain_excerpt( $featured[4]->post_title, 12 )); ?></h6>
                                </div>
                            </a>
                        </article>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /* Top article's title and excerpt. Here and not above due to styling requirements*/
        ?>

        <div class="featured-top-row-2 row">
            <?php
            //
            // Row
            //
            ?>
            <div class="featured-top-70 col-sm-6 col-xs-12">
                <?php
                // 6th article 
                ?>
                <div class="featured-50-a col-md-6 col-sm-6 col-xs-12">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim[5]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[5]->ID); ?>">
                            <div class="section-trim <?php printf($trim[5]['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-sm-12 col-xs-4">
                                <?php post_image_html($featured[5]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-sm-12 col-xs-8">
                                <h5 class="title article--small__title"><?php printf( kaitain_excerpt( $featured[5]->post_title, 30 )); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 7th article 
                ?>
                <div class="featured-25-b col-md-3 col-sm-6 col-xs-12">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim[6]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[6]->ID); ?>">
                            <div class="section-trim <?php printf($trim[6]['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-md-12 col-sm-4 col-xs-4">
                                <?php post_image_html($featured[6]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-md-12 col-sm-8 col-xs-8">
                                <h5 class="title article--small__title"><?php printf(kaitain_excerpt($featured[6]->post_title, 55)); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 8th article 
                ?>
                <div class="featured-25-c col-md-3 col-sm-6 col-xs-12">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim[7]['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[7]->ID); ?>">
                            <div class="section-trim <?php printf($trim[7]['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-md-12 col-sm-4 col-xs-4">
                                <?php post_image_html($featured[7]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-md-12 col-sm-8 col-xs-8">
                                <h5 class="title article--small__title"><?php printf(kaitain_excerpt($featured[7]->post_title, 55)); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
            </div>

            <div class="featured-top-30 col-sm-6 col-xs-12">
                <div class="col-xs-12">
                    <?php if (is_active_sidebar('ad-sidebar-1')) : ?>
                        <div class="advert_sidebar">
                            <?php dynamic_sidebar('ad-sidebar-1'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
        <?php       
        wp_reset_postdata();

    }
}




add_action('widgets_init', create_function('', 'register_widget("Kaitain_Featured_Recent_Post_Widget");'));

?>