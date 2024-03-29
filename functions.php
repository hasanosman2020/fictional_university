<?php
require get_theme_file_path('/includes/search-route.php');

require get_theme_file_path('/includes/like-route.php');

function university_custom_rest(){
    register_rest_field('post', 'authorName', array(
        'get_callback' => function(){return get_the_author();}
    ));
};

add_action('rest_api_init', 'university_custom_rest');


function 

pageBanner($args = NULL){
    if (!isset($args['title'])){
        $args['title'] = get_the_title();
    };
    if (!isset($args['subtitle'])){
        $args['subtitle'] = get_field('page_banner_subtitle');
    };
    if(!isset($args['photo'])){
        if(get_field('page_banner_background_image') AND !is_archive() AND !is_home()){
            $args['photo'] = get_field('page_banner_background_image')['url'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
<?php 
}

function university_files(){
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBH_rp5yKUcU2DQVO_IeoAun4fYQFhGx-8', NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?fd;;family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
};
add_action('wp_enqueue_scripts', 'university_files');

function university_features(){
    /**register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');**/
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 850, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query){
    //Adjust Campuses Query
    //Adjust Programmes Query
    if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
        $query->set('posts_per_page', -1);
    }
    
    
    //Adjust Programmes Query
    if(!is_admin() AND is_post_type_archive('programme') AND $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    //Adjust Events Query
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api){
    $api['key'] = 'AIzaSyBH_rp5yKUcU2DQVO_IeoAun4fYQFhGx-8';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

function load_scripts(){
    //load scripts
wp_enqueue_script('jquery'); # Loading the wp bundled jQuery version
}

add_action('wp_enqueue_scripts', 'load_scripts');


function redirectSubsToFrontend(){
    $ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0] == 'subscriber'){
        wp_redirect(site_url('/'));
        exit;
    }
}
add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar(){
    $ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles)== 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
        show_admin_bar(false);
        
    }
}
add_action('wp_loaded', 'noSubsAdminBar');

function ourHeaderUrl(){
    return esc_url(site_url('/'));
}
add_filter('login_headerurl', 'ourHeaderUrl');

function ourLoginCSS(){
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?fd;;family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    
}


add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginTitle(){
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'ourLoginTitle');

//Force note posts to be private

function makeNotePrivate($data){
    if($data['post_type'] == 'note'){
$data['post_content'] = sanitize_textarea_field($data['post_content']);
$data['post_title'] = sanitize_text_field($data['post_title']);
    };

    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){
        $data['post_status'] = 'private';
    };
    return $data;
};
add_filter('wp_insert_post_data', 'makeNotePrivate');

/*
function remove_google_font(){
    wp_dequeue_style('custom-google-fonts');
}

add_action('wp_enqueue_scripts', 'remove_google_font', 999);
*/

add_filter("ai1wm_exclude_content_from_export", "ignoreCertainFiles");

function ignoreCertainFiles($exclude_filters){
    $exclude_filters[] = "themes/university-theme/node_modules";
    /*$exclude_filters[] = "themes/university-theme/package.json";
    $exclude_filters[] = "themes/university-theme/package-lock.json";

}*/
return $exclude_filters;
}