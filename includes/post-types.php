<?php
// Add custom columns for certificates.
function certificate_add_custom_columns($columns) {
    $columns['certificate_pdf'] = 'PDF';
    return $columns;
}
add_filter('manage_certificate_posts_columns', 'certificate_add_custom_columns');

// Populate custom column with the PDF link.
function certificate_custom_column_content($column, $post_id) {
    if ($column === 'certificate_pdf') {
        $pdf_url = get_post_meta($post_id, '_certificate_pdf_url', true);
        if ($pdf_url) {
            echo '<a href="' . esc_url($pdf_url) . '" target="_blank">Download PDF</a>';
        } else {
            echo 'Not generated';
        }
    }
}
add_action('manage_certificate_posts_custom_column', 'certificate_custom_column_content', 10, 2);