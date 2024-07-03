<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Withdrawal extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->check_login();
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	
	public function send_request(){
		$this->form_validation->set_rules('user_id','homeowner','trim|required');
		$this->form_validation->set_rules('pay_method','recent payment method','trim|required');
		$this->form_validation->set_rules('wallet','homeowner wallet','trim|required|numeric|greater_than[0]');
		$wallet = $this->input->post('wallet');
		$this->form_validation->set_rules('amount','amount','trim|required|numeric|greater_than[0]|less_than_equal_to['.$wallet.']',array('less_than_equal_to'=>'withdrawal amount can not be more then homeowner wallet amount.'));
		
		if($this->form_validation->run()){
			$token = md5(time());
			$insert['token'] = $token;
			$insert['user_id'] = $this->input->post('user_id');
			$insert['status'] = 0;
			$insert['amount'] = $this->input->post('amount');
			$pay_method = $insert['pay_method'] = $this->input->post('pay_method');
			$insert['create_date'] = date('Y-m-d H:i:s');
			$insert['update_date'] = date('Y-m-d H:i:s');
			
			$run = $this->Common_model->insert('homeowner_fund_withdrawal',$insert);
			if($run){
				
				$has_email_noti = $this->Common_model->GetColumnName('users',array('id'=>$insert['user_id']),array('email','f_name'));
				
				if($pay_method=='Stripe'){
					$payment_method = 'card';
				} else if($pay_method=='Bank Transfer'){
					$payment_method = 'bank account';
				} else {
					$payment_method = 'Paypal account';
				}
				
				$subject = "Refund request initiated- Please, complete your details.";
				
				$html = '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Your refund request has been initiated and awaits for you to fill in your details.</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Refunding amount: £'.$insert['amount'].'</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">To process your request, we need you to enter and confirm the details of the '.$payment_method.' where you want the payment to be made. </p>';
				
				$html .= '<br><div style="text-align:center"><a href="'.site_url().'fund-request-form/'.$insert['user_id'].'/'.$run.'/'.$insert['token'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Enter your '.$payment_method.' details!</a></div><br>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Your money will be refunded after we have received and confirm your details. To avoid delay, please make sure you enter the right information.</p>';
				
				$html .= '<br><br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					
				$this->Common_model->send_mail($has_email_noti['email'],$subject,$html,null,null,'support');
				
				$json['status'] = 1;
				$this->session->set_flashdata('msg','<div class="alert alert-success">Request has been sent successfully.</div>');
				
				
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}
		echo json_encode($json);
	}
	function reject_post()
	{
		$id=$this->input->post('id');
		$user_id=$this->input->post('user_id');
		$amount=$this->input->post('amount');
		$reason=$this->input->post('reason');
		
		$userdata['status']=2;
		$userdata['reason']=$reason;
		$where_array=array('id'=>$id); 
		$result=$this->Common_model->update_data('homeowner_fund_withdrawal',$where_array,$userdata);
		
		$get_users = $this->Common_model->GetColumnName('users',array('id'=>$user_id),array('email','f_name','l_name','u_wallet'));

		
		$data = $this->Common_model->GetColumnName('homeowner_fund_withdrawal',array('id'=>$id),array('pay_method','amount')); 
		
		if($data['pay_method']=='Stripe'){
			$payment_method = 'card';
		} else if($data['pay_method']=='Bank Transfer'){
			$payment_method = 'bank account';
		} else {
			$payment_method = 'Paypal account';
		}

		$subject = "Refund Request Decline!";
				
		$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Refund request Decline!</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Hi '.$get_users['f_name'].' '.$get_users['l_name'].',</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Unfortunately, we´re unable to process the request to refund your money to your '.$payment_method.'.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Requested refund amount: £'.$data['amount'].'</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Transaction ID: '.md5($id).'</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Decline reason: '.$reason.'</p>';
	
		$html .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
				
		$runsss=$this->Common_model->send_mail($get_users['email'],$subject,$html,null,null,'support');

		$insertn['nt_userId']=$user_id;

		// $insertn['nt_message']='Admin has rejected your withdrawal request of amount £'.$amount.' .<br><b>Reason: </b>'.$reason.'';
		$insertn['nt_message'] = 'Your refund request was declined. <a href="' .site_url('wallet?reject_reason=' .$id) .'" >View reason!</a>';
		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['nt_apstatus']=4;
		$run2 = $this->Common_model->insert('notification',$insertn);
		
		$json['status']=1;
		$this->session->set_flashdata('success', 'Success! Withdrawal Request Rejected Successfully');		
		echo json_encode($json);

	}
	public function accept_withdraw($id)
	{
		$data = $this->Common_model->get_single_data('homeowner_fund_withdrawal',array('id'=>$id));
		
		$userdata['status']=1;
		$where_array=array('id'=>$id); 
		$result = $this->Common_model->update_data('homeowner_fund_withdrawal',$where_array,$userdata);
		
		$get_users = $this->Common_model->GetColumnName('users',array('id'=>$data['user_id']),array('email','f_name','l_name','u_wallet')); 
		
		$userdata1['u_wallet']=$get_users['u_wallet']-$data['amount'];
		$where_array1=array('id'=>$data['user_id']);
		$results=$this->Common_model->update_data('users',$where_array1,$userdata1);
		
		$isExist = $this->Common_model->GetColumnName('billing_details', array('user_id' => $data['user_id']),array('name','card_number','card_exp_month','card_exp_year','card_cvc','postcode','address','paypal_id'));
		
		
		$subject = "Refund Request Processed: Payment on the way";
				
		$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Refund request processed!</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Hi '.$get_users['f_name'].' '.$get_users['l_name'].',</p>';
		
		if($data['pay_method']=='Stripe'){
			
			$html .= '<p style="margin:0;padding:10px 0px">The request to refund your money to your card is processed and the money paid.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Paid  amount:  £'.$data['amount'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Card: '.$isExist['card_number'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Transaction ID: '.md5($id).'</p>';
			$html .= '<br><p style="margin:0;padding:10px 0px">It could take 1-2 business days for the money to appear in your bank account, depending on your bank. If it takes longer, please contact your bank.</p>';
			
			$html .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$insertn['nt_message']='£'.$data['amount'].' credited to your card.';
			
		} else if($data['pay_method']=='Bank Transfer'){
			
			$html .= '<p style="margin:0;padding:10px 0px">The request to refund your money to your bank account has been processed.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Paid  amount:  £'.$data['amount'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Bank name: '.$data['bank_name'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Sort code: '.$data['short_code'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Bank account: '.$data['account_number'].'</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Transaction ID: '.md5($id).'</p>';
			
			$html .= '<br><p style="margin:0;padding:10px 0px">It could take 1-2 business days for the money to appear in your bank account, depending on your bank. If it takes longer, please contact your bank.</p>';
			
			$html .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$insertn['nt_message']='£'.$data['amount'].' credited to your bank.';
			
		} else {
			$html .= '<p style="margin:0;padding:10px 0px">The request to refund your money to your Paypal account has been processed.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Paid  amount:  £'.$data['amount'].'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Paypal username: '.$isExist['paypal_id'].'</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Transaction ID: '.md5($id).'</p>';
			
			$html .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$insertn['nt_message']='£'.$data['amount'].' credited to your PayPal account.';
			
		}
		
		
		
			
				
		$runsss=$this->Common_model->send_mail($get_users['email'],$subject,$html,null,null,'support');

		$insertn['nt_userId']=$data['user_id'];

		
		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['nt_apstatus']=4;
		$run2 = $this->Common_model->insert('notification',$insertn);

		$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Withdrawal Request Accepted Successfully.</div>');
		
		redirect('Admin/homeowner-fund-withdrawal');
	}
	public function homeowner_fund_withdrawal(){
		$result['withdrawal'] = $this->Common_model->newgetRows('homeowner_fund_withdrawal',null,'id');
		$result['users'] = $this->Common_model->GetColumnName('users',array('type'=>2,'u_wallet >'=>0),array('f_name','unique_id','f_name','id'),true,'u_wallet');
		$this->load->view('Admin/homeowner_fund_withdrawal',$result);
	}
	public function get_user_wallet($id=null){
		
		$users = $this->Common_model->GetColumnName('users',array('id'=>$id),array('u_wallet'));
		
		$check = $this->Common_model->GetColumnName('transactions',array('tr_userid'=>$id,'is_deposit'=>1),array('tr_paid_by'),null,'tr_id');
		//echo $this->db->last_query();
		if($users && $check){
			$json['status'] = 1;
			$json['wallet'] = $users['u_wallet'];
			$json['pay_method'] = $check['tr_paid_by'];
		} else {
			$json['status'] = 0;
		}
		echo json_encode($json);
	}
	public function delete_request($id=null){
		$users = $this->Common_model->delete(array('id'=>$id),'homeowner_fund_withdrawal');
		if($users){
			$this->session->set_flashdata('msg','<div class="alert alert-success">Request has been deleted successfully.</div>');
		} else {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">Something went wrong, try again later.</div>');
		}
		redirect('Admin/homeowner-fund-withdrawal');
	}
}