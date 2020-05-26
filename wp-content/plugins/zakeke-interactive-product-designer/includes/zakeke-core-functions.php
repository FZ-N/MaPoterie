<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Zakeke Core Supported Themes.
 *
 * @return string[]
 */
function zakeke_get_core_supported_themes() {
	return array(
		'twentyseventeen',
		'twentysixteen',
		'twentyfifteen',
		'twentyfourteen',
		'twentythirteen',
		'twentyeleven',
		'twentytwelve',
		'twentyten'
	);
}

/**
 * Check whether the product is customizable.
 *
 * @param int $product_id
 *
 * @return bool Whether the product is customizable.
 */
function zakeke_is_customizable( $product_id ) {
	$zakeke_enabled = get_post_meta( $product_id, 'zakeke_enabled', 'no' );

	return 'yes' === $zakeke_enabled;
}

/**
 * Check whether the product has a provider.
 *
 * @param int $product_id
 *
 * @return bool Whether the product has a provider.
 */
function zakeke_has_provider( $product_id ) {
    $has_provider = get_post_meta( $product_id, 'zakeke_provider', 'no' );

    return 'yes' === $has_provider;
}

/**
 * Get the Zakeke guest identifier using cookies.
 *
 * @return string
 */
function zakeke_guest_code() {
    if ( isset( $_COOKIE['zakeke-guest'] ) ) {
        return $_COOKIE['zakeke-guest'];
    }

    $value = wp_generate_password( 32, false );
    /**Ten years */
    $period = 315360000;
    wc_setcookie( 'zakeke-guest', $value, time() + $period, is_ssl() );

    return $value;
}

function zakeke_customizer_url( $mobile ) {
	global $zakeke_auth_token;

	$product  = wc_get_product();
	$quantity = empty( $_REQUEST['quantity'] ) ? 1 : wc_stock_amount( $_REQUEST['quantity'] );

	if ( ! wc_tax_enabled() ) {
		$tax_policy = 'hidden';
	} else if ( get_option('woocommerce_tax_display_shop') === 'excl' ) {
		$tax_policy = 'excluding';
	} else {
		$tax_policy = 'including';
	}

	$data = array(
		'name'            => $product->get_title(),
		'qty'             => $quantity,
		'currency'        => get_woocommerce_currency(),
		'taxPricesPolicy' => $tax_policy,
		'culture'         => str_replace( '_', '-', get_locale() ),
		'modelCode'       => (string) $product->get_id(),
		'ecommerce'       => 'woocommerce',
		'attribute'       => array()
	);

	$auth = zakeke_get_auth();
	$data = $auth->set_customizer_token( $data, $zakeke_auth_token );

    $default_attributes = $product->get_default_attributes();
    if ($default_attributes) {
        foreach ($default_attributes as $attribute_slug => $attribute) {
            $data['attribute'][ $attribute_slug ] = $attribute;
        }
    }

	foreach ( $_REQUEST as $key => $value ) {
		$prefix = substr( $key, 0, 10 );
		if ( 'attribute_' === $prefix ) {
			$short_key                       = substr( $key, 10 );
			$data['attribute'][ $short_key ] = $value;
		}
	}

	$zakekeOption = $_REQUEST['zakeke_design'];
	if ( 'new' !== $zakekeOption ) {
		$data['designdocid'] = $zakekeOption;
	}

	$path = '/Customizer/index.html';
	if ( $mobile ) {
		$path = '/Customizer/index.mobile.html';
	}

	$url = ZAKEKE_BASE_URL . $path . '?' . http_build_query( apply_filters( 'zakeke_designer_url_data', $data ) );

	return $url;
}

function zakeke_customizer_config() {
	$config = array(
		'zakekeUrl'          => ZAKEKE_BASE_URL,
		'customizerLargeUrl' => zakeke_customizer_url( false ),
		'customizerSmallUrl' => zakeke_customizer_url( true ),
		'params'             => $_REQUEST
	);

	return apply_filters( 'zakeke_customizer_config', json_encode( $config ) );
}

/**
 * Calculate Zakeke price.
 *
 * @param float $price
 * @param array $pricing
 * @param int $qty
 *
 * @return float
 */
function zakeke_calculate_price($price, $pricing, $qty) {
	$zakekePrice = 0.0;

	if ( $pricing['modelPriceDeltaPerc'] > 0 ) {
		$zakekePrice += $price * ((float) $pricing['modelPriceDeltaPerc'] / 100);
	} else {
		$zakekePrice += (float) $pricing['modelPriceDeltaValue'];
	}

	if ( $pricing['designPrice'] > 0 ) {
		if ( isset($pricing['pricingModel']) && $pricing['pricingModel'] === 'advanced' ) {
			$zakekePrice += (float) $pricing['designPrice'] / $qty;
		} else {
			$zakekePrice += (float) $pricing['designPrice'];
		}
	}

	return $zakekePrice;
}

/**
 * Get an instance of the Zakeke auth based on the plugin configuration.
 *
 * @return Zakeke_Auth_Base
 */
function zakeke_get_auth() {
    $integration = new Zakeke_Integration();

    if ( strlen( $integration->get_option( 'client_id' ) ) === 0 ) {
        return new Zakeke_Auth_Legacy( $integration );
    } else {
        return new Zakeke_Auth( $integration );
    }
}
