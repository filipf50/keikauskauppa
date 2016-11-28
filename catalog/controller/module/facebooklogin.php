<?php  
class ControllerModuleFacebooklogin extends Controller {
	protected function index($config) {
		$this->language->load('module/facebooklogin');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
      	$login_ssl = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'));

		if(!$this->customer->isLogged()){
			if ($login_ssl) {
				$configuration = str_replace('http', 'https', $this->config->get('FacebookLogin'));
			} else {
				$configuration = $this->config->get('FacebookLogin');
			}
			
			$this->data['data']['FacebookLogin'] = $configuration[$this->config->get('config_store_id')];
			$this->data['data']['FacebookLoginConfig'] = $config;
			
			if (!empty($configuration['Activated']) && $configuration['Activated'] == 'Yes' && !empty($this->data['data']['FacebookLogin']['Enabled']) && $this->data['data']['FacebookLogin']['Enabled'] == 'Yes') {

				$this->data['url_login'] = $this->url->link('module/facebooklogin/display', '', $login_ssl ? 'SSL' : 'NONSSL');
				
				if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/facebooklogin.css')) {
					$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/facebooklogin.css');
				} else {
					$this->document->addStyle('catalog/view/theme/default/stylesheet/facebooklogin.css');
				}
				
				if(!isset($this->data['data']['FacebookLogin']['ButtonName_'.$this->config->get('config_language')])){
					$this->data['data']['FacebookLogin']['ButtonLabel'] = 'Login with Facebook';
				} else {
					$this->data['data']['FacebookLogin']['ButtonLabel'] = $this->data['data']['FacebookLogin']['ButtonName_'.$this->config->get('config_language')];
				}
				
				if(!isset($this->data['data']['FacebookLogin']['WrapperTitle_'.$this->config->get('config_language')])){
					$this->data['data']['FacebookLogin']['WrapperTitle'] = 'Login';
				} else {
					$this->data['data']['FacebookLogin']['WrapperTitle'] = $this->data['data']['FacebookLogin']['WrapperTitle_'.$this->config->get('config_language')];
				}
	
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebooklogin.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/facebooklogin.tpl';
				} else {
					$this->template = 'default/template/module/facebooklogin.tpl';
				}
	
				$this->render();
			}
		}
	}
	
	public function display() {		
      	$login_ssl = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'));

		if ($login_ssl) {
			$configuration = str_replace('http', 'https', $this->config->get('FacebookLogin'));
		} else {
			$configuration = $this->config->get('FacebookLogin');
		}
		
		$this->data['data']['FacebookLogin'] = $configuration[$this->config->get('config_store_id')];
		
		if(!isset($this->facebookObject)) {
			if (!class_exists('Facebook')) {	
				require_once(DIR_SYSTEM . '../vendors/facebook-api/facebook.php');
			}

			$this->facebookObject = new Facebook(array(
				'appId'  => $this->data['data']['FacebookLogin']['APIKey'],
				'secret' => $this->data['data']['FacebookLogin']['APISecret'],
			));
		}
		
		if (!empty($this->session->data['facebooklogin_redirect'])) {
			$redirect_url = $this->session->data['facebooklogin_redirect'];
		} else if (!empty($this->request->server['HTTP_REFERER'])) {
			$redirect_url = $this->request->server['HTTP_REFERER'];
		} else {
			$redirect_url = '';
		}

		unset($this->session->data['facebooklogin_redirect']);
		
		echo $this->facebookObject->getLoginUrl(
			array(
				'scope' => 'email',
				'redirect_uri'  => str_replace('&amp;', '&', $this->url->link('account/facebooklogin', !empty($redirect_url) ? 'redirect=' . base64_encode($redirect_url) : '', $login_ssl ? 'SSL' : 'NONSSL')),
				'display' => 'popup'
			)
		);
		
		exit;
	}
}
?>