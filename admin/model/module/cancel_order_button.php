<?php
class ModelModuleCancelOrderButton extends Model {
    public function cancelOrder($order_id){
        $this->load->model('sale/order');
        
        $results=$this->model_sale_order->getOrderProducts($order_id);
        
        foreach($results as $product)
        {
            $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

            $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

            foreach ($option_query->rows as $option) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
            }            
        }
        
        $this->model_sale_order->addOrderHistory($order_id,array('order_status_id'=>$this->config->get('cob_cancelled_status_id'), 'notify'=>1,'comment'=>''));
        
        //Notify to admin
        $order_info=$this->model_sale_order->getOrder($order_id);
        
        $language = new Language($order_info['language_directory']);
        $language->load($order_info['language_filename']);
        $language->load('mail/order');

        $subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_id);

        $message  = $language->get('text_order') . ' ' . $order_id . "\n";
        $message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$this->config->get('cob_cancelled_status_id') . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

        if ($order_status_query->num_rows) {
                $message .= $language->get('text_order_status') . "\n";
                $message .= $order_status_query->row['name'] . "\n\n";
        }

        if ($order_info['customer_id']) {
                $message .= $language->get('text_link') . "\n";
                $message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";
        }

        $message .= $language->get('text_footer');

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
        $mail->setSender($order_info['store_name']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
        
        return true;
    }
    
    public function notify(){
        $url=HTTP_SERVER . "index.php?route=module/notify_when_arrives/notify&nwa_cron_key=" . $this->config->get('nwa_cron_key');
        // Crear un nuevo recurso cURL
        ob_start();
        $ch = curl_init();
        
        // Establecer URL y otras opciones apropiadas
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // Capturar la URL y pasarla al navegador
        curl_exec($ch);

        // Cerrar el recurso cURL y liberar recursos del sistema
        curl_close($ch);
        ob_end_clean();
        return;
    }
    
    private function sendEmail($store, $address, $subject, $message) {

	if (!isset($this->notify_mail)) {

	    $this->notify_mail = new Mail();
	    $this->notify_mail->protocol = $this->config->get('config_mail_protocol');
	    $this->notify_mail->parameter = $this->config->get('config_mail_parameter');
	    $this->notify_mail->hostname = $this->config->get('config_smtp_host');
	    $this->notify_mail->username = $this->config->get('config_smtp_username');
	    $this->notify_mail->password = $this->config->get('config_smtp_password');
	    $this->notify_mail->port = $this->config->get('config_smtp_port');
	    $this->notify_mail->timeout = $this->config->get('config_smtp_timeout');
	}

	$this->notify_mail->setFrom($store['email']);
	$this->notify_mail->setSender($store['name']);

	$this->notify_mail->setTo($address);
	$this->notify_mail->setSubject($subject);
	$this->notify_mail->setHtml($message);
	#$this->notify_mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
	#$this->notify_mail->setSender($order_info['store_name']);
	#$this->notify_mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'), md5(basename($this->config->get('config_logo'))));

	$this->notify_mail->send();
    }
}
?>