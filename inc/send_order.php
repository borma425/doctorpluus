<?php

function handle_order_form_submission() {
    // Verify nonce
    if (!isset($_POST['order_form_nonce']) || !wp_verify_nonce($_POST['order_form_nonce'], 'submit_order_form_nonce')) {
        wp_redirect(home_url('/post_creation_failed'));
        exit;
    }

    $did = sanitize_text_field($_POST['did']); // Replace with your actual post ID
    $doctor = get_post($did);

    // Validate and sanitize input
    if ( $doctor && get_post_type($did) === 'doctors' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $doctor_name = $doctor->post_title;

        // Validate email
        if (!is_email($email)) {
            wp_redirect(home_url('/post_creation_failed'));
            exit;
        }

          // Create HTML content with inline CSS
          $html_content = '
          <div style="
              font-family: Arial, sans-serif;
              background-color: #f9f9f9;
              border: 1px solid #ddd;
              border-radius: 8px;
              padding: 20px;
              max-width: 400px;
              margin: 20px auto;
              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          direction: rtl; ">
              <h2 style="
                  color: #333;
                  text-align: center;
                  margin-top: 0;
                  font-size: 24px;
              ">
                  معلومات الحجز
              </h2>
                            <div style="
                  margin-bottom: 15px;
                  padding: 10px;
                  background-color: #fff;
                  border: 1px solid #eee;
                  border-radius: 4px;
              ">
                  <strong style="color: #555;">مع د/</strong>
                  <span style="color: #333;">' . esc_html($doctor_name) . '</span>
              </div>
              <div style="
                  margin-bottom: 15px;
                  padding: 10px;
                  background-color: #fff;
                  border: 1px solid #eee;
                  border-radius: 4px;
              ">
                  <strong style="color: #555;">اسم العميل :</strong>
                  <span style="color: #333;">' . esc_html($name) . '</span>
              </div>
              <div style="
                  margin-bottom: 15px;
                  padding: 10px;
                  background-color: #fff;
                  border: 1px solid #eee;
                  border-radius: 4px;
              ">
                  <strong style="color: #555;">البريد الألكتروني:</strong>
                  <span style="color: #333;">' . esc_html($email) . '</span>
              </div>
              <div style="
                  margin-bottom: 15px;
                  padding: 10px;
                  background-color: #fff;
                  border: 1px solid #eee;
                  border-radius: 4px;
              ">
                  <strong style="color: #555;">رقم الهاتف:</strong>
                  <span style="color: #333;">' . esc_html($phone) . '</span>
              </div>
          </div>';
  
        // Create a new post in the "orders" CPT
        $post_id = wp_insert_post([
            'post_title' => 'حجز من  ' . $name,
            'post_content' => $html_content, // Add the HTML content here
            'post_type' => 'orders',
            'post_status' => 'draft',
        ]);

        if ($post_id) {
         
         require(get_theme_file_path('inc/send_mail_order.php'));

            wp_redirect(home_url('/thank-you'));
            exit;
        } else {
            wp_redirect(home_url('/post_creation_failed'));
            exit;
        }
    } else {
        wp_redirect(home_url('/post_creation_failed'));
        exit;
    }
}
add_action('admin_post_submit_order_form', 'handle_order_form_submission');
add_action('admin_post_nopriv_submit_order_form', 'handle_order_form_submission');