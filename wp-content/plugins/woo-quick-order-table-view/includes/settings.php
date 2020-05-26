<?php

add_action('admin_head', 'woo_qotv_backend_styles');

function woo_qotv_backend_styles() {
    // register
    wp_enqueue_style( 'back-css', plugins_url( '../css/back.css', __FILE__) );
}


function woqtb_register_settings() {
   add_option( 'woqtb_option_name', 'This is my option value.');
   register_setting( 'woqtb_options_group', 'woqtb_option_name', 'woqtb_callback' );
}
add_action( 'admin_init', 'woqtb_register_settings' );



function woqtb_register_options_page() {
    $page_title = 'Quick Order Table View Settings';
    $menu_title = 'Quick Order Table View Settings';
    $capability = 'edit_posts';
    $menu_slug = 'quick-order-settings';
    $function = 'woqtb_options_page';
    $icon_url = '';
    $position = '';

    add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
add_action('admin_menu', 'woqtb_register_options_page');

add_action( 'admin_init', function() {
    register_setting( 'woqtb_options_group', 'header-color' );
    register_setting( 'woqtb_options_group', 'header-font-color' );
    register_setting( 'woqtb_options_group', 'cell-font-color' );
    register_setting( 'woqtb_options_group', 'header-font-size' );
    register_setting( 'woqtb_options_group', 'cell-font-size' );
    register_setting( 'woqtb_options_group', 'cart-bg-color' );
    register_setting( 'woqtb_options_group', 'cart-icon-color' );
});

function woqtb_options_page()
{
?>
<div class="pro">
  <h3><a href="http://amp-templates.com">PRO VERSION</a></h3>
  <img src="<?php echo plugins_url(); ?>/woo-quick-order-table-view/assets/images/pro-banner.png" class="img-banner">
  <p>This plugin pro version live now.Pro version has some great features.please check <a href="http://amp-temlates.com/quick-order-demo/" target="_blank">Demo for Pro</a>.</p>
  <ul>
    <li>Multi Product add to cart.User can add multiple products at a time in there shopping cart</li>
    <li>Category Filtring</li>
    <li>Ajax add to cart</li>
    <li>Ajax searching</li>
    <li>Multi Lanugaue</li>
    <li>Chose fields from admin section</li>
    <li><a href="mailto:shojibvai@gmail.com">Contact for pro</a></li>
    <li><a href="http://amp-temlates.com/quick-order-demo/" target="_blank">Demo for Pro</a></li>
  </ul>  
</div>

  <h2>Quick Order Table View Settings</h2>
  
  <div class="setting-area">
  <form method="post" class="setting-form" action="options.php">
  <?php settings_fields( 'woqtb_options_group' ); ?>
  <?php do_settings_sections( 'woqtb_options_group' ); ?>
  <div class="full_area">
  <div class="label_area">
  <label for="myplugin_option_name">Header Background</label>
  </div>
  <div class="input_area">
  <div class="col-1 custom">
    <input type="color" class="custom-color" name="header-color" id="header-color" value="<?php echo esc_attr(get_option('header-color')); ?>">
  </div>
  </div>
  </div>

<div class="full_area">
  <div class="label_area">
  <label>Header Font Color</label>
  </div>
  <div class="input_area">
    <input type="text" name="header-font-color" id="header-font-color" value="<?php echo esc_attr(get_option('header-font-color')); ?>">
  </div>
</div>

<div class="full_area">
  <div class="label_area">
  <label>Cell Font Color</label>
  </div>
  <div class="input_area">
    <input type="text" name="cell-font-color" id="cell-font-color" value="<?php echo esc_attr(get_option('cell-font-color')); ?>">
  </div>
</div>

<div class="full_area">
  <div class="label_area">
  <label>Header Font Size</label>
  </div>
  <div class="input_area">
    <input type="text" name="header-font-size" id="header-font-size" value="<?php echo esc_attr(get_option('header-font-size')); ?>">
  </div>
</div>

<div class="full_area">
  <div class="label_area">
  <label>Cell Font Size</label>
  </div>
  <div class="input_area">
    <input type="text" name="cell-font-size" id="cell-font-size" value="<?php echo  esc_attr(get_option('cell-font-size')); ?>">
  </div>
</div>

<div class="full_area">
  <div class="label_area">
  <label>Cart Background Color</label>
  </div>
  <div class="input_area">
    <input type="text" name="cart-bg-color" id="cart-bg-color" value="<?php echo esc_attr(get_option('cart-bg-color')); ?>">
  </div>
</div>

<div class="full_area">
  <div class="label_area">
  <label>Cart Icon Color</label>
  </div>
  <div class="input_area">
    <input type="text" name="cart-icon-color" id="cart-icon-color" value="<?php echo esc_attr(get_option('cart-icon-color')); ?>">
  </div>
</div>

<div class="full_area">
  <?php  submit_button(); ?>
</div>  
  </form>
  </div>
<?php
} ?>