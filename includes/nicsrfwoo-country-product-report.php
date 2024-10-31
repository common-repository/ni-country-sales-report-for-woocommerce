<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('NICSRFWoo_Country_Product_Report')){	
	class NICSRFWoo_Country_Product_Report{
		var $nicsrfwoo_constant = array();  
		public function __construct($nicsrfwoo_constant = array()){
			
		}
		function print_array($arr){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
		function get_countries(){
			$countries_obj = new WC_Countries();
   			$countries_array = $countries_obj->get_countries();
			
			return  $countries_array ;
		} 	
		function page_init(){
		 	$order_days = $this->get_order_days();
			$order_country = $this->get_order_country();
			?>
            <div class="container-fluid">
            	<div id="nicsrfwoo">
                	<div class="row">
                    <div class="col">
                        <div class="card " style="max-width:50%">
                            <div class="card-header bd-indigo-400">
                                <?php esc_html_e("Country Search","nicsrfwoo"); ?>
                            </div>
                            <div class="card-body">
                                <form id="frm_country_report" name="frm_country_report">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="order_days">
                                                <?php  esc_html_e("Select Order Days","nicsrfwoo"); ?>
                                            </label>
                                        </div>
                                        <div class="col-2">
                                            <select id="order_days" name="order_days" class="form-control" >
                                                <?php foreach($order_days as $key=>$value): ?>
                                                    <option value="<?php esc_attr_e($key); ?>">
                                                        <?php  esc_html_e( $value ); ?>
                                                    </option>
                                                    <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="order_country">
                                                <?php  esc_html_e("Order Country","nicsrfwoo"); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <select id="order_country" name="order_country" class="form-control" >
                                                <option value="-1">  <?php  esc_html_e("Select One Country","nicsrfwoo"); ?></option>
												<?php foreach($order_country as $key=>$value): ?>
                                                	
                                                    <option value="<?php esc_attr_e($value->billing_country); ?>">
                                                        <?php  esc_html_e( $value->country_name ); ?>
                                                    </option>
                                                    <?php endforeach;?>
                                            </select>
                                        </div>
                                         <div class="col-2" style="text-align:right">
                                        	<input type="submit" value="<?php  esc_html_e("Search","nicsrfwoo "); ?>" class="btn bd-blue-300  mb-2" />
                                        </div> 
                                    </div>
                                    <div class="row">
                                    	<div  class="col"  style="padding:10px;"></div>
                                    </div>
                                    
                                    <input type="hidden" name="sub_action" id="sub_action" value="product_country_report" />
                                    <input type="hidden" name="action" id="action" value="nicsrfwoo_ajax" />
                                    <input type="hidden" name="call" id="call" value="get_report" />
                                </form>
                                    
                            </div>
                        </div>
                    </div>
                	</div>
            		<div class="row">
                    	<div class="col">
                        	<div class="card " style="max-width:99%">
                                  <div class="card-header bd-indigo-400">
                                    <?php esc_html_e("Country Product","nicsrfwoo"); ?> 
                                    </div>
                                  <div class="card-body">
                                     <div class="_ajax_content"></div>
                                  </div>
                                </div>
                        </div>
                    </div>
            	</div>
            
            </div>
            
            <?php
			
		}
		function get_product_query(){
			global $wpdb;
			
			$today = date_i18n("Y-m-d");
			
			$order_days = sanitize_text_field(isset($_REQUEST["order_days"])?$_REQUEST["order_days"]:'today');
			$order_country = sanitize_text_field(isset($_REQUEST["order_country"])?$_REQUEST["order_country"]:'-1');
			
			$order_by = sanitize_text_field(isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:'billing_country');
			$sort = sanitize_text_field(isset($_REQUEST["sort"])?$_REQUEST["sort"]:'asc');
			
			$query = "
				SELECT 
			
				
				product_id.meta_value as product_id
				,variation_id.meta_value as variation_id
				
				
				,woocommerce_order_items.order_item_name as product_name
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";

			
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID ";
			
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=woocommerce_order_items.order_item_id ";
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=woocommerce_order_items.order_item_id ";
			
			
			
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
		
	
			$query .= "	AND woocommerce_order_items.order_item_type ='line_item' ";
			
			$query .= "	AND product_id.meta_key ='_product_id' ";
			$query .= "	AND variation_id.meta_key ='_variation_id' ";
	
			
			
			
			switch ($order_days) {			
			  case "today":
				$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
				break;
			  case "yesterday":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
				break;
			  case "last_7_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_15_days":
					$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_30_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_60_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_90_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 90 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;				
			  default:
					$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
			}

			
			
			$query .= " GROUP BY product_id.meta_value, variation_id.meta_value";
			
			$query .= " Order By woocommerce_order_items.order_item_name  ASC";
			
			$rows = $wpdb->get_results( $query);
			
			return $rows;		
		}
		function get_product_country_query(){
			global $wpdb;
			
			$today = date_i18n("Y-m-d");
			
			$order_days = sanitize_text_field(isset($_REQUEST["order_days"])?$_REQUEST["order_days"]:'today');
			$order_country = sanitize_text_field(isset($_REQUEST["order_country"])?$_REQUEST["order_country"]:'-1');
			
			$order_by = sanitize_text_field(isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:'billing_country');
			$sort = sanitize_text_field(isset($_REQUEST["sort"])?$_REQUEST["sort"]:'asc');
			
			$query = "
				SELECT 
				billing_country.meta_value as 'billing_country'
				
				,product_id.meta_value as product_id
				,variation_id.meta_value as variation_id
				,ROUND(SUM(line_total.meta_value),2) as line_total
				
				,woocommerce_order_items.order_item_name as product_name
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID ";
			
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=woocommerce_order_items.order_item_id ";
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=woocommerce_order_items.order_item_id ";
			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=woocommerce_order_items.order_item_id ";
			
			
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
			$query .= " AND order_total.meta_key ='_order_total' ";
			$query .= " AND billing_country.meta_key ='_billing_country' ";
			$query .= "	AND woocommerce_order_items.order_item_type ='line_item' ";
			
			$query .= "	AND product_id.meta_key ='_product_id' ";
			$query .= "	AND variation_id.meta_key ='_variation_id' ";
			$query .= "	AND line_total.meta_key ='_line_total' ";
			
			if ($order_country !=='-1'){
				$query .= " AND billing_country.meta_value IN ('". $order_country ."') ";
			}
			
			switch ($order_days) {			
			  case "today":
				$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
				break;
			  case "yesterday":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
				break;
			  case "last_7_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_15_days":
					$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_30_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_60_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_90_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 90 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;				
			  default:
					$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
			}

			
			
			$query .= " GROUP BY billing_country.meta_value ,product_id.meta_value, variation_id.meta_value";
			
			switch ($order_by) {
				case "billing_country":
					$query .= " Order BY  billing_country.meta_value " .$sort;	
				break;
				case "order_total":
					$query .= " Order BY  order_total " .$sort;	
				break;
				case "order_count":
					$query .= " Order BY  order_count " .$sort;	
				break;
				 default:
					$query .= " Order BY  order_total ".$sort;	
			}
			
	     
			
			
			$rows = $wpdb->get_results( $query);
			
			return $rows;
			$countries = $this->get_countries();
			
			foreach($rows as $key=>$value){
				$rows[$key]->country_name = $countries[$value->billing_country];
			}
			$product_data = array();
			foreach($rows as $key=>$value){
				$new_key = 	$value->billing_country."_".$value->product_id."_".$value->variation_id;
				$product_data[$new_key ] = $value;
			}
			
			return $product_data;		
		}
		function get_country_query(){
			global $wpdb;
			
			$today = date_i18n("Y-m-d");
			
			$order_days = sanitize_text_field(isset($_REQUEST["order_days"])?$_REQUEST["order_days"]:'today');
			$order_country = sanitize_text_field(isset($_REQUEST["order_country"])?$_REQUEST["order_country"]:'-1');
			
			$order_by = sanitize_text_field(isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:'billing_country');
			$sort = sanitize_text_field(isset($_REQUEST["sort"])?$_REQUEST["sort"]:'asc');
			
			$query = "
				SELECT 
				billing_country.meta_value as 'billing_country'
				
			
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
		
			$query .= " AND billing_country.meta_key ='_billing_country' ";
		
			
		
			
			if ($order_country !=='-1'){
				$query .= " AND billing_country.meta_value IN ('". $order_country ."') ";
			}
			
			switch ($order_days) {			
			  case "today":
				$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
				break;
			  case "yesterday":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
				break;
			  case "last_7_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_15_days":
					$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			  case "last_30_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_60_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			 case "last_90_days":
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 90 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;				
			  default:
					$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
			}

			
			
			$query .= " GROUP BY billing_country.meta_value ";
			$query .= " Order BY billing_country.meta_value ASC ";
			
	     
			$rows = $wpdb->get_results( $query);
			$countries = $this->get_countries();
			foreach($rows as $key=>$value){
				$rows[$key]->country_name = isset($countries[$value->billing_country])?$countries[$value->billing_country]:$value->billing_country . "(". $value->billing_country .")";
			}
			 
			return $rows;		
		}
		function get_order_country(){
				global $wpdb;
			$query = "
				SELECT 
				billing_country.meta_value as 'billing_country'
				
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
			$query .= " AND billing_country.meta_key ='_billing_country' ";
			$query .= " GROUP BY billing_country.meta_value";
			
			$query .= " Order BY billing_country.meta_value ASC";	
			
			//$query = $wpdb->prepare($query );
			$rows = $wpdb->get_results( $query);
			
			
			
			$countries = $this->get_countries();
			
			foreach($rows as $key=>$value){
				$rows[$key]->country_name =  isset($countries[$value->billing_country])?$countries[$value->billing_country]:$value->billing_country;
			}
			
			return $rows;
		}
		function get_order_days(){
			$order_days = array();
			$order_days["today"] = esc_html__("Today","nicsrfwoo");
			$order_days["yesterday"] = esc_html__("Yesterday","nicsrfwoo");
			$order_days["last_7_days"] = esc_html__("Last 7 Days","nicsrfwoo");
			$order_days["last_15_days"] = esc_html__("Last 15 Days","nicsrfwoo");
			$order_days["last_30_days"] = esc_html__("Last 30 Days","nicsrfwoo");
			$order_days["last_60_days"] = esc_html__("Last 60 Days","nicsrfwoo");
			$order_days["last_90_days"] = esc_html__("Last 90 Days","nicsrfwoo");
			return $order_days;
		}
		function ajax_init(){
			$call = sanitize_text_field(isset($_REQUEST["call"])?$_REQUEST["call"]:'');
			if ($call =='get_report'){
				$this->get_report();
				die;
			}
			
			
			
		}
		function get_report(){
			$product_rows 			= $this->get_product_query();
			$country_rows 			= $this->get_product_country_query();
			$country				= $this->get_country_query();
		
			$cd = array();
			foreach($country_rows as $key => $c){
				$cd[$c->billing_country.'_'.$c->product_id.'_'.$c->variation_id] = $c->line_total;
			}
			
			
			foreach($product_rows as $key => $c){
				$variation_id = $c->variation_id;
				$product_id = $c->product_id;
				
				foreach($country_rows  as $country_key=>$country_value):
						$country_code = $country_value->billing_country;
						$new_key = $country_code.'_'.$product_id.'_'.$variation_id;						
						//$product_rows[$key]->{$country_code} = isset($c[$new_key]) ? $c[$new_key] : 0;						
						$product_rows[$key]->$new_key = isset($cd[$new_key]) ? $cd[$new_key] : 0;	
							
				endforeach;
			}
			
			
			if (count($country_rows) ==0 ){
				 esc_html_e("no record found","nicsrfwoo") ;
			return '';	
			}
			?>
            <table class="table table-bordered">
            	<thead>
                	<tr>
                
                	<th><?php  esc_html_e("Product Name/Country Name","nicsrfwoo") ?></th>
                	<?php foreach($country  as $country_key=>$country_value): ?>
                    	
                        <th  style="text-align:right"><?php esc_html_e( $country_value->country_name); ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
              
                
                <?php foreach($product_rows  as $product_key=>$product_value):
					 ?>
                	<tr>
                    	<td><?php esc_html_e( $product_value->product_name); ?></td>
                    	<?php foreach($country  as $country_key=>$country_value): ?>
                    		<td   style="text-align:right"> 
							<?php 
								$new_key = 	$country_value->billing_country."_".$product_value->product_id."_".$product_value->variation_id;
								echo wc_price(intval(isset($product_value->$new_key)?$product_value->$new_key:0));
							
							 ?>
                            
                             </td>
                    	<?php endforeach; ?>
                    </tr>
				<?php endforeach; ?>
                  </tbody>
            </table>
            <?php
				
		}

	}
}