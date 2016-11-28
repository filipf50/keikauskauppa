<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class EmailTemplate extends Template {

	static $version = '4.5.1.7';
	
	public $data = array();
	public $registry;
	public $request;
	public $config;
	public $server;
	public $server_image;
	public $language_id;
	public $theme_dir;

	/**
	 * @param Request $request
	 */
	public function __construct(Request $request, Registry $registry, $language_id = null) {
		$this->registry = $registry;
		$this->request = $request;
		$this->config = $registry->get('config');
		$this->language = $registry->get('language');
		$this->load = $registry->get('load');
		$this->db = $registry->get('db');
		$this->currency = $registry->get('currency');

		# Load models
		$this->load->model('tool/image');
		$this->model_tool_image = new ModelToolImage($this->registry);
		
		$this->load->model('module/emailtemplate');
		$this->model_module_emailtemplate = new ModelModuleEmailTemplate($this->registry);

		if (isset($request->server['HTTPS']) && (($request->server['HTTPS'] == 'on') || ($request->server['HTTPS'] == '1'))) {
			$this->server = defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTPS_SERVER;
		} else {
			$this->server = defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER;
		}
		$this->server_image = defined("HTTP_IMAGE") ? HTTP_IMAGE : ($this->server.'image/');
		
		$this->language_id = isset($language_id) ? $language_id : $this->config->get("config_language_id");

		$this->populateStoreData();
		$this->populateEmailData();
		
		$this->data['tracking'] = $this->tracking(); 
	}


	/**
	 * Set config data for store
	 *
	 * @param if config->data not set for store (e.g admin area) use $config
	 */
	public function populateStoreData($_config = null) {
		$copy_keys = array(
			'title',
			'name',
			'owner',
			'address',
			'email',
			'fax'
		);
		if(isset($_config)){
			$this->data['store_id'] = isset($_config['store_id']) ? $_config['store_id'] : $this->config->get('config_store_id');
			$this->data['title'] = isset($_config['config_name']) ? $_config['config_name'] : $this->config->get('config_name');

			$this->data['store_url'] = isset($_config['config_url']) ? $_config['config_url'] : $this->config->get('config_url');
			$this->data['store_ssl'] = isset($_config['config_ssl']) ? $_config['config_ssl'] : $this->config->get('config_ssl');

			foreach ($copy_keys as $key) {
				$this->data["store_{$key}"] = isset($_config["config_{$key}"]) ? $_config["config_{$key}"] : '';
			}
		} else {
			$this->data['store_id'] = $this->config->get('config_store_id');
			$this->data['title'] = $this->config->get('config_name');
			$this->data['store_url'] = $this->config->get('config_url');
			$this->data['store_ssl'] = $this->config->get('config_ssl');

			foreach ($copy_keys as $key) {
				$this->data["store_{$key}"] = $this->config->get("config_{$key}");
			}
		}
	}

	/**
	 * Populate email data for backend where config is not related to the current store.
	 * e.g demo
	 *
	 * @param if config->data not set for store (e.g admin area) use $_data
	 */
	public function populateEmailData($_data = null) {

		# General data
		$this->data['language_id'] = $this->language_id;

		$this->data['server'] = $this->server;
		$this->data['server_image'] = $this->server_image;

		# Email template
		$keys = array(
			'email_width',
			'page_padding',
			'page_bg_color',
			'body_link_color',
			'body_bg_color',
			'body_font_color',
			'body_heading_color',
			'body_product_option_size',
			'body_section_bg_color',
			'page_footer_text',
			'footer_text',
			'footer_height',
			'footer_align',
			'footer_valign',
			'footer_font_color',
			'footer_section_bg_color',
			'header_bg_color',
			'header_bg_image',
			'header_border_color',
			'header_border_height',
			'header_height',
			'header_section_bg_color',
			'head_text',
			'head_section_bg_color',
			'logo',
			'logo_align',
			'logo_font_color',
			'logo_font_size',
			'logo_top',
			'logo_resize',
			'logo_width',
			'logo_height',
			'logo_valign',
			'text_align',
			'order_picture',
			'theme',
			'shadow_top_start',
			'shadow_top_end',
			'shadow_top_length',
			'shadow_top_overlap',
			'shadow_bottom_start',
			'shadow_bottom_end',
			'shadow_bottom_length',
			'shadow_bottom_overlap',
			'shadow_left_start',
			'shadow_left_end',
			'shadow_left_length',
			'shadow_left_overlap',
			'shadow_right_start',
			'shadow_right_end',
			'shadow_right_length',
			'shadow_right_overlap',
			'shadow_top_left_img',
			'shadow_top_right_img',
			'shadow_bottom_left_img',
			'shadow_bottom_right_img',
			'showcase',
			'showcase_title',
			'showcase_page_bg_color',
			'showcase_section_bg_color'
		);

		# Populate items
		if (isset($_data)) {
			# from  $_data
			$language_id = $this->language_id;
			foreach ($keys as $key) {
				$data_key = "emailtemplate_{$key}";
				if (isset($_data[$data_key][$language_id])) {
					$this->data[$key]  = $_data[$data_key][$language_id];
				}
			}
		} else {
			# from config
			foreach ($keys as $key) {
				$config_key = "emailtemplate_{$key}";
				$this->data[$key] = $this->getConfig($config_key);
			}
		}

		$this->setThemeDir($this->data['theme'] . '/template/mail/');
		$this->setMailImages($this->data['theme'] . '/image/mail/');
		
		# Shadows
		foreach(array('top','bottom','left','right') as $var){
			$this->data['shadow_'.$var] = "";	
			$cells = '';
			if($this->data['shadow_'.$var.'_start'] && $this->data['shadow_'.$var.'_end'] &&  $this->data['shadow_'.$var.'_length'] > 0){
				$gradient = $this->generateGradientArray($this->data['shadow_'.$var.'_start'], $this->data['shadow_'.$var.'_end'], $this->data['shadow_'.$var.'_length']);
				foreach($gradient as $hex => $width){
					switch($var){
						case 'top':
						case 'bottom':
							$cells .= " <tr><td bgcolor='#{$hex}' style='background:#{$hex}; height:1px; font-size:1px; line-height:0; mso-margin-top-alt:1px' height='1'>&nbsp;</td></tr>\n";
						break;
						default:
							$cells .= " <td bgcolor='#{$hex}' style='background:#{$hex}; width:{$width}px !important; font-size:1px; line-height:0; mso-margin-top-alt:1px' width='{$width}'>&nbsp;</td>\n";
						break;
					}
										
					$this->data['shadow_'.$var] = $cells;
				}
			}
		}
				
		# Data post-processing
		$this->data['head_text'] = html_entity_decode($this->data['head_text'], ENT_QUOTES, 'UTF-8');
		$this->data['page_footer_text'] = html_entity_decode($this->data['page_footer_text'], ENT_QUOTES, 'UTF-8');
		$this->data['footer_text'] = html_entity_decode($this->data['footer_text'], ENT_QUOTES, 'UTF-8');
		
		$this->data['header_bg_image'] = ($this->data['header_bg_image']) ? $this->model_tool_image->get($this->data['header_bg_image']) : '';
		
		$this->data['email_full_width'] = $this->data['email_width'] + ($this->data['shadow_left_length'] + $this->data['shadow_right_length']);
		$this->data['email_width'] = $this->data['email_width'];
		
		$this->data['shadow_top_left_img'] = ($this->data['shadow_top_left_img']) ? $this->model_tool_image->get($this->data['shadow_top_left_img']) : '';
		$this->data['shadow_top_right_img'] = ($this->data['shadow_top_right_img']) ? $this->model_tool_image->get($this->data['shadow_top_right_img']) : '';
		$this->data['shadow_bottom_left_img'] = ($this->data['shadow_bottom_left_img']) ? $this->model_tool_image->get($this->data['shadow_bottom_left_img']) : '';
		$this->data['shadow_bottom_right_img'] = ($this->data['shadow_bottom_right_img']) ? $this->model_tool_image->get($this->data['shadow_bottom_right_img']) : '';
		
		$this->data['shadow_top_left_img_height'] = $this->data['shadow_top_length'] + $this->data['shadow_top_overlap'];
		$this->data['shadow_top_right_img_height'] = $this->data['shadow_top_length'] + $this->data['shadow_top_overlap'];		
		$this->data['shadow_bottom_left_img_height'] = $this->data['shadow_bottom_length'] + $this->data['shadow_bottom_overlap'];
		$this->data['shadow_bottom_right_img_height'] = $this->data['shadow_bottom_length'] + $this->data['shadow_bottom_overlap'];
		
		$this->data['shadow_top_left_img_width'] = $this->data['shadow_left_length'] + $this->data['shadow_left_overlap'];
		$this->data['shadow_top_right_img_width'] = $this->data['shadow_right_length'] + $this->data['shadow_right_overlap'];
		$this->data['shadow_bottom_left_img_width'] = $this->data['shadow_left_length'] + $this->data['shadow_left_overlap'];
		$this->data['shadow_bottom_right_img_width'] = $this->data['shadow_right_length'] + $this->data['shadow_right_overlap'];

		# Scale logo if needs it
		if($this->data['logo_resize'] && $this->data['logo_width'] && $this->data['logo_height']){
			$this->data['logo'] = $this->model_tool_image->resize($this->data['logo'], $this->data['logo_width'], $this->data['logo_height']);
		} else {
			$this->data['logo'] = $this->model_tool_image->get($this->data['logo']);
		}
	}

	/**
	 * Set Google trackings parmas
	 */
	public function tracking($source = '') {
		$tracking = array();
		$tracking['utm_campaign'] = $this->getConfig('emailtemplate_tracking_campaign_name');
		$tracking['utm_medium'] = 'email';		
		$tracking['utm_term'] = $this->getConfig('emailtemplate_tracking_campaign_term');		
		if($source == '' && isset($this->request->get['route'])){
			$source = $this->request->get['route'];
		}
		$tracking['utm_source'] = $source . ' ' . $this->data['store_name'];
				
		return http_build_query($tracking);
	}

	/**
	 * Set title
	 */
	public function setTitle($title) {
		$this->data['title'] = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * Set language ID - used in the admin area if "config_language_id" not set.
	 *
	 * @param int $language_id
	 */
	public function setLanguage($language_id) {
		$this->language_id = $language_id;
	}

	/**
	 * Get config
	 *
	 * @param int $language_id
	 * @return config data index (langauge) if it exists OR defaults to first
	 */
	public function getConfig($key) {
		$config = $this->config->get($key);

		if(is_array($config)){
			if(array_key_exists($this->language_id, $config)){
				# get config index using language_id
				return $config[$this->language_id];
			} else {
				# get first language from config if selected language doesn't exist
				return reset($config);
			}
		} else {
			if(isset($config)) {
				# get default config
				return $config;
			} else {
				return null;
			}
		}
	}

	/**
	 * Generate array of hex values for shadow
	 * @param $from - HEX colour from
	 * @param $until - HEX colour from
	 * @param $length - distance of shadow
	 * @return Array(hex=>width)
	 */
	protected function generateGradientArray($from, $until, $length){
		$from = ltrim($from,'#');
		$until = ltrim($until,'#');
		$from = array(hexdec(substr($from,0,2)),hexdec(substr($from,2,2)),hexdec(substr($from,4,2)));
		$until = array(hexdec(substr($until,0,2)),hexdec(substr($until,2,2)),hexdec(substr($until,4,2)));
		$red=($until[0]-$from[0])/($length-1);
		$green=($until[1]-$from[1])/($length-1);
		$blue=($until[2]-$from[2])/($length-1);
		$return = array();

		for($i=0;$i<$length;$i++){
			$newred=dechex($from[0]+round($i*$red));
			if(strlen($newred)<2) $newred="0".$newred;

			$newgreen=dechex($from[1]+round($i*$green));
			if(strlen($newgreen)<2) $newgreen="0".$newgreen;

			$newblue=dechex($from[2]+round($i*$blue));
			if(strlen($newblue)<2) $newblue="0".$newblue;

			$hex = $newred.$newgreen.$newblue;
			if(isset($return[$hex])){
				$return[$hex] ++;
			} else {
				$return[$hex] = 1;
			}
		}
		return $return;
	}


	/**
	 * Set absolute URL to theme images.
	 */
	public function setMailImages($theme) {
		$this->data['mail_images'] = $this->server . 'catalog/view/theme/' . trim($theme, '/') . '/';
	}

	/**
	 * Set theme directory
	 */
	public function setThemeDir($dir) {
		$this->theme_dir = trim($dir, '/') . '/';
	}

	/**
	 * Set theme directory
	 */
	public function setShowcase() {
		$this->data['showcase_selection'] = $this->model_module_emailtemplate->loadShowcase($this->data['store_id'], $this->language_id);
	}

	/**
	 * @param string $filename - same as 1st parameter in Template::fetch()
	 * @param string $filename_base - path to a base template. This template
	 * 								  must contain {CONTENT} substring which
	 * 								  will be substituted with content from
	 * 								  $filename.
	 * @param string $content - if $filename is null then the content will be 
	 * 							used as the body
	 * @returns string
	 */
	public function fetch($filename, $filename_base = "", $content = "", $withPrefix = true) {
		
		$this->setShowcase();
		
		# Use "Template" class to do the actual work
		$tpl = new Template();
		$tpl->data = $this->data;

		if (empty($filename_base)) {
			# Default behavior
			return $tpl->fetch($filename);
		} else {
			# Content instead of template body
			if($filename == null && $content != ""){
				$fetch = $content;
			} else {		
				# Content template without prefix		
				if($withPrefix == false){
					$fetch = $tpl->fetch($filename, false);					
				} else {
					if(file_exists(DIR_TEMPLATE.$this->theme_dir.$filename)){
						# Use "base" template as a wrapper
						$fetch = $tpl->fetch($this->theme_dir.$filename, true);
					} else {
						# try the default store.
						$fetch = $tpl->fetch(str_replace($this->data['theme'], "default", $this->theme_dir.$filename), true);
					}
				}				
			}

			# Find the main mail template
			if(defined('DIR_CATALOG')){
				# If admin area and base template exists use it
				if(file_exists(DIR_TEMPLATE.$this->theme_dir.$filename_base)) {
					$fetch_base = $tpl->fetch(DIR_TEMPLATE.$this->theme_dir.$filename_base, false);
				} else {
					# Otherwise use the theme template
					$fetch_base = $tpl->fetch(DIR_CATALOG.'view/theme/'.$this->data['theme'].'/template/'.$this->theme_dir.$filename_base, false);
				}
			} else {
				$fetch_base = $tpl->fetch(DIR_TEMPLATE.$this->theme_dir.$filename_base, false);
			}

			return str_ireplace('{CONTENT}', $fetch, $fetch_base);
		}
	}

	/**
	 * Appends $this->data with $data
	 *
	 * @return EmailTemplate
	 */
	public function appendData($data) {
		$this->data = array_merge($this->data, $data);
	}

	/**
	 * Appends $this->data with data from language (using $language->get)
	 *
	 * @param mixed $language
	 * @param array $keys - (int => key) - copies $language[key] to $this->data[key];
	 * 						(key1 => key2) - copies $language[key1] to $this->data[key2]
	 */
	 public function appendDataLanguage($language, $keys) {
		 foreach ($keys as $idx => $key) {
			if (is_integer($idx)) {
			 	$this->data[$key] = $language->get($key);
			} else {
				$this->data[$key] = $language->get($idx);
			}
		 }
	}
		 
	/**
	  * Format Address
	  */
	public static function formatAddress($address, $address_prefix = '', $format = null){
		$find = array();
		$replace = array();
	 	$address_prefix = trim($address_prefix, '_') . '_';
	 	if (is_null($format) || $format == '') {
	 		$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
	 	}
	 	$vars = array(
	 		'firstname',
	 		'lastname',
	 		'company',
	 		'address_1',
	 		'address_2',
	 		'city',
	 		'postcode',
	 		'zone',
	 		'zone_code',
	 		'country'
	 	);
	 	foreach($vars as $var){
	 		$find[$var] = '{'.$var.'}';
	 		if(isset($address[$address_prefix.$var])){
	 			$replace[$var] =  $address[$address_prefix.$var];
	 		} elseif(isset($address[$var])){
	 			$replace[$var] =  $address[$var];
	 		} else {
	 			$replace[$var] =  '';
	 		}
	 	}
	 	return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
	}
	 
	public static function truncate_str($str, $length = 100, $breakWords = true, $append = '...') {
		$strLength = mb_strlen($str);
		
		if ($strLength <= $length) {
			return $str;
		}
		
		if (!$breakWords) {
			while ($length < $strLength AND preg_match('/^\pL$/', mb_substr($str, $length, 1))) {
				$length++;
			}
		}
		
		return mb_substr($str, 0, $length) . $append;
	}
}
?>