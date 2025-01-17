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

$context['posts'] = Timber::get_posts($args);

Timber::render('content/single-doctors-loc.twig', $context);