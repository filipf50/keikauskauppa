<?php
class ModelToolPopup extends Model {
	public function getData($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact_popup WHERE lang_id = '".(int)$id."' AND status = '1'");
		return $query->row;
	}
	public function getDynamic($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_dynamic WHERE lang_id = '".(int)$id."' AND status = '1'");
		return $query->row;
	}
	public function getNews($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_newsletter WHERE lang_id = '".(int)$id."' AND status = '1'");
		return $query->row;
	}

	public function submitData($data) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletterdb WHERE email = '".$this->db->escape($data['email'])."'");
		
		if(!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "newsletterdb SET fname = '" . $this->db->escape($data['fname']) . "',email = '" . $this->db->escape($data['email']) . "',lname = '" . $this->db->escape($data['lname']) . "',subscribe = '1', date = NOW()");
			return 1;
		} else {
			return 0;
		}
	}
}
?>