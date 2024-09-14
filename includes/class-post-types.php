<?php

class Echolist_Post_Types {
    public function __construct() {
        add_action('init', [$this, 'register_listing_post_type']);
        add_action('init', [$this, 'register_listing_taxonomies']);
        add_action('cmb2_admin_init', [$this, 'register_listing_metaboxes']);
    }

    public function register_listing_post_type() {
        $labels = [
            'name'               => __('Listings', 'echolist-core'),
            'singular_name'      => __('Listing', 'echolist-core'),
            'menu_name'          => __('Listings', 'echolist-core'),
            'name_admin_bar'     => __('Listing', 'echolist-core'),
            'add_new'            => __('Add New', 'echolist-core'),
            'add_new_item'       => __('Add New Listing', 'echolist-core'),
            'new_item'           => __('New Listing', 'echolist-core'),
            'edit_item'          => __('Edit Listing', 'echolist-core'),
            'view_item'          => __('View Listing', 'echolist-core'),
            'all_items'          => __('All Listings', 'echolist-core'),
            'search_items'       => __('Search Listings', 'echolist-core'),
            'parent_item_colon'  => __('Parent Listings:', 'echolist-core'),
            'not_found'          => __('No listings found.', 'echolist-core'),
            'not_found_in_trash' => __('No listings found in Trash.', 'echolist-core'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'listing'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
        ];

        register_post_type('listing', $args);
    }

    public function register_listing_taxonomies()
    {
        // Category taxonomy
        $category_labels = [
            'name'              => _x('Categories', 'taxonomy general name', 'echolist-core'),
            'singular_name'     => _x('Category', 'taxonomy singular name', 'echolist-core'),
            'search_items'      => __('Search Categories', 'echolist-core'),
            'all_items'         => __('All Categories', 'echolist-core'),
            'parent_item'       => __('Parent Category', 'echolist-core'),
            'parent_item_colon' => __('Parent Category:', 'echolist-core'),
            'edit_item'         => __('Edit Category', 'echolist-core'),
            'update_item'       => __('Update Category', 'echolist-core'),
            'add_new_item'      => __('Add New Category', 'echolist-core'),
            'new_item_name'     => __('New Category Name', 'echolist-core'),
            'menu_name'         => __('Categories', 'echolist-core'),
        ];

        $category_args = [
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'listing-category'],
        ];

        register_taxonomy('listing_category', ['listing'], $category_args);

        // Region taxonomy
        $region_labels = [
            'name'              => _x('Regions', 'taxonomy general name', 'echolist-core'),
            'singular_name'     => _x('Region', 'taxonomy singular name', 'echolist-core'),
            'search_items'      => __('Search Regions', 'echolist-core'),
            'all_items'         => __('All Regions', 'echolist-core'),
            'parent_item'       => __('Parent Region', 'echolist-core'),
            'parent_item_colon' => __('Parent Region:', 'echolist-core'),
            'edit_item'         => __('Edit Region', 'echolist-core'),
            'update_item'       => __('Update Region', 'echolist-core'),
            'add_new_item'      => __('Add New Region', 'echolist-core'),
            'new_item_name'     => __('New Region Name', 'echolist-core'),
            'menu_name'         => __('Regions', 'echolist-core'),
        ];

        $region_args = [
            'hierarchical'      => true,
            'labels'            => $region_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'listing-region'],
        ];

        register_taxonomy('listing_region', ['listing'], $region_args);
    }

    public function register_listing_metaboxes(){
        $cmb = new_cmb2_box([
            'id'            => 'listing_metabox',
            'title'         => __('Listing Details', 'echolist-core'),
            'object_types'  => ['listing'],
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ]);

        $cmb->add_field([
            'name' => __('Short Description', 'echolist-core'),
            'id'   => 'listing_short_description',
            'type' => 'textarea_small',
        ]);

        $cmb->add_field([
            'name' => __('Regular Price', 'echolist-core'),
            'id'   => 'listing_regular_price',
            'type' => 'text_money',
            'before_field' => '₹', // Add currency symbol before the field
        ]);

        $cmb->add_field([
            'name' => __('Offer Price', 'echolist-core'),
            'id'   => 'listing_offer_price',
            'type' => 'text_money',
            'before_field' => '₹', // Add currency symbol before the field
        ]);

        $cmb->add_field([
            'name' => __('Address', 'echolist-core'),
            'id'   => 'listing_address',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Size', 'echolist-core'),
            'id'   => 'listing_size',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Weight', 'echolist-core'),
            'id'   => 'listing_weight',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Stock', 'echolist-core'),
            'id'   => 'listing_stock',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Google Maps Place ID', 'echolist-core'),
            'id'   => 'listing_gmaps_place_id',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Gallery', 'echolist-core'),
            'id'   => 'listing_gallery',
            'type' => 'file_list',
            'preview_size' => [100, 100],
        ]);

        $cmb->add_field([
            'name' => __('Product Image', 'echolist-core'),
            'id'   => 'listing_product_image',
            'type' => 'file',
        ]);

        $cmb->add_field([
            'name' => __('Delivery Options', 'echolist-core'),
            'id'   => 'listing_delivery_options',
            'type' => 'group',
            'options' => [
                'group_title'   => __('Option {#}', 'echolist-core'),
                'add_button'    => __('Add Another Option', 'echolist-core'),
                'remove_button' => __('Remove Option', 'echolist-core'),
                'sortable'      => true,
            ],
        ]);

        // Delivery Type
        $cmb->add_group_field('listing_delivery_options', [
            'name' => __('Type', 'echolist-core'),
            'id'   => 'delivery_type',
            'type' => 'select',
            'options' => [
                'collection' => __('Collection/Handover', 'echolist-core'),
                'shipment'   => __('Shipment', 'echolist-core'),
            ],
        ]);

        // Pick-up Address
        $cmb->add_group_field('listing_delivery_options', [
            'name'       => __('Pick-up Address', 'echolist-core'),
            'id'         => 'pickup_address',
            'type'       => 'text',
            'desc'       => __('Enter the pick-up address if Collection/Handover is selected.', 'echolist-core'),
            'attributes' => [
                'placeholder' => __('1234 Main St', 'echolist-core'),
                'data-conditional-id'    => 'delivery_type',
                'data-conditional-value' => 'collection',
            ],
        ]);

        // Apartment, Suite, Building (Optional)
        $cmb->add_group_field('listing_delivery_options', [
            'name'       => __('Apartment, Suite, Building (Optional)', 'echolist-core'),
            'id'         => 'apartment_suite_building',
            'type'       => 'text',
            'desc'       => __('Enter additional address information if needed.', 'echolist-core'),
            'attributes' => [
                'placeholder' => __('Apartment, suite, etc.', 'echolist-core'),
                'data-conditional-id'    => 'delivery_type',
                'data-conditional-value' => 'collection',
            ],
        ]);

        // Shipping Costs for One Item
        $cmb->add_group_field('listing_delivery_options', [
            'name'       => __('Shipping Costs for One Item', 'echolist-core'),
            'id'         => 'shipping_costs',
            'type'       => 'text_money',
            'before_field' => '₹', // Add currency symbol before the field
            'desc'       => __('Enter the shipping cost per item if Shipment is selected.', 'echolist-core'),
            'attributes' => [
                'placeholder' => __('Enter shipping cost', 'echolist-core'),
                'data-conditional-id'    => 'delivery_type',
                'data-conditional-value' => 'shipment',
            ],
        ]);
    }

}

new Echolist_Post_Types();