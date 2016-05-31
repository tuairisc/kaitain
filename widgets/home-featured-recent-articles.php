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
        ); 

        $instance = wp_parse_args($instance, $defaults);
        
        ?>
        <p>Enabling this widget will insert the Featured Recent Posts into the selected widget area.</p>
        <ul>
            <li>
                <label for="<?php printf($this->get_field_id('count')); ?>"><?php _e('Number of posts to display: ', 'kaitain'); ?></label>
                <select id="<?php printf($this->get_field_id('count')); ?>" name="<?php printf($this->get_field_name('count')); ?>">
                    <?php printf('<option value="%s">%s</option>', $defaults['count'], $defaults['count']); ?>
                </select>
            </li>
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


        // 1st large article
         ?>
    <div class="container-fluid">
        <div class="featured-top-row-1 row">
            <div class="featured-top-70 col-sm-6 col-xs-12">
                <div class="col-xs-12">
                    <article <?php post_class('article--lead'); ?> id="article--lead--<?php printf($featured[0]->ID); ?>">
                        <a class="article--lead__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[0]->ID); ?>">
                            <div class="thumbnail article--lead__thumb img-frame">
                                <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                                <?php post_image_html($featured[0]->ID, 'tc_home_feature_lead', true); ?>
                            </div>
                        </a>
                            <div class="featured-top-70-text">
                                <a class="article--lead__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[0]->ID); ?>">
                                    <h1 class="title article--lead__title"><?php the_title(); ?></h1>
                                </a>
                            <!--<header class="article--lead__header vspace--half">
                                 <h4 class="article--lead__author">
                                    <?php if (!kaitain_is_verboten_user($featured[0]->post_author)) : ?>
                                        <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author_meta('display_name', $featured[0]->post_author); ?></a>
                                        <?php endif; ?>
                                </h4> 
                                <h5 class="post-meta article--lead__meta"><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime($featured[0]->ID); ?></time></h5>
                            </header> -->
                            <p class="post-excerpt article--lead__excerpt"><?php printf(kaitain_excerpt($featured[0]->post_excerpt, 55 )); ?></p>
                            </div>
                    </article>
                </div>
            </div>
            <?php
            // 2nd article 
            ?>
            <div class="featured-top-30 col-sm-6 col-xs-12">
                <div class="featured-side-100 col-md-12 col-sm-12 col-xs-6">
                    <article class="article--small" id="article--small--<?php printf($featured[1]->ID); ?>">
                        <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[1]->ID); ?>">
                            <div class="thumbnail article--small__thumb img-frame">
                                <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                                <?php post_image_html($featured[1]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                            </div>
                            <div class="title-container">
                                <h5 class="title article--small__title"><?php printf($featured[1]->post_title); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 3rd article 
                ?>
                <div class="featured-top-30-middle">
                    <div class="featured-side-50 col-md-6 col-sm-12 col-xs-6">
                        <article class="article--small" id="article--small--<?php printf($featured[2]->ID); ?>">
                            <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[2]->ID); ?>">
                                <div class="thumbnail article--small__thumb img-frame ">
                                    <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                                    <?php post_image_html($featured[2]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                                </div>
                                <div class="title-container">
                                    <h6 class="title article--small__title"><?php printf($featured[2]->post_title); ?></h6>
                                </div>
                            </a>
                        </article>
                    </div>
                    <?php
                    // 4th article 
                    ?>
                    <div class="featured-side-50 col-md-6 col-sm-12 col-xs-6">
                        <article class="article--small" id="article--small--<?php printf($featured[3]->ID); ?>">
                            <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[3]->ID); ?>">
                                <div class="thumbnail article--small__thumb img-frame ">
                                    <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                                    <?php post_image_html($featured[3]->ID, 'tc_home_feature_small featured-post-image-inner', true); ?>
                                </div>
                                <div class="title-container">
                                    <h6 class="title article--small__title"><?php printf($featured[3]->post_title); ?></h6>
                                </div>
                            </a>
                        </article>
                    </div>
                </div>
                <?php
                // 5th article  
                ?>
                <div class="featured-top-33-container">
                    <div class="featured-top-33-inner-container col-md-12 col-sm-12 col-xs-6">
                        <article class="article--small" id="article--small--<?php the_id(); ?>">
                            <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[4]->ID); ?>">
                                <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                                    <div class="thumbnail article--small__thumb img-frame col-sm-3 col-xs-12">
                                    <?php post_image_html($featured[4]->ID, 'tc_home_feature_small', true); ?>
                                </div>
                                <div class="title-container col-sm-9 col-xs-12">
                                    <h6 class="title article--small__title"><?php printf($featured[4]->post_title); ?></h6>
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
                <div class="featured-50-a col-md-6 col-sm-12 col-xs-6">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[5]->ID); ?>">
                            <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-xs-12">
                                <?php post_image_html($featured[5]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-xs-12">
                                <h5 class="title article--small__title"><?php printf($featured[5]->post_title); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 7th article 
                ?>
                <div class="featured-25-b col-md-3 col-sm-6 col-xs-6">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[6]->ID); ?>">
                            <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-xs-12">
                                <?php post_image_html($featured[6]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-xs-12">
                                <h5 class="title article--small__title"><?php printf(kaitain_excerpt($featured[6]->post_title, 55)); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                // 8th article 
                ?>
                <div class="featured-25-c col-md-3 col-sm-6 col-xs-6">
                    <article class="article--small" id="article--small--<?php the_id(); ?>">
                        <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php echo get_permalink($featured[7]->ID); ?>">
                            <div class="section-trim <?php printf($trim['bg']); ?>"></div>
                            <div class="thumbnail article--small__thumb img-frame col-xs-12">
                                <?php post_image_html($featured[7]->ID, 'tc_home_feature_small', true); ?>
                            </div>
                            <div class="title-container col-xs-12">
                                <h5 class="title article--small__title"><?php printf(kaitain_excerpt($featured[7]->post_title, 55)); ?></h5>
                            </div>
                        </a>
                    </article>
                </div>
            </div>

            <div class="featured-top-30 col-sm-6 col-xs-6">
                <div class="col-xs-12">
                    <?php if (is_active_sidebar('ad-sidebar-1')) : ?>
                        <div class="sidebar__widgets">
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