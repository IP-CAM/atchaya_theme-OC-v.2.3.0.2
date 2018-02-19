<?php
class ControllerExtensionModuleGallery extends Controller {
	
	public function index() {

		$this->load->language('extension/module/gallary');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/gallery');

		$data['galleries'] = array();

		$galleries = $this->model_catalog_gallery->getGalleries();

		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		foreach ($galleries as $gallerys) {

			$data['galleries'][] = array(
				'galleryid'   => $gallerys['id'],
				'image'       => $gallerys['gallery_image'],
				'name'        => $gallerys['name'] ,
				'description' => $gallerys['description'],
				'sort_order'  => $gallerys['sort_order']
			);
		}

		$this->response->setOutput($this->load->view('extension/module/gallery', $data));
	}
}