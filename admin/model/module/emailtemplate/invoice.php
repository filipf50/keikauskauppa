<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class ModelModuleEmailTemplateInvoice extends Model {
	
	/**
	 * Set array of all available tags
	 */
	public function getInvoice($order_id, $output = false){
		$order_id = intval($order_id);		
		
		$this->load->model('localisation/language');
		$this->load->model('sale/order');
		$this->load->model('setting/store');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		
		# Directory
		//$dir = str_replace('/system/', '', DIR_SYSTEM) . '/../resources/'.date('Y-m-d').'/'; # path outside doc root more secure
		$dir = str_replace('/system/', '', DIR_SYSTEM) . '/image/data/emailtemplate/resources/'.date('Y-m-d').'/';
		if(!is_dir($dir) || !is_writable($dir)){
			if(!@mkdir($dir, 0777, true)){
				trigger_error("Error: unable to create directory: {$dir}");
				exit;
			}
		}
		
		# Order
		$order_info = $this->model_sale_order->getOrder($order_id);
		if($order_info == false) return false;
		$order_info['language_id'] = ($order_info['language_id']) ? $order_info['language_id'] : 1;
		$order_info['shipping_address'] = EmailTemplate::formatAddress($order_info, 'shipping', $this->data['order']['shipping_address_format']);
		$order_info['payment_address'] = EmailTemplate::formatAddress($order_info, 'payment', $this->data['order']['payment_address_format']);		
		$order_info['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
		$order_info['totals'] = $this->model_sale_order->getOrderTotals($order_id);
		
		# Store
		$store_info = array_merge(
			$this->model_setting_store->getStore($order_info['store_id']),
			$this->model_setting_setting->getSetting("config", $order_info['store_id'])
		);
		if(!isset($store_info['config_url'])) {
			$store_info['config_url'] = HTTP_CATALOG;
		}
				
		# Order - Products
		$order_info['products'] = array();	
		$products = $this->model_sale_order->getOrderProducts($order_id);		
		foreach ($products as $product) {
			$option_data = array();		
			$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);		
			foreach ($options as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
				}		
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => $value
				);
			}		
			$order_info['products'][] = array(
				'name'     => $product['name'],
				'model'    => $product['model'],
				'option'   => $option_data,
				'quantity' => $product['quantity'],
				'url' 	   => str_replace(HTTP_SERVER, HTTP_CATALOG, $this->url->link('product/product', 'product_id=' . $product['product_id'])), # url without admin
				'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
			);
		}
			
		# Order - Vouchers
		$order_info['vouchers'] = array();
		if(method_exists($this->model_sale_order, 'getOrderVouchers')){		
			$vouchers = $this->model_sale_order->getOrderVouchers($order_id);		
			foreach ($vouchers as $voucher) {
				$order_info['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
		}
		
		# Extension settings
		$emailtemplate = array();
		foreach($this->model_setting_setting->getSetting("emailtemplate", $order_info['store_id']) as $key => $val){
			$emailtemplate[$key] = $val[$order_info['language_id']];
		}
				
		# Language
		$languages = $this->model_localisation_language->getLanguages();
		foreach($languages as $lang){
			if($lang['language_id'] == $order_info['language_id']){
				$oLanguage = new Language($lang['directory']);
				$language = array_merge(
					$oLanguage->load($lang['filename']),
					$oLanguage->load('sale/order'),
					$oLanguage->load('sale/invoice')
				);
			}
		}
		
		# Delete old order file
		if($order_info['invoice_filename'] && file_exists($dir.$order_info['invoice_filename'])){
			@unlink($dir.$order_info['invoice_filename']);
		}
				
		# Filename
		while (true) {
			$filename = uniqid('order_'.$order_id.'_', true).'.pdf';
			if (!file_exists($dir.$filename)) break;
		}

		# Merge all data together
		$data = $emailtemplate;
		$data['order'] = $order_info;
		$data['store'] = $store_info;
				
		# Create Invoice
		$pdf = new invoicePdf('P', 'mm', 'A4');				
		$pdf->setLanguageArray($language);
		$pdf->Build($data);
		$pdf->Draw();

		if($output === true){
			$pdf->Output($dir.$filename, 'I');
		} elseif($pdf->Output($dir.$filename, 'F') !== false){
			$p = DB_PREFIX;
			$this->db->query("UPDATE `{$p}order` SET `invoice_filename` = '{$filename}' WHERE `order_id` = '{$order_id}'");
		}
		
		return $dir.$filename;
	}
}


/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
# CONFIG in: library/shared/tcpdf/config
require_once(DIR_SYSTEM . '/library/shared/tcpdf/tcpdf.php');
require_once(DIR_SYSTEM . '/library/shared/tcpdf/include/tcpdf.EasyTable.php');
require_once(DIR_SYSTEM . '/library/shared/tcpdf/include/tcpdf.PDFImage.php');

