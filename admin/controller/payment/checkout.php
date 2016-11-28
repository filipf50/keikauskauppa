<?php
/********************************************************
*	CHECKOUT FINLAND PAYMENT METHOD						*
*	Version:	1.5.4									*
*	Date:		01-05-2013								*
*	File:		admin/controller/payment/checkout.php	*
*	Author:		HydeNet									*
*	Web:		www.hydenet.fi							*
*	Email:		info@hydenet.fi							*
********************************************************/

class ControllerPaymentCheckout extends Controller {
	private $error = array();

	public function index() {
		define("CHECKOUTVERSION", '1.5.4'); // DO NOT EDIT THIS!!!
		$this->load->language('payment/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('checkout', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_normal'] = $this->language->get('text_normal');
		$this->data['text_adult'] = $this->language->get('text_adult');
		$this->data['text_device_html'] = $this->language->get('text_device_html');
		$this->data['text_device_xml'] = $this->language->get('text_device_xml');
		$this->data['text_info'] = CHECKOUTVERSION;
		$this->data['text_no_file'] = $this->language->get('text_no_file');

		$this->data['entry_merchant'] = $this->language->get('entry_merchant');
		$this->data['entry_safety_key'] = $this->language->get('entry_safety_key');
		$this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_message_fi'] = $this->language->get('entry_message_fi');
		$this->data['entry_message_se'] = $this->language->get('entry_message_se');
		$this->data['entry_message_en'] = $this->language->get('entry_message_en');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_device'] = $this->language->get('entry_device');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_debug_contents'] = $this->language->get('entry_debug_contents');
		$this->data['entry_log'] = $this->language->get('entry_log');
		$this->data['entry_log_contents'] = $this->language->get('entry_log_contents');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_ok_status'] = $this->language->get('entry_ok_status');
		$this->data['entry_delayed_status'] = $this->language->get('entry_delayed_status');
		$this->data['entry_unknown_status'] = $this->language->get('entry_unknown_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_log'] = $this->language->get('tab_log');

		$this->data['button_clear_log'] = $this->language->get('button_clear_log');
		$this->data['button_clear_debug'] = $this->language->get('button_clear_debug');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

