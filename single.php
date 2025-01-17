<?php

// In your PHP template file (e.g., single-doctor.php)
$context = Timber::context();
$context['post'] = Timber::get_post();
Timber::render('content/single.twig', $context);