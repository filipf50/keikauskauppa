<?php
class ModelToolPopupEmail extends Model {

	public function getd($id) {
		$result = array();
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletterdb WHERE id = '".$id."'");
		return $result->row['details'];
	}

	public function getfh($data) {
		$result = array();
		$sql = "SELECT * FROM " . DB_PREFIX . "newsletterdb";

		if (isset($data['sort'])) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY id ";	
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
		$result = $this->db->query($sql);
		return $result->rows;
	}

	public function getfht($data) {
		$result = array();
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletterdb");
		return $result->num_rows;
	}

	public function delete($id) {
		$result = $this->db->query("DELETE  FROM " . DB_PREFIX . "newsletterdb WHERE id = '".$id."'");
	}

	public function createTablesInDatabse() {
		
        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."contact_popup'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contact_popup` (
                       `lang_id` int(11) NOT NULL,
                       `loc` int(11) NOT NULL,
                       `allow` int(11) NOT NULL,
					  `left` text NOT NULL,
					  `image` varchar(256) NOT NULL,
					  `width` int(10) NOT NULL,
					  `height` int(10) NOT NULL,
					  `blackout` int(10) NOT NULL,
					  `status` int(10) NOT NULL
					) ENGINE=MyISAM COLLATE=utf8_general_ci;";
            $this->db->query($sql);
        }

        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "contact_popup` LIKE  'pc'";
	    $result = $this->db->query($sql)->num_rows;
	    if(!$result) {
	      	$this->db->query("ALTER TABLE  `". DB_PREFIX ."contact_popup` ADD  `pc` INT( 11 ) NOT NULL AFTER  `loc`");
	    }

	    $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "contact_popup` LIKE  'mobile'";
	    $result = $this->db->query($sql)->num_rows;
	    if(!$result) {
	      	$this->db->query("ALTER TABLE  `". DB_PREFIX ."contact_popup` ADD  `mobile` INT( 11 ) NOT NULL AFTER  `loc`");
	    }

        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."popup_dynamic'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "popup_dynamic` (
                       `lang_id` int(11) NOT NULL,
                       `status` int(11) NOT NULL,
                       `theme` int(11) NOT NULL,
                       `style` int(11) NOT NULL,
					  `url` text NOT NULL,
					  `message` varchar(256) NOT NULL
					) ENGINE=MyISAM COLLATE=utf8_general_ci;";
            $this->db->query($sql);
        }
        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."popup_newsletter'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "popup_newsletter` (
                       `lang_id` int(11) NOT NULL,
                       `status` int(11) NOT NULL,
                       `fname` int(11) NOT NULL,
                       `lname` int(11) NOT NULL,
					  `logo` int(11) NOT NULL,
					  `theme` int(11) NOT NULL,
					  `mailchimp` text NOT NULL
					) ENGINE=MyISAM COLLATE=utf8_general_ci;";
            $this->db->query($sql);
        }
        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."newsletterdb'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "newsletterdb` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `fname` text NOT NULL,
                       `lname` text NOT NULL,
					  `email` text NOT NULL,
					  `subscribe` int(11) NOT NULL,
					   `date` datetime NOT NULL,
					   PRIMARY KEY (`id`)
					) ENGINE=MyISAM COLLATE=utf8_general_ci;";
            $this->db->query($sql);
        }
    }
}
?>