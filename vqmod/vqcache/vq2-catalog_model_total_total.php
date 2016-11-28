<?php
class ModelTotalTotal extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->language->load('total/total');
	 

				if (isset($this->session->data['layaway_payment']) && !isset($this->session->data['customer_info'])) {
					$total_data[] = array(
						'code'		 => 'layaway_fee',
						'title'		 => $this->config->get('layaway_button_name') . ' ' . $this->language->get('text_payment_fee'),
						'text'		 => $this->currency->format($this->config->get('layaway_payment_fee')),
						'value'		 => $this->config->get('layaway_payment_fee'),
						'sort_order' => $this->config->get('total_sort_order') - 1
					);
					$total += $this->config->get('layaway_payment_fee');
				}
			
		$total_data[] = array(
			'code'       => 'total',
			'title'      => $this->language->get('text_total'),
			'text'       => $this->currency->format(max(0, $total)),
			'value'      => max(0, $total),
			'sort_order' => $this->config->get('total_sort_order')
		);
	}
}
?>