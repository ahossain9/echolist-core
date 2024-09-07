<?php

/**
 * Template Name: Registration Form
 */

get_header(); ?>

<div class="container">
    <form id="loginForm" method="post" class="mt-5">
        <div class="mb-3">
            <label for="login_email" class="form-label">Username or Email</label>
            <input type="text" class="form-control" id="login_email" name="login_email" required>
        </div>
        <div class="mb-3">
            <label for="login_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="login_password" name="login_password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
            <label class="form-check-label" for="remember_me">Remember Me</label>
        </div>
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('ajax-login-nonce'); ?>">
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="<?php echo wp_lostpassword_url(); ?>" class="btn btn-link">Forgot Password?</a>
    </form>

    <div id="loginResponse" class="mt-3"></div>


</div>


<?php get_footer(); ?>