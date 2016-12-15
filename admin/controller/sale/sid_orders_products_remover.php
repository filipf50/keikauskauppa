<?php
class ControllerSaleSidOrdersProductsRemover extends Controller { 
	public function index() {  
 		$this->language->load('sale/sid_orders_products_remover');

		$this->document->setTitle($this->language->get('heading_title'));
                
                $this->data['action'] = $this->url->link('sale/sid_orders_products_remover', 'token=' . $this->session->data['token'], 'SSL');
                $this->data['delete'] = $this->url->link('sale/sid_orders_products_remover/removeProducts', 'token=' . $this->session->data['token'] , 'SSL');
                $this->data['orders'] = array();
                
                if (isset($this->session->data['error_warning'])) {
			$this->data['error_warning'] = $this->session->data['error_warning'];
		
			unset($this->session->data['error_warning']);
		} else {
			$this->data['error_warning'] = '';
		}
                
                if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
                
                $order_total=0;
                if (isset($this->request->post['filter_date_start'])) {
                        $filter_date_start = $this->request->post['filter_date_start'];
                } else {
                        $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
                }

                if (isset($this->request->post['filter_date_end'])) {
                        $filter_date_end = $this->request->post['filter_date_end'];
                } else {
                        $filter_date_end = date('Y-m-d');
                }

                if (isset($this->request->post['filter_order_statuses_ids'])) {
                        $filter_order_statuses_ids = $this->request->post['filter_order_statuses_ids'];
                } else {
                        $filter_order_statuses_ids = array();
                }	

                if (isset($this->request->post['filter_stores_ids'])) {
                        $filter_order_stores_ids = $this->request->post['filter_stores_ids'];
                } else {
                        $filter_order_stores_ids = array();
                }

                if (isset($this->request->post['product_to_delete'])) {
                        $product_to_delete= $this->request->post['product_to_delete'];
                        $product_to_delete_id=$this->request->post['product_to_delete_id'];
                        $this->load->model('sale/sid_orders_products_remover');
                    
                        $product_to_delete_options=$this->model_sale_sid_orders_products_remover->getProductOptions($product_to_delete_id);
                        //$product_options=$this->model_sale_sid_orders_products_remover->getOtpProductOptions($product_to_delete);
                } else {
                        $product_to_delete = "";
                        $product_to_delete_id="";
                        $product_to_delete_options=array();
                }
                
                if (isset($this->request->post['filter_options_to_delete'])) {
                        $filter_options_to_delete = $this->request->post['filter_options_to_delete'];
                } else {
                        $filter_options_to_delete = array();
                }
                
                if (isset($this->request->post['product_to_add'])) {
                        $product_to_add= $this->request->post['product_to_add'];
                        $product_to_add_id=$this->request->post['product_to_add_id'];
                        $this->load->model('sale/sid_orders_products_remover');
                    
                        $product_to_add_options=$this->model_sale_sid_orders_products_remover->getProductOptions($product_to_add_id);
                } else {
                        $product_to_add = "";
                        $product_to_add_id="";
                        $product_to_add_options=array();
                }
                
                if (isset($this->request->post['filter_options_to_add'])) {
                        $filter_options_to_add = $this->request->post['filter_options_to_add'];
                } else {
                        $filter_options_to_add = array();
                }
                
                if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                    $this->load->model('sale/sid_orders_products_remover');
                    //$order_total = $this->model_sale_sid_orders_products_remover->getTotalOrders($data);
                    $data = array(
                            'filter_date_start'	     => $filter_date_start, 
                            'filter_date_end'	     => $filter_date_end, 
                            'filter_order_statuses_ids'  => $filter_order_statuses_ids,
                            'filter_order_stores_ids'    => $filter_order_stores_ids,
                            'product_to_delete'         => $product_to_delete_id,
                            'filter_product_options'    => array_filter($filter_options_to_delete),
                            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
                            'limit'                  => $this->config->get('config_admin_limit')
                    );
                    $results = $this->model_sale_sid_orders_products_remover->getOrders($data);
                    $order_total= count($results);
                    foreach ($results as $result) {
                            $this->data['orders'][] = array(
                                    'order_id'      => $result['order_id'],
                                    'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                                    'customer'      => $result['customer'],
                                    'status'        => $result['status'],
                                    'totalproducts' => $result['totalproducts'],
                                    'productsToRemove'  => $result['productsToDelete'],
                                    'pendingProducts'   => $result['pendingProducts']
                            );
                    }
                }
                
