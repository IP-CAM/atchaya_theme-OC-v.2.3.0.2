<?php
class ControllerBlogVideo extends Controller
{
  public function index()
  {
    $this->load->model('blog/video');
    $this->load->language('blog/video');

    if(file_exists('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/stylesheet/opentheme/ocblog.css'))
    {
      $this->document->addStyle('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/stylesheet/opentheme/ocblog.css');
    }
    else
    {
      $this->document->addStyle('catalog/view/theme/default/stylesheet/opentheme/ocblog.css');
    }

    $data['heading_title'] = $this->config->get('heading_title');

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

    $data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blog'),
			'href' => $this->url->link('blog/blog')
		);

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('name'),
      'href' => $this->url->link('blog/video')
    );

    $data['blogvideos'] = array();

    $data['blogvideos'] = $this->model_blog_video->getVideoBlog();

    $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		$this->response->setOutput($this->load->view('blog/video.tpl', $data));

  }
}
?>
