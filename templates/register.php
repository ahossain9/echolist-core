<?php

/**
 * Template Name: Registration Form
 */

get_header(); ?>

<div class="container">
    <form id="registrationForm" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="retype_password">Retype Password</label>
            <input type="password" name="retype_password" id="retype_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
        </div>

        <input type="hidden" name="role" value="seller"> <!-- or dynamic based on tab selection -->

        <input type="hidden" name="nonce" id="register-nonce" value="<?php echo wp_create_nonce('ajax-register-nonce'); ?>">

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <div id="registrationResponse" class="mt-3"></div>

</div>


<?php get_footer(); ?>