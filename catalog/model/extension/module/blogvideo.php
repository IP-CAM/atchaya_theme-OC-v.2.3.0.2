<?php
class ModelExtensionModuleBlogvideo extends Model
{
  public function getBloghome()
  {
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogvideo` ORDER BY `id` DESC LIMIT 2");
    return $query->row;
  }
}
?>
