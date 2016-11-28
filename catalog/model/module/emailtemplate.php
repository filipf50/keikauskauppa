<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class ModelModuleEmailTemplate extends Model {
		
	/**
	 * Get Template
	 * @param int $id
	 * @return array
	 */
	public function getTemplate($id, $langId = null) {
		$p = DB_PREFIX;
		$return = array();
		
		$query = "SELECT * FROM `{$p}email_templates` WHERE `id` = '" . intval($id) . "'";
		if($langId != null){
			$query .= " AND `language_id` = '" . intval($langId) . "'";
		}
		$result = $this->db->query($query);
		
		foreach($result->rows as $row){
			foreach($row as $col=>$val){
				if($col == 'body'){
					$return[$col][$row['language_id']] = $val;
				} elseif(!isset($return[$col])) {
					$return[$col] = $val;
				}
			}
		}
		return $return;
	}
				
	/**
	 * Set array of all available tags
	 */
	public function parseTemplate($template, $request){
		if(!$template) return false;
		$find = array();
		$replace = array();
		$data = array();
		
		if (isset($request['order_id'])) {
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($request['order_id']);
			$data = array_merge($data, $order_info);
			$data['shipping_address'] = EmailTemplate::formatAddress($order_info, 'shipping', $order_info['shipping_address_format']);
			$data['payment_address'] = EmailTemplate::formatAddress($order_info, 'payment', $order_info['payment_address_format']);
			if($data['shipping_address'] == '') $data['shipping_address'] = $data['payment_address'];
		} 
		if (isset($request['customer_id'])) {
			$this->load->model('sale/customer');
			$data = array_merge($data, $this->model_sale_customer->getCustomer($request['customer_id']));
		} 
		if (isset($request['store_id'])) {
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			$this->load->model('localisation/language');
			$store_info = $this->model_setting_store->getStore($request['store_id']);
			$store_settings_config = $this->model_setting_setting->getSetting("config", $request['store_id']);			
			$language = $this->model_localisation_language->getLanguageByCode($store_settings_config['config_language']);			
			$data = array_merge($data, $store_settings_config, $store_info, $language);
		} 
		
		if(is_numeric($template) && isset($data['language_id'])){
			$result = $this->model_module_emailtemplate->getTemplate($template);
			if(isset($data['language_id']) && isset($result['body'][$data['language_id']])){
				$template = $result['body'][$data['language_id']];
			}
		} 
		
		if(!is_string($template)){
			trigger_error('Error: unable to load $template');
			exit;
		}
		$html = html_entity_decode($template, ENT_QUOTES, 'UTF-8');
		
		foreach($data as $key => $val){
			if(is_string($val) || is_int($val)){
				$find[$key] = '{$'.$key.'}';
				$replace[$key] = $val;
			}
		}
		
		return str_replace($find, $replace, $html);
	}
	
	/**
	 * Load showcase for store emails
	 * NOTE: duplicate method admin/model/module/emailtemplate.php
	 */
	public function loadShowcase($store_id = 0, $language_id = 1){
		$return = array();
		$selection = explode(',', $this->getConfig('emailtemplate_showcase_selection', $language_id));
	
		switch($this->getConfig('emailtemplate_showcase', $language_id)){
			case 'products':
				$this->load->model('catalog/product');
				$result = $this->model_catalog_product->getProducts(array('filter_product_id' => $selection, 'limit', $this->getConfig('emailtemplate_showcase_limit', $language_id)));
		
				foreach($result as $row){
					if ($row['image']) {
						$image = $this->model_tool_image->resize($row['image'], 100, 100);
					} else {
						$image = false;
					}
		
					$return[] = array(
						'id' => $row['product_id'],
						'thumb'   	 => $image,
						'name'    	 => $row['name'],
						'name_short' => EmailTemplate::truncate_str($row['name'], 28, ''),
						'description' => substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
						'href'    	 => HTTP_SERVER . 'index.php?route=product/product&product_id=' . $row['product_id'],
					);
				}
			break;
		}
		
		return $return;
	}
	
	/**
	 * Get config
	 *
	 * @param int $language_id
	 * @return config data index (langauge) if it exists OR defaults to first
	 */
	public function getConfig($key, $language_id) {
		$config = $this->config->get($key);
	
		if(is_array($config)){
			if(array_key_exists($language_id, $config)){
				# get config index using language_id
				return $config[$language_id];
			} else {
				# get first language from config if selected language doesn't exist
				return reset($config);
			}
		} else {
			if(isset($config)) {
				# get default config
				return $config;
			} else {
				return null;
			}
		}
	}
			
}