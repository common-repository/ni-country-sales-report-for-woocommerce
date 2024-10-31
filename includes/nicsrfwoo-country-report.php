<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('NICSRFWoo_Country_Report')){	
	class NICSRFWoo_Country_Report{
		var $nicsrfwoo_constant = array();  
		public function __construct($nicsrfwoo_constant = array()){
			
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
                                    </div>
                                    <div class="row">
                                    	<div  class="col"  style="padding:10px;"></div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-3">
                                        	<label for="order_days">
                                                <?php  esc_html_e("Order By","nicsrfwoo"); ?>
                                            </label>
                                        </div>
                                        <div class="col-2">
                                        	<select id="order_by" name="order_by">
                                            	<option value="billing_country"> <?php  esc_html_e("Billing Country","nicsrfwoo"); ?></option>
                                                <option value="order_total"> <?php  esc_html_e("Order Total","nicsrfwoo"); ?></option>
                                                <option value="order_count"> <?php  esc_html_e("Order Count","nicsrfwoo"); ?></option>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">
                                        	<label for="sort">
                                                <?php  esc_html_e("Sort","nicsrfwoo"); ?>
                                            </label>
                                        </div>
                                        <div class="col-2">
                                        	<select id="sort" name="sort">
                                                <option value="asc"> <?php  esc_html_e("ASC","nicsrfwoo"); ?></option>
                                                <option value="desc"> <?php  esc_html_e("DESC","nicsrfwoo"); ?></option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-2" style="text-align:right">
                                        	<input type="submit" value="<?php  esc_html_e("Search","nicsrfwoo "); ?>" class="btn bd-blue-300  mb-2" />
                                        </div> 
                                    </div>
                                    <input type="hidden" name="sub_action" id="sub_action" value="country_report" />
                                    <input type="hidden" name="action" id="action" value="nicsrfwoo_ajax" />
                                    <input type="hidden" name="call" id="call" value="get_report" />
                                </form>
                                    
                            </div>
                        </div>
                    </div>
                	</div>
                	
                    
                    <div class="row" style="padding-top:20px;">
                    	<div class="col">
                        	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?php esc_html_e("Country Table","nicsrfwoo"); ?></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><?php esc_html_e("Country Bar Chart","nicsrfwoo"); ?></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><?php esc_html_e("Country Pie Chart","nicsrfwoo"); ?></button>
                          </li>
                        </ul>
                        	<div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row" style="padding-top:20px;">
                                <div class="col">
                                    <div class="_ajax_content"></div>
                                </div>
                              </div>
                          </div>
                          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                              <div class="row" style="padding-top:20px;">
                                <div class="col">
                                   <div class="card " style="max-width:99%">
                                  <div class="card-header bd-indigo-400">
                                    <?php esc_html_e("Country Bar Chart","nicsrfwoo"); ?> 
                                    </div>
                                  <div class="card-body">
                                     <div class="chartreport"  >
                                     	<canvas style="height:500px" id="myChart" height="500" ></canvas>
                                     </div>
                                     
                                  </div>
                                </div>
                                </div>
                       		 </div>
                          </div>
                          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                          	<div class="card " style="max-width:99%">
                              <div class="card-header bd-indigo-400">
							  	<?php esc_html_e("Country Pie Chart","nicsrfwoo"); ?> 
                                </div>
                              <div class="card-body">
                               		<div class="chartreport_pie"  >
                                     	<canvas style="height:500px" id="myChart_pie" height="500" ></canvas>
                                 	</div>
                                
                              </div>
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
			$call = sanitize_text_field(isset($_REQUEST["call"])?$_REQUEST["call"]:'');
			if ($call =='get_report'){
				$this->get_report();
				die;
			}
			if ($call =='get_detail_report'){
				$this->get_detail_report();
				die;
			}
			
			
		}
		function get_query(){
			global $wpdb;
			
			$today = date_i18n("Y-m-d");
			
			$order_days = sanitize_text_field(isset($_REQUEST["order_days"])?$_REQUEST["order_days"]:'today');
			$order_country = sanitize_text_field(isset($_REQUEST["order_country"])?$_REQUEST["order_country"]:'-1');
			
			$order_by = sanitize_text_field(isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:'billing_country');
			$sort = sanitize_text_field(isset($_REQUEST["sort"])?$_REQUEST["sort"]:'asc');
			
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

			
			
			$query .= " GROUP BY billing_country.meta_value";
			
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
			$countries = $this->get_countries();
			
			foreach($rows as $key=>$value){
				$rows[$key]->country_name =isset($countries[$value->billing_country])?$countries[$value->billing_country]:$value->billing_country;
			}
		
			?>
            <script type="text/javascript">
             CountryJSON = <?php echo trim( wp_json_encode( $rows ) );  ?>;
			 
			console.log(CountryJSON);
			 
		    </script>
            <?php
			return $rows;		
		}
		function get_detail_report(){
			
	
			
			global $wpdb;
			$rows = array();
			$today = date_i18n("Y-m-d");
			$order_days = sanitize_text_field(isset($_REQUEST["order_days"])?$_REQUEST["order_days"]:'');
			$country_code = sanitize_text_field(isset($_REQUEST["country_code"])?$_REQUEST["country_code"]:'');
			
			
			
			$query = "
				SELECT 
				posts.ID as order_id
				,posts.post_status as order_status
				,posts.post_date as post_date 
				,billing_country.meta_value as 'billing_country'
				
				,billing_email.meta_value as 'billing_email'
				,billing_last_name.meta_value as 'billing_last_name'
				,billing_first_name.meta_value as 'billing_first_name'
				
				,ROUND(order_total.meta_value,2) as 'order_total'
			
				FROM {$wpdb->prefix}posts as posts	";	
				
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_email ON billing_email.post_id=posts.ID ";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_last_name ON billing_last_name.post_id=posts.ID ";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_first_name ON billing_first_name.post_id=posts.ID ";
			
			$query .= " WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order' ";
			$query .= " AND order_total.meta_key ='_order_total' ";
			$query .= " AND billing_country.meta_key ='_billing_country' ";
			
			$query .= " AND billing_email.meta_key ='_billing_email' ";
			$query .= " AND billing_last_name.meta_key ='_billing_last_name' ";
			$query .= " AND billing_first_name.meta_key ='_billing_first_name' ";
			
			$query .= " AND billing_country.meta_value IN ('". $country_code ."') ";
			
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
			
			$query .= " Order BY   posts.post_date  DESC ";
			
	
			
			//$query = $wpdb->prepare($query );
			
			$rows = $wpdb->get_results( $query);
				
			$columns  =  $this->get_detail_columns();
			
				
			?>
            <table class="table table-bordered">
            	<thead>
                	<tr class="bd-indigo-400">
                	<?php foreach($columns as $key=>$value): ?>
                    	
                        <?php switch($key): case 1: break; ?>
                         	<?php case "order_total": ?>
                            <?php case "order_count": ?>
                             <th style="text-align:right"><?php  esc_html_e( $value); ?></th>
                         	<?php break; ?>
                            <?php default; ?>
                              <th><?php  esc_html_e( $value); ?></th>
                        <?php endswitch; ?>  
                    <?php endforeach; ?>
                	</tr>
                </thead>
                <tbody>
                <?php if (count($rows ) ===0): ?>
                <tr>
                	<td colspan="<?php echo  intval(count($columns )); ?>"><?php esc_html_e("No record found","nicsrfwoo"); ?></td>
                </tr>
                <?php return; ?>
                <?php endif;?>
                
                	<?php foreach($rows as $row_key=>$row_value): ?>
                    <?php $td_class = ""; ?>
                    	<tr>
						<?php foreach($columns  as $col_key=>$col_value): ?>
                            <?php switch($col_key): case 1: break; ?>
                            
								<?php case "order_total": ?>
                                <?php $td_class = "style=\"text-align:right\""; ?>
                                <?php $td_vale = esc_html__(isset($row_value->$col_key)?$row_value->$col_key:""); ?>
                                <?php $td_vale = wc_price( intval($td_vale ));   ?>
                                 <td style="text-align:right"><?php echo  $td_vale ;  ?></td>
                                <?php break; ?>
                                
                                 <?php case "order_status": ?>
								<?php $td_vale =   esc_html__( ucfirst ( str_replace("wc-","", $row_value->order_status)));   ?>
                                 <td><?php echo  $td_vale ;  ?></td>
                                <?php break; ?>
                                
                              
                                <?php default; ?>
                                 <?php $td_vale =  esc_html__( isset($row_value->$col_key)?$row_value->$col_key:""); ?>
                                  <td><?php echo  $td_vale ;  ?></td>
                            <?php endswitch; ?>
                           
                        <?php endforeach; ?>
                   
               		 </tr>
					<?php endforeach; ?>
                </tbody>
            </table>
            
            <?php
			
			die;
		}
		function get_order_detail($order_id){
			$order_detail	= get_post_meta($order_id);
			$order_detail_array = array();
			foreach($order_detail as $k => $v)
			{
				$k =substr($k,1);
				$order_detail_array[$k] =$v[0];
			}
			return 	$order_detail_array;
		}
		function allow_tagsget_allow_tags(){
		 $args = array(
				//formatting
				'strong' => array(),
				'em'     => array(),
				'b'      => array(),
				'i'      => array(),
			
				//links
				'a'     => array(
					'href' => array()
				),
				
			);	
			
			 $args['a']['data-*'] = true;
			 $args['a']['class'] = true;
			 
			 
			 return   $args;
			
		}
		function get_report(){
			$rows  = $this->get_query();
			$allow_tags = $this->allow_tagsget_allow_tags();
			$columns  =  $this->get_columns();
			?>
           <table class="table table-bordered">
            	<thead>
                	<tr class="bd-indigo-400">
                	<?php foreach($columns as $key=>$value): ?>
                    	
                        <?php switch($key): case 1: break; ?>
                         	<?php case "order_total": ?>
                            <?php case "order_count": ?>
                             <th style="text-align:right"><?php  esc_html_e( $value); ?></th>
                         	<?php break; ?>
                            <?php default; ?>
                              <th><?php  esc_html_e( $value); ?></th>
                        <?php endswitch; ?>  
                    <?php endforeach; ?>
                	</tr>
                </thead>
                <tbody>
                <?php if (intval(count($rows )) ===0): ?>
                <tr>
                	<td colspan="<?php echo intval( count($columns )); ?>"><?php esc_html_e("No record found","nicsrfwoo"); ?></td>
                </tr>
                <?php return; ?>
                <?php endif;?>
                
                	<?php foreach($rows as $row_key=>$row_value): ?>
                    <?php $td_class = ""; ?>
                    	<tr>
						<?php foreach($columns  as $col_key=>$col_value): ?>
                            <?php switch($col_key): case 1: break; ?>
                            
                                <?php case "country_name": ?>
                                	<?php $country_name = sanitize_text_field(isset($row_value->$col_key)?$row_value->$col_key:""); ?>
                                    <?php $country_code = sanitize_text_field(isset($row_value->billing_country)?$row_value->billing_country:""); ?>
                                    <?php $td_vale  = ' <a class="_show_detail" href="#" data-country-code="' . esc_attr( $country_code ). '"  data-country-name="' .esc_attr( $country_name) . '" >' . wp_kses_post($country_name ). '</a>'; ?>         
                                    
                                    <td <?php esc_attr_e($td_class); ?>><?php  echo  wp_kses($td_vale,$allow_tags);  ?></td>
                                 <?php break; ?>
								
								<?php case "order_total": ?>
                                <?php $td_vale = esc_html__( isset($row_value->$col_key)?$row_value->$col_key:""); ?>
                                <?php $td_vale = wc_price(intval($td_vale) );   ?>
                                <td style="text-align:right" ><?php  echo ( $td_vale);  ?></td>
                                <?php break; ?>
                                
                                <?php case "order_count": ?>
                             
                                <?php $td_vale = isset($row_value->$col_key)?$row_value->$col_key:""; ?>
                                <?php $td_vale = intval($td_vale) ;   ?>
                                <td style="text-align:right" ><?php  echo $td_vale;  ?></td>
                                <?php break; ?>
                              
                                <?php default; ?>
                                 <?php $td_vale = esc_html_e( isset($row_value->$col_key)?$row_value->$col_key:""); ?>
                                 <td><?php  echo $td_vale;  ?></td>
                            <?php endswitch; ?>
                             
                            
                        <?php endforeach; ?>
                   
               		 </tr>
					<?php endforeach; ?>
                </tbody>
            </table>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="btn_show_detail" data-bs-target="#staticBackdrop" style="display:none">
              Launch static backdrop modal
            </button>



            <?php
		}
		
		function get_columns(){
			$columns = array();
			$columns["country_name"] =	esc_html__("Country Name ","nicsrfwoo");
			$columns["order_total"] = 	esc_html__("Order Total ","nicsrfwoo");
			$columns["order_count"] = 	esc_html__("Order Count ","nicsrfwoo");
			return $columns;
		}
		function get_detail_columns(){
			$columns = array();
			$columns["order_id"] 			=	esc_html__("#ID","nicsrfwoo");
			$columns["post_date"] 			= 	esc_html__("Order Date","nicsrfwoo");
			$columns["order_status"] 		= 	esc_html__("Order Status","nicsrfwoo");
			$columns["billing_last_name"] 	= 	esc_html__("Billing Last Name","nicsrfwoo");
			$columns["billing_first_name"] 	= 	esc_html__("Billing First Name","nicsrfwoo");
			$columns["billing_email"] 		= 	esc_html__("Billing Email","nicsrfwoo");
			$columns["order_total"] 		=   esc_html__("Order Total","nicsrfwoo");
			
			return $columns;
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
				$rows[$key]->country_name = isset($countries[$value->billing_country])?$countries[$value->billing_country]:$value->billing_country;
			}
			
			return $rows;
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