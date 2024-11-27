<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Register meta boxes for certificates.
function certificate_register_meta_boxes() {
    add_meta_box(
        'certificate_details',               // Meta box ID.
        'Certificate Details',               // Meta box title.
        'certificate_render_meta_box',       // Callback function to render the meta box.
        'certificate',                       // Custom post type.
        'normal',                            // Context (normal, side, etc.).
        'high'                               // Priority.
    );
}

// Render the meta box HTML.
function certificate_render_meta_box($post) {
    $fields = ['client_name', 'certificate_type', 'wedding_date', 'witness_1', 'witness_2'];
    foreach ($fields as $field) {
        $value = get_post_meta($post->ID, $field, true);
        echo "<label for='{$field}'>".ucwords(str_replace('_', ' ', $field))."</label>";
        echo "<input type='text' id='{$field}' name='{$field}' value='{$value}' style='width:100%; margin-bottom:10px;' />";
    }
}

// Save the meta box data when the post is saved.
function certificate_save_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $fields = ['client_name', 'certificate_type', 'wedding_date', 'witness_1', 'witness_2'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}