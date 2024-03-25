<?php
/* 
Plugin Name: Word Count Read Time
Description: This plugin will count the number of words and the number of characters in a post, and will calculate the approximate reading time of the post. 
Version: 1.0
Author: Hasan Osman
Author URI: https://www.hasanosman2020.github.com
*/
 class WordCountReadTime{
    function __construct(){
        add_action('admin_menu', array($this, 'adminPage' ));

    }
    function adminPage(){
    add_options_page('Word Count Read Time Settings','Word Count Read Time', 'manage_options', 'word-count-read-time-settings-page', array($this,'ourHTML'));
}
function ourHTML(){?>
<div class="wrap">
<h1>Word Count Read Time Settings Page</h1>
</div>
<?php
}
 }
 $wordCountReadTime = new WordCountReadTime();







    ?>

