<?php 

/**
 * Customer Group Restrict
 * 
 * @author marsilea15 <marsilea15@gmail.com> 
 */
class ModelModuleCustomerGroupRestrict extends Model {
	
	/**
	 * Pobierz wg ID produktu
	 * 
	 * @param int $product_id 
	 * @return array
	 */
	public function getByProductId( $product_id ) {
		$customers	= '';
		$product	= $this->db->query("
			SELECT
				mod_customer_group_restrict
			FROM
				" . DB_PREFIX . "product
			WHERE
				product_id = '" . (int) $product_id . "'
		");
		
		if( $product->num_rows )
			$customers = (string) $product->row['mod_customer_group_restrict'];
		
		if( ! $customers )
			return array();
		
		return $this->db->query("
			SELECT
				cg.customer_group_id,
				cgn.name
			FROM
				" . DB_PREFIX . "customer_group cg
			LEFT JOIN
				" . DB_PREFIX . "customer_group_description cgn
			ON
				cg.customer_group_id = cgn.customer_group_id AND
				cgn.language_id = " . $this->config->get( 'config_language_id' ) . "
			WHERE
				cg.customer_group_id IN(" . $customers . ")
		")->rows;
	}
	
	/**
	 * Pobierz wg ID kategorii
	 * 
	 * @param int $category_id 
	 * @return array
	 */
	public function getByCategoryId( $category_id ) {
		$customers	= '';
		$category	= $this->db->query("
			SELECT
				mod_customer_group_restrict
			FROM
				" . DB_PREFIX . "category
			WHERE
				category_id = '" . (int) $category_id . "'
		");
		
		if( $category->num_rows )
			$customers = (string) $category->row['mod_customer_group_restrict'];
		
		if( ! $customers )
			return array();
		
		return $this->db->query("
			SELECT
				cg.customer_group_id,
				cgn.name
			FROM
				" . DB_PREFIX . "customer_group cg
			LEFT JOIN
				" . DB_PREFIX . "customer_group_description cgn
			ON
				cg.customer_group_id = cgn.customer_group_id AND
				cgn.language_id = " . $this->config->get( 'config_language_id' ) . "
			WHERE
				cg.customer_group_id IN(" . $customers . ")
		")->rows;
	}
	
	/**
	 * Instalacja modułu
	 */
	public function install() {
		/**
		 * Produkty 
		 */
		$query = $this->db->query('SHOW COLUMNS FROM ' . DB_PREFIX . 'product LIKE "mod_customer_group_restrict"');
		
		// sprawdź czy istnieje takie pole
		if( ! $query->num_rows )
			$this->db->query('ALTER TABLE ' . DB_PREFIX . 'product ADD `mod_customer_group_restrict` TEXT NULL DEFAULT NULL');
		
		/**
		 * Kategorie 
		 */
		$query = $this->db->query('SHOW COLUMNS FROM ' . DB_PREFIX . 'category LIKE "mod_customer_group_restrict"');
		
		// sprawdź czy istnieje takie pole
		if( ! $query->num_rows )
			$this->db->query('ALTER TABLE ' . DB_PREFIX . 'category ADD `mod_customer_group_restrict` TEXT NULL DEFAULT NULL');
	}
	
	/**
	 * Deinstalacja modułu
	 */
	public function uninstall() {
		/**
		 * Produkty 
		 */
		$query = $this->db->query('SHOW COLUMNS FROM ' . DB_PREFIX . 'product LIKE "mod_customer_group_restrict"');
		
		// sprawdź czy istnieje takie pole
		if( $query->num_rows )
			$this->db->query('ALTER TABLE ' . DB_PREFIX . 'product DROP `mod_customer_group_restrict`');
		
		/**
		 * Kategorie 
		 */
		$query = $this->db->query('SHOW COLUMNS FROM ' . DB_PREFIX . 'category LIKE "mod_customer_group_restrict"');
		
		// sprawdź czy istnieje takie pole
		if( $query->num_rows )
			$this->db->query('ALTER TABLE ' . DB_PREFIX . 'category DROP `mod_customer_group_restrict`');
	}
}
?>