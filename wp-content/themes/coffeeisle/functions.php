<?php
/**
 * Coffeeisle functions and definitions
 *
 * Set up the theme and provides some helper functions.
 *
 * @package coffeeisle
 * @since Coffeeisle 1.0.0
 */

/**
 * Check if parent theme is free or pro version
 *
 * @since 1.0.0
 */
function coffeeisle_compatibility_with_pro_features() {
	$theme = wp_get_theme();
	if ( is_child_theme() ) {
		$parent_theme = $theme->parent()->get( 'Name' );
		if ( $parent_theme == 'Oblique Pro' ) {
			return true;
		} elseif ( $parent_theme == 'Oblique' ) {
			return false;
		}
	}
	return false;
}

/**
 * Enqueue stylesheets and scripts
 *
 * @since 1.0.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'coffeeisle_child_parent_css' ) ) :
	function coffeeisle_child_parent_css() {
		wp_enqueue_style( 'coffeeisle_child_parent_css', trailingslashit( get_template_directory_uri() ) . 'style.css' );

		wp_enqueue_script( 'coffeeisle-script', get_stylesheet_directory_uri() . '/js/scripts.js' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'coffeeisle_child_parent_css', 10 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function coffeeisle_customize_preview_js() {
	wp_enqueue_script( 'coffeeisle_customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'coffeeisle_customize_preview_js' );

/**
 * Google Fonts
 *
 * @since 1.0.0
 */
function coffeeisle_include_google_fonts() {
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Lora:400,700', false );
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Athiti:300,400,600', false );
}
add_action( 'wp_enqueue_scripts', 'coffeeisle_include_google_fonts' );

/**
 * Remove functions from the parent theme
 * That are replaced with child theme function
 *
 * @since 1.0.0
 */
function coffeeisle_remove_actions() {

	// Post read more
	remove_action( 'oblique_link_to_single', 'oblique_post_link_to_single' );

	// Header svg
	remove_action( 'oblique_nav_container', 'oblique_nav_svg_container' );

	// Blog post bottom svg
	remove_action( 'oblique_post_bottom_svg','oblique_svg_1' );

	// Footer credits
	if ( ! coffeeisle_compatibility_with_pro_features() ) {
		remove_action( 'oblique_footer', 'oblique_footer_credits' );
	}

	// Index posts navigation
	remove_action( 'oblique_posts_navigation', 'oblique_posts_navigation' );

	// Archive title bottom svg
	remove_action( 'oblique_archive_title_bottom_svg', 'oblique_archive_title_bottom_svg' );

	// Content single post bottom svg
	remove_action( 'oblique_single_post_bottom_svg', 'oblique_single_post_bottom_svg' );

	// Single page post bottom svg
	remove_action( 'oblique_single_page_post_svg', 'oblique_single_page_post_svg' );

	// Comments title
	remove_action( 'oblique_comments_title', 'oblique_comments_title_text' );

	// Comments list
	remove_action( 'oblique_comments_list', 'oblique_comments_list' );

}
add_action( 'after_setup_theme', 'coffeeisle_remove_actions' );

/**
 * Dynamic styles
 *
 * @since 1.0.0
 */
