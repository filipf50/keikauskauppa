<?php
class ModelSaleSidOrdersProductsUpdater extends Model {
	
        public function deleteOrder($order_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach($product_query->rows as $product) {
				$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

				$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

				foreach ($option_query->rows as $option) {
					$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
				}
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_fraud WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM " . DB_PREFIX . "order_recurring `or`, " . DB_PREFIX . "order_recurring_transaction ort WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
	}
        
        public function removeProducts($order_id, $data=array()){

            if(!empty($data['filter_product_options'])){
                $strFilterOptions= $this->getstrProductOptionsFilter($data);
                

                //Delete order_product and options
                $this->db->query("DELETE op,oo FROM  " . DB_PREFIX . "order_product op INNER JOIN " . DB_PREFIX . "order_option oo ON
                 op.order_product_id=oo.order_product_id AND op.order_id=oo.order_id " . $strFilterOptions .                  
                " WHERE op.order_id=" . (int)$order_id . " AND op.product_id=" . (int)$data['product_to_delete']);

                $this->log->write("DELETE op,oo FROM  " . DB_PREFIX . "order_product op INNER JOIN " . DB_PREFIX . "order_option oo ON
                 op.order_product_id=oo.order_product_id AND op.order_id=oo.order_id " . $strFilterOptions .                  
                " WHERE op.order_id=" . (int)$order_id . " AND op.product_id=" . (int)$data['product_to_delete']);
            }
            else{
                //Delete order_product
                $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id=" . (int)$order_id . " "
                    . " AND product_id=" . (int)$data['product_to_delete'] );

                $this->log->write("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id=" . (int)$order_id . " "
                    . " AND product_id=" . (int)$data['product_to_delete']);

            }


            return true;
        }

