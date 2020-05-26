<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Zakeke_Admin_Order {

	/**
	 * Setup class.
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'add_scripts' ) );
		add_action( 'woocommerce_before_order_itemmeta', array( __CLASS__, 'add_order_item_meta' ), 10, 3 );
		add_filter( 'woocommerce_admin_order_item_thumbnail', array( __CLASS__, 'change_cart_item_thumbnail' ), 10, 3 );
	}

	public static function add_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		if ( in_array( str_replace( 'edit-', '', $screen_id ), wc_get_order_types( 'order-meta-boxes' ) ) ) {
			wp_register_script( 'zakeke-admin-order-preview',
				get_zakeke()->plugin_url() . '/assets/js/admin/preview.js', array(), ZAKEKE_VERSION );
			wp_enqueue_script( 'zakeke-admin-order-preview' );
		}
	}

	public static function add_order_item_meta( $item_id, $item, $order ) {
		$zakeke_data = $item->get_meta( 'zakeke_data' );
		if ( ! $zakeke_data ) {
			return;
		}

		$webservice = new Zakeke_Webservice();

		try {
			$previews = $webservice->get_previews( $zakeke_data['design'] );
		} catch ( Exception $e ) {
			$previews = array();
		}

		try {
			$output_zip = $webservice->get_zakeke_output_zip( $zakeke_data['design'] );
		} catch ( Exception $e ) {
			$output_zip = '';
		}

		add_thickbox();
		?>
        <div class="zakeke-previews" style="display: flex">
			<?php foreach ( $previews as $preview ): ?>
                <div class="zakeke-preview" style="cursor: pointer; margin: 0;">
                    <img src="<?php echo esc_url( $preview->url ) ?>" title="<?php echo esc_attr( $preview->label ) ?>"
                         style="width: 180px">
                </div>
			<?php endforeach; ?>
        </div>
		<?php if ( $output_zip ) : ?>
            <a href="<?php echo esc_url( $output_zip ) ?>" download>
				<?php _e( 'Download customization files' ) ?>
            </a>
		<?php else : ?>
			<?php _e( 'Customization files in processing' ) ?>
		<?php endif; ?>
		<?php
	}

	public static function change_cart_item_thumbnail( $image, $item_id, $item ) {
		if ( $zakeke_data = $item->get_meta( 'zakeke_data' ) ) {
			$image = '<img src="' . esc_url( $zakeke_data['previews'][0]->url ) . '" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" title="" width="150" height="150">';
		}

		return $image;
	}

}

Zakeke_Admin_Order::init();
