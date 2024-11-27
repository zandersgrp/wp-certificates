<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Generate PDF and save it to the uploads directory.
function certificate_generate_pdf($post_id) {
    require_once 'path/to/dompdf/autoload.inc.php';
    $dompdf = new Dompdf\Dompdf();

    // Get the certificate HTML template.
    $html = generate_certificate_template($post_id);
    $dompdf->loadHtml($html);
    $dompdf->render();

    // Save the PDF to the uploads directory.
    $upload_dir = wp_upload_dir();
    $path = $upload_dir['basedir'] . "/certificate-{$post_id}.pdf";
    $url = $upload_dir['baseurl'] . "/certificate-{$post_id}.pdf";

    file_put_contents($path, $dompdf->output());

    // Save the PDF URL as post meta for later use.
    update_post_meta($post_id, '_certificate_pdf_url', $url);

    return $path;
}