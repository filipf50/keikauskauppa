<?php
/****************************************************
*	CHECKOUT FINLAND PAYMENT METHOD					*
*	Version:	1.5.4								*
*	Date:		01-05-2013							*
*	File:		catalog/model/payment/checkout.php	*
*	Author:		HydeNet								*
*	Web:		www.hydenet.fi						*
*	Email:		info@hydenet.fi						*
****************************************************/

class ModelPaymentCheckout extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/checkout');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('checkout_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('checkout_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('checkout_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	

		$method_data = array();

		if ($status) {  
			$method_data = array( 
				'code'       => 'checkout',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('checkout_sort_order')
			);
		}

		return $method_data;
	}
}
?>