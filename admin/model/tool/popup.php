<?php
class ModelToolPopup extends Model {
	public function adddata($data) {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "contact_popup");
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "popup_dynamic");
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "popup_newsletter");
		foreach ($data['contact'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contact_popup SET `lang_id` = '" . (int)$key . "',`loc` = '" . (int)$value['loc'] . "',`pc` = '" . (int)$value['pc'] . "',`allow` = '" . (int)$value['allow'] . "',`mobile` = '" . (int)$value['mobile'] . "', `left` = '" . $this->db->escape($value['left']) . "',image = '" . $this->db->escape($value['image']) . "',width = '" . $this->db->escape($value['width']) . "',height = '" . $this->db->escape($value['height']) . "',blackout = '" . $this->db->escape($value['blackout']) . "',status = '" . $this->db->escape($value['status']) . "'");
		}
		foreach ($data['dynamic'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_dynamic SET `lang_id` = '" . (int)$key . "',`theme` = '" . (int)$value['theme'] . "',`url` = '" . $this->db->escape($value['url']) . "', `message` = '" . $this->db->escape($value['message']) . "',style = '" . (int)$value['style'] . "',status = '" . $this->db->escape($value['status']) . "'");
		}
		foreach ($data['newsletter'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_newsletter SET `lang_id` = '" . (int)$key . "',`message` = '" . $this->db->escape($value['message']) . "',`fname` = '" . (int)$value['fname'] . "',`lname` = '" . (int)$value['lname'] . "',`logo` = '" . (int)$value['logo'] . "',image = '" . $this->db->escape($value['image']) . "',width = '" . $this->db->escape($value['width']) . "',height = '" . $this->db->escape($value['height']) . "',theme = '" . (int)$value['theme'] . "',status = '" . $this->db->escape($value['status']) . "'");
		}
	}

	public function getdata() {
		$result_data = array();
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact_popup");
		foreach ($result->rows as $key => $value) {
			$result_data[$value['lang_id']]['left'] = $value['left']; 
			$result_data[$value['lang_id']]['image'] = $value['image']; 
			$result_data[$value['lang_id']]['status'] = $value['status']; 
			$result_data[$value['lang_id']]['width'] = $value['width'];
			$result_data[$value['lang_id']]['loc'] = $value['loc'];
			$result_data[$value['lang_id']]['pc'] = $value['pc'];
			$result_data[$value['lang_id']]['mobile'] = $value['mobile'];
			$result_data[$value['lang_id']]['height'] = $value['height']; 
			$result_data[$value['lang_id']]['blackout'] = $value['blackout']; 
			$result_data[$value['lang_id']]['allow'] = $value['allow']; 
		}
		
		return $result_data;
	}

	public function getdatad() {
		$result_data = array();
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_dynamic");
		foreach ($result->rows as $key => $value) {
			$result_data[$value['lang_id']]['theme'] = $value['theme']; 
			$result_data[$value['lang_id']]['url'] = $value['url']; 
			$result_data[$value['lang_id']]['status'] = $value['status']; 
			$result_data[$value['lang_id']]['message'] = $value['message'];
			$result_data[$value['lang_id']]['style'] = $value['style'];
		}
		
		return $result_data;
	}

	public function getdatan() {
		$result_data = array();
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_newsletter");
		
		foreach ($result->rows as $key => $value) {
			$result_data[$value['lang_id']]['theme'] = $value['theme']; 
			$result_data[$value['lang_id']]['logo'] = $value['logo']; 
			$result_data[$value['lang_id']]['image'] = $value['image'];
			$result_data[$value['lang_id']]['status'] = $value['status']; 
			$result_data[$value['lang_id']]['fname'] = $value['fname'];
			$result_data[$value['lang_id']]['width'] = $value['width'];
			$result_data[$value['lang_id']]['height'] = $value['height'];
			$result_data[$value['lang_id']]['lname'] = $value['lname'];
			$result_data[$value['lang_id']]['message'] = $value['message'];
		}
		
		return $result_data;
	}

	public function getLanguages($data = array()) {
		
		if ($data) {
			
			$sql = "SELECT * FROM " . DB_PREFIX . "language WHERE status = 1 ";
	
			$sort_data = array(
				'name',
				'code',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY sort_order, name";	
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
			
			$query = $this->db->query($sql);
	
			return $query->rows;
		} else {
			$language_data = $this->cache->get('language');
		
			if (!$language_data) {
				$language_data = array();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE status = 1 ORDER BY sort_order, name");
	
    			foreach ($query->rows as $result) {
      				$language_data[$result['code']] = array(
        				'language_id' => $result['language_id'],
        				'name'        => $result['name'],
        				'code'        => $result['code'],
						'locale'      => $result['locale'],
						'image'       => $result['image'],
						'directory'   => $result['directory'],
						'filename'    => $result['filename'],
						'sort_order'  => $result['sort_order'],
						'status'      => $result['status']
      				);
    			}	
			
				$this->cache->set('language', $language_data);
			}
		
			return $language_data;			
		}
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
					  `image` varchar(256) NOT NULL,
					  `width` int(10) NOT NULL,
					  `height` int(10) NOT NULL,
					  `theme` int(11) NOT NULL,
					  `message` varchar(256) NOT NULL,
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