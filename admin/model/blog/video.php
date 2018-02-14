<?php

class ModelBlogVideo extends Model
{
  // Add Video Blog
  public function addBlogvideo($data)
  {
    $this->db->query("INSERT INTO " . DB_PREFIX . "blogvideo SET title = '" . $this->db->escape($data['title']) . "', url = '" . $this->db->escape($data['url']) . "', short_description = '" . $this->db->escape($data['short_description']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)$data['status'] . "'");

    $this->cache->delete('blogvideo');
    $blogvideo_id = $this->db->getLastId();
    return $blogvideo_id;
  }

  // Edit Video Blog
  public function editvideo($blogvideo_id, $data = array())
  {
    $sql = "UPDATE " . DB_PREFIX . "blogvideo SET title = '" . $this->db->escape($data['title']) . "', url = '" . $this->db->escape($data['url']) . "', short_description = '" . $this->db->escape($data['short_description']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int) $data['status'] . "' WHERE id = '" . (int) $blogvideo_id . "'";
    $this->db->query($sql);
    $this->cache->delete('blogvideo');
    return;
  }

  // Delete Video Blog
  public function deleteBlogvideo($id)
  {
      $this->db->query("DELETE FROM " . DB_PREFIX . "blogvideo WHERE id = '" . (int)$id . "'");
      $this->cache->delete('blogvideo');
  }

    public function BlogvideoList($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "blogvideo SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");

        $blogvideo_id = $this->db->getLastId();

        $this->cache->delete('blogvideo');

        return $blogvideo_list_id;
    }

    public function addBlogvideoToList($blogvideo_list_id, $blogvideoIds)
    {
        foreach($blogvideoIds as $blogvideoId) {
            $sql = "INSERT INTO " . DB_PREFIX . "article_to_list SET article_list_id = '". (int) $article_list_id . "', article_id = '" . (int) $articleId . "'";

            $this->db->query($sql);
        }

        $this->cache->delete('article_to_list');

        return;
    }

    public function editArticleList($article_list_id, $data = array()) {
        $sql = "UPDATE " . DB_PREFIX . "article_list SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int) $data['status'] . "' WHERE article_list_id = '" . (int) $article_list_id . "'";

        $this->db->query($sql);

        $this->db->query("DELETE FROM " . DB_PREFIX . "article_to_list WHERE article_list_id = '" . (int)$article_list_id . "'");

        foreach($data['article'] as $articleId) {
            $sql = "INSERT INTO " . DB_PREFIX . "article_to_list SET article_list_id = '". (int) $article_list_id . "', article_id = '" . (int) $articleId . "'";

            $this->db->query($sql);
        }

        $this->cache->delete('article_to_list');

        return;
    }

    public function copyArticlesList($article_list_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_list WHERE article_list_id = '" . (int)$article_list_id . "'");

        if ($query->num_rows) {
            $data = array();
            $result = $query->row;

            $data['name'] = $result['name'];
            $data['status'] = $result['status'];
            $this->addArticlesList($data);
        }
    }

    public function deleteArticlesList($article_list_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "article_list WHERE article_list_id = '" . (int)$article_list_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "article_to_list WHERE article_list_id = '" . (int)$article_list_id . "'");
        $this->cache->delete('article_list');
    }

    public function getvideo($id)
    {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogvideo WHERE id = '" . (int)$id . "'");
      return $query->row;
    }

    public function getBlogvdieo($id)
    {
      $query = $this->db->query("SELECT id FROM " . DB_PREFIX . "blogvideo WHERE id = '" . (int)$id . "'");
      return $query->row;
    }

    public function getArticleToList($article_list_id) {
        $query = $this->db->query("SELECT article_id FROM " . DB_PREFIX . "article_to_list WHERE article_list_id = '" . (int)$article_list_id . "'");

        return $query->rows;
    }

    public function getArticleList($article_list_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_list WHERE article_list_id = '" . (int)$article_list_id . "'");

        return $query->row;
    }

    public function getAllBlogvideoList($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "blogvideo";

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
    }

    public function getTotalBlogvideoList()
    {
      $sql = "SELECT COUNT(DISTINCT id) AS total FROM " . DB_PREFIX . "blogvideo";
      $query = $this->db->query($sql);
      return $query->row['total'];
    }
}
