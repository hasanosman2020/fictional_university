<?php
get_header();
while (have_posts()){
    the_post();
    pageBanner();
    ?>
    

     <div class="container container--narrow page-section">
      
     
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php 
                    $likeCount = new WP_Query(array(
                        'post_type' => 'like',
                        'meta_query' => array(
                            array(
                                'key' => 'liked_professor_id',
                                'compare' => '=',
                                'value' => get_the_ID()
                            )
                        ) 
                    )); 
                    
$existStatus = 'no';
$likePostID = 0;


if(is_user_logged_in()){
                    
                    $existQuery = new WP_Query(array(
                        'author' => get_current_user_id(),
                        'post_type' => 'like',
                        'meta_query' => array(
                            array(
                                'key' => 'liked_professor_id',
                                'compare' => '=',
                                'value' => get_the_ID()
                            )
                        ) 
                    )); 
                             
                   if($existQuery->found_posts){
                    $existStatus = 'yes';
                    /*$likePostId = $existQuery->posts[0]->ID;
                    
                   } else {
                    $existStatus = "no";
                    $likePostID = '';*/
                   };}
                   ?>
                   
                    <span class="like-box" data-like="<?php if (isset($existQuery->posts[0]->ID)) echo $existQuery->posts[0]->ID; ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
                
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php 
        $relatedProgrammes = get_field('related_programme');
        if($relatedProgrammes){

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Subjects Taught</h2>';
        echo '<ul class="link-list min-list">';
        
        foreach($relatedProgrammes as $programme){ ?>
            <li><a href="<?php echo get_the_permalink($programme); ?>"><?php echo get_the_title($programme); ?></a></li>
        <?php }
        echo
        "</ul>";
        //};
        
        //foreach($relatedProgrammes as $programme){
            //echo get_the_title($programme);
        }
        ?>
        </div>
    
    <?php
};
get_footer();
?>
