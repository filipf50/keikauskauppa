<?php
// -----------------------------------
// Sliding Shopping Cart for OpenCart
// By Best-Byte
// www.best-byte.com
// -----------------------------------

class ControllerModuleSlidecart extends Controller {
	private $error = array();
 
	public function index() {   
		$this->load->language('module/slidecart');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('slidecart', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_module_settings'] = $this->language->get('text_module_settings');

		$this->data['entry_display'] = $this->language->get('entry_display');			
    $this->data['entry_trigger'] = $this->language->get('entry_trigger');  
    $this->data['entry_from_top'] = $this->language->get('entry_from_top');
    $this->data['entry_fixed'] = $this->language->get('entry_fixed');
    $this->data['entry_loadout'] = $this->language->get('entry_loadout');	
    $this->data['entry_click'] = $this->language->get('entry_click'); 
		$this->data['entry_hover']	= $this->language->get('entry_hover');   
    $this->data['entry_true'] = $this->language->get('entry_true'); 
		$this->data['entry_false']	= $this->language->get('entry_false');    		
		$this->data['entry_left'] = $this->language->get('entry_left'); 
		$this->data['entry_right']	= $this->language->get('entry_right');    	
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_template']	= $this->language->get('entry_template');
		$this->data['entry_moduleinfo'] = $this->language->get('entry_moduleinfo');		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

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
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/slidecart', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/slidecart', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['templates'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}	
		
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');			
		}	
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		$this->data['languages'] = $languages;
		
		if (isset($this->request->post['display'])) { 
			$this->data['display'] = $this->request->post['display']; 
		} else { 
			$this->data['display'] = $this->config->get('display' ); 
		} 

    if (isset($this->request->post['from_top'])) {
			$this->data['from_top'] = $this->request->post['from_top'];
		} else {
			$this->data['from_top'] = $this->config->get('from_top');
		}

    if (isset($this->request->post['trigger'])) {
			$this->data['trigger'] = $this->request->post['trigger'];
		} else {
			$this->data['trigger'] = $this->config->get('trigger');
		}

    if (isset($this->request->post['fixed'])) {
			$this->data['fixed'] = $this->request->post['fixed'];
		} else {
			$this->data['fixed'] = $this->config->get('fixed');
		}

    if (isset($this->request->post['loadout'])) {
			$this->data['loadout'] = $this->request->post['loadout'];
		} else {
			$this->data['loadout'] = $this->config->get('loadout');
		}		

		$this->data['modules'] = array();
		
		if (isset($this->request->post['slidecart_module'])) {
			$this->data['modules'] = $this->request->post['slidecart_module'];
		} elseif ($this->config->get('slidecart_module')) { 
			$this->data['modules'] = $this->config->get('slidecart_module');
		}
						
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		
		$this->template = 'module/slidecart.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/slidecart')) {
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