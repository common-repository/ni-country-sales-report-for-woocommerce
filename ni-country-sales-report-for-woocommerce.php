<?php
/*
Plugin Name: Country Sales Report For WooCommerce
Description: Ni Country Sales Report For WooCommerce provides country wise sales reports and country product wise sales reports.
Author: anzia
Version: 1.1.0
Author URI: http://naziinfotech.com/
Plugin URI: https://wordpress.org/plugins/ni-country-sales-report-for-woocommerce
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Text Domain: nioacowfw
Domain Path: /languages/
Requires at least: 4.7
Tested up to: 6.5.2
WC requires at least: 3.0.0
WC tested up to: 8.8.2
Last Updated Date: 29-April-2024
Requires PHP: 7.0
 
*/
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Ni_Country_Sales_Report_For_WooCommerce')){	
	class Ni_Country_Sales_Report_For_WooCommerce{
		
	  public $nicsrfwoo_constant = array(); // Declaring the property within the class
      
		public function __construct(){
			$this->nicsrfwoo_constant = array();
			
			$this->nicsrfwoo_constant['__FILE__'] = __FILE__;
			$this->nicsrfwoo_constant['plugin_dir_url'] = plugin_dir_url( __FILE__ );
			$this->nicsrfwoo_constant['manage_options'] = 'manage_options';
			$this->nicsrfwoo_constant['menu_name'] = 'nioacowfw-dashboard';
			$this->nicsrfwoo_constant['menu_icon'] = 'dashicons-media-document';
			add_action('plugins_loaded', array($this, 'plugins_loaded'));
			add_action('admin_notices', array($this, 'nioacowfw_check_woocommece_active'));

		}
		function plugins_loaded(){
			require_once("includes/nicsrfwoo-init.php");
			$obj = new NICSRFWoo_Init($this->nicsrfwoo_constant);
			
		
			
		}
		function nioacowfw_check_woocommece_active(){
			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				esc_html_e( "<div class='error'><p><strong>Ni Country Sales Report For WooCommerce</strong> requires <strong> WooCommerce active plugin</strong> </p></div>");
			}
		}
		
	
	}/*End Class*/
}/*End Class Check*/

$obj = new Ni_Country_Sales_Report_For_WooCommerce();


