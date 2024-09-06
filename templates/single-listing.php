<?php
/*
Template Name: Custom Buy Now Page
*/

get_header();
?>

<div class="container">
    <h1>Buy Now</h1>
    <p>The product price is $100.</p>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="custom_buy_now">
        <input type="hidden" name="amount" value="100"> <!-- Set your static amount here -->
        <button type="submit" class="btn btn-primary">Buy Now</button>
    </form>
    <h1>Available Balance</h1>
    <?php
    if (class_exists('WooCommerce') && is_user_logged_in()) {
        $user_id = get_current_user_id();

        // Retrieve the balance from user meta
        $balance = get_user_meta($user_id, 'available_balance', true);

        // Check if balance is set; default to 0 if not
        if ($balance === '') {
            $balance = 0;
        }

        echo '<h2>Your Available Balance: $' . number_format($balance, 2) . '</h2>';
    } else {
        echo '<p>You need to be logged in to view your balance.</p>';
    }
    ?>
</div>

<?php get_footer(); ?>