<?php
/*
Plugin Name: Count Words and Characters
Description: This Word Count plugin will count the number of words and the number of characters in a post. It will also calculate the approximate reading time of the post, based on the average reading speed of 225 words per minute.
Version: 1.0
Author: Hasan Osman
Website: https://github/hasanosman2020.com
*/

class CountWordsandCharactersPlugin{
    function __construct(){
        add_action('admin_menu', array($this,'adminPage'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'ifWrap'));
    }
    function ifWrap($content){
        if(is_main_query() AND is_single() AND 
        (
            get_option('cwcp_countwords', '1') OR
            get_option('cwcp_countchars', '1') OR
            get_option('cwcp_readtime', '1')
        )){
            return $this->createHTML($content);
        }
        return $content;
    }
    function createHTML($content){
        $html = '<h5>'.esc_html(get_option('cwcp_headline', 'Blog Post Statistics')).'</h5><p>';

        //get word count
        if(get_option('cwcp_countwords', '1') OR
        get_option('cwcp_readtime', '1')){
            $countWords = str_word_count(strip_tags($content));
        }
        if(get_option('cwcp_countwords', '1')){
            $html .= 'This post has '. $countWords .' words.<br />';
        }
        if(get_option('cwcp_countchars', '1')){
            $html .= 'This post has '. strlen(strip_tags($content)) . ' characters.<br />';
        }
        if(get_option('cwcp_readtime', '1')){
            $html .= 'This post will take approximately '. round($countWords/225) . ' minute(s) to read.<br />';
        }
        $html .= '</p>';

        if(get_option('cwcp_location', '0') == '0'){
            return $html . $content;
        }
        return $content . $html;
    }

    function settings(){
        add_settings_section('cwcp_first_section', null, null, 'count_words_settings_page');
add_settings_field('cwcp_location', 'Display Location', array($this, 'locationHTML'), 'count_words_settings_page', 'cwcp_first_section');
register_setting('countwordsplugin', 'cwcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));

add_settings_field('cwcp_headline', 'Headline Text', array($this, 'headingHTML'), 'count_words_settings_page', 'cwcp_first_section');
register_setting('countwordsplugin', 'cwcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Blog Post Statistics'));

add_settings_field('cwcp_countwords', 'Display Word Count', array($this, 'checkboxHTML'), 'count_words_settings_page', 'cwcp_first_section', array('theName' => 'cwcp_countwords'));
register_setting('countwordsplugin', 'cwcp_countwords', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

add_settings_field('cwcp_countchars', 'Display Character Count', array($this, 'checkboxHTML'), 'count_words_settings_page', 'cwcp_first_section', array('theName' => 'cwcp_countchars'));
register_setting('countwordsplugin', 'cwcp_countchars', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

add_settings_field('cwcoreadtime', 'Display Read Time', array($this, 'checkboxHTML'), 'count_words_settings_page', 'cwcp_first_section', array('theName' => 'cwcp_readtime'));
register_setting('countwordsplugin', 'cwcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }
    function sanitizeLocation($input){
        if ($input != '0' AND $input != '1'){
            add_settings_error('cwcp_location', 'cwcp_location_error', 'Display location must be either beginning or end.');
            return get_option('cwcp_location');
        }
        return $input;

    }
    function checkboxHTML($args){ ?>
    <input type='checkbox' name='<?php echo $args['theName'] ?>' value='1' <?php checked(get_option($args['theName']), '1') ?> />
<?php }

function headingHTML(){ ?>
<input type='text' name='cwcp_headline' value='<?php echo esc_attr(get_option('cwcp_headline')) ?>' />
<?php }


function locationHTML(){ ?>
<select name="cwcp_location">
    <option value="0" <?php echo
    selected(get_option('cwcp_location'), '0'); ?>>Beginning of post</option>
    <option value="1" <?php echo
    selected(get_option('cwcp_location'), '1'); ?>>End of post</option>
</select>
<?php
}

    function adminPage(){
        add_options_page('Count Words and Characters Settings', 'Count Words and Characters', 'manage_options', 'count_words_settings_page', array($this, 'countWordsSettingsPage'));
    }
    function countWordsSettingsPage(){ ?>
    <div class="wrap">
        <h2>Count Words and Characters Settings</h2>
        <form action="options.php", method="POST">
            <?php
            settings_fields('countwordsplugin');
            do_settings_sections('count_words_settings_page');
            submit_button();
            ?>
        </form>
    </div>
<?php }
}
if(class_exists('CountWordsandCharactersPlugin')){
    $countWordsandCharactersPlugin = new CountWordsandCharactersPlugin();
}
