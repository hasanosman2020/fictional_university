<?php 
get_header(); 
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our events that have taken place in the past.'
))

?>
    
    <div class="container container--narrow page-section">
    <?php 
          $today = date('Ymd');
          $pastEvents = new WP_Query(array(
            'paged' => get_query_var('paged', 1),
            'posts_per_page' => 1,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today
              )
            )
          ));
       while($pastEvents->have_posts()){
        $pastEvents->the_post(); 
        get_template_part('template-parts/content-event');
        ?>


<hr class="section-break">

<?php }; 
echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
)); 
?>

</div>

<?php get_footer();
?>
        






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
        