<?php
/*
Plugin Name: Location Address Meta Box with Suggestions
Description: Adds a meta box for location address with a dropdown of previously used addresses.
Version: 1.0
Author: Your Name
*/

// Add the Location Address Meta Box
function iwant_add_location_meta_box() {
    add_meta_box(
        'iwant_location_meta_box', // Meta box ID
        'Location Address',        // Meta box title
        'iwant_location_meta_box_callback', // Callback function
        'doctors-loc',         // Replace with your CPT slug
        'normal',                  // Context (normal, side, advanced)
        'high'                     // Priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'iwant_add_location_meta_box');

// Callback function to display the meta box
function iwant_location_meta_box_callback($post) {
    // Add a nonce field for security
    wp_nonce_field('iwant_location_meta_box', 'iwant_location_meta_box_nonce');

    // Get the current value of the location address if it exists
    $location_address = get_post_meta($post->ID, '_iwant_location_address', true);

    // Get all previously used addresses for this CPT
    $all_addresses = iwant_get_all_location_addresses();

    // Output the input field and dropdown
    echo '<label for="iwant_location_address">Location Address: </label>';
    echo '<input type="text" id="iwant_location_address" name="iwant_location_address" value="' . esc_attr($location_address) . '" style="width: 100%;" />';

    // Display the dropdown of previously used addresses
    if (!empty($all_addresses)) {
        echo '<p><strong>Or select a previously used address:</strong></p>';
        echo '<select id="iwant_location_address_dropdown" onchange="document.getElementById(\'iwant_location_address\').value = this.value;">';
        echo '<option value="">Select an address</option>';
        foreach ($all_addresses as $address) {
            echo '<option value="' . esc_attr($address) . '">' . esc_html($address) . '</option>';
        }
        echo '</select>';
    }
}

// Function to get all previously used location addresses for the CPT
function iwant_get_all_location_addresses() {
    global $wpdb;

    // Query the database for all unique meta values for the CPT
    $results = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT meta_value FROM $wpdb->postmeta
            WHERE meta_key = '_iwant_location_address'
            AND post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = %s)",
            'doctors-loc' // Replace with your CPT slug
        )
    );

    // Remove empty values and return the results
    return array_filter($results);
}

// Save the meta box data
function iwant_save_location_meta_box_data($post_id) {
    // Check if the nonce is set and valid
    if (!isset($_POST['iwant_location_meta_box_nonce']) || !wp_verify_nonce($_POST['iwant_location_meta_box_nonce'], 'iwant_location_meta_box')) {
        return;
    }

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the location address if it exists
    if (isset($_POST['iwant_location_address'])) {
        update_post_meta($post_id, '_iwant_location_address', sanitize_text_field($_POST['iwant_location_address']));
    }
}
add_action('save_post', 'iwant_save_location_meta_box_data');