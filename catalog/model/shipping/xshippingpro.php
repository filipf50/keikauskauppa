<?php
class ModelShippingXshippingpro extends Model {
	function getQuote($address) {
	
		$this->load->language('shipping/xshippingpro');
		$this->load->model('catalog/product');
		
		$language_id=$this->config->get('config_language_id');
	
		$method_data = array();
	    $quote_data = array();
		$sort_data = array();
	    
		$xshippingpro=$this->config->get('xshippingpro');
		if($xshippingpro)
		$xshippingpro=unserialize($xshippingpro);
		
		if(!isset($xshippingpro['name']))$xshippingpro['name']=array();
		if(!is_array($xshippingpro['name']))$xshippingpro['name']=array();
			
        foreach($xshippingpro['name'] as $no_of_tab=>$names){
		    
			
	   	 
			 if(!isset($xshippingpro['customer_group'][$no_of_tab]))$xshippingpro['customer_group'][$no_of_tab]=array();
			 if(!isset($xshippingpro['geo_zone_id'][$no_of_tab]))$xshippingpro['geo_zone_id'][$no_of_tab]=array();
			 if(!isset($xshippingpro['product_category'][$no_of_tab]))$xshippingpro['product_category'][$no_of_tab]=array();
			 if(!is_array($xshippingpro['customer_group'][$no_of_tab]))$xshippingpro['customer_group'][$no_of_tab]=array();
			 if(!is_array($xshippingpro['geo_zone_id'][$no_of_tab]))$xshippingpro['geo_zone_id'][$no_of_tab]=array();
			 if(!is_array($xshippingpro['product_category'][$no_of_tab]))$xshippingpro['product_category'][$no_of_tab]=array();
			 
			 if(!isset($xshippingpro['customer_group_all'][$no_of_tab]))$xshippingpro['customer_group_all'][$no_of_tab]='';
			 if(!isset($xshippingpro['geo_zone_all'][$no_of_tab]))$xshippingpro['geo_zone_all'][$no_of_tab]='';
			 
			  if(!isset($xshippingpro['desc'][$no_of_tab]))$xshippingpro['desc'][$no_of_tab]=array();
		      if(!is_array($xshippingpro['desc'][$no_of_tab]))$xshippingpro['desc'][$no_of_tab]=array();
			  
			  if(!isset($xshippingpro['desc'][$no_of_tab][$language_id]) || !$xshippingpro['desc'][$no_of_tab][$language_id])$xshippingpro['desc'][$no_of_tab][$language_id]='';
			 
			  if(!isset($xshippingpro['inc_weight'][$no_of_tab]))$xshippingpro['inc_weight'][$no_of_tab]='';
				
				$status = true;
				
				if($xshippingpro['geo_zone_id'][$no_of_tab] && $xshippingpro['geo_zone_all'][$no_of_tab]!=1){
				   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id in (" . implode(',',$xshippingpro['geo_zone_id'][$no_of_tab]) . ") AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");         }
                
				if($xshippingpro['geo_zone_all'][$no_of_tab]!=1){
				  if ($xshippingpro['geo_zone_id'][$no_of_tab] && $query->num_rows==0) {
					$status = false;
				  } 
				}
				
				if (!$xshippingpro['status'][$no_of_tab]) {
				  $status = false;
				}
				

				if(!isset($names[$language_id]) || !$names[$language_id]){
				  $status = false;
				}
				
                
				if($xshippingpro['order_total_end'][$no_of_tab]>0){
				    
					 if ($this->cart->getSubTotal() < $xshippingpro['order_total_start'][$no_of_tab] || $this->cart->getSubTotal() > $xshippingpro['order_total_end'][$no_of_tab]) {
					   $status = false;
					 }
					 
				}
				
				if($xshippingpro['weight_end'][$no_of_tab]>0){
				    
					 if ($this->cart->getWeight() < $xshippingpro['weight_start'][$no_of_tab] || $this->cart->getWeight() > $xshippingpro['weight_end'][$no_of_tab])           {
					   $status = false;
					 }
				}
				
				
				if ($this->customer->isLogged()) {
					 $customer_group_id = $this->customer->getCustomerGroupId();
				 } else {
					 $customer_group_id = $this->config->get('config_customer_group_id');
				 }
				 
				if ($xshippingpro['customer_group'][$no_of_tab] && !in_array($customer_group_id,$xshippingpro['customer_group'][$no_of_tab]) && $xshippingpro['customer_group_all'][$no_of_tab]!=1) {
				   $status = false; 
				}
				
				/*category checking*/
				if ($xshippingpro['category'][$no_of_tab]==2){
				    
					foreach($this->cart->getProducts() as $product){
					     $product_categories=$this->model_catalog_product->getCategories($product['product_id']);
						 if($product_categories){
						 
						     $cart_categories=array();
						     foreach($product_categories as $category){
								$cart_categories[]=$category['category_id'];  
							 }
							
					          if(!array_intersect($cart_categories,$xshippingpro['product_category'][$no_of_tab])) $status = false; 
						   
						 }
					} 
				}
				
				if ($xshippingpro['category'][$no_of_tab]==3){
				    
					$is_found=false;
					
					foreach($this->cart->getProducts() as $product){
					     $product_categories=$this->model_catalog_product->getCategories($product['product_id']);
						 if($product_categories){
						     $cart_categories=array();
						     foreach($product_categories as $category){
								$cart_categories[]=$category['category_id'];  
							 } 
						 }
						 
						 if(array_intersect($cart_categories,$xshippingpro['product_category'][$no_of_tab])) { $is_found = true; break; }
					} 
	
					if(!$is_found) $status = false;
				}
				
				/*End of category checking*/
			
			    if($xshippingpro['inc_weight'][$no_of_tab]==1 && $this->cart->getWeight()>0){
				  $names[$language_id].=' ('.$this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point')).')';
				}
				
				
				$method_desc=($xshippingpro['desc'][$no_of_tab][$language_id])?'<br /><span style="color: #999999;font-size: 11px;" class="x-shipping-desc">'.$xshippingpro['desc'][$no_of_tab][$language_id].'</span>':'';
				
				if ($status) {
					$quote_data['xshippingpro'.$no_of_tab] = array(
						'code'         => 'xshippingpro'.'.xshippingpro'.$no_of_tab,
						'title'        => $names[$language_id].$method_desc,
						'cost'         => $xshippingpro['cost'][$no_of_tab],
						'tax_class_id' => $xshippingpro['tax_class_id'][$no_of_tab],
						'text'         => $this->currency->format($this->tax->calculate($xshippingpro['cost'][$no_of_tab], $xshippingpro['tax_class_id'][$no_of_tab], $this->config->get('config_tax')))
					);
		          $sort_data[$no_of_tab]=intval($xshippingpro['sort_order'][$no_of_tab]);
					
				}
			}
			
			$new_quote_data=array();
			if($sort_data){
			   asort($sort_data);
			   foreach($sort_data as $no_of_tab=>$sort_order){
			       $new_quote_data['xshippingpro'.$no_of_tab]=$quote_data['xshippingpro'.$no_of_tab];
			   }
			}
			
			$method_data = array(
				'code'       => 'xshippingpro',
				'title'      => $this->language->get('text_title'),
				'quote'      => $new_quote_data,
				'sort_order' => $this->config->get('xshippingpro_sort_order'),
				'error'      => ''
			);	
		
	
		return $method_data;
	}
}
?>