<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * 
 * @link       http://www.techspawn.com
 * @since      1.0.0
 * @package    Wcmlim
 * @subpackage Wcmlim/admin
 * @author     techspawn1 <contact@techspawn.com>
 */
class Wcmlim_Admin
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
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */

  private $option_name = 'wcmlim';

  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the admin area.
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
    if(isset($_GET['page']) && $_GET['page'] == "wcmlim-product-central") {
      wp_enqueue_style($this->plugin_name . 'css-datatable', 'https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css', array(), $this->version, 'all');   
      wp_enqueue_style($this->plugin_name . '-central', plugin_dir_url(__FILE__) . 'css/wcmlim-admin-central-min.css', array(), $this->version, 'all');
    } 
    wp_enqueue_style($this->plugin_name . '_chosen_css', plugin_dir_url(__FILE__) . 'css/chosen.min.css', array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wcmlim-admin-min.css', array(), $this->version, 'all');
    /*alertify css added*/
    wp_enqueue_style($this->plugin_name . 'alertify', plugin_dir_url(__FILE__) . 'css/alertify.min.css', array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name . 'alertify-theme', plugin_dir_url(__FILE__) . 'css/default.min.css', array(), $this->version, 'all');
    /* Display Preview */
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style($this->plugin_name . '_designbox_css', WCMLIM_URL_PATH . '/public/css/wcmlim-public-min.css', array(), $this->version, 'all');
    $customcss_enable = get_option('wcmlim_custom_css_enable');
    if ($customcss_enable == "") {
      wp_enqueue_style($this->plugin_name . '_frontview_css', WCMLIM_URL_PATH . '/public/css/wcmlim-frontview-min.css', array(), $this->version, 'all');
    }
  }

  /**
   * Register the JavaScript for the admin area.
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
    $api_key = get_option('wcmlim_google_api_key');
    if(isset($_GET['page']) && $_GET['page'] == "wcmlim-product-central") {
      wp_enqueue_script( 'wcmlim-datatable', 'https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js', array( 'jquery' ), '1.10.21', true );
      wp_enqueue_script($this->plugin_name . '_wcmlim_product-central', plugin_dir_url(__FILE__) . 'js/wcmlim-central-min.js', array('jquery'), $this->version . rand(), false);
    } 
    wp_enqueue_script($this->plugin_name . '_chosen_js', plugin_dir_url(__FILE__) . 'js/chosen.jquery.min.js', array('jquery'), $this->version . rand(), false);
    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wcmlim-admin-min.js', array('jquery'), $this->version . rand(), false);
    wp_enqueue_script($this->plugin_name. '_validation_js', plugin_dir_url(__FILE__) . 'js/product_edit_validation.min.js', array('jquery'), $this->version . rand(), false);

    wp_enqueue_script($this->plugin_name.'_deactivate', plugin_dir_url(__FILE__) . 'js/wcmlim-deactivate-min.js', array('jquery'), $this->version . rand(), false);
    /*alertify js added*/
    wp_enqueue_script($this->plugin_name . '_alerify', plugin_dir_url(__FILE__) . 'js/alertify.min.js', array('jquery'), $this->version . rand(), false);
    wp_localize_script($this->plugin_name, 'multi_inventory', array("ajaxurl" => admin_url("admin-ajax.php"), 'check_nonce' => wp_create_nonce('mi-nonce')));
    wp_enqueue_script($this->plugin_name . '_google_places', "https://maps.googleapis.com/maps/api/js?key={$api_key}&libraries=places&callback=Function.prototype", array('jquery'), $this->version, true);
    /* Display Preview && fontawesome */
    
     // Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code init
     $notexcludedLocations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
     $allowedcount_for_exclude = count($notexcludedLocations) - 1;
     $dataToPass = array(
       'keys' => $allowedcount_for_exclude
     );
     wp_localize_script( $this->plugin_name, 'passedData', $dataToPass );

     //Location widget enable disable setting 
     $locationWidget =  get_option('wcmlim_enable_location_widget');
     $_location_widget = array(
      'keys' => $locationWidget
    );
    wp_localize_script( $this->plugin_name, 'locationWidget', $_location_widget );
      // Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code end
      //
      // Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code init
     $notexcludedLocations_group = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0));
     $allowedcount_for_exclude_group = count($notexcludedLocations_group) - 1;
     $dataToPass_group = array(
       'keys' => $allowedcount_for_exclude_group
     );
     wp_localize_script( $this->plugin_name, 'passedData_group', $dataToPass_group );
       // Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code end

    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('wcmlim-fontawesome', "https://kit.fontawesome.com/82940a45e9.js", array('jquery'), $this->version, true);
    wp_enqueue_script($this->plugin_name . 'preview', plugin_dir_url(__FILE__) . 'js/wcmlim-admin-preview-min.js', array('jquery'), $this->version . rand(), false);
    /* bulk assign location to users and products */
    wp_enqueue_script($this->plugin_name . '_set_bulk_defaultloc', plugin_dir_url(__FILE__) . 'js/set-bulk-default-loc-min.js', array('jquery'), $this->version . rand(), false);
    /*update all products js*/
    wp_enqueue_script($this->plugin_name . '_update_all_products', plugin_dir_url(__FILE__) . 'js/updateallproducts-min.js', array('jquery'), $this->version . rand(), false);
    wp_enqueue_script($this->plugin_name . '_update_all_orders', plugin_dir_url(__FILE__) . 'js/wcmlim-order-update-min.js', array('jquery'), $this->version . rand(), false);

    $enable_COGSprice = get_option('wcmlim_enable_COGSprice');
    if ($enable_COGSprice == 'on') {
      wp_enqueue_script($this->plugin_name . '_cogsValidation', plugin_dir_url(__FILE__) . 'js/wcmlim-cogs-validation-min.js', array('jquery'), $this->version . rand(), false);
    }
    
  }
  
  /**
	 * Show feedback_form_module options on plugin page.
	 *
	 * update 3.0.3
	 */
	public function feedback_form_module()
	{
    $currentUser = wp_get_current_user();
    $currentUserEmail = $currentUser->user_email;
    $currentDomain = $_SERVER['SERVER_NAME'];
    $plugin = basename( "WooCommerce-Multi-Locations-Inventory-Management" );
    $html_op = '
                  <div id="wcmlim_deactivator_popup" class="wcmlim-modal" style="display:none;"  >
                  
                  
                
    <!-- Modal content -->
    
    <div class="wcmlim-modal-content" style="width: 65%"  >
    
      <div class="wcmlim-modal-header" >
        <span class="wcmlim-close">&times;</span>
        <h2><i class="fa fa-commenting" aria-hidden="true"></i>
        <strong>Quick Feedback<span class="wcmlim_stock_modal_product_name"></span></strong></h2>
      </div>
      
      <div class="wcmlim-modal-body" >
      <div style="display:none;">
      <input type="text" name="wcmlim-user-email"  id="wcmlim-user-email" value="'.$currentUserEmail.'">
      <input type="text" name="wclim-user-domain"  id="wclim-user-domain" value= "'.$currentDomain.'">
      <input type="text" name="wclim-user-plugin"  id="wclim-user-plugin" value= "'.$plugin.'">
      </div>
      <h4>If you have a moment, please share why you are deactivating Multilocation Plugin</h4>
      <table class="form-table" role="presentation">
      <tbody>';
        
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://demo.techspawn.com/Analytics/API/wcmlim/read_options/get_options",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
              "accept: application/json",
              "content-type: application/json"
              ),
            ));
            
            $response = curl_exec($curl); 
            curl_close($curl);
            
            $response_arr = json_decode($response);
            if (isset($response_arr) && !empty($response_arr)) {
              foreach($response_arr as $key => $value)
              {
                
                $option_name = $value->name;
                $option_value = $value->value;
                $html_op .= '<tr class="form-field form-required">
                <td><input name="wcmlim_feedback_option" type="radio" class="wcmlim_stock_modal_location_stock" id="wcmlim_stock_modal_location_stock" value="'.$option_value.'">'.$option_name.'</td>
              </tr>';

              }
            }     
            $html_op .=' 
      </tbody> 
      <tr>
        <td>We do not collect any personal data when you submit this form. Its your feedback that we value.</td>
      </tr>
      </table>
      <hr/>
      <br/>
      <button class="button button-primary wcmlim_update_deactivate_submit" id="wcmlim_submit_deactive" type="button" >Submit and Deactivate </button>
      <button class="button button-primary wcmlim_update_deactivate_skip" id="wcmlim_skip_deactive" type="button" style="width: 30%;">Skip and Deactivate </button>
      <p class="wcmlim_update_inline_stock_msg">&nbsp;</p>
      </div>
    </div>
    </div>';
    echo $html_op;
	}
  
	/**
	 * Show doc and support options on plugin page.
	 *
	 * @since 1.2.8
	 */
	public function plugin_row_meta($plugin_meta, $plugin_file)
	{
	  if (WCMLIM_BASE === $plugin_file) {
		$row_meta = [
		  'docs' => '<a href="https://techspawn.com/docs/woocommerce-multi-locations-inventory-management/" aria-label="' . esc_attr(__('View Documentation', 'wcmlim')) . '" target="_blank">' . __('Docs', 'wcmlim') . '</a>',
		  'ideo' => '<a href="http://techspawn.com/support/" aria-label="' . esc_attr(__('Support', 'wcmlim')) . '" target="_blank">' . __('Support', 'wcmlim') . '</a>',
		];

		$plugin_meta = array_merge($plugin_meta, $row_meta);
	  }

	  return $plugin_meta;
	}

  /**
   * Register the Menu page for the plugin.
   *
   * @since    1.0.0
   */

  public function wcmlim_register_menu_page()
  {
    $isLocationsGroup = get_option('wcmlim_enable_location_group');
    add_menu_page(
      __('Multi Locations', 'wcmlim'),
      __('Multi Locations', 'wcmlim'),
      'manage_options',
      'multi-location-inventory-management',
      array($this, 'wcmlim_menu_page'),
      plugins_url('WooCommerce-Multi-Locations-Inventory-Management/admin/img/pins.png'),
      '65'
    );
    if (get_option('wcmlim_license') == '' || get_option('wcmlim_license') == 'invalid') {
      add_submenu_page(
        'multi-location-inventory-management',
        __('Settings', 'wcmlim'),
        __('Settings', 'wcmlim'),
        'manage_options',
        'multi-location-inventory-management'
      );
      if ($isLocationsGroup == 'on' ) {
        add_submenu_page(
          'multi-location-inventory-management',
          __('Manage Group', 'wcmlim'),
          __('Manage Group', 'wcmlim'),
          'manage_options',
          'multi-location-inventory-management'
        );
      }
      add_submenu_page(
        'multi-location-inventory-management',
        __('Manage Locations', 'wcmlim'),
        __('Manage Locations', 'wcmlim'),
        'manage_options',
        'multi-location-inventory-management'
      );

      add_submenu_page(
        'multi-location-inventory-management',
        __('Display Settings', 'wcmlim'),
        __('Display Settings', 'wcmlim'),
        'manage_options',
        'multi-location-inventory-management'
      );
      add_submenu_page(
        'multi-location-inventory-management',
        __('Locations on Map', 'wcmlim'),
        __('Locations on Map', 'wcmlim'),
        'manage_options',
        'multi-location-inventory-management'
      );
    } else {
      add_submenu_page(
        'multi-location-inventory-management',
        __('Settings', 'wcmlim'),
        __('Settings', 'wcmlim'),
        'manage_options',
        'multi-location-inventory-management',
        array($this, 'wcmlim_menu_page')
      );
      if ($isLocationsGroup == 'on' ) {
        add_submenu_page(
          'multi-location-inventory-management',
          __('Manage Group', 'wcmlim'),
          __('Manage Group', 'wcmlim'),
          'manage_options',
          'edit-tags.php?taxonomy=location_group&post_type=product'
        );
      }
      add_submenu_page(
        'multi-location-inventory-management',
        __('Manage Locations', 'wcmlim'),
        __('Manage Locations', 'wcmlim'),
        'manage_options',
        'edit-tags.php?taxonomy=locations&post_type=product'
      );

      add_submenu_page(
        'multi-location-inventory-management',
        __('Display Settings', 'wcmlim'),
        __('Display Settings', 'wcmlim'),
        'manage_options',
        'wcmlim-display-settings',
        array($this, 'wcmlim_display_settings')
      );
      add_submenu_page(
        'multi-location-inventory-management',
        __('Product Central', 'wcmlim'),
        __('Product Central', 'wcmlim'),
        'manage_options',
        'wcmlim-product-central',
        array($this, 'wcmlim_display_products')
      );
      add_submenu_page(
        'multi-location-inventory-management',
        __('Locations On Map', 'wcmlim'),
        __('Locations On Map', 'wcmlim'),
        'manage_options',
        'wcmlim-map-settings',
        array($this, 'wcmlim_map_settings')
      );
      add_submenu_page(
        'multi-location-inventory-management',
        __('Addons' , 'wcmlim'),
        __('Addons' , 'wcmlim'),
        'manage_options',
        'wcmlim-addon-settings',
        array($this, 'wcmlim_addon_settings')
      );
    }
    
  }

  /**
   * Stock wise product sorting as per location on shop-page.
   *
   * @since    3.0.1
   */

  public function filter_woocommerce_get_catalog_ordering_args( $args ) {

    $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
    $loc_key = isset($_COOKIE['wcmlim_selected_location']) ? $_COOKIE['wcmlim_selected_location'] : 0;
    
    if ( $orderby_value == 'high-to-low' ) {
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        $args['meta_key'] = "wcmlim_stock_at_".$terms[$loc_key]->term_id;
    }
    if ( $orderby_value == 'low-to-high' ) {
      $args['orderby'] = 'meta_value_num';
      $args['order'] = 'ASC';
      $args['meta_key'] = "wcmlim_stock_at_".$terms[$loc_key]->term_id;
    }
    return $args;
  }
  public function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['high-to-low'] = 'Sort By Stock: High To Low';
    $sortby['low-to-high'] = 'Sort By Stock: Low To High';
    return $sortby;
  }

  /**
   * Hightlight the submenu page for custom taxonomy.
   *
   * @since    1.0.0
   */

  public function wcmlim_submenu_highlight($parent_file)
  {
    global $current_screen;
    $taxonomy = $current_screen->taxonomy;
    if ($taxonomy == 'locations') {
      $parent_file = 'multi-location-inventory-management';
    } else if ($taxonomy == 'location_group') {
      $parent_file = 'multi-location-inventory-management';
    }
    return $parent_file;
  }

  /**
   * Hightlight the submenu page is active for custom taxonomy.
   *
   * @since    1.0.0
   */

  public function wcmlim_hightlight_submenu($submenu_file)
  {
    $locations = 'edit-tags.php?taxonomy=locations&post_type=product';
    $loc_group = 'edit-tags.php?taxonomy=location_group&post_type=product';    
    
    if (esc_html($locations) == $submenu_file) {       
        //$submenu_file = $locations;
        return 'edit-tags.php?taxonomy=locations&post_type=product';
    }
    elseif (esc_html($loc_group) == $submenu_file) {       
       // $submenu_file = $loc_group;
        return 'edit-tags.php?taxonomy=location_group&post_type=product';
    }
    return $submenu_file;
  }

  /**
   * load the admin page.
   *
   * @since    1.0.0
   */

  public function wcmlim_menu_page()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-admin-display.php';
  }

  /**
   * load the display settings page.
   *
   * @since    1.0.0
   */

  public function wcmlim_display_settings()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-display-settings.php';
  }

  /**
   * load the map settings page.
   *
   * @since    1.0.0
   */

  public function wcmlim_map_settings()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-map-settings.php';
  }

  public function wcmlim_addon_settings()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-addon-settings.php';
  }

  /**
   * Product Central Callback Function.
   *
   * @since    1.2.9
   */

  public function wcmlim_display_products()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-product-central.php';
  }

  /**
   * load the location shortcode settings page.
   *
   * @since    1.0.0
   */

  public function wcmlim_location_shortcode_settings()
  {
    require plugin_dir_path(__FILE__) . 'partials/wcmlim-location-shortcode-settings.php';
  }


  /**
   * Register the settings for plugin.
   *
   * @since    1.0.0
   */

  public function wcmlim_register_setting()
  {
    // general setting section
    add_settings_section(
      $this->option_name . '_general',
      __('General', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name
    );

    add_settings_field(
      $this->option_name . '_enable_userspecific_location',
      __('Restrict users to specific location', 'wcmlim'),
      array($this, $this->option_name . '_enable_userspecific_location_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_enable_userspecific_location')
    );
    $isLocationsGroup = get_option('wcmlim_enable_location_group');
    if($isLocationsGroup == 'on'){
      $excludedLocationGroup = get_option($this->option_name . '_exclude_locations_group_frontend');
   
    add_settings_field(
      $this->option_name . '_exclude_locations_group_frontend',
      __('Exclude Location Group From FrontEnd', 'wcmlim'),
      array($this, $this->option_name . '_exclude_locations_group_frontend_cb'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_exclude_locations_group_frontend')
      );}

    add_settings_field(
      $this->option_name . '_exclude_locations_from_frontend',
      __('Exclude Locations From FrontEnd', 'wcmlim'),
      array($this, $this->option_name . '_exclude_locations_from_frontend_cb'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_exclude_locations_from_frontend')
    );

    add_settings_field(
      $this->option_name . '_next_closest_location',
      __('Show Next Closest in stock Location', 'wcmlim'),
      array($this, $this->option_name . '_next_closest_location_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_next_closest_location')
    );

    add_settings_field(
      $this->option_name . '_distance_calculator_by_coordinates',
      __('Distance Calculator Using Coordinates', 'wcmlim'),
      array($this, $this->option_name . '_distance_calculator_by_coordinates_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_distance_calculator_by_coordinates')
    );

    add_settings_field(
      $this->option_name . '_hide_out_of_stock_location',
      __('Hide Locations from Dropdown/List if they are Out Of Stock', 'wcmlim'),
      array($this, $this->option_name . '_hide_out_of_stock_location_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_hide_out_of_stock_location')
    );

    add_settings_field(
      $this->option_name . '_clear_cart',
      __('Limit 1 location per order', 'wcmlim'),
      array($this, $this->option_name . '_clear_cart_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_general')
    );

   
    add_settings_field(
      $this->option_name . '_pos_compatibility',
      __('OpenPOS Compatibility', 'wcmlim'),
      array($this, $this->option_name . '_pos_compatibility_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_pos_compatiblity')
    );

    add_settings_field(
      $this->option_name . '_wc_pos_compatiblity',
      __('WooCommerce Point of Sale Compatibility', 'wcmlim'),
      array($this, $this->option_name . '_wc_pos_compatibility_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_wc_pos_compatiblity')
    );
  
    add_settings_field(
      $this->option_name,
      __('<div class="wcmlim-form-divider">Backend Only Mode <hr></div>', 'wcmlim'),     
      array($this, $this->option_name . '_general_backend_mode'),
      $this->plugin_name,
      $this->option_name . '_general'
    );

    add_settings_field(
      $this->option_name . '_order_fulfil_edit',
      __('Allow to Fulfil Order from Backend', 'wcmlim'),
      array($this, $this->option_name . '_order_fulfil_edit_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_order_fulfil_edit' , 'class' => 'hidden')
    );

    add_settings_field(
      $this->option_name . '_allow_only_backend',
      __('Allow to Work plugin from Backend Only', 'wcmlim'),
      array($this, $this->option_name . '_allow_only_backend_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_allow_only_backend')
    );

    add_settings_field(
      $this->option_name . '_order_fulfilment_rules',
      __('Order Fulfilment Rules', 'wcmlim'),
      array($this, $this->option_name . '_order_fulfilment_rules_callback'),
      $this->plugin_name,
      $this->option_name . '_general',
      array('label_for' => $this->option_name . '_order_fulfilment_rules')
    );

    register_setting($this->plugin_name, $this->option_name . '_clear_cart');
    
    register_setting($this->plugin_name, $this->option_name . '_enable_userspecific_location');
    register_setting($this->plugin_name, $this->option_name . '_show_location_selection');
    register_setting($this->plugin_name, $this->option_name . '_pos_compatiblity');
    register_setting($this->plugin_name, $this->option_name . '_wc_pos_compatiblity');
    register_setting($this->plugin_name, $this->option_name . '_exclude_locations_group_frontend');
    register_setting($this->plugin_name, $this->option_name . '_exclude_locations_from_frontend');
    register_setting($this->plugin_name, $this->option_name . '_next_closest_location');
    register_setting($this->plugin_name, $this->option_name . '_distance_calculator_by_coordinates');
    register_setting($this->plugin_name, $this->option_name . '_hide_out_of_stock_location');
    register_setting($this->plugin_name, $this->option_name . '_order_fulfil_edit');
    register_setting($this->plugin_name, $this->option_name . '_allow_only_backend');
    register_setting($this->plugin_name, $this->option_name . '_order_fulfilment_rules');

    // Location Shortcode setting section
    add_settings_section(
      $this->option_name . '_location_shortcode_settings',
      __('Location Settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name . '_location_shortcode_settings'
    );

    add_settings_field(
      $this->option_name . '_google_api_key',
      __('Enter Your Google API Key', 'wcmlim'),
      array($this, $this->option_name . '_google_api_key_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_google_api_key')
    );

    add_settings_field(
      $this->option_name . '_enable_autodetect_location',
      __('Detect location on Page load', 'wcmlim'),
      array($this, $this->option_name . '_enable_autodetect_location_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_autodetect_location')
    );

    add_settings_field(
      $this->option_name . '_geo_location',
      __('Nearby location finder', 'wcmlim'),
      array($this, $this->option_name . '_geo_location_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_geo_location')
    );

    add_settings_field(
      $this->option_name . '_enable_price',
      __('Regular and Sale Price for Each location', 'wcmlim'),
      array($this, $this->option_name . '_enable_price_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_price')
    );

    add_settings_field(
      $this->option_name . '_location_fee',
      __('Custom Fee for Each location', 'wcmlim'),
      array($this, $this->option_name . '_location_fee_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_location_fee')
    );

     //Enable Backorder
     add_settings_field(
      $this->option_name . '_enable_backorder_for_locations',
      __('Backorder For Each Location', 'wcmlim'),
      array($this, $this->option_name . '_enable_backorder_for_locations_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_backorder_for_locations')
    );

    //Enable specific location
    add_settings_field(
      $this->option_name . '_enable_specific_location',
      __('Enable Locations For Each Product', 'wcmlim'),
      array($this, $this->option_name . '_enable_specific_location_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_specific_location')
    );

     add_settings_field(
      $this->option_name . '_enable_location_widget',
      __('Enable Location As a Category', 'wcmlim'),
      array($this, $this->option_name . '_enable_location_widget_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_location_widget')
    );

    add_settings_field(
      $this->option_name . '_enable_COGSprice',
      __('COGS Price for Each location', 'wcmlim'),
      array($this, $this->option_name . '_enable_COGSprice_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_COGSprice')
    );

    add_settings_field(
      $this->option_name . '_restore_location_stock',
      __('Restore location stock value', 'wcmlim'),
      array($this, $this->option_name . '_restore_location_stock_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_restore_location_stock')
    );

    add_settings_field(
      $this->option_name . '_hide_show_location_dropdown',
      __('Hide location dropdown/list on product page', 'wcmlim'),
      array($this, $this->option_name . '_hide_show_dropdown_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_hide_show_location_dropdown')
    );

    add_settings_field(
      $this->option_name . '_set_location_cookie_time',
      __('Set Location Cookie Time', 'wcmlim'),
      array($this, $this->option_name . '_set_location_cookie_time_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_set_location_cookie_time')
    );

    add_settings_field(
      $this->option_name . '_enable_default_location',
      __('Enable default location', 'wcmlim'),
      array($this, $this->option_name . '_enable_default_location_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_default_location')
    );
    
    add_settings_field(
      $this->option_name . '_cron_for_product',
      __('Set cron job for product update', 'wcmlim'),
      array($this, $this->option_name . '_cron_for_product_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_cron_for_product')
    );

    add_settings_field(
      $this->option_name . '_service_radius_for_location',
      __('Set service radius to each location', 'wcmlim'),
      array($this, $this->option_name . '_service_radius_for_location_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_service_radius_for_location')
    );

    add_settings_field(
      $this->option_name . '_get_direction_for_location',
      __('Get Direction on map for selected location', 'wcmlim'),
      array($this, $this->option_name . '_get_direction_for_location_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_get_direction_for_location')
    );


    add_settings_field(
      $this->option_name,
      __('<div class="wcmlim-form-divider">Location Group <hr></div>', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_general')     
    );

    add_settings_field(
      $this->option_name . '_assign_location_shop_manager',
      __('Set users as a Location Shop /Location Regional manager', 'wcmlim'),
      array($this, $this->option_name . '_assign_location_shop_manager_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_assign_location_shop_manager')
    );


    add_settings_field(
      $this->option_name . '_enable_location_group',
      __('Enable location group', 'wcmlim'),
      array($this, $this->option_name . '_enable_location_group_callback'),
      $this->plugin_name . '_location_shortcode_settings',
      $this->option_name . '_location_shortcode_settings',
      array('label_for' => $this->option_name . '_enable_location_group')
    );
    
    $ifLocationsGroup = get_option('wcmlim_enable_location_group');
    if ($ifLocationsGroup == null || $ifLocationsGroup == false ) { 
    add_settings_field(
        $this->option_name . '_select_or_dropdown',
        __('Location List View on Product Detail Page', 'wcmlim'),
        array($this, $this->option_name . '_select_or_dropdown_callback'),
        $this->plugin_name . '_display_settings',
        $this->option_name . '_display_settings',
        array('label_for' => $this->option_name . '_select_or_dropdown')
      );
    }
    $radiolisitng = get_option('wcmlim_select_or_dropdown');
    if ($radiolisitng == "on" && $ifLocationsGroup == null || $ifLocationsGroup == false) { 
      add_settings_field(
        $this->option_name . '_radio_loc_fulladdress',
        __('Show address details', 'wcmlim'),
        array($this, $this->option_name . '_radio_loc_fulladdress_callback'),
        $this->plugin_name . '_display_settings',
        $this->option_name . '_display_settings',
        array('label_for' => $this->option_name . '_radio_loc_fulladdress')
      );     
      add_settings_field(
        $this->option_name . '_radio_loc_format',
        __('Listing view formatting ', 'wcmlim'),
        array($this, $this->option_name . '_radio_loc_format_callback'),
        $this->plugin_name . '_display_settings',
        $this->option_name . '_display_settings',
        array('label_for' => $this->option_name . '_radio_loc_format')
      );
    }

    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_default_location');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_backorder_for_locations');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_specific_location');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_set_location_cookie_time');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_autodetect_location');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_price');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_location_fee');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_location_widget');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_hide_show_location_dropdown');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_geo_location');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_restore_location_stock_for_failed');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_restore_location_stock_for_refund');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_google_api_key');    
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_cron_for_product');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_cron_for_product_userdefined');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_service_radius_for_location');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_get_direction_for_location');
    register_setting($this->plugin_name . '_location_shortcode_settings',$this->option_name  . '_assign_location_shop_manager');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_location_group');
    
    register_setting($this->plugin_name . '_display_settings', $this->option_name . '_select_or_dropdown');
    register_setting($this->plugin_name . '_display_settings', $this->option_name . '_radio_loc_fulladdress');
    register_setting($this->plugin_name . '_display_settings', $this->option_name . '_radio_loc_format');
    register_setting($this->plugin_name . '_location_shortcode_settings', $this->option_name . '_enable_COGSprice');


    /*
    * Custom Error Notice Message 
    * added options
    * @since    1.2.15
    */
    add_settings_section(
      $this->option_name . '_custom_notice',
      __('Updated notice messages for users', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name . '_custom_notice'
    );
    add_settings_field(
      $this->option_name . '_select_loc_val',
      __('Location Validation', 'wcmlim'),
      array($this, $this->option_name . '_select_loc_val_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_select_loc_val')
    );
    add_settings_field(
      $this->option_name . '_prod_instock_valid',
      __('Location Stock Unavailable', 'wcmlim'),
      array($this, $this->option_name . '_prod_instock_valid_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_prod_instock_valid')
    );   
    add_settings_field(
      $this->option_name . '_pickup_valid',
      __('Validating for PickUp Address', 'wcmlim'),
      array($this, $this->option_name . '_pickup_valid_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_pickup_valid')
    );
    add_settings_field(
      $this->option_name . '_label_limi1',
      __('Limit 1 Location Feature', 'wcmlim'),
      array($this, $this->option_name . '_label_limi1_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_label_limi1')
    );
    add_settings_field(
      $this->option_name . '_two_diff_loc_addtocart',
      __('Add product with two different location', 'wcmlim'),
      array($this, $this->option_name . '_two_diff_loc_addtocart_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_two_diff_loc_addtocart')
    );  
    add_settings_field(
      $this->option_name . '_valid_cart_message',
      __('Validation Message', 'wcmlim'),
      array($this, $this->option_name . '_valid_cart_message_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_valid_cart_message')
    );   
    add_settings_field(
      $this->option_name . '_btn_cartclear',
      __('Validation Button Text', 'wcmlim'),
      array($this, $this->option_name . '_btn_cartclear_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_btn_cartclear')
    );
    add_settings_field(
      $this->option_name . '_cart_popup_heading',
      __('Popup Heading', 'wcmlim'),
      array($this, $this->option_name . '_cart_popup_heading_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_cart_popup_heading')
    );   
    add_settings_field(
      $this->option_name . '_cart_popup_message',
      __('Popup Message', 'wcmlim'),
      array($this, $this->option_name . '_cart_popup_message_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_cart_popup_message')
    );
    add_settings_field(
      $this->option_name . '_var_message1',
      __('For Product Variation', 'wcmlim'),
      array($this, $this->option_name . '_var_message1_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_var_message1')
    );
    add_settings_field(
      $this->option_name . '_var_message2',
      __('No Matching Variations', 'wcmlim'),
      array($this, $this->option_name . '_var_message2_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_var_message2')
    ); 
    add_settings_field(
      $this->option_name . '_var_message3',
      __('Make Variations Selection', 'wcmlim'),
      array($this, $this->option_name . '_var_message3_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_var_message3')
    ); 
    add_settings_field(
      $this->option_name . '_var_message4',
      __('Product Variations Unavailable', 'wcmlim'),
      array($this, $this->option_name . '_var_message4_cb'),
      $this->plugin_name . '_custom_notice',
      $this->option_name . '_custom_notice',
      array('label_for' => $this->option_name . '_var_message4')
    ); 

    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_select_loc_val');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_prod_instock_valid');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_two_diff_loc_addtocart');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_pickup_valid');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_label_limi1');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_valid_cart_message');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_btn_cartclear');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_cart_popup_heading');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_cart_popup_message');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_var_message1');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_var_message2');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_var_message3');
    register_setting($this->plugin_name . '_custom_notice', $this->option_name . '_var_message4');
    
   

    // Shipping Zone and Shipping Method setting section
    add_settings_section(
      $this->option_name . '_shipping_zone_method_settings',
      __('Shipping and Payment Method Settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name . '_shipping_zone_method_settings'
    );
    add_settings_field(
      $this->option_name . '_enable_shipping_zones',
      __('Shipping zones to each location', 'wcmlim'),
      array($this, $this->option_name . '_enable_shipping_zones_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->option_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_enable_shipping_zones')
    );

    add_settings_field(
      $this->option_name . '_enable_shipping_methods',
      __('Shipping Methods to each location', 'wcmlim'),
      array($this, $this->option_name . '_enable_shipping_methods_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->option_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_enable_shipping_methods')
    );

    add_settings_field(
      $this->option_name . '_enable_split_packages',
      __('Split Package by location', 'wcmlim'),
      array($this, $this->option_name . '_enable_split_packages_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->option_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_enable_split_packages')
    );

    add_settings_field(
      $this->option_name . '_assign_payment_methods_to_locations',
      __('Payment methods to location', 'wcmlim'),
      array($this, $this->option_name . '_assign_payment_methods_to_location_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->option_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_assign_payment_methods_manager')
    );

    add_settings_field(
      $this->option_name . '_allow_local_pickup',
      __('Local Pickup Location', 'wcmlim'),
      array($this, $this->option_name . '_allow_local_pickup_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->plugin_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_allow_local_pickup')
    );

    add_settings_field(
      $this->option_name . '_allow_tax_to_locations',
      __('WC Tax To Each Location', 'wcmlim'),
      array($this, $this->option_name . '_allow_tax_to_locations_callback'),
      $this->plugin_name . '_shipping_zone_method_settings',
      $this->plugin_name . '_shipping_zone_method_settings',
      array('label_for' => $this->option_name . '_allow_tax_to_locations')
    );


    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_assign_payment_methods_to_locations');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_enable_shipping_methods');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_enable_split_packages');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_enable_shipping_zones');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_allow_local_pickup');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_allow_tax_to_locations');
    register_setting($this->plugin_name . '_shipping_zone_method_settings', $this->option_name . '_enable_tax_to_each_item');

   
    // Shipping Zone and Shipping Method setting section
    add_settings_section(
      $this->option_name . '_product_shop_page_settings',
      __('Shop Page Settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->plugin_name . '_product_shop_page_settings'
    );

   

    add_settings_field(
      $this->option_name . '_enable_location_onshop',
      __('Locations name and stock', 'wcmlim'),
      array($this, $this->option_name . '_enable_location_onshop_callback'),
      $this->plugin_name . '_product_shop_page_settings',
      $this->option_name . '_product_shop_page_settings',
      array('label_for' => $this->option_name . '_enable_location_onshop')
    );

    add_settings_field(
      $this->option_name . '_enable_location_onshop_variable',
      __('Variable Setting', 'wcmlim'),
      array($this, $this->option_name . '_enable_location_onshop_variable_callback'),
      $this->plugin_name . '_product_shop_page_settings',
      $this->option_name . '_product_shop_page_settings',
      array('label_for' => $this->option_name . '_enable_location_onshop_variable')
    );


    add_settings_field(
      $this->option_name . '_enable_location_price_onshop',
      __('Location price', 'wcmlim'),
      array($this, $this->option_name . '_enable_location_price_onshop_callback'),
      $this->plugin_name . '_product_shop_page_settings',
      $this->option_name . '_product_shop_page_settings',
      array('label_for' => $this->option_name . '_enable_location_price_onshop')
    );

    add_settings_field(
      $this->option_name . '_hide_outofstock_products',
      __('Hide out of stock products', 'wcmlim'),
      array($this, $this->option_name . '_hide_outofstock_products_callback'),
      $this->plugin_name . '_product_shop_page_settings',
      $this->option_name . '_product_shop_page_settings',
      array('label_for' => $this->option_name . '_hide_outofstock_products')
    );

    add_settings_field(
      $this->option_name . '_use_location_widget',
      __('Location Filter Widget', 'wcmlim'),
      array($this, $this->option_name . '_use_location_widget_callback'),
      $this->plugin_name . '_product_shop_page_settings',
      $this->option_name . '_product_shop_page_settings',
      array('label_for' => $this->option_name . '_use_location_widget')
    );
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_enable_location_onshop_variable');
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_use_location_widget');
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_widget_select_mode');
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_enable_location_onshop');
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_enable_location_price_onshop');
    register_setting($this->plugin_name . '_product_shop_page_settings', $this->option_name . '_hide_outofstock_products');
    
    // Location Shortcode Settings
    add_settings_section(
      $this->option_name . '_shortcode_setting',
      __('Switch settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->option_name . '_shortcode_setting'
    );
    
    add_settings_field(
      $this->option_name . '_preferred_location',
      __('Allow users to set location', 'wcmlim'),
      array($this, $this->option_name . '_preferred_location_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_preferred_location')
    );
    
    add_settings_field(
      $this->option_name . '_location_popup',
      __('Allow users to set location popup.', 'wcmlim'),
      array($this, $this->option_name . '_location_popup_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_location_popup')
    );


    add_settings_section(
      $this->option_name . '_shortcode_setting',
      __('Popup Settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->option_name . '_shortcode_setting'
    );

    add_settings_field(
      $this->option_name . '_show_in_popup',
      __('What you want to show in popup', 'wcmlim'),
      array($this, $this->option_name . '_show_in_popup_cb'),
      $this->option_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_show_in_popup')
    );

    add_settings_field(
      $this->option_name . '_force_to_select_location',
      __('Force visitors to select location', 'wcmlim'),
      array($this, $this->option_name . '_force_to_select_location_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_force_to_select_location')
    );

    add_settings_section(
      $this->option_name . '_shortcode_setting',
      __('Control settings', 'wcmlim'),
      array($this, $this->option_name . '_general_cb'),
      $this->option_name . '_shortcode_setting'
    );

    add_settings_field(
      $this->option_name . '_txt_inline_location',
      __('Label', 'wcmlim'),
      array($this, $this->option_name . '_txt_inline_location_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_txt_inline_location')
    );

    add_settings_field(
      $this->option_name . '_popup_icon_position',
      __('Pop up icon position', 'wcmlim'),
      array($this, $this->option_name . '_popup_icon_position_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_popup_icon_position')
    );

    add_settings_field(
      $this->option_name . '_listing_inline_location',
      __('List View on Location Popup', 'wcmlim'),
      array($this, $this->option_name . '_listing_inline_location_callback'),
      $this->plugin_name . '_shortcode_setting',
      $this->option_name . '_shortcode_setting',
      array('label_for' => $this->option_name . '_listing_inline_location')
    );
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_txt_inline_location');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_listing_inline_location');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_preferred_location');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_location_popup');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_show_in_popup');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_listing_popup_location');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_force_to_select_location');
    register_setting($this->plugin_name . '_shortcode_setting', $this->option_name . '_popup_icon_position');
    
    // Display setting section
    add_settings_section(
      $this->option_name . '_display_settings',
      __('Front End Visual Display', 'wcmlim'),
      array($this, $this->option_name . '_display_settings_cb'),
      $this->option_name . '_display_settings'
    );

    add_settings_field(
      $this->option_name . '_show_location_distance',
      __('Show Location Distance', 'wcmlim'),
      array($this, $this->option_name . '_show_location_distance_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_show_location_distance')
    );

    register_setting($this->option_name . '_display_settings', $this->option_name . '_show_location_distance');

    add_settings_field(
      $this->option_name . '_custom_css_enable',
      __('Disable Multilocation CSS', 'wcmlim'),
      array($this, $this->option_name . '_custom_css_enable_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_custom_css_enable')
    );

    register_setting($this->option_name . '_display_settings', $this->option_name . '_custom_css_enable');

    add_settings_section(
      $this->option_name . '_map_settings',
      "",
      array($this, $this->plugin_name . '_general_cb'),
      $this->plugin_name . '_map_settings'
    );

    add_settings_field(
      $this->option_name . '_default_zoom',
      __('Default Zoom on Map', 'wcmlim'),
      array($this, $this->option_name . '_default_zoom_callback'),
      $this->option_name . '_map_settings',
      $this->option_name . '_map_settings',
      array('label_for' => $this->option_name . '_default_zoom')
    );

    add_settings_field(
      $this->option_name . '_default_origin_center',
      __('Default Origin on Map', 'wcmlim'),
      array($this, $this->option_name . '_default_origin_center_callback'),
      $this->plugin_name . '_map_settings',
      $this->option_name . '_map_settings',
      array('label_for' => $this->option_name . '_default_origin_center')
    );

    add_settings_field(
      $this->option_name . '_default_list_align',
      __('Location List Alignment On Map', 'wcmlim'),
      array($this, $this->option_name . '_default_list_align_callback'),
      $this->plugin_name . '_map_settings',
      $this->option_name . '_map_settings',
      array('label_for' => $this->option_name . '_default_list_align')
    );

    add_settings_field(
      $this->option_name . '_default_map_color',
      __('Default Map Color', 'wcmlim'),
      array($this, $this->option_name . '_default_map_color_callback'),
      $this->plugin_name . '_map_settings',
      $this->option_name . '_map_settings',
      array('label_for' => $this->option_name . '_default_map_color')
    );

    add_settings_field(
      $this->option_name . '_filter_visibility_shortcode',
      __('Product/Category Filter on Map', 'wcmlim'),
      array($this, $this->option_name . '_filter_visibility_shortcode_callback'),
      $this->option_name . '_map_settings',
      $this->option_name . '_map_settings',
      array('label_for' => $this->option_name . '_filter_visibility_shortcode')
    );

    register_setting($this->plugin_name . '_map_settings', $this->option_name . '_default_list_align');
    register_setting($this->plugin_name . '_map_settings', $this->option_name . '_default_origin_center');
    register_setting($this->plugin_name . '_map_settings', $this->option_name . '_default_zoom');
    register_setting($this->plugin_name . '_map_settings', $this->option_name . '_filter_visibility_shortcode');
    register_setting($this->plugin_name . '_map_settings', $this->option_name . '_default_map_color');

    /**
     * Design Preview Options and controls
     * @since    1.1.5
     */

    add_settings_field(
      $this->option_name . '_preview_stock_bgcolor',
      __('Multilocation Box', 'wcmlim'),
      array($this, $this->option_name . '_preview_stock_bgcolor_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_preview_stock_bgcolor')
    );

    add_settings_field(
      $this->option_name . '_preview_stock_border',
      __('Multilocation Box Border Setting', 'wcmlim'),
      array($this, $this->option_name . '_preview_stock_border_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_preview_stock_border')
    );

    /** separator Line Display */
    add_settings_field(
      $this->option_name . '_separator_linecolor',
      __('Separator', 'wcmlim'),
      array($this, $this->option_name . '_separator_linecolor_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_separator_linecolor')
    );

    /** Header - 1 */
    add_settings_field(
      $this->option_name . '_txt_stock_info',
      __('Header', 'wcmlim'),
      array($this, $this->option_name . '_txt_stock_info_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_txt_stock_info')
    );

    /** Header - 2 */
    add_settings_field(
      $this->option_name . '_txt_preferred_location',
      __('Select Box', 'wcmlim'),
      array($this, $this->option_name . '_txt_preferred_location_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_txt_preferred_location')
    );

    /** Header - 3 */
    add_settings_field(
      $this->option_name . '_txt_nearest_stock_loc',
      __('Output Box', 'wcmlim'),
      array($this, $this->option_name . '_txt_nearest_stock_loc_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_txt_nearest_stock_loc')
    );

    /** Button Label */
    add_settings_field(
      $this->option_name . '_oncheck_button_text',
      __('Input Field Button', 'wcmlim'),
      array($this, $this->option_name . '_oncheck_button_text_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_oncheck_button_text')
    );

    /** Sold out */
    add_settings_field(
      $this->option_name . '_soldout_button_text',
      __('Out Of Stock', 'wcmlim'),
      array($this, $this->option_name . '_soldout_button_text_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_soldout_button_text')
    );

    /** Instock */
    add_settings_field(
      $this->option_name . '_instock_button_text',
      __('In Stock ', 'wcmlim'),
      array($this, $this->option_name . '_instock_button_text_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_instock_button_text')
    );

     /** On backorder */
     add_settings_field(
      $this->option_name . '_onbackorder_button_text',
      __('On backorder', 'wcmlim'),
      array($this, $this->option_name . '_onbackorder_button_text_cb'),
      $this->option_name . '_display_settings',
      $this->option_name . '_display_settings',
      array('label_for' => $this->option_name . '_onbackorder_button_text')
    );

    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_border');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_borderoption');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_bordercolor');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_bgcolor');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txt_stock_info');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txt_preferred_location');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txt_nearest_stock_loc');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_oncheck_button_text');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_oncheck_button_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_oncheck_button_text_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_soldout_button_text');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_soldout_button_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_soldout_button_text_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_instock_button_text');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_onbackorder_button_text');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_instock_button_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_instock_button_text_color');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_display_stock_info');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txtcolor_stock_info');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txtcolor_preferred_loc');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_display_preferred_loc');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_txtcolor_nearest_stock');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_display_nearest_stock');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_separator_linecolor');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_display_separator_line');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_refbox_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_instock_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_soldout_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_input_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_oncheck_borderradius');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_preview_stock_width');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sel_padding_top');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sel_padding_bottom');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sel_padding_right');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sel_padding_left');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_inp_padding_top');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_inp_padding_bottom');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_inp_padding_right');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_inp_padding_left');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_btn_padding_top');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_btn_padding_bottom');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_btn_padding_right');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_btn_padding_left');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_display_icon');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_iconcolor_loc');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_iconsize_loc');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_is_padding_top');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_is_padding_bottom');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_is_padding_right');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_is_padding_left');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sbox_padding_top');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sbox_padding_bottom');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sbox_padding_right');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_sbox_padding_left');
    register_setting($this->option_name . '_display_settings', $this->option_name . '_selbox_bgcolor');
  }

  /**
   * callback function for Notice message checkbox.
   *
   * @since    1.2.15
   */  

  public function wcmlim_select_loc_val_cb()
  {
    $loc_valid = get_option($this->option_name . '_select_loc_val');
    if ($loc_valid  == false) {
      update_option($this->option_name . '_select_loc_val', 'Please select location.');
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_select_loc_val'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_select_loc_val'); ?>" id="<?php esc_attr_e($this->option_name . '_select_loc_val'); ?>" value="<?php esc_attr_e($loc_valid); ?>"><?php esc_attr_e($loc_valid); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('User to do select any one location for product purchase.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_prod_instock_valid_cb()
  {
    $pinstock_valid = get_option($this->option_name . '_prod_instock_valid');
    if ($pinstock_valid  == false) {
      update_option($this->option_name . '_prod_instock_valid', 'You can’t have more than items in cart');
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_prod_instock_valid'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_prod_instock_valid'); ?>" id="<?php esc_attr_e($this->option_name . '_prod_instock_valid'); ?>" value="<?php esc_attr_e($pinstock_valid); ?>"><?php esc_attr_e($pinstock_valid); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('While updating product quatity and don’t have more items to add on cart.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
    /**Variation Message */
  public function wcmlim_var_message1_cb() { /** Separator  */}
  public function wcmlim_var_message2_cb() {
    $var_message2 = get_option($this->option_name . '_var_message2');
    if ($var_message2  == false) {
      update_option($this->option_name . '_var_message2', "Sorry, no products matched your selection. Please choose a different combination.");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_var_message2'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_var_message2'); ?>" id="<?php esc_attr_e($this->option_name . '_var_message2'); ?>" value="<?php esc_attr_e($var_message2); ?>"><?php esc_attr_e($var_message2); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __("No products matched for selected variations", 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_var_message3_cb() {
    $var_message3 = get_option($this->option_name . '_var_message3');
    if ($var_message3  == false) {
      update_option($this->option_name . '_var_message3', "Please select some product options before adding this product to your cart.");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_var_message3'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_var_message3'); ?>" id="<?php esc_attr_e($this->option_name . '_var_message3'); ?>" value="<?php esc_attr_e($var_message3); ?>"><?php esc_attr_e($var_message3); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __("If variation options won't selected and user try product add to cart", 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_var_message4_cb()
  {
    $var_message4 = get_option($this->option_name . '_var_message4');
    if ($var_message4  == false) {
      update_option($this->option_name . '_var_message4', "Sorry, this product is unavailable. Please choose a different combination.");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_var_message4'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_var_message4'); ?>" id="<?php esc_attr_e($this->option_name . '_var_message4'); ?>" value="<?php esc_attr_e($var_message4); ?>"><?php esc_attr_e($var_message4); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If product variation combination not avaible for purchase.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_label_limi1_cb() { /** Separator  */}
  public function wcmlim_two_diff_loc_addtocart_cb()
  {
    $diff_loc_valid = get_option($this->option_name . '_two_diff_loc_addtocart');
    if ($diff_loc_valid  == false) {
      update_option($this->option_name . '_two_diff_loc_addtocart', "Product with 2 differnt location won't allow.");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_two_diff_loc_addtocart'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_two_diff_loc_addtocart'); ?>" id="<?php esc_attr_e($this->option_name . '_two_diff_loc_addtocart'); ?>" value="<?php esc_attr_e($diff_loc_valid); ?>"><?php esc_attr_e($diff_loc_valid); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('Limit 1 location feature, if product added with two different location on cart.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_pickup_valid_cb()
  {
    $pickup_valid = get_option($this->option_name . '_pickup_valid');
    if ($pickup_valid  == false) {
      update_option($this->option_name . '_pickup_valid', "Pickup At Store Unavailable");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_pickup_valid'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_pickup_valid'); ?>" id="<?php esc_attr_e($this->option_name . '_pickup_valid'); ?>" value="<?php esc_attr_e($pickup_valid); ?>"><?php esc_attr_e($pickup_valid); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If pickup at location store wasn’t available or enable service for user.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_btn_cartclear_cb()
  {
    $btn_cartclear = get_option($this->option_name . '_btn_cartclear');
    if ($btn_cartclear  == false) {
      update_option($this->option_name . '_btn_cartclear', 'Yes, clear cart!');
    }     
    ?>                    
    <label for="<?php esc_attr_e($this->option_name . '_btn_cartclear'); ?>"></label>
    <input type="text" name="<?php esc_attr_e($this->option_name . '_btn_cartclear'); ?>" id="<?php esc_attr_e($this->option_name . '_btn_cartclear'); ?>" value="<?php esc_attr_e($btn_cartclear); ?>">
    <?php echo '<label class="wcmlim-setting-option-des">' . __('On clear cart validation, Button Text.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_valid_cart_message_cb()
  {
    $val_cart_message = get_option($this->option_name . '_valid_cart_message');
    if ($val_cart_message  == false) {
      update_option($this->option_name . '_valid_cart_message', "You can only order from 1 location, do you want to clear the cart?");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_valid_cart_message'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_valid_cart_message'); ?>" id="<?php esc_attr_e($this->option_name . '_valid_cart_message'); ?>" value="<?php esc_attr_e($val_cart_message); ?>"><?php esc_attr_e($val_cart_message); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('On clear cart validation, message text for user.', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_cart_popup_heading_cb()
  {
    $popup_head = get_option($this->option_name . '_cart_popup_heading');
    if ($popup_head  == false) {
      update_option($this->option_name . '_cart_popup_heading', 'Updated Cart!');
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_cart_popup_heading'); ?>"></label>
    <input type="text" name="<?php esc_attr_e($this->option_name . '_cart_popup_heading'); ?>" id="<?php esc_attr_e($this->option_name . '_cart_popup_heading'); ?>" value="<?php esc_attr_e($popup_head); ?>">
    <?php echo '<label class="wcmlim-setting-option-des">' . __('After clearing cart popup header text', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }
  public function wcmlim_cart_popup_message_cb()
  {
    $popup_message = get_option($this->option_name . '_cart_popup_message');
    if ($popup_message  == false) {
      update_option($this->option_name . '_cart_popup_message', "our cart has been cleared, re-add from new location!");
    }     
    ?>                 
    <label for="<?php esc_attr_e($this->option_name . '_cart_popup_message'); ?>"></label>
    <textarea rows = "2" cols = "50" name="<?php esc_attr_e($this->option_name . '_cart_popup_message'); ?>" id="<?php esc_attr_e($this->option_name . '_cart_popup_message'); ?>" value="<?php esc_attr_e($popup_message); ?>"><?php esc_attr_e($popup_message); ?></textarea>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('After clearing cart popup detail text message', 'wcmlim') . '</label>'; ?>
    </p>
    <?php  
  }

  /**
   * callback function for general checkbox.
   *
   * @since    1.0.0
   */

  public function wcmlim_general_cb()
  {
    echo '<p>' . __('Please change the settings accordingly.', 'wcmlim') . '</p>';
  }
  /**
   * callback function for backend mode.
   *
   * @since    3.0.7
   */

  public function wcmlim_general_backend_mode()
  {
    echo '<p>' . __('If you enable the below settings, the other setting related to front end functionality will be  disabled.', 'wcmlim') . '</p>';
  }
  /**
   * callback function for general checkbox.
   *
   * @since    1.0.0
   */

  public function wcmlim_location_mini_store_shortcode_cb()
  {
    echo '<p>' . __('Please change the settings accordingly.', 'wcmlim') . '</p>';
  }

  /**
   * callback function for geo location checkbox.
   *
   * @since    1.0.0
   */

  public function wcmlim_geo_location_cb()
  {
    $checked = get_option($this->option_name . '_geo_location');
?>
    <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_geo_location') ?>" name="<?php esc_attr_e($this->option_name . '_geo_location') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <br>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable the google map related functionality like find location, calculate distance etc. <b>This Requires google map api key</b>', 'wcmlim') . '</label>'; ?>
  <?php
  }

  /**
   * callback function for location switch.
   *
   * @since    1.0.0
   * @Update   1.2.11
   */

  public function wcmlim_preferred_location_callback()
  {
    $isLocationSet = get_option($this->option_name . '_preferred_location'); 
       
  ?>
      <label class="switch">
       <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_preferred_location') ?>" name="<?php esc_attr_e($this->option_name . '_preferred_location') ?>" <?php echo ($isLocationSet == 'on') ? 'checked="checked"' : ''; ?>>
       <span class="slider round"></span>
      </label>
      <br />
      <label class="wcmlim-setting-option-des"><b><?php echo __('Shortcode Instructions: ', 'wcmlim'); ?></b><br>
        <?php echo __('To display Locations Dropdown on your website - use', 'wcmlim'); ?><code>[wcmlim_locations_switch]</code> <?php echo __('shortcode.', 'wcmlim'); ?><br><?php echo __('You can put it anywhere into page content using editor just by copy-paste,', 'wcmlim'); ?> <br> </label>              
      <?php      
    }
    public function wcmlim_location_popup_callback()
    {
      $locationpopup = get_option($this->option_name . '_location_popup'); 
         
    ?>
        <label class="switch">
         <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_location_popup') ?>" name="<?php esc_attr_e($this->option_name . '_location_popup') ?>" <?php echo ($locationpopup == 'on') ? 'checked="checked"' : ''; ?>>
         <span class="slider round"></span>
        </label>
        <br />
        <label class="wcmlim-setting-option-des"><b><?php echo __('Shortcode Instructions: ', 'wcmlim'); ?></b><br>
          <?php echo __('To display Locations Dropdown on your website - use', 'wcmlim'); ?><code>[wcmlim_locations_popup]</code> <?php echo __('shortcode.', 'wcmlim'); ?><br><?php echo __('You can put it anywhere into page content using editor just by copy-paste,', 'wcmlim'); ?> <br> </label>              
        <?php      
      }
    /**
     *  Function for label text on shortcode.
     * 
     * @since    1.2.11     
     */

    public function wcmlim_txt_inline_location_callback()
    {      
      $h2_text = get_option($this->option_name . '_txt_inline_location');
      if ($h2_text  == false) {
      update_option($this->option_name . '_txt_inline_location', 'Location: ');
      }     
      ?>                 
      <label for="<?php esc_attr_e($this->option_name . '_txt_inline_location'); ?>"></label>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_txt_inline_location'); ?>" id="<?php esc_attr_e($this->option_name . '_txt_inline_location'); ?>" value="<?php esc_attr_e($h2_text); ?>" maxlength="40">
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enter text to display on linear view as a title.', 'wcmlim') . '</label>'; ?>
      </p>
      <?php       
    }

    /**
     *  Function for label text on shortcode.
     * 
     * @since    1.2.11     
     */

    public function wcmlim_popup_icon_position_callback()
    {      
      $popupPosition = get_option($this->option_name . '_popup_icon_position');
      ?>
      <select name="wcmlim_popup_icon_position" id="wcmlim_popup_position">
        <option value="default"><?php _e('Select', 'wcmlim'); ?></option>
        <option value="left" <?php if ($popupPosition == 'left') { echo "selected='selected'"; } ?>><?php _e('Left', 'wcmlim'); ?></option>
        <option value="right" <?php if ($popupPosition == 'right') { echo "selected='selected'"; } ?>><?php _e('Right', 'wcmlim'); ?></option>
        <option value="top" <?php if ($popupPosition == 'top') { echo "selected='selected'"; } ?>><?php _e('Top', 'wcmlim'); ?></option>
        <option value="bottom" <?php if ($popupPosition == 'bottom') { echo "selected='selected'"; } ?>><?php _e('Bottom', 'wcmlim'); ?></option>
      </select>            
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Position for pop up icon.', 'wcmlim') . '</label>'; ?>
      </p>
      <?php       
    }
    

    /**
     * Function for list mode on shortcode.
     *
     * @since    1.2.11     
     */
    public function wcmlim_listing_inline_location_callback()
    {          
      $loc_listing = get_option($this->option_name . '_listing_inline_location');    
      if($loc_listing == "on") {
        update_option("wcmlim_show_in_popup", "list");
      }
      ?> 
      <p>            
      <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_listing_inline_location') ?>" name="<?php esc_attr_e($this->option_name . '_listing_inline_location') ?>" <?php echo ($loc_listing == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
      </label>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to display location on listing format for linear style. ', 'wcmlim') . '</label>'; ?>
      </p>
      <?php         
    }    
    
    /**
     * callback function for preferred location checkbox.
     *
     * @since    1.0.0
     */

    public function wcmlim_google_api_key_cb()
    {
      $key = get_option($this->option_name . '_google_api_key');
      ?>
      <input type="password" autocomplete="new-password" name="<?php esc_attr_e($this->option_name . '_google_api_key'); ?>" id="<?php esc_attr_e($this->option_name . '_google_api_key'); ?>" value="<?php esc_attr_e($key); ?>">
      <a class="keyEye"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
      <a class="wcmlimvalidateGMAPI"> <?php echo __('Validate', 'wcmlim'); ?> </a>
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('<b>If you do not have a API Key, You can Generate one from <a href="https://developers.google.com/maps/documentation/distance-matrix/get-api-key" target="_blank"> Here</a></b><br>Requires the activation of Places API, Distance Matrix API, Geocoding Api, Maps JavaScript API.', 'wcmlim') . '</label>'; ?>
    <?php
    }
    /**
     * callback function for Enabling Regular And Sale Price
     *
     * @since    1.0.0
     */

    public function wcmlim_enable_price_cb()
    {
      $checked = get_option($this->option_name . '_enable_price');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_price') ?>" name="<?php esc_attr_e($this->option_name . '_enable_price') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Set the regular price and sales price for each products location by activating the toggle', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_location_fee_cb()
    {
      $checked = get_option($this->option_name . '_location_fee');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_location_fee') ?>" name="<?php esc_attr_e($this->option_name . '_location_fee') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Set the custom fee for each products location by activating the toggle', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_enable_location_widget_cb()
    {
      $checked = get_option($this->option_name . '_enable_location_widget');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_location_widget') ?>" name="<?php esc_attr_e($this->option_name . '_enable_location_widget') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Set locations as a category for products.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_restore_location_stock_cb()
    {
      $restore_location_stock_for_failed = get_option($this->option_name . '_restore_location_stock_for_failed');
      $restore_location_stock_for_refund = get_option($this->option_name . '_restore_location_stock_for_refund');
      ?>
      <label for="switch">
          <input type="checkbox" name="<?php esc_attr_e($this->option_name . '_restore_location_stock_for_failed') ?>" id="order_status_failed" <?php echo ($restore_location_stock_for_failed == 'on') ? 'checked="checked"' : ''; ?> />
          <?php _e('Order Status Failed', 'wcmlim'); ?>
        </label>
    <label for="switch">
          <input type="checkbox" name="<?php esc_attr_e($this->option_name . '_restore_location_stock_for_refund') ?>" id="order_status_refund" <?php echo ($restore_location_stock_for_refund == 'on') ? 'checked="checked"' : ''; ?> />
          <?php _e('Order Status Refund', 'wcmlim'); ?>
        </label>
    <?php
    }

    /**
     * callback function for Enabling COGS Price
     *
     * 
     */
    public function wcmlim_enable_COGSprice_cb()
    {
      $checked = get_option($this->option_name . '_enable_COGSprice');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_COGSprice') ?>" name="<?php esc_attr_e($this->option_name . '_enable_COGSprice') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Set the COGS price for each products location by activating the toggle.<b> To activate COGS price must activate regular price and sales price first.</b> ', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for Hide/show location dropdown on product page
     *
     * @since    1.0.0
     */

    public function wcmlim_hide_show_dropdown_cb()
    {
      $check = get_option($this->option_name . '_hide_show_location_dropdown');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_hide_show_location_dropdown') ?>" name="<?php esc_attr_e($this->option_name . '_hide_show_location_dropdown') ?>" <?php echo ($check == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __("Enabling this will hide the Location listed dropdown on the product page.<b> Use any one of the shortcode which allow user to set location. So that add-to-cart button on product page won't get disable.</b>", 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for Enabling shipping zones
     *
     * @since    1.0.0
     */
    public function wcmlim_enable_location_onshop_variable_callback()
    {
      $isLocationOnshop = get_option($this->option_name . '_enable_location_onshop_variable');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_location_onshop_variable') ?>" name="<?php esc_attr_e($this->option_name . '_enable_location_onshop_variable') ?>" <?php echo ($isLocationOnshop == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to show locations name and available stock for <b> default variations </b> at selected location', 'wcmlim') . '</label>'; ?>
    <?php
    }


    public function wcmlim_enable_shipping_zones_callback()
    {
      $isShipping = get_option($this->option_name . '_enable_shipping_zones');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_shipping_zones') ?>" name="<?php esc_attr_e($this->option_name . '_enable_shipping_zones') ?>" <?php echo ($isShipping == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to set shipping zone to each location. You can set shipping zone from location edit screen after enabling this', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for Enabling locations on shop
     *
     * @since    1.0.0
     */
    public function wcmlim_hide_outofstock_products_callback()
    {
      $hideOutOfStock = get_option($this->option_name . '_hide_outofstock_products');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_hide_outofstock_products') ?>" name="<?php esc_attr_e($this->option_name . '_hide_outofstock_products') ?>" <?php echo ($hideOutOfStock == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to hide outofstock products from shop page. This feature hide products where stock at locations is not available or zero', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_enable_location_onshop_callback()
    {
      $isLocationOnshop = get_option($this->option_name . '_enable_location_onshop');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_location_onshop') ?>" name="<?php esc_attr_e($this->option_name . '_enable_location_onshop') ?>" <?php echo ($isLocationOnshop == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to show locations name and available stock at selected location', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for Enabling locations on shop
     *
     * @since    1.1.8
     */

    public function wcmlim_enable_location_price_onshop_callback()
    {
      $isLocationPriceOnshop = get_option($this->option_name . '_enable_location_price_onshop');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_location_price_onshop') ?>" name="<?php esc_attr_e($this->option_name . '_enable_location_price_onshop') ?>" <?php echo ($isLocationPriceOnshop == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to Show location regular price and sale price on shop page', 'wcmlim') . '</label>'; ?>
    <?php
    }

   //removed old filter product on shop page option

    public function wcmlim_use_location_widget_callback()
    {
      $widgetOnShop = get_option($this->option_name . '_use_location_widget');
      $selectSet = get_option($this->option_name . '_widget_select_mode');    
      if ($selectSet  == false) {
        update_option($this->option_name . '_widget_select_mode', 'simple');
      }
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_use_location_widget') ?>" name="<?php esc_attr_e($this->option_name . '_use_location_widget') ?>" <?php echo ($widgetOnShop == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
    
        <br>
        <p id="wcmlim_option_for_selection">
          <b><?php echo __('Select dropdown type', 'wcmlim'); ?></b><br>
          <label for="wcmlim_select_simple">
            <input type="radio" name="<?php esc_attr_e($this->option_name . '_widget_select_mode') ?>" id="wcmlim_select_simple" value="simple" <?php echo ($selectSet == 'simple') ? 'checked="checked"' : ''; ?> />
            <?php echo __('Simple select', 'wcmlim'); ?>
          </label>

          <label for="wcmlim_select_multi">
            <input type="radio" name="<?php esc_attr_e($this->option_name . '_widget_select_mode') ?>" id="wcmlim_select_multi" value="multi" <?php echo ($selectSet == 'multi') ? 'checked="checked"' : ''; ?> />
            <?php echo __('Multi Select', 'wcmlim'); ?>
          </label>
        </p>
      <?php
   
      ?>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to show location filter on the shop page along with WooCommerce filter', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for Enabling auto-detect locations
     *
     * @since    1.0.0
     */

    public function wcmlim_enable_autodetect_location_callback()
    {
      $autoDetect = get_option($this->option_name . '_enable_autodetect_location');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_autodetect_location') ?>" name="<?php esc_attr_e($this->option_name . '_enable_autodetect_location') ?>" <?php echo ($autoDetect == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to detect users current location. <b>This Require valid google map api key</b>', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for restirct users to specific locations
     *
     * @since    1.0.0
     */

    public function wcmlim_enable_userspecific_location_callback()
    {
      $userSpecific = get_option($this->option_name . '_enable_userspecific_location');
      $showLocS = get_option($this->option_name . '_show_location_selection');

    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_userspecific_location') ?>" name="<?php esc_attr_e($this->option_name . '_enable_userspecific_location') ?>" <?php echo ($userSpecific == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Turning on this switch will allow you to restrict users to the selected location. You can select a location to restrict for the user from the user edit screen', 'wcmlim') . '</label>';
      if ($userSpecific == "on") {
      ?>
        <br />
        <label for="wcmlim_show_locselection">
          <input type="checkbox" name="<?php esc_attr_e($this->option_name . '_show_location_selection') ?>" id="wcmlim_show_locselection" <?php echo ($showLocS == 'on') ? 'checked="checked"' : ''; ?> />
          <?php _e('Enable if you want to show the location dropdown on the front-end', 'wcmlim'); ?>
        </label>
        <br />
      <?php
      }
    }

    /**
     * *callback function for location cookie time
     *
     * @since    1.1.3
     */

    public function wcmlim_set_location_cookie_time_callback()
    {
      $locationCookieTime = get_option($this->option_name . '_set_location_cookie_time');
      if($locationCookieTime == ''){
       update_option($this->option_name . '_set_location_cookie_time', '30');
      }
      $locationCookieTime = get_option($this->option_name . '_set_location_cookie_time');
      // print_r($locationCookieTime);
      ?>
      <input type="number" min="0" id="<?php esc_attr_e($this->option_name . '_set_location_cookie_time') ?>" name="<?php esc_attr_e($this->option_name . '_set_location_cookie_time') ?>" value="<?php echo $locationCookieTime; ?>">
      <br>
      <?php echo '<label class="wcmlim-setting-option-des">' . __('The default cookie time is 30.<br/>Extend the default cookie time in your browser <b>Note - Entered value considerd in days</b>', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for assign shop manager to specific locations
     *
     * @since    1.1.3
     */

    public function wcmlim_assign_location_shop_manager_callback()
    {
      $isShopManager = get_option($this->option_name . '_assign_location_shop_manager');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_assign_location_shop_manager') ?>" name="<?php esc_attr_e($this->option_name . '_assign_location_shop_manager') ?>" <?php echo ($isShopManager == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable location group setting from below to use Location Regional manager feature.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_assign_payment_methods_to_location_callback()
    {
      $isPaymentMethods = get_option($this->option_name . '_assign_payment_methods_to_locations');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_assign_payment_methods_to_locations') ?>" name="<?php esc_attr_e($this->option_name . '_assign_payment_methods_to_locations') ?>" <?php echo ($isPaymentMethods == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to set payment method to each location. You can set the payment method from the location edit screen after enabling this. On the checkout page, the common payment methods from selected product locations will be shown', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_clear_cart_callback()
    {
      $isClearCart = get_option($this->option_name . '_clear_cart');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_clear_cart') ?>" name="<?php esc_attr_e($this->option_name . '_clear_cart') ?>" <?php echo ($isClearCart == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this option if you want the users to order from only one location So user can select the same location products to fulfill orders', 'wcmlim') . '</label>'; ?>
    <?php
    }

    public function wcmlim_pos_compatibility_callback()
    {
      $_pos_compatiblity = get_option($this->option_name . '_pos_compatiblity');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_pos_compatiblity') ?>" name="<?php esc_attr_e($this->option_name . '_pos_compatiblity') ?>" <?php echo ($_pos_compatiblity == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this option to compatible with openpos plugin <a href="https://codecanyon.net/item/openpos-a-complete-pos-plugins-for-woocomerce/22613341?gclid=CjwKCAjwnPOEBhA0EiwA609ReX_5ziLI5kGOsT0iLMBTlyEQc4oCmx7fF01-XPUd4ivhaxdqfqhYOhoCqwsQAvD_BwE" target="_blank">Click here to visit OpenPOS Plugin</a>', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for wcpos
     *
     * @since    3.1.1
     */

    public function wcmlim_wc_pos_compatibility_callback()
    {
      $wc_pos_compatiblity = get_option($this->option_name . '_wc_pos_compatiblity');
      ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_wc_pos_compatiblity') ?>" name="<?php esc_attr_e($this->option_name . '_wc_pos_compatiblity') ?>" <?php echo ($wc_pos_compatiblity == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php
    }

    /**
     * *callback function for enable default location
     *
     * @since    1.2.5
     */

    public function wcmlim_enable_backorder_for_locations_callback()
    {
      $backorder_for_locations = get_option($this->option_name . '_enable_backorder_for_locations');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_backorder_for_locations') ?>" name="<?php esc_attr_e($this->option_name . '_enable_backorder_for_locations') ?>" <?php echo ($backorder_for_locations == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('This option lets you use backorder for each locations.', 'wcmlim') . '</label>'; ?>
    <?php
    }


    /**
     * *callback function for enable-disable locations
     *
     * @since    1.2.5
     */

    public function wcmlim_enable_specific_location_callback()
    {
      $specific_locations_for_product = get_option($this->option_name . '_enable_specific_location');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_specific_location') ?>" name="<?php esc_attr_e($this->option_name . '_enable_specific_location') ?>" <?php echo ($specific_locations_for_product == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('This option is lets you use to enable-disable locations.', 'wcmlim') . '</label>'; ?>
    <?php
    }

/**
     * *callback function for enable default location
     *
     * @since    3.3.0
     */

    public function wcmlim_enable_default_location_callback()
    {
      $_is_default = get_option($this->option_name . '_enable_default_location');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_default_location') ?>" name="<?php esc_attr_e($this->option_name . '_enable_default_location') ?>" <?php echo ($_is_default == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('This option will set the default location in product pages in frontend. The default is set under the product edit page by choosing Default location option.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    
    /**
   * *callback function for cron options
   *
   * @since    1.2.5
   */
  public function wcmlim_cron_for_product_callback()
  {
    $cronf_product = get_option("wcmlim_cron_for_product");
    $cronf_product_ud = get_option("wcmlim_cron_for_product_userdefined");
  ?>
    <select name="wcmlim_cron_for_product" id="wcmlim_cron_for_product">
      <option value="default"><?php _e('Select', 'wcmlim'); ?></option>
      <option value="hourly" <?php if ($cronf_product == 'hourly') { echo "selected='selected'"; } ?>><?php _e('Hourly', 'wcmlim'); ?></option>
      <option value="daily" <?php if ($cronf_product == 'daily') { echo "selected='selected'"; } ?>><?php _e('Daily', 'wcmlim'); ?></option>
      <option value="twicedaily" <?php if ($cronf_product == 'twicedaily') { echo "selected='selected'"; } ?>><?php _e('Twice a Day', 'wcmlim'); ?></option>
    </select>
    or Every <input type="number" min="1" name="wcmlim_cron_for_product_userdefined" value="<?php if(!empty($cronf_product_ud)){ echo $cronf_product_ud; }?>"> Minute
    <br />
    <label class="wcmlim-setting-option-des">
    <b>WARNING:</b> Enabling this option will update inventory levels to reflect the total stock at all locations for each product. Backup your  database or woocommerce inventroy before enabling this.
  </label>
  <?php

  }

  /**
   * Callback function for service radius 
   * to each location
   * 
   * @since 1.2.15
   */

  public function wcmlim_service_radius_for_location_callback(){
    $isRadiusLocations = get_option($this->option_name . '_service_radius_for_location');
  ?>
    <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_service_radius_for_location') ?>" name="<?php esc_attr_e($this->option_name . '_service_radius_for_location') ?>" <?php echo ($isRadiusLocations == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <br>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If you enable you are able to set radius to each location', 'wcmlim') . '</label>'; ?>
    <a href="admin.php?page=wcmlim-display-settings"> Click Here</a> Make Sure Distance unit has been selected.
 <?php
  }
  /**
   * Callback function for location group
   * to each location
   * 
   * @since 3.0.2
   */

  public function wcmlim_get_direction_for_location_callback(){
    $getdirection = get_option($this->option_name . '_get_direction_for_location');
  ?>
    <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_get_direction_for_location') ?>" name="<?php esc_attr_e($this->option_name . '_get_direction_for_location') ?>" <?php echo ($getdirection == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <br>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If you enable you can find map to each location', 'wcmlim') . '</label>'; ?>
  <?php
  }

    /**
   * Callback function for location group
   * to each location
   * 
   * @since 3.0.0
   */

  public function wcmlim_enable_location_group_callback(){
    $isLocationsGroup = get_option($this->option_name . '_enable_location_group');
  ?>
    <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_location_group') ?>" name="<?php esc_attr_e($this->option_name . '_enable_location_group') ?>" <?php echo ($isLocationsGroup == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <br>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If you enable you are able to set location groups', 'wcmlim') . '</label>'; ?>
  <?php
  }
  
  /**
   * callback function for force to select location
   *
   * @since    1.2.10
   */

  public function wcmlim_force_to_select_location_callback()
  {
    $isForced = get_option($this->option_name . '_force_to_select_location');
  ?>
    <label class="switch">
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_force_to_select_location') ?>" name="<?php esc_attr_e($this->option_name . '_force_to_select_location') ?>" <?php echo ($isForced == 'on') ? 'checked="checked"' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <br>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('If you enable we force visitors to select location first', 'wcmlim') . '</label>'; ?>
  <?php
  }

    /**
     * *callback function for order routing rules
     *
     * @since    1.2.5
     */

    public function wcmlim_order_fulfilment_rules_callback()
    {
      $fulfilment_rule = get_option("wcmlim_order_fulfilment_rules");
      if($fulfilment_rule == "nearby_instock")
      {
        $fulfilment_rule = "clcsadd";
      }
    ?>
      <select name="<?php esc_attr_e($this->option_name . '_order_fulfilment_rules') ?>" id="<?php esc_attr_e($this->option_name . '_order_fulfilment_rules') ?>">
        <option value="default"><?php _e('Please select rule', 'wcmlim'); ?></option>
        <option value="maxinvloc" <?php if ($fulfilment_rule == 'maxinvloc') {
                                    echo "selected='selected'";
                                  } ?>><?php _e('Location with most inventory in stock', 'wcmlim'); ?></option>
        <option value="clcsadd" <?php if ($fulfilment_rule == 'clcsadd') {
                                  echo "selected='selected'";
                                } ?>><?php _e('Closest location to Customers shipping address', 'wcmlim'); ?></option>

        <option value="locappriority" <?php if ($fulfilment_rule == 'locappriority') {
                                        echo "selected='selected'";
                                      } ?>><?php _e('Location as per priority in stock', 'wcmlim'); ?></option>

       <option value="shipping_loc" <?php if ($fulfilment_rule == 'shipping_loc') {
                                      echo "selected='selected'";
                                    } ?>><?php _e('Location as per Shipping Zones', 'wcmlim'); ?></option>                           

      </select>
    <?php echo '<label class="wcmlim-setting-option-des">' . __('<b>Rule description : </b><br>
    <b> 0. None selected rule :</b> For administration manually adding order, Location list dropdown under each item.<br>
    <b> 1.</b> <b>Location with most inventory in stock :</b> The location is automatically chosen with availability of most number of stock .<br><b>2.</b> <b>Closest location to Customers shipping address :</b> The location that is closest to the shipping address is automatically selected, even if the order is placed from a different location. <br><b> 3.</b> <b>Location as per priority in stock:</b> Assign location as per priority set and availability stock is automatically chosen. <br> <b> 4. Location as per Shipping Zones : </b>  i. The location belonging to the shipping zone from the order is automatically selected. <p> &nbsp; &nbsp; ii. Prerequisite: To enable and use this setting you need to enable shipping zone and shipping method settings first.</p>', 'wcmlim') . '</label>'; ?>
    <?php
    }


    /**
     * *callback function for Allow Local Pickup
     *
     * @since    1.1.8
     */

    public function wcmlim_allow_local_pickup_callback()
    {
      if (in_array('local-pickup-for-woocommerce/local-pickup.php', apply_filters('active_plugins', get_option('active_plugins'))) ||  is_array(get_site_option('active_sitewide_plugins')) && !array_key_exists('local-pickup-for-woocommerce/local-pickup.php', get_site_option('active_sitewide_plugins'))) 
        {
          update_option($this->option_name . '_allow_local_pickup','');
        }
      $allow_local_pickup = get_option($this->option_name . '_allow_local_pickup');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_allow_local_pickup') ?>" name="<?php esc_attr_e($this->option_name . '_allow_local_pickup') ?>" <?php echo ($allow_local_pickup == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Turning on this switch will allow Local Pickup Address details on frontend & if Backend Mode is enabled it will show a Dropdwon of Locations if Pickup Location Shipping Method is selected.', 'wcmlim') . '</label>'; ?>
      <a href="https://codecanyon.net/item/local-pickup-for-woocommerce/34768481?s_rank=1"> Click Here</a> To Download the Local Pickup for WooCommerce – Pickup Location, Date & Time Slots.


    <?php
    }
    
        /**
     * *callback function for Allow Local Pickup
     *
     * @since    1.1.8
     */

    public function wcmlim_allow_tax_to_locations_callback()
    {
      $allow_tax_location = get_option($this->option_name . '_allow_tax_to_locations');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_allow_tax_to_locations') ?>" name="<?php esc_attr_e($this->option_name . '_allow_tax_to_locations') ?>" <?php echo ($allow_tax_location == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Turning on this switch will allow to select set WC Tax to Locations.', 'wcmlim') . '</label>'; ?>
    <?php
    }

        /**
     * *callback function for enable tax for each item
     *
     * @since    1.1.8
     */

    public function wcmlim_enable_tax_to_each_item_callback()
    {
      $allow_tax_location = get_option($this->option_name . '_enable_tax_to_each_item');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_tax_to_each_item') ?>" name="<?php esc_attr_e($this->option_name . '_enable_tax_to_each_item') ?>" <?php echo ($allow_tax_location == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Turning on this switch will allow to select set WC Tax For Each Line Item.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for next closest location
     *
     * @since    1.1.5
     */
    public function wcmlim_next_closest_location_callback()
    {
      $nextCL = get_option($this->option_name . '_next_closest_location');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_next_closest_location') ?>" name="<?php esc_attr_e($this->option_name . '_next_closest_location') ?>" <?php echo ($nextCL == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('When enabled, the next in stock location will be shown if the current location has out of stock', 'wcmlim') . '</label>'; ?>
    <?php
    }

     /**
     * *callback function or distance calculator by coordinates
     *
     * @since    3.1.2
     */
    public function wcmlim_distance_calculator_by_coordinates_callback()
    {
      $distMatCalc = get_option($this->option_name . '_distance_calculator_by_coordinates');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_distance_calculator_by_coordinates') ?>" name="<?php esc_attr_e($this->option_name . '_distance_calculator_by_coordinates') ?>" <?php echo ($distMatCalc == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('If we enable Calculate Distance by co-ordinates. In this s case, Latitude and longitude are calculated based on the selected address.This setting is used for Nearby Location finder.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for Shipping Methods to specific locations
     *
     * @since    1.0.0
     */

    public function wcmlim_enable_shipping_methods_callback()
    {
      $enable_shipping_methods = get_option($this->option_name . '_enable_shipping_methods');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_shipping_methods') ?>" name="<?php esc_attr_e($this->option_name . '_enable_shipping_methods') ?>" <?php echo ($enable_shipping_methods == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to set shipping method to each location. You can set shipping methods from the location edit screen after enabling this. <b>Note - Shipping Zone Setting Must be enabled for this', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for Split Package by locations
     *
     * @since    3.0.2
     */

    public function wcmlim_enable_split_packages_callback()
    {
      $enable_split_packages = get_option($this->option_name . '_enable_split_packages');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_enable_split_packages') ?>" name="<?php esc_attr_e($this->option_name . '_enable_split_packages') ?>" <?php echo ($enable_split_packages == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to split package by locations', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for Hiding Locations which are out of Stock
     *
     * @since    1.1.6
     */

    public function wcmlim_hide_out_of_stock_location_callback()
    {
      $hide_out_of_stock_location = get_option($this->option_name . '_hide_out_of_stock_location');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_hide_out_of_stock_location') ?>" name="<?php esc_attr_e($this->option_name . '_hide_out_of_stock_location') ?>" <?php echo ($hide_out_of_stock_location == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable if you want to hide the location which has out of stock status from the dropdown on the front-end', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for Default zoom for map
     *
     * @since    1.1.8
     */

    public function wcmlim_default_zoom_callback()
    {
      $default_zoom = get_option($this->option_name . '_default_zoom');
      if (empty($default_zoom)) {
        $default_zoom = update_option($this->option_name . '_default_zoom', '10');
      }
      $default_zoom = get_option($this->option_name . '_default_zoom');

    ?>
      <input type="number" id="<?php esc_attr_e($this->option_name . '_default_zoom') ?>" name="<?php esc_attr_e($this->option_name . '_default_zoom') ?>" value="<?php echo $default_zoom; ?>" placeholder="eg. 10">
      <br /><label> Map will be load with given Default zoom level/scale </label>
    <?php
    }
    /**
     * *callback function for Default zoom for map
     *
     * @since    1.1.8
     */

    public function wcmlim_filter_visibility_shortcode_callback()
    {
      $filter_visibility_shortcode = get_option($this->option_name . '_filter_visibility_shortcode');
      if (!isset($filter_visibility_shortcode) && empty($filter_visibility_shortcode)) {
        $filter_visibility_shortcode = update_option($this->option_name . '_filter_visibility_shortcode', 'on');
      }
      $filter_visibility_shortcode = get_option($this->option_name . '_filter_visibility_shortcode');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_filter_visibility_shortcode') ?>" name="<?php esc_attr_e($this->option_name . '_filter_visibility_shortcode') ?>" <?php echo ($filter_visibility_shortcode == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br><label> Show product/category filter on Location Finder</label>
    <?php
    }
    /**
     * *callback function for Default color for map
     *
     * @since    1.1.8
     */

    public function wcmlim_default_map_color_callback()
    {
      $map_theme_color = get_option($this->option_name . '_default_map_color');
      if ($map_theme_color  == false) {
        update_option($this->option_name . '_default_map_color', '#187dc7');
      }
    ?>
      <input class="map_shortcode_color_field" id="map_shortcode_color_field" type="text" name="<?php esc_attr_e($this->option_name . '_default_map_color'); ?>" value="<?php esc_attr_e($map_theme_color); ?>" />
      <br /><label> Set theme color for Location Finder Map/Location Finder List </label>
    <?php
    }

    /**
     * *callback function for Default origin center for map
     *
     * @since    1.1.8
     */

    public function wcmlim_default_origin_center_callback()
    {
      $default_origin_center = get_option($this->option_name . '_default_origin_center');
    ?>
      <input type="text" id="wcmlim_autocomplete_address" name="<?php esc_attr_e($this->option_name . '_default_origin_center') ?>" value="<?php echo $default_origin_center; ?>" placeholder="Enter Address">
      <br /><label> Map will be load with given Default location as center</label>
    <?php
    }

    /**
     * *callback function for Default align location list map
     *
     * @since    1.1.8
     */

    public function wcmlim_default_list_align_callback()
    {
      $default_list_align = get_option($this->option_name . '_default_list_align');
    ?>
      <select name="<?php esc_attr_e($this->option_name . '_default_list_align') ?>" id="<?php esc_attr_e($this->option_name . '_default_list_align') ?>">
        <option value="default">
          Select Alignment
        </option>
        <option value="right" <?php if ($default_list_align == 'right') {
                                echo "selected='selected'";
                              } ?>>
          Right Align
        </option>
        <option value="left" <?php if ($default_list_align == 'left') {
                                echo "selected='selected'";
                              } ?>>
          Left Align
        </option>
      </select>
      <br /><label> Set Locations list alignment on Location Finder Map </label>
    <?php
    }



    /**
     * *callback function for Order Fulfilment
     *
     * @since    1.1.6
     */

    public function wcmlim_order_fulfil_edit_callback()
    {
      $order_fulfil_edit = get_option($this->option_name . '_order_fulfil_edit');
      ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_order_fulfil_edit') ?>" name="<?php esc_attr_e($this->option_name . '_order_fulfil_edit') ?>" <?php echo ($order_fulfil_edit == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label><br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enabling backend mode and selected any one options for order fulfilment rule. The stock levels of the Locations will get updated accordingly as per selecting.', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * *callback function for Allow to Work only for Backend
     *
     * @since    1.1.8
     */

    public function wcmlim_allow_only_backend_callback()
    {
      $allow_only_backend = get_option($this->option_name . '_allow_only_backend');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_allow_only_backend') ?>" name="<?php esc_attr_e($this->option_name . '_allow_only_backend') ?>" <?php echo ($allow_only_backend == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Turning on this switch will disable the front-end location selection functionality. you can modify the order from the backend. eg. User can order without selecting location but still, you can set location to order from backend. which will also update the selected location stock', 'wcmlim') . '</label>'; ?>
    <?php
    }

    /**
     * callback function for display settings checkbox.
     *
     * @since    1.0.0
     */

    public function wcmlim_display_settings_cb()
    {
      echo '<p>' . __('Please change the settings accordingly.', 'wcmlim') . '</p>';
    }

    /**
     * callback function for location select options.
     *
     * @since    1.0.0
     */

    public function wcmlim_location_select_cb()
    {
      $checked = get_option($this->option_name . '_location_select');
    ?>
      <label for="wcmlim_location_select_none">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_location_select') ?>" id="wcmlim_location_select_none" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('None', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_location_select_dropdown">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_location_select') ?>" id="wcmlim_location_select_dropdown" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Dropdown', 'wcmlim'); ?>
      </label>
    <?php
    }

    /**
     * callback function for Enabling search nearest location
     *
     * @since    1.0.0
     */

    public function wcmlim_search_nearest_location_cb()
    {
      $searchNearest = get_option($this->option_name . '_search_nearest_location');
    ?>
      <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_search_nearest_location') ?>" name="<?php esc_attr_e($this->option_name . '_search_nearest_location') ?>" <?php echo ($searchNearest == 'on') ? 'checked="checked"' : ''; ?>>
    <?php
    }

    /**
     * callback function for button style options.
     *
     * @since    1.0.0
     */

    public function wcmlim_button_style_cb()
    {
      $checked = get_option($this->option_name . '_button_style');
    ?>
      <label for="wcmlim_button_style_one">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_button_style') ?>" id="wcmlim_button_style_one" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Style 1', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_button_style_two">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_button_style') ?>" id="wcmlim_button_style_two" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Style 2', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_button_style_three">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_button_style') ?>" id="wcmlim_button_style_three" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Style 3', 'wcmlim'); ?>
      </label>
    <?php
    }

    /**
     * callback function for button text options.
     *
     * @since    1.0.0
     */

    public function wcmlim_button_text_cb()
    {
      $button_text = get_option($this->option_name . '_button_text');
    ?>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_button_text'); ?>" id="<?php esc_attr_e($this->option_name . '_button_text'); ?>" value="<?php esc_attr_e($button_text); ?>">
      <br>
      <p><?php echo __('text to appear on the bottom', 'wcmlim'); ?></p>
    <?php
    }

    /**
     * callback function for button color options.
     *
     * @since    1.0.0
     */

    public function wcmlim_button_color_cb()
    {
      $button_color = get_option($this->option_name . '_button_color');
    ?>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_button_color'); ?>" id="<?php esc_attr_e($this->option_name . '_button_color'); ?>" value="<?php esc_attr_e($button_color); ?>">
      <br>
      <p><?php echo __('Hex color of the bottom', 'wcmlim'); ?></p>
    <?php
    }

    /**
     * callback function for button border radius options.
     *
     * @since    1.0.0
     */

    public function wcmlim_button_border_radius_cb()
    {
      $button_radius = get_option($this->option_name . '_button_border_radius');
    ?>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_button_border_radius'); ?>" id="<?php esc_attr_e($this->option_name . '_button_border_radius'); ?>" value="<?php esc_attr_e($button_radius); ?>">
      <br>
      <p><?php echo __('Level of curve on design (0px for no curves)', 'wcmlim'); ?></p>
    <?php
    }

    /**
     * callback function for stock level number options.
     *
     * @since    1.0.0
     */

    public function wcmlim_show_stocklevel_numbers_cb()
    {
      $stockNumber = get_option($this->option_name . '_show_stocklevel_numbers');
    ?>
      <label for="wcmlim_show_stocklevel_numbers_yes">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_show_stocklevel_numbers') ?>" id="wcmlim_show_stocklevel_numbers_yes" <?php echo ($stockNumber == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Yes', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_show_stocklevel_numbers_no">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_show_stocklevel_numbers') ?>" id="wcmlim_show_stocklevel_numbers_no" <?php echo ($stockNumber == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('No', 'wcmlim'); ?>
      </label>
    <?php
    }

    /**
     * callback function for suggested location options.
     *
     * @since    1.0.0
     */

    public function wcmlim_suggested_location_cb()
    {
      $suggestLocation = get_option($this->option_name . '_suggested_location');
    ?>
      <label for="wcmlim_suggested_location_yes">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_suggested_location') ?>" id="wcmlim_suggested_location_yes" <?php echo ($suggestLocation == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Yes', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_suggested_location_no">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_suggested_location') ?>" id="wcmlim_suggested_location_no" <?php echo ($suggestLocation == 'on') ? 'checked="checked"' : ''; ?> />
        <?php echo __('No', 'wcmlim'); ?>
      </label>
    <?php
    }

    /**
     * callback function for suggested location distance options.
     *
     * @since    1.0.0
     */

    public function wcmlim_suggested_location_distance_cb()
    {
      $suggested_dis = get_option($this->option_name . '_suggested_location_distance');
    ?>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_suggested_location_distance'); ?>" id="<?php esc_attr_e($this->option_name . '_suggested_location_distance'); ?>" value="<?php esc_attr_e($suggested_dis); ?>">
    <?php
    }

    /**
     * callback function for custom css enable or not.
     *
     * @since    1.2.4
     */

    public function wcmlim_custom_css_enable_cb()
    {
      $customcss_enable = get_option($this->option_name . '_custom_css_enable');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_custom_css_enable') ?>" name="<?php esc_attr_e($this->option_name . '_custom_css_enable') ?>" <?php echo ($customcss_enable == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Please enable if you want to disable plugins css for frontend, and use custom css', 'wcmlim') . '</label>'; ?>
    <?php
    }
    /**
     * callback function for show location distance options.
     *
     * @since    1.0.0
     */

    public function wcmlim_show_location_distance_cb()
    {
      $locationDistance = get_option($this->option_name . '_show_location_distance');
    ?>
      <label for="wcmlim_show_location_distance_none">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_show_location_distance') ?>" id="wcmlim_show_location_distance_none" value="none" <?php echo ($locationDistance == 'none') ? 'checked="checked"' : ''; ?> />
        <?php echo __('None', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_show_location_distance_miles">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_show_location_distance') ?>" id="wcmlim_show_location_distance_miles" value="miles" <?php echo ($locationDistance == 'miles') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Miles', 'wcmlim'); ?>
      </label>

      <label for="wcmlim_show_location_distance_kms">
        <input type="radio" name="<?php esc_attr_e($this->option_name . '_show_location_distance') ?>" id="wcmlim_show_location_distance_kms" value="kms" <?php echo ($locationDistance == 'kms') ? 'checked="checked"' : ''; ?> />
        <?php echo __('Kilometers', 'wcmlim'); ?>
      </label>
    <?php
    }

    /**
     * callback function for show location distance options.
     *
     * @since    1.1.4
     */
    public function wcmlim_exclude_locations_from_frontend_cb()
    {
      $excludedLocations = get_option($this->option_name . '_exclude_locations_from_frontend');
    ?>
      <select multiple="multiple" class="multiselect" name="wcmlim_exclude_locations_from_frontend[]" id="wcmlim_exclude_locations_from_frontend" data-placeholder="Select Some Locations">
        <?php
        $args = ['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0];
        $all_locations = get_terms($args);
        foreach ((array) $all_locations as $location) {
        ?>
          <option value="<?php esc_html_e($location->term_id); ?>" <?php if (!empty($excludedLocations)) {
                                                                      if (in_array($location->term_id, $excludedLocations)) {
                                                                        echo "selected='selected'";
                                                                      }
                                                                    }
                                                                    ?>><?php esc_html_e($location->name); ?></option>
        <?php } ?>
      </select>
      <br />
       <!-- Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code init -->
       <p class="exclude_prod_onfront"></p>
      <!-- Add Validation to "Exclude all locations" settings - User should not able to exclude all locations -code init -->
      <?php echo '<label class="wcmlim-setting-option-des">' . __('The selected location will be hidden from location dropdown in frontend', 'wcmlim') . '</label>'; ?>
      <?php
    }

    /**
     * callback function for show location Group options.
     *
     * @since    3.0.0
     */
    public function wcmlim_exclude_locations_group_frontend_cb()
    {
      $excludedLocationGroup = get_option($this->option_name . '_exclude_locations_group_frontend');
    ?>
      <select multiple="multiple" class="multiselect" name="wcmlim_exclude_locations_group_frontend[]" id="wcmlim_exclude_locations_group_frontend" data-placeholder="Select Location Groups">
        <?php
        $args = ['taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0];
        $all_locationgroup = get_terms($args);
        foreach ((array) $all_locationgroup as $location) {
        ?>
          <option value="<?php esc_html_e($location->term_id); ?>" <?php if (!empty($excludedLocationGroup)) {
                                                                      if (in_array($location->term_id, $excludedLocationGroup)) {
                                                                        echo "selected='selected'";
                                                                      }
                                                                    }
                                                                    ?>><?php esc_html_e($location->name); ?></option>
        <?php } ?>
      </select>
      <br />
       <!-- Add Validation to "Exclude all locations group" settings - User should not able to exclude all locations -code init -->
       <p class="exclude_prodg_onfront"></p>
      <!-- Add Validation to "Exclude all locations group" settings - User should not able to exclude all locations -code init -->
      
      <?php echo '<label class="wcmlim-setting-option-des">' . __('The selected location will be hidden from location dropdown in frontend', 'wcmlim') . '</label>'; ?>
      <?php
    }
    
    /**
	  * callback function for show location in popup.
	  *
	  * @since    1.2.11
	  */

	public function wcmlim_show_in_popup_cb()
	{
		$locationInPopup = get_option($this->option_name . '_show_in_popup');
	  ?> 
	<label for="wcmlim_show_in_popup_select">
    <input type="checkbox" name="<?php esc_attr_e($this->option_name . '_show_in_popup[]') ?>" id="wcmlim_show_in_popup_select" value="location_dropdown_in_popup" <?php echo (!empty($locationInPopup) && is_array($locationInPopup) && in_array('location_dropdown_in_popup',$locationInPopup) ) ? 'checked="checked"' : ''; ?> />

         
         <?php echo __('Location dropdown', 'wcmlim'); ?>
        </label>

        <label for="wcmlim_show_in_popup_input">
    <input type="checkbox" name="<?php esc_attr_e($this->option_name . '_show_in_popup[]') ?>" id="wcmlim_show_in_popup_select" value="location_finder_in_popup" <?php echo (!empty($locationInPopup) && is_array($locationInPopup) && in_array('location_finder_in_popup',$locationInPopup) ) ? 'checked="checked"' : ''; ?> />
          <?php echo __('Nearby location Finder', 'wcmlim'); ?>
        </label>
	  <?php
	}

    /**
     * Removed default taxonomy coloumn and add new one.
     *
     * @since    1.0.0
     */

    public function wcmlim_remove_default_tcoloumn($columns)
    {
      unset($columns['taxonomy-locations']);
      return array_slice($columns, 0, 5, true)
        + array('stock_at_locations' => __('Stock at Locations', 'wcmlim'))
        + array_slice($columns, 5, NULL, true);
      return $columns;
    }
    
     /**
     * Add location price coloumn.
     *
     * @since    1.0.0
     */

    public function wcmlim_add_price_at_location_tcoloumn($columns)
    {
      $new_columns = array();

    foreach ( $columns as $column_name => $column_info ) {

        $new_columns[ $column_name ] = $column_info;

        if ( 'stock_at_locations' === $column_name ) {
            $new_columns['price_at_locations'] = __( 'Price at Locations', 'wcmlim' );
        }
    }

    return $new_columns;
    }
    

    /**
     * Returns new taxonomy coloumn.
     *
     * @since    1.0.0
     */
    public function wcmlim_populate_locations_column($column_name)
    {
      if ($column_name == 'stock_at_locations') {
        $cuser = wp_get_current_user();
        $cuserId = $cuser->ID;
        $cuserRoles = $cuser->roles;
        $product = wc_get_product(get_the_ID());
        if (!empty($product)) {
          $variations_products = array();
          if (!empty($product) && $product->is_type('variable')) {
            $product_variations_ids = $product->get_children();
            $product_variations = array();
            foreach ($product_variations_ids as $variation_id) {
              $product_variations[] = $product->get_available_variation($variation_id);
            }
            foreach ($product_variations as $variation) {
              $variations_products[] = wc_get_product($variation['variation_id']);
            }
          }
          // Get locations from parent product
          $locations = wp_get_post_terms($product->get_id(), 'locations', array('parent' => 0));
          if(empty($locations))
          {
            $args = ['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0];
            $locations = get_terms($args);
          }
          // Print data
          if ($product->is_type('simple')) {
            echo '<label>#' . $product->get_id() . ':</label><br>';
            if($product->managing_stock()){
              $this->show_locations_in_column($product->get_id(), $locations, $cuserId, $cuserRoles );
            }elseif(!$product->is_in_stock()){
              echo '<mark class="outofstock">Out of stock</mark>';
            }
            else{
              echo '<mark class="instock">In stock</mark>';
            }
          } elseif ($product->is_type('variable')) {
            echo '<label>#' . $product->get_id() . ':</label><br>';
            if($product->managing_stock()){
              $this->show_locations_in_column($product->get_id(), $locations, $cuserId, $cuserRoles );
            }else{
              echo '<mark class="instock">In stock</mark>';
            }
            if (!empty($variations_products)) {
              foreach ($variations_products as $variation_product) {
                if($variation_product->managing_stock()){
                  foreach ($attributes = $variation_product->get_variation_attributes() as $attribute) {
                    echo '<label>#' . $variation_product->get_id() . ' (' . ucfirst($attribute) . '):</label><br>';
                  }
                  $this->show_locations_variations_in_column($variation_product->get_id(), $locations, $cuserId, $cuserRoles );
                }
              }
            }
          }
        }
      }
    }

    public function wcmlim_populate_stock_column($column_name)
    {
      if ($column_name == 'is_in_stock') {
        $isExcludeLocation = get_option("wcmlim_exclude_locations_from_frontend");
									if (!empty($isExcludeLocation)) {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcludeLocation));
									} else {
										$terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
									}
        $p_id = get_the_ID();
        $product = wc_get_product($p_id);        
        $text = get_post_meta($p_id, '_stock_status', true);
        $count=0;
        if ($product->is_type("variable")) {
          $variations = $product->get_available_variations();

            foreach ($terms as $k => $term) {
              foreach ($variations as $key => $value) {
                $check_taxanomy_variable = '';
                $check_taxanomy_variable =  get_post_meta($value['variation_id'], "wcmlim_stock_at_{$term->term_id}", true);
                if($check_taxanomy_variable!=''){
                  $count = $count + 1;
                }
              }
            }
            if ($count > 0) {
              update_post_meta($p_id, '_stock_status', 'instock');
            } else {
              update_post_meta($p_id, '_stock_status', 'outofstock');
            } 
          }
      }
    }
    /**
     * Returns new Location Price coloumn.
     *
     * @since    1.2.9
     */

    public function wcmlim_populate_price_locations_column($column_name)
    {
      if ($column_name == 'price_at_locations') {
        $cuser = wp_get_current_user();
        $cuserId = $cuser->ID;
        $cuserRoles = $cuser->roles;
        $product = wc_get_product(get_the_ID());
        if (!empty($product)) {
          $variations_products = array();
          if (!empty($product) && $product->is_type('variable')) {
            $product_variations_ids = $product->get_children();
            $product_variations = array();
            foreach ($product_variations_ids as $variation_id) {
              $product_variations[] = $product->get_available_variation($variation_id);
            }
            foreach ($product_variations as $variation) {
              $variations_products[] = wc_get_product($variation['variation_id']);
            }
          }
          // Get locations from parent product
          $locations = wp_get_post_terms($product->get_id(), 'locations', array('parent' => 0));
          if(empty($locations))
          {
            $args = ['taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0];
            $locations = get_terms($args);
          }
          // Print data
          if ($product->is_type('simple')) {
            echo '<label>#' . $product->get_id() . ':</label><br>';
            $this->show_price_locations_in_column($product->get_id(), $locations, $cuserId, $cuserRoles );
          } elseif ($product->is_type('variable')) {
            echo '<label>#' . $product->get_id() . ':</label><br>';
            $this->show_price_locations_in_column($product->get_id(), $locations, $cuserId, $cuserRoles );
            if (!empty($variations_products)) {
              foreach ($variations_products as $variation_product) {
                foreach ($attributes = $variation_product->get_variation_attributes() as $attribute) {
                  echo '<label>#' . $variation_product->get_id() . ' (' . ucfirst($attribute) . '):</label><br>';
                }
                $this->show_price_locations_variations_in_column($variation_product->get_id(), $locations, $cuserId, $cuserRoles );
              }
            }
          }
        }
      }
    }
    
    /**
     * Replaced stock column to sync and show stock qty
     *
     * @since    3.3.7
     */
    public function wcmlim_filter_woocommerce_admin_stock_html( $stock_html, $product ) {
      // update it
      $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
        if ($product->is_type("simple")) {
            $product_id = $product->get_id();
            $_loc_stock = array();
            $_stock = get_post_meta($product_id, '_stock', true);
            foreach ($terms as $key => $value) {
                $for_loc_stock = (int)get_post_meta( $product_id, "wcmlim_stock_at_{$value->term_id}" , true );
                array_push($_loc_stock, $for_loc_stock);
                $all_location_stock_qty = array_sum($_loc_stock);
            }
            $stockQty = $all_location_stock_qty;
            if($all_location_stock_qty != $_stock){
                // Mark product as updated
                update_post_meta($product_id, "_stock", $all_location_stock_qty);
                $product->update_meta_data( 'wcmlim_sync_updated', true );
            }

            $product->save();
        } elseif ($product->is_type("variable")) {
            $variations = $product->get_available_variations();
            $variations_id = wp_list_pluck($variations, 'variation_id');
            if (!empty($variations_id)) {
                foreach ($variations_id as $varid) { 
                    $_loc_var_stock = array();
                    $_stock = get_post_meta($varid, '_stock', true);
                    foreach ($terms as $key => $value) {
                        $for_var_loc_stock = (int)get_post_meta( $varid, "wcmlim_stock_at_{$value->term_id}" , true );
                        array_push($_loc_var_stock, $for_var_loc_stock);
                        $all_var_location_stock_qty = array_sum($_loc_var_stock);
                    }
                    $stockQty[] = $all_var_location_stock_qty;
                    
                    if($all_var_location_stock_qty != $_stock){
                        // Mark product as updated
                        update_post_meta($varid, "_stock", $all_var_location_stock_qty);
                        $product->update_meta_data( 'wcmlim_sync_updated', true );
                    }
                    
                    $product->save();
                }
                $stockQty = array_sum($stockQty);
            }
        } else {
            _e("nothing to update", "wcmlim");
        }

        $manageStock = get_post_meta($product->get_id(), '_manage_stock', true);
        if ( $stockQty > 0 && $stockQty != "" && $manageStock == "yes" && $product->is_in_stock()|| $product->is_type("variable")) {
            $stock_html = '<mark class="instock">'.esc_html("In stock", "woocommerce").'</mark> (' . esc_attr( $stockQty, 'wcmlim' ) . ')';      
        }elseif($manageStock == "no" && $product->is_in_stock()){
            $stock_html = '<mark class="instock">'.esc_html("In stock", "woocommerce").'</mark>';      
        }elseif(!$product->is_in_stock()){
            $stock_html = '<mark class="outofstock">'.esc_html("Out of stock", "woocommerce").'</mark>';  
        }

      return $stock_html;
    }

    /**
     * Show data in new taxonomy coloumn.
     *
     * @since    1.0.0
     */

    function show_locations_in_column($product_id, $locations, $cuserId, $cuserRoles )
    {
      if (!empty($locations)) {
        $product = wc_get_product( $product_id );
        $restock = 0;
        foreach ($locations as $location) {
          $prod_name = $product->get_name();
          $loc_stock = get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true);
          $shopM =  get_term_meta($location->term_id, 'wcmlim_shop_manager', true);
          $restock += intval($loc_stock); 
          $regM = get_term_meta($location->term_id, "wcmlim_locator", true);
          $regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);  

          if (in_array("location_shop_manager", $cuserRoles) && !empty($shopM) && in_array($cuserId, $shopM) && $loc_stock >= 0 && $loc_stock != null) {
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil "></i><br>';
          } elseif (in_array("location_regional_manager", $cuserRoles) && !empty($regM2) && in_array($cuserId, $regM2) && $loc_stock >= 0 && $loc_stock != null) {     
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil "></i><br>';
          } elseif (current_user_can('administrator')) {
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil "></i><br>';
          } else {
            //Won't edit stock
          }
        }
        if(intval($restock) > 0)
        {
          update_post_meta($product_id, '_stock', $restock);
        }
      }
    }
    public function show_locations_variations_in_column($product_id, $locations, $cuserId, $cuserRoles )
    {
      if (!empty($locations)) {
        $product = wc_get_product( $product_id );
        $restock = 0;
        foreach ($locations as $location) {
          $prod_name = $product->get_name();
          $loc_stock = get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true);
          $shopM =  get_term_meta($location->term_id, 'wcmlim_shop_manager', true);
          $regM = get_term_meta($location->term_id, "wcmlim_locator", true);
          $regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);  
          $restock += intval($loc_stock); 
          if (in_array("location_shop_manager", $cuserRoles) && !empty($shopM) && in_array($cuserId, $shopM) && $loc_stock >= 0 && $loc_stock != null) {
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil"></i><br>';
          } elseif (in_array("location_regional_manager", $cuserRoles) && !empty($regM2) && in_array($cuserId, $regM2) && $loc_stock >= 0 && $loc_stock != null) {     
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil"></i><br>';
          } elseif (current_user_can('administrator')) {
            echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="change_'.$product_id.'_'.$location->term_id.'">(' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . ')</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-stock="' . get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true) . '" title="Change Stock" id="stock_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_stock_pro_list fa fa-pencil"></i><br>';
          } else {
              //Won't edit stock
          }
        }
        if(intval($restock) > 0)
        {
          update_post_meta($product_id, '_stock', $restock);
        }
      }
    }
    /**
     * Show location price in new price coloumn.
     *
     * @since    1.2.9
     */

    function show_price_locations_in_column($product_id, $locations, $cuserId, $cuserRoles )
    {
      if (!empty($locations)) {
        $product = wc_get_product( $product_id );
        foreach ($locations as $location) {
          $prod_name = $product->get_name();
          $shopM =  get_term_meta($location->term_id, 'wcmlim_shop_manager', true);
          $regM = get_term_meta($location->term_id, "wcmlim_locator", true);
          $regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);
          // If out of stock
          $wcmlim_stock_at = get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true);
          $location_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$location->term_id}", true);
          $location_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$location->term_id}", true);
          $wc_currency_symbol = get_woocommerce_currency_symbol();
            if(!empty($location_regular_price))
            {
                $location_regular_price = number_format(floatval($location_regular_price),2);    
            }
            if(!empty($location_sale_price))
            {
                $location_sale_price = number_format(floatval($location_sale_price),2);    
            }            
            if(!empty($location_sale_price) && $location_sale_price != 0 )
            {
              $wcmlim_price_html =  '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_regular_price.'</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_sale_price.'</span></ins>';
            }
            elseif(empty($location_regular_price) && !empty($wcmlim_stock_at))
            {
              $wcmlim_price_html =  '';
            }
            else
            {
              $wcmlim_price_html =  '<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_regular_price.'</span></ins>';
            }
           
            if (in_array("location_shop_manager", $cuserRoles) && !empty($shopM) && in_array($cuserId, $shopM) && $product->is_type( 'simple' ) && !empty($wcmlim_stock_at) ) {
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } elseif (in_array("location_regional_manager", $cuserRoles) && !empty($regM2) && in_array($cuserId, $regM2) && $product->is_type( 'simple' ) && !empty($wcmlim_stock_at) ) {     
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } elseif (current_user_can('administrator')) {
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } else {
                //Won't edit stock
            }
        }
      }
    }
    public function show_price_locations_variations_in_column($product_id, $locations, $cuserId, $cuserRoles )
    {
      if (!empty($locations)) {
        $product = wc_get_product( $product_id );
        foreach ($locations as $location) {
          $prod_name = $product->get_name();
          $shopM =  get_term_meta($location->term_id, 'wcmlim_shop_manager', true);
          $regM = get_term_meta($location->term_id, "wcmlim_locator", true);
          $regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);
          // If out of stock
          $location_regular_price = get_post_meta($product_id, "wcmlim_regular_price_at_{$location->term_id}", true);
          $location_sale_price = get_post_meta($product_id, "wcmlim_sale_price_at_{$location->term_id}", true);
          $wc_currency_symbol = get_woocommerce_currency_symbol();
          if(!empty($location_regular_price))
            {
                $location_regular_price = number_format(floatval($location_regular_price),2);    
            }
            if(!empty($location_sale_price))
            {
                $location_sale_price = number_format(floatval($location_sale_price),2);    
            }
            if(!empty($location_sale_price) && $location_sale_price != 0 )
            {
              $wcmlim_price_html =  '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_regular_price.'</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_sale_price.'</span></ins>';
            }
            elseif(empty($location_regular_price))
            {
              $wcmlim_price_html =  '';
            }
            else
            {
              $wcmlim_price_html =  '<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.$wc_currency_symbol.'</span>'.$location_regular_price.'</span></ins>';
            }
            if (in_array("location_shop_manager", $cuserRoles) && !empty($shopM) && in_array($cuserId, $shopM) ) {
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } elseif (in_array("location_regional_manager", $cuserRoles) && !empty($regM2) && in_array($cuserId, $regM2) ) {     
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } elseif (current_user_can('administrator')) {
              echo '<span style="margin-left: 10px;"><mark class="instock">' . $location->name . '</mark> <span class="price_change_'.$product_id.'_'.$location->term_id.'">' . $wcmlim_price_html . '</span></span><i data-productname="'.$prod_name.'" data-locationname="'.$location->name.'" data-id="'.$product_id.'" data-location="'.$location->term_id.'" data-saleprice="' . $location_sale_price. '" data-currency="' . $wc_currency_symbol. '" data-regularprice="' . $location_regular_price. '" title="Change Price" id="price_data_attr_change_'.$product_id.'_'.$location->term_id.'" class="wcmlim_edit_price_pro_list fa fa-pencil"></i><br>';
            } else {
                //Won't edit stock
            }
        }
      }
    }

    /**
     * Returns filter for taxonomy coloumn.
     *
     * @since    1.0.0
     */

    public function wcmlim_filter_by_taxonomy_locations($post_type, $which)
    {
		if (isset($_GET['post_type'])) {
			if ($_GET['post_type'] != 'shop_order') {
      ?>
<!-- Stock Edit Modal Starts here -->
             <div id="stockModal" class="wcmlim-modal">
<!-- Modal content -->
<div class="wcmlim-modal-content">
  <div class="wcmlim-modal-header">
    <span class="wcmlim-close">&times;</span>
    <h2>Update Stock For <span class="wcmlim_stock_modal_product_name"></span></h2>
  </div>
  <div class="wcmlim-modal-body">
  <input name="wcmlim_stock_modal_location_stock" type="hidden" class="wcmlim_stock_modal_product_id">
  <input name="wcmlim_stock_modal_location_stock" type="hidden" class="wcmlim_stock_modal_location_id">
  <table class="form-table" role="presentation">
	<tbody>
    <tr class="form-field form-required">
		  <td scope="row"><label class="wcmlim_stock_modal_location_name" for="wcmlim_stock_modal_location_stock"></label></td>
		  <td><input name="wcmlim_stock_modal_location_stock" type="number" class="wcmlim_stock_modal_location_stock" id="wcmlim_stock_modal_location_stock" value=""></td>
	  </tr>
  </tbody>
  </table>
  <hr />
  <br />
  <button class="button button-primary wcmlim_update_inline_stock" type="button" style="width: 100%;">Update Stock </button>
  <p class="wcmlim_update_inline_stock_msg">&nbsp;</p>
  </div>
</div>
</div>
<!-- Price Edit Modal Starts here -->
<div id="priceModal" class="wcmlim-modal">
<!-- Modal content -->
<div class="wcmlim-modal-content">
  <div class="wcmlim-modal-header">
    <span class="wcmlim-close wcmlim-price-modal-close">&times;</span>
    <h2>Update Price For <span class="wcmlim_stock_modal_product_name"></span></h2>
  </div>
  <div class="wcmlim-modal-body">
  <input name="wcmlim_stock_modal_location_stock" type="hidden" class="wcmlim_stock_modal_product_id">
  <input name="wcmlim_stock_modal_location_stock" type="hidden" class="wcmlim_stock_modal_location_id">
  <input name="wcmlim_stock_modal_currency" type="hidden" class="wcmlim_stock_modal_currency">
  <table class="form-table" role="presentation">
	<tbody>
  <tr class="form-field form-required">
		  <th scope="row"><label class="wcmlim_stock_modal_location_name" for="wcmlim_stock_modal_location_regular_price"></label></th>
	  </tr>
    <tr class="form-field form-required">
		  <td scope="row"><label for="wcmlim_stock_modal_location_regular_price">Regular Price</label> (<span class="wcmlim_price_currency"></span>)</td>
		  <td><input name="wcmlim_stock_modal_location_stock" type="text" class="wcmlim_stock_modal_location_regular_price" id="wcmlim_stock_modal_location_regular_price" value=""></td>
	  </tr>
    <tr class="form-field form-required">
		  <td scope="row"><label for="wcmlim_stock_modal_location_sale_price">Sale Price</label> (<span class="wcmlim_price_currency"></span>)</td>
		  <td><input name="wcmlim_stock_modal_location_stock" type="text" class="wcmlim_stock_modal_location_sale_price" id="wcmlim_stock_modal_location_sale_price" value=""></td>
	  </tr>
  </tbody>
  </table>
  <hr />
  <br />
  <button class="button button-primary wcmlim_update_inline_price" type="button" style="width: 100%;">Update Price </button>
  <p class="wcmlim_update_inline_stock_msg">&nbsp;</p>
  </div>
</div>
</div>

      <?php
			}
		}
      // Apply this only on a specific post type
      if ('product' !== $post_type) return;
      // A list of taxonomy slugs to filter by
      $taxonomies = array('locations');
      foreach ($taxonomies as $taxonomy_slug) {
        // Retrieve taxonomy data
        $taxonomy_name = 'locations';
        // Retrieve taxonomy terms
        $terms = get_terms($taxonomy_slug, array('parent' => 0));
        // Display filter HTML
        echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
        echo '<option value="">' . sprintf(esc_html__('Show all %s', $this->plugin_name), $taxonomy_name) . '</option>';
        foreach ($terms as $term) {
          printf(
            '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
            $term->slug,
            ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
            $term->name,
            $term->count
          );
        }
        echo '</select>';
      }
    }
public function wcmlim_sync_on_product_save( $meta_id, $post_id, $meta_key, $meta_value ) {
  if ( $meta_key == '_edit_lock') { // we've been editing the post
      if ( get_post_type( $post_id ) == 'product' ) { // we've been editing a product
          $product = wc_get_product( $post_id );
          $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false));
        $all_stock = 0;
      foreach ($terms as $term) {
        $term_id = $term->term_id;
        $location_stock = get_post_meta($post_id,  "wcmlim_stock_at_{$term->term_id}", true); 
      $all_stock= $all_stock + (int)$location_stock; 
     
      }
      $manage_stock = get_post_meta($post_id, '_manage_stock', true);
       if($manage_stock)
      {
        if(intval($all_stock) > 0)
        {
          update_post_meta($post_id, '_stock', $all_stock);
        }
      }
      else 
      {
		// $resetTerms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false));
		// foreach ($resetTerms as $rT) {
		// 	update_post_meta($post_id, "wcmlim_stock_at_{$rT->term_id}", 0);
		// }
      return;
      }    
      }
  }
}
    // Custom function where metakeys / labels pairs are defined
    public function wcmlim_get_filter_shop_order_meta($domain = 'woocommerce')
    {
      $order_filter = array();
      // Add below the metakey / label pairs to filter orders
      $taxonomies = array('locations');
      foreach ($taxonomies as $taxonomy_slug) {
        // Retrieve taxonomy data
        $taxonomy_name = 'locations';
        // Retrieve taxonomy terms
        $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));

        foreach ($terms as $term) {
          $wordCount = explode(" ", $term->name);
          if (count($wordCount) > 1) {
            $_termname = str_replace(' ', '-', strtolower($term->name));
          } else {
            $_termname = $term->name;
          }
          $order_filter[] = array(
            $_termname => __($term->name, $domain),
          );
        }
      }
      return $order_filter;
    }

    // Add a dropdown to filter orders by meta

    public function wcmlim_display_location_filter_on_shoppge()
    {
      global $pagenow, $typenow;

      if ('shop_order' === $typenow && 'edit.php' === $pagenow) {
        $domain    = 'woocommerce';
        $filter_id = 'filter_shop_order_by_meta';
        $current   = isset($_GET[$filter_id]) ? $_GET[$filter_id] : '';

        echo '<select name="' . $filter_id . '">
        <option value="">' . __('All locations', $domain) . '</option>';

        $options = $this->wcmlim_get_filter_shop_order_meta($domain);

        foreach ($options as $key => $label) {

          $taxonomies = array('locations');
          foreach ($taxonomies as $taxonomy_slug) {
            // Retrieve taxonomy data
            $taxonomy_name = 'locations';
            // Retrieve taxonomy terms
            $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
            foreach ($terms as $term) {
              $wordCount = explode(" ", $term->name);
              if (count($wordCount) > 1) {
                $_termname = str_replace(' ', '-', strtolower($term->name));
              } else {
                $_termname = $term->name;
              }
              if (in_array($term->name, $label)) {
                printf(
                  '<option value="%s" %s>%s</option>',
                  $_termname,
                  $_termname === $current ? 'selected="selected"' : '',
                  $term->name
                );
              }
            }
          }
        }
        echo '</select>';
      }
      ?>
<a href="?post_type=shop_order"><input type="button" class="button" id="wcmlim-order-filter-reset" value="Reset"></a>
<?php
    }

    // Process the filter dropdown for orders by locations

    public function wcmlim_process_location_filter_on_shoppage($vars)
    {
      global $pagenow, $typenow;

      $filter_id = 'filter_shop_order_by_meta';
      if ($pagenow == 'edit.php' && 'shop_order' === $typenow && isset($_GET[$filter_id]) && !empty($_GET[$filter_id])) {
        $vars['meta_key'] = "_location";
        $vars['meta_value']   = $_GET[$filter_id];
      }
      return $vars;
    }

    /**
     * Restrict user to default location
     *
     * @since    1.1.2
     */

    public function wcmlim_get_all_locations()
    {
      $isLcex = get_option("wcmlim_exclude_locations_from_frontend");
      if (!empty($isLcex)) {
        $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isLcex));
      } else {
        $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
      }
      $result = [];
      $i = 0;
      foreach ($terms as $k => $term) {
        $term_meta = get_option("taxonomy_$term->term_id");
        $term_meta = array_map(function ($term) {
          if (!is_array($term)) {
            return $term;
          }
        }, $term_meta);
        $result[$i]['location_address'] = implode(" ", array_filter($term_meta));
        $result[$i]['location_name'] = $term->name;
        $result[$i]['term_id'] = $term->term_id;
        $i++;
      }

      return $result;
      wp_die();
    }

    /**
     * Add fields to user profile screen, add new user screen
     */
    

    public function wcmlim_register_profile_fields($user)
    {

      if ($user != "add-new-user") {
        $userID = $user->ID;
        if (!current_user_can('administrator', $userID))
          return false;
      }
      $ui = isset($userID) ? $userID : "";
      $selected_location = get_user_meta($ui, 'wcmlim_user_specific_location', true);
      $locations_list = $this->wcmlim_get_all_locations();
      if (sizeof($locations_list) > 0) {
      ?>
        <h3><?php _e('WC Multi locations Inventory', 'wcmlim'); ?></h3>
        <table class="form-table">
          <tr>
            <th>
              <label for="wcmlim_user_specific_location"><?php _e('Choose default location', 'wcmlim'); ?></label>
            </th>
            <td>
              <select name="wcmlim_user_specific_location" id="">
                <option value="-1" <?php if (!$selected_location) echo "selected='selected'"; ?>><?php echo __('select', 'wcmlim') ?></option>
                <?php
                foreach ($locations_list as $key => $loc) {
                ?>
                  <option value="<?php echo $key; ?>" data-lc-address="<?php echo base64_encode($loc['location_address']); ?>" <?php if (preg_match('/^\d+$/', $selected_location)) {
                                                                                                                                  if ($selected_location == $key) echo "selected='selected'";
                                                                                                                                } ?>><?php echo ucfirst($loc['location_name']); ?></option>
                <?php
                }
                ?>
              </select>
            </td>
          </tr>
        </table>
      <?php }
    }

    /**
     *  Save portal category field to user profile page, add new profile page etc
     */
    public function wcmlim_save_profile_fields($user_id)
    {
      if (!current_user_can('administrator', $user_id))
        return false;

      $specificLocaion = isset($_POST['wcmlim_user_specific_location']) ? intval($_POST['wcmlim_user_specific_location']) : "";
      update_user_meta($user_id, 'wcmlim_user_specific_location', $specificLocaion);
    }

    function getShopMangersLocation($current_user_id)
    {
      $taxonomies = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
      if (!empty($taxonomies)) {
        foreach ($taxonomies as $term) {
          $shopManager = get_term_meta($term->term_id, "wcmlim_shop_manager", true);
          if (!empty($shopManager)) {
            if (in_array($current_user_id, $shopManager)) {
              $locationNames = $term->term_id;
              $wordCount = explode(" ", $locationNames);
              if (count($wordCount) > 1) {
                $_location = str_replace(' ', '-', strtolower($locationNames));
              } else {
                $_location = $locationNames;
              }

              if (preg_match('/"/', $_location)) {
                $_location = str_replace('"', '', $_location);
              }

              $result[] = $_location;
            }
          }
        }

        return $result;
      }
    }
    function getShopRegional_MangersLocation($current_user_id)
    {
      $taxonomies = get_terms(array('taxonomy' => 'location_group', 'hide_empty' => false, 'parent' => 0));
      if (!empty($taxonomies)) {
        foreach ($taxonomies as $term) {
          $regshopManager = get_term_meta($term->term_id, "wcmlim_shop_regmanager", true);
          if (!empty($regshopManager)) {
            if (in_array($current_user_id, $regshopManager)) {
              $locationId1 = $term->term_id;       
              $terms_ID = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
              $items = array();
              foreach ($terms_ID as $k => $term2) {
                $locationgID2 = get_term_meta($term2->term_id, "wcmlim_locator", true);
                if ($locationId1 == $locationgID2) {                
                $locationNames = $term2->term_id;
                $wordCount = explode(" ", $locationNames);
                if (count($wordCount) > 1) {
                  $_location = str_replace(' ', '-', strtolower($locationNames));
                } else {
                   $_location = $locationNames;
                }
                if (preg_match('/"/', $_location)) {
                  $_location = str_replace('"', '', $_location);
                } 
                $items[] = $_location;
                }
              }  // Get All Regional Location.               

              $result[] = $items;

            } else {
              // Redirect to Order Listing Page 
              $url =  admin_url( 'edit.php?post_type=shop_order');
              wp_safe_redirect( $url );
              exit;              
            }
          }
        }

        return $result;
      }
    }

    public function wcmlim_filter_orders_by_location($query)
    {

      $isShopManagerEnable = get_option('wcmlim_assign_location_shop_manager');

      global $pagenow;

      if(!function_exists('wp_get_current_user')) {
        include(ABSPATH . "wp-includes/pluggable.php"); 
      }
      
      $current_user = wp_get_current_user();
      $qv = &$query->query_vars;
      $current_user_id = $current_user->ID;
      $currentUserRoles = $current_user->roles;

      if (in_array('location_shop_manager', $currentUserRoles)) {
        if (in_array('location_shop_manager', $currentUserRoles) && $isShopManagerEnable == "on") {
          if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == 'shop_order') {

            $places = $this->getShopMangersLocation($current_user_id);          
            if ( !empty($places) ) {
              $meta_query = array('relation' => 'OR');
              foreach ($places as $placesvalue) {
                  $meta_query[] = array(
                      'key'       => '_multilocation',
                      'value'     => $placesvalue,
                      'compare'   => 'LIKE',
                  );
              }                
              $query->set('meta_query',$meta_query);            
            } else {
              $query->set('meta_key', '_multilocation');
              $query->set('meta_value', 'null');             
            }

          }
        } elseif (in_array('location_shop_manager', $currentUserRoles) && empty($isShopManagerEnable)) {
          $query->set('meta_key', '_location');
          $query->set('meta_value', 'null');
        }
      }
      if (in_array('location_regional_manager', $currentUserRoles)) {
        if (in_array('location_regional_manager', $currentUserRoles) && $isShopManagerEnable == "on") {

          if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == 'shop_order') {

            $places = $this->getShopRegional_MangersLocation($current_user_id);                     
            if (!empty($places[0])) {
              $meta_query = array('relation' => 'OR');
              foreach ($places[0] as $placesvalue) {
                  $meta_query[] = array(
                      'key'       => '_multilocation',
                      'value'     => $placesvalue,
                      'compare'   => 'LIKE',
                  );
              }                
              $query->set('meta_query',$meta_query);
            } else {
              $query->set('meta_key', '_multilocation');
              $query->set('meta_value', 'null');           
            }

          }

        } elseif (in_array('location_regional_manager', $currentUserRoles) && empty($isShopManagerEnable)) {
          $query->set('meta_key', '_location');
          $query->set('meta_value', 'null');
        }
      }
      return $query;
    }
    function wcmlim_woocommerce_admin_html_order_item_class_filter( $class, $item, $order ){
      $current_store_manager = get_current_user_id();
      $current_user = wp_get_current_user();
			$roles = $current_user->roles;
      if ($roles[0] == 'location_shop_manager') {
      $ord__selectedLocTermId = $item->get_meta('_selectedLocTermId', true);
      $shop_manager = get_term_meta($ord__selectedLocTermId, 'wcmlim_shop_manager', true);
         if(is_array($shop_manager))
         {
          if(in_array($current_store_manager,$shop_manager))
          {
    
            $class = 'wcmlim_active_line-item';
          }
          else
          {
            $class = 'wcmlim_inactive_line-item';
          }
    
         }
         else
         {
           $class = 'wcmlim_inactive_line-item';
         }
      return $class;
     }
    }

    /**
     * Manager for view location wise order
     *
     * @since 3.0.0
     */

    public function wcmlim_order_restrict()
    { 
       /** Restrict Regional and Shop Manager to view another location order */     
       $cuser = wp_get_current_user();
       $cuserId = $cuser->ID;
       $cuserRoles = $cuser->roles; 
       if (in_array("location_shop_manager", $cuserRoles) || in_array("location_regional_manager", $cuserRoles))
       {
       if (isset($_GET['post']) ) {        
       $orderid = $_GET['post'];  
       $order_type = get_post_type( $orderid ); 
          if ( $order_type == "shop_order" ) {       
             $order = new WC_Order($orderid);      
             if ( $order && ! in_array("administrator", $cuserRoles) ) {         
                $url = admin_url('edit.php?post_type=shop_order');                     
                $order_data = $order->get_meta('_multilocation'); 
    
                /** On order view restrict */
                $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));      
                $loc_ID = array();
                foreach ($terms as $k => $term_data) {
                   $loc_name = $term_data->term_id;      
                   if($order_data) {
                      foreach ($order_data as $od_data) {             
                         if ( $od_data == $loc_name ) {                            
                            $loc_ID[] = $loc_name;
                         }
                      }
                   }
                }  
                $shopM_ID = array();
                $regM2_ID = array();
                if($loc_ID) {
                   foreach ($loc_ID as $l_id) {
                      $shopM =  get_term_meta($l_id, 'wcmlim_shop_manager', true);
                      if($shopM) {
                         foreach ($shopM as $shopM_arr) {
                            $shopM_ID[] = $shopM_arr;
                         }
                      }     	
                      $regM = get_term_meta($l_id, "wcmlim_locator", true);
                      $regM2 = get_term_meta($regM, "wcmlim_shop_regmanager", true);
                      if($regM2) {
                         foreach ($regM2 as $regM2_arr) {
                            $regM2_ID[] =  $regM2_arr;
                         }
                      }
                   }  
                }                      
                if (in_array("location_shop_manager", $cuserRoles)) {
                   if( in_array($cuserId, $shopM_ID)) {
                         
                      return; 
                   } else {            
                         wp_redirect($url); 
                   }
                } elseif (in_array("location_regional_manager", $cuserRoles)) {           
                   if( in_array($cuserId, $regM2_ID)) {     
                      return;                                 
                   } else {
                      wp_redirect($url); 
                   }
                } elseif (in_array("administrator", $cuserRoles)) {           
                   return; 
                }  else {              
                   wp_redirect($url); 
                }            
             }// if for singular order
          }
       } // Isset post      
    }
  }

    /**
     * Ajax callback function for 
     * update stock inline 
     *
     * @since  2.2.1
     */

    public function wcmlim_update_stock_inline()
    {
      $location_stock = $_POST['location_stock'];
      $product_id = $_POST['product_id'];
      $location_id = $_POST['location_id'];
      $product = wc_get_product( $product_id );
      update_post_meta($product_id, 'wcmlim_stock_at_'.$location_id, $location_stock);
      $total = 0;
      $locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false));
      foreach ($locations as $location) {
        $total +=  intval(get_post_meta($product_id, "wcmlim_stock_at_{$location->term_id}", true));
      }        
      if(intval($total) > 0)
        {
          update_post_meta($product_id, '_stock', $total);
        }
      
      if ($total > 0) {
        update_post_meta($product_id, '_stock_status', 'instock');
      } else {
        update_post_meta($product_id, '_stock_status', 'outofstock');
      }

     $termName = array();
     $removetermName = array();
     $locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
     $stock = '';
     foreach($locations as $key=>$term){
       
             $stock  = intval(get_post_meta($product_id, 'wcmlim_stock_at_'.$term->term_id));
                      if($term->term_id == $location_id){
                        $stock = intval($location_stock);
                    }
             if($stock == '' || $stock == 0){
              $removetermName[] = $term->slug;
             }else{
              $termName[] = $term->slug;
             }
      }
      
     wp_set_object_terms( $product_id, $termName, 'locations' );
     wp_remove_object_terms( $product_id, $removetermName, 'locations' );
    
      echo $location_stock;      
      wp_die();
    }
    public function wcmlim_default_hidden_meta_boxes( $hidden, $screen ) {
      // Grab the current post type
      $post_type = $screen->post_type;
      // If we're on a 'post'...
      if ( $post_type == 'product' ) {
          // Define which meta boxes we wish to hide
          $hidden = array(
              'price_at_locations',
          );
          // Pass our new defaults onto WordPress
          return $hidden;
      }
      // If we are not on a 'post', pass the
      // original defaults, as defined by WordPress
      return $hidden;
  }
    public function wcmlim_update_price_inline()
    {
      $regular_price = $_POST['regular_price'];
      $sale_price = $_POST['sale_price'];
      if($sale_price == 'NaN')
      {
        $sale_price = '';
      }
      $product_id = $_POST['product_id'];
      $location_id = $_POST['location_id'];
      update_post_meta($product_id, 'wcmlim_regular_price_at_'.$location_id, $regular_price);
      update_post_meta($product_id, 'wcmlim_sale_price_at_'.$location_id, $sale_price);
      
      echo $regular_price.'/'.$sale_price;     
      wp_die();
    }
    /**
     * Restricted location selection
     * dropdown
     *
     * @since  1.1.4
     */
    public function wcmlim_restrict_parent_location($args, $taxonomy)
    {
      if ('locations' != $taxonomy) return $args; // no change
      $args['depth'] = '1';
      $args['class'] = "locationsParent";
      return $args;
    }

    /**
     * callback function for Stock Information Border
     *
     * @since    1.1.5
     */
    public function wcmlim_preview_stock_border_cb()
    {
      $box_brstyle = get_option($this->option_name . '_preview_stock_borderoption');
      if ($box_brstyle  == false) {
        update_option($this->option_name . '_preview_stock_borderoption', 'solid');
      }
    ?>

      <p><strong><?php echo __('Border Style', 'wcmlim'); ?></strong></p>
      <select name="<?php esc_attr_e($this->option_name . '_preview_stock_borderoption') ?>" id="<?php esc_attr_e($this->option_name . '_preview_stock_borderoption') ?>">
        <option value="default">
          Select Border style
        </option>
        <option value="none" <?php if ($box_brstyle == 'none') {
                                echo "selected='selected'";
                              } ?>>
          None
        </option>
        <option value="solid" <?php if ($box_brstyle == 'solid') {
                                echo "selected='selected'";
                              } ?>>
          Solid
        </option>
        <option value="dotted" <?php if ($box_brstyle == 'dotted') {
                                  echo "selected='selected'";
                                } ?>>
          Dotted
        </option>
        <option value="double" <?php if ($box_brstyle == 'double') {
                                  echo "selected='selected'";
                                } ?>>
          Double
        </option>
        <option value="dashed" <?php if ($box_brstyle == 'dashed') {
                                  echo "selected='selected'";
                                } ?>>
          Dashed
        </option>
      </select>
      <p><?php echo __('Select border style', 'wcmlim'); ?></p>
      <br>
      <?php
      $box_border = get_option($this->option_name . '_preview_stock_border');
      if ($box_border  == false) {
        update_option($this->option_name . '_preview_stock_border', '1px');
      } ?>
      <p><strong><?php echo __('Border Width', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_preview_stock_border'); ?>" id="<?php esc_attr_e($this->option_name . '_preview_stock_border'); ?>" value="<?php esc_attr_e($box_border); ?>">
      <br>
      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p><br>
      <?php
      $box_brcolor = get_option($this->option_name . '_preview_stock_bordercolor');
      if ($box_brcolor  == false) {
        update_option($this->option_name . '_preview_stock_bordercolor', '#cfcfcf');
      }
      ?>
      <p><strong><?php echo __('Border Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_preview_stock_bordercolor'); ?>" name="<?php esc_attr_e($this->option_name . '_preview_stock_bordercolor'); ?>" value="<?php esc_attr_e($box_brcolor); ?>" />
      <p><?php esc_attr__('Hex color for Border Color', 'wcmlim'); ?></p>
      <br>
      <?php
      $box_bradius = get_option($this->option_name . '_preview_stock_borderradius');
      if ($box_bradius  == false) {
        update_option($this->option_name . '_preview_stock_borderradius', '0px');
      }
      ?>
      <p><strong><?php echo __('Border Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_preview_stock_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_preview_stock_borderradius'); ?>" value="<?php esc_attr_e($box_bradius); ?>">

      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p>
      <hr>
    <?php
    }
    /**
     * callback function for Stock Information Background Color
     *
     * @since    1.1.5
     */
    public function wcmlim_preview_stock_bgcolor_cb()
    {
      $box_bgcolor = get_option($this->option_name . '_preview_stock_bgcolor');
      $box_width = get_option($this->option_name . '_preview_stock_width');
    ?>
      <p><strong><?php echo __('Box Width', 'wcmlim'); ?></strong></p>
      <input id="<?php esc_attr_e($this->option_name . '_preview_stock_width'); ?>" type="number" style="width: 20%;" name="<?php esc_attr_e($this->option_name . '_preview_stock_width'); ?>" value="<?php esc_attr_e($box_width); ?>" />
      <p><?php echo __('Multilocation grid box width in percentage(%)', 'wcmlim'); ?></p>
      <br>
      <p><strong><?php echo __('Background Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_preview_stock_bgcolor'); ?>" name="<?php esc_attr_e($this->option_name . '_preview_stock_bgcolor'); ?>" value="<?php esc_attr_e($box_bgcolor); ?>" />
      <br>
      <p><?php echo __('Hex color for Multilocation grid box', 'wcmlim'); ?></p>
      <hr>
    <?php
    }
    /**
     * callback function for Stock Information text options.
     *
     * @since    1.1.5
     */

    public function wcmlim_txt_stock_info_cb()
    {
      $h1_text = get_option($this->option_name . '_txt_stock_info');
      if ($h1_text  == false) {
        update_option($this->option_name . '_txt_stock_info', 'Stock Information');
      }
      $checked = get_option($this->option_name . '_display_stock_info');
    ?>
      <p><strong><?php echo __('To Hide Title', 'wcmlim'); ?></strong></p>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_display_stock_info') ?>" name="<?php esc_attr_e($this->option_name . '_display_stock_info') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <p><?php echo __('Remove header section', 'wcmlim'); ?></p><br>
      <p><strong><?php echo __('Title', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_txt_stock_info'); ?>" id="<?php esc_attr_e($this->option_name . '_txt_stock_info'); ?>" value="<?php esc_attr_e($h1_text); ?>">
      <p><?php echo __('text to appear on header stock box', 'wcmlim'); ?></p><br>
      <?php
      $h1_textcolor = get_option($this->option_name . '_txtcolor_stock_info');
      if ($h1_textcolor  == false) {
        update_option($this->option_name . '_txtcolor_stock_info', '#000000');
      }
      ?>
      <p><strong><?php echo __('Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_txtcolor_stock_info'); ?>" name="<?php esc_attr_e($this->option_name . '_txtcolor_stock_info'); ?>" value="<?php esc_attr_e($h1_textcolor); ?>" />
      <p><?php echo __('Hex color for header text color', 'wcmlim'); ?></p><br>
      <hr>
    <?php
    }

    /**
     * callback function for Preferred Location text.
     *
     * @since    1.1.5
     */

    public function wcmlim_txt_preferred_location_cb()
    {
      $h2_text = get_option($this->option_name . '_txt_preferred_location');
      if ($h2_text  == false) {
        update_option($this->option_name . '_txt_preferred_location', 'Location: ');
      }
      $checked = get_option($this->option_name . '_display_preferred_loc'); ?>
      <p><strong><?php echo __('To Hide Label', 'wcmlim'); ?></strong></p>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_display_preferred_loc') ?>" name="<?php esc_attr_e($this->option_name . '_display_preferred_loc') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <p><?php echo __('Remove select Label', 'wcmlim'); ?></p> <br>
      <p><strong><?php echo __('Label', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_txt_preferred_location'); ?>" id="<?php esc_attr_e($this->option_name . '_txt_preferred_location'); ?>" value="<?php esc_attr_e($h2_text); ?>">
      <p><?php echo __('label text for select option list', 'wcmlim'); ?></p> <br>

      <?php
      $pref_textcolor = get_option($this->option_name . '_txtcolor_preferred_loc');
      if ($pref_textcolor  == false) {
        update_option($this->option_name . '_txtcolor_preferred_loc', '#000000');
      }
      ?><p><strong><?php echo __('Label Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_txtcolor_preferred_loc'); ?>" name="<?php esc_attr_e($this->option_name . '_txtcolor_preferred_loc'); ?>" value="<?php esc_attr_e($pref_textcolor); ?>" />
      <p><?php echo __('Hex color for select label text color', 'wcmlim'); ?></p> <br>

      <p><strong><?php echo __('Padding for Select Box', 'wcmlim'); ?></strong></p>
      <?php
      $sbox_padtop = get_option($this->option_name . '_sbox_padding_top');
      $sbox_padright = get_option($this->option_name . '_sbox_padding_right');
      $sbox_padbottom = get_option($this->option_name . '_sbox_padding_bottom');
      $sbox_padleft = get_option($this->option_name . '_sbox_padding_left');
      ?>
      <div class="wclim_input_wrapper">
        <ul class="wclim_dimensions">
          <li class="wclim_dimension">
            <input id="wclim_top" type="number" data-setting="top" id="<?php esc_attr_e($this->option_name . '_sbox_padding_top'); ?>" name="<?php esc_attr_e($this->option_name . '_sbox_padding_top'); ?>" value="<?php esc_attr_e($sbox_padtop); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sbox_padding_top'); ?>">Top</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_right" type="number" data-setting="right" id="<?php esc_attr_e($this->option_name . '_sbox_padding_right'); ?>" name="<?php esc_attr_e($this->option_name . '_sbox_padding_right'); ?>" value="<?php esc_attr_e($sbox_padright); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sbox_padding_right'); ?>">Right</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_bottom" type="number" data-setting="bottom" id="<?php esc_attr_e($this->option_name . '_sbox_padding_bottom'); ?>" name="<?php esc_attr_e($this->option_name . '_sbox_padding_bottom'); ?>" value="<?php esc_attr_e($sbox_padbottom); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sbox_padding_bottom'); ?>">Bottom</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_left" type="number" data-setting="left" id="<?php esc_attr_e($this->option_name . '_sbox_padding_left'); ?>" name="<?php esc_attr_e($this->option_name . '_sbox_padding_left'); ?>" value="<?php esc_attr_e($sbox_padleft); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sbox_padding_left'); ?>">Left</label>
          </li>
        </ul>
      </div>
      <p><?php echo __('Set height and width for select box, Enter digit support px', 'wcmlim'); ?></p> <br>



      <?php
      $selbg_color = get_option($this->option_name . '_selbox_bgcolor');
      if ($selbg_color  == false) {
        update_option($this->option_name . '_selbox_bgcolor', '#ffffff');
      }
      ?><p><strong><?php echo __('Background Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_selbox_bgcolor'); ?>" name="<?php esc_attr_e($this->option_name . '_selbox_bgcolor'); ?>" value="<?php esc_attr_e($selbg_color); ?>" />
      <p><?php echo __('Set background color for selct box, Hex color for select title text color.', 'wcmlim'); ?></p> <br>
      <?php
      $ref_radius = get_option($this->option_name . '_refbox_borderradius');
      if ($ref_radius  == false) {
        update_option($this->option_name . '_refbox_borderradius', '4px');
      }
      ?>
      <p><strong><?php echo __('Border Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_refbox_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_refbox_borderradius'); ?>" value="<?php esc_attr_e($ref_radius); ?>">

      <p><?php echo __('Set border radius for selct box, Enter digit with px,em. i.e 3px or 6em.', 'wcmlim'); ?></p> <br>

      <?php /**Icon Options */
      $iconshow = get_option($this->option_name . '_display_icon'); ?>
      <p><strong><?php echo __('To Hide Location Icon', 'wcmlim'); ?></strong></p>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_display_icon') ?>" name="<?php esc_attr_e($this->option_name . '_display_icon') ?>" <?php echo ($iconshow == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <p><?php echo __('Remove location icon', 'wcmlim'); ?></p> <br>

      <?php $icon_color = get_option($this->option_name . '_iconcolor_loc');
      if ($icon_color  == false) {
        update_option($this->option_name . '_iconcolor_loc', '#ff7a00');
      }
      ?><p><strong><?php echo __('Icon Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_iconcolor_loc'); ?>" name="<?php esc_attr_e($this->option_name . '_iconcolor_loc'); ?>" value="<?php esc_attr_e($icon_color); ?>" />
      <p><?php echo __('Hex color for location icon', 'wcmlim'); ?></p> <br>
      <?php $icon_size = get_option($this->option_name . '_iconsize_loc'); ?>
      <p><strong><?php echo __('Icon Size', 'wcmlim'); ?></strong></p>
      <input type="number" style="width: 20%;" id="<?php esc_attr_e($this->option_name . '_iconsize_loc'); ?>" name="<?php esc_attr_e($this->option_name . '_iconsize_loc'); ?>" value="<?php esc_attr_e($icon_size); ?>" />
      <p><?php echo __('location icon size in px', 'wcmlim'); ?></p><br>

      <p><strong><?php echo __('Dropdown Padding(select field)', 'wcmlim'); ?></strong></p>
      <?php
      $sel_padtop = get_option($this->option_name . '_sel_padding_top');
      $sel_padright = get_option($this->option_name . '_sel_padding_right');
      $sel_padbottom = get_option($this->option_name . '_sel_padding_bottom');
      $sel_padleft = get_option($this->option_name . '_sel_padding_left');
      ?>
      <div class="wclim_input_wrapper">
        <ul class="wclim_dimensions">
          <li class="wclim_dimension">
            <input id="wclim_top" type="number" data-setting="top" id="<?php esc_attr_e($this->option_name . '_sel_padding_top'); ?>" name="<?php esc_attr_e($this->option_name . '_sel_padding_top'); ?>" value="<?php esc_attr_e($sel_padtop); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sel_padding_top'); ?>">Top</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_right" type="number" data-setting="right" id="<?php esc_attr_e($this->option_name . '_sel_padding_right'); ?>" name="<?php esc_attr_e($this->option_name . '_sel_padding_right'); ?>" value="<?php esc_attr_e($sel_padright); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sel_padding_right'); ?>">Right</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_bottom" type="number" data-setting="bottom" id="<?php esc_attr_e($this->option_name . '_sel_padding_bottom'); ?>" name="<?php esc_attr_e($this->option_name . '_sel_padding_bottom'); ?>" value="<?php esc_attr_e($sel_padbottom); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sel_padding_bottom'); ?>">Bottom</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_left" type="number" data-setting="left" id="<?php esc_attr_e($this->option_name . '_sel_padding_left'); ?>" name="<?php esc_attr_e($this->option_name . '_sel_padding_left'); ?>" value="<?php esc_attr_e($sel_padleft); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_sel_padding_left'); ?>">Left</label>
          </li>
        </ul>
      </div>
      <p><?php echo __('Enter digit support px', 'wcmlim'); ?></p> <br>

      <hr>
    <?php
    }

    /**
     * callback function for nearest stock location text options.
     *
     * @since    1.1.5
     */
    public function wcmlim_txt_nearest_stock_loc_cb()
    {
      $h3_text = get_option($this->option_name . '_txt_nearest_stock_loc');
      if ($h3_text  == false) {
        update_option($this->option_name . '_txt_nearest_stock_loc', 'Check your nearest stock location :');
      }
      $checked = get_option($this->option_name . '_display_nearest_stock'); ?>
      <p><strong><?php echo __('To Hide label', 'wcmlim'); ?></strong></p>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_display_nearest_stock') ?>" name="<?php esc_attr_e($this->option_name . '_display_nearest_stock') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <p><?php echo __('Remove label text for output box', 'wcmlim'); ?></p><br>
      <p><strong><?php echo __('Label', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_txt_nearest_stock_loc'); ?>" id="<?php esc_attr_e($this->option_name . '_txt_nearest_stock_loc'); ?>" value="<?php esc_attr_e($h3_text); ?>">
      <p><?php echo __('Label for output box', 'wcmlim'); ?></p><br>
      <?php
      $h3_textcolor = get_option($this->option_name . '_txtcolor_nearest_stock');
      if ($h3_textcolor  == false) {
        update_option($this->option_name . '_txtcolor_nearest_stock', '#000000');
      }
      ?><p><strong><?php echo __('Label Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_txtcolor_nearest_stock'); ?>" name="<?php esc_attr_e($this->option_name . '_txtcolor_nearest_stock'); ?>" value="<?php esc_attr_e($h3_textcolor); ?>" />
      <p><?php echo __('Hex color for output box Label color', 'wcmlim'); ?></p><br>
      <hr>
    <?php
    }

    /**
     * callback function for nearest stock location text color && Display Title or not. 
     * @since    1.1.5
     */
    public function wcmlim_separator_linecolor_cb()
    {
      $sep_color = get_option($this->option_name . '_separator_linecolor');
      if ($sep_color  == false) {
        update_option($this->option_name . '_separator_linecolor', '#cfcfcf');
      }
      $checked = get_option($this->option_name . '_display_separator_line'); ?>
      <p><strong><?php echo __('To Hide Line', 'wcmlim'); ?></strong></p>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_display_separator_line') ?>" name="<?php esc_attr_e($this->option_name . '_display_separator_line') ?>" <?php echo ($checked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <p><?php echo __('Remove Separtor Line', 'wcmlim'); ?></p><br>
      <p><strong><?php echo __('Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_separator_linecolor'); ?>" name="<?php esc_attr_e($this->option_name . '_separator_linecolor'); ?>" value="<?php esc_attr_e($sep_color); ?>" />

      <p><?php echo __('Hex color for separator line', 'wcmlim'); ?></p> <br>

      <hr>
    <?php
    }

    /**
     * callback function for oncheck button text options.
     *
     * @since    1.1.5
     */

    public function wcmlim_oncheck_button_text_cb()
    {
      $button_text = get_option($this->option_name . '_oncheck_button_text');
      if ($button_text  == false) {
        update_option($this->option_name . '_oncheck_button_text', 'Check');
      }
    ?><p><strong><?php echo __('Button Text', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_oncheck_button_text'); ?>" id="<?php esc_attr_e($this->option_name . '_oncheck_button_text'); ?>" value="<?php esc_attr_e($button_text); ?>">
      <p><?php echo __('enter text for button', 'wcmlim'); ?></p><br>
      <?php
      $button_color = get_option($this->option_name . '_oncheck_button_color');
      /*if ($button_color  == false) {
        update_option($this->option_name . '_oncheck_button_color', '#cfcfcf');
      }*/
      ?><p><strong><?php echo __('Button Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_oncheck_button_color'); ?>" name="<?php esc_attr_e($this->option_name . '_oncheck_button_color'); ?>" value="<?php esc_attr_e($button_color); ?>" />
      <p><?php echo __('Hex color for button Background color', 'wcmlim'); ?></p><br>
      <?php
      $button_txt_color = get_option($this->option_name . '_oncheck_button_text_color');
      ?><p><strong><?php echo __('Text Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_oncheck_button_text_color'); ?>" name="<?php esc_attr_e($this->option_name . '_oncheck_button_text_color'); ?>" value="<?php esc_attr_e($button_txt_color); ?>" />
      <p><?php echo __('Hex color for check button text color', 'wcmlim'); ?></p>
      <br>
      <?php
      $input_radius = get_option($this->option_name . '_input_borderradius');
      if ($input_radius  == false) {
        update_option($this->option_name . '_input_borderradius', '0px');
      }
      ?>
      <p><strong><?php echo __('Input Border Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_input_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_input_borderradius'); ?>" value="<?php esc_attr_e($input_radius); ?>">
      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p><br>
      <?php
      $check_radius = get_option($this->option_name . '_oncheck_borderradius');
      if ($check_radius  == false) {
        update_option($this->option_name . '_oncheck_borderradius', '0px');
      }
      ?>
      <p><strong><?php echo __('Button Border Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_oncheck_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_oncheck_borderradius'); ?>" value="<?php esc_attr_e($check_radius); ?>">
      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p><br>
      <p><strong><?php echo __('Input field padding', 'wcmlim'); ?></strong></p>
      <?php
      $inp_padtop = get_option($this->option_name . '_inp_padding_top');
      $inp_padright = get_option($this->option_name . '_inp_padding_right');
      $inp_padbottom = get_option($this->option_name . '_inp_padding_bottom');
      $inp_padleft = get_option($this->option_name . '_inp_padding_left');
      ?>
      <div class="wclim_input_wrapper">
        <ul class="wclim_dimensions">
          <li class="wclim_dimension">
            <input id="wclim_top" type="number" data-setting="top" id="<?php esc_attr_e($this->option_name . '_inp_padding_top'); ?>" name="<?php esc_attr_e($this->option_name . '_inp_padding_top'); ?>" value="<?php esc_attr_e($inp_padtop); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_inp_padding_top'); ?>">Top</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_right" type="number" data-setting="right" id="<?php esc_attr_e($this->option_name . '_inp_padding_right'); ?>" name="<?php esc_attr_e($this->option_name . '_inp_padding_right'); ?>" value="<?php esc_attr_e($inp_padright); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_inp_padding_right'); ?>">Right</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_bottom" type="number" data-setting="bottom" id="<?php esc_attr_e($this->option_name . '_inp_padding_bottom'); ?>" name="<?php esc_attr_e($this->option_name . '_inp_padding_bottom'); ?>" value="<?php esc_attr_e($inp_padbottom); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_inp_padding_bottom'); ?>">Bottom</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_left" type="number" data-setting="left" id="<?php esc_attr_e($this->option_name . '_inp_padding_left'); ?>" name="<?php esc_attr_e($this->option_name . '_inp_padding_left'); ?>" value="<?php esc_attr_e($inp_padleft); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_inp_padding_left'); ?>">Left</label>
          </li>
        </ul>
      </div>
      <p><?php echo __('Enter digit support px', 'wcmlim'); ?></p> <br>
      <p><strong><?php echo __('Button padding', 'wcmlim'); ?></strong></p>
      <?php
      $btn_padtop = get_option($this->option_name . '_btn_padding_top');
      $btn_padright = get_option($this->option_name . '_btn_padding_right');
      $btn_padbottom = get_option($this->option_name . '_btn_padding_bottom');
      $btn_padleft = get_option($this->option_name . '_btn_padding_left');
      ?>
      <div class="wclim_input_wrapper">
        <ul class="wclim_dimensions">
          <li class="wclim_dimension">
            <input id="wclim_top" type="number" data-setting="top" id="<?php esc_attr_e($this->option_name . '_btn_padding_top'); ?>" name="<?php esc_attr_e($this->option_name . '_btn_padding_top'); ?>" value="<?php esc_attr_e($btn_padtop); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_btn_padding_top'); ?>">Top</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_right" type="number" data-setting="right" id="<?php esc_attr_e($this->option_name . '_btn_padding_right'); ?>" name="<?php esc_attr_e($this->option_name . '_btn_padding_right'); ?>" value="<?php esc_attr_e($btn_padright); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_btn_padding_right'); ?>">Right</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_bottom" type="number" data-setting="bottom" id="<?php esc_attr_e($this->option_name . '_btn_padding_bottom'); ?>" name="<?php esc_attr_e($this->option_name . '_btn_padding_bottom'); ?>" value="<?php esc_attr_e($btn_padbottom); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_btn_padding_bottom'); ?>">Bottom</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_left" type="number" data-setting="left" id="<?php esc_attr_e($this->option_name . '_btn_padding_left'); ?>" name="<?php esc_attr_e($this->option_name . '_btn_padding_left'); ?>" value="<?php esc_attr_e($btn_padleft); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_btn_padding_left'); ?>">Left</label>
          </li>
        </ul>
      </div>
      <p><?php echo __('Enter digit support px', 'wcmlim'); ?></p> <br>
      <hr>
    <?php
    }
    /**
     * callback function for SoldOut button text options.
     *
     * @since    1.1.5
     */

    public function wcmlim_soldout_button_text_cb()
    {
      $soldoutbutton_text = get_option($this->option_name . '_soldout_button_text');
      if ($soldoutbutton_text  == false) {
        update_option($this->option_name . '_soldout_button_text', 'Sold Out');
      }
    ?><p><strong><?php echo __('Label', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_soldout_button_text'); ?>" id="<?php esc_attr_e($this->option_name . '_soldout_button_text'); ?>" value="<?php esc_attr_e($soldoutbutton_text); ?>">
      <p><?php echo __('SoldOut button text to appear', 'wcmlim'); ?></p><br>
      <?php
      $button_color = get_option($this->option_name . '_soldout_button_color');
      if ($button_color  == false) {
        update_option($this->option_name . '_soldout_button_color', '#dc3545');
      }
      ?><p><strong><?php echo __('Background Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_soldout_button_color'); ?>" name="<?php esc_attr_e($this->option_name . '_soldout_button_color'); ?>" value="<?php esc_attr_e($button_color); ?>" />
      <p><?php echo __('Hex color for SoldOut button color', 'wcmlim'); ?></p><br>
      <?php
      $button_txt_color = get_option($this->option_name . '_soldout_button_text_color');
      if ($button_txt_color == null) {
        update_option($this->option_name . '_soldout_button_text_color', '#ffffff');
      }
      ?><p><strong><?php echo __('Text Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_soldout_button_text_color'); ?>" name="<?php esc_attr_e($this->option_name . '_soldout_button_text_color'); ?>" value="<?php esc_attr_e($button_txt_color); ?>" />
      <p><?php echo __('Hex color for SoldOut button text color', 'wcmlim'); ?></p>
      <br>
      <?php
      $sold_radius = get_option($this->option_name . '_soldout_borderradius');
      if ($sold_radius  == false) {
        update_option($this->option_name . '_soldout_borderradius', '0px');
      }
      ?>
      <p><strong><?php echo __('Button Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_soldout_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_soldout_borderradius'); ?>" value="<?php esc_attr_e($sold_radius); ?>">
      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p>
      <hr>
    <?php
    }

    /**
     * callback function for InStock button text options.
     *
     * @since    1.1.5
     */

    public function wcmlim_instock_button_text_cb()
    {
      $stockbutton_text = get_option($this->option_name . '_instock_button_text');
      if ($stockbutton_text  == false) {
        update_option($this->option_name . '_instock_button_text', 'In Stock');
      }
    ?><p><strong><?php echo __('Label', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_instock_button_text'); ?>" id="<?php esc_attr_e($this->option_name . '_instock_button_text'); ?>" value="<?php esc_attr_e($stockbutton_text); ?>">
      <p><?php echo __('InStock button text to appear', 'wcmlim'); ?></p><br>
      <?php
      $button_color = get_option($this->option_name . '_instock_button_color');
      if ($button_color  == false) {
        update_option($this->option_name . '_instock_button_color', '#28a745');
      }
      ?><p><strong><?php echo __('Background Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_instock_button_color'); ?>" name="<?php esc_attr_e($this->option_name . '_instock_button_color'); ?>" value="<?php esc_attr_e($button_color); ?>" />
      <p><?php echo __('Hex color for InStock button color', 'wcmlim'); ?></p><br>
      <?php
      $button_txt_color = get_option($this->option_name . '_instock_button_text_color');
      if ($button_txt_color  == false) {
        update_option($this->option_name . '_instock_button_text_color', '#ffffff');
      }
      ?><p><strong><?php echo __('Text Color', 'wcmlim'); ?></strong></p>
      <input class="color_field" type="text" id="<?php esc_attr_e($this->option_name . '_instock_button_text_color'); ?>" name="<?php esc_attr_e($this->option_name . '_instock_button_text_color'); ?>" value="<?php esc_attr_e($button_txt_color); ?>" />
      <p><?php echo __('Hex color for InStock button text color', 'wcmlim'); ?></p>
      <br>
      <?php
      $stock_radius = get_option($this->option_name . '_instock_borderradius');
      if ($stock_radius  == false) {
        update_option($this->option_name . '_instock_borderradius', '0px');
      }
      ?>
      <p><strong><?php echo __('Button Radius', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_instock_borderradius'); ?>" id="<?php esc_attr_e($this->option_name . '_instock_borderradius'); ?>" value="<?php esc_attr_e($stock_radius); ?>">
      <p><?php echo __('Enter digit with px,em. i.e 3px or 6em', 'wcmlim'); ?></p>
      <hr>
      <br>
      <p><strong><?php echo __('Set height & width for In-Stock and Sold-Out Box', 'wcmlim'); ?></strong></p>
      <?php
      $is_padtop = get_option($this->option_name . '_is_padding_top');
      $is_padright = get_option($this->option_name . '_is_padding_right');
      $is_padbottom = get_option($this->option_name . '_is_padding_bottom');
      $is_padleft = get_option($this->option_name . '_is_padding_left');
      ?>
      <div class="wclim_input_wrapper">
        <ul class="wclim_dimensions">
          <li class="wclim_dimension">
            <input id="wclim_top" type="number" data-setting="top" id="<?php esc_attr_e($this->option_name . '_is_padding_top'); ?>" name="<?php esc_attr_e($this->option_name . '_is_padding_top'); ?>" value="<?php esc_attr_e($is_padtop); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_is_padding_top'); ?>">Top</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_right" type="number" data-setting="right" id="<?php esc_attr_e($this->option_name . '_is_padding_right'); ?>" name="<?php esc_attr_e($this->option_name . '_is_padding_right'); ?>" value="<?php esc_attr_e($is_padright); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_is_padding_right'); ?>">Right</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_bottom" type="number" data-setting="bottom" id="<?php esc_attr_e($this->option_name . '_is_padding_bottom'); ?>" name="<?php esc_attr_e($this->option_name . '_is_padding_bottom'); ?>" value="<?php esc_attr_e($is_padbottom); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_is_padding_bottom'); ?>">Bottom</label>
          </li>
          <li class="wclim_dimension">
            <input id="wclim_left" type="number" data-setting="left" id="<?php esc_attr_e($this->option_name . '_is_padding_left'); ?>" name="<?php esc_attr_e($this->option_name . '_is_padding_left'); ?>" value="<?php esc_attr_e($is_padleft); ?>" />
            <label for="<?php esc_attr_e($this->option_name . '_is_padding_left'); ?>">Left</label>
          </li>
        </ul>
      </div>
      <p><?php echo __('Enter digit support px', 'wcmlim'); ?></p> <br>
      <hr>
  <?php
    }

    public function wcmlim_onbackorder_button_text_cb(){

      $backorder_text = get_option($this->option_name . '_onbackorder_button_text');
      if ($backorder_text  == false) {
        update_option($this->option_name . '_onbackorder_button_text', 'On backorder');
      }
    ?><p><strong><?php echo __('Label', 'wcmlim'); ?></strong></p>
      <input type="text" name="<?php esc_attr_e($this->option_name . '_onbackorder_button_text'); ?>" id="<?php esc_attr_e($this->option_name . '_onbackorder_button_text'); ?>" value="<?php esc_attr_e($backorder_text); ?>">
      <p><?php echo __('On backorder button text to appear', 'wcmlim'); ?></p><br>
<?php
    }

    /**
     * Ajax callback function for showing parent attributes to sub locations
     *
     * @since  1.2.2
     */

    public function wcmlim_show_parent_paremeter()
    {
      $term_id = $_POST['loc_id'];
      $parent_start_time = get_term_meta($term_id, 'wcmlim_start_time', true);
      (isset($parent_start_time)) ? $parent_start_time : $parent_start_time = '';
      $parent_end_time = get_term_meta($term_id, 'wcmlim_end_time', true);
      (isset($parent_end_time)) ? $parent_end_time : $parent_end_time = '';
      $parent_wcmlim_phone = get_term_meta($term_id, 'wcmlim_phone', true);
      (isset($parent_wcmlim_phone)) ? $parent_wcmlim_phone : $parent_wcmlim_phone = '';
      $parent_time = array(
        'start' => $parent_start_time,
        'end' => $parent_end_time,
        'phone' => $parent_wcmlim_phone,
      );
      echo json_encode($parent_time);
      wp_die();
    }

    /**
     * Register the widget
     *
     * @since    1.1.6
     */
    public function wcmlim_register_wcmlim_widget()
    {
      register_widget('WCMLIM_Widget');
    }

    /**
     * Register the settings for plugin.
     *
     * @since    1.0.0
     */

    public function wcmlim_wpml_init()
    {
      load_plugin_textdomain($this->plugin_name, false, basename(dirname(__FILE__)) . '/languages');
    }

  /**
   * OpenPOS Comaptibility - Reduces Stock Levels from Locations  
   *
   * @since    1.2.3
   */

  public function wcmlim_pos_stock_levels_reduction($order_id)
  {
    if (!$order_id) {
      return;
    }
    $order = new WC_Order($order_id);
    $wcmlim_pos_compatiblity1 = get_option('wcmlim_pos_compatiblity');
    if ($wcmlim_pos_compatiblity1 == "on" && in_array('woocommerce-openpos/woocommerce-openpos.php', apply_filters('active_plugins', get_option('active_plugins')))) {
      $pos_order_warehouse = get_post_meta($order_id, "_pos_order_warehouse", true);
      if( $pos_order_warehouse == '' || $pos_order_warehouse == 0 ) {
        return;
      }
      $op_order = get_post_meta($order_id, "_op_order", true);
      $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
      foreach ($terms as $term) {
        $wcmlim_pos_id =  get_term_meta($term->term_id, 'wcmlim_pos_compatiblity', true);
       
        if ( $pos_order_warehouse == $wcmlim_pos_id) {
          foreach ($op_order['items'] as  $item_key => $item_values) {
            $parentTerms =   get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => $term->term_id));
            $product = wc_get_product($item_values['product_id']);
            if (!empty($parentTerms)) {
              foreach ($parentTerms as $parentTerm) {
                $stockInParentLocation[$parentTerm->term_id] = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentTerm->term_id}", true);
              }
              $parentValue = max($stockInParentLocation);
              $parentKey = array_search($parentValue, $stockInParentLocation);
              if ($parentKey) {
                $maxStockAtSub = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentKey}", true);
                $subStock = ((int) $maxStockAtSub - (int) $item_values['qty']);            
                update_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentKey}", $subStock);
                $product->save();
              }
            }
            $location_stock = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$term->term_id}", true);
            $main_old_stock = get_post_meta($item_values['product_id'], "_stock", true);
            $location_pos_stock = $location_stock - $item_values['qty'];
            update_post_meta($item_values['product_id'], "wcmlim_stock_at_{$term->term_id}", $location_pos_stock);
            $main_new_stock = $main_old_stock - $item_values['qty'];
            update_post_meta($item_values['product_id'], "_stock", $main_new_stock);
            $product->save();
          }
        }
       
      }
    }
  }
  public function wcmlim_increase_stock_levels_order_status_failed_refunded($order_id, $old_status, $new_status)
  {
    if ($new_status == 'failed' || $new_status == 'refunded')
    {
      $order = new WC_Order($order_id);

      if (!get_option('woocommerce_manage_stock') == 'yes' && !sizeof($order->get_items()) > 0) {
        return;
      }

      if (!empty($order)) 
      {
        foreach ($order->get_items() as  $item ) 
        {
          $product = $item->get_product();
          $item_stock_reduced = $item->get_meta('_reduced_stock', true);

          $item_selectedLocation_key = $item->get_meta('_selectedLocationKey', true);
          $itemSelLocTermId = $item->get_meta('_selectedLocTermId', true);
          $itemSelLocName = $item->get_meta('Location', true);
          $selLocQty = get_post_meta($product->get_id(), "wcmlim_stock_at_{$itemSelLocTermId}", true);
          $newStock = 0;
          if (!$item_stock_reduced || !$product || !$product->managing_stock()) {
            continue;
          }

          $item_name = $product->get_formatted_name();
          $product_id =  !empty($item->get_variation_id()) ? $item->get_variation_id() : $item->get_product_id();

          if($item_stock_reduced > 0 )
          {
            $newStock = intval($selLocQty) + intval($item_stock_reduced);
          }

          update_post_meta($product_id, "wcmlim_stock_at_{$itemSelLocTermId}", $newStock);
          $product->save();

          $item->delete_meta_data('_reduced_stock');
          $item->save();

          $locChanges[] = "{ Stock levels increased: {$item_name} from Location: {$itemSelLocName}  {$selLocQty} &rarr; {$newStock} }";

        }
        if ($locChanges) {        
          $order->add_order_note(implode(', ', $locChanges));       
        }
      }
    }
  }
 
  /**
   * OpenPOS Comaptibility - Restores/Adds Stock Levels from Locations  
   *
   * @since    1.2.3
   */

  public function wcmlim_pos_restore_order_stock($order_id)
  {
    $order = new WC_Order($order_id);

    if (!get_option('woocommerce_manage_stock') == 'yes' && !sizeof($order->get_items()) > 0) {
      return;
    }
    $op_order = get_post_meta($order_id, "_op_order", true);
    $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
    $pos_order_warehouse = get_post_meta($order_id, "_pos_order_warehouse", true);
    foreach ($terms as $term) {

      $wcmlim_pos_id =  get_term_meta($term->term_id, 'wcmlim_pos_compatiblity', true);
      if ($pos_order_warehouse == $wcmlim_pos_id) {
        if (!empty($op_order)) {
          foreach ($op_order['items'] as  $item_key => $item_values) {
            $parentTerms =   get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => $term->term_id));
            if (!empty($parentTerms)) {
              foreach ($parentTerms as $parentTerm) {
                $stockInParentLocation[$parentTerm->term_id] = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentTerm->term_id}", true);
              }
              $parentValue = max($stockInParentLocation);
              $parentKey = array_search($parentValue, $stockInParentLocation);
              if ($parentKey) {
                $maxStockAtSub = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentKey}", true);
                $subStock = ((int) $maxStockAtSub + (int) $item_values['qty']);
                update_post_meta($item_values['product_id'], "wcmlim_stock_at_{$parentKey}", $subStock);
              }
            }
            $location_stock = get_post_meta($item_values['product_id'], "wcmlim_stock_at_{$term->term_id}", true);
            $main_old_stock = get_post_meta($item_values['product_id'], "_stock", true);
            $location_pos_stock = $location_stock + $item_values['qty'];
            update_post_meta($item_values['product_id'], "wcmlim_stock_at_{$term->term_id}", $location_pos_stock);
            $main_new_stock = $main_old_stock + $item_values['qty'];
            update_post_meta($item_values['product_id'], "_stock", $main_new_stock);
          }
        }
      }
    }
  }
    /**
     * Ajax callback function for validating google distance api matrix
     *
     * @since  1.2.4
     */

    public function wcmlim_distance_matrix_validate_api()
    {
      global $wpdb;
      $google_api_key = $_POST['api'];
      $origins = WC()->countries->get_base_state() . WC()->countries->get_base_city() . WC()->countries->get_base_postcode();
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins=" . $origins . "&destinations=" . $origins . "&key=" . $google_api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
      ));
      $response = curl_exec($curl);
      $response_arr = json_decode($response);
      curl_close($curl);
      $validate_status = 'valid';
      if (isset($response_arr) && !empty($response_arr)) {
        if (isset($response_arr->error_message)) {
          $validate_status = $response_arr->error_message;
        }
      }
      if(isset($response_arr) && $response_arr == "You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started")
        {
          $validate_status = $response_arr;
        }
      echo $validate_status;
      die();
    }
    /**
     * Ajax callback function for validating google Geocode service
     *
     * @since  1.2.4
     */

    public function wcmlim_geocode_validate_api()
    {
      global $wpdb;
      $google_api_key = $_POST['api'];
      $origins = WC()->countries->get_base_state() . WC()->countries->get_base_city() . WC()->countries->get_base_postcode();
      $address = str_replace(' ', '+', $origins);
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $google_api_key,
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
      $geocode_validate_status = 'valid';
      if (isset($output) && !empty($output)) {
        if (isset($output->error_message)) {
          $geocode_validate_status = $output->error_message;
        }
      }
      if(isset($output) && $output == "You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started")
      {
        $geocode_validate_status = $output;
      }      
      echo $geocode_validate_status;
      die();
    }
    /**
     * Ajax callback function for validating google Geocode service
     *
     * @since  1.2.4
     */

    public function wcmlim_place_validate_api()
    {
      global $wpdb;
      $google_api_key = $_POST['api'];
      $origins = WC()->countries->get_base_state() . WC()->countries->get_base_city() . WC()->countries->get_base_postcode();
      $address = str_replace(' ', '+', $origins);
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=' . urlencode($address) . '&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=' . $google_api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
      ));
      $placeapi = curl_exec($curl);
      $output = json_decode($placeapi);
      curl_close($curl);
      $geocode_validate_status = 'valid';
      if (isset($output) && !empty($output)) {
        if (isset($output->error_message)) {
          $geocode_validate_status = $output->error_message;
        }
      }
      if(isset($output) && $output == "You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started")
      {
        $geocode_validate_status = $output;
      }
      echo $geocode_validate_status;
      die();
    }
    
    public function wcmlim_locations_bulk_dropdown()
    {
      global $pagenow;
      $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
      if ( is_admin() && 
        'product' == $current_page &&
        'edit.php' == $pagenow) {

          $locations_list = $this->wcmlim_get_all_locations();
?>
  <select name="bulk_default_selection" id="bulk_default_selection" style="float:none;max-width:fit-content;display:<?php
  $default_location = get_option( 'wcmlim_enable_default_location ');
  if($default_location == 'on'){
    echo '';
  }
    else{
      echo 'none';
    
  }
  ?>">
    <option value="-1"><?php _e('Change default location to...', 'wcmlim'); ?></option>
    <?php
      if (sizeof($locations_list) > 0) {
        foreach ($locations_list as $key => $loc) {
          $__locName = ucfirst($loc['location_name']);
          $__locTermID = $loc['term_id'];
    ?>
        <option value="<?= $key ?>" data-termid="<?= $__locTermID ?>"><?= $__locName ?></option>
    <?php
        }
      }
    ?>
  </select>
  <input type="button" name="assignitloc" id="assignitloc" class="button" value="Change">
<?php
        }
    }

    public function wcmlim_bulk_assign_default_location()
    {
      $user_id = get_current_user_id();
      if (!current_user_can('administrator', $user_id))
        return false;

      if ($_POST['type'] == "users") {
        $user_ids = isset($_POST['userids']) ? intval($_POST['userids']) : "";
        $new_value = isset($_POST['selected']) ? intval($_POST['selected']) : "";

        // Will return false if the previous value is the same as $new_value.
        $updated = update_user_meta($user_ids, 'wcmlim_user_specific_location', $new_value);

        // So check and make sure the stored value matches $new_value.
        if ($new_value != get_user_meta($user_ids,  'wcmlim_user_specific_location', true)) {
          echo "fail";
        } else {
          echo "success";
        }
      }

      if ($_POST['type'] == "product") {
        $product_ids = isset($_POST['productids']) ? intval($_POST['productids']) : "";
        $new_pvalue = isset($_POST['selected']) ? intval($_POST['selected']) : "";
        $prepare_val = '';
        $isExcLoc = get_option("wcmlim_exclude_locations_from_frontend");
        if (!empty($isExcLoc)) {
          $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0, 'exclude' => $isExcLoc));
        } else {
          $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
        }
        foreach ($terms as $in => $term) {
          $termid = $term->term_id;
          if($termid == $new_pvalue)
          {
            $prepare_val = "loc_$in";

          }
        }
        $new_pvalue = $prepare_val;
        $product = wc_get_product($product_ids);
        if ($product->is_type("simple")) {
          update_post_meta($product_ids, "wcmlim_default_location", $new_pvalue);
          if ($new_pvalue != get_post_meta($product_ids,  'wcmlim_default_location', true)) {
            echo "fail";
          } else {
            echo "success";
          }
        } elseif ($product->is_type("variable")) {
          update_post_meta($product_ids, "wcmlim_default_location", $new_pvalue);
          $variations = $product->get_available_variations();
          $variations_id = wp_list_pluck($variations, 'variation_id');
          foreach ($variations_id as $vid) {
            update_post_meta($vid, "wcmlim_default_location", $new_pvalue);
            if ($new_pvalue != get_post_meta($vid,  'wcmlim_default_location', true)) {
              $smg = "fail";
            } else {
              $smg = "success";
            }
          }
          echo $smg;
        } else {
          update_post_meta($product_ids, "wcmlim_default_location", $new_pvalue);
          if ($new_pvalue != get_post_meta($product_ids,  'wcmlim_default_location', true)) {
            echo "fail";
          } else {
            echo "success";
          }
        }
      }

      wp_die();
    }
     /**
     * On single page List View or Dropdown Select
     *
     * @since  1.2.8
     */

    public function wcmlim_select_or_dropdown_callback()
    {
      $locchecked = get_option($this->option_name . '_select_or_dropdown');
    ?>
    <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_select_or_dropdown') ?>" name="<?php esc_attr_e($this->option_name . '_select_or_dropdown') ?>" <?php echo ($locchecked == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label><br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to display radio listing for Location.', 'wcmlim') . '</label>'; ?>
    <?php 
    }
      /**
     * On Radio List Show detail address or not
     *
     * @since  1.2.8
     */    
    public function wcmlim_radio_loc_fulladdress_callback()
    {
      $showdetailladd = get_option($this->option_name . '_radio_loc_fulladdress');
    ?>
      <label class="switch">
        <input type="checkbox" id="<?php esc_attr_e($this->option_name . '_radio_loc_fulladdress') ?>" name="<?php esc_attr_e($this->option_name . '_radio_loc_fulladdress') ?>" <?php echo ($showdetailladd == 'on') ? 'checked="checked"' : ''; ?>>
        <span class="slider round"></span>
      </label><br />
      <?php echo '<label class="wcmlim-setting-option-des">' . __('Enable this to show detail address information on listing options.', 'wcmlim') . '</label>'; ?>
    <?php
    }
    /**
     * On Radio List Show detail address or not
     *
     * @since  1.2.8
     */
    public function wcmlim_radio_loc_format_callback()
    {
      $showformat = get_option($this->option_name . '_radio_loc_format');     
      ?>
        <select name="<?php esc_attr_e($this->option_name . '_radio_loc_format') ?>" id="<?php esc_attr_e($this->option_name . '_radio_loc_format') ?>">
          <option value="full"><?php _e('One Column', 'wcmlim'); ?></option>
          <option value="half" <?php if ($showformat == 'half') {
                                      echo "selected='selected'";
                                    } ?>><?php _e('Two Column', 'wcmlim'); ?></option>
          <option value="third" <?php if ($showformat == 'third') {
                                    echo "selected='selected'";
                                  } ?>><?php _e('Three Column', 'wcmlim'); ?></option>
  
          <option value="scroll" <?php if ($showformat == 'scroll') {
                                          echo "selected='selected'";
                                        } ?>><?php _e('Scroll View', 'wcmlim'); ?></option>
          <option value="advanced_list_view" <?php if ($showformat == 'advanced_list_view') {
                                          echo "selected='selected'";
                                        } ?>><?php _e('Adv. List View', 'wcmlim'); ?></option>
  
        </select>
        <?php echo '<label class="wcmlim-setting-option-des">' . __('Select one of the options for format grid or scroll view on location listing options. <b>Default -> One Column selected</b>', 'wcmlim') . '</label>'; ?>
      <hr>
      <?php
    }
     /**
     * On Product Central
     *
     * @since  1.2.9
     */
    public function wcmlim_update_product_central()
    {
      if (!empty($_POST)) {
        $arr = [];
        foreach ($_POST['arr'] as $key => $value) {
          $arrVal = explode("=",$value);
          $arr[$arrVal[0]] = $arrVal[1];
  
        }
        update_option( 'ProductCentralControlOptions', $arr);
        echo json_encode($arr);
      } 
    } 
  /**
  * Product Update Function
  *
  * @since    1.0.0
  */
  public function wcmlim_product_updated()
  {
    
    if (!empty($_POST)) {
      $inp_value = $_POST['inp_value'];
      $data_id = $_POST['data-id'];
      $data_name = $_POST['data-name'];

      if ($data_name == "stckup_product_name") {
        wp_update_post([
          'ID' => $data_id,
          'post_title' => $inp_value
        ]);
      }
      if ($data_name == "stckup_product_stock_at_location") {
        $data_location = $_POST['data-location'];  
        update_post_meta($data_id, 'wcmlim_stock_at_' . $data_location, $inp_value);
        wp_update_post([
          'ID' => $data_id,
        ]);
        $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
        $arr_stock = array();
        foreach ($terms as $key => $value) {
          $loc_stock_val = intval(get_post_meta( $data_id, "wcmlim_stock_at_{$value->term_id}" , true ));
          array_push($arr_stock, $loc_stock_val);
          $total_stock_qty = array_sum($arr_stock);
        }
        update_post_meta($data_id, "_stock", $total_stock_qty);
         echo $data_name;
          die();
      }
      if ($data_name == "stckup_product_sku") {
        update_post_meta($data_id, '_sku', $inp_value);
      }
      if ($data_name == "stckup_product_regular_price") {
        update_post_meta($data_id, '_regular_price', $inp_value);
        $chk_val = get_post_meta($data_id, '_sale_price', true); 
        if (!isset( $chk_val )) {
          update_post_meta($data_id, '_price', $inp_value);
        }
        wc_delete_product_transients( $data_id );
      }
      if ($data_name == "stckup_product_sale_price") {
        $chk_val = get_post_meta($data_id, '_regular_price', true); 
        if($chk_val > $inp_value){
          if ($inp_value != null || $inp_value != false) {
            update_post_meta($data_id, '_price', $inp_value);
            update_post_meta($data_id, '_sale_price', $inp_value);
          } else {
            $chk_v = get_post_meta($data_id, '_regular_price', true); 
            update_post_meta($data_id, '_price', $chk_v);
          } 
        }else {
          update_post_meta($data_id, '_sale_price','--');
        }
        
        wc_delete_product_transients( $data_id );
        $updatestatus=1;
        echo json_encode($updatestatus);
        die();
      }      
      if ($data_name == "stckup_product_stock_status") {
        update_post_meta($data_id, '_stock_status', $inp_value);
        $data_pid = isset($_POST['data-pid']) ? $_POST['data-pid'] : '';
        if($data_pid) {
          $product = wc_get_product($data_pid);
          if(!empty($product) && $product->is_type( 'variable' )) {
            $stock_status = array();
            $variations = $product->get_available_variations();
            $variations_id = wp_list_pluck($variations, 'variation_id');
            if (!empty($variations_id)) {
              foreach ($variations_id as $varid) {               
                $stock_status[] = get_post_meta($varid, '_stock_status', true);	                
              }
            }           
            if(in_array("instock", $stock_status)) {
              update_post_meta($data_pid, '_stock_status', 'instock');
            } else {
              update_post_meta($data_pid, '_stock_status', 'outofstock');
            }
          }
        }       
      }
      if ($data_name == "product_stock_manage") {
        update_post_meta($data_id, '_manage_stock', $inp_value);
        wp_update_post([
          'ID' => $data_id,
        ]);
      }
      if ($data_name == "stckup_product_short_description") {
        wp_update_post([
          'ID' => $data_id,
          'post_excerpt' => $inp_value
        ]);
      }
      if ($data_name == "stckup_product_description") {
        wp_update_post([
          'ID' => $data_id,
          'post_content' => $inp_value
        ]);
      }
      if ($data_name == "stckup_product_status") {
        wp_update_post([
          'ID' => $data_id,
          'post_status' => $inp_value
        ]);
      }

      if ($data_name == "stckup_product_backorders") {
        update_post_meta($data_id, '_backorders', $inp_value);
      }
      if ($data_name == "stckup_product_tax_status") {
        update_post_meta($data_id, '_tax_status', $inp_value);
        $table_name = $wpdb->prefix . 'wc_product_meta_lookup';
        $wpdb->query("UPDATE `".$table_name."` SET `tax_status` = '".$inp_value."' WHERE `".$table_name."`.`product_id`  = " . $data_id);
      }
      if ($data_name == "stckup_product_length") {
        update_post_meta($data_id, '_length', $inp_value);
      }
      if ($data_name == "stckup_product_width") {
        update_post_meta($data_id, '_width', $inp_value);
      }
      if ($data_name == "stckup_product_height") {
        update_post_meta($data_id, '_height', $inp_value);
      }
      if ($data_name == "stckup_product_weight") {
        update_post_meta($data_id, '_weight', $inp_value);
      }
      if ($data_name == "stckup_product_category") {
        wp_set_object_terms($data_id, $inp_value, 'product_cat');
      }
      if ($data_name == "stckup_product_tag") {
        wp_set_object_terms($data_id, $inp_value, 'product_tag');
      }
      if ($data_name == "stckup_product_catalog_visibility") {
        update_post_meta($data_id, '_visibility', $inp_value);
        if($inp_value == 'Hidden'){
          $terms = array( 'exclude-from-catalog', 'exclude-from-search' );
        } else if($inp_value == 'Catalog'){
           $terms = 'exclude-from-catalog';
        }else{
          $terms = 'exclude-from-search';
        }
        echo $terms;
        wp_set_object_terms( $data_id, $terms, 'product_visibility' );
      }
    }
  }

  /**
   * Callback function for populate shipping methods
   * 
   * @since 1.2.14
   */
  public function wcmlim_dynamic_shipping_methods(){

    $nonce = $_POST['security'];
    if ( ! wp_verify_nonce( $nonce, 'mi-nonce' ) ) {
        die( __( 'Security check', 'wcmlim' ) ); 
    } else {
        // Do stuff here.
        $allShippingMethodIds = $_POST['shippingMethods'];
       
        foreach ($allShippingMethodIds as $zone_id) {
          // Get the shipping Zone object
          $shipping_zone = new WC_Shipping_Zone($zone_id);

          // Get all shipping method values for the shipping zone
          $shipping_methods = $shipping_zone->get_shipping_methods(true, 'values');

            foreach($shipping_methods as $i => $value){
              $methods[] = array( 
                "key" => $i,
                "value" => $value->title 
              );
              }
              
           
            }
            echo json_encode($methods);
        }

    wp_die();
  }

  public function support_validator_admin_notice() {  
	  $wcmlim_validte = get_option('wcmlim_license', true);
	  if($wcmlim_validte != 'invalid')
	  {		 
      $user = wp_get_current_user();
      $buyer_email = $user->user_email;
      $purchase_code = get_option('purchase_code');
      $purchase_username = get_option('purchase_username');
      @update_option('date', $date);
      $url = get_site_url();
      $domain_str = parse_url($url, PHP_URL_HOST);
      $domain = str_replace('www.', '', $domain_str);
      if(!function_exists('wp_get_current_user')) {
        include(ABSPATH . "wp-includes/pluggable.php"); 
      }
      $json_array = array(
        "purchase_code" => $purchase_code,
        "purchase_username" => $purchase_username,
        "domain" => $domain,
        "email" => $purchase_username
      );
      $json_format = json_encode($json_array);

      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://verify.techspawn.com/wp-json/my-route/support/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $json_format,
      CURLOPT_HTTPHEADER => array(
      "accept: application/json",
      "content-type: application/json"
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $response;
      }
      $response_arr = json_decode($response);      
      if (isset($response_arr->result) && $response_arr->result == 1) {
        $result = $response_arr->message;
        $supported_until = $response_arr->supported_until;
        $supported_until = date("d-m-Y", strtotime($supported_until));
        $now = time(); // or your date as well
        $support_date = strtotime($response_arr->supported_until);
        $datediff = $support_date - $now;
        $difffound =  round($datediff / (60 * 60 * 24));
        if (strpos($difffound, '-') !== false) {
            ?>
            <div class="notice notice-error is-dismissible">
            <p>
              Your support for <b><?php echo $response_arr->product; ?></b> has been expired, please <a href ="<?php echo $response_arr->url; ?>">Click here to renew your support</a>
            </p>
          </div>
            <?php
        }
        else
        {
          if($difffound < 8)
          {
            ?>
          <div class="notice notice-warning is-dismissible">
            <p>
            Your support for <b><?php echo $response_arr->product; ?></b> expires in <b><?php echo $difffound; ?> Days</b>, please <a href ="<?php echo $response_arr->url; ?>">Click here to renew your support</a>
            </p>
          </div>
          <?php
          }
        }
        update_option('wcmlim_license', "valid");  
      }
      else 
      {
        ?>
        <div class="notice notice-error is-dismissible">
        <p><?php        
        if (isset($response_arr->error_message)) {
          echo $response_arr->message; 
        }
        ?></p>
        </div>
        <?php
        update_option('wcmlim_license', "invalid");            
      }      
    }
  }
  public function wcmlim_deactivate_plugin()
  {
    $deactivate_url= plugin_dir_path(__FILE__) . 'includes/class-wcmlim-deactivator.php';
    deactivate_plugins( '/WooCommerce-Multi-Locations-Inventory-Management/wcmlim.php' ); 
  }

   /**
   * Callback function for getting lat lng once
   * 
   * @since 1.2.14
   */

   
