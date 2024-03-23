<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes(){
    register_rest_route('university/v1', 'manageLikes', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));
    register_rest_route('university/v1', 'manageLikes', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
};

function createLike($data){
    if(is_user_logged_in()){
        $professor = sanitize_text_field($data['professorId']);
        $existQuery = new WP_Query(array(
            'author' => get_curent_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => get_the_ID()
                )
            )
        ));

        if($existQuery -> found_posts == 0 AND get_post_type($professor)=='professor'){
            return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => '3nd PHP POST Test',
        'post_content' => 'Hello beautiful world.',
        'meta_input' => array(
            'liked_professor_id' => $professor
        )
    ));
        } else {
            die('Invalid professor id');
        }
    }
    else {
        die('Only logged in users can create a like.');
    };
};

function deleteLike($data){
    //return ("Thanks for trying to delete a like.");
    $likeId = sanitize_text_field($data['like']);
    if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like' ){
        wp_delete_post($likeId, true);
        return 'Congrats, like deleted';
    } else {
        die('You do not have permission to delete that.');
    }

    };
    ?>
