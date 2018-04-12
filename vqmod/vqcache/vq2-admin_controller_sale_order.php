<?php
class ControllerSaleOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getForm();
	}
	
	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
	
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
	
			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}
	
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}
	
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
	
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

$data['button_import'] = $this->language->get('button_import');
                $data['import'] = $this->url->link('sale/order/irsorderimport', 'token=' . $this->session->data['token'],true);
$data['button_export'] = $this->language->get('button_export');
			  $data['export'] = $this->url->link('sale/order/orderexport', 'token=' . $this->session->data['token'],true);
		$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], true);
		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'], true);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'          => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_list', $data));
	}


        public function irsorderimport() {

        $excel_field_error = 0;
        $_SESSION['orderlist']=array();

        $this->load->language('sale/order');
        $this->load->model('sale/order');

        $data['heading_title'] = "Import Order Data";

        $data['entry_import'] = $this->language->get('Upload CSV File');

        $data['entry_insertonly'] = $this->language->get('Insert Only');

        $data['action'] = $this->url->link('sale/order/irsorderimport', 'token=' . $this->session->data['token'], 'SSL');

        $data['importdataurl'] = $this->url->link('sale/order/importproducts', 'token=' . $this->session->data['token'],true);
        $data['sampleexport'] = $this->url->link('sale/order/productsampleexport', 'token=' . $this->session->data['token'], true);
        $data['sample_export'] = $this->language->get('Sample Csv File');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );


        if(isset($_POST['submit']))
        { 
            $version_check=$_POST['opcversion'];
 
            $insertonly=0;

            if(isset($_POST['insertonly']) && $_POST['insertonly']==1)
                $insertonly=1;

            if($this->validateImport())
            {  // import form validate start

                if ((isset($this->request->files['file'])) && (is_uploaded_file($this->request->files['file']['tmp_name'])))
                { //file upload start
 			if($version_check=="opc2200" || $version_check=="opc2302")
						{ //opc version check start

                    @set_time_limit(3600);
                    if (substr(@ini_get("memory_limit"), 0, -1) < "512") {
                        @ini_set("memory_limit", "512M");
                    }
                    ini_set("memory_limit", "512M");
                    ini_set("max_execution_time", 180);
                    ini_set('display_errors', 1);
                    ini_set('log_errors', 1);
                    error_reporting(E_ALL);
                    //set_time_limit( 60 );

                    $filename = $this->request->files['file']['tmp_name'];

                    //chdir('../system/library/PHPExcel'); // change directory to PHPExcel library
                    //require_once( 'Classes/PHPExcel.php' );
                    //chdir('../../../admin');

                    require_once('../system/library/PHPExcel/Classes/PHPExcel.php' );

                    $inputFileType = PHPExcel_IOFactory::identify($filename);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    //$objReader->setReadDataOnly(true);
                    $reader = $objReader->load($filename);
                    $reader = &$reader;
                    //			$this->clearCache();

                    $xldata = $reader->getSheet(0);

                    $isFirstRow = TRUE;

                    $i = 0;

                    $temp=0;//declared
                    $b=0;//declared
                    $option1=0;//declared
                    $option2=0;//declared
                   

                    $k = $xldata->getHighestRow();
                    $order_array = array();

                    $columns = PHPExcel_Cell::columnIndexFromString($xldata->getHighestColumn());

                    if($columns == 53)
                    {
                        for ($i = 0; $i < $k; $i++) {  // Excel row loop start
                            //Skip the header row
                            if ($isFirstRow) {
                                $isFirstRow = FALSE;
                                continue;
                            }

                            $invoice_no = $this->getCell($xldata, $i, 1);

                            $currency = $this->getCell($xldata, $i, 2);
                            $currency=$this->model_sale_order->getcurrencyid($currency);
                            $customer = $this->getCell($xldata, $i, 3);

                            $ip=$this->model_sale_order->getip();

                            $customer_Group = $this->getCell($xldata, $i, 4);
                            $customer_Group_id=$this->model_sale_order->getcustomergroupid($customer_Group);
                            $firstname = $this->getCell($xldata, $i, 5);
                            $lastname = $this->getCell($xldata, $i, 6);
                            $email = $this->getCell($xldata, $i, 7);
                            $telephone = $this->getCell($xldata, $i, 8);
                            $fax = $this->getCell($xldata, $i, 9);

                            //2.produtcs..
                            $product = $this->getCell($xldata, $i, 10);
				if(!empty($product)){ 
                            $product_id=$this->model_sale_order->getproductid($product);//print_r($product_id);
                            $product_details=$this->model_sale_order->getproductmodel($product_id);//print_r($product_details);
				}else{
				 $product_id="";
 $product_details="";
				}
                            $quantity = $this->getCell($xldata, $i, 11);
                            $reward = $this->model_sale_order->getproductreward($product_id);
                            $reward_point_total = $quantity * $reward;
                            //products option
                            $total = $this->getCell($xldata, $i, 12);

                            //$product_option_id=$this->model_sale_order->getproductoptionid($product_id);print_r($product_option_id);
//                            $order_product_id=$this->model_sale_order->getorderproductid($order_id);//print_r($order_id);

                            $optionname = $this->getCell($xldata, $i, 13);
                            $optionvalue = $this->getCell($xldata, $i, 14);
                            $optiontype = $this->getCell($xldata, $i, 15);

                            $option_id=$this->model_sale_order->getoptionid($optionname);//print_r($option_id);
							$product_option_id=$this->model_sale_order->getproductoptionid($option_id);//print_r($product_option_id);
                            // print_r($option_id['option_id']);

                            //$option_id
                            $option_value_id=$this->model_sale_order->getoptionvalueid($optionvalue,$option_id);
                            $product_option_value_id=$this->model_sale_order->getproductoptionvalueid($option_value_id,$option_id,$product_option_id);
                            //voucher
                            $description=$this->getCell($xldata, $i, 16);
                            $vouchercode=$this->getCell($xldata, $i, 17);
                            $recipient_name = $this->getCell($xldata, $i, 18);
                            $recipient_email = $this->getCell($xldata, $i, 19);
                            $senders_name = $this->getCell($xldata, $i, 20);
                            $senders_email = $this->getCell($xldata, $i, 21);
                            $gift_certificate_theme = $this->getCell($xldata, $i, 22);
                            $gift_certificate_theme_id=$this->model_sale_order->getvoucherthemeid($gift_certificate_theme);
                            $message = $this->getCell($xldata, $i, 23);
                            $amount = $this->getCell($xldata, $i, 24);

                            $user_agent = $this->request->server['HTTP_USER_AGENT'];
                            //3.payment details
                            $pyment_firstname = $this->getCell($xldata, $i, 25);
                            $payment_lastname = $this->getCell($xldata, $i, 26);
                            $pyment_company = $this->getCell($xldata, $i, 27);
                            $payment_dddress1 = $this->getCell($xldata, $i, 28);
                            $payment_dddress2 = $this->getCell($xldata, $i, 29);
                            $payment_city = $this->getCell($xldata, $i, 30);
                            $payment_postcode = $this->getCell($xldata, $i, 31);
                            $payment_country = $this->getCell($xldata, $i, 32);
                            $country_id=$this->model_sale_order->getcountryid($payment_country);
                            $payment_region_state = $this->getCell($xldata, $i, 33);
                            $state_zone_id=$this->model_sale_order->getstatezoneid($payment_region_state);

                            //4.shipping details
                            $shipping_firstname = $this->getCell($xldata, $i, 34);
                            $shipping_lastname = trim($this->getCell($xldata, $i, 35));
                            $shipping_company = $this->getCell($xldata, $i, 36);
                            $shipping_address1 = $this->getCell($xldata, $i, 37);
                            $shipping_address2 = $this->getCell($xldata, $i, 38);
                            $shipping_city = $this->getCell($xldata, $i, 39);
                            $shipping_postcode = $this->getCell($xldata, $i, 40);
                            $shipping_country = $this->getCell($xldata, $i, 41);
                            $shipping_region_state = $this->getCell($xldata, $i, 42);

                            //5.Totals..
                            //order Details..
                            $shipping_method = $this->getCell($xldata, $i, 43);
                            $payment_method = $this->getCell($xldata, $i, 44);
                            $coupon = $this->getCell($xldata, $i, 45);
                            $voucher = $this->getCell($xldata, $i, 46);
                            $reward = $this->getCell($xldata, $i, 47);
                            $order_status = $this->getCell($xldata, $i, 48);
                            $order_status_id=$this->model_sale_order->getorderstatusid($order_status);
                            $comment = $this->getCell($xldata, $i, 49);
                            $affiliate = $this->getCell($xldata, $i, 50);

                            /*$date_added = $this->getCell($xldata, $i, 54);
                            $date = str_replace('/', '-',$date_added);
                            $date_added_valuechange = date('Y-m-d H:i:s', strtotime($date));*/


                            $custom_language_id=is_numeric($this->config->get('config_language_id'))?$this->config->get('config_language_id'):1;

                            if($invoice_no!=='') {//validation of empty fields...........
                                $temp++;$b=0; $option1=0;
                                $order_array[$temp]['invoice_no'] = $invoice_no;
                                $invoice_prefix = $this->config->get('config_invoice_prefix');
                                // $store_id = $this->config->get('config_store_id');
                                $store_id = 0;
                                $store_name = $this->config->get('config_name');
                                if ($store_id) {
                                    $store_url = $this->config->get('config_url');
                                } else {
                                    $store_url = HTTP_SERVER;
                                }

                                $order_array[$temp]['invoice_prefix'] = $invoice_prefix;
                                $order_array[$temp]['store_id'] = $store_id;
                                $order_array[$temp]['store_name'] = $store_name;
                                $order_array[$temp]['store_url'] = $store_url;

                                $order_array[$temp]['customer_id'] = '';
                                $order_array[$temp]['customer_group_id'] = $customer_Group_id;

                                $order_array[$temp]['firstname'] = $firstname;
                                $order_array[$temp]['lastname'] = $lastname;
                                $order_array[$temp]['email'] = $email;
                                $order_array[$temp]['telephone'] = $telephone;
                                $order_array[$temp]['fax'] = $fax;
//                                                        $order_array['custom_field'] = $custom_field;
                                $order_array[$temp]['payment_firstname'] = $pyment_firstname;
                                $order_array[$temp]['payment_lastname'] = $payment_lastname;
                                $order_array[$temp]['payment_company'] = $pyment_company;
                                $order_array[$temp]['payment_address_1'] = $payment_dddress1;
                                $order_array[$temp]['payment_address_2'] = $payment_dddress2;
                                $order_array[$temp]['payment_city'] = $payment_city;
                                $order_array[$temp]['payment_postcode'] = $payment_postcode;
                                $order_array[$temp]['payment_country'] = $payment_country;
                                $order_array[$temp]['payment_country_id'] = $country_id;
                                $order_array[$temp]['payment_zone'] = $payment_region_state;
                                $order_array[$temp]['payment_zone_id'] = $state_zone_id;

                                $order_array[$temp]['payment_address_format'] = '';
//                              $order_array['payment_custom_field'] = $payment_custom_field;
                                $order_array[$temp]['payment_method'] = $payment_method;
                                /*$order_array['payment_code'] = $this->session->data['payment_method']['code'];*/
                                $order_array[$temp]['payment_code'] = '';

                                $order_array[$temp]['shipping_firstname'] = $shipping_firstname;
                                $order_array[$temp]['shipping_lastname'] = $shipping_lastname;
                                $order_array[$temp]['shipping_company'] = $shipping_company;
                                $order_array[$temp]['shipping_address_1'] = $shipping_address1;
                                $order_array[$temp]['shipping_address_2'] = $shipping_address2;
                                $order_array[$temp]['shipping_city'] = $shipping_city;
                                $order_array[$temp]['shipping_postcode'] = $shipping_postcode;
                                $order_array[$temp]['shipping_country'] = $shipping_country;
                                $order_array[$temp]['shipping_country_id'] = $country_id;
                                $order_array[$temp]['shipping_zone'] = $payment_region_state;
                                $order_array[$temp]['shipping_zone_id'] = $state_zone_id;

                                $order_array[$temp]['shipping_address_format'] = '';
//                                                        $order_array['shipping_custom_field'] =  $shipping_custom_field;
                                $order_array[$temp]['shipping_method'] = $shipping_method;
                                /* $order_array['shipping_code'] =  $this->session->data['shipping_method']['code'];*/
                                $order_array[$temp]['shipping_code'] = '';
                                $order_array[$temp]['tracking'] = '';
                                $order_array[$temp]['accept_language'] = '';
                                $order_array[$temp]['forwarded_ip'] = '';

                                $order_array[$temp]['comment'] = $comment;
                                //$order_array[$temp]['total'] = $total;
                                $order_array[$temp]['order_status_id'] = $order_status_id;

                                $order_array[$temp]['affiliate_id'] = 0;
                                $order_array[$temp]['commission'] = 0.0000;
                                $order_array[$temp]['marketing_id'] = 0;
//                                                        $order_array['tracking'] =  $tracking ;
                                $order_array[$temp]['language_id'] = $custom_language_id;

                                $order_array[$temp]['currency_id'] = $currency['currency_id'];
                                $order_array[$temp]['currency_code'] = $currency['code'];
                                $order_array[$temp]['currency_value'] = $currency['value'];
                                $order_array[$temp]['ip'] = $ip;
//                                                        $order_array['forwarded_ip'] = $forwarded_ip  ;
                                $order_array[$temp]['user_agent'] = $user_agent;
//                                                        $order_array['accept_language'] = $accept_language  ;
                                // $order_array[$temp]['date_added'] = $date_added_valuechange;
                                //                                                        $order_array['date_modified'] = $date_modified  ;

                                
                                if($this->getCell($xldata, $i, 13)!=='')                              
                                 {
		                                	$order_option_data = array();
			                                $order_option_data[] = array(
			                                    'product_option_id' => $product_option_id,
			                                    'product_option_value_id' => $product_option_value_id,
			                                    'option_id' => $option_id,
			                                    'option_value_id' => $option_value_id,
			                                    'name' => $optionname,
			                                    'value' => $optionvalue,
			                                    'type' => $optiontype
			                                );
			
			                                // $order_array['products'] = array();
			                                $order_array[$temp]['products'][$option1] = array(
			                                    'product_id' => $product_id,
			                                    'name' => $product,
			                                    'price' => $product_details['price'],
			                                    'model' => $product_details['model'],
			                                    'quantity' => $quantity,
			                                    'total' => $total,
			                                    'tax' => 0.0000,
			                                    'reward' => $reward_point_total,
			                                    'option' => $order_option_data
			                                );
								
                                }
								else 
									{
				 								$order_array[$temp]['products'][$option1] = array(
			                                    'product_id' => $product_id,
			                                    'name' => $product,
			                                    'price' => $product_details['price'],
			                                    'model' => $product_details['model'],
			                                    'quantity' => $quantity,
			                                    'total' => $total,
			                                    'tax' => 0.0000,
			                                    'reward' => $reward_point_total
												);
									}
                                
                    
                                $order_data['vouchers'] = array();
                                $order_array[$temp]['vouchers'][] = array(
                                    'description' => $description,
                                    'code' => $vouchercode,
                                    'from_name' => $senders_name,
                                    'from_email' => $senders_email,
                                    'to_name' => $recipient_name,
                                    'to_email' => $recipient_email,
                                    'voucher_theme_id' => $gift_certificate_theme_id,
                                    'message' => $message,
                                    'amount' => $amount
                                );
                                $order_array[$temp]['totals']=array();

                                $order_array[$temp]['totals'][$b] = array(
                                    'code' => $this->getCell($xldata, $i, 51),
                                    'title' => $this->getCell($xldata, $i, 52),
                                    'value' => $this->getCell($xldata, $i, 53),
                                    'sort_order' => ''
                                );
                                $b++;                               
                            }//validation of empty fields....
                           
                           else {
										     if($this->getCell($xldata, $i, 10)!=='')
										     {	
												 $order_option_data1=array();
												 
												  $order_option_data1[] = array(
												'product_option_id' => $product_option_id,
												'product_option_value_id' => $product_option_value_id,
												'option_id' => $option_id,
												'option_value_id' => $option_value_id,
												'name' => $optionname,
												'value' => $optionvalue,
												'type' => $optiontype
												 );						
											    $option1++;
										        $order_array_products_count = array(
													'product_id' => $product_id,
													'name' => $product,
													'price' => $product_details['price'],
													'model' => $product_details['model'],
													'quantity' => $quantity,
													'total' => $total,
													'tax' => 0.0000,
													'reward' => $reward_point_total,
													'option' => $order_option_data1
												);
												$order_array[$temp]['products'][$option1]=$order_array_products_count;										
											 }	
											 							
		                                     elseif($this->getCell($xldata, $i, 13)!=='')
										 	 {
												$order_option_data2 = array(
												'product_option_id' => $product_option_id,
												'product_option_value_id' => $product_option_value_id,
												'option_id' => $option_id,
												'option_value_id' => $option_value_id,
												'name' => $optionname,
												'value' => $optionvalue,
												'type' => $optiontype
												 );
		
												 array_push($order_array[$temp]['products'][$option1]['option'],$order_option_data2);									
										
											}	                        
	                        
	                             if($this->getCell($xldata, $i, 51)!=='')
                                {
                                $getlooping_totals = array(
                                    'code' => $this->getCell($xldata, $i, 51),
                                    'title' => $this->getCell($xldata, $i, 52),
                                    'value' => $this->getCell($xldata, $i, 53),
                                    'sort_order' => ''
                                );
                                $order_array[$temp]['totals'][$b]=$getlooping_totals;
                                $b++;
                                }
								
								//*****************************************			
				                if("Total" == $this->getCell($xldata, $i, 52))
				                {				
				                    $order_array[$temp]['total'] = $this->getCell($xldata, $i, 53);//print_r($Total);
				                    //echo $Flat_Shipping_Rate;exit;
				                }
								
								//*****************************************
						}                            
                            

                        } // Excel row loop end

                          //print_r($order_array);exit;

                        $order_list_data=$order_array;

                    }
                    else
                    {
                        $excel_field_error = 1;
                    }
 }//opc version check end

                } //file upload end

                if(!$excel_field_error)
                {

                    $data['sampletabledata']= $order_list_data;

                    $_SESSION['orderlist'] = $order_list_data;
                }

            } // import form validate end

        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['errorfile'])) {
            $data['error_file'] = $this->error['errorfile'];
        } else {
            $data['error_file'] = '';
        }

        if (isset($this->error['errorfile_opcversion'])) {
            $data['error_file_opcversion'] = $this->error['errorfile_opcversion'];
        } else {
            $data['error_file_opcversion'] = '';
        }

        if($excel_field_error)
        {
            $data['error_fields'] = 'Upload like our Sample Excel File';
        }
        else
        {
            $data['error_fields'] = '';
        }

        /* $this->load->model('design/layout');
       $data['layouts']=$this->model_design_layout->getLayouts();*/

        $data['header']=$this->load->controller('common/header');
        $data['footer']=$this->load->controller('common/footer');
        $data['column_left']=$this->load->controller('common/column_left');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $data['base'] = $this->config->get('config_ssl');
        } else {
            $data['base'] = $this->config->get('config_url');
        }

        $this->response->setOutput($this->load->view('sale/orders_import.tpl',$data));

    }

    public function importproducts(){

        unset($_SESSION['orderlist']);
        $url = '';
        $this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    function getCell(&$worksheet, $row, $col, $default_val = '') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
    }

    public function productsampleexport()
    {
        /* Include PHPExcel class */
        //chdir('../system/library/PHPExcel');
        //require_once( 'Classes/PHPExcel.php' );
        //chdir('../../../admin');

        require_once('../system/library/PHPExcel/Classes/PHPExcel.php' );

        // Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number
        $rowCount = 1;

        /* Add Heading Row */

        //1.customer details..
//        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Order_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Invoice_no');

        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Currency');
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Customer');
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Customer Group');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Customer First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Customer Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Customer E-Mail');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Customer Telephone');
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Customer Fax');

        //2.produtcs..
        //products
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Product');
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Total');
        //products option
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Product option Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'Product option Value');
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'Product option Type');
        //voucher
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, 'Voucher Description');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'Voucher Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, 'Voucher Recipient Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'Voucher Recipient Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, 'Voucher Senders Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, 'Voucher Senders Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, 'Voucher Gift Certificate Theme');
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'Voucher Message');
        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, 'Voucher Amount');
        //3.payment details
