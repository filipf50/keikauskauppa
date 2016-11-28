<?php 
class ControllerProductCategory extends Controller {  
	public function index() { 
		$this->language->load('product/category');
		
		$this->load->model('catalog/category');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							

				if (isset($this->request->get['filter_season'])) {
					$this->data['filter_season']=$this->request->get['filter_season'];
				}else{
					$this->data['filter_season']='';
				}
			
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
					

				if (isset($this->request->get['filter_product_sku'])) {
					$filter_sku = $this->request->get['filter_product_sku'];
				} else {
					$filter_sku = null;
				}
				
				if (isset($this->request->get['filter_product_name'])) {
					$filter_name = $this->request->get['filter_product_name'];
				} else {
					$filter_name = null;
				}
		
				if (isset($this->request->get['filter_model'])) {
					$filter_model = $this->request->get['filter_model'];
				} else {
					$filter_model = null;
				}
				
				if (isset($this->request->get['filter_location'])) {
					$filter_location = $this->request->get['filter_location'];
				} else {
					$filter_location = null;
				}
				
				if (isset($this->request->get['filter_season'])) {
					$filter_season = $this->request->get['filter_season'];
				} else {
					$filter_season = null;
				}
				$this->data['filter_product_sku']=$filter_sku;
				$this->data['filter_product_name'] = $filter_name;
				$this->data['filter_model'] = $filter_model;
				$this->data['filter_location'] = $filter_location;
				$this->data['filter_season']=$filter_season;
			
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
		
		if (isset($this->request->get['path'])) {

				$this->data['path']=$this->request->get['path'];
				if (!empty($this->request->post['quantity'])) {
					foreach ($this->request->post['quantity'] as $key => $value) {
						if ($value>0){
							$options=array();
							if (!strpos($key,'-')>0){
								$this->cart->add($key,$value,$options);
							} else {
								if (isset($this->request->post['option'])){
									foreach($this->request->post['option'] as $keyOpt=>$valueOpt){
										if ($keyOpt==$key){
											$auxKey=explode('-',$keyOpt);
											$options[$auxKey[1]]=$valueOpt;
											$this->cart->add($auxKey[0], $value,$options);
										}
									}
								}
							}							
						}
					}
					
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']); 
					unset($this->session->data['reward']);
					
					//$this->redirect($this->url->link('product/category&path=' . $this->data['path']));  
					$this->redirect($this->url->link('checkout/cart'));  
					
				}
				
				$this->data['action'] = $this->url->link('product/category&path=' . $this->data['path']); 
			
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
									
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$category_info = $this->model_catalog_category->getCategory($category_id);
	
		if ($category_info) {
	  		$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			
			$this->data['heading_title'] = $category_info['name'];
			
			$this->data['text_refine'] = $this->language->get('text_refine');
			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_quantity'] = $this->language->get('text_quantity');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model'] = $this->language->get('text_model');

				$this->data['text_stock'] = $this->language->get('text_stock');
				
				$this->data['column_image'] = $this->language->get('column_image');		
				$this->data['column_sku'] = $this->language->get('column_sku');		
				$this->data['column_name'] = $this->language->get('column_name');		
				$this->data['column_model'] = $this->language->get('column_model');		
				$this->data['column_stock'] = $this->language->get('column_stock');		
				$this->data['column_quantity'] = $this->language->get('column_quantity');		
				$this->data['column_options'] = $this->language->get('column_options');		
				$this->data['button_filter'] = $this->language->get('button_filter');
				$this->data['text_title_excel'] = $this->language->get('text_title_excel');	
				$this->data['excel_ico']=DIR_IMAGE . 'data/doc_excel_table.png';
				$this->data['text_title_textfile'] = $this->language->get('text_title_textfile');
				$this->data['textfile_ico']=DIR_IMAGE . 'data/downloadFile.gif';
				$this->data['text_season']=$this->language->get('text_season');
			
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_points'] = $this->language->get('text_points');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
					
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['button_continue'] = $this->language->get('button_continue');
					
			if ($category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$this->data['thumb'] = '';
			}
									
			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['compare'] = $this->url->link('product/compare');
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			

				if (isset($this->request->get['filter_season'])) {
					$this->data['filter_season']=$this->request->get['filter_season'];
				}else{
					$this->data['filter_season']='';
				}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
								
			$this->data['categories'] = array();
			
			$results = $this->model_catalog_category->getCategories($category_id);
			
			foreach ($results as $result) {
				$data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true	
				);
							
				$product_total = $this->model_catalog_product->getTotalProducts($data);

				$this->data['category_id']=$category_id;
				$this->data['product_total']=$product_total;
				$this->data['stock_total']=$this->model_catalog_product->getStockProducts($data); 
			
				
				$this->data['categories'][] = array(
					'name'  => $result['name'] . ' (' . $product_total . ')',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}
			
			$this->data['products'] = array();
			
			$data = array(
				'filter_category_id' => $category_id, 

				'filter_sku'	  => $filter_sku,
				'filter_name'	  => $filter_name,
				'filter_model'	  => $filter_model,
				'filter_location'	  => $filter_location,
				'filter_season'	  => $filter_season,
			
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			
			$product_total = $this->model_catalog_product->getTotalProducts($data); 

				$this->data['category_id']=$category_id;
				$this->data['product_total']=$product_total;
				$this->data['stock_total']=$this->model_catalog_product->getStockProducts($data); 
			
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}	
				
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
								

				$options = array();
			
				foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) { 
					if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
						$option_value_data = array();
						
						foreach ($option['option_value'] as $option_value) {
							if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
								if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
									$price = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax')));
								} else {
									$price = false;
								}
								
								$option_value_data[] = array(
									'product_option_value_id' => $option_value['product_option_value_id'],
									'option_value_id'         => $option_value['option_value_id'],
									'name'                    => $option_value['name'],
									'quantity'				  => $option_value['quantity'],
									'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
									'price'                   => $price,
									'price_prefix'            => $option_value['price_prefix']
								);
							}
						}
						
