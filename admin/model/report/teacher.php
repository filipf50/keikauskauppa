<?php
class ModelReportTeacher extends Model {
	
        public function getCourses($data=array()){
                $start=$data['start'];
                $limit=$data['limit'];
            
                if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 99999;
		}
                
                $sql_fields="SELECT o.order_id,op.order_product_id, op.product_id, o.date_added, o.order_status_id,o.email,o.telephone,os.Name status, pd.name product_name, op.model, od.name option_name, oo.value option_value";
                $sql=" FROM `order` o
                        INNER JOIN order_product op ON op.order_id = o.order_id
                        INNER JOIN order_status os ON os.order_status_id=o.order_status_id AND os.language_id=" . (int)$this->config->get('config_language_id') . "
                            INNER JOIN product_description pd ON pd.product_id=op.product_id AND pd.language_id=" . (int)$this->config->get('config_language_id') . "
                        LEFT JOIN order_option oo ON oo.order_product_id = op.order_product_id
                            LEFT JOIN product_option po ON po.product_option_id=oo.product_option_id
                            LEFT JOIN option_description od ON od.option_id=po.option_id AND od.language_id=" . (int)$this->config->get('config_language_id');
                
                if (isset($data['roll_date']) && !empty($data['roll_date'])){
                    $sql_fields.=",date assist";
                    $sql.= " LEFT JOIN teachers_roll_call trc on trc.order_id=o.order_id and trc.order_product_id=op.order_product_id and trc.date='" . $data['roll_date'] . "'";
                }
                    
