<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller
{ 
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('search_model');
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020','0','1','2','3','4','5','6','7','8','9','@','www','http://','https://','.com','.uk','.co.uk','.gov.uk','.me.uk','.ac.uk','.org.uk','.Itd.uk','.mod.uk ','.mil.uk','.net.uk','.nic.uk','.nhs.uk','.pic.uk','.sch.uk','.pic.uk:','.info','.io','.cloud','.online','.ai','.net','.org');
		error_reporting(0);
		if($this->session->userdata('user_id')){
			$user_id = $this->session->userdata('user_id');
			if(!empty($user_id)){
				$user_profile = $this->common_model->get_single_data('users',array('id'=>$user_id));

				if(empty($user_profile)){
					$this->session->sess_destroy();
					redirect('login');
				}
			}
		}
	}

	public function serviceCheckout($value=''){
		$sId = $this->input->post('service_id');
		$prices = 0;
		$totalPrice = 0;
		$exsId = !empty($this->input->post('selected_exsIds')) ? $this->input->post('selected_exsIds') : '';
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));
		$data['service_fee'] = $setting['service_fees'];
		$data['service_details'] = $this->common_model->GetSingleData('my_services',['id'=>$sId]);
		if(!empty($exsId)){
			$data['ex_services'] = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $sId);	
		}else{
			$data['ex_services'] = [];
		}
		
		if(!empty($data['ex_services']) && count($data['ex_services']) > 0){
			$prices = array_column($data['ex_services'], 'price');
			$totalPrice = array_sum($prices);	
		}
		$data['totalPrice'] = $totalPrice + $data['service_details']['price'];
		$this->load->view('site/checkout',$data);
	}
}