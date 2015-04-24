<?php 
/**
 * Site Sections
 * -------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */ 

// 1. Define a section
// 2. Associate an object-post, category, tag, type or page-with a section.

class Section {
    function add_filter($action, $function, $priority = 10, $accepted_args = 1) {
        add_filter($action, $function, $priority, $accepted_args);
    }

    public function add_section_body_class($classes) {
        if (is_single()) {
            $classes[] = 'yolo-swag-lol';
        }
        
        return $classes;
    }


    function __construct($category, $arguments = null) {
        $this->category = $category;
        $this->add_filter('body_class', array(&$this, 'add_section_body_class'));
    } 
}

// Pobal: 159
// Children: 182, 183, 184, 185, 184, 216, 221

// $pobal = new Section(159, array(
//     'exclude' => array(
//         'category' => 216,
//         'category' => 221
//     ),
//     'include' => array(
//         'post' => 159,
//         'tag' => 100,
//         'page' => 15
//         'category' => 33
//     )
// ));

$Pobal = new Section('HELLO MUMMY');
?>