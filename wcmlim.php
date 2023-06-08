<?php

/**
 * Copyright: (c)  [2020] - Techspawn Solutions Private Limited ( contact@techspawn.com  ) 
 *  All Rights Reserved.
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Techspawn Solutions Private Limited,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Techspawn Solutions Private Limited,
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Techspawn Solutions Private Limited
 *
 * @link              http://www.techspawn.com
 * @since             1.0.0
 * @package           Wcmlim
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Multi Locations Inventory Management
 * Plugin URI:        http://www.techspawn.com
 * Description:       This plugin will help you manage WooCommerce Products stocks through locations.
 * Version:           3.4.9
 * Requires at least: 4.9
 * Author:            Techspawn Solutions
 * Author URI:        http://www.techspawn.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wcmlim
 * Domain Path:       /languages
 * WC requires at least:	3.4
 * WC tested up to: 	5.8.0
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WCMLIM_VERSION', '3.4.9');
/**
 * Define default path and url for plugin.
 * 
 * @since    1.1.5
 */
define('WCMLIM_DIR_PATH', plugin_dir_path(__FILE__));
define('WCMLIM_URL_PATH', plugins_url('/', __FILE__));
define('WCMLIM_BASE', plugin_basename(__FILE__));
//blocks
add_action("enqueue_block_editor_assets", "wcmlim_blocks_enqueue");

function wcmlim_blocks_enqueue(){
  wp_enqueue_script('wcmlim-switch-block', plugin_dir_url(__FILE__).'admin/blocks/switch-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  wp_enqueue_script('wcmlim-popup-block', plugin_dir_url(__FILE__).'admin/blocks/popup-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  wp_enqueue_script('wcmlim-location-finder-block', plugin_dir_url(__FILE__).'admin/blocks/loc-finder-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  wp_enqueue_script('wcmlim-lflv-block', plugin_dir_url(__FILE__).'admin/blocks/lflv-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  wp_enqueue_script('wcmlim-locinfo-block', plugin_dir_url(__FILE__).'admin/blocks/locinfo-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  wp_enqueue_script('wcmlim-prod-by-id-block', plugin_dir_url(__FILE__).'admin/blocks/prod-by-id-block.js',array('wp-blocks','wp-i18n', 'wp-editor'),true, true );

  //styles
  wp_enqueue_style('wcmlim-popup-block', plugin_dir_url(__FILE__).'admin/css/wcmlim-popup-block.css',array('wp-blocks','wp-i18n', 'wp-editor'),true, false ); 
}


function wcmlim_block_category( $categories ) {
  $custom_block = array(
    'slug'  => 'amultilocation',
    'title' => 'Multilocations For WooCommerce'
  );
  $categories_sorted = array();
  $categories_sorted[0] = $custom_block;
  foreach ($categories as $category) {
      $categories_sorted[] = $category;
  }
  return $categories_sorted;
}
add_filter( 'block_categories', 'wcmlim_block_category', 10, 2);


//shop_page_location_meta_fixes_start
add_filter( 'init', 'wcmlim_shop_page_location_cookie', 20 );
function wcmlim_shop_page_location_cookie() { 
$refresh_id = (isset($_COOKIE['wcmlim_selected_location'])) ? $_COOKIE['wcmlim_selected_location'] : '' ;
$cookieindays = get_option('wcmlim_set_location_cookie_time');
global $wpdb;
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', rtrim($path, '/'));
$loc_name = end($segments);	
$taxonomies = get_taxonomies();
foreach ( $taxonomies as $tax_type_key => $taxonomy ) {
   if ( $term_object = get_term_by( 'slug', $loc_name , $taxonomy ) ) {
        break;
    }}
    if(isset($term_object->term_id))
    {
$l_term_id = $term_object->term_id;
$locations = array();
	$wpdb->show_errors();
	$wptermtax = $wpdb->prefix.'term_taxonomy';
$locations = get_terms(array('taxonomy' => 'locations', 'hide_empty' => false, 'parent' => 0));
foreach($locations as $key=>$term){
  if($term->term_id == $l_term_id){
    if($key!=$refresh_id){
       if($loc_name == 'shop'){
       header("Refresh:0");
       }
    }
    setcookie("wcmlim_selected_location", $key, time() + (86400 * $cookieindays), "/");
    setcookie("wcmlim_nearby_location", $key, time() + (86400 * $cookieindays), "/");
  }
  }
}
}
//shop_page_location_meta_fixes_start
//shop_page_location_meta_fixes_start
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wcmlim-activator.php
 */
function wcmlim_activate()
{

  /**
   * Check if WooCommerce is active
   **/
  $locationCookieTime = get_option('wcmlim_set_location_cookie_time');
  if($locationCookieTime == ''){
   update_option('wcmlim_set_location_cookie_time', '30');
  }
  if (
    !in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ||  is_array(get_site_option('active_sitewide_plugins')) && !array_key_exists('woocommerce/woocommerce.php', get_site_option('active_sitewide_plugins'))
  ) {
    // Deactivate the plugin
    deactivate_plugins(__FILE__);
    // Throw an error in the wordpress admin console
    $error_message = esc_html_e('WooCommerce has not yet been installed or activated. WooCommerce Multi Locations Inventory Management is a WooCommerce Extension that will only function if WooCommerce is installed. Please first install and activate the WooCommerce Plugin.', 'wcmlim');
    wp_die($error_message, 'Plugin dependency check', array('back_link' => true));
  } else {
    require_once plugin_dir_path(__FILE__) . 'includes/class-wcmlim-activator.php';
    Wcmlim_Activator::activate();
  }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wcmlim-deactivator.php
 */
function wcmlim_deactivate()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-wcmlim-deactivator.php';
  Wcmlim_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'wcmlim_activate');
register_deactivation_hook(__FILE__, 'wcmlim_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wcmlim.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wcmlim_run()
{
  $plugin = new Wcmlim();
  $plugin->run();
}

wcmlim_run();