class invoicePdf extends TCPDF_EasyTable {
	var $data = array(); 
		
	/**
	 * Sets PDF Config
	 * 
	 * @param array $data
	 * @return invoicePdf
	 */
	public function Build($data) {	
		$this->data = $data;
		
		# Set PDF protection (encryption)
		$this->SetProtection(array('modify', 'copy'), '', null, 1, null);
		
		# Set document meta-information
		$this->SetAuthor('opencart-templates');
		$this->SetCreator('tdpdf');
		$this->SetSubject($this->data['store']['config_name']);
		$this->SetTitle($this->data['store']['config_name']);
		//$this->SetKeywords();

		# Set font
		$this->SetFont(PDF_FONT_NAME_MAIN, '', 7);
		$this->SetTextColor(0, 0, 0);
		
		# Set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		# Set margins
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		# Set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		# Image scale
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		# Table options
		$this->SetTableOptions();
				
		return $this;
	}
	
	/**
	 * Main method responsible for drawing the sections onto the page
	 * Group products into page(s)?
	 * 
	 * @return invoicePdf
	 */
	public function Draw(){
		if(count($this->data['order']['products']) >= $this->data['emailtemplate_invoice_products_limit']){
			$group_products = array_chunk($this->data['order']['products'], $this->data['emailtemplate_invoice_products_limit']);
			$lastPage = count($group_products);
			$currentPage = 1;
			foreach($group_products as $products){
				$this->AddPage();							
				if($currentPage == 1){			
					$storedY = $this->AddLogo();
					$this->AddOrderDetails($storedY);
					$stored2Y = $this->AddCompanyDetails();
					$storedY = $this->AddAddress(($stored2Y > $stored2Y) ? $stored2Y : $storedY);
					$this->setY($storedY);
				} 
				$this->AddProducts($this->data['order']['products']);
				if($currentPage == $lastPage){
					$this->AddVouchers($this->data['order']['vouchers']);
					$this->AddTotals($this->data['order']['totals']);					
				}
				$this->AddInvoiceText($this->data['emailtemplate_invoice_text']);
				$currentPage++;
			}
		} else { 
			$this->AddPage();
			$storedY = $this->AddLogo();
			$this->AddOrderDetails($storedY);
			$stored2Y = $this->AddCompanyDetails();
			$storedY = $this->AddAddress(($stored2Y > $stored2Y) ? $stored2Y : $storedY);
			$this->setY($storedY);
			$this->AddProducts($this->data['order']['products']);
			$this->AddVouchers($this->data['order']['vouchers']);
			$this->AddTotals($this->data['order']['totals']);
			$this->AddInvoiceText($this->data['emailtemplate_invoice_text']);
		}		
		return $this;
	}
		
	protected function AddProducts($products){		
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100; 
		$this->SetCellWidths(array($w1*35, $w1*20, $w1*15, $w1*15, $w1*15));

		$rows = array();
		foreach($products as $product){
			$rows[] = array(
				'<a href="'.$product['url'].'" style="text-decoration:none; color:#000000;">'.$product['name'].'</a>',
				$product['model'],
				$product['quantity'],
				$product['price'],
				$product['total']
			);
		}
		
		$this->EasyTable($rows, array(
			$this->getLanguage('column_product'),
			$this->getLanguage('column_model'),
			$this->getLanguage('column_quantity'),
			$this->getLanguage('column_price'),
			$this->getLanguage('column_total')
		));
	}
		
	protected function AddVouchers($vouchers){		
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100; 
		$this->SetCellWidths(array($w1*35, $w1*20, $w1*15, $w1*15, $w1*15));

		$rows = array();
		foreach($vouchers as $voucher){
			$rows[] = array(
				$voucher['description'],
				'',
				1,
				$voucher['amount'],
				$voucher['amount']
			);
		}
		
		$this->EasyTable($rows);
	}
		
	protected function AddTotals($totals){
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100;
		$this->SetCellWidths(array($w1*85, $w1*15));
		$this->SetFillColor(255,255,255);
		$this->SetCellAlignment(array('R','R'));		
		$rows = array();
		foreach($totals as $total){
			$rows[] = array(
				$total['title'],
				$total['text']
			);
		}		
		$this->EasyTable($rows);
	}
	
	
	/**
	 * Add Order Details
	 */
	protected function AddOrderDetails($storedY){
		$w = 29;
		$h = 4;
		$x = PDF_MARGIN_LEFT;
		$y = ($this->y>$storedY) ? $this->y : $storedY;
		$this->SetY($y);		
		$this->SetFont(PDF_FONT_NAME_MAIN, 'B', 9);
		$this->SetCellPaddings(0, 1, 0, 1);
		foreach(array( # Get max width
			'text_date_added', 
			'text_order_id', 
			'text_invoice_no', 
			'text_payment_method', 			
			'text_shipping_method'
		) as $var){
			$_w = $this->GetStringWidth($this->getLanguage($var));
			if($_w > $w) $w = $_w;
		}
		
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_date_added'), 0, 1, 'L');
	
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_order_id'), 0, 1, 'L');
	
		if($this->data['order']['invoice_no']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->getLanguage('text_invoice_no'), 0, 1, 'L');
		}
	
