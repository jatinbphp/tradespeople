<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$user_id = $this->session->userdata('user_id');
		if(!empty($user_id)){
			$user_profile = $this->common_model->get_single_data('users',array('id'=>$user_id));

			if(empty($user_profile)){
				$this->session->sess_destroy();
				redirect('login');
			}
		}
	}
	
	public function auto_update_paln($id){
		
		$data = $this->common_model->get_single_data('invoice',array('id'=>$id));
		
		
		
		if($data){
			$arr =  explode('&',$data['data']);
			
			if($arr[0]==1){
				$page['package_name'] = $arr[1];
				$page['startdate'] = $arr[2];
				$page['enddate'] = $arr[3];
				$page['amount'] = $arr[4];
				$page['transId'] = $arr[5];
				$page['userId'] = $arr[6];
				$page['planId'] = $arr[7];
				$page['msg'] = $arr[8];
				
				$this->load->view('site/invoice-update-plan',$page);
			} else if($arr[0]==2){
				$page['method'] = $arr[1];
				$page['amount'] = $arr[2];
				$page['userId'] = $arr[3];
				$page['date'] = $arr[4];
				$page['transId'] = $arr[5];
				$page['msg'] = $arr[6];
				
				$this->load->view('site/invoice-add-money',$page);
			} else {
				redirect('');
			}
		} else {
			redirect('');
		}
		
		
		
	}
}