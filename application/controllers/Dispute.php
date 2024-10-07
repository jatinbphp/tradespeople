<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dispute extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		error_reporting(0);

	}
	public function cancel_dispute($id=null,$post_id=null){
		
		$user_id = $this->session->userdata('user_id');
		
		$data = $this->common_model->GetColumnName('tbl_dispute',array('ds_id'=>$id,'disputed_by'=>$user_id),array('ds_id','ds_job_id','ds_buser_id','ds_puser_id','mile_id'));
		
		if($id && $post_id && $data){
			
			$user_id = $this->session->userdata('user_id');
			
			$run = $this->common_model->delete(array('ds_id'=>$id),'tbl_dispute');
			
			if($run){
				$this->common_model->delete(array('dct_disputid'=>$id),'disput_conversation_tbl');
				
				$this->common_model->update_data('tbl_milestones',array('id'=>$data['mile_id']),array('status'=>0));
				
				$job = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$post_id),array('title'));
				
				$milestone = $this->common_model->GetColumnName('tbl_milestones',array('id'=>$data['mile_id']),array('milestone_name','milestone_amount'));
				
				if($user_id == $data['ds_buser_id']){
					
					$disput_user = $this->common_model->GetColumnName('users',array('id'=>$data['ds_buser_id']),array('email','f_name','l_name','type','id', 'trading_name'));
					
					$other_user = $this->common_model->GetColumnName('users',array('id'=>$data['ds_puser_id']),array('email','f_name','l_name','type','id', 'trading_name'));
					
					
				} else {

					$disput_user = $this->common_model->GetColumnName('users',array('id'=>$data['ds_puser_id']),array('email','f_name','l_name','type','id', 'trading_name'));
					
					$other_user = $this->common_model->GetColumnName('users',array('id'=>$data['ds_buser_id']),array('email','f_name','l_name','type','id', 'trading_name'));
					
				}
				
				$insertn1['nt_userId']=$other_user['id'];
				$insertn1['nt_message']= $disput_user['f_name'].' '.$disput_user['l_name'].' has cancelled <a href="'.site_url('payments/?post_id='.$post_id).'">the milestone payment dispute.</a>';
				$insertn1['nt_satus']=0;
				$insertn1['nt_apstatus']=0;
				$insertn1['nt_create']=date('Y-m-d H:i:s');
				$insertn1['nt_update']=date('Y-m-d H:i:s');
				$insertn1['job_id']=$post_id;
				$insertn1['posted_by']=0;
				$run2 = $this->common_model->insert('notification',$insertn1);
				
				if($disput_user['type']==1){ //cancelled by tradesmen
					
					
					$subject = 'Milestone Payment Dispute was cancelled:"' .$job['title'] .'"'; 
					$contant .= '<p style="margin:0;padding:10px 0px">Hi ' .$other_user['f_name'] .',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">'.$disput_user['trading_name'].' has cancelled the milestone payment dispute claim for the job "' .$job['title'] .'"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$milestone['milestone_amount'] .'</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p>';
					
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">View our homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'],$subject,$contant);


					/*$subject = 'Your milestone payment dispute has been cancelled: "' .$job['title'] .'"'; 
					$contant = 'Hi '.$disput_user['f_name'] .',<br><br>';
					$contant .= 'Your milestone payment dispute against '.$other_user['f_name'].' has been cancelled successfully.<br><br>';
					$contant .= 'Milestone name: ' .$milestone['milestone_name'] .'<br>';
					$contant .= 'Milestone Dispute Amount: ' .$milestone['milestone_amount'] .' <br><br>';
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div><br>';
					$contant .= 'Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.<br><br>';
					
					$this->common_model->send_mail($disput_user['email'],$subject,$contant);*/
					
				} else { //cancelled by home owner
				
					$subject = 'Milestone Payment Dispute was cancelled:"' .$job['title'] .'"'; 
					$contant .= '<p style="margin:0;padding:10px 0px">Hi ' .$other_user['f_name'] .',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">'.$disput_user['f_name'].' '.$disput_user['l_name'].' has cancelled the milestone payment dispute claim for the job "' .$job['title'] .'"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$milestone['milestone_amount'] .'</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to ask them to release the milestone if they have not yet done that.</p>';
					
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'],$subject,$contant);
					
					
					$subject = 'Your milestone payment dispute has been cancelled: "' .$job['title'] .'"'; 
					$contant = 'Hi '.$disput_user['f_name'] .',<br><br>';
					$contant .= 'Your milestone payment dispute against '.$other_user['trading_name'].' has been cancelled successfully.<br><br>';
					$contant .= 'Milestone name: ' .$milestone['milestone_name'] .'<br>';
					$contant .= 'Milestone Dispute Amount: ' .$milestone['milestone_amount'] .' <br><br>';
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div><br>';
					$contant .= 'Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.<br><br>';
					
					$this->common_model->send_mail($disput_user['email'],$subject,$contant);
					
					
				}
				
				$this->session->set_flashdata('message','<div class="alert alert-success">Dispute has been cancelled successfully.</div>');
				
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger">Something went wrong, try again later.</div>');
			}
			
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger">Something went wrong, try again later.</div>');
			
		}
		
		redirect('payments/?post_id='.$post_id);
	}
	
	public function accept_and_close($id=null,$post_id=null){
		//echo '<pre>';
		$user_id = $this->session->userdata('user_id');
		
		$row = $this->common_model->get_single_data('tbl_dispute',array('ds_id'=>$id,'dispute_to'=>$user_id));
		
		$milestone = $this->common_model->get_single_data('tbl_milestones',array('id'=>$row['mile_id']));
		
		$dipute_by = $row['disputed_by'];
		$dipute_to = $row['dispute_to'];
		
		$job_id = $post_id;

		$tradesman = $row['ds_buser_id'];
		$homeowner = $row['ds_puser_id'];
		
		$dispute_ids = $row['ds_id'];
		
		$dispute_finel_user = $dipute_by;
		
		$home=$this->common_model->get_userDataByid($homeowner);
		$trades=$this->common_model->get_userDataByid($tradesman);
		$favo=$this->common_model->get_userDataByid($dispute_finel_user);
		
		$mile_id = $row['mile_id'];
		
		if($dipute_by==$tradesman){
			$accname = $home['f_name'];
		} else {
			$accname = $trades['trading_name'];
		}
		
		$massage = 'Dispute resolved as  '.$accname.' accept and close.';
		$insert['dct_disputid']=$dispute_ids;
		$insert['dct_userid']=0;
		$insert['dct_msg']=$massage;
		$insert['dct_isfinal']=1;
		$insert['mile_id']=$mile_id;	

		$run = $this->common_model->insert('disput_conversation_tbl',$insert);	
		
		if($run){
			
			$bid_update['status']=6;  
			
			$where="id = '".$mile_id."'";
			
			$this->common_model->update('tbl_milestones',$where,$bid_update);
			
			
			$disput_update['ds_status']=1;
			$disput_update['ds_favour']=$dispute_finel_user;

			$run1 = $this->common_model->update('tbl_dispute',array('ds_id'=>$dispute_ids),$disput_update);
			
			$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$milestone['post_id']));
				
			$amount = $milestone['milestone_amount'];
				
			if($trades['id']==$dispute_finel_user){
				$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time','commision'));
				
				$commision=$setting['commision'];
					
				$get_post_job = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$milestone['bid_id']));
		
				
					
				$pamnt = $get_post_job['paid_total_miles'];
				$final_amount = $pamnt + $amount;
					
				$sql3 = "update tbl_jobpost_bids set paid_total_miles = '".$final_amount."' where id = '".$milestone['bid_id']."'";
				$this->db->query($sql3);


				$total = ($amount*$commision)/100;
				
				$amounts = $amount-$total;
					
				$u_wallet=$trades['u_wallet'];
				$withdrawable_balance=$trades['withdrawable_balance'];
				
				//$update1['u_wallet']=$u_wallet+$amounts;
				$update1['withdrawable_balance']=$withdrawable_balance+$amounts;
			
				
			
				$this->common_model->update('tbl_milestones',array('id'=>$mile_id),array('is_dispute_to_traders'=>1,'admin_commission'=>$commision));
					
				if($final_amount >= $get_post_job['bid_amount']) {
						
					$runss12 = $this->common_model->update_data('tbl_jobs',array('job_id'=>$milestone['post_id']),array('status'=>5));
						
					$runss123 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$get_post_job['id']),array('status'=>4));
						
					$post_title=$get_job_post['title'];
						
					$insertn['nt_userId']=$get_post_job['bid_by'];
					
					$insertn['nt_message']='Congratulation this project has been completed successfully.<a href="'.site_url().'profile/'.$home['id'].'">'.$home['f_name'].' '.$home['l_name'].'</a> has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed.Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
					
					$insertn['nt_satus']=0;
					$insertn['nt_apstatus']=2;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');   
					$insertn['job_id']=$get_post_job['job_id'];
					$insertn['posted_by']=$get_post_job['posted_by'];
					$run2 = $this->common_model->insert('notification',$insertn);
						
					
					/*mail to homeOwner*/	
					$subject = "Congratulations on Job Completion: “".$post_title."”";
	
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$home['f_name'].',</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “'.$post_title.'”! completed successfully and milestone payments released to '.$trades['trading_name'].'.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to '.$trades['trading_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
					
					$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$runs1=$this->common_model->send_mail($home['email'],$subject,$html);
					/*mail to homeOwner*/
					
					$subject = 'Congratulations on Completing the Job:'.$post_title;

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “'.$post_title.'”! Your milestone payments has now been released and can be withdrawn. </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for '.$home['f_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
					
					$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$runs1=$this->common_model->send_mail($trades['email'],$subject,$html);
						

					$insertn1['nt_userId']=$get_post_job['posted_by'];
					// $insertn1['nt_message']='Congratulation this project has been completed successfully.You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
					$insertn1['nt_message'] = 'Congratulations! Your job has been completed. <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">Rate ' .$trades['trading_name'] .'!</a>';
								
					$insertn1['nt_satus']=0;
					$insertn1['nt_apstatus']=2;
					$insertn1['nt_create']=date('Y-m-d H:i:s');
					$insertn1['nt_update']=date('Y-m-d H:i:s');   
					$insertn1['job_id']=$get_post_job['job_id'];
					$insertn1['posted_by']=$get_post_job['bid_by'];
					$this->common_model->insert('notification',$insertn1);

					$insertn2['nt_userId']=$get_post_job['bid_by'];
					$insertn2['nt_message']='Congratulation this project has been completed successfully. Homeowner has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
								
					$insertn2['nt_satus']=0;
					$insertn2['nt_apstatus']=2;
					$insertn2['nt_create']=date('Y-m-d H:i:s');
					$insertn2['nt_update']=date('Y-m-d H:i:s');   
					$insertn2['job_id']=$get_post_job['job_id'];
					$insertn2['posted_by']=$get_post_job['posted_by'];
					$this->common_model->insert('notification',$insertn2);

				}
					
			} else {
					
				$amounts = $amount;
				$u_wallet=$home['u_wallet'];
				$update1['u_wallet']=$u_wallet+$amounts;
					
			}
				
			$runss1 = $this->common_model->update_data('users',array('id'=>$dispute_finel_user),$update1);
				
			$jon_name = $this->common_model->update_data('users',array('id'=>$dispute_finel_user),$update1);
				
			$transactionid = md5(rand(1000,999).time());
			$data1 = array(
				'tr_userid'=>$dispute_finel_user, 
				'tr_amount'=>$amounts,
				'tr_type'=>1,
				'tr_transactionId'=>$transactionid,
				'tr_message'=>$massage,
				'tr_status'=>1,
				'tr_created'=>date('Y-m-d H:i:s'),
				'tr_update' =>date('Y-m-d H:i:s')
			);
			$this->common_model->insert('transactions',$data1);
			
			
			$subject ="Milestone payment dispute accepted and closed.";

			$contant = '<p style="margin:0;padding:10px 0px">Hi '.$favo['f_name'].',</p>';
			
			$contant .= '<p style="margin:0;padding:10px 0px">'.$accname.' has accepted and closed the milestone payment dispute.</p>';
			$contant .= '<p style="margin:0;padding:10px 0px">You don\'t need to do anything else - we wanted to keep you updated.</p>';
				
			$contant .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($favo['email'],$subject,$contant);
			
				
			//$this->release_milestone($job_id,$dispute_finel_user);
		}
	
		$this->session->set_userdata('message','<div class="alert alert-success">Dispute has been closed successfully.</div>');
		redirect('payments/?post_id='.$post_id);
	}
	
	function dispute_job() {
		
		$milestones=$this->input->post('milestones');
		
		$dispute_mile=implode(',',$milestones);
		
		$text=explode(',',$dispute_mile);
		
		foreach($text as $t) {
			
			$where="id='".$t."'";
			
			$get_users=$this->common_model->get_single_data('tbl_milestones',$where);
			
			if($get_users){
				
				$userid = $this->session->userdata('user_id');
				
				$dispute_to = ($userid == $get_users['userid']) ? $get_users['posted_user'] : $get_users['userid'];
				
		    $insert['ds_in_id'] =  $userid;
		    $insert['ds_job_id'] = $get_users['post_id'];
				$insert['ds_buser_id'] = $get_users['userid'];
				$insert['ds_puser_id'] = $get_users['posted_user'];		
				$insert['caseid'] = time();
				$insert['ds_status']=0;
				$insert['mile_id']=$t;
				$insert['disputed_by']=$userid;
				$insert['dispute_to']=$dispute_to;
				$insert['ds_comment']=$this->input->post('dispute_reason');
				if ($this->session->userdata('type') == 1) {
					$insert['tradesmen_offer'] = $this->input->post('offer_amount');
				} else {
					$insert['homeowner_offer'] = $this->input->post('offer_amount');
				}

				$insert['last_offer_by'] = $userid;
				$insert['ds_create_date'] = date('Y-m-d H:i:s');

				if($userid==$get_users['posted_user']) {
					
					$run = $this->common_model->insert('tbl_dispute',$insert);	
					$login_user=$this->common_model->get_userDataByid($get_users['posted_user']);
					$insertn['nt_userId']=$get_users['userid'];
					$insertn['nt_message']=''.$login_user['f_name'].' '.$login_user['l_name'].' has opened a milestone dispute. <a href="'.site_url('dispute/'.$get_users['id'].'/'.$get_users['post_id']).'">View & respond!</a>';
					$insertn['nt_satus']=0;
					$insertn['nt_apstatus']=0;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');
					$insertn['job_id']=$get_users['post_id'];
					$insertn['posted_by']=$this->session->userdata('user_id');;
					$run2 = $this->common_model->insert('notification',$insertn);
				} else {
					$run = $this->common_model->insert('tbl_dispute',$insert);	
					$login_user=$this->common_model->get_userDataByid($get_users['userid']);
					$insertn['nt_userId']=$get_users['posted_user'];
					$insertn['nt_message']=''.$login_user['trading_name'] .' opened a milestone dispute. <a href="'.site_url('dispute/'.$get_users['id'].'/'.$get_users['post_id']).'">View & respond!</a>';
					$insertn['nt_satus']=0;
					$insertn['nt_apstatus']=0;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');
					$insertn['job_id']=$get_users['post_id'];
					$insertn['posted_by']=$this->session->userdata('user_id');;
					$run2 = $this->common_model->insert('notification',$insertn);

				}
				
				if($run){
					$login_users=$this->common_model->get_single_data('users',array('id'=>$userid));
					
					$posted_users=$this->common_model->get_single_data('users',array('id'=>$get_users['posted_user']));



					
					$bid_users=$this->common_model->get_single_data('users',array('id'=>$get_users['userid']));
					
					$job=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_users['post_id']));
					
					$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time'));
					
					$today = date('Y-m-d H:i:s');
		
					$newTime = date('Y-m-d H:i:s',strtotime($today.' +'.$setting['waiting_time'].' days'));
					
					if($get_users['posted_user']==$userid){ // open by home owner
						
						$by_name= $posted_users['f_name'].' '.$posted_users['l_name'];
					
						
						$subject = "Action required: Milestone Payment is being Disputed, Job “" .$job['title']."”"; 
						$contant = '<p style="margin:0;padding:10px 0px">Your Milestone Payment is being Disputed and required your response!</p>';
						$contant .= '<br><p style="margin:0;padding:10px 0px">Hi ' .$bid_users['f_name'] .',</p>';
						$contant .= '<br><p style="margin:0;padding:10px 0px"> ' .$by_name .' is disputing their Milestone payment for job “' .$job['title'] .'”</p>';
						$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$get_users['milestone_amount'] .'</p>';
						
						$contant .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with the ' .$by_name .'. If you can\'t solve this problem, you or  ' .$by_name .' can ask us to step in.</p>';
						
						$contant .= '<br><div style="text-align:center"><a href="' .site_url('dispute/' .$get_users['id'] .'/' .$get_users['post_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';
						
						$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in the client favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p>';
						
						$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$this->common_model->send_mail($bid_users['email'],$subject,$contant);
						

						$subject = "Your milestone payment dispute has been opened: “" .$job['title']."”.";
						$contant = 'Hi '.$posted_users['f_name'].',<br><br>';
						$contant.= 'Your milestone payment dispute against '.$bid_users['trading_name'].' has been opened successfully and awaits their response.<br><br>';
						$contant.= 'Milestone name: '.$get_users['milestone_name'].'<br>';
						$contant.= 'Milestone Dispute Amount: £'.$get_users['milestone_amount'].'<br><br>';
						$contant.= "We encourage to respond and resolve this issue you amicably. If you can't solve it, you or ".$bid_users['trading_name']." can ask us to step in.<br>";
						$contant .= '<br><div style="text-align:center"><a href="' .site_url('dispute/' .$get_users['id'] .'/' .$get_users['post_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View  dispute</a></div><br>';
						$contant.= $bid_users['trading_name'].' not responding within '.date("d-M-Y H:i:s", strtotime($newTime)).' (i.e. '.$setting['waiting_time'].' days) will result in closing this case and deciding in your favour.<br><br>';
						$contant.= 'If you receive a reply from  '.$bid_users['trading_name'].', please respond as soon as you can as not responding within 2 days closes the case automatically and decided in favour of '.$bid_users['trading_name'].'.<br><br>';
						$contant.= "Any decision reached is final and irrevocable. Once a case is close, it can't reopen.<br><br>";
						
						$contant.= "Visit our Milestone Payment system on the homeowner help page or contact our customer services if you have any specific questions using our service.<br>";
						$this->common_model->send_mail($posted_users['email'],$subject,$contant);
						
						
						
					} else {

						$to_mail= $posted_users['email'];	
						$to_name= $posted_users['f_name'];
						$type= $posted_users['type'];
						$to_first_name= $posted_users['f_name'];
						
						$by_name= $bid_users['f_name'].' '.$bid_users['l_name'];
						
						$by_mail= $bid_users['email'];
						
						$subject = "Action required: Your Milestone Payment is being Disputed: “" .$job['title']."”"; 
						$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' .$posted_users['f_name'] .',</p>';
						$contant .= '<br><p style="margin:0;padding:10px 0px"> ' .$bid_users['trading_name'] .' is disputing your Milestone payment to them & need your response.</p>';
						
						$contant .= '<p style="margin:0;padding:0px 0px">Job title: ' .$job['title'] .'</p>';
						$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £' .$get_users['milestone_amount'] .'</p>';
						
						$contant .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with ' .$bid_users['trading_name'] .'. If you can\'t solve it, you or  '.$bid_users['trading_name'].' can ask us to step in.</p>';
						
						$contant .= '<br><div style="text-align:center"><a href="' .site_url('dispute/' .$get_users['id'] .'/' .$get_users['post_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';
						
						$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in '.$bid_users['trading_name'].' favour.  Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
						
						$contant .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						$this->common_model->send_mail($posted_users['email'],$subject,$contant);
						
						
						
						$subject = "Your milestone payment dispute has been opened: “" .$job['title']."”.";
						$contant = 'Hi '.$bid_users['f_name'].',<br><br>';
						$contant.= 'Your milestone payment dispute against '.$posted_users['trading_name'].' has been opened successfully and awaits their response.<br><br>';
						$contant.= 'Milestone name: '.$get_users['milestone_name'].'<br>';
						$contant.= 'Milestone Dispute Amount: £'.$get_users['milestone_amount'].'<br><br>';
						$contant.= "We encourage ".$posted_users['trading_name']." to respond and resolve this issue with you amicably. If you can't solve it, you or '".$posted_users['trading_name']."' can ask us to step in.<br><br>";
						$contant .= '<div style="text-align:center"><a href="' .site_url('dispute/' .$get_users['id'] .'/' .$get_users['post_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View dispute</a></div><br>';
						$contant.= 'Please note: '.$posted_users['trading_name'].' not responding within '.date("d-M-Y H:i:s", strtotime($newTime)).' (i.e. '.$setting['waiting_time'].' days) will result in closing this case and deciding in your favour. <br><br>';
						$contant.= 'If you receive a reply from '.$posted_users['trading_name'].', please respond as soon as you can as not responding within 2 days closes the case automatically and decides in favour of '.$posted_users['trading_name'].'. <br><br>';
						$contant.= "Any decision reached is final and irrevocable. Once a case is closed, it can't reopen.<br><br>";
						$contant.= "Visit our Milestone Payment system on the tradespeople  help page or contact our customer services if you have any specific questions using our service.<br>";

						$this->common_model->send_mail($bid_users['email'],$subject,$contant);	
											
					}
					
					
					
					
					$bid_update['status']=5; 
					$run1=$this->common_model->update('tbl_milestones',$where,$bid_update);
				
					$this->session->set_flashdata('success1', 'Success! Milestone Disputed successfully.');
					
				}

			}
		}
		 redirect('payments?post_id='.$get_users['post_id']);
	}

	function dispute($mile)
	{
		if($this->session->userdata('user_id')) {
			$dispute_id=$this->common_model->get_single_data('tbl_dispute',array('mile_id'=>$mile));
			$page['dispute']=$dispute_id;
			$page['job_details']=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mile));
			$page['job_files']=$this->common_model->get_single_data('job_files',array('job_id'=>$job_id));
			$page['owner']=$this->common_model->get_single_data('users',array('id'=>$dispute_id['ds_puser_id']));
			$page['tradmen']=$this->common_model->get_single_data('users',array('id'=>$dispute_id['ds_buser_id']));
			$page['pending_amount']=$this->common_model->sumcollum_value('milestone_amount','tbl_milestones',array('post_id'=>$dispute_id['ds_job_id'],'status'=>0,'status'=>3,'status'=>4,'status'=>5));
			$page['release_amount']=$this->common_model->sumcollum_value('milestone_amount','tbl_milestones',array('id'=>$mile,'status'=>2));
			$page['disput_comment']=$this->common_model->get_all_data('disput_conversation_tbl',array('dct_disputid'=>$dispute_id['ds_id']),'dct_id','DESC');
			$page['bid_amont']=$this->common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$dispute_id['ds_job_id'],'bid_by'=>$dispute_id['ds_buser_id']));
			$this->load->view('site/dispute',$page);

		} else {
			redirect('login');
		}

	}

  function send_massege(){
    $userid = $this->session->userdata('user_id');
    $login_user = $this->common_model->get_userDataByid($userid);
    $from = $login_user['f_name'].' '.$login_user['l_name'];
    $ds = $this->input->post('ds_id');
    $buser = $this->input->post('bid_by');
    $puser = $this->input->post('post_by');
    $dct_msg = $this->input->post('dct_msg');
    $job_id = $this->input->post('job_id');
    $mile_id = $this->input->post('mile_id');
    $dispute_id = $this->common_model->get_single_data('tbl_milestones', array('id'=>$mile_id));
    $jobDetails = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $dispute_id['post_id']));

    if($buser!=$userid){
      $user=$this->common_model->get_userDataByid($buser);
      $to_mail=$user['email'];
      $type=$user['type'];
    }else if($puser!=$userid){
      $user=$this->common_model->get_userDataByid($puser);
      $to_mail=$user['email'];
			$type=$user['type'];
    }

    if($_FILES['dct_image']['name']!=''){
      $config['upload_path'] = 'img/dispute/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['remove_spaces'] = TRUE;
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config);

      //$this->upload->do_upload('cat_image');
      if($this->upload->do_upload('dct_image')){
        $data = $this->upload->data();
      } else {
        $this->upload->display_errors();
        $file_check = false;
      }
    }
		
		$message_to=$user['id'];
		
		$current = date('Y-m-d H:i:s');
		
		$end_time = date('Y-m-d H:i:s',strtotime($current.' + 48 hours'));

    $insert['dct_disputid'] =  $ds;
    $insert['dct_userid'] = $userid;
    $insert['dct_msg'] = $dct_msg;
    $insert['dct_isfinal'] = 0;
		$insert['message_to'] = $message_to;	
		$insert['is_reply_pending'] = 1;	
		$insert['dct_update'] = date('Y-m-d H:i:s');	
		$insert['end_time'] = $end_time;	
    $insert['mile_id']=$mile_id;
    $insert['dct_image']=$data['file_name'];

    $run = $this->common_model->insert('disput_conversation_tbl',$insert);
    if($run){
			
			$this->common_model->update_data('disput_conversation_tbl',array('dct_disputid'=>$ds,'dct_id != '=>$run),array('is_reply_pending'=>0));
			
      $this->common_model->update_data('disput_conversation_tbl',array('dct_disputid'=>$ds,'message_to'=>$userid),array('is_reply_pending'=>0));

      $insertn['nt_userId'] = $user['id'];
      if($login_user['trading_name']){
        $insertn['nt_message'] = $login_user['trading_name'] .' responded to the milestone payment dispute. <a href="'. site_url('dispute/'.$mile_id.'/'.$job_id).'">View & reply!</a>';
      }else{
        $insertn['nt_message'] = ''.$login_user['f_name'].' '.$login_user['l_name'].' responded to the milestone payment dispute. <a href="'. site_url('dispute/'.$mile_id.'/'.$job_id).'">View & reply!</a>';
      }
      $insertn['nt_satus'] = 0;
      $insertn['nt_apstatus'] = 0;
      $insertn['nt_create'] = date('Y-m-d H:i:s');
      $insertn['nt_update'] = date('Y-m-d H:i:s');
      $insertn['job_id'] = $job_id;
      $insertn['posted_by'] = $puser;
      $run2 = $this->common_model->insert('notification',$insertn);

			if($type==1){ 	
				$subject = $login_user['f_name'] ." has replied to the milestone payment dispute “" .$jobDetails['title'] ."”";
				
				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' .$user['f_name'] .'</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">You´ve received a new reply from '.$login_user['f_name'].' on the milestone payment dispute for job “'.$jobDetails['title'].'”. We encourage you to respond as soon as possible to resolve your issue.</p>';
				
				$contant .= '<br><div style="text-align:center"><a href="'.site_url('dispute/'.$mile_id.'/'.$job_id) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reply Now</a></div><br>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A',strtotime($end_time)) .' will result in closing this case and deciding in the client favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p>';
				
				$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$this->common_model->send_mail($to_mail, $subject, $contant);
			
			} else {
				
				$subject = $login_user['trading_name']." has replied to the milestone payment dispute: “" .$jobDetails['title'] ."”";
			
				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' .$user['f_name'] .'</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">You\'ve received a new reply from '.$login_user['trading_name'].' on the milestone payment dispute for job “' .$jobDetails['title'] .'”. We encourage you to respond as soon as possible to resolve the issue.</p>';
				
				$contant .= '<br><div style="text-align:center"><a href="'.site_url('dispute/'.$mile_id.'/'.$job_id) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View and reply now</a></div><br>';
				
				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A',strtotime($end_time)) .' will result in closing this case and deciding in favour of '.$login_user['trading_name'].'. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
				
				$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$this->common_model->send_mail($to_mail, $subject, $contant);
			}
      $_SESSION['succ'] = 'Your comment has been submitted successfully.';

      //$db->redirect('dispute.php?tsr_id='.$tsr_id);
      $this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
      redirect('dispute/'.$mile_id.'/'.$job_id);
    }
  }

}