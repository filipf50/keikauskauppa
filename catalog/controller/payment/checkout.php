<?php
/********************************************************
*	CHECKOUT FINLAND PAYMENT METHOD						*
*	Version:	1.5.4									*
*	Date:		01-05-2013								*
*	File:		catalog/controller/payment/checkout.php	*
*	Author:		HydeNet									*
*	Web:		www.hydenet.fi							*
*	Email:		info@hydenet.fi							*
********************************************************/

class ControllerPaymentCheckout extends Controller {
	protected function index() {
		$this->language->load('payment/checkout');

		$this->data['text_testmode'] = $this->language->get('text_testmode');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['testmode'] = $this->config->get('checkout_test');
		
		if (!$this->config->get('checkout_test')) {
			$this->data['action'] = 'https://payment.checkout.fi/';
		} else {
			$this->data['action'] = 'https://payment.checkout.fi/';
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$testdata = print_r($order_info, true);
			file_put_contents(DIR_LOGS . "orderinfo.txt", $testdata);

			$tilausnumero = $this->session->data['order_id'];
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


			if (!$this->config->get('checkout_test')) {
				$merchant = $this->config->get('checkout_merchant'); // Myyj�n tunniste
				$safety_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
			} else {
				$merchant = 375917; // Myyj�n tunniste jos testitila
				$safety_key = 'SAIPPUAKAUPPIAS'; // Turva-avain jos testitila
			}
			$version = '0001'; // Maksun versio
			//$stamp = substr($this->session->data['order_id'], 0, 20); // Maksun tunnus
                        $stamp=time();
			$amount = 100 * $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE); // Maksun m��r� -> Euro senttein�
			$reference = $fiviite; // Maksun viite
			if (strtolower($this->session->data['language']) == 'fi') { // Maksun kieli suomi
				$message = substr($this->config->get('checkout_message_fi'), 0, 512);
				$language = 'FI';
			} elseif (strtolower($this->session->data['language']) == 'se') { // Maksun kieli ruotsi
				$message = substr($this->config->get('checkout_message_se'), 0, 512);
				$language = 'SE';
			} else { // Maksun kieli englanti
				$message = substr($this->config->get('checkout_message_en'), 0, 512);
				$language = 'EN';
			}
			$return = $this->url->link('payment/checkout/callback'); // Paluu-linkki
			$cancel = $this->url->link('payment/checkout/canceled', '', 'SSL'); // Peruutus-linkki
			$reject = $this->url->link('payment/checkout/reject', '', 'SSL'); // Hyl�tty-linkki
			$delayed = $this->url->link('payment/checkout/callback', '', 'SSL'); // Viiv�stytetty-linkki
			$country = 'FIN'; // Maa
			$currency = 'EUR'; // Valuutta
			$device = $this->config->get('checkout_device'); // Maksup��te: 1=html, 10=xml
			$content = $this->config->get('checkout_content'); // Maksun tyyppi
			$type = '0'; // Maksutavat
			$algorithm = '2'; // Algoritmi
			$delivery_date = date('Ymd'); // Toimitusp�iv�
			$firstname = substr(html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8'), 0, 40); // Tilaajan etunimi
			$familyname = substr(html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8'), 0, 40); // Tilaajan sukunimi
			$address = substr(html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8'), 0, 40); // Tilaajan osoite
			$postcode = substr(html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8'), 0, 5); // Tilaajan postinumero
			$postoffice = substr(html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8'), 0, 18); // Tilaajan postitoimipaikka
			//$mac = strtoupper(md5($version . '+' . $stamp . '+' . $amount . '+' . $reference . '+' . $message . '+' . $language . '+' . $merchant . '+' . $return . '+' . $cancel . '+' . $reject . '+' . $delayed . '+' . $country . '+' . $currency . '+' . $device . '+' . $content . '+' . $type . '+' . $algorithm . '+' . $delivery_date . '+' . $firstname . '+' . $familyname . '+' . $address . '+' . $postcode . '+' . $postoffice . '+' . $safety_key));
			$mac1 = strtoupper(md5($version . '+' . $stamp . '+' . $amount . '+' . $reference . '+' . $message . '+' . $language . '+' . $merchant . '+' . $return . '+' . $cancel . '+' . $reject . '+' . $delayed . '+' . $country . '+' . $currency . '+1+' . $content . '+' . $type . '+' . $algorithm . '+' . $delivery_date . '+' . $firstname . '+' . $familyname . '+' . $address . '+' . $postcode . '+' . $postoffice . '+' . $safety_key));
			$mac10 = strtoupper(md5($version . '+' . $stamp . '+' . $amount . '+' . $reference . '+' . $message . '+' . $language . '+' . $merchant . '+' . $return . '+' . $cancel . '+' . $reject . '+' . $delayed . '+' . $country . '+' . $currency . '+10+' . $content . '+' . $type . '+' . $algorithm . '+' . $delivery_date . '+' . $firstname . '+' . $familyname . '+' . $address . '+' . $postcode . '+' . $postoffice . '+' . $safety_key));

			if($device == 10) {
				$codata = urlencode('VERSION') . '=' . urlencode($version) . '&';
				$codata .= urlencode('STAMP') . '=' . urlencode($stamp) . '&';
				$codata .= urlencode('AMOUNT') . '=' . urlencode($amount) . '&';
				$codata .= urlencode('REFERENCE') . '=' . urlencode($reference) . '&';
				$codata .= urlencode('MESSAGE') . '=' . urlencode($message) . '&';
				$codata .= urlencode('LANGUAGE') . '=' . urlencode($language) . '&';
				$codata .= urlencode('MERCHANT') . '=' . urlencode($merchant) . '&';
				$codata .= urlencode('RETURN') . '=' . urlencode($return) . '&';
				$codata .= urlencode('CANCEL') . '=' . urlencode($cancel) . '&';
				$codata .= urlencode('REJECT') . '=' . urlencode($reject) . '&';
				$codata .= urlencode('DELAYED') . '=' . urlencode($delayed) . '&';
				$codata .= urlencode('COUNTRY') . '=' . urlencode($country) . '&';
				$codata .= urlencode('CURRENCY') . '=' . urlencode($currency) . '&';
				$codata .= urlencode('DEVICE') . '=' . urlencode($device) . '&';
				$codata .= urlencode('CONTENT') . '=' . urlencode($content) . '&';
				$codata .= urlencode('TYPE') . '=' . urlencode($type) . '&';
				$codata .= urlencode('ALGORITHM') . '=' . urlencode($algorithm) . '&';
				$codata .= urlencode('DELIVERY_DATE') . '=' . urlencode($delivery_date) . '&';
				$codata .= urlencode('FIRSTNAME') . '=' . urlencode($firstname) . '&';
				$codata .= urlencode('FAMILYNAME') . '=' . urlencode($familyname) . '&';
				$codata .= urlencode('ADDRESS') . '=' . urlencode($address) . '&';
				$codata .= urlencode('POSTCODE') . '=' . urlencode($postcode) . '&';
				$codata .= urlencode('POSTOFFICE') . '=' . urlencode($postoffice) . '&';
				$codata .= urlencode('MAC') . '=' . urlencode($mac10) . '&';

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,'https://payment.checkout.fi/'); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $codata); 
				curl_setopt($ch, CURLOPT_POST, 1);  
				curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded')); 

				$res = urldecode(curl_exec($ch));
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

				$curlError = $httpCode > 0 ? null : curl_error($ch).' ('.curl_errno($ch).')';

				curl_close($ch);

				if ($curlError) { // Yhteys virhe
					$aika = date("Y-m-d H:i:s");
					file_put_contents(DIR_LOGS . "checkout.log", "{$aika}\nConnection failure. {$curlError}\n", FILE_APPEND);
					$this->data['text_error'] = $this->language->get('text_connection_failure');
				} else {
					$this->data['methods'] = $res;
					$this->data['text_xml_title'] = $this->language->get('text_xml_title');
					$this->data['text_xml_info'] = $this->language->get('text_xml_info');

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_xml.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/payment/checkout_xml.tpl';
					} else {
						$this->template = 'default/template/payment/checkout_xml.tpl';
					}

					$this->render();
				}

			} // end Upotettu maksu
			if($device == 1 || $curlError) {
				if($device == 10) {
					$device = 1;
				}
				$this->data['version'] = $version; // Maksun versio
				$this->data['stamp'] = $stamp; // Maksun tunnus
				$this->data['amount'] = $amount; // Maksun m��r� -> Euro senttein�
				$this->data['reference'] = $reference; // Maksun viite
				$this->data['message'] = $message; // Maksun viesti ostajalle
				$this->data['language'] = $language; // Maksun kieli
				$this->data['merchant'] = $merchant; // Myyj�n tunniste
				$this->data['return'] = $return; // Paluu-linkki
				$this->data['cancel'] = $cancel; // Peruutus-linkki
				$this->data['reject'] = $reject; // Hyl�tty-linkki
				$this->data['delayed'] = $delayed; // Viiv�stytetty-linkki
				$this->data['country'] = $country; // Maa
				$this->data['currency'] = $currency; // Valuutta
				$this->data['device'] = $device; // Maksup��te
				$this->data['content'] = $content; // Maksun tyyppi
				$this->data['type'] = $type; // Maksutavat
				$this->data['algorithm'] = $algorithm; // Algoritmi
				$this->data['delivery_date'] = $delivery_date; // Toimitusp�iv�
				$this->data['firstname'] = $firstname; // Tilaajan etunimi
				$this->data['familyname'] = $familyname; // Tilaajan sukunimi
				$this->data['address'] = $address; // Tilaajan osoite
				$this->data['postcode'] = $postcode; // Tilaajan postinumero
				$this->data['postoffice'] = $postoffice; // Tilaajan postitoimipaikka
				$this->data['mac'] = $mac1; // Turvatarkiste

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout.tpl';
				} else {
					$this->template = 'default/template/payment/checkout.tpl';
				}

				$this->render();
			}
		}
	} // end index

