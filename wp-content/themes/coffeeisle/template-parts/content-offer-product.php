<?php
/**
 * The template used for displaying Special Offer Product on Alt Shop Page
 *
 * @package Coffeesile
 * @since 1.0.0
 */
?>

<?php
	global $product;
	$current_product_url = get_permalink( $product->get_id() );
?>

<div class="special-offer-wrapper">
<div class="svg-container svg-block alt-shop-special-offer-top-svg">
	<?php oblique_svg_3(); ?>
</div>
<div class="offer-product-wrapper">
	<a href="<?php echo esc_url( $current_product_url ); ?>">
	<?php the_post_thumbnail( 'coffeeisle_special_offer_thumbnail_size' ); ?>
	</a>
	<div class="offer-product-inner">
		<a href="<?php echo esc_attr( $current_product_url ); ?>">
		<h2 class="offer-product-special-offer"><?php echo esc_html__( 'Special Offer', 'coffeeisle' ); ?></h2>
		<h3 class="offer-product-title"><?php the_title(); ?></h3>
		<?php
			$coffeeisle_offer_product_price = $product->get_price_html();
		?>
		<div class="offer-product-price">
		<?php
		if ( ! empty( $coffeeisle_offer_product_price ) ) {
			echo wp_kses_post( $coffeeisle_offer_product_price ); }
?>
</div>
		</a>
		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>
</div>
<div class="svg-container svg-block alt-shop-special-offer-bottom-svg">
	<?php oblique_svg_1(); ?>
</div>
</div>
