jQuery(document).ready(function ($) {

jQuery(document).ready(function ($) {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize() + '&action=login_user';

        $.ajax({
            url: echolist_ajax.ajax_url, // Use localized AJAX URL
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Show the first message (Login successful)
                    $('#loginResponse').html('<div class="alert alert-success">' + response.data.message + '</div>');

                    // After 2 seconds, replace the first message with the second message (Redirecting...)
                    setTimeout(function () {
                        $('#loginResponse').html('<div class="alert alert-info">Redirecting to your dashboard...</div>');
                    }, 2000); // Replace the first message with the second one after 2 seconds

                    // Redirect after 4 seconds
                    setTimeout(function () {
                        window.location.href = response.data.redirect_url;
                    }, 4000); // Redirect after 4 seconds (2 seconds after the second message)
                } else {
                    $('#loginResponse').html('<div class="alert alert-danger">' + response.data + '</div>');
                }
            },
            error: function (xhr, status, error) {
                $('#loginResponse').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
            }
        });
    });
});





    $('#registrationForm').on('submit', function (e) {
    e.preventDefault();

    var password = $('#password').val();
    var confirmPassword = $('#retype_password').val();

    // Check if the password has at least 8 characters
    if (password.length < 8) {
        $('#registrationResponse').html('<div class="alert alert-danger">Password must be at least 8 characters long.</div>');
        return;
    }

    // Check if the password and confirm password match
    if (password !== confirmPassword) {
        $('#registrationResponse').html('<div class="alert alert-danger">Passwords do not match.</div>');
        return;
    }

    var formData = $(this).serialize() + '&action=register_user';

    $.ajax({
        url: echolist_ajax.ajax_url, // Use localized AJAX URL
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                // Show the first message (Registration successful)
                $('#registrationResponse').html('<div class="alert alert-success">' + response.data.message + '</div>');

                // After 2 seconds, replace the first message with the second message (Redirecting...)
                setTimeout(function () {
                    $('#registrationResponse').html('<div class="alert alert-info">Redirecting to your dashboard...</div>');
                }, 2000);

                // Redirect after 4 seconds
                setTimeout(function () {
                    window.location.href = response.data.redirect_url;
                }, 4000);
            } else {
                $('#registrationResponse').html('<div class="alert alert-danger">' + response.data + '</div>');
            }
        },
        error: function (xhr, status, error) {
            $('#registrationResponse').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
        }
    });
});


$('#logoutButton').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: echolist_ajax.ajax_url, // Use localized AJAX URL
            type: 'POST',
            data: {
                action: 'logout_user' // Action name for the logout request
            },
            success: function (response) {
                if (response.success) {
                    $('#logoutResponse').html('<div class="alert alert-success">Logout successful. Redirecting...</div>');
                    setTimeout(function () {
                        window.location.href = response.data.redirect_url;
                    }, 2000); // Redirect after 2 seconds
                } else {
                    $('#logoutResponse').html('<div class="alert alert-danger">' + response.data + '</div>');
                }
            },
            error: function (xhr, status, error) {
                $('#logoutResponse').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
            }
        });
    });


    
    $('#listingForm').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize() + '&action=submit_listing';

        $.ajax({
            url: echolist_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#listingResponse').html('<div class="alert alert-success">Listing submitted successfully!</div>');
                } else {
                    $('#listingResponse').html('<div class="alert alert-danger">' + response.data + '</div>');
                }
            },
            error: function (xhr, status, error) {
                $('#listingResponse').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
            }
        });
    });
});





// jQuery(document).ready(function($) {
//     $('#listingForm').on('submit', function(e) {
//         e.preventDefault();

//         var formData = {
//             action: 'submit_listing',
//             title: $('#listingTitle').val(),
//             description: $('#listingDescription').val(),
//             security: echolist_ajax.ajax_nonce // Use the localized nonce
//         };

//         $.ajax({
//             url: echolist_ajax.ajax_url, // Use localized URL
//             type: 'POST',
//             data: formData,
//             success: function(response) {
//                 if (response.success) {
//                     $('#listingResponse').html('<div class="alert alert-success">Listing submitted successfully!</div>');
//                 } else {
//                     $('#listingResponse').html('<div class="alert alert-danger">' + response.data + '</div>');
//                 }
//             }
//         });
//     });
// });