 		if (isset($this->error['safety_key'])) {
			$this->data['error_safety_key'] = $this->error['safety_key'];
		} else {
			$this->data['error_safety_key'] = '';
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
			'href'      => $this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['checkout_merchant'])) {
			$this->data['checkout_merchant'] = $this->request->post['checkout_merchant'];
		} else {
			$this->data['checkout_merchant'] = $this->config->get('checkout_merchant');
		}

		if (isset($this->request->post['checkout_safety_key'])) {
			$this->data['checkout_safety_key'] = $this->request->post['checkout_safety_key'];
		} else {
			$this->data['checkout_safety_key'] = $this->config->get('checkout_safety_key');
		}

		if (isset($this->request->post['checkout_message_fi'])) {
			$this->data['checkout_message_fi'] = $this->request->post['checkout_message_fi'];
		} else {
			$this->data['checkout_message_fi'] = $this->config->get('checkout_message_fi');
		}

		if (isset($this->request->post['checkout_message_se'])) {
			$this->data['checkout_message_se'] = $this->request->post['checkout_message_se'];
		} else {
			$this->data['checkout_message_se'] = $this->config->get('checkout_message_se');
		}

		if (isset($this->request->post['checkout_message_en'])) {
			$this->data['checkout_message_en'] = $this->request->post['checkout_message_en'];
		} else {
			$this->data['checkout_message_en'] = $this->config->get('checkout_message_en');
		}

		if (isset($this->request->post['checkout_test'])) {
			$this->data['checkout_test'] = $this->request->post['checkout_test'];
		} else {
			$this->data['checkout_test'] = $this->config->get('checkout_test');
		}

		if (isset($this->request->post['checkout_debug'])) {
			$this->data['checkout_debug'] = $this->request->post['checkout_debug'];
		} else {
			$this->data['checkout_debug'] = $this->config->get('checkout_debug');
		}

		if (isset($this->request->post['checkout_log'])) {
			$this->data['checkout_log'] = $this->request->post['checkout_log'];
		} else {
			$this->data['checkout_log'] = $this->config->get('checkout_log');
		}

		if (isset($this->request->post['checkout_content'])) {
			$this->data['checkout_content'] = $this->request->post['checkout_content'];
		} elseif ($this->config->has('checkout_content')) {
			$this->data['checkout_content'] = $this->config->get('checkout_content');
		} else {
			$this->data['checkout_content'] = '1';
		}

		if (isset($this->request->post['checkout_device'])) {
			$this->data['checkout_device'] = $this->request->post['checkout_device'];
		} elseif ($this->config->has('checkout_device')) {
			$this->data['checkout_device'] = $this->config->get('checkout_device');
		} else {
			$this->data['checkout_device'] = '10';
		}

		if (isset($this->request->post['checkout_total'])) {
			$this->data['checkout_total'] = $this->request->post['checkout_total'];
		} else {
			$this->data['checkout_total'] = $this->config->get('checkout_total'); 
		} 

		if (isset($this->request->post['checkout_ok_status_id'])) {
			$this->data['checkout_ok_status_id'] = $this->request->post['checkout_ok_status_id'];
		} else {
			$this->data['checkout_ok_status_id'] = $this->config->get('checkout_ok_status_id');
		}

		if (isset($this->request->post['checkout_delayed_status_id'])) {
			$this->data['checkout_delayed_status_id'] = $this->request->post['checkout_delayed_status_id'];
		} else {
			$this->data['checkout_delayed_status_id'] = $this->config->get('checkout_delayed_status_id');
		}

		if (isset($this->request->post['checkout_unknown_status_id'])) {
			$this->data['checkout_unknown_status_id'] = $this->request->post['checkout_unknown_status_id'];
		} else {
			$this->data['checkout_unknown_status_id'] = $this->config->get('checkout_unknown_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['checkout_geo_zone_id'])) {
			$this->data['checkout_geo_zone_id'] = $this->request->post['checkout_geo_zone_id'];
		} else {
			$this->data['checkout_geo_zone_id'] = $this->config->get('checkout_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['checkout_status'])) {
			$this->data['checkout_status'] = $this->request->post['checkout_status'];
		} else {
			$this->data['checkout_status'] = $this->config->get('checkout_status');
		}

		if (isset($this->request->post['checkout_sort_order'])) {
			$this->data['checkout_sort_order'] = $this->request->post['checkout_sort_order'];
		} else {
			$this->data['checkout_sort_order'] = $this->config->get('checkout_sort_order');
		}

		$file = DIR_LOGS . "checkout.log";
		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			$this->data['log_file'] = $file;
		} else {
			$this->data['log'] = '';
			$this->data['log_file'] = $this->language->get('text_no_file');
		}
		$this->data['clear_log'] = $this->url->link('payment/checkout/clear_log', 'token=' . $this->session->data['token'], 'SSL');

		$file = DIR_LOGS . "checkout.txt";
		if (file_exists($file)) {
			$this->data['debug'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			$this->data['debug_file'] = $file;
		} else {
			$this->data['debug'] = '';
			$this->data['debug_file'] = $this->language->get('text_no_file');
		}
		$this->data['clear_debug'] = $this->url->link('payment/checkout/clear_debug', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'payment/checkout.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function clear_log() {
		$this->load->language('payment/checkout');

		$file = DIR_LOGS . "checkout.log";

		$handle = fopen($file, 'w+'); 

		fclose($handle);

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function clear_debug() {
		$this->load->language('payment/checkout');

		$file = DIR_LOGS . "checkout.txt";

		$handle = fopen($file, 'w+'); 

		fclose($handle);

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function paymentStatus() {
		$this->language->load('payment/checkout');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission'); 
		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info) {

				$tilausnumero = $order_info['order_id'];
				if( $tilausnumero < 10 ) {
					$tilausnumero *= 1000;
				}
				elseif( $tilausnumero < 100 ) {
					$tilausnumero *= 100;
				}
				elseif( $tilausnumero < 1000 ) {
					$tilausnumero *= 10;
				}

					$kertoimet = array(7,3,1);
					$pituus = strlen($tilausnumero);
					$summa = 0;
					$viite = str_split($tilausnumero);
				for ($i = $pituus - 1; $i >= 0; --$i) {
					$summa += $viite[$i] * $kertoimet[($pituus - 1 - $i) % 3];
				}
				$tarkiste = (10 - $summa % 10) % 10;

				$fiviite = $tilausnumero . $tarkiste;

				$total = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);

				if (!$this->config->get('checkout_test')) {
					$safety_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
				} else {
					$safety_key = 'SAIPPUAKAUPPIAS'; // Turva-avain jos testitila
				}
				$version = '0001'; // Maksun versio
				$stamp = $order_info['order_id']; // Maksun tunnus
				$reference = $fiviite; // Maksun viite
				if (!$this->config->get('checkout_test')) {
					$merchant = $this->config->get('checkout_merchant'); // Myyjän tunniste
				} else {
					$merchant = 375917; // Myyjän tunniste jos testitila
				}
				$amount = $total * 100 ; // Maksun määrä -> Euro sentteinä
				$currency = $order_info['currency_code']; // Valuutta
				$format = '1'; // Maksutavat
				$algorithm = '1'; // Algoritmi
				$mac = strtoupper(md5($version . '+' . $stamp . '+' . $reference . '+' . $merchant . '+' . $amount . '+' . $currency . '+' . $format . '+' . $algorithm . '+' . $safety_key));

				$codata = urlencode('VERSION') . '=' . urlencode($version) . '&';
				$codata .= urlencode('STAMP') . '=' . urlencode($stamp) . '&';
				$codata .= urlencode('REFERENCE') . '=' . urlencode($reference) . '&';
				$codata .= urlencode('MERCHANT') . '=' . urlencode($merchant) . '&';
				$codata .= urlencode('AMOUNT') . '=' . urlencode($amount) . '&';
				$codata .= urlencode('CURRENCY') . '=' . urlencode($currency) . '&';
				$codata .= urlencode('FORMAT') . '=' . urlencode($format) . '&';
				$codata .= urlencode('ALGORITHM') . '=' . urlencode($algorithm) . '&';
				$codata .= urlencode('MAC') . '=' . urlencode($mac) . '&';

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,'https://rpcapi.checkout.fi/poll');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $codata);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded'));

				$res = curl_exec($ch);

				$res = urldecode($res);

				curl_close($ch);

				if($this->config->get('checkout_debug')) {
					$aika = date("Y-m-d H:i:s");
					$viesti = 'Maksun tilan tarkistus.';
					$getdata = $res;
					file_put_contents(DIR_LOGS . "checkout.txt", "{$aika} {$viesti}\n{$getdata}\n", FILE_APPEND);
				}

				if(stripos($res, 'error') !== false) {
					$json['status_id'] = $this->language->get('error_action');
				} else {
					$status = new SimpleXMLElement($res);

					switch ($status->status) {
						case "1":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_1'),$status->status);
							break;
						case "2":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_2'),$status->status);
							break;
						case "3":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_3'),$status->status);
							break;
						case "4":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_4'),$status->status);
							break;
						case "5":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_5'),$status->status);
							break;
						case "6":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_6'),$status->status);
							break;
						case "7":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_7'),$status->status);
							break;
						case "8":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_8'),$status->status);
							break;
						case "9":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_9'),$status->status);
							break;
						case "10":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_10'),$status->status);
							break;
						case "-1":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_-1'),$status->status);
							break;
						case "-2":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_-2',$status->status));
							break;
						case "-3":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_-3'),$status->status);
							break;
						case "-4":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_-4'),$status->status);
							break;
						case "-10":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_-10'),$status->status);
							break;
						default:
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_error'),$status->status);
					} //end switch
				}
			} // end if order_info
		}

		$this->response->setOutput(json_encode($json));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/checkout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['checkout_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['checkout_safety_key']) {
			$this->error['safety_key'] = $this->language->get('error_safety_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>