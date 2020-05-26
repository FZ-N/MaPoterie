<?php
/*shortcode generated using these codes*/

// Handle cart in header fragment for ajax add to cart
add_filter('add_to_cart_fragments', 'header_add_to_cart_fragment');
function header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
 
    ob_start();
 
    woocommerce_cart_link();
 
    $fragments['a.cart-button'] = ob_get_clean();
 
    return $fragments;
 
}

function woocommerce_cart_link() {
    global $woocommerce;
    ?>
    <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php _e('in your shopping cart', 'woothemes'); ?>" class="cart-button ">
    <span class="label"><?php _e('My Basket:', 'woothemes'); ?></span>
    <?php echo $woocommerce->cart->get_cart_total();  ?>
    <span class="items"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?></span>
    </a>
    <?php
}


    function woo_qotv($atts){

    extract(shortcode_atts(array(
        'products_per_page'   => -1,
        'category'      => '',
        'orderby'       => 'meta_value_num',
        'meta_key'      => '_price',
        'order'         => 'asc',
        'header_color'   => '#ccc',
        'table_color'   => '#efefef'
    ), $atts));  

    wc_print_notices();



    $header_color = get_option('header-color');
    $header_font_color = get_option('header-font-color');
    $cell_font_color = get_option('cell-font-color');
    $header_font_size = get_option('header-font-size');
    $cell_font_size = get_option('cell-font-size');
    $cart_bg_color = get_option('cart-bg-color');
    $cart_icon_color = get_option('cart-icon-color');

    $return_string ='
        <table id="example" class="display quick-order" cellspacing="0" width="100%">
        
        <thead style="background:'.$header_color.';color:'.$header_font_color.';font-size:'.$header_font_size.';">
        <tr class="top_part">';
        $return_string .='<th style="width:10%">Image</th>
        <th style="width:50%">Product Name</th>
        <th style="width:20%">Price</th>
        <th style="width:20%">Quantity</th>

        </tr>
        </thead>
        ';
    
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    
    $args = array( 
        'post_type' => 'product',
        'post_status' => 'publish',
        'product_cat'=>$category,
        'posts_per_page' =>$products_per_page,
        'paged' => $paged,
        'page' => $paged,
        'orderby'   => 'meta_value_num',
        'meta_key'  => '_price',
        'order' => $order); 
         $loop = new WP_Query( $args );
         $return_string .='<tbody style="color:'.$cell_font_color.';font-size:'.$cell_font_size.';">';
         $i=1;
         while ( $loop->have_posts() ) : $loop->the_post();global $product; 
         if ( $product->is_in_stock() ) : 

         $return_string .='<tr>';
         $return_string .='<td><a class="btn btn-default product" href="#" data-featherlight="#product_details_'.$loop->post->ID.'">
         <div class="normal_thumnail">';
         if (!empty(get_the_post_thumbnail_url($loop->post->ID))) {
         $return_string .='<img src="'.get_the_post_thumbnail_url( $loop->post->ID).'">';
            }else{
         $return_string .='<img src="'. home_url().'/wp-content/plugins/woo-quick-order-table-view/assets/images/thumnail.png">';       
            }

        $return_string .='</div></a></td>';
        $return_string .='<td class="qotv-title">'.get_the_title().'</td>';
        $return_string .='<td>'.wc_price($product->get_price()).'</td>';

            if ( $product->is_type( 'simple' ) ) {
                $return_string .='<td>
                                <div class="quantity">
                                    <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Quantity" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric">
                                </div>
                                <input type="hidden" name="add-to-cart" value="'.get_the_ID().'">
                                <input type="hidden" name="product_id" value="'.get_the_ID().'">
                                
                                    <button style="background:'.$cart_bg_color.';" class="single_add_to_cart_button button alt" ><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
                                     <a href="'.wc_get_checkout_url().'" class="checkout-button button alt wc-forward">Checkout<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
</a> 
                               </td>';
            }
        ?>

        <?php 
            if ( $product->is_type( 'variable' ) ) {
                $return_string .= '<td class="">' . woo_qotv_variable_cart() . '</td>';
            }
        ?>

        
        <?php 

         $return_string .='<div class="lightbox" id="product_details_'.$loop->post->ID.'">';
         $return_string .='<div class="light_image">';

         if (!empty(get_the_post_thumbnail_url($loop->post->ID))) {
         $return_string .='<img src="'.get_the_post_thumbnail_url( $loop->post->ID).'">';
            }else{
         $return_string .='<img src="'. home_url().'/wp-content/plugins/woo-quick-order-table-view/assets/images/thumnail.png" style="margin-top:45px;">';
            }
        $return_string .='</div>';
        $return_string .='<div class="light_details">';
        $return_string .='<h2>'.get_the_title().'</h2>';
        $return_string .='<div class="description">'.get_the_content().'</div>';
        $return_string .='<p>SKU:'.($sku = $product->get_sku() ).'</p>';
        $return_string .='<p>Price:'.wc_price($product->get_price()).'</p>';
        $return_string .= '<p>Categories:'.wc_get_product_category_list($loop->post->ID, ',').'</p>';
        $return_string .='</div>';
        $return_string .='</div>';
        $return_string .='</tr>';

        endif;
        $i++;
        endwhile;
        $return_string .='</tbody>';
        $return_string .='</table>';
        return $return_string;
        }

        add_shortcode('woo_qotv_code','woo_qotv');

        ?>