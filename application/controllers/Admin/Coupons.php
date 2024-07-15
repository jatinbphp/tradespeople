<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coupons extends CI_Controller {

    protected $_data = [];
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->check_login();
        $this->_data['page_title'] = 'Coupons';
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId')) {
			redirect('Admin');
		}
	}
	
	public function index(){
		$this->_data['coupons'] = $this->Common_model->newgetRows('promo_code',null,'id');
		$this->load->view('Admin/coupons', $this->_data);
	}
	
	public function add_coupon(){
        $discountType = $this->input->post('discount_type');
        $discount     = $this->input->post('discount');

        if($discountType == 'percentage' && $discount > 100){
            $this->session->set_flashdata('msg','<div class="alert alert-error">You cannot add discount percentage more then 100%.</div>');
		    redirect('Admin/coupon-management');
        }

        $isLimited     = $this->input->post('is_limited');
		$limitedUser = $this->input->post('limited_user');

        if($isLimited == 'no'){
            $limitedUser = 0;
        }

		$insert['code']          = $this->input->post('code');
		$insert['is_limited']    = $isLimited;
		$insert['limited_user']  = $limitedUser;
		$insert['discount_type'] = $discountType;
		$insert['discount']      = $discount;
		$insert['status']        = $this->input->post('status');
		
		$this->Common_model->insert('promo_code',$insert);
		$this->session->set_flashdata('msg','<div class="alert alert-success">Coupon has been added successfully.</div>');
		redirect('Admin/coupon-management');
	}
	
	public function edit_coupon($id){
        if(!$id){
    		$this->session->set_flashdata('msg','<div class="alert alert-success">Something went wrong.</div>');
        }

        $discountType = $this->input->post('discount_type');
        $discount     = $this->input->post('discount');

        if($discountType == 'percentage' && $discount > 100){
            $this->session->set_flashdata('msg','<div class="alert alert-error">You cannot add discount percentage more then 100%.</div>');
		    redirect('Admin/coupon-management');
        }
		
		$isLimited   = $this->input->post('is_limited');
		$limitedUser = $this->input->post('limited_user');

        if($isLimited == 'no'){
            $limitedUser = 0;
        }

		$insert['code']          = $this->input->post('code');
		$insert['is_limited']    = $isLimited;
		$insert['limited_user']  = $limitedUser;
		$insert['discount_type'] = $discountType;
		$insert['discount']      = $discount;
		$insert['status']        = $this->input->post('status');

		$this->Common_model->update_data('promo_code',['id' => $id],$insert);
		$this->session->set_flashdata('msg','<div class="alert alert-success">Coupon has been updated successfully.</div>');
        redirect('Admin/coupon-management');
	}
	
	public function delete_coupons($id=null){
		$insert['id'] = $id;
		$this->Common_model->delete($insert,'promo_code');
		$this->session->set_flashdata('msg','<div class="alert alert-success">Coupon has been deleted successfully.</div>');
        redirect('Admin/coupon-management');
	}
}