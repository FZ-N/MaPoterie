<?php
/*
Plugin Name:Woo Quick Order Table View
Description:Woocommerce Products shows on responsive table with ajax add to cart,view checkout page button,ordering,pagination,lightbox,add to cart,price.For more advance options please buy <a class="pro" target="_blank" href="http://amp-templates.com/quick-order-demo/">Pro</a>
Version: 2.2
Author: Abu Rayhan
Author URI: http://amp-templates.com/quick-order-demo/
*/

add_action('wp_enqueue_scripts', 'woo_qotv_register_scripts');
add_action('wp_enqueue_scripts', 'woo_qotv_register_styles');


function woo_qotv_register_scripts() {
    if (!is_admin()) {
        // register
    wp_enqueue_script('smgt-defaultscript_ui', plugins_url( '/assets/js/jquery-ui.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script('smgt-font', 'https://use.fontawesome.com/2653d7c166.js', array( 'jquery' ), '1.0', true );

    wp_register_script('woo_qotv_script', plugins_url('/assets/js/featherlight.min.js', __FILE__),array('jquery'),'1.0', false);
   
    wp_enqueue_script('smgt-datatable', plugins_url( '/assets/js/jquery.dataTables.min.js',__FILE__ ), array( 'jquery' ), '1.0', true);

    wp_enqueue_script('smgt-datatable-tools', plugins_url( '/assets/js/dataTables.tableTools.min.js',__FILE__ ), array( 'jquery' ), '1.0', true);

    wp_enqueue_script('smgt-datatable-editor', plugins_url( '/assets/js/dataTables.editor.min.js',__FILE__ ), array( 'jquery' ), '1.0', true);

    wp_enqueue_script('smgt-datatable-responsive-js', plugins_url( '/assets/js/dataTables.responsive.js',__FILE__ ), array( 'jquery' ), '1.0', true);
    wp_enqueue_script('smgt-customjs', plugins_url( '/assets/js/custom.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_localize_script( 'smgt-customjs', 'postlove', array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ));
    $i18n = array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'checkout_url' => get_permalink( wc_get_page_id( 'checkout' ) ) );
    wp_localize_script( 'smgt-customjs', 'SO_TEST_AJAX', $i18n );
        // enqueue
    wp_enqueue_script('woo_qotv_script');
    }
}
 
function woo_qotv_register_styles() {
    // register
    wp_register_style('woo_qotv_style', plugins_url('css/featherlight.min.css', __FILE__));
    wp_register_style('woo_qotv_style_main', plugins_url('css/style.css', __FILE__));
    wp_enqueue_style( 'smgt-datatable', plugins_url( '/assets/css/dataTables.css', __FILE__) );
    wp_enqueue_style( 'smgt-datable-responsive', plugins_url( '/assets/css/dataTables.responsive.css', __FILE__) );
    // enqueue
    wp_enqueue_style('woo_qotv_style');
    wp_enqueue_style('woo_qotv_style_main');
}

add_action('wp_ajax_cartajax', 'cartajax_callback');
add_action('wp_ajax_nopriv_cartajax', 'cartajax_callback');

    /**
     * AJAX add to cart.
     */
function cartajax_callback() {        
        ob_start();
    // Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
     remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );


    $data_ids = stripslashes($_POST['data_ids']);
    $data_id_array = json_decode($data_ids); // Set second argument as TRUE

    $count       = count( $data_id_array );
    $number      = 0;
    if(!empty($data_id_array)) {

        foreach($data_id_array as $data_id_array) {
            $product_id        = $data_id_array->checkbox_id;

            if ( ++$number === $count ) {
             $_REQUEST['add-to-cart'] = $product_id;
        }

        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
        $was_added_to_cart = false;
        $adding_to_cart    = wc_get_product( $product_id );

        if ( ! $adding_to_cart ) {
            continue;
        }

        $add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->product_type, $adding_to_cart );

       
        if ( 'simple' !== $add_to_cart_handler ) {
            continue;
        }

        // For now, quantity applies to all products.. This could be changed easily enough, but I didn't need this feature.
        $quantity          = empty( $data_id_array->quantity ) ? 1 : wc_stock_amount( $data_id_array->quantity );
        $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

        if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity ) ) {
            //wc_add_to_cart_message( array( $product_id => $quantity ), true );
        } 
            
        }
    }
    else {

        // If there was an error adding to the cart, redirect to the product page to show any errors
        $data = array(
            'error'       => true,
            'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
        );

        wp_send_json( $data );

    }
    die();

}

require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcode.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );

?>