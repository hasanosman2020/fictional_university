This is Hasan Osman's Fictional University theme.
<?php
get_header();
while (have_posts()){
    the_post();
    ?>
    <h2><?php the_title(); ?></h2>
    <h2><?php the_content(); ?></h2>
    
    <?php
};
get_footer();
?>
