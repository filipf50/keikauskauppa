<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_return'] = $this->language->get('text_return');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		
		$this->data['sellya_contacts_title'] = $this->config->get('sellya_contacts_title' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_mphone1'] = $this->config->get('sellya_contact_mphone1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_mphone2'] = $this->config->get('sellya_contact_mphone2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_sphone1'] = $this->config->get('sellya_contact_sphone1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_sphone2'] = $this->config->get('sellya_contact_sphone2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_fax1'] = $this->config->get('sellya_contact_fax1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_fax2'] = $this->config->get('sellya_contact_fax2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_email1'] = $this->config->get('sellya_contact_email1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_email2'] = $this->config->get('sellya_contact_email2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_skype1'] = $this->config->get('sellya_contact_skype1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_skype2'] = $this->config->get('sellya_contact_skype2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_location1'] = $this->config->get('sellya_contact_location1' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_location2'] = $this->config->get('sellya_contact_location2' . $this->config->get('config_language_id'));
		$this->data['sellya_contact_hours'] = $this->config->get('sellya_contact_hours' . $this->config->get('config_language_id'));
		$this->data['sellya_twitter_block_title'] = $this->config->get('sellya_twitter_block_title' . $this->config->get('config_language_id'));
		$this->data['sellya_custom_title'] = $this->config->get('sellya_custom_title' . $this->config->get('config_language_id'));
		$this->data['sellya_custom_content'] = $this->config->get('sellya_custom_content' . $this->config->get('config_language_id'));
		$this->data['sellya_powered_content'] = $this->config->get('sellya_powered_content' . $this->config->get('config_language_id'));
		$this->data['sellya_about_content'] = $this->config->get('sellya_about_content' . $this->config->get('config_language_id'));
		
		$this->load->model('catalog/information');
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$this->data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
    	}

		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
    	$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');		

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		
		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');
	
			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];	
			} else {
				$ip = ''; 
			}
			
			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];	
			} else {
				$url = '';
			}
			
			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];	
			} else {
				$referer = '';
			}
						
			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}		
		

			
				$this->load->model('design/layout');
				$this->load->model('catalog/category');
				$this->load->model('catalog/product');
				$this->load->model('catalog/information');
				
				if (isset($this->request->get['route'])) {
					$route = (string)$this->request->get['route'];
				} else {
					$route = 'common/home';
				}
				
				$layout_id = 0;
				
				if ($route == 'product/category' && isset($this->request->get['path'])) {
					$path = explode('_', (string)$this->request->get['path']);
				
					$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
				}
				
				if ($route == 'product/product' && isset($this->request->get['product_id'])) {
					$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
				}
				
				if ($route == 'information/information' && isset($this->request->get['information_id'])) {
					$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
				}
				
				if (!$layout_id) {
					$layout_id = $this->model_design_layout->getLayout($route);
				}
				
				if (!$layout_id) {
					$layout_id = $this->config->get('config_layout_id');
				}
				
				$module_data = array();
				
				$this->load->model('setting/extension');
				
				$extensions = $this->model_setting_extension->getExtensions('module');
				
				foreach ($extensions as $extension) {
					$modules = $this->config->get($extension['code'] . '_module');
						
					if ($modules) {
						foreach ($modules as $module) {
							if ($module['layout_id'] == $layout_id && $module['position'] == 'footer_bottom' && $module['status']) {
								$module_data['footer_bottom'][] = array(
										'code'       => $extension['code'],
										'setting'    => $module,
										'sort_order' => $module['sort_order']
								);
							} elseif($module['layout_id'] == $layout_id && $module['position'] == 'footer_top' && $module['status']) {
								$module_data['footer_top'][] = array(
										'code'       => $extension['code'],
										'setting'    => $module,
										'sort_order' => $module['sort_order']
								);
							}
						}
					}
				}
				
				foreach ($module_data as $k => $v) {
					
					if (!empty($module_data[$k])) {
					
						$sort_order = array();
					
						foreach ($module_data[$k] as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
							
						array_multisort($sort_order, SORT_ASC, $module_data[$k]);
							
						$this->data['modules'][$k] = array();
							
						foreach ($module_data[$k] as $module) {
							$module = $this->getChild('module/' . $module['code'], $module['setting']);
								
							if ($module) {
								$this->data['modules'][$k][] = $module;
							}
						}
					
					}
					
				}
			
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>