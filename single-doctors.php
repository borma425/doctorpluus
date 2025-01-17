<?php

// In your PHP template file (e.g., single-doctor.php)
$context = Timber::context();
$context['doctor'] = Timber::get_post();
Timber::render('content/single-doctor.twig', $context);