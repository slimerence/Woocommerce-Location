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
 * @subpackage Wcmlim/includes
 * @author     techspawn1 <contact@techspawn.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load WP_List_Table if not loaded
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}


class Multiloc_Product_Central extends WP_List_Table
{
  function __construct()
  {
    global $status, $page;

    parent::__construct(array(
      'singular' => 'product_bulk_edit',
      'plural' => 'prodcentral_bulk_edit',
    ));
  }

  public function no_items()
  {
    esc_html_e('No Products found.');
  }

  function column_default($item, $column_name)
  {    
    return $item[$column_name];
  }

  function get_columns()
  {
    $columns = array(
      'id' => esc_html__('Product ID', 'stckup'),
      'thumbnail' =>  esc_html__('Thumbnail', 'stckup'),
      'name' => esc_html__('Name', 'stckup'),
      'sku' => esc_html__('SKU', 'stckup'),
      'type' =>  esc_html__('Type', 'stckup'),
      'regular_price' => esc_html__('Regular Price', 'stckup'),
      'sale_price' => esc_html__('Sale Price', 'stckup'),      
      'stock_status' => esc_html__('Stock Status', 'stckup'),
      'manage_stock' =>  esc_html__('Manage Stock', 'stckup'),
      'stock_at_location' => esc_html__('Stock At Locations', 'stckup'),
      'stock_quantity' => esc_html__('Stock Quantity', 'stckup'),
      //'categories' => esc_html__('Categories', 'stckup'),
      //'tags' =>  esc_html__('Tags', 'stckup'),
      'short_description' =>  esc_html__('Short Description', 'stckup'),
      'description' =>  esc_html__('Description', 'stckup'),     
      'status' =>  esc_html__('Status', 'stckup'),      
      'backorders' =>  esc_html__('Backorders', 'stckup'),
      'weight' =>  esc_html__('Weight', 'stckup'),
      'length' =>  esc_html__('Length', 'stckup'),
      'width' =>  esc_html__('Width', 'stckup'),
      'height' =>  esc_html__('Height', 'stckup'),      
    );
    return $columns;
  }

  function get_sortable_columns()
  {
    $sortable_columns = array(
      'id' => array('id', true),
      'thumbnail' =>  esc_html__('thumbnail', 'stckup'),
      'name' => array('name', true),
      'sku' => array('sku', true),
      'type' =>  esc_html__('type', 'stckup'),
      'regular_price' => array('regular_price', true),
      'sale_price' => array('sale_price', true),      
      'stock_status' => array('stock_status', true),
      'manage_stock' =>  esc_html__('manage_stock', 'stckup'),
      'stock_at_location' => esc_html__('stock_at_location', 'stckup'),
      'stock_quantity' => array('stock_quantity', true),     
      'short_description' =>  esc_html__('short_description', 'stckup'),
      'description' =>  esc_html__('description', 'stckup'),     
      'status' =>  esc_html__('status', 'stckup'),      
      'backorders' =>  esc_html__('backorders', 'stckup'),
      'weight' =>  esc_html__('weight', 'stckup'),
      'length' =>  esc_html__('length', 'stckup'),
      'width' =>  esc_html__('width', 'stckup'),
      'height' =>  esc_html__('height', 'stckup'),     
    );
    return $sortable_columns;
  }

