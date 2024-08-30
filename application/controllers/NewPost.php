<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class NewPost extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		error_reporting(0);

	}
	
	
	
	public function reject_award_homeowner($post_id,$job_id) {
		
		$job_data = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$job_id));
		$bid_data = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$post_id));
		
		
		if($job_data && $bid_data){ 
			$homeOwner = $this->common_model->get_single_data('users',array('id'=>$job_data['userid']));
			
			$tradeMen = $this->common_model->get_single_data('users',array('id'=>$bid_data['bid_by']));
			
			if($bid_data['total_milestone_amount'] > 0){
		
				$update2['u_wallet']=$homeOwner['u_wallet']+$bid_data['total_milestone_amount'];
				$update2['spend_amount']=$homeOwner['spend_amount']-$bid_data['total_milestone_amount'];
			
				$runss1 = $this->common_model->update('users',array('id'=>$job_data['userid']),$update2);
				
				$transactionid = md5(rand(1000,999).time());
				
				if($bid_data['hiring_type']==1){
				
					$tr_message = '£'.$bid_data['total_milestone_amount'].' has been credited to your wallet. You has rejected your proposal for <a href="'.site_url().'details/?post_id='.$job_data['job_id'].'">'.$job_data['title'].'</a>';
				
				} else {
					
					$tr_message = '£'.$bid_data['total_milestone_amount'].' has been credited to your wallet. You has rejected your proposal for '.$job_data['title'];
					
				}
			 
				$data1 = array(
					'tr_userid'=>$homeOwner['id'], 
					'tr_amount'=>$bid_data['total_milestone_amount'],
					'tr_type'=>1,
					'tr_transactionId'=>$transactionid,
					'tr_message'=>$tr_message,
					'tr_status'=>1,
					'tr_created'=>date('Y-m-d H:i:s'),
					'tr_update' =>date('Y-m-d H:i:s')
				);
				
				$run1 = $this->common_model->insert('transactions',$data1);
				
			}
			
			
			
			/*
      if($bid_data['hiring_type']==1){
				$insertn2['nt_message'] = $homeOwner['f_name'].'has rejected proposal for '.$job_data['title'];
			} else {
				$insertn2['nt_message'] = $homeOwner['f_name'].'has rejected proposal for <a href="'.site_url().'details/?post_id='.$job_data['job_id'].'">'.$job_data['title'].'</a>';
			}
      */
      $insertn2['nt_message'] = $homeOwner['f_name'] . ' ' .$homeOwner['l_name'] .' withdrew the offer as you didn\'t respond in time.';
			
			
			
			$insertn2['nt_userId']=$tradeMen['id'];
			$insertn2['nt_satus']=0;
			$insertn2['nt_create']=date('Y-m-d H:i:s');
			$insertn2['nt_update']=date('Y-m-d H:i:s');
			$insertn2['job_id']=$bid_data['job_id'];
			$insertn2['posted_by']=$homeOwner['id'];
			$insertn2['nt_apstatus']=3;
				
			$this->common_model->insert('notification',$insertn2);
			
			$update['status'] = 1;
			$update['awarded_to'] = 0;
			
			$where_array1=array('job_id'=>$bid_data['job_id']);
			
			if($job_data['direct_hired']==1){
				$this->common_model->delete($where_array1,'tbl_jobs');
			} else {
				$this->common_model->update('tbl_jobs',$where_array1,$update);
			}
			
			$this->common_model->delete(array('id'=>$bid_data['id']),'tbl_jobpost_bids'); 
			$this->common_model->delete(array('bid_id'=>$bid_data['id']),'tbl_milestones'); 

			$subject = "You proposal has been rejected for the ".$job_data['title']." job"; 
			$content= 'Hello '.$homeOwner['f_name'].', <br><br>';
			
			$content.='<p class="text-center"><a href="'.site_url().'profile/'.$tradeMen['id'].'">'.$tradeMen['trading_name'].'</a> has rejected your proposal for <a href="'.site_url().'details/?post_id='.$bid_data['job_id'].'">'.$job_data['title'].'</a>.</p>';
			
			$has_email_noti = $this->common_model->check_email_notification($tradeMen['id']);
							
			if($has_email_noti){
			
				// $subject = "Awarded has been rejected for the ".$job_data['title']." job";
				$subject = "Unfortunately! ".$tradeMen['trading_name']." has declined your job offer for the job: ".$job_data['title']."!";
				
		
				// $content.='<p class="text-center">'.$homeOwner['f_name'].' has cancel the awarded for the job post <b>'.$job_data['title'].'</b></p>';
				$content= 'Hi '.$has_email_noti['f_name'].', <br><br>';
				$content.='<p class="text-center">Unfortunately! '.$tradeMen['trading_name'].' has declined to begin work on your project '.$job_data['title'].'!</b></p>';
				$content.='<p class="text-center">As your next step, you can award the job to another tradesperson or increase your budget to attract more skilled tradespeople</b></p>';



				if($job_data['direct_hired']==0){
					$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit</a>&nbsp;&nbsp;<a href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Award</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="color:grey">'.site_url().'payments/?post_id='.$bid_data['job_id'].'</a></p>';
				}

				$content.='<p class="text-center">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</b></p>';
				
				$this->common_model->send_mail($has_email_noti['email'],$subject,$content);


				$subject1 = "Job offer on  “".$job_data['title']."” has been retracted!";
				$content1= 'Hi '.$has_email_noti['f_name'].', <br><br>';
				$content1.= 'Your job offer by '.$homeOwner['f_name'].' has been retracted as you didn\'t respond on time. <br><br>';
				$content1.= 'Job: '.$job_data['title'].'!<br><br>';
				$content1.= 'As your next step, you can discuss and ask  '.$homeOwner['f_name'].'  to re-award you the job.  <br><br>';
				$contant1.= '<br><div style="text-align:center"><a href="'.site_url('proposals?post_id='.$job_data['job_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Discuss Now </a></div><br>';
				$content1.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.<br><br>';


				$this->common_model->send_mail($has_email_noti['email'],$subject1,$content1);

			
			}
			
			$has_email_noti = $this->common_model->check_email_notification($homeOwner['id']);
				
			if($has_email_noti){
				
				// $subject = "Awarded has been rejected for the ".$job_data['title']." job";
				$subject = "Unfortunately! ".$tradeMen['trading_name']." has declined your job offer for the job: ".$job_data['title']."!";
				
				// $content= 'Hello '.$has_email_noti['f_name'].', <br><br>';
		
				// $content.='<p class="text-center">You have cancel the awarded for the job post <b>'.$job_data['title'].'</b></p>';
				$content= 'Hi '.$has_email_noti['f_name'].', <br><br>';
				$content.='<p class="text-center">Unfortunately! '.$tradeMen['trading_name'].' has declined to begin work on your project '.$job_data['title'].'!</b></p>';
				$content.='<p class="text-center">As your next step, you can award the job to another tradesperson or increase your budget to attract more skilled tradespeople</b></p>';

				if($job_data['direct_hired']==0){
					$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit</a>&nbsp;&nbsp;<a href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Award</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$bid_data['job_id'].'" style="color:grey">'.site_url().'payments/?post_id='.$bid_data['job_id'].'</a></p>';
				}
				
				$content.='<p class="text-center">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</b></p>';

				$this->common_model->send_mail($has_email_noti['email'],$subject,$content);
			
			}
			
			
		
			$this->session->set_flashdata('success1', '<p class="alert alert-success">Success! Project has been rejected successfully.</p>');
			
			if($job_data['direct_hired']==1){
				redirect('dashboard');
			} else {
				redirect('proposals/?post_id='.$bid_data['job_id']);
			}
		} else {
			redirect('proposals/?post_id='.$job_id);
		}

	}
	
	
	function repost($job_id,$page){
		
		$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$job_id));
		
		$user_id = $this->session->userdata('user_id');
		
		if($user_id){
			
			if($user_id == $get_job_post['userid']){
				
				
				$get_commision=$this->common_model->get_commision(); 
				$closed_date=$get_commision[0]['closed_date'];
				$c_date = date('Y-m-d H:i:s');
				
				$job_end_date= date('Y-m-d H:i:s', strtotime($c_date. ' + '.$closed_date.' days'));
				
				$runss12 = $this->common_model->update_data('tbl_jobs',array('job_id'=>$job_id),array('c_date'=>date('Y-m-d H:i:s'),'job_end_date'=>$job_end_date));
				
				if($runss12){
					
					$this->session->set_flashdata('msg2','<div class="alert alert-success">job has been reposted successfully.</div>');
					
				} else {
					
					$this->session->set_flashdata('msg2','<div class="alert alert-danger">Something went wrong.</div>');
					
				}
				
			} else {
				$this->session->set_flashdata('msg2','<div class="alert alert-danger">Something went wrong.</div>');
			}
			redirect($page.'?post_id='.$job_id);
		} else {
			redirect('login');
		}
			
	}
	
	function release_amount1($mile_id,$post_id,$job_id) {
	
		//$get_milestones=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mile_id));

		//$get_post_job = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$get_milestones['bid_id']));
		
		$user_id = $this->session->userdata('user_id');
		
		$sql = "select * from tbl_milestones where id = '".$mile_id."' and (status=0 or status = 3) and posted_user = '".$user_id."'";
		$run = $this->db->query($sql);
		if($run->num_rows() > 0){
		$get_milestones = $run->row_array();
		
		$sql2 = "select * from tbl_jobpost_bids where id = '".$get_milestones['bid_id']."'";
		$run2 = $this->db->query($sql2);
		$get_post_job = $run2->row_array();
		
		$amount = $get_milestones['milestone_amount'];
		
		$pamnt = $get_post_job['paid_total_miles'];
		$final_amount = $pamnt + $amount;
		if($get_milestones['status']==0 || $get_milestones['status']==3) {
			//$this->common_model->update_data('tbl_jobpost_bids',array('id'=>$get_milestones['bid_id']),array('paid_total_miles2'=>$paid_total_miles));
			
			$sql3 = "update tbl_jobpost_bids set paid_total_miles = '".$final_amount."' where id = '".$get_milestones['bid_id']."'";
			$this->db->query($sql3);

			$get_commision=$this->common_model->get_single_data('admin',array('id'=>1));
		
			$commision=$get_commision['commision'];
			$this->common_model->update_data('tbl_milestones',array('id'=>$mile_id),array('status'=>2,'admin_commission'=>$commision));

			$total = ($amount*$commision)/100;
		
			$amounts = $amount-$total;
		
			$bid_by=$get_post_job['bid_by'];
		
			$get_users=$this->common_model->get_single_data('users',array('id'=>$bid_by));
		
			$get_homeuser=$this->common_model->get_single_data('users',array('id'=>$get_post_job['posted_by']));
		
		
			$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_milestones['post_id']));
		
		
			$post_title=$get_job_post['title'];
		
			$cdate=strtotime($get_milestones['cdate']);

		
			$json['status']=1;
			//$this->session->set_flashdata('success2', 'Success! Amount has been released successfully.');
		
			$custme_redirect = 'payments/?post_id='.$get_post_job['job_id'];

			if($final_amount >= $get_post_job['bid_amount']) {
				$updatej['status']=5;
				$updatej['update_date']=date('Y-m-d H:i:s');
				
				$runss12 = $this->common_model->update_data('tbl_jobs',array('job_id'=>$get_milestones['post_id']),$updatej);
					
				
				$updatejs['status']=4;
				$updatejs['update_date']=date('Y-m-d H:i:s');
				
				$runss123 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$get_post_job['id']),$updatejs);	
				
				
				$insertn['nt_userId']=$get_post_job['bid_by'];
				$insertn['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">'.$get_homeuser['f_name'].' '.$get_homeuser['l_name'].'.</a>';
				$insertn['nt_satus']=0;
				$insertn['nt_apstatus']=2;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');   
				$insertn['job_id']=$get_post_job['job_id'];
				$insertn['posted_by']=$get_post_job['posted_by'];
				$run2 = $this->common_model->insert('notification',$insertn);
				
					
				$subject = "Congratulations on Completing the Job: “".$post_title."”";
		
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$get_users['f_name'].',</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “'.$post_title.'”! Your milestone payments has now been released and can be withdrawn. </p>';
				$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for '.$get_homeuser['f_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
				
				$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';
				
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$runs1=$this->common_model->send_mail($get_users['email'],$subject,$html);
				
				$subject = "Congratulations on Job Completion: “".$post_title."”";
			
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$get_homeuser['f_name'].',</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “'.$post_title.'”! completed successfully and milestone payments released to '.$get_users['trading_name'].'.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to '.$get_users['trading_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
				
				$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';
				
				$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>'; 
				
				$runs1=$this->common_model->send_mail($get_homeuser['email'],$subject,$html);
					
				
			
				$insertn1['nt_userId']=$get_post_job['posted_by'];
				// $insertn1['nt_message']='Congratulation this project has been completed successfully.You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
        $insertn1['nt_message'] = 'Congratulations! Your job has been completed. <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">Rate ' .$get_users['trading_name'] .'!</a>';
						
				$insertn1['nt_satus']=0;
				$insertn1['nt_apstatus']=2;
				$insertn1['nt_create']=date('Y-m-d H:i:s');
				$insertn1['nt_update']=date('Y-m-d H:i:s');   
				$insertn1['job_id']=$get_post_job['job_id'];
				$insertn1['posted_by']=$get_post_job['bid_by'];
				$this->common_model->insert('notification',$insertn1);

				$json['status']=2;
				//$this->session->set_flashdata('success2', '<p class="alert alert-success">Success! Amount has been released successfully and job has been completed Please rate the Job and share your experience.</p>');
				
				$custme_redirect = 'reviews/?post_id='.$get_post_job['job_id'];
			} else {
				$this->session->set_flashdata('message', '<p class="alert alert-success">Success! Amount has been released successfully.</p>');
			}
				
			$u_wallet=$get_users['u_wallet'];
			//$update1['u_wallet']=$u_wallet+$amounts;
			
			$withdrawable_balance=$get_users['withdrawable_balance'];
			$update1['withdrawable_balance']=$withdrawable_balance+$amounts;
			
			$runss1 = $this->common_model->update_data('users',array('id'=>$bid_by),$update1);
			
		
			$transactionid = md5(rand(1000,999).time());
			$tr_message='£'.$amounts.' has been credited in your wallet for releasing amount of '.$get_milestones['milestone_name'].' milestone for the job post <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> on date '.date('d-m-Y h:i:s A');
			$data1 = array(
					'tr_userid'=>$bid_by, 
					'tr_amount'=>$amounts,
					'tr_type'=>1,
					'tr_transactionId'=>$transactionid,
					'tr_message'=>$tr_message,
					'tr_status'=>1,
					'tr_created'=>date('Y-m-d H:i:s'),
					'tr_update' =>date('Y-m-d H:i:s')
			);
			$run1 = $this->common_model->insert('transactions',$data1);
			
			$has_email_noti = $this->common_model->check_email_notification($get_post_job['bid_by']);
						
			if($has_email_noti){
				
				$subject = $get_homeuser['f_name'].", Released the Milestone Payment for “".$post_title."”";
				
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone Payment Released!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">'.$get_homeuser['f_name'].' has released a milestone payment for the job “'.$post_title.'.” </p>';
				$html .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$amount.'</p>';
				$html .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to transfer the money to your UK bank account.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperpeople help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html);
				
			}
			
			$subject = "You´ve successfully released Milestone Payment to ".$get_users['trading_name']." for “".$post_title."”."; 
					
			
			$html = '<p style="margin:0;padding:10px 0px">Milestone Payment Released Successfully!</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_homeuser['f_name'] .',</p>';

			$html .= '<p style="margin:0;padding:10px 0px">Your milestone payment has been released successfully to '.$get_users['trading_name'].'.</p>';
			
			$html .= '<p style="margin:0;padding:0px 0px">Job: '.$post_title.'</p>';
			$html .= '<p style="margin:0;padding:0px 0px">Milestone released amount: £'.$amount.'</p>';
			
			
			$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$this->common_model->send_mail($get_homeuser['email'],$subject,$html);
			
					
			
			$insertn['nt_userId']=$get_post_job['bid_by'];
			$insertn['nt_message']=$get_homeuser['f_name'].' '.$get_homeuser['l_name'].' has released the milestone payment: <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'">Amount £'.$amount.'</a>';
			$insertn['nt_satus']=0;
			$insertn['nt_apstatus']=2;
			$insertn['nt_create']=date('Y-m-d H:i:s');
			$insertn['nt_update']=date('Y-m-d H:i:s');   
			$insertn['job_id']=$get_post_job['job_id'];
			$insertn['posted_by']=$get_post_job['posted_by'];
			$run2 = $this->common_model->insert('notification',$insertn);
		
			
		}
		
		if($final_amount >= $get_post_job['bid_amount'])
		{
			redirect('reviews/?post_id='.$get_post_job['job_id']);
		} else {
			redirect('payments/?post_id='.$get_post_job['job_id']);
		}
		
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Something went wrong try again later.</div>');
			redirect('payments/?post_id='.$job_id);
		}
	
	 
	}
}