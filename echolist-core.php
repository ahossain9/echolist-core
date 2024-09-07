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

    // Add the Seller role
    add_role(
        'seller',
        __('Seller', 'echolist-core'),
        [
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            'upload_files' => true,
            'edit_listing' => true,
        ]
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



// Register AJAX actions for non-logged-in users
add_action('wp_ajax_nopriv_register_user', 'ajax_register_user');
add_action('wp_ajax_register_user', 'ajax_register_user');

function ajax_register_user()
{
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-register-nonce')) {
        wp_send_json_error('Invalid security token.');
    }

    // Retrieve form data
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $retype_password = sanitize_text_field($_POST['retype_password']);
    $role = sanitize_text_field($_POST['role']);

    // Validate data
    if (empty($username) || empty($email) || empty($password) || empty($retype_password)) {
        wp_send_json_error('All fields are required.');
    }

    if (username_exists($username)) {
        wp_send_json_error('Error: Username already exists!');
    }

    if (email_exists($email)) {
        wp_send_json_error('Error: Email already registered!');
    }

    if ($password !== $retype_password) {
        wp_send_json_error('Error: Passwords do not match.');
    }

    // Register user
    $user_data = array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass'  => $password,
        'role'       => $role, // Role can be 'seller' or 'customer'
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name'  => sanitize_text_field($_POST['last_name']),
    );

    $user_id = wp_insert_user($user_data);

    // Check for errors during user registration
    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
    }

    // Log the new user in
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    // Redirect based on role
    $redirect_url = ($role === 'seller') ? home_url('/dashboard') : home_url('/listing');

    // Send success response
    wp_send_json_success(array('message' => 'Registration successful!', 'redirect_url' => $redirect_url));
}



// function handle_registration_form()
// {
//     if (isset($_POST['register_seller']) && wp_verify_nonce($_POST['seller_registration_nonce'], 'seller_registration_action')) {
//         $username = sanitize_text_field($_POST['username']);
//         $email = sanitize_email($_POST['email']);
//         $password = sanitize_text_field($_POST['password']);
//         $retype_password = sanitize_text_field($_POST['retype_password']);
//         $role = 'seller'; // Seller role

//         // Check if username already exists
//         if (username_exists($username)) {
//             echo 'Error: Sorry, that username already exists!';
//             return;
//         }

//         // Check if email already exists
//         if (email_exists($email)) {
//             echo 'Error: Sorry, that email is already registered!';
//             return;
//         }

//         // Check if passwords match
//         if ($password !== $retype_password) {
//             echo 'Error: Passwords do not match';
//             return;
//         }

//         // Insert the new seller user
//         $user_data = array(
//             'user_login'    => $username,
//             'user_email'    => $email,
//             'user_pass'     => $password,
//             'first_name'    => sanitize_text_field($_POST['first_name']),
//             'last_name'     => sanitize_text_field($_POST['last_name']),
//             'role'          => $role,
//         );

//         $user_id = wp_insert_user($user_data);

//         if (!is_wp_error($user_id)) {
//             // Add custom fields
//             update_user_meta($user_id, 'company_name', sanitize_text_field($_POST['company_name']));
//             update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone_number']));
//             update_user_meta($user_id, 'company_type', sanitize_text_field($_POST['company_type']));
//             update_user_meta($user_id, 'info', sanitize_textarea_field($_POST['info']));

//             echo 'Seller registration successful';
//         } else {
//             echo 'Error: ' . $user_id->get_error_message();
//         }
//     }

//     if (isset($_POST['register_customer']) && wp_verify_nonce($_POST['customer_registration_nonce'], 'customer_registration_action')) {
//         $username = sanitize_text_field($_POST['username']);
//         $email = sanitize_email($_POST['email']);
//         $password = sanitize_text_field($_POST['password']);
//         $retype_password = sanitize_text_field($_POST['retype_password']);
//         $role = 'customer'; // Default customer role

//         // Check if username already exists
//         if (username_exists($username)) {
//             echo 'Error: Sorry, that username already exists!';
//             return;
//         }

//         // Check if email already exists
//         if (email_exists($email)) {
//             echo 'Error: Sorry, that email is already registered!';
//             return;
//         }

//         // Check if passwords match
//         if ($password !== $retype_password) {
//             echo 'Error: Passwords do not match';
//             return;
//         }

//         // Insert the new customer user
//         $user_data = array(
//             'user_login'    => $username,
//             'user_email'    => $email,
//             'user_pass'     => $password,
//             'first_name'    => sanitize_text_field($_POST['first_name']),
//             'last_name'     => sanitize_text_field($_POST['last_name']),
//             'role'          => $role,
//         );

//         $user_id = wp_insert_user($user_data);

//         if (!is_wp_error($user_id)) {
//             // Add custom fields
//             update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone_number']));

//             echo 'Customer registration successful';
//         } else {
//             echo 'Error: ' . $user_id->get_error_message();
//         }
//     }
// }


// Hide admin bar for all users except administrators
add_filter('show_admin_bar', function ($show) {
    if (!current_user_can('administrator')) {
        return false;
    }
    return $show;
});


function ajax_login_user()
{
    // Check the nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-login-nonce')) {
        wp_send_json_error('Invalid security token.');
    }

    // Get the posted data
    $creds = array();
    $creds['user_login'] = sanitize_text_field($_POST['login_email']);
    $creds['user_password'] = $_POST['login_password'];
    $creds['remember'] = isset($_POST['remember_me']) ? true : false;

    // Attempt to log the user in
    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
        // Check if the user is a seller and redirect accordingly
        if (in_array('seller', (array) $user->roles)) {
            $redirect_url = site_url('/dashboard');
        } else {
            $redirect_url = site_url('/listing');
        }

        wp_send_json_success(array(
            'message' => 'Login successful!',
            'redirect_url' => $redirect_url
        ));
    }
}
add_action('wp_ajax_nopriv_login_user', 'ajax_login_user');



add_action('wp_ajax_logout_user', 'handle_ajax_logout');
add_action('wp_ajax_nopriv_logout_user', 'handle_ajax_logout'); // Allow non-logged-in users to access this action

function handle_ajax_logout()
{
    // Check for nonce if used for security
    // check_ajax_referer('your_nonce_action', 'nonce');

    // Log out the user
    wp_logout();

    // Return a JSON response
    wp_send_json_success(array(
        'redirect_url' => home_url() // Redirect to the home page or other desired URL
    ));
}
