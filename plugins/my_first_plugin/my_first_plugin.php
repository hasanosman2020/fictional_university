<?php
/*
Plugin Name: My First Plugin
Description: Basic plugin to display a sentence at the end of each post.
Version: 1.0
Author: Hasan Osman
Author URI: https://hasanosman.com
*/

add_filter('the_content', 'addSentenceToPost');

function addSentenceToPost($content){
    //return $content.'<p>My name is Hasan Osman.</p>';
    //return '<p>My name is Hasan Osman.</p>';
    if(is_page() && is_main_query()){
        return $content.'<p>My name is Hasan Osman.</p>';
    }
    return $content;
    }



?>