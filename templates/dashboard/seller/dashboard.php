<?php
// Ensure you include the header and necessary styles/scripts
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// get_header();
include plugin_dir_path(__FILE__) . '../../../includes/header.php';

?>

<div class="dashboard-wrap">
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="https://demo.bootstrapdash.com/purple-admin-free/assets/images/faces/face1.jpg" alt="profile">
                            <span class="login-status online"></span>
                            <!--change to offline or busy as needed-->
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">Jhon Doe</span>
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/dashboard')); ?>">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/messages')); ?>">
                        <span class="menu-title">Message</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/dashboard')); ?>">
                        <span class="menu-title">All listing</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/add-listing')); ?>">
                        <span class="menu-title">Add listing</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Transactions</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Orders</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Reviews</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Withdraw</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Settings</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Logout</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Add Listing</h3>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form id="listingForm">
                                    <label for="listingTitle">Title:</label>
                                    <input class="form-control" type="text" id="listingTitle" name="title" required>

                                    <label for="listingDescription">Description:</label>
                                    <textarea class="form-control" id="listingDescription" name="description" required></textarea>

                                    <!-- Add additional fields for metaboxes -->
                                    <label for="listingRegularPrice">Regular Price:</label>
                                    <input class="form-control" type="text" id="listingRegularPrice" name="regular_price">

                                    <label for="listingOfferPrice">Offer Price:</label>
                                    <input class="form-control" type="text" id="listingOfferPrice" name="offer_price">

                                    <label for="listingAddress">Address:</label>
                                    <input class="form-control" type="text" id="listingAddress" name="address">

                                    <label for="listingSize">Size:</label>
                                    <input class="form-control" type="text" id="listingSize" name="size">

                                    <label for="listingWeight">Weight:</label>
                                    <input class="form-control" type="text" id="listingWeight" name="weight">

                                    <label for="listingStock">Stock:</label>
                                    <input class="form-control" type="number" id="listingStock" name="stock">

                                    <label for="listingGmapsPlaceId">Google Maps Place ID:</label>
                                    <input class="form-control" type="text" id="listingGmapsPlaceId" name="gmaps_place_id">

                                    <input class="form-control" type="hidden" name="security" value="<?php echo wp_create_nonce('echolist_nonce'); ?>">

                                    <button type="submit">Submit Listing</button>
                                </form>
                                <div id="listingResponse"></div>

                                <div id="listingResponse" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<?php
// Get Footer
include plugin_dir_path(__FILE__) . '../../../includes/footer.php';
?>