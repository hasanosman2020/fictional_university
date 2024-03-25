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
        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input class="new-note-title" placeholder="Title">
            <textarea class="new-note-body" placeholder="Your note here."></textarea>
            <span class="submit-note">Create Note</span>
        </div>
        <ul class="min-list link-list" id="my-notes">
            <?php 
            $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => "-1",
                'author' => get_current_user_id()

            ));
            while ($userNotes -> have_posts()){
                $userNotes -> the_post(); ?>
                <li data-id="<?php the_ID(); ?>">
                <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>">
                <span class="edit-note"><i class="fa fa-pencil">Edit</i></span>
                <span class="delete-note"><i class="fa fa-trash-o">Delete</i></span>
                <textarea readonly class="note-body-field"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span> 
            </li>
            <?php };
            ?>
        </ul> 
        
    </div>
    
    <?php
};
get_footer();
?>
