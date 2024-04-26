<?php
/*
Plugin Name: Word Filter
Description: This Word Filter plugin will allow the user to provide a comma-separated list of words which they would want to have excluded from the plugin's content. It also gives the user the option to replace such words with whatever expression or otherwise that they choose. 
Version: 1.0
Author: Hasan Osman
Website: https://github/hasanosman2020.com
*/
if(!defined('ABSPATH'))exit; //Exit if plugin is accessed directly


class WordFilterPlugin{
    function __construct(){
        add_action('admin_menu', array($this, 'theMenu'));
    }
    function theMenu(){
        /*add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'wordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+CiA=', 110);*/
        $mainPageHook = add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'wordfilter', array($this, 'wordFilterPage'),plugin_dir_url(__FILE__).'custom.svg', 110);
        add_submenu_page('wordfilter', 'Words To Filter', 'Words List', 'manage_options', 'wordfilter', array($this, 'wordFilterPage'));
        add_submenu_page('wordfilter', 'Word Filter Options', 'Options', 'manage_options', 'wordfilteroptions', array($this, 'subMenuOptions'));
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }
    function mainPageAssets(){wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__).'styles.css');
    }
    function subMenuOptions(){ ?>
    <h2>Word Filter Options</h2>
<?php }

function handleForm(){
    if(wp_verify_nonce($_POST['theFilterNonce'], 'saveFilterWords') AND current_user_can('manage_options')){
    update_option('pluginwordstofilter', sanitize_text_field($_POST['plugin_wordfilter'])); ?>
    <div class="updated">
        <p>Your filtered words have been saved.</p>
    </div>
<?php } else { ?>
<div class="error">
    <p>Sorry, you do not have permission to perform that action.</p>
</div>
<?php }}
    function wordFilterPage(){ ?>
    <div class="wrap">
        <h1>Word Filter</h1>
        <?php if ($_POST["justsubmitted"] == true) $this->handleForm();
             ?>
        <form method="POST">
            <input type="hidden" name="justsubmitted" class="justsubmitted" value=true>
           <?php wp_nonce_field('saveFilterWords', 'theFilterNonce'); ?>
            <label for="plugin_wordfilter">
                <p>Enter a <strong>comma-separated</strong> list of words to filter from your site content.</p>
            </label>
            <div class="word-filter_flex-container">
                <textarea name="plugin_wordfilter" id="plugin_wordfilter" placeholder="bad, moody, horrible, ugly etc..."><?php echo esc_textarea(get_option('plugin_wordfilter')); ?></textarea>
            </div>
            <input type="submit" name="submit" id="submit" class="button button_primary" value="Save Changes">
        </form>
    </div>
<?php }

}

$wordFilterPlugin = new WordFilterPlugin();
