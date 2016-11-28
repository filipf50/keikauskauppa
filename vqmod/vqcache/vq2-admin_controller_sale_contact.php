<?php 
class ControllerSaleContact extends Controller {
	private $error = array();
	 
	public function index() {
		$this->language->load('sale/contact');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_customer_all'] = $this->language->get('text_customer_all');	
		$this->data['text_customer'] = $this->language->get('text_customer');	
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_affiliate_all'] = $this->language->get('text_affiliate_all');	
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');	
		$this->data['text_product'] = $this->language->get('text_product');	

		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_to'] = $this->language->get('entry_to');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_message'] = $this->language->get('entry_message');

			$this->data['entry_template'] = $this->language->get('entry_template');
            
			$this->load->model('module/emailtemplate');
            $this->data['templates'] = $this->model_module_emailtemplate->getTemplates(array('type' => 'newsletter'));            
            $this->data['templates_action'] = $this->url->link('module/emailtemplate/fetch_template', 'token='.$this->session->data['token'], 'SSL'); 
		
		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['token'] = $this->session->data['token'];

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
    	$this->data['cancel'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('sale/customer_group');
				
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
				
		$this->template = 'sale/contact.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function send() {
		$this->language->load('sale/contact');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/contact')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}
					
			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}
	
			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('error_message');
			}
			
			if (!$json) {
				$this->load->model('setting/store');
			
				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);			
				
				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}
	
				$this->load->model('sale/customer');
				
				$this->load->model('sale/customer_group');
				
				$this->load->model('sale/affiliate');
	
				$this->load->model('sale/order');
	
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
								
				$email_total = 0;
							

            $this->load->model('setting/setting');
			$this->load->model('module/emailtemplate');
			$this->load->model('localisation/language');
            $languages = $this->model_localisation_language->getLanguages(); 
				$emails = array();
				
				switch ($this->request->post['to']) {
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter' => 1,
							'start'             => ($page - 1) * 10,
							'limit'             => 10
						);
						
						$email_total = $this->model_sale_customer->getTotalCustomers($customer_data);
							
						$results = $this->model_sale_customer->getCustomers($customer_data);
					
						foreach ($results as $result) {
							
            $emails[$result['customer_id']] = array(
            	'email' => $result['email'],
            	'store_id' => $result['store_id'],
            	'customer_id' => $result['customer_id'],
            	'language_id' => $result['language_id']
           	); 
						}
						break;
					case 'customer_all':
						$customer_data = array(
							'start'  => ($page - 1) * 10,
							'limit'  => 10
						);
									
						$email_total = $this->model_sale_customer->getTotalCustomers($customer_data);
										
						$results = $this->model_sale_customer->getCustomers($customer_data);
				
						foreach ($results as $result) {
							
            $emails[$result['customer_id']] = array(
            	'email' => $result['email'],
            	'store_id' => $result['store_id'],
            	'customer_id' => $result['customer_id'],
            	'language_id' => $result['language_id']
           	); 
						}						
						break;
					case 'customer_group':
						$customer_data = array(
							'filter_customer_group_id' => $this->request->post['customer_group_id'],
							'start'                    => ($page - 1) * 10,
							'limit'                    => 10
						);
						
						$email_total = $this->model_sale_customer->getTotalCustomers($customer_data);
										
						$results = $this->model_sale_customer->getCustomers($customer_data);
				
						foreach ($results as $result) {
							
            $emails[$result['customer_id']] = array(
            	'email' => $result['email'],
            	'customer_id' => $result['customer_id'],
            	'store_id' => $result['store_id'],
            	'language_id' => $result['language_id']
           	); 
						}						
						break;
					case 'customer':
						if (!empty($this->request->post['customer'])) {					
							foreach ($this->request->post['customer'] as $customer_id) {
								$customer_info = $this->model_sale_customer->getCustomer($customer_id);
								
								if ($customer_info) {
									
            $emails[] = array(
            	'email' => $customer_info['email'],
            	'customer_id' => $customer_info['customer_id'],
            	'store_id' => $customer_info['store_id'],
            	'language_id' => $customer_info['language_id']
           	); 
								}
							}
						}
						break;	
					case 'affiliate_all':
						$affiliate_data = array(
							'start'  => ($page - 1) * 10,
							'limit'  => 10
						);
						
						$email_total = $this->model_sale_affiliate->getTotalAffiliates($affiliate_data);		
						
						$results = $this->model_sale_affiliate->getAffiliates($affiliate_data);
				
						foreach ($results as $result) {
							$emails[] = $result['email'];
						}						
						break;	
					case 'affiliate':
						if (!empty($this->request->post['affiliate'])) {					
							foreach ($this->request->post['affiliate'] as $affiliate_id) {
								$affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);
								
								if ($affiliate_info) {
									$emails[] = $affiliate_info['email'];
								}
							}
						}
						break;											
					case 'product':
						if (isset($this->request->post['product'])) {
							$email_total = $this->model_sale_order->getTotalEmailsByProductsOrdered($this->request->post['product']);	
							
							$results = $this->model_sale_order->getEmailsByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);
													
							foreach ($results as $result) {
								$emails[] = $result['email'];
							}
						}
						break;												
				}
				
				if ($emails) {
					$start = ($page - 1) * 10;
					$end = $start + 10;
					
					if ($end < $email_total) {
						$json['success'] = sprintf($this->language->get('text_sent'), $start, $email_total);
					} else { 
						$json['success'] = $this->language->get('text_success');
					}				
						
					if ($end < $email_total) {
						$json['next'] = str_replace('&amp;', '&', $this->url->link('sale/contact/send', 'token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
					} else {
						$json['next'] = '';
					}
										
					$message  = '<html dir="ltr" lang="en">' . "\n";
					$message .= '  <head>' . "\n";
					$message .= '    <title>' . $this->request->post['subject'] . '</title>' . "\n";
					$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
					$message .= '  </head>' . "\n";
					$message .= '  <body>' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
					$message .= '</html>' . "\n";
					
					foreach ($emails as $email) {

            if(!isset($email['customer_id'])) continue;
			$languageId = isset($email['language_id']) ? $email['language_id'] : $this->config->get('config_language_id');
            $template = new EmailTemplate($this->request, $this->registry, $languageId);
            $template->tracking('newsletter');
            			
			$store_settings_config = $this->model_setting_setting->getSetting("config", $email['store_id']);						
			$template->populateStoreData(array_merge($store_settings_config, $store_info));
			$et_store = $this->model_setting_setting->getSetting("emailtemplate", $email['store_id']);			
			$template->populateEmailData($et_store);
			
			$template->setThemeDir('mail');
			
			$language = $this->language; // save current lang  
			foreach($languages as $lang){				
				if($lang['language_id'] == $languageId){
					$language = new Language($lang['directory']);
					$language->load("sale/contact");
				}
			} 
						$mail = new Mail();	
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->parameter = $this->config->get('config_mail_parameter');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');				
						
            $mail->setTo($email['email']); 
						
            $mail->setFrom($store_settings_config['config_email']); 
						$mail->setSender($store_name);
						$mail->setSubject(html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8'));					
						             
            if($template->getConfig('emailtemplate_unsubscribe') && in_array($this->request->post['to'], array('newsletter', 'customer_all', 'customer_group', 'customer'))) {
            	$url = (isset($store_info['url']) ? $store_info['url'] : HTTP_CATALOG) . 'index.php?route=account/newsletter/unsubscribe&code='.md5($email['email']);
            	$template->data['unsubscribe'] = sprintf(html_entity_decode($template->getConfig('emailtemplate_unsubscribe'), ENT_QUOTES, 'UTF-8'), $url);
            }
            
            $body = $this->model_module_emailtemplate->parseTemplate($this->request->post['message'], array_merge($email, $this->request->post));
			$html = $template->fetch(null, '_mail.tpl', $body);
			
			$mail->setText(trim(strip_tags($body)));			
			$mail->setHtml($html); 
						$mail->send();
					}
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));	
	}
}
?>