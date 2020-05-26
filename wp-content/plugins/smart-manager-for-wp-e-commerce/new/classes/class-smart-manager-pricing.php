<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

class Smart_Manager_Pricing {

	public static function sm_show_pricing() {
		?>
		<style type="text/css">
			.update-nag {
				display: none;
			}
			.wrap.about-wrap.sm {
				margin: 25px 70px 0 70px;
				max-width: 100%;
			}
			.sm_main_heading {
				font-size: 2em;
				color: #008cddc7;
				text-align: center;
				font-weight: 600;
				margin: 0 0 1em 0;
			}
			.sm_sub_headline {
				font-size: 1.4em;
				font-weight: 600;
				color: #008cddc7;
				text-align: center;
				line-height: 1.5em;
				margin: 0 auto 1em;
			}
			.row {
				padding: 1em !important;
				margin: 1.5em !important;
				clear: both;
				position: relative;
			}
			.sm_price_column_container {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				/*max-width: 900px;*/
				max-width: 1190px;
				margin-right: auto;
				margin-left: auto;
				padding-right: 2em;
				padding-left: 2em;
			}
			.column_one_fourth {
				width: 40%;
			}
			.column {
				padding: 1em;
				margin: 0 1em;
				background-color: #fff;
				border: 1px solid rgba(0, 0, 0, 0.1);
				text-align: center;
				color: rgba(0, 0, 0, 0.75);
			}
			.last {
				margin-right: 0;
			}
			.sm_price {
				margin: 1.5em 0;
				color: #1e73be;
			}
			.sm_button {
				color: #FFFFFF !important;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				font-weight: 600;
				margin: 1em 2px;
				cursor: pointer;
			}
			.sm_button.green {
				background: #4fad43;
				border-color: #4fad43;
			}
			.sm_button.green:hover {
				background: #00870c;
				border-color: #00870c;
			}
			.dashicons.dashicons-yes {
				color: green;
				font-size: 2em;
			}
			.dashicons.dashicons-no-alt {
				color: #ed4337;
				font-size: 2em;
			}
			.dashicons.dashicons-yes.yellow {
				color: #BDB76B;
				line-height: unset;
			}
			.dashicons.dashicons-awards,
			.dashicons.dashicons-testimonial {
				line-height: 1.6 !important;
				color: darkgoldenrod;
			}
			.sm_license_name {
				font-size: 1.1em !important;
				color: #1a72bf !important;
			}
			.sm_feature_table {
				width: 70%;
				margin-left: 15%;
				margin-right: 15%;
			}
			.sm_old_price {
				font-size: 1.5em;
				color: #ed4337;
			}
			.sm_new_price {
				font-size: 1.5em;
			}
			#sm-testimonial {
				text-align: center;
			}
			#sm-jeff-testimonial {
				width: 50%;
				margin: 0 auto;
			}
			#sm-jeff-testimonial img {
				width: 12% !important;
			}
			.sm_testimonial_headline {
				margin: 0.6em 0 !important;
			}
			.sm_testimonial_text {
				text-align: left;
				font-size: 1.1em;
				line-height: 1.6;
			}
			table.sm_feature_table th,
			table.sm_feature_table tr,
			table.sm_feature_table td,
			table.sm_feature_table td span {
				padding: 0.5em !important;
				text-align: center !important;
				background-color: transparent !important;
				vertical-align: middle !important;
			}
			table.sm_feature_table,
			table.sm_feature_table th,
			table.sm_feature_table tr,
			table.sm_feature_table td {
				border: 1px solid #eaeaea;
			}
			table.sm_feature_table.widefat th,
			table.sm_feature_table.widefat td {
				color: #515151;
			}
			table.sm_feature_table th {
				font-weight: bolder !important;
				font-size: 1.3em;
			}
			table.sm_feature_table tr td {
				font-size: 15px;
			}
			.sm_feature {
				text-transform: capitalize;
				text-align: left !important;
			}
			.sm_product_page_link {
				text-align: center;
				font-size: 1.2em;
				margin-top: 2em;
			}
		</style>

		<div class="wrap about-wrap sm">
			<div class="row" id="sm-pricing">
				<div class="sm_main_heading"><?php echo __( '🎉 Congratulations! You just unlocked 50% off on Smart Manager Pro 🎉 ', 'smart-manager-for-wp-e-commerce' ); ?></div>
				<div class="sm_price_column_container">
					<div class="column column_one_fourth">
						<span class="sm_plan"><h4 class="sm_license_name"><?php echo __( '1 site (Annual)', 'smart-manager-for-wp-e-commerce' ); ?></h4></span>
						<span class="sm_price">
							<strike class="sm_old_price"><?php echo __( '$149/year', 'smart-manager-for-wp-e-commerce' ); ?></strike>
							<b class="sm_new_price"><?php echo __( '$75/year', 'smart-manager-for-wp-e-commerce' ); ?></b>
						</span>
						<a href="https://www.storeapps.org/?buy-now=18694&qty=1&coupon=sm-50off&page=722&with-cart=1&utm_source=sm&utm_medium=in_app_pricing&utm_campaign=single_annual" target="_blank" rel="noopener" class="sm_button green"><?php echo __( 'Get 50% OFF', 'smart-manager-for-wp-e-commerce' ); ?></a>
					</div>
					<div class="column column_one_fourth sm_lifetime_price">
						<span class="sm_plan"><h4 class="sm_license_name"><?php echo __( '1 site (Lifetime)', 'smart-manager-for-wp-e-commerce' ); ?></h4></span>
						<span class="sm_price">
							<strike class="sm_old_price"><?php echo __( '$449', 'smart-manager-for-wp-e-commerce' ); ?></strike>
							<b class="sm_new_price"><?php echo __( '$225', 'smart-manager-for-wp-e-commerce' ); ?></b>
						</span>
						<a href="https://www.storeapps.org/?buy-now=86835&qty=1&coupon=sm-50off-l&page=722&with-cart=1&utm_source=sm&utm_medium=in_app_pricing&utm_campaign=single_lifetime" target="_blank" rel="noopener" class="sm_button green"><?php echo __( 'Get 50% OFF', 'smart-manager-for-wp-e-commerce' ); ?></a>
					</div>
					<div class="column column_one_fourth">
						<span class="sm_plan"><h4 class="sm_license_name"><?php echo __( '5 sites (Annual)', 'smart-manager-for-wp-e-commerce' ); ?></h4></span>
						<span class="sm_price">
							<strike class="sm_old_price"><?php echo __( '$179/year', 'smart-manager-for-wp-e-commerce' ); ?></strike>
							<b class="sm_new_price"><?php echo __( '$90/year', 'smart-manager-for-wp-e-commerce' ); ?></b>
						</span>
						<a href="https://www.storeapps.org/?buy-now=18693&qty=1&coupon=sm-50off&page=722&with-cart=1&utm_source=sm&utm_medium=in_app_pricing&utm_campaign=multi_annual" target="_blank" rel="noopener" class="sm_button green"><?php echo __( 'Get 50% OFF', 'smart-manager-for-wp-e-commerce' ); ?></a>
					</div>
					<div class="column column_one_fourth last sm_lifetime_price">
						<span class="sm_plan"><h4 class="sm_license_name"><?php echo __( '5 sites (Lifetime)', 'smart-manager-for-wp-e-commerce' ); ?></h4></span>
						<span class="sm_price">
							<strike class="sm_old_price"><?php echo __( '$549', 'smart-manager-for-wp-e-commerce' ); ?></strike>
							<b class="sm_new_price"><?php echo __( '$275', 'smart-manager-for-wp-e-commerce' ); ?></b>
						</span>
						<a href="https://www.storeapps.org/?buy-now=86836&qty=1&coupon=sm-50off-l&page=722&with-cart=1&utm_source=sm&utm_medium=in_app_pricing&utm_campaign=multi_lifetime" target="_blank" rel="noopener" class="sm_button green"><?php echo __( 'Get 50% OFF', 'smart-manager-for-wp-e-commerce' ); ?></a>
					</div>
				</div>
			</div>
			<div class="row" id="sm-testimonial">
				<div class="sm_sub_headline"><span class="dashicons dashicons-testimonial"></span><?php echo __( ' Read what Jeff has to say about Smart Manager Pro:', 'smart-manager-for-wp-e-commerce' ); ?></div>
				<div class="column" id="sm-jeff-testimonial">
					<img src="<?php echo SM_BETA_IMG_URL ?>jeff-smith.png" alt="Jeff" />
					<h3 class="sm_testimonial_headline"><?php echo __( 'I would happily pay five times for this product!', 'smart-manager-for-wp-e-commerce' ); ?></h3>
					<div class="sm_testimonial_text">
						<?php echo __( 'What really sold me on Smart Manager Pro was Batch Update. My assistant does not have to do any complex math now (earlier, I always feared she would make mistakes)! With Smart Manager, she has more free time at hand, so I asked her to set up auto responder emails. The response was phenomenal. Repeat sales were up by 19.5%.', 'smart-manager-for-wp-e-commerce' ); ?>
					</div>
				</div>
			</div>
			<div class="sm_comparison_table">
				<div class="sm_sub_headline"><span class="dashicons dashicons-awards"></span><?php echo __( ' Get tons of more features with Smart Manager Pro!', 'smart-manager-for-wp-e-commerce' ); ?></div>
				<table class="sm_feature_table wp-list-table widefat fixed">
					<thead>
						<tr>
							<th>
								<?php echo esc_html__( 'Features', 'smart-manager-for-wp-e-commerce' ); ?>
							</th>
							<th>
								<?php echo esc_html__( 'Free', 'smart-manager-for-wp-e-commerce' ); ?>
							</th>
							<th>
								<?php echo esc_html__( 'Pro', 'smart-manager-for-wp-e-commerce' ); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Supported Post Types', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes yellow'></span><br>
								<?php echo __( '5 POST TYPES', 'smart-manager-for-wp-e-commerce' ); ?><br>
								<?php echo __( 'WordPress: Posts', 'smart-manager-for-wp-e-commerce' ); ?><br>
								<?php echo __( 'WooCommerce: Products, Variations, Orders, Coupons', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span><br>
								<strong>
									<?php echo __( 'ALL POST TYPES', 'smart-manager-for-wp-e-commerce' ); ?><br>
									<?php echo __( 'Everything in Lite +', 'smart-manager-for-wp-e-commerce' ); ?>
								</strong><br>
								<?php echo __( 'WordPress: Pages, Media, Users', 'smart-manager-for-wp-e-commerce' ); ?><br>
								<?php echo __( 'WooCommerce Post Types: Customers, Subscriptions, Smart Offers', 'smart-manager-for-wp-e-commerce' ); ?>
								<?php echo __( 'and all your WordPress custom post types and their custom fields', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Inline editing', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes yellow'></span><br>
								<?php echo __( 'Only 3 records at a time', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span><br>
								<?php echo __( 'Unlimited records', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Add and delete records', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Customizable Columns', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Simple Search', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Advanced Search', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes yellow'></span><br>
								<?php echo __( 'Only using AND operator', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span><br>
								<?php echo __( 'Using AND + OR operator', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<strong><?php echo __( 'Bulk / Batch Update', 'smart-manager-for-wp-e-commerce' ); ?></strong>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span><br>
								<?php echo __( 'Set to, Append, Prepend, Increase / Decrease by %, Increase / Decrease by number, Set datetime to, Set date to, Set time to, Upload images and many more...', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Export all / filtered records as CSV', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Duplicate single / multiple / all records for a particular post type  in a single click', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Manage WordPress User roles', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Print packing slips for WooCommerce orders in bulk', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'View Customer Lifetime Value (LTV)', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<span class='dashicons dashicons-no-alt'></span>
							</td>
							<td>
								<span class='dashicons dashicons-yes'></span>
							</td>
						</tr>
						<tr>
							<td class="sm_feature">
								<?php echo __( 'Help', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<?php echo __( 'WP forum', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
							<td>
								<?php echo __( 'Priority support via Email', 'smart-manager-for-wp-e-commerce' ); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="sm_product_page_link">
				<?php echo sprintf( __( 'Want to know more about Smart Manager Pro? %s.', 'smart-manager-for-wp-e-commerce' ), '<a style="color: #008cddc7;" target="_blank" href="https://www.storeapps.org/product/smart-manager/?utm_source=sm&utm_medium=in_app_pricing&utm_campaign=sm_know">' . __( 'Click here', 'smart-manager-for-wp-e-commerce' ) . '</a>' ); ?>
			</div>
		</div>
		<?php
	}
}

new Smart_Manager_Pricing();