<?php
// Ensure you include the header and necessary styles/scripts
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


get_header();

$nonce = wp_create_nonce('add_listing_nonce');
?>
<div class="container">
    <form id="listingForm" method="post">
        <div class="mb-3">
            <label for="listingTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="listingTitle" name="listingTitle" required>
        </div>
        <div class="mb-3">
            <label for="listingDescription" class="form-label">Description</label>
            <textarea class="form-control" id="listingDescription" name="listingDescription" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Listing</button>
    </form>

    <div id="listingResponse" class="mt-3"></div>



</div>
<?php
// Ensure you include the footer
get_footer();
?>