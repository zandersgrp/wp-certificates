<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submissions.
function certificate_handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['certificate_form'])) {
        $post_id = wp_insert_post([
            'post_type' => 'certificate',
            'post_title' => sanitize_text_field($_POST['client_name']),
            'post_status' => 'publish',
        ]);

        $fields = ['certificate_type', 'wedding_date', 'witness_1', 'witness_2'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }

        // Generate PDF.
        $pdf_path = certificate_generate_pdf($post_id);

        // Send email.
        send_certificate_email_notification($post_id);

        wp_redirect(home_url('/thank-you/'));
        exit;
    }
}
add_action('template_redirect', 'certificate_handle_form_submission');