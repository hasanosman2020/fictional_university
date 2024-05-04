<?php
/*
Plugin Name: Are You Paying Attention?
Description: This plugin will be used to create a new custom block type. This block will display a message to the user, asking them if they are paying attention. The user will be able to customise the message that is displayed. 
Version: 1.0
Author: Hasan Osman
Website: https://github/hasanosman2020.com
*/
if(!defined('ABSPATH'))exit; //Exit if plugin is accessed directly

class AreYouPayingAttention{
function __construct(){
    add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
}
function adminAssets(){
    wp_enqueue_script('newblocktype', plugin_dir_url(__FILE__).'test.js', array('wp-blocks', 'wp-element') );
}
}

$areYouPayingAttention = new AreYouPayingAttention();
?>
