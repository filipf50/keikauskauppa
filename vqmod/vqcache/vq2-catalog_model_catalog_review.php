<?php
class ModelCatalogReview extends Model {		
	public function addReview($product_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added = NOW()");


			$review_id = $this->db->getLastId();



			$this->load->model('catalog/product');



			$product_info = $this->model_catalog_product->getProduct($product_id);



			$template = new EmailTemplate($this->request, $this->registry);

			$template->tracking('product/review');

            $template->setTitle(sprintf($this->language->get('text_subject'), $product_info['name']));



			$template->appendDataLanguage($this->language, array(

            	'text_product',

            	'text_author',

            	'text_rating',

            	'text_message',

            	'text_approve'

            ));



			$template->appendData(array(

				'review_author' => $data['name'],

				'review_rating' => $data['rating'],

				'review_message' => $data['text'],

				'product_name' => $product_info['name'],

				'product_link' => $this->url->link('product/product', 'product_id=' . $this->request->get['product_id']),

				'review_approve' => (defined('HTTP_ADMIN') ? HTTP_ADMIN : HTTP_SERVER.'admin/') . 'index.php?route=catalog/review/update&review_id=' . $review_id

			));



			$html = $template->fetch('product_review.tpl', '_mail.tpl');



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

			$mail->setSubject(sprintf($this->language->get('text_subject'), $product_info['name']));

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
		
	public function getReviewsByProductId($product_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 20;
		}		
		
		$query = $this->db->query("SELECT r.review_id, r.author, r.rating, r.text, p.product_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
			
		return $query->rows;
	}

	public function getTotalReviewsByProductId($product_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
}
?>