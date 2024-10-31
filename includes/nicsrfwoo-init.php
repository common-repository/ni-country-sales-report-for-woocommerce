<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('NICSRFWoo_Init')){	
	class NICSRFWoo_Init{
		var $nicsrfwoo_constant = array();  
		public function __construct($nicsrfwoo_constant = array()){
			
			$this->nicsrfwoo_constant = $nicsrfwoo_constant;
			
			add_action( 'admin_menu',  array(&$this,'admin_menu' ));
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			add_action( 'wp_ajax_nicsrfwoo_ajax',  array(&$this,'nicsrfwoo_ajax' )); /*used in form field name="action" value="my_action"*/
			
			add_action( 'admin_footer', array(&$this,'admin_footer' ), 10, 1 ); 
			
		}
		function admin_menu(){
			add_menu_page(__(  'Country Sales', 'nicsrfwoo')
			,__(  'Country Sales', 'nicsrfwoo')
			,'manage_options'
			,'nicsrfwoo-dashboard'
			,array(&$this,'add_page')
			,'dashicons-chart-pie'
			,62.85);
			
			add_submenu_page('nicsrfwoo-dashboard'
			,__( 'Dashboard', 'nicsrfwoo' )
			,__( 'Dashboard', 'nicsrfwoo' )
			,'manage_options'
			,'nicsrfwoo-dashboard' 
			,array(&$this,'add_page'));
			
		
			add_submenu_page('nicsrfwoo-dashboard'
			,__( 'Country Report', 'nicsrfwoo' )
			,__( 'Country Report', 'nicsrfwoo' )
			, 'manage_options', 'nicsrfwoo-country-report' 
			, array(&$this,'add_page'));
			
			add_submenu_page('nicsrfwoo-dashboard'
			,__( 'Country Product Report', 'nicsrfwoo' )
			,__( 'Country Product Report', 'nicsrfwoo' )
			, 'manage_options', 'nicsrfwoo-country-product-report' 
			, array(&$this,'add_page'));
			
			
		}
		function admin_footer(){
			$page = sanitize_text_field(isset($_REQUEST['page'])?$_REQUEST['page']:'');
			if ($page  == "nicsrfwoo-country-report"){
				?>
                <!-- Vertically centered scrollable modal -->
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="_show_country_detail"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
			}
			
		}
		function admin_enqueue_scripts(){
			$page = sanitize_text_field(isset($_REQUEST['page'])?$_REQUEST['page']:'');
			
			if ($page =='nicsrfwoo-dashboard' || $page  == "nicsrfwoo-country-report" || $page =="nicsrfwoo-country-product-report"){
				
				
				
				if ($page =='nicsrfwoo-dashboard'){
					wp_enqueue_script( 'nicsrfwoo-dashboard-script', plugins_url( '../admin/js/nicsrfwoo-dashboard.js', __FILE__ ), array('jquery') );	
					
				}
				if ($page =='nicsrfwoo-country-report'){
					wp_enqueue_script( 'nicsrfwoo-country-report-script', plugins_url( '../admin/js/nicsrfwoo-country-report.js', __FILE__ ), array('jquery') );	
					
					wp_enqueue_script( 'nicsrfwoo-chart-js-script', plugins_url( '../admin/js/chart.min.js', __FILE__ ), array('jquery') );	
				
					
					
					
				}
				if ($page =='nicsrfwoo-country-product-report'){
					wp_enqueue_script( 'nicsrfwoo-country-report-script', plugins_url( '../admin/js/nicsrfwoo-product-country-report.js', __FILE__ ), array('jquery') );	
				}
				
				
				/*Boostrap*/  
				wp_enqueue_script( 'nicsrfwoo-bootstrap-script', plugins_url( '../admin/js/bootstrap.min.js', __FILE__ ), array('jquery') );
			
				wp_enqueue_style('nicsrfwoo-bootstrap-css',plugins_url( '../admin/css/bootstrap.min.css', __FILE__ ));	
				
				wp_enqueue_style('nicsrfwoo-country-css',plugins_url( '../admin/css/nicsrfwoo-country.css', __FILE__ ));	
				/*End Boostrap*/  
				$currency_symbol = get_woocommerce_currency_symbol();
				$currency_position = get_option("woocommerce_currency_pos");
				wp_enqueue_script( 'nicsrfwoo-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') );	
				wp_localize_script( 'nicsrfwoo-script','nicsrfwoo_ajax_object',array('nicsrfwoo_ajaxurl'=>admin_url('admin-ajax.php'), 'currency_symbol'=>$currency_symbol, 'currency_position'=>$currency_position));
				
				
			}
			
		}
		
		function add_page(){
			$page = sanitize_text_field(isset($_REQUEST['page'])?$_REQUEST['page']:'');
			if ($page =='nicsrfwoo-dashboard'){
				include_once('nicsrfwoo-dashboard.php');
				$obj = new NICSRFWoo_Dashboard();
				$obj->page_init();
				
			}
			if ($page =='nicsrfwoo-country-report'){
				include_once('nicsrfwoo-country-report.php');
				$obj = new NICSRFWoo_Country_Report();
				$obj->page_init();
				
			}
			if ($page =='nicsrfwoo-country-product-report'){
				include_once('nicsrfwoo-country-product-report.php');
				$obj = new NICSRFWoo_Country_Product_Report();
				$obj->page_init();
			}
		}
		function nicsrfwoo_ajax(){
			
			$sub_action = sanitize_text_field(isset($_REQUEST['sub_action'])?$_REQUEST['sub_action']:'');
			if ($sub_action  =='country_report'){
				
				include_once('nicsrfwoo-country-report.php');
				$obj = new NICSRFWoo_Country_Report();
				$obj->ajax_init();
			}
			if ($sub_action  =='product_country_report'){
				
				include_once('nicsrfwoo-country-product-report.php');
				$obj = new NICSRFWoo_Country_Product_Report();
				$obj->ajax_init();
			}
			
			
			
		}
	}
}
?>