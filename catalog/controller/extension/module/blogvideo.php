<?php
class ControllerExtensionModuleBlogvideo extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->model('extension/module/blogvideo');
		$this->load->language('extension/module/blogvideo');

		$data = array();
		$data['heading_title'] = $this->language->get('heading_title');

		$data['blogvideos'] = array();

		$results = $this->model_extension_module_blogvideo->getBloghome();

		foreach ($results as $result) {
			$data['blogvideos'][] = array(
				'url'  							=> $result['url'],
				'title'        			=> $result['title'],
				'author'	  				=> "Atchaya's Traditional Farms & Foods",
				'created_at'  			=> date("m/d/Y", strtotime($result['created_at'])),
				'short_description'	=> html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
				'href'        			=> $this->url->link('blog/video', 'video_id=' . $result['id'])
			);
		}

		if(!empty($data['blogvideos']) && $this->config->get('blogvideo_status') == 1)
		{
			return $this->load->view('extension/module/blogvideo', $data);
		}
	}
}
