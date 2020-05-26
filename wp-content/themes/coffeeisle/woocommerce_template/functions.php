<?php
/**
 * WooCommerce functions used in child theme.
 *
 * @package coffeeisle
 * @since 1.0.0
 */

/**
 * Sanitize checkbox
 *
 * @param $input
 * @return int|string
 *
 * @since 1.0.1
 */
function coffeeisle_sanitize_checkbox( $input ) {

	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Sanitize dropdown for select categories
 *
 * @param $input
 * @return string
 *
 * @since 1.0.1
 */
function coffeeisle_sanitize_category_dropdown( $input ) {

	$cat = get_category_by_slug( $input );

	if ( empty( $cat ) ) {
		return 'all';
	}
	return $input;
}

/**
 * Replace parent theme functions bound to woo hooks
 *
 * @since 1.0.0
 */
function coffeeisle_remove_woo_functions() {
	/* Shop Page */
	remove_action( 'woocommerce_after_shop_loop_item', 'oblique_product_bottom_svg', 10 );

	/* Single Product Page */
	remove_action( 'oblique_single_product_bottom_svg', 'oblique_svg_5' );
	remove_action( 'oblique_related_products_title_after', 'oblique_svg_5' );
}
add_action( 'after_setup_theme', 'coffeeisle_remove_woo_functions', 15 );

/**
 * Adding bottom svg for item on shop page
 *
 * @since 1.0.0
 */
function coffeeisle_product_bottom_svg() {
	?>
	<div class="svg-container post-bottom-svg svg-block">
		<?php coffeeisle_svg_new(); ?>
	</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item', 'coffeeisle_product_bottom_svg', 10 );

/**
 * Set the number of products per row
 *
 * @since 1.0.0
 */
function coffeeisle_products_per_row() {
	return 3;
}
add_filter( 'loop_shop_columns', 'coffeeisle_products_per_row' );

/**
 * Change pagination on shop page
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'coffeeisle_custom_pagination', 10 );

// Remove categories information from single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
 * Change the number of related products
 *
 * Variables:
 * posts_per_page - related products per page
 * columns - number of columns for related products
 *
 * @since 1.0.0
 */
function coffeeisle_related_products( $args ) {

	$args['posts_per_page'] = 4;
	$args['columns'] = 4;

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'coffeeisle_related_products' );

/**
 * Single Product Bottom SVG
 *
 * @since 1.0.0
 */
function coffeeisle_single_product_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="single_product_bottom_svg_line" />
		</svg>
	';
}
add_action( 'oblique_single_product_bottom_svg', 'coffeeisle_single_product_bottom_svg' );

/**
 * Related Products Title Bottom SVG
 *
 * @since 1.0.0
 */
function coffeeisle_related_title_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="related_title_bottom_svg_line" />
		</svg>
	';
}
add_action( 'oblique_related_products_title_after', 'coffeeisle_related_title_bottom_svg' );


/**
 * Alt Shop Page template
 */

/**
 * Display products from category
 *
 * @param $ids_array - category for the products to be shown
 * @since 1.0.0
 */
function coffeeisle_display_woo_cat( $ids_array, $posts_per_page = null ) {

	$default_posts_per_page = 3;
	if ( ! empty( $posts_per_page ) ) {
		$default_posts_per_page = $posts_per_page;
	}

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $default_posts_per_page,
		'meta_query'     => array(
			array(
				'key' => '_thumbnail_id',
			),
		),
	);
	if ( ! empty( $ids_array ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $ids_array,
			),
		);
	}

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {
	?>
	<ul class="products"> 
	<?php
	while ( $loop->have_posts() ) {
		$loop->the_post();
		wc_get_template_part( 'content', 'product' );
	}
		wp_reset_postdata();
		?>
	</ul>
	<?php
	}
}

/**
 * Adding control for selecting category
 * Products from this category will be listed in the section
 * Choose category for special offer product
 * Hide Blog section on alt shop template
 *
 * @since 1.0.0
 */