function coffeeisle_custom_styles( $custom ) {

	$custom = '';

	$background_color = get_background_color();
	if ( ! empty( $background_color ) ) {

		$custom .= 'div.svg-block{ fill: #' . esc_attr( $background_color ) . ';}';

		$custom .= '.search div.search-title-top-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";
		$custom .= '.search div.search-title-bottom-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap table td { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_bottom_svg { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= 'div.alt-shop-special-offer-top-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";
		$custom .= 'div.alt-shop-special-offer-bottom-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";

	}

	// Primary color
	$primary_color = esc_html( get_theme_mod( 'primary_color', '#925D34' ) );
	if ( ! empty( $primary_color ) ) {
		$custom .= 'div.entry-meta a:hover, h2.entry-title a:hover, div.widget-area a:hover, nav.social-navigation li a:hover, a.entry-content-link:hover { color:' . esc_attr( $primary_color ) . ';}' . "\n";
		$rgba   = oblique_hex2rgba( $primary_color, 0.3 );
        $darken_color = esc_html( coffeeisle_darken_color( $primary_color, 10 ) );

		$custom .= '.home article.post div.post-inner a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page .contact-details-list a:hover { color:' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.archive .post-inner a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page div.comments-area ol.comment-list li.comment div.reply a.comment-reply-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";

		$current_selector = '.comment-form .form-submit input[type="submit"]:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.single a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single .comment-body .reply a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single .comment-body .comment-author a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-post nav.post-navigation div.nav-previous:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.single-post nav.post-navigation div.nav-next:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-submit:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit:hover { border: 1px solid ' . esc_attr( $darken_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit:hover { border: 1px solid ' . esc_attr( $darken_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_categories ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_archive ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_archive ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_pages ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_meta ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_nav_menu ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_recent_entries ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$current_selector = '.single-sidebar .widget select:hover';
		$custom .= coffeeisle_sidebar_dropdown( $current_selector, $primary_color );
		$current_selector = '.header-widgets .widget select:hover';
		$custom .= coffeeisle_sidebar_dropdown( $current_selector, $primary_color );

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$current_selector = '.woocommerce-page ul.products li.product a.button:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce button.button.alt:hover, .single-product .single_add_to_cart_button:hover { background: ' . esc_attr( $primary_color ) . ' !important;}' . "\n";

		$current_selector = '.woocommerce #review_form #respond .form-submit input[type="submit"]:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-page div.woocommerce-message a.button:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-page form.woocommerce-form-login input[type="submit"]:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce-cart p.return-to-shop a.button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$current_selector = '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"]:hover';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce-page ul.products li.product a.added_to_cart:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocomerce-form p.lost_password a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-message a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-info a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocommerce-cart-form a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page div.alt-shop-blog-large article.hentry a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.page div.alt-shop-blog-small article.hentry a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.added_to_cart:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

	}// End if().

	// Secondary Color
	$secondary_color = get_theme_mod( 'secondary_color', '#333333' );
	if ( ! empty( $secondary_color ) ) {

		$custom .= '.woocommerce-page ul.products li.product .price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

		$custom .= '.woocommerce div.product p.price, .woocommerce div.product span.price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.single-product form.cart p.quantity-title { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.single-product form.cart div.quantity { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product form.cart table.variations td.label { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--description h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--reviews h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product form.cart table.variations { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cross-sells>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce-cart div.cart_totals>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-checkout div.woocommerce-billing-fields>h3 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce-checkout div.woocommerce-additional-fields>h3 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= '.woocommerce-checkout form.woocommerce-checkout h3#order_review_heading { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-account div.woocommerce>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner h3.offer-product-price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
		$custom .= 'div.offer-product-wrapper div.offer-product-inner div.offer-product-price del { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

	}

	// Entry Titles Color
	$entry_titles = esc_html( get_theme_mod( 'entry_titles', '#d1b586' ) );
	if ( ! empty( $entry_titles ) ) {
		$rgba   = oblique_hex2rgba( $entry_titles, 0.3 );
		$darken_color = esc_html( coffeeisle_darken_color( $entry_titles, 10 ) );

		$custom .= '.home article.post div.post-inner a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.archive .post-inner a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";

		$custom .= '.pirate-forms-submit-button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page div.entry-content li:first-of-type { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.page .contact-details-list a { color:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page div.comments-area ol.comment-list li.comment div.reply a.comment-reply-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single_post_bottom_svg { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.comment-respond h3 { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'h2.entry-title, h2.entry-title a, .entry-content a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'line.post-bottom-svg-line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= 'div.nav-links .current { background-color:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.comment-form .form-submit input[type="submit"]';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.single_page_post_svg { stroke:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single h2.comments-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page-header .page-title { color: ' . esc_attr( $entry_titles ) . ' !important;}' . "\n";

		$custom .= '.single .comment-body .comment-author { color:' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single .comment-body .comment-author a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single .comment-body .reply a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single .comment-list>.comment:nth-of-type(even) { border-left: 2px solid ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .widget-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table caption { background: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .widget-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap table caption { background: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.header-widgets .widget_calendar .calendar_wrap td#prev { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap td#prev { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap td#next { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap td#next { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-submit { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit { border: 1px solid ' . esc_attr( $darken_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-submit { border: 1px solid ' . esc_attr( $darken_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_categories ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_categories ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a:hover { color: #ffffff; background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_tag_cloud .tagcloud a:hover { color: #ffffff; background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_archive ul li:before, .single-sidebar .widget_archive ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_archive ul li:before, .single-sidebar .widget_archive ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_pages ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_meta ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_nav_menu ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_recent_entries ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_rss ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_rss ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_comments ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_recent_comments ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.header-widgets .widget_calendar .calendar_wrap table td#today { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td#today { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.single-sidebar .widget select';
		$custom .= coffeeisle_sidebar_dropdown( $current_selector, $entry_titles );
		$current_selector = '.header-widgets .widget select';
		$custom .= coffeeisle_sidebar_dropdown( $current_selector, $entry_titles );

		$custom .= '.page h2.comments-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page .comment-body .comment-author .fn { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.archive_title_svg { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product h2.woocommerce-loop-product__title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.woocommerce-page ul.products li.product a.button';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.single-product h1.product_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.single-product .single_add_to_cart_button, .woocommerce button.button.alt';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__author { color: ' .
				   esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce .star-rating span { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.woocommerce #review_form #respond .form-submit input[type="submit"]';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce #reviews #respond #reply-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_bottom_svg .single_product_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-product h2.related_products_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-page h2.alt_shop_cat_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-product div.related-title-bottom-svg .related_title_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.alt_shop_cat_title_bottom_svg .alt_shop_cat_title_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled:hover { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$current_selector = '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce-page div.woocommerce-message { border-top-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.woocommerce-message:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.woocommerce-page div.woocommerce-message a.button';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$current_selector = '.woocommerce-page form.woocommerce-form-login input[type="submit"]';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce form .form-row .required { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-cart p.return-to-shop a.button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-info { border-top-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.woocommerce-info:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info { border-top-color: ' .
				   esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info:before { color: ' .
				   esc_attr( $entry_titles ) . ';}' . "\n";
		$current_selector = '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"]';
		$custom .= coffeeisle_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce-page ul.products li.product a.added_to_cart { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocomerce-form p.lost_password a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-message a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-info a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocommerce-cart-form a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-cart header.entry-header h1.entry-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-checkout header.entry-header h1.entry-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-account header.entry-header h1.entry-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'h2.alt-shop-blog-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page div.alt-shop-blog-large article.hentry a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.page div.alt-shop-blog-small article.hentry a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner h2.offer-product-special-offer { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner div.offer-product-price ins { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button { background-color:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.added_to_cart { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-error { border-top-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.woocommerce-error::before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.sticky .post-bottom-svg { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

	}// End if().

	// Body text color
	$body_text_color = get_theme_mod( 'body_text_color', '#8c8c8c' );
	if ( ! empty( $body_text_color ) ) {

		$custom .= 'body { color: ' . esc_attr( $body_text_color ) . ' !important;}' . "\n";

		$custom .= 'form.comment-form p label { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= 'nav.posts-navigation div.nav-links .page-numbers { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single .comment-body .comment-metadata a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-post nav.post-navigation div.nav-previous { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.single-post nav.post-navigation div.nav-next { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget select { color: ' . esc_attr( $body_text_color ) . ' !important;}' . "\n";
		$custom .= '.header-widgets .widget select { color: ' . esc_attr( $body_text_color ) . ' !important;}' . "\n";

		$custom .= '.header-widgets, .header-widgets a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_categories ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_tag_cloud .tagcloud a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_archive ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_archive ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_pages ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_meta ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_nav_menu ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_recent_entries ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-form label input.search-field::placeholder { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.header-widgets .widget .search-form label input.search-field::placeholder { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page nav.navigation .page-numbers { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.woocommerce div.product .woocommerce-tabs { border: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li { border: none; border-right: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs .woocommerce-Tabs-panel { border-top: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";

	}// End if().

	// Footer color
	$footer_background_color = get_theme_mod( 'footer_background', '#ffffff' );
	if ( ! empty( $footer_background_color ) ) {
		$custom .= 'footer.site-footer { background-color:' . esc_attr( $footer_background_color ) . ';}' . "\n";
		$custom .= 'div.footer-svg.svg-block { fill:' . esc_attr( $footer_background_color ) . ';}' . "\n";
	}

	// Header padding
	$branding_padding = get_theme_mod( 'branding_padding', '300' );
	if ( ! empty( $branding_padding ) ) {
		$custom .= 'div.site-branding { padding:' . intval( $branding_padding ) . 'px 0; }' . "\n";
	}

	// Entry background
	$entry_background = get_theme_mod( 'entry_background', '#ffffff' );
	if ( ! empty( $entry_background ) ) {
		$custom .= 'div.post-inner { background-color:' . esc_attr( $entry_background ) . ';}' . "\n";

		// Single Sidebar Page
		$custom .= '.single .hentry { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single .single-post-svg { fill: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.single .comment-body { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single .reply a { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single .comment-form input, .single .comment-form textarea { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-post nav.post-navigation div.nav-previous { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-post nav.post-navigation div.nav-next { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-post nav.post-navigation div.nav-previous:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-post nav.post-navigation div.nav-next:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap table { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table caption { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap table caption { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.header-widgets .widget_calendar .calendar_wrap table td#today { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td#today { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.header-widgets .widget_calendar .calendar_wrap table tfoot td.pad { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table tfoot td.pad { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap table td.pad { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td.pad { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.header-widgets .widget_calendar .calendar_wrap td#prev a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap td#prev a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_calendar .calendar_wrap td#next a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap td#next a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a { background-color:  ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_tag_cloud .tagcloud a { background-color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a:hover { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.header-widgets .widget_tag_cloud .tagcloud a:hover { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'nav.posts-navigation div.nav-links .current { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .hentry {background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .single-post-svg {fill: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.page .comments-area .comment-body { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-body .reply a { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-form input { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.comment-form .form-submit input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-form textarea { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.archive .page-header { background-color:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.archive div.svg-container.svg-block.page-header-svg { fill:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.search div.search-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.search header.page-header { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.search div.search-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.button { color: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.woocommerce ul.products li.product,' . ' .woocommerce-page ul.products li.product ' .
				   '{ background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.product .post-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-product form.cart p.single-product-add-cart-icon { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page ul.products li.product a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product .single_add_to_cart_button { color: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product p.shop_page_add_cart_icon { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page nav.navigation .current { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce #reviews #comments ol.commentlist li { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce #review_form #respond .form-submit input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.product .post-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_top_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_wrapper { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_bottom_svg { fill:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.related-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.alt_shop_cat_title_top_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product h2.related_products_title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page h2.alt_shop_cat_title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.related-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.alt_shop_cat_title_bottom_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cross-sells ul.products li.product div.post-svg { fill: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cross-sells ul.products li.product div.post-bottom-svg { fill: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active { border-bottom: 1px solid ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-message a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocommerce-form-login input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart p.return-to-shop a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"] { color: ' .
				   esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'div.alt-shop-blog-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'h2.alt-shop-blog-title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'div.alt-shop-blog-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.need-woocommerce { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

	}// End if().

	// Menu icon/leave color
	$menu_icon_color = get_theme_mod( 'menu_icon_color', '#f8f9fb' );
	if ( ! empty( $menu_icon_color ) ) {
		$custom .= 'div.sidebar-toggle { color:' . esc_attr( $menu_icon_color ) . ';}' . "\n";
	}

	// Site title
	$site_title_color = get_theme_mod( 'site_title_color', '#f9f9f9' );
	if ( ! empty( $site_title_color ) ) {
		$custom .= 'h1.site-title a, h1.site-title a:hover {color:' . esc_attr( $site_title_color ) . ';}' . "\n" ;
	}

	// Site description
	$site_desc_color = get_theme_mod( 'site_desc_color', '#f9f9f9' );
	if ( ! empty( $site_desc_color ) ) {
		$custom .= 'h2.site-description { color:' . esc_attr( $site_desc_color ) . ';}' . "\n";
	}

	// Social color
	$social_color = get_theme_mod( 'social_color', '#f9f9f9' );
	if ( ! empty( $social_color ) ) {
		$custom .= 'nav.social-navigation li a { color:' . esc_attr( $social_color ) . ';}' . "\n";
		$custom .= '.header-search .search-field::-webkit-input-placeholder { color: ' . esc_attr( $social_color ) . ';}' . "\n";
		$custom .= '.header-search .search-field.search-field-opened  { border-bottom-color: ' . esc_attr( $social_color ) . ';}' . "\n";
		$custom .= '.nav_search_icon:after { color: ' . esc_attr( $social_color ) . ';}' . "\n";
	}

	// Sidebar background
	$sidebar_background = get_theme_mod( 'sidebar_bg', '#17191B' );
	if ( ! empty( $sidebar_background ) ) {
		$custom .= 'div.widget-area-visible { background: ' . esc_attr( $sidebar_background ) . ';}' . "\n";
	}

	// Sidebar color
	$sidebar_color = get_theme_mod( 'sidebar_color', '#f9f9f9' );
	if ( ! empty( $sidebar_color ) ) {
		$custom .= 'div.widget-area-visible, div.widget-area-visible a { color: ' . esc_attr( $sidebar_color ) . ';}' . "\n";

		$custom .= 'div.widget-area-visible nav.sidebar-nav div.slicknav_menu ul.slicknav_nav li.menu-item { border-bottom: 1px solid ' . esc_attr( $sidebar_color ) . ';}' . '\n';
	}

	// Output all the styles
	wp_add_inline_style( 'oblique-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'coffeeisle_custom_styles', 20 );

/**
 * Customizer
 * Register main controls in customizer
 * Set default values in the customizer
 *
 * @since 1.0.0
 */
function coffeeisle_customize_register( $wp_customize ) {

	// Branding Padding
	$wp_customize->get_setting( 'branding_padding' )->default = '300';
	$wp_customize->get_control( 'branding_padding' )->description = esc_html__( 'Top&amp;bottom padding for the branding. Default: 300px','coffeeisle' );

	// Entry background
	$wp_customize->add_setting(
		'entry_background',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_background',
			array(
				'label'     => esc_html__( 'Entry background', 'coffeeisle' ),
				'section'   => 'colors',
				'priority'  => 15,
			)
		)
	);

	// Secondary Color
	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default'           => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_color',
			array(
				'label'     => esc_html__( 'Secondary color', 'coffeeisle' ),
				'section'   => 'colors',
				'priority'  => 12,
			)
		)
	);

}
add_action( 'customize_register', 'coffeeisle_customize_register', 20 );

/**
 * Color
 * Background default color
 *
 * @since 1.0.0
 */
function coffeeisle_background_filter( $input ) {
	$input['default-color'] = 'f8f9fb';
	return $input;
}
add_filter( 'oblique_custom_background_args', 'coffeeisle_background_filter' );

/**
 * Color
 * Primary default color
 *
 * @since 1.0.0
 */
function coffeeisle_default_primary_color() {
	return '#925D34';
}
add_filter( 'oblique_primary_color', 'coffeeisle_default_primary_color' );

/**
 * Color
 * Body text default color
 *
 * @since 1.0.0
 */
function coffeeisle_body_text_color() {
	return '#8c8c8c';
}
add_filter( 'oblique_body_text_color', 'coffeeisle_body_text_color' );

/**
 * Color
 * Site title default color
 *
 * @since 1.0.0
 */
function coffeeisle_site_title_color() {
	return '#ffffff';
}
add_filter( 'oblique_site_title_color', 'coffeeisle_site_title_color' );

/**
 * Color
 * Site desc color
 *
 * @since 1.0.0
 */
function coffeeisle_site_desc_color() {
	return '#ffffff';
}
add_filter( 'oblique_site_desc_color', 'coffeeisle_site_desc_color' );

/**
 * Color
 * Entry titles color
 *
 * @since 1.0.0
 */
function coffeeisle_entry_titles_color() {
	return '#d1b586';
}
add_filter( 'oblique_entry_titles_color', 'coffeeisle_entry_titles_color' );

/**
 * Color
 * Entry meta color
 *
 * @since 1.0.0
 */
function coffeeisle_entry_meta_color() {
	return '#8c8c8c';
}
add_filter( 'oblique_entry_meta_color', 'coffeeisle_entry_meta_color' );

/**
 * Color
 * Footer background color
 *
 * @since 1.0.0
 */
function coffeeisle_footer_background_color() {
	return '#ffffff';
}
add_filter( 'oblique_footer_background_color', 'coffeeisle_footer_background_color' );

/**
 * Color
 * Menu icon default color
 *
 * @since 1.0.0
 */
function coffeeisle_menu_icon_color() {
	return '#f8f9fb';
}
add_filter( 'oblique_menu_icon_color', 'coffeeisle_menu_icon_color' );

/**
 * Color
 * Social icon default color
 *
 * @since 1.0.0
 */
function coffeeisle_social_color() {
	return '#f8f9fb';
}
add_filter( 'oblique_social_color', 'coffeeisle_social_color' );

/**
 * Color
 * Color darken or lighten
 *
 * @since 1.0.0
 */
function coffeeisle_darken_color( $color, $filter ) {

	$filter = max( -255, min( 255, $filter ) );

	$color = str_replace( '#', '', $color );
	if ( strlen( $color ) == 3 ) {
		$color = str_repeat( substr( $color,0,1 ), 2 ) . str_repeat( substr( $color,1,1 ), 2 ) . str_repeat( substr( $color,2,1 ), 2 );
	}

	$color_rgb = str_split( $color, 2 );
	$darken_color = '#';

	foreach ( $color_rgb as $rgb_pair ) {
		$rgb_pair   = hexdec( $rgb_pair ); // Convert to decimal
		$rgb_pair   = max( 0,min( 255,$rgb_pair + $filter ) ); // Adjust color
		$darken_color .= str_pad( dechex( $rgb_pair ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $darken_color;
}

/**
 * Color
 * Apply gradient on buttons
 *
 * @param $selector - background-color
 * @param $color - -darken/lighten color filter
 *
 * @since 1.0.0
 */
function coffeeisle_gradient_on_button( $selector, $color ) {

	$btn_gradient_style = '';

	$new_color = coffeeisle_darken_color( $color, 1 );

	$btn_gradient_style .= $selector . ' { background: ' . $color . ';' . "\n";
	$btn_gradient_style .= ' background: -moz-linear-gradient(top, ' . $color . ' 0%, ' . $new_color . ' 100%);' . "\n";
	$btn_gradient_style .= ' background: -webkit-linear-gradient(top, ' . $color . ' 0%,' . $new_color . ' 100%);' . "\n";
	$btn_gradient_style .= ' background: linear-gradient(to bottom, ' . $color . ' 0%,' . $new_color . ' 100%);' . "\n";
	$btn_gradient_style .= " filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $color . "', endColorstr='" . $new_color . "',GradientType=0 ); }" . "\n";

	return $btn_gradient_style;
}

/**
 * Color
 * Apply style on Sidebar Dropdowns
 *
 * @since 1.0.0
 */
function coffeeisle_sidebar_dropdown( $selector, $bg_color ) {

	$custom_style = '';

	$custom_style .= $selector . ' { background: linear-gradient(45deg, transparent 50%, #fff 50%), linear-gradient(134deg, #fff 50%, transparent 50%), linear-gradient(to right, ' . $bg_color . ', ' . $bg_color . ');';

	$custom_style .= "\n";
	$custom_style .= 'background-position: calc(100% - 36px) calc(1em + -2px), calc(100% - 25px) calc(1em + -2px), 100% 0;' . "\n";

	$custom_style .= 'background-size: 11px 20px, 11px 20px, 4.5em 3.5em;' . "\n";
	$custom_style .= 'background-repeat: no-repeat;' . "\n";

	$custom_style .= 'border-radius: 0;' . "\n";
	$custom_style .= 'margin: 0;' . "\n";
	$custom_style .= '-webkit-box-sizing: border-box;' . "\n";
	$custom_style .= '-moz-box-sizing: border-box;' . "\n";
	$custom_style .= 'box-sizing: border-box;' . "\n";
	$custom_style .= '-webkit-appearance: none; }' . "\n";

	return $custom_style;
}

/**
 * Image
 * Changing the header image
 * same location, same image name as the parent
 *
 * @since 1.0.0
 */
function coffeeisle_header_image( $input ) {
	$input['default-image'] = get_stylesheet_directory_uri() . '/images/header.jpg';
	return $input;
}
add_filter( 'oblique_custom_header_args', 'coffeeisle_header_image' );

/**
 * Post
 * thumbnail size
 *
 * @since 1.0.0
 */
function coffeeisle_post_thumbnail_size() {
	remove_image_size( 'oblique-entry-thumb' );
	add_image_size( 'oblique-entry-thumb', 525 );
}
add_action( 'after_setup_theme', 'coffeeisle_post_thumbnail_size', 15 );

/**
 * Post
 * read more message
 *
 * @since 1.0.0
 */
function coffeeisle_post_read_more() {
	return esc_html__( 'Keep Reading &rarr;','coffeeisle' );
}
add_filter( 'oblique_post_read_more', 'coffeeisle_post_read_more' );

/**
 * Post
 * read more message
 *
 * @since 1.0.0
 */
function coffeeisle_post_link_to_single() {
	if ( ! get_theme_mod( 'read_more' ) ) :?>
		<a href="<?php the_permalink(); ?>" class="entry-content-link">
			<?php echo apply_filters( 'oblique_post_read_more' , esc_html__( 'Continue reading &hellip;','coffeeisle' ) ); ?>
		</a>
	<?php
	endif;
}
add_action( 'oblique_post_entry_content_bottom', 'coffeeisle_post_link_to_single' );

/**
 * Svg new
 * Post bottom svg
 *
 * @since 1.0.0
 */
function coffeeisle_svg_new() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1890" y1="0" x2="0" y2="150" width="100%" height="50" class="bottom post-bottom-svg-line" />
		</svg>
	';
}
add_action( 'oblique_post_bottom_svg', 'coffeeisle_svg_new' );

/**
 * Svg
 * Archive page title svg
 *
 * @since 1.0.0
 */
function coffeeisle_archive_title_svg() {
	echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="archive_title_svg" />
    </svg>';
}
add_action( 'oblique_archive_title_bottom_svg', 'coffeeisle_archive_title_svg' );

/**
 * Svg
 * Search Results Page title top svg
 *
 * @since 1.0.0
 */
function coffeeisle_search_title_top_svg() {
	?>
	<div class="svg-container svg-block search-title-top-svg">
		<?php oblique_svg_3(); ?>
	</div>
	<?php
}
add_action( 'oblique_search_before_title', 'coffeeisle_search_title_top_svg' );

/**
 * Svg
 * Search Results Page title bottom svg
 *
 * @since 1.0.0
 */
function coffeeisle_search_title_bottom_svg() {
	?>
	<div class="svg-container svg-block search-title-bottom-svg">
		<?php
		echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1890" y1="0" x2="0" y2="150" width="100%" height="50" class="archive_title_svg" />
		</svg>';
		?>
	</div>
	<?php
}
add_action( 'oblique_search_after_title', 'coffeeisle_search_title_bottom_svg' );

/**
 * Post
 * Change post format
 *
 * @since 1.0.0
 */
function oblique_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$category = get_the_category();
	if ( $category ) {
		$cat = '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_attr( $category[0]->cat_name ) . '</a>';
	}

	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	if ( ! is_singular() ) {
		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	} elseif ( ! get_theme_mod( 'meta_singles' ) ) {
		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'coffeeisle' ) );
			if ( $categories_list ) {
				echo '<span class="cat-links">' . $categories_list . '</span>';
			}
		}
	}
}

/**
 * Footer
 * Change footer credits
 *
 * @since 1.0.0
 */
function coffeeisle_footer_credits() {
	echo esc_html__( 'Coffeeisle Shop Theme', 'coffeeisle' );
	echo '<span class="sep"> | </span>';
	/* Translators: Copyright message */
	printf( __('&copy; %s', 'coffeeisle'), esc_html__( 'Copyright 2017', 'coffeeisle') );
	echo '<span class="sep"> | </span>';
	echo esc_html__( 'All Rights Reserved.', 'coffeeisle' );
}
if ( ! coffeeisle_compatibility_with_pro_features() ) {
	add_action( 'oblique_footer', 'coffeeisle_footer_credits' );
}

/**
 * Posts Navigation
 *
 * @since 1.0.0
 */
function coffeeisle_custom_pagination() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	echo '<nav class="navigation posts-navigation" role="navigation">';

	echo '<h2 class="screen-reader-text">';
	esc_html_e( 'Posts navigation', 'coffeeisle' );
	echo '</h2>';

	echo '<div class="nav-links">';

		the_posts_pagination(
			array(
				'mid_size' => 1,
				'prev_text' => esc_html__( 'Prev', 'coffeeisle' ),
				'next_text' => esc_html__( 'Next', 'coffeeisle' ),
				'screen_reader_text' => esc_html__('Posts navigation', 'coffeeisle' ),
			)
		);

	echo '</div>';

	echo '</nav>';
}
add_action( 'oblique_posts_navigation', 'coffeeisle_custom_pagination' );

/**
 * Single content
 * single post bottom svg
 *
 * @since 1.0.0
 */
function coffeeisle_single_post_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="bottom single_post_bottom_svg" />
		</svg>
	';
}
add_action( 'oblique_single_post_bottom_svg', 'coffeeisle_single_post_bottom_svg' );

/**
 * Comments
 * changing the default comment form
 *
 * @since 1.0.0
 */
function coffeeisle_comments_template() {
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$commenter = wp_get_current_commenter();
	$args = array(
		'title_reply' => esc_html__( 'Leave us a Message', 'coffeeisle' ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply_before' => '<h3>',
		'title_reply_after' => '</h3>',
		'label_submit' => esc_html__( 'Submit', 'coffeeisle' ),
		'fields' => apply_filters(
			'comment_form_default_fields', array(
				'author' =>
				'<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'coffeeisle' ) . '</label><input id="author" name="author" type="text" value="' .
				esc_attr( $commenter['comment_author'] ) . '" size ="30" ' . esc_html( $aria_req ) . '/></p>',

				'email' =>
				'<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'coffeeisle' ) . '</label><input id="email" type="text" value="' .
				esc_attr( $commenter['comment_author'] ) . '" size="30" ' . esc_html( $aria_req ) . ' /></p>',

				'url' =>
				'<p class="comment-form-url"><label for="url">' . esc_html__( 'Subject','coffeeisle' ) . '</label><input id="url" name="url" type="text" value="' .
				esc_attr( $commenter['comment_author_url'] ) . '" /></p>',

			)
		),
		'comment_field' =>
		'<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'coffeeisle' ) . '</label><textarea id="comment" name="comment" cols="45" rows="15" placeholder="' .
		'" aria-required="true"></textarea></p>',
	);

	return $args;
}
add_filter( 'oblique_comments_args','coffeeisle_comments_template' );

/**
 * Comment respond
 * moving comment field at the end of fields
 *
 * @since 1.0.0
 */
function coffeeisle_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'coffeeisle_move_comment_field_to_bottom' );

/**
 * SVG
 * changing post bottom svg on single page
 *
 * @since 1.0.0
 */
function coffeeisle_single_page_post_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1920 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1920" y1="0" x2="0" y2="150" width="100%" height="50" class="single_page_post_svg" />
		</svg>
	';
}
add_action( 'oblique_single_page_post_svg', 'coffeeisle_single_page_post_svg' );

/**
 * Single page post tags message
 *
 * @since 1.0.0
 */
function coffeeisle_post_tags_message() {

    /* Translators: Post Tags */
	$args = esc_html__( 'Tags: %1$s', 'coffeeisle' );
	return $args;
}
add_filter( 'oblique_post_tags_message', 'coffeeisle_post_tags_message' );

/**
 * Comments title text
 *
 * @since 1.0.0
 */
function coffeeisle_comments_title_text() {
	?>
	<h2 class="comments-title"><?php echo esc_html__( 'Comments', 'coffeeisle' ); ?></h2>
	<?php
}
add_action( 'oblique_comments_title', 'coffeeisle_comments_title_text' );

/**
 * Comments list
 *
 * @since 1.0.0
 */
function coffeeisle_comments_list() {
	wp_list_comments(
		array(
			'style'      => 'ol',
			'short_ping' => true,
			'avatar_size' => 60,
			'reply_text' => 'Reply',
		)
	);
}
add_action( 'oblique_comments_list', 'coffeeisle_comments_list' );

/**
 * Main classes
 *
 * @since 1.0.0
 */
function coffeeisle_main_classes( $input ) {
	if ( is_active_sidebar( 'single-sidebar' ) ) :
		$input .= ' col-md-8';
	endif;

	return $input;
}
add_filter( 'oblique_main_classes', 'coffeeisle_main_classes' );

/**
 * Sidebar
 * Register the second sidebar
 *
 * @since 1.0.0
 */
function coffeeisle_single_sidebar() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Single Sidebar', 'coffeeisle' ),
			'id'            => 'single-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'coffeeisle_single_sidebar' );

/**
 * Sidebar
 * Show the second sidebar
 *
 * @since 1.0.0
 */
function coffeeisle_sidebar_on_single() {
	if ( is_active_sidebar( 'single-sidebar' ) ) :
	?>
		<aside id="secondary" class="col-md-4 single-sidebar" role="complementary">
			<?php dynamic_sidebar( 'single-sidebar' ); ?>
		</aside><!-- .sidebar .widget-area -->
		<?php
	endif;
}
add_action( 'oblique_single_sidebar', 'coffeeisle_sidebar_on_single' );

/**
 * Header Search Icon
 *
 * @since 1.0.0
 */
function coffeeisle_search_icon() {
	?>
	<div class="nav_search_icon">
	</div>
	<?php
}
add_action( 'oblique_nav_search', 'coffeeisle_search_icon' );

// Include template for alt shop page
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/woocommerce_template/functions.php';
}
