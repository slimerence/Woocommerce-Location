<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://www.techspawn.com
 * @since      1.0.0
 * @package    Wcmlim
 * @subpackage Wcmlim/public
 * @author     techspawn Solutions <contact@techspawn.com>
 */
class Wcmlim_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $max_in_value;

	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
              
	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wcmlim_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wcmlim_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$customcss_enable = get_option('wcmlim_custom_css_enable');
		wp_enqueue_style($this->plugin_name . '_chosen_css_public', plugin_dir_url(__FILE__) . 'css/chosen.min.css', array(), $this->version . rand(), 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wcmlim-public-min.css', array(), $this->version . rand(), 'all');
		wp_enqueue_style($this->plugin_name."-popup-css", plugin_dir_url(__FILE__) . 'css/wcmlim-popup-min.css', array(), $this->version . rand(), 'all');

		if ($customcss_enable == "") {
			wp_enqueue_style($this->plugin_name . '_frontview_css', plugin_dir_url(__FILE__) . 'css/wcmlim-frontview-min.css', array(), $this->version . rand(), 'all');
		}

		$advanceListView = get_option('wcmlim_radio_loc_format');
		$optiontype_loc = get_option('wcmlim_select_or_dropdown');
		if ($advanceListView == "advanced_list_view"  && $optiontype_loc == 'on') {
		wp_enqueue_style($this->plugin_name. '_list_view_pro', plugin_dir_url(__FILE__) . 'css/wcmlim-list-view-pro-min.css', array(), $this->version . rand(), 'all');
		$theme = wp_get_theme();
    	if ($theme['Name'] == 'Astra') {
   		wp_enqueue_style($this->plugin_name. '_list_view_pro_astra', plugin_dir_url(__FILE__) . 'css/wcmlim-astra-list-view-min.css', array(), $this->version . rand(), 'all');
    	}

		}
		$theme = wp_get_theme();
		if ($theme['Name'] == 'Flatsome') {
			wp_enqueue_style($this->plugin_name . '_flatsome_css_public', plugin_dir_url(__FILE__) . 'css/flatsome_css_public-min.css', array(), $this->version . rand(), 'all');
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wcmlim_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wcmlim_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$pl_enable = get_option('wcmlim_preferred_location');
		$api_key = get_option('wcmlim_google_api_key');
		$autodetect = get_option('wcmlim_enable_autodetect_location');
		$enable_price     = get_option('wcmlim_enable_price');
		$uspecLoc = get_option('wcmlim_enable_userspecific_location');
		$showLS = get_option("wcmlim_show_location_selection");
		$instock     = get_option('wcmlim_instock_button_text');
		$instock = __($instock, 'wcmlim');
		$soldout = get_option('wcmlim_soldout_button_text');
		$soldout = __($soldout, 'wcmlim');
		$showNxtLoc = get_option("wcmlim_next_closest_location");
		$store_on_map_arr = get_option("store_on_map_arr");
		$store_on_map_prod_arr = get_option("store_on_map_prod_arr");
		$default_list_align = get_option('wcmlim_default_list_align');
		$default_origin_center = get_option('wcmlim_default_origin_center');
		$default_zoom = get_option('wcmlim_default_zoom');
		$setting_loc_dis_unit = get_option("wcmlim_show_location_distance", true);
		$default_map_color = get_option('wcmlim_default_map_color');
		$widget_select_type = get_option('wcmlim_widget_select_mode');
        $optiontype_loc = get_option('wcmlim_select_or_dropdown');		
        $scoptiontype_loc = get_option('wcmlim_listing_inline_location');		
		$fulladd = get_option('wcmlim_radio_loc_fulladdress');
		$viewformat = get_option('wcmlim_radio_loc_format');
		$wchideoosproduct = get_option("woocommerce_hide_out_of_stock_items");
		$isClearCart = get_option('wcmlim_clear_cart');
		$isdefault   = get_option('wcmlim_enable_default_location');
		$stock_display_format = get_option('woocommerce_stock_format');
		$isLocationsGroup = get_option('wcmlim_enable_location_group');	
		$current_user_id = get_current_user_id();
		$isAdmin = current_user_can('administrator', $current_user_id);
		$specificLocation = get_user_meta($current_user_id, 'wcmlim_user_specific_location', true);
		$getdirection = get_option('wcmlim_get_direction_for_location');
		$coordinates_calculator      = get_option('wcmlim_distance_calculator_by_coordinates');
		wp_enqueue_script('wcmlim-sweet-js', plugin_dir_url(__FILE__) . 'js/sweetalert2@10-min.js', array('jquery'), $this->version, true);

		wp_enqueue_script($this->plugin_name . '_google_places', "https://maps.googleapis.com/maps/api/js?key={$api_key}&libraries=places", array('jquery'), $this->version, true);
		wp_enqueue_script($this->plugin_name . '_chosen_js_public', plugin_dir_url(__FILE__) . 'js/chosen.jquery.min.js', array('jquery'), $this->version, false);
		// wcmlim_ajax_add_to_cart
		wp_enqueue_script($this->plugin_name . '_add_to_cart_js', plugin_dir_url(__FILE__) . 'js/ajax-add-to-cart-min.js', array('jquery'), $this->version . rand(), true);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wcmlim-public-min.js', array('jquery'), $this->version . rand(), true);
		wp_enqueue_script($this->plugin_name.'-popup-js', plugin_dir_url(__FILE__) . 'js/wcmlim-popup-min.js', array('jquery'), $this->version . rand(), true);

		 if ( $isLocationsGroup == "on" ) {
			wp_enqueue_script($this->plugin_name . '_locator', plugin_dir_url(__FILE__) . 'js/wcmlim-locator-min.js', array('jquery'), $this->version . rand(), true);	
			if ($getdirection == 'on') {
				wp_enqueue_script($this->plugin_name.'_getdirlocationgroup', plugin_dir_url(__FILE__) . 'js/wcmlim-getdirlocationgroup-min.js', array('jquery'), $this->version . rand(), true);	
			}
		}
		if ($getdirection == 'on') {
			wp_enqueue_script($this->plugin_name.'_direction', plugin_dir_url(__FILE__) . 'js/wcmlim-getdirection-min.js', array('jquery'), $this->version . rand(), true);
		  }
		  if ($showNxtLoc == 'on' &&  $coordinates_calculator!='on') {
			wp_enqueue_script($this->plugin_name.'_direction', plugin_dir_url(__FILE__) . 'js/wcmlim-get-next-closest-location-min.js', array('jquery'), $this->version . rand(), true); 
		}

		wp_enqueue_script($this->plugin_name.'product_single_validation', plugin_dir_url(__FILE__) . 'js/wcmlim-product-single-validation-min.js', array('jquery'), $this->version . rand(), true);
		$backorder_for_locations = get_option('wcmlim_enable_backorder_for_locations');
		$specific_location = get_option('wcmlim_enable_specific_location');
		$hideDropdown = get_option('wcmlim_hide_show_location_dropdown');
		wp_localize_script($this->plugin_name, 'multi_inventory', array(
			"ajaxurl" => admin_url("admin-ajax.php"),
			"wc_currency" => get_woocommerce_currency_symbol(),
			"autodetect" => $autodetect,
			"stock_format" => $stock_display_format,
			"enable_price" => $enable_price,
			"specific_location" => $specific_location,
			"user_specific_location" => $uspecLoc,
			"show_location_selection" => $showLS,
			"instock" => $instock,
			"soldout" => $soldout,
			"nxtloc" => $showNxtLoc,
			"store_on_map_arr" => $store_on_map_arr,
			"store_on_map_prod_arr" => $store_on_map_prod_arr,
			"default_list_align" => $default_list_align,
			"default_origin_center" => $default_origin_center,
			"default_zoom" => $default_zoom,
			"setting_loc_dis_unit" => $setting_loc_dis_unit,
			"default_map_color" => $default_map_color,
			"widget_select_type" => $widget_select_type,
            "optiontype_loc" => $optiontype_loc,
            "scoptiontype_loc" => $scoptiontype_loc,
			"fulladd" => $fulladd,
			"viewformat" => $viewformat,
			'NextClosestinStock' => esc_html__('Next Closest in Stock', 'wcmlim'),			
			'away' => esc_html__('away', 'wcmlim'),
			'wchideoosproduct' => $wchideoosproduct,
			"isClearCart" => $isClearCart,
			"isdefault" => $isdefault,
			"isUserLoggedIn" => is_user_logged_in(),
			"loginURL" => get_permalink(get_option('woocommerce_myaccount_page_id')),
			"isUserAdmin" => $isAdmin,
			"resUserSLK" => $specificLocation,
			"isLocationsGroup" => $isLocationsGroup,
			"isBackorderOn" => $backorder_for_locations,
			"hideDropdown"=>  $hideDropdown,
			
		));
		/* fontawesome */
		wp_enqueue_script('wcmlim-fontawesome', "https://kit.fontawesome.com/82940a45e9.js", array('jquery'), $this->version, true);
		$advanceListView = get_option('wcmlim_radio_loc_format');
		$optiontype_loc = get_option('wcmlim_select_or_dropdown');
		if ($advanceListView == "advanced_list_view" && $optiontype_loc == 'on') {
			wp_enqueue_script($this->plugin_name. '_list_view_pro', plugin_dir_url(__FILE__) . 'js/wcmlim-advanced-list-view.js', array(), $this->version . rand(), 'all');
		}
	}
	public function enqueue_scripts_clear_cart()
	{
		$isClearCart = get_option('wcmlim_clear_cart');
		$autodetect = get_option('wcmlim_enable_autodetect_location');
		$enable_price     = get_option('wcmlim_enable_price');
		$uspecLoc = get_option('wcmlim_enable_userspecific_location');
		$showLS = get_option('wcmlim_show_location_selection');
		$instock     = get_option('wcmlim_instock_button_text');
		$soldout = get_option('wcmlim_soldout_button_text');
		$showNxtLoc = get_option("wcmlim_next_closest_location");
        $optiontype_loc = get_option('wcmlim_select_or_dropdown');		
        $scoptiontype_loc = get_option('wcmlim_listing_inline_location');		
		$fulladd = get_option('wcmlim_radio_loc_fulladdress');
		$viewformat = get_option('wcmlim_radio_loc_format');
		$default_origin_center = get_option('wcmlim_default_origin_center');
		$setting_loc_dis_unit = get_option("wcmlim_show_location_distance", true);
		$store_on_map_arr = get_option("store_on_map_arr");		
		$store_on_map_prod_arr = get_option("store_on_map_prod_arr");
		$default_list_align = get_option('wcmlim_default_list_align');
		$default_zoom = get_option('wcmlim_default_zoom');	
		$default_map_color = get_option('wcmlim_default_map_color');
		$wchideoosproduct = get_option("woocommerce_hide_out_of_stock_items");
		$isdefault   = get_option('wcmlim_enable_default_location');
		$stock_display_format = get_option('woocommerce_stock_format');		
		$cart_valid_message = get_option('wcmlim_valid_cart_message');
		$cart_valid_buttontxt = get_option('wcmlim_btn_cartclear');
		$popup_headtxt = get_option('wcmlim_cart_popup_heading');
		$popup_mssgtxt = get_option('wcmlim_cart_popup_message');
		$current_user_id = get_current_user_id();
		$isAdmin = current_user_can('administrator', $current_user_id);
		$getdirection = get_option('wcmlim_get_direction_for_location');
		$specificLocation = get_user_meta($current_user_id, 'wcmlim_user_specific_location', true);	
		$isLocationsGroup = get_option('wcmlim_enable_location_group');

		if ($isClearCart == 'on') {
			wp_enqueue_script('woocommerce-ajax-add-to-cart', plugin_dir_url(__FILE__) . 'js/clear-cart-min.js', array('jquery'), $this->version . rand(), true);
			wp_localize_script($this->plugin_name, 'multi_inventory', array(
				"ajaxurl" => admin_url("admin-ajax.php"),	
				"wc_currency" => get_woocommerce_currency_symbol(),			
				"autodetect" => $autodetect,
				"enable_price" => $enable_price,
				"user_specific_location" => $uspecLoc,
				"show_location_selection" => $showLS,
				"instock" => $instock,
				"soldout" => $soldout,
				"optiontype_loc" => $optiontype_loc,
				"scoptiontype_loc" => $scoptiontype_loc,
				"fulladd" => $fulladd,
				"viewformat" => $viewformat,
				'swal_cart_update_btn' => $cart_valid_buttontxt, 			
				'swal_cart_validation_message' => $cart_valid_message,
				'swal_cart_update_heading' => $popup_headtxt, 
				'swal_cart_update_message' => $popup_mssgtxt,
				"nxtloc" => $showNxtLoc,
				"default_origin_center" => $default_origin_center,
				"setting_loc_dis_unit" => $setting_loc_dis_unit,
				"store_on_map_arr" => $store_on_map_arr,
				"store_on_map_prod_arr" => $store_on_map_prod_arr,
				'away' => esc_html__('away', 'wcmlim'),
				"default_list_align" => $default_list_align,
				"default_zoom" => $default_zoom,
				"default_map_color" => $default_map_color,
				"wchideoosproduct" => $wchideoosproduct,
				"isClearCart" => $isClearCart,
				"NextClosestinStock" => esc_html__('Next Closest in Stock', 'wcmlim'),
				"isdefault" => $isdefault,
				"stock_format" => $stock_display_format,
				"isUserLoggedIn" => is_user_logged_in(),
				"loginURL" => get_permalink(get_option('woocommerce_myaccount_page_id')),
				"isUserAdmin" => $isAdmin,
				"resUserSLK" => $specificLocation,
				"isLocationsGroup" => $isLocationsGroup,
			));
		}
	}
       
	// Distance Matrix API to Display the Closest Location for the Product
	public function wcmlim_closest_location()
	{

		$coordinates_calculator      = get_option('wcmlim_distance_calculator_by_coordinates');
		if($coordinates_calculator != '')
        {
		
		$selectedLocationId = isset($_POST['selectedLocationId']) ? $_POST['selectedLocationId'] : false;
		$nearby_location = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
		$globalPincheck = isset($_POST['globalPin']) ? $_POST['globalPin'] : false;
		$product_id  = isset($_POST['product_id']) ? intval($_POST['product_id']) : "";
		$variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : "";
	
		if(!empty($variation_id))
		{
			$product_id = $variation_id;
		}	
		if (isset($_POST['postcode'])) {
			$ladd = str_replace(",", "", $_POST['postcode']);
			$origins = str_replace(" ", "+", $ladd);
		}
		$dis_unit = get_option("wcmlim_show_location_distance", true);


		$lat = isset($_POST['lat']) ? $_POST['lat'] : "";
		$lng = isset($_POST['lng']) ? $_POST['lng'] : "";

		$isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($isExcLoc)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		 if (isset($product_id) && !$globalPincheck) {
		$product = wc_get_product($product_id);
		 $backorder = $product->backorders_allowed();
		 }
		$google_api_key = get_option('wcmlim_google_api_key');
		// Check for the custom field value
		
		$sli = isset($_POST["selectedLocationId"]) ? $_POST["selectedLocationId"] : "";
		foreach ($terms as $in => $term) {
			$termid = $term->term_id;
			$postmeta_stock_at_term = get_post_meta($product_id, 'wcmlim_stock_at_' . $term->term_id, true);
			$streetNumber = get_term_meta($termid, 'wcmlim_street_number', true);
            $route = get_term_meta($termid, 'wcmlim_route', true);
            $locality = get_term_meta($termid, 'wcmlim_locality', true);
            $state = get_term_meta($termid, 'wcmlim_administrative_area_level_1', true);
            $postal_code = get_term_meta($termid, 'wcmlim_postal_code', true);
            $country = get_term_meta($termid, 'wcmlim_country', true);
			$loc_lat = get_term_meta( $termid, 'wcmlim_lat', true );
			$loc_lng = get_term_meta( $termid, 'wcmlim_lng', true );
		
            if ($streetNumber) {
                $streetNumber = $streetNumber . " ,";
            } else {
                $streetNumber = ' ';
            }
            if ($route) {
                $route = $route . " ,";
            } else {
                $route = ' ';
            }
            if ($locality) {
                $locality = $locality . " ,";
            } else {
                $locality = ' ';
            }
            if ($state) {
                $state = $state . " ,";
            } else {
                $state = ' ';
            }
            if ($postal_code) {
                $postal_code = $postal_code . " ,";
            } else {
                $postal_code = ' ';
            }
            if ($country) {
                $country = $country;
            } else {
                $country = ' ';
            }
            $address = $streetNumber . $route . $locality . $state . $postal_code . $country;
            $find_address = $streetNumber .'+'. $route .'+'. $locality .'+'. $state .'+'. $postal_code .'+'. $country;
			
			
           if(empty($loc_lat) || empty($loc_lng))
		   {
			$address = str_replace(' ', '+', $find_address);
			$address = str_replace(',', '+', $find_address);
			$getlatlng = wcmlim_get_lat_lng($address, $termid);
			$loc_lat = get_term_meta( $termid, 'wcmlim_lat', true );
			$loc_lng = get_term_meta( $termid, 'wcmlim_lng', true );
           }
		  
			if($selectedLocationId == $in)
			{
				$lat = $loc_lat;
				$lng = $loc_lng;
			}

		   $distance = distance_between_coordinates($lat, $lng, $loc_lat, $loc_lng);
		   $return_dis_unit = get_option("wcmlim_show_location_distance", true);
		   $return_dis_unit = $distance.' ' .$return_dis_unit;
		   if (!empty($postmeta_stock_at_term) || ($postmeta_stock_at_term > 0)) {
			$loc_tmp_arr[] = array(
				"key" => $in,
				"loc_id" => $termid,
				"loc_lat" => $loc_lat,
				"loc_lng" => $loc_lng,
				"distance" => $distance,
				"ret_distance" => $return_dis_unit,
				"address" => $address
			);
		}
		}
		
		//sort the array by distance
		function sortByDis($a, $b)
        {
            return $a['distance'] > $b['distance'];
        }
        usort($loc_tmp_arr, 'sortByDis');
		
		//get nearby loc id
		$nearby_first_loc_id = $loc_tmp_arr[0]['loc_id'];
		$nearby_first_loc_key = $loc_tmp_arr[0]['key'];
		$nearby_first_loc_ret_distance = $loc_tmp_arr[0]['ret_distance'];
		$nearby_second_loc_id = $loc_tmp_arr[1]['loc_id'];
		$nearby_second_loc_key = $loc_tmp_arr[1]['key'];
		$nearby_second_loc_ret_distance = $loc_tmp_arr[1]['ret_distance'];

			$first_streetNumber = get_term_meta($nearby_first_loc_id, 'wcmlim_street_number', true);
            $first_route = get_term_meta($nearby_first_loc_id, 'wcmlim_route', true);
            $first_locality = get_term_meta($nearby_first_loc_id, 'wcmlim_locality', true);
            $first_state = get_term_meta($nearby_first_loc_id, 'wcmlim_administrative_area_level_1', true);
            $first_postal_code = get_term_meta($nearby_first_loc_id, 'wcmlim_postal_code', true);
            $first_country = get_term_meta($nearby_first_loc_id, 'wcmlim_country', true);
			$first_loc_lat = get_term_meta( $nearby_first_loc_id, 'wcmlim_lat', true );
			$first_loc_lng = get_term_meta( $nearby_first_loc_id, 'wcmlim_lng', true );

		
			//bind the first location parameter
            if ($first_streetNumber) {
                $first_streetNumber = $first_streetNumber . " ,";
            } else {
                $first_streetNumber = ' ';
            }
            if ($first_route) {
                $first_route = $first_route . " ,";
            } else {
                $first_route = ' ';
            }
            if ($first_locality) {
                $first_locality = $first_locality . " ,";
            } else {
                $first_locality = ' ';
            }
            if ($first_state) {
                $first_state = $first_state . " ,";
            } else {
                $first_state = ' ';
            }
            if ($first_postal_code) {
                $first_postal_code = $first_postal_code . " ,";
            } else {
                $first_postal_code = ' ';
            }
            if ($first_country) {
                $first_country = $first_country;
            } else {
                $first_country = ' ';
            }
            $first_address = $first_streetNumber . $first_route . $first_locality . $first_state . $first_postal_code . $first_country;
			
			$second_streetNumber = get_term_meta($nearby_second_loc_id, 'wcmlim_street_number', true);
            $second_route = get_term_meta($nearby_second_loc_id, 'wcmlim_route', true);
            $second_locality = get_term_meta($nearby_second_loc_id, 'wcmlim_locality', true);
            $second_state = get_term_meta($nearby_second_loc_id, 'wcmlim_administrative_area_level_1', true);
            $second_postal_code = get_term_meta($nearby_second_loc_id, 'wcmlim_postal_code', true);
            $second_country = get_term_meta($nearby_second_loc_id, 'wcmlim_country', true);
			$second_loc_lat = get_term_meta( $nearby_second_loc_id, 'wcmlim_lat', true );
			$second_loc_lng = get_term_meta( $nearby_second_loc_id, 'wcmlim_lng', true );

			//bind the second location parameter
			if ($second_streetNumber) {
				$second_streetNumber = $second_streetNumber . " ,";
			} else {
				$second_streetNumber = ' ';
			}
			if ($second_route) {
				$second_route = $second_route . " ,";
			} else {
				$second_route = ' ';
			}
			if ($second_locality) {
				$second_locality = $second_locality . " ,";
			} else {
				$second_locality = ' ';
			}
			if ($second_state) {
				$second_state = $second_state . " ,";
			} else {
				$second_state = ' ';
			}
			if ($second_postal_code) {
				$second_postal_code = $second_postal_code . " ,";
			} else {
				$second_postal_code = ' ';
			}
			if ($second_country) {
				$second_country = $second_country;
			} else {
				$second_country = ' ';
			}
			$second_address = $second_streetNumber . $second_route . $second_locality . $second_state . $second_postal_code . $second_country;
		
			
		if (isset($__seleOrigin[0])) {
			$origins = $__seleOrigin[0];
		}
		$nearby_location = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
		$res = array(
			"status"=> "true",
			"globalpin"=> "true",
			"loc_address"=> $first_address,
			"loc_key"=> $nearby_first_loc_key,
			"loc_dis_unit"=> $nearby_first_loc_ret_distance,
			"secNearLocAddress"=> $second_address,
			"secNearStoreDisUnit"=> $nearby_second_loc_ret_distance,
			"secNearLocKey"=> $nearby_second_loc_key,
			"cookie"=> $nearby_location		
		);
		echo json_encode($res);
        die();
			
		}
		else
		{
			$nearby_location = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
		$globalPincheck = isset($_POST['globalPin']) ? $_POST['globalPin'] : false;
		$product_id  = isset($_POST['product_id']) ? intval($_POST['product_id']) : "";
		$variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : "";
		
		if(empty($product_id) && empty($variation_id))
		{
                $response_array["message"] = esc_html('Not found any Product Id.', 'wcmlim');
                $response_array["status"] = "false";
		}
		
		if (isset($_POST['postcode'])) {
			$ladd = str_replace(",", "", $_POST['postcode']);
			$origins = str_replace(" ", "+", $ladd);
		}
		$dis_unit = get_option("wcmlim_show_location_distance", true);
		$lat = isset($_POST['lat']) ? $_POST['lat'] : "";
		$lng = isset($_POST['lng']) ? $_POST['lng'] : "";

		$isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($isExcLoc)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		
		$product = wc_get_product($product_id);
		
		$google_api_key = get_option('wcmlim_google_api_key');
		// Check for the custom field value
		$sli = isset($_POST["selectedLocationId"]) ? $_POST["selectedLocationId"] : "";
		foreach ($terms as $in => $term) {
			if ($sli != '') {
				if ($in == $sli) {
					$term_meta = get_option("taxonomy_$term->term_id");
					$term_meta = array_map(function ($term) {
						if (!is_array($term)) {
							return $term;
						}
					}, $term_meta);
					$__spare = implode(" ", array_filter($term_meta));
					$__seleOrigin[] = str_replace(" ", "+", $__spare);
				}
			}
			$term_meta = get_option("taxonomy_$term->term_id");
			$term_meta = array_map(function ($term) {
				if (!is_array($term)) {
					return $term;
				}
			}, $term_meta);
			$spacead = implode(" ", array_filter($term_meta));
			$dest[] = str_replace(" ", "+", $spacead);

			$allterm_names[] = $term->name;
			$postcode[] = isset($term_meta['wcmlim_postcode']) ? $term_meta['wcmlim_postcode'] : "";
			$wcountry[] = isset($term_meta['wcmlim_country_state']) ? $term_meta['wcmlim_country_state'] : "";
		}
		if (isset($__seleOrigin[0])) {
			$origins = $__seleOrigin[0];
		}
		
		
        $destcount = count($dest);
		if ( $destcount <= 20 ) 
            {
            $destination = implode("|", $dest);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $destination . "&key={$google_api_key}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            $response_arr = json_decode($response);
			
            curl_close($curl);
            if (isset($response_arr->error_message)) {
                $response_array["message"] = $response_arr->error_message;
                $response_array["status"] = "false";
                echo json_encode($response_array);
                die();
            }

            foreach ($response_arr->rows as $r => $t) {
                foreach ($t as $key => $value) {
                    foreach ($value as $a => $b) {
                        if ($b->status == "OK") {
                            $dis = explode(" ", $b->distance->text);
							
                            $plaindis = str_replace(',', '', $dis[0]);
                            if ($dis_unit == "kms") {
                                $dis_in_un = $b->distance->text;
                            } elseif ($dis_unit == "miles") {
                                $dis_in_un = round($plaindis * 0.621, 1) . ' miles';
                            } elseif ($dis_unit == "none") {
                                $dis_in_un = $b->distance->text;
                            }
							$isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
							//prepare terms
							if (!empty($isExcLoc)) {
							  $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
							} else {
							  $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
							}
							
							if(isset($_POST['product_id']))
								{
									
							foreach ($terms as $in => $term) {
								if($a == $in)
								{
									   if (!empty($variation_id)) {
										   $postmeta_stock_at_term = get_post_meta($variation_id, 'wcmlim_stock_at_' . $term->term_id, true);
										   $postmeta_backorders_product = get_post_meta($variation_id, '_backorders', true);
									   }else {
										$postmeta_stock_at_term = get_post_meta($product_id, 'wcmlim_stock_at_' . $term->term_id, true);
										$postmeta_backorders_product = get_post_meta($product_id, '_backorders', true);
									}
									if(((!empty($postmeta_stock_at_term)) && ($postmeta_stock_at_term != 0)) || ($postmeta_backorders_product == 'yes'))
									{
										$distance[] = array("value" => $plaindis, "key" => $a, "plaindis" => $plaindis, "dis_in_un" => $dis_in_un);
									}
								}
							}
							}
							else
							{
								$distance[] = array("value" => $plaindis, "key" => $a, "plaindis" => $plaindis, "dis_in_un" => $dis_in_un);
							}
                            if ($first_route) {
								$first_route = $first_route . " ,";
							} else {
								$first_route = ' ';
							}
				
                        }
                    }
                }
            }
			if(isset($distance)){
				$dis_in_unit = (is_array($distance)) ? min($distance)['dis_in_unit'] : '';
            	$dis_key = (is_array($distance)) ? min($distance)['key'] : '';
			}
            foreach ($response_arr->destination_addresses as $k => $v) {
                if ($k == $dis_key) {
                    $lcAdd = str_replace(",", "", $v);
                    if ($lcAdd) {
                        // getting second nearest location
                        $secNLocation = $this->getSecondNearestLocation($distance, $dis_unit, $product_id);
						$serviceRadius = $this->getLocationServiceRadius($dis_key);
						$groupID =$this->getLocationgroupID($dis_key);
						if(empty($secNLocation[0]))
						{
							$secNearLocAddress = $lcAdd;
							$secNearLocKey = $dis_key;
							$secNearStoreDisUnit = $dis_in_unit;

						}
						else
						{
							$secNearLocAddress =  $secNLocation[0];
							$secNearLocKey = $secNLocation[2];
							$secNearStoreDisUnit = isset($secNLocation[1]) ? $secNLocation[1] : "";
						}

                        $response_array["status"] = "true";
                        $response_array["globalpin"] = "true";
                        $response_array["loc_address"] = $lcAdd;
                        $response_array['loc_key'] = $dis_key;
                        $response_array['loc_dis_unit'] = $dis_in_unit;
                        $response_array["secNearLocAddress"] = $secNearLocAddress;
                        $response_array['secNearStoreDisUnit'] = $secNearStoreDisUnit;
                        $response_array['secNearLocKey'] = $secNearLocKey;
						$response_array["cookie"] = $nearby_location;
						$response_array["secgrouploc"] = $groupID;

						
						if(isset($serviceRadius)){
							$response_array['locServiceRadius'] = $serviceRadius;
						}
                        if (isset($ladd)) {
                            setcookie("wcmlim_nearby_location", $ladd, time() + 36000, '/');
                        }
                        update_option('wcmlim_location_distance', $dis_in_unit);
                        echo json_encode($response_array);
                        wp_die();
                    };
                }
            }
            if (empty($terms)) {
                $response_array["message"] = _e('Not found any location.', 'wcmlim');
                $response_array["status"] = "false";
				$response_array["cookie"] = $nearby_location;
                echo json_encode($response_array);
                die();
            }
            die();
        } else {

			
            $nodes = array_chunk($dest, 20);
			$node_count = count($nodes);
			$curl_arr = array();
			$master = curl_multi_init();			
			for($i = 0; $i < $node_count; $i++)
			{
				$url = $nodes[$i];
				$destination[$i] = implode("|", $url);						
				$curl_arr[$i] = curl_init();
			
				
				curl_setopt_array($curl_arr[$i], array(
					CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $destination[$i] . "&key={$google_api_key}",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
				));
				curl_multi_add_handle($master, $curl_arr[$i]);				
				
			}

			$running = NULL;
			do {
				usleep(10000);
				curl_multi_exec($master,$running);
			} while($running > 0); 					

			$responses = array();
			for($i = 0; $i < $node_count; $i++)
			{						
				$resp = curl_multi_getcontent($curl_arr[$i]);	
				array_push($responses, json_decode($resp));	
			} 
			// all of our requests are done, we can now access the results
			for($i = 0; $i < $node_count; $i++)
			{
				curl_multi_remove_handle($master, $curl_arr[$i]);						
			}
			curl_multi_close($master);

			for($i = 0; $i < $node_count; $i++)
			{
				if (isset($responses[$i]->error_message)) {
					$response_array["message"] = $response_arr[$i]->error_message;
					$response_array["status"] = "false";
					$response_array["cookie"] = $nearby_location;
					echo json_encode($response_array);
					die();
				}
				foreach ($responses[$i]->rows as $r => $t) {
					foreach ($t as $key => $value) {
						foreach ($value as $a => $b) {
							if ($b->status == "OK") {
								$dis = explode(" ", $b->distance->text);
								$plaindis = str_replace(',', '', $dis[0]);
								if ($dis_unit == "kms") {
									$dis_in_un = $b->distance->text;
								} elseif ($dis_unit == "miles") {
									$dis_in_un = round($plaindis * 0.621, 1) . ' miles';
								} elseif ($dis_unit == "none") {
									$dis_in_un = $b->distance->text;
								}
								$loc_id = $terms[$a]->term_id;
							if(!empty($variation_id) && ($variation_id != 0))
							{
								$loc_stock = get_post_meta($variation_id, "wcmlim_stock_at_{$loc_id}", true);
							}
							else
							{
								$loc_stock = get_post_meta($product_id, "wcmlim_stock_at_{$loc_id}", true);
							}								
							if(($loc_stock != '') && ($loc_stock != '0'))
							{
								$distance[] = array("value" => $plaindis, "key" => $a, "dis_in_un" => $dis_in_un, "loc_id" => $terms[$a]->term_id, "loc_stock" => $loc_stock);
							}
						}
					}
				}
			}
			$dis_in_unit = (is_array($distance)) ? min($distance)['plaindis'] : '';
				$dis_key = (is_array($distance)) ? min($distance)['key'] : '';
				foreach ($responses[$i]->destination_addresses as $k => $v) {
					if ($k == $dis_key) {
						$lcAdd = str_replace(",", "", $v);
						if ($lcAdd) {
							// getting second nearest location
							$secNLocation = $this->getSecondNearestLocation($distance, $dis_unit, $product_id);
							$response_array["status"] = "true";
							$response_array["globalpin"] = "true";
							$response_array["loc_address"] = $lcAdd;
							$response_array['loc_key'] = $dis_key;
							$response_array['loc_dis_unit'] = $dis_in_unit;
							$response_array["secNearLocAddress"] = $secNLocation[0];
							$response_array['secNearStoreDisUnit'] = isset($secNLocation[1]) ? $secNLocation[1] : "";
							$response_array['secNearLocKey'] = $secNLocation[2];
							$response_array["cookie"] = $nearby_location;
							if (isset($ladd)) {
								setcookie("wcmlim_nearby_location", $ladd, time() + 36000, '/');
							}
							update_option('wcmlim_location_distance', $dis_in_unit);
							echo json_encode($response_array);
							wp_die();
						};
					}
				}	
								
			}//foreach
			if (empty($terms)) {
				$response_array["message"] = _e('Not found any location.', 'wcmlim');
				$response_array["status"] = "false";
				$response_array["cookie"] = $nearby_location;
				echo json_encode($response_array);
				die();
			}			
			die();
			
        }

		}

	}
	public function wcmlim_closest_instock_location()
	{


		$nearby_location = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
	  $product_id  = isset($_POST['product_id']) ? intval($_POST['product_id']) : "";
	  $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : "";
	  if(empty($product_id) && !empty($variation_id)){
		$product_id = $variation_id ;
	  }
	  $dis_unit = get_option("wcmlim_show_location_distance", true);
	  $isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
	  if (!empty($isExcLoc)) {
		$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
	  } else {
		$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
	  }
	  
	  $product = wc_get_product($product_id);
	  
	  $google_api_key = get_option('wcmlim_google_api_key');
	  // Check for the custom field value
	  $sli = isset($_POST["selectedLocationId"]) ? $_POST["selectedLocationId"] : "";
	  foreach ($terms as $in => $term) {
		if ($sli != '') {
		  if ($in == $sli) {
			$term_meta = get_option("taxonomy_$term->term_id");
			$term_meta = array_map(function ($term) {
			  if (!is_array($term)) {
				return $term;
			  }
			}, $term_meta);
			$__spare = implode(" ", array_filter($term_meta));
			$__seleOrigin[] = str_replace(" ", "+", $__spare);
		  }
		}
		$term_meta = get_option("taxonomy_$term->term_id");
		$term_meta = array_map(function ($term) {
		  if (!is_array($term)) {
			return $term;
		  }
		}, $term_meta);
		$spacead = implode(" ", array_filter($term_meta));
		$dest[] = str_replace(" ", "+", $spacead);
  
		$allterm_names[] = $term->name;
		$postcode[] = isset($term_meta['wcmlim_postcode']) ? $term_meta['wcmlim_postcode'] : "";
		$wcountry[] = isset($term_meta['wcmlim_country_state']) ? $term_meta['wcmlim_country_state'] : "";
	  }
	  if (isset($__seleOrigin[0])) {
		$origins = $__seleOrigin[0];
	  }
		  $destcount = count($dest);
	  if ( $destcount <= 20 ) 
			  {
			  $destination = implode("|", $dest);
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $destination . "&key={$google_api_key}",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
			  ));

			  $response = curl_exec($curl);
			  $response_arr = json_decode($response);
		
			  curl_close($curl);
			  if (isset($response_arr->error_message)) {
				  $response_array["message"] = $response_arr->error_message;
				  $response_array["status"] = "false";
				  echo json_encode($response_array);
				  die();
			  }

			  foreach ($response_arr->rows as $r => $t) {
				  foreach ($t as $key => $value) {
					  foreach ($value as $a => $b) {
						  if ($b->status == "OK") {
							   $dis = explode(" ", $b->distance->text);
							   $plaindis = str_replace(',', '', $dis[0]);
							  if ($dis_unit == "kms") {
								  $dis_in_un = $b->distance->text;
							  } elseif ($dis_unit == "miles") {
								  $dis_in_un = round($plaindis * 0.621, 1) . ' miles';
							  } elseif ($dis_unit == "none") {
								  $dis_in_un = $b->distance->text;
							  }
				$isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");

				if (!empty($isExcLoc)) {
				  $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
				} else {
				  $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
				}
				
				if(isset($_POST['product_id']) || isset($_POST['variation_id']))
				  {
					
				foreach ($terms as $in => $term) {
				  if($a == $in)
				  {
					   if (!empty($variation_id)) {
						 $postmeta_stock_at_term = get_post_meta($variation_id, 'wcmlim_stock_at_' . $term->term_id, true);
						 $postmeta_backorders_product = get_post_meta($variation_id, '_backorders', true);
					   }else {
					  $postmeta_stock_at_term = get_post_meta($product_id, 'wcmlim_stock_at_' . $term->term_id, true);
					  $postmeta_backorders_product = get_post_meta($product_id, '_backorders', true);
					}
					if(((!empty($postmeta_stock_at_term)) && ($postmeta_stock_at_term != 0)) || ($postmeta_backorders_product == 'yes'))
					{
					  $distance[] = array("value" => $plaindis, "key" => $a, "plaindis" => $plaindis, "dis_in_un" => $dis_in_un);
					}
				  }
				}
				}
				else
				{
				  $distance[] = array("value" => $plaindis, "key" => $a, "plaindis" => $plaindis, "dis_in_un" => $dis_in_un);
				}
							  if ($first_route) {
				  $first_route = $first_route . " ,";
				} else {
				  $first_route = ' ';
				}
		  
						  }
					  }
				  }
			  }
		if(isset($distance)){
		  $dis_in_unit = (is_array($distance)) ? min($distance)['dis_in_un'] : '';
				$dis_key = (is_array($distance)) ? min($distance)['key'] : '';
		}
			  foreach ($response_arr->destination_addresses as $k => $v) {
				  if ($k == $dis_key) {
					  $lcAdd = str_replace(",", "", $v);
					  if ($lcAdd) {
						  // getting second nearest location
						  $secNLocation = $this->getSecondNearestLocation($distance, $dis_unit, $product_id);
			  $serviceRadius = $this->getLocationServiceRadius($dis_key);
			  $groupID =$this->getLocationgroupID($dis_key);
			  if(empty($secNLocation[0]))
			  {
				$secNearLocAddress = $lcAdd;
				$secNearLocKey = $dis_key;
				$secNearStoreDisUnit = $dis_in_unit;
  
			  }
			  else
			  {
				$secNearLocAddress =  $secNLocation[0];
				$secNearLocKey = $secNLocation[2];
				$secNearStoreDisUnit = isset($secNLocation[1]) ? $secNLocation[1] : "";
			  }
  
						  $response_array["status"] = "true";
						  $response_array["globalpin"] = "true";
						  $response_array["loc_address"] = $lcAdd;
						  $response_array['loc_key'] = $dis_key;
						  $response_array['loc_dis_unit'] = $dis_in_unit;
						  $response_array["secNearLocAddress"] = $secNearLocAddress;
						  $response_array['secNearStoreDisUnit'] = $secNearStoreDisUnit;
						  $response_array['secNearLocKey'] = $secNearLocKey;
			  			  $response_array["cookie"] = $nearby_location;
			  			  $response_array["secgrouploc"] = $groupID;
  
			  
							if(isset($serviceRadius)){
								$response_array['locServiceRadius'] = $serviceRadius;
							}
						  if (isset($ladd)) {
							  setcookie("wcmlim_nearby_location", $ladd, time() + 36000, '/');
						  }
						  update_option('wcmlim_location_distance', $dis_in_unit);
						  echo json_encode($response_array);
						  wp_die();
					  };
				  }
			  }
			  if (empty($terms)) {
				  $response_array["message"] = _e('Not found any location.', 'wcmlim');
				  $response_array["status"] = "false";
		  $response_array["cookie"] = $nearby_location;
				  echo json_encode($response_array);
				  die();
			  }
			  die();
		  } else {
  
		
			  $nodes = array_chunk($dest, 20);
		$node_count = count($nodes);
		$curl_arr = array();
		$master = curl_multi_init();      
		for($i = 0; $i < $node_count; $i++)
		{
		  $url = $nodes[$i];
		  $destination[$i] = implode("|", $url);            
		  $curl_arr[$i] = curl_init();
		
		  
		  curl_setopt_array($curl_arr[$i], array(
			CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $destination[$i] . "&key={$google_api_key}",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		  ));
		  curl_multi_add_handle($master, $curl_arr[$i]);        
		  
		}
  
		$running = NULL;
		do {
		  usleep(10000);
		  curl_multi_exec($master,$running);
		} while($running > 0);          
  
		$responses = array();
		for($i = 0; $i < $node_count; $i++)
		{           
		  $resp = curl_multi_getcontent($curl_arr[$i]); 
		  array_push($responses, json_decode($resp)); 
		} 
		// all of our requests are done, we can now access the results
		for($i = 0; $i < $node_count; $i++)
		{
		  curl_multi_remove_handle($master, $curl_arr[$i]);           
		}
		curl_multi_close($master);
  
		for($i = 0; $i < $node_count; $i++)
		{
		  if (isset($responses[$i]->error_message)) {
			$response_array["message"] = $response_arr[$i]->error_message;
			$response_array["status"] = "false";
			$response_array["cookie"] = $nearby_location;
			echo json_encode($response_array);
			die();
		  }
		  foreach ($responses[$i]->rows as $r => $t) {
			foreach ($t as $key => $value) {
			  foreach ($value as $a => $b) {
				if ($b->status == "OK") {
				  $dis = explode(" ", $b->distance->text);
				  $plaindis = str_replace(',', '', $dis[0]);
				  if ($dis_unit == "kms") {
					$dis_in_un = $b->distance->text;
				  } elseif ($dis_unit == "miles") {
					$dis_in_un = round($plaindis * 0.621, 1) . ' miles';
				  } elseif ($dis_unit == "none") {
					$dis_in_un = $b->distance->text;
				  }
				  $loc_id = $terms[$a]->term_id;
				if(!empty($variation_id) && ($variation_id != 0))
				{
				  $loc_stock = get_post_meta($variation_id, "wcmlim_stock_at_{$loc_id}", true);
				}
				else
				{
				  $loc_stock = get_post_meta($product_id, "wcmlim_stock_at_{$loc_id}", true);
				}               
				if(($loc_stock != '') && ($loc_stock != '0'))
				{
				  $distance[] = array("value" => $plaindis, "key" => $a, "dis_in_un" => $dis_in_un, "loc_id" => $terms[$a]->term_id, "loc_stock" => $loc_stock);
				}
			  }
			}
		  }
		}
		$dis_in_unit = (is_array($distance)) ? min($distance)['plaindis'] : '';
		  $dis_key = (is_array($distance)) ? min($distance)['key'] : '';
		  foreach ($responses[$i]->destination_addresses as $k => $v) {
			if ($k == $dis_key) {
			  $lcAdd = str_replace(",", "", $v);
			  if ($lcAdd) {
				// getting second nearest location
				$secNLocation = $this->getSecondNearestLocation($distance, $dis_unit, $product_id);
				$response_array["status"] = "true";
				$response_array["globalpin"] = "true";
				$response_array["loc_address"] = $lcAdd;
				$response_array['loc_key'] = $dis_key;
				$response_array['loc_dis_unit'] = $dis_in_unit;
				$response_array["secNearLocAddress"] = $secNLocation[0];
				$response_array['secNearStoreDisUnit'] = isset($secNLocation[1]) ? $secNLocation[1] : "";
				$response_array['secNearLocKey'] = $secNLocation[2];
				$response_array["cookie"] = $nearby_location;
				if (isset($ladd)) {
				  setcookie("wcmlim_nearby_location", $ladd, time() + 36000, '/');
				}
				update_option('wcmlim_location_distance', $dis_in_unit);
				echo json_encode($response_array);
				wp_die();
			  };
			}
		  } 
				  
		}//foreach
		if (empty($terms)) {
		  $response_array["message"] = _e('Not found any location.', 'wcmlim');
		  $response_array["status"] = "false";
		  $response_array["cookie"] = $nearby_location;
		  echo json_encode($response_array);
		  die();
		}     
		die();
		
		  }
  
	}
	public function getLocationgroupID($distanceKey){
		$ExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($ExcLoc)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $ExcLoc));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		
		foreach ($terms as $key => $value) {
			if($distanceKey == $key){
				$_groupLocators = 	get_term_meta( $value->term_id, 'wcmlim_locator', true );
			}
		}
		return $_groupLocators;
	}
	public function getLocationServiceRadius($distanceKey){
		$ExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($ExcLoc)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $ExcLoc));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		
		foreach ($terms as $key => $value) {
			if($distanceKey == $key){
				$_locRadius = 	get_term_meta( $value->term_id, 'wcmlim_service_radius_for_location', true );
			}
		}
		return $_locRadius;
	}

	public function getSecondNearestLocation($addresses, $dis_unit, $product_id)
	{
		
		$ExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($ExcLoc)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $ExcLoc));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		$addresses = array();
		$dnumber = array();
		foreach ($addresses as $ad) {
			$dnumber[] = $ad["value"];
		}
		sort($dnumber, SORT_NUMERIC);
		$smallest = array_shift($dnumber);
		$smallest_2nd = array_shift($dnumber);
		foreach ($addresses as $e => $v) {
			if ($smallest_2nd == $v["value"]) {
				$finalKeyOfLocation = $e;
			}
		}
		$secondNearLocKey = isset($finalKeyOfLocation) ? $finalKeyOfLocation : "";
		


		foreach ($terms as $index => $term) {
				if ($index == $secondNearLocKey) {
					$secNearStore[] = $term->name;
				}
		}

		foreach ($addresses as $k => $address) {
			if ($secondNearLocKey == $k) {
				if ($dis_unit == "kms") {
					$dis_in_un = $address["dis_in_un"];
				} elseif ($dis_unit == "miles") {
					$dis_in_un = round($address["value"] * 0.621, 1) . ' miles';
				} elseif ($dis_unit == "none") {
					$dis_in_un = $address["dis_in_un"];
				}
				$secNearStore[] = $dis_in_un;
			}
		}
		$secNearStore[] = $secondNearLocKey;
		return $secNearStore;
	}

	public function checkLocInstockOrNot($locIndex, $terms, $product_id)
	{
		foreach ($terms as $p => $term) {
			if ($p == $locIndex) {
				$quanAtLocation = get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true);
			}
		}

		if (empty($quanAtLocation) || $quanAtLocation == 0) {
			$locStockStatus = "outofstock";
		} else {
			$locStockStatus = "instock";
		}
		return $locStockStatus;
	}

	public function wcmlim_empty_cart_content()
	{
		global $woocommerce;
		$updated_term_id = $_POST['loc_id'];
		$product_id = (isset($_POST['product_id'])) ? $_POST['product_id'] : '';

		$cookieindays = get_option('wcmlim_set_location_cookie_time');
		$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		$woocommerce->cart->empty_cart();

		foreach($locations as $key=>$term){
		if($key == $updated_term_id){
			$match_term_id = $term->term_id;
			setcookie("wcmlim_selected_location_termid", $match_term_id, time() + (86400 * $cookieindays), "/");
			setcookie("wcmlim_selected_location", $updated_term_id, time() + (86400 * $cookieindays), "/");
			if(!empty($product_id))
			{
				$loc_stock_pid = get_post_meta($product_id, "wcmlim_stock_at_{$match_term_id}", true);
				$postmeta_backorders_product = get_post_meta($product_id, '_backorders', true);
				if(($loc_stock_pid > 0) || ($postmeta_backorders_product=='yes'))
				{
				$_location_data = array();
				$_location_data['select_location']['location_name'] = $term->name;
				$_location_data['select_location']['location_key'] = (int)$key;
				$_location_data['select_location']['location_qty'] = 1;
				$_location_data['select_location']['location_termId'] = $match_term_id;
				$location_id = $match_term_id;										
				$stock_regular_price = get_post_meta($product_id, "regular_price", true);
				$pml_product = wc_get_product( $product_id );
				$price = $pml_product->get_price();
			
				$_isrspon = get_option("wcmlim_enable_price");
				if ($wcmlim_enable_price == 'on') {
					$loc_stock_pid = get_post_meta($product_id, "wcmlim_stock_at_{$location_id}", true);
					$stock_wcmlim_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$location_id}", true);
					$stock_wcmlim_stock_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$location_id}", true);
					if((!empty($stock_wcmlim_stock_sale_price)))
					{
						$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($stock_wcmlim_stock_sale_price)));
	
					}
					elseif(($stock_wcmlim_regular_price != 0 && $stock_wcmlim_stock_sale_price == 0) || ($stock_wcmlim_regular_price != '' && $stock_wcmlim_stock_sale_price == ''))
					{
						$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($stock_wcmlim_regular_price)));
	
					}
					elseif(($stock_wcmlim_regular_price == 0 && $stock_wcmlim_stock_sale_price == 0) || ($stock_wcmlim_regular_price == '' && $stock_wcmlim_stock_sale_price == ''))
					{
						$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($price)));
					}
					else
					{
						$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($price)));
					}
			}
			else
			{
				$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($price)));
			}
				
				  WC()->cart->add_to_cart($product_id, 1, '0', array(), $_location_data);
		}
			}
			
		}
	}

	}

	public function action_woocommerce_cart_item_removed( $cart_item_key, $instance ) { 
		global $woocommerce;
		$cart_count = $woocommerce->cart->get_cart_total();
		if($cart_count != 0)
		{
			unset($_COOKIE['wcmlim_selected_location']);
		}
	}

	public function action_woocommerce_add_tax_each_location($cart) {
		global $woocommerce;
		foreach ( $cart->get_cart() as $cart_item ) {  
             $product_id = $cart_item['data']->get_id();
		   $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false));
		   $wcmlim_tax_location = array();
		   foreach ($terms as $term) {
			$term_id = $term->term_id;
			if(isset($cart_item['select_location']['location_termId']))
			{
				$l_id = $cart_item['select_location']['location_termId'];
			}
			else
			{
				$req_lc_id = $_REQUEST['select_location'];
				$isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
				if (!empty($isExcLoc)) {
					$In_terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
				} else {
					$In_terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
				}
				foreach ($In_terms as $In_terms_key => $In_terms_term) {
					if($In_terms_key == $req_lc_id)
					{
						$l_id = $In_terms_term->term_id;
					}
				}				
			}
		$wcmlim_tax_location = get_term_meta($l_id, 'wcmlim_tax_locations',true);
		$cart_subtotal = WC()->cart->get_subtotal();
		$all_tax_rates = [];
		$tax_classes = WC_Tax::get_tax_classes(); // Retrieve all tax classes.
		if ( !in_array( '', $tax_classes ) ) { // Make sure "Standard rate" (empty class name) is present.
			array_unshift( $tax_classes, '' );
		}
		foreach ( $tax_classes as $tax_class ) { // For each tax class, get all rates.
			$taxes = WC_Tax::get_rates_for_tax_class( $tax_class );
			$all_tax_rates = array_merge( $all_tax_rates, $taxes );
		}
		foreach($all_tax_rates as $tax_key => $tax_value)
		{
			if (in_array($tax_value->tax_rate_id, $wcmlim_tax_location)) {
				$tax_name = $tax_value->tax_rate_name;
				$tax_rate = $tax_value->tax_rate;
				$tax_amunt_to_apply = ($tax_rate * $cart_subtotal ) / 100; 
				WC()->cart->add_fee($tax_name, $tax_amunt_to_apply);
			  }
		}
	  } 
	 }
	}
	/**
	 * Dropdown code startingpassedSoldbtn
	 *
	 */
	/**
	 * Dropdown code startingpassedSoldbtn
	 *
	 */
	public function wcmlim_display_location()
	{
		global $post;
		$hideDropdown = get_option('wcmlim_hide_show_location_dropdown');

			//for out of stock button text
		  $soldoutbuttontext = get_option("wcmlim_soldout_button_text");
		  $soldbtntext = array(
			'keys' => $soldoutbuttontext,
		  );
		  wp_localize_script( $this->plugin_name, 'passedSoldbtn', $soldbtntext );

		   //for In stock button text
		  
		   $instockbuttontext = get_option("wcmlim_instock_button_text");
		   $instobtntext = array(
			 'keys' => $instockbuttontext,
		   );
		   wp_localize_script( $this->plugin_name, 'passedinstockbtn', $instobtntext);
		   
		   //for Backorder button text

		   $backorderbuttontext = get_option("wcmlim_onbackorder_button_text");
		   $backbtntext = array(
			 'keys' => $backorderbuttontext,
		   );
		   wp_localize_script( $this->plugin_name, 'passedbackorderbtn', $backbtntext);

		$excludeLocations = get_option("wcmlim_exclude_locations_from_frontend");
		if (!empty($excludeLocations)) {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $excludeLocations));
		} else {
			$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
		}
		$preffLocation = (isset($_COOKIE['wcmlim_selected_location']) && $_COOKIE['wcmlim_selected_location'] != 'default') ? $_COOKIE['wcmlim_selected_location'] : false;
		$enable_price = get_option('wcmlim_enable_price');
		$hideDropdown = get_option('wcmlim_hide_show_location_dropdown');
		$stock_display_format = get_option('woocommerce_stock_format');
		/**Display setting option */
		$stockbox_color = get_option("wcmlim_preview_stock_bgcolor");
		$txt_stock_inf = get_option("wcmlim_txt_stock_info");
		$txtcolor_stock_inf = get_option("wcmlim_txtcolor_stock_info");
		$display_stock_inf = get_option("wcmlim_display_stock_info");
		$txt_preferred = get_option("wcmlim_txt_preferred_location");
		$txtcolor_preferred = get_option("wcmlim_txtcolor_preferred_loc");
		$display_preferred = get_option("wcmlim_display_preferred_loc");
		$txt_nearest = get_option("wcmlim_txt_nearest_stock_loc");
		$txtcolor_nearest = get_option("wcmlim_txtcolor_nearest_stock");
		$display_nearest = get_option("wcmlim_display_nearest_stock");
		$color_separator = get_option("wcmlim_separator_linecolor");
		$display_separator = get_option("wcmlim_display_separator_line");
		$oncheck_btntxt = get_option("wcmlim_oncheck_button_text");
		$oncheck_btnbgcolor = get_option("wcmlim_oncheck_button_color");
		$oncheck_btntxtcolor = get_option("wcmlim_oncheck_button_text_color");
		$soldout_btntxt = get_option("wcmlim_soldout_button_text");
		$soldout_btnbgcolor = get_option("wcmlim_soldout_button_color");
		$soldout_btntxtcolor = get_option("wcmlim_soldout_button_text_color");
		$instock_btntxt = get_option("wcmlim_instock_button_text");
		$instock_btnbgcolor = get_option("wcmlim_instock_button_color");
		$instock_btntxtcolor = get_option("wcmlim_instock_button_text_color");
		$border_option = get_option("wcmlim_preview_stock_borderoption");
		$border_color = get_option("wcmlim_preview_stock_bordercolor");
		$border_width = get_option("wcmlim_preview_stock_border");
		$border_radius = get_option("wcmlim_preview_stock_borderradius");
		$refborder_radius = get_option("wcmlim_refbox_borderradius");
		$input_radius = get_option("wcmlim_input_borderradius");
		$oncheck_radius = get_option("wcmlim_oncheck_borderradius");
		$instock_radius = get_option("wcmlim_instock_borderradius");
		$soldout_radius = get_option("wcmlim_soldout_borderradius");
		$showNxtLoc = get_option("wcmlim_next_closest_location");
		$boxwidth = get_option("wcmlim_preview_stock_width");
		$sel_padtop = get_option("wcmlim_sel_padding_top");
		$sel_padright = get_option("wcmlim_sel_padding_right");
		$sel_padbottom = get_option("wcmlim_sel_padding_bottom");
		$sel_padleft = get_option("wcmlim_sel_padding_left");
		$inp_padtop = get_option("wcmlim_inp_padding_top");
		$inp_padright = get_option("wcmlim_inp_padding_right");
		$inp_padbottom = get_option("wcmlim_inp_padding_bottom");
		$inp_padleft = get_option("wcmlim_inp_padding_left");
		$btn_padtop = get_option("wcmlim_btn_padding_top");
		$btn_padright = get_option("wcmlim_btn_padding_right");
		$btn_padbottom = get_option("wcmlim_btn_padding_bottom");
		$btn_padleft = get_option("wcmlim_btn_padding_left");
		$iconshow = get_option("wcmlim_display_icon");
		$icon_color = get_option("wcmlim_iconcolor_loc");
		$icon_size = get_option("wcmlim_iconsize_loc");
		$is_padtop = get_option("wcmlim_is_padding_top");
		$is_padbottom = get_option("wcmlim_is_padding_bottom");
		$is_padright = get_option("wcmlim_is_padding_right");
		$is_padleft = get_option("wcmlim_is_padding_left");
		$sbox_padtop = get_option("wcmlim_sbox_padding_top");
		$sbox_padbottom = get_option("wcmlim_sbox_padding_bottom");
		$sbox_padright = get_option("wcmlim_sbox_padding_right");
		$sbox_padleft = get_option("wcmlim_sbox_padding_left");
		$sbox_bgcolor = get_option("wcmlim_selbox_bgcolor");
        $optiontype_loc = get_option('wcmlim_select_or_dropdown');
		$product = wc_get_product($post->ID);
		$regprice = wc_price($product->get_price_html());
		$isLocationsGroup = get_option('wcmlim_enable_location_group'); 
		// Check for the custom field value
		foreach ($terms as $term) {
			if ($product instanceof WC_Product && $product->is_type('variable') && !$product->is_downloadable() && !$product->is_virtual()) {
				$variations = $product->get_available_variations();
				if (!empty($variations)) {
					foreach ($variations as $key => $value) {
						$check_taxanomy_variable =  get_post_meta($value['variation_id'], "wcmlim_stock_at_{$term->term_id}", true);
					}
				}
			} elseif ($product instanceof WC_Product && $product->is_type('simple') && !$product->is_downloadable() && !$product->is_virtual()) {
				$check_taxanomy = get_post_meta($post->ID, "wcmlim_stock_at_{$term->term_id}", true);
			}
		}

		if ($product instanceof WC_Product && $product->is_type('variable') && !$product->is_downloadable() && !$product->is_virtual()) {
			$variations = $product->get_available_variations();
			if (!empty($variations)) { 
				
				if ($hideDropdown == "on") {
					?>
					<style>
						.wcmlim_product
						{
							display:none !important;
						}
					</style>
					<?php
					}
					?>
				<div class="Wcmlim_container wcmlim_product">
					<div class="Wcmlim_box_wrapper">
						<div class="Wcmlim_box_content select_location-wrapper">
							<div class="Wcmlim_box_header">
								<h4 class="Wcmlim_box_title">
								<?php if ($hideDropdown != "on") { 
									if ($txt_stock_inf) {
										echo $txt_stock_inf;
									} else {
										_e('Stock Information', 'wcmlim');
									}
								 } ?>
								</h4>
							</div>
							<div class="Wcmlim_prefloc_box">
								<?php if ($hideDropdown == "on") { ?>
									<div class="loc_dd Wcmlim_prefloc_sel" style="display: none;">
									<?php } else { ?>
										<div class="loc_dd Wcmlim_prefloc_sel">
										<?php } ?>
										<label class="Wcmlim_sloc_label" for="select_location" style = "<?php if($display_preferred == 'on'){echo 'display:none';}?>"><?php if ($txt_preferred) {
																									echo $txt_preferred;
																								} else {
																									_e('Location: ', 'wcmlim');
																								} ?></label>
										<i class="wc_locmap fa fa-map-marker-alt" style="font-size: 18px;"></i>
										<?php if ($isLocationsGroup == 'on') { ?>
											<div class="wclim_select_location" style="display: inline-block;">
												<?php 
												echo do_shortcode( '[wcmlim_loc_storedropdown]' );												
												?>
											</div>
											<style>
											.loc_dd.Wcmlim_prefloc_sel .select_location {
												display: none !important;
											}
											</style>
											<select class="select_location" name="select_location" id="select_location">
										<?php } else { ?>
											<select class="select_location Wcmlim_sel_loc" name="select_location" id="select_location" required>
										<?php } ?>
											<option data-lc-qty="" value=""><?php echo esc_html('- Select Location -', 'wcmlim'); ?></option>
										</select>
										<?php if ($isLocationsGroup == null || $isLocationsGroup == false ) { ?>
											<!-- Radio Listing Mode -->
											<div class="wcmlradio_box rselect_location"></div>
											<div class="wc_scrolldown">
												<p>Scroll Location</p>
												<i class="fas fa-chevron-circle-down"></i>												
											</div>
										<?php } ?>
										</div><!-- Div loc_dd -->
									</div> <!-- Div Wcmlim_prefloc_box -->
									<?php
									$geolocation = get_option('wcmlim_geo_location');
									if ($geolocation == "on") : ?>
										<div class="postcode-checker">
											<p class="postcode-checker-title">
												<strong>
													<?php if ($txt_nearest) {
														echo $txt_nearest;
													} else {
														_e('Check your nearest stock location :', 'wcmlim');
													} ?>
												</strong>
											</p>
											<div class="postcode-checker-div postcode-checker-div-show">
												<?php
												$globpin = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
												$loc_dis_un = get_option('wcmlim_location_distance');
												?>
												<input type="text" placeholder="<?php _e('Enter Location', 'wcmlim'); ?>" class="class_post_code" name="post_code" value="<?php esc_html_e($globpin); ?>" id="elementId">
												
												<button class="button" type="button" id="submit_postcode_product" style="line-height: 1.4;border: 0;">
													<i class="fa fa-map-marker-alt"></i>
													<?php if ($oncheck_btntxt) {
														echo $oncheck_btntxt;
													} else {
														_e('Check', 'wcmlim');
													} ?>
												</button>
												<input type='hidden' name="global_postal_check" id='global-postal-check' value='true'>
												<input type='hidden' name="product_postal_location" id='product-postal-location' value='<?php esc_html_e($globpin); ?>'>
												<input type='hidden' name="product_location_distance" id='product-location-distance' value='<?php esc_html_e($loc_dis_un); ?>'>
											</div>
											<div class="search_rep" style="display: inline-flex;">
												<div class="postcode-checker-response"></div>
												<a class="postcode-checker-change postcode-checker-change-show" href="#" data-wpzc-form-open="" style="display: none;">
													<i class="fa fa-edit" aria-hidden="true"></i>
												</a>
											</div>
											<div class="Wcmlim_loc_label">
												<div class="Wcmlim_locadd">
													<div class="selected_location_detail"></div>
													<div class="postcode-location-distance"></div>
												</div>
												<div class="Wcmlim_locstock"></div>
											</div>
											<?php if ($showNxtLoc  == "on") { ?>
												<div class="Wcmlim_nextloc_label">
													<div class="Wcmlim_nextlocadd">
														<div class="next_closest_location_detail"></div>
													</div>
												</div>
											<?php } ?>
											<div class="Wcmlim_messageerror"></div>
										</div>
								<?php
									endif;
								}
							} elseif ($product instanceof WC_Product && $product->is_type('simple') && !$product->is_downloadable() && !$product->is_virtual()) {
								$productOnBackorder = $product->backorders_allowed();
								$product_id = $product->get_id();
								 $manage_stock = get_post_meta($product_id, '_manage_stock', true);
								$stock_status = get_post_meta($product_id, '_stock_status', true);
								if ($preffLocation) {
									foreach ($terms as $k => $term) {
										$stock_location_quantity = get_post_meta($post->ID, "wcmlim_stock_at_{$term->term_id}", true);
										$stock_regular_price = get_post_meta($post->ID, "wcmlim_regular_price_at_{$term->term_id}", true);
										$stock_sale_price = get_post_meta($post->ID, "wcmlim_sale_price_at_{$term->term_id}", true);

										if (isset($stock_location_quantity)) {
											if ($preffLocation == $k) {
												if ($stock_display_format == "no_amount") {
													echo '<p id="globMsg"> ' . __($instock_btntxt, 'wcmlim') . ' at <b>' . ucfirst($term->name) . '</b></p>';
												} elseif (empty($stock_display_format)) {
													echo '<p id="globMsg"><b> ' . $stock_location_quantity . ' </b> ' . __($instock_btntxt, 'wcmlim') . ' at <b>' . ucfirst($term->name) . '</b></p>';
												}
											}
										}
									}
								}
								if ($hideDropdown == "on" || $manage_stock == 'no' ){
								?>
								<style>
									.wcmlim_product
									{
										display:none !important;
									}
								</style>
								<?php
								}
								?>
								<div class="Wcmlim_container wcmlim_product">
									<div class="Wcmlim_box_wrapper">
										<div class="Wcmlim_box_content select_location-wrapper">
											<div class="Wcmlim_box_header">
												<h3 class="Wcmlim_box_title">
													<?php
													if ($hideDropdown != "on") {
														 if ($txt_stock_inf) {
														echo $txt_stock_inf;
													} else {
														_e('Stock Information', 'wcmlim');
													}
												 } ?>
												</h3>
											</div>
											<div class="Wcmlim_prefloc_box">
												<?php if ($hideDropdown == "on") { ?>
													<div class="loc_dd Wcmlim_prefloc_sel" style="display: none;">
													<?php } else { ?>
														<div class="loc_dd Wcmlim_prefloc_sel">
														<?php } ?>
														<label class="Wcmlim_sloc_label" for="select_location" style = "<?php if($display_preferred == 'on'){echo 'display:none';}?>">
															<?php if ($txt_preferred) {
																echo $txt_preferred;
															} else {
																_e('Location: ', 'wcmlim');
															} ?>
														</label>
														<i class="wc_locmap fa fa-map-marker-alt" style="font-size: 18px;"></i>
														<?php if ($isLocationsGroup == 'on') { ?>
														<div class="wclim_select_location" style="display: inline-block;">
															<?php 
															echo do_shortcode( '[wcmlim_loc_storedropdown]' );												
															?>
														</div>
														<style>
														.loc_dd.Wcmlim_prefloc_sel .select_location {
															display: none !important;
														}
														</style>
															<select class="select_location" name="select_location" id="select_location">
														<?php } else { ?>
															<select class="select_location Wcmlim_sel_loc" name="select_location" id="select_location" required>
														<?php } ?>												
														<option data-lc-qty="" data-lc-sale-price="" data-lc-regular-price="<?php esc_attr_e($regprice); ?>" value="-1"><?php echo esc_html('- Select Location -', 'wcmlim'); ?></option>
															
															<?php						
															
															foreach ($terms as $k => $term) {
																$isBackorderEnabled = get_post_meta($product_id, "wcmlim_allow_backorder_at_$term->term_id", true );
																$allow_backorder_each_location = get_option('wcmlim_enable_backorder_for_locations');
																
																$stock_location_quantity = get_post_meta($post->ID, "wcmlim_stock_at_{$term->term_id}", true);
																$stock_regular_price = get_post_meta($post->ID, "wcmlim_regular_price_at_{$term->term_id}", true);
																$stock_sale_price = get_post_meta($post->ID, "wcmlim_sale_price_at_{$term->term_id}", true);
																if($stock_regular_price == '' || $stock_regular_price == '0.00')
																{
																	$stock_regular_price = wc_price($product->get_regular_price());
																	$stock_sale_price = wc_price($product->get_sale_price());
																}
																$term_meta = get_option("taxonomy_$term->term_id");
																$rl = $this->wcmlim_get_loactionaddress($term->term_id);																if ($enable_price == "on") {
																	$price = "on";
																} else {
																	$price = "off";
																}
																$hide_out_of_stock_location   = get_option('wcmlim_hide_out_of_stock_location');
																$d_location   = get_option('wcmlim_enable_default_location');
																$selDefLoc = get_post_meta($post->ID, "wcmlim_default_location", true);
																$specific_location = get_option('wcmlim_enable_specific_location');
																if ($specific_location == 'on') {
																$allow_specific_location = get_post_meta($product_id, 'wcmlim_allow_specific_location_at_' . $term->term_id, true);
																$allow_specific_location = (empty($allow_specific_location)) ? 'Yes' : $allow_specific_location;		
																}else{
																	$allow_specific_location = 'Yes';
																}
																if (!empty($stock_location_quantity)) {
																	if (isset($stock_location_quantity)) {
																		$response = "wcmlim_stock_at_{$term->term_id}";
																		$term_vals = get_term_meta($term->term_id);
																		foreach ($term_vals as $key => $val) {
																			if ($key == 'wcmlim_postcode') {
																				$lc_code = $val[0];
																			}
																		} ?>
																		<?php if($allow_specific_location == 'Yes'){ 
																			
																			//get current user
																			$current_user = wp_get_current_user();

																			//get user specific location
																			$user_specific_location = get_user_meta($current_user->ID, 'wcmlim_user_specific_location', true);
																			if(get_option('wcmlim_enable_userspecific_location') != 'on'){
																				$user_specific_location = "-1";
																			}
																			if($user_specific_location == $k || $user_specific_location == '-1'){
																			
																			?>
																		<option 
																		<?php		
																		$variation_backorder = '';	
																																	
																		if(!empty($d_location) && !empty($selDefLoc)){
																			$_actualLcK = explode("_", $selDefLoc);
																			if ($_actualLcK[1] == $k) echo "selected='selected'";
																		}else{
																			if (preg_match('/^\d+$/', $preffLocation)) {
																				if ($preffLocation == $k) echo "selected='selected'";
																			} 
																		} 
																		if(($productOnBackorder) ||  ($isBackorderEnabled == "Yes" && $allow_backorder_each_location == "on")){
																				$variation_backorder = 'yes';
																		}
																		
																		?> 
																		value="<?php echo $k; ?>" data-lc-backorder="<?php echo $variation_backorder; ?>" data-lc-qty="<?php esc_attr_e($stock_location_quantity); ?>" data-lc-address="<?php esc_attr_e(base64_encode($rl)); ?>" data-lc-regular-price="<?php esc_attr_e(wc_price($stock_regular_price)); ?>" data-lc-sale-price="<?php ((!empty($stock_sale_price)) ?  esc_attr_e(wc_price($stock_sale_price)) : _e("undefined")); ?>" class="<?php echo 'wclimloc_'.$term->slug; ?>"  style="<?php if($allow_specific_location == 'No' ){echo 'display'.':'.'none';}else {echo 'display'.':'.'';} ?>"><?php 
																			if($productOnBackorder){
																				echo ucfirst($term->name) . ' - ' . __('On Backorder', 'woocommerce');
																			}else{
																				if( $isBackorderEnabled == "Yes" && $allow_backorder_each_location == "on"){
																					echo ucfirst($term->name) . ' - ' . __('Backorder', 'woocommerce');
																				}
																				else if (empty($stock_location_quantity) || $stock_location_quantity < 0)  { 
																					echo ucfirst($term->name) . ' - ' . __($soldout_btntxt, 'wcmlim'); 
																				} else {
																							echo ucfirst($term->name) . ' - ' . __($instock_btntxt, 'wcmlim');
																				} 		
																			}
																		?>
																				</option>
																		<?php
																			}
																		} 
																	} 
																	
																} else {
																	if (!$product->managing_stock() && $product->is_in_stock()) {
																		$stock_status = $product->get_stock_status();
																															if($stock_status == "instock"){
																			$optionname = ucfirst($term->name) . ' - ' . __($instock_btntxt, 'wcmlim');
																			$location_stock_status = 'instock';
																		}elseif($stock_status == "outofstock"){
																			$optionname = ucfirst($term->name) . ' - ' . __($soldout_btntxt, 'wcmlim');
																		}elseif($stock_status == "onbackorder"){
																			$optionname = ucfirst($term->name) . ' - ' . __('On Backorder', 'woocommerce');
																		}
																		?>
																		<option <?php if (preg_match('/^\d+$/', $preffLocation)) {
																					if ($preffLocation == $k) echo "selected='selected'";
																				} ?> class="<?php echo 'wclimloc_'.$term->slug; ?>"  value="<?php echo $k; ?>" data-lc-address="<?php esc_attr_e(base64_encode($rl));  ?>" data-lc-stockstatus="<?php echo $location_stock_status; ?>" style="<?php if($allow_specific_location == 'No' ){echo 'display'.':'.'none';}else {echo 'display'.':'.'';} ?>" ><?php echo $optionname; ?></option>
																		<?php
																	}else{	
																		if (isset($stock_location_quantity) && $hide_out_of_stock_location != "on") {
																			$response = "wcmlim_stock_at_{$term->term_id}";
																			$term_vals = get_term_meta($term->term_id);
																			foreach ($term_vals as $key => $val) {
																				if ($key == 'wcmlim_postcode') {
																					$lc_code = $val[0];
																				}
																			} ?>
																			<option
																																					<?php
																			if(!empty($d_location) && !empty($selDefLoc)){
																				$_actualLcK = explode("_", $selDefLoc);
																				if ($_actualLcK[1] == $k) echo "selected='selected'";
																			}else{
																				if (preg_match('/^\d+$/', $preffLocation)) {
																					if ($preffLocation == $k) echo "selected='selected'";
																				} 
																			}
																			if(($productOnBackorder) ||  ($isBackorderEnabled == "Yes" && $allow_backorder_each_location == "on")){
																				$variation_backorder = 'yes';
																		}
																			$int_stock_location_quantity = intval($stock_location_quantity);
																			?>
																			value="<?php echo $k; ?>" data-lc-backorder="<?php echo $variation_backorder; ?>" data-lc-qty="<?php esc_attr_e(round($int_stock_location_quantity)); ?>" data-lc-address="<?php esc_attr_e(base64_encode($rl)); ?>" data-lc-regular-price="<?php esc_attr_e(wc_price($stock_regular_price)); ?>" data-lc-sale-price="<?php ((!empty($stock_sale_price)) ?  esc_attr_e(wc_price($stock_sale_price)) : _e("undefined")); ?>" class="<?php echo 'wclimloc_'.$term->slug; ?>"  style="<?php if($allow_specific_location == 'No' ){echo 'display'.':'.'none';}else {echo 'display'.':'.'';} ?>"><?php 
																			if($productOnBackorder){
																				echo ucfirst($term->name) . ' - ' . __('On Backorder', 'woocommerce');
																			}else{
																		
																				if( $isBackorderEnabled == "Yes" && $allow_backorder_each_location == "on"){
																					echo ucfirst($term->name) . ' - ' . __('Backorder', 'woocommerce');
																				}
																				else if (empty($stock_location_quantity) || $stock_location_quantity < 0)  { 
																					echo ucfirst($term->name) . ' - ' . __($soldout_btntxt, 'wcmlim'); 
																				} else {
																							echo ucfirst($term->name) . ' - ' . __($instock_btntxt, 'wcmlim');
																				} 														
																			}
																		
																			?></option>
															<?php
																		}
																	}
																}
															}														
															?>
														</select>
														<?php if ($isLocationsGroup == null || $isLocationsGroup == false ) { ?>
															<!-- Radio Listing Mode -->
															<div class="wcmlradio_box rselect_location"></div>
															<div class="wc_scrolldown">
																<p>Scroll Location</p>
																<i class="fas fa-chevron-circle-down"></i>												
															</div>
														<?php } ?>                                                      

														</div><!-- Div loc_dd -->
														<?php
														if ($preffLocation) {
															foreach ($terms as $k => $term) {
																$stock_location_quantity = get_post_meta($post->ID, "wcmlim_stock_at_{$term->term_id}", true);
																$stock_regular_price = get_post_meta($post->ID, "wcmlim_regular_price_at_{$term->term_id}", true);
																$stock_sale_price = get_post_meta($post->ID, "wcmlim_sale_price_at_{$term->term_id}", true);
																if($stock_regular_price == '' || $stock_regular_price == '0.00')
																{
																	$stock_regular_price = get_post_meta($post->ID, "_regular_price", true);
																	$stock_sale_price = get_post_meta($post->ID, "_sale_price", true);
																}
																if (isset($stock_location_quantity)) {
																	if ($preffLocation == $k) {
																		if ($stock_display_format == "no_amount") {
																			echo '<p id="globMsg">' . __($instock_btntxt, 'wcmlim') . '</p>';
																		} elseif (empty($stock_display_format)) {
																			echo '<p id="globMsg"><b>' . $stock_location_quantity . ' </b> ' . __($instock_btntxt, 'wcmlim') . '</p>';
																		}
																	}
																}
															}
														} ?>
													</div> <!-- Div Wcmlim_prefloc_box -->
													<?php $geolocation = get_option('wcmlim_geo_location');
													if ($geolocation == "on") :
													?>
														<div class="postcode-checker">
															<p class="postcode-checker-title">
																<strong>
																	<?php if ($txt_nearest) {
																		echo $txt_nearest;
																	} else {
																		_e('Check your nearest stock location :', 'wcmlim');
																	} ?>
																</strong>

															</p>
															<div class="postcode-checker-div postcode-checker-div-show">
																<?php
																$globpin = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
																$loc_dis_un = get_option('wcmlim_location_distance');
																?>
																<input type="text" placeholder="<?php _e('Enter Location', 'wcmlim'); ?>" class="class_post_code" name="post_code" value="<?php esc_html_e($globpin); ?>" id="elementId">
																<!-- <input type="button" class="button" id="submit_postcode_product" value=" <?php //_e('Check', 'wcmlim'); 
																																				?>"> -->
																<button class="button" type="button" id="submit_postcode_product">
																	<i class="fa fa-map-marker-alt"></i>
																	<?php if ($oncheck_btntxt) {
																		echo $oncheck_btntxt;
																	} else {
																		_e('Check', 'wcmlim');
																	} ?>
																</button>
																<input type='hidden' name="global_postal_check" id='global-postal-check' value='true'>
																<input type='hidden' name="product_postal_location" id='product-postal-location' value='<?php esc_html_e($globpin); ?>'>
																<input type='hidden' name="product_location_distance" id='product-location-distance' value='<?php esc_html_e($loc_dis_un); ?>'>
															</div><!-- Div postcode-checker-div -->
															<div class="search_rep" style="display: inline-flex;">
																<div class="postcode-checker-response"></div>
																<a class="postcode-checker-change postcode-checker-change-show" href="#" data-wpzc-form-open="" style="display: none;">
																	<i class="fa fa-edit" aria-hidden="true"></i>
																</a>
															</div>
															<div class="Wcmlim_loc_label">
																<div class="Wcmlim_locadd">
																	<div class="selected_location_detail"></div>
																	<div class="postcode-location-distance"></div>
																</div>
																<div class="Wcmlim_locstock"></div>
															</div>
															<?php if ($showNxtLoc  == "on") { ?>
																<div class="Wcmlim_nextloc_label">
																	<div class="Wcmlim_nextlocadd">
																		<div class="next_closest_location_detail"></div>
																	</div>
																</div>
															<?php } ?>
															<div class="Wcmlim_messageerror"></div>
														</div><!-- Div postcode-checker -->
												<?php
													endif;
												}
												?>
												<!-- End If else  WC_Product variation and simple -->
												<input type="hidden" id="lc_regular_price" name="location_regular_price" value="">
												<input type="hidden" id="lc_sale_price" name="location_sale_price" value="">
												<input type="hidden" id="lc_qty" name="location_qty" value="">
												<input type="hidden" id="wcstdis_format" name="stock_display_format" value="<?php esc_attr_e($stock_display_format); ?>">
												<input type="hidden" id="productOrgPrice" name="product_original_price" value="<?php esc_attr_e($product->get_price_html()); ?>">
												<input type="hidden" id="backorderAllowed" name="backorder_allowed" value="<?php if (isset($productOnBackorder)) {
																																esc_attr_e($productOnBackorder);
																															} ?>">
																															<?php
												if (
													$product instanceof WC_Product && $product->is_type('variable') && !$product->is_downloadable() && !$product->is_virtual()
													|| $product instanceof WC_Product && $product->is_type('simple') && !$product->is_downloadable() && !$product->is_virtual()
												) {  ?>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php
									$customcss_enable = get_option('wcmlim_custom_css_enable');
									if ($customcss_enable == "") {
									?>
										<style>
											.wcmlim_product .loc_dd.Wcmlim_prefloc_sel {
												border-radius: <?php echo $refborder_radius;
																?> !important;
												padding-top: <?php echo $sbox_padtop;
																?>px !important;
												padding-right: <?php echo $sbox_padright;
																?>px !important;
												padding-bottom: <?php echo $sbox_padbottom;
																?>px !important;
												padding-left: <?php echo $sbox_padleft;
																?>px !important;
												background: <?php echo $sbox_bgcolor;
															?> !important;
											}

											.Wcmlim_have_stock,
											.Wcmlim_over_stock {
												padding-top: <?php echo $is_padtop;
																?>px !important;
												padding-right: <?php echo $is_padright;
																?>px !important;
												padding-bottom: <?php echo $is_padbottom;
																?>px !important;
												padding-left: <?php echo $is_padleft;
																?>px !important;
											}

											.wcmlim_product .loc_dd.Wcmlim_prefloc_sel .Wcmlim_sel_loc {
												padding-top: <?php echo $sel_padtop;
																?>px !important;
												padding-right: <?php echo $sel_padright;
																?>px !important;
												padding-bottom: <?php echo $sel_padbottom;
																?>px !important;
												padding-left: <?php echo $sel_padleft;
																?>px !important;
											}

											.wcmlim_product .postcode-checker-div input[type="text"] {
												padding-top: <?php echo $inp_padtop;
																?>px !important;
												padding-right: <?php echo $inp_padright;
																?>px !important;
												padding-bottom: <?php echo $inp_padbottom;
																?>px !important;
												padding-left: <?php echo $inp_padleft;
																?>px !important;
												border-radius: <?php echo $input_radius;
																?>px !important;
											}

											.wcmlim_product #submit_postcode_product {
												padding-top: <?php echo $btn_padtop;
																?>px !important;
												padding-right: <?php echo $btn_padright;
																?>px !important;
												padding-bottom: <?php echo $btn_padbottom;
																?>px !important;
												padding-left: <?php echo $btn_padleft;
																?>px !important;
											}

											.wcmlim_product .loc_dd.Wcmlim_prefloc_sel .fa-map-marker-alt {
												color: <?php echo $icon_color;
														?> !important;
												font-size: <?php echo $icon_size;
															?>px !important;
											}

											<?php if ($iconshow == "on") {
											?>.wcmlim_product .loc_dd.Wcmlim_prefloc_sel .fa-map-marker-alt {
												display: none !important;
											}

											<?php }	?>.Wcmlim_container.wcmlim_product {
												background-color: <?php echo $stockbox_color;
																	?>;
												border-radius: <?php echo $border_radius;
																?>;
												border-color: <?php echo $border_color;
																?>;
												border-width: <?php echo $border_width;
																?>;
												width: <?php echo $boxwidth;
														?>%;
											}

											<?php if ($border_option == "none") {
											?>.Wcmlim_container.wcmlim_product {
												 max-width: 438px;
  												 width: 100%;
												border-style: none;
												padding: 0;
											}

											<?php
											}

											?><?php if ($border_option == "solid") {
												?>.Wcmlim_container.wcmlim_product {
												border-style: solid;
												max-width: 438px;
  												width: 100%;
												
											}

											<?php
												}

											?><?php if ($border_option == "dotted") {
												?>.Wcmlim_container.wcmlim_product {
													 max-width: 438px;
  													 width: 100%;
												border-style: dotted;
											}

											<?php
												}

											?><?php if ($border_option == "double") {
												?>.Wcmlim_container.wcmlim_product {
												border-style: double;
												max-width: 438px;
  												width: 100%;
											}

											<?php
												}

											?><?php if ($border_option == "dashed") {
												?>.Wcmlim_container.wcmlim_product {
												border-style: dashed;
												max-width: 438px;
  												width: 100%;
											}

											<?php
												}

											?>.wcmlim_product #submit_postcode_product,
											.wcmlim_product #submit_postcode_global {
												border-radius: <?php echo $oncheck_radius;
																?> !important;
												color: <?php echo $oncheck_btntxtcolor;
														?> !important;
												background-color: <?php echo $oncheck_btnbgcolor;
																	?> !important;
											}

											.wcmlim_product .Wcmlim_box_title {
												color: <?php echo $txtcolor_stock_inf;
														?> !important;
											}

											.wcmlim_product .loc_dd {
												color: <?php echo $txtcolor_preferred;
														?> !important;
											}

											.wcmlim_product .postcode-checker-title {
												color: <?php echo $txtcolor_nearest;
														?> !important;
											}

											.wcmlim_product .Wcmlim_prefloc_box {
												border-color: <?php echo $color_separator;
																?>;
											}

											.wcmlim_product #submit_postcode_product,
											.wcmlim_product #submit_postcode_global {
												border-radius: <?php echo $oncheck_radius;
																?> !important;
												color: <?php echo $oncheck_btntxtcolor;
														?> !important;
												background-color: <?php echo $oncheck_btnbgcolor;
																	?> !important;
											}

											.Wcmlim_have_stock {
												border-radius: <?php echo $instock_radius;
																?>;
												color: <?php echo $instock_btntxtcolor;
														?> !important;
												background-color: <?php echo $instock_btnbgcolor;
																	?> !important;
											}

											.Wcmlim_over_stock {
												border-radius: <?php echo $soldout_radius;
																?>;
												color: <?php echo $soldout_btntxtcolor;
														?> !important;
												background-color: <?php echo $soldout_btnbgcolor;
																	?> !important;
											}

											<?php if ($display_stock_inf == "on") {
											?>.Wcmlim_box_header {
												display: none;
											}

											<?php
											}

											?><?php if ($display_preferred == "on") {
												?>.Wcmlim_sloc_label {
												display: none;
											}

											<?php
												}

											?><?php if ($display_nearest == "on") {
												?>.postcode-checker-title {
												display: none;
											}

											<?php
												}

											?><?php if ($display_separator == "on") {
												?>.Wcmlim_prefloc_box {
												border: none;
											}

											<?php
												}

											?>
										</style>
										<?php
									}
								}

											/** shortcode wcmlim_loc_storedropdown && for detail Page */
											public function woo_storelocator_dropdown()
											{
												global $post;
												$Inline_title = get_option("wcmlim_txt_inline_location", true);									
												$is_preferred = get_option('wcmlim_preferred_location');
												$geolocation = get_option('wcmlim_geo_location');
												$useLc = get_option('wcmlim_enable_autodetect_location');
												$uspecLoc = get_option('wcmlim_enable_userspecific_location');
												$show_in_popup = get_option("wcmlim_show_in_popup");
												$product = wc_get_product($post->ID);
												$storelocator_list = $this->wcmlim_get_all_store();
												$locations_list = $this->wcmlim_get_all_locations();										
												$selected_location = $this->get_selected_location();
												$terms = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0));
													if (sizeof($locations_list) > 0) { 											
															
														if ($product instanceof WC_Product && $product->is_type('variable') && !$product->is_downloadable() && !$product->is_virtual()) { ?>									
														<select class="sel_location Wcmlim_sel_loc" name="sel_location">
														<option value="-1"><?php echo esc_html('- Select Location -', 'wcmlim'); ?></option>
														</select>
														<div class="wcmlim-lcswitch" style="display:none;" >
																	<?php } else { ?>
																	<div class="wcmlim-lcswitch">
																	<?php } ?>
																	<div class="wcmlim_sel_location wcmlim_storeloc">
																		
																		<select name="wcmlim_change_sl_to" class="wcmlim_changesl" id="wcmlim-change-sl-select">
																		<?php if(count($terms)==0){?>	
																			<option value="-1"><?php _e('No group found', 'wcmlim') ?></option>
																		<?php }else { ?>
																				<option value="-1"><?php _e('Select City or Area', 'wcmlim') ?></option>
																		<?php }
																			foreach ($storelocator_list as $key => $loc) {
																			?>
																				<option class="<?php echo 'wclimstore_'.$loc['store_id']; ?>" value="<?php echo $loc['store_id']; ?>"><?php echo ucfirst($loc['store_name']); ?></option>
																			<?php
																			}
																			?>
																		</select>		
																							
																		<select class="wcmlim_lcselect" name="wcmlim_change_lc_to" id="wcmlim-change-lcselect">
																			<option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php _e('Please Select', 'wcmlim') ?></option>
																
																		</select>
																		
																															
																	</div>	
																	</div>	
																	<script type="text/javascript"> 
																	jQuery(document).ready(function() {														
																		var regiExists = <?php echo isset($_COOKIE['wcmlim_selected_location_regid']) ? $_COOKIE['wcmlim_selected_location_regid'] : ""; ?>;  
																		var termiExists = <?php echo isset($_COOKIE['wcmlim_selected_location_termid']) ? $_COOKIE['wcmlim_selected_location_termid'] : ""; ?>;  
																		
																		jQuery('.wcmlim_changesl option[value=' + regiExists + ']').prop( "selected" , true );
																		jQuery('.wcmlim_lcselect option[data-lc-term=' + termiExists + ']').prop( "selected" , true );
																	});
																	</script>
			
																
														<!-- default design End-->
													<?php }																		
											
											}

								public function add_order_item_meta($item_id, $cart_item, $cart_item_key)
								{
									if (isset($cart_item['select_location'])) {
										$values =  array();
										foreach ($cart_item['select_location'] as $key => $value) {
											$values[$key] = $value;
										}

										if(get_option('wcmlim_allow_local_pickup') == 'on' && $chosen_shipping[0] == "wcmlim_pickup_location"){
											wc_add_order_item_meta($item_id, "Pickup Location", $values["location_name"]);

										}
										else
										{
											wc_add_order_item_meta($item_id, "Location", $values["location_name"]);

										}
										wc_add_order_item_meta($item_id, "_selectedLocationKey", $values["location_key"]);
										wc_add_order_item_meta($item_id, "_selectedLocTermId", $values["location_termId"]);
										setcookie("wcmlim_selected_location", $values["location_key"], time() + 36000, '/');
									}
								}
								public function wcmlim_remove_item_meta_from_mail($formatted_meta, $item){
									if(is_wc_endpoint_url()) {
										return $formatted_meta;
									}
								  if(is_checkout() || is_cart() )
								  {
									return $formatted_meta;
								  }
								  foreach($formatted_meta as $key => $meta){
									  if(in_array($meta->key, array('_selectedLocationKey'))) {
										
										  unset($formatted_meta[$key]);
									  }
									  if(in_array($meta->key, array('_selectedLocTermId'))) {
										
										  unset($formatted_meta[$key]);
									  }
								  }
								  return $formatted_meta;
								}

								public function hidden_order_itemmeta($args)
								{
									$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										if(count($locations) == '0'){
											return 0;
											wp_die();
										}
									$args[] = '_selectedLocationKey';
									$args[] = '_selectedLocTermId';
									return $args;
								}

								// Adds the Selected Stock Location to the Product Cart
								public function wcmlim_add_location_item_data($cart_item_data, $product_id, $variation_id, $quantity)
								{	
									$manage_stock = get_post_meta($variation_id, '_manage_stock', true);
									if($variation_id == "0"){
										$manage_stock = get_post_meta($product_id, '_manage_stock', true);
									}else{
										$manage_stock = get_post_meta($variation_id, '_manage_stock', true);
									}
									if($manage_stock == "no"){
										return $cart_item_data;
									}
									
									$_isrspon = get_option("wcmlim_enable_price");

									$product = wc_get_product($product_id);
									
									if ($product->is_type('composite')) {

										if (!isset($cart_item_data['select_location'])) {

											$selected_store = $_COOKIE['wcmlim_selected_location'];

											$stores = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));

											foreach ($stores as $key => $store) {
												if ($selected_store == $key) {
													$cart_item_data['select_location'] = array(
														'location_name'     => $store->name,
														'location_key'      => $key,
														'location_termId'   => $store->term_id
													);
												}
											}
										}
									} else {
										if ($product->is_type('simple')) {
											$productPrice = $product->get_price();
											$sProductPrice = wc_price($productPrice);
										} elseif ($product->is_type('variable')) {
											$varProduct = wc_get_product($variation_id);
											$productPrice = $varProduct->get_price();
											$sProductPrice = wc_price($productPrice);
										}

										if (isset($_POST['select_location'])) {
											$lcKey = isset($_POST['select_location']) ? $_POST['select_location'] : "";
											$lcQty = isset($_POST['location_qty']) ? $_POST['location_qty'] : "";
											$ExL = get_option("wcmlim_exclude_locations_from_frontend");
											if (!empty($ExL)) {
												$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $ExL));
											} else {
												$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
											}
											foreach ($terms as $k => $term) {
												if ($k == $lcKey) {
													$locationName = $term->name;
													$locationTermId = $term->term_id;
													$locaKey = $k;
													$this->set_location_cookie($locaKey);
												}
											}

											$cart_item_data['select_location']['location_name'] = $locationName;
											$cart_item_data['select_location']['location_key'] = isset($locaKey) ? (int)$locaKey : "";
											$cart_item_data['select_location']['location_qty'] = isset($lcQty) ? (int)$lcQty : "";
											$cart_item_data['select_location']['location_termId'] = (int)$locationTermId;
											
											if($_isrspon == "on"){
												if(!empty($_POST['location_regular_price']) && $_POST['location_sale_price'] == 'undefined'){
													$cart_item_data['select_location']['location_cart_price'] = strip_tags($_POST['location_regular_price']);
												}

												if(isset($_POST['location_sale_price']) && $_POST['location_sale_price'] !== 'undefined' ){
													$cart_item_data['select_location']['location_cart_price'] = strip_tags($_POST['location_sale_price']);
												}
												
												if(empty($_POST['location_regular_price']) && empty($_POST['location_sale_price'])){
													$cart_item_data['select_location']['location_cart_price'] = strip_tags(html_entity_decode($sProductPrice));
												}
											}
											
										}
								    }

									return $cart_item_data;
								}
								//Detail Address List view
								public function wcmlim_get_loactionaddress( $termid )
								{
									$termid = $termid;
									$streetNumber = get_term_meta($termid, 'wcmlim_street_number', true);
									$route = get_term_meta($termid, 'wcmlim_route', true);
									$locality = get_term_meta($termid, 'wcmlim_locality', true);
									$state = get_term_meta($termid, 'wcmlim_administrative_area_level_1', true);
									$postal_code = get_term_meta($termid, 'wcmlim_postal_code', true);
									$country = get_term_meta($termid, 'wcmlim_country', true);
									return $streetNumber .  " " . $route . " " . $locality . " " . $state . " " . $postal_code . " " . $country;
								
								}
								/**
								 * WC custom notice message for variation
								 */
								public function wcmlim_get_wc_script_data( $params, $handle )
								{
									$no_matching_var = get_option('wcmlim_var_message2');	
									$make_a_selection = get_option('wcmlim_var_message3');	
									$var_unavailable = get_option('wcmlim_var_message4');	
									if ( $handle === 'wc-add-to-cart-variation' ) {										
										$params['i18n_no_matching_variations_text'] = __( $no_matching_var, 'wcmlim' );
										$params['i18n_make_a_selection_text'] = __( $make_a_selection, 'wcmlim' );
										$params['i18n_unavailable_text'] = __( $var_unavailable, 'wcmlim' );
									}
									return $params;
								}

								/**
								 * Set the max attribute value for the quantity input field for Add to cart forms.
								 * This applies to Simple product Add To Cart forms, and ALL (simple and variable) products on the Cart page quantity field.
								 *
								 */
								public function wcmlim_max_qty_input_args($args, $product)
								{

									$stock = $product->get_stock_quantity();

									$max = isset($this->max_in_value) ? $this->max_in_value : $stock;

									$product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
									if ($product->backorders_allowed()) {
										echo '<p id="backorder_status" style="display:none">backorders_allowed</p>';
									}
									if ($product->managing_stock() && !$product->backorders_allowed()) {
										// Limit our max by the available stock
										if (isset($this->max_value_inpl)) {
											$args['max_value'] = $this->max_value_inpl;
										
										} else {
											$args['max_value'] = isset($max['location_qty']) ? $max['location_qty'] : $stock;
				
										}
									
									}
									return $args;
								}

								//Displays the Selected Location below the Product name in Cart
								public function wcmlim_cart_item_name($name, $cart_item, $cart_item_key)
								{
									$name .= sprintf('<p>');

									if (isset($cart_item['select_location']['location_name'])) {
										$locescstring = __("Location : ", "wcmlim");
										$locfeeescstring = __("Fee : ", "wcmlim");

										if((isset($cart_item['select_location']['location_name']))):
										
											if(!empty($cart_item['select_location']['location_name'])):
											
												$name .= sprintf('%s', __($locescstring . $cart_item['select_location']['location_name']));
									endif;
								endif;

										// add custom fee assigned
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										$wc_currency_symbol = get_woocommerce_currency_symbol();
										foreach ($terms as $term) {
											if ($term->name == $cart_item['select_location']['location_name']) {
											  $term_id = $term->term_id;
											  $location_fee = get_term_meta($term_id, 'wcmlim_location_fee', true);
											  if((!empty($location_fee)) && ($location_fee != 0))
											  {
												  $name .= sprintf('<br>%s', __($locfeeescstring . $wc_currency_symbol.$location_fee));
											  }
											}
										  }         
										  $name .= sprintf('</p>');


									} else {
										$termExclude = get_option("wcmlim_exclude_locations_from_frontend");
										if (!empty($termExclude)) {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $termExclude));
										} else {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										}
										foreach ($terms as $term) {
											$this->max_value_inpl = get_post_meta($cart_item['product_id'], "wcmlim_stock_at_{$term->term_id}", true);
										}
									}
									$this->max_in_value = isset($cart_item['select_location']) ? $cart_item['select_location'] : "";
									return $name;
								}
								
								public function wcmlim_display_selected_location_dropdown(){
										    $product_id = $_POST['product_id'];
											$location_cookie = $_POST['locationCookie'];
											$location_stock=get_post_meta( $product_id, "wcmlim_stock_at_{$location_cookie}", true );
											echo $location_stock;
											die();

								}
								public function wcmlim_display_location_dropdown()
								{
									$response = array();
									$hideDropdown = get_option('wcmlim_hide_show_location_dropdown');
									if($hideDropdown == 'on'){
										$response['show_wcmlim_product'] = 'hide';
												echo json_encode($response);
												die();
									}

									$isExcludeLocation = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($isExcludeLocation)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcludeLocation));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
									$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : "";
									$variation = wc_get_product($product_id);
									$parent_product =  $variation->get_parent_id();
									$product = wc_get_product($parent_product);
									$stock_display_format = get_option('woocommerce_stock_format');
									$instock_btntxt = get_option("wcmlim_instock_button_text");									
									$variation_stock = $variation->get_stock_quantity();
									$allow_backorder_each_location = get_option('wcmlim_enable_backorder_for_locations');

									if( $variation_stock <= 0 && $allow_backorder_each_location != 'on'){
										$response['show_wcmlim_product'] = 'hide';
										echo json_encode($response);
										die();
									}
									if ($product instanceof WC_Product && $product->is_type('variable') && !$product->is_downloadable() && !$product->is_virtual()) {
										$variations = $product->get_available_variations();
										if (!empty($variations)) {
											$variation_stock_status =  get_post_meta($product_id , "_stock_status", true);
											$manage_stock = get_post_meta($product_id, '_manage_stock', true);
											
											 $stock_status = get_post_meta($product_id, '_stock_status', true);
											if(empty($variations))
											{
												if( $manage_stock == 'no' ){
													$response['show_wcmlim_product'] = 'hide';
													echo json_encode($response);
													die();
												}
											}
											foreach ($variations as $key => $value) {
												
												foreach ($terms as $k => $term) {
													if ($product_id == $value['variation_id']) {
														 $stock_location_quantity =  get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true);
														
														$stock_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$term->term_id}", true);
														$stock_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$term->term_id}", true);
														$backorder = !empty($value['backorders_allowed']) ? $value['backorders_allowed'] : 0;
														$manage_stock = get_post_meta($product_id, '_manage_stock', true);
														$stock_status = get_post_meta($product_id, '_stock_status', true);
														
														 $variable_is_in_stock =  $value['is_in_stock'];
														$isBackorderEnabled = get_post_meta($product_id, "wcmlim_allow_backorder_at_$term->term_id", true );
														$specific_location = get_option('wcmlim_enable_specific_location');
														if ($specific_location == 'on') {
														$allow_specific_location = get_post_meta($product_id, 'wcmlim_allow_specific_location_at_' . $term->term_id, true);
														 $allow_specific_location = (empty($allow_specific_location)) ? 'Yes' : $allow_specific_location;
														}else{
															$allow_specific_location = 'Yes';
														}

														if($allow_specific_location == 'Yes')
														{	
															//get current user
															$current_user = wp_get_current_user();

															//get user specific location
															$user_specific_location = get_user_meta($current_user->ID, 'wcmlim_user_specific_location', true);
															if(get_option('wcmlim_enable_userspecific_location') != 'on'){
																$user_specific_location = "-1";
															}
															if($user_specific_location == $k || $user_specific_location == '-1'){
															
															$d_location   = get_option('wcmlim_enable_default_location');
															$allow_backorder_each_location = get_option('wcmlim_enable_backorder_for_locations');
															$selDefLoc = get_post_meta($product_id, "wcmlim_default_location", true);
															$term_meta = get_option("taxonomy_$term->term_id");
															$rl = $this->wcmlim_get_loactionaddress($term->term_id);
															$term_location = base64_encode($rl);
															$hide_out_of_stock_location   = get_option('wcmlim_hide_out_of_stock_location');

																if ($manage_stock == 1 || $manage_stock == 'yes' ) {
																	if($isBackorderEnabled == "Yes" && $allow_backorder_each_location == "on"){
																		$response[$k]['text'] = $term->name . ' - ' . __('Backorder', 'woocommerce');
																				$response[$k]['location_qty'] = '0';
																				$response[$k]['location_address'] = $term_location;
																				$response[$k]['variation_backorder'] = "yes";
																				$response[$k]['location_class'] = "wclimloc_". $term->slug;
																	} else{
																		if($backorder == 1){
																			$response[$k]['text'] = $term->name. ' - ' . __('On Backorder', 'woocommerce');
																			if ($hide_out_of_stock_location != "on") {
																				$response[$k]['text'] = $term->name . ' - ' . __('On Backorder', 'woocommerce');
																				$response[$k]['location_qty'] = round(intval($stock_location_quantity));
																				$response[$k]['location_class'] = "wclimloc_". $term->slug;
																				$response[$k]['variation_backorder'] = "yes";
																			}
																		}else{
																			if(!empty($stock_location_quantity) && $stock_location_quantity > 0){
																				$response[$k]['text'] = $term->name. ' - ' . __('In stock', 'woocommerce');
																				$response[$k]['location_qty'] = round(intval($stock_location_quantity));
																				$response[$k]['location_address'] = $term_location;
																				$response[$k]['location_class'] = "wclimloc_". $term->slug;
																			}else{
																				if ($hide_out_of_stock_location != "on") {
																					$response[$k]['text'] = $term->name . ' - ' . __('Out of Stock', 'woocommerce');
																					$response[$k]['location_qty'] = '0';
																					$response[$k]['location_address'] = $term_location;
																					$response[$k]['location_class'] = "wclimloc_". $term->slug;
																					
																				}
																				
																			}
																		}
																	}
																	

																	if (!empty($stock_regular_price)) {
																		$response[$k]['regular_price'] = wc_price($stock_regular_price);
																	}
																	if (!empty($stock_sale_price)) {
																		$response[$k]['sale_price'] = wc_price($stock_sale_price);
																	}
																} else {
																	if ($hide_out_of_stock_location != "on") {
																		if ($stock_status =='instock') {
																			$response[$k]['text'] = $term->name. ' - ' . __($stock_status, 'woocommerce'); 
																			
																		$response[$k]['location_address'] = $term_location;
																		$response[$k]['location_class'] = "wclimloc_". $term->slug;
																		$response[$k]['location_stock_status'] = 'instock';
																		}
																		else{
																			$response[$k]['text'] = $term->name . ' - ' . __('Out of Stock', 'woocommerce');
																			$response[$k]['location_class'] = "wclimloc_". $term->slug;
																		}
																		if (!empty($stock_regular_price)) {
																			$response[$k]['regular_price'] = wc_price($stock_regular_price);
																		}
																		if (!empty($stock_sale_price)) {
																			$response[$k]['sale_price'] = wc_price($stock_sale_price);
																		}
																		
																	}

																}
																if (!empty($d_location) && !empty($selDefLoc)) {
																	$_actualLcK = explode("_", $selDefLoc);
																			if ($_actualLcK[1] == $k) {
																			$response[$k]['default_location'] = $k;
																	}else{
																		$response[$k]['default_location'] = '';
																	}
																}
																$response[$k]['start_time'] = get_term_meta($term->term_id, 'wcmlim_start_time', true);
																$response[$k]['end_time'] = get_term_meta($term->term_id, 'wcmlim_end_time', true);
																$response[$k]['allow_specific_location'] = $allow_specific_location;
															}
														}
													}
												}
											}
											$response['backorder'] = $backorder;
										}
									}
									echo json_encode($response);
									die();
								}
								public function wcmlim_add_custom_price($cart_object)
								{
									// Avoiding hook repetition (when using price calculations for example)
									if (did_action('woocommerce_before_calculate_totals') >= 2)
										return;

									foreach ($cart_object->get_cart() as $key => $item_values) {
										##  Get cart item data
										$manageStock = get_post_meta($item_values["product_id"], '_manage_stock', true);
										if($manageStock == "no"){
											$price = $item_values['data']->get_price();
											return wc_price($price);
										}else{
											$original_price = isset($item_values['select_location']['location_org_price']) ? $item_values['select_location']['location_org_price'] : ""; // Product original price							
											if (!empty($original_price)) {
												## Set the new item price in cart
												$item_values['data']->set_price(($original_price));
											} else {
												$price = isset($item_values['select_location']['location_cart_price']) ? $item_values['select_location']['location_cart_price'] : "";
												$newprice = html_entity_decode($price);
												## Set the new item price in cart
												$item_values['data']->set_price(($newprice));
											}
										}
									}
								}
								
								public function wcmlim_get_all_locations()
								{
									$isLocEx = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($isLocEx)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isLocEx));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
									$result = [];
									$i = 0;
									foreach ($terms as $k => $term) {
										$term_meta = get_option("taxonomy_$term->term_id");
										$term_locator = get_term_meta( $term->term_id , 'wcmlim_locator', true);
										$term_meta = array_map(function ($term) {
											if (!is_array($term)) {
												return $term;
											}
										}, $term_meta);
										$result[$i]['location_address'] = implode(" ", array_filter($term_meta));
										$result[$i]['location_name'] = $term->name;
                                        $result[$i]['location_slug'] = $term->slug;
										$result[$i]['location_storeid'] = $term_locator;
										$result[$i]['location_termid'] = $term->term_id;
										$i++;
									}
									return $result;
									wp_die();
								}
							
								public function wcmlim_set_preferred_location()
								{
									if (isset($_POST)) {
										$prefLoc = $_POST['ploc'];
									}
									wp_die();
								}
								public function woo_switch_content()
								{
									$Inline_title = get_option("wcmlim_txt_inline_location", true);									
									$is_preferred = get_option('wcmlim_preferred_location');
									$geolocation = get_option('wcmlim_geo_location');
									$useLc = get_option('wcmlim_enable_autodetect_location');
									$uspecLoc = get_option('wcmlim_enable_userspecific_location');
									$show_in_popup = get_option("wcmlim_show_in_popup");
									$isLocationsGroup = get_option('wcmlim_enable_location_group');	
									$isEditor = wp_get_referer();
									if(strpos($isEditor, 'action=edit') || strpos($isEditor, 'post-new.php')){
										return;
									}
										if ($is_preferred == 'on' || !empty($show_in_popup) && (empty($uspecLoc) && ( get_current_user_id() ))) {
										$locations_list = $this->wcmlim_get_all_locations();
										$selected_location = $this->get_selected_location();
										if ($isLocationsGroup == 'on') {
											$storelocator_list = $this->wcmlim_get_all_store();										}
										if (sizeof($locations_list) >= 0) { ?>											
											<!-- default design Start-->
											<div class="main-cont">
											<div class="wcmlim-lc-switch">
												<form id="lc-switch-form" class="inline_wcmlim_lc" method="post">
													<div class="wcmlim_form_box">
														<div class="wcmlim_sel_location wcmlim_storeloc">
														<?php
															$current_user = wp_get_current_user();
															$current_user_id = get_current_user_id();
															$current_ui = isset($current_user_id) ? $current_user_id : "";
															$restricUsers   = get_option('wcmlim_enable_userspecific_location');
															if($restricUsers == "on"){
															$user_selected_location = get_user_meta($current_ui, 'wcmlim_user_specific_location', true);
															}else{
																$user_selected_location = "";
															}
															$terms = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0));
															$roles = $current_user->roles;
															if ($isLocationsGroup == 'on' ) { ?>
																<p class="wcmlim_change_sl_to"><?php if ($Inline_title) {
																																							echo $Inline_title;
																																						} else {
																																							_e('Region: ', 'wcmlim');
																																						} ?></p>
	
																<?php if ($restricUsers == "on" && $roles[0] == "customer") { ?>
																<select name="wcmlim_change_sl_to" id="wcmlim-change-sl-select">
																																<option value="-1"><?php _e('Please Select', 'wcmlim') ?></option>  
																															<?php
																															foreach ($locations_list as $key => $loc) {
																															if (preg_match('/^\d+$/',$user_selected_location)) {
																																if ($user_selected_location == $key) 
																																	{
																																	$rectricted_location_store_id = $loc['location_storeid'];
																																	}
																																}
																															}
																															$restricted_store = get_term($rectricted_location_store_id);?>
	
																					<option class="<?php echo 'wclimstore_'.$restricted_store->term_id; ?>" value="<?php echo $restricted_store->term_id; ?>"><?php echo ucfirst($restricted_store->name); ?></option>
																					</select>
																<?php }
																else {?>
																	<select name="wcmlim_change_sl_to" id="wcmlim-change-sl-select">
																																<option value="-1"><?php _e('Please Select', 'wcmlim') ?></option>  
																															<?php
																																foreach ($storelocator_list as $key => $loc) {
																																?>
																																	<option class="<?php echo 'wclimstore_'.$loc['store_id']; ?>" value="<?php echo $loc['store_id']; ?>"><?php echo ucfirst($loc['store_name']); ?></option>
																																<?php
																																}
																																?>
																															</select>
	
																<?php }?>
																<p class="wcmlim_change_lc_to" id="wcmlim_store_label_popup"><?php _e('Store: ', 'wcmlim'); ?></p>	
																<?php if ($restricUsers == "on" && $roles[0] == "customer") { ?>
																<select name="wcmlim_change_lc_to" class="wcmlim-lc-select" id="wcmlim-change-lc-select">
																<option value="-1" <?php if (
																	!$selected_location
																) {
																	echo "selected='selected'";
																} ?>><?php _e("Select", "wcmlim"); ?></option>
																<?php foreach (
																	$locations_list
																	as $key => $loc
																) {
																	if (
																		preg_match(
																			'/^\d+$/',
																			$user_selected_location
																		)
																	) {
																		if (
																			$user_selected_location == $key
																		) { ?>
																<option 
																class="<?php echo "wclimloc_" .
																	$loc["location_slug"]; ?>" 
																value="<?php echo $key; ?>" 
																data-lc-address="<?php echo base64_encode(
																	$loc["location_address"]
																); ?>"
																data-lc-term="<?php echo $loc[
																	"location_termid"
																]; ?>" 
																<?php if (
																	preg_match(
																		'/^\d+$/',
																		$user_selected_location
																	)
																) {
																	if ($user_selected_location == $key) {
																		echo "selected='selected'";
																	}
																} ?>>
																<?php echo ucfirst($loc["location_name"]); ?>
																</option>
																<?php }
																	}
																} ?>
															</select>
															<?php } else { ?>
																	<select name="wcmlim_change_lc_to" class="wcmlim-lc-select <?php
																	$lcselect = get_option("wcmlim_enable_location_group");
																	if ($lcselect == "on") {
																		echo "wcmlim-lc-select-2";
																	}
																	?>" id="wcmlim-change-lc-select">
																									<option value="-1" <?php if (
																										!$selected_location
																									) {
																										echo "selected='selected'";
																									} ?>><?php _e(
																		"Please Select",
																		"wcmlim"
																	); ?></option>
																								</select>
																	<?php }
	
																 } else if ((!empty($current_user_id)) || (empty($current_user_id) && $restricUsers == '')){ 
																?>
															<p class="wcmlim_change_lc_to"><?php if ($Inline_title ) {
																								echo $Inline_title;
																							} else {
																								_e('Location: ', 'wcmlim');
																							}?></p>
																<?php 
																if(isset($roles[0]) && $roles[0] == 'customer'){ 
																	?>
																	<select name="wcmlim_change_lc_to" class="wcmlim-lc-select" id="wcmlim-change-lc-select">
																	<option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php _e('Select', 'wcmlim') ?></option>
																	<?php
																	foreach ($locations_list as $key => $loc) {
																	if (preg_match('/^\d+$/', $user_selected_location)) {
																		if ($user_selected_location == $key) {
																	?>
																	<option 
																	class="<?php echo 'wclimloc_'.$loc['location_slug']; ?>" 
																	value="<?php echo $key; ?>" 
																	data-lc-address="<?php echo base64_encode($loc['location_address']); ?>"
																	data-lc-term="<?php echo $loc['location_termid']; ?>" 
																	<?php
																	 if (preg_match('/^\d+$/', $user_selected_location)) {
																	if ($user_selected_location == $key) 
																	echo "selected='selected'";
																	} 
																	?>>
																	<?php echo ucfirst($loc['location_name']); 
																	?>
																	</option>
																<?php 
																		}
																	}else{
																		?>
																		<option 
																	class="<?php echo 'wclimloc_'.$loc['location_slug']; ?>" 
																	value="<?php echo $key; ?>" 
																	data-lc-address="<?php echo base64_encode($loc['location_address']); ?>"
																	data-lc-term="<?php echo $loc['location_termid']; ?>" 
																	<?php
																	 if (preg_match('/^\d+$/', $selected_location)) {
																	if ($selected_location == $key) 
																	echo "selected='selected'";
																	} 
																	?>>
																	<?php echo ucfirst($loc['location_name']); 
																	?>
																	</option>
																		<?php
																	}
															}	?>
															</select>
																<?php }
																else if(isset($roles[0]) && $roles[0] != ''){ ?>
																<select name="wcmlim_change_lc_to" class="wcmlim-lc-select" id="wcmlim-change-lc-select">
																<option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php _e('Select', 'wcmlim') ?></option>
																<?php
																foreach ($locations_list as $key => $loc) {
																?>
																	<option 
																	class="<?php echo 'wclimloc_'.$loc['location_slug']; ?>" 
																	value="<?php echo $key; ?>" 
																	data-lc-address="<?php echo base64_encode($loc['location_address']); ?>"
																	data-lc-term="<?php echo $loc['location_termid']; ?>" 
																	<?php if (preg_match('/^\d+$/', $selected_location)) {
																	if ($selected_location == $key) 
																	echo "selected='selected'";
																	} ?>>
																	<?php echo ucfirst($loc['location_name']); 
																	?>
																	</option>
																<?php }	?>
															</select>	
									
															<?php } 
															else if ($restricUsers == '') { ?>
																<select name="wcmlim_change_lc_to" class="wcmlim-lc-select" id="wcmlim-change-lc-select">
																<option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php _e('Select', 'wcmlim') ?></option>
																<?php
																foreach ($locations_list as $key => $loc) {
																?>
																	<option 
																	class="<?php echo 'wclimloc_'.$loc['location_slug']; ?>" 
																	value="<?php echo $key; ?>" 
																	data-lc-address="<?php echo base64_encode($loc['location_address']); ?>"
																	data-lc-term="<?php echo $loc['location_termid']; ?>" 
																	<?php if (preg_match('/^\d+$/', $selected_location)) {
																	if ($selected_location == $key) 
																	echo "selected='selected'";
																	} ?>>
																	<?php echo ucfirst($loc['location_name']); 
																	?>
																	</option>
																<?php }	?>
															</select>	
									
															<?php } 
													
														}else {
															 ?>
															 <p class="wcmlim_change_lc_to"><?php if ($Inline_title ) {
																								echo $Inline_title;
																							} else {
																								_e('Location: ', 'wcmlim');
																							}?></p>
															<select name="wcmlim_change_lc_to" class="wcmlim-lc-select" id="wcmlim-change-lc-select">
															<option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php _e('Select', 'wcmlim') ?></option>
															<?php
															foreach ($locations_list as $key => $loc) {
															?>
																<option 
																class="<?php echo 'wclimloc_'.$loc['location_slug']; ?>" 
																value="<?php echo $key; ?>" 
																data-lc-address="<?php echo base64_encode($loc['location_address']); ?>"
																data-lc-term="<?php echo $loc['location_termid']; ?>" 
																<?php if (preg_match('/^\d+$/', $selected_location)) {
																if ($selected_location == $key) 
																echo "selected='selected'";
																} ?>>
																<?php echo ucfirst($loc['location_name']); 
																?>
																</option>
															<?php }	?>
														</select>	
													<?php 
														} ?>
															<div class="er_location"></div>
															<!-- Radio Listing Mode -->
															<?php if ($isLocationsGroup == null || $isLocationsGroup == false ) { ?>
																<div class="rlist_location"></div>
															<?php } ?>
														</div>
														<?php
														
														if ($geolocation == "on" || (is_array($show_in_popup) && in_array('location_finder_in_popup', $show_in_popup))) : ?>
															<div class="postcode-checker">
																<div class="postcode_wcmliminput">
																	<span class="postcode-checker-div postcode-checker-div-show">
																		<?php
																		$globpin = isset($_COOKIE['wcmlim_nearby_location']) ? $_COOKIE['wcmlim_nearby_location'] : "";
																		$loc_dis_un = get_option('wcmlim_location_distance');
																		?>
																		<input type="text" placeholder="<?php _e('Enter Pincode/Zipcode', 'wcmlim'); ?>" required class="class_post_code_global" name="post_code_global" value="<?php if($globpin != 0){esc_html_e($globpin);} ?>" id="elementIdGlobal">
																		<input type="button" class="button" id="submit_postcode_global" value="<?php _e('Apply', 'wcmlim'); ?>">
																		<input type='hidden' name="global_postal_check" id='global-postal-check' value='true'>
																		<input type='hidden' name="global_postal_location" id='global-postal-location' value='<?php esc_html_e($globpin); ?>'>
																		<input type='hidden' name="product_location_distance" id='product-location-distance' value='<?php esc_html_e($loc_dis_un); ?>'>
																	</span>
																</div>
																<?php if ($useLc == "on") { ?>
																	<div class="wclimlocsearch" style="display:none;">
																		<i id="currentLoc" class="fas fa-crosshairs currentLoc">
																			<a>Use Current Location</a> </i>
																	</div>
																<?php } ?>
																<div class="search_rep">
																	<div class="postcode-checker-response"></div>
																	<a class="postcode-checker-change postcode-checker-change-show" href="#" data-wpzc-form-open="" style="display: none;">
																		<i class="fa fa-edit" aria-hidden="true"></i>
																	</a>
																</div>
																<div class="postcode-location-distance"></div>
															</div>
														<?php endif; ?>
													</div>
													<?php wp_nonce_field('wcmlim_change_lc', 'wcmlim_change_lc_nonce'); ?>
													<input type="hidden" name="action" value="wcmlim_location_change">
												</form>
											</div>
											</div>
											<!-- default design End-->
										<?php }										
									} /** is_preferred */
								}
								//Ravindra
								/***
								 * On load and change region update
								 */
                                public function wcmlim_getdropdown_location()
								{
									$termselect = isset($_POST['selectedstoreValue']) ? intval($_POST['selectedstoreValue']) : "";
									$selected_location = $this->get_selected_location();
									$isLocEx = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($isLocEx)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isLocEx));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
				
									$result = array();
									$current_user = wp_get_current_user();
									$current_user_id = get_current_user_id();
									$current_ui = isset($current_user_id) ? $current_user_id : "";
									$user_selected_location = get_user_meta($current_ui, 'wcmlim_user_specific_location', true);
									$restricUsers   = get_option('wcmlim_enable_userspecific_location');
									$roles = $current_user->roles;
									if ( $restricUsers == 'on' && $roles[0] == 'customer'){
						
										foreach ($terms as $i => $term) {	
											if ( $user_selected_location == $i) {
												$term_locator = get_term_meta( $term->term_id , 'wcmlim_locator', true);
												$area_name = get_term_meta( $term->term_id , 'wcmlim_areaname', true);
												$id = strval($term->term_id);
												$name = strval($term->name);
												$slug = strval($term->slug);										
												$classname = 'wclimloc_'.$slug . ' ' .  'wclimstoreloc_'.$term_locator; 
												$value = $i; 
												$selected = "selected";

													$result[$i]['selected'] = $selected_location;	
													$result[$i]['term_id'] = $id;	
													$result[$i]['classname'] = $classname;	
													$result[$i]['vkey'] = $value;	
													$result[$i]['location_name'] = $name;
													$result[$i]['location_slug'] = $slug;
													$result[$i]['location_storeid'] = $term_locator;
													$result[$i]['wcmlim_areaname'] = $area_name; 
											}
										}
									 }else {
										foreach ($terms as $i => $term) {										
											$term_locator = get_term_meta( $term->term_id , 'wcmlim_locator', true);
											$area_name = get_term_meta( $term->term_id , 'wcmlim_areaname', true);
											$id = strval($term->term_id);
											$name = strval($term->name);
											$slug = strval($term->slug);										
											$classname = 'wclimloc_'.$slug . ' ' .  'wclimstoreloc_'.$term_locator; 
											$value = $i; 
											$selected = "";
											if (preg_match('/^\d+$/', $selected_location)) {
												if ($selected_location == $i) 
												{ 
													$selected = 'selected';
												} else  {
													$selected = "";
												}
											} 
											
											if( $term_locator == $termselect) {
												$result[$i]['selected'] = $selected_location;	
												$result[$i]['term_id'] = $id;	
												$result[$i]['classname'] = $classname;	
												$result[$i]['vkey'] = $value;	
												$result[$i]['location_name'] = $name;
												$result[$i]['location_slug'] = $slug;
												$result[$i]['location_storeid'] = $term_locator;
												$result[$i]['wcmlim_areaname'] = $area_name; 
											}
														  
											
										}
									 }
															
									echo json_encode($result);									
									die(); 
								}
								/**
								 * Location Group
								 */

								public function wcmlim_get_all_store()
								{
									$isStoreLocEx = get_option("wcmlim_exclude_locations_group_frontend");
									if (!empty($isStoreLocEx)) {
										$terms = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isStoreLocEx));
									} else {
										$terms = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0));
									}
									
									$result = [];
									$i = 0;
									foreach ($terms as $k => $term) {
										$term_meta = get_option("taxonomy_$term->term_id");
																			
										$result[$i]['store_name'] = $term->name;
                                        $result[$i]['store_id'] = $term->term_id;
										$i++;
									}
									return $result;
									wp_die();
								}

								private static function get_selected_location($count_on_default = false)
								{

									if (!$count_on_default) {
										// only alternative locations will be counted
										$selected_location = (isset($_COOKIE['wcmlim_selected_location']) && $_COOKIE['wcmlim_selected_location'] != 'default') ? $_COOKIE['wcmlim_selected_location'] : -1;
									} else {
										// any location selected, even default will return true
										$selected_location = (isset($_COOKIE['wcmlim_selected_location'])) ? true : -1;
									}
									return $selected_location;
								}

								// process select location form submission here
								public function handle_switch_form_submit()
								{
									// process switch location form data
									if (isset($_POST['wcmlim_change_lc_nonce']) && wp_verify_nonce($_POST['wcmlim_change_lc_nonce'], 'wcmlim_change_lc')) {

										$selected_location = isset($_POST['wcmlim_change_lc_to']) ? $_POST['wcmlim_change_lc_to'] : "";

										if ($selected_location && $selected_location == 'default') {
											$this->set_location_cookie($selected_location); // set
										} else if (isset($selected_location) && $selected_location != '') {
											$this->set_location_cookie($selected_location); // set
										}
									}
								}

								// set and unset location cookies
								public function set_location_cookie($selected_location = null)
								{
									$cookieTimeOption = get_option("wcmlim_set_location_cookie_time");
									$shold = get_option("wcmlim_show_location_selection");
									$cookieTime = intval($cookieTimeOption) ? $cookieTimeOption : 1;
									if ($shold == "on") {
										if (is_user_logged_in()) {
											$current_user_id = get_current_user_id();
											if (current_user_can('administrator', $current_user_id)){
												if (isset($selected_location)) {
													setcookie("wcmlim_selected_location", $selected_location, time() + ($cookieTime * 24 * 60 * 60), '/');
													$_COOKIE['wcmlim_selected_location'] = $selected_location;
												}
											}else {
												$specificLocation = get_user_meta($current_user_id, 'wcmlim_user_specific_location', true);	
												setcookie("wcmlim_selected_location", $specificLocation, time() + 36000, '/');
											}
										}if (isset($selected_location)) {
											setcookie("wcmlim_selected_location", $selected_location, time() + ($cookieTime * 24 * 60 * 60), '/');
											$_COOKIE['wcmlim_selected_location'] = $selected_location;
										} else {
											// unset cookies
											setcookie('wcmlim_selected_location', -1, -1, '/');
											unset($_COOKIE['wcmlim_selected_location']);
										}
									} else {

										if (isset($selected_location)) {
											setcookie("wcmlim_selected_location", $selected_location, time() + ($cookieTime * 24 * 60 * 60), '/');
											$_COOKIE['wcmlim_selected_location'] = $selected_location;
										} else {
											// unset cookies
											setcookie('wcmlim_selected_location', -1, -1, '/');
											unset($_COOKIE['wcmlim_selected_location']);
										}
									}
								}

								public function wcmlim_show_stock_shop()
								{
									global $product;
									$setLocation = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : "";
									if ($product->get_type() == 'simple') {
										$exclExists = get_option("wcmlim_exclude_locations_from_frontend");
										if (!empty($exclExists)) {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $exclExists));
										} else {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										}

										foreach ($terms as $k => $term) {
											$locationQty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$term->term_id}", true);
											if ($setLocation == $k && !empty($locationQty)) {
												print_r($term->name . ': ' . $locationQty . '<br>');
											}
										}
									}
								}
 							

								public function wcmlim_select_location_validation($passed)
								{
								
									$pass_location = isset($_REQUEST['select_location']) ? $_REQUEST['select_location'] : "";
									$select_loc_va = get_option('wcmlim_select_loc_val');
									$product_id = $_REQUEST['add-to-cart'];
									$manage_stock =  get_post_meta($product_id,'_manage_stock',true);
									
									if ($manage_stock != 'no') {
										if ($pass_location == -1) {
											wc_add_notice(__( $select_loc_va , 'wcmlim'), 'error');
											$passed = false;
											return $passed;
										}
										else
										{
										$passed = true;
										return $passed;
										}
									}
									else if ($manage_stock == 'no') {
										$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										$location_id = '';
										foreach($locations as $key=>$term){
											if($key == $pass_location){
												$location_id = $term->term_id;
											}
										}
										$allow_backorder_each_location = get_option('wcmlim_enable_backorder_for_locations');
										
										if($allow_backorder_each_location == "on")
										{
											$location_pid_backorder = get_post_meta($product_id, 'wcmlim_allow_backorder_at_' . $location_id, true);
											
											if($location_pid_backorder == 'Yes')
											{
												$passed = true;
												return $passed;
											}
											else
										{
											echo $passed;
										die();
										$passed = false;
										return $passed;
										}
											
										}
									}
									else
									{
										$passed = true;
										return $passed;
									}
									
								}

								public function wcmlim_replacing_add_to_cart_button($button, $product)
								{	
									$slCookie = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : "";
									$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									foreach ($terms as $t => $v) {
										if ($slCookie == $t) {
											$ln = $v->name;
											$_location_key = $t;
											$_location_qty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$v->term_id}", true);
											$_location_regular_price = get_post_meta($product->get_id(), "wcmlim_regular_price_at_{$v->term_id}", true);
											$_location_sale_price = get_post_meta($product->get_id(), "wcmlim_sale_price_at_{$v->term_id}", true);
											$_location_termId = $v->term_id;
										}
									}

									$ln = !empty($ln) ? $ln : "";
									$_location_key = isset($_location_key) ? (int)$_location_key : "";
									$_location_qty = isset($_location_qty) ? (int)$_location_qty : "";
									$_location_termId = isset($_location_termId) ? (int)$_location_termId : "";
									$_location_regular_price = !empty($_location_regular_price) ? $_location_regular_price : "";
									$_location_sale_price = !empty($_location_sale_price) ? $_location_sale_price : "";
									$_isRedirect = get_option("woocommerce_cart_redirect_after_add");
									$_cart_url = wc_get_cart_url();

									if ($product->is_type('simple') && !$product->is_downloadable() && !$product->is_virtual()) {
										$_product_id = $product->get_id();
										$_product_sku = $product->get_sku();
										$_product_name = $product->get_name();
										$_product_price = $product->get_price();
										$_product_backorder = $product->backorders_allowed();

										$button_text = __("Add to cart", "woocommerce");
										$button = '<a data-cart-url="' . $_cart_url . '" data-isredirect="' . $_isRedirect . '" data-quantity="1" class="button product_type_simple add_to_cart_button wcmlim_ajax_add_to_cart" data-product_id="' . $_product_id . '" data-product_sku="' . $_product_sku . '" aria-label="Add “' . $_product_name . '” to your cart" data-selected_location="' . $ln . '" data-location_key="' . $_location_key . '" data-location_qty="' . $_location_qty . '" data-location_termid="' . $_location_termId . '" data-product_price="' . $_product_price . '" data-location_sale_price="' . $_location_sale_price . '" data-location_regular_price="' . $_location_regular_price . '" data-product_backorder="' . $_product_backorder . '" rel="nofollow">' . $button_text . '</a>';
									}
									return $button;
								}

								public function wcmlim_ajax_validation_manage_stock()
								{
									global $woocommerce;
									$product_id = $_POST['product_id'];
									$manage_stock = get_post_meta($product_id, '_manage_stock', true);

									if($manage_stock == "yes")
									{
										$current_stock = get_post_meta($product_id, '_stock', true);
										if($current_stock <= 0){
											echo '0';
											wp_die();
										}else{
											echo '1';
											wp_die();
										}
									}
									else 
									{
										$current_stock_status = get_post_meta($product_id, '_stock_status', true);
										if ($current_stock_status == 'instock') {
											echo '1';
										}
										else
										{
											echo '0';
										}
									}
									wp_die();
								}

								public function wcmlim_ajax_add_to_cart()
								{	
									global $woocommerce;
									$reserr = '0';
									$product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
									
									$product_location_termid = isset($_POST['product_location_termid']) ? $_POST['product_location_termid'] : "";
									$manage_stock = get_post_meta($product_id, '_manage_stock', true);
									$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
									
									
									//restricting user from adding product to cart if the location is not selected (when manage stock is on)
									if($manage_stock == "yes" && empty($product_location_termid))
									{
										echo '3';
										wp_die();
									}

									if($manage_stock != "yes" && !empty($product_location_termid)){
										echo '2';
										wp_die();
									}

									$__stock_at_location = get_post_meta($product_id, "wcmlim_stock_at_{$product_location_termid}", true);
									
									if($manage_stock == "yes"){
										if ($__stock_at_location <= 0 ) {
											echo '2';
											wp_die();
										}
									}

									$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
									$product_status = get_post_status($product_id);
									$product_price = isset($_POST['product_price']) ? $_POST['product_price'] : "";
									$_isrspon = get_option("wcmlim_enable_price");
									// Location data
									$product_location = isset($_POST['product_location']) ? $_POST['product_location'] : "";
									$product_location_key = isset($_POST['product_location_key']) ? $_POST['product_location_key'] : "";
									$product_location_qty = isset($_POST['product_location_qty']) ? $_POST['product_location_qty'] : "";
									
									$product_location_regular_price = isset($_POST['product_location_regular_price']) ? $_POST['product_location_regular_price'] : "";
									$product_location_sale_price = isset($_POST['product_location_sale_price']) ? $_POST['product_location_sale_price'] : "undefined";

									// wcmlim_allow_specific_location_241_location_id_22
									$_location_termid = $_COOKIE['wcmlim_selected_location_termid'];

									$allow_specific_location = get_post_meta($product_id, 'wcmlim_allow_specific_location_at_'.$_location_termid, true);
									
									if($allow_specific_location != 'Yes' && get_option('wcmlim_enable_specific_location') == "on")
									{
										$reserr = "2";
										echo $reserr;
										wp_die();
									}

									$isClearCart = get_option('wcmlim_clear_cart');
									if ($isClearCart == 'on') {
										$items = $woocommerce->cart->get_cart();
										$tmp_cart_location_id = '';
										foreach ($items as $item => $values) {
											if (empty($tmp_cart_location_id)) {
												$tmp_cart_location_id = $values['select_location']['location_termId'];
												if ($tmp_cart_location_id != $values['select_location']['location_termId'] || $values['select_location']['location_termId'] != $product_location_termid) {
													$reserr = '1';
													echo $reserr;
													wp_die();
												}
											}
										}
									}
									if ($passed_validation && 'publish' === $product_status) {
										
										$_location_data = array();
										$_location_data['select_location']['location_name'] = $product_location;
										$_location_data['select_location']['location_key'] = (int)$product_location_key;
										$_location_data['select_location']['location_qty'] = (int)$product_location_qty;
										$_location_data['select_location']['location_termId'] = (int)$product_location_termid;
										
										if($_isrspon == "on"){
											if(!empty($product_location_regular_price) && empty($product_location_sale_price)){
												$_location_data['select_location']['location_cart_price'] =  strip_tags(html_entity_decode(wc_price($product_location_regular_price)));
											}

											if(!empty($product_location_sale_price)){
												$_location_data['select_location']['location_cart_price'] = strip_tags(html_entity_decode(wc_price($product_location_sale_price)));
											}
											
											if(empty($product_location_regular_price) && empty($product_location_sale_price)){
												$_location_data['select_location']['location_cart_price'] = strip_tags(html_entity_decode(wc_price($product_price)));
											}
										}
										
										WC()->cart->add_to_cart($product_id, $quantity, '0', array(), $_location_data);

										WC_AJAX::get_refreshed_fragments();
									}

									wp_die();
								}
								
								public function wcmlim_woocommerce_price_class( $string )
								{
								    // Add new class
                                    $string = 'price wcmlim_product_price';
                                	return $string;
								}

								public function wcmlim_cart_item_price($price, $cart_item, $cart_item_key)
								{
									$manageStock = get_post_meta($cart_item["product_id"], '_manage_stock', true);
										if($manageStock == "no"){
											return (trim(strip_tags($price)));
										}
									
									$original_price = floatval($cart_item['data']->get_price()); // Product original price

									$price1 = strip_tags($cart_item['select_location']['location_cart_price']);
									// CALCULATION FOR EACH ITEM:
									if (!$price1) {
										$new_price = $original_price;
									} else {
										$new_price = $price1;
									}
									return $new_price;
								}

								public function wcmlim_location_stock_allowed_add_to_cart($passed, $product_id, $quantity)
								{	
									global $woocommerce;
									$pass_location = isset($_REQUEST['select_location']) ? $_REQUEST['select_location'] : "";
									$product_id = $_REQUEST['add-to-cart'];
									$manage_stock =  get_post_meta($product_id,'_manage_stock',true);
								
									if ($manage_stock != 'no') {
										
										if ($pass_location == -1) {
											wc_add_notice(__( $select_loc_va , 'wcmlim'), 'error');
											$passed = false;
											return $passed;
										}
									}
									else
									{
										$passed = true;
										return $passed;
									}

									
									
									$product = wc_get_product($product_id);
									if ( is_a( $product, 'WC_Product' ) ) {
										$isBackorder = $product->backorders_allowed();
										if ($isBackorder) {
											return true;
										}
									}

									if (WC()->cart->cart_contents_count == 0) {
										return true;
									}
									if (WC()->cart->cart_contents_count > 0) {
										foreach (WC()->cart->get_cart() as $key => $val) {
											if (isset($val['select_location']['location_qty']) && isset($val['select_location']['location_key'])) {
												$_product = $val['data'];
												$pro = wc_get_product($val['product_id']);
												$stock_invalid = get_option('wcmlim_prod_instock_valid');
												if ($pro->is_type('simple')) {

													// a simple product

													$_locqty = $val['select_location']['location_qty'];
													$cart_items_count = $val['quantity'];
													$total_count = ((int)$cart_items_count + (int)$quantity);

													if ($_POST['select_location'] == $val['select_location']['location_key'] && $product_id == $_product->get_id()) {
														if ($cart_items_count >= $_locqty || $total_count > $_locqty) {
															// Set to false
															$passed = false;
															// Display a message
															wc_add_notice(__( $stock_invalid , "wcmlim"), "error");
														}
													}
												} elseif ($pro->is_type('variable')) {

													// a variable product

													$_locqty = $val['select_location']['location_qty'];
													$cart_items_count = $val['quantity'];
													$total_count = ((int)$cart_items_count + (int)$quantity);

													if ($_POST['select_location'] == $val['select_location']['location_key'] && $_POST['variation_id'] == $_product->get_id()) {
														if ($cart_items_count >= $_locqty || $total_count > $_locqty) {
															// Set to false
															$passed = false;
															// Display a message
															wc_add_notice(__( $stock_invalid , "wcmlim"), "error");
														}
													}
												}
											}
										}
									}
									return $passed;
								}

								/**
								 * Add rewrite rule and tag to WP
								 */
								public function wcmlim_url_init()
								{
									// rewrite rule tells wordpress to expect the given url pattern
									add_rewrite_rule('^mlfilter/(.*)/?', 'index.php?locations=$matches[1]', 'top');
									// rewrite tag adds the matches found in the pattern to the global $wp_query
									add_rewrite_tag('%mlfilter%', '(.*)');
								}

								/**
								 * Modify the query based on our rewrite tag
								 */
								public function wcmlim_url_redirect()
								{

									// get the value of our rewrite tag
									$longerer = get_query_var('mlfilter');

									// look for the existence of our rewrite tag
									if (get_query_var('mlfilter')) {
										// get the post ID from the longerer string
									
										$location_Name = $longerer;

										// attempt to find the permalink associated with this post ID
										$permalink =  get_permalink($location_Name);
										// if valid, send to permalink
										if ($location_Name && $permalink) {
											wp_redirect($permalink);
										}
										// otherwise, send to homepage
										else {
											wp_redirect(home_url());
										}
										exit;
									}
									 $isClearCart = get_option('wcmlim_clear_cart');
                                    $location = null;
									$two_diff_loc = get_option('wcmlim_two_diff_loc_addtocart');
                                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {                                      
										$item_location_id = !empty($cart_item['select_location']['location_termId']) ? $cart_item['select_location']['location_termId'] : "";	
                                        $item_names = $cart_item['data']->get_name();  
                                        if ($isClearCart == 'on') {                                   							
                                            if(empty($location)){                                          
                                                $location = $item_location_id;
                                                continue;
                                            }
                                            if($location != $item_location_id){
                                                wc_add_notice( $two_diff_loc , 'error' );                                                		
                                                WC()->cart->remove_cart_item($cart_item_key);
                                                remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);									
                                                break;
                                            } 
                                        } 
                                    }
								}

								public function wcmlim_sortshop_product()
								{
									do_action("woocommerce_product_query");
									wp_die();
								}

								public function wcmlim_calculate_distance_search()
								{
									$api_key = get_option('wcmlim_google_api_key');
									$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									$search_lat = isset($_POST['search_lat']) ? $_POST['search_lat'] : false;
									$search_lng = isset($_POST['search_lng']) ? $_POST['search_lng'] : false;
									$calclate_dist = array();
									foreach ($terms as $k => $term) {
										$term_meta = get_option("taxonomy_$term->term_id");
										$term_meta = array_map(function ($term) {
											if (!is_array($term)) {
												return $term;
											}
										}, $term_meta);
										$get_address = $term_meta['wcmlim_street_number'] . ' ' . $term_meta['wcmlim_route'] . ' ' . $term_meta['wcmlim_locality'] . ' ' . $term_meta['wcmlim_administrative_area_level_1'] . ',' . $term_meta['wcmlim_country'] . ' - ' . $term_meta['wcmlim_postal_code'];
										$address = $term_meta['wcmlim_street_number'] . ' ' . $term_meta['wcmlim_route'] . ' ' . $term_meta['wcmlim_locality'] . ' ' . $term_meta['wcmlim_administrative_area_level_1'] . ' ' . $term_meta['wcmlim_postal_code'] . ' ' . $term_meta['wcmlim_country'];
										$address = str_replace(' ', '+', $address);
										$curl = curl_init();
										curl_setopt_array($curl, array(
											CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $api_key,
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_ENCODING => "",
											CURLOPT_MAXREDIRS => 10,
											CURLOPT_TIMEOUT => 0,
											CURLOPT_FOLLOWLOCATION => true,
											CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST => "GET",
										));
										$geocode = curl_exec($curl);
										$output = json_decode($geocode);
										curl_close($curl);
										$latitude = $output->results[0]->geometry->location->lat;
										$longitude = $output->results[0]->geometry->location->lng;
										$theta = $search_lng - $longitude;
										$dist = sin(deg2rad($search_lat)) * sin(deg2rad($latitude)) +  cos(deg2rad($search_lat)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
										$dist = acos($dist);
										$dist = rad2deg($dist);
										$miles = $dist * 60 * 1.1515;
										$slug = $term->slug;
										$get_address = $term_meta['wcmlim_street_number'] . ' ' . $term_meta['wcmlim_route'] . ' ' . $term_meta['wcmlim_locality'] . ' ' . $term_meta['wcmlim_administrative_area_level_1'] . ',' . $term_meta['wcmlim_country'] . ' - ' . $term_meta['wcmlim_postal_code'];
										$get_address_dir = str_replace(' ', '+', $get_address);
										$wcmlim_email = get_term_meta($term->term_id, 'wcmlim_email_regmanager', true);
										$html = "<div class='wcmlim-map-sidebar-list' id='$term->term_id'>
										<h4> $term->name </h4>
										<p class='location-address'>
											<span class='far fa-building'></span>
											<span> $get_address </span>
											<br />";

											if (isset($wcmlim_email) && !empty($wcmlim_email)) {
												$html = $html ."<span class='far fa-envelope-open'></span>
												<span> $wcmlim_email</span>";
											}
										
											$site_url = get_site_url();
											$html = $html ."</p>
										<button class='btn btn-primary' onclick=window.open('https://www.google.com/maps/dir/$get_address_dir', '_blank');>
										Direction </button>
										<button class='btn btn-primary' onclick=window.open('$site_url?locations=$slug', '_blank');>
											Shop Now </button>
									</div>";							
										$tmp_arr = array(
											"id" =>  $term->term_id,
											"distance" => $miles
										);
										array_push($calclate_dist, $tmp_arr);
									}
									$keys = array_column($calclate_dist, 'distance');
									array_multisort($keys, SORT_ASC, $calclate_dist);
									$calclate_dist = json_encode($calclate_dist);
									echo $calclate_dist;
									die();
								}

								//backorder for each location
								public function wcmlim_backorder4el(){
									global $woocommerce;
									$productID = sanitize_text_field($_POST['product_simple']);
									if($productID == ""){
										$productID = trim($_POST['product_vid']);
									}
									$term_key = $_POST['term_key'];
									$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									foreach($locations as $key=>$term){
											if($key == $term_key){
							 
													$term_name = $term->name;
													$term_id = $term->term_id;
													
											}}

										
									$product = wc_get_product( $productID );

									$postmeta_stock_at_term = get_post_meta($productID, 'wcmlim_stock_at_' . $term_id, true);
									$stz = 'wcmlim_allow_backorder_at_'.$term_id.'';
									$is_backorder_enabled = get_post_meta($productID ,$stz,true);
								if($is_backorder_enabled != "Yes" && $postmeta_stock_at_term >0){
									$response = "instk";
										echo $response;
								}else {
									if($is_backorder_enabled == "Yes"){
										//then show button
										$response = "show_btn";
										echo $response;
									}else{
										if($postmeta_stock_at_term < 1){
											echo "ofs";

										}else{
											if($postmeta_stock_at_term > 1){
												echo "instk";
											}
											echo "hide";
										}									
									}
								}
									
									wp_die();
								}

								//toggle for each location
								public function wcmlim_toggle_for_each_location(){
									echo 'hello';
								}

								//list advanced view location details results
								public function wcmlim_prepare_advanced_view_information(){
									global $prepare_op;
														$wcmlim_enable_price = get_option('wcmlim_enable_price');
									$product_id = $_POST['product_id'];
									$isLcex = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($isLcex)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isLcex));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
									$manage_stock = get_post_meta($product_id, '_manage_stock', true);
									$indexing = 1;
									foreach ($terms as $k => $term) {
										$location_id = $term->term_id;										
										$loc_stock_pid = get_post_meta($product_id, "wcmlim_stock_at_{$location_id}", true);
										$loc_each_backorder = get_post_meta($product_id, 'wcmlim_allow_backorder_at_'.$location_id, true);

										$stock_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$location_id}", true);
										$stock_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$location_id}", true);
										// $stock_regular_price = get_post_meta($product_id, "regular_price", true);
										$pml_product = wc_get_product( $product_id );
										$price = $pml_product->get_price();
										$sales_price = $pml_product->get_sale_price();
										$loc_start_time = get_term_meta($location_id, "wcmlim_start_time", true); 
										$loc_end_time = get_term_meta($location_id, "wcmlim_end_time", true); 
				
										if ($wcmlim_enable_price == 'on') {
											$loc_stock_pid = get_post_meta($product_id, "wcmlim_stock_at_{$location_id}", true);
											$stock_wcmlim_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$location_id}", true);
											$stock_wcmlim_stock_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$location_id}", true);
											if((!empty($stock_wcmlim_stock_sale_price)))
											{
												$stock_price = $stock_wcmlim_stock_sale_price;
											}
											elseif(($stock_wcmlim_regular_price != 0 && $stock_wcmlim_stock_sale_price == 0) || ($stock_wcmlim_regular_price != '' && $stock_wcmlim_stock_sale_price == ''))
											{
												$stock_price = $stock_wcmlim_regular_price;
											}
											elseif(($stock_wcmlim_regular_price == 0 && $stock_wcmlim_stock_sale_price == 0) || ($stock_wcmlim_regular_price == '' && $stock_wcmlim_stock_sale_price == ''))
											{
												$stock_price = $price;
											}
											else
											{
												$stock_price = $price;
											}
										}elseif((!empty($sales_price)))
										{
											$stock_price = $sales_price;
										}
										elseif(($stock_regular_price != 0 && $stock_sale_price == 0) || ($stock_regular_price != '' && $stock_sale_price == ''))
										{
											$stock_price = $price;
										}
										elseif(($stock_regular_price == 0 && $stock_sale_price == 0) || ($stock_regular_price == '' && $stock_sale_price == ''))
										{
											$stock_price = $price;
										}
										else
										{
											$stock_price = $price;
										}

										

										$shipping_cost = $this->wcmlim_calculate_shipping();
										if($loc_start_time != '' && $loc_end_time != ''){
											$prepare_op[] = array(
												"indexing" => intval($indexing),
												"location_id" => intval($location_id),
												"loc_stock_pid" => intval($loc_stock_pid),
												"loc_each_backorder" => $loc_each_backorder,
												"stock_price" => floatval($stock_price),
												"shipping_cost" => $shipping_cost,
												"location_start_time" => $loc_start_time,
												"location_end_time" => $loc_end_time
											);
										}
										else{
											$prepare_op[] = array(
												"indexing" => intval($indexing),
												"location_id" => intval($location_id),
												"loc_stock_pid" => intval($loc_stock_pid),
												"loc_each_backorder" => $loc_each_backorder,
												"stock_price" => floatval($stock_price),
												"shipping_cost" => $shipping_cost
											);
										}
										$indexing++;
									}
								
									if($manage_stock == 'yes')
									{
										echo json_encode($prepare_op);
									}
								   die();

								}
								public function wcmlim_calculate_shipping()
								{
									global $result;
									$prepare_shipping_cost_text = '';
									WC()->shipping->load_shipping_methods();
									WC()->shipping->reset_shipping();
									$currency_symbol = get_woocommerce_currency_symbol();
									
									$nearByAddress = $_COOKIE['wcmlim_nearby_location'];
									$nearByAddress = str_replace(' ', '+', $nearByAddress);
									$address = $this->getAddress($nearByAddress);
									$country  = $address['country'];
									$state    = $address['state'];
									$postcode = $address['postal_code'];
									$city     = $address['city'];
						  
									if ($postcode && !WC_Validation::is_postcode($postcode, $country)) {
									  throw new Exception(__('Please enter a valid postcode / ZIP.', 'woocommerce'));
									} elseif ($postcode) {
									  $postcode = wc_format_postcode($postcode, $country);
									}
						  
									if ($country) {
						  
									  WC()->customer->set_location($country, $state, $postcode, $city);
									  WC()->customer->set_shipping_location($country, $state, $postcode, $city);
									} else {
									  WC()->customer->set_to_base();
									  WC()->customer->set_shipping_to_base();
									}
						  
									WC()->customer->set_calculated_shipping(true);
									WC()->customer->save();
						  
									do_action('woocommerce_calculated_shipping');
						  
									WC()->shipping->calculate_shipping(WC()->cart->get_shipping_packages());
									$packages = WC()->shipping->get_packages();
						  
									if (count($packages) > 0) {
									  foreach ($packages as $i => $package) {
										if (count($package['rates']) > 0) {
										  foreach ($package['rates'] as $key => $value) {
											$result[$value->cost] = "<li>" . $value->label . " <span> - " . $currency_symbol . " " . $value->cost . "</span></li>";
										  }
										}
									  }
								}
								if(is_array($result))
								{
									$shipping_array_count = count($result);
							
									ksort($result);
									if(count($result) > 1)
									{
										$arr_inc_count = 1;
										foreach($result as $shipping_cost_key => $shipping_cost_value)
										{
											if($arr_inc_count == 1)
											{
											$prepare_shipping_cost_text .= $currency_symbol.$shipping_cost_key;
											}
											if($arr_inc_count == $shipping_array_count)
											{
											$prepare_shipping_cost_text .= '-'.$currency_symbol.$shipping_cost_key;
											}
											$arr_inc_count++;
										}
									}
									else
									{
										foreach($result as $shipping_cost_key => $shipping_cost_value)
										{
											$prepare_shipping_cost_text .= $currency_symbol.$shipping_cost_key;	
										}
									}
								}
								
								
									return $prepare_shipping_cost_text;
									die();
							}

							public function getAddress($address)
								{
									$GoogleAPIKEY = get_option('wcmlim_google_api_key');
									$geocode = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=$GoogleAPIKEY");
									$json = json_decode($geocode);
									$latitude = $json->results[0]->geometry->location->lat;
									$longitude = $json->results[0]->geometry->location->lng;
									
									// get zipcode
									$geocode = file_get_contents("https://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$GoogleAPIKEY");
									$json = json_decode($geocode);

									foreach($json->results[0]->address_components as $adr_node) {
										if($adr_node->types[0] == 'postal_code') {
											$postal_code =  $adr_node->long_name;
										}
										if($adr_node->types[0] == 'country') {
										$country = $adr_node->short_name;
										}
										if($adr_node->types[0] == 'administrative_area_level_1') {
										$state = $adr_node->short_name;
										}
										if($adr_node->types[0] == 'locality') {
										$city = $adr_node->long_name;
										} 
									}
									$addressString = array(
									'postal_code' => $postal_code,
									'country' => $country,
									'state' => $state,
									'city' => $city
									);
									
									return $addressString;
									wp_die();
								}


								// wcmlim_shipstation_custom_field_2
								public function wcmlim_shipstation_custom_field_2(){
									return '_location';
								}
							
								public function wcmlim_maybe_reduce_stock_levels($order_id)
								{

									// var_dump("you are here man");die;
									$order = wc_get_order($order_id);

									if (!$order) {
										return;
									}

									$stock_reduced  = $order->get_data_store()->get_stock_reduced($order_id);
									$trigger_reduce = apply_filters('woocommerce_payment_complete_reduce_order_stock', !$stock_reduced, $order_id);

									// Only continue if we're reducing stock.
									if (!$trigger_reduce) {
										return;
									}

									$this->wc_reduce_stock_levels($order);

									// Ensure stock is marked as "reduced" in case payment complete or other stock actions are called.
									$order->get_data_store()->set_stock_reduced($order_id, true);
								}

								public function wc_reduce_stock_levels($order_id)
								{

									if (is_a($order_id, 'WC_Order')) {
										$order    = $order_id;
										$order_id = $order->get_id();
									} else {
										$order = wc_get_order($order_id);
									}

									// We need an order, and a store with stock management to continue.
									if (!$order || 'yes' !== get_option('woocommerce_manage_stock') || !apply_filters('woocommerce_can_reduce_order_stock', true, $order)) {
										return;
									}

									$changes = array();
									$item_mail = array();
									// Loop over all items.

									// Given URL
									$url = $_SERVER['REQUEST_URI']; 
									
									// Search substring 
									$key = 'wp-json/wc-pos';
								
									// *WooCommerce Point Of Sale by Actuality Extensions compatibility
									$wc_pos_compatiblity1 = get_option('wcmlim_wc_pos_compatiblity');
    								if (($wc_pos_compatiblity1 == "on") && (in_array('woocommerce-point-of-sale/woocommerce-point-of-sale.php', apply_filters('active_plugins', get_option('active_plugins')))) && (strpos($url, $key) != false)) { 
																	
										$blogURL = get_bloginfo('url');
										$referer = $_SERVER['HTTP_REFERER'];
										$referer = str_replace($blogURL, "", $referer);
										$refe = explode("/", $referer);
										foreach($refe as $r => $s) {
											if($s == "point-of-sale")
											{
												$outletSlug = $refe[$r+1];
												$registerSlug = $refe[$r+2];
											}
										}
										
										$rargs = array(
											'post_type' => 'pos_register',
											'name' => $registerSlug,
											'post_status' => 'publish',
											'fields' => 'ids',
										);

										$registerPOST = get_posts($rargs);
										$regPostID = $registerPOST[0];
										$assignedOutletID = get_post_meta($regPostID, 'outlet', true);
										
										global $wpdb;
										$termMetaTable = $wpdb->prefix . 'termmeta';
										$getTermID = $wpdb->get_results("SELECT term_id FROM $termMetaTable WHERE meta_key = 'wcmlim_wcpos_compatiblity' AND meta_value = $assignedOutletID;");
										
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										
										
										$exclExists = get_option("wcmlim_exclude_locations_from_frontend");
										if (!empty($exclExists)) {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $exclExists));
										} else {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										}

										foreach ($order->get_items() as $item) {

											if (!$item->is_type('line_item')) {
												continue;
											}
	
											// Only reduce stock once for each item.
											$product            = $item->get_product();
											$product_id = $product->get_id();
											$item_stock_reduced = $item->get_meta('_reduced_stock', true);
	
											// *WooCommerce Point Of Sale by Actuality Extensions compatibility
	
											foreach ($getTermID as $key => $value) {
											
												$foundTermID= $value->term_id;
										
											if ($item_stock_reduced || !$product || !$product->managing_stock()) {
												continue;
											}
	
											$qty       = apply_filters('woocommerce_order_item_quantity', $item->get_quantity(), $order, $item);
											$item_name = $product->get_formatted_name();
										
											$order = wc_get_order( $order_id ); 

	
											$item->add_meta_data('_reduced_stock', $qty, true);
											$item->save();
												
											$this->wcpos_reduce_product_stock($product_id, $qty, $foundTermID, $order);
										
									   }
												
								     }
									
									}
									else{
									foreach ($order->get_items() as $item) {
										
										if (!$item->is_type('line_item')) {
											continue;
										}

										// Only reduce stock once for each item.
										$product            = $item->get_product();
										$item_stock_reduced = $item->get_meta('_reduced_stock', true);
										

											$item_selectedLocation_key = $item->get_meta('_selectedLocationKey', true);
												$itemSelLocTermId = $item->get_meta('_selectedLocTermId', true);
											$itemSelLocName = $item->get_meta('Location', true);
											$dataLocation = $item->get_meta('Location', true);
											

										$selLocQty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$itemSelLocTermId}", true);

										if ($item_stock_reduced || !$product || !$product->managing_stock()) {
											continue;
										}

										$qty       = apply_filters('woocommerce_order_item_quantity', $item->get_quantity(), $order, $item);
										$item_name = $product->get_formatted_name();
										$new_stock = $this->wc_update_product_stock($product, $qty, 'decrease', false, $item_selectedLocation_key);

										if (is_wp_error($new_stock)) {
											/* translators: %s item name. */
											$order->add_order_note(sprintf(_e('Unable to reduce stock for item %s.', 'woocommerce'), $item_name));
											continue;
										}

										$item->add_meta_data('_reduced_stock', $qty, true);
										$item->save();

										$changes[] = array(
											'product' => $product,
											'from'    => intval($new_stock) + intval($qty),
											'to'      => $new_stock,
										);

										$locChanges[] = array(
											'product' 	=> $product,
											'location'	=> $itemSelLocName,
											'from'    	=> $selLocQty,
											'to'      	=> intval($selLocQty) - intval($qty),
										);
										//send Mail
										if(!in_array( $itemSelLocTermId, $item_mail ) ) {
											$item_mail[] = $itemSelLocTermId;
										}
									}
									$dataLocate = array();
									 
									foreach($item_mail as $wcmlim_email_val) {
										
										$wcmlim_emailadd = get_term_meta($wcmlim_email_val, 'wcmlim_email', true);
										$shop_manager = get_term_meta($wcmlim_email_val, 'wcmlim_shop_manager', true);
										$term_object = get_term( $wcmlim_email_val );
										$dataLo = $term_object->term_id;										
										$dataLocate[] = $dataLo;
										if ($shop_manager) {
											$author_id = 	$shop_manager[0];
											$author_obj = get_user_by('id', $author_id);
											$author_email = $author_obj->user_email;	
											if($wcmlim_emailadd) {
												$wcmlimemail = $author_email . ", " . $wcmlim_emailadd;	
											}  else {
												$wcmlimemail = $author_email;	
											}												
										} else {
											$wcmlimemail = $wcmlim_emailadd;
										}
										/*Regional code */
										$regM = get_term_meta($wcmlim_email_val, "wcmlim_locator", true);
										$regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);
										$wcmlim_regemail = get_term_meta($regM, 'wcmlim_email_regmanager', true);
										if ($regM2) {
											$authorid = 	$regM2[0];
											$authorobj = get_user_by('id', $authorid);
											$authoremail = $authorobj->user_email;	
												if($wcmlim_regemail) {
													$regwcmlimemail = $authoremail . ", " . $wcmlim_regemail;		
												} else {
													$regwcmlimemail = $authoremail;		
												}	
										} else {
											$regwcmlimemail = $wcmlim_regemail;
										}
										
										if($regwcmlimemail) {
											$wcmlim_email = $regwcmlimemail . ", " . $wcmlimemail;		
										} else {
											$wcmlim_email = $wcmlimemail;		
										}	
										
										if (isset($wcmlim_email) && !empty($wcmlim_email)) {
											include(plugin_dir_path(dirname(__FILE__)) . 'public/partials/email-template.php');
										}
									}
									//update multiloc
									update_post_meta($order_id, "_multilocation", $dataLocate);	

									$wordCount = explode(" ", $dataLocation);
									if (count($wordCount) > 1) {
										$_location = str_replace(' ', '-', strtolower($dataLocation));
									} else {
										$_location = $dataLocation;
									}

									if (preg_match('/"/', $_location)) {
										$_location = str_replace('"', '', $_location);
									}

									update_post_meta($order_id, "_location", $_location);

									$this->wc_trigger_stock_change_notifications($order, $changes, $locChanges);

									do_action('woocommerce_reduce_order_stock', $order);
								 }
								}

								public function wcpos_reduce_product_stock($product_id, $qty, $location_id, $order)
								{
									
									$product_current_qty_at = get_post_meta($product_id, "wcmlim_stock_at_{$location_id}", true);
      								$postmeta_backorders_product = get_post_meta($product_id, '_backorders', true);
									
									if((($product_current_qty_at <= 0 ) || ($product_current_qty_at >= 0 ) || ( $product_current_qty_at = ''))  && (($postmeta_backorders_product == "yes") || ($postmeta_backorders_product == "notify")))
									{

									$product_updated_qty = intval($product_current_qty_at) - intval($qty);
									$term_name = get_term( $location_id )->name;

									$product = wc_get_product( $product_id );

									$loc_order_notes[]    = "{ Stock levels reduced: {$product->get_formatted_name()}  from Location: {$term_name} {$product_current_qty_at} &rarr; {$product_updated_qty} }";
									$order->add_order_note(implode(', ', $loc_order_notes));

									update_post_meta($product_id, "wcmlim_stock_at_{$location_id}", $product_updated_qty);

									return 1;	
									}
									else{
										if($qty > $product_current_qty_at){
									$product_updated_qty = 0;

										}
										else
										{
									$product_updated_qty = intval($product_current_qty_at) - intval($qty);
										}
									$term_name = get_term( $location_id )->name;

									$product = wc_get_product( $product_id );

									$loc_order_notes[]    = "{ Stock levels reduced: {$product->get_formatted_name()}  from Location: {$term_name} {$product_current_qty_at} &rarr; {$product_updated_qty} }";
									$order->add_order_note(implode(', ', $loc_order_notes));

									update_post_meta($product_id, "wcmlim_stock_at_{$location_id}", $product_updated_qty);

									return 1;	
									}
								}
								public function wc_update_product_stock($product, $stock_quantity = null, $operation = 'set', $updating = false, $item_selectedLocation_key=null)
								{

									if (!is_a($product, 'WC_Product')) {
										$product = wc_get_product($product);
									}

									if (!$product) {
										return false;
									}

									if (!is_null($stock_quantity) && $product->managing_stock()) {
										// Some products (variations) can have their stock managed by their parent. Get the correct object to be updated here.
										$product_id_with_stock = $product->get_stock_managed_by_id();
										$product_with_stock    = $product_id_with_stock !== $product->get_id() ? wc_get_product($product_id_with_stock) : $product;

										$data_store            = WC_Data_Store::load('product');

										$product_id = $product_with_stock->get_id();

										$exclExists = get_option("wcmlim_exclude_locations_from_frontend");
										if (!empty($exclExists)) {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $exclExists));
										} else {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										}
										
										// Fire actions to let 3rd parties know the stock is about to be changed.
										if ($product_with_stock->is_type('variation')) {
											foreach ($terms as $k => $term) {
												if ($k == $item_selectedLocation_key) {
													$variationParentTerms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => $term->term_id));
													if (!empty($variationParentTerms)) {
														foreach ($variationParentTerms as $vParentTerm) {
															$stockInpVariation[$vParentTerm->term_id] = get_post_meta($product_id, "wcmlim_stock_at_{$vParentTerm->term_id}", true);
														}
														$varParentValue = max($stockInpVariation);
														$varParentKey = array_search($varParentValue, $stockInpVariation);
														if ($varParentKey) {
															$maxStockAtVarSub = get_post_meta($product_id, "wcmlim_stock_at_{$varParentKey}", true);
															if ($operation == "decrease") {
																$varSubStock = ((int)$maxStockAtVarSub - (int)$stock_quantity);
															} else {
																$varSubStock = ((int)$maxStockAtVarSub + (int)$stock_quantity);
															}
															if (class_exists('SitePress')) {
																global $sitepress;
																$trid = $sitepress->get_element_trid($product_id, 'post_product');
																$translations = $sitepress->get_element_translations($trid, 'product');
																foreach ($translations as $lang => $translation) {
																	if ($translation->element_id != $product_id) {
																		update_post_meta($translation->element_id, "wcmlim_stock_at_{$varParentKey}", $varSubStock);
																	}
																}
																if (!$updating) {
																	$product_with_stock->save();
																}
															}
															
															update_post_meta($product_id, "wcmlim_stock_at_{$varParentKey}", $varSubStock);
															//OpenPos - Outlet stock updated
															$wcmlim_pos_compatiblity = get_option('wcmlim_pos_compatiblity');
															if ($wcmlim_pos_compatiblity == "on" && in_array('woocommerce-openpos/woocommerce-openpos.php', apply_filters('active_plugins', get_option('active_plugins')))) {
																$wcmlim_pos_id =  get_term_meta($term->term_id, 'wcmlim_pos_compatiblity', true);
																update_post_meta($product_id, "_op_qty_warehouse_{$wcmlim_pos_id}", $varSubStock);
															}
														}
													}
													$stock_in_location_variation = get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true);
													if ($operation == "decrease") {
														$stock = ((int)$stock_in_location_variation - (int)$stock_quantity);
													} else {
														$stock = ((int)$stock_in_location_variation + (int)$stock_quantity);
													}
													if (class_exists('SitePress')) {
														global $sitepress;
														$trid = $sitepress->get_element_trid($product_id, 'post_product');
														$translations = $sitepress->get_element_translations($trid, 'product');
														foreach ($translations as $lang => $translation) {
															if ($translation->element_id != $product_id) {
																update_post_meta($translation->element_id, "wcmlim_stock_at_{$term->term_id}", $stock);
															
															}
														}
														if (!$updating) {
															$product_with_stock->save();
														}
													}
													update_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", $stock);
													//OpenPos - Outlet stock updated
													$wcmlim_pos_compatiblity = get_option('wcmlim_pos_compatiblity');
													if ($wcmlim_pos_compatiblity == "on" && in_array('woocommerce-openpos/woocommerce-openpos.php', apply_filters('active_plugins', get_option('active_plugins')))) {
														$wcmlim_pos_id =  get_term_meta($term->term_id, 'wcmlim_pos_compatiblity', true);
														update_post_meta($product_id, "_op_qty_warehouse_{$wcmlim_pos_id}", $stock);
													}
												}
												
											}
											$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
											$stock = '';
											foreach($locations as $key=>$term){
													$stock  = intval(get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true));
													if($stock == '' || $stock == 0){
													 $removetermName[] = $term->slug;
													}else{
													 $termName[] = $term->slug;
													}
											 }
											wp_set_object_terms( $product_id, $termName, 'locations' );
											wp_remove_object_terms( $product_id, $removetermName, 'locations' );
											do_action('woocommerce_variation_before_set_stock', $product_with_stock);
										} else {

											foreach ($terms as $k => $term) {
												if ($k == $item_selectedLocation_key) {
													$parentTerms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => $term->term_id));
													if (!empty($parentTerms)) {
														foreach ($parentTerms as $parentTerm) {
															$stockInParentLocation[$parentTerm->term_id] = get_post_meta($product_id, "wcmlim_stock_at_{$parentTerm->term_id}", true);
														}
														$parentValue = max($stockInParentLocation);
														$parentKey = array_search($parentValue, $stockInParentLocation);
														if ($parentKey) {
															$maxStockAtSub = get_post_meta($product_id, "wcmlim_stock_at_{$parentKey}", true);
															if ($operation == "decrease") {
																$subStock = ((int)$maxStockAtSub - (int)$stock_quantity);
															} else {
																$subStock = ((int)$maxStockAtSub + (int)$stock_quantity);
															}
															if (class_exists('SitePress')) {
																global $sitepress;
																$trid = $sitepress->get_element_trid($product_id, 'post_product');
																$translations = $sitepress->get_element_translations($trid, 'product');
																foreach ($translations as $lang => $translation) {
																	if ($translation->element_id != $product_id) {
																		update_post_meta($translation->element_id, "wcmlim_stock_at_{$parentKey}", $subStock);
																	}
																}
																if (!$updating) {
																	$product_with_stock->save();
																}
															}
															update_post_meta($product_id, "wcmlim_stock_at_{$parentKey}", $subStock);
														}
													}
													$stock_in_location = get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true);
													if ($operation == "decrease") {
														$stock = ((int)$stock_in_location - (int)$stock_quantity);
													} else {
														$stock = ((int)$stock_in_location + (int)$stock_quantity);
													}
													if (class_exists('SitePress')) {
														global $sitepress;
														$trid = $sitepress->get_element_trid($product_id, 'post_product');
														$translations = $sitepress->get_element_translations($trid, 'product');
														foreach ($translations as $lang => $translation) {
															if ($translation->element_id != $product_id) {
																update_post_meta($translation->element_id, "wcmlim_stock_at_{$term->term_id}", $stock);
															}
														}if($stock == '' || $stock == 0){
															$removetermName[] = $term->slug;
														   }
														   wp_remove_object_terms( $product_id, $removetermName, 'locations' );
														if (!$updating) {
															$product_with_stock->save();
														}
													}

													update_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", $stock);
													//OpenPos - Outlet stock updated
													$wcmlim_pos_compatiblity = get_option('wcmlim_pos_compatiblity');

													if ($wcmlim_pos_compatiblity == "on" && in_array('woocommerce-openpos/woocommerce-openpos.php', apply_filters('active_plugins', get_option('active_plugins')))) {
														$wcmlim_pos_id =  get_term_meta($term->term_id, 'wcmlim_pos_compatiblity', true);
														update_post_meta($product_id, "_op_qty_warehouse_{$wcmlim_pos_id}", $stock);
													}
												}
											}

											$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
											$stock = '';
											foreach($locations as $key=>$term){
													$stock  = intval(get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true));
													if($stock == '' || $stock == 0){
													 $removetermName[] = $term->slug;
													}else{
													 $termName[] = $term->slug;
													}
											 }
											wp_set_object_terms( $product_id, $termName, 'locations' );
											wp_remove_object_terms( $product_id, $removetermName, 'locations' );
											do_action('woocommerce_product_before_set_stock', $product_with_stock);
										}

										// Update the database.
										$new_stock = $data_store->update_product_stock($product_id_with_stock, $stock_quantity, $operation);

										// Update the product object.
										$data_store->read_stock_quantity($product_with_stock, $new_stock);

										// If this is not being called during an update routine, save the product so stock status etc is in sync, and caches are cleared.
										if (!$updating) {
											$product_with_stock->save();
										}

										// Fire actions to let 3rd parties know the stock changed.
										if ($product_with_stock->is_type('variation')) {
											do_action('woocommerce_variation_set_stock', $product_with_stock);
										} else {
											do_action('woocommerce_product_set_stock', $product_with_stock);
										}

										return $product_with_stock->get_stock_quantity();
									}
									return $product->get_stock_quantity();
								}

								public function wc_trigger_stock_change_notifications($order, $changes, $locChanges)
								{
									if (empty($changes)) {
										return;
									}

									$order_notes     = array();
									$no_stock_amount = absint(get_option('woocommerce_notify_no_stock_amount', 0));

									foreach ($changes as $change) {
										$order_notes[]    = $change['product']->get_formatted_name() . ' ' . $change['from'] . '&rarr;' . $change['to'];
										$low_stock_amount = absint($this->wc_get_low_stock_amount(wc_get_product($change['product']->get_id())));
										if ($change['to'] <= $no_stock_amount) {
											do_action('woocommerce_no_stock', wc_get_product($change['product']->get_id()));
										} elseif ($change['to'] <= $low_stock_amount) {
											do_action('woocommerce_low_stock', wc_get_product($change['product']->get_id()));
										}

										if ($change['to'] < 0) {
											do_action(
												'woocommerce_product_on_backorder',
												array(
													'product'  => wc_get_product($change['product']->get_id()),
													'order_id' => $order->get_id(),
													'quantity' => abs($change['from'] - $change['to']),
												)
											);
										}
									}

									$order->add_order_note( implode(', ', $order_notes));				

									if (empty($locChanges)) {
										return;
									}

									foreach ($locChanges as $locChange) {										
										$loc_order_notes[]    = "{ Stock levels reduced: {$locChange['product']->get_formatted_name()}  from Location: {$locChange['location']} {$locChange['from']} &rarr; {$locChange['to']} }";
										
										$low_stock_amount = absint($this->wc_get_low_stock_amount(wc_get_product($locChange['product']->get_id())));
										if ($locChange['to'] <= $no_stock_amount) {
											do_action('woocommerce_no_stock', wc_get_product($locChange['product']->get_id()));
										} elseif ($locChange['to'] <= $low_stock_amount) {
											do_action('woocommerce_low_stock', wc_get_product($locChange['product']->get_id()));
										}

										if ($locChange['to'] < 0) {
											do_action(
												'woocommerce_product_on_backorder',
												array(
													'product'  => wc_get_product($locChange['product']->get_id()),
													'order_id' => $order->get_id(),
													'quantity' => intval($locChange['from']) - intval($locChange['to']),
												)
											);
										}
									}

									$order->add_order_note(implode(', ', $loc_order_notes));
								}

								public function wc_get_low_stock_amount(WC_Product $product)
								{
									if ($product->is_type('variation')) {
										$product = wc_get_product($product->get_parent_id());
									}
									$low_stock_amount = $product->get_low_stock_amount();
									if ('' === $low_stock_amount) {
										$low_stock_amount = get_option('woocommerce_notify_low_stock_amount', 2);
									}

									return $low_stock_amount;
								}

								public function wcmlim_maybe_increase_stock_levels($order_id)
								{
									//Check order as wc_order or it a ID
									if (is_a($order_id, 'WC_Order')) {
										$order    = $order_id;
										$order_id = $order->get_id();
									} else {
										$order = wc_get_order($order_id);
									}

									if (!$order) {
										return;
									}

									$stock_reduced    = $order->get_data_store()->get_stock_reduced($order_id);
									$trigger_increase = (bool) $stock_reduced;
									
									// Only continue if we're increasing stock.
									if (!$trigger_increase) {
										return;
									}

									$this->wc_increase_stock_levels($order);

									// Ensure stock is not marked as "reduced" anymore.
									$order->get_data_store()->set_stock_reduced($order_id, false);
								}

								public function wc_increase_stock_levels($order_id)
								{
									if (is_a($order_id, 'WC_Order')) {
										$order    = $order_id;
										$order_id = $order->get_id();
									} else {
										$order = wc_get_order($order_id);
									}

									// We need an order, and a store with stock management to continue.
									if (!$order || 'yes' !== get_option('woocommerce_manage_stock') || !apply_filters('woocommerce_can_restore_order_stock', true, $order)) {
										return;
									}

									$changes = array();
									$StoreTermID = array();
									// Loop over all items.
									foreach ($order->get_items() as $item) {
										if (!$item->is_type('line_item')) {
											continue;
										}

										// Only increase stock once for each item.
										$product            = $item->get_product();
										$item_stock_reduced = $item->get_meta('_reduced_stock', true);

										$item_selectedLocation_key = $item->get_meta('_selectedLocationKey', true);
										$itemSelLocTermId = $item->get_meta('_selectedLocTermId', true);
										$itemSelLocName = $item->get_meta('Location', true);
										$selLocQty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$itemSelLocTermId}", true);

										if (!$item_stock_reduced || !$product || !$product->managing_stock()) {
											continue;
										}

										$item_name = $product->get_formatted_name();
										$new_stock = $this->wc_update_product_stock($product, $item_stock_reduced, 'increase', false, $item_selectedLocation_key);

										if (is_wp_error($new_stock)) {
											/* translators: %s item name. */
											$order->add_order_note(sprintf(_e('Unable to restore stock for item %s.', 'woocommerce'), $item_name));
											continue;
										}

										$item->delete_meta_data('_reduced_stock');
										$item->save();

										$val_stock1 = ($new_stock - $item_stock_reduced);
										$changes[]    = "{ Stock levels increased : {$item_name} {$val_stock1} &rarr; {$new_stock} }";        
										
										$val_stock2 = ($selLocQty - $item_stock_reduced);        
										$locChanges[]    = "{ Stock levels increased from location : {$itemSelLocName} {$val_stock2} &rarr; {$selLocQty} }";        

										if(!in_array( $itemSelLocTermId, $StoreTermID ) ) {
											$StoreTermID[] = $itemSelLocTermId;
										}
									}

									$dataLocate = array(); 
									foreach($StoreTermID as $wcmlim_tid) {
										$term_object = get_term( $wcmlim_tid );
										$dataLo = $term_object->term_id;										
										$dataLocate[] = $dataLo;
									}    
									update_post_meta($order_id, "_multilocation", $dataLocate);	    

									if ($changes) {        
										$order->add_order_note(implode(', ', $changes));   
									}

									if ($locChanges) {        
										$order->add_order_note(implode(', ', $locChanges));       
									}

									do_action('woocommerce_restore_order_stock', $order);
								}
								public function wcmlim_stock_availability_location($text, $product)
								{
									$product_id = $product->get_id();
									$setLocation = isset($_COOKIE['wcmlim_selected_location_termid']) ? $_COOKIE['wcmlim_selected_location_termid'] : null;
									if($setLocation != null) {
										$soldoutlabel = get_option("wcmlim_soldout_button_text", true);
										$instocklabel = get_option("wcmlim_instock_button_text", true);
										$loc_stock = get_post_meta($product_id, "wcmlim_stock_at_{$setLocation}", true);         
										if (!$product->is_in_stock()) {											
											if($soldoutlabel) {
												$text = $loc_stock . ' ' . $soldoutlabel;
											 } else {
												$text = 'Sold out';
											 }
										} elseif ($product->is_in_stock()) {											
											if($instocklabel) {
												$text = $loc_stock . ' ' . $instocklabel;
											} else {
												$text = $loc_stock . ' In Stock';
											}										
										}
									}									
									return $text;
								}
								public function wcmlim_stock_availability_for_each_location($stock_text,$product){
									$stock = $product->get_stock_quantity();
									$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									$manage_stock = get_post_meta($product->get_id(), '_manage_stock', true);
									$arr_stock = array();
									foreach ($terms as $term) {
										 $allow_specific_location = get_post_meta($product->get_id(), 'wcmlim_allow_specific_location_at_' . $term->term_id, true);
										 if ($allow_specific_location  == 'Yes') {
											$loc_stock_val = intval(get_post_meta( $product->get_id(), "wcmlim_stock_at_{$term->term_id}" , true ));
											array_push($arr_stock, $loc_stock_val);
										}	
									}									
									$total_stock_qty = array_sum($arr_stock);
									 if ($total_stock_qty  > 0 && $manage_stock =='yes') {
										 $stock_text = $total_stock_qty .' is instock';
									}
									return $stock_text;
									
								}
								public function wcmlim_change_product_price($price_html, $product)
								{
									
									
									$setLocation = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : "";
									if ($product->get_type() == 'simple') {
										$terms = get_terms(['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0]);
										foreach ($terms as $k => $term) {
											$locRP = get_post_meta($product->get_id(), "wcmlim_regular_price_at_{$term->term_id}", true);
											$locSP = get_post_meta($product->get_id(), "wcmlim_sale_price_at_{$term->term_id}", true);
											$wRP = wc_price($locRP);
											$wSP = wc_price($locSP);
											if ($setLocation == $k) {
												if (!empty($locSP)) {
													$price_html = "<del>{$wRP}</del><ins>{$wSP}</ins>";
												} elseif (!empty($locRP)) {
													$price_html = $wRP;
												}
											}
										}
									}
									// 6068 show default variation price at locations on shop page code init
									$default_var_price = get_option('wcmlim_enable_location_onshop_variable');
									if($default_var_price == 'on'){
									if ($product->get_type() == 'variable') {
									
										$default_attributes = $product->get_default_attributes();
										foreach($product->get_available_variations() as $variation_values ){
											foreach($variation_values['attributes'] as $key => $attribute_value ){
												$attribute_name = str_replace( 'attribute_', '', $key );
												$default_value = $product->get_variation_default_attribute($attribute_name);
												if( $default_value == $attribute_value ){
													$is_default_variation = true;
												} else {
													$is_default_variation = false;
													break; 
												}
											}
											if( $is_default_variation ){
												$_var_id = $variation_values['variation_id'];
												break; 
											}
										}
										
										$terms = get_terms(['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0]);
										$selected_loc_id = $_COOKIE['wcmlim_selected_location'];
										$_var_id = isset($variation_values['variation_id']) ? $variation_values['variation_id'] : '';
										foreach($terms as $key=>$term){
											if($key == $selected_loc_id){
												$sel_term_id = $term->term_id;
											}}
											$locRP = get_post_meta($_var_id, "wcmlim_regular_price_at_{$sel_term_id}", true);
										
										foreach ($terms as $k => $term) {
											$locRP = get_post_meta($_var_id, "wcmlim_regular_price_at_{$sel_term_id}", true);
											
											$locSP = get_post_meta($_var_id, "wcmlim_sale_price_at_{$sel_term_id}", true);
											$wRP = wc_price($locRP);
											$wSP = wc_price($locSP);
											if ($setLocation == $k) {
												if (!empty($locSP)) {
													$price_html = "<del>{$wRP}</del><ins>{$wSP}</ins>";
												} elseif (!empty($locRP)) {
													$price_html = $wRP;
												}
											}
										}
									}
									
									if($product->get_type() == 'variable' && (empty($product->get_default_attributes()))){
										
										$terms = get_terms(['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0]);
										$selected_loc_id = $_COOKIE['wcmlim_selected_location'];
										foreach($terms as $key=>$term){
											if($key == $selected_loc_id){
												$sel_term_id = $term->term_id;
											}
										}

										foreach($product->get_available_variations() as $variation_values ){
												$_var_id[] = $variation_values['variation_id'];
										}
											
										foreach ($_var_id as $k => $var_id) {
											
											$locRP[] = get_post_meta($var_id, "wcmlim_regular_price_at_{$sel_term_id}", true);
											
											$locSP[] = get_post_meta($var_id, "wcmlim_sale_price_at_{$sel_term_id}", true);
										}

										if(is_array($locRP) && is_array($locSP)){
											$locRP = array_unique($locRP);
											$locSP = array_unique($locSP);
											sort($locRP);
											sort($locSP);
											$cp = (int)count($locRP) - 1;
											$cps = (int)count($locSP) - 1;
	
											$rminPrice = wc_price($locRP[0]);
											$rmaxPrice = wc_price($locRP[$cp]);
	
											
	
											$sminPrice = wc_price($locSP[0]);
											$smaxPrice = wc_price($locSP[$cps]);
	
	
											$price_html = "<del>{$rminPrice} - {$rmaxPrice}</del>  <ins>{$sminPrice} - {$smaxPrice}</ins>";
										}
										
									}

								}
									// show default variation price at locations on shop page code end
									return $price_html;
								}

								public function wcmlim_change_cookie_change_location()
								{
									$location_id = get_queried_object_id();
									$setLocation = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : "";
									$exclExists = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($exclExists)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $exclExists));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
									foreach ($terms as $k => $term) {
										$term_id = $term->term_id;
										if ((empty($setLocation))) {

											if($term_id == $location_id)
											{
												$_COOKIE['wcmlim_selected_location'] = $k;
												$_COOKIE['wcmlim_nearby_location'] = $k;
												$_COOKIE['wcmlim_selected_location_termid'] = $term_id;
												setcookie("wcmlim_selected_location", $k, time() + 36000, '/');
												setcookie("wcmlim_nearby_location", $k, time() + 36000, '/');
												setcookie("wcmlim_selected_location_termid", $term_id, time() + 36000, '/');
											}
										}
										else
										{
											if($term_id == $location_id)
											{
												if($setLocation != $k)
												{
													$_COOKIE['wcmlim_selected_location'] = $k;
													$_COOKIE['wcmlim_nearby_location'] = $k;
													$_COOKIE['wcmlim_selected_location_termid'] = $term_id;
													setcookie("wcmlim_selected_location", $k, time() + 36000, '/');
													setcookie("wcmlim_nearby_location", $k, time() + 36000, '/');
													setcookie("wcmlim_selected_location_termid", $term_id, time() + 36000, '/');
												}
											}
										}
									}
									
								}


								public function wcmlim_change_product_query($q)
								{
									
									$args = array(
										'post_type'      => 'product',
										'posts_per_page' => '-1'
									);
									
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post();
										global $product;
										if ( $product->is_type( 'simple' ) ) {
										  $product_id = $product->get_id();
										}
										if ( $product->is_type( 'variable' ) ) {
										  $variations1=$product->get_children();
										  foreach ($variations1 as $id){
											$vp_ids[] = $id; //variable product ids
										  }
										}
										if(!empty($product_id)){
											$all_ids[] = $product_id;
										}
									endwhile;
									wp_reset_query();
									
									//now get selected location id
									$selected_loc_id = $_COOKIE['wcmlim_selected_location'] ? $_COOKIE['wcmlim_selected_location'] : null ; 
									$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									foreach($locations as $key => $term){     
										if($key == $selected_loc_id){
											$term_ids = $term->term_id;
										}
									}
									if(is_array($vp_ids)){
										$all_ids = array_merge($all_ids, $vp_ids);
									}
									
									//now get stock at locations for each products
									foreach($all_ids as $pid){
											$prodw = wc_get_product( $pid );
											if($term_ids) {
												$stock_at_loc = get_post_meta($pid, "wcmlim_stock_at_{$term_ids}", true);
												$stock_at_loc = ( $stock_at_loc <= 0 || $stock_at_loc == null || $stock_at_loc == "undefined") ? 0 : 1; 
											  } else {		
													$stock_at_loc = intval($prodw->get_stock_quantity());
													$stock_at_loc = ( $stock_at_loc <= 0 || $stock_at_loc == null || $stock_at_loc == "undefined") ? 0 : 1; 
											  }
											if( $prodw->is_type( 'simple' ) ) {
											 if( $stock_at_loc == 0 ){
												$product_with_outstock[] = $pid;
											  } 
										 	} else {   
												$variation = wc_get_product($pid);
												$variation_backorder = $variation->backorders_allowed();
												if($stock_at_loc <= 0 || $stock_at_loc == null || $stock_at_loc == false){
													if($variation_backorder == '1' ){
														$withstock[] = $variation->get_parent_id();
													}
													$product_with_outstock[] = $variation->get_parent_id();
												}
												if($stock_at_loc > 0){
													$withstock[] = $variation->get_parent_id();
												}
										  	}
						            }
									if(!empty($withstock)){
									  $new_array = array_diff($product_with_outstock, $withstock);
									  $q->set( 'post__not_in', $new_array );
									  return;
									}else{
									  $q->set( 'post__not_in', $product_with_outstock ); 
									  return;
									}
								}

								public function wcmlim_widget_product_query($q)
								{
									$globalLocFilter = get_option("wcmlim_sort_shop_asper_glocation");
									if ($globalLocFilter == "on") {
										return true;
									}
									$location = isset($_COOKIE['wcmlim_widget_chosenlc']) ? $_COOKIE['wcmlim_widget_chosenlc'] : "";
									if ($location) {
										$tax_query[] = array(
											'taxonomy' => 'locations',
											'field'    => 'id',
											'terms'    => array($location),
										);
										$q->set('tax_query', $tax_query);
									}
								}



								public function woocommerce_template_loop_stock()
								{
									global $product;
									$setLocation = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : "";
									if ($product->get_type() == 'simple') {
										$exclExists = get_option("wcmlim_exclude_locations_from_frontend");
										if (!empty($exclExists)) {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $exclExists));
										} else {
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										}

										foreach ($terms as $k => $term) {
											$locationQty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$term->term_id}", true);
											if ($setLocation == $k && empty($locationQty)) {
												
												echo '<span class="locsoldout">' . __('Out of stock3', 'woocommerce') . '</span>';
											}
										}
									}
								}

								function woo_locations_info($atts)
								{	
									$isEditor = $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
									if(strpos($isEditor, 'wp-json/wp/')){
										return;
									}
									require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/shortcodes/locationInfoShortcode.php';
								}
								function woo_store_finder_list_view()
								{
									require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/shortcodes/locationFinderMapListShortcode.php';
								}
								
								function wcmlim_shortcode_atts_products( $out, $pairs, $atts, $shortcode ){
									if(isset($atts[ 'location_id' ]))
									{
										$out[ 'location_id' ] = $atts[ 'location_id' ];
									}  
									return $out;
								  }
								  
								  function wcmlim_woocommerce_shortcode_products_query( $query_args, $attributes ) {
								  
									if ( isset($attributes[ 'location_id' ])) {
										$location_id = $attributes[ 'location_id' ];
										// write your own $query_args here
										$query_args[ 'meta_query' ] = array(
											array(
												'key'     => "wcmlim_stock_at_$location_id",
												'compare' => 'EXISTS'
											)
										);
									  }
									return $query_args;
								  }

								function woo_store_finder()
								{
									require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/shortcodes/locationFinderMapShortcode.php';
								}
								function wcmlim_ajax_cart_count()
								{
									global $woocommerce;
									$items_count = count($woocommerce->cart->get_cart());
									echo $items_count;
									die();
								}
								function wcmlim_filter_map_product_wise()
								{									
									$api_key = get_option('wcmlim_google_api_key');
									$default_list_align = get_option('wcmlim_default_list_align');
									$default_origin_center = get_option('wcmlim_default_origin_center');
									$default_origin_center_modify = str_replace(' ', '+', $default_origin_center);

									$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									$result = [];
									$store_on_map_arr = [];
									$mapid = 1;
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($default_origin_center_modify) . '&sensor=false&key=' . $api_key,
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 0,
										CURLOPT_FOLLOWLOCATION => true,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "GET",
									));
									$geocode = curl_exec($curl);
									$output = json_decode($geocode);
									curl_close($curl);
									if (isset($output->results[0]->geometry->location->lat)) {
										$originlatitude = $output->results[0]->geometry->location->lat;
										$originlongitude = $output->results[0]->geometry->location->lng;
									} else {
										$originlatitude = 0;
										$originlongitude = 0;
									}
									$origin_store_on_map_str = array(
										"<div class='locator-store-block'><h4>" . $default_origin_center . "</h4></div>",
										floatval($originlatitude),
										floatval($originlongitude),
										intval($mapid),
										'origin'
									);
									array_push($store_on_map_arr, $origin_store_on_map_str);
									$mapid = 2;
									foreach ($terms as $k => $term) {
										$slug = $term->slug;
										$term_meta = get_option("taxonomy_$term->term_id");
										$term_meta = array_map(function ($term) {
											if (!is_array($term)) {
												return $term;
											}
										}, $term_meta);
										$prod_stoc_detail = "<div class='map-prod-details'> <strong> Filter - </strong><br>";
										if ($_REQUEST['searchtype'] == 'product') {
											foreach ($_REQUEST['parameter_id'] as $key => $parameter_id) {
											/* for variable products code start */
												$var_stock_count = 0;
											 $product = wc_get_product($parameter_id);
											 if ($product->is_type('variable')){
													
													$variations = $product->get_available_variations();
												if (!empty($variations)) {
													$var_stock_status = '';
													foreach ($variations as $value) {
														$variation_id = $value['variation_id'];
														$variation_obj = new WC_Product_variation($variation_id);
														$stockqty = $variation_obj->get_stock_quantity();
				
														$var_location_stock = get_post_meta($variation_id, 'wcmlim_stock_at_' . $term->term_id, true);

														 $var_stock_count += intval($var_location_stock);

														if( intval($var_stock_count) != 0 || $var_stock_count != ''  ){
															$var_stock_status = 'true';
														}
													}
												}
										     }
											else {
												$prod_location_stock = get_post_meta($parameter_id, 'wcmlim_stock_at_' . $term->term_id, true);
												}
								
												if ($product->is_type('variable')){
		
													if (intval($var_stock_count) == 0) {
														
														$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_outstock' href='" . $product->get_permalink() . "' target='_blank'>" . $product->get_name() . "-<span> 0 <span></a>";
													} else {
														$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_instock' href='" . $product->get_permalink() . "' target='_blank'>" . $product->get_name() . "-<span> " . $var_stock_count . "<span></a>";
													}

												}/* for variable products code end */
												else {

														if (empty($prod_location_stock) || $prod_location_stock == '0' || $prod_location_stock == 0 ) {
															$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_outstock' href='" . $product->get_permalink() . "' target='_blank'>" . $product->get_name() . "-<span> 0 <span></a>";
														} else {
															$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_instock' href='" . $product->get_permalink() . "' target='_blank'>" . $product->get_name() . "-<span> " . $prod_location_stock . "<span></a>";
														}
												}
											
											}
										} else {
											foreach ($_REQUEST['parameter_id'] as $key => $cat_parameter_id) {
												$category = get_term_by('slug', $cat_parameter_id, 'product_cat');
												$cat_id = $category->term_id; // Get the ID of a given category
												// Get the URL of this category
												$cat_link = get_category_link($cat_id);
												$all_ids = get_posts(array(
													'post_type' => 'product',
													'numberposts' => -1,
													'post_status' => 'publish',
													'fields' => 'ids',
													'tax_query' => array(
														array(
															'taxonomy' => 'product_cat',
															'field' => 'slug',
															'terms' => $cat_parameter_id, /*category name*/
															'operator' => 'IN',
														)
													),
												));
												$prod_location_stock_tmp = 0;
												foreach ($all_ids as $parameter_id) {
													$product = wc_get_product($parameter_id);
													$prod_location_stock = get_post_meta($parameter_id, 'wcmlim_stock_at_' . $term->term_id, true);
													$prod_location_stock_tmp = intval($prod_location_stock_tmp) + intval($prod_location_stock);
												}
												
												if (empty($prod_location_stock_tmp) || $prod_location_stock_tmp == '0' || $prod_location_stock_tmp == 0) {
													$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_outstock' href='" . $cat_link . "' target='_blank'>" . $cat_parameter_id . "</a>";
												} else {
													$prod_stoc_detail = $prod_stoc_detail . "<a class='map_cont_prod_link map_prod_instock' href='" . $cat_link . "' target='_blank'>" . $cat_parameter_id . "</a>";
												}
											}
										}
										$prod_stoc_detail = $prod_stoc_detail . "</div>";
										$get_address = $term_meta['wcmlim_street_number'] . ' ' . $term_meta['wcmlim_route'] . ' ' . $term_meta['wcmlim_locality'] . ' ' . $term_meta['wcmlim_administrative_area_level_1'] . ',' . $term_meta['wcmlim_country'] . ' - ' . $term_meta['wcmlim_postal_code'];
										$address = $term_meta['wcmlim_street_number'] . ' ' . $term_meta['wcmlim_route'] . ' ' . $term_meta['wcmlim_locality'] . ' ' . $term_meta['wcmlim_administrative_area_level_1'] . ' ' . $term_meta['wcmlim_postal_code'] . ' ' . $term_meta['wcmlim_country'];
										$address = str_replace(' ', '+', $address);
										$curl = curl_init();
										curl_setopt_array($curl, array(
											CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $api_key,
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_ENCODING => "",
											CURLOPT_MAXREDIRS => 10,
											CURLOPT_TIMEOUT => 0,
											CURLOPT_FOLLOWLOCATION => true,
											CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST => "GET",
										));
										$geocode = curl_exec($curl);
										$output = json_decode($geocode);
										curl_close($curl);
										$latitude = $output->results[0]->geometry->location->lat;
										$longitude = $output->results[0]->geometry->location->lng;
										$wcmlim_email = get_term_meta($term->term_id, 'wcmlim_email', true);
										$titletext = "<div class='locator-store-block' id='" . $term->term_id . "'><h4>" . $term->name . "</h4>";
										
										$site_url = get_site_url();
										$get_address_dir = str_replace(' ', '+', $get_address);
										if (isset($wcmlim_email) && !empty($wcmlim_email)) {
											$titletext = $titletext . "<p><span class='far fa-envelope'></span>" . $wcmlim_email . '</p>';
										}
										$titletext =  $titletext . "<p><span class='far fa-map'></span>" . $get_address . "</p>";
										$titletext =  $titletext . $prod_stoc_detail;
										$titletext =  $titletext . "<a class='marker-btn-1 btn btn-primary' target='_blank' href='https://www.google.com/maps/dir//$get_address_dir'> " . __('Direction', 'wcmlim') . " </a>";
										$titletext =  $titletext . "<a class='marker-btn-2 btn btn-primary' target='_blank' href='$site_url?locations=$slug'> " . __('Shop Now', 'wcmlim') . " </a></div>";
										$store_on_map_str = array(
											$titletext,
											floatval($latitude),
											floatval($longitude),
											intval($mapid),
											intval($term->term_id)
										);
										array_push($store_on_map_arr, $store_on_map_str);
										$mapid++;
									}
									update_option("store_on_map_prod_arr", json_encode($store_on_map_arr));

									$store_on_map_arr = json_encode($store_on_map_arr);
									echo $store_on_map_arr;
									die();
								}

								public function restore_order_stock( $order_id ) {
									$order = new WC_Order( $order_id );
						
									if ( ! get_option('woocommerce_manage_stock') == 'yes' && ! sizeof( $order->get_items() ) > 0 ) {
										return;
									}
						
									foreach ( $order->get_items() as $item ) {
						
										if ( $item['product_id'] > 0 ) {
											$_product = $order->get_product_from_item( $item );
						
											if ( $_product && $_product->exists() && $_product->managing_stock() ) {
													//OpenPos - Outlet stock updated
												$wcmlim_pos_compatiblity = get_option('wcmlim_pos_compatiblity');

												if ($wcmlim_pos_compatiblity == "on" && in_array('woocommerce-openpos/woocommerce-openpos.php', apply_filters('active_plugins', get_option('active_plugins')))) {
													$location_name = $item->get_meta('Location');
													$termid = $item->get_meta('_selectedLocTermId');
													$product_id = $_product->get_id();
													$wcmlim_pos_id =  get_term_meta($termid, 'wcmlim_pos_compatiblity', true);
													$poswarehouseStock = get_post_meta($item['product_id'], "_op_qty_warehouse_{$wcmlim_pos_id}", true);
													$locstockQty = get_post_meta($item['product_id'], "wcmlim_stock_at_{$termid}", true);
													$newqty = $poswarehouseStock + $item['qty'];
													$locstock = $locstockQty + $item['qty'];
													
													update_post_meta($item['product_id'], "_op_qty_warehouse_{$wcmlim_pos_id}", $newqty);
													update_post_meta($item['product_id'], "wcmlim_stock_at_{$termid}", $locstock);
												}
											}
										}
									}
								}
								/** since V3.1.1 */
								//each line item tax class code starts here
								public function overwrite_tax_calculation_to_use_product_tax_class_and_location_zip_code($item_tax_rates, $item, $cart)
								{
									$location_term_id = $_COOKIE['wcmlim_selected_location_termid'];
									$request = new WP_REST_Request( 'GET', "/wp/v2/locations/" . $location_term_id );
									$response = rest_do_request( $request );
									if ( !$response->is_error() ) {
										$server = rest_get_server();
										$data = $server->response_to_data( $response, false );
										$store_meta = $data["meta"];
							
										$current_location_standard_tax_rate = $this->get_tax_rate_for_location( $store_meta, '' );
										$current_location_reduced_tax_rate = $this->get_tax_rate_for_location($store_meta, 'reduced');
							
										switch ($item->tax_class) {
											case 'reduced':
												$rate = $current_location_reduced_tax_rate;
												break;
											default:
												$rate = $current_location_standard_tax_rate;
												break;
										}
										return $rate;
									} else {
										error_log('REST API call to get location_taxonomy for a given id failed: ' . $response->get_error_message());
									}
								}

								
							
								public function get_tax_rate_for_location($store_meta, $tax_class) {
									$wc_base_country = WC()->countries->get_base_country();
									$wc_states = WC()->countries->get_states( $wc_base_country );
							
									$tax_rate_object = WC_Tax::get_rates_from_location($tax_class,
										[
											$wc_base_country,
											array_search( strtolower( $store_meta['wcmlim_administrative_area_level_1'][0] ), array_map( 'strtolower',$wc_states ) ),
											$store_meta["wcmlim_postal_code"][0],
											strtoupper($store_meta['wcmlim_locality'][0])
										], null);
							
									return $tax_rate_object;
								}

								public function checking_order_is_in_location_radius( $rates, $package ){
									global $woocommerce;
									$rates_arr = array();
									$google_api_key = get_option('wcmlim_google_api_key');
									$destination = '';
										$country =  $package['destination']['country'];
										$state =  $package['destination']['state'];
										$postcode =  $package['destination']['postcode'];
										$city = $package['destination']['city'];

									 $destination = $country."+".$state."+".$postcode."+".$city;

									 $cart = $woocommerce->cart->cart_contents;
									 if(!empty($cart))
									 {
									 foreach ($cart as $array_item) {
                    
										if (isset($array_item['select_location']['location_name'])) {
											$product_name = $array_item['data']->get_name();
											$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false));
											foreach ($terms as $term) {
												if ($term->name == $array_item['select_location']['location_name']) {
													$_locRadius = 	get_term_meta( $term->term_id, 'wcmlim_service_radius_for_location', true );
													$term_meta = get_option("taxonomy_$term->term_id");
													$term_meta = array_map(function ($term) {
													  if (!is_array($term)) {
														return $term;
													  }
													}, $term_meta);
													$__spare = implode(" ", array_filter($term_meta));
													$__seleOrigin[] = str_replace(" ", "+", $__spare);
													if (isset($__seleOrigin[0])) {
														$origins = $__seleOrigin[0];
													}
													
							
													$curl = curl_init();
													curl_setopt_array($curl, array(
														CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $destination . "&key={$google_api_key}",
														CURLOPT_RETURNTRANSFER => true,
														CURLOPT_ENCODING => "",
														CURLOPT_MAXREDIRS => 10,
														CURLOPT_TIMEOUT => 0,
														CURLOPT_FOLLOWLOCATION => true,
														CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
														CURLOPT_CUSTOMREQUEST => "GET",
													));
									  
													$response = curl_exec($curl);
													$response_arr = json_decode($response);
													curl_close($curl);
													foreach ($response_arr->rows as $r => $t) {
														foreach ($t as $key => $value) {
															foreach ($value as $a => $b) {
																if ($b->status == "OK") {
																	$dis = explode(" ", $b->distance->text);
															
																}
															}
														}
													}
												
												if ($_locRadius < $dis[0]) {
													wc_clear_notices();
													wc_add_notice("We are not serving this area...", "error");
												}else {
													wc_clear_notices();
												}
												}
											}
										}
									}
								}
									return $rates;
								}

								public function wcmlim_restrict_user_instock_quantity_text( $availability, $product){
									if(get_option('wcmlim_enable_userspecific_location') == "on"){

										// Get the current user ID
										$user_id = get_current_user_id();

										// Get the user specific location
										$user_location = get_user_meta( $user_id, 'wcmlim_user_specific_location', true );
										if($user_location == "-1" || $user_location == ""){
											return $availability;
										}
										
										$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
										foreach($locations as $key=>$term){
											if($key == $user_location){
												$user_location_termid = $term->term_id;
											}
										}

										//get stock at location
										$stock = get_post_meta( $product->get_id(), 'wcmlim_stock_at_'.$user_location_termid, true );

										if ( $product->is_in_stock() && $product->managing_stock() ) $availability = $stock . __( ' in stock', 'woocommerce' );
										return $availability;
									}else{
										return $availability;
									}


								}


							}

							


						
							function distance_between_coordinates($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
								$theta = $longitude1 - $longitude2; 
								$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
								$distance = acos($distance); 
								$distance = rad2deg($distance); 
								$dis_unit = get_option("wcmlim_show_location_distance", true);
								$distance = $distance * 60 * 1.1515; 
								$distance = round($distance,2);
								switch($unit) { 
								  case 'miles':
									$distance = $distance; 
									break; 
								  case 'kilometers' : 
									$distance = $distance * 1.609344;
									$distance = $distance;
								} 
								
								return $distance; 
							  }

							function wcmlim_get_lat_lng($address, $termid){
								global $latlngarr;
									$api_key = get_option('wcmlim_google_api_key');
								$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $api_key,
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 0,
										CURLOPT_FOLLOWLOCATION => true,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "GET",
									));
									$geocode = curl_exec($curl);
									$output = json_decode($geocode);
								curl_close($curl);
									if (isset($output->results[0]->geometry->location->lat)) {
										$latitude = $output->results[0]->geometry->location->lat;
										$longitude = $output->results[0]->geometry->location->lng;
									} else {
										$latitude = 0;
										$longitude = 0;
									}
									update_term_meta($termid, 'wcmlim_lat', $latitude);
									update_term_meta($termid, 'wcmlim_lng', $longitude);

							
								$latlngarr = array(
								  'latitude'=>$latitude,
								  'longitude'=>$longitude
								);
								//update term meta lat lng
								
									return json_encode($latlngarr);
									wp_die();
							  }
