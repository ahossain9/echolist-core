<?php

class Echolist_Metabox {
    public function __construct()
    {
        add_action('cmb2_admin_init', [$this, 'register_listing_metaboxes']);
    }

    public function register_listing_metaboxes()
    {
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

new Echolist_Metabox();