                if (!empty($data['filter_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
                
                if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name like '" . $data['filter_name'] . "%'";
		} 
                
                if (!empty($data['filter_model'])) {
			$sql .= " AND op.model like '" . $data['filter_model'] . "%'";
		} 
                
                if (!empty($data['filter_option'])){
                    $sql .= " AND ucase(oo.VALUE) LIKE ucase('%" . $data['filter_option']. "%')";
                }
                
                $sql.="Order by o.order_id";
                
                $query = $this->db->query($sql_fields . $sql . " LIMIT " . (int)$start . "," . (int)$limit);
		
    		return $query->rows;
        }
        
        public function getTotalCourses($data=array()){
                $sql_fields="SELECT count(*) total";
                $sql=" FROM `order` o
                        INNER JOIN order_product op ON op.order_id = o.order_id
                        INNER JOIN order_status os ON os.order_status_id=o.order_status_id AND os.language_id=" . (int)$this->config->get('config_language_id') . "
                            INNER JOIN product_description pd ON pd.product_id=op.product_id AND pd.language_id=" . (int)$this->config->get('config_language_id');
                
                if (isset($data['roll_date']) && !empty($data['roll_date'])){
                    $sql.= " LEFT JOIN teachers_roll_call trc on trc.order_id=o.order_id and trc.order_product_id=op.order_product_id and trc.date='" . $data['roll_date'] . "'";
                }
                    
                if (!empty($data['filter_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
                
                if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name like '" . $data['filter_name'] . "%'";
		} 
                
                if (!empty($data['filter_model'])) {
			$sql .= " AND op.model like '" . $data['filter_model'] . "%'";
		} 
                //$sql.="Order by o.order_id";
                
                $query = $this->db->query($sql_fields . $sql);
				
    		return $query->row['total'];
        }
        
        public function getTimeTable($product_id,$rc_week_days_descrition,$rc_attributes_id){
            $start_date="";
            $end_date="";
            $week_days="";
            
            $query="SELECT * FROM product_attribute WHERE product_id=".(int)$product_id." AND attribute_id IN(". implode(',',$rc_attributes_id). ") AND language_id=" . (int)$this->config->get('config_language_id');
            $results=$this->db->query($query);
            foreach($results->rows as $attribute){
                    
                    $attribute_id=$attribute['attribute_id'];
                    
                    if ($attribute_id == $rc_attributes_id['start_date']){
                        $value_date_array = date_parse($attribute['text']);
                        if(checkdate($value_date_array['month'], $value_date_array['day'], $value_date_array['year'])){
                            $start_date=$attribute['text'];
                        }
                    } elseif ($attribute_id == $rc_attributes_id['end_date']){
                            $value_date_array = date_parse($attribute['text']);
                            if(checkdate($value_date_array['month'], $value_date_array['day'], $value_date_array['year'])){
                                $end_date=$attribute['text'];
                            }
                    }elseif ($attribute_id == $rc_attributes_id['week_day']){
                            $week_days=$attribute['text'];
                    }
                }
              $arrResult=$this->getDates($start_date,$end_date,$week_days,$rc_week_days_descrition);
              return $arrResult;
        }
        
               
        public function getRollCall($order_id,$order_product_id){
            $sql="SELECT DATE_FORMAT(`date`,'%Y-%m-%d') `date` FROM teachers_roll_call WHERE order_id=" . (int)$order_id . " and order_product_id=" . (int)$order_product_id;
            
            $query=$this->db->query($sql);
            
            return $query->rows;
        }
        public function saveRollCall($fault,$assist,$roll_date){
            //We delete previous data for $not_assist
            foreach ($fault as $roll_id) {
                //We get an array from $roll_id
                $auxData=explode('-',$roll_id);

                //We extract order_id and order_product_id from $auxData array
                $order_id=$auxData[0];
                $order_product_id=$auxData[1];    

                $this->deleteRollCall($order_id,$order_product_id,$roll_date);            
            }
            //We save each RollCall assist info
            foreach ($assist as $roll_id) {
                //We get an array from $roll_id
                $auxData=explode('-',$roll_id);

                //We extract order_id and order_product_id from $auxData array
                $order_id=$auxData[0];
                $order_product_id=$auxData[1];    

                $this->insertRollCall($order_id,$order_product_id,$roll_date);
            }
        }
        
        private function deleteRollCall($order_id,$order_product_id,$roll_date){
            $sql="DELETE FROM teachers_roll_call where order_id=" . (int)$order_id . " and order_product_id=" . (int)$order_product_id . " and date='" . $roll_date . "';";
            
            $this->db->query($sql);
        }
        
        private function insertRollCall($order_id,$order_product_id,$date){
            $sql="INSERT INTO teachers_roll_call (order_id,order_product_id,date) values(". (int)$order_id ."," . (int)$order_product_id . ",'" . $date . "');";
            
            $this->db->query($sql);
        }
        
        private function getDates($start_date,$end_date,$week_days,$rc_week_days_descrition){
            $arrRes=array();
            //We get dates
            $start_date=strtotime($start_date);
            $end_date=  strtotime($end_date);
            
            //We get an array of week's days
            $week_days=  explode('-',$week_days);
            if($start_date && $end_date && count($week_days)>0){
                //We continue if start_date and $end_date are dates and we have week_day
                if ($start_date<$end_date){
                    //We continue if start_date is lower than $end_date
                    foreach($week_days as $weekDay){
                        //We get week day searching $weekDay on $rc_week_days_descrition;
                        $aux=  array_search($weekDay,$rc_week_days_descrition);
                        if ($aux==false){
                            //If we don't find $weekDay could be in a diferene language so we have to search into sub-arrays
                            foreach($rc_week_days_descrition as $key=>$value){
                                if(strtolower ($value[(int)$this->config->get('config_language_id')]['value'])==strtolower($weekDay)){
                                    $aux=$key;
                                    break;
                                }
                            }
                        }
                        
                        $weekDaysKeys[]=$aux;
                    }
                    $arrRes[]=date('Y-m-d',$start_date);
                    $dayPos=0;  
                    $day='Saturday';
                    while ($start_date<$end_date){
                        //We get date info
                        if (count($weekDaysKeys)>1){
                            //If we have more than 1 day by week we get next day
                            if($dayPos<(count($weekDaysKeys)-1)){
                                //Go to next week day
                                $dayPos++;
                            } else {
                                //Return to first week day
                                $dayPos=0;
                            }                            
                        }
                        $arrRes[]=date("Y-m-d",strtotime("next " . $weekDaysKeys[$dayPos],$start_date));
                        $start_date=strtotime("next " . $weekDaysKeys[$dayPos],$start_date);
                        if($dayPos>7||count($arrRes)>365) {
                            break;  
                        }
                    }              
                }
            }
            return $arrRes;
        }
        
}
?>