        public function addProduct($order_id,$order_product){
            //Insert into order_product
            $sql="INSERT INTO " . DB_PREFIX . "order_product (order_id,product_id,name,model,quantity,price,total,tax,reward) ".
                 "VALUES (" . $order_id . "," . $order_product['product_id'] . ",'" . $order_product['name'] . "','" . $order_product['model'] . "'," . $order_product['quantity'] . "," . $order_product['price'] . "," . $order_product['total'] . "," . $order_product["tax"] . "," . $order_product["reward"] . ")";
            $this->db->query($sql);
            $this->log->write($sql);
            if (!empty($order_product['option'])){
                //Insert into order_option
                $order_product_id=$this->db->getLastId();
                foreach($order_product['option'] as $option){
                        $sql="INSERT INTO " . DB_PREFIX . "order_option (order_id, order_product_id, product_option_id, product_option_value_id, name, value, type) " . 
                             "VALUES (" . $order_id . "," . $order_product_id . "," . $option['product_option_id'] . "," . ($option['product_option_value_id']==''?0:$option['product_option_value_id']) . ",'" . $option['name'] . "','" . $option['value'] . "','" . $option['type'] . "')";
                        $this->db->query($sql);
                        $this->log->write($sql);
                }                
            }
        }
	public function getOrders($data = array()) {
		$sql = "SELECT v.order_id, v.customer,v.language_id, v.status_id,  v.status,v.date_added, v.date_modified,v.totalproducts,v.productsToDelete,(v.totalproducts-v.productsToDelete) AS pendingProducts
                        FROM (SELECT o.order_id, 
                                        CONCAT(o.firstname, ' ', o.lastname) AS customer, 
                                        o.order_status_id as status_id,
                                        o.language_id,
                                        (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status, 
                                        o.date_added, 
                                        o.date_modified, 
                                        (SELECT COUNT(*) orderProducts FROM `" . DB_PREFIX . "order_product` WHERE order_id=o.order_id) AS totalproducts,
                                        (SELECT COUNT(DISTINCT op.order_product_id) AS productsToDelete
                                FROM  `" . DB_PREFIX . "order` od
                                  INNER JOIN " . DB_PREFIX . "order_product op ON op.order_id=od.order_id
                                  ~strProductOptionsFilter~
                                WHERE od.order_id =o.order_id ~strProductFilter~
                                ) AS productsToDelete
                                FROM `" . DB_PREFIX . "order` o
                                WHERE o.order_status_id > '0') v
                        WHERE v.productsToDelete>0";
                $strProductOptionsFilter="";
                $strFilter="";
                if(!empty($data['filter_product_options'])){
                    $strProductOptionsFilter=$this->getstrProductOptionsFilter($data);
                }
                $sql=str_replace("~strProductOptionsFilter~", $strProductOptionsFilter, $sql);
                
                //Reset strFilter string
		$strFilter="";
                if (isset($data['filter_date_start']) && !is_null($data['filter_date_start'])) {
			$strFilter .= " AND DATE(od.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
		} 
                
                if (isset($data['filter_date_end']) && !is_null($data['filter_date_end'])) {
			$strFilter .= " AND DATE(od.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
		} 
                
		if (isset($data['filter_order_statuses_ids']) && !empty($data['filter_order_statuses_ids'])) {
			$strFilter .= " AND od.order_status_id in (" . implode(',',$data['filter_order_statuses_ids']) . ") ";
		}

                if (isset($data['filter_order_stores_ids']) && !empty($data['filter_order_stores_ids'])){
                        $strFilter.= " AND o.store_id in (" . implode(',',$data['filter_order_stores_ids']) . ") ";
                }
                
		if (!empty($data['filter_customer'])) {
			$strFilter .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}
                

		if (!empty($data['product_to_delete'])) {
			$strFilter .= " AND op.product_id = '" . (string)$data['product_to_delete'] . "'";
		}
                
                /*if(!empty($data['filter_product_options'])){
                        $strOptions="";
                        $delimiter="";
                        foreach($data['filter_product_options'] as $filter){
                            if (strlen($strOptions)>0){
                                $delimiter=',';
                            }
                            $strOptions.=$delimiter . $filter;
                        }
                            if(strlen($strOptions)>0){
                            $strFilter .= " AND op.otp_id in (" .$strOptions . ")";
                        }                       
                }*/

		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY v.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

                $sql=str_replace("~strProductFilter~",$strFilter,$sql);
                //$this->log->write($sql);
                $query = $this->db->query($sql);

		return $query->rows;
	}
        
        public function getOtpProductOptions($product_id){
            $sql="SELECT otp_id,CONCAT(CASE WHEN odp.name IS NULL THEN '' ELSE CONCAT(odp.name,':',ovdp.name) END,
                                        CASE WHEN odc.name IS NULL THEN '' ELSE CONCAT(' ',odc.name,':',ovdc.name) END,
                                        CASE WHEN odgc.name IS NULL THEN '' ELSE CONCAT(' ',odgc.name,':',ovdgc.name)END) description, parent_option_id, odp.name, parent_option_value_id, ovdp.name, child_option_id, odc.name, child_option_value_id,ovdc.name, grandchild_option_id,odgc.name, grandchild_option_value_id, ovdgc.name 
                  FROM " . DB_PREFIX . "otp_data otp
                   INNER JOIN " . DB_PREFIX . "otp_option_value otpo ON otpo.id=otp.otp_id
                   LEFT JOIN " . DB_PREFIX . "option_description odp ON odp.option_id=otpo.parent_option_id AND odp.language_id=1
                   LEFT JOIN " . DB_PREFIX . "option_value_description ovdp ON ovdp.option_value_id=otpo.parent_option_value_id AND ovdp.language_id=1
                   LEFT JOIN " . DB_PREFIX . "option_description odc ON odc.option_id=otpo.child_option_id AND odc.language_id=1
                   LEFT JOIN " . DB_PREFIX . "option_value_description ovdc ON ovdc.option_value_id=otpo.child_option_value_id AND ovdc.language_id=1
                   LEFT JOIN " . DB_PREFIX . "option_description odgc ON odgc.option_id=otpo.grandchild_option_id AND odgc.language_id=1
                   LEFT JOIN " . DB_PREFIX . "option_value_description ovdgc ON ovdgc.option_value_id=otpo.grandchild_option_value_id AND ovdgc.language_id=1
                   WHERE otp.product_id=" . $product_id . ";";
            $query = $this->db->query($sql);

            return $query->rows;
        }
        
