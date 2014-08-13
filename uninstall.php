<?php

// All that is required to uninstall Simple Slider is to remove the option
// record (delete_option) and remove the posts set for sfrs_slider post
// type.

if (!defined('WP_UNINSTALL_PLUGIN'))
	exit();

// Remove the option
delete_option('sfrs_options');

// Setup a query
$args = array(
	'post_type' => 'sfrs_slider',
	'nopaging' => true
);

// Query slider posts
$old_posts = new WP_Query ($args);

// Loop through slider posts
while ($old_posts->have_posts()) {
	$old_posts->the_post();
	$id = get_the_ID();
	wp_delete_post($id, true);
}

// Clean up query
wp_reset_postdata();