<?php

/**
 * Customer Group Restrict
 * 
 * @author marsilea15 <marsilea15@gmail.com> 
 */
class ControllerModuleCustomerGroupRestrict extends Controller {	
	
	private $_version	= '1.0.3';
	
	private $_name		= 'customer_group_restrict';
	
	/**
	 * Wygeneruj wiadomości
	 */
	private function _messages() {
		/**
		 * Ostrzeżenia
		 */
		if( isset( $this->session->data['error'] ) ) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset( $this->session->data['error'] );
		} else if( empty( $this->data['error_warning'] ) ) {
			$this->data['error_warning'] = '';
		}

		/**
		 * Wiadomości
		 */
		if( isset( $this->session->data['success'] ) ) {
			$this->data['success'] = $this->session->data['success'];

			unset( $this->session->data['success'] );
		} else if( empty( $this->data['success'] ) ) {
			$this->data['success'] = '';
		}
	}
	
	/**
	 * __construct()
	 * 
	 * @param type $registry
	 */
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->data = array_merge($this->data, $this->language->load('module/' . $this->_name));
		
		$this->document->setTitle($this->language->get('heading_title'));

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
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['tab_action_settings']	= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['tab_action_about']		= $this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'], 'SSL');		
		
		$this->data['back'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];
		$this->data['_name'] = $this->_name;
		
		$this->_messages();
	}
	
	/**
	 * Ustawienia
	 */
	public function index() {		
		// załaduj modele
		$this->load->model('setting/setting');
				
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ) {			
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['action']	= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['settings']	= (array) $this->config->get($this->_name);
		
		// ustawienia szablonu
		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	/**
	 * Informacje o module
	 */
	public function about() {
		// ustawienia szablonu
		$this->template = 'module/' . $this->_name . '_about.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->data['ext_version'] = $this->_version;

		$this->response->setOutput($this->render());
	}

	/**
	 * Sprawdź uprawnienia użytkownika
	 * 
	 * @param string $permission
	 * @return boolean
	 */
	private function userPermission($permission = 'modify') {
		$this->language->load('module/' . $this->_name);

		if( ! $this->user->hasPermission($permission, 'module/' . $this->_name) ) {
			$this->session->data['error'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Instalacja modułu
	 */
	public function install() {
		/**
		 * Sprawdź czy użytkownik ma uprawnienia
		 */
		if( $this->userPermission() ) {			
			$this->load->model('module/customer_group_restrict');
			
			$this->model_module_customer_group_restrict->install();
			
			$this->session->data['success'] = $this->language->get('success_install');
			
			unset( $this->session->data['error'] );
			
			/**
			 * Sprawdź czy wtyczka jest na liście 
			 */
			$this->load->model('setting/extension');
			
			if( ! in_array( $this->_name, $this->model_setting_extension->getInstalled('module') ) )
				$this->model_setting_extension->install('module', $this->_name);
		} else if( ! isset( $this->session->data['error_install'] ) ) {
			$this->session->data['error_install'] = true;
			
			$this->load->model('setting/extension');
			$this->model_setting_extension->uninstall('module', $this->_name);
			
			$this->redirect($this->url->link('extension/module/install', 'token=' . $this->session->data['token'] . '&extension=' . $this->_name, 'SSL'));
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');
			
			$this->redirect($this->url->link('extension/module/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $this->_name, 'SSL'));
		}
		
		// przekieruj do modułu
		$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	/**
	 * Deinstalacja rozszerzenia
	 */
	public function uninstall() {
		/**
		 * Sprawdź czy użytkownik ma uprawnienia
		 */
		if( $this->userPermission() ) {			
			$this->load->model('module/customer_group_restrict');
			
			$this->model_module_customer_group_restrict->uninstall();
			
			if( isset( $this->session->data['error_install'] ) ) {
				unset( $this->session->data['error_install'] );
			} else {
				$this->session->data['success'] = $this->language->get('success_uninstall');
			}
			
			$this->load->model('setting/extension');
			$this->model_setting_extension->uninstall('module', $this->_name);
		}

		// przekieruj do listy modułów
		$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>