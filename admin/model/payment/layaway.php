<?php
    class ModelPaymentLayaway extends Model {
  	public function allowAutoSelectByProductOption() {
            $columns=$this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "option_value like 'layaway_checked'");
            
            if ($columns->num_rows==0){
                $this->db->query("ALTER TABLE `" . DB_PREFIX . "option_value`  ADD column `layaway_checked` int(1) NOT NULL DEFAULT 0;");
            }
        }
    }
?>