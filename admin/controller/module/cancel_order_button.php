<?php

class ControllerModuleCancelOrderButton extends Controller {

    private $error = array();
 
    public function index() {

	$this->load->language('module/cancel_order_button');

	$this->document->setTitle($this->language->get('heading_title'));
	
        $this->load->model('setting/setting');

	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	    $this->model_setting_setting->editSetting('cancel_order_button', $this->request->post);

	    $this->session->data['success'] = $this->language->get('text_success');

	    $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
	}


	$this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_order_statuses'] = $this->language->get('entry_order_statuses');
        $this->data['entry_cancelled_status'] = $this->language->get('entry_cancelled_status');
        
	
	$this->data['token'] = $this->session->data['token'];

	$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
	$this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_module'] = $this->language->get('text_module');

	$this->data['button_save'] = $this->language->get('button_save');
	$this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->request->post['cob_status'])) {
	    $this->data['cob_status'] = $this->request->post['cob_status'];
	} else {
	    $this->data['cob_status'] = $this->config->get('cob_status');
	}  
        
        if (isset($this->request->post['cob_order_statuses_allow_cancel'])) {
	    $this->data['cob_order_statuses_allow_cancel'] = $this->request->post['cob_order_statuses_allow_cancel'];
	} else if(!is_null($this->config->get('cob_order_statuses_allow_cancel'))) {
	    $this->data['cob_order_statuses_allow_cancel'] = explode(',',$this->config->get('cob_order_statuses_allow_cancel'));
	} else {
            $this->data['cob_order_statuses_allow_cancel']=array();
        }
        
        if (isset($this->request->post['cob_cancelled_status_id'])) {
	    $this->data['cob_cancelled_status_id'] = $this->request->post['cob_cancelled_status_id'];
	} else {
	    $this->data['cob_cancelled_status_id'] = $this->config->get('cob_cancelled_status_id');
	} 

	$this->data['breadcrumbs'] = array();

	$this->data['breadcrumbs'][] = array(
	    'text' => $this->language->get('text_home'),
	    'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
	    'separator' => false
	);

	$this->data['breadcrumbs'][] = array(
	    'text' => $this->language->get('text_module'),
	    'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
	    'separator' => ' :: '
	);

	$this->data['breadcrumbs'][] = array(
	    'text' => $this->language->get('heading_title'),
	    'href' => $this->url->link('module/cancel_order_button', 'token=' . $this->session->data['token'], 'SSL'),
	    'separator' => ' :: '
	);


	$this->data['action'] = $this->url->link('module/cancel_order_button', 'token=' . $this->session->data['token'], 'SSL');

	$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

	$this->load->model('localisation/order_status');

	$this->data['order_status_list'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('design/layout');

	$this->data['layouts'] = $this->model_design_layout->getLayouts();
	
        $this->template = 'module/cancel_order_button.tpl';
	$this->children = array(
	    'common/header',
	    'common/footer',
	);

	$this->response->setOutput($this->render());
    }
    public function option_warning() {

	    $this->load->language('module/cancel_order_button');

	    $this->response->setOutput('<div class="attention">'.str_replace('{heading_title}','<a href="index.php?route=module/notify_when_arrives&amp;token='.$this->session->data['token'].'">'.$this->language->get('heading_title').'</a>', $this->language->get('option_warning')).'</div>');

    }
    private function validate() {
	if (!$this->user->hasPermission('modify', 'module/cancel_order_button')) {
	    $this->error['warning'] = $this->language->get('error_permission');
	}
	if (isset($this->request->post['cob_order_statuses_allow_cancel'])){
	    $this->request->post['cob_order_statuses_allow_cancel'] =  implode(',',  $this->request->post['cob_order_statuses_allow_cancel']);
	}
	if (!$this->error) {
	    return true;
	} else {
	    return false;
	}
    }

}

?>