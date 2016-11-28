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
	 * Return array of templates
	 * @param array - $data
	 */
	public function getTemplates($data = array()) {
		$p = DB_PREFIX;	
		$cond = array();
		if (isset($data['language_id'])) {
			$cond[] = "e.`language_id` = '".intval($data['language_id'])."'";
		} 	
		if (isset($data['type']) && $data['type'] != "") {
			$cond[] = "e.`type` = '".$this->db->escape($data['type'])."'";
		}	
		$query = "SELECT e.*, l.name AS language_name, l.code AS language_code FROM `{$p}email_templates` e INNER JOIN `{$p}language` l ON(l.language_id = e.language_id)";
		if(!empty($cond)){
			$query .= ' WHERE ' . implode(' AND ', $cond);
		}
	
		$sort_data = array(
			'e.name',
			'e.id',
			'e.language_id',
			'e.type',
			'e.body'
		);	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$query .= " ORDER BY `" . $data['sort'] . "`";
		} else {
			$query .= " ORDER BY e.`name`";
		}
	
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}	
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
					
		$result = $this->db->query($query);	
		return $result->rows;
	}
		
	/**
	 * Return total template(s) for selected type
	 * 
	 * @parma string - type
	 * @return int - total rows
	 */
	public function getTotalTemplates($data){
		$p = DB_PREFIX;
		if (isset($data['type'])) {
			$type = $this->db->escape($data['type']);
		} else {
			$type = "order_status";
		}
		$query = "SELECT COUNT(*) AS total FROM `{$p}email_templates` WHERE `type` = '{$type}'";
		$result = $this->db->query($query);	
		return $result->row['total'];
	}
	
	/**
	 * Add new template row
	 * 
	 * @return new row indentifier
	 */
	public function insertTemplate(array $data) {
		$p = DB_PREFIX;		
		$new_id = 'NULL';
		foreach($data['body'] as $langId=>$body){
			$query = "INSERT INTO `{$p}email_templates` (`id`, `name`, `body`, `type`, `language_id`) VALUES (
				{$new_id},
				'".$this->db->escape($data['name'])."',
				'".$this->db->escape($body)."',
				'".$this->db->escape($data['type'])."',
				'".$this->db->escape($langId)."'
			)";
			$this->db->query($query);
			if($new_id == 'NULL'){
				$new_id = $this->db->getLastId();
			}
		}
		
		$this->cache->delete('email_templates');
				
		return $new_id;
	}
	
	/**
	 * Edit existing template row
	 * 
	 * @param int - emailtemplate.id
	 * @param array - column => value 
	 * @return returns true if row was updated with new data
	 */
	public function updateTemplate($id, array $data) {
		$p = DB_PREFIX;		
		$queries = array();
		$affected = 0;
		foreach($data['body'] as $langId=>$body){
			$queries[] = "UPDATE `{$p}email_templates` SET 
				`name` = '".$this->db->escape($data['name'])."', 
				`body` = '".$this->db->escape($body)."', 
				`type` = '".$this->db->escape($data['type'])."'
				WHERE `id` = '".intval($id)."' AND `language_id` = '".intval($langId)."'";	
		}	
		foreach($queries as $query){
			$this->db->query($query);
			$affected += $this->db->countAffected();
		}
			
		$this->cache->delete('email_templates');
		return ($affected > 0) ? $affected : false;
	}
	
	/**
	 * Delete template row
	 * 
	 * @param mixed array||int - emailtemplate.id
	 * @return int - row count effected
	 */
	public function deleteTemplate($var) {
		$ids = array();
		$p = DB_PREFIX;
		if(is_array($var)){
			foreach($var as $_var){
				$ids[] = intval($_var);
			}
		} else {
			$ids[] = intval($var);
		}				
		$query = "DELETE FROM `{$p}email_templates` WHERE `id` IN('".implode("', '", $ids)."')";		
		$this->db->query($query);	
		
		$this->cache->delete('email_templates');
		
		$affected = $this->db->countAffected();		
		return ($affected > 0) ? $affected : false;
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
	 * Set array of all available tags
	 */
	public function getTagsList($type = 'order_status'){
		$return = array();
		$p = DB_PREFIX;
		switch($type){
			case 'newsletter':
				$query = "SELECT `customer_id` FROM `{$p}customer` LIMIT 1";
				$result = $this->db->query($query);
				if(empty($result->row)) return false;
				
				$this->load->model('sale/customer');
				$result = $this->model_sale_customer->getCustomer($result->row['customer_id']);
				
				ksort($result);
				$return = array_keys($result);
			break;
			case 'order_status':
				$query = "SELECT `order_id` FROM `{$p}order` LIMIT 1";
				$result = $this->db->query($query);
				if(empty($result->row)) return false;
				
				$this->load->model('sale/order');
				$result = $this->model_sale_order->getOrder($result->row['order_id']);
				
				ksort($result);
				$return = array_keys($result);
			break;
			default:
				return false;
			break;			
		}
		return $return;
	}
	
	/**
	 * Get complete order email
	 * 
	 * @param int $order_id 
	 * @param int $store_id - rare case overwrite order
	 * @param int $language_id - rare case overwrite order	 
	 */
	public function getCompleteOrderEmail($order_id, $store_id = null, $language_id = null){
		$order_id = intval($order_id);
		$order_status_id = $this->config->get('config_order_status_id');
		
		$this->load->model('sale/order');
		$this->load->model('tool/image');
		$this->load->model('setting/store');
		$this->load->model('setting/setting');
		
		$order_info = $this->model_sale_order->getOrder($order_id);
		
		if($language_id === null){
			if(isset($order->row['language_id'])){
				$language_id = $order->row['language_id']; 
			} else {
				$language_id = $this->config->get('config_language_id');
			}
		}
		
		if($store_id === null){
			if(isset($order->row['store_id'])){
				$store_id = $order->row['store_id'];
			} elseif($this->config->get('config_store_id')) {
				$store_id = $this->config->get('config_store_id');
			} else {
				$store_id = 0;
			}
		}
							
		# Demo email template
		$template = new EmailTemplate($this->request, $this->registry, $language_id);
		
		# Overwrite store data
		$store_info = $this->model_setting_store->getStore($store_id);
		$store_settings_config = $this->model_setting_setting->getSetting("config", $store_id);
		$template->populateStoreData(array_merge($store_settings_config, $store_info));
		
		# Overwrite email data
		$data_store = $this->model_setting_setting->getSetting("emailtemplate", $store_id);
		$template->populateEmailData($data_store);
		
		$template->setTitle('Example Order:' . $order_id);
		
		# Overwrite theme for admin area template/mail
		$template->setThemeDir('mail');
				
		//$template->setShowcase();
		
		// Load Customer Group - check file exists for old versions of opencart
		if(isset($order_info['customer_group_id']) && $order_info['customer_group_id']){
			$this->load->model('sale/customer_group');
			$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);
		}
			
		// Load affiliate data into email
		if(isset($order_info['affiliate_id']) && $order_info['affiliate_id']){
			$this->load->model('sale/affiliate');
			$affiliate_info = $this->model_sale_affiliate->getAffiliate($order_info['affiliate_id']);
		}

		// Order Products
		$order_product_query = $this->db->query("SELECT op.*, p.image, p.sku, p.quantity AS stock_quantity FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id) WHERE order_id = '" . (int)$order_id . "'");
		
		// Downloads
		$order_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
		
		// Gift Voucher	
		$chk = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "order_voucher'");				
		if($chk->num_rows){			
			$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");		
		} else {
			$order_voucher_query = false;
		}
		
		// Order Totals
		$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
		
		// Order Status
		$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
		if ($order_status_query->num_rows) {
			$order_status = $order_status_query->row['name'];
		} else {
			$order_status = '';
		}
				
		// Send out order confirmation mail
		$language = new Language($order_info['language_directory']);
		$language->setPath(DIR_CATALOG.'language/');
		$language->load($order_info['language_filename']);
		$language->load('mail/order');
		
		$title = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);
		$template->setTitle($title);
			
		$template->appendDataLanguage($language, array(
			'text_affiliate',
			'text_new_comment',
			'text_id',
			'text_sku',
			'text_new_instruction',
			'text_new_received',
			'text_new_order_status',
			'text_new_products',
			'text_new_order_total',
			'text_order_link',
			'text_customer_group',
			'text_stock_quantity',
			'text_product_options'
		));
			
		$template->appendData(array(
			'affiliate' => (isset($affiliate_info)) ? $affiliate_info : '',
			'customer_group' => (isset($customer_group_info['name'])) ? $customer_group_info['name'] : '',
			'new_order_status' => $order_status,
			'order_id' => $order_id
		));			
		
		$template->data['title'] = $title;
		
		$template->data['text_greeting'] = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
		$template->data['text_link'] = $language->get('text_new_link');
		$template->data['text_download'] = $language->get('text_new_download');
		$template->data['text_order_detail'] = $language->get('text_new_order_detail');
		$template->data['text_instruction'] = $language->get('text_new_instruction');
		$template->data['text_order_id'] = $language->get('text_new_order_id');
		$template->data['text_date_added'] = $language->get('text_new_date_added');
		$template->data['text_payment_method'] = $language->get('text_new_payment_method');
		$template->data['text_shipping_method'] = $language->get('text_new_shipping_method');
		$template->data['text_email'] = $language->get('text_new_email');
		$template->data['text_telephone'] = $language->get('text_new_telephone');
		$template->data['text_ip'] = $language->get('text_new_ip');
		$template->data['text_payment_address'] = $language->get('text_new_payment_address');
		$template->data['text_shipping_address'] = $language->get('text_new_shipping_address');
		$template->data['text_product'] = $language->get('text_new_product');
		$template->data['text_model'] = $language->get('text_new_model');
		$template->data['text_quantity'] = $language->get('text_new_quantity');
		$template->data['text_price'] = $language->get('text_new_price');
		$template->data['text_total'] = $language->get('text_new_total');
		$template->data['text_footer'] = $language->get('text_new_footer');
		$template->data['text_powered'] = $language->get('text_new_powered');
				
		$template->data['store_name'] = $order_info['store_name'];
		$template->data['store_url'] = $order_info['store_url'];
		$template->data['customer_id'] = $order_info['customer_id'];
			
		$template->data['customer_name'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
		$template->data['customer_firstname'] = $order_info['firstname'];
		$template->data['customer_lastname'] = $order_info['lastname'];
			
		$template->data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;
		
		if ($order_download_query->num_rows) {
			$template->data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
		} else {
			$template->data['download'] = '';
		}
		
		$template->data['order_id'] = $order_id;
		$template->data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
		$template->data['payment_method'] = $order_info['payment_method'];
		$template->data['shipping_method'] = $order_info['shipping_method'];
		$template->data['email'] = $order_info['email'];
		$template->data['telephone'] = $order_info['telephone'];
		$template->data['ip'] = $order_info['ip'];
		
		$template->data['comment'] = ($order_info['comment']) ? str_replace(array("\r\n", "\r", "\n"), "<br />", $order_info['comment']) : '';
		$template->data['instruction'] = '';

		$template->data['shipping_address'] = EmailTemplate::formatAddress($order_info, 'shipping', $order_info['shipping_address_format']);
		$template->data['payment_address'] = EmailTemplate::formatAddress($order_info, 'payment', $order_info['payment_address_format']);
				
		// Products
		$template->data['products'] = array();			
		foreach ($order_product_query->rows as $product) {
			$option_data = array();			
			$order_option_query = $this->db->query("SELECT oo.*, pov.* FROM " . DB_PREFIX . "order_option oo LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_option_value_id = oo.product_option_value_id) WHERE oo.order_id = '" . (int)$order_id . "' AND oo.order_product_id = '" . (int)$product['order_product_id'] . "'");
				
			foreach ($order_option_query->rows as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
				}
							
				$price = false;
				if ((float)$option['price']) {
					$price = $this->currency->format($option['price'], $this->config->get('config_currency'));
				}
					
				$option_data[] = array(
					'name'  => $option['name'],						
					'price'  => $price,
					'price_prefix'  => $option['price_prefix'],						
					'value' => (utf8_strlen($value) > $template->getConfig('emailtemplate_body_product_option_length') ? utf8_substr($value, 0, $template->getConfig('emailtemplate_body_product_option_length')) . '..' : $value)
				);
			}
				
			if (isset($product['image']) && $template->getConfig('emailtemplate_order_picture')) {
				$image = $this->model_tool_image->resize($product['image'], 50, 50);
			} else {
				$image = '';
			}
				
			$template->data['products'][] = array(
				'image'     	=> $image,
				'product_id'	=> $product['order_product_id'],
				'sku'			=> $product['sku'],
				'stock_quantity'=> ($product['stock_quantity'] - $product['quantity']),		
				'name'     => $product['name'],
				'model'    => $product['model'],
				'option'   => $option_data,
				'quantity' => $product['quantity'],
				'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
			);
		}
			
		// Vouchers
		$template->data['vouchers'] = array();
		if($order_voucher_query){
			foreach ($order_voucher_query->rows as $voucher) {
				$template->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
		}
			
		// Order Totals
		$template->data['totals'] = $order_total_query->rows;
				
		// Text Mail
		$text = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
		$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
		$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
		$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
					
		// Products
		$text .= $language->get('text_new_products') . "\n";			
		foreach ($order_product_query->rows as $product) {
			$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
				
			$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
				
			foreach ($order_option_query->rows as $option) {
				$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($option['value']) > 20 ? utf8_substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
			}
		}
			
		// Vouchers
		if($order_voucher_query){
			foreach ($order_voucher_query->rows as $voucher) {
				$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
			}			
			$text .= "\n";
		}
			
		// Totals
		$text .= $language->get('text_new_order_total') . "\n";			
		foreach ($order_total_query->rows as $total) {
			$text .= $total['title'] . ': ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
		}			
		$text .= "\n";
			
		if ($order_info['customer_id']) {
			$text .= $language->get('text_new_link') . "\n";
			$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
		}
			
		if ($order_download_query->num_rows) {
			$text .= $language->get('text_new_download') . "\n";
			$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
		}
			
		// Comment
		if ($order_info['comment']) {
			$text .= $language->get('text_new_comment') . "\n\n";
			$text .= $order_info['comment'] . "\n\n";
		}
			
		$text .= $language->get('text_new_footer') . "\n\n";
		
		$mailTplPath = DIR_CATALOG.'view/theme/'.$data_store['emailtemplate_theme'][$language_id].'/template/mail/';
		$html = $template->fetch($mailTplPath.'order_customer.tpl', '_mail.tpl', '', false);
		
		return array('html'=>$html, 'plaintext'=>$text);
	}

	/**
	 * Load show for admin emails
	 */
	public function loadShowcase($store_id = 0, $language_id = 1){
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		$config = $this->model_setting_setting->getSetting("emailtemplate", $store_id);
		
		$return = array();
		$selection = explode(',', $config['emailtemplate_showcase_selection'][$language_id]);
	
		switch($config['emailtemplate_showcase'][$language_id]){
			case 'products':	
				$this->load->model('catalog/product');
				$result = $this->model_catalog_product->getProducts(array('filter_product_id' => $selection));
	
				foreach($result as $row){
					if ($row['image']) {
						$image = $this->model_tool_image->resize($row['image'], 100, 100);
					} else {
						$image = false;
					}
						
					$return[] = array(
						'product_id' => $row['product_id'],
						'thumb'   	 => $image,
						'name'    	 => $row['name'],
						'name_short' => EmailTemplate::truncate_str($row['name'].$row['name'].$row['name'].$row['name'], 28, ''),
						'description' => substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
						'href'    	 => HTTP_CATALOG . 'index.php?route=product/product&amp;product_id=' . $row['product_id'],
					);
				}
			break;
		}
		
		return $return;
	}
	
	/**
	 * Method handles saving custom language changes to new file
	 */
	public function saveLanguageFile($dir, $language, $directory, $file, $data)
	{
		$path = str_replace('../', '', $dir.$language.'/'.$directory.'/');
		$file = basename($file, ".php");		
		$filepath = $path.$file.'.php';
		$newfile = $path.$file.'_.php';
		$changes = array();
		
		if(!file_exists($filepath)) return false;
		
		# Load original
		$oLanguage = new Language($language);
		$oLanguage->setPath($dir);
		$language_vars = $oLanguage->load($directory.'/'.$file, false);
		
		# Compare changes to original language file
		foreach ($language_vars as $key => $value){
			$data[$key] = trim(str_replace(array("\r\n", "\n", "\r"), '', html_entity_decode($data[$key], ENT_QUOTES, 'UTF-8')));
			$value = trim(str_replace(array("\r\n", "\n", "\r"), '', $value));
			if(isset($data[$key]) && strcmp($value, $data[$key]) !== 0){				
				$changes[$key] = $data[$key];
			}
		}
		
		if(file_exists($newfile)){
			$oLanguage = new Language($language);
			$oLanguage->setPath($dir);
			$custom_language_vars = $oLanguage->load($directory.'/'.$file.'_');
			
			# Compare changes to custom language file
			foreach ($custom_language_vars as $key => $value){			
				$changes[$key] = $data[$key];			
			}		
		}		
		
		if(empty($changes)) return false;
		
		ksort($changes);
		
		# Write new file
		$contents = "<?php\n# Anything in here with the same name will overwrite the main file without underscore. \n\n";
		foreach($changes as $key => $value){
			$contents .= str_pad("\$_['" . $key . "']", 30, " ", STR_PAD_RIGHT) . "= '" . $value . "'; \n";
		}		
		$contents .= "\n?>";	
				
		if(is_writable($newfile) && file_exists($newfile)){
			# only perform write if contents has changed in our custom language file
			if(file_get_contents($newfile) == $contents){
				return true; 
			} elseif(file_put_contents($newfile, $contents)){
				return true;
			}
		} else {
			if(file_put_contents($newfile, $contents)){
				return true;
			}			
		}
		
		# if we get to here then we have been unable to write
		return array(
			'file' => $newfile,
			'filename' => $file.'_.php',
			'path' => $path,
			'contents' => $contents
		);
	}
	
	/**
	 * Method handles creating new tables and fixing opencart bugs
	 */
	public function install() {
		$p = DB_PREFIX;
		$queries = array();
		
		// Check settings table has serialised - OC Version: < 1.5.0.5
		$chk = $this->db->query("SHOW COLUMNS FROM `{$p}setting` LIKE 'serialized'");
		if(!$chk->num_rows){
			$result = $this->db->query("ALTER TABLE `{$p}setting` ADD `serialized` tinyint(1) NOT NULL DEFAULT 0");
		}
		
		// Opencart missing ability to find a registered customers language
		$chk = $this->db->query("SHOW COLUMNS FROM `{$p}customer` LIKE 'language_id'");
		if(!$chk->num_rows){
			$result = $this->db->query("ALTER TABLE `{$p}customer` ADD `language_id` int(11) NOT NULL DEFAULT '0' AFTER `store_id`");
		}
		
		// Add order PDf field
		$chk = $this->db->query("SHOW COLUMNS FROM `{$p}order` LIKE 'invoice_filename'");
		if(!$chk->num_rows){
			$result = $this->db->query("ALTER TABLE `{$p}order` ADD `invoice_filename` varchar(255) NOT NULL AFTER `invoice_prefix`");
		}
		
		// Extension table
		$chk = $this->db->query("SHOW TABLES LIKE '{$p}email_templates'");
		if(!$chk->num_rows){
			$queries[] = "DROP TABLE IF EXISTS `{$p}email_templates`";
			$queries[] = "CREATE TABLE IF NOT EXISTS `{$p}email_templates` (
							`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
							`name` varchar(120) NOT NULL,
							`body` text NOT NULL,
							`type` enum('order_status', 'newsletter') NOT NULL,
							`language_id` INT( 11 ) NOT NULL,
					      	PRIMARY KEY (`id`,`language_id`)
					      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";			
			$queries[] = 'INSERT INTO `'.$p.'email_templates` (`id`, `name`, `body`, `type`, `language_id`) VALUES (NULL, "Example Order Dispatched", "&lt;p&gt;Your order {$order_id} has been dispatched for delivery and should be with you shortly&lt;/p&gt;\r\n\r\n&lt;p&gt;Delivery Address:&lt;br /&gt;\r\n{$shipping_address}&lt;/p&gt;\r\n", "order_status", "'. $this->config->get('config_language_id').'")';
			$queries[] = 'INSERT INTO `'.$p.'email_templates` (`id`, `name`, `body`, `type`, `language_id`) VALUES (NULL, "Example Newsletter", "&lt;p&gt;Hi {$firstname}&lt;/p&gt;", "newsletter", "'. $this->config->get('config_language_id').'")';					
			foreach($queries as $query){
				$this->db->query($query);
			}
		}
		
		$this->cache->delete('email_templates');
		
		return true;
	}
	
	/**
	 * Method handles removing table
	 */
	public function uninstall() {
		$p = DB_PREFIX;
		$query = "DROP TABLE IF EXISTS `{$p}email_templates`";
		$this->db->query($query);
		$this->cache->delete('email_templates');
	}		
}