<?php

class WPZOOM_Theme {
    private static $dynamic_google_webfonts = array();

    public static function init() {
        add_action('after_setup_theme', array(__CLASS__, 'add_feed_links'));

        if (get_option('blog_public') != 0) {
            add_action('wp_head', array(__CLASS__, 'seo'), 1);
            add_action('wp_head', array(__CLASS__, 'canonical'), 1);
        }

        add_action('wp_head', array(__CLASS__, 'favicon'));
        add_action('wp_head', array(__CLASS__, 'generate_options_css'));
        add_action('wp_head', array(__CLASS__, 'header_code'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'theme_scripts'));
        add_action('wp_footer', array(__CLASS__, 'footer_code'));
    }

    public static function favicon() {
        /**
         * Shows favicon if it's set in theme options
         */
        $favicon = option::get('misc_favicon');

        if ($favicon) {
            echo '<link rel="shortcut icon" href="' . $favicon . '" type="image/x-icon" />';
        }
    }

    public static function header_code() {
        /**
         * Includes header/footer scripts if they are set in theme options
         */
        $header_code = trim(stripslashes(option::get('header_code')));

        if ($header_code) {
            echo stripslashes(option::get('header_code'));
        }
    }

    public static function footer_code() {
        $footer_code = trim(stripslashes(option::get('footer_code')));

        if ($footer_code) {
            echo stripslashes(option::get('footer_code'));
        }
    }

    public static function metaPostKeywords() {
        /**
         * Keywords meta tag for SEO on posts
         */
        $posttags = get_the_tags();
        $meta_post_keywords = '';
        if (!$posttags) {
            return;
        }
        foreach((array)$posttags as $tag) {
            $meta_post_keywords .= $tag->name . ',';
        }

        $meta_post_keywords = esc_attr(stripslashes($meta_post_keywords));

        echo '<meta name="keywords" content="'.$meta_post_keywords.'" />' . "\n";
    }

    public static function metaHomeKeywords() {
        /**
         * Keywords meta tag for SEO on homepage
         */
        $keywords = esc_attr(stripslashes(trim(option::get('meta_key'))));
        if ($keywords) {
            echo '<meta name="keywords" content="' . $keywords . '" />' . "\n";
        }
    }

    public static function canonical() {
        /**
         * Canonical meta tag for SEO
         */
        global $wp_query;

        if(option::is_on('canonical')) {

            #homepage urls
            if (is_home() )echo '<link rel="canonical" href="'.get_bloginfo('url').'" />';

            #single page urls
            $postid = $wp_query->post->ID;

            if (is_single() || is_page()) echo '<link rel="canonical" href="'.get_permalink().'" />';

            #index page urls
            if (is_archive() || is_category() || is_search()) echo '<link rel="canonical" href="'.get_permalink().'" />';
        }
    }

