<?php

class ControllerModuleRollCall extends Controller {

    private $error = array();
 
    public function index() {

	$this->load->language('module/rollcall');

	$this->document->setTitle($this->language->get('heading_title'));
	
        $this->load->model('setting/setting');

	if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
	    $this->model_setting_setting->editSetting('rollcall', $this->request->post);

	    $this->session->data['success'] = $this->language->get('text_success');

	    $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
	}


	$this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_start_date_attribute'] = $this->language->get('entry_start_date_attribute');
        $this->data['entry_end_date_attribute'] = $this->language->get('entry_end_date_attribute');
        $this->data['entry_week_day_attribute'] = $this->language->get('entry_week_day_attribute');
        $this->data['entry_Monday'] = $this->language->get('entry_Monday');
        $this->data['entry_Tuesday'] = $this->language->get('entry_Tuesday');
        $this->data['entry_Wednesday'] = $this->language->get('entry_Wednesday');
        $this->data['entry_Thursday'] = $this->language->get('entry_Thursday');
        $this->data['entry_Friday'] = $this->language->get('entry_Friday');
        $this->data['entry_Saturday'] = $this->language->get('entry_Saturday');
        $this->data['entry_Sunday'] = $this->language->get('entry_Sunday');
        
	
	$this->data['token'] = $this->session->data['token'];

	$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
	$this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_module'] = $this->language->get('text_module');

	$this->data['button_save'] = $this->language->get('button_save');
	$this->data['button_cancel'] = $this->language->get('button_cancel');
        
        $this->load->model('localisation/language');
        $this->data['languages'] = $this->model_localisation_language->getLanguages();
        
        if (isset($this->request->post['rc_status'])) {
	    $this->data['rc_status'] = $this->request->post['rc_status'];
	} else {
	    $this->data['rc_status'] = $this->config->get('rc_status');
	}  
        
        //Attributes
        
        if (isset($this->request->post['rc_attribute_start_date'])) {
	    $this->data['rc_attribute_start_date'] = $this->request->post['rc_attribute_start_date'];
	} else {
            $this->data['rc_attribute_start_date'] = $this->config->get('rc_attribute_start_date');
	}

        if (isset($this->request->post['rc_attribute_id_start_date'])) {
	    $this->data['rc_attribute_id_start_date'] = $this->request->post['rc_attribute_id_start_date'];
	} else {
	    $this->data['rc_attribute_id_start_date'] = $this->config->get('rc_attribute_id_start_date');
	}  
        
        if (isset($this->request->post['rc_attribute_end_date'])) {
	    $this->data['rc_attribute_end_date'] = $this->request->post['rc_end_date_attribute'];
	} else {
	    $this->data['rc_attribute_end_date'] = $this->config->get('rc_attribute_end_date');
	}
        
        if (isset($this->request->post['rc_attribute_id_end_date'])) {
	    $this->data['rc_attribute_id_end_date'] = $this->request->post['rc_attribute_id_end_date'];
	} else {
	    $this->data['rc_attribute_id_end_date'] = $this->config->get('rc_attribute_id_end_date');
	}
        
        if (isset($this->request->post['rc_attribute_week_day'])) {
	    $this->data['rc_attribute_week_day'] = $this->request->post['rc_attribute_week_day'];
	} else {
	    $this->data['rc_attribute_week_day'] = $this->config->get('rc_attribute_week_day');
	}
        
        if (isset($this->request->post['rc_attribute_id_week_day'])) {
	    $this->data['rc_attribute_id_week_day'] = $this->request->post['rc_attribute_id_week_day'];
	} else {
	    $this->data['rc_attribute_id_week_day'] = $this->config->get('rc_attribute_id_week_day');
	}
        
        //Week days
        if(isset($this->request->post['rc_monday_description'])){
            $this->data['rc_monday_description']=$this->request->post['rc_monday_description'];
        }else{
            $this->data['rc_monday_description']=$this->config->get('rc_monday_description');
        }
        
        if(isset($this->request->post['rc_tuesday_description'])){
            $this->data['rc_tuesday_description']=$this->request->post['rc_tuesday_description'];
        }else{
            $this->data['rc_tuesday_description']=$this->config->get('rc_tuesday_description');
        }
        
        if(isset($this->request->post['rc_wednesday_description'])){
            $this->data['rc_wednesday_description']=$this->request->post['rc_wednesday_description'];
        }else{
            $this->data['rc_wednesday_description']=$this->config->get('rc_wednesday_description');
        }
        
        if(isset($this->request->post['rc_thursday_description'])){
            $this->data['rc_thursday_description']=$this->request->post['rc_thursday_description'];
        }else{
            $this->data['rc_thursday_description']=$this->config->get('rc_thursday_description');
        }
        
        if(isset($this->request->post['rc_friday_description'])){
            $this->data['rc_friday_description']=$this->request->post['rc_friday_description'];
        }else{
            $this->data['rc_friday_description']=$this->config->get('rc_friday_description');
        }
        
        if(isset($this->request->post['rc_saturday_description'])){
            $this->data['rc_saturday_description']=$this->request->post['rc_saturday_description'];
        }else{
            $this->data['rc_saturday_description']=$this->config->get('rc_saturday_description');
        }
        
        if(isset($this->request->post['rc_sunday_description'])){
            $this->data['rc_sunday_description']=$this->request->post['rc_sunday_description'];
        }else{
            $this->data['rc_sunday_description']=$this->config->get('rc_sunday_description');
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


	$this->load->model('module/rollcall');

	$this->data['roll_call_installed'] = $this->model_module_rollcall->install();
        
        $this->data['action'] = $this->url->link('module/rollcall', 'token=' . $this->session->data['token'], 'SSL');

	$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

	$this->load->model('localisation/order_status');

	$this->data['order_status_list'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('design/layout');

	$this->data['layouts'] = $this->model_design_layout->getLayouts();
	
        $this->template = 'module/rollcall.tpl';
	$this->children = array(
	    'common/header',
	    'common/footer',
	);

	$this->response->setOutput($this->render());
    }
    public function option_warning() {

	    $this->load->language('module/rollcall');

	    $this->response->setOutput('<div class="attention">'.str_replace('{heading_title}','<a href="index.php?route=module/rollcall&amp;token='.$this->session->data['token'].'">'.$this->language->get('heading_title').'</a>', $this->language->get('option_warning')).'</div>');

    }
    
}

?>