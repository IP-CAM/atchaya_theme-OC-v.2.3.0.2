<?php
class ControllerExtensionModuleDiscountPopup extends Controller {
  	private $error = array();

  	public function index() { echo "string";exit;

  		$this->language->load('extension/module/newslettersubscribe');
		$this->document->addScript('catalog/view/javascript/opentheme/jquery.bpopup.min.js');
		$this->document->addScript('catalog/view/javascript/opentheme/jquery.cookie.js');

  		return $this->load->view('extension/module/newsletterpopup', $data);



  	}


  }