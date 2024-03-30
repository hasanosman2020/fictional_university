<?php
get_header();
pageBanner();
while (have_posts()){
    the_post();
    ?>
    

     <div class="container container--narrow page-section">
       <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Campuses</a> <span class="metabox-main"><?php the_title(); ?></span>
        </p>
      </div>
      
        <div class="generic-content">
            <?php the_content();
} 
            ?> 
            </div>
            <?php $mapLocation = get_field('map_location');
            ?>
       
       <div class="acf-map">
        <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"><h3><?php the_title(); ?>
    <?php echo $mapLocation['address']; ?>
        </h3></div>
</div>

        <?php
        $relatedProgrammes = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'programme',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"'.get_the_ID().'"'
              )
            )
          ));

          if($relatedProgrammes->have_posts()){
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium"> Programmes </h2>';
          
      echo '<ul class="link-list min-list">';
          
          while($relatedProgrammes->have_posts()){
            $relatedProgrammes->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          
          
        <?php  }
         echo '</ul>';
          }
wp_reset_postdata();

          $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                'key' => 'related_programme',
                'compare' => 'LIKE',
                'value' => '"'.get_the_ID().'"'
              )
            )
          ));

          if($homepageEvents->have_posts()){
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium"> Upcoming '.get_the_title().' Events</h2>';
              
          while($homepageEvents->have_posts()){
            $homepageEvents->the_post(); 
            get_template_part('template-parts/content-event');
          };
        };
        wp_reset_postdata();

?>
</div>
    <?php 
get_footer();
?>