<?php 
class ModelModuleProductSpecialsWizard extends Model {
	
	public function getEnabledProducts() {
		$products	= $this->db->query("
			SELECT p.product_id, CONCAT(pd.NAME,' (',ROUND(p.price,2),')',CASE WHEN (SELECT COUNT(*) FROM ". DB_PREFIX . "product_special WHERE product_id=p.product_id)>0 THEN ' <span style=''color:green;''>Specials calculated</span>' ELSE '' END) name
                        FROM ". DB_PREFIX . "product p 
                            INNER JOIN ". DB_PREFIX . "product_description pd ON pd.product_id=p.product_id 
                        WHERE p.STATUS=1 AND language_id=" . $this->config->get( 'config_language_id' ) . "
                        ORDER BY pd.name,p.product_id;
		");
		
		if($products->num_rows )
			return $products->rows;
		else
                        return array();
	}
        
        public function updateSpecials($product_id, $specials){
		if (isset($specials)) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
			foreach ($specials as $special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$special['customer_group_id'] . "', priority = '1', price = '" . (float)$special['price'] . "', date_start = '" . $this->db->escape($special['date_start']) . "', date_end = '" . $this->db->escape($special['date_end']) . "'");
			}
		}
        }
        
        public function deleteSpecials($product_id){
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
        }
}
?>