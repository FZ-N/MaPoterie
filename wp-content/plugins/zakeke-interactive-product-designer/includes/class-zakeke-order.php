<?php

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Zakeke_Order
{

    /**
     * Setup class.
     */
    public static function init()
    {
        add_action('woocommerce_add_order_item_meta', array(__CLASS__, 'add_order_item_meta'), 20, 2);
        add_action('woocommerce_thankyou', array(__CLASS__, 'new_order'), 20);
        add_action('woocommerce_order_status_processing', array(__CLASS__, 'new_order'));
        add_action('woocommerce_before_order_object_save', array(__CLASS__, 'update_order'));

        add_action('woocommerce_order_item_meta_start', array(__CLASS__, 'order_item_meta_start'), 20, 3);
    }

    public function add_order_item_meta($item_id, $values)
    {
        if (isset($values['zakeke_data'])) {
            wc_add_order_item_meta($item_id, 'zakeke_data', $values['zakeke_data']);
        }
    }

    /**
     * @param WC_Order $order
     */
    public static function update_order($order)
    {
        if ($order->has_status('processing')) {
            self::new_order($order->get_id());
        }
    }

    public static function new_order($order_id)
    {
        if (get_post_meta($order_id, 'zakeke_placed_order', true)) {
            return;
        }

        $order = wc_get_order($order_id);

        $data = array(
            'orderCode'            => $order_id,
            'ecommerceOrderNumber' => $order->get_order_number(),
            'sessionID'            => get_current_user_id(),
            'total'                => $order->get_total(),
            'orderStatusID'        => 1,
            'details'              => array()
        );

        if ($order->has_shipping_address()) {
            $states = WC()->countries->get_states($order->get_shipping_country());

            $data['shippingAddress'] = array(
                'firstName'    => $order->get_shipping_first_name(),
                'lastName'     => $order->get_shipping_last_name(),
                'city'         => $order->get_shipping_city(),
                'zip'          => $order->get_shipping_postcode(),
                'provinceCode' => $order->get_shipping_state(),
                'province'     => ! empty($states[$order->get_shipping_state()]) ? $states[$order->get_shipping_state()] : null,
                'countryCode'  => $order->get_shipping_country(),
                'country'      => ! empty(WC()->countries->countries[$order->get_shipping_country()]) ? WC()->countries->countries[$order->get_shipping_country()] : null,
                'address1'     => $order->get_shipping_address_1(),
                'address2'     => $order->get_shipping_address_2(),
                'company'      => $order->get_shipping_company()
            );
        }

        $guestCode = zakeke_guest_code();
        if ($order->get_customer_id() > 0) {
            $data['customerID'] = $order->get_customer_id();
        } elseif ($guestCode) {
            $data['visitorID'] = $guestCode;
        }

        foreach ($order->get_items('line_item') as $order_item_id => $item) {
            $product     = $item->get_product();
            $zakeke_data = $item->get_meta('zakeke_data');

            if ( ! $zakeke_data) {
                continue;
            }

            $item_data = array(
                'designDocID'     => $zakeke_data['design'],
                'orderDetailCode' => $order_item_id,
                'sku'             => is_object($product) ? $product->get_sku() : null,
                'variantCode'     => strval($item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id()),
                'quantity'        => absint($item->get_quantity()),
                'designUnitPrice' => $zakeke_data['price_excl_tax'],
                'modelUnitPrice'  => $zakeke_data['original_final_excl_tax_price'],
                'retailPrice'     => $zakeke_data['original_final_price'] + $zakeke_data['price']
            );

            $data['details'][] = $item_data;
        }

        if (count($data['details']) > 0) {
            $webservice = new Zakeke_Webservice();
            $webservice->place_order($data);

            update_post_meta($order_id, 'zakeke_placed_order', true);
        }
    }

    public static function order_item_meta_start($item_id, $item, $order)
    {
        if ($zakeke_data = $item->get_meta('zakeke_data')) {
            ?>
            <ul class="wc-item-meta">
                <li><strong class="wc-item-meta-label"><?php _e('Customization', 'zakeke') ?>:</strong><img
                            src="<?php echo esc_url($zakeke_data['previews'][0]->url) ?>"/></li>
                <?php if ($zakeke_data['price_tax'] > 0.0) : ?>
                    <li><strong class="wc-item-meta-label"><?php _e('Customization Price', 'zakeke') ?>
                            :</strong> <?php echo wc_price($zakeke_data['price_tax']) ?></li>
                <?php endif ?>
            </ul>
            <?php
        }
    }
}

Zakeke_Order::init();
