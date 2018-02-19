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

		$data['blogvideos'] = $this->model_extension_module_blogvideo->getBloghome();

		if(!empty($data['blogvideos']) && $this->config->get('blogvideo_status') == 1)
		{
			return $this->load->view('extension/module/blogvideo', $data);
		}
	}
}
