<?php

//Add rewrite rules for custom URLs
function echolist_add_rewrite_rules() {
    add_rewrite_rule(
        '^dashboard/?',
        'index.php?dashboard=1',
        'top'
    );
    add_rewrite_rule(
        '^add-listing/?',
        'index.php?add-listing=1',
        'top'
    );
    add_rewrite_rule(
        '^login/?',
        'index.php?login=1',
        'top'
    );
    add_rewrite_rule(
        '^register/?',
        'index.php?register=1',
        'top'
    );
}
add_action('init', 'echolist_add_rewrite_rules');

// Add custom query variables
function echolist_query_vars($vars)
{
    $vars[] = 'dashboard';
    $vars[] = 'add-listing';
    $vars[] = 'login';
    $vars[] = 'register';

    return $vars;
}
add_filter('query_vars', 'echolist_query_vars');


// Add the Seller role
function echolist_add_seller_role(){
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
function echolist_activate_plugin(){
    echolist_add_seller_role();
}
register_activation_hook(__FILE__, 'echolist_activate_plugin');

function echolist_deactivate_plugin() {
    remove_role('seller');
}
register_deactivation_hook(__FILE__, 'echolist_deactivate_plugin');

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

// Hide admin bar for all users except administrators
add_filter('show_admin_bar', function ($show) {
    if (!current_user_can('administrator')) {
        return false;
    }
    return $show;
});