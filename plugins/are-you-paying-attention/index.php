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
    add_action('init', array($this, 'adminAssets'));
}
function adminAssets(){
    wp_register_style('quizeditcss', plugin_dir_url(__FILE__).'build/index.css');
    wp_register_script('newblocktype', plugin_dir_url(__FILE__).'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor') );
    register_block_type('ourplugin/are-you-paying-attention', array('editor_script' => 'newblocktype', 
    'editor_style' => 'quizeditcss',
    'render_callback' => array($this, 'theHTML')
    ));
}

function theHTML($attributes){
    if(!is_admin()){
        wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__).'build/frontend.js', array('wp-element'));
    wp_enqueue_style('attentionFrontendCSS', plugin_dir_url(__FILE__).'build/frontend.css');
    }
    
    ob_start(); ?>
    <h3>Today the sky is <?php echo esc_html($attributes['skyColour']) ?> and the grass is <?php echo esc_html($attributes['grassColour']) ?></h3>
    <?php return ob_get_clean();
    
}
}



$areYouPayingAttention = new AreYouPayingAttention();
?>