    public static function seo() {
        /**
         * Handles SEO Options
         */
        global $post;

        if (option::is_on('seo_enable')) {
            if (is_singular()) {
                if ($post->post_excerpt !== '') {
                    $description = $post->post_excerpt;
                } else {
                    $content = str_replace(']]>', ']]&gt;', $post->post_content);
                    $content = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);
                    $content = strip_tags($content);
                    $description = (strlen($content) < 155) ? $content : substr($content, 0, strpos($content, " ", 155));
                }
                echo '<meta name="description" content="' . esc_attr(strip_tags(stripslashes($description))) . '" />' . "\n";
                self::metaPostKeywords();
            } elseif (is_home()) {
                echo '<meta name="description" content="' . self::description() . '" />' . "\n";
                self::metaHomeKeywords();
            }

            self::index();
        }
    }

    public static function index() {
        /**
         * Robots meta tag for SEO
         */

        global $post, $wpdb;

        if(!empty($post)) {
            $post_id = $post->ID;
        }

        // Robots defaults
        $index = 'index';
        $follow = 'follow';

        if ( is_tag() && option::get('index_tag') != 'index') { 
            $index = 'noindex'; 
        } elseif (is_search() && option::get('index_search') != 'index') {
            $index = 'noindex';
        } elseif (is_author() && option::get('index_author') != 'index') {
            $index = 'noindex';
        } elseif (is_date() && option::get('index_date') != 'index') {
            $index = 'noindex';
        } elseif (is_category() && option::get('index_category') != 'index') {
            $index = 'noindex';
        }

        printf('<meta name="robots" content="%s, %s" />', $index, $follow);
    }

    public static function description() {
        /**
         * Returns meta description if is specified in theme options, if not
         * return WordPress' one
         *
         * @param {none}
         * @return {string} $description
         */

        $description = esc_attr(trim(option::get('meta_desc')));

        if (!$description) {
            $description = get_bloginfo('description');
        }

        return $description;
    }

    public static function add_feed_links() {
        global $wpz_default_feed;
        $wpz_default_feed = get_feed_link();

        add_theme_support('automatic-feed-links');
        add_filter('feed_link', array(__CLASS__, 'custom_feed_links'), 1);
    }

    public static function custom_feed_links($feed) {
        global $wpz_default_feed;
        $custom_feed = esc_attr(trim(option::get('misc_feedburner')));

        if ($feed == $wpz_default_feed && $custom_feed) {
            return $custom_feed;
        }

        return $feed;
    }

    public static function theme_scripts() {
        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }

        if (file_exists(get_template_directory() . '/js/init.js')) {
            /**
             * Enqueue initialization script, HTML5 Shim included.
             *
             * Only if this file exists.
             */
            wp_enqueue_script('wpzoom-init',  get_template_directory_uri() . '/js/init.js', array('jquery'));
        }

        if (isset(WPZOOM::$config['scripts'])) {
            /**
             * Enqueue all theme scripts specified in config file to the footer
             */
            foreach (WPZOOM::$config['scripts'] as $script) {
                wp_enqueue_script('wpzoom-' . $script,  get_template_directory_uri() . '/js/' . $script . '.js', array(), false, true);
            }
        }
    }

    public static function generate_options_css() {
        /**
         * Generate CSS for Options
         * ------------------------
         * @param {none}
         * @return {none}
         */

        $css = array();
        $enable = false;

        foreach (option::$evoOptions as $Eoption) {
            foreach ($Eoption as $option) {
                if ((isset($option['type']) && $option['type'] == 'color') || isset($option['css'])) {
                    $value = option::get($option['id']);
                    if (!trim($value) != "") continue;
                    $enable = true;

                    if (in_array($option['attr'], array('height', 'width')) &&
                        strpos($value, 'px') === false) {
                        $value = $value . 'px';
                    }

                    $css[] = "{$option['selector']}{{$option['attr']}:$value;}\n";
                }

                if ((isset($option['type']) && $option['type'] == 'typography')) {
                    $enable = true;
                    $css[] = self::dynamic_typography_css($option);
                }
            }
        }

        if ($enable) {
            printf('<style type="text/css">%s%s</style>', self::dynamic_google_webfonts_css(), implode('', $css));
        }
    }

    public static function dynamic_google_webfonts_register($font) {
        /**
         * Register Google Fonts
         * ---------------------
         * Registers Google Fonts so you can later determine what fonts to
         * include from the service.
         *
         * @param {array} $font Google Fonts data.
         * @return {none}
         */

        self::$dynamic_google_webfonts[] = $font;
    }

    public static function dynamic_google_webfonts_css() {
        /**
         * Generate Google Fonts CSS
         * -------------------------
         * Generates CSS for Google Fonts.
         *
         * @param {none}
         * @return {string} $css The CSS import string.
         */

        $fonts = '';

        foreach (self::$dynamic_google_webfonts as $font) {
            $fonts.= $font['name'] . $font['variant'] . '|';
        }

        if (!$fonts) {
            return '';
        }

        $fonts = str_replace( " ","+",$fonts);
        $css = '@import url("http'. (is_ssl() ? 's' : '') .'://fonts.googleapis.com/css?family=' . $fonts . "\");\n";
        $css = str_replace('|"', '"', $css);

        return $css;
    }

    public static function dynamic_typography_css($option) {
        /**
         * Generate Admin Typography Options CSS 
         * -------------------------------------
         * Generates CSS for typography options from ZOOM Admin.
         *
         * @param {array} $option
         * @return {string} The CSS
         */

        $value = option::get($option['id']);

        if (!is_array($value)) {
            return '';
        }

        $google_fonts = array();
        $font = array();

        if (isset($value['font-color']) && trim($value['font-color'])) {
            $font[] = "color: " . $value['font-color'] . ";";
        }

        if (isset($value['font-family']) && trim($value['font-family'])) {
            $font_families = ui::recognized_font_families($option['id']);
            $google_font_families = ui::recognized_google_webfonts_families($option['id']);

            if (array_key_exists($value['font-family'], $font_families)) {
                $font[] = "font-family: " . $font_families[$value['font-family']] . ";";
            }

            foreach ($google_font_families as $google_font_v) {
                if (isset($google_font_v['separator'])) {
                    continue;
                }

                $key = str_replace(' ', '-', strtolower($google_font_v['name']));

                if ($value['font-family'] == $key) {
                    $font[] = "font-family: " . $google_font_v['name'] . ";";
                    self::dynamic_google_webfonts_register($google_font_v);
                    break;
                }
            }
        }

        if (isset($value['font-size']) && trim($value['font-size'])) {
            $font[] = "font-size: " . $value['font-size'] . ";";
        }

        if (isset($value['font-style']) && trim($value['font-style'])) {
            if ($value['font-style'] == 'bold-italic') {
                $font[] = "font-style: italic;";
                $font[] = "font-weight: bold;";
            } elseif ($value['font-style'] == 'bold') {
                $font[] = "font-weight: bold;";
            } else {
                $font[] = "font-style: " . $value['font-style'] . ";";
            }
        }

        if (empty($font)) {
            return '';
        }

        return $option['selector'] . '{' . implode('', $font) . '}';
    }
}