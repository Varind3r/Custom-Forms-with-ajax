<?php
/* Template Name: Homepage */
get_header();
?>

<section class="home-banner">
    <!-- <img src="<?php echo get_template_directory_uri().'/images/aaa.jpg' ?>"> -->
    <!-- <img src="<?php the_field('banner_image'); ?>"> -->
    <img src="<?php echo get_the_post_thumbnail_url(); ?>">

<h1> <?php the_title(); ?> </h1>

<h2><?php echo get_field('homepage_banner_heading'); ?></h2>
<p><?php echo get_field('homepage_banner_subheading'); ?></p>

<a href="<?php the_field('banner_button_url'); ?>"><?php the_field('banner_button'); ?></a>

</section>

<?php
if (is_user_logged_in()) {
    // User is logged in
    echo 'Welcome, logged-in user!', "<br>";
    $current_user = wp_get_current_user();
    echo $current_user->display_name ;
    $logout_url = wp_logout_url(home_url());
    ?>
    <a href="<?php echo home_url().'/change-password'?>">change password</a>
    <?php
    echo '<a href="' . esc_url($logout_url) . '">Logout</a>';
} else {
    // User is not logged in
    echo 'Please log in to access this content.';
    echo '<a href="' . home_url() . '/login">Login</a>';
}
?>



/* ----------------------------------------------------------------------------------------------------------
                                                 ACF repeater - Start
--------------------------------------------------------------------------------------------------------------*/

<?php

// Check rows exists.
if( have_rows('repeater_field_name') ):

    // Loop through rows.
    while( have_rows('repeater_field_name') ) : the_row();

        // Load sub field value.
        $sub_value = get_sub_field('sub_field');
        // Do something...

    // End loop.
    endwhile;

// No value.
else :
    // Do something...
endif;
?>
/* ------------------------------------------------------------------------------------------------------------
                                                 ACF repeater - End
--------------------------------------------------------------------------------------------------------------*/
<?php
get_footer();
?>
