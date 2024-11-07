<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bids extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020','0','1','2','3','4','5','6','7','8','9','@','www','http://','https://','.com','.uk','.co.uk','.gov.uk','.me.uk','.ac.uk','.org.uk','.Itd.uk','.mod.uk ','.mil.uk','.net.uk','.nic.uk','.nhs.uk','.pic.uk','.sch.uk','.pic.uk:','.info','.io','.cloud','.online','.ai','.net','.org');
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

  public function send_resend_request($id) {
		$data = $this->common_model->get_single_data('tbl_milestones',array('id'=>$id));
		
		
		if($data){
			
			$has_email_noti = $this->common_model->check_email_notification($data['posted_user']);
						
			if($has_email_noti){
				
				$trades = $this->common_model->get_userDataByid($data['userid']);
				$post_data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$data['post_id']),array('title'));
			 
				$subject = "Milestone Request";
				
				$content= 'Hello '.$has_email_noti['f_name'].', <br><br>';
		
				$content.='<p class="text-center">'.$trades['trading_name'].' has request to create milestone for the job post <b>'.$post_data['title'].'</b> of amount £'.$data['milestone_amount'].' .</p>';
				$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$data['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$data['post_id'].'" style="color:grey">'.site_url().'payments/?post_id='.$data['post_id'].'</a></p>';
				$this->common_model->send_mail($has_email_noti['email'],$subject,$content);
				
				$insertn['nt_userId']=$data['posted_user'];
				
				$insertn['nt_message']='<a href="'.site_url().'profile/'.$trades['id'].'">'.$trades['trading_name'].'</a> has request to create milestone for the job post <a href="'.site_url().'payments?post_id='.$data['post_id'].'">'.$post_data['title'].'</a> of amount £'.$data['milestone_amount'].'.';
				
				$insertn['nt_satus']=0;
				
				$insertn['nt_apstatus']=2;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$data['post_id'];
				
				$insertn['posted_by']=$trades['id'];
				
				$run2 = $this->common_model->insert('notification',$insertn);
				$run2 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$data['bid_id']),array('miles_noti_status_by_trades'=>1,'update_date'=>date('Y-m-d H:i:s')));
			
			}
			
			echo json_encode(array('status'=>1));
		} else {
			echo json_encode(array('status'=>0));
		}
		
	}
  public function update_bid($post_id) {
    $this->form_validation->set_rules('bid_amount','Quote Amount','required');
    $this->form_validation->set_rules('delivery_days','Project Delivered in','required');
    $this->form_validation->set_rules('propose_description','Describe Proposal','required');
    if ($this->form_validation->run()==false) {
      $json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
    } else {
    	/*-------------Detect Contact Detail In Proposal Description Code Start-------------*/

			$propose_description = $this->input->post('propose_description');
			foreach ($this->words as $url) {				
				if (strpos($propose_description, $url) !== FALSE) {
					$json['block_word'] = $url;
					$json['status'] = 7; break;
				}
			}

			if($json['status'] == 7){
				$json['msg'] = 'Contact detail detected. Remove it and use the chat feature to contact the client.';
				echo json_encode($json);
				exit;	
			}

			/*-------------Detect Contact Detail In Proposal Description Code End-------------*/    	

      $insert['bid_amount']=$this->input->post('bid_amount');
      $insert['delivery_days']=$this->input->post('delivery_days');
      $insert['propose_description']=$this->input->post('propose_description');
      $run=$this->common_model->update('tbl_jobpost_bids',array('id'=>$post_id),$insert);
      //if($run) {
        $this->common_model->delete(array('bid_id'=>$post_id),'tbl_milestones');

        $data = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$post_id));
				$other_user = $this->common_model->GetColumnName('users',array('id'=>$data['bid_by']),'');
				// $post_data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$data['post_id']),array('title'));
				$post_data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$data['job_id']),array('title', 'userid'));

				$post_by_user = $this->common_model->GetColumnName('users',array('id'=>$post_data['userid']),'');
