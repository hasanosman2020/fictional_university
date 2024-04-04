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

//Code to add the first field to the settings page - Display Location
        add_settings_field('wcp_location', 'Display Location',array($this, 'locationHTML'), 'word-count-read-time-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));
        
        //First option is the name of the setting, second is the name of the field, third is the callback function, fourth is the page name, fifth is the section name
add_settings_field('wcp_heading', 'Heading', array($this, 'headingHTML'), 'word-count-read-time-settings-page', 'wcp_first_section');
         
        register_setting('wordcountplugin', 'wcp_heading', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Word Count Read Time Plugin'));

        //Code to add the third field to the settings page - Word Count
        add_settings_field('wcp_wordcount', 'Word Count', array($this, 'checkboxHTML'), 'word-count-read-time-settings-page', 'wcp_first_section', array('theName' => 'wcp_wordcount'));
         
        register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        //Code to add the fourth field to the settings page - Character Count
        add_settings_field('wcp_charactercount', 'Character Count', array($this, 'checkboxHTML'), 'word-count-read-time-settings-page', 'wcp_first_section', array('theName' => 'wcp_charactercount'));
        register_setting('wordcountplugin', 'wcp_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        //Code to add the fifth field to the settings page - Read Time
        add_settings_field('wcp_readtime', 'Read Time', array($this, 'checkboxHTML'), 'word-count-read-time-settings-page', 'wcp_first_section', array('theName' => 'wcp_readtime'));
        register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        
    }

    function sanitizeLocation($input){
        if($input != '0' AND $input != '1' ){
            add_settings_error('\wcp_location', 'wcp_location_error', 'Please select a valid location', 'error');
            return get_option('wcp_location');
        }
        return $input;
    }

    function locationHTML(){ ?>
    <select name='wcp_location'>
    <option value='0'<?php selected(get_option('wcp_location'), '0'); ?>>Beginning of post</option>
    <option value = '1' <?php selected(get_option('wcp_location'), '1'); ?>>End of post</option>
    </select>
<?php }

function headingHTML(){ ?>
<input type='text' name='wcp_heading' value='<?php echo esc_attr(get_option('wcp_heading')); ?>' />
    
<?php }

function checkboxHTML($args){ ?>
<input type='checkbox' name='<?php echo $args['theName']; ?>' value = '1' <?php checked(get_option($args['theName']), '1'); ?> />

<?php }
function adminPage(){
    add_options_page('Word Count Read Time Settings','Word Count Read Time', 'manage_options', 'word-count-read-time-settings-page', array($this,'ourHTML'));
}
function ourHTML(){ ?>
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

 
/*The code above is a simple plugin that creates a settings page in the WordPress admin dashboard. The settings page allows the user to select the location of the word count and read time display (beginning or end of the post) and set a custom heading for the display. The plugin also includes a class called WordCountReadTime that handles the settings and display of the word count and read time. The class constructor adds actions to create the admin menu and settings, and the settings function registers the settings fields and sections. The locationHTML and headingHTML functions create the HTML elements for the settings fields, and the adminPage and ourHTML functions create the settings page in the admin dashboard. The plugin is activated by creating an instance of the WordCountReadTime class at the end of the file.*/
?>