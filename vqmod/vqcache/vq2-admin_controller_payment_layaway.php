<?php 

class ControllerPaymentLayaway extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('payment/layaway');
		if ($this->config->get('layaway_button_name')) {
			$this->document->setTitle($this->config->get('layaway_button_name'));
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('layaway', $this->request->post);

                            if ($this->request->post['layaway_autoselect_by_product_option']==1){
                                $this->load->model('payment/layaway');
                                $this->model_payment_layaway->allowAutoSelectByProductOption();
                            }                        
                    
			$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->config->get('layaway_button_name'));
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if ($this->config->get('layaway_button_name')) {
			$this->data['heading_title'] = $this->config->get('layaway_button_name');
		} else {
			$this->data['heading_title'] = $this->language->get('heading_title');
		}
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_allow_layaway_admin'] = $this->language->get('text_allow_layaway_admin');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['entry_min_layaway_deposit'] = $this->language->get('entry_min_layaway_deposit');
		$this->data['entry_allow_customer_group'] = $this->language->get('entry_allow_customer_group');
		$this->data['entry_hide_buttons'] = $this->language->get('entry_hide_buttons');
		$this->data['entry_min_layaway_amount'] = $this->language->get('entry_min_layaway_amount');
		$this->data['entry_allow_layaway_deposit'] = $this->language->get('entry_allow_layaway_deposit');
		$this->data['entry_allow_layaway_admin'] = $this->language->get('entry_allow_layaway_admin');
		$this->data['entry_send_emails'] = $this->language->get('entry_send_emails');

                            $this->data['entry_autoselect_by_product_option'] = $this->language->get('entry_autoselect_by_product_option');
                    
		$this->data['entry_email_reminder'] = $this->language->get('entry_email_reminder');
		$this->data['entry_active_stores'] = $this->language->get('entry_active_stores');
		$this->data['entry_layaway_timeframe'] = $this->language->get('entry_layaway_timeframe');
		$this->data['entry_layaway_payment_fee'] = $this->language->get('entry_layaway_payment_fee');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_button_name'] = $this->language->get('entry_button_name');
		$this->data['entry_per_product'] = $this->language->get('entry_per_product');

		$this->data['button_cancel'] = $this->language->get('button_cancel');

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
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/layaway', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/layaway', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');	
		
		$this->load->model('setting/store');
		$this->data['default_store'] = $this->config->get('config_name');
		$this->data['stores'] = array();
		$results = $this->model_setting_store->getStores();
		$this->data['stores'][] = array(
			'store_id'	=> 0,
			'name'		=> $this->config->get('config_name')
		);
		foreach ($results as $result) {
			$this->data['stores'][] = array(
				'store_id'	=> $result['store_id'],
				'name'		=> $result['name']
			);
		}
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = array();
		$results = $this->model_sale_customer_group->getCustomerGroups();
		foreach ($results as $result) {
			$this->data['customer_groups'][] = array(
				'customer_group_id'	=> $result['customer_group_id'],
				'name'				=> $result['name']
			);
		}
		
		if (isset($this->request->post['layaway_button_name'])) {
			$this->data['layaway_button_name'] = $this->request->post['layaway_button_name'];
		} else {
			$this->data['layaway_button_name'] = $this->config->get('layaway_button_name');
		}
		
		if (isset($this->request->post['layaway_per_product'])) {
			$this->data['layaway_per_product'] = $this->request->post['layaway_per_product'];
		} else {
			$this->data['layaway_per_product'] = $this->config->get('layaway_per_product');
		}
		
		if (isset($this->request->post['layaway_customer_groups'])) {
			$this->data['layaway_customer_groups'] = $this->request->post['layaway_customer_groups'];
		} else {
			$this->data['layaway_customer_groups'] = $this->config->get('layaway_customer_groups');
		}
		
		if (isset($this->request->post['layaway_active_stores'])) {
			$this->data['layaway_active_stores'] = $this->request->post['layaway_active_stores'];
		} else {
			$this->data['layaway_active_stores'] = $this->config->get('layaway_active_stores');
		}
		
		if (isset($this->request->post['layaway_min_deposit'])) {
			$this->data['layaway_min_deposit'] = $this->request->post['layaway_min_deposit'];
		} else {
			$this->data['layaway_min_deposit'] = $this->config->get('layaway_min_deposit');
		}
		
		if (isset($this->request->post['layaway_deposit_type'])) {
			$this->data['layaway_deposit_type'] = $this->request->post['layaway_deposit_type'];
		} else {
			$this->data['layaway_deposit_type'] = $this->config->get('layaway_deposit_type');
		}
		
		if (isset($this->request->post['layaway_email_reminder'])) {
			$this->data['layaway_email_reminder'] = $this->request->post['layaway_email_reminder'];
		} else {
			$this->data['layaway_email_reminder'] = $this->config->get('layaway_email_reminder');
		}
		
		if (isset($this->request->post['layaway_status'])) {
			$this->data['layaway_status'] = $this->request->post['layaway_status'];
		} else {
			$this->data['layaway_status'] = $this->config->get('layaway_status');
		}
		
		if (isset($this->request->post['layaway_send_emails'])) {
			$this->data['layaway_send_emails'] = $this->request->post['layaway_send_emails'];
		} else {
			$this->data['layaway_send_emails'] = $this->config->get('layaway_send_emails');
		}
		

                            if (isset($this->request->post['layaway_autoselect_by_product_option'])) {
                                    $this->data['layaway_autoselect_by_product_option'] = $this->request->post['layaway_autoselect_by_product_option'];
                            } else {
                                    $this->data['layaway_autoselect_by_product_option'] = $this->config->get('layaway_autoselect_by_product_option');
                            }                        
                    
		if (isset($this->request->post['layaway_allow_admin'])) {
			$this->data['layaway_allow_admin'] = $this->request->post['layaway_allow_admin'];
		} else {
			$this->data['layaway_allow_admin'] = $this->config->get('layaway_allow_admin');
		}
		
		if (isset($this->request->post['layaway_timeframe'])) {
			$this->data['layaway_timeframe'] = $this->request->post['layaway_timeframe'];
		} else {
			$this->data['layaway_timeframe'] = $this->config->get('layaway_timeframe');
		}
		
		if (isset($this->request->post['layaway_min_amount'])) {
			$this->data['layaway_min_amount'] = $this->request->post['layaway_min_amount'];
		} else {
			$this->data['layaway_min_amount'] = $this->config->get('layaway_min_amount');
		}
		
		if (isset($this->request->post['layaway_payment_fee'])) {
			$this->data['layaway_payment_fee'] = $this->request->post['layaway_payment_fee'];
		} else {
			$this->data['layaway_payment_fee'] = $this->config->get('layaway_payment_fee');
		}
		
		if (isset($this->request->post['layaway_hide_buttons'])) {
			$this->data['layaway_hide_buttons'] = $this->request->post['layaway_hide_buttons'];
		} else {
			$this->data['layaway_hide_buttons'] = $this->config->get('layaway_hide_buttons');
		}
		
		if (isset($this->request->post['layaway_order_status_id'])) {
			$this->data['layaway_order_status_id'] = $this->request->post['layaway_order_status_id'];
		} else {
			$this->data['layaway_order_status_id'] = $this->config->get('layaway_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['layaway_geo_zone_id'])) {
			$this->data['layaway_geo_zone_id'] = $this->request->post['layaway_geo_zone_id'];
		} else {
			$this->data['layaway_geo_zone_id'] = $this->config->get('layaway_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');						
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['layaway_sort_order'])) {
			$this->data['layaway_sort_order'] = $this->request->post['layaway_sort_order'];
		} else {
			$this->data['layaway_sort_order'] = $this->config->get('layaway_sort_order');
		}

		$this->template = 'payment/layaway.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/layaway')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

}

?>