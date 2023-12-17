<?php
if(!is_user_logged_in()){
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
while (have_posts()){
    the_post();
    pageBanner(array(
      'title' => 'My Notes',
      'subtitle' => 'Lectures, Discussions, & Thoughts',
      'photo' => 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?dpr=16auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop='
    ));
    ?>
    <div class="container container--narrow page-section">
        <ul class="min-list link-list" id="my-notes">
            <?php 
            $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => "-1",
                'author' => get_current_user_id()

            ));
            while ($userNotes -> have_posts()){
                $userNotes -> the_post(); ?>
                <li></li>
                <input class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                <span class="edit-note"><i class="fa fa-pencil">Edit</i></span>
                <span class="delete-note"><i class="fa fa-trash-o">Delete</i></span>
                <textarea class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
            </li>
            <?php };
            ?>
        </ul> 
        
    </div>
    
    <?php
};
get_footer();
?>
