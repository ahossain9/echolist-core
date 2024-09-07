<?php

//Add rewrite rules for custom URLs
function echolist_add_rewrite_rules() {
    // Dashboard URL
    add_rewrite_rule(
        '^dashboard/?',
        'index.php?dashboard=1',
        'top'
    );
    // Add listing URL
    add_rewrite_rule(
        '^add-listing/?',
        'index.php?add-listing=1',
        'top'
    );

    // Login URL
    add_rewrite_rule(
        '^login/?',
        'index.php?login=1',
        'top'
    );
    // Registration URL
    add_rewrite_rule(
        '^register/?',
        'index.php?register=1',
        'top'
    );
}
add_action('init', 'echolist_add_rewrite_rules');

// Add custom query variables
function echolist_query_vars($vars) {
    $vars[] = 'dashboard';
    $vars[] = 'add-listing';
    $vars[] = 'login';
    $vars[] = 'register';

    return $vars;
}
add_filter('query_vars', 'echolist_query_vars');


function get_user_dashboard_template($template_name)
{
    $user = wp_get_current_user();

    // Check if the user is logged in and is a seller
    if (is_user_logged_in() && in_array('seller', (array) $user->roles)) {
        // Seller dashboard templates
        $template_path = plugin_dir_path(__FILE__) . 'dashboard/seller/' . $template_name;
    } elseif (is_user_logged_in()) {
        // Customer dashboard templates
        $template_path = plugin_dir_path(__FILE__) . 'dashboard/customer/' . $template_name;
    } else {
        wp_redirect(home_url('/login'));
        exit;
    }

    // Check if the template exists
    if (file_exists($template_path)) {
        return $template_path;
    }

    return false; // Return false if no template is found
}

function load_custom_dashboard_templates($template)
{
    if (get_query_var('dashboard')) {
        $dashboard_template = get_user_dashboard_template('dashboard.php');
        if ($dashboard_template) {
            return $dashboard_template;
        }
    }

    if (get_query_var('add-listing')) {
        $add_listing_template = get_user_dashboard_template('add-listing.php');
        if ($add_listing_template) {
            return $add_listing_template;
        }
    }

    return $template; // Return the original template if nothing matches
}

add_filter('template_include', 'load_custom_dashboard_templates');



// Load template
add_action('template_include', 'account_page_template');

function account_page_template($template) {
    if (get_query_var('register')) {
        if (is_user_logged_in()) {
            _e( 'Already Logged In', 'echolist-core' );
        } else {
            $new_template = plugin_dir_path(__FILE__) . 'register.php';
            if (file_exists($new_template)) {
                return $new_template;
            }
        }
    }
    // if (get_query_var('register')) {
    //     $new_template = plugin_dir_path(__FILE__) . 'register.php';
    //     if (file_exists($new_template)) {
    //         return $new_template;
    //     }
    // }
    if (get_query_var('login')) {
        $new_template = plugin_dir_path(__FILE__) . 'login.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }

    return $template;
}