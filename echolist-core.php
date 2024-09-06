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
// require_once ECHOLIST_CORE_DIR . 'includes/class-echolist-core-loader.php';
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

// Add rewrite rules for custom URLs
// function echolist_add_rewrite_rules()
// {
//     // Dashboard URL
//     add_rewrite_rule(
//         '^dashboard/?',
//         'index.php?dashboard=1',
//         'top'
//     );

//     // Registration URL
//     add_rewrite_rule(
//         '^register/?',
//         'index.php?register=1',
//         'top'
//     );
// }
// add_action('init', 'echolist_add_rewrite_rules');

// // Add custom query variables
// function echolist_query_vars($vars)
// {
//     $vars[] = 'dashboard';
//     $vars[] = 'register';
//     return $vars;
// }
// add_filter('query_vars', 'echolist_query_vars');


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


// function echolist_template_loader($template)
// {
//     // Check for custom query variables and load the corresponding template
//     if (get_query_var('dashboard')) {
//         return plugin_dir_path(__FILE__) . 'templates/dashboard.php';
//         // if ($custom_template) {
//         //     return $custom_template;
//         // }
//     }

//     if (get_query_var('register')) {
//         return plugin_dir_path(__FILE__) . 'templates/register-template.php';
//         // if ($custom_template) {
//         //     return $custom_template;
//         // }
//     }

//     // Check for custom post type templates
//     if (is_singular('listing')) {
//         $custom_template = echolist_locate_template('single-listing.php');
//         if ($custom_template) {
//             return $custom_template;
//         }
//     }

//     if (is_post_type_archive('listing')) {
//         $custom_template = echolist_locate_template('archive-listing.php');
//         if ($custom_template) {
//             return $custom_template;
//         }
//     }

//     return $template;
// }
// add_filter('template_include', 'echolist_template_loader');

// Register to query vars

add_filter('query_vars', 'add_query_vars');


function add_query_vars($vars)
{

    $vars[] = 'account';

    return $vars;
}


// Add rewrite endpoint


add_action('init', 'account_page_endpoint');

function account_page_endpoint()
{

    add_rewrite_endpoint('account', EP_ROOT);
}



// Load template

add_action('template_include', 'account_page_template');

function account_page_template($template)
{

    if (get_query_var('account', false) !== false) {

        return plugin_dir_path(__FILE__) . 'templates/account.php';
    }

    return $template;
}


                                        // function echolist_template_redirect()
                                        // {
                                        //     global $wp_query;

                                        //     if (isset($wp_query->query_vars['dashboard'])) {
                                        //         // Check if user is logged in
                                        //         if (!is_user_logged_in()) {
                                        //             wp_redirect(wp_login_url()); // Redirect to login if not logged in
                                        //             exit;
                                        //         }

                                        //         // Get current user info
                                        //         $user = wp_get_current_user();

                                        //         // Determine user role
                                        //         if (in_array('seller', $user->roles)) {
                                        //             // Load Seller Dashboard
                                        //             include(plugin_dir_path(__FILE__) . 'templates/seller/dashboard.php');
                                        //             exit;
                                        //         } elseif (in_array('customer', $user->roles)) {
                                        //             // Load Customer Dashboard
                                        //             include(plugin_dir_path(__FILE__) . 'templates/customer/dashboard.php');
                                        //             exit;
                                        //         } else {
                                        //             // Redirect or show an error if the role is not recognized
                                        //             wp_redirect(home_url());
                                        //             exit;
                                        //         }
                                        //     }
                                        // }
                                        // add_action('template_redirect', 'echolist_template_redirect');





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

    if (!current_user_can('edit_posts')) {
        wp_send_json_error('You do not have permission to submit listings.');
    }

    $title = sanitize_text_field($_POST['title']);
    $description = sanitize_textarea_field($_POST['description']);

    if (empty($title) || empty($description)) {
        wp_send_json_error('Please fill out all required fields.');
    }

    // Create a new listing (custom post type)
    $listing_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $description,
        'post_type'    => 'listing',
        'post_status'  => 'publish',
    ));

    if (is_wp_error($listing_id)) {
        wp_send_json_error('Failed to create listing.');
    }

    // If successful
    wp_send_json_success('Listing created successfully!');
}

add_action('wp_ajax_submit_listing', 'echolist_submit_listing');
// add_action('wp_ajax_nopriv_submit_listing', 'echolist_submit_listing');





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