public function wcmlim_get_lcpriority(){
  $lcpriority = $_POST['lcpriority'];
  $skip_location = $_POST['skip_location'];
    $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
    
    $return_status = 0;
    foreach($terms as $term){
      $term_id = $term->term_id;
     if($skip_location != $term_id)
     {
      $cvalterm = get_term_meta($term_id, 'wcmlim_location_priority', true); // get priotity number

      if(intval($lcpriority) == intval($cvalterm))
          {
            $return_status = 1;
          }
     }
    }
    echo $return_status; 
    wp_die();
  }

  function exclude_other_location_products($query) {

      $isShopManagerEnable = get_option('wcmlim_assign_location_shop_manager');

    global $pagenow;
        $current_user = wp_get_current_user();
         $qv = &$query->query_vars;
         $current_user_id = $current_user->ID;
         $currentUserRoles = $current_user->roles;

   
        if (in_array('location_shop_manager', $currentUserRoles) && $isShopManagerEnable == "on") {
                    if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == 'product') {

                      $locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
                      foreach($locations as $key => $term){     
                        $shopM =  get_term_meta($term->term_id, 'wcmlim_shop_manager', true);
                        if (in_array($current_user_id, $shopM)) {
                          $term_ids = $term->term_id;
                        }
                      }
                                            $limit = -1;
                                          $products_ids = get_posts( array(
                                            'post_type'        => ['product'], 
                                            'numberposts'      => $limit,
                                            'fields'           => 'ids',
                                            'meta_query'       => array( array(
                                              'key'       => "wcmlim_stock_at_{$term_ids}",
                                               'value'   => array(0,''),
                                                'compare' => 'NOT IN' ,
                                            ) )
                                        ) );

                                        $variation_products_ids = get_posts( array(
                                          'post_type'        => ['product_variation'], 
                                          'numberposts'      => $limit,
                                          'fields'           => 'id=>parent',
                                          'meta_query'       => array( array(
                                            'key'       => "wcmlim_stock_at_{$term_ids}",
                                             'value'   => array(0,''),
                                              'compare' => 'NOT IN' ,
                                          ) )
                                      ) );
                                      $all_ids = array_merge($products_ids, $variation_products_ids);
                                      $query->set( 'post__in', $all_ids );

                }
       }

   }



  public function wcmlim_get_lat_lng(){

    global $latlngarr;
    $nonce = $_POST['security'];
    if ( ! wp_verify_nonce( $nonce, 'mi-nonce' ) ) {
        die( __( 'Security check', 'wcmlim' ) ); 
    } else {
        $wcmlim_autocomplete_address = $_POST['wcmlim_autocomplete_address'];

        $address = str_replace(' ', '+', $wcmlim_autocomplete_address);
        $address = str_replace(',', '+', $wcmlim_autocomplete_address);
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

    $latlngarr = array(
      'latitude'=>$latitude,
      'longitude'=>$longitude
    );
    
        }
        echo json_encode($latlngarr);
        wp_die();
  }

  
  public function admin_order_list_top_bar_button($which) 
  {
      global $typenow;  
      if ( 'shop_order' === $typenow && 'top' === $which ) {
          ?>
          <div class="alignleft actions custom">
              <button type="button" id="updateAllorder" name="custom_" style="height:32px;" class="button" value=""><?php
                  echo __( 'Update Order for Managers', 'woocommerce' ); ?></button>
          </div>
          <?php
      }
  }
  public function wcmlim_submit_feedback()
  {
    $selected_feedback_option= $_POST['selected_option'];
    $user_email_id= $_POST['UserEmail'];
    $domain= home_url();
    $Current_Plugin= $_POST['CurrentPlugin'];
    $msg = $_POST['msg'];
    $json_array = array(
      "plugin" => $Current_Plugin,
      "domain" => $domain,
      "email" => $user_email_id,
      "option" => $selected_feedback_option,
      "msg" => $msg
    );
    $json_format = json_encode($json_array);
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
            CURLOPT_URL => "https://demo.techspawn.com/Analytics/API/wcmlim/save_options/save_options",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json_format,
            CURLOPT_HTTPHEADER => array(
              "accept: application/json",
              "content-type: application/json"
            ),
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);           
          echo $response;
          die();
  }

  }

