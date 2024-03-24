<?php
function university_post_types(){
    //Event Post Type
    register_post_type('event', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'event'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar-alt'
        ));
    }

    //Programme Post Type
    register_post_type('programme', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programme'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Programmes',
            'add_new_item' => 'Add New Programme',
            'edit_item' => 'Edit Programme',
            'all_items' => 'All Programmes',
            'singular_name' => 'Programme'
        ),
        'menu_icon' => 'dashicons-awards'
        ));

add_action('init', 'university_post_types');