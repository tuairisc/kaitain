<?php

/**
 * Output Social Sharing Links
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

function kaitain_share_links() {
    global $post; 

    if (!($post = get_post($post))) {
        return false;
    }

    $post_info = array(
        'blog'  => urlencode(get_bloginfo('name')),
        'url'   => urlencode(post_permalink($post->ID)),
        'title' => urlencode($post->post_title),
        'tuser' => 'tuairiscnuacht',
    );

    $services = array(
        'print' => array(
            'title' => 'Print %s',
            'href' => 'javascript:window.print()',
            'target' => '',
            'reqires' => null
        ),
        'twitter' => array(
            'title' => 'Tweet %s',
            'href' => sprintf('//twitter.com/share?via=%s&text=%s&url=%s&related=@%s', 
                $share['tuser'], 
                $share['title'],
                $share['url'],
                $share['tuser']
            ),
            'target' => '_blank',
        ),
        'facebook' => array(
            'title' => 'Share %s',
            'href' => sprintf('//facebook.com/sharer.php?u=%s',
                $share['url']
            ),
            'target' => '_blank',
        ),
        'email' => array(
            'title' => 'Email %s',
            'href' => sprintf('mailto:?subject=%s&amp;body=%s',
                $share['title'],
                $share['url']
            ),
            'target' => '_blank',
        ),
        'google' => array(
            'title' => '+1 %s',
            'href' => sprintf('//plus.google.com/share?url=%s',
                $share['url']
            ),
            'target' => '_blank',
        ),
        'reddit' => array(
            'title' => 'Upvote %s',
            'href' => sprintf('//reddit.com/submit?url=%s&title=%s',
                $share['url'],
                $share['title']
            ),
            'target' => '_blank',
        ),
        'discuss' => array(
            'href' => '#comments',
            'title' => 'Read comments on %s',
            'target' => ''
        )
    );

    printf('<nav class="%s">', 'kaitain-share-links');
    printf('<ul class="%s">', 'kaitain-social');

    foreach ($services as $service => $service_info) {
        if ($service === 'discuss' && !is_singular('post') && comments_open($post->ID)) {
            // Skip comment if it isn't a single post and comments are open.
            continue;
        }

        kaitain_social_link($post_info, $service, $service_info);
    }

    printf('</ul>');
    printf('</nav>');
}

/**
 * Output Sharing Link
 * -----------------------------------------------------------------------------
 * Generate individual link.
 * 
 * @param   array        $link_info     Array of information on the page to be shared.
 * @param   string       $service       Name of sharing service. 
 * @param   array        $service_info  Link attributes for social sharing service.
 * @return  string       Social link HTML.
 */

function kaitain_social_link($link_info, $service_name, $service_info) {
    $link = array();
    $classes = array();

    $classes[] = $service_name;
    $classes[] = 'share-item';

    $link[] = sprintf('<li class="%s">', implode(' ', $classes));

    $link[] = sprintf('<a class="%s" href="%s" target="%s" title="%s">',
        'social-share-link',
        $service_info['href'],
        $service_info['target'],
        sprintf($service_info['title'], $link_info['title'])
    );

    $link[] = sprintf('<span class="%s"></span>',
        'social-share-span'
    );

    $link[] = '</a>';
    $link[] = sprintf('</li>');

    echo implode('', $link);
}
