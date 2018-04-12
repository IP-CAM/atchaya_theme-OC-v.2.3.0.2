<?php
class ControllerExtensionModuleGallerymodule extends Controller {
	
	public function index() {

		$this->load->language('extension/module/gallarymodule');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/gallerymodule');

		$data['galleries'] = array();

		$galleries = $this->model_catalog_gallerymodule->getGalleries();

		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

		if(!empty($galleries))
		{
			foreach ($galleries as $gallerys)
			{
				$data['galleries'][] = array(
					'galleryid'   => $gallerys['id'],
					'image'       => $gallerys['gallery_image'],
					'name'        => $gallerys['name'] ,
					'description' => $gallerys['description'],
					'sort_order'  => $gallerys['sort_order']
				);
			}
		}

		return $this->load->view('extension/module/gallerymodule', $data);
	}
}