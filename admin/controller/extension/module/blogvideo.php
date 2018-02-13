<?php

class ControllerExtensionModuleBlogvideo extends Controller
{
	private $error = array();

	public function index()
  	{
  		$blog_video = $this->load->language('extension/module/blogvideo');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit']     = $this->language->get('text_edit');
		$data['entry_name']    = $this->language->get('entry_name');
		$data['button_save']   = $this->language->get('button_save');

		if (isset($this->error['warning']))
		{
			$data['error_warning'] = $this->error['warning'];
		}
		else
    	{
    		$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blogvideo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
    
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/blogvideo', 'token=' . $this->session->data['token'], true)
		);
    
		$data['action'] = $this->url->link('extension/module/blogvideo', 'token=' . $this->session->data['token'], true);
    
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['blogvideo_url'])) {
			$data['blogvideo_url'] = $this->request->post['blogvideo_url'];
		} else {
			$data['blogvideo_url'] = $this->config->get('blogvideo_url');
		}

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/blogvideo', $data));
	}

	protected function validate()
  {
    if (!$this->user->hasPermission('modify', 'extension/module/account'))
    {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

  // function install()
  // {
  //   $this->load->model('setting/setting');
  //   $this->model_setting_setting->editSetting('module_blogvideo', array('module_video_status' => 1));
  // }
}
?>