function coffeeisle_alt_woo_register( $wp_customize ) {

	$wp_customize->add_section(
		'coffeeisle_featured_products', array(
			'title'       => esc_html__( 'Featured products', 'coffeeisle' ),
			'priority'    => apply_filters( 'coffeeisle_section_priority', 15, 'coffeeisle_featured_products' ),
		)
	);

	$wp_customize->add_setting(
		'coffeeisle_featured_products_category_1',
		array(
			'default'           => '-',
            'sanitize_callback' => 'coffeeisle_sanitize_woo_cat'
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_1',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products first category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);
	$wp_customize->add_setting(
		'coffeeisle_number_of_featured_products_category_1',
		array(
			'default' => '3',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_number_of_featured_products_category_1',
		array(
			'type'          => 'number',
			'section'       => 'coffeeisle_featured_products',
			'label'         => __( 'Number of products from first category', 'coffeeisle' ),
			'input_attrs'   => array(
				'min'   => 1,
				'max'   => 30,
				'step'  => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'coffeeisle_offer_product_category',
		array(
			'default'           => '-',
			'sanitize_callback' => 'coffeeisle_sanitize_woo_cat',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_offer_product_category',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Offer product category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting(
		'coffeeisle_featured_products_category_2',
		array(
			'default'           => '-',
			'sanitize_callback' => 'coffeeisle_sanitize_woo_cat',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_2',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products second category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);
	$wp_customize->add_setting(
		'coffeeisle_number_of_featured_products_category_2',
		array(
			'default' => '3',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_number_of_featured_products_category_2',
		array(
			'type'          => 'number',
			'section'       => 'coffeeisle_featured_products',
			'label'         => __( 'Number of products from second category', 'coffeeisle' ),
			'input_attrs'   => array(
				'min'   => 1,
				'max'   => 30,
				'step'  => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'coffeeisle_featured_products_category_3',
		array(
			'default'           => '-',
			'sanitize_callback' => 'coffeeisle_sanitize_woo_cat',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_3',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products third category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);
	$wp_customize->add_setting(
		'coffeeisle_number_of_featured_products_category_3',
		array(
			'default' => '3',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_number_of_featured_products_category_3',
		array(
			'type'          => 'number',
			'section'       => 'coffeeisle_featured_products',
			'label'         => __( 'Number of products from third category', 'coffeeisle' ),
			'input_attrs'   => array(
				'min'   => 1,
				'max'   => 30,
				'step'  => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'coffeeisle_hide_blog_on_alt_shop',
		array(
			'default'       => 0,
			'sanitize_callback' => 'coffeeisle_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_hide_blog_on_alt_shop',
		array(
			'type'      => 'checkbox',
			'label'     => __( 'Hide Blog section on Alt Template Shop', 'coffeeisle' ),
			'section'   => 'coffeeisle_featured_products',
		)
	);
}
add_action( 'customize_register', 'coffeeisle_alt_woo_register', 20 );

/**
 * Categories to be displayed in customizer
 *
 * @param bool $placeholder
 *
 * @return array
 * @since 1.0.0
 */
function coffeeisle_get_woo_categories( $placeholder = true ) {

	$coffeeisle_prod_categories_array = $placeholder === true ? array(
		'-' => esc_html__( 'Select category','coffeeisle' ),
	) : array();
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $coffeeisle_prod_categories_array;
	}
	$coffeeisle_prod_categories = get_categories(
		array(
			'taxonomy' => 'product_cat',
			'hide_empty' => 0,
			'title_li' => '',
		)
	);
	if ( ! empty( $coffeeisle_prod_categories ) ) {
		foreach ( $coffeeisle_prod_categories as $coffeeisle_prod_cat ) {
			if ( ! empty( $coffeeisle_prod_cat->term_id ) && ! empty( $coffeeisle_prod_cat->name ) ) {
				$coffeeisle_prod_categories_array[ $coffeeisle_prod_cat->term_id ] = $coffeeisle_prod_cat->name;
			}
		}
	}
	$coffeeisle_prod_categories_array['none'] = esc_html__( 'None', 'coffeeisle' );
	return $coffeeisle_prod_categories_array;
}

/**
 * Display alt shop page category name
 *
 * @since 1.0.0
 */
function coffeeisle_display_woo_cat_title( $woo_cat_name ) {

	?>

	<div class="svg-container svg-block alt_shop_cat_title_top_svg">
		<?php oblique_svg_3(); ?>
	</div>
	<h2 class="alt_shop_cat_title"><?php echo $woo_cat_name; ?></h2>
	<div class="svg-container svg-block alt_shop_cat_title_bottom_svg">
		<?php
		echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="alt_shop_cat_title_bottom_svg_line" />
		</svg>';
		?>
	</div>

	<?php
}

/**
 * Special Offer Product Display
 *
 * @since 1.0.0
 */
function coffeeisle_display_offer_product( $cat_ids_array ) {

	$params = array(
		'post_type'         => 'product',
		'posts_per_page'    => 1,
		'orderby'           => 'rand',
		'meta_query'        => array(
			array(
				'key' => '_thumbnail_id',
			),
		),
	);

	if ( ! empty( $cat_ids_array ) ) {

		$params['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'term_id',
				'terms'     => $cat_ids_array,
			),
		);
	}

	$product_offer_loop = new WP_Query( $params );

	if ( $product_offer_loop->have_posts() ) {
			do_action( 'coffeeisle_before_offer_product' );
		while ( $product_offer_loop->have_posts() ) {
			$product_offer_loop->the_post();

			get_template_part( 'template-parts/content','offer-product' );
		}
			wp_reset_postdata();
			do_action( 'coffeeisle_after_offer_product' );
	}
}

/** Set Special Offer Thumbnail size
 *
 * @since 1.0.0
 */
function coffeeisle_special_offer_thumbnail() {
	add_image_size( 'coffeeisle_special_offer_thumbnail_size', 700, 700, true );
}
add_action( 'after_setup_theme', 'coffeeisle_special_offer_thumbnail', 15 );

/**
 * Blog Section on Alt Shop Template
 *
 * @since 1.0.0
 */
function coffeeisle_display_alt_shop_blog_section() {

	// Blog title
	?>
	<div class="svg-container svg-block alt-shop-blog-title-top-svg">
		<?php oblique_svg_3(); ?>
	</div>
	<h2 class="alt-shop-blog-title">Blog</h2>
	<div class="svg-container svg-block alt-shop-blog-title-bottom-svg">
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

	$loop = new WP_Query(
		array(
			'posts_per_page' => 3,
			'ignore_sticky_posts' => true,
		)
	);

	if ( $loop->have_posts() ) :

		$i = 0;
		$has_col = 0;
		while ( $loop->have_posts() ) :
			$loop->the_post();

			if ( $i == 0 ) {
				get_template_part( 'template-parts/content', 'big' );
				$i++;
			} else {
				if ( $has_col == 0 ) {
					echo '<div class="col-md-4 alt-shop-blog-small">';
					$has_col = 1;
				}
				get_template_part( 'content' );
				$i++;
				if ( $i == 3 ) {
					echo '</div><!-- /.col-md-4 -->';
				}
			}

		endwhile;

		wp_reset_postdata();

	endif;
}

/**
 * Sanitize for drop down category on Featured products
 *
 * @since 1.0.1
 * @return string
 */
function coffeeisle_sanitize_woo_cat( $input ){
    $woo_cats = coffeeisle_get_woo_categories( true );
    if( array_key_exists( $input, $woo_cats ) ){
        return $input;
    }
    return '-';
}

/**
 * Change the Blog Section large post thumbnail size
 *
 * @since 1.0.0
 */
function coffeeisle_alt_shop_blog_large_thumb_size() {
	remove_image_size( 'oblique-entry-thumb' );
	add_image_size( 'coffeeisle-blog-large-thumb', 745 );
}
add_action( 'after_setup_theme', 'coffeeisle_alt_shop_blog_large_thumb_size', 15 );
