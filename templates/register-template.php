<?php

/**
 * Template Name: Registration Form
 */

get_header(); ?>

<div class="container mt-5">
    <h2>Registration</h2>
    <?php
    // Ensure the user is not logged in
    if (is_user_logged_in()) {
        wp_redirect(home_url()); // Redirect to home if already logged in
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_type = isset($_POST['user_type']) ? sanitize_text_field($_POST['user_type']) : 'customer';

        // Validate nonce
        if (!isset($_POST['registration_nonce']) || !wp_verify_nonce($_POST['registration_nonce'], 'register_user')) {
            echo '<div class="alert alert-danger">Nonce verification failed. Please try again.</div>';
        } else {
            // Collect and sanitize form data
            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);
            $password = $_POST['password'];
            $retype_password = $_POST['retype_password'];
            $phone = sanitize_text_field($_POST['phone']);
            $company_name = sanitize_text_field($_POST['company_name']);
            $company_type = isset($_POST['company_type']) ? sanitize_text_field($_POST['company_type']) : '';
            $agree_terms = isset($_POST['agree_terms']);

            // Additional validation for passwords
            if ($password !== $retype_password) {
                echo '<div class="alert alert-danger">Passwords do not match.</div>';
            } elseif (!$agree_terms) {
                echo '<div class="alert alert-danger">You must agree to the terms and conditions.</div>';
            } else {
                // Create user
                $user_id = wp_create_user($username, $password, $email);
                if (is_wp_error($user_id)) {
                    echo '<div class="alert alert-danger">' . $user_id->get_error_message() . '</div>';
                } else {
                    // Update user meta
                    update_user_meta($user_id, 'first_name', $first_name);
                    update_user_meta($user_id, 'last_name', $last_name);
                    update_user_meta($user_id, 'phone', $phone);
                    update_user_meta($user_id, 'company_name', $company_name);
                    if ($user_type === 'seller') {
                        $user = new WP_User($user_id);
                        $user->add_role('seller');
                    }
                    // Redirect after registration
                    wp_redirect(home_url('/welcome'));
                    exit;
                }
            }
        }
    }
    ?>

    <form method="POST" action="">
        <?php wp_nonce_field('register_user', 'registration_nonce'); ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="seller-tab" data-bs-toggle="tab" href="#seller" role="tab" aria-controls="seller" aria-selected="true">Seller</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="false">Customer</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Seller Form -->
            <div class="tab-pane fade show active" id="seller" role="tabpanel" aria-labelledby="seller-tab">
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="retype_password" class="form-label">Retype Password</label>
                    <input type="password" class="form-control" id="retype_password" name="retype_password" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="company_type" class="form-label">Company/Private Person</label>
                    <select class="form-select" id="company_type" name="company_type" required>
                        <option value="pursue">Pursue</option>
                        <option value="private_person">Private Person</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="information" class="form-label">Additional Information</label>
                    <textarea class="form-control" id="information" name="information"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                    <label class="form-check-label" for="agree_terms">
                        I agree to the terms and conditions
                    </label>
                </div>
            </div>

            <!-- Customer Form -->
            <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="retype_password" class="form-label">Retype Password</label>
                    <input type="password" class="form-control" id="retype_password" name="retype_password" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                    <label class="form-check-label" for="agree_terms">
                        I agree to the terms and conditions
                    </label>
                </div>
            </div>
        </div>
        <input type="hidden" name="user_type" id="user_type" value="customer">
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9H93j3Y8NnQ8Y4z+efkaF4h5ZWl7ZaBPGGo6GT0p1x9mp1Y8zpK" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('user_type').value = this.getAttribute('id').replace('-tab', '');
        });
    });
</script>

<?php get_footer(); ?>