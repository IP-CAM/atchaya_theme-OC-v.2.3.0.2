<?php
class ModelBlogVideo extends Model
{
  public function getVideoBlog()
  {
    $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."blogvideo WHERE status = 1 ORDER BY id DESC");
    return $query->rows;
  }

  public function getArticle($article_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogvideo WHERE id = '" . (int)$article_id . "' AND status = '1' ");

    if ($query->num_rows) {
      return array(
        'id'       => $query->row['id'],
        'title'             => $query->row['title'],
        'author'            => "Atchaya's Traditional Farms & Foods",
        'url'               => $query->row['url'],
        'description'       => $query->row['description'],
        'short_description' => $query->row['short_description'],        
        'date_added'        => $query->row['created_at']
      );
    } else {
      return false;
    }
  }
}
?>
