<?php
// Add Metaboxes for Doctor Details
function add_doctor_metaboxes() {
    add_meta_box(
        'doctor_photo_metabox',         // Metabox ID
        'Doctor Photo',                 // Metabox Title
        'render_doctor_photo_metabox',  // Callback function to render the metabox
        'doctors',                      // Custom Post Type (replace 'doctors' with your CPT slug)
        'normal',                       // Context (normal, side, advanced)
        'default'                       // Priority (default, high, low)
    );

    add_meta_box(
        'doctor_details_metabox',       // Metabox ID
        'Doctor Details',               // Metabox Title
        'render_doctor_details_metabox', // Callback function to render the metabox
        'doctors',                      // Custom Post Type
        'normal',                       // Context
        'default'                       // Priority
    );

    add_meta_box(
        'booking_dates_metabox',        // Metabox ID
        'Booking Date',                 // Metabox Title (updated to singular)
        'render_booking_dates_metabox', // Callback function to render the metabox
        'doctors',                      // Custom Post Type
        'normal',                       // Context
        'default'                       // Priority
    );
}
add_action('add_meta_boxes', 'add_doctor_metaboxes');

// Render Doctor Photo Metabox (unchanged)
function render_doctor_photo_metabox($post) {
    // Retrieve existing photo URL
    $doctor_photo = get_post_meta($post->ID, 'doctor_photo', true);

    // Nonce field for security
    wp_nonce_field('doctor_photo_nonce', 'doctor_photo_nonce');

    // HTML for the metabox
    echo '<label for="doctor_photo">Upload Doctor Photo:</label>';
    echo '<input type="text" id="doctor_photo" name="doctor_photo" value="' . esc_url($doctor_photo) . '" style="width: 70%;">';
    echo '<input type="button" id="upload_photo_button" class="button" value="Upload Photo">';
    echo '<p class="description">Upload a photo for the doctor.</p>';

    // Display the photo preview
    if ($doctor_photo) {
        echo '<div style="margin-top: 10px;"><img src="' . esc_url($doctor_photo) . '" style="max-width: 200px; height: auto;"></div>';
    }

    // Enqueue WordPress media uploader script
    wp_enqueue_media();
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#upload_photo_button').click(function() {
                var file_frame = wp.media({
                    title: 'Select or Upload Doctor Photo',
                    button: { text: 'Use this photo' },
                    multiple: false
                });

                file_frame.on('select', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    $('#doctor_photo').val(attachment.url);
                });

                file_frame.open();
            });
        });
    </script>
    <?php
}

// Render Doctor Details Metabox (unchanged)
function render_doctor_details_metabox($post) {
    // Retrieve existing values from the database
    $ratings_stars = get_post_meta($post->ID, 'ratings_stars', true);
    $address = get_post_meta($post->ID, 'address', true);
    $detection_price = get_post_meta($post->ID, 'detection_price', true);
    $waiting_time = get_post_meta($post->ID, 'waiting_time', true);
    $phone_number = get_post_meta($post->ID, 'phone_number', true);
    $gender = get_post_meta($post->ID, 'gender', true); // Gender field

    // Nonce field for security
    wp_nonce_field('doctor_details_nonce', 'doctor_details_nonce');

    // HTML for the metabox
    echo '<label for="ratings_stars">Ratings (1-5):</label>';
    echo '<input type="number" id="ratings_stars" name="ratings_stars" value="' . esc_attr($ratings_stars) . '" min="1" max="5" style="width: 100%; margin-bottom: 10px;">';

    echo '<label for="address">Address:</label>';
    echo '<input type="text" id="address" name="address" value="' . esc_attr($address) . '" style="width: 100%; margin-bottom: 10px;">';

    echo '<label for="detection_price">Detection Price:</label>';
    echo '<input type="text" id="detection_price" name="detection_price" value="' . esc_attr($detection_price) . '" style="width: 100%; margin-bottom: 10px;">';

    echo '<label for="waiting_time">Waiting Time:</label>';
    echo '<input type="text" id="waiting_time" name="waiting_time" value="' . esc_attr($waiting_time) . '" style="width: 100%; margin-bottom: 10px;">';

    echo '<label for="phone_number">Phone Number:</label>';
    echo '<input type="text" id="phone_number" name="phone_number" value="' . esc_attr($phone_number) . '" style="width: 100%; margin-bottom: 10px;">';

    // Gender Radio Buttons
    echo '<label>Gender:</label><br>';
    echo '<input type="radio" id="gender_man" name="gender" value="Man" ' . checked($gender, 'Man', false) . '> Man<br>';
    echo '<input type="radio" id="gender_woman" name="gender" value="Woman" ' . checked($gender, 'Woman', false) . '> Woman';
}

