<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Create custom roles.
function certificate_register_roles() {
    add_role(
        'staff',
        'Staff',
        [
            'read' => true,
            'edit_certificates' => true,
            'edit_others_certificates' => true,
            'publish_certificates' => true,
            'read_private_certificates' => true,
        ]
    );
}
add_action('init', 'certificate_register_roles');

// Assign capabilities to administrator.
function certificate_add_admin_capabilities() {
    $role = get_role('administrator');
    if ($role) {
        $capabilities = [
            'edit_certificates',
            'edit_others_certificates',
            'publish_certificates',
            'read_private_certificates',
        ];
        foreach ($capabilities as $cap) {
            $role->add_cap($cap);
        }
    }
}
add_action('admin_init', 'certificate_add_admin_capabilities');