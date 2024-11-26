	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_offer extends CI_Controller
{ 
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}

	public function send($id, $receiverId){

		$uId = $this->session->userdata('user_id');
		$data['title'] = 'Custom Offer';
		$data['service_id'] = $id;
		$data['receiver_id'] = $receiverId;
		$data['service'] = $this->common_model->GetSingleData('my_services',['id'=>$id]);

		if(empty($data['service'])){
			$this->load->view('site/My404');
		}

		$service_category = $this->common_model->GetSingleData('service_category',['cat_id'=>$data['service']['category']]);			

		$data['attributes'] = $this->common_model->get_all_data('service_attribute',['service_cat_id'=>$service_category['cat_id']]);

		$data['package_data'] = !empty($data['service']['package_data']) ? json_decode($data['service']['package_data']) : [];

		$data['milestones'] = $this->common_model->get_all_data('tbl_milestones',['post_id'=>$id, 'posted_user'=>$uId]);

		$this->load->view('site/custom_offer',$data);
	}

	public function store() {
		$uId = $this->session->userdata('user_id');
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));

		$insert['is_custom'] = 1;
		$insert['order_id'] = $this->common_model->generateOrderId(13);
		$insert['user_id'] = $this->input->post('receiver_id');
		$insert['service_id'] = $this->input->post('service_id');
		$insert['price'] = $this->input->post('price');
		$insert['service_qty'] = 1;
		$insert['package_type'] = 'custom';
		$insert['service_fee'] = $setting['service_fees'];
		$insert['total_price'] = ($this->input->post('price')+$setting['service_fees']);
		$insert['status'] = 'offer_created';
		$insert['description'] = $this->input->post('description');
		//$insert['revisions'] = isset($_POST['revisions']) ? $this->input->post('revisions') : 0;
		$insert['delivery'] = isset($_POST['delivery']) ? $this->input->post('delivery') : 0;
		$insert['is_offer_expires'] = isset($_POST['is_offer_expires']) ? $this->input->post('is_offer_expires') : 0;
		$insert['offer_expires_days'] = isset($_POST['offer_expires_days']) ? $this->input->post('offer_expires_days') : 0;
		$insert['is_requirements'] = isset($_POST['is_requirements']) ? $this->input->post('is_requirements') : 0;
		$insert['offer_includes'] = isset($_POST['offer_includes']) ? $this->input->post('offer_includes') : 0;
		$insert['offer_includes_ids'] = isset($_POST['offer_includes_ids']) ? json_encode($this->input->post('offer_includes_ids')) : null;
		$newOrder = $this->common_model->insert('service_order', $insert);

		if($newOrder) {
			$insert = [];
			$insert['type']='service';
			$insert['post_id']=$this->input->post('service_id');
			$insert['offer_id']=$newOrder;
			$insert['sender_id']=$uId;
			$insert['receiver_id']=$this->input->post('receiver_id');
			$insert['mgs']='Here is your custom offer.';
			$insert['is_read']=0;
			$insert['create_time']=date('Y-m-d H:i:s');
			$run = $this->common_model->insert('chat',$insert);

			$users=$this->common_model->get_single_data('users',array('id'=>$this->input->post('receiver_id')));
			$service_details = $this->common_model->get_single_data('my_services', array('id'=>$this->input->post('service_id')));
			$homeOwner = $this->common_model->check_email_notification($users['id']);
			if($homeOwner){
				$subject = "Order Payment Made for “".$service_details['service_name']."”";				
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Order Payment Made Successfully!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$homeOwner['f_name'].'!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Service payment amount:  £'.($this->input->post('price')+$setting['service_fees']).'</p>';
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$sent = $this->common_model->send_mail($homeOwner['email'],$subject,$html);
			}

			$this->session->set_flashdata('success',"Order has been added successfully.");
			$json['success'] = "Order has been added successfully.";
	   	} else {
	   		$json['error'] = "Something went wrong, try again later.";
	   	}
		echo json_encode($json); 
	}
}