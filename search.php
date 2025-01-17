<?php

$search    = strip_tags( (string) wp_unslash( get_query_var('s') ) );

if ( $search  == "filter1") {


$args = array(
    'post_type'      => array( 'doctors'),
    's' => $search,
    'posts_per_page' => 10,
    'order' => 'ASC',
    'paged' => $paged,
);




if ( isset($_GET['sort'])  ) {




    // Get the current URL parameter tag Name
    $sort = isset($_GET['sort']) ? strip_tags((string) wp_unslash($_GET['sort'])) : 'most_relevant';

    // Define sorting options as a key-value map
    $sort_options = [
        'most_relevant' => [
            'key' => '', // No specific key for most relevant
            'orderby' => 'date', // Default orderby
            'order' => 'DESC', // Default order
        ],
        'highest_rated' => [
            'key' => 'ratings_stars', // Meta key for rating
            'orderby' => 'meta_value_num', // Order by numeric meta value
            'order' => 'DESC', // Highest rated first
        ],
        'lowest_price' => [
            'key' => 'detection_price', // Meta key for price
            'orderby' => 'meta_value_num', // Order by numeric meta value
            'order' => 'ASC', // Lowest price first
        ],
        'highest_price' => [
            'key' => 'detection_price', // Meta key for price
            'orderby' => 'meta_value_num', // Order by numeric meta value
            'order' => 'DESC', // Highest price first
        ],
        'shortest_wait_time' => [
            'key' => 'waiting_time', // Meta key for wait time
            'orderby' => 'meta_value_num', // Order by numeric meta value
            'order' => 'ASC', // Shortest wait time first
        ],
    ];


// Get the sorting parameters based on the selected sort option
$sort_params = $sort_options[$sort] ?? $sort_options['most_relevant']; // Default to 'most_relevant' if invalid sort option

// Build the meta query if a key is specified
$meta_query = [];
if (!empty($sort_params['key'])) {
    $meta_query = [
        'meta_query' => [
            [
                'key' => $sort_params['key'],
                'compare' => 'EXISTS', // Use 'EXISTS' to ensure posts have the meta key
            ],
        ],
    ];
}

// Build the main query arguments
$args = [
    's' => "", // Search keyword (empty for now)
    'post_type' => ['doctors'], // Post types to query
    'posts_per_page' => 10, // Number of posts per page
    'orderby' => $sort_params['orderby'], // Order by the specified field
    'order' => $sort_params['order'], // Order direction (ASC or DESC)
];

// Merge the meta query into the main query arguments
if (!empty($meta_query)) {
    $args = array_merge($args, $meta_query);
}

    }











$context = Timber::context();
$posts_data = Timber::get_posts( $args  );

$context = Timber::context([
    'posts' => $posts_data,
    'pagination' => $posts_data,

]);




Timber::render('content/archive-doctor.twig', $context);




}else{

echo esc_html("Some Error Here 425 But Not XSS Hahaaa");


}