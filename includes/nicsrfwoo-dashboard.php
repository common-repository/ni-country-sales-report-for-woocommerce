<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('NICSRFWoo_Dashboard')){	
	class NICSRFWoo_Dashboard{
		var $nicsrfwoo_constant = array();  
		public function __construct($nicsrfwoo_constant = array()){
			$this->nicsrfwoo_constant = $nicsrfwoo_constant;
			
		}
		function page_init(){
			
			$rows = $this->get_query();
			$this->get_billing_country_map($rows);
			
			//$this->print_array($rows );
			
			?>
            <div class="container-fluid">
            	<div id="nicsrfwoo" >
                
                	
                
                
                    <div class="row">
             	<div class="col">
                	<div class="card" style="max-width:99%">
                      <div class="card-body">
                      <h5> We will develop a <span class="text-success" style="font-size:26px;">New</span> WordPress and WooCommerce <span class="text-success" style="font-size:26px;">plugin</span> and customize or modify  the <span class="text-success" style="font-size:26px;">existing</span> plugin, if yourequire any <span class="text-success" style="font-size:26px;"> customization</span>  in WordPress and WooCommerce then please <span class="text-success" style="font-size:26px;">contact us</span> at: <a href="mailto:support@naziinfotech.com">support@naziinfotech.com</a>.</h5>
                      
                      	<h3 style="padding-top:30px">For more analytics reports, please visit <a href="http://naziinfotech.com/product/ni-woocommerce-sales-report-pro/" target="_blank">Ni WooCommerce Sales Report Pro</a>.</h3>
                      
                      </div>
                    </div>
                </div>
            </div>
                
                    <div class="row">
                        <div class="col">
                            <div class="card" style="max-width:99%">
                              <div class="card-header bd-indigo-400">
                                <?php esc_html_e("Countries ","nicsrfwoo"); ?>
                              </div>
                              <div class="card-body">
                                <div id="country_box" class="row text-center">
                                    <?php foreach($rows as  $key=>$value): ?>
                                        <div class="col-md-2 _country" style="padding-bottom:10px">
                                        <div class="counter"> <i class="fa fa-code fa-2x"></i>
                                            <h2 class="timer count-title count-number" data-code="<?php esc_html_e( $value->billing_country); ?>" data-to="<?php echo intval($value->order_total) ; ?>" data-speed="1500"><?php echo wc_price(intval($value->order_total)); ?></h2>
                                            <p class="count-text "><?php esc_html_e($value->country_name); ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
            	</div>
            </div>
            
           
            
            <?php
			
		}
		function ajax_init(){
		}
		function get_query(){
			global $wpdb;
			$query = "
				SELECT 
				billing_country.meta_value as 'billing_country'
				,ROUND(SUM(order_total.meta_value),2) as 'order_total'
				,count(*) as 'order_count'
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
			$query .= " AND order_total.meta_key ='_order_total' ";
			$query .= " AND billing_country.meta_key ='_billing_country' ";
			$query .= " GROUP BY billing_country.meta_value";
			
			$query .= " Order BY  billing_country.meta_value asc";	
			$rows = $wpdb->get_results( $query);
			
			return $rows;		
		}
		function get_billing_country_map($rows = array()){
			
			//$rows = $this->get_query();		
			
			$countries = $this->get_countries();
			
			foreach($rows as $key=>$value){
				$rows[$key]->country_name = isset($countries[$value->billing_country])?$countries[$value->billing_country]:$value->billing_country;
			}
			
			//$this->print_array($rows);
			
			$main_data = array();
			$sub_data = array();
			foreach($rows as $key=>$value){
				$sub_data = array();
				
			
				
				$main_data[$key]["name"] = $value->country_name;
				$main_data[$key]["billing_country"] = $value->billing_country;
				
				$main_data[$key]["color"] = '#'.$this->doNewColor();
				
				$sub_data["title"] =  $value->country_name;
				
				$sub_data["order_total"] =  $value->order_total;
				$sub_data["order_count"] =  $value->order_count;
				$sub_data["id"] =  $value->billing_country;
				
				$main_data[$key]["data"][] = $sub_data;
			}
			?>
            <script type="text/javascript">
            	var JSONMap = <?php echo trim( wp_json_encode($main_data)); ?>;
			
            </script>
            <?php
		
		}
		function get_color(){
			
		}
		function doNewColor(){
		$color = dechex(rand(0x000000, 0xFFFFFF));
		return $color;
		}
		function get_countries(){
			$countries_obj = new WC_Countries();
   			$countries_array = $countries_obj->get_countries();
			
			return  $countries_array ;
		} 
		function print_array($arr){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
		
	}
}