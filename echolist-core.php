<?php

/**
 * Plugin Name: Echolist Core
 * Plugin URI:  https://omexer.com
 * Description: A listing management system with multivendor support.
 * Version:     1.0
 * Author:      Omexer
 * Author URI:  https://omexer.com
 * Text Domain: echolist-core
 * Domain Path: /languages
 */

// Prevent direct access
if (! defined('ABSPATH')) {
    exit;
}

// Define constants
define('ECHOLIST_CORE_VERSION', '1.0.0');
define('ECHOLIST_CORE_FILE', __FILE__);
define('ECHOLIST_CORE_DIR', plugin_dir_path(__FILE__));
define('ECHOLIST_CORE_URL', plugin_dir_url(__FILE__));
define('ECHOLIST_CORE_TEMPLATE_PATH', ECHOLIST_CORE_DIR . 'templates/');

// Include required files
require_once ECHOLIST_CORE_DIR . 'includes/class-echolist-core.php';
require_once ECHOLIST_CORE_DIR . 'templates/templates-functions.php';
// require_once ECHOLIST_CORE_DIR . 'includes/admin/class-echolist-core-admin.php';
// require_once ECHOLIST_CORE_DIR . 'includes/public/class-echolist-core-public.php';
// require_once ECHOLIST_CORE_DIR . 'includes/class-echolist-core-settings.php';

// Instantiate the plugin
// function run_echolist_core()
// {
//     $plugin = new Echolist_Core();
//     $plugin->run();
// }
// run_echolist_core();



// function echolist_locate_template($template_name)
// {
//     $template_path = 'echolist/';
//     $theme_template = locate_template(array($template_path . $template_name, $template_name));

//     if ($theme_template) {
//         return $theme_template;
//     }

//     // Fallback to the plugin template
//     return plugin_dir_path(__FILE__) . 'templates/' . $template_name;
// }



function echolist_add_seller_role()
{
    // Get the Editor role capabilities
    $editor = get_role('editor');

    // Add the Seller role with the same capabilities as Editor
    add_role(
        'seller',
        __('Seller', 'echolist-core'),
        $editor->capabilities
    );
}

// Add role on plugin activation
function echolist_activate_plugin()
{
    echolist_add_seller_role();
    // echolist_add_rewrite_rules();
    // flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'echolist_activate_plugin');

// Clean up on plugin deactivation (optional)
function echolist_deactivate_plugin()
{
    remove_role('seller');
    // flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'echolist_deactivate_plugin');



function echolist_submit_listing()
{
    // Verify nonce before proceeding
    check_ajax_referer('echolist_nonce', 'security');

    // Check if user has the right capabilities
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('You do not have permission to submit listings.');
    }

    // Sanitize and validate form data
    $title = sanitize_text_field($_POST['title']);
    $description = sanitize_textarea_field($_POST['description']);

    if (empty($title) || empty($description)) {
        wp_send_json_error('Please fill out all required fields.');
    }

    // Additional sanitization
    $regular_price = isset($_POST['regular_price']) ? floatval($_POST['regular_price']) : 0;
    $offer_price = isset($_POST['offer_price']) ? floatval($_POST['offer_price']) : '';
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
    $weight = isset($_POST['weight']) ? sanitize_text_field($_POST['weight']) : '';
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
    $gmaps_place_id = isset($_POST['gmaps_place_id']) ? sanitize_text_field($_POST['gmaps_place_id']) : '';

    // Create a new listing (custom post type)
    $listing_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $description,
        'post_type'    => 'listing',
        'post_status'  => 'pending', // Set to 'pending' initially
    ));

    // Check if there was an error inserting the post
    if (is_wp_error($listing_id)) {
        wp_send_json_error('Failed to create listing.');
    }

    // Save post meta
    update_post_meta($listing_id, 'listing_regular_price', $regular_price);
    update_post_meta($listing_id, 'listing_offer_price', $offer_price);
    update_post_meta($listing_id, 'listing_address', $address);
    update_post_meta($listing_id, 'listing_size', $size);
    update_post_meta($listing_id, 'listing_weight', $weight);
    update_post_meta($listing_id, 'listing_stock', $stock);
    update_post_meta($listing_id, 'listing_gmaps_place_id', $gmaps_place_id);

    // Return success response with listing ID
    wp_send_json_success(array('listing_id' => $listing_id));

    // Ensure the AJAX request exits after processing
    wp_die();
}

add_action('wp_ajax_submit_listing', 'echolist_submit_listing');



function echolist_enqueue_scripts()
{
    wp_enqueue_script('echolist-ajax', plugin_dir_url(__FILE__) . 'assets/js/echolist-core.js', ['jquery'], null, true);
    wp_localize_script(
        'echolist-ajax',
        'echolist_ajax', // This object is available in JavaScript
        array(
            'ajax_url' => admin_url('admin-ajax.php'), // Ajax URL for WordPress
            'ajax_nonce' => wp_create_nonce('echolist_nonce') // Generate nonce with a unique name
        )
    );

}
add_action('wp_enqueue_scripts', 'echolist_enqueue_scripts');