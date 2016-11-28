<?php
class ControllerModuleProductSpecialsWizard extends Controller {
	private $error = array();
	
	public function index() {
            $this->language->load('module/product_specials_wizard');
            $this->document->addScript('view/javascript/jquery/ui/minified/datepicker/jquery.plugin.min.js');
            $this->document->addScript('view/javascript/jquery/ui/minified/datepicker/jquery.datepick.min.js');
            $this->document->addStyle('view/javascript/jquery/ui/themes/ui-lightness/jquery.datepick.css');
            

            
            $this->data['title'] = $this->language->get('heading_title');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                //We use roll call configuration for parameters and week days
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

                //We get and format a free days array
                $arrFreeDates=explode(',',$this->request->post['free-dates']);
                foreach ($arrFreeDates as $key => $value) {
                    $arrFreeDates[$key]= date_format(new DateTime($value), 'Y-m-d');
                }    
                $updated_products=0;
                $action=$this->request->post['action'];
                if(isset($this->request->post['selected_products'])){
                    foreach($this->request->post['selected_products'] as $product_id){
                        if ($action=='add'){
                            //We get product data
                            $this->load->model('catalog/product');
                            $product=$this->model_catalog_product->getProduct($product_id);

                            //We get product TimeTable
                            $this->load->model('report/teacher');
                            $course_time_table=$this->model_report_teacher->getTimeTable($product['product_id'],$rc_week_days_descrition,$rc_attributes_id);

                            if (count($course_time_table)>1){
                                //If product has more than one date, we calculate specials.
                                $starting_price=$product['price'];
                                $class_price=$starting_price / count($course_time_table);

                                $startDate_index=0;
                                $endDate_index=1;
                                $diff1Day = new DateInterval('P1D');
                                $price=$starting_price-$class_price;
                                while ($startDate_index<count($course_time_table)&& $endDate_index<count($course_time_table)){
                                    $startDate=new DateTime($course_time_table[$startDate_index]);
                                    $startDate->add($diff1Day);
                                    while(in_array($course_time_table[$endDate_index],$arrFreeDates,false)){
                                        $endDate_index++;
                                    }
                                    $endDate=$course_time_table[$endDate_index];

                                    $specials[]=array('product_id'=>$product['product_id'],
                                                      'customer_group_id'=>$this->request->post['customer_group_id'],
                                                      'date_start'=> date_format($startDate,'Y-m-d'),
                                                      'date_end'=>$endDate,
                                                      'price'=>$price);
                                    $startDate_index=$endDate_index;
                                    $price=$price-$class_price;
                                    $endDate_index++;
                                }

                                //We update product's specials
                                $this->load->model('module/product_specials_wizard');
                                $this->model_module_product_specials_wizard->updateSpecials($product_id,$specials);

                                //We increase the updated products counter
                                $updated_products++;
                            }
                        }else{
                                //Delete
                                //We update product's specials
                                $this->load->model('module/product_specials_wizard');
                                $this->model_module_product_specials_wizard->deleteSpecials($product_id);

                                //We increase the updated products counter
                                $updated_products++;
                        }
                    }
                }
                if ($action=='add'){
                    $this->session->data['success'] = sprintf($this->language->get('text_success'),$updated_products);
                }else{
                    $this->session->data['success'] = sprintf($this->language->get('text_deleted'),$updated_products);
                }

                $this->redirect($this->url->link('module/product_specials_wizard', 'token=' . $this->session->data['token'], 'SSL'));
            }
            
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $this->data['base'] = HTTPS_SERVER;
            } else {
                    $this->data['base'] = HTTP_SERVER;
            }
            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('module/product_specials_wizard', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );
            
            if (isset($this->session->data['success'])) {
		$this->data['success'] = $this->session->data['success'];
		
                unset($this->session->data['success']);
            } else {
                $this->data['success'] = '';
            }
            
            $this->data['text_module'] = $this->language->get('text_module');
            
            $this->data['heading_title'] = $this->language->get('heading_title');
            
            $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
            $this->data['entry_starting_price'] = $this->language->get('entry_starting_price');
            $this->data['entry_steps'] = $this->language->get('entry_steps');
            $this->data['entry_days_betteen_steps'] = $this->language->get('entry_days_betteen_steps');
            $this->data['entry_start_date_attribute'] = $this->language->get('entry_start_date_attribute');
            $this->data['entry_end_date_attribute'] = $this->language->get('entry_end_date_attribute'); 
            $this->data['entry_free_days'] = $this->language->get('entry_free_days');
            $this->data['entry_products'] = $this->language->get('entry_products');

            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['button_generate'] = $this->language->get('button_generate');
            $this->data['button_delete'] = $this->language->get('button_delete');

            $this->data['column_customer_group'] = $this->language->get('column_customer_group');
            $this->data['column_price'] = $this->language->get('column_price');
            $this->data['column_date_start'] = $this->language->get('column_date_start');
            $this->data['column_date_end'] = $this->language->get('column_date_end');

            $this->data['token'] = $this->session->data['token'];

            $this->load->model('sale/customer_group');

            $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
            
            $this->load->model('module/product_specials_wizard');
            
            $this->data['products'] = $this->model_module_product_specials_wizard->getEnabledProducts();

            if (isset($this->request->get['price'])) {
                    $this->data['starting_price'] = $this->request->get['price'];
            } else {
                    $this->data['starting_price'] = '';
            }

            if (isset($this->request->get['date_start'])) {
                    $this->data['starting_date'] = $this->request->get['date_start'];
            } else {
                    $this->data['starting_date'] = '';
            }

            if (isset($this->request->get['date_end'])) {
                    $this->data['ending_date'] = $this->request->get['date_end'];
            } else {
                    $this->data['ending_date'] = '';
            }
            
            $this->data['action'] = $this->url->link('module/product_specials_wizard', 'token=' . $this->session->data['token'], 'SSL');

            $this->load->model('design/layout');

            $this->data['layouts'] = $this->model_design_layout->getLayouts();

            $this->template = 'module/product_specials_wizard.tpl';

            $this->children = array(
                'common/header',
                'common/footer',
            );

            $this->response->setOutput($this->render());
	}	
}
?>