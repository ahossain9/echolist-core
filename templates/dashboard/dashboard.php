<?php
// Ensure you include the header and necessary styles/scripts
get_header(
?>

<div class="container mt-5">
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
            <!-- Form Content -->
            <form id="add-listing-form" enctype="multipart/form-data">
                <?php wp_nonce_field('add_listing_nonce', 'nonce'); ?>

                <div class="mb-3">
                    <label for="listing_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="listing_title" name="listing_title" required>
                </div>

                <div class="mb-3">
                    <label for="listing_description" class="form-label">Description</label>
                    <textarea class="form-control" id="listing_description" name="listing_description" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="listing_short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" id="listing_short_description" name="listing_short_description" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="listing_regular_price" class="form-label">Regular Price</label>
                        <input type="text" class="form-control" id="listing_regular_price" name="listing_regular_price" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="listing_offer_price" class="form-label">Offer Price</label>
                        <input type="text" class="form-control" id="listing_offer_price" name="listing_offer_price">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="listing_address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="listing_address" name="listing_address" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="listing_size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="listing_size" name="listing_size">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="listing_weight" class="form-label">Weight</label>
                        <input type="text" class="form-control" id="listing_weight" name="listing_weight">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="listing_stock" class="form-label">Stock</label>
                        <input type="text" class="form-control" id="listing_stock" name="listing_stock">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="listing_gmaps_place_id" class="form-label">Google Maps Place ID</label>
                    <input type="text" class="form-control" id="listing_gmaps_place_id" name="listing_gmaps_place_id">
                </div>

                <!-- Drag and Drop Gallery Upload -->
                <div class="mb-3">
                    <label class="form-label">Gallery</label>
                    <div class="dropzone" id="gallery-dropzone"></div>
                </div>

                <!-- Drag and Drop Product Image Upload -->
                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <div class="dropzone" id="product-image-dropzone"></div>
                </div>

                <!-- Delivery Options -->
                <div class="mb-3">
                    <label class="form-label">Delivery Options</label>
                    <div id="delivery-options-group">
                        <!-- Grouped fields will be dynamically added here -->
                    </div>
                    <button type="button" class="btn btn-primary" id="add-delivery-option">Add Delivery Option</button>
                </div>

                <button type="submit" class="btn btn-success">Submit Listing</button>
            </form>

            <!-- Success and Error Messages -->
            <div id="form-messages" class="mt-3"></div>
        </div>
    </div>
</div>

<?php
// Ensure you include the footer
get_footer();
?>