        public function getProductOptionsWithOtp($product_id){
            $sql="SELECT DISTINCT otp.parent_option_id option_id, otp.parent_option_value_id option_value_id, od.name optionName,ovd.name valueName
                            FROM oc_otp_option_value otp
                            INNER JOIN oc_option_description od ON od.option_id=otp.parent_option_id AND od.language_id=1
                            INNER JOIN oc_option_value_description ovd ON ovd.option_value_id=otp.parent_option_value_id AND ovd.language_id=1
                            WHERE otp.product_id=" . $product_id . " 
                            UNION ALL
                            SELECT DISTINCT otp.child_option_id option_id, otp.child_option_value_id option_value_id, od.name optionName,ovd.name valueName
                            FROM oc_otp_option_value otp
                            INNER JOIN oc_option_description od ON od.option_id=otp.child_option_id AND od.language_id=1
                            INNER JOIN oc_option_value_description ovd ON ovd.option_value_id=otp.child_option_value_id AND ovd.language_id=1
                            WHERE otp.product_id=" . $product_id . " 
                            UNION ALL
                            SELECT DISTINCT otp.child_option_id option_id, otp.grandchild_option_value_id option_value_id, od.name optionName,ovd.name valueName
                            FROM oc_otp_option_value otp
                            INNER JOIN oc_option_description od ON od.option_id=otp.grandchild_option_id AND od.language_id=1
                            INNER JOIN oc_option_value_description ovd ON ovd.option_value_id=otp.grandchild_option_value_id AND ovd.language_id=1
                            WHERE otp.product_id=" . $product_id . "
                            UNION ALL
                            SELECT DISTINCT po.option_id,po.option_value_id,od.name optionName,ovd.name valueName
                            FROM oc_product_option_value po
                            INNER JOIN oc_option_description od ON po.option_id=od.option_id AND od.language_id=1
                            INNER JOIN oc_option_value_description ovd ON ovd.option_value_id=po.option_value_id
                            WHERE po.product_id=" . $product_id . ";";
            $query = $this->db->query($sql);

            return $query->rows;
        }
        
        public function getProductOptions($product_id){
            $this->load->model('catalog/product');
            $this->load->model('catalog/option');
            $option_data = array();
				
            $product_options = $this->model_catalog_product->getProductOptions($product_id);	
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

                                    $option_data[$product_option['product_option_id']] = array(
                                            'product_option_id' => $product_option['product_option_id'],
                                            'option_id'         => $product_option['option_id'],
                                            'name'              => $option_info['name'],
                                            'type'              => $option_info['type'],
                                            'option_value'      => $option_value_data,
                                            'required'          => $product_option['required']
                                    );	
                            } else {
                                    $option_data[$product_option['product_option_id']] = array(
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

            return $option_data;
        }
        
        public function updateTotals($order_id,$totals=array()){
            foreach($totals as $total){
                $query="UPDATE " . DB_PREFIX . "order_total set text='" . $total['text'] . "',value='" . $total['value'] . "' WHERE order_id=" . (int)$order_id . " and code='" . $total['code'] . "'";
                $this->db->query($query);
                $query="UPDATE `" . DB_PREFIX . "order` set total=" . $total['value'] . " WHERE order_id=" . (int)$order_id;
                $this->db->query($query);
            }
        }
        
        public function getstrProductOptionsFilter($data){
            $strFilter="";
            $strFilterOptions="";
            $strFilterValues="";
            $strFilterOptionsValuesId="";
            $delimiterOp="";
            $delimiterVal="";
            $delimiterValID="";
            foreach($data['filter_product_options'] as $key=>$value){
                if(strlen($strFilterOptions)>0){
                    $delimiterOp=",";
                }
                $aux=explode('~',$key);
                $strFilterOptions.=$delimiterOp . $aux[0];
                if ($aux[1]==0){
                    if(strlen($strFilterValues)>0){
                        $delimiterVal=",";
                    }
                    $strFilterValues.=$delimiterVal . "'" . $value . "'";
                } else { 
                    if(strlen($strFilterOptionsValuesId)>0){
                        $delimiterValID=",";
                    }
                    $strFilterOptionsValuesId.=$delimiterValID . $value;
                }
            }
            if(strlen($strFilterOptions)>0){
                $strFilter .= " product_option_id IN (" .$strFilterOptions . ") AND ";
                if (strlen($strFilterOptionsValuesId)==0){
                    $strFilter .= "`value` IN(" . $strFilterValues . ") ";
                } else {
                    $strFilter .= "(`value` IN(" . $strFilterValues . ") OR product_option_value_id IN (". $strFilterOptionsValuesId . ")) ";
                }                            
            }                       

            $strProductOptionsFilter="INNER JOIN (
                                                SELECT order_id, order_product_id,COUNT(*) FROM " . DB_PREFIX . "order_option 
                                                WHERE  " . $strFilter . 
                                                "GROUP BY order_id, order_product_id
                                                HAVING COUNT(*)=" . count($data['filter_product_options']) .
                                        ") v ON v.order_id=op.order_id AND v.order_product_id=op.order_product_id";            
            return $strProductOptionsFilter;
        }
        
}