	public function callback() {
		$this->language->load('payment/checkout');

		// Ladataan paluuarvot
		$version = $this->request->get['VERSION']; // Maksun versio
		$stamp = $this->request->get['STAMP']; // Maksun tunnus
		$reference = $this->request->get['REFERENCE']; // Maksun viitenumero
		$payment = $this->request->get['PAYMENT']; // Maksun arkistotunnus
		$status = $this->request->get['STATUS']; // Maksun tilatieto
		$algorithm = $this->request->get['ALGORITHM']; // K�ytetty algoritmi
		$return_mac = $this->request->get['MAC']; // Turvatarkiste
                
                // We extract order_id from reference --> 15008 = 1500 order_id
                $order_id= substr($reference, 0, strlen($reference)-1);
                
                if (!$this->config->get('checkout_test')) {
                        $merchant = $this->config->get('checkout_merchant'); // Myyj�n tunniste
                        $safety_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
                } else {
                        $merchant = 375917; // Myyj�n tunniste jos testitila
                        $safety_key = 'SAIPPUAKAUPPIAS'; // Turva-avain jos testitila
                }

		// Lasketaan tarkiste paluuarvoista
		$mac = strtoupper(md5($safety_key . '&' . $version . '&' . $stamp . '&' . $reference . '&' . $payment . '&' . $status . '&' . $algorithm));

		if($return_mac === $mac) {
			if($this->config->get('checkout_debug')) {
				$aika = date("Y-m-d H:i:s");
				$viesti = $this->language->get('text_success');
				//$geturl = print_r($this->request->get);
				$geturl = trim($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"], "/") ;
				$getdata = print_r($this->request->get, true);

				file_put_contents(DIR_LOGS . "checkout.txt", "akia {$aika} \n", FILE_APPEND);
				file_put_contents(DIR_LOGS . "checkout.txt", "viesti {$viesti}\n", FILE_APPEND);
				file_put_contents(DIR_LOGS . "checkout.txt", "geturl {$geturl}\n", FILE_APPEND);
				file_put_contents(DIR_LOGS . "checkout.txt", "getdata {$getdata}\n", FILE_APPEND);


				file_put_contents(DIR_LOGS . "checkout.txt", "{$aika} {$viesti}\n{$geturl}\n{$getdata}\n", FILE_APPEND);
			}

			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);

			if($status == 2 || $status == 8) {
				$comment = sprintf($this->language->get('text_reference'), $reference);
				$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_ok_status_id'), $comment, true);
				if($this->config->get('checkout_log')) {
					$aika = date("Y-m-d H:i:s");
					$tilaus = $this->language->get('text_order_number') . $this->request->get['STAMP'];
					$viesti = sprintf($this->language->get('text_checkout_status'), $this->language->get('text_status_' . $status), $status);


					file_put_contents(DIR_LOGS . "checkout.log", "{$aika} {$tilaus} {$viesti}\n", FILE_APPEND);
				}
			} elseif ($status == 3 || $status == 5 || $status == 7) {
				$comment = sprintf($this->language->get('text_reference'), $reference);
				$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_delayed_status_id'), $comment, true);
				if($this->config->get('checkout_log')) {
					$aika = date("Y-m-d H:i:s");
					$tilaus = $this->language->get('text_order_number') . $this->request->get['STAMP'];
					$viesti = sprintf($this->language->get('text_checkout_status'), $this->language->get('text_status_' . $status), $status);
					file_put_contents(DIR_LOGS . "checkout.log", "{$aika} {$tilaus} {$viesti}\n", FILE_APPEND);
				}
			} elseif ($status == 10) {
				$comment = sprintf($this->language->get('text_reference'), $reference);
				$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_delayed_status_id'), $comment, true);
				if($this->config->get('checkout_log')) {
					$aika = date("Y-m-d H:i:s");
					$tilaus = $this->language->get('text_order_number') . $this->request->get['STAMP'];
					$viesti = sprintf($this->language->get('text_checkout_status'), $this->language->get('text_status_' . $status), $status);
					file_put_contents(DIR_LOGS . "checkout.log", "{$aika} {$tilaus} {$viesti}\n", FILE_APPEND);
				}
			} else {
				$comment = sprintf($this->language->get('text_reference'), $reference);
				$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_unknown_status_id'), $comment, true);
				if($this->config->get('checkout_log')) {
					$aika = date("Y-m-d H:i:s");
					$tilaus = $this->language->get('text_order_number') . $this->request->get['STAMP'];
					$viesti = sprintf($this->language->get('text_checkout_status'), $this->language->get('text_status_' . $status), $status);
					file_put_contents(DIR_LOGS . "checkout.log", "{$aika} {$tilaus} {$viesti}\n", FILE_APPEND);
				}
			}

			$this->redirect($this->url->link('checkout/success'));

		} else {
			if($this->config->get('checkout_debug')) {
				$aika = date("Y-m-d H:i:s");
				$viesti = $this->language->get('return_error');
				$getdata = print_r($this->request->get, true);
				file_put_contents(DIR_LOGS . "checkout.txt", "{$aika} {$viesti}\n{$getdata}\n{$mac}\n\n", FILE_APPEND);
			}

			if($this->config->get('checkout_log')) {
				file_put_contents(DIR_LOGS . "checkout.log", date("Y-m-d H:i:s") . " " . $this->language->get('return_error') . " "  . $this->language->get('text_order_number') . $this->request->get['STAMP'] . "\n", FILE_APPEND);
			}

			if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
					$this->data['base'] = $this->config->get('config_url');
			} else {
					$this->data['base'] = $this->config->get('config_ssl');
			}

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['return_error'] = $this->language->get('return_error');
			$this->data['error_description'] = sprintf($this->language->get('error_description'), $this->language->get('button_continue'));

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('information/contact');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
				} else {
					$this->template = 'default/template/payment/checkout_error.tpl';
				}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		}
	} // end callback

	public function canceled() {
		$this->language->load('payment/checkout');

		if($this->config->get('checkout_debug')) {
			$aika = date("Y-m-d H:i:s");
			$viesti = $this->language->get('text_error_canceled');
			$getdata = print_r($this->request->get, true);
			file_put_contents(DIR_LOGS . "checkout.txt", "{$aika} {$viesti}\n{$getdata}\n", FILE_APPEND);
		}

		if($this->config->get('checkout_log')) {
			file_put_contents(DIR_LOGS . "checkout.log", date("Y-m-d H:i:s") . " " . $this->language->get('text_error_canceled') . " "  . $this->language->get('text_order_number') . $this->request->get['STAMP'] . "\n", FILE_APPEND);
		}

		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$this->data['base'] = $this->config->get('config_url');
		} else {
			$this->data['base'] = $this->config->get('config_ssl');
		}

		$this->document->setTitle($this->language->get('heading_title_canceled'));

		$this->data['heading_title'] = $this->language->get('heading_title_canceled');

		$this->data['return_error'] = $this->language->get('return_error_canceled');
		$this->data['error_description'] = sprintf($this->language->get('error_description_canceled'), $this->language->get('button_continue'));

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('checkout/checkout');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
		} else {
			$this->template = 'default/template/payment/checkout_error.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	} // end canceled

	public function reject() {
		$this->language->load('payment/checkout');

		if($this->config->get('checkout_debug')) {
			$aika = date("Y-m-d H:i:s");
			$viesti = $this->language->get('text_error_reject');
			$getdata = print_r($this->request->get, true);
			file_put_contents(DIR_LOGS . "checkout.txt", "{$aika} {$viesti}\n{$getdata}\n", FILE_APPEND);
		}

		if($this->config->get('checkout_log')) {
			file_put_contents(DIR_LOGS . "checkout.log", date("Y-m-d H:i:s") . " " . $this->language->get('text_error_reject') . " "  . $this->language->get('text_order_number') . $this->request->get['STAMP'] . "\n", FILE_APPEND);
		}

		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$this->data['base'] = $this->config->get('config_url');
		} else {
			$this->data['base'] = $this->config->get('config_ssl');
		}

		$this->document->setTitle($this->language->get('heading_title_reject'));

		$this->data['heading_title'] = $this->language->get('heading_title_reject');

		$this->data['return_error'] = $this->language->get('return_error_reject');
		$this->data['error_description'] = sprintf($this->language->get('error_description_reject'), $this->language->get('button_continue'));

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('checkout/checkout');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
		} else {
			$this->template = 'default/template/payment/checkout_error.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	} // end reject
}
?>