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
    $vars[] = 'register';
    $vars[] = 'add-listing';
    return $vars;
}
add_filter('query_vars', 'echolist_query_vars');

// Load template
add_action('template_include', 'account_page_template');

function account_page_template($template) {

    if (get_query_var('dashboard')) {
        $new_template = plugin_dir_path(__FILE__) . 'dashboard/seller/dashboard.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    if (get_query_var('add-listing')) {
        $new_template = plugin_dir_path(__FILE__) . 'dashboard/seller/add-listing.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }

    return $template;
}