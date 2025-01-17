<?php

// In your PHP template file (e.g., single-doctor.php)
$context = Timber::context();
$context['order'] = Timber::get_post();
Timber::render('content/single-order.twig', $context);