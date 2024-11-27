<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Generate HTML for certificates.
function generate_certificate_template($post_id) {
    $post = get_post($post_id);
    $meta = get_post_meta($post_id);
    ob_start();
    ?>
    <div style="font-family: Arial, sans-serif; border: 2px solid black; padding: 20px;">
        <h1 style="text-align: center;">Certificate of <?= esc_html($meta['certificate_type'][0]) ?></h1>
        <p>This certifies that <strong><?= esc_html($meta['client_name'][0]) ?></strong></p>
        <p>Date: <?= esc_html($meta['wedding_date'][0]) ?></p>
        <p>Witness 1: <?= esc_html($meta['witness_1'][0]) ?></p>
        <p>Witness 2: <?= esc_html($meta['witness_2'][0]) ?></p>
    </div>
    <?php
    return ob_get_clean();
}