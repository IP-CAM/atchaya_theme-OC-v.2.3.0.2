<?php
class ControllerExtensionModuleGallery extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/gallery');

		$data['gallery_data'] = $this->model_setting_gallery->getGallery();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_gallery->editSetting('gallery', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/gallery', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['grid_image'] = $this->language->get('grid_image');
		$data['grid_name'] = $this->language->get('grid_name');
		$data['grid_description'] = $this->language->get('grid_description');
		$data['grid_sortorder'] = $this->language->get('grid_sortorder');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('extension/module/gallery', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/gallery', 'token=' . $this->session->data['token'], true);

		$data['ajaxaction'] = $this->url->link('extension/module/gallery/ajaxrequest');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/gallery',$data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function ajaxrequest() {
		
		$this->load->model('setting/gallery');
			
		if(isset($_POST['deleteid']))
		{
			$this->model_setting_gallery->deleteSetting($_POST['deleteid']);
		}
	}

	public function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."gallery (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `gallery_image` varchar(255) NOT NULL,
      `name` varchar(255) NOT NULL,
      `description` text NOT NULL,
      `sort_order` int(11) NOT NULL,
      `created_date` varchar(30) NOT NULL,
      `updated_date` timestamp NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");
	}
}
