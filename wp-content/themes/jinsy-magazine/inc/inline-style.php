<?php
/**
 * Inline style
 *
 * @package jinsy-magazine
 */

/**
 * Inline style when parent theme is Hestia
 */
function jinsy_magazine_inline_style() {

	$accent_color = get_theme_mod( 'accent_color', '#5e72e4' );

	$custom_css = '';

	if ( ! jinsy_magazine_pro() ) {
		/**
		 * Very top bar background color
		 */
		if ( ! empty( $accent_color ) ) {
			$custom_css .= '
			.hestia-top-bar {
				background-color: ' . esc_html( $accent_color ) . ';
			}
		';
		}
	}

	/**
	 * Scroll to top button background-color and box-shadow
	 */
	if ( ! empty( $accent_color ) && function_exists( 'hestia_hex_rgba' ) ) {
		$custom_css .= '
			.hestia-scroll-to-top,
			.hestia-scroll-to-top:hover,
			.hestia-scroll-to-top:focus, 
			.hestia-scroll-to-top:active {
				background-color: ' . esc_html( $accent_color ) . ';
			}
		';
		$custom_css .= '
			.hestia-scroll-to-top {
				-webkit-box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $accent_color, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $accent_color, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $accent_color, '0.12' ) . ';
		    box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $accent_color, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $accent_color, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $accent_color, '0.12' ) . ';
			}
		';
		$custom_css .= '
			.hestia-scroll-to-top:hover {
				-webkit-box-shadow: 0 14px 26px -12px' . hestia_hex_rgba( $accent_color, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $accent_color, '0.2' ) . ';
		    box-shadow: 0 14px 26px -12px ' . hestia_hex_rgba( $accent_color, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $accent_color, '0.2' ) . ';
			}
		';
	}

	/* Hide Blog page title when Magazine Layout is enabled */
	$magazine_layout_enabled = get_theme_mod( 'jinsy_magazine_magazine_layout', true );
	if ( $magazine_layout_enabled ) {
		$custom_css .= '
			.blog .title-in-content {
				display: none;
			}
		';
	} else {
		$custom_css .= '
			.blog .title-in-content {
				display: block;
			}
		';
	}

	wp_add_inline_style( 'hestia_style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'jinsy_magazine_inline_style', 20 );