//        $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, 'Choose Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, 'payment First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, 'payment Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, 'payment Company');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, 'payment Address 1');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, 'payment Address 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, 'payment City');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, 'payment Postcode');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, 'payment Country');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, 'payment Region / State');

        //4.shipping details
//        $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, 'Choose Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$rowCount, 'Shipping First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, 'Shipping Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, 'Shipping Company');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, 'Shipping Address 1');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, 'Shipping Address 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, 'Shipping City');
        $objPHPExcel->getActiveSheet()->SetCellValue('AN'.$rowCount, 'Shipping Postcode');
        $objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, 'Shipping Country');
        $objPHPExcel->getActiveSheet()->SetCellValue('AP'.$rowCount, 'Shipping Region / State');

        //5.Totals..
        //order Details..
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, 'Shipping Method');
        $objPHPExcel->getActiveSheet()->SetCellValue('AR'.$rowCount, 'Payment Method');
        $objPHPExcel->getActiveSheet()->SetCellValue('AS'.$rowCount, 'Coupon');
        $objPHPExcel->getActiveSheet()->SetCellValue('AT'.$rowCount, 'Voucher');
        $objPHPExcel->getActiveSheet()->SetCellValue('AU'.$rowCount, 'Reward');
        $objPHPExcel->getActiveSheet()->SetCellValue('AV'.$rowCount, 'Order Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AW'.$rowCount, 'Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('AX'.$rowCount, 'Affiliate');
        $objPHPExcel->getActiveSheet()->SetCellValue('AY'.$rowCount, 'Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('AZ'.$rowCount, 'Title');
        $objPHPExcel->getActiveSheet()->SetCellValue('BA'.$rowCount, 'Value');
        $objPHPExcel->getActiveSheet()->SetCellValue('BB'.$rowCount, 'Date_Added');


        header("Content-Type: text/csv; charset=utf-8");
        header('Content-Disposition: attachment;filename="order_list_'.date("Y m d G i s").'.csv"');
        //header('Content-Disposition: attachment;filename="category_list_'.date("Y m d G i s").'.xlsx"');
        header('Cache-Control: max-age=0');

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'CSV');
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        //$objWriter->save('some_excel_file.xlsx');

        /* Download CsV file in downloads */
        $objWriter->save('php://output');

//        chdir('../../..');
    }
    protected function validateImport() {
        /*if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }*/
        if(!$_POST['opcversion']){
	     $this->error['errorfile_opcversion'] = $this->language->get('Please Select upload Opencart version');
        }

        if (!$this->request->files['file']['tmp_name']) {
            $this->error['errorfile'] = $this->language->get('Please Upload a Excel/CSV file');
        }
        elseif($_FILES["file"]["name"])
        {
            $allowedExts = array("csv", "xlsx", "xls");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if(!in_array($extension, $allowedExts))
                $this->error['errorfile'] = $this->language->get('Please Upload a Excel/CSV file');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

//orders Export
    public function orderexport() {
    	
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}   
		   
		   $filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified
			
		);

		
        
        $orders = array();
        
        $orders_column=array();
        
        $this->load->model('sale/order');
        
		
        $results = $this->model_sale_order->gettotalOrdersexport($filter_data); 
		
        $orders_list = array();
		
		$temp_count = 1;
		$product_option_count = 1;
		
        	foreach ($results as $result) {
        		$voucher_count = $temp_count;
				$payment_temp =	$temp_count;
				$total_temp = $temp_count;
				$temp_j = 0;
        		$customer_group_name = $this->model_sale_order->getcustomer_group_name($result['customer_group_id']);
        		//start customer detail new temp variable set ( common field )
				$orders_list[$temp_count]['invoice_no']            = $result['invoice_no'];
				$orders_list[$temp_count]['currency_code']          = $result['currency_code'];
				$orders_list[$temp_count]['customer']               = '';
				$orders_list[$temp_count]['customer_group']          = $customer_group_name;
				//customer
				$orders_list[$temp_count]['firstname']          = $result['firstname'];
				$orders_list[$temp_count]['lastname']          = $result['lastname'];
				$orders_list[$temp_count]['email']          = $result['email'];
				$orders_list[$temp_count]['telephone']          = $result['telephone'];
				$orders_list[$temp_count]['fax']          = $result['fax']; 
				// process products
				$export_products = $this->model_sale_order->get_exportorder_product($result['order_id']);
					foreach ($export_products as $export_product) {
						if($temp_j == 0){
							$orders_list[$temp_count]['product']           = $export_product['name'];				
							$orders_list[$temp_count]['quantity']          = $export_product['quantity'];
							$orders_list[$temp_count]['total']         	 = $export_product['total'];
					   		$temp_j++;	
						}
						else{
				            $orders_list[$temp_count]['invoice_no']            = '';
							$orders_list[$temp_count]['currency_code']          = '';
							$orders_list[$temp_count]['customer']               = '';
							$orders_list[$temp_count]['customer_group']          = '';
							//customer
							$orders_list[$temp_count]['firstname']          = '';
							$orders_list[$temp_count]['lastname']          = '';
							$orders_list[$temp_count]['email']          = '';
							$orders_list[$temp_count]['telephone']          = '';
							$orders_list[$temp_count]['fax']          = '';
					        $orders_list[$temp_count]['product']          = $export_product['name'];				
							$orders_list[$temp_count]['quantity']          = $export_product['quantity'];
							$orders_list[$temp_count]['total']          = $export_product['total'];
							$temp_j++;	
						}
						
						
						// process options
						$export_products_options = $this->model_sale_order->get_exportorder_product_option($result['order_id'],$export_product['order_product_id']);
						if(!empty($export_products_options)){
							$temp_i = 0;
							foreach ($export_products_options as $export_products_option) {
								if($temp_i == 0){
									$orders_list[$temp_count]['option_name']	=$export_products_option['name'];
									$orders_list[$temp_count]['option_value']	= $export_products_option['value'];
									$orders_list[$temp_count]['option_type']	=$export_products_option['type'];
									$temp_i++;
									$temp_count++;
								}else{
									$orders_list[$temp_count]['invoice_no']            = '';
									$orders_list[$temp_count]['currency_code']          = '';
									$orders_list[$temp_count]['customer']               = '';
									$orders_list[$temp_count]['customer_group']          = '';
									//customer
									$orders_list[$temp_count]['firstname']          = '';
									$orders_list[$temp_count]['lastname']          = '';
									$orders_list[$temp_count]['email']          = '';
									$orders_list[$temp_count]['telephone']          = '';
									$orders_list[$temp_count]['fax']          = '';
									$orders_list[$temp_count]['product']          = '';
									$orders_list[$temp_count]['quantity']          = '';
									$orders_list[$temp_count]['total']          = '';
									$orders_list[$temp_count]['option_name']	=$export_products_option['name'];
									$orders_list[$temp_count]['option_value']	= $export_products_option['value'];
									$orders_list[$temp_count]['option_type']	=$export_products_option['type'];							
									$temp_i++;
									$temp_count++;
								}
							} // eo option loop
							////$temp_count++;
					  	}// !empty check 
					  	else{
					  		$orders_list[$temp_count]['option_name']	='';
							$orders_list[$temp_count]['option_value']	= '';
							$orders_list[$temp_count]['option_type']	='';
							$temp_count++;
					  	}  
				  	} // eo product loop

				  	$temp_v = 0;
				  	// process vouchers
						$voucher_details = $this->model_sale_order->getvoucher_detatil($result['order_id']);
						if(!empty($voucher_details))
						{
							foreach ($voucher_details as $voucher_detail) {
								$voucher_theme_name = $this->model_sale_order->getvoucher_theme_name($voucher_detail['voucher_theme_id']);
								if($temp_v == 0){
								    $orders_list[$voucher_count]['voucher_description']   	= $voucher_detail['description'];
									$orders_list[$voucher_count]['code']						= $voucher_detail['code'];
									$orders_list[$voucher_count]['to_name']					= $voucher_detail['to_name'];
									$orders_list[$voucher_count]['to_email']		   		    = $voucher_detail['to_email'];
									$orders_list[$voucher_count]['from_name']				= $voucher_detail['from_name'];
									$orders_list[$voucher_count]['from_email']				= $voucher_detail['from_email'];
									$orders_list[$voucher_count]['gift_certificate_theme']	= $voucher_theme_name;
									$orders_list[$voucher_count]['message']					= $voucher_detail['message'];
									$orders_list[$voucher_count]['amount']					= $voucher_detail['amount'];
									$temp_v++;
									$voucher_count++;							
								}
								else{
									$orders_list[$voucher_count]['invoice_no']            = '';
									$orders_list[$voucher_count]['currency_code']          = '';
									$orders_list[$voucher_count]['customer']               = '';
									$orders_list[$voucher_count]['customer_group']          = '';
									//customer
									$orders_list[$voucher_count]['firstname']          = '';
									$orders_list[$voucher_count]['lastname']          = '';
									$orders_list[$voucher_count]['email']          = '';
									$orders_list[$voucher_count]['telephone']          = '';
									$orders_list[$voucher_count]['fax']          = '';
									$orders_list[$voucher_count]['product']          = '';
					
									$orders_list[$voucher_count]['quantity']          = '';
									$orders_list[$voucher_count]['total']          = '';
									$orders_list[$voucher_count]['option_name']	='';
									$orders_list[$voucher_count]['option_value']	= '';
									$orders_list[$voucher_count]['option_type']	='';
									
									$orders_list[$voucher_count]['voucher_description']   	= $voucher_detail['description'];
									$orders_list[$voucher_count]['code']						= $voucher_detail['code'];
									$orders_list[$voucher_count]['to_name']					= $voucher_detail['to_name'];
									$orders_list[$voucher_count]['to_email']		   		    = $voucher_detail['to_email'];
									$orders_list[$voucher_count]['from_name']				= $voucher_detail['from_name'];
									$orders_list[$voucher_count]['from_email']				= $voucher_detail['from_email'];
									$orders_list[$voucher_count]['gift_certificate_theme']	= $voucher_theme_name;
									$orders_list[$voucher_count]['message']					= $voucher_detail['message'];
									$orders_list[$voucher_count]['amount']					= $voucher_detail['amount'];
									$temp_v++;
									$voucher_count++;
								} // eo else
							} // eo voucher foreach
						} // eo empty check
						else{
					            $orders_list[$voucher_count]['voucher_description']   	= '';
								$orders_list[$voucher_count]['code']						= '';
								$orders_list[$voucher_count]['to_name']					= '';
								$orders_list[$voucher_count]['to_email']		   		    = '';
								$orders_list[$voucher_count]['from_name']				= '';
								$orders_list[$voucher_count]['from_email']				= '';
								$orders_list[$voucher_count]['gift_certificate_theme']	= '';
								$orders_list[$voucher_count]['message']					= '';
								$orders_list[$voucher_count]['amount']					= '';
								$voucher_count++;
			 	 		}
				 
				 	$order_status_name = $this->model_sale_order->getorder_status_name($result['order_status_id']); 	
				 	//payment
					$orders_list[$payment_temp]['payment_firstname']				= $result['payment_firstname'];
					$orders_list[$payment_temp]['payment_lastname']					= $result['payment_lastname'];
					$orders_list[$payment_temp]['payment_company']					= $result['payment_company'];
					$orders_list[$payment_temp]['payment_address_1']				= $result['payment_address_1'];
					$orders_list[$payment_temp]['payment_address_2']				= $result['payment_address_2'];
					$orders_list[$payment_temp]['payment_city']				   	    = $result['payment_city'];
					$orders_list[$payment_temp]['payment_postcode']					= $result['payment_postcode'];
					$orders_list[$payment_temp]['payment_country']					= $result['payment_country'];
					$orders_list[$payment_temp]['payment_zone']				    	= $result['payment_zone'];
					//shipping
					$orders_list[$payment_temp]['shipping_firstname']				= $result['shipping_firstname'];
					$orders_list[$payment_temp]['shipping_lastname']				= $result['shipping_lastname'];
					$orders_list[$payment_temp]['shipping_company']					= $result['shipping_company'];
					$orders_list[$payment_temp]['shipping_address_1']				= $result['shipping_address_1'];
					$orders_list[$payment_temp]['shipping_address_2']				= $result['shipping_address_2'];
					$orders_list[$payment_temp]['shipping_city']				    = $result['shipping_city'];
					$orders_list[$payment_temp]['shipping_postcode']				= $result['shipping_postcode'];
					$orders_list[$payment_temp]['shipping_country']					= $result['shipping_country'];
					$orders_list[$payment_temp]['shipping_zone']				    = $result['shipping_zone'];
					$orders_list[$payment_temp]['shipping_method']					= $result['shipping_method'];
					$orders_list[$payment_temp]['payment_method']					= $result['payment_method'];
					
					$orders_list[$payment_temp]['coupon']				   		    = (isset($result['coupon']) ? $result['coupon'] : "");
					$orders_list[$payment_temp]['voucher']							= (isset($result['voucher']) ? $result['voucher'] : "");
					$orders_list[$payment_temp]['reward']							= (isset($result['reward']) ? $result['reward'] : "");			
					$orders_list[$payment_temp]['order_status']						= $order_status_name;
					$orders_list[$payment_temp]['comment']				  		    = $result['comment'];
					$orders_list[$payment_temp]['affiliate']				   	    = (isset($result['affiliate']) ? $result['affiliate'] : "");
				
					$temp_t = 0;
					$export_totals = $this->model_sale_order->get_exportorder_total($result['order_id']); 
				 	foreach ($export_totals as $export_total) {
							$code = $export_total['code'];
							$title = $export_total['title'];
							$value = $export_total['value'];
							if($temp_t == 0){
								$temp_count++;
								$orders_list[$total_temp]['total_code']    = $code;
								$orders_list[$total_temp]['total_title']   = $title;
								$orders_list[$total_temp]['total_value']   = $value;
								$temp_t++;
		                    }
		                    else{
								$orders_list[$total_temp]['invoice_no']            = '';
								$orders_list[$total_temp]['currency_code']          = '';
								$orders_list[$total_temp]['customer']               = '';
								$orders_list[$total_temp]['customer_group']          = '';
								//customer
								$orders_list[$total_temp]['firstname']          = '';
								$orders_list[$total_temp]['lastname']          = '';
								$orders_list[$total_temp]['email']          = '';
								$orders_list[$total_temp]['telephone']          = '';
								$orders_list[$total_temp]['fax']          = '';
								
																
								if(isset($orders_list[$total_temp]['product'])){
									$orders_list[$total_temp]['product'] = $orders_list[$total_temp]['product'];	
								}else{
									$orders_list[$total_temp]['product'] = '';
								}
								
								if(isset($orders_list[$total_temp]['quantity'])){
									$orders_list[$total_temp]['quantity'] = $orders_list[$total_temp]['quantity'];	
								}else{
									$orders_list[$total_temp]['quantity'] = '';
								}
								
								if(isset($orders_list[$total_temp]['total'])){
									$orders_list[$total_temp]['total'] = $orders_list[$total_temp]['total'];	
								}else{
									$orders_list[$total_temp]['total'] = '';
								}
								
							
								
								
								
								if(isset($orders_list[$total_temp]['option_name'])){
									$orders_list[$total_temp]['option_name'] = $orders_list[$total_temp]['option_name'];	
								}else{
									$orders_list[$total_temp]['option_name'] = '';
								}
								
								
								if(isset($orders_list[$total_temp]['option_type'])){
									$orders_list[$total_temp]['option_type'] = $orders_list[$total_temp]['option_type'];	
								}else{
									$orders_list[$total_temp]['option_type'] = '';
								}
								
								if(isset($orders_list[$total_temp]['option_value'])){
									$orders_list[$total_temp]['option_value'] = $orders_list[$total_temp]['option_value'];	
								}else{
									$orders_list[$total_temp]['option_value'] = '';
								}
								
								
								
	               	  	        $orders_list[$total_temp]['voucher_description']   	= '';
								$orders_list[$total_temp]['code']						= '';
								$orders_list[$total_temp]['to_name']					= '';
								$orders_list[$total_temp]['to_email']		   		    = '';
								$orders_list[$total_temp]['from_name']				= '';
								$orders_list[$total_temp]['from_email']				= '';
								$orders_list[$total_temp]['gift_certificate_theme']	= '';
								$orders_list[$total_temp]['message']					= '';
								$orders_list[$total_temp]['amount']					= '';
								$orders_list[$total_temp]['payment_firstname']				= '';
								$orders_list[$total_temp]['payment_lastname']					= '';
								$orders_list[$total_temp]['payment_company']					= '';
								$orders_list[$total_temp]['payment_address_1']				= '';
								$orders_list[$total_temp]['payment_address_2']				= '';
								$orders_list[$total_temp]['payment_city']				   	    = '';
								$orders_list[$total_temp]['payment_postcode']					= '';
								$orders_list[$total_temp]['payment_country']					= '';
								$orders_list[$total_temp]['payment_zone']				    	= '';
								//shipping
								$orders_list[$total_temp]['shipping_firstname']				= '';
								$orders_list[$total_temp]['shipping_lastname']				= '';
								$orders_list[$total_temp]['shipping_company']					= '';
								$orders_list[$total_temp]['shipping_address_1']				= '';
								$orders_list[$total_temp]['shipping_address_2']				= '';
								$orders_list[$total_temp]['shipping_city']				    = '';
								$orders_list[$total_temp]['shipping_postcode']				= '';
								$orders_list[$total_temp]['shipping_country']					= '';
								$orders_list[$total_temp]['shipping_zone']				    = '';
								$orders_list[$total_temp]['shipping_method']					= '';
								$orders_list[$total_temp]['payment_method']					= '';
								
								$orders_list[$total_temp]['coupon']				   		    = '';
								$orders_list[$total_temp]['voucher']							= '';
								$orders_list[$total_temp]['reward']							= '';
								$orders_list[$total_temp]['order_status']						= '';
								$orders_list[$total_temp]['comment']				  		    = '';
								$orders_list[$total_temp]['affiliate']				   	    = '';
								
						        $orders_list[$total_temp]['total_code']    = $code;
								$orders_list[$total_temp]['total_title']   = $title;
								$orders_list[$total_temp]['total_value']   = $value;
								$temp_t++;
                        	}
							$total_temp++;
					  	} 


				 
				
				
//print_r($orders_list);exit;
$temp_count++;
}//Main loop end	
		

  //print_r($orders_list);exit;
      
        $orders_column = array('Invoice_no', 'Currency', 'Customer', 'Customer Group', 'Customer First Name', 'Customer Last Name', 'Customer E-Mail', 'Customer Telephone', 'Customer Fax', 'Product', 'Quantity', 'Total', 'Product option Name','Product option Value','Product option Type','Voucher Description', 'Voucher Code', 'Voucher Recipient Name','Voucher Recipient Email','Voucher Senders Name','Voucher Senders Email','Voucher Gift Certificate Theme','Voucher Message','Voucher Amount','payment First Name','payment Last Name','payment Company','payment Address 1','payment Address 2','payment City','payment Postcode','payment Country','payment Region / State','Shipping First Name','Shipping Last Name','Shipping Company','Shipping Address 1','Shipping Address 2','Shipping City','Shipping Postcode','Shipping Country','Shipping Region / State','Shipping Method','Payment Method','Coupon','Voucher','Reward','Order Status','Comment','Affiliate','Code','Title','Value');
            
      $orders[0]=   $orders_column;
        
        foreach($orders_list as $orders_row)
        {
            $orders[]=   $orders_row;
        } 
    
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename="Order_list_'.date("Y m d G i s").'.csv"');
		$out = fopen('php://output', 'w');

		foreach ($orders as $fields) {
		    fputcsv($out, $fields);
		}
		
		fclose($out);
	}

    


	public function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
		$data['text_product'] = $this->language->get('text_product');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_order_detail'] = $this->language->get('text_order_detail');

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$data['entry_coupon'] = $this->language->get('entry_coupon');
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_order_status'] = $this->language->get('entry_order_status');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_refresh'] = $this->language->get('button_refresh');
		$data['button_product_add'] = $this->language->get('button_product_add');
		$data['button_voucher_add'] = $this->language->get('button_voucher_add');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['tab_order'] = $this->language->get('tab_order');
		$data['tab_customer'] = $this->language->get('tab_customer');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_shipping'] = $this->language->get('tab_shipping');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_voucher'] = $this->language->get('tab_voucher');
		$data['tab_total'] = $this->language->get('tab_total');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		if (!empty($order_info)) {
			$data['order_id'] = $this->request->get['order_id'];
			$data['store_id'] = $order_info['store_id'];
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

			$data['customer'] = $order_info['customer'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['customer_group_id'] = $order_info['customer_group_id'];
			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];

			$this->load->model('customer/customer');

			$data['addresses'] = $this->model_customer_customer->getAddresses($order_info['customer_id']);

			$data['payment_firstname'] = $order_info['payment_firstname'];
			$data['payment_lastname'] = $order_info['payment_lastname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address_1'] = $order_info['payment_address_1'];
			$data['payment_address_2'] = $order_info['payment_address_2'];
			$data['payment_city'] = $order_info['payment_city'];
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_country_id'] = $order_info['payment_country_id'];
			$data['payment_zone_id'] = $order_info['payment_zone_id'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['payment_code'] = $order_info['payment_code'];

			$data['shipping_firstname'] = $order_info['shipping_firstname'];
			$data['shipping_lastname'] = $order_info['shipping_lastname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address_1'] = $order_info['shipping_address_1'];
			$data['shipping_address_2'] = $order_info['shipping_address_2'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_country_id'] = $order_info['shipping_country_id'];
			$data['shipping_zone_id'] = $order_info['shipping_zone_id'];
			$data['shipping_custom_field'] = $order_info['shipping_custom_field'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['shipping_code'] = $order_info['shipping_code'];

			// Products
			$data['order_products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'reward'     => $product['reward']
				);
			}

			// Vouchers
			$data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';

			$data['order_totals'] = array();

			$order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');

				if ($start && $end) {
					$data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
				}
			}

			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment'] = $order_info['comment'];
			$data['affiliate_id'] = $order_info['affiliate_id'];
			$data['affiliate'] = $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'];
			$data['currency_code'] = $order_info['currency_code'];
		} else {
			$data['order_id'] = 0;
			$data['store_id'] = 0;
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();

			$data['addresses'] = array();

			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';

			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';

			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();

			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
		}

		// Stores
		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}

		// Customer Groups
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Custom Fields
		$this->load->model('customer/custom_field');

		$data['custom_fields'] = array();

		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);

		$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_customer_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['voucher_min'] = $this->config->get('config_voucher_min');

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		// API login
		$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
		
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_form', $data));
	}

	public function info() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_customer_detail'] = $this->language->get('text_customer_detail');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_customer_group'] = $this->language->get('text_customer_group');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_invoice'] = $this->language->get('text_invoice');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_affiliate'] = $this->language->get('text_affiliate');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_account_custom_field'] = $this->language->get('text_account_custom_field');
			$data['text_payment_custom_field'] = $this->language->get('text_payment_custom_field');
			$data['text_shipping_custom_field'] = $this->language->get('text_shipping_custom_field');
			$data['text_browser'] = $this->language->get('text_browser');
			$data['text_ip'] = $this->language->get('text_ip');
			$data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
			$data['text_user_agent'] = $this->language->get('text_user_agent');
			$data['text_accept_language'] = $this->language->get('text_accept_language');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_history_add'] = $this->language->get('text_history_add');
			$data['text_loading'] = $this->language->get('text_loading');

			$data['column_product'] = $this->language->get('column_product');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['entry_order_status'] = $this->language->get('entry_order_status');
			$data['entry_notify'] = $this->language->get('entry_notify');
			$data['entry_override'] = $this->language->get('entry_override');
			$data['entry_comment'] = $this->language->get('entry_comment');

			$data['help_override'] = $this->language->get('help_override');

			$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['button_shipping_print'] = $this->language->get('button_shipping_print');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_generate'] = $this->language->get('button_generate');
			$data['button_reward_add'] = $this->language->get('button_reward_add');
			$data['button_reward_remove'] = $this->language->get('button_reward_remove');
			$data['button_commission_add'] = $this->language->get('button_commission_add');
			$data['button_commission_remove'] = $this->language->get('button_commission_remove');
			$data['button_history_add'] = $this->language->get('button_history_add');
			$data['button_ip_add'] = $this->language->get('button_ip_add');

			$data['tab_history'] = $this->language->get('tab_history');
			$data['tab_additional'] = $this->language->get('tab_additional');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['edit'] = $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);

			$data['token'] = $this->session->data['token'];

			$data['order_id'] = $this->request->get['order_id'];

			$data['store_id'] = $order_info['store_id'];
			$data['store_name'] = $order_info['store_name'];
			
			if ($order_info['store_id'] == 0) {
				$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			} else {
				$data['store_url'] = $order_info['store_url'];
			}

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];

			if ($order_info['customer_id']) {
				$data['customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], true);
			} else {
				$data['customer'] = '';
			}

			$this->load->model('customer/customer_group');

			$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($order_info['customer_group_id']);

			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}

			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];

			$data['shipping_method'] = $order_info['shipping_method'];
			$data['payment_method'] = $order_info['payment_method'];

			// Payment Address
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			// Shipping Address
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			// Uploaded files
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $upload_info['name'],
								'type'  => $option['type'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
							);
						}
					}
				}

				$data['products'][] = array(
					'order_product_id' => $product['order_product_id'],
					'product_id'       => $product['product_id'],
					'name'    	 	   => $product['name'],
					'model'    		   => $product['model'],
					'option'   		   => $option_data,
					'quantity'		   => $product['quantity'],
					'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], true)
				);
			}

			$data['vouchers'] = array();

			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], true)
				);
			}

			$data['totals'] = array();

			$totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			$this->load->model('customer/customer');

			$data['reward'] = $order_info['reward'];

			$data['reward_total'] = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

			$data['affiliate_firstname'] = $order_info['affiliate_firstname'];
			$data['affiliate_lastname'] = $order_info['affiliate_lastname'];

			if ($order_info['affiliate_id']) {
				$data['affiliate'] = $this->url->link('marketing/affiliate/edit', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], true);
			} else {
				$data['affiliate'] = '';
			}

			$data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

			$this->load->model('marketing/affiliate');

			$data['commission_total'] = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

			$this->load->model('localisation/order_status');

			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

			if ($order_status_info) {
				$data['order_status'] = $order_status_info['name'];
			} else {
				$data['order_status'] = '';
			}

			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			$data['order_status_id'] = $order_info['order_status_id'];

			$data['account_custom_field'] = $order_info['custom_field'];

			// Custom Fields
			$this->load->model('customer/custom_field');

			$data['account_custom_fields'] = array();

			$filter_data = array(
				'sort'  => 'cf.sort_order',
				'order' => 'ASC'
			);

			$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'account' && isset($order_info['custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['account_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['account_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['custom_field'][$custom_field['custom_field_id']]
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name']
							);
						}
					}
				}
			}

			// Custom fields
			$data['payment_custom_fields'] = array();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['payment_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['payment_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['payment_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}

			// Shipping
			$data['shipping_custom_fields'] = array();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['shipping_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['shipping_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['shipping_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['shipping_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}

			$data['ip'] = $order_info['ip'];
			$data['forwarded_ip'] = $order_info['forwarded_ip'];
			$data['user_agent'] = $order_info['user_agent'];
			$data['accept_language'] = $order_info['accept_language'];

			// Additional Tabs
			$data['tabs'] = array();

			if ($this->user->hasPermission('access', 'extension/payment/' . $order_info['payment_code'])) {
				if (is_file(DIR_CATALOG . 'controller/extension/payment/' . $order_info['payment_code'] . '.php')) {
					$content = $this->load->controller('extension/payment/' . $order_info['payment_code'] . '/order');
				} else {
					$content = null;
				}

				if ($content) {
					$this->load->language('extension/payment/' . $order_info['payment_code']);

					$data['tabs'][] = array(
						'code'    => $order_info['payment_code'],
						'title'   => $this->language->get('heading_title'),
						'content' => $content
					);
				}
			}

			$this->load->model('extension/extension');

			$extensions = $this->model_extension_extension->getInstalled('fraud');

			foreach ($extensions as $extension) {
				if ($this->config->get($extension . '_status')) {
					$this->load->language('extension/fraud/' . $extension);

					$content = $this->load->controller('extension/fraud/' . $extension . '/order');

					if ($content) {
						$data['tabs'][] = array(
							'code'    => $extension,
							'title'   => $this->language->get('heading_title'),
							'content' => $content
						);
					}
				}
			}
			
			// The URL we send API requests to
			$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			// API login
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$data['api_id'] = $api_info['api_id'];
				$data['api_key'] = $api_info['key'];
				$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
			} else {
				$data['api_id'] = '';
				$data['api_key'] = '';
				$data['api_ip'] = '';
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('sale/order_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function createInvoiceNo() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} elseif (isset($this->request->get['order_id'])) {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$invoice_no = $this->model_sale_order->createInvoiceNo($order_id);

			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
				$this->load->model('customer/customer');

				$reward_total = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($order_id);

				if (!$reward_total) {
					$this->model_customer_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['reward'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_reward_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('customer/customer');

				$this->model_customer_customer->deleteReward($order_id);
			}

			$json['success'] = $this->language->get('text_reward_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$affiliate_total = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($order_id);

				if (!$affiliate_total) {
					$this->model_marketing_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_commission_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$this->model_marketing_affiliate->deleteTransaction($order_id);
			}

			$json['success'] = $this->language->get('text_commission_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function history() {
		$this->load->language('sale/order');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$this->load->model('sale/order');

		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/order_history', $data));
	}

	public function invoice() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_payment_address'] = $this->language->get('text_payment_address');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comment'] = $this->language->get('text_comment');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');

		$this->load->model('sale/order');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = array();

				$totals = $this->model_sale_order->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'payment_address'  => $payment_address,
					'payment_method'   => $order_info['payment_method'],
					'product'          => $product_data,
					'voucher'          => $voucher_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_invoice', $data));
	}

	public function shipping() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_shipping');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_picklist'] = $this->language->get('text_picklist');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_sku'] = $this->language->get('text_sku');
		$data['text_upc'] = $this->language->get('text_upc');
		$data['text_ean'] = $this->language->get('text_ean');
		$data['text_jan'] = $this->language->get('text_jan');
		$data['text_isbn'] = $this->language->get('text_isbn');
		$data['text_mpn'] = $this->language->get('text_mpn');
		$data['text_comment'] = $this->language->get('text_comment');

		$data['column_location'] = $this->language->get('column_location');
		$data['column_reference'] = $this->language->get('column_reference');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_weight'] = $this->language->get('column_weight');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');

		$this->load->model('sale/order');

		$this->load->model('catalog/product');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_weight = '';

					$product_info = $this->model_catalog_product->getProduct($product['product_id']);

					if ($product_info) {
						$option_data = array();

						$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

						foreach ($options as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

								if ($upload_info) {
									$value = $upload_info['name'];
								} else {
									$value = '';
								}
							}

							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $value
							);

							$product_option_value_info = $this->model_catalog_product->getProductOptionValue($product['product_id'], $option['product_option_value_id']);

							if ($product_option_value_info) {
								if ($product_option_value_info['weight_prefix'] == '+') {
									$option_weight += $product_option_value_info['weight'];
								} elseif ($product_option_value_info['weight_prefix'] == '-') {
									$option_weight -= $product_option_value_info['weight'];
								}
							}
						}

						$product_data[] = array(
							'name'     => $product_info['name'],
							'model'    => $product_info['model'],
							'option'   => $option_data,
							'quantity' => $product['quantity'],
							'location' => $product_info['location'],
							'sku'      => $product_info['sku'],
							'upc'      => $product_info['upc'],
							'ean'      => $product_info['ean'],
							'jan'      => $product_info['jan'],
							'isbn'     => $product_info['isbn'],
							'mpn'      => $product_info['mpn'],
							'weight'   => $this->weight->format(($product_info['weight'] + $option_weight) * $product['quantity'], $product_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'))
						);
					}
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_shipping', $data));
	}
}
