<?php
function enqueues() {

$ver = DEV_MODE ? time() : false;


if( !is_admin() ) {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', [], $ver, 'all' );
    wp_enqueue_style( 'bootstrap.min', asset_url('bootstrap.min.css','/css/'), [], $ver, 'all' );
    wp_enqueue_style( 'all.min', asset_url('all.min.css','/css/'), [], $ver, 'all' );
    wp_enqueue_style( 'main', asset_url('main.css','/css/'), [], $ver, 'all' );

    wp_enqueue_script("bootstrap.bundle.min.js", asset_url('bootstrap.bundle.min.js','/js/'), [], $ver, true );

    }

}


add_action('wp_enqueue_scripts', 'enqueues', 999);








