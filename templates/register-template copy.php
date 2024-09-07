<?php

/**
 * Template Name: Registration Form
 */

get_header(); ?>

<?php
// Load WordPress functions and hooks
if (isset($_POST['register_seller']) || isset($_POST['register_customer'])) {
    handle_registration_form(); // Call the form handling function
}
?>
<div class="container">
    <?
     ob_start(); // Start output buffering
    ?>
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="seller-tab" data-bs-toggle="tab" data-bs-target="#seller" type="button" role="tab" aria-controls="seller" aria-selected="true">Seller</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false">Customer</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="registrationTabsContent">
            <!-- Seller Registration Form -->
            <div class="tab-pane fade show active" id="seller" role="tabpanel" aria-labelledby="seller-tab">
                <form id="sellerRegistrationForm" method="post">
                    <?php wp_nonce_field( 'seller_registration_action', 'seller_registration_nonce' ); ?>
                    <input type="hidden" name="user_role" value="seller">
                    <div class="mb-3">
                        <label for="sellerUserName" class="form-label">User Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" id="sellerUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="sellerEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="first_name" id="sellerFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerLastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="last_name" id="sellerLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerCompanyName" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="sellerCompanyName">
                    </div>
                    <div class="mb-3">
                        <label for="sellerPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="sellerPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerRetypePassword" class="form-label">Retype Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="retype_password" id="sellerRetypePassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerPhoneNumber" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" id="sellerPhoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="sellerType" class="form-label">Company/Private Person <span class="text-danger">*</span></label>
                        <select class="form-select" name="company_type" id="sellerType" required>
                            <option value="">Select</option>
                            <option value="pursue">Pursue</option>
                            <option value="private_person">Private Person</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sellerInfo" class="form-label">Information</label>
                        <textarea class="form-control" name="info" id="sellerInfo" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="terms" id="sellerAgreeTerms" required>
                        <label class="form-check-label" for="sellerAgreeTerms">Agree to terms and conditions <span class="text-danger">*</span></label>
                    </div>
                    <button type="submit" name="register_seller" class="btn btn-primary">Register as Seller</button>
                </form>
            </div>

            <!-- Customer Registration Form -->
            <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <form id="customerRegistrationForm" method="post">
                    <?php wp_nonce_field( 'customer_registration_action', 'customer_registration_nonce' ); ?>
                    <input type="hidden" name="user_role" value="customer">
                    <div class="mb-3">
                        <label for="customerUserName" class="form-label">User Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" id="customerUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="customerEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="first_name" id="customerFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerLastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="last_name" id="customerLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerCompanyName" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="customerCompanyName">
                    </div>
                    <div class="mb-3">
                        <label for="customerPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="customerPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerRetypePassword" class="form-label">Retype Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="retype_password" id="customerRetypePassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerPhoneNumber" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" id="customerPhoneNumber" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="terms" id="customerAgreeTerms" required>
                        <label class="form-check-label" for="customerAgreeTerms">Agree to terms and conditions <span class="text-danger">*</span></label>
                    </div>
                    <button type="submit" name="register_customer" class="btn btn-primary">Register as Customer</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
    ?>
</div>


<?php get_footer(); ?>