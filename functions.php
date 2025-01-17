<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DEV_MODE', true);

// Initialize Timber.
Timber\Timber::init();

require(get_theme_file_path('inc/view-page-source.php'));

require(get_theme_file_path('inc/setup.php'));
require(get_theme_file_path('inc/enqueues.php'));
require(get_theme_file_path('inc/custom_post_type.php'));
require(get_theme_file_path('inc/acf/main.php'));
require(get_theme_file_path('inc/customizer/main.php'));
require(get_theme_file_path('inc/contact_us.php'));


require(get_theme_file_path('inc/send_order.php'));



function custom_admin_menu_script() {
    wp_enqueue_script('custom-admin-menu', get_template_directory_uri() . '/js/custom-admin-menu.js', array(), null, true);
    wp_add_inline_script('custom-admin-menu', '
        document.addEventListener("DOMContentLoaded", function() {
            const menuReplacements = {
                "doctors": "الأطباء",
                "orders": "الحجوزات",
                "article_doctors": "أقسام بلعنوان",
                // Add more replacements as needed
            };
            document.querySelectorAll("#adminmenu li a .wp-menu-name").forEach(el => {
                const menuText = el.textContent.trim();
                if (menuReplacements[menuText]) {
                    el.textContent = menuReplacements[menuText];
                }
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'custom_admin_menu_script');

