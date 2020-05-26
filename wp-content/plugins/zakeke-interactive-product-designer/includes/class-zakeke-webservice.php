<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Zakeke_Webservice {

	/**
	 * Debug mode.
	 *
	 * @var boolean
	 */
	private $debug;

	/**
	 * Logger instance.
	 *
	 * @var WC_Logger
	 */
	private $logger;

	/**
	 * Setup class.
	 */
	public function __construct() {
		$this->logger = new WC_Logger();
	}

	/**
	 * Performs the underlying HTTP request.
	 *
	 * @param  string $method HTTP method (GET|POST|PUT|PATCH|DELETE)
	 * @param  string $resource Zakeke API resource to be called
	 * @param  array $args array of parameters to be passed
	 * @param Zakeke_Auth_Base $auth Authentication
	 *
	 * @throws Exception
	 * @return array          array of decoded result
	 */
	public function request( $method, $resource, $args = array(), $auth = null ) {
		$url = ZAKEKE_WEBSERVICE_URL . $resource;

		global $wp_version;

		$request_args = array(
			'method'      => $method,
			'redirection' => 5,
			'httpversion' => '1.1',
			'headers'     => array(
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
				'User-Agent'   => 'woocommerce-zakeke/' . ZAKEKE_VERSION . '; WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
			),
		);

		if ( ! is_null( $auth ) ) {
			$request_args = $auth->set_authentication( $request_args );
		}

		// attach arguments (in body or URL)
        if ( ! empty( $args ) ) {
            if ($method === 'GET') {
                $url = $url . '?' . http_build_query($args);
            } else {
                $request_args['body'] = json_encode($args);
            }
        }

		$raw_response = wp_remote_request( $url, $request_args );

		$this->maybe_log( $url, $method, $args, $raw_response );

		if ( is_wp_error( $raw_response )
		     || ( is_array( $raw_response )
		          && $raw_response['response']['code']
		          && floor( $raw_response['response']['code'] ) / 100 >= 4 )
		) {
			throw new Exception( 'Zakeke_Webservice::request ' . $resource . ' ' . print_r( $raw_response, true ) );
		}

		$json   = wp_remote_retrieve_body( $raw_response );
		$result = json_decode( $json, true );

		return $result;
	}

    /**
     * Check Zakeke authentication credentials.
     *
     * @param string $username Zakeke username
     * @param string $password Zakeke password
     *
     * @throws Exception
     * @return bool
     */
    public function are_valid_credentials( $username, $password ) {
        try {
            $this->request('GET', '/api/Login', array(
                'user' => $username,
                'pwd'  => $password
            ));

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }

	/**
	 * Associate the guest with a customer
	 *
	 * @param string $guest_code - Guest identifier.
	 * @param string $customer_id - Customer identifier.
	 *
	 * @throws Exception
	 * @return void
	 */
	public function associate_guest( $guest_code, $customer_id ) {
	    $auth = zakeke_get_auth();
	    $auth->set_guest( $guest_code );
	    $auth->set_customer( $customer_id );

	    $auth->get_auth_token();
	}

	/**
	 * Get the needed data for adding a product to the cart
	 *
	 * @param string $designId Zakeke design identifier.
	 * @param int $qty Quantity.
	 *
	 * @throws Exception
	 * @return object
	 */
	public function cart_info( $designId, $qty ) {
	    $auth = zakeke_get_auth();
		$data = array(
		    'qty' => $qty
        );

		$resource = '/api/designdocs/' . $designId . '/cartinfo';

		$json = self::request( 'GET', $resource, $data, $auth );

		$res = new stdClass();

		$res->pricing = $json['pricing'];

		$preview        = new stdClass();
		$preview->url   = $json['tempPreviewUrl'];
		$preview->label = '';

		$res->previews = array($preview);

		return $res;
	}

	/**
	 * Order containing Zakeke customized products placed.
	 *
	 * @param array $data The data of the order.
	 *
	 * @throws Exception
	 * @return void
	 */
	public function place_order( $data ) {
		$auth = zakeke_get_auth();
		if ( isset( $data['customerID'] ) ) {
			$auth->set_customer( $data['customerID'] );
		} elseif ( isset( $data['visitorID'] ) ) {
			$auth->set_guest( $data['visitorID'] );
		}

		$data['marketplaceID'] = '1';

		self::request( 'POST', '/api/orderdocs', $data, $auth );
	}

	/**
	 * Get the Zakeke design preview files
	 *
	 * @param string $designId Zakeke design identifier.
	 *
	 * @throws Exception
	 * @return array
	 */
	public function get_previews( $designId ) {
		$auth = zakeke_get_auth();

		$data = array(
			'docid' => $designId
		);

		$json = self::request(
			'GET',
			'/api/designs/0/previewfiles',
			$data,
			$auth
		);

		$previews = array();
		foreach ( $json as $preview ) {
			if ( $preview['format'] == 'SVG' ) {
				continue;
			}

			$previewObj        = new stdClass();
			$previewObj->url   = $preview['url'];
			$previewObj->label = $preview['sideName'];
			$previews[]        = $previewObj;
		}

		return $previews;
	}

	/**
	 * Get the Zakeke design output zip
	 *
	 * @param string $designId Zakeke design identifier.
	 *
	 * @throws Exception
	 * @return string
	 */
	public function get_zakeke_output_zip( $designId ) {
		$auth = zakeke_get_auth();

		$data = array(
			'docid' => $designId
		);
		$json = self::request( 'GET', '/api/designs/0/outputfiles/zip', $data, $auth );

		return $json['url'];
	}

	/**
	 * Conditionally log Zakeke Webservice Call
	 *
	 * @param  string $url Zakeke url.
	 * @param  string $method HTTP Method.
	 * @param  array $args HTTP Request Body.
	 * @param  array $response WP HTTP Response.
	 *
	 * @return void
	 */
	private function maybe_log( $url, $method, $args, $response ) {
		if ( ! $this->debug ) {
			return;
		}

		$this->logger->add( 'zakeke', "Zakeke Webservice Call URL: $url \n METHOD: $method \n BODY: " . print_r( $args,
				true ) . ' \n RESPONSE: ' . print_r( $response, true ) );
	}
}