<?php
class ModelAccountReturn extends Model {
	public function addReturn($data) {			      	
		$this->db->query("INSERT INTO `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', customer_id = '" . (int)$this->customer->getId() . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_status_id = '" . (int)$this->config->get('config_return_status_id') . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW()");


			$return_id = $this->db->getLastId();

			

			$this->language->load('account/return');

			

			// HTML email

			$template = new EmailTemplate($this->request, $this->registry);

			$template->tracking('account/return');

            $template->setTitle(sprintf($this->language->get('text_subject'), $this->config->get('config_name')));



			$template->appendDataLanguage($this->language, array(

            	'text_subject',

            	'text_return_detail',

            	'text_firstname',

            	'text_lastname',

            	'text_email',

            	'text_telephone',

            	'text_order_id',

            	'text_order_date',

            	'text_product',

            	'text_product_name',

            	'text_model',

            	'text_quantity',

            	'text_reason',

            	'text_opened',

            	'text_comment',

            	'text_action'

            ));



			$this->load->model('localisation/return_reason');



			// Backwards compatabile with 1.5.1.3

			if(isset($this->request->post['return_product'])){



				foreach ($this->request->post['return_product'] as $return_product) {

					$return_reason_info = $this->model_localisation_return_reason->getReturnReason($return_product['return_reason_id']);



					if(isset($return_product['product'])){

						$name = $return_product['product'];

					} elseif(isset($return_product['name'])){

						$name = $return_product['name'];

					} else {

						$name = '';

					}



					$return_product = array(

						'name' => $name,

						'model' => $return_product['model'],

						'quantity' => $return_product['quantity'],

						'reason' => ($return_reason_info) ? $return_reason_info['name'] : '',

						'opened' => $return_product['opened'] ? $this->language->get('text_yes') : $this->language->get('text_no'),

						'comment' => (isset($return_product['comment'])) ? nl2br($return_product['comment']) : ''

					);

				}



			} else {

				$return_reason_info = $this->model_localisation_return_reason->getReturnReason($data['return_reason_id']);

				$return_product = array(

					'name' => $data['product'],

					'model' => $data['model'],

					'quantity' => $data['quantity'],

					'reason' => ($return_reason_info) ? $return_reason_info['name'] : '',

					'opened' => $data['opened'] ? $this->language->get('text_yes') : $this->language->get('text_no'),

					'comment' => (isset($data['comment'])) ? nl2br($data['comment']) : ''

				);



			}

			

			$template->appendData(array(

				'text_greeting' 	=> sprintf($this->language->get('text_greeting'), $this->config->get('config_name')),

				'firstname' 		=> $data['firstname'],

				'lastname' 			=> $data['lastname'],

				'email' 			=> $data['email'],

				'telephone' 		=> $data['telephone'],

				'order_id' 			=> $data['order_id'],

				'order_date' 		=> $data['date_ordered'],

				'comment' 			=> (isset($data['comment'])) ? nl2br($data['comment']) : '',

				'return_product' 	=> $return_product,

				'return_link' 		=> (defined('HTTP_ADMIN') ? HTTP_ADMIN : HTTP_SERVER.'admin/') . 'index.php?route=sale/return/info&return_id=' . $return_id

			));



			$html = $template->fetch('return_admin.tpl', '_mail.tpl');



			$mail = new Mail();

			$mail->protocol = $this->config->get('config_mail_protocol');

			$mail->parameter = $this->config->get('config_mail_parameter');

			$mail->hostname = $this->config->get('config_smtp_host');

			$mail->username = $this->config->get('config_smtp_username');

			$mail->password = $this->config->get('config_smtp_password');

			$mail->port = $this->config->get('config_smtp_port');

			$mail->timeout = $this->config->get('config_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));

			$mail->setFrom($this->config->get('config_email'));

			$mail->setSender($this->config->get('config_name'));

			$mail->setSubject(sprintf($this->language->get('text_subject'), $this->config->get('config_name')));

			$mail->setHtml($html);

			$mail->send();



			// Send to additional alert emails

			$emails = explode(',', $this->config->get('config_alert_emails'));



			foreach ($emails as $email) {

				if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {

					$mail->setTo($email);

					$mail->send();

				}

			}

			
	}
	
	public function getReturn($return_id) {
		$query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, r.email, r.telephone, r.product, r.model, r.quantity, r.opened, (SELECT rr.name FROM " . DB_PREFIX . "return_reason rr WHERE rr.return_reason_id = r.return_reason_id AND rr.language_id = '" . (int)$this->config->get('config_language_id') . "') AS reason, (SELECT ra.name FROM " . DB_PREFIX . "return_action ra WHERE ra.return_action_id = r.return_action_id AND ra.language_id = '" . (int)$this->config->get('config_language_id') . "') AS action, (SELECT rs.name FROM " . DB_PREFIX . "return_status rs WHERE rs.return_status_id = r.return_status_id AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, r.comment, r.date_ordered, r.date_added, r.date_modified FROM `" . DB_PREFIX . "return` r WHERE return_id = '" . (int)$return_id . "' AND customer_id = '" . $this->customer->getId() . "'");
		
		return $query->row;
	}
	
	public function getReturns($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 20;
		}	
				
		$query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, rs.name as status, r.date_added FROM `" . DB_PREFIX . "return` r LEFT JOIN " . DB_PREFIX . "return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.customer_id = '" . $this->customer->getId() . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.return_id DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
			
	public function getTotalReturns() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return`WHERE customer_id = '" . $this->customer->getId() . "'");
		
		return $query->row['total'];
	}
	
	public function getReturnHistories($return_id) {
		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM " . DB_PREFIX . "return_history rh LEFT JOIN " . DB_PREFIX . "return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY rh.date_added ASC");

		return $query->rows;
	}			
}
?>