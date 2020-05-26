<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Zakeke_Integration' ) ) :

	/**
	 * Zakeke_Integration Class.
	 */
	class Zakeke_Integration extends WC_Integration {

		/**
		 * Zakeke Integration Constructor.
		 */
		public function __construct() {
			$this->id                 = 'zakeke';
			$this->method_title       = __( 'Zakeke Interactive Product Designer', 'zakeke' );
            $this->method_description = __( 'Integrate Zakeke into WooCommerce. These credentials will be used to allow the integration of Zakeke with your store. By entering your Zakeke credentials your store will be able to communicate with the Zakeke API. Please refer to the <a href="https://www.zakeke.com/Documentation/Integration/WooCommerce">Zakeke documentation</a> if you are unsure how to proceed',
                'zakeke' );

			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();

			// Define user set variables.
			$this->username            = $this->get_option( 'username' );
			$this->password            = $this->get_option( 'password' );
			$this->client_id           = $this->get_option( 'client_id' );
			$this->secret_key          = $this->get_option( 'secret_ket' );
			$this->force_customization = $this->get_option( 'force_customization' );
            $this->hide_price          = $this->get_option( 'hide_price' );
			$this->debug               = $this->get_option( 'debug' );

			// Actions.
			add_action( 'woocommerce_update_options_integration_' . $this->id,
				array( $this, 'process_admin_options' ) );
		}

        /**
         * Processes and saves options.
         * If there the Zakeke credentials are invalid, no setting will be saved and an error is show.
         *
         * @return bool was anything saved?
         */
        public function process_admin_options() {
            $this->init_settings();

            $post_data = $this->get_post_data();

            $username = $this->get_field_value( 'username', array(), $post_data );

            if ( ! empty( $username ) ) {
                $password = $this->get_field_value( 'password', array(), $post_data );

                $webservice = new Zakeke_Webservice();
                if ( ! $webservice->are_valid_credentials( $username, $password ) ) {
                    $this->add_error( __( 'Incorrect Zakeke credentials', 'zakeke' ) );
                    WC_Admin_Settings::add_error( esc_html__( 'Incorrect Zakeke credentials', 'zakeke' ) );
                    return false;
                }
            }

            return parent::process_admin_options();
        }

		/**
		 * Initialize integration settings form fields.
		 */
		public function init_form_fields() {
			$this->form_fields = array(
				'username'            => array(
					'title'       => __( 'Zakeke username', 'zakeke' ),
					'type'        => 'text',
					'description' => __( 'Your Zakeke account username. Need a Zakeke account? <a href="https://www.zakeke.com/Admin/Register" target="_blank">Click here to get one</a>',
                        'zakeke' )
				),
				'password'            => array(
					'title'       => __( 'Zakeke password', 'zakeke' ),
					'type'        => 'password',
					'description' => __( 'Your Zakeke account password', 'zakeke' )
				),
                'client_id'          => array(
                    'title'       => __( 'Zakeke API client id', 'zakeke' ),
                    'type'        => 'text',
                    'description' => __( 'Your Zakeke API client id', 'zakeke' )
                ),
                'secret_key'         => array(
                    'title'       => __( 'Zakeke API secret key', 'zakeke' ),
                    'type'        => 'text',
                    'description' => __( 'Your Zakeke API secret key', 'zakeke' )
                ),
				'force_customization' => array(
					'title'       => __( 'Force product customization', 'zakeke' ),
					'type'        => 'checkbox',
					'default'     => 'yes',
					'description' => __( 'Replace the "Add to cart" button with the "Customize" button for customizable products',
						'zakeke' )
				),
                'hide_price' => array(
                    'title'       => __( 'Manage prices outside Zakeke', 'zakeke' ),
                    'type'        => 'checkbox',
                    'default'     => 'no',
                    'description' => __( 'Check when your products price is handled outside Zakeke',
                        'zakeke' )
                ),
				'debug'               => array(
					'title'       => __( 'Debug Log', 'zakeke' ),
					'type'        => 'checkbox',
					'label'       => __( 'Enable logging', 'zakeke' ),
					'default'     => 'no',
					'description' => __( 'Log events such as API requests', 'zakeke' ),
				)
			);
		}
	}

endif;