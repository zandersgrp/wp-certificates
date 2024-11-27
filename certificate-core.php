<?php
/**
 * Plugin Name: Certificate Core
 * Description: A plugin to manage certificates for reverts, weddings, and divorces.
 * Version: 1.0
 * Author: Your Name
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define constants.
define('CERTIFICATE_CORE_PATH', plugin_dir_path(__FILE__));
define('CERTIFICATE_CORE_URL', plugin_dir_url(__FILE__));

// Include necessary files.
require_once CERTIFICATE_CORE_PATH . 'includes/post-types.php';
require_once CERTIFICATE_CORE_PATH . 'includes/meta-boxes.php';
require_once CERTIFICATE_CORE_PATH . 'includes/form-handler.php';
require_once CERTIFICATE_CORE_PATH . 'includes/pdf-generator.php';
require_once CERTIFICATE_CORE_PATH . 'includes/email-notifications.php';
require_once CERTIFICATE_CORE_PATH . 'includes/role-management.php';
require_once CERTIFICATE_CORE_PATH . 'includes/html-templates.php';

// Initialize the plugin.
function certificate_core_init() {
    certificate_register_post_types();
}
add_action('init', 'certificate_core_init');

// Hook meta boxes only in admin context.
if (is_admin()) {
    add_action('add_meta_boxes', 'certificate_register_meta_boxes');
    add_action('save_post_certificate', 'certificate_save_meta_boxes');
}

// Enqueue scripts and styles.
function certificate_core_enqueue_scripts() {
    wp_enqueue_style('certificate-core-styles', CERTIFICATE_CORE_URL . 'assets/css/styles.css');
    wp_enqueue_script('certificate-core-scripts', CERTIFICATE_CORE_URL . 'assets/js/scripts.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'certificate_core_enqueue_scripts');