		if($this->data['order']['payment_method']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->getLanguage('text_payment_method'), 0, 1, 'L');
		}
	
		if($this->data['order']['shipping_method']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->getLanguage('text_shipping_method'), 0, 1, 'L');
		}
			
		$this->SetFont(PDF_FONT_NAME_MAIN,'', 9);
		$this->SetY($y);
		$x = $x+$w;
		$w = 45;
		
		$this->SetX($x);
		$this->Cell($w, $h, date($this->getLanguage('date_format_short'), strtotime($this->data['order']['date_added'])), 0, 1, 'L');
	
		$this->SetX($x);
		$this->Cell($w, $h, $this->data['order']['order_id'], 0, 1, 'L');
	
		if($this->data['order']['invoice_no']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->data['order']['invoice_prefix'] . $this->data['order']['invoice_no'], 0, 1, 'L');
		}
	
		if($this->data['order']['payment_method']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->data['order']['payment_method'], 0, 1, 'L');
		}
	
		if($this->data['order']['shipping_method']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->data['order']['shipping_method'], 0, 1, 'L');
		}
		
		return $this->getY();
	}
	
	/**
	 * Add Address
	 */
	protected function AddAddress($storedY){
		$this->SetFillColor($this->data['emailtemplate_invoice_color']);
		$this->SetTextColor(255, 255, 255);
		$this->SetDrawColor(162, 162, 162);
		$this->SetLineWidth(0.1);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'B', 10);
		
		$y = (($this->y>$storedY) ? $this->y : $storedY)+3;
		$x = PDF_MARGIN_LEFT;
		$w = 95.5;
		$h = 9;
		$this->SetY($y);
	
		$this->SetX($x);
		$this->setCellPaddings(4, 2, '', 1);
		$this->Cell($w, $h, $this->getLanguage('text_to'), 'TB', 0, 'L', true);
		$x2 = $this->GetX();
		$this->Cell($w, $h, $this->getLanguage('text_ship_to'), 'TB', 1, 'L', true);
			
		$this->SetFont(PDF_FONT_NAME_MAIN,'', 10);
		$this->SetTextColor(60, 60, 60);
		$this->setCellPadding(0);
		$w = $w-5.5;
		$h = $h-5;
		$y = $this->y+2;
		
		$txt = str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $this->data['order']['payment_address']);		
		$this->MultiCell($w, $h, $txt, 0, 'L', false, 1, $x+4, $y);
		$storedY = $this->getY();
		
		$txt = str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $this->data['order']['shipping_address']);
		$this->MultiCell($w, $h, $txt, 0, 'L', false, 1, $x2+4, $y);
		$stored2Y = $this->getY();
		
		return (($stored2Y>$storedY)?$stored2Y:$storedY)+4;
	}
	
	/**
	 * Add Invoice Text
	 */
	protected function AddInvoiceText($txt){
		$txt = html_entity_decode($txt, ENT_QUOTES, 'UTF-8');
		$this->Ln(5);		
		$this->SetFont(PDF_FONT_NAME_MAIN,'', 10);
		$this->SetTextColor(0, 0, 0);
		$this->writeHTML($txt, true, false, false, false, 'L');	
	}
	
	/**
	 * Add Logo
	 */
	protected function AddLogo(){
		$logo = DIR_IMAGE.($this->data['emailtemplate_invoice_logo'] ? $this->data['emailtemplate_invoice_logo'] : $this->data['store']['config_logo']);
		$info = $this->Image($logo, PDF_MARGIN_LEFT, PDF_MARGIN_TOP, $this->data['emailtemplate_invoice_logo_width'], 0, '', $this->data['store']['config_url'], 'N');
		return $this->GetY()+3;
	}
	
	protected function AddCompanyDetails(){
		$txt = $this->data['store']['config_name'];
		$this->SetFont(PDF_FONT_NAME_MAIN, 'B', 24);
		$this->SetTextColor($this->data['emailtemplate_invoice_heading_color']);
		$w = 98;
		$h = $this->getStringHeight($w, $txt);
		$x = $this->w-($w+PDF_MARGIN_RIGHT);
		$y = PDF_MARGIN_TOP;
		$cnt = $this->Multicell($w, $h, $txt, 0, 'R', false, 1, $x, $y);
		$this->Link($x, $y, $w, $h*$cnt, $this->data['store']['config_url'], 0);
		
		$w = 90;
		$x = $this->w-($w+PDF_MARGIN_RIGHT);
		$this->SetFont(PDF_FONT_NAME_MAIN, '', 9);
		$this->SetTextColor(60, 60, 60);
		$this->Multicell($w, 4, $this->data['store']['config_address'], 0, 'R', false, 1, $x);
		
		if($this->data['store']['config_telephone']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->getLanguage('text_telephone').' '.$this->data['store']['config_telephone'], 0, 1, 'R');
		}
		if($this->data['store']['config_fax']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->getLanguage('text_fax').' '.$this->data['store']['config_fax'], 0, 1, 'R');
		}
		if($this->data['store']['config_email']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->data['store']['config_email'], 0, 1, 'R', false, 'mailto:'.$this->data['store']['config_email']);
		}
		if($this->data['store']['config_url']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->data['store']['config_url'], 0, 1, 'R', false, $this->data['store']['config_url']);
		}
		return $this->y;
	}
					
	/**
	 * 
	 * @see tFPDF::Header()
	 */
	function Header(){
		
	}
	
	protected function setTableOptions(){
		$this->SetLineWidth(0.1);
		$this->SetCellPaddings(1.5, 2, 1, 2);
		$this->SetCellAlignment(array('L', 'L', 'R', 'R', 'R'));
		$this->SetCellFillStyle(2);
		$this->SetHeaderCellsFillColor($this->data['emailtemplate_invoice_color']);
		$this->SetFillColor(247, 247, 247);
		$this->SetDrawColor(150, 150, 150);
		$this->SetTableHeaderPerPage(true);
		$this->SetHeaderCellsFontColor(255, 255, 255);
		$this->SetFillImageCell(false);
	}
	
	/**
	 * Get language text
	 * @param $key
	 */
	public function getLanguage($key) {
		if (isset($this->l[$key])) {
			return $this->l[$key];
		} 
		return '';
	}
	
	/**
	 * @see TCPDF::Footer()
	 */
	function Footer(){
		$this->SetY($this->y);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'I', 7);		
		$w_page = isset($this->l['text_paging']) ? $this->l['text_paging'] : 'Page %s of %s';
		if (empty($this->pagegroups)) {
			$pagenumtxt = sprintf($w_page, $this->getAliasNumPage(), $this->getAliasNbPages());
		} else {
			$pagenumtxt = sprintf($w_page, $this->getPageNumGroupAlias(), $this->getPageGroupAlias());
		}		
		$this->Cell(0, 0, $pagenumtxt, 0, 0, 'C');
	}
	
	function GetInnerPageWidth(){
		return $this->getPageWidth()-(PDF_MARGIN_LEFT+PDF_MARGIN_RIGHT);
	}
			
	/**
	 * Overload to allow HEX color
	 * @see TCPDF::SetDrawColor()
	 */
	function SetDrawColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);	
		}
		return parent::SetDrawColor($col1, $col2, $col3, $col4, $ret, $name);
	}
	
	/**
	 * Overload to allow HEX color
	 * @see TCPDF::SetTextColor()
	 */
	function SetTextColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);
		}
		return parent::SetTextColor($col1, $col2, $col3, $col4, $ret, $name);
	}
	
	/**
	 * Overload to allow HEX color
	 * @see FPDF::SetFillColor()
	 */
	function SetFillColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);	
		}
		return parent::SetFillColor($col1, $col2, $col3, $col4, $ret, $name);
	}
	
	/**
	 * Overload to allow HEX color
	 * @see TCPDF_EasyTable::SetHeaderCellsFillColor()
	 */
	function SetHeaderCellsFillColor($R, $G=-1, $B=-1){
		if($R[0] == '#'){
			list($R, $G, $B) = $this->_hex2rbg($R);	
		}
		return parent::SetHeaderCellsFillColor($R, $G, $B);
	}
	
	/**
	 * Overload to allow HEX color
	 * @see TCPDF_EasyTable::SetCellFontColor()
	 */
	function SetCellFontColor($R, $G=-1, $B=-1){
		if($R[0] == '#'){
			list($R, $G, $B) = $this->_hex2rbg($R);	
		}
		return parent::SetCellFontColor($R, $G, $B);
	}
						
	# HEX to RGB
	function _hex2rbg($hex){
		$hex = substr($hex, 1);
		if(strlen($hex) == 6){
			list($col1, $col2, $col3) = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
		} elseif(strlen($hex) == 3) {
			list($col1, $col2, $col3) = array($hex[0].$hex[0], $hex[1].$hex[1], $hex[2].$hex[2]);
		} else {
			return false;
		}
		return array(hexdec($col1), hexdec($col2), hexdec($col3));
	}
	
	# pixel -> millimeter in 72 dpi
	function _px2mm($px){
		return $px*25.4/72;
	}
	
}