// Render Booking Dates Metabox (updated for single date)
function render_booking_dates_metabox($post) {
    // Retrieve existing booking date
    $booking_date = get_post_meta($post->ID, 'booking_date', true);
    $start_time = get_post_meta($post->ID, 'start_time', true);
    $end_time = get_post_meta($post->ID, 'end_time', true);

    // Nonce field for security
    wp_nonce_field('booking_dates_nonce', 'booking_dates_nonce');

    // HTML for the metabox
    echo '<label>Date:</label>';
    echo '<input type="text" name="booking_date" value="' . esc_attr($booking_date) . '" style="width: 100%; margin-bottom: 10px;">';

    echo '<label>Start Time:</label>';
    echo '<input type="text" name="start_time" value="' . esc_attr($start_time) . '" style="width: 100%; margin-bottom: 10px;">';

    echo '<label>End Time:</label>';
    echo '<input type="text" name="end_time" value="' . esc_attr($end_time) . '" style="width: 100%; margin-bottom: 10px;">';
}

// Save Metabox Data (updated for single date)
function save_doctor_metaboxes($post_id) {
    // Check nonce for Doctor Photo
    if (!isset($_POST['doctor_photo_nonce']) || !wp_verify_nonce($_POST['doctor_photo_nonce'], 'doctor_photo_nonce')) {
        return;
    }

    // Check nonce for Doctor Details
    if (!isset($_POST['doctor_details_nonce']) || !wp_verify_nonce($_POST['doctor_details_nonce'], 'doctor_details_nonce')) {
        return;
    }

    // Check nonce for Booking Dates
    if (!isset($_POST['booking_dates_nonce']) || !wp_verify_nonce($_POST['booking_dates_nonce'], 'booking_dates_nonce')) {
        return;
    }

    // Save Doctor Photo
    if (isset($_POST['doctor_photo'])) {
        update_post_meta($post_id, 'doctor_photo', esc_url_raw($_POST['doctor_photo']));
    }

    // Save Doctor Details
    if (isset($_POST['ratings_stars'])) {
        update_post_meta($post_id, 'ratings_stars', intval($_POST['ratings_stars']));
    }
    if (isset($_POST['address'])) {
        update_post_meta($post_id, 'address', sanitize_text_field($_POST['address']));
    }
    if (isset($_POST['detection_price'])) {
        update_post_meta($post_id, 'detection_price', sanitize_text_field($_POST['detection_price']));
    }
    if (isset($_POST['waiting_time'])) {
        update_post_meta($post_id, 'waiting_time', sanitize_text_field($_POST['waiting_time']));
    }
    if (isset($_POST['phone_number'])) {
        update_post_meta($post_id, 'phone_number', sanitize_text_field($_POST['phone_number']));
    }

    // Save Gender
    if (isset($_POST['gender'])) {
        update_post_meta($post_id, 'gender', sanitize_text_field($_POST['gender']));
    } else {
        delete_post_meta($post_id, 'gender'); // Remove gender if no option is selected
    }

    // Save Booking Date (single date)
    if (isset($_POST['booking_date'])) {
        update_post_meta($post_id, 'booking_date', sanitize_text_field($_POST['booking_date']));
    }
    if (isset($_POST['start_time'])) {
        update_post_meta($post_id, 'start_time', sanitize_text_field($_POST['start_time']));
    }
    if (isset($_POST['end_time'])) {
        update_post_meta($post_id, 'end_time', sanitize_text_field($_POST['end_time']));
    }
}
add_action('save_post', 'save_doctor_metaboxes');