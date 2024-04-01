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
        add_action('admin_init', array($this, 'settings'));

    }
    function settings(){
add_settings_section('wcp_first_section', null, null, 'word-count-read-time-settings-page');

        add_settings_field('wcp_location', 'Display Location',array($this, 'locationHTML'), 'word-count-read-time-settings-page', 'wcp_first_section');

        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0')); 
    }

    function locationHTML(){ ;?>
    <select name='wcp_location'>
    <option value='0'>Beginning of post</option>
    <option value = '1'>End of post</option>
    </select>
<?php }
    function adminPage(){
    add_options_page('Word Count Read Time Settings','Word Count Read Time', 'manage_options', 'word-count-read-time-settings-page', array($this,'ourHTML'));
}
function ourHTML(){?>
<div class="wrap">
<h1>Word Count Read Time Settings Page</h1>
<form action="options.php" method="POST">
    <?php
    settings_fields('wordcountplugin');
    do_settings_sections('word-count-read-time-settings-page');
    submit_button();
    ?>
</form>
</div>
<?php
}
 }
 $wordCountReadTime = new WordCountReadTime();







    ?>

