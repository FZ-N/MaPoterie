<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Zakeke_Designer Class.
 */
class Zakeke_Designer {

	/**
	 * Setup class.
	 */
	public static function init() {
		if ( ! self::should_show_designer() ) {
			return;
		}

		remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ), 20 );
		add_action( 'wp', array( __CLASS__, 'authorization' ), 20 );
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ), 1100 );
	}

	private static function should_show_designer() {
		return ( ! empty( $_REQUEST['zakeke_design'] ) && 'new' === $_REQUEST['zakeke_design'] );
	}

	public static function enqueue_scripts() {
	    wp_register_style( 'zakeke-designer', get_zakeke()->plugin_url() . '/assets/css/frontend/designer.css',
            array(),  ZAKEKE_VERSION );

		wp_register_script(
		    'zakeke-designer',
            apply_filters( 'zakeke_javascript_designer', get_zakeke()->plugin_url() . '/assets/js/frontend/designer.js' ),
			array( 'jquery' ),
            ZAKEKE_VERSION
        );

		wp_enqueue_style( 'zakeke-designer' );
		wp_enqueue_script( 'zakeke-designer' );
	}

	public static function authorization() {
		global $wp_query;
	    global $zakeke_auth_token;

	    $auth = zakeke_get_auth();

		$user_id = get_current_user_id();
		if ( $user_id > 0 ) {
			$auth->set_customer( (string) $user_id );
		} else {
			$auth->set_guest( zakeke_guest_code() );
		}

		try {
			$zakeke_auth_token = $auth->get_auth_token();
		} catch (Exception $e) {
			wc_add_notice( 'We can\'t customize this product right now.', 'error' );
			wp_redirect( get_post_permalink( $wp_query->post->ID ) );
			exit;
		}
    }

	/**
	 * Load the Zakeke designer template.
	 *
	 * @param mixed $template
	 *
	 * @return string
	 */
	public static function template_loader( $template ) {
		$file     = 'zakeke.php';
		$template = locate_template( $file );
		if ( ! $template ) {
			$template = get_zakeke()->plugin_path() . '/templates/' . $file;
		}

		return $template;
	}
}

Zakeke_Designer::init();
