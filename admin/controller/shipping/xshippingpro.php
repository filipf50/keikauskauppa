<?php
class ControllerShippingXshippingpro extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/xshippingpro');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$save=array();
			
			$save['xshippingpro_status']=$this->request->post['xshippingpro_status'];
			$save['xshippingpro_sort_order']=$this->request->post['xshippingpro_sort_order'];
			if(isset($this->request->post['xshippingpro']))
			$save['xshippingpro']=serialize($this->request->post['xshippingpro']);
			$this->model_setting_setting->editSetting('xshippingpro', $save);		
			$this->session->data['success'] = $this->language->get('text_success');	
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
			
				
		$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['tab_rate'] = $this->language->get('tab_rate');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_order_total'] = $this->language->get('entry_order_total');
		$this->data['entry_order_weight'] = $this->language->get('entry_order_weight');
		$this->data['entry_to'] = $this->language->get('entry_to');
		$this->data['entry_order_hints'] = $this->language->get('entry_order_hints');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_category_any'] = $this->language->get('text_category_any');
		$this->data['text_category_all'] = $this->language->get('text_category_all');
		$this->data['text_category_least'] = $this->language->get('text_category_least');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_weight_include'] = $this->language->get('entry_weight_include');
		$this->data['entry_desc'] = $this->language->get('entry_desc');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_any'] = $this->language->get('text_any');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/xshippingpro', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/xshippingpro', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$xshippingpro=$this->config->get('xshippingpro');
		if($xshippingpro)
		$xshippingpro=unserialize($xshippingpro);
		
		if(!is_array($xshippingpro))$xshippingpro=array();
		$this->data['xshippingpro'] = $xshippingpro;
		
		$this->data['token']=$this->session->data['token'];
		
		
		 
		 if (isset($this->request->post['xshippingpro_status'])) {
					$this->data['xshippingpro_status'] = $this->request->post['xshippingpro_status'];
				} else {
					$this->data['xshippingpro_status'] = $this->config->get('xshippingpro_status');
				}
		if (isset($this->request->post['xshippingpro_sort_order'])) {
					$this->data['xshippingpro_sort_order'] = $this->request->post['xshippingpro_sort_order'];
				} else {
					$this->data['xshippingpro_sort_order'] = $this->config->get('xshippingpro_sort_order');
				}						

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$customer_groups=array();
		$result=$this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $customer_groups[$row['customer_group_id']]=$row['name'];  
		  }
		}
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['language_id']=$this->config->get('config_language_id');
		
		$this->data['customer_groups'] = $customer_groups;
		
		
		$this->data['form_data']=$this->getFormData();
								
		$this->template = 'shipping/xshippingpro.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/xshippingpro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	private function getFormData()
	{
	   $this->load->model('catalog/category');
	   
	   $return='';
	   if(!isset($this->data['xshippingpro']['name']))$this->data['xshippingpro']['name']=array();
	   if(!is_array($this->data['xshippingpro']['name']))$this->data['xshippingpro']['name']=array();
	   foreach($this->data['xshippingpro']['name'] as $no_of_tab=>$names){
	   	 
		 if(!isset($this->data['xshippingpro']['customer_group'][$no_of_tab]))$this->data['xshippingpro']['customer_group'][$no_of_tab]=array();
		 if(!isset($this->data['xshippingpro']['geo_zone_id'][$no_of_tab]))$this->data['xshippingpro']['geo_zone_id'][$no_of_tab]=array();
		 if(!isset($this->data['xshippingpro']['product_category'][$no_of_tab]))$this->data['xshippingpro']['product_category'][$no_of_tab]=array();
		 if(!is_array($this->data['xshippingpro']['customer_group'][$no_of_tab]))$this->data['xshippingpro']['customer_group'][$no_of_tab]=array();
		 if(!is_array($this->data['xshippingpro']['geo_zone_id'][$no_of_tab]))$this->data['xshippingpro']['geo_zone_id'][$no_of_tab]=array();
		 if(!is_array($this->data['xshippingpro']['product_category'][$no_of_tab]))$this->data['xshippingpro']['product_category'][$no_of_tab]=array();
		 
		 if(!isset($this->data['xshippingpro']['inc_weight'][$no_of_tab]))$this->data['xshippingpro']['inc_weight'][$no_of_tab]='';
		
		 if(!is_array($names))$names=array();
		 
		 if(!isset($this->data['xshippingpro']['desc'][$no_of_tab]))$this->data['xshippingpro']['desc'][$no_of_tab]=array();
		 if(!is_array($this->data['xshippingpro']['desc'][$no_of_tab]))$this->data['xshippingpro']['desc'][$no_of_tab]=array();
		 
		  if(!isset($this->data['xshippingpro']['customer_group_all'][$no_of_tab]))$this->data['xshippingpro']['customer_group_all'][$no_of_tab]='';
		  if(!isset($this->data['xshippingpro']['geo_zone_all'][$no_of_tab]))$this->data['xshippingpro']['geo_zone_all'][$no_of_tab]='';
		 
		 
		
		
		 
		  $return.='<div id="shipping-'.$no_of_tab.'" class="vtabs-content shipping">';
		 
		  $return.='<div class="htabs">';
          foreach ($this->data['languages'] as $language) {
             $return.='<a href="#language'.$language['language_id'].'_'.$no_of_tab.'"><img src="view/image/flags/'.$language['image'].'" title="'.$language['name'].'" /> '.$language['name'].'</a>';
          } 
           $return.='</div>';
		   
		   $inc=0;
		   foreach ($this->data['languages'] as $language) {
		        $lang_cls=($inc==0)?'':'-lang'; $inc++;
			    if(!isset($names[$language['language_id']]) || !$names[$language['language_id']])$names[$language['language_id']]='Untitled Method '.$no_of_tab;     
				if(!isset($this->data['xshippingpro']['desc'][$no_of_tab][$language['language_id']]) || !$this->data['xshippingpro']['desc'][$no_of_tab][$language['language_id']])$this->data['xshippingpro']['desc'][$no_of_tab][$language['language_id']]='';
				
			    $return.='<div id="language'.$language['language_id'].'_'.$no_of_tab.'">'
		            .'<table class="form">'
				  .'<tr>'
					.'<td>'.$this->data['entry_name'].'</td>'
					.'<td><input type="text" class="method-name'.$lang_cls.'" size="45" name="xshippingpro[name]['.$no_of_tab.']['.$language['language_id'].']" value="'.$names[$language['language_id']].'" /></td>'
				  .'</tr>'
				  .'<tr>'
					.'<td>'.$this->data['entry_desc'].'</td>'
					.'<td><input type="text" size="45" name="xshippingpro[desc]['.$no_of_tab.']['.$language['language_id'].']" value="'.$this->data['xshippingpro']['desc'][$no_of_tab][$language['language_id']].'" /></td>'
				  .'</tr>'
				   .'</table>'
		          .'</div>';
			  }	  
				  
			$return.='<table class="form">'
			          .'<tr>'
						.'<td>'.$this->data['entry_weight_include'].'</td>'
						.'<td><input '.(($this->data['xshippingpro']['inc_weight'][$no_of_tab]=='1')?'checked="checked"':'').' type="checkbox" name="xshippingpro[inc_weight]['.$no_of_tab.']" value="1" /></td>'
					  .'</tr>'
			        .'<tr>'
					.'<td>'.$this->data['entry_cost'].'</td>'
					.'<td><input type="text" name="xshippingpro[cost]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['cost'][$no_of_tab].'" /></td>'
				  .'</tr>'
				  .'<tr>'
					.'<td>'.$this->data['entry_tax'].'</td>'
					.'<td><select name="xshippingpro[tax_class_id]['.$no_of_tab.']">'
						.'<option value="0">'.$this->data['text_none'].'</option>';
				      foreach ($this->data['tax_classes'] as $tax_class) { 
						$return.='<option '.(($this->data['xshippingpro']['tax_class_id'][$no_of_tab]==$tax_class['tax_class_id'])?'selected':'').' value="'.$tax_class['tax_class_id'].'">'.$tax_class['title'].'</option>';
					   } 
					 $return.='</select></td>'
				  .'</tr>'
				 .'<tr>'
					.'<td>'.$this->data['entry_geo_zone'].'</td>' 
					.'<td>'
					.'<label class="any-class"><input '.(($this->data['xshippingpro']['geo_zone_all'][$no_of_tab]=='1')?'checked="checked"':'').' type="checkbox" name="xshippingpro[geo_zone_all]['.$no_of_tab.']" class="choose-any" value="1" />&nbsp;'.$this->data['text_any'].'</label>'
			        .'<div class="scrollbox-wrapper" '.(($this->data['xshippingpro']['geo_zone_all'][$no_of_tab]!='1')?'style="display:block"':'').'>'
					.'<div class="scrollbox">';
						$class = 'even';
						foreach ($this->data['geo_zones'] as $geo_zone) {
							$class = ($class == 'even' ? 'odd' : 'even');
						$return.='<div class="'.$class.'">'
						.'<input '.((in_array($geo_zone['geo_zone_id'],$this->data['xshippingpro']['geo_zone_id'][$no_of_tab]))?'checked':'').' type="checkbox" name="xshippingpro[geo_zone_id]['.$no_of_tab.'][]" value="'.$geo_zone['geo_zone_id'].'" />&nbsp;'.$geo_zone['name'].'</div>';
						 }
					$return.='</div>'
			       .'<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);">'.$this->data['text_select_all'].'</a>'
			       .'/ <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);">'.$this->data['text_unselect_all'].'</a>'
			       .'</div></td>'
				  .'</tr>'
				   .'<tr>'
					.'<td>'.$this->data['entry_customer_group'].'</td>'
					.'<td>'
					.'<label class="any-class"><input '.(($this->data['xshippingpro']['customer_group_all'][$no_of_tab]=='1')?'checked="checked"':'').' type="checkbox" name="xshippingpro[customer_group_all]['.$no_of_tab.']" class="choose-any" value="1" />&nbsp;'.$this->data['text_any'].'</label>'
			        .'<div class="scrollbox-wrapper" '.(($this->data['xshippingpro']['customer_group_all'][$no_of_tab]!='1')?'style="display:block"':'').' >'
					.'<div class="scrollbox">';
						 $class = 'even';
						 foreach ($this->data['customer_groups'] as $customer_group_id=>$name) {
						   $class = ($class == 'even' ? 'odd' : 'even');
						$return.='<div class="'.$class.'">'
						.'<input '.((in_array($customer_group_id,$this->data['xshippingpro']['customer_group'][$no_of_tab]))?'checked':'').' type="checkbox" name="xshippingpro[customer_group]['.$no_of_tab.'][]" value="'.$customer_group_id.'" />&nbsp;'.$name.'</div>';
						}
					$return.='</div>'
			       .'<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);">'.$this->data['text_select_all'].'</a>'
			       .'/ <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);">'.$this->data['text_unselect_all'].'</a>'
			       .'</div></td>'
				  .'</tr>'
				  .'<tr>'
				  .'<td>'.$this->data['text_category'].'</td>'
				  .'<td><select class="category-selection" name="xshippingpro[category]['.$no_of_tab.']">'
					  .'<option value="1" '.(($this->data['xshippingpro']['category'][$no_of_tab]==1)?'selected':'').'>'.$this->data['text_category_any'].'</option>'
					  .'<option value="2" '.(($this->data['xshippingpro']['category'][$no_of_tab]==2)?'selected':'').'>'.$this->data['text_category_all'].'</option>'
					  .'<option value="3" '.(($this->data['xshippingpro']['category'][$no_of_tab]==3)?'selected':'').'>'.$this->data['text_category_least'].'</option>'
					.'</select></td>'
				.'</tr>'
				.'<tr class="category" '.(($this->data['xshippingpro']['category'][$no_of_tab]!=1)?'style="display:table-row"':'').'>'
				  .'<td>'.$this->data['entry_category'].'</td>'
				  .'<td><input type="text" name="category" value="" /></td>'
				.'</tr>'
				.'<tr class="category" '.(($this->data['xshippingpro']['category'][$no_of_tab]!=1)?'style="display:table-row"':'').'>'
				  .'<td>&nbsp;</td>'
				  .'<td><div class="scrollbox product-category">';
				  foreach ($this->data['xshippingpro']['product_category'][$no_of_tab] as $category_id) {
						   $category_info = $this->model_catalog_category->getCategory($category_id);
						   $category_name=($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name'];
						   $return.='<div class="product-category'.$category_id. '">'.$category_name.'<img src="view/image/delete.png" alt="" />'
						     .'<input type="hidden" name="xshippingpro[product_category]['.$no_of_tab.'][]" value="'.$category_id.'" /></div>';
						}
			      $return.='</div></td>'
				.'</tr>'
				   .'<tr>'
					.'<td>'.$this->data['entry_order_total'].'</td>'
					.'<td><input size="15" type="text" name="xshippingpro[order_total_start]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['order_total_start'][$no_of_tab].'" /> &nbsp;'.$this->data['entry_to'].'&nbsp; <input size="15" type="text" name="xshippingpro[order_total_end]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['order_total_end'][$no_of_tab].'" />&nbsp;&nbsp;['.$this->data['entry_order_hints'].']</td>'
				  .'</tr>'
				  .'<tr>'
				  .'<td>'.$this->data['entry_order_weight'].'</td>'
					.'<td><input size="15" type="text" name="xshippingpro[weight_start]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['weight_start'][$no_of_tab].'" /> &nbsp;'.$this->data['entry_to'].'&nbsp; <input size="15" type="text" name="xshippingpro[weight_end]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['weight_end'][$no_of_tab].'" />&nbsp;&nbsp;['.$this->data['entry_order_hints'].']</td>'
				  .'</tr>'
				  .'<tr>'
					.'<td>'.$this->data['entry_sort_order'].'</td>'
					.'<td><input type="text" name="xshippingpro[sort_order]['.$no_of_tab.']" value="'.$this->data['xshippingpro']['sort_order'][$no_of_tab].'" size="1" /></td>'
				  .'</tr>'
				  .'<tr>'
					  .'<td>'.$this->data['entry_status'].'</td>'
					  .'<td><select name="xshippingpro[status]['.$no_of_tab.']">'
						  .'<option value="1" '.(($this->data['xshippingpro']['status'][$no_of_tab]==1 || $this->data['xshippingpro']['status'][$no_of_tab]=='')?'selected':'').'>'.$this->data['text_enabled'].'</option>'
						  .'<option value="0" '.(($this->data['xshippingpro']['status'][$no_of_tab]==0)?'selected':'').'>'.$this->data['text_disabled'].'</option>'
						.'</select></td>'
					.'</tr>'
				.'</table>'
				.'</div>';
		}
		
		return $return;		
	}
}
?>