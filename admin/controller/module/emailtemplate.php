<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class ControllerModuleEmailtemplate extends Controller {

	private $error = array();
	private $params = null;
	private $vqmod_files = array('0pencart_emailtemplate', 'emailtemplate', 'emailtemplate_admin');

	public function index() {			
		$this->load->model('setting/setting');
		$this->load->model('module/emailtemplate');
		$this->load->language('module/emailtemplate');

		$this->document->setTitle($this->language->get('heading'));
		
		$this->data['store_id'] = (isset($this->request->get['store_id'])) ? $this->request->get['store_id'] : 0;
		
		# Edit Settings
		$this->data['form_url'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'] . '&store_id='.$this->data['store_id'], 'SSL');
		
		if($this->params === null){			
			if (isset($this->request->get['store_id'])) {
				$this->params .= '&store_id=' . $this->request->get['store_id'];
			}			
			if (isset($this->request->get['sort'])) {
				$this->params .= '&sort=' . $this->request->get['sort'];
			}			
			if (isset($this->request->get['order'])) {
				$this->params .= '&order=' . $this->request->get['order'];
			}			
			if (isset($this->request->get['page'])) {
				$this->params .= '&page=' . $this->request->get['page'];
			}
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {			
			foreach($this->request->post['store'] as $store_id => $data){
				
				foreach($data['emailtemplate_unsubscribe'] as $langId => $val) {
					$data['emailtemplate_unsubscribe'][$langId] = $this->db->escape($val);
				}
				
				# Each store save store data into settings
				$this->model_setting_setting->editSetting('emailtemplate', $data, $store_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			if (isset($this->request->post['send_to'])) {
				$storeId = key($this->request->post['send_to']);
				$langId = key($this->request->post['send_to'][$storeId]);
				$email = $this->request->post['send_to'][$storeId][$langId];
				if($this->_validateEmail($email)){					
					if($this->sendTestEmail($email, $storeId, $langId)){
						$this->session->data['success'] = $this->language->get('text_success_send');
					}
				}
			}

			if (isset($this->request->get['exit'])) {
				$this->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('module/emailtemplate', 'token='.$this->session->data['token'].'&store_id='.$this->data['store_id'], 'SSL'));
			}
		}
				
		$this->getForm();
		$this->getTemplates();
		
		$this->display('module/emailtemplate/extension.tpl');
	}
	
	/**
	 * Install module
	 */
	public function install() {
		$this->load->language('module/emailtemplate');
		$this->load->model('module/emailtemplate');
		
		if(!class_exists('VQMod')) {
			die('Error: check vqmod installed for admin/index.php, vqcache files are getting generated &amp; upgrade vqmod version greater than: 2.4.0');
		}
		
		$classVQMod = new ReflectionClass('VQMod');
		if(!$classVQMod->isAbstract()){
			$this->session->data['error'] = 'Warning: old vqmod version detected, upgrade to version (greater than: 2.4.0)';
		}
		
		# Re-name vqmod files
		$vqmod_path = str_replace("/system", "/vqmod", DIR_SYSTEM);
		$rename = false;
		foreach($this->vqmod_files as $filename){
			if (file_exists($vqmod_path."xml/".$filename.'.xml_')) {
				rename($vqmod_path."xml/".$filename.'.xml_', $vqmod_path."xml/".$filename.'.xml');
				$rename = true;
			}
		}
		if($rename){
			# redirect back to self to ensure vqmod creates cached files.
			$this->redirect($this->url->link('extension/module/install', 'token=' . $this->session->data['token'] . '&extension=emailtemplate', 'SSL'));
		}
		
		if($this->model_module_emailtemplate->install()){
			$this->session->data['success'] = $this->language->get('install_success');
			return true;
		}
	}

	/**
	 * Delete module settings for each store.
	 */
	public function uninstall() {
		$this->load->language('module/emailtemplate');

		if (!$this->user->hasPermission('modify', 'module/emailtemplate')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			$this->load->model('module/emailtemplate');
			
			foreach ($this->model_setting_store->getStores() as $store) {
				$this->model_setting_setting->deleteSetting("emailtemplate", $store['store_id']);
			}

			$this->model_module_emailtemplate->uninstall();
			
			# Re-name vqmod files
			$vqmod_path = str_replace("system", "vqmod", DIR_SYSTEM);
			foreach($this->vqmod_files as $filename){
				if (file_exists($vqmod_path."xml/".$filename.'.xml')) {
					rename($vqmod_path."xml/".$filename.'.xml', $vqmod_path."xml/".$filename.'.xml_');
				}
			}
			# Clear vqmod cache
			if(file_exists($vqmod_path.'mods.cache')){
				unlink($vqmod_path.'mods.cache');
			}
			$files = glob($vqmod_path.'vqcache/vq*');
			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						@unlink($file);
						clearstatcache();
					}
				}
			}
		}
	}

	/**
	 * Create new template
	 */
	public function insert_template(){
		$this->load->language('module/emailtemplate');
		$this->load->model('module/emailtemplate');
	
		$this->document->setTitle($this->language->get('heading_template'));
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateTemplateForm()) {
			$new_id = $this->model_module_emailtemplate->insertTemplate($this->request->post);
				
			$url = '';
			if ($new_id) {
				$url .= '&id='.$new_id;
				$this->session->data['success'] = $this->language->get('text_success');
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['exit'])) {
				$this->redirect($this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('module/emailtemplate/update_template', 'token='.$this->session->data['token'] . $url, 'SSL'));
			}
		}
		
		$this->data['insertMode'] = true;	
		$this->getTemplateForm();
		
		$this->display('module/emailtemplate/template_form.tpl');
	}
	
	/**
	 * Update existing template
	 */
	public function update_template() {
		$this->language->load('module/emailtemplate');
		$this->load->model('module/emailtemplate');
	
		$this->document->setTitle($this->language->get('heading_template'));
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateTemplateForm()) {			
			if(isset($this->request->post['delete_btn'])){
				$result = $this->model_module_emailtemplate->deleteTemplate($this->request->get['id']);
				if($result){
					$this->session->data['success'] = $this->language->get('text_success');
					$this->redirect($this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL'));
				}
			} else {
				if($this->model_module_emailtemplate->updateTemplate($this->request->get['id'], $this->request->post)){
					$this->session->data['success'] = $this->language->get('text_success');
				}
				
				$url = '&id='.$this->request->get['id'];
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['exit'])) {
					$this->redirect($this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL'));
				} else {
					$this->redirect($this->url->link('module/emailtemplate/update_template', 'token='.$this->session->data['token'] . $url, 'SSL'));
				}
			}
		}
	
		$this->getTemplateForm();	
			
		$this->display('module/emailtemplate/template_form.tpl');
	}
	
	/**
	 * Load language editor
	 */
	public function language_files() {
		$this->language->load('module/emailtemplate');
		$this->load->model('module/emailtemplate');
		$this->load->model('localisation/language');
	
		# Language text
		$this->data = array_merge($this->data, $this->load->language('module/emailtemplate'));
		
		# Search
		if(isset($this->request->post['search']) && $this->request->post['search']){
			$this->data['search'] = $this->request->post['search'];
		} else {
			$this->data['search'] = '';
		}
		
		$this->document->setTitle($this->language->get('heading_language'));
		
		if(isset($this->request->post['language'])){
			$this->data['id'] = intval($this->request->post['language']);
		} else {
			$this->data['id'] = $this->config->get('config_language_id');
		}
		if(isset($this->request->post['admin'])){
			$this->data['type'] = 'admin';
		} else {
			$this->data['type'] = 'catalog';
		}
		
		# Messages
		$this->populateMessages();
		
		# Security token
		$this->data['token'] = $this->session->data['token'];
			
		$this->populateBreadcrumbs(array('heading_language' => array(
			'link' => 'module/emailtemplate/language_files',
			'params' => '&id='.$this->data['id']
		)));
		
		$this->data['action'] = $this->url->link('module/emailtemplate/language_files', 'token='.$this->session->data['token'] . '&id=' . $this->data['id'], 'SSL');
		$this->data['cancel'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL');
		
		switch($this->data['type']){
			case 'admin':
				$dir = DIR_LANGUAGE;
			break;
			
			default;
			case 'catalog':
				$dir = DIR_CATALOG . 'language/';
		}
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
				
		$language = $this->model_localisation_language->getLanguage($this->data['id']);
		if(!$language || !isset($language['directory'])) 
			return false;
		
		$dir = rtrim($dir . str_replace('../', '', $language['directory']), '/');
		$directories = glob($dir.'/*', GLOB_ONLYDIR);
		
		sort($directories); //sort($directories, SORT_NATURAL | SORT_FLAG_CASE);
		
		$this->data['language_files'] = array();
		$this->data['language_files_count'] = 0;
		
		if ($directories) {				
			foreach ($directories as $directory) {
				$i = basename($directory);
				$this->data['language_files'][$i] = array();
				$this->data['language_files'][$i]['dir'] = $directory;
								
				$files = glob(rtrim($directory, '/') . '/*.php');					
				if ($files)  {
					sort($files);
					
					$this->data['language_files'][$i]['files'] = array();
					
					foreach ($files as $ii => $file) {
						$ii = basename($file, ".php");
						
						if(mb_substr($ii, -1) == '_') continue;

						if($this->data['search']){
							$contents = file_get_contents($file);						
							if(strpos($contents, $this->data['search']) === false) {
								continue;
							}
						}
						
						$this->data['language_files'][$i]['files'][$ii] = array(
							'file' => ltrim(str_replace($directory, '', $file), '/'),
							'action' => $this->url->link('module/emailtemplate/language_file', 'file=' . $language['directory'] . '/' . $i . '/' . $ii . '&type=' . $this->data['type'] .  '&token='.$this->session->data['token'], 'SSL')
						);	

						$this->data['language_files_count']++;
					}
				}
			}
		}
							
		$this->display('module/emailtemplate/language_files.tpl');
	}
				
	/**
	 * Parse Template Tags
	 */
	public function language_file() {	
		$this->language->load('module/emailtemplate');
		$this->load->model('module/emailtemplate');
		$this->load->model('localisation/language');
		
		# Language text
		$this->data = array_merge($this->data, $this->load->language('module/emailtemplate'));
		
		# URL params
		if(isset($this->request->get['type'])){
			$this->data['type'] = $this->request->get['type'];
		} else {
			return false;
		}
		
		if(isset($this->request->get['file'])){
			$this->data['file'] = $this->request->get['file'];
		} else {
			return false;
		}
		
		# Type
		if($this->data['type'] == 'admin'){
			$dir = DIR_LANGUAGE;
		} else {
			$dir = DIR_CATALOG . 'language/';
		}
		
		list($language, $directory, $file) = explode('/', $this->data['file']);
					
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$result = $this->model_module_emailtemplate->saveLanguageFile($dir, $language, $directory, $file, $this->request->post['vars']);
			
			if(is_array($result)) {
				$this->error['warning'] = sprintf($this->language->get('error_language_permissions'), str_replace(str_replace('/system', '', DIR_SYSTEM), '', $result['file']));
				$this->data['manual'] = $result;				
				$this->data['manual']['info'] = sprintf($this->language->get('text_language_permissions'), $result['filename'], $result['path']);				
			} else {
				if($result === true){
					$this->session->data['success'] = $this->language->get('text_success');
				}				
				if (isset($this->request->get['exit'])) {
					$this->redirect($this->url->link('module/emailtemplate/language_files', 'token='.$this->session->data['token'], 'SSL'));
				} else {
					$this->redirect($this->url->link('module/emailtemplate/language_file', 'token='.$this->session->data['token'].'&file='.$this->data['file'].'&type='.$this->data['type'], 'SSL'));
				}
			}
		}
		
		$this->document->setTitle($this->language->get('heading_language'). ' - ' . $this->data['file']);
		
		# Messages
		$this->populateMessages();

		# Security token
		$this->data['token'] = $this->session->data['token'];

		$this->populateBreadcrumbs(array(
			'heading_language' => array(
				'link' => 'module/emailtemplate/language_files'
			),
			$this->data['file'] => array(
				'link' => 'module/emailtemplate/language_file',
				'params' => '&file='.$this->data['file']
			)			
		));
			
		$this->data['action'] = $this->url->link('module/emailtemplate/language_file', 'token='.$this->session->data['token'].'&file='.$this->data['file'].'&type='.$this->data['type'], 'SSL');
		$this->data['action_exit'] = $this->url->link('module/emailtemplate/language_file', 'token='.$this->session->data['token'].'&file='.$this->data['file'].'&type='.$this->data['type'].'&exit=true', 'SSL');
		$this->data['cancel'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL');
				
		# Load language
		$language = new Language($language);
		$language->setPath($dir);
		$language_vars = $language->load($directory.'/'.$file);
		
		$this->data['language_vars'] = array();
		
		foreach($language_vars as $key => $value){
			if(isset($this->request->post['vars'][$key])){
				$value = $this->request->post['vars'][$key];
			}
			$this->data['language_vars'][] = array(
				'key' => $key,
				'value' => $value,
				'hasHtml' => ($value == strip_tags(html_entity_decode($value,ENT_QUOTES,'UTF-8'))) ? false : true
			);
		}
				
		$this->display('module/emailtemplate/language_file_form.tpl');
	}
				
	/**
	 * Parse Template Tags
	 */
	public function fetch_template() {	
		if(!isset($this->request->post['id'])) return false;
		$this->load->model('module/emailtemplate');
		echo $this->model_module_emailtemplate->parseTemplate($this->request->post['id'], $this->request->post);		
		exit;
	}
	
	/**
	 * Documentation
	 */
	public function docs() {	
		# Language text
		$this->data = array_merge($this->data, $this->load->language('module/emailtemplate'));
		
		$this->document->setTitle($this->language->get('heading_docs'));
		
		$this->data['support_url'] = 'http://support.opencart-templates.co.uk/open.php';
		$this->data['customer_register_url'] = $this->_link('account/register');
		$this->data['customer_forgot_url'] = $this->_link('account/forgotten');
		$this->data['checkout_url'] = $this->_link('checkout/cart');
		$this->data['contact_url'] = $this->_link('information/contact');
		$this->data['affiliate_register_url'] = $this->_link('affiliate/register');
		$this->data['affiliate_forgot_url'] = $this->_link('affiliate/forgotten');
		$this->data['voucher_url'] = $this->_link('account/voucher');
		$this->data['return_url'] = $this->_link('account/return/insert');
		
		$this->data['url'] = $this->_link('module/emailtemplate/docs', 'ADMIN');
		$this->data['order_url'] = $this->_link('sale/order', 'ADMIN');
		$this->data['newsletter_url'] = $this->_link('sale/contact', 'ADMIN');
		$this->data['customer_url'] = $this->_link('sale/customer', 'ADMIN');
		$this->data['affiliate_url'] = $this->_link('sale/affiliate', 'ADMIN');
		$this->data['voucher_url'] = $this->_link('sale/voucher', 'ADMIN');
		$this->data['return_url'] = $this->_link('sale/return', 'ADMIN');
		
		$i=1;
		foreach(array('name'=>$this->config->get("config_owner").' - '.$this->config->get("config_name"), 'email'=>$this->config->get("config_email"), 'protocol'=>$this->config->get("config_mail_protocol"), 'storeUrl'=>HTTP_CATALOG, 'opencartVersion'=>VERSION, 'vqmodVersion'=>VQMod::$_vqversion, 'phpVersion'=>phpversion()) as $key=>$val){
			$this->data['support_url'] .= (($i == 1) ? '?' : '&amp;') . $key . '=' . urlencode(html_entity_decode($val,ENT_QUOTES,'UTF-8'));
			$i++;
		}
		
		$this->populateBreadcrumbs(array('text_docs' => array(
			'link' => 'module/emailtemplate/docs'
		)));
		
		$this->display('module/emailtemplate/docs.tpl');
	}
	
	/**
	 * Get Extension Form
	 */
	private function getForm(){	
		# Load extra models
		$this->load->model('setting/store');
		$this->load->model('tool/image');
		$this->load->model('localisation/language');
		# Language text
		$this->data = array_merge($this->data, $this->load->language('module/emailtemplate'));
		
		# Messages
		$this->populateMessages();
				
		# Security token
		$this->data['token'] = $this->session->data['token'];
		
		# Breadcrumbs
		$this->populateBreadcrumbs();
		
		# URLs
		$this->data['action'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'].'&store_id='.$this->data['store_id'], 'SSL');
		$this->data['action_exit'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'].'&exit=true', 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL');
		
		$this->data['language_url'] = $this->url->link('module/emailtemplate/language_files', 'token='.$this->session->data['token'].'&id='.$this->config->get('config_language_id'), 'SSL');		
		$this->data['docs_url'] = $this->url->link('module/emailtemplate/docs', 'token='.$this->session->data['token'], 'SSL');		
		$this->data['support_url'] = 'http://support.opencart-templates.co.uk/open.php';
		$i = 1;
		foreach(array('name'=>$this->config->get("config_owner").' - '.$this->config->get("config_name"), 'email'=>$this->config->get("config_email"), 'protocol'=>$this->config->get("config_mail_protocol"), 'storeUrl'=>HTTP_CATALOG, 'version'=>EmailTemplate::$version, 'opencartVersion'=>VERSION, 'vqmodVersion'=>VQMod::$_vqversion, 'phpVersion'=>phpversion()) as $key=>$val){
			$this->data['support_url'] .= (($i == 1) ? '?' : '&amp;') . $key . '=' . urlencode(html_entity_decode($val,ENT_QUOTES,'UTF-8'));
			$i++;
		}
		
		# Langauges
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		# Installed Themes
		$this->data['themes'] = array();
		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		foreach ($directories as $directory) {
			$this->data['themes'][] = basename($directory);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		if($this->config->get("config_logo") && file_exists(DIR_IMAGE.$this->config->get("config_logo"))){
			list($config_logo_width, $config_logo_height) = getimagesize(DIR_IMAGE.$this->config->get("config_logo"));
		} else {
			$config_logo_width = 0;
			$config_logo_height = 0;
		}
		
		# Setup Data for each store with defualt values.
		$config_data = array(
			'emailtemplate_body_comment_length' 		=> 255,
			'emailtemplate_email_width' 				=> 580,
			'emailtemplate_page_bg_color' 				=> '#FFFFFF',
			'emailtemplate_page_padding' 				=> 25,
			'emailtemplate_body_bg_color' 				=> '#F9F9F9',
			'emailtemplate_body_font_color' 			=> '#333333',
			'emailtemplate_body_link_color' 			=> '#28B0EC',
			'emailtemplate_body_heading_color' 			=> '#079bdc',
			'emailtemplate_body_product_option_length'  => 20,
			'emailtemplate_body_product_option_size' 	=> 11,
			'emailtemplate_body_section_bg_color'		=> '',
			'emailtemplate_page_footer_text' 			=> '',
			'emailtemplate_contactus_customer' 			=> 0,
			'emailtemplate_customer_password' 			=> 0,
			'emailtemplate_footer_text' 				=> '<p style="text-align:center; margin:0; padding:0;">Powered by <a href="http://www.opencart.com" target="_blank" style="text-decoration:none; color:#28B0EC;">Opencart</a>, Designed By <a href="http://www.opencart-templates.co.uk" target="_blank" style="text-decoration:none; color:#28B0EC;">OpenCart-templates</a>.</p>',
			'emailtemplate_footer_align'		 		=> 'center',
			'emailtemplate_footer_valign'				=> 'middle',
			'emailtemplate_footer_font_color' 			=> '#333333',
			'emailtemplate_footer_height' 				=> 30,
			'emailtemplate_footer_section_bg_color' 	=> '',
			'emailtemplate_header_bg_color' 			=> '#515151',
			'emailtemplate_header_bg_image' 			=> 'data/emailtemplate/head-bg.jpg',
			'emailtemplate_header_height' 				=> 130,
			'emailtemplate_header_border_color' 		=> '',
			'emailtemplate_header_border_height' 		=> '',
			'emailtemplate_header_section_bg_color' 	=> '',
			'emailtemplate_head_text' 					=> '',
			'emailtemplate_head_section_bg_color'		=> '',
			'emailtemplate_invoice_color'				=> '#28B0EC',
			'emailtemplate_invoice_heading_color'		=> '#333333',
			'emailtemplate_invoice_logo'				=> $this->config->get("config_logo"),
			'emailtemplate_invoice_logo_width' 			=> 90,
			'emailtemplate_invoice_products_limit' 		=> 15,
			'emailtemplate_invoice_text'				=> '',
			'emailtemplate_invoice_title'				=> '',
			'emailtemplate_logo' 						=> $this->config->get("config_logo"),
			'emailtemplate_logo_align' 					=> 'center',
			'emailtemplate_logo_font_color'				=> '#32C6F0',
			'emailtemplate_logo_font_size' 				=> 30,
			'emailtemplate_logo_height' 				=> $config_logo_height,
			'emailtemplate_logo_valign' 				=> 'middle',
			'emailtemplate_logo_resize' 				=> true,
			'emailtemplate_logo_width' 					=> $config_logo_width,
			'emailtemplate_shadow_top_start'			=> '',
			'emailtemplate_shadow_left_start'			=> '#f8f8f8',
			'emailtemplate_shadow_right_start'			=> '#d4d4d4',
			'emailtemplate_shadow_bottom_start'			=> '#d4d4d4',
			'emailtemplate_shadow_top_end'				=> '',
			'emailtemplate_shadow_bottom_end'			=> '#f8f8f8',
			'emailtemplate_shadow_left_end'				=> '#d4d4d4',
			'emailtemplate_shadow_right_end'			=> '#f8f8f8',
			'emailtemplate_shadow_top_length'			=> 0,
			'emailtemplate_shadow_right_length'			=> 9,
			'emailtemplate_shadow_bottom_length'		=> 9,
			'emailtemplate_shadow_left_length'			=> 9,
			'emailtemplate_shadow_top_overlap'			=> 0,
			'emailtemplate_shadow_right_overlap'		=> 8,
			'emailtemplate_shadow_bottom_overlap'		=> 8,
			'emailtemplate_shadow_left_overlap'			=> 8,
			'emailtemplate_shadow_top_right_img'		=> '',
			'emailtemplate_shadow_top_left_img'  		=> '',
			'emailtemplate_shadow_bottom_left_img' 		=> 'data/emailtemplate/gray/bottom_left.png',
			'emailtemplate_shadow_bottom_right_img'		=> 'data/emailtemplate/gray/bottom_right.png',
			'emailtemplate_showcase'					=> '',
			'emailtemplate_showcase_limit'				=> 5,
			'emailtemplate_showcase_selection'			=> '',
			'emailtemplate_showcase_section_bg_color'	=> '',
			'emailtemplate_showcase_page_bg_color'		=> '',
			'emailtemplate_showcase_title'				=> 'You May Also Like',			
			'emailtemplate_text_align'					=> 'left',
			'emailtemplate_tracking_campaign_name' 		=> $this->config->get("config_name"),
			'emailtemplate_order_picture' 				=> 0,
			'emailtemplate_theme' 						=> 'default',
			'emailtemplate_unsubscribe' 				=> '&lt;a href=&quot;%s&quot;&gt;Unsubscribe&lt;/a&gt; from our newsletter'
		);
		
		# Stores
		$this->data['stores'] = array();
		$this->data['stores'][0] = array(
			'store_id' 	 => 0,
			'store_name' => ((strlen($this->config->get('config_name')) > 20) ? substr(strip_tags(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')), 0, 20) . '...' : $this->config->get('config_name')).$this->language->get('text_default'),
			'store_name_long' => strip_tags(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')).$this->language->get('text_default')
		);
		foreach ($this->model_setting_store->getStores() as $result) {
			$this->data['stores'][$result['store_id']] = array(
				'store_id'	 => $result['store_id'],
				'store_name' => (strlen($result['name']) > 20) ? substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, 20) . '...' : $result['name'],
				'store_name_long' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
			);
		}
		
		# Get store settings and set view data
		$stores = array($this->data['store_id'] => $this->data['stores'][$this->data['store_id']]);
		$this->data['showcase_selection'] = array();
		
		foreach($stores as $store){
			$store_id = $store['store_id'];
			$store_settings = $this->model_setting_setting->getSetting("emailtemplate", $store_id);
		
			# View data of the store which should be set
			$this->data['stores'][$store_id] = array();
			$data_store = &$this->data['stores'][$store_id];
		
			$this->data['stores'][$store_id]['store_id'] = $store['store_id'];
			$this->data['stores'][$store_id]['store_name'] = $store['store_name_long'];
		
			foreach($this->data['languages'] as $language){		
				$language_id = $language['language_id'];		
				$hasIncompleteData = false;
				
				foreach ($config_data as $_config => $_config_default) {		
					$value = null;
					if (isset($this->request->post['store'][$store_id][$_config][$language_id])) {
						# Post
						$value = $this->request->post['store'][$store_id][$_config][$language_id];
					} elseif (isset($store_settings[$_config][$language_id])) {
						# Store settings
						$value = $store_settings[$_config][$language_id];
					} else {
						# Or default
						$value = $_config_default;
						$hasIncompleteData = true;
					}
					$data_store[$_config][$language_id] = $value;
				}
				
				if ($data_store['emailtemplate_logo'][$language_id] && file_exists(DIR_IMAGE . $data_store['emailtemplate_logo'][$language_id])) {
					if ($data_store['emailtemplate_logo_resize'][$language_id] && $data_store['emailtemplate_logo_width'][$language_id] && $data_store['emailtemplate_logo_height'][$language_id]){
						$data_store['emailtemplate_logo_thumb'][$language_id] = $this->model_tool_image->resize(
							$data_store['emailtemplate_logo'][$language_id],
							$data_store['emailtemplate_logo_width'][$language_id],
							$data_store['emailtemplate_logo_height'][$language_id]
						);
					} else {
						$data_store['emailtemplate_logo_thumb'][$language_id] = $this->model_tool_image->get($data_store['emailtemplate_logo'][$language_id]);
					}
				} else {
					$data_store['emailtemplate_logo_thumb'][$language_id] = $this->data['no_image'];
				}
				
				if ($data_store['emailtemplate_header_bg_image'][$language_id] && file_exists(DIR_IMAGE . $data_store['emailtemplate_header_bg_image'][$language_id])) {
					$data_store['emailtemplate_header_bg_image_thumb'][$language_id] = $this->model_tool_image->get($data_store['emailtemplate_header_bg_image'][$language_id]);
				} else {
					$data_store['emailtemplate_header_bg_image_thumb'][$language_id] = $this->data['no_image'];
				}
					
				if ($data_store['emailtemplate_invoice_logo'][$language_id] && file_exists(DIR_IMAGE . $data_store['emailtemplate_invoice_logo'][$language_id])) {
					$data_store['emailtemplate_invoice_logo_thumb'][$language_id] = $this->model_tool_image->get($data_store['emailtemplate_invoice_logo'][$language_id]);
				} else {
					$data_store['emailtemplate_invoice_logo_thumb'][$language_id] = $this->data['no_image'];
				}
					
				$thumbs = array('shadow_top_right_img', 'shadow_top_left_img', 'shadow_bottom_right_img', 'shadow_bottom_left_img');
				foreach($thumbs as $col){
					if ($data_store['emailtemplate_'.$col][$language_id] && file_exists(DIR_IMAGE . $data_store['emailtemplate_'.$col][$language_id])) {
						$data_store['emailtemplate_'.$col.'_thumb'][$language_id] = $this->model_tool_image->get($data_store['emailtemplate_'.$col][$language_id]);
					} else {
						$data_store['emailtemplate_'.$col.'_thumb'][$language_id] = '';
					}
				}
				
				if($hasIncompleteData == false){
					$this->data['showcase_selection'][$language_id] = $this->model_module_emailtemplate->loadShowcase($store_id, $language_id);
					
					# Get first order_id
					$result = $this->db->query("SELECT `order_id` FROM `" . DB_PREFIX . "order` ORDER BY `order_id` DESC LIMIT 1");
					if($result->row){
												
						# Load preview only if the module has been saved.
						if(!empty($store_settings)){
							$email = $this->model_module_emailtemplate->getCompleteOrderEmail($result->row['order_id'], $store_id, $language_id);
							if(isset($email['html'])){
								$this->data['demo_html'][$store_id][$language_id] = $this->extractHtml($email['html'], "body");
							} else {
								$this->data['demo_html'][$store_id][$language_id] = sprintf($this->language->get('error_templates_notfound'), DIR_CATALOG, $data_store['emailtemplate_theme'][$language_id]);
							}
						}
					} else {
						$this->data['error_attention'] = $this->language->get('text_no_orders');
					}
				} else {
					if(empty($this->data['success'])){
						$this->data['error_attention'] = $this->language->get('install_success');
					}
				}
			} # end foreach($this->data['languages'])
			unset($data_store);			
		}
		
		if($hasIncompleteData == true){
			$this->model_module_emailtemplate->install();
		}
	}			
	
	/**
	 * Get Templates
	 */
	private function getTemplates(){				
		if (isset($this->request->get['type'])) {
			$type = $this->request->get['type'];
		} else {
			$type = '';
		}
				
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$data = array(
			'type'  => $type,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$templates_total = $this->model_module_emailtemplate->getTotalTemplates($data);		
		$results = $this->model_module_emailtemplate->getTemplates($data);
		
		$this->data['templates'] = array();
		foreach ($results as $result) {		
			$body = strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8'));
			$this->data['templates'][] = array(
				'id' 		  => $result['id'],
				'language_id' => $result['language_id'],
				'name'    	  => $result['name'],
				'body' 		  => $body,
				'desc' 		  => (mb_strlen($body) > 50) ? (mb_substr($body, 0, 50).'...') : $body,
				'type'        => $result['type'],
				'url'    	  => $this->url->link('module/emailtemplate/update_template', 'token='.$this->session->data['token'] . '&id=' . $result['id'], 'SSL'),
				'selected'	  => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected'])
			);
		}
				
		$url = '';		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		# URLs
		$this->data['sort_name'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_body'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'] . '&sort=body' . $url, 'SSL');
		$this->data['insert_template'] = $this->url->link('module/emailtemplate/insert_template', 'token='.$this->session->data['token'], 'SSL');
		
		$this->data['language_url'] = $this->url->link('module/emailtemplate/language_files', 'token='.$this->session->data['token'].'&id='.$this->config->get('config_language_id'), 'SSL');
		$this->data['docs_url'] = $this->url->link('module/emailtemplate/docs', 'token='.$this->session->data['token'], 'SSL');
		$this->data['support_url'] = 'http://support.opencart-templates.co.uk/open.php';
		$i = 1;
		foreach(array('name'=>$this->config->get("config_owner").' - '.$this->config->get("config_name"), 'email'=>$this->config->get("config_email"), 'protocol'=>$this->config->get("config_mail_protocol"), 'storeUrl'=>HTTP_CATALOG, 'version'=>EmailTemplate::$version, 'opencartVersion'=>VERSION, 'vqmodVersion'=>VQMod::$_vqversion, 'phpVersion'=>phpversion()) as $key=>$val){
			$this->data['support_url'] .= (($i == 1) ? '?' : '&amp;') . $key . '=' . urlencode(html_entity_decode($val,ENT_QUOTES,'UTF-8'));
			$i++;
		}
		
		$url = '';		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $templates_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
	}

	/**
	 * Get template form
	 */
	private function getTemplateForm() {
		# Models
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		
		# Language text
		$this->data = array_merge($this->data, $this->load->language('module/emailtemplate'));
		
		# Messages
		$this->populateMessages();
				
		# Security token
		$this->data['token'] = $this->session->data['token'];
									
		if (isset($this->request->get['id'])) {
			$this->data['action'] = 	 $this->url->link('module/emailtemplate/update_template', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'], 'SSL');
			$this->data['action_exit'] = $this->url->link('module/emailtemplate/update_template', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'] . '&exit=true', 'SSL');
				
			if ($this->request->server['REQUEST_METHOD'] != 'POST') {
				$template_info = $this->model_module_emailtemplate->getTemplate($this->request->get['id']);
			}
			
			$this->populateBreadcrumbs(array('heading_template' => array(
				'link' => 'module/emailtemplate/update_template',
				'params' => '&id='.$this->request->get['id']
			)));
		} else {
			$this->data['action'] = 	 $this->url->link('module/emailtemplate/insert_template', 'token='.$this->session->data['token'], 'SSL');
			$this->data['action_exit'] = $this->url->link('module/emailtemplate/insert_template', 'token='.$this->session->data['token'].'&exit=true', 'SSL');
				
			$this->populateBreadcrumbs(array('heading_template' => array(
				'link' => 'module/emailtemplate/insert_template'
			)));
		}	
		$this->data['cancel'] = $this->url->link('module/emailtemplate', 'token='.$this->session->data['token'], 'SSL');
	
		# Langauges
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		# Setup Fields
		$this->data['dataset'] = array();
		foreach(array(
			'name' => '',
			'type' => 'order_status'
		) as $field => $val){
			if (isset($this->request->post[$field])) {
				$this->data['dataset'][$field] = $this->request->post[$field];
			} elseif (isset($template_info[$field])) {
				$this->data['dataset'][$field] = $template_info[$field];
			} else {
				$this->data['dataset'][$field] = $val;
			}
		}
		
		# Language fields
		foreach($this->data['languages'] as $language){
			foreach(array(
				'body' => ''
			) as $field => $val){
				if (isset($this->request->post[$field][$language['language_id']])) {
					$this->data['dataset'][$field][$language['language_id']] = $this->request->post[$field][$language['language_id']];
				} elseif (isset($template_info[$field][$language['language_id']])) {
					$this->data['dataset'][$field][$language['language_id']] = $template_info[$field][$language['language_id']];
				} else {
					$this->data['dataset'][$field][$language['language_id']] = $val;
				}
			}
		}
						
		# Tags
		if(!isset($this->data['insertMode'])){
			$tags = $this->model_module_emailtemplate->getTagsList($this->data['dataset']['type']);
			if(!$tags){				
				switch ($this->data['dataset']['type']){
					case 'order_status':
						$this->data['error_warning'] = $this->language->get('text_no_orders');
					break;
					case 'newsletter':
						$this->data['error_warning'] = $this->language->get('text_no_customers');
					break;						
				}
			} else {
				$this->data['tags'] = $tags;
			}
		}
	}
		
	/**
	 * Send Test Email with demo template
	 */
	private function sendTestEmail($toAddress, $store_id, $language_id = 1){		
		$this->load->model('module/emailtemplate');
		
		$result = $this->db->query("SELECT `order_id` FROM `" . DB_PREFIX . "order` ORDER BY `order_id` DESC LIMIT 1");
		if($result->row){
			$email = $this->model_module_emailtemplate->getCompleteOrderEmail($result->row['order_id']);
			
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($this->config->get('config_name'));
			$mail->setHtml($email['html']);
			$mail->setText($email['plaintext']);
			$mail->setTo($toAddress);
			
			if($mail->send()){
				return true; # always returns true bug in mail.php
			}			
		} else {
			$this->data['error_attention'] = $this->language->get('text_no_orders');
		}

		return false; 		
	}
		
	/**
	 * Extract HTML from within BODY
	 */
	private function extractHtml($html){
		require_once(DIR_SYSTEM . 'library/shared/html_dom_parser.php');
	    $oHtml = new simple_html_dom();
		$oHtml->load($html);
	    $body = $oHtml->find("#emailWrapper", 0);
	    return (is_object($body)) ? $body->innertext : '';
	}

	/**
	 * Display admin page
	 */
	private function display($file) {
		$this->template = $file;
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
		
		return $this;
	}

	/**
	 * Populates $this->data with error_* keys using data from $this->error
	 */
	private function populateMessages() 
	{		
		# Warning, error
		$this->data["error_attention"] = '';
		$this->data["error_warning"] = '';		
		foreach ($this->error as $key => $val) {
			$this->data["error_{$key}"] = $val;
		}
		
		# Success
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
	}

	/**
	 * Populates breadcrumbs array for $this->data
	 */
	private function populateBreadcrumbs($crumbs = array()) {
		$bc = array();
		$bc_map = array(
			'text_home' => array(
				'link' => 'common/home',
				'params' => '',
				'separator' => false),

			'text_module' => array(
				'link' => 'extension/module',
				'params' => '',
				'separator' => ' :: '),

			'heading' => array(
				'link' => 'module/emailtemplate',
				'params' => $this->params,
				'separator' => ' :: ')
		);
		$bc_map = array_merge($bc_map, $crumbs);
		foreach ($bc_map as $name => $item) {
			$bc[]= array(
				'text'      => $this->language->get($name),
				'href'      => $this->url->link($item['link'], 'token='.$this->session->data['token'] . (isset($item['params']) ? $item['params'] : ''), 'SSL'),
				'separator' => isset($item['separator']) ? $item['separator'] : ' :: '
			);
		}

   		$this->data['breadcrumbs'] = $bc;
	}

	/**
	 * Validate form data
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/emailtemplate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['store'])) {
			foreach ($this->request->post['store'] as $store_id => $data) {
				foreach ($data['emailtemplate_theme'] as $language_id => $theme) {

					# Check directory and images exist
					$dir = DIR_CATALOG . 'view/theme/' . $theme . '/template/mail/_mail.tpl';
					if (!file_exists($dir)) {
						$this->error['theme'][$store_id][$language_id] = sprintf($this->language->get('error_theme'), $dir);
					}

					# Required logo width and height
					$logo = $data['emailtemplate_logo'][$language_id];
					if ($logo && (!$data['emailtemplate_logo_width'][$language_id] || !$data['emailtemplate_logo_height'][$language_id])) {
						$this->error['dimension'][$store_id][$language_id] = $this->language->get('error_logo_dimension');
					}

					# Validate logo doesn't contain spaces or special characters
					if ($logo && preg_match('/[^\w.-]/', basename($logo))){
						$this->error['logo'][$store_id][$language_id] = sprintf($this->language->get('error_logo_filename'), $logo);
					}

				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Validate template form data
	 */
	private function validateTemplateForm() {
		if (!$this->user->hasPermission('modify', 'module/emailtemplate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$required = array('name', 'type');
		foreach($required as $field){
			if (!isset($this->request->post[$field]) || $this->request->post[$field] == '') {
				$this->error[$field] = $this->language->get('error_required');
			}
		}
		
		$required = array('body');
		foreach($required as $field){
			if (isset($this->request->post[$field])) {
				foreach ($this->request->post[$field] as $langId => $val) {
					if (!$val) {
						$this->error[$field][$langId] = $this->language->get('error_required');
					}
				}
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Validate email address
	 */
	private function _validateEmail($email) {
		# First, we check that there's one @ symbol, and that the lengths are right
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
			# Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		# Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
				return false;
			}
		}
		# Check if domain is IP. If not, it should be valid domain name
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])){ 
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; # Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	private function _link($link, $isAdmin = false){
		if($isAdmin){
			return $this->url->link($link, 'token='.$this->session->data['token'], 'SSL');
		} else {
			if($this->config->get('config_secure')){
				return str_replace(HTTPS_SERVER, HTTPS_CATALOG, $this->url->link($link, '', 'SSL'));
			} else {
				return str_replace(HTTP_SERVER, HTTP_CATALOG, $this->url->link($link, '', 'SSL'));
			}
		}
	}

}
?>