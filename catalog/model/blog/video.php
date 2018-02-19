<?php
class ModelBlogVideo extends Model
{
  public function getVideoBlog()
  {
    $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."blogvideo WHERE status = 1 ORDER BY id DESC");
    return $query->rows;
  }
}
?>
