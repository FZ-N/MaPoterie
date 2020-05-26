<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Zakeke_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		add_action( 'wc_ajax_zakeke_get_price', array( __CLASS__, 'get_price' ) );
	}

	/**
	 * Get a matching variation price based on posted attributes.
	 */
	public static function get_price() {
		ob_start();

		if ( ! empty( $_POST['product_id'] ) ) {
			$product_id = $_POST['product_id'];
		} else {
			$product_id = $_POST['add-to-cart'];
		}

        $qty = 1;
		if ( isset( $_POST['quantity'] ) ) {
            // Sanitize
            $qty = wc_stock_amount(preg_replace("/[^0-9\.]/", '', $_POST['quantity']));
            if ($qty <= 0) {
                $qty = 1;
            }
        }

		if ( ! ( $product = wc_get_product( absint( $product_id ) ) ) ) {
			die();
		}

		if ( $product->is_type( 'variable' ) ) {
			/** @var WC_Product_Data_Store_Interface $data_store */
            $data_store = WC_Data_Store::load( 'product' );
            $variation_id = $data_store->find_matching_product_variation( $product, wp_unslash( $_POST ) );
			if ( $variation_id ) {
			    $product = wc_get_product( $variation_id );
            }
		}

        do_action( 'zakeke_before_ajax_price', $product, $qty );

        $integration = new Zakeke_Integration();
        $hide_price = $integration->hide_price;

        $original_price = 0.0;
        $zakeke_final_price = 0.0;

		if ($hide_price !== 'yes') {
            $zakeke_price = 0.0;
		    $original_price = (float) wc_get_price_to_display( $product, array( 'qty' => $qty ) );

            if (isset($_POST['zakeke-percent-price']) && $_POST['zakeke-percent-price'] > 0.0) {
                $zakeke_price += $original_price * ((float)$_POST['zakeke-percent-price'] / 100);
            }
            if (isset($_POST['zakeke-price']) && $_POST['zakeke-price'] > 0.0) {
                $zakeke_price += (float)$_POST['zakeke-price'];
            }

            $zakeke_final_price = (float) wc_get_price_to_display( $product, array( 'price' => $zakeke_price ) );
        }

		wp_send_json( array(
            'is_purchasable'      => $product->is_purchasable(),
            'is_in_stock'         => $product->is_in_stock(),
            'price_including_tax' => $original_price + $zakeke_final_price
        ) );

		die();
	}
}

Zakeke_AJAX::init();
