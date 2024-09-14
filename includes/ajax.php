<?php

// Listing Form Submission
function echolist_listing_form() {
    check_ajax_referer('echolist_nonce', 'security');

    if (!current_user_can('edit_posts')) {
        wp_send_json_error('You do not have permission to submit listings.');
    }

    $title = sanitize_text_field($_POST['title']);
    $description = sanitize_textarea_field($_POST['description']);

    if (empty($title) || empty($description)) {
        wp_send_json_error('Please fill out all required fields.');
    }

    $regular_price = isset($_POST['regular_price']) ? floatval($_POST['regular_price']) : 0;
    $offer_price = isset($_POST['offer_price']) ? floatval($_POST['offer_price']) : '';
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
    $weight = isset($_POST['weight']) ? sanitize_text_field($_POST['weight']) : '';
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
    $gmaps_place_id = isset($_POST['gmaps_place_id']) ? sanitize_text_field($_POST['gmaps_place_id']) : '';

    $listing_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $description,
        'post_type'    => 'listing',
        'post_status'  => 'pending'
    ));

    if (is_wp_error($listing_id)) {
        wp_send_json_error('Failed to create listing.');
    }

    update_post_meta($listing_id, 'listing_regular_price', $regular_price);
    update_post_meta($listing_id, 'listing_offer_price', $offer_price);
    update_post_meta($listing_id, 'listing_address', $address);
    update_post_meta($listing_id, 'listing_size', $size);
    update_post_meta($listing_id, 'listing_weight', $weight);
    update_post_meta($listing_id, 'listing_stock', $stock);
    update_post_meta($listing_id, 'listing_gmaps_place_id', $gmaps_place_id);

    wp_send_json_success(array('listing_id' => $listing_id));
    wp_die();
}

add_action('wp_ajax_submit_listing', 'echolist_listing_form');


// Registration Form
function echolist_register_form()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'echolist-register-nonce')) {
        wp_send_json_error('Invalid security token.');
    }

    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $retype_password = sanitize_text_field($_POST['retype_password']);
    $role = sanitize_text_field($_POST['role']);

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

    $user_data = array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass'  => $password,
        'role'       => $role, // Role can be 'seller' or 'customer'
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name'  => sanitize_text_field($_POST['last_name']),
    );

    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
    }

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    $redirect_url = ($role === 'seller') ? home_url('/dashboard') : home_url('/listing');

    wp_send_json_success(array('message' => 'Registration successful!', 'redirect_url' => $redirect_url));
}

add_action('wp_ajax_nopriv_register_user', 'echolist_register_form');
add_action('wp_ajax_register_user', 'echolist_register_form');


// Login Form
function echolist_login_form()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'echolist-login-nonce')) {
        wp_send_json_error('Invalid security token.');
    }

    $creds = array();
    $creds['user_login'] = sanitize_text_field($_POST['login_email']);
    $creds['user_password'] = $_POST['login_password'];
    $creds['remember'] = isset($_POST['remember_me']) ? true : false;

    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
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

add_action('wp_ajax_nopriv_login_user', 'echolist_login_form');
add_action('wp_ajax_login_user', 'echolist_login_form');