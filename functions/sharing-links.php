<?php
/**
 * Generate Social Sharing Links
 * -----------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

function social_link_code($service = 'facebook', $is_list_item = false) {
    /**
     * Generate Social Network Link Code
     * ---------------------------------
     * Return the sharing link for the provided network, with an optional 
     * <li></li> wrapper. Currently supported:
     * 
     * facebook, twitter, google, reddit, email, discussion, printing
     * 
     * @param {string} $service The social service/sharing action.
     * @param {bool} $is_list_item Optionally wrap link in <li>
     * @return {string} $service_link The generated link to the network.
     */

    global $post; 

    $share_meta = array(
        'blog'  => urlencode(get_bloginfo('name')),
        'url'   => urlencode(get_permalink($post->ID)),
        'title' => urlencode($post->post_title),
        'tuser' => 'tuairiscnuacht',
        'title_attr' => the_title_attribute('echo=0')
    );

    $networks = array(
        'print' => array(
            'href' => 'javascript:window.print()', 
            'rel' => -1, 
            'target' => '', 
            'title' => 'Print ' . $share_meta['title_attr']
        ),
        'facebook' => array(
            'href' => '//facebook.com/share.php?u=' . $share_meta['url'],
            'rel' => 1,
            'target' => '_blank', 
            'title' => 'Share ' . $share_meta['title_attr'] . ' on Facebook'
        ),
        'twitter' => array(
            'href' => '//twitter.com/share?via='. $share_meta['tuser'] . '&text=' . $share_meta['title'] . '&url=' . $share_meta['url'] . '&related=@' . $share_meta['tuser'], 
            'rel' => 3, 
            'target' => '_blank', 
            'title' => 'Tweet about ' . $share_meta['title_attr']
        ),
        'google' => array(
            'href' => '//plus.google.com/share?url=' . $share_meta['url'],
            'rel' => 2, 
            'target' => '_blank', 
            'title' => '+1 ' . $share_meta['title_attr']
        ),
        'email' => array(
            'href' => 'mailto:?subject=' . $share_meta['title'] . '&amp;body=' . $share_meta['url'], 
            'rel' => 0, 
            'target' => '_blank', 
            'title' => 'Email ' . $share_meta['title_attr']
        ),
        'reddit' => array(
            'href' => '//reddit.com/submit?url=' . $share_meta['url'] . '&title=' . $share_meta['title'], 
            'rel' => 5, 
            'target' => '_blank',
            'title' => 'Upvote ' . $share_meta['title_attr'] . ' on Reddit'
        ),
        'discuss' => array(
            'href' => '#comments',
            'rel' => '-1',
            'target' => '',
            'title' => 'Read comments on ' . $share_meta['title_attr'] 
        )
    ); 

    $service_link = array();

    if ($is_list_item) {
        $service_link[] = '<li>';
    }

    $service_link[] = '<a ';
    $service_link[] = 'class="' . $service . '" ';
    $service_link[] = 'href="' . $networks[$service]['href'] . '" ';
    $service_link[] = 'data-rel="' . $networks[$service]['rel'] . '" ';
    $service_link[] = 'title="' . $networks[$service]['title'] . '"';
    $service_link[] = '></a>';

    if ($is_list_item) {
        $service_link[] = '</li>';
    }

    return implode('', $service_link);
}

function get_sharing_links($services = null, $is_list_item = false) {
    /**
     * Get Sharing Links Array
     * -----------------------
     * Return the sharing link for the provided network, with an optional 
     * <li></li> wrapper. Currently supported:
     * 
     * facebook, twitter, google, reddit, email, discussion, printing
     * 
     * @param {string} $service The social service/sharing action.
     * @param {bool} $is_list_item Optionally wrap link in <li>
     * @return {array} $service_links Array of social links.
     */

    $services_links = array();

    if (is_null($services)) {
        // Default networks for which to generate links.
        $services = array('twitter', 'facebook', 'email', 'print');
    } else if (!is_array($services)) {
        // Convert string input to array.
        $services = str_replace(' ', '', $services);
        $services = explode(',', $services);
    }

    foreach ($services as $service) {
        $services_links[] = social_link_code($service, $is_list_item);
    }

    return $services_links;
}

function sharing_links($services = null, $is_list_item = false) {
    /**
     * Print Sharing Links Array
     * -------------------------
     * Fetch, collapse and print array of social links.
     * 
     * @param {array} $services
     * @param {bool} $is_list_item
     * @return {none}
     */
    
    $sharing_links = get_sharing_links($services, $is_list_item);
    printf('%s', implode('', $sharing_links));
}
?>