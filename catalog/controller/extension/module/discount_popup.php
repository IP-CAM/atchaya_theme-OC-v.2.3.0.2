<?php
class ControllerExtensionModuleDiscountPopup extends Controller {
  	private $error = array();

  	public function index() {


		$this->load->language('extension/module/ocspecialproductslider');

		$this->load->model('catalog/product');
		$this->load->model('catalog/ocproductrotator');
		$this->load->model('tool/image');

		$this->document->addScript('catalog/view/javascript/opentheme/jquery.bpopup.min.js');
		$this->document->addScript('catalog/view/javascript/opentheme/jquery.cookie.js');

		$data = array();

		$data['heading_title'] = $this->language->get('heading_title');

		$lang_code = $this->session->data['language'];

		$data['title'] = $this->language->get('heading_title');
		
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_new'] = $this->language->get('text_new');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');;

		$data['products'] = array();



		

  		return $this->load->view('extension/module/newsletterpopup');


  	}


  }