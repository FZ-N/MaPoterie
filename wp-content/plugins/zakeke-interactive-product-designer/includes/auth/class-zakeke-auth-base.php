<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Zakeke_Auth_Base Class.
 */
abstract class Zakeke_Auth_Base {

    /**
     * Logged customer
     *
     * @var string
     */
    private $customer = null;

    /**
     * Guest identifier code
     *
     * @var string
     */
    private $guest = null;

    /**
     * Zakeke integration settings.
     *
     * @var Zakeke_Integration
     */
    protected $integration;

    /**
     * Zakeke webservice.
     *
     * @var Zakeke_Webservice
     */
    protected $webservice;

    /**
     * Logger instance.
     *
     * @var WC_Logger
     */
    protected $logger;

    /**
     * Setup class.
     *
     * @param Zakeke_Integration $integration
     */
    public function __construct( $integration ) {
        $this->integration = $integration;
        $this->webservice  = new Zakeke_Webservice();
        $this->logger      = new WC_Logger();
    }

    /**
     * Zakeke authentication token.
     *
     * @throws Exception
     * @return string
     */
    abstract public function get_auth_token();

    /**
     * Zakeke authentication token.
     *
     * @param array $request_args
     *
     * @throws Exception
     * @return array
     */
    abstract public function set_authentication( $request_args );

    /**
     * Zakeke authentication token for the customizer.
     *
     * @param array $data
     * @param string $token
     *
     * @return array
     */
    abstract public function set_customizer_token( $data, $token );

    /**
     * Set the logged customer
     *
     * @param string $data
     */
    public function set_customer( $data ) {
        $this->customer = $data;
    }

    /**
     * Get the logged customer
     *
     * @return string
     */
    public function get_customer() {
        return $this->customer;
    }

    /**
     * Set the guest identifier code
     *
     * @param string $data
     */
    public function set_guest( $data ) {
        $this->guest = $data;
    }

    /**
     * Get the guest identifier code
     *
     * @return string
     */
    public function get_guest() {
        return $this->guest;
    }
}
