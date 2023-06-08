<?php

/**
 * Cron update product stock and bulk update all products
 *
 * @link       http://www.techspawn.com
 * @since      1.2.10
 *
 * @package    Wcmlim
 * @subpackage Wcmlim/admin
 */

class Wcmlim_Cron_Update
{
    public function __construct()
    {
        add_action('manage_posts_extra_tablenav', [$this, 'admin_order_list_top_bar_button'], 20, 1);
        add_action('wp_ajax_update_inventory_data', [$this, 'wcmlim_update_inventory_data']);
        add_filter('cron_schedules', [$this, 'wcmlim_product_update_cron']);
        add_action('wp_ajax_update_order_data', [$this, 'wcmlim_update_order_data']);
        $cronf_product = get_option("wcmlim_cron_for_product");
        if ($cronf_product !== "default") {
            if (!wp_next_scheduled('wcmlim_product_update_cron_hourly') && $cronf_product == "hourly") {
                wp_schedule_event(time(), 'hourly', 'wcmlim_product_update_cron_hourly');
            }
            if (!wp_next_scheduled('wcmlim_product_update_cron_daily') && $cronf_product == "daily") {
                wp_schedule_event(time(), 'daily', 'wcmlim_product_update_cron_daily');
            }
            if (!wp_next_scheduled('wcmlim_product_update_cron_twicedaily') && $cronf_product == "twicedaily") {
                wp_schedule_event(time(), 'twicedaily', 'wcmlim_product_update_cron_twicedaily');
            }
        } else {
            // Schedule an action if it's not already scheduled
            if (!wp_next_scheduled('wcmlim_product_update_cron')) {
                wp_schedule_event(time(), 'wcmlim_product_update_cron', 'wcmlim_product_update_cron');
            }
        }
        // Hook into that action that'll fire
        add_action('wcmlim_product_update_cron', [$this, 'wcmlim_product_update_cron_cb']);
    }

    public function admin_order_list_top_bar_button($which)
    {
        global $typenow;
        $all_ids = get_posts(array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
        ));
        if ('product' === $typenow && 'top' === $which) {
?>
            <div class="alignleft actions custom">
                <button type="button" id="updateAllStock" style="height:32px;" class="button" data-Products="<?php echo json_encode($all_ids); ?>"><?php _e('Update All products', 'wcmlim'); ?></button>
                <div id="pup_loader" style="display: none;">
                    <span class="spinner"></span>
                </div>
            </div>
<?php
        }
    }

    public function wcmlim_update_inventory_data()
    {
        $product = wc_get_product($_POST['product']);
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
                    
                    if($all_var_location_stock_qty != $_stock){
                        // Mark product as updated
                        update_post_meta($varid, "_stock", $all_var_location_stock_qty);
                        $product->update_meta_data( 'wcmlim_sync_updated', true );
                    }
                    
                    $product->save();
                }
            }
        } else {
            _e("nothing to update", "wcmlim");
        }
        wp_die();
    }

    public function wcmlim_update_order_data()
    {
        $args = array(
        'limit' => -1,
        );
        $query = new WC_Order_Query( $args );
        $order_ids = $query->get_orders();
        $item_term = array();
        $locAdd = array(); 
        $locAdd2 = array(); 
        $locItemID = array(); 
        foreach ($order_ids as $order_id) {
            $order = wc_get_order($order_id);
            $order_id  = $order->get_id();
            foreach ($order->get_items() as $item ) {
                $itemid = $item->get_id();
                $itemSelLocid = $item->get_meta('_selectedLocTermId', true);
                $itemSelLocName = $item->get_meta('Location', true);
                $itemSelData = $order_id . " " . $itemSelLocid;
                if(!in_array( $itemSelData, $locItemID ) ) {
                   $elements = array($order_id => $itemSelLocid);
                   $locItemID[] = $itemSelData;
                   $locAdd[] = $elements;
                }
               
            }       
            $result = array();
            foreach ($locAdd as $arr) {
                foreach($arr as $key => $val) {
                    $result[$key][] = $val;
                }
            }       
            foreach($result as $key => $val) {
                if($val) {
                update_post_meta($key, "_multilocation", $val);     
                }
            }      
        }
    }

    function wcmlim_product_update_cron($schedules)
    {
        $cron_time = get_option("wcmlim_cron_for_product_userdefined");
        if (!empty($cron_time)) {
            $schedules['wcmlim_product_update_cron'] = array(
                'interval'  => $cron_time * 60,
                'display'   => __('product update stock Location', 'wcmlim')
            );
        }
        return $schedules;
    }

    function wcmlim_product_update_cron_hourly()
    {
        $this->wcmlim_product_update_cron_cb();
    }

    function wcmlim_product_update_cron_daily()
    {
        $this->wcmlim_product_update_cron_cb();
    }

    function wcmlim_product_update_cron_twicedaily()
    {
        $this->wcmlim_product_update_cron_cb();
    }

    public function wcmlim_product_update_cron_cb()
    {

        $limit = 200;

        // getting all products
        $products_ids = get_posts( array(
            'post_type'        => ['product','product_variation'], // or ['product','product_variation'],
            'numberposts'      => $limit,
            'post_status'      => 'publish',
            'fields'           => 'ids',
            'meta_query'       => array( array(
                'key'     => 'wcmlim_sync_updated',
                'compare' => 'NOT EXISTS',
            ) )
        ) );

        $terms = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
        $all_location_stock_qty = 0; // Initializing
        // Loop through product Ids
        foreach ( $products_ids as $product_id ) {
            
            // Get the WC_Product object
            $product = wc_get_product($product_id);
            
            if($product->managing_stock() && $product->is_type('simple') || $product->is_type('variable')){
                $_loc_stock = array();
                $_stock = get_post_meta($product_id, '_stock', true);
                foreach ($terms as $key => $value) {
                    $for_loc_stock = (int)get_post_meta( $product_id, "wcmlim_stock_at_{$value->term_id}" , true );
                    array_push($_loc_stock, $for_loc_stock);
                    $all_location_stock_qty = array_sum($_loc_stock);
                }

                if($all_location_stock_qty != $_stock){
                    // Mark product as updated
                    update_post_meta($product_id, "_stock", $all_location_stock_qty);
                    $product->update_meta_data( 'wcmlim_sync_updated', true );
                }

                $product->save();
            }
        }
    }
}

new Wcmlim_Cron_Update();
