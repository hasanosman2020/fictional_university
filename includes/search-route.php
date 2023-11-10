<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch(){
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
};
function universitySearchResults($_data){
    //return 'Congrats, you created a route.';
    $mainQuery = new WP_QUERY(array(
        'post_type' => array('post', 'page', 'professor', 'programme', 'event', 'campus'),
        's' => sanitize_text_field($_data['term']),
        'posts_per_page' => -1
        
    ));
    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programmes' => array(),
        'events' => array(),
        'campuses' => array()
    );
    while($mainQuery->have_posts()){
        $mainQuery->the_post();

        if(get_post_type() == 'post' || get_post_type() == 'page'){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        };
        if(get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        };
        if(get_post_type() == 'programme'){
            array_push($results['programmes'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ));
        };
        
        if(get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
if(has_excerpt()){
    $description = get_the_excerpt();
} else {
    $description = wp_trim_words(get_the_content(), 18);}
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        };
        if(get_post_type() == 'campus'){
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        };
    }

    $programmeRelationshipQuery = new WP_Query(array(
        'post_type' => 'professor',
        'meta_query' => array(
            array(
                'key' => 'related_programme',
                'compare' => 'LIKE',
                'value' => '"'.get_the_ID().'"'
            )
        )
    ));

    while($programmeRelationshipQuery->have_posts()){
        $programmeRelationshipQuery->the_post();

        if(get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        };

    }
    $results['professors'] == array_values(array.unique($results['professors'], SORT_REGULAR));
    
    return $results;
};