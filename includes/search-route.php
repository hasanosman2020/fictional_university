<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch(){
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
};
function universitySearchResults($data){
    //return 'Congrats, you created a route.';
    $mainQuery = new WP_QUERY(array(
        'post_type' => array('post', 'page', 'professor', 'programme', 'event', 'campus'),
        's' => sanitize_text_field($data['term']),
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

        if(get_post_type() == 'post' OR get_post_type() == 'page'){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }
        if(get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        };
        if(get_post_type() == 'programme'){
            $relatedCampuses = get_field('related_campus');

            if($relatedCampuses){
                foreach($relatedCampuses as $campus){
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus)
                    ));
                }
            }

            array_push($results['programmes'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_id()
            ));
        };
        
        if(get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
if(has_excerpt()){
    $description = get_the_excerpt();
} else {
    $description = wp_trim_words(get_the_content(), 18);

        }
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
        }
    }
    
    /*
    if($results['programmes']){
        $programmesMetaQuery = array('relation' => 'OR');
    

        forEach($results['programmes'] as $item){
            array_push($programmesMetaQuery, array(
                'key' => 'related_programmes',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'      
            ));
        }*/

        if($results['programmes']){

        $programmesMetaQuery = array('relation' => 'OR');
foreach($results['programmes'] as $item){
    array_push($programmesMetaQuery, array(
        'key' => 'related_programme',
        'compare' => 'LIKE',
        'value' => '"' . $item['id'] . '"'
    ));
};

    $programmeRelationshipQuery = new WP_Query(array(
        'post_type' => array('professor', 'event'),
        'meta_query' => $programmesMetaQuery
    ));
        /*array(
            'relation' => 'OR',
            array(
                'key' => 'related_programme',
                'compare' => 'LIKE',
                'value' => '"' . $results['programmes'][0]['id'] . '"'
            )
        )
    ));*/

    while($programmeRelationshipQuery->have_posts()){
        $programmeRelationshipQuery->the_post();

        if(get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
if(has_excerpt()){
    $description = get_the_excerpt();
} else {
    $description = wp_trim_words(get_the_content(), 18);

        }
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        };

        if(get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
            ));
        };
    };
    
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));

}

    return $results; 
}
