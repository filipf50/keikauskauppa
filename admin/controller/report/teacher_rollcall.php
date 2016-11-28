<?php
class ControllerReportTeacherRollcall extends Controller { 
	public function index() {   
		$this->language->load('report/teacher_rollcall');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}
		
		if (isset($this->request->get['filter_status_id'])) {
			$filter_status_id = $this->request->get['filter_status_id'];
		} else {
			$filter_status_id = 0;
		}
                
                if (isset($this->request->get['filter_option'])) {
			$filter_option = $this->request->get['filter_option'];
		} else {
			$filter_option = '';
		}
                
                if (isset($this->request->get['roll_date'])) {
			$roll_date = $this->request->get['roll_date'];
		} else {
			$roll_date = date('Y-m-d');
		}
						
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}
		
		if (isset($this->request->get['filter_status_id'])) {
			$url .= '&filter_status_id=' . $this->request->get['filter_status_id'];
		}
                
                if (isset($this->request->get['filter_option'])) {
			$url .= '&filter_option=' . $this->request->get['filter_option'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/teacher_courses', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/teacher');
		
		$this->data['products'] = array();
		
		$data = array(
			'filter_name'	 => $filter_name, 
			'filter_model'           => $filter_model, 
			'filter_status_id' => $filter_status_id,
                        'filter_option' =>$filter_option,
                        'roll_date'=>$roll_date,
			'start'                  => 0,
			'limit'                  => 999999 //No limit
		);
				
		$results = $this->model_report_teacher->getCourses($data);
                $prev_product_order_id='';
                foreach ($results as $result) {
                    if ($result['order_id'].'-'.$result['product_name'].'-'.$result['order_product_id']!=$prev_product_order_id){	
                        if (isset($result['assist'])){
                            $assist=$result['assist'];
                        }else{
                            $assist=false;                                    
                        }
                        $options_data=array();
                            
                        $options_data[]=array(
                            'name'    => $result['option_name'],
                            'value'     => $result['option_value']
                        );
                        $this->data['courses'][$result['order_id'].'-'.$result['product_name'].'-'.$result['order_product_id']] = array(
                                'order_id'  => $result['order_id'],
                                'order_product_id' => $result['order_product_id'],
                                'status'    => $result['status'],
                                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                                'email'     => $result['email'],
                                'telephone' => $result['telephone'],
				'name'      => $result['product_name'],
				'model'     => $result['model'],
				'options'   => $options_data,
                                'assist'    => $assist
			);
                        $prev_product_order_id=$result['order_id'].'-'.$result['product_name'].'-'.$result['order_product_id'];
                    }else{
                        $this->data['courses'][$result['order_id'].'-'.$result['product_name'].'-'.$result['order_product_id']]['options'][]=array(
                                'name'    => $result['option_name'],
                                'value'     => $result['option_value']
                            );
                    }
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		
		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_status'] = $this->language->get('column_status');
                $this->data['column_date_added'] = $this->language->get('column_date_added');
                $this->data['column_email'] = $this->language->get('column_email');
                $this->data['column_phone'] = $this->language->get('column_phone');
                $this->data['column_product_name'] = $this->language->get('column_product_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_option'] = $this->language->get('column_option');
		$this->data['column_value'] = $this->language->get('column_value');
                $this->data['column_assist'] = $this->language->get('column_assist');
		
		$this->data['entry_product_name'] = $this->language->get('entry_product_name');
		$this->data['entry_model'] = $this->language->get('entry_model');
                $this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_status'] = $this->language->get('entry_status');
                $this->data['entry_roll_date'] = $this->language->get('entry_roll_date');

		$this->data['button_filter'] = $this->language->get('button_filter');
                $this->data['button_excel'] = $this->language->get('button_excel');
                $this->data['button_save'] = $this->language->get('button_save');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
                if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
                
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}

		if (isset($this->request->get['filter_status_id'])) {
			$url .= '&filter_status_id=' . $this->request->get['filter_status_id'];
		}
                
                if (isset($this->request->get['filter_option'])) {
			$url .= '&filter_option=' . $this->request->get['filter_option'];
		}
                
				
		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;		
                $this->data['filter_option'] = $filter_option;	
		$this->data['filter_status_id'] = $filter_status_id;
                $this->data['roll_date'] = $roll_date;
		$this->data['save']=$this->url->link('report/teacher_rollcall/save', 'token=' . $this->session->data['token'] . $url, 'SSL');
                
                $this->template = 'report/teacher_rollcall.tpl';
                
                if(isset($this->request->get['export'])){
                    if ($this->request->get['export']=='excell'){
                        $this->template='report/excel.tpl';
                    }
                }		
		
                $this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
        
        public function save(){
            
            $this->language->load('report/teacher_rollcall');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->load->model('report/teacher');
            
            $fault=array();
            $assist=array();
            
            if(isset($this->request->post['fault'])){
                $fault=$this->request->post['fault'];
            }
            
            if(isset($this->request->post['assist'])){
                $assist=$this->request->post['assist'];
            }
            
            $this->model_report_teacher->saveRollCall($fault, $assist, $this->request->post['roll_date']);


            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                    $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_model'])) {
                    $url .= '&filter_model=' . $this->request->get['filter_model'];
            }

            if (isset($this->request->get['filter_status_id'])) {
                    $url .= '&filter_status_id=' . $this->request->get['filter_status_id'];
            }

            if (isset($this->request->get['filter_option'])) {
			$url .= '&filter_option=' . $this->request->get['filter_option'];
            }
                
            if (isset($this->request->post['roll_date'])) {
                    $url .= '&roll_date=' . $this->request->post['roll_date'];
            }

            if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('report/teacher_rollcall', 'token=' . $this->session->data['token'] . $url, 'SSL'));

            $this->index();
        }
}
?>