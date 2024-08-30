<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dispute extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		//$this->email->initialize($config);
		$this->load->library('form_validation');
		date_default_timezone_set('UTC');
		//$this->lang->load('message','english');
		$this->load->model('Admin_model');
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->check_login();
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId')) {
			redirect('Admin');
		}
	}

	public function reject_bank_transer(){
		$this->form_validation->set_rules('reject_reason','Reject reason','trim|required');
		
		if($this->form_validation->run()){
			
			$id = $this->input->post('id');
			$reject_reason = $this->input->post('reject_reason');
			
			$data = $this->Common_model->getRows('bank_transfer',$id);
			
			if($data){

				$user_id = $data['userId'];
				
				$update = $this->Common_model->update('bank_transfer',array('id'=>$id),array('status'=>2,'reject_reason'=>$reject_reason));
				
				if($update){
						
					
					$nt_message = 'Bank transfer request declined. <a href="' .site_url('wallet?reject_reason=' .$id .'&type=bank_transfer') .'" >View reason</a>';
					
					$this->Common_model->insert_notification($user_id,$nt_message);
					
					$user = $this->Common_model->get_userDataByid($user_id);
					
					$subject = "Unable to fund Your Tradespeople Hub account."; 
						
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Declined reason: '.$reject_reason.'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Bank Transfer</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$this->Common_model->send_mail($user['email'],$subject,$html,null,null,'support');
					
					$json['status'] = 1;
					
					$this->session->set_flashdata('msg','<div class="alert alert-success">Request has been reject successfully.</div>');
					
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
				
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
	
	public function approve_bank_transer(){
		$this->form_validation->set_rules('amount','amount','trim|required|numeric');
		
		if($this->form_validation->run()){
			
			$id = $this->input->post('id');
			$amount = $this->input->post('amount');
			
			$data = $this->Common_model->getRows('bank_transfer',$id);
			
			if($data){

				$user_id = $data['userId'];
				
				$update = $this->Common_model->update('bank_transfer',array('id'=>$id),array('status'=>1,'user_amount'=>$amount));
				
				if($update){
					$txnID = time().rand();
			
					$insert['tr_userid'] = $user_id;
					$insert['tr_message'] = '<i class="fa fa-gbp"></i>'.$amount.' has deposited in your wallet by Bank Transfer.</b>';
					$insert['tr_amount'] = $amount;
					$insert['tr_type'] = 1;
					$insert['tr_transactionId'] = $txnID;
					$insert['tr_status'] = 1;
					$insert['tr_paid_by']='Bank Transfer';
					$insert['is_deposit']=1;
					
					$run2 = $this->Common_model->insert('transactions',$insert);
					
					
					$user = $this->Common_model->get_userDataByid($user_id);
					$amount1 = $user['u_wallet']+$amount;
					$u_data['u_wallet'] = $amount1;
					$this->Common_model->update('users',array('id'=>$user_id),$u_data);
								
			
					//$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' were successfully credited to your wallet, TransactionId: <b>'.$txnID.'</b>';
					
					$store = '2';//0
					$store .= '&Bank transfer';//1
					$store .= '&'.$amount;//2
					$store .= '&'.$user_id;//3
					$store .= '&'.date('Y-m-d');//4
					$store .= '&'.$txnID;//5
					$store .= '&<i class="fa fa-gbp"></i>'.$amount.' was credited to your account.';//6
								
					$inv = $this->Common_model->insert('invoice',array('data'=>$store));
					
					$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' was credited to your account. <a target="_blank" href="'.site_url().'view-invoice/'.$inv.'">View invoice!</a>';
					
					$this->Common_model->insert_notification($user_id,$nt_message);
					
					$subject = "Your TradespeopleHub account funded successfully.";
		
					$html = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
					
					if($user['type']==1){
			
						$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now quote jobs using those funds.</p>';
					
					} else {
						$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now create milestones and pay your tradesperson on our platform using those funds.</p>';
					}
					
					
					$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$amount.'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Bank transfer</p>';
					if($user['type']==1){
						$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					} else {
						$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					}
					
					//$user['email'] = 'anil.webwiders@gmail.com';
					
					$runs1=$this->Common_model->send_mail($user['email'],$subject,$html,null,null,'support');
					
					$json['status'] = 1;
					
					$this->session->set_flashdata('msg','<div class="alert alert-success">Request has been accpeted successfully.</div>');
					
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
				
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
	
	public function banner_transfer_request(){
		$page['bank_transfer_history'] = $this->Common_model->get_all_data('bank_transfer',null,'id');
      
		$this->load->view('Admin/banner_transfer_request',$page);
	}
	public function dispute(){
		$page['dispute_user']=$this->Common_model->get_all_data('tbl_dispute','','ds_id');
		// print_r($page['dispute_user']);
      
		$this->load->view('Admin/dispute_job',$page);
      
	}

	public function dispute_details($dispute_ids){
		//echo $dispute_id;
		$dispute_id=$this->Common_model->get_single_data('tbl_dispute',array('ds_id'=>$dispute_ids));

		$job_id=$dispute_id['ds_job_id'];
		$page['dispute']=$dispute_id;
		$page['job_details']=$this->Common_model->get_single_data('tbl_milestones',array('id'=>$dispute_id['mile_id']));
		$page['job_files']=$this->Common_model->get_single_data('job_files',array('job_id'=>$job_id));
		$page['owner']=$this->Common_model->get_single_data('users',array('id'=>$dispute_id['ds_puser_id']));
		$page['tradmen']=$this->Common_model->get_single_data('users',array('id'=>$dispute_id['ds_buser_id']));
		$page['pending_amount']=$this->Common_model->sumcollum_value('milestone_amount','tbl_milestones',array('post_id'=>$dispute_id['ds_job_id'],'status'=>0,'status'=>3,'status'=>4,'status'=>5));
		$page['release_amount']=$this->Common_model->sumcollum_value('milestone_amount','tbl_milestones',array('id'=>$dispute_id['mile_id'],'status'=>2));
		$page['disput_comment']=$this->Common_model->get_all_data('disput_conversation_tbl',array('dct_disputid'=>$dispute_id['ds_id']),'dct_id');
		$page['bid_amont']=$this->Common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$dispute_id['ds_job_id'],'bid_by'=>$dispute_id['ds_buser_id']));

		
		$this->load->view('Admin/dispute_details',$page);
        

	}

	public function makedisputefinal(){
  
    $job_id=$this->input->post('job_id');
    $tradesman=$this->input->post('tradesman_id');
    $homeowner=$this->input->post('homeowner_id');
    $dispute_ids=$this->input->post('ds_id');
    $dispute_finel_user=$this->input->post('ds_favour');
    $mile_id=$this->input->post('mile_id');
    $massage=$this->input->post('massage');
		
		$milestone = $this->Common_model->get_single_data('tbl_milestones',array('id'=>$mile_id));
	
		$insert['dct_disputid']=$dispute_ids;
		$insert['dct_userid']=0;
		$insert['dct_msg']=$massage;
		$insert['dct_isfinal']=1;
		$insert['mile_id']=$mile_id;	

    $run = $this->Common_model->insert('disput_conversation_tbl',$insert);	
		
		if($run){
			
			$bid_update['status']=6;  
			
			$where="id = '".$mile_id."' and status = '5'";
			
			$this->Common_model->update('tbl_milestones',$where,$bid_update);
			
			
			$disput_update['ds_status']=1;
			$disput_update['ds_favour']=$dispute_finel_user;

			$run1 = $this->Common_model->update('tbl_dispute',array('ds_id'=>$dispute_ids),$disput_update);
			if($run1){
				
				$home=$this->Common_model->get_userDataByid($homeowner);
				$trades=$this->Common_model->get_userDataByid($tradesman);
				$favo=$this->Common_model->get_userDataByid($dispute_finel_user);
				
				$amount = $milestone['milestone_amount'];
				
				if($trades['id']==$dispute_finel_user){
					
					$get_commision=$this->Common_model->get_single_data('admin',array('id'=>1));
		
					$commision=$get_commision['commision'];
					
					$get_post_job = $this->Common_model->get_single_data('tbl_jobpost_bids',array('id'=>$milestone['bid_id']));
		
					$get_job_post = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$milestone['post_id']));
					
					$pamnt = $get_post_job['paid_total_miles'];
					$final_amount = $pamnt + $amount;
					
					$sql3 = "update tbl_jobpost_bids set paid_total_miles = '".$final_amount."' where id = '".$milestone['bid_id']."'";
					$this->db->query($sql3);


					$total = ($amount*$commision)/100;
				
					$amounts = $amount-$total;
					
					$u_wallet=$trades['u_wallet'];
					//$update1['u_wallet']=$u_wallet+$amounts;
					
					$withdrawable_balance=$trades['withdrawable_balance'];
					$update1['withdrawable_balance']=$withdrawable_balance+$amounts;
					
				
			
					$this->Common_model->update('tbl_milestones',array('id'=>$mile_id),array('is_dispute_to_traders'=>1,'admin_commission'=>$commision));
					
					if($final_amount >= $get_post_job['bid_amount']) {
						
						$runss12 = $this->Common_model->update_data('tbl_jobs',array('job_id'=>$milestone['post_id']),array('status'=>5));
						
						$runss123 = $this->Common_model->update_data('tbl_jobpost_bids',array('id'=>$get_post_job['id']),array('status'=>4));
						
						$post_title=$get_job_post['title'];
						
						/*$insertn['nt_userId']=$get_post_job['bid_by'];
						$insertn['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">Max Tommy.</a>';
						
						$insertn['nt_message']='Congratulation this project has been completed successfully.<a href="'.site_url().'profile/'.$home['id'].'">'.$home['f_name'].' '.$home['l_name'].'</a> has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed.Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
						$insertn['nt_satus']=0;
						$insertn['nt_apstatus']=2;
						$insertn['nt_create']=date('Y-m-d H:i:s');
						$insertn['nt_update']=date('Y-m-d H:i:s');   
						$insertn['job_id']=$get_post_job['job_id'];
						$insertn['posted_by']=$get_post_job['posted_by'];
						$run2 = $this->Common_model->insert('notification',$insertn);*/
						
						
						$subject = "Congratulations on Completing the Job: “".$post_title."”";
			
						$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “'.$post_title.'”! Your milestone payments has now been released and can be withdrawn. </p>';
						$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for '.$home['f_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
						
						$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';
						
						$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$runs1=$this->Common_model->send_mail($trades['email'],$subject,$html,null,null,'support');
						
						
						$subject = "Congratulations on Job Completion: “".$post_title."”";
			
						$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Hi '.$home['f_name'].',</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “'.$post_title.'”! completed successfully and milestone payments released to '.$trades['trading_name'].'.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to '.$trades['trading_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
						
						$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';
						
						$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$runs1=$this->Common_model->send_mail($home['email'],$subject,$html,null,null,'support');
						
					
						$insertn1['nt_userId']=$get_post_job['posted_by'];
						// $insertn1['nt_message']='Congratulation this project has been completed successfully.You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
						$insertn1['nt_message'] = 'Congratulations! Your job has been completed. <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">Rate ' .$trades['trading_name'] .'!</a>';
								
						$insertn1['nt_satus']=0;
						$insertn1['nt_apstatus']=2;
						$insertn1['nt_create']=date('Y-m-d H:i:s');
						$insertn1['nt_update']=date('Y-m-d H:i:s');   
						$insertn1['job_id']=$get_post_job['job_id'];
						$insertn1['posted_by']=0;
						$this->Common_model->insert('notification',$insertn1);

						$insertn2['nt_userId']=$get_post_job['bid_by'];
						$insertn2['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">'.$home['f_name'].' '.$home['l_name'].'.</a>';
								
						$insertn2['nt_satus']=0;
						$insertn2['nt_apstatus']=2;
						$insertn2['nt_create']=date('Y-m-d H:i:s');
						$insertn2['nt_update']=date('Y-m-d H:i:s');   
						$insertn2['job_id']=$get_post_job['job_id'];
						$insertn2['posted_by']=0;
						$this->Common_model->insert('notification',$insertn2);

					}
					
				} else {
					
					$amounts = $amount;
					$u_wallet=$home['u_wallet'];
					$update1['u_wallet']=$u_wallet+$amounts;
					
				}
				
				$runss1 = $this->Common_model->update_data('users',array('id'=>$dispute_finel_user),$update1);
				
				$jon_name = $this->Common_model->update_data('users',array('id'=>$dispute_finel_user),$update1);
				
				$transactionid = md5(rand(1000,999).time());
				$tr_message= 'Dispute team resolved the <a href="'. site_url('dispute/'.$mile_id.'/'.$job_id).'">'.$milestone['milestone_name'].' milestone dispute</a> in favour of you and £'.$amounts.' has been credited in your wallet for </b>';
				$data1 = array(
						'tr_userid'=>$dispute_finel_user, 
						'tr_amount'=>$amounts,
						'tr_type'=>1,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
				);
        $this->Common_model->insert('transactions',$data1);
				
				$job = $this->Common_model->GetColumnName('tbl_jobs',array('job_id'=>$job_id),array('title'));
				
				
				$insertn4['nt_userId']=$home['id'];
				$insertn4['nt_message']='Milestone payment dispute decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
						
				$insertn4['nt_satus']=0;
				$insertn4['nt_apstatus']=0;
				$insertn4['nt_create']=date('Y-m-d H:i:s');
				$insertn4['nt_update']=date('Y-m-d H:i:s');   
				$insertn4['job_id']=$job_id;
				$insertn4['posted_by']=0;
				$this->Common_model->insert('notification',$insertn4);
				
				$insertn5['nt_userId']=$trades['id'];
				$insertn5['nt_message']='Milestone payment dispute decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
						
				$insertn5['nt_satus']=0;
				$insertn5['nt_apstatus']=0;
				$insertn5['nt_create']=date('Y-m-d H:i:s');
				$insertn5['nt_update']=date('Y-m-d H:i:s');   
				$insertn5['job_id']=$job_id;
				$insertn5['posted_by']=0;
				$this->Common_model->insert('notification',$insertn5);

        $subject = "We've decided on the Milestone Payment Dispute & Closed the case: “" .$get_job_post['title'] ."”";
				
				$traing_name = ($favo['type']==1) ? $favo['trading_name'] : $favo['f_name'].' '.$favo['f_name'];
				
        $html = '<br><p style="margin:0;padding:10px 0px">Hi, '.$home['f_name'].'</p>';
        $html .= '<br><p style="margin:0;padding:10px 0px">We\'ve completed our review on the milestone dispute and decided in favour of the ' .$traing_name .'. We have therefore returned the Milestone payment to them and close the case.</p>';
				
        $html .= '<p style="margin:0;padding:10px 0px">Returned amount: £' .$amount .'</p>';
        $html .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and closed case can\'t be reopened.</p>';
				
				$html .= '<br><div style="text-align:center"><a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View reason</a></div><br>';
				
        $html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

        $this->Common_model->send_mail($home['email'], $subject, $html,null,null,'support');
				
        $html = '<br><p style="margin:0;padding:10px 0px">Hi, '.$trades['f_name'].'</p>';
        $html .= '<br><p style="margin:0;padding:10px 0px">We\'ve completed our review on the milestone dispute and decided in favour of the ' .$favo['f_name'] .' ' .$favo['l_name'] .'. We have therefore returned the Milestone payment to them and close the case.</p>';
				
        $html .= '<p style="margin:0;padding:10px 0px">Returned  amount: £' .$amount .'</p>';
        $html .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and closed case can\'t be reopened.</p>';
				
				$html .= '<br><div style="text-align:center"><a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div><br>';
				
        $html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

        $this->Common_model->send_mail($trades['email'], $subject, $html,null,null,'support');
				

        $this->session->set_flashdata('msg','<div class="alert alert-success">Dispute has been resolved successfully.</div>');
				//$this->release_milestone($job_id,$dispute_finel_user);
			}else{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something went wrong, try again later</div>');
			}

		}
    redirect('dispute_details/'.$dispute_ids);
	}

	function add_dispute_comment(){

		$job_id=$this->input->post('job_id');
		$buser=$this->input->post('tradesman_id');
		$puser=$this->input->post('homeowner_id');
		$ds=$this->input->post('dispute_id');
		$dct_msg=$this->input->post('massage');
		$mile=$this->input->post('mile_id');
		
		$message_to=$this->input->post('message_to');
		
		$current = date('Y-m-d H:i:s');
		
		$end_time = date('Y-m-d H:i:s',strtotime($current.' + 48 hours'));
		
		$dispute_id=$this->Common_model->get_single_data('tbl_milestones',array('id'=>$mile));

		$insert['dct_disputid'] =  $ds;
		$insert['dct_userid'] = 0;
		$insert['dct_msg'] = $dct_msg;
		$insert['dct_isfinal'] = 0;	
		$insert['message_to'] = $message_to;	
		$insert['is_reply_pending'] = 1;	
		$insert['dct_update'] = date('Y-m-d H:i:s');	
		$insert['end_time'] = $end_time;	
		$insert['mile_id'] = $mile;	
					
		$run = $this->Common_model->insert('disput_conversation_tbl',$insert);	
		if($run){
			
			$traduser=$this->Common_model->GetColumnName('users',array('id'=>$message_to),array('email','f_name','l_name','type'));
		
			if($message_to==$buser){
				$favor=$this->Common_model->GetColumnName('users',array('id'=>$puser),array('f_name','trading_name'));
			} else {
				$favor=$this->Common_model->GetColumnName('users',array('id'=>$buser),array('f_name','trading_name'));
			}
			
			$jobTitle=$this->Common_model->GetColumnName('tbl_jobs',array('job_id'=>$job_id),array('title'));
			
			$this->Common_model->update_data('disput_conversation_tbl',array('dct_disputid'=>$ds,'dct_id != '=>$run),array('is_reply_pending'=>0));
			
			if($traduser['type']==1){
			
				$subject ="Action required: Provide Additional information: Milestone Payment Dispute: ".$jobTitle['title'];
				
				$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Additional information needed!</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$traduser['f_name'].',</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">We are contacting you because we need additional information that supports your claim. Please log in to your account to take the next action to provide the required information.</p>';
				
				$contant .= '<div style="text-align:center"><a href="'. site_url('dispute/'.$mile.'/'.$job_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View the message and respond</a></div>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within '.date('d M Y h:i:s A',strtotime($end_time)).' will result in closing this case and deciding in the '.$favor['f_name'].' favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t reopen.</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->Common_model->send_mail($traduser['email'],$subject,$contant,null,null,'support');
			
			} else {
				
				$subject ="Action required: Milestone Payment Dispute: Provide Additional information ".$jobTitle['title'];
				
				$contant = '<p style="margin:0;padding:10px 0px">Additional information needed!</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$traduser['f_name'].',</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">We are contacting you because we need additional information that supports your claim. Please log in to your account to take the next action to provide the required information.</p>';
				
				$contant .= '<div style="text-align:center"><a href="'. site_url('dispute/'.$mile.'/'.$job_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View the message and respond</a></div>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within '.date('d M Y h:i:s A',strtotime($end_time)).' will result in closing this case and deciding in the favour of '.$favor['trading_name'].'.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t reopen.</p>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->Common_model->send_mail($traduser['email'],$subject,$contant,null,null,'support');
				
			}
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
				
		}else{
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
			
		}
		redirect('dispute_details/'.$ds);
	}

	function release_milestone($jobId,$userId){
		$release_milestone = $this->Common_model->get_all_data('tbl_milestones',array('post_id'=>$jobId,'status'=>0));
		/* print_r($release_milestone);*/
		if($release_milestone){
			foreach ($release_milestone as $miles) {
				$user=$this->Common_model->get_userDataByid($userId);
				$u_update['u_wallet']=$user['u_wallet']+$miles['milestone_amount'];
				$update_result=$this->Common_model->update('users',array('id'=>$user['id']),$u_update);
				if($update_result){
					$tr_update['tr_userid'] = $user['id'];
					$tr_update['tr_message'] = '<i class="fa fa-gbp"></i>'.$miles['milestone_amount'].' has been credited in your wallet for '.$miles['milestone_name'].' milestone.';
					$tr_update['tr_amount'] ='<i class="fa fa-gbp"></i>'.$miles['milestone_amount'];
					$tr_update['tr_type'] = 1;
					$tr_update['tr_transactionId'] = md5(rand(1000,999).time());
					$tr_update['tr_status'] = 1;
					$tr_update['tr_created'] = date('Y-m-d H:i:s');
					$tr_update['tr_update'] = date('Y-m-d H:i:s');
					$run = $this->Common_model->insert('transactions',$tr_update);
					//$miles_update['status']=2;
					//$update_result=$this->Common_model->update('tbl_milestones',array('id'=>$miles['id']),$miles_update);
				}
			}	
		}
        
	}
		
}