<?php

class ModelModuleRollCall extends Model {

    public function install() {

	$query_table = $this->db->query("SHOW tables like 'teachers_roll_call'");

	if (!$query_table->num_rows) {

	    return $this->db->query('CREATE TABLE if not exists `teachers_roll_call`( 
                                        `order_id` int(11) NOT NULL , 
                                        `order_product_id` int(11) NOT NULL , 
                                        `date` date NOT NULL , 
                                        PRIMARY KEY (`order_id`, `order_product_id`, `date`)
                                      )');
	}
    }
}
?>