  function prepare_items($search = '')
  {

    $product_all = array();
    $args = array(
      'post_type' => 'product',
      'numberposts' => -1,      
      'posts_per_page' => 150,    
      'post_status' => array(
        'publish',
          'draft',
          'Pending'
       
      ), 
      'tax_query' => array(
        array(
          'taxonomy' => 'product_type',
          'field'    => 'slug',
          'terms'    => array( 'simple', 'variable' ),
        ),
      ),        
    );
    if (!empty($search)) {
      $args['s'] = $search;
    }
    if (!empty($_GET['cat-filter'])) {
      $args['tax_query'][] = array(
        'taxonomy'      => 'product_cat',
        'field' => 'term_id', //This is optional, as it defaults to 'term_id'
        'terms'         => $_GET['cat-filter'],
        'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
      );

    }
    if (!empty($_GET['stock-status-filter'])) {
      if ($_GET['stock-status-filter'] == 'in_stock') {
        $args['meta_query'][] = array(
          'key'     => '_stock_status',
          'value'   => 'outofstock',
          'compare' => '!=',
        );
      }
      else
      {
        $args['meta_query'][] = array(
          'key'     => '_stock_status',
          'value'   => 'outofstock',
          'compare' => '==',
        );
      }
    }
    if (!empty($_GET['type-filter'])) {
      $args['tax_query'][] = array(
        'taxonomy' => 'product_type',
        'field'    => 'slug',
        'terms'    => $_GET['type-filter'],
      );
    }
    if (!empty($_GET['Srchval']) && ($_GET['by'] != 'post_id')) {
      $flt_title = $_GET['Srchval'];
      $behavior = $_GET['behavior'];
      $args['tax_query'][] = array(
        'taxonomy' => 'product_type',
        'field'    => 'slug',
        'terms'    => $_GET['type-filter'],
      );
    }
    if (!empty($_GET['Srchval']) && ($_GET['by'] != 'post_id')) {
      $flt_title = $_GET['Srchval'];
      $behavior = $_GET['behavior'];

      if (($_GET['by'] == 'post_title') && ($behavior == 'LIKE')) {
        $args['s'] = $_GET['Srchval'];
      }

      if (($_GET['by'] == 'post_title') && ($behavior == 'EXACT')) {
        $args['title'] = $_GET['Srchval'];
      }

      if (($_GET['by'] == 'post_title') && ($behavior == '!=')) {
        $args['s'] = '-' . $_GET['Srchval'];
      }

      if ($_GET['by'] == '_sku') {
        $args['meta_query'] = array(
          array(
            'key' => $_GET['by'],
            'value' => $flt_title,
            'compare' => $behavior
          )
        );
      }
    }
    $product_info = get_posts($args);
    if (!empty($_GET['Srchval']) && ($_GET['by'] == 'post_id')) {
      $product_arr_id = [];
      $iarr = 0;
      foreach ($product_info as $value) {
        if ($_GET['Srchval'] == $value->ID) {
          $product_arr_id[$iarr++] = $value;
        }
      }
      $product_info = $product_arr_id;
    }    
    global $wpdb;
    $options_table = $wpdb->prefix . 'options';
    $ProductCentralControlOptions = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $options_table . " WHERE `option_name`= '%s'", 'ProductCentralControlOptions'));
    $PCFOR = maybe_unserialize($ProductCentralControlOptions[0]->option_value);

    foreach ($product_info as $key => $value) {
      $stock_at_location = '';
      $product_id = $value->ID;
      $product = wc_get_product($product_id);     
      
      $prices = get_post_meta( $product_id, '_regular_price', true);
      $price_sale = get_post_meta( $product_id, '_sale_price', true);
      if ($price_sale <= $prices ) {
          $validity =  "Valid";
      } else {
        $validity =  "Not Valid";
      }

      $name  = sprintf('<label class="lbledit stckup_product_name" >%s</label><input class="clickedit" value="%s" data-name="stckup_product_name" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_name(), 'stckup'), esc_html__($product->get_name(), 'stckup'), $product_id);
      if (!empty($product->get_sku())) {
        $sku =  sprintf('<label class="lbledit stckup_product_sku">%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sku" type="text" /><div class="clearfix"></div>', esc_html__($product->get_sku(), 'stckup'), esc_html__($product->get_sku(), 'stckup'), $product_id);
      } else {
        $sku =  sprintf('<label class="lbledit stckup_product_sku">%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sku" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }

      if (!empty($product->get_regular_price())) {
        $price = sprintf('<label class="lbledit stckup_product_regular_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_regular_price" type="text" /><div class="clearfix"></div>', esc_html__($product->get_regular_price(), 'stckup'), esc_html__($product->get_regular_price(), 'stckup'), $product_id);
      } else {
        $price = sprintf('<label class="lbledit stckup_product_regular_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_regular_price" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }
      if (!empty($product->get_sale_price()) && $validity == 'Valid') {
        $sale_price = sprintf('<label class="lbledit stckup_product_sale_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sale_price" type="text" /><div class="clearfix"></div>', esc_html__($product->get_sale_price(), 'stckup'), esc_html__($product->get_sale_price(), 'stckup'), $product_id);
      } else {
        $sale_price = sprintf('<label class="lbledit stckup_product_sale_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sale_price" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }

      if (!empty($product->get_status())) {
        $status  = sprintf('<label class="lbledit stckup_product_status" >%s</label><select class="clickedit product_status" data-name="stckup_product_status" Pid="pid_' . $product_id . '"><option selected="selected" value="publish">Published</option><option value="pending">Pending Review</option><option value="draft">Draft</option></select><input class="pid_' . $product_id . '" data-name="stckup_product_status" data-id="%s" type="hidden" /><div class="clearfix"></div>', esc_html__($product->get_status(), 'stckup'), $product_id);
      } else {
        $status  = sprintf('<label class="lbledit stckup_product_status" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_status" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }     

      if (!empty($product->get_description())) {
        $description  = sprintf('<label class="lbledit stckup_product_description" >%s</label><textarea rows="5"  class="clickedit" data-name="stckup_product_description" data-id="%s" type="text">%s</textarea><div class="clearfix"></div>', esc_html__($product->get_description(), 'stckup'), $product_id ,  esc_html__($product->get_description(), 'stckup'));
      } else {
        $description  = sprintf('<label class="lbledit stckup_product_description" >%s</label><textarea rows="5"  class="clickedit" data-name="stckup_product_description" data-id="%s" type="text">%s</textarea><div class="clearfix"></div>', '--', $product_id, '--');
      }

      if (!empty($product->get_short_description())) {
        $short_description  = sprintf('<label class="lbledit stckup_product_short_description" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_short_description" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_short_description(), 'stckup'), esc_html__($product->get_short_description(), 'stckup'), $product_id);
      } else {
        $short_description  = sprintf('<label class="lbledit stckup_product_short_description" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_short_description" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }   

      if (!empty($product->get_backorders())) {
        $backorderlbl =  $product->get_backorders();
        if ($backorderlbl == "notify") {
          $backorderlbl = "Allow, but notify customer";
        } else if($backorderlbl == "yes") {
          $backorderlbl = "Allow";
        } else {
          $backorderlbl = "Do not allow";
        }
        $backorders  = sprintf('<label class="lbledit stckup_product_backorders" >%s</label><select class="clickedit bulk_product_backorder_edit" data-name="stckup_product_backorders" Pid="pid_' . $product_id . '"><option value="-1">Select Below</option><option value="no">NO Backdoor</option><option value="notify">Backorder notify</option><option value="yes">yes backdoor</option></select><input class="pid_' . $product_id . '"  class="clickedit" data-name="stckup_product_backorders" data-id="%s" type="hidden" /><div class="clearfix"></div>', $backorderlbl , $product_id);
      } else {
        $backorders  = sprintf('<label class="lbledit stckup_product_backorders" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_backorders" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }
      

      if (!empty($product->get_weight())) {
        $weight  = sprintf('<label class="lbledit stckup_product_weight" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_weight" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_weight(), 'stckup'), esc_html__($product->get_weight(), 'stckup'), $product_id);
      } else {
        $weight  = sprintf('<label class="lbledit stckup_product_weight" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_weight" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }

      if (!empty($product->get_length())) {
        $length  = sprintf('<label class="lbledit stckup_product_length" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_length" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_length(), 'stckup'), esc_html__($product->get_length(), 'stckup'), $product_id);
      } else {
        $length  = sprintf('<label class="lbledit stckup_product_length" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_length" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }

      if (!empty($product->get_width())) {
        $width  = sprintf('<label class="lbledit stckup_product_width" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_width" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_width(), 'stckup'), esc_html__($product->get_width(), 'stckup'), $product_id);
      } else {
        $width  = sprintf('<label class="lbledit stckup_product_width" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_width" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      }

      if (!empty($product->get_height())) {
        $height  = sprintf('<label class="lbledit stckup_product_height" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_height" data-id="%s" type="text" /><div class="clearfix"></div>', esc_html__($product->get_height(), 'stckup'), esc_html__($product->get_height(), 'stckup'), $product_id);
      } else {
        $height  = sprintf('<label class="lbledit stckup_product_height" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_height" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--', $product_id);
      } 
    
      if (!empty($product->get_type())) {
        $product_type  = sprintf('<label class="stckup_product_type" >%s</label>
          <input class="" data-name="stckup_product_type" data-id="%s" type="hidden" /><div class="clearfix"></div>', $product->get_type(), $product_id);
      } else {
        $product_type  = sprintf('<label class="stckup_product_type" >%s</label><input class="" data-name="stckup_product_type" data-id="%s" type="hidden" /><div class="clearfix"></div>', '--', $product_id);
      }
      if (!empty($product->get_image_id())) {
        $thumbnail_url =  wp_get_attachment_image_src($product->get_image_id());
        $site_url_im = get_site_url();
        $thumbnail  = sprintf('<label class="stckup_product_thumbnail" ><img src="' . $thumbnail_url[0] . '" width="30px" style="border: 1px solid #d6d5d5; border-radius: 3px;"></label><div class="clearfix"></div>', $product_id);
      } else {
        $thumbnail  = sprintf('<label class="stckup_product_thumbnail" ><img src="' . plugin_dir_url(__FILE__) . 'images/placeholder.png" width="30px" style="border: 1px solid #d6d5d5; border-radius: 3px;"></label><div class="clearfix"></div>', $product_id);
      }

      if ($product->get_manage_stock() == 1) {
        $check_val = 'checked';
        $cus_stock_manage = 'Yes';
      } else {
        $check_val = '';
        $cus_stock_manage = 'No';
      }
      $manage_stock = sprintf('<label class="switch"><input type="checkbox" ' . $check_val . ' id="check_' . $product_id . '"><span class="slider round"></span></label><label class="product_stock_manage check_' . $product_id . ' ' . $cus_stock_manage . ' %s"> ' . $cus_stock_manage . '</label><div class="empty_to_cll_action"> </div><input class="clickedit check_' . $product_id . '" data-id="%s" data-name="product_stock_manage" type="hidden" /><div class="clearfix"></div>',  esc_html__($product->get_manage_stock(), 'stckup'), $product_id);
 

      if (!empty($product->get_stock_quantity())) {
        $stock_quantity = sprintf('<label class="stckup_product_stock_quantity" >%s</label><div class="clearfix"></div>', esc_html__($product->get_stock_quantity(), 'stckup'), $product_id);
      } else {
        $stock_quantity = sprintf('<label class="stckup_product_stock_quantity" >%s</label><div class="clearfix"></div>', '0', $product_id);
      }

      if (!empty($product->get_stock_status())) {
        if ($product->get_stock_status() == 'instock') {
          $checked_val = 'checked';
          $cust_stock_val = 'Yes';
        } else {
          $checked_val = '';
          $cust_stock_val = 'No';
        }
        $stock_status = sprintf('<label class="switch"><input type="checkbox" ' . $checked_val . ' id="check_' . $product_id . '"><span class="slider round"></span></label><label class="stckup_product_stock_status check_' . $product_id . ' ' . $cust_stock_val . ' %s"> ' . $cust_stock_val . '</label><div class="empty_to_cll_action"> </div><input class="clickedit check_' . $product_id . '" data-id="%s" data-name="stckup_product_stock_status" type="hidden" /><div class="clearfix"></div>',  esc_html__($product->get_stock_status(), 'stckup'), $product_id);
      
      } else {
        $stock_status = sprintf('<label class="switch"><input type="checkbox" ' . $checked_val . ' id="check_' . $product_id . '"><span class="slider round"></span></label><label class="stckup_product_stock_status check_' . $product_id . ' ' . $cust_stock_val . '">%s</label><input class="clickedit check_' . $product_id . '" data-id="%s" data-name="stckup_product_stock_status" type="hidden" /><div class="clearfix"></div>', '--', $product_id);
      }

      $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
      if (!empty($terms)) {
        foreach ($terms as $term) {
          if (isset($term->term_id)) {
            $stock_location = get_post_meta($product_id, "wcmlim_stock_at_{$term->term_id}", true);
            $managesimple_stock = get_post_meta($product_id, '_manage_stock', true);
            if ( $managesimple_stock && $managesimple_stock != 'no') {
              if ($stock_location <= 0) {
                $stock_at_location .=  sprintf('<strong><label class="stckup_product_stock_at_location">%s : </label></strong>
                <label class="lbledit stckup_product_stock_at_location">%s</label>
                <input class="stock_at_location" value="%s" data-id="%s" data-name="stckup_product_stock_at_location" 
                data-location="%s" type="text" /><div class="clearfix"></div>'
                , $term->name, '--', '0', $product_id, $term->term_id);
              } else {
                $stock_at_location .=  sprintf('<strong><label class="stckup_product_stock_at_location">%s : 
                </label></strong><label class="lbledit stckup_product_stock_at_location">%s</label>
                <input class="stock_at_location"  value="%s" data-id="%s" 
                data-name="stckup_product_stock_at_location" data-location="%s" type="text" />
                <div class="clearfix"></div>', $term->name, $stock_location, $stock_location, $product_id, $term->term_id);
              } 
            } else {
              $stock_at_location = sprintf('<label class="lbledit stckup_product_stock_at_location">%s</label>
              <input class="stock_at_location" data-id="%s" data-name="stckup_product_stock_at_location" type="text" />
              <div class="clearfix"></div>', 
              '<span style="font-weight: 800;color: #e2401c;">Manage Stock Option Disable</span>', $product_id);          
                  
            }

          }
        }
      }    
      $pr_id = sprintf('<label class="stckup_product_id" prdctID="' . $product_id . '" >%s</label>', $product_id);        
      if ($product instanceof WC_Product && $product->is_type('simple') ) {    
        $product_all[] = array(
          "id" => $pr_id,
          'thumbnail' => $thumbnail,
          "name" => $name,
          "sku" => $sku,
          'type' =>  $product_type,
          "regular_price" => $price,
          "sale_price" => $sale_price,         
          "stock_status" => $stock_status,
          'manage_stock' =>  $manage_stock,
          "stock_at_location" => $stock_at_location,
          "stock_quantity" => $stock_quantity,         
          'short_description' =>  $short_description,
          'description' =>  $description,         
          'status' =>  $status,        
          'backorders' =>  $backorders,
          'weight' =>  $weight,
          'length' =>  $length,
          'width' =>  $width,
          'height' =>  $height,
          
        );
      }
      if ($product instanceof WC_Product && $product->is_type('variable')) {
        $variations = $product->get_available_variations();
        
        


        if (!empty($variations)) {
          foreach ($variations as $key => $variation) {
            $stock_at_variation_location = '';
            $product_variation = wc_get_product($variation['variation_id']);
            $prices = get_post_meta( $variation['variation_id'], '_regular_price', true);
            $price_sale = get_post_meta( $variation['variation_id'], '_sale_price', true);
            if ($price_sale <= $prices ) {
                $validity =  "Valid";
            } else {
              $validity =  "Not Valid";
            }
           
            $variation_name = sprintf('<label class="stckup_product_name" >%s</label>', esc_html__($product_variation->get_name(), 'stckup'));

            if (!empty($product_variation->get_sku())) {
              $variation_sku = sprintf('<label class="lbledit stckup_product_sku" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sku" type="text" /><div class="clearfix"></div>',  esc_html__($product_variation->get_sku(), 'stckup'), esc_html__($product_variation->get_sku(), 'stckup'), $variation['variation_id']);
            } else {
              $variation_sku = sprintf('<label class="lbledit stckup_product_sku" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sku" type="text" /><div class="clearfix"></div>', '--', '--', $variation['variation_id']);
            }

            if (!empty($product_variation->get_regular_price())) {
              $variation_price = sprintf('<label class="lbledit stckup_product_regular_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_regular_price" type="text" /><div class="clearfix"></div>', esc_html__($product_variation->get_regular_price(), 'stckup'), esc_html__($product_variation->get_regular_price(), 'stckup'), $variation['variation_id']);
            } else {
              $variation_price = sprintf('<label class="lbledit stckup_product_regular_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_regular_price" type="text" /><div class="clearfix"></div>', '--', '--', $variation['variation_id']);
            }

            if (!empty($product_variation->get_sale_price()) && $validity == 'Valid') {
              $variation_sale_price = sprintf('<label class="lbledit stckup_product_sale_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sale_price" type="text" /><div class="clearfix"></div>',  esc_html__($product_variation->get_sale_price(), 'stckup'), esc_html__($product_variation->get_sale_price(), 'stckup'), $variation['variation_id']);
            } else {
              $variation_sale_price = sprintf('<label class="lbledit stckup_product_sale_price" >%s</label><input class="clickedit" value="%s" data-id="%s" data-name="stckup_product_sale_price" type="text" /><div class="clearfix"></div>', '--', '--', $variation['variation_id']);
            }
            
            if ($product_variation->get_manage_stock() == 1) {
              $check_val = 'checked';
              $cus_stock_manage = 'Yes';
            } else {
              $check_val = '';
              $cus_stock_manage = 'No';
            }
            $variation_manage_stock = sprintf('<label class="switch"><input type="checkbox" ' . $check_val . ' id="check_' . $variation['variation_id'] . '"><span class="slider round"></span></label><label class="product_stock_manage check_' . $variation['variation_id'] . ' ' . $cus_stock_manage . ' %s"> ' . $cus_stock_manage . '</label><div class="empty_to_cll_action"> </div><input class="clickedit check_' . $variation['variation_id'] . '" data-id="%s" data-name="product_stock_manage" type="hidden" /><div class="clearfix"></div>',  esc_html__($product_variation->get_manage_stock(), 'stckup'), $variation['variation_id']);
          

            if (!empty($product_variation->get_stock_quantity())) {
              $variation_stock_quantity = sprintf('<label class="stckup_product_stock_quantity" >%s</label><div class="clearfix"></div>',  esc_html__($product_variation->get_stock_quantity(), 'stckup'), $variation['variation_id']);
            } else {
              $variation_stock_quantity = sprintf('<label class="stckup_product_stock_quantity" >%s</label><div class="clearfix"></div>', '0', $variation['variation_id']);
            }

            if (!empty($product_variation->get_stock_status())) {
              if ($product_variation->get_stock_status() == 'instock') {
                $checked_val = 'checked';
                $cust_stock_val = 'Yes';
              } else {
                $checked_val = '';
                $cust_stock_val = 'No';
              }
              $variation_stock_status = sprintf('<label class="switch"><input type="checkbox" ' . $checked_val . ' id="check_' . $variation['variation_id'] . '"><span class="slider round"></span></label><label class="stckup_product_stock_status check_' . $variation['variation_id'] . ' ' . $cust_stock_val . ' %s"> ' . $cust_stock_val . '</label><div class="empty_to_cll_action"> </div><input class="clickedit check_' . $variation['variation_id'] . '" data-id="%s" data-pid="%s" data-name="stckup_product_stock_status" type="hidden" /><div class="clearfix"></div>',  esc_html__($product_variation->get_stock_status(), 'stckup'), $variation['variation_id'], $product_id);
            } else {
              $variation_stock_status = sprintf('<label class="switch"><input type="checkbox" ' . $checked_val . ' id="check_' . $variation['variation_id'] . '"><span class="slider round"></span></label><label class="stckup_product_stock_status check_' . $variation['variation_id'] . ' ' . $cust_stock_val . '">%s</label><input class="clickedit check_' . $variation['variation_id'] . '" data-id="%s" data-pid="%s" data-name="stckup_product_stock_status" type="hidden" /><div class="clearfix"></div>', '--', $variation['variation_id'], $product_id);
            }
            $locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
            if (!empty($locations)) {
              foreach ($locations as $location) {
                if (isset($location->term_id)) {
                  $stock_location_variation = get_post_meta($variation['variation_id'], "wcmlim_stock_at_{$location->term_id}", true);
                  $manage_stock_var = get_post_meta($variation['variation_id'], '_manage_stock', true);
                  if ( $manage_stock_var && $manage_stock_var != 'no') {
                    if ($stock_location_variation <= 0) {
                      $stock_at_variation_location .=  sprintf('<strong><label class="stckup_product_stock_at_location">%s : 
                      </label></strong><label class="lbledit stckup_product_stock_at_location">%s</label><input class="stock_at_location" 
                      value="%s" data-id="%s" data-name="stckup_product_stock_at_location" data-location="%s"
                      type="text" /><div class="clearfix"></div>'
                      , $location->name, '--', '0', $variation['variation_id'], $location->term_id);
                    } else {
                      $stock_at_variation_location .=  sprintf('<strong><label class="stckup_product_stock_at_location">%s :
                      </label></strong><label class="lbledit stckup_product_stock_at_location">%s</label><input class="stock_at_location" 
                      value="%s" data-id="%s" data-name="stckup_product_stock_at_location" data-location="%s" 
                      type="text" /><div class="clearfix"></div>'
                      , $location->name, $stock_location_variation, $stock_location_variation, $variation['variation_id'], $location->term_id);
                    }
                  } else {
                    $stock_at_variation_location = sprintf('<label class="stckup_product_stock_at_location">%s</label><input class="stock_at_location" data-id="%s" data-name="stckup_product_stock_at_location" type="text" /><div class="clearfix"></div>', '<span style="font-weight: 800;color: #e2401c;">Manage Stock Option Disable</span>', $variation['variation_id']);          
                  }
                }
              }
            }
            if (!empty($product_variation->get_backorders())) {
              $backorderlbl =  $product_variation->get_backorders();
              if ($backorderlbl == "notify") {
                $backorderlbl = "Allow, but notify customer";
              } else if($backorderlbl == "yes") {
                $backorderlbl = "Allow";
              } else {
                $backorderlbl = "Do not allow";
              }
              $variation_backorders  = sprintf('<label class="lbledit stckup_product_backorders" >%s</label><select class="clickedit bulk_product_backorder_edit" data-name="stckup_product_backorders" Pid="pid_' . $variation['variation_id'] . '"><option value="Select Below">Select Below</option><option value="no">NO Backdoor</option><option value="notify">Backorder notify</option><option value="yes">yes backdoor</option></select><input class="pid_' . $variation['variation_id'] . '"  class="clickedit" data-name="stckup_product_backorders" data-id="%s" type="hidden" /><div class="clearfix"></div>', $backorderlbl ,$variation['variation_id']);
            } else {
              $variation_backorders  = sprintf('<label class="lbledit stckup_product_backorders" >%s</label><input value="%s" class="clickedit" data-name="stckup_product_backorders" data-id="%s" type="text" /><div class="clearfix"></div>', '--', '--',$variation['variation_id']);
            }
            $vpr_id = sprintf('<label class="stckup_product_id" prdctID="' . $product_id . '" >%s</label>', $variation['variation_id']);        
            $product_all[] = array(
              "id" => $vpr_id,              
              'thumbnail' => $thumbnail,
              "name" => $variation_name,
              "sku" => $variation_sku,
              'type' =>  $product_type,
              "regular_price" => $variation_price,
              "sale_price" => $variation_sale_price,              
              "stock_status" => $variation_stock_status,
              'manage_stock' =>  $variation_manage_stock,
              "stock_at_location" => $stock_at_variation_location,
              "stock_quantity" => $variation_stock_quantity,             
              'short_description' =>  $short_description,
              'description' =>  $description,             
              'status' =>  $status,             
              'backorders' =>  $variation_backorders,
              'weight' =>  $weight,
              'length' =>  $length,
              'width' =>  $width,
              'height' =>  $height,              
            );           
          }
        }
      }  


    }
    $columns = $this->get_columns();
    $cl_fr_nw = [];
    foreach ($columns as $key => $value) {
      if (isset($PCFOR[0])) {
        $col_val_shw = $PCFOR[0][$key];
      } else {
        $col_val_shw = $PCFOR[$key];
      }
      if ($col_val_shw == 'Show') {
        $cl_fr_nw[$key] = $value;
      }
    }
    $columns = $cl_fr_nw;
    $hidden = array();    
    $sortable = array();
    $this->_column_headers = array($columns, $hidden, $sortable);   
    $totalItems = count($product_all);
    $perPage = $totalItems;
    $currentPage = $this->get_pagenum();
    $this->set_pagination_args(array(      
    ));
    $data = array_slice($product_all, (($currentPage - 1) * $perPage), $perPage);
    $this->items = $data;
  }

  function extra_tablenav($which)
  {
    global $wpdb, $testiURL, $tablename, $tablet;
    $move_on_url = '&cat-filter=';
    if ($which == "top") {
?>
      <div class="alignleft actions bulkactions">
        <?php
        $args = array(
          'taxonomy'   => "product_cat",
          'orderby'    => 'title',
          'order'      => 'ASC'
        );
        $product_categories = get_terms($args);

        if ($product_categories) {
        ?>
          <select name="cat-filter" id="cat-filter" class="ewc-filter-cat">
            <option value=""><?php esc_html_e('Filter by Category', 'stckup') ?></option>
            <?php
            foreach ($product_categories as $cat) {

              $selected = '';
              if (!empty($_GET)) {
                if ($_GET['cat-filter'] == $cat->term_id) {
                  $selected = ' selected = "selected"';
                }
              }
            ?>
              <option value="<?php esc_attr_e($move_on_url . $cat->term_id, 'stckup'); ?>" <?php esc_attr_e($selected, 'stckup'); ?>><?php esc_attr_e($cat->name, 'stckup'); ?></option>
            <?php

            }
            ?>
          </select>
        <?php
        }
        ?>
      </div>

      <div class="alignleft actions bulkactions">
        <?php
        $type_filter_url = '&type-filter=';

        $product_types = wc_get_product_types();

        if ($product_types) {
        ?>
          <select name="type-filter" class="ewc-filter-type" id="ewc-filter-type">
            <option value=""><?php esc_html_e('Filter by Product Type', 'stckup') ?></option>
            <?php
            foreach ($product_types as $key => $product_type) {

              $selected = '';
              if (!empty($_GET)) {
                if ($_GET['type-filter'] == $key) {
                  $selected = ' selected = "selected"';
                }
              }
              if ($key == "simple" || $key == "variable"  ) {
            ?>
              <option value="<?php esc_attr_e($type_filter_url . $key, 'stckup'); ?>" <?php esc_attr_e($selected, 'stckup'); ?>><?php esc_attr_e($product_type, 'stckup'); ?></option>
            <?php
              }
            }
            ?>
          </select>
        <?php
        }
        ?>
      </div>
      <div class="alignleft actions bulkactions">
        <?php
        $stock_status_filter_url = '&stock-status-filter=';
        ?>
        <select name="stock-status-filter" id= "ewc-filter-stock-status" class="ewc-filter-stock-status">
          <?php
          $selected = '';
          if (!empty($_GET['stock-status-filter'])) {
            if ($_GET['stock-status-filter'] == "in_stock") {
              $selected = ' selected = "selected"';
            }
          }
          ?>
          <option value=""><?php esc_html_e('Filter by Stock Status', 'stckup') ?></option>
          <option value="<?php esc_attr_e($stock_status_filter_url . 'in_stock'); ?>" <?php if (!empty($_GET['stock-status-filter'])) {
                                                                                                if ($_GET['stock-status-filter'] == "in_stock") {
                                                                                                  echo "selected='selected'";
                                                                                                }
                                                                                              } ?>>In Stock</option>
          <option value="<?php esc_attr_e($stock_status_filter_url . 'out_of_stock'); ?>" <?php if (!empty($_GET['stock-status-filter'])) {
                                                                                                    if ($_GET['stock-status-filter'] == "out_of_stock") {
                                                                                                      echo "selected='selected'";
                                                                                                    }
                                                                                                  }  ?>>Out Of Stock</option>

        </select>

      </div>
    <div class="alignleft actions bulkactions">

    <a href="?page=wcmlim-product-central"><input type="button" class="button" id="wcmlim-rest" value="Reset"></a>

    </div>
<?php
    }
  }
}
