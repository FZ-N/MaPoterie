/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
/* global wp*/
( function( $ ) {
    'use strict';

    //Background color
    //atentie ca variabila in care este culoarea nu are

    // Primary color
    wp.customize('primary_color', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {

            }
        });
    });

    // Secondary Color
    wp.customize('secondary_color', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('.woocommerce-page ul.products li.product .price').css('color', to );
                $('.woocommerce div.product p.price').css('color', to );
                $('.woocommerce div.product span.price').css('color', to );
                $('.single-product form.cart p.quantity-title').css('color', to );
                $('.single-product form.cart div.quantity').css('color', to );
                $('.woocommerce div.product form.cart table.variations td.label').css('color', to );
                $('.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--description h2').css('color', to );
                $('.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--reviews h2').css('color', to );
                $('.woocommerce div.product form.cart table.variations').css('color', to );
                $('.woocommerce-cart div.cross-sells>h2').css('color', to );
                $('.woocommerce-cart div.cart_totals>h2').css('color', to );
                $('.woocommerce-checkout div.woocommerce-billing-fields>h3').css('color', to );
                $('.woocommerce-checkout div.woocommerce-additional-fields>h3').css('color', to );
                $('.woocommerce-checkout form.woocommerce-checkout h3#order_review_heading ').css('color', to );
                $('.woocommerce-account div.woocommerce>h2').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner h3.offer-product-price').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner div.offer-product-price del').css('color', to );
            }
        });
    });

    // Entry Titles Color
    wp.customize('entry_titles', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('.home article.post div.post-inner a.entry-content-link').css('color', to );
                $('.archive .post-inner a').css('color', to );
                $('div.entry-thumb:after').css('background-color', to );
                $('.pirate-forms-submit-button').css('background-color', to );
                $('.page div.entry-content li:first-of-type').css('color', to );
                $('.page .contact-details-list a').css('color', to );
                $('.page div.comments-area ol.comment-list li.comment div.reply a.comment-reply-link').css('color', to );
                $('.single_post_bottom_svg').css('stroke', to );
                $('.comment-respond h3').css('color', to );
                $('h2.entry-title').css('color', to );
                $('h2.entry-title a').css('color', to );
                $('.entry-content a.entry-content-link').css('color', to );
                $('line.post-bottom-svg-line').css('stroke', to );
                $('div.nav-links .current').css('background-color', to );
                $('.single_page_post_svg ').css('stroke', to );
                $('.single a').css('color', to );
                $('.single h2.comments-title').css('color', to );
                $('.page-header .page-title').css('color', to );
                $('.single .comment-body .comment-author').css('color', to );
                $('.single .comment-body .reply a').css('color', to );
                $('.single-sidebar .widget .widget-title').css('color', to );
                $('.single-sidebar .widget_calendar .calendar_wrap table caption').css('background', to );
                $('.single-sidebar .widget .search-submit').css('background-color', to );
                $('.single-sidebar .widget .search-submit').css('color', to );
                $('.single-sidebar .widget_categories ul li:before').css('color', to );
                $('.single-sidebar .widget_categories ul li').css('color', to );
                $('.single-sidebar .widget_archive ul li:before').css('color', to );
                $('.single-sidebar .widget_archive ul li').css('color', to );
                $('.single-sidebar .widget_pages ul li:before').css('color', to );
                $('.single-sidebar .widget_meta ul li:before').css('color', to );
                $('.single-sidebar .widget_nav_menu ul li:before').css('color', to );
                $('.single-sidebar .widget_recent_entries ul li:before').css('color', to );
                $('.single-sidebar .widget_rss ul li:before').css('color', to );
                $('.single-sidebar .widget_recent_comments ul li:before').css('color', to );
                $('.single-sidebar .widget_calendar .calendar_wrap table td a').css('background-color', to );
                $('.page h2.comments-title ').css('color', to );
                $('.page .comment-body .comment-author .fn').css('color', to );
                $('.archive_title_svg').css('stroke', to );
                $('.woocommerce-page ul.products li.product h2.woocommerce-loop-product__title').css('color', to );
                $('.woocommerce-page ul.products li.product a.add_to_cart_button').css('background-color', to );
                $('.single-product h1.product_title').css('color', to );
                $('.woocommerce div.product .woocommerce-tabs ul.tabs li.active a').css('color', to );
                $('.woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__author').css('color', to );
                $('.woocommerce .star-rating span').css('color', to );
                $('.woocommerce #reviews #respond #reply-title').css('color', to );
                $('.single-product div.single_product_bottom_svg .single_product_bottom_svg_line ').css('stroke', to );
                $('.single-product h2.related_products_title').css('color', to );
                $('.woocommerce-page h2.alt_shop_cat_title').css('color', to );
                $('.single-product div.related-title-bottom-svg .related_title_bottom_svg_line').css('stroke', to );
                $('.woocommerce-page div.alt_shop_cat_title_bottom_svg .alt_shop_cat_title_bottom_svg_line').css('stroke', to );
                $('.woocommerce-page div.woocommerce-message').css('border-top-color', to );
                $('.woocommerce-page div.woocommerce-message:before').css('color', to );
                $('.woocommerce form .form-row .required').css('color', to );
                $('.woocommerce-cart p.return-to-shop a.button').css('background-color', to );
                $('.woocommerce-page div.woocommerce-info').css('border-top-color', to );
                $('.woocommerce-page div.woocommerce-info:before').css('color', to );
                $('.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info').css('border-top-color', to );
                $('.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info:before').css('color', to );
                $('.woocommerce-page ul.products li.product a.added_to_cart').css('color', to );
                $('.woocommerce-page form.woocomerce-form p.lost_password a').css('color', to );
                $('.woocommerce-page div.woocommerce-message a').css('color', to );
                $('.woocommerce-page div.woocommerce-info a').css('color', to );
                $('.woocommerce-page form.woocommerce-cart-form a').css('color', to );
                $('h2.alt-shop-blog-title').css('color', to );
                $('.page div.alt-shop-blog-large article.hentry a.entry-content-link').css('color', to );
                $('.page div.alt-shop-blog-small article.hentry a.entry-content-link').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner h2.offer-product-special-offer').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner div.offer-product-price ins').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button').css('background-color', to );
            }
        });
    });

    // Body text color
    wp.customize('body_text_color', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('body').css('color', to );
                $('form.comment-form p label').css('color', to );
                $('nav.posts-navigation div.nav-links .page-numbers').css('color', to );
                $('.single .comment-body .comment-metadata a').css('color', to );
                $('.single-sidebar .widget select').css('color', to );
                $('.single-sidebar .widget_categories ul li a').css('color', to );
                $('.single-sidebar .widget_tag_cloud .tagcloud a').css('color', to );
                $('.single-sidebar .widget_archive ul li a').css('color', to );
                $('.single-sidebar .widget_pages ul li a').css('color', to );
                $('.single-sidebar .widget_meta ul li a').css('color', to );
                $('.single-sidebar .widget_nav_menu ul li a').css('color', to );
                $('.single-sidebar .widget_recent_entries ul li a').css('color', to );
                $('.single-sidebar .widget .search-form label input.search-field::placeholder').css('color', to );
                $('.woocommerce-page nav.navigation .page-numbers').css('color', to );
            }
        });
    });

    // Footer color
    wp.customize('footer_background', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('footer.site-footer').css('background-color', to );
                $('div.footer-svg.svg-block').css('fill', to );
            }
        });
    });

    // Entry background
    wp.customize('entry_background', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('div.post-inner').css('background-color', to );
                $('.single .hentry ').css('color', to );
                $('.single .single-post-svg').css('fill', to );
                $('.single .comment-body').css('background-color', to );
                $('.single .reply a').css('background-color', to );
                $('.single .comment-form input, .single .comment-form textarea').css('background-color', to );
                $('.single-sidebar .widget_calendar .calendar_wrap table').css('background-color', to );
                $('.single-sidebar .widget_calendar .calendar_wrap table caption').css('color', to );
                $('.single-sidebar .widget_calendar .calendar_wrap table td a').css('color', to );
                $('.single-sidebar .widget_tag_cloud .tagcloud a').css('background-color', to );
                $('.single-sidebar .widget_tag_cloud .tagcloud a:hover').css('color', to );
                $('nav.posts-navigation div.nav-links .current').css('color', to );
                $('.page .hentry').css('background-color', to );
                $('.page .single-post-svg').css('fill', to );
                $('.page .comments-area .comment-body').css('background-color', to );
                $('.page .comment-body .reply a').css('background-color', to );
                $('.page .comment-form input').css('background-color', to );
                $('.comment-form .form-submit input[type="submit"]').css('color', to );
                $('.page .comment-form textarea').css('background-color', to );
                $('.archive .page-header').css('background-color', to );
                $('.archive div.svg-container.svg-block.page-header-svg').css('fill', to );
                $('.search div.search-title-top-svg').css('background-color', to );
                $('.search header.page-header').css('background-color', to );
                $('.search div.search-title-bottom-svg').css('background-color', to );
                $('.woocommerce-page ul.products li.product a.button').css('color', to );
                $('.woocommerce ul.products li.product').css('background-color', to );
                $('.woocommerce-page ul.products li.product').css('background-color', to );
                $('.product .post-bottom-svg').css('background-color', to );
                $('.woocommerce-page ul.products li.product a.add_to_cart_button').css('color', to );
                $('.single-product form.cart p.single-product-add-cart-icon').css('color', to );
                $('.single-product .single_add_to_cart_button').css('color', to );
                $('.woocommerce-page ul.products li.product p.shop_page_add_cart_icon').css('color', to );
                $('.woocommerce-page nav.navigation .current').css('color', to );
                $('.woocommerce #reviews #comments ol.commentlist li').css('background-color', to );
                $('.woocommerce #review_form #respond .form-submit input[type="submit"]').css('color', to );
                $('.single-product div.single_product_top_svg').css('background-color', to );
                $('.single-product div.single_product_wrapper').css('background-color', to );
                $('.single-product div.single_product_bottom_svg').css('fill', to );
                $('.single-product div.related-title-top-svg').css('background-color', to );
                $('.woocommerce-page div.alt_shop_cat_title_top_svg').css('background-color', to );
                $('.single-product h2.related_products_title').css('background-color', to );
                $('.woocommerce-page h2.alt_shop_cat_title').css('background-color', to );
                $('.single-product div.related-title-bottom-svg').css('background-color', to );
                $('.woocommerce-page div.alt_shop_cat_title_bottom_svg').css('background-color', to );
                $('.woocommerce-cart div.cross-sells ul.products li.product div.post-svg').css('fill', to );
                $('.woocommerce-cart div.cross-sells ul.products li.product div.post-bottom-svg').css('fill', to );
                $('.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a').css('color', to );
                $('.woocommerce-cart form.woocommerce-cart-form input[type="submit"]').css('color', to );
                $('.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled ').css('color', to );
                $('.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled:hover').css('color', to );
                $('.woocommerce-page div.woocommerce-message a.button').css('color', to );
                $('.woocommerce-page form.woocommerce-form-login input[type="submit"]').css('color', to );
                $('.woocommerce-cart p.return-to-shop a.button').css('color', to );
                $('.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"]').css('color', to );
                $('.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a:hover').css('color', to );
                $('div.alt-shop-blog-title-top-svg').css('background-color', to );
                $('h2.alt-shop-blog-title').css('background-color', to );
                $('div.alt-shop-blog-title-bottom-svg').css('background-color', to );
                $('div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button').css('color', to );
                $('div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button:hover').css('color', to );

            }
        });
    });

} )( jQuery );