<?php
// Ensure you include the header and necessary styles/scripts
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


get_header();

$nonce = wp_create_nonce('add_listing_nonce');
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar with menu -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo esc_url(home_url('/dashboard')); ?>"><i class="sl sl-icon-settings"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/messages')); ?>"><i class="sl sl-icon-envelope-open"></i> Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/add-listing')); ?>"><i class="fa fa-plus"></i> Add Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/all-listings')); ?>"><i class="fa fa-list"></i> All Listings</a>
                </li>
                <!-- Add more menu items as needed -->
            </ul>
        </div>
        <div class="col-md-9">
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
    </div>
</div>
<?php
// Ensure you include the footer
get_footer();
?>