                $this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/sid_orders_products_remover', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		
		
                
             
                
                $this->load->model('catalog/product');
                
                
		$this->data['heading_title'] = $this->language->get('heading_title');
                $this->data['heading_orders_title'] = $this->language->get('heading_orders_title');
                $this->data['text_removeMsg'] = $this->language->get('text_removeMsg');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
                $this->data['text_default'] = $this->language->get('text_default');
                $this->data['text_select'] = $this->language->get('text_select');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_order_products'] = $this->language->get('column_order_products');
		$this->data['column_products_to_remove'] = $this->language->get('column_products_to_remove');
                $this->data['column_pending_products'] = $this->language->get('column_pending_products');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_store'] = $this->language->get('entry_stores');	
                $this->data['entry_product'] = $this->language->get('entry_product');
                $this->data['entry_product_dest'] = $this->language->get('entry_product_dest');
		$this->data['entry_status'] = $this->language->get('entry_status');
                $this->data['entry_option'] = $this->language->get('entry_option');

		$this->data['button_filter'] = $this->language->get('button_filter');
                $this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
                
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_statuses_ids'])) {
			$url .= '&filter_order_statuses_ids=' . $this->request->get['filter_order_statuses_ids'];
		}		

		if (isset($this->request->get['filter_order_store_id'])) {
			$url .= '&filter_order_store_id=' . $this->request->get['filter_order_store_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_order_statuses_ids'] = $filter_order_statuses_ids;
		$this->data['filter_order_stores_ids'] = $filter_order_stores_ids;
                $this->data['filter_options_to_delete'] = $filter_options_to_delete;
                $this->data['filter_options_to_add'] = $filter_options_to_add;
                $this->data['product_to_delete']=$product_to_delete;
                $this->data['product_to_delete_id']=$product_to_delete_id;
                $this->data['product_to_delete_options']=$product_to_delete_options;
                $this->data['product_to_add']=$product_to_add;
                $this->data['product_to_add_id']=$product_to_add_id;
                $this->data['product_to_add_options']=$product_to_add_options;
                
		$this->template = 'sale/sid_orders_products_remover.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
        
        public function options(){
            $json=array();
            if (isset($this->request->get['product_id'])){
                    $this->load->model('sale/sid_orders_products_remover');
                    
                    $product_id=$this->request->get['product_id'];
                    
                    $product_otp=$this->model_sale_sid_orders_products_remover->getOtpProductOptions($product_id);
                    
                    foreach($product_otp as $option){
                        $json[$option['otp_id']]=$option['description'];
                    }
            }
            
            $this->response->setOutput(json_encode($json));
        }
        
        public function removeProducts(){
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                    $this->language->load('sale/sid_orders_products_remover');
                    $this->load->model('sale/sid_orders_products_remover');
                    
                    //Cargamos las variables para aplicar el filtro
                    if (isset($this->request->post['filter_date_start'])) {
                            $filter_date_start = $this->request->post['filter_date_start'];
                    } else {
                            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
                    }

                    if (isset($this->request->post['filter_date_end'])) {
                            $filter_date_end = $this->request->post['filter_date_end'];
                    } else {
                            $filter_date_end = date('Y-m-d');
                    }

                    if (isset($this->request->post['filter_order_statuses_ids'])) {
                            $filter_order_statuses_ids = $this->request->post['filter_order_statuses_ids'];
                    } else {
                            $filter_order_statuses_ids = array();
                    }	

                    if (isset($this->request->post['filter_stores_ids'])) {
                            $filter_order_stores_ids = $this->request->post['filter_stores_ids'];
                    } else {
                            $filter_order_stores_ids = array();
                    }

                    if (isset($this->request->post['product_to_delete'])) {
                            $product_to_delete= $this->request->post['product_to_delete'];
                            $product_to_delete_id=$this->request->post['product_to_delete_id'];
                    } else {
                            $product_to_delete = "";
                            $product_to_delete_id="";
                    }

                    if (isset($this->request->post['filter_options_to_delete'])) {
                            $filter_options_to_delete = $this->request->post['filter_options_to_delete'];
                    } else {
                            $filter_options_to_delete = array();
                    }

                    if (isset($this->request->post['product_to_add'])) {
                            $product_to_add= $this->request->post['product_to_add'];
                            $product_to_add_id=$this->request->post['product_to_add_id'];
                    } else {
                            $product_to_add = "";
                            $product_to_add_id="";
                    }

                    if (isset($this->request->post['filter_options_to_add'])) {
                            $filter_options_to_add = $this->request->post['filter_options_to_add'];
                    } else {
                            $filter_options_to_add = array();
                    }

                    //Cargamos las variables en el array de datos
                    $data = array(
                            'filter_date_start'	     => $filter_date_start, 
                            'filter_date_end'	     => $filter_date_end, 
                            'filter_order_statuses_ids'  => $filter_order_statuses_ids,
                            'filter_order_stores_ids'    => $filter_order_stores_ids,
                            'product_to_delete'         => $product_to_delete_id,
                            'filter_product_options'    => array_filter($filter_options_to_delete),
                            'product_to_add'            => $product_to_add_id,
                            'filter_product_options_to_add' => array_filter($filter_options_to_add)
                    );
                    
                    //Obtenemos los pedidos afectados
                    $orders = $this->model_sale_sid_orders_products_remover->getOrders($data);
                    
                    //Recorremos el array de resultados
                    foreach($orders as $order){
                        $this->load->model('sale/order');
                        
                        if((int)$order['pendingProducts']==0 && $product_to_add_id=""){
                            //Si el pedido se queda sin artículos, lo marcamos como cancelado por falta de stock
                            //y lo notificamos al cliente
                            $status_data=array('order_status_id'=>7, //Canceled
                                               'notify'=>-1,
                                               'comment'=>$this->language->get('text_canceled_order_comment'));
                            $this->model_sale_order->addOrderHistory($order['order_id'],$status_data);
                        } else {
                            //Borro los productos / opciones seleccionados
                            if ($this->model_sale_sid_orders_products_remover->removeProducts($order['order_id'], $data)){
                                $this->session->data['success'] = $this->language->get('text_success');
                                //Cargo los datos del producto borrado para grabar la acción en el historial
                                $this->load->model('catalog/product');
                                $descriptions=$this->model_catalog_product->getProductDescriptions($product_to_delete);
                                $product_info=$this->language->get('text_removed_products_comment') . "\n  - " .$product_to_delete . ':' . $descriptions[$this->config->get('config_language_id')]["name"];

                                if(!empty($filter_product_options)){
                                    $product_ops=$this->model_sale_sid_orders_products_remover->getProductOptions($product_to_delete);
                                    $product_info.=":";
                                    foreach($filter_options_to_delete as $key=>$value){
                                        $aux=explode("~",$key);
                                        $product_info.= "\n&nbsp;&nbsp;- " . $product_ops[$aux[0]]['name'] . ':' . $product_ops[$aux[0]]['value'];
                                    }
                                    /*foreach($product_ops as $option){
                                        if (in_array($option['otp_id'], $filter_product_options)){
                                            $product_info.= "\n&nbsp;&nbsp;- " . $option['otp_id'] . ':' . $option['description'];
                                        }
                                    }*/
                                }

                                //Recalculo el pedido
                                $json=$this->recalculateOrder($order['order_id'],$product_to_add_id, $filter_options_to_add);
                                
                                //Añado el nuevo producto en caso de existir
                                $response=json_decode($json,true);
                                if (isset($response)){
                                    if ($product_to_add_id!=""){
                                        //Si hemos indicado un artículo para añadir, procedemos a añadirlo
                                        $products=$response['order_product'];
                                        foreach($products as $order_product){
                                            if ($order_product['product_id']==$product_to_add_id){
                                                $this->model_sale_sid_orders_products_remover->addProduct($order['order_id'],$order_product);
                                                //Añado la información para añadirla al historial del pedido
                                                $product_info.= "\n" . $this->language->get('text_added_products_comment') . "\n  - " .$order_product['product_id'] . ':' . $order_product["name"];
                                                
                                                if (!empty($order_product['option'])){
                                                    foreach($order_product['option'] as $option){
                                                        $product_info.= "\n&nbsp;&nbsp;- " . $option['name'] . ':' . $option['value'];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //Actualizo los totales
                                    $this->model_sale_sid_orders_products_remover->updateTotals($order['order_id'],$response['order_total']);
                                    
                                    $comment= $product_info;
                                    $history_data=array('order_status_id'=>$order['status_id'],
                                                        'notify'=>0,
                                                        'comment' =>$comment);
                                    $this->model_sale_order->addOrderHistory($order['order_id'],$history_data);
                                }
                                
                            } else {
                                $this->error['warning'] =$this->language->get('error_removing');
                                break;
                            }                            
                        }
                    }
            }
            $this->redirect($this->url->link('sale/sid_orders_products_remover', 'token=' . $this->session->data['token'], 'SSL'));
            $this->response->setOutput($this->render());
        }
        public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');
			
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
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
					
					if ($option_info) {				
						if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
							$option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						
								if ($option_value_info) {
									$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $option_value_info['name'],
										'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}
						
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);	
						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
        
        private function recalculateOrder($order_id,$product_to_add_id="",$product_to_add_options=array()){
            //Cargo los datos del pedido
            $this->load->model('sale/order');
            $order_data=$this->model_sale_order->getOrder($order_id);
            
            //Cargo los datos relacionados con los artículos del pedido
            $order_products=$this->model_sale_order->getOrderProducts($order_id);
            $this->data['order_products'] = array();
            foreach ($order_products as $product) {
                    $order_option = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);
                    
                    if (isset($product['order_download'])) {
                            $order_download = $product['order_download'];
                    } elseif (isset($this->request->get['order_id'])) {
                            $order_download = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $product['order_product_id']);
                    } else {
                            $order_download = array();
                    }

                    $order_product[] = array(
                            'order_product_id' => $product['order_product_id'],
                            'product_id'       => $product['product_id'],
                            'name'             => $product['name'],
                            'model'            => $product['model'],
                            'order_option'     => $order_option,
                            'order_download'   => $order_download,
                            'quantity'         => $product['quantity'],
                            'price'            => $product['price'],
                            'total'            => $product['total'],
                            'tax'              => $product['tax'],
                            'reward'           => $product['reward']
                    );
            }
            
            //Cargamos los vales
            $order_voucher=array();
            $order_vouchers = $this->model_sale_order->getOrderVouchers($order_id);
            foreach($order_vouchers as $voucher){
                $order_voucher[]=array(
                    'voucher_id'       => $voucher['voucher_id'],
                    'description'      => $voucher['description'],
                    'code'             => substr(md5(mt_rand()), 0, 10),
                    'from_name'        => $voucher['from_name'],
                    'from_email'       => $voucher['from_email'],
                    'to_name'          => $voucher['to_name'],
                    'to_email'         => $voucher['to_email'],
                    'voucher_theme_id' => $voucher['voucher_theme_id'], 
                    'message'          => $voucher['message'],
                    'amount'           => $voucher['amount']   
                );
            }
            
            //Asignamos las opciones del articulos que estamos añadiendo si corresponde
            $option=array();
            if (!empty($product_to_add_options)){
                foreach($product_to_add_options as $key=>$value){
                    $aux=explode('~',$key);
                    $option[$aux[0]]=$value;
                }
            }
            
            //Lo asigno a un array
            $data=array(
                'token' => $this->session->data['token'],
                'store_id' => $order_data['store_id'],
                'customer_id' => $order_data['customer_id'],
                'customer_group_id' => $order_data['customer_group_id'],
                'payment_firstname'       => $order_data['payment_firstname'],
                'payment_lastname'        => $order_data['payment_lastname'],
                'payment_company'         => $order_data['payment_company'],
                'payment_company_id'      => $order_data['payment_company_id'],
                'payment_tax_id'          => $order_data['payment_tax_id'],
                'payment_address_1'       => $order_data['payment_address_1'],
                'payment_address_2'       => $order_data['payment_address_2'],
                'payment_postcode'        => $order_data['payment_postcode'],
                'payment_city'            => $order_data['payment_city'],
                'payment_zone_id'         => $order_data['payment_zone_id'],
                'payment_zone'            => $order_data['payment_zone'],
                'payment_country_id'      => $order_data['payment_country_id'],
                'payment_country'         => $order_data['payment_country'],
                'payment_address_format'  => $order_data['payment_address_format'],
                'payment_method'          => $order_data['payment_method'],
                'payment_code'            => $order_data['payment_code'],				
                'shipping_firstname'      => $order_data['shipping_firstname'],
                'shipping_lastname'       => $order_data['shipping_lastname'],
                'shipping_company'        => $order_data['shipping_company'],
                'shipping_address_1'      => $order_data['shipping_address_1'],
                'shipping_address_2'      => $order_data['shipping_address_2'],
                'shipping_postcode'       => $order_data['shipping_postcode'],
                'shipping_city'           => $order_data['shipping_city'],
                'shipping_zone_id'        => $order_data['shipping_zone_id'],
                'shipping_zone'           => $order_data['shipping_zone'],
                'shipping_country_id'     => $order_data['shipping_country_id'],
                'shipping_country'        => $order_data['shipping_country'],
                'shipping_address_format' => $order_data['shipping_address_format'],
                'shipping_method'         => $order_data['shipping_method'],
                'shipping_code'           => $order_data['shipping_code'],
                'language_id'             => $order_data['language_id'],
                'order_product' => $order_product,
                'order_voucher' => $order_voucher,
                'product_id' => $product_to_add_id,
                'option' => $option,
                'fromMassiveRemover' => 1
            );
            
            $url=HTTP_CATALOG . "index.php?route=checkout/manual&token=" . $this->session->data['token'] . "&customer_group_id=" . $order_data['customer_group_id'] . "&order_language_id=" . $order_data['language_id'];
            
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

            // in real life you should use something like:
            // curl_setopt($ch, CURLOPT_POSTFIELDS, 
            //          http_build_query(array('postvar1' => 'value1')));

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec ($ch);

            curl_close ($ch);
            
//            require_once(DIR_CATALOG . "controller/checkout/manual.php");
//            $this->session->data['fromAdmin']=true;
//            $action=new ControllerCheckoutManual($this->registry);
//            $this->request->post=$data;
//            $this->load->library('customer');
//            $this->customer=new Customer($this->registry);
//            $this->registry->set('customer',$this->customer);
//            $this->load->library('tax');
//            $this->registry->set('tax',New Tax($this->registry));
//            $this->load->library('cart');
//            $this->cart=new Cart($this->registry);
//            $result= $action->recalculateFromAdmin();
//            unset($this->session->data['fromAdmin']);
//            $action=null;
            return $result;
        }
}
?>