<?php 
class ControllerToolPopup extends Controller { 
	private $error = array();
	
	public function index() {		
		$this->load->language('tool/popup');
		$this->load->model('tool/popup');
		$this->load->model('tool/image');
		
		$this->model_tool_popup->createTablesInDatabse();
		$this->document->setTitle($this->language->get('heading_title'));
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', 'tool/popup')) {		
			$this->model_tool_popup->adddata($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['c_data'] = $this->language->get('c_data');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_popup_extent'] = $this->language->get('text_popup_extent');
		$this->data['text_allow'] = $this->language->get('text_allow');
		$this->data['text_disallow'] = $this->language->get('text_disallow');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_image_size'] = $this->language->get('entry_image_size');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['entry_blackout'] = $this->language->get('entry_blackout');
		$this->data['text_general'] = $this->language->get('text_general');
		$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_allowance'] = $this->language->get('text_allowance');
		$this->data['text_dynamic'] = $this->language->get('text_dynamic');
		$this->data['text_url'] = $this->language->get('text_url');
		$this->data['text_mobile'] = $this->language->get('text_mobile');
		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_importemail'] = $this->language->get('text_importemail');
		$this->data['text_viewemail'] = $this->language->get('text_viewemail');
		$this->data['text_style'] = $this->language->get('text_style');
		$this->data['text_message'] = $this->language->get('text_message');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_logo'] = $this->language->get('text_logo');
		$this->data['text_fname'] = $this->language->get('text_fname');
		$this->data['text_lname'] = $this->language->get('text_lname');
		$this->data['token'] = $this->session->data['token'];

		$this->data['languages'] = $this->model_tool_popup->getLanguages();
		$this->data['action'] = $this->url->link('tool/popup', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action1'] = $this->url->link('tool/popupemail', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['emaillist'] =  $this->url->link('tool/popup/csv','token=' . $this->session->data['token'],'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
		if(isset($this->request->post['contact'])) {
			$this->data['contact'] = $this->request->post['contact'];
		} else {
			$this->data['contact'] = $this->model_tool_popup->getdata();
		}

		if(isset($this->request->post['dynamic'])) {
			$this->data['dynamic'] = $this->request->post['dynamic'];
		} else {
			$this->data['dynamic'] = $this->model_tool_popup->getdatad();
		}

		if(isset($this->request->post['newsletter'])) {
			$this->data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$this->data['newsletter'] = $this->model_tool_popup->getdatan();
		}
		
		$this->data['locations'] = array('Bottom-left','Bottom-right','Bottom-center','Top-left','Top-right','Top-center','Middle-left','Middle-right'); 
		$this->data['allows'] = array('Show Once','Show Until Closed','Show Permanent','Show On Page Load','Show On Browser Close'); 
		$this->data['themes'] = array('theme1','theme2','theme3','theme4','theme5','theme6','theme7','theme8','theme9','theme10','theme11','theme12');
		$this->data['styles'] = array('Bottom to top','Top to bottom','Left to right','Right to left'); 
		foreach ($this->data['languages'] as $key => $value) {
			if(isset($this->data['contact'][$value['language_id']])) {
				$this->data['contact'][$value['language_id']]['thumb'] = $this->model_tool_image->resize($this->data['contact'][$value['language_id']]['image'], 100, 100);
			} else {
				$this->data['contact'][$value['language_id']]['thumb']  = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				$this->data['contact'][$value['language_id']]['left']  = '';
				$this->data['contact'][$value['language_id']]['status']  = 0;
				$this->data['contact'][$value['language_id']]['blackout']  = 1;
				$this->data['contact'][$value['language_id']]['width']  = 220;
				$this->data['contact'][$value['language_id']]['height']  = 180;
				$this->data['contact'][$value['language_id']]['mobile']  = 1;
				$this->data['contact'][$value['language_id']]['loc']  = 0;
				$this->data['contact'][$value['language_id']]['pc']  = 0;
				$this->data['contact'][$value['language_id']]['allow']  = 0;
				$this->data['contact'][$value['language_id']]['image']  = 'image/no_image.jpg';
			}

			if(!isset($this->data['dynamic'][$value['language_id']])) {
				$this->data['dynamic'][$value['language_id']]['theme']  = 0;
				$this->data['dynamic'][$value['language_id']]['url']  = '';
				$this->data['dynamic'][$value['language_id']]['status']  = 0;
				$this->data['dynamic'][$value['language_id']]['message']  = '';
				$this->data['dynamic'][$value['language_id']]['style']  = 0;
			}

			if(isset($this->data['newsletter'][$value['language_id']])) {
				$this->data['newsletter'][$value['language_id']]['thumb'] = $this->model_tool_image->resize($this->data['newsletter'][$value['language_id']]['image'], 100, 100);
			} else {	
				$this->data['newsletter'][$value['language_id']]['theme']  = 0;
				$this->data['newsletter'][$value['language_id']]['logo']  = 1;
				$this->data['newsletter'][$value['language_id']]['status']  = 0;
				$this->data['newsletter'][$value['language_id']]['fname']  = 1;
				$this->data['newsletter'][$value['language_id']]['width']  = 220;
				$this->data['newsletter'][$value['language_id']]['height']  = 180;
				$this->data['newsletter'][$value['language_id']]['message']  = "";
				$this->data['newsletter'][$value['language_id']]['lname']  = 1;
				$this->data['newsletter'][$value['language_id']]['image']  = 'image/no_image.jpg';
				$this->data['newsletter'][$value['language_id']]['thumb']  = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			}
		}
		

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/popup', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'tool/popup.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	public function csv(){
		 $this->load->model("tool/popupemail");
		 $fields = array();
		 $sample_data = array();
		 array_push($fields,'first_name','last_name','email');
		 $popupemail = $this->model_tool_popupemail->getfh($data=array());
		
		 for($i =0; $i < count($popupemail); $i++){

		   $sample_data[$i]['first_name'] = $popupemail[$i]['fname'];
		   $sample_data[$i]['last_name'] = $popupemail[$i]['lname'];
		   $sample_data[$i]['email'] = $popupemail[$i]['email'];
		 }

		 $this->load->library('exportcsv');
		 $csv = new ExportCSV();
		 $csv->fields = $fields;
		 $csv->result = $sample_data;
		 $csv->process();
		 $csv->download('emaillist.csv');
	}
}
?>