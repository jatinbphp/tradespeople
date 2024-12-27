<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_offer extends CI_Controller
{ 
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}

	public function send($id, $receiverId, $pMethod){
		$uId = $this->session->userdata('user_id');
		$this->session->unset_userdata('latest_custom_order');
		$this->session->unset_userdata('totalDays');
		$this->session->unset_userdata('totalAmount');

		$data['title'] = 'Custom Offer';
		$data['service_id'] = $id;
		$data['receiver_id'] = $receiverId;
		$data['service'] = $this->common_model->GetSingleData('my_services',['id'=>$id]);
		$data['pMethod'] = $pMethod;
		
		if(empty($data['service'])){
			$this->load->view('site/My404');
		}else{
			$service_category = $this->common_model->GetSingleData('service_category',['cat_id'=>$data['service']['category']]);

			$data['price_per_type'] = !empty($service_category['price_type_list']) ? explode(',', $service_category['price_type_list']) : [];

			$data['attributes'] = $this->common_model->get_all_data('service_attribute',['service_cat_id'=>$service_category['cat_id']]);

			$data['package_data'] = !empty($data['service']['package_data']) ? json_decode($data['service']['package_data']) : [];

			$data['milestones'] = [];
			$data['custom_order'] = [];
			$data['totalAmtDays'] = [];
			$data['service_category'] = $service_category;
			$data['milestoneList'] = '';
			$data['mIds'] = '';

			if(!empty($latestOid)){
				$data['milestones'] = $this->common_model->get_all_data('tbl_milestones',['milestone_type'=>'service', 'post_id'=>$latestOid, 'posted_user'=>$uId]);

				$data['totalAmtDays'] = $this->common_model->getTotalMilestone($latestOid);
				$data['milestoneList'] = $this->load->view('site/milestoneList',$data, true);

				if(!empty($data['milestones'])){
					foreach($data['milestones'] as $list){
						$data['mIds'] .= $list['id'].',';
					}
				}
				$data['custom_order'] = $this->common_model->GetSingleData('service_order',['id'=>$latestOid]);
			}		
			$viewData = $this->load->view('site/custom_offer',$data, true);			
			echo $viewData; 
		}
	}

	public function store() {
		$uId = $this->session->userdata('user_id');
		$oId = $this->input->post('customOrderId');
		$quantity = $this->input->post('quantity');
		$tradesman=$this->common_model->get_single_data('users',array('id'=>$uId));
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));

		$order_type = $this->input->post('order_type');

		if($order_type == 'single'){
			$price =  $this->input->post('price');
			$totalPrice = ($this->input->post('price') * $quantity) + $setting['service_fees'];
		}else{
			$price = 0;
			$totalPrice = 0;
		}

		$insert['is_custom'] = 1;
		$insert['order_type'] = $order_type;
		$insert['order_id'] = $this->common_model->generateOrderId(13);
		$insert['user_id'] = $this->input->post('receiver_id');
		$insert['service_id'] = $this->input->post('service_id');
		$insert['price'] = $price;
		$insert['price_per_type'] = $this->input->post('price_per_type');
		$insert['service_qty'] = $quantity;
		$insert['package_type'] = 'custom';
		$insert['service_fee'] = $setting['service_fees'];
		$insert['total_price'] = $totalPrice;
		$insert['status'] = 'offer_created';
		$insert['description'] = $this->input->post('description');
		//$insert['revisions'] = isset($_POST['revisions']) ? $this->input->post('revisions') : 0;
		$insert['delivery'] = isset($_POST['delivery']) ? $this->input->post('delivery') : 0;
		$insert['is_offer_expires'] = isset($_POST['is_offer_expires']) ? $this->input->post('is_offer_expires') : 0;
		$insert['offer_expires_days'] = isset($_POST['offer_expires_days']) ? $this->input->post('offer_expires_days') : 0;
		$insert['is_requirements'] = isset($_POST['is_requirements']) ? $this->input->post('is_requirements') : 0;
		$insert['offer_includes'] = isset($_POST['offer_includes']) ? $this->input->post('offer_includes') : 0;
		$insert['offer_includes_ids'] = isset($_POST['offer_includes_ids']) ? json_encode($this->input->post('offer_includes_ids')) : null;

		if(!empty($oId)){
			$this->common_model->update('service_order',array('id'=>$oId),$insert);
			$newOrder = $oId;
		}else{
			$newOrder = $this->common_model->insert('service_order', $insert);	
		}

		if($newOrder) {

			$tPrice = 0;

			if($this->input->post('order_type') == 'milestone'){
				$totalAmtDays = $this->common_model->getTotalMilestone($newOrder);

				if(!empty($totalAmtDays)){
					$insert1['price'] = $totalAmtDays[0]['mAmount'];
					$insert1['delivery'] = $totalAmtDays[0]['totalDays'];
					$insert1['total_price'] = $totalAmtDays[0]['mAmount'] + $setting['service_fees'];
					$tPrice = $totalAmtDays[0]['mAmount'] + $setting['service_fees'];

					$this->common_model->update('service_order', ['id'=>$newOrder], $insert1);	
				}				
			}

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

			/*Notification Code Start*/
			$insertn['nt_userId'] = $this->input->post('receiver_id');
    	$insertn['nt_message'] = $tradesman['trading_name'] .' has been created custom offer for you. <a href="' .site_url('order-tracking/'.$newOrder) .'" >View Offer</a>';
	    $insertn['nt_satus'] = 0;
	    $insertn['nt_create'] = date('Y-m-d H:i:s');
	    $insertn['nt_update'] = date('Y-m-d H:i:s');
	    $insertn['job_id'] = $newOrder;
	    $insertn['posted_by'] = $uId;
	    $run2 = $this->common_model->insert('notification',$insertn);
	    /*Notification Code End*/				

			if($homeOwner){
				$subject = $tradesman['trading_name']." has been created custom offer for “".$service_details['service_name']."”";				
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">'.$tradesman['trading_name'].'has been created custom offer for '.$service_details['service_name'].'</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$homeOwner['f_name'].'!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Service payment amount: £'.$tPrice.'</p>';
				$html .= '<p style="margin:0;padding:10px 0px"><a href="'.site_url().'order-tracking/'.$newOrder.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Offer</a></p>';
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$sent = $this->common_model->send_mail($homeOwner['email'],$subject,$html);
			}
			$this->session->unset_userdata('latest_custom_order');
			$this->session->set_flashdata('success',"Order has been added successfully.");
			$json['success'] = "Order has been added successfully.";
   	} else {
   		$json['error'] = "Something went wrong, try again later.";
   	}
		echo json_encode($json); 
	}

	public function milestoneStore(){
		$uId = $this->session->userdata('user_id');
		$service_id = $this->input->post('service_id');		
		$receiver_id = $this->input->post('receiver_id');		
		$order_type = $this->input->post('order_type');		
		$main_description = $this->input->post('main_description');		
		$name = $this->input->post('name');		
		$delivery = $this->input->post('delivery');		
		$price = $this->input->post('price');		
		$delivery = $this->input->post('delivery');		
		$description = $this->input->post('description');		
		$price_per_type = $this->input->post('price_per_type');	
		$quantity = $this->input->post('quantity');	
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));

		$insert['is_custom'] = 1;
		$insert['order_type'] = $order_type;
		$insert['order_id'] = $this->common_model->generateOrderId(13);
		$insert['user_id'] = $receiver_id;
		$insert['service_id'] = $service_id;
		$insert['description'] = $main_description;
		$insert['service_fee'] = $setting['service_fees'];
		$insert['status'] = 'create';

		$latestOid = $this->session->userdata('latest_custom_order');

		if(!empty($latestOid)){
			$this->common_model->update('service_order', ['id'=>$latestOid], $insert);
			$newOrder = $latestOid;
		}else{
			$newOrder = $this->common_model->insert('service_order', $insert);
			$this->session->set_userdata('latest_custom_order',$newOrder);
		}

		$totalMilestone = $this->common_model->getCountMilestone($newOrder);

		$data1 = [
			'milestone_level' => $totalMilestone[0]['total'] + 1,
			'milestone_type' => 'service',
			'milestone_name' => $name,
			'milestone_amount' => $price,
			'userid' => $receiver_id,
			'post_id' => $newOrder,
			'cdate' => date('Y-m-d H:i:s'),
			'posted_user' => $uId,
			'created_by' => $uId,
			'bid_id' => $service_id,
			'description' => $description,
			'delivery' => $delivery,
			'price_per_type' => $price_per_type,
			'quantity' => $quantity,
			'service_status' => 'offer_created',
			'service_previous_status' => 'offer_created',
			'total_amount' => $price * $quantity,
		];

		$run = $this->common_model->insert('tbl_milestones',$data1);

		if($run){
			$data['service'] = $this->common_model->GetSingleData('my_services',['id'=>$id]);
			$data['service_category'] = $this->common_model->GetSingleData('service_category',['cat_id'=>$data['service']['category']]);
			$data['price_per_type'] = !empty($data['service_category']['price_type_list']) ? explode(',', $service_category['price_type_list']) : [];
			$totalAmtDays = $this->common_model->getTotalMilestone($newOrder);
			$data['milestones'] = $this->common_model->get_all_data('tbl_milestones',['milestone_type'=>'service', 'post_id'=>$newOrder]);

			$json['status'] = 1;
			$json['oId'] = $newOrder;
			$json['milestoneId'] = $run;
			$json['totalDays'] = $totalAmtDays[0]['totalDays'];
			$json['totalAmount'] = number_format($totalAmtDays[0]['mAmount'],2);
			$json['totalQty'] = $totalAmtDays[0]['qty'];
			$json['priceType'] = $data['milestones'][0]['price_per_type'];
			$json['success'] = "Milestone added successfully.";
			$json['viewData'] = $this->load->view('site/milestoneList',$data, true);
			$json['nextMilestone'] = $this->ordinal(count($data['milestones']) + 1).' Milestone Name';
			$json['allMilestones'] = json_encode($data['milestones'], true);
			echo json_encode($json);
		}else{
			echo "Something went wrong, try again later.";
		}		
	}

	public function ordinal($number) {
		$suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
		if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
			return $number . 'th';
		} else {
			return $number . $suffixes[$number % 10];
		}
	}
}

