<?php

// In your PHP template file (e.g., single-doctor.php)
$context = Timber::context();

$location_address = get_post_meta($post->ID, '_iwant_location_address', true);

$args = array(
    'post_type' => 'doctors', // Your CPT slug
    'meta_key' => 'address', // Meta key
    'meta_value' => sanitize_text_field($location_address), // Replace with the address you're searching for
    'meta_compare' => 'LIKE', // Exact match
    'posts_per_page' => -1, // Retrieve all matching posts
);

// Fetch posts
$posts_query = Timber::get_posts($args);

// Convert Timber\PostQuery to an array of Timber\Post objects using to_array()
$posts = $posts_query->to_array();

// Check if any post has the 'show_top' tag
$has_show_top_tag = false;
foreach ($posts as $post) {
    if (has_tag('show_top', $post->ID)) {
        $has_show_top_tag = true;
        break;
    }
}

// If 'show_top' tag exists, prioritize those posts
if ($has_show_top_tag) {
    usort($posts, function ($a, $b) {
        $a_has_tag = has_tag('show_top', $a->ID);
        $b_has_tag = has_tag('show_top', $b->ID);

        if ($a_has_tag && !$b_has_tag) {
            return -1; // $a comes first
        } elseif (!$a_has_tag && $b_has_tag) {
            return 1; // $b comes first
        } else {
            return 0; // No change in order
        }
    });
}

// Pass the sorted posts to the context

$context = Timber::context([
    'posts' => $posts,
    'pagination' => $posts_query,
]);

Timber::render('content/single-doctors-loc.twig', $context);