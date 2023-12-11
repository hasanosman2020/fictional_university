<?php
get_header();
while (have_posts()){
    the_post();
    pageBanner(array(
      'title' => 'Hello user, this is the title of the About Us page.',
      'subtitle' => 'Hello again, this is the subtitle of the About Us page.',
      'photo' => 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?dpr=16auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=' 
    ));
    ?>
    <div class="container container--narrow page-section">
        <?php 
        $theParent = wp_get_post_parent_id(get_the_ID());
        if($theParent){ ?>
        
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo the_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <?php };
      ?>
<?php $testArray = get_pages(array(
    'child_of' => get_the_ID()
));
if($theParent or $testArray){; ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
            <?php if($theParent){
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf  = get_the_ID();
            }

            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'

            ))
            ?>
            </ul>
            </div>
            <?php }; ?>
            <!--
          <li class="current_page_item"><a href="#">Our History</a></li>
          <li><a href="#">Our Goals</a></li>
        </ul>
      </div>-->

      <div class="generic-content">
        <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>"> <!-- site_url() is a WP function that returns the URL of the site. -->
        <label class="headline headline--medium" for="s">Perform a New Search:</label>
        <div class="search-form-row">
            <input placeholder="What are you looking for?" id="s" class="s" type="search" name="s">
            <input class="search-submit" type="submit" value="Search">
            </div>
        </form>
      </div>
    </div>  `z
    
    <?php
};
get_footer();
?>
