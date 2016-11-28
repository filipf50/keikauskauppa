<?php   
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle();

				$results = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "order_layaway LIKE 'paid_in_full'");
				if (!$results->num_rows) {
					$this->db->query("ALTER TABLE " . DB_PREFIX . "order_layaway ADD COLUMN paid_in_full TINYINT(1) NOT NULL DEFAULT 0");
					$this->db->query("ALTER TABLE " . DB_PREFIX . "order_layaway ADD COLUMN email_sent TINYINT(1) NOT NULL DEFAULT 0");
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_layaway");
					if ($query->num_rows) {
						foreach ($query->rows as $row) {
							$records = unserialize($row['payments']);
							if (!empty($records)) {
								$order_total = $this->db->query("SELECT total FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$row['order_id'] . "'");
								$amount_paid = $row['deposit'];
								foreach ($records as $record) {
									$amount_paid += $record['payment_amount'];
								}
								if (round($order_total->row['total'],2) == $amount_paid) {
									$this->db->query("UPDATE " . DB_PREFIX . "order_layaway SET paid_in_full = 1 WHERE layaway_id = '" . (int)$row['layaway_id'] . "' AND order_id = '" . (int)$row['order_id'] . "'");
								}
							}
						}
					}
				}
				if ($this->config->get('layaway_status') && $this->config->get('layaway_allow_admin') && $this->config->get('layaway_send_emails')) {
					$layaways = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_layaway WHERE paid_in_full = 0 AND email_sent = 0");
					if ($layaways->num_rows) {
						$today = time();
						foreach ($layaways->rows as $layaway) {
							$order_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$layaway['order_id'] . "'");
							foreach ($order_products->rows as $order_product) {
								$product_query = $this->db->query("SELECT payment_due FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$order_product['product_id'] . "'");
								if ($product_query->row['payment_due'] > 0) {
									$due_date = $product_query->row['payment_due'];
								} else {
									$due_date = $layaway['date_added'] + (86400 * $this->config->get('layaway_timeframe'));
								}
								$reminder_period = $this->config->get('layaway_email_reminder') * 86400;
								if ($due_date - $reminder_period < $today) {
									$order_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$layaway['order_id'] . "'");
									if ($order_info->num_rows) {
										$customer_email = $order_info->row['email'];
										$this->load->model('setting/setting');
										$store_info = $this->model_setting_setting->getSetting('config', $order_info->row['store_id']);
										if ($store_info) {
											$store_email = $store_info['config_email'];
										} else {
											$store_email = $this->config->get('config_email');
										}
										$this->language->load('account/layaway');
										$html = sprintf($this->language->get('text_customer_message'), $this->config->get('layaway_button_name'), $layaway['order_id'], $this->config->get('layaway_button_name'), $this->config->get('layaway_timeframe'));
										$subject = sprintf($this->language->get('text_customer_subject'), $this->config->get('layaway_button_name'), $layaway['order_id'], $order_info->row['store_name']);

			$template = new EmailTemplate($this->request, $this->registry);
			$template->setTitle($subject);
			
			$template->populateStoreData($store_info);
			
			$this->load->model('setting/setting');
			$et_store = $this->model_setting_setting->getSetting("emailtemplate", $order_info->row['store_id']);
			$template->populateEmailData($et_store);
					
			$html = $template->fetch(null, '_mail.tpl', $html);				
            
										$mail = new Mail();
										$mail->protocol = $this->config->get('config_mail_protocol');
										$mail->parameter = $this->config->get('config_mail_parameter');
										$mail->hostname = $this->config->get('config_smtp_host');
										$mail->username = $this->config->get('config_smtp_username');
										$mail->password = $this->config->get('config_smtp_password');
										$mail->port = $this->config->get('config_smtp_port');
										$mail->timeout = $this->config->get('config_smtp_timeout');
										$mail->setTo($customer_email);
										$mail->setFrom($store_email);
										$mail->setSender($order_info->row['store_name']);
										$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
										$mail->setHtml($html);
										$mail->send();
										$html = sprintf($this->language->get('text_store_message'), $this->config->get('layaway_button_name'), $layaway['order_id'], $this->config->get('layaway_button_name'), $this->config->get('layaway_timeframe'));
										$subject = sprintf($this->language->get('text_store_subject'), $this->config->get('layaway_button_name'), $layaway['order_id'], $order_info->row['store_name']);

			$template = new EmailTemplate($this->request, $this->registry);
			$template->setTitle($subject);
								
			$html = $template->fetch(null, '_mail.tpl', $html);				
            
										$mail = new Mail();
										$mail->protocol = $this->config->get('config_mail_protocol');
										$mail->parameter = $this->config->get('config_mail_parameter');
										$mail->hostname = $this->config->get('config_smtp_host');
										$mail->username = $this->config->get('config_smtp_username');
										$mail->password = $this->config->get('config_smtp_password');
										$mail->port = $this->config->get('config_smtp_port');
										$mail->timeout = $this->config->get('config_smtp_timeout');
										$mail->setTo($store_email);
										$mail->setFrom($store_email);
										$mail->setSender($order_info->row['store_name']);
										$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
										$mail->setHtml($html);
										$mail->send();
										$this->db->query("UPDATE " . DB_PREFIX . "order_layaway SET email_sent = 1 WHERE layaway_id = '" . (int)$layaway['layaway_id'] . "' AND order_id = '" . (int)$layaway['order_id'] . "'");
									}
								}
							}
						}
					}
				}
			
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		
		if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];
            
            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	 
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');	
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_return'] = $this->language->get('text_return');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_special'] = $this->language->get('text_special');		
		$this->data['text_contact'] = $this->language->get('text_contact');		
		$this->data['name'] = $this->config->get('config_name');
		
		$this->data['sellya_menu_link_1'] = $this->config->get('sellya_menu_link_1' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_2'] = $this->config->get('sellya_menu_link_2' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_3'] = $this->config->get('sellya_menu_link_3' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_4'] = $this->config->get('sellya_menu_link_4' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_5'] = $this->config->get('sellya_menu_link_5' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_6'] = $this->config->get('sellya_menu_link_6' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_7'] = $this->config->get('sellya_menu_link_7' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_8'] = $this->config->get('sellya_menu_link_8' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_9'] = $this->config->get('sellya_menu_link_9' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_link_10'] = $this->config->get('sellya_menu_link_10' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_title_1'] = $this->config->get('sellya_menu_custom_block_title_1' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_content_1'] = $this->config->get('sellya_menu_custom_block_content_1' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_title_2'] = $this->config->get('sellya_menu_custom_block_title_2' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_content_2'] = $this->config->get('sellya_menu_custom_block_content_2' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_title_3'] = $this->config->get('sellya_menu_custom_block_title_3' . $this->config->get('config_language_id'));
		$this->data['sellya_menu_custom_block_content_3'] = $this->config->get('sellya_menu_custom_block_content_3' . $this->config->get('config_language_id'));
		$this->data['sellya_custom_box_content'] = $this->config->get('sellya_custom_box_content' . $this->config->get('config_language_id'));		
		
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
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
	    		'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
      		);
    	}	
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}		
		
		$this->language->load('common/header');

    $this->language->load('module/slidecart');
    
		
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
    	$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_login_s'] = $this->language->get('text_login_s');
		$this->data['text_register'] = $this->language->get('text_register');		
		$this->data['text_logged_s'] = sprintf($this->language->get('text_logged_s'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

        $this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
				
		$this->data['home'] = $this->url->link('common/home');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['login'] = $this->url->link('account/login', '', 'SSL');
		$this->data['register'] = $this->url->link('account/register', '', 'SSL');		
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		
    	$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_menu_categories'] = $this->language->get('text_menu_categories');			
		$this->data['text_menu_brands'] = $this->language->get('text_menu_brands');		
		$this->data['text_menu_contact_us'] = $this->language->get('text_menu_contact_us');
		$this->data['text_menu_contacts'] = $this->language->get('text_menu_contacts');
		$this->data['text_menu_contact_map'] = $this->language->get('text_menu_contact_map');
		$this->data['text_menu_contact_address'] = $this->language->get('text_menu_contact_address');
		$this->data['text_menu_contact_hours'] = $this->language->get('text_menu_contact_hours');		
		$this->data['text_menu_contact_form'] = $this->language->get('text_menu_contact_form');
		$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
    	$this->data['text_fax'] = $this->language->get('text_fax');	
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		
        $this->data['contact'] = $this->url->link('information/contact');	
		$this->data['action'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
    	$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');		
		$this->data['store'] = $this->config->get('config_name');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');	
    	$this->data['address'] = nl2br($this->config->get('config_address'));
    	$this->data['telephone'] = $this->config->get('config_telephone');
    	$this->data['fax'] = $this->config->get('config_fax');
		
		if (isset($this->request->get['filter_name'])) {
			$this->data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$this->data['filter_name'] = '';
		}
		
		
		
		// Daniel's robot detector
		$status = true;
		
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", trim($this->config->get('config_robots')));

			foreach ($robots as $robot) {
				if (strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}
		
		// A dirty hack to try to set a cookie for the multi-store feature
		$this->load->model('setting/store');
		
		$this->data['stores'] = array();
		
		if ($this->config->get('config_shared') && $status) {
			$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			
			$stores = $this->model_setting_store->getStores();
					
			foreach ($stores as $store) {
				$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			}
		}
		
		
		
				
		// Search		
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}
		
		
		// Menu
		$this->load->model('catalog/category');
		
		$this->load->model('catalog/product');
		
		$this->load->model('catalog/manufacturer');
		$this->load->model('tool/image');
		$results = $this->model_catalog_manufacturer->getManufacturers();
		foreach ($results as $result) {	
			if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}			
			$this->data['manufacturers'][] = array(
				'name' => $result['name'],
				'image' => $this->model_tool_image->resize($image, 50, 50),
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}
		
		$this->data['categories'] = array();
					
		$categories = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();
				
				$children = $this->model_catalog_category->getCategories($category['category_id']);
				
				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
					
					$product_total = $this->model_catalog_product->getTotalProducts($data);
									
					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}
				
				// Level 1
				$this->load->model('tool/image');
                $image = empty($category['image']) ? 'no_image.jpg' : $category['image'];
                $thumb = $this->model_tool_image->resize($image, 100, 100);
				$this->data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'thumb'    => $thumb,	
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}
		
		$this->children = array(
			'module/language',
			'module/currency',
			'module/cart'
		);
				

			
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
							if ($module['layout_id'] == $layout_id && $module['position'] == 'header_bottom' && $module['status']) {
								$module_data['header_bottom'][] = array(
										'code'       => $extension['code'],
										'setting'    => $module,
										'sort_order' => $module['sort_order']
								);
							} elseif($module['layout_id'] == $layout_id && $module['position'] == 'header_top' && $module['status']) {
								$module_data['header_top'][] = array(
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
			
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}
		
    	$this->render();
	} 	
}
?>