// echo "<pre>"; print_r($post_by_user); exit;
				/*
	$isAlreadyEarnRefferedUser = $this->common_model->get_single_data("referrals_earn_list", array("user_id"=>$post_data['userid'], 'earn_amount'=>""));
				if ($isAlreadyEarnRefferedUser) {
					 
				}
				*/
        if($this->input->post('tsm_name')){
          $tsm_name_arr = $this->input->post('tsm_name');
          $tsm_amount_arr = $this->input->post('tsm_amount');
          foreach($_REQUEST['tsm_name'] as $key => $row){
            $tsm_name = $tsm_name_arr[$key];
            $tsm_amount = $tsm_amount_arr[$key];

            $insert_mile = array();
            $insert_mile['milestone_name'] = $tsm_name;
            $insert_mile['milestone_amount'] = $tsm_amount;
            $insert_mile['userid'] = $data['bid_by'];
            $insert_mile['post_id'] = $data['job_id'];
            $insert_mile['cdate'] = date('Y-m-d');
            $insert_mile['status'] = 0;
            $insert_mile['posted_user'] = $data['posted_by'];
            $insert_mile['created_by'] = $data['bid_by'];
            $insert_mile['bid_id'] = $data['id'];
            $insert_mile['is_requested'] = 0;
            $insert_mile['is_suggested'] = 1;
            $insert_mile['is_dispute_to_traders'] = 0;
            $this->common_model->insert('tbl_milestones',$insert_mile);
          }
        }
						
				$subject = $other_user['trading_name']." has updated their Quote!"; 
				$content= 'Hi '.$post_by_user['f_name'].', <br><br>';
				$content.= $other_user['trading_name'].' has updated their quote on the job '.$post_data['title'].'.<br><br>';
				$content.= 'We encourage you to review the update and  initiating a conversation with '.$other_user['trading_name'].' .<br><br>';
				$content.='<div style="text-align:center"><a href="'.site_url().'details?post_id='.$data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review quote now</a></div><br>';
				$content.= 'Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.<br>';

				$runs1=$this->common_model->send_mail($post_by_user['email'], $subject,$content);



				$subject1 = "Your quote was updated successfully!"; 
				$content1= 'Hi '.$other_user['f_name'].', <br><br>';
				$content1.= 'Your quote on the job “'.$post_data['title'].'” was updated successfully.  '.$post_by_user['f_name'].' will review and discuss with you.<br><br>';
				$content1.= 'We encourage you to follow up the quote by initiating a conversation with '.$post_by_user['f_name'].'.<br><br>';
				$content1.= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Chat now</a></div><br>';
				$content1.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.<br><br>';

				// $runs1=$this->common_model->send_mail($post_by_user['email'], $subject1,$content1);
				$runs2=$this->common_model->send_mail($other_user['email'], $subject1,$content1); //trads man gma9il


        $json['status'] = 1;
        // $this->session->set_flashdata('msg','<div class="alert alert-success">Success! Your quote details updated successfully.</div>');
        $this->session->set_flashdata('msg','<div class="alert alert-success">Success! Your quote has been updated successfully.</div>');

      /*} else {
        $json['status'] = 0;
        $json['msg'] = '<div class="alert alert-danger">We have not found any changes in your quote details.</div>';
      }*/
    }
    echo json_encode($json);
  }

  public function apply_post() {
		 
		$user_id = $this->session->userdata('user_id');
		$get_users=$this->common_model->get_single_data('users',array('id'=>$user_id));
		$setting = $this->common_model->get_all_data('admin');
		if($get_users['u_email_verify']==1){
			if($setting[0]['payment_method'] == 0 && empty($get_users['about_business'])){
					$json['status'] = 0;
					$profileUrl = site_url().'edit-profile';
					$json['msg'] = '<div class="alert alert-danger">You can\'t submit a quote until you\'ve completed your profile. <a href="'.$profileUrl.'">Click here to complete it.</a></div>';
			}else {
				$this->form_validation->set_rules('bid_amount','Quote Amount','required');
				$this->form_validation->set_rules('delivery_days','Project Delivered in','required');
				$this->form_validation->set_rules('propose_description','Describe Proposal','required');
				if ($this->form_validation->run()==false) {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
				} else {
					/*-------------Detect Contact Detail In Proposal Description Code Start-------------*/

					$propose_description = $this->input->post('propose_description');
					foreach ($this->words as $url) {				
						if (strpos($propose_description, $url) !== FALSE) {
							$json['block_word'] = $url;
							$json['status'] = 7; break;
						}
					}

					if($json['status'] == 7){
						$json['msg'] = 'Contact detail detected. Remove it and use the chat feature to contact the client.';
						echo json_encode($json);
						exit;	
					}

					/*-------------Detect Contact Detail In Proposal Description Code End-------------*/

					$job_id = $this->input->post('post_id');
					$get_jobs = $this->common_model->get_job_details($job_id);
					$get_commision=$this->common_model->get_commision();
					$credit_amount=$get_commision[0]['credit_amount'];
					$check = false;
					$update_wallet = false;
					$update_plan = false;
					$calculate_ref = true;
					if($user_id) {
						$get_plan_bids=$this->common_model->get_user_bids('user_plans',$user_id);
						$get_post_bid=$this->common_model->get_post_bids('tbl_jobpost_bids',$job_id,$user_id);
						if($get_post_bid) {
							$json['status'] = 0;
							$json['msg'] = '<div class="alert alert-danger">You have already placed a quote on this job post.</div>';
						} else {
							if($setting[0]['payment_method'] == 1){
								if($get_plan_bids) {
									if($get_plan_bids[0]['up_status']==1 && strtotime($get_plan_bids[0]['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids[0]['valid_type']==1) {
										if($get_plan_bids[0]['bid_type']==2) {
											$check = true;
											//$update_plan = true;
											$json['status1'] = 121;
											if($get_plan_bids[0]['up_amount']<=0){
												$calculate_ref = false;
											}
										} else if($get_plan_bids[0]['bid_type']==1) {
											//echo $get_plan_bids[0]['up_used_bid']; echo '/'; echo $get_plan_bids[0]['up_bid'];
											if($get_plan_bids[0]['up_used_bid'] < $get_plan_bids[0]['up_bid']) {
												$check = true;
												$update_plan = true;
												$json['status1'] = 11;

												if($get_plan_bids[0]['up_amount']<=0){
													$calculate_ref = false;
												}

											} else if($get_users['u_wallet'] >= $credit_amount) {
												$check = true;
												$update_wallet = true;
												$json['status1'] = 2;
											} else {
												$json['status'] = 2;
												$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
											}
										} else if($get_users['u_wallet'] >= $credit_amount){
											$check = true;
											$update_wallet = true;
											$json['status1'] = 3;
										} else {
											$json['status'] = 2;
											$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
										}
									} else if($get_users['u_wallet'] >= $credit_amount){
										$check = true;
										$update_wallet = true;
										$json['status1'] = 4;
									} else {
										$json['status'] = 2;
										$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
									}
								} else if($get_users['u_wallet'] >= $credit_amount) {
									$check = true;
									$update_wallet = true;
									$json['status1'] = 5;
								} else {
									$json['status'] = 2;
									$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
								}
							}else{
								$check = true;
								/*$json['status'] = 1;*/
							}
						}

						/*success code here*/
						if($check){
							$bid_by = $user_id;
							$posted_by = $this->input->post('posted_by');
							
							$insert['bid_amount'] = $this->input->post('bid_amount');
							$insert['delivery_days'] = $this->input->post('delivery_days');
							$insert['propose_description'] = $this->input->post('propose_description');
							$insert['bid_by'] = $bid_by;
							$insert['job_id'] = $job_id;
							$insert['posted_by'] = $posted_by;
							$insert['cdate'] = date('Y-m-d H:i:s');
							$insert['paid_total_miles'] = 0;

							$run = $this->common_model->insert('tbl_jobpost_bids',$insert);

							if($calculate_ref){
								// earn referral 
								$settings = $this->common_model->get_all_data('admin');
								if($settings[0]['payment_method'] == 1){
									$this->common_model->earn_refer_to_tradsman($bid_by); //checking tradesmen invited
									$this->common_model->earn_refer_to_homeowner($posted_by);//checking homeowner invited	
								}								
							}
							$get_post_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['userid']));
							

							$notArr = [];
							$notArr['title'] = 'New Quote';
							$notArr['message'] = 'You´ve got a new quote from '.$get_users['trading_name'];
							$notArr['link'] = site_url().'proposals/?post_id='.$job_id;
							$notArr['user_id'] = $get_jobs[0]['userid'];
							$notArr['behalf_of'] = $bid_by;
							$this->common_model->AndroidNotification($notArr);

							$OneSignalNoti = [];
							$OneSignalNoti['title'] = 'New Quote';
							$OneSignalNoti['message'] = 'You´ve got a new quote from '.$get_users['trading_name'];
							$OneSignalNoti['is_customer'] = true;
							$OneSignalNoti['user_id'] = $get_jobs[0]['userid'];
							/*$OneSignalNoti['pushdata']['message_type'] = 'recieved_quote';
							$OneSignalNoti['pushdata']['link'] = site_url().'proposals/?post_id='.$job_id; //in push data array you can send any data
							$OneSignalNoti['pushdata']['customer_id'] = $get_jobs[0]['userid'];
							$OneSignalNoti['pushdata']['job_id'] = $job_id; 
							$OneSignalNoti['pushdata']['tradesmen_id'] = $bid_by;*/

							$OneSignalNoti['pushdata']['action'] = 'add_quote';
							$OneSignalNoti['pushdata']['other_user_id'] = $bid_by;
							$OneSignalNoti['pushdata']['user_id'] = $get_jobs[0]['userid'];
							$OneSignalNoti['pushdata']['action_id'] = $job_id; 
							
							
							//print_r($OneSignalNoti);
							$return = $this->common_model->OneSignalNotification($OneSignalNoti);
							//print_r($return);

							$insertn = [];
							$insertn['nt_userId']=$get_jobs[0]['userid'];
							// $insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a>';
							$insertn['nt_message']='You´ve got a new quote from '.$get_users['trading_name'] .'. <a href="'.site_url().'proposals/?post_id='.$job_id.'">View quote!</a>';

							$insertn['nt_satus'] = 0;
							$insertn['nt_create'] = date('Y-m-d H:i:s');
							$insertn['nt_update'] = date('Y-m-d H:i:s');
							$insertn['job_id'] = $job_id;
							$insertn['posted_by'] = $bid_by;
							$insertn['action']=$OneSignalNoti['pushdata']['action'];
							$insertn['action_id']=$OneSignalNoti['pushdata']['action_id'];
							$insertn['action_json']=json_encode($OneSignalNoti['pushdata']);
							$run2 = $this->common_model->insert('notification',$insertn);
							
							if($update_wallet && $setting[0]['payment_method'] == 1){
								$update['u_wallet']=$get_users['u_wallet']-$credit_amount;
								$runs = $this->common_model->update('users',array('id'=>$user_id),$update);
								
								$transactionid = md5(rand(1000,999).time());
								$tr_message='£'.$credit_amount.' has been debited to your wallet for placing a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'.</a>';
								$data1 = array(
									'tr_userid'=>$user_id, 
									'tr_amount'=>$credit_amount,
									'tr_type'=>2,
									'tr_transactionId'=>$transactionid,
									'tr_message'=>$tr_message,
									'tr_status'=>1,
									'tr_created'=>date('Y-m-d H:i:s'),
									'tr_update' =>date('Y-m-d H:i:s')
								);
								$run1 = $this->common_model->insert('transactions',$data1);
							}
							if($update_plan){
								$update['up_used_bid']=$get_plan_bids[0]['up_used_bid']+1;
								$runs = $this->common_model->update('user_plans',array('up_id'=>$get_plan_bids[0]['up_id']),$update);
							}
							
							$subjectB = "You´ve got a new quote from ".$get_users['trading_name']." for the job:  ".$get_jobs[0]['title'];
							
							$htmlB = '<p style="margin:0;padding:10px 0px">Hi ' . $get_post_user['f_name'] .',</p>';
							$htmlB .= '<p style="margin:0;padding:10px 0px">You´ve got a new quote from '.$get_users['trading_name'].'. Please review and discuss with them. If you think they´re the perfect fit for the work, award them the job.</p>';
							
							$htmlB .= '<tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="10" width="100%"><tbody><tr><td align="left" valign="top" style="color:#444;font-size:14px"><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">';
								
							$htmlB .= $this->get_profile_loop($get_users['id'],$job_id,$insert['bid_amount']);
							
							$htmlB .= '</table></td></tr></td></tr></tbody></td></tr>';
							
							$htmlB .= '<br><p style="margin:0;padding:10px 0px">We suggest not making decisions on price alone. Read their profiles and feedback to help you decide who to hire.</p>';
							$htmlB .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
							$this->common_model->send_mail($get_post_user['email'],$subjectB,$htmlB);

							$subject = "Your quote submitted successfully!";
							$html = 'Hi ' .$get_users['f_name'].',<br><br>';
							$html.= 'Your quote on the job “'.$get_jobs[0]['title'].'” was submitted successfully. '.$get_post_user['f_name'].' will review it and discuss with you.<br><br>';
							$html.= 'We encourage you to follow the quote up by initiating a conversation with '.$get_post_user['f_name'].'.<br><br>';
							$html.= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Chat now</a></div><br><br>';
							$html.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.<br><br>';

							$runs1=$this->common_model->send_mail($get_users['email'],$subject,$html);

							if($this->input->post('tsm_name')){
								$tsm_name_arr = $this->input->post('tsm_name');
								$tsm_amount_arr = $this->input->post('tsm_amount');
								foreach($_REQUEST['tsm_name'] as $key => $row){
									$tsm_name = $tsm_name_arr[$key];
									$tsm_amount = $tsm_amount_arr[$key];

									$insert_mile = array();
									$insert_mile['milestone_name'] = $tsm_name;
									$insert_mile['milestone_amount'] = $tsm_amount;
									$insert_mile['userid'] = $user_id;
									$insert_mile['post_id'] = $job_id;
									$insert_mile['cdate'] = date('Y-m-d');
									$insert_mile['status'] = 0;
									$insert_mile['posted_user'] = $posted_by;
									$insert_mile['created_by'] = $user_id;
									$insert_mile['bid_id'] = $run;
									$insert_mile['is_requested'] = 0;
									$insert_mile['is_suggested'] = 1;
									$insert_mile['is_dispute_to_traders'] = 0;
									$this->common_model->insert('tbl_milestones',$insert_mile);
								}
							}
							$json['status'] = 1;
							$_SESSION['quote_success'] = '<p class="alert alert-success">Thank you for submitting your quote. The homeowner will review it and get back shortly.</p>';
							/*$this->session->set_flashdata('quote_success', '<p class="alert alert-success">Thank you for submitting your quote. The homeowner will review it and get back shortly.</p>');
							print_r($_SESSION);*/
						}
						/*success code here*/

					} else {
						$json['status'] = 0;
						$check = false;
						$json['msg'] = '<div class="alert alert-danger">Please login to place quote.</div>';
					}
				}				
			}			
		} else {
			$json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">You can\'t submit a quote until you\'ve verified your email address.</div>';
		}
		echo json_encode($json);
  }
	
	public function get_profile_loop($user_id=null,$job_id=null,$price=null,$sender=null){
		
		$userdata = $this->common_model->GetColumnName('users', array('id' => $user_id),array('trading_name','city','county','cdate','total_reviews','average_rate','profile'));
		
		$profile = site_url().'img/profile/dummy_profile.jpg';
		
		if($userdata['profile']){
			$profile = site_url().'img/profile/'.$userdata['profile'];
		}
		
		$html = '<tr>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; width: 100px; vertical-align: top;" >
							<img src="'.$profile.'" style="width: 100%; height: 122px; object-fit: cover; border-radius: 5px;">
						</td>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; color: #464c5b; vertical-align: top;">
							<span style="font-size: 20px; font-weight: 600; display: inline-block; margin-bottom: 7px;">'.$userdata['trading_name'].'</span><br>
							<span style="font-size: 15px; display: inline-block; margin-bottom: 7px;"><img src="https://www.tradespeoplehub.co.uk/img_us_1.png" style="margin-right: 5px; vertical-align: middle;"> '.$userdata['city'].', '.$userdata['county'].' </span><br>
							<span style="font-size: 15px; display: inline-block; margin-bottom: 7px;"><img src="https://www.tradespeoplehub.co.uk/img_us_2.png" style="margin-right: 5px; vertical-align: middle;">  Member since '.date('M Y',strtotime($userdata['cdate'])).'  </span><br>
							<span style="font-size: 14px; display: inline-block; margin-bottom: 7px;">
								<span style="background: #e77803; color: #fff; display: inline-block; padding: 2px 6px; border-radius: 3px;">'.$userdata['average_rate'].'</span> <img src="https://www.tradespeoplehub.co.uk/star_active'.$userdata['average_rate'].'.png" style=" vertical-align: middle;"> ('.$userdata['total_reviews'].' reviews)
							</span>

						</td>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; text-align: center;">
							<span style="font-size: 18px; display: inline-block; margin-bottom: 10px;">£'.$price.'</span>
							<br>
							<a href="'.site_url().'proposals?post_id='.$job_id.'&chat='.$user_id.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Chat</a>
							<a href="'.site_url().'proposals?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Award</a>
						</td>
					</tr>';
		return $html;
	}
	
	public function apply_post1()  {
		$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		$job_id=$this->input->post('post_id');
		$get_jobs=$this->common_model->get_job_details($job_id);
		$user_id = $this->session->userdata('user_id');
		if($user_id) {
			
			$get_plan_bids=$this->common_model->get_user_bids('user_plans',$user_id);
			$get_post_bid=$this->common_model->get_post_bids('tbl_jobpost_bids',$job_id,$user_id);
			if($get_post_bid) {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">You have already placed a quote on this job post.</div>';
							
			} else {
				if($this->input->post('option')==1) {
					
					$this->form_validation->set_rules('bid_amount','Quote Amount','required');
					$this->form_validation->set_rules('delivery_days','Project Delivered in','required');
					$this->form_validation->set_rules('propose_description','Describe Proposal','required');
					if ($this->form_validation->run()==false) {
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
							
					} else  {
						
						$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
						
						$get_commision=$this->common_model->get_commision();
						
						$credit_amount=$get_commision[0]['credit_amount'];
						
						if($get_users['u_wallet'] >= $credit_amount) {
							$bid_by = $user_id;
							$insert['bid_amount'] = $this->input->post('bid_amount');
							$insert['delivery_days'] = $this->input->post('delivery_days');
							$insert['propose_description'] = $this->input->post('propose_description');
							$insert['bid_by'] = $bid_by;
							$insert['job_id'] = $job_id;
							$insert['posted_by']=$this->input->post('posted_by');
							$insert['cdate'] =date('Y-m-d H:i:s');
							$insert['paid_total_miles']=0;
							
							$run = $this->common_model->insert('tbl_jobpost_bids',$insert);
							
							
							
							$update['u_wallet']=$get_users['u_wallet']-$credit_amount;
							
							$runs = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$update);
							
							$get_post_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['userid']));
							
							$insertn['nt_userId']=$get_jobs[0]['userid'];
							
							$insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a>';
							
							$insertn['nt_satus']=0;
							$insertn['nt_create']=date('Y-m-d H:i:s');
							$insertn['nt_update']=date('Y-m-d H:i:s');
							$insertn['job_id']=$job_id;
							$insertn['posted_by']=$bid_by;
							$run2 = $this->common_model->insert('notification',$insertn);

							$transactionid = md5(rand(1000,999).time());
							
							$tr_message='£'.$credit_amount.' has been debited to your wallet for placing a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'.</a>';
							
							$data1 = array(
								'tr_userid'=>$this->session->userdata('user_id'), 
								'tr_amount'=>$credit_amount,
								'tr_type'=>2,
								'tr_transactionId'=>$transactionid,
								'tr_message'=>$tr_message,
								'tr_status'=>1,
								'tr_created'=>date('Y-m-d H:i:s'),
								'tr_update' =>date('Y-m-d H:i:s')
							);
						 
							$run1 = $this->common_model->insert('transactions',$data1);

							//$subject = $get_users['f_name']." has placed a quote on '".$get_jobs[0]['title']."' job post"; 
							$subject = $get_users['trading_name']." has placed a quote on job"; 
							$content= 'Hello '.$get_post_user['f_name'].' '.$get_post_user['l_name'].', <br><br>';
			
							$content.='<p class="text-center"><a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a></p>';
							
							$runs1=$this->common_model->send_mail($get_post_user['email'],$subject,$content);

							if($run){
								$json['status'] = 1;
						
								$this->session->set_flashdata('success1', '<p class="alert alert-success">Thank you for submitting your quote. The homeowner will review it and get back shortly.</p>');
								//$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Your bid has been submitted successfully.</div>');
			
						
							} else {
								$json['status'] = 0;
								$json['msg'] = '<div class="alert alert-danger">Something went wrong, please try again later.</div>';
							}
						} else {
							$json['status'] = 4;
							$json['msg'] = '<div class="alert alert-danger">Your wallet amount is low recharge your wallet to place quote.</div>';
						}
		
					}
				} else if($this->input->post('option')==2) {
					
					$json['status'] = 5;
				
				} else if($get_plan_bids) {		
					
					if($get_plan_bids[0]['up_status']==1 && strtotime($get_plan_bids[0]['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids[0]['valid_type']==1) {
				
						if($get_plan_bids[0]['bid_type']==2) {
							$this->form_validation->set_rules('bid_amount','Quote Amount','required');
							$this->form_validation->set_rules('delivery_days','Project Delivered in','required');
							$this->form_validation->set_rules('propose_description','Describe Proposal','required');
								
							if ($this->form_validation->run()==false) {
								
								$json['status'] = 0;
								$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
							
							}  else {
												
								$bid_by = $user_id;
								$insert['bid_amount'] = $this->input->post('bid_amount');
								$insert['delivery_days'] = $this->input->post('delivery_days');
								$insert['propose_description'] = $this->input->post('propose_description');
								$insert['bid_by'] = $bid_by;
								$insert['job_id'] = $job_id;
								$insert['posted_by']=$this->input->post('posted_by');
								$insert['cdate'] =date('Y-m-d H:i:s');
								$insert['paid_total_miles']=0;
								$run = $this->common_model->insert('tbl_jobpost_bids',$insert);

								
								$update['up_used_bid']=1;
								$runs = $this->common_model->update('user_plans',array('up_id'=>$get_plan_bids[0]['up_id']),$update);

								if($run){
									$insertn['nt_userId']=$get_jobs[0]['userid'];
									$insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a>';
									$insertn['nt_satus']=0;
									$insertn['nt_create']=date('Y-m-d H:i:s');
									$insertn['nt_update']=date('Y-m-d H:i:s');
									$insertn['job_id']=$job_id;
									$insertn['posted_by']=$bid_by;
									$get_post_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['userid']));
									$run2 = $this->common_model->insert('notification',$insertn);
									$subjectC = $get_users['f_name']." has placed a quote on '".$get_jobs[0]['title']."' job post"; 
									// $subject = $get_users['trading_name']." has placed a quote on job"; 
									$contentC= 'Hello '.$get_post_user['f_name'].', <br><br>';
				
									$contentC.='<p class="text-center"><a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a></p>';
									$runs1=$this->common_model->send_mail($get_post_user['email'],$subjectC,$contentC);




									$subject = ' Your quote submitted successfully!'; 
									$content= 'Hi '.$get_users['f_name'].', <br><br>';
									$content.= 'Your quote on the job “'.$get_jobs[0]['title'].'” was submitted successfully. '.$get_post_user['f_name'].' will review it and discuss with you.<br><br>';
									$content.= 'We encourage you to follow the quote up by initiating a conversation with '.$get_post_user['f_name'].'.<br><br>';
									$content.= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Chat now</a></div><br><br>';
									$content.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.';
									$runs1=$this->common_model->send_mail($get_users['email'],$subject,$content);
									$json['status'] = 1;
									$this->session->set_flashdata('success1','<p class="alert alert-success">Thank you for submitting your quote. The homeowner will review it and get back shortly.</p>');
									//$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Your bid has been submitted successfully.</div>');
				
							
								} else {
									$json['status'] = 0;
									$json['msg'] = '<div class="alert alert-danger">Something went wrong, please try again later.</div>';
								}
			
							}

						} else if($get_plan_bids[0]['bid_type']==1) {
							if($get_plan_bids[0]['up_used_bid']>=$get_plan_bids[0]['up_bid']) {
								$json['status'] = 2;
								$json['msg'] = '<div class="alert alert-danger">You have exceeded the limit of quotes.Please Purchase Plan to place the quote.</div>';
				
							} else {	
								$this->form_validation->set_rules('bid_amount','Quote Amount','required');
								$this->form_validation->set_rules('delivery_days','Project Delivered in','required');
								$this->form_validation->set_rules('propose_description','Describe Proposal','required');
					
								if ($this->form_validation->run()==false)  {
									$json['status'] = 0;
									$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
									
								} else {
									
									$bid_by = $user_id;
									$insert['bid_amount'] = $this->input->post('bid_amount');
									$insert['delivery_days'] = $this->input->post('delivery_days');
									$insert['propose_description'] = $this->input->post('propose_description');
									$insert['bid_by'] = $bid_by;
									$insert['job_id'] = $job_id;
									$insert['cdate'] =date('Y-m-d H:i:s');
									$insert['posted_by']=$this->input->post('posted_by');
									$insert['paid_total_miles']=0;
									$runz = $this->common_model->insert('tbl_jobpost_bids',$insert);
					
								
									$update['up_used_bid']=$get_plan_bids[0]['up_used_bid']+1;
									$runs = $this->common_model->update('user_plans',array('up_id'=>$get_plan_bids[0]['up_id']),$update);

									if($runz){
										$json['status'] = 1;
										$insertn['nt_userId']=$get_jobs[0]['userid'];
										$insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a>';
										$insertn['nt_satus']=0;
										$insertn['nt_create']=date('Y-m-d H:i:s');
										$insertn['nt_update']=date('Y-m-d H:i:s');
										$insertn['job_id']=$job_id;
										$insertn['posted_by']=$bid_by;
										$run2 = $this->common_model->insert('notification',$insertn);

										$get_post_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['userid']));
										$run2 = $this->common_model->insert('notification',$insertn);
										

										$subjectA = $get_users['id'].'">'.$get_users['f_name']." has placed a quote on '".$get_jobs[0]['title']."' job post"; 
										// $subject = $get_users['trading_name']." has placed a quote on job"; 
										$contentA= 'Hello '.$get_post_user['f_name'].' '.$get_post_user['l_name'].', <br><br>';
						
										$contentA.='<p class="text-center"><a href="'.site_url().'profile/'.$get_users[	'id'].'">'.$get_users['trading_name'].'</a> has placed a quote on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a></p>';
										$runs1=$this->common_model->send_mail($get_post_user['email'],$subjectA,$contentA);


										$subject = 'Your quote submitted successfully!'; 
										$content= 'Hi '.$get_users['f_name'].', <br><br>';
										$content.= 'Your quote on the job “'.$get_jobs[0]['title'].'” was submitted successfully. '.$get_post_user['f_name'].' will review it and discuss with you.<br><br>';
										$content.= 'We encourage you to follow the quote up by initiating a conversation with '.$get_post_user['f_name'].'.<br><br>';
										$content.= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Chat now</a></div><br><br>';
										$content.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.';
										$runs1=$this->common_model->send_mail($get_users['email'],$subject,$content);


										$this->session->set_flashdata('success1','<p class="alert alert-success">Thank you for submitting your quote. The homeowner will review it and get back shortly.</p>');
										
									} else {
										$json['status'] = 0;
										$json['msg'] = '<div class="alert alert-danger">Something went wrong, please try again later.</div>';
									}
						
								}
							}
						}

					} else {
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger">Your Plan has been expired.You can not place quote.</div>';
					}
				} else {
					$json['status'] = 2;
					$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
				}
			}
		
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">Please login to place quote.</div>';
		}
		echo json_encode($json);
	}
}