						$options[] = array(
							'product_option_id' => $option['product_option_id'],
							'option_id'         => $option['option_id'],
							'name'              => $option['name'],
							'type'              => $option['type'],
							'option_value'      => $option_value_data,
							'required'          => $option['required']
						);					
					} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
						$options[] = array(
							'product_option_id' => $option['product_option_id'],
							'option_id'         => $option['option_id'],
							'name'              => $option['name'],
							'type'              => $option['type'],
							'option_value'      => $option['option_value'],
							'required'          => $option['required']
						);						
					}
				}
				
				if ($result['quantity'] <= 0) {
					$stock = $result['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $result['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}
			
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
'stock'	=> $stock,
						  'model'	=> $result['model'],
						  'options'	=> $options,
						  'sku'		=> $result['sku'],
 						  'popup'		  =>  $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),

					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'])
				);
			}
			
			$url = '';

				if (isset($this->request->get['filter_product_sku'])) {
					$url .= '&filter_product_sku=' . $this->request->get['filter_product_sku'];
				} 
				
				if (isset($this->request->get['filter_product_name'])) {
					$url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
				}
		
				if (isset($this->request->get['filter_model'])) {
					$url .= '&filter_model=' . $this->request->get['filter_model'];
				}
				
				if (isset($this->request->get['filter_location'])) {
					$url .= '&filter_location=' . $this->request->get['filter_location'];
				} 
				if (isset($this->request->get['filter_season'])) {
					$url .= '&filter_season=' . $this->request->get['filter_season'];
				} 
				if (isset($this->request->get['filter_location'])) {
					$url .= '&filter_location=' . $this->request->get['filter_location'];
				} 
			
	

				if (isset($this->request->get['filter_season'])) {
					$this->data['filter_season']=$this->request->get['filter_season'];
				}else{
					$this->data['filter_season']='';
				}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

						
			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);
			

				$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_stock_asc'),
				'value' => 'p.quantity-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.quantity&order=ASC' . $url)
			);
				$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_stock_desc'),
				'value' => 'p.quantity-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.quantity&order=DESC' . $url)
			);
			
			$url = '';

				if (isset($this->request->get['filter_product_sku'])) {
					$url .= '&filter_product_sku=' . $this->request->get['filter_product_sku'];
				} 
				
				if (isset($this->request->get['filter_product_name'])) {
					$url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
				}
		
				if (isset($this->request->get['filter_model'])) {
					$url .= '&filter_model=' . $this->request->get['filter_model'];
				} 
				if (isset($this->request->get['filter_season'])) {
					$url .= '&filter_season=' . $this->request->get['filter_season'];
				} 
				if (isset($this->request->get['filter_location'])) {
					$url .= '&filter_location=' . $this->request->get['filter_location'];
				} 
			
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=25')
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=50')
			);

			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=75')
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=100')
			);
						

				$this->data['limits'][] = array(
				'text'  => 'Ver Todos',
				'value' => 99999,
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . 
				           '&limit=99999')	);

				$seasons = $this->model_catalog_product->getProductsSeasons();
				
				$this->data['seasons'] = array();
				$this->data['seasons'][]=array(
								'value' =>"",
								'text'=>'Ver Todo'); 
				if (count($seasons)>1){
					foreach ($seasons as $season) {
						if (strlen($season['upc'])>0){
							$this->data['seasons'][]=array(
								'value' =>$season['upc'],
								'text'  =>$season['upc']); 
							}
					}
				}
			
			$url = '';

				if (isset($this->request->get['filter_product_sku'])) {
					$url .= '&filter_product_sku=' . $this->request->get['filter_product_sku'];
				} 
				
				if (isset($this->request->get['filter_product_name'])) {
					$url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
				}
		
				if (isset($this->request->get['filter_model'])) {
					$url .= '&filter_model=' . $this->request->get['filter_model'];
				} 
				if (isset($this->request->get['filter_season'])) {
					$url .= '&filter_season=' . $this->request->get['filter_season'];
				} 
				if (isset($this->request->get['filter_location'])) {
					$url .= '&filter_location=' . $this->request->get['filter_location'];
				} 
			
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	

				if (isset($this->request->get['filter_season'])) {
					$this->data['filter_season']=$this->request->get['filter_season'];
				}else{
					$this->data['filter_season']='';
				}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
					
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
		
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;
		
			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
			} else {
				$this->template = 'default/template/product/category.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());										
    	} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {

				$this->data['path']=$this->request->get['path'];
				if (!empty($this->request->post['quantity'])) {
					foreach ($this->request->post['quantity'] as $key => $value) {
						if ($value>0){
							$options=array();
							if (!strpos($key,'-')>0){
								$this->cart->add($key,$value,$options);
							} else {
								if (isset($this->request->post['option'])){
									foreach($this->request->post['option'] as $keyOpt=>$valueOpt){
										if ($keyOpt==$key){
											$auxKey=explode('-',$keyOpt);
											$options[$auxKey[1]]=$valueOpt;
											$this->cart->add($auxKey[0], $value,$options);
										}
									}
								}
							}							
						}
					}
					
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']); 
					unset($this->session->data['reward']);
					
					//$this->redirect($this->url->link('product/category&path=' . $this->data['path']));  
					$this->redirect($this->url->link('checkout/cart'));  
					
				}
				
				$this->data['action'] = $this->url->link('product/category&path=' . $this->data['path']); 
			
				$url .= '&path=' . $this->request->get['path'];
			}
									
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						

				if (isset($this->request->get['filter_season'])) {
					$this->data['filter_season']=$this->request->get['filter_season'];
				}else{
					$this->data['filter_season']='';
				}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
		}
  	}

				public function export(){
					$this->load->model('catalog/category');
					
					$this->load->model('catalog/product');
					
					$this->load->model('tool/image'); 
					
					if (isset($this->request->get['path'])) {
						$path = '';
						$parts = explode('_', (string)$this->request->get['path']);
					
						foreach ($parts as $path_id) {
							if (!$path) {
								$path = $path_id;
							} else {
								$path .= '_' . $path_id;
							}
												
							$category_info = $this->model_catalog_category->getCategory($path_id);
							
							if ($category_info) {
								$this->data['breadcrumbs'][] = array(
									'text'      => $category_info['name'],
									'href'      => $this->url->link('product/category', 'path=' . $path),
									'separator' => $this->language->get('text_separator')
								);
							}
						}		
					
						$category_id = array_pop($parts);
					} else {
						$category_id = 0;
					}
					
					if (isset($this->request->get['type'])) {
						$type=$this->request->get['type'];
					} else {
						$type='excell';
					}
					
					if (isset($this->request->get['sort'])) {
						$sort = $this->request->get['sort'];
					} else {
						$sort = 'p.sort_order';
					}
			
					if (isset($this->request->get['order'])) {
						$order = $this->request->get['order'];
					} else {
						$order = 'ASC';
					}
					
					if (isset($this->request->get['page'])) {
						$page = $this->request->get['page'];
					} else { 
						$page = 1;
					}	
										
					if (isset($this->request->get['limit'])) {
						$limit = $this->request->get['limit'];
					} else {
						$limit = $this->config->get('config_catalog_limit');
					}
					if (isset($this->request->get['filter_product_sku'])) {
						$filter_sku = $this->request->get['filter_product_sku'];
					} else {
						$filter_sku = null;
					}
					
					if (isset($this->request->get['filter_product_name'])) {
						$filter_name = $this->request->get['filter_product_name'];
					} else {
						$filter_name = null;
					}
			
					if (isset($this->request->get['filter_model'])) {
						$filter_model = $this->request->get['filter_model'];
					} else {
						$filter_model = null;
					}
					
					if (isset($this->request->get['filter_location'])) {
						$filter_location = $this->request->get['filter_location'];
					} else {
						$filter_location = null;
					}
					
					if (isset($this->request->get['filter_season'])) {
						$filter_season = $this->request->get['filter_season'];
					} else {
						$filter_season = null;
					}
					
					$this->data['products'] = array();
			
					$data = array(
						'filter_category_id' => $category_id, 
		
						'filter_sku'	  => $filter_sku,
						'filter_name'	  => $filter_name,
						'filter_model'	  => $filter_model,
						'filter_location' => $filter_location,
						'filter_season' => $filter_season,
					
						'sort'               => $sort,
						'order'              => $order,
						'start'              => ($page - 1) * $limit,
						'limit'              => $limit
					);
					
					$product_total = $this->model_catalog_product->getTotalProducts($data); 

				$this->data['category_id']=$category_id;
				$this->data['product_total']=$product_total;
				$this->data['stock_total']=$this->model_catalog_product->getStockProducts($data); 
			
					
					$results = $this->model_catalog_product->getProducts($data);
					
					foreach ($results as $result) {
							if ($result['image']) {
								$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
							} else {
								$image = false;
							}
							
							if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
								$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$price = false;
							}
							
							if ((float)$result['special']) {
								$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$special = false;
							}	
							
							if ($this->config->get('config_tax')) {
								$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
							} else {
								$tax = false;
							}				
							
							if ($this->config->get('config_review_status')) {
								$rating = (int)$result['rating'];
							} else {
								$rating = false;
							}
											
			
							$options = array();
						
							foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) { 
								if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
									$option_value_data = array();
									
									foreach ($option['option_value'] as $option_value) {
										if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
											if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
												$price = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax')));
											} else {
												$price = false;
											}
											
											$option_value_data[] = array(
												'product_option_value_id' => $option_value['product_option_value_id'],
												'option_value_id'         => $option_value['option_value_id'],
												'name'                    => $option_value['name'],
												'quantity'				  => $option_value['quantity'],
												'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
												'price'                   => $price,
												'price_prefix'            => $option_value['price_prefix'],
												'ean'					  => $option_value['ean']
											);
										}
									}
									
									$options[] = array(
										'product_option_id' => $option['product_option_id'],
										'option_id'         => $option['option_id'],
										'name'              => $option['name'],
										'type'              => $option['type'],
										'option_value'      => $option_value_data,
										'required'          => $option['required']
									);					
								} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
									$options[] = array(
										'product_option_id' => $option['product_option_id'],
										'option_id'         => $option['option_id'],
										'name'              => $option['name'],
										'type'              => $option['type'],
										'option_value'      => $option['option_value'],
										'required'          => $option['required']
									);						
								}
							}
							
							if ($result['quantity'] <= 0) {
								$stock = $result['stock_status'];
							} elseif ($this->config->get('config_stock_display')) {
								$stock = $result['quantity'];
							} else {
								$stock = $this->language->get('text_instock');
							}
						
							$this->data['products'][] = array(
								'product_id'  => $result['product_id'],
								'thumb'       => $image,
								'name'        => $result['name'],
								'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
								'price'       => $price,
								'special'     => $special,
								'tax'         => $tax,
								'rating'      => $result['rating'],
			'stock'	=> $stock,
									  'model'	=> $result['model'],
									  'options'	=> $options,
									  'sku'		=> $result['sku'],
								'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
								'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'])
							);
					}
					
					$this->data['category_id']=$category_id;
					
					if($type=='excell'){
						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/b2b/excel.tpl')) {
							$this->template = $this->config->get('config_template') . '/template/b2b/excel.tpl';
						} else {
							$this->template = 'default/template/b2b/excel.tpl';
						}
					} else {
						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/b2b/textfile.tpl')) {
							$this->template = $this->config->get('config_template') . '/template/b2b/textfile.tpl';
						} else {
							$this->template = 'default/template/b2b/textfile.tpl';
						}

					}
						
					$this->children = array(
						'common/column_left',
						'common/column_right',
						'common/content_top',
						'common/content_bottom',
						'common/footer',
						'common/header'
					);
						
					$this->response->setOutput($this->render());
				}
			
}
?>