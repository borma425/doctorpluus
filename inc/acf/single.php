<?php
/*
Plugin Name: Meta Title & Description Meta Box
Description: Adds a meta box with meta title and meta description fields for posts and doctors CPT.
Version: 1.0
Author: Your Name
*/

// Add the meta box
function add_custom_meta_box() {
    $post_types = array('post', 'doctors','doctors-loc');
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_meta_box',          // Meta box ID
            'Meta Title & Description', // Meta box title
            'render_custom_meta_box',   // Callback function to render the meta box
            $post_type,                 // Post type
            'side',                     // Context (normal, side, advanced)
            'high'                      // Priority (high, core, default, low)
        );
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Render the meta box content
function render_custom_meta_box($post) {
    // Retrieve existing values for the meta fields
    $meta_title = get_post_meta($post->ID, 'meta_title', true);
    $meta_description = get_post_meta($post->ID, 'meta_description', true);
    
    // Nonce field for security
    wp_nonce_field('custom_meta_box_nonce', 'custom_meta_box_nonce');
    
    // HTML for the meta box
    ?>
    <p>
        <label for="meta_title"><strong>Meta Title:</strong></label>
        <input type="text" id="meta_title" name="meta_title" value="<?php echo esc_attr($meta_title); ?>" style="width: 100%;" />
    </p>
    <p>
        <label for="meta_description"><strong>Meta Description:</strong></label>
        <textarea id="meta_description" name="meta_description" style="width: 100%;"><?php echo esc_textarea($meta_description); ?></textarea>
    </p>
    <?php
}

// Save the meta box data
function save_custom_meta_box_data($post_id) {
    // Check if nonce is set and valid
    if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
        return;
    }
    
    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save meta title
    if (isset($_POST['meta_title'])) {
        update_post_meta($post_id, 'meta_title', sanitize_text_field($_POST['meta_title']));
    }
    
    // Save meta description
    if (isset($_POST['meta_description'])) {
        update_post_meta($post_id, 'meta_description', sanitize_textarea_field($_POST['meta_description']));
    }
}
add_action('save_post', 'save_custom_meta_box_data');