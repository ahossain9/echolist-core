jQuery(document).ready(function ($) {
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
