<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Send email notification with the certificate PDF attached.
function send_certificate_email_notification($post_id) {
    // Ensure we only process 'certificate' post types.
    if (get_post_type($post_id) !== 'certificate') {
        return;
    }

    // Generate the PDF.
    $pdf_path = certificate_generate_pdf($post_id);

    // Safely retrieve meta values.
    $meta = get_post_meta($post_id);
    $certificate_type = $meta['certificate_type'][0] ?? 'Unknown';
    $client_name = $meta['client_name'][0] ?? 'No name provided';
    $wedding_date = $meta['wedding_date'][0] ?? 'No date provided';

    // Email details.
    $to = 'kyle.alexander@zanders.group'; // Replace with appropriate email address.
    $subject = 'New Certificate Generated';
    $message = "A new certificate has been generated:\n\n";
    $message .= "Type: " . esc_html($certificate_type) . "\n";
    $message .= "Name: " . esc_html($client_name) . "\n";
    $message .= "Date: " . esc_html($wedding_date) . "\n";

    // Send email with attachment.
    $headers = [];
    $attachments = [$pdf_path];
    wp_mail($to, $subject, $message, $headers, $attachments);
}
add_action('save_post_certificate', 'send_certificate_email_notification');