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
            <form id="listingForm">
                <label for="listingTitle">Title:</label>
                <input type="text" id="listingTitle" name="title" required>

                <label for="listingDescription">Description:</label>
                <textarea id="listingDescription" name="description" required></textarea>

                <!-- Add additional fields for metaboxes -->
                <label for="listingRegularPrice">Regular Price:</label>
                <input type="text" id="listingRegularPrice" name="regular_price">

                <label for="listingOfferPrice">Offer Price:</label>
                <input type="text" id="listingOfferPrice" name="offer_price">

                <label for="listingAddress">Address:</label>
                <input type="text" id="listingAddress" name="address">

                <label for="listingSize">Size:</label>
                <input type="text" id="listingSize" name="size">

                <label for="listingWeight">Weight:</label>
                <input type="text" id="listingWeight" name="weight">

                <label for="listingStock">Stock:</label>
                <input type="number" id="listingStock" name="stock">

                <label for="listingGmapsPlaceId">Google Maps Place ID:</label>
                <input type="text" id="listingGmapsPlaceId" name="gmaps_place_id">

                <input type="hidden" name="security" value="<?php echo wp_create_nonce('echolist_nonce'); ?>">

                <button type="submit">Submit Listing</button>
            </form>

            <div id="listingResponse"></div>

            <div id="listingResponse" class="mt-3"></div>
        </div>
    </div>
</div>
<?php
// Ensure you include the footer
get_footer();
?>