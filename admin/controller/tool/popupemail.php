<?php 
class ControllerToolPopupEmail extends Controller { 
	private $error = array();
	
	public function index() {		

		$this->load->language('tool/popupemail');
		$this->load->model('tool/popupemail');
		$this->model_tool_popupemail->createTablesInDatabse();
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/popupemail', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
   		$this->data['popupemail_id'] = $this->language->get('popupemail_id');
   		$this->data['popupemail_fname'] = $this->language->get('popupemail_fname');
   		$this->data['popupemail_lname'] = $this->language->get('popupemail_lname');
   		$this->data['popupemail_email'] = $this->language->get('popupemail_email');
   		$this->data['popupemail_delete'] = $this->language->get('popupemail_delete');
   		$this->data['popupemail_subscriber'] = $this->language->get('popupemail_subscriber');
   		$this->data['popupemail_unsubscriber'] = $this->language->get('popupemail_unsubscriber');
   		$this->data['popupemail_date'] = $this->language->get('popupemail_date');
   		$this->data['popupemail_setting'] = $this->language->get('popupemail_setting');
   		$this->data['button_cancel'] = $this->language->get('button_cancel');
    	$this->data['token'] = $this->session->data['token'];
    	$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
    	$this->data['action'] = $this->url->link('tool/popup', 'token=' . $this->session->data['token'], 'SSL');
     	if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$data = array(
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

		$this->data['popupemail']  = $this->model_tool_popupemail->getfh($data);
		$this->data['popupemailt']  = $this->model_tool_popupemail->getfht($data);
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_id'] = $this->url->link('tool/popupemail', 'token=' . $this->session->data['token'] . '&sort=id' . $url, 'SSL');	
		$this->data['sort_category'] = $this->url->link('tool/popupemail', 'token=' . $this->session->data['token'] . '&sort=category' . $url, 'SSL');	
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total =$this->data['popupemailt'];
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/popupemail', 'token=' . $this->session->data['token'] . $url .'&page={page}', 'SSL');
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'tool/popupemail.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	public function delete(){
		$id = $this->request->get['id'];
		$this->load->model('tool/popupemail');
		$this->load->language('tool/popupemail');
		$detail = $this->model_tool_popupemail->delete($id);
	}
	
}
?>