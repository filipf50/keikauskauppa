<?php
class ControllerReportTeacherCourses extends Controller { 
	public function index() {   
		$this->language->load('report/teacher_courses');

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
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$results = $this->model_report_teacher->getCourses($data);
                $prev_product_order_id='';
                
                $rc_status=$this->config->get('rc_status');
                
                $rc_week_days_descrition['Monday']=$this->config->get('rc_monday_description');
                $rc_week_days_descrition['Tuesday']=$this->config->get('rc_tuesday_description');
                $rc_week_days_descrition['Wednesday']=$this->config->get('rc_wednesday_description');
                $rc_week_days_descrition['Thursday']=$this->config->get('rc_thursday_description');
                $rc_week_days_descrition['Friday']=$this->config->get('rc_friday_description');
                $rc_week_days_descrition['Saturday']=$this->config->get('rc_saturday_description');
                $rc_week_days_descrition['Sunday']=$this->config->get('rc_sunday_description');
                
                $rc_attributes_id['start_date']=$this->config->get('rc_attribute_id_start_date');
                $rc_attributes_id['end_date']=$this->config->get('rc_attribute_id_end_date');
                $rc_attributes_id['week_day']=$this->config->get('rc_attribute_id_week_day');
                
                $this->data['rc_status']=$rc_status;
                $courses_time_tables=array();
                foreach ($results as $result) {
			if ($result['order_id'].'-'.$result['product_name'].'-'.$result['order_product_id']!=$prev_product_order_id){
                            $options_data=array();
                            
                            $options_data[]=array(
                                'name'    => $result['option_name'],
                                'value'     => $result['option_value']
                            );
                            
                            $roll_call_dates=array();
                            
                            if($rc_status){
                                $rollcall_result=$this->model_report_teacher->getRollCall($result['order_id'],$result['order_product_id']);
                                foreach($rollcall_result as $date){
                                    $roll_call_dates[]=$date['date'];
                                }
                                if(!isset($courses_time_tables[$result['product_id']])){
                                    $courses_time_tables[$result['product_id']]=$this->model_report_teacher->getTimeTable($result['product_id'],$rc_week_days_descrition,$rc_attributes_id);
                                }
                            } else {
                                $courses_time_tables[$result['product_id']]=array();
                            }
                            
                            
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
                                    'time_table' => $courses_time_tables[$result['product_id']],
                                    'roll_call_dates' => $roll_call_dates                                
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
                $this->data['column_roll'] = $this->language->get('column_roll');
		
		$this->data['entry_product_name'] = $this->language->get('entry_product_name');
		$this->data['entry_model'] = $this->language->get('entry_model');
                $this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');
                $this->data['button_excel'] = $this->language->get('button_excel');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
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
                
		$pagination = new Pagination();
		$pagination->total=$this->model_report_teacher->getTotalCourses($data);
                $pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/teacher_courses', 'token=' . $this->session->data['token'] . $url . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();		
		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;		
                $this->data['filter_option'] = $filter_option;
		$this->data['filter_status_id'] = $filter_status_id;
		
                
                $this->template = 'report/teacher_courses.tpl';
                
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
}
?>