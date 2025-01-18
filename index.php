
<?php


$context = Timber::context();

$context['is_front_page'] = true;

$context['best_doctors'] = Timber::get_posts([
    'post_type' => 'doctors', // Target the 'doctors' CPT
    'meta_key' => 'ratings_stars', // Meta key for sorting
    'orderby' => 'meta_value_num', // Order by numeric value of the meta field
    'order' => 'DESC', // Sort in descending order (highest rating first)
    'posts_per_page' => 4, // Get top 4 doctors
]);

$context['posts'] = Timber::get_posts([
    'post_type' => 'post',
    'posts_per_page' => 6,
]);

$context['why_us'] = array(
    'main_title' => get_theme_mod('basic-why_us-main-title', ''),
    'sections' => array(),
);

$section_count = get_theme_mod('basic-why_us-sections', 1);
for ($i = 1; $i <= $section_count; $i++) {
    $context['why_us']['sections'][] = array(
        'title' => get_theme_mod("basic-why_us-section-title-$i", ''),
        'icon' => get_theme_mod("basic-why_us-section-icon-$i", ''),
        'description' => get_theme_mod("basic-why_us-section-desc-$i", ''),
    );
}



// Retrieve Feedbacks Customizer data
$context['feedbacks'] = array(
    'title' => get_theme_mod('basic-feedbacks-title', ''),
    'items' => array(),
);

$feedback_count = get_theme_mod('basic-feedbacks-count', 1);
for ($i = 1; $i <= $feedback_count; $i++) {
    $context['feedbacks']['items'][] = array(
        'avatar' => get_theme_mod("basic-feedback-avatar-$i", ''),
        'title' => get_theme_mod("basic-feedback-title-$i", ''),
        'description' => get_theme_mod("basic-feedback-desc-$i", ''),
    );
}


Timber::render('index-home.twig', $context);




