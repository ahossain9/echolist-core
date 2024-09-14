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
require_once ECHOLIST_CORE_DIR . 'includes/class-post-types.php';
require_once ECHOLIST_CORE_DIR . 'includes/class-metabox.php';
require_once ECHOLIST_CORE_DIR . 'includes/functions.php';
require_once ECHOLIST_CORE_DIR . 'includes/ajax.php';
require_once ECHOLIST_CORE_DIR . 'templates/templates-functions.php';

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


function echolist_enqueue_scripts()
{
    wp_enqueue_style('echolist-css', plugin_dir_url(__FILE__) . 'assets/css/dashboard.css');
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

