<?php
class ModelSettingGallery extends Model {
	public function getGallery() {
		
		$gallery_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery");
		
		foreach ($query->rows as $result){
				$gallery_data[] = $result;
		}
		return $gallery_data;
	}

	public function editSetting($code,$data) {

		foreach ($data as $key => $value) {

			foreach($value as $values){

				$id = $values['id'];
				$createddate = date('d-m-Y');

				if($id != ""){
					$this->db->query("UPDATE ".DB_PREFIX."gallery SET gallery_image = '".$values['image']."',name = '".$values['name']."', description = '".$values['description']."', sort_order = '".$values['sort_order']."' WHERE id = '".$id."'");
				}
				else
				{
					$this->db->query("INSERT INTO ".DB_PREFIX."gallery SET gallery_image = '".$values['image']."',name = '".$values['name']."', description = '".$values['description']."', sort_order = '".$values['sort_order']."',created_date='".$createddate."'");
				}
			}
		}
	}

	public function deleteSetting() {
		echo "dfsfsd"; die;
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");
	}
	
	public function getSettingValue($key, $store_id = 0) {
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = '" . $this->db->escape($key) . "'");

		if ($query->num_rows) {
			return $query->row['value'];
		} else {
			return null;	
		}
	}
	
	public function editSettingValue($code = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "', serialized = '0'  WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1' WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		}
	}
}
