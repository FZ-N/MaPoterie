<?php

if ( !defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Smart_Manager_Shop_Subscription' ) ) {
	class Smart_Manager_Shop_Subscription extends Smart_Manager_Base {
		public $dashboard_key = '',
			$default_store_model = array();

		function __construct($dashboard_key) {
			parent::__construct($dashboard_key);

			$this->dashboard_key = $dashboard_key;
			$this->post_type = $dashboard_key;
			$this->req_params  	= (!empty($_REQUEST)) ? $_REQUEST : array();
			
			add_filter( 'sm_dashboard_model',array( &$this,'subscriptions_dashboard_model' ), 10, 1 );
			add_filter( 'posts_where',array( &$this,'sm_query_sub_where_cond' ), 11, 2 );
		}

		public function subscriptions_dashboard_model ($dashboard_model) {
			global $wpdb, $current_user;

			$dashboard_model[$this->dashboard_key]['tables']['posts']['where']['post_type'] = 'shop_subscription';

			$dashboard_model_saved[$this->dashboard_key] = get_transient( 'sm_beta_'.$current_user->user_email.'_'.$this->dashboard_key );

			$visible_columns = array('ID', 'post_date', 'post_status', '_billing_email', '_billing_first_name', '_billing_last_name', '_order_total', '_billing_interval', '_billing_period', '_payment_method_title', '_schedule_next_payment', '_schedule_end');

			$numeric_columns = array('_billing_phone', '_billing_postcode', '_cart_discount', '_cart_discount_tax', '_customer_user', '_shipping_postcode');

			$column_model = &$dashboard_model[$this->dashboard_key]['columns'];

			$post_status_col_index = sm_multidimesional_array_search('posts_post_status', 'data', $dashboard_model[$this->dashboard_key]['columns']);
			
			$sub_statuses = array();

			if( function_exists('wcs_get_subscription_statuses') ) {
				$sub_statuses = wcs_get_subscription_statuses();
			}

			$sub_statuses_keys = ( !empty( $sub_statuses ) ) ? array_keys($sub_statuses) : array();
			$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['defaultValue'] = ( !empty( $sub_statuses_keys[0] ) ) ? $sub_statuses_keys[0] : 'wc-pending';

			$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['save_state'] = true;
			
			$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['values'] = $sub_statuses;
			$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['selectOptions'] = $sub_statuses; //for inline editing

			$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['search_values'] = array();
			foreach ($sub_statuses as $key => $value) {
				$dashboard_model[$this->dashboard_key]['columns'][$post_status_col_index]['search_values'][] = array('key' => $key, 'value' => $value);
			}

			//Code for unsetting the position for hidden columns

			foreach( $column_model as &$column ) {
				
				if (empty($column['src'])) continue;

				$src_exploded = explode("/",$column['src']);

				if (empty($src_exploded)) {
					$src = $column['src'];
				}

				if ( sizeof($src_exploded) > 2) {
					$col_table = $src_exploded[0];
					$cond = explode("=",$src_exploded[1]);

					if (sizeof($cond) == 2) {
						$src = $cond[1];
					}
				} else {
					$src = $src_exploded[1];
					$col_table = $src_exploded[0];
				}


				if( empty($dashboard_model_saved[$this->dashboard_key]) ) {
					if (!empty($column['position'])) {
						unset($column['position']);
					}

					$position = array_search($src, $visible_columns);

					if ($position !== false) {
						$column['position'] = $position + 1;
						$column['hidden'] = false;
					} else {
						$column['hidden'] = true;
					}
				}

				if ($src == 'post_date') {
					$column ['name'] = $column ['key'] = 'Date';
				} else if ($src == 'post_status') {
					$column ['name'] = $column ['key'] = 'Status';
				} else if( !empty( $numeric_columns ) && in_array( $src, $numeric_columns ) ) {
					$column ['type'] = $column ['editor'] = 'numeric';
				}
			}

			if (!empty($dashboard_model_saved[$this->dashboard_key])) {
				$col_model_diff = sm_array_recursive_diff($dashboard_model_saved,$dashboard_model);	
			}

			//clearing the transients before return
			if (!empty($col_model_diff)) {
				delete_transient( 'sm_beta_'.$current_user->user_email.'_'.$this->dashboard_key );	
			}

			return $dashboard_model;

		}

		public function sm_query_sub_where_cond ($where, $wp_query_obj) {
			global $wpdb;

			//Code for handling simple search
			if( empty( $this->req_params['search_text'] ) || strpos( $where, 'posts.ID IN' ) === true ) {
				return $where;
			}

			$search_text = $wpdb->_real_escape( $this->req_params['search_text'] );
			$skuSubIds = $userSubIds = array();

			//Query to get the post_id of the products whose sku code matches with the one type in the search text box of the Orders Module
			$pIds  = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(post_id) FROM {$wpdb->prefix}postmeta
			              									WHERE meta_key = %s
			                 								AND meta_value LIKE '%".$search_text."%'", '_sku') );

			if( count( $pIds ) > 0 ) {
				$skuSubIds = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(order_id)
							                                    FROM {$wpdb->prefix}woocommerce_order_items AS woocommerce_order_items
							                                    	LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS woocommerce_order_itemmeta USING ( order_item_id )
							                                    WHERE woocommerce_order_itemmeta.meta_key IN ( %s, %s )
							                                    	AND woocommerce_order_itemmeta.meta_value IN ( ". implode( ',', $pIds ) ." )", '_product_id', '_variation_id') );
			}
			
			//Query to perform simple search in either of item names i.e. product_name, shipping_title, coupon_code
			$itemNameSkuSubIds = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(order_id)
									                                FROM {$wpdb->prefix}woocommerce_order_items
									                                WHERE 1=%d
									                                	AND order_item_name LIKE '%". $search_text ."%'",1 ) );

			//Query for getting the user_id based on the email enetered in the Search Box
            $userIds = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(id)
														FROM {$wpdb->prefix}users 
                    									WHERE 1=%d
                    										AND user_email like '%". $search_text ."%'",1 ) );

            if( count( $userIds ) > 0 ) {
            	$userSubIds = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT(p.ID)
            														FROM {$wpdb->prefix}posts AS p
            															JOIN {$wpdb->prefix}postmeta AS pm
            																ON( pm.post_id = p.ID
            																	AND p.post_type = %s
            																	AND pm.meta_key = %s )
            														WHERE pm.meta_value IN( ". implode( ',', $userIds ) ." )", 'shop_subscription', '_customer_user' ) );
            }

            if( !empty( $skuSubIds ) || !empty( $itemNameSkuSubIds ) || !empty( $userSubIds ) ) {
            	$subIds = array_unique( array_merge( $skuSubIds, $itemNameSkuSubIds, $userSubIds ) );
            	$where = " AND {$wpdb->prefix}posts.ID IN(". implode( ',', $subIds ) .") AND {$wpdb->prefix}posts.post_type = 'shop_subscription' ";
            }

			return $where;
		}
	}
}