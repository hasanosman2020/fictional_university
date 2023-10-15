<?php 
get_header(); 
pageBanner(array(
  'title' => 'All Campuses',
  'subtitle' => 'Visit our campuses located in the heart of London.'
))
?>
    
    <div class="container container--narrow page-section">
        <div class="acf-map">
        
      <?php while(have_posts()){
        the_post(); 
        $mapLocation = get_field('map_location');
        ?>
        <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"></div>
        
        


<?php };
get_footer();
?>
</div>
        






        <!--<div class='post-item'>
          <h2 class='headline headlline--medium headline--post-title'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h2>-->
         <!-- <div class='metabox'>
          <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
      </div>
      </div>-->
        