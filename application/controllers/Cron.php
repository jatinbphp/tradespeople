<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		//error_reporting(0);
		
		
		$check_budget = $this->common_model->get_single_data('show_page',array('id'=>2));
		$this->show_budget = 1;
		if($check_budget && $check_budget['status']==0){
			$this->show_budget = 0;
		}
		
		//die;
	}
	
	public function cron(){
		//$this->auto_upgrade_plan();
		
		$this->update_awarded_job();
		$this->send_mail_to_repost();
		//$this->common_model->send_mail('anil.webwiders@gmail.com','test','test');
	}

	public function update_ticket_status()
  {  	
    $tecketsList = $this->common_model->get_all_data('admin_chats', ['ticket_status'=>0]);    

  	foreach ($tecketsList as $key => $ticket) {
	    $chats = $this->common_model->GetSingleData('admin_chat_details', array('admin_chat_id' => $ticket['id']), 'id', 'desc');
	    if(!empty($chats)){

	    	if($chats['is_admin']==1){
	    		$time = date('Y-m-d H:i:s');
	    	
	    		$expaire = date('Y-m-d H:i:s', strtotime($chats['create_time'].' + 48 hours'));
	    		if(strtotime($time) > strtotime($expaire)){

	    			$user =  $this->common_model->GetSingleData('users', array('id' => $chats['receiver_id']));

	    			$this->common_model->update('admin_chats', array('id' => $ticket['id']), ['ticket_status'=>1]);

					$subject = 'Your support ticket is now closed : '.$ticket['ticket_id'];
					$content = '<p style="margin:0;padding:10px 0px">Hi ' .$user['f_name'] .',</p>';
					$content .= '<p style="margin:0;padding:10px 0px">A solution was proposed for your support ticket '.$ticket['ticket_id'].' few days ago.</p>';
					$content .= '<p style="margin:0;padding:10px 0px">As we have not received a response, we have now closed the ticket. However should you require further assistance, please create a new support ticket.</p>';

					if($user['type']==1){ //tradsman
					$content .= '<p style="margin:0;padding:10px 0px">Visit our tradespeople help page or contact our customer service if you have any specific questions using our service.</p>';
					}else if($user['type']==2){ //homeowner
					$content .= '<p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer service if you have any specific questions using our service.</p>';
					}

					$this->common_model->send_mail($user['email'], $subject, $content);
	    		}
	    	}
	    }  		
  	}
		// exit('test');
  }
	
	public function test(){
		
		/*$jobs = $this->common_model->GetColumnName('tbl_jobs',null,array('job_id','post_code'),true);
		foreach($jobs as $key => $row){
			$check_postcode = $this->common_model->check_postalcode($row['post_code']);
			$insert = array();
			
			$insert['longitude'] = $check_postcode['longitude'];
			$insert['latitude'] = $check_postcode['latitude'];
			$insert['city'] = $check_postcode['primary_care_trust'];
			$insert['address'] = $check_postcode['address'];
			$insert['country']  = $check_postcode['country'];
			
			$this->common_model->update('tbl_jobs',array('job_id'=>$row['job_id']),$insert); 
		}
	*/
	}
	
	public function send_post_job_email(){
		
		//echo '<pre>';
		$jobs = $this->common_model->GetColumnName('tbl_jobs',array('is_email_sent'=>0,'direct_hired'=>0),null,true); 
		if(!empty($jobs)){
			foreach($jobs as $key => $row){
				
				$job_id = $row['job_id'];
				$user_id = $row['userid'];
				$title = $row['title'];
				$budget = $row['budget'];
				$budget2 = $row['budget2'];
				$description = $row['description'];
				$category = $row['category'];
				$post_code1 = $row['post_code'];
				$longitude = $row['longitude'];
				$latitude = $row['latitude'];
				$city = $row['city'];
				$show_budget_text = '';
				$show_budget = '';
				
				if($this->show_budget==1){
					if($budget > 0){
						$show_budget .= '£'.$budget;
						$show_budget_text = 'Budget';
					}
					
					if($budget2 > 0){
						$show_budget .= ' - £'.$budget2;
					}
					$show_budget .= ' GBP';
				}
				
				
				$post_code2 = str_replace(" ","",$post_code1);
				
				if($longitude && $latitude){

					// if($check_postcode['status']==1)
					 // {		
			

					$sql = "select *, 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$latitude.")) * COS(RADIANS(users.latitude)) * COS(RADIANS(".$longitude." - users.longitude)) + SIN(RADIANS(".$latitude.")) * SIN(RADIANS(users.latitude))))) AS distance_in_km from users where users.type=1 and users.u_email_verify=1 and users.notification_status = 1  HAVING distance_in_km <= users.max_distance";				 

					 $run = $this->db->query($sql);
					
					//$trades = $this->common_model->GetColumnName('users',"type = 1 and u_email_verify = 1 and notification_status = 1 and (FIND_IN_SET($category,category) != 0 or postal_code = '".$post_code1."' or postal_code = '".$post_code2."')",array('phone_no','id','f_name','email'),true);
					//echo $this->db->last_query();

					if($run->num_rows() > 0){
						
						$trades = $run->result_array();
					
					
						//$this->load->model('send_sms');

						$userdataaa = $this->common_model->GetColumnName('users',array("id"=>$user_id),array('f_name','l_name','city'));
						
						$cateName = $this->common_model->GetColumnName('category',array("cat_id"=>$category),array('cat_name'));
						
						$link = site_url()."details?post_id=".$job_id;
						
						$respSL = file_get_contents('https://cutt.ly/api/api.php?key=69d958cf7b30dd3bef9485886a1d820bdcd57&short='.$link);

						$respSLJ = json_decode($respSL);
						
						$shortLink = $respSLJ->url->shortLink;
						
						//$sms = $userdataaa['f_name']." ".$userdataaa['l_name']." posted a new job. View & Quote now! \r\n".$shortLink."\r\n\r\nTradespeoplehub.co.uk";
						
						foreach($trades as $key => $value){
							
							/*$insertn = array(); 
							$insertn['nt_userId']=$value['id'];
							$insertn['nt_message']= $userdataaa['f_name'].' '.$userdataaa['l_name'].' posted a new job. <a href="'.site_url().'details/?post_id='.$json['job_id'].'">View & Quote now!</a>';
							$insertn['nt_satus']=0;
							$insertn['nt_create']=date('Y-m-d H:i:s');
							$insertn['nt_update']=date('Y-m-d H:i:s');
							$insertn['job_id']=$json['job_id'];
							$run2 = $this->common_model->insert('notification',$insertn);
							
							$today_sms = $this->common_model->get_data_count('daily_sms_records',array('date'=>date('Y-m-d'),'user_id'=>$value['id']),'id');
							
							if($today_sms <= 0){
								$has_sms_noti = $this->common_model->check_sms_notification($value['id']);
								
								if($has_sms_noti){
									
									//$delivered = $this->send_sms->send_india($has_sms_noti['phone_no'],$sms);
									$delivered = $this->send_sms->send($has_sms_noti['phone_no'],$sms);
									if($delivered){
										
										$this->common_model->update('user_plans',array('up_user'=>$value['id']),array('used_sms_notification'=>$has_sms_noti['used_sms_notification']));
										
										$this->common_model->insert('daily_sms_records',array('user_id'=>$value['id'],'date'=>date('Y-m-d')));
									}
								}
							}*/
							
							$subject = "New ".$cateName['cat_name']." Job Posted: ".$city.": Quote now!";
							
							$html = '<p style="margin:0;padding:10px 0px">Hi '.$value['f_name'].',</p><br>';
							
							$html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p><br>';
							
							$html .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job title</td><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">'.$show_budget_text.'</td></tr>';
							
							$html .= '<tr><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 75%; vertical-align: top;">';
							
							//$html .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">'.$cateName['cat_name'].' in '.$userdataaa['city'].'</h4>';
							
							$html .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">' .$title .'</h4><p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">'.$userdataaa['f_name'].' '.$userdataaa['l_name'].' has just posted a job that matches your profile and awaits your quote.</p></td><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 25%;  vertical-align: top;"><h4 style="font-size: 15px ; margin: 0 ; margin-bottom: 8px ; color: #000">'.$show_budget.'</h4><a href="' .site_url() .'proposals?post_id=' .$job_id .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a></td></tr>';
							
							$html .= '</table>';
							
							$html .= '<br><br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$sent = $this->common_model->send_mail($value['email'],$subject,$html);
						
						}
					}
					$this->common_model->update('tbl_jobs',array('job_id'=>$job_id),array('is_email_sent'=>1)); 
				}
			}
		}
	}
	
	public function delete_non_email_verified_users(){
		
		$today = date('Y-m-d');
		
		$users = $this->common_model->GetColumnName('users',array('u_email_verify'=>0),array('id'),true);
		
		if(!empty($users)){
			foreach($users as $key => $row);
			$user_id = $row['id'];
			
		}
	}	
	
	public function provide_feedback_reminder_homeowner(){
		
		$posts = $this->common_model->GetColumnName('tbl_jobs',array('status'=>5,'(select count(tr_id) from rating_table where rating_table.rt_jobid = tbl_jobs.job_id and rating_table.rt_rateBy = tbl_jobs.userid) ='=>0),array('job_id','userid','title','awarded_to','update_date'),true);
		 
		if(count($posts) >= 0){ 
			
			foreach($posts as $job_data) {
				
				
				$awarded_date = date('Y-m-d H:i:s',strtotime($job_data['update_date']));
				
				$current = date('Y-m-d H:i:s');
				
				$hrs24 = date('Y-m-d H:i:s',strtotime($awarded_date.' +24 hour'));
				$week1 = date('Y-m-d H:i:s',strtotime($hrs24.' +1 week'));
				$week2 = date('Y-m-d H:i:s',strtotime($hrs24.' +2 week'));
				$week3 = date('Y-m-d H:i:s',strtotime($hrs24.' +3 week'));
				$week4 = date('Y-m-d H:i:s',strtotime($hrs24.' +4 week'));
				$week5 = date('Y-m-d H:i:s',strtotime($hrs24.' +5 week'));
			
				$check = false;
				$status = 0;
				
				if($current >= $week5){
					$check_5week_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>20,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_5week_remider==false){
						$check = true;
						$status = 20;
					}
				} else if($current >= $week4){
					$check_4week_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>19,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_4week_remider==false){
						$check = true;
						$status = 19;
					}
				} else if($current >= $week3){
					
					$check_3week_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>18,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_3week_remider==false){
						$check = true;
						$status = 18;
					}
				} else if($current >= $week2){
					$check_2week_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>17,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_2week_remider==false){
						$check = true;
						$status = 17;
					}
				} else if($current >= $week1){
					$check_1week_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>16,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_1week_remider==false){
						$check = true;
						$status = 16;
					}
				} else if($current >= $hrs24){
					$check_24hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>15,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_24hrs_remider==false){
						$check = true;
						$status = 15;
					}
				} 
				
				if($check){
					
					$homeOwner = $this->common_model->GetColumnName('users', array('id' =>$job_data['userid']),array('f_name','l_name','email'));
					
					$trademen = $this->common_model->GetColumnName('users', array('id' =>$job_data['awarded_to']),array('trading_name','f_name','l_name','email'));
					
					$subject = "Reminder: Provide feedback for ".$trademen['trading_name']." for completing the job: “".$job_data['title']."”";
						
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">You have not yet rated '.$trademen['trading_name'].'. Please leave a feedback for them to help other  Tradespeoplehub members know what it was like working with them.</p>';
					
					$html .= '<br><div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$job_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div><br>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$runs1=$this->common_model->send_mail($homeOwner['email'],$subject,$html);
					
					$this->common_model->insert('last_email_records',array('user'=>$job_data['userid'],'type'=>$status,'reference_id'=>$job_data['job_id'],'last_date'=>date('Y-m-d H:i:s')));
					
				}
			
			}
		}
	}
	
	public function create_milestone_reminder(){
		$where = "total_milestone_amount = 0 and (status=7 or status = 3)";
		$posts = $this->common_model->GetColumnName('tbl_jobpost_bids',$where,array('job_id','awarded_date','bid_amount','delivery_days'),true);
		//echo '<pre>'; print_r($posts); echo '</pre>';
		if(count($posts) >= 0){
			
			foreach($posts as $list) {
				
				$job_data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$list['job_id']),array('job_id','userid','title','awarded_to','awarded_time'));
				
				$awarded_date = date('Y-m-d H:i:s',strtotime($job_data['awarded_time']));
				
				$current = date('Y-m-d H:i:s');
				
				$hrs1 = date('Y-m-d H:i:s',strtotime($awarded_date.' +1 hour'));
				$hrs3 = date('Y-m-d H:i:s',strtotime($awarded_date.' +3 hour'));
				$hrs12 = date('Y-m-d H:i:s',strtotime($awarded_date.' +12 hour'));
				$hrs24 = date('Y-m-d H:i:s',strtotime($awarded_date.' +24 hour'));
				$hrs30 = date('Y-m-d H:i:s',strtotime($awarded_date.' +30 hour'));
				$hrs36 = date('Y-m-d H:i:s',strtotime($awarded_date.' +36 hour'));
				$hrs48 = date('Y-m-d H:i:s',strtotime($awarded_date.' +48 hour'));
				$hrs72 = date('Y-m-d H:i:s',strtotime($awarded_date.' +72 hour'));
				
				
				//echo '<pre>'; print_r($job_data); echo '</pre>';
				
				$check = false;
				$number_hour = '';
				$status = 0;
				
				if($current >= $hrs72){
					$check_72hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>14,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_72hrs_remider==false){
						$check = true;
						$number_hour = '3 days';
						$status = 14;
					}
				} else if($current >= $hrs48){
					$check_48hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>13,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_48hrs_remider==false){
						$check = true;
						$number_hour = '2 days';
						$status = 13;
					}
				} else if($current >= $hrs36){
					$check_36hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>12,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_36hrs_remider==false){
						$check = true;
						$number_hour = '36 hours';
						$status = 12;
					}
				} else if($current >= $hrs30){
					
					$check_30hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>11,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_30hrs_remider==false){
						$check = true;
						$number_hour = '30 hours';
						$status = 11;
					}
				} else if($current >= $hrs24){
					$check_24hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>10,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_24hrs_remider==false){
						$check = true;
						$number_hour = '24 hours';
						$status = 10;
					}
				} else if($current >= $hrs12){
					$check_12hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>9,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_12hrs_remider==false){
						$check = true;
						$number_hour = '12 hours';
						$status = 9;
					}
				} else if($current >= $hrs3){
					
					$check_3hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>8,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_3hrs_remider==false){
						$check = true;
						$number_hour = '3 hours';
						$status = 8;
					}
					
				} else if($current >= $hrs1){
					$check_1hrs_remider = $this->common_model->GetColumnName('last_email_records',array('user'=>$job_data['userid'],'type'=>7,'reference_id'=>$job_data['job_id']),array('id'));
					
					if($check_1hrs_remider==false){
						$check = true;
						$number_hour = '1 hour';
						$status = 7;
					}
				}
				
				if($check){
					
					$homeOwner = $this->common_model->GetColumnName('users', array('id' =>$job_data['userid']),array('f_name','l_name','email'));
					
					$trademen = $this->common_model->GetColumnName('users', array('id' =>$job_data['awarded_to']),array('trading_name','f_name','l_name','email'));
					
					$subject = "Create a Milestone Payment to guarantee you want to work with ".$trademen['trading_name'];
						
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">We noticed that you have not yet created a Milestone Payment for the job “'.$job_data['title'].'”  that you offered to '.$trademen['trading_name'].' '.$number_hour.' ago.</p>';
					$html .= '<p style="margin:0;padding:3px 0px">Job title : '.$job_data['title'].'</p>';
					$html .= '<p style="margin:0;padding:3px 0px">Quote  Amount: £'.$list['bid_amount'].'</p>';
					$html .= '<p style="margin:0;padding:3px 0px">Days to Complete:  '.$list['delivery_days'].' day(s)</p>';
					
					$html .= '<br><p style="margin:0;padding:10px 0px">Create a Milestone payment to guarantee you want to work with '.$trademen['trading_name'].'.</p>';
					
					$html .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create Milestone Now!</a></div><br>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$runs1=$this->common_model->send_mail($homeOwner['email'],$subject,$html);
					
					$this->common_model->insert('last_email_records',array('user'=>$job_data['userid'],'type'=>$status,'reference_id'=>$job_data['job_id'],'last_date'=>date('Y-m-d H:i:s')));
					
				}
			
			}
		}
	}
		
	public function job_summary_for_homeowner(){
		
		$posts = $this->common_model->get_open_projects('tbl_jobs');
		
		if(count($posts) >= 0){
			foreach($posts as $list) {
				
				$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$list['userid'],'type'=>6,'reference_id'=>$list['job_id']),array('id'));
				 
				if($last_email_records==false){
					$list['c_date'];
					//$datesss= date('Y-m-d H:i:s', strtotime($list['c_date']. ' + 1 second'));
					$datesss= date('Y-m-d H:i:s', strtotime($list['c_date']. ' + 24 hour'));
					
					if(date('Y-m-d H:i:s') > $datesss){
					
						$homeOwner = $this->common_model->get_single_data('users',array('id'=>$list['userid']));
						
						$tradesmens_id = $this->common_model->GetColumnName('tbl_jobpost_bids',array('job_id'=>$list['job_id']),array('bid_by','bid_amount'),true);
						
						if(!empty($tradesmens_id) && count($tradesmens_id) > 0){
							
							
							$cateName = $this->common_model->GetColumnName('category',array("cat_id"=>$list['category']),array('cat_name'));
							
							$subject = "You´ve got more quotes on your job post titled: ".$list['title'];
						
							$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">You\'ve received quotes from our '.$cateName['cat_name'].'. Please review, discuss and award the job to one of them.</p>';
							
							$html .= '<tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="10" width="100%"><tbody><tr><td align="left" valign="top" style="color:#444;font-size:14px"><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">';
							
							foreach($tradesmens_id as $row1){
								$html .= $this->get_profile_loop($row1['bid_by'],$list['job_id'],$row1['bid_amount']);
							}
							
							$html .= '</table></td></tr></td></tr></tbody></td></tr>';
							
							$html .= '<br><p style="margin:0;padding:10px 0px">We suggest not making decisions on price alone. Read their profiles, previous works and feedback to help you decide who to hire.</p>';
							
							$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$runs1=$this->common_model->send_mail($homeOwner['email'],$subject,$html);
							$this->common_model->insert('last_email_records',array('user'=>$list['userid'],'type'=>6,'reference_id'=>$list['job_id'],'last_date'=>date('Y-m-d H:i:s')));
						}			
					}
				}
			}
		}
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
	
	public function job_post_reminder_if_visited(){
		$today = date('Y-m-d');
	
		$yesterday = date('Y-m-d',strtotime($today.' -7 day'));
		
		$where = "tbl_jobs.status = 1 and tbl_jobs.is_delete=0 and tbl_jobs.c_date >= '".$yesterday."' and tbl_jobs.direct_hired = 0";
		
		$jobs = $this->common_model->GetColumnName('tbl_jobs',$where,array('title','job_id','userid','description','budget','category','city'),true);
		
		if(count($jobs) > 0){
			foreach($jobs as $key => $value){
				
				$job_id = $value['job_id'];
				$title = $value['title'];
				$description = $value['description'];
				$category = $value['category'];
				$budget = $value['budget'];
				$budget2 = $value['budget2'];
				$userid = $value['userid'];
				$city = $value['city'];
				
				$show_budget = '';
				$show_budget_text = '';
				if($this->show_budget==1){
					if($budget > 0){
						$show_budget .= '£'.$budget;
						$show_budget_text = 'Budget';
					}
					
					if($budget2 > 0){
						$show_budget .= ' - £'.$budget2;
					}
					
					$show_budget .= ' GBP';
				}
				
				
				
				$home = $this->common_model->GetColumnName('users',array('id'=>$userid),array('f_name','l_name','email','city'));
				
				$cate = $this->common_model->GetColumnName('category',array('cat_id'=>$category),array('cat_name'));
				
				$check_visite = $this->common_model->GetColumnName('visit_job',array('job_id'=>$job_id),array('user_id'),true);
				if(count($check_visite) > 0){
				foreach($check_visite as $key1 => $value1){
					
					$check12 = $this->common_model->GetColumnName('tbl_jobpost_bids',array('job_id'=>$job_id,'bid_by'=>$value1['user_id']),array('id'));
					
					if(!$check12){
						
						$trade = $this->common_model->GetColumnName('users',array('id'=>$value1['user_id'],'u_email_verify'=>1),array('f_name','l_name','email'));
						
						if($trade){
						
						$subject = "Job Reminder: ".$home['f_name']." is Still Waiting for your Quote - Please provide quote!";
						
						
						$html = '<p style="margin:0;padding:10px 0px">Hi '.$trade['f_name'].',</p>';
						$html .= '<p style="margin:0;padding:10px 0px">'.$home['f_name'].' is still waiting for you to provide a quote on their job post below.</p><br>';
						
						$html .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job title</td><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">'.$show_budget_text.'</td></tr>';
						
						$html .= '<tr><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 75%; vertical-align: top;">';
						
						//$html .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">'.$cate['cat_name'].' in '.$home['city'].'</h4>';
						
						$html .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">' .$title .'</h4><p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">'.$home['f_name'].' '.$home['l_name'].' is still waiting for you to quote their job post</p></td><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 25%;  vertical-align: top;"><h4 style="font-size: 15px ; margin: 0 ; margin-bottom: 8px ; color: #000">'.$show_budget.'</h4><a href="' .site_url() .'proposals?post_id=' .$job_id .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a></td></tr>';
						
						$html .= '</table>';
						
						$html .= '<br><br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$sent = $this->common_model->send_mail($trade['email'],$subject,$html);
					}
					}
				}
				}				
			}
		}		
	}
	
	public function send_signup_remider2(){		
		$current = date('Y-m-d H:i:s');
	
		$newTime = date('Y-m-d H:i:s',strtotime($current.' -3 hour'));
		
		//$newTime1 = date('Y-m-d H:i:s',strtotime($newTime.' +59 min'));//05.00.00
		//$newTime2 = date('Y-m-d H:i:s',strtotime($newTime1.' +59 second'));02.00.00
		
		$sql = "SELECT `id`, `f_name`, `l_name`, `email` FROM `users` WHERE `type` = 1 AND `free_trial_taken` = 0 AND `u_email_verify` = 1 AND `is_pay_as_you_go` = 0 AND cdate <= '".$newTime."'";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			
			$data = $query->result_array();
			//print_r($data);
			foreach($data as $key => $value){
				
				$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$value['id'],'type'=>3,'reference_id'=>0),array('last_date','id'));
			
				if($last_email_records==false){ 
				
					$this->common_model->insert('last_email_records',array('user'=>$value['id'],'type'=>3,'reference_id'=>0,'last_date'=>date('Y-m-d H:i:s')));
				
					$subject = "Reminder: Complete your Free Trial Sign up Today before it Expires";
						
					$html = '<p style="margin:0;padding:10px 0px">Complete Your Free Trial Sign up Today!</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$value['f_name'].',</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Don\'t miss the chance to grow your business by completing your free trial sign up today. It merely takes a few minutes to complete. </p>';
					
					
					$html .= '<br><div style="text-align:center"><a href="'.site_url().'membership-plans" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Complete Your Free Trial Now</a></div><br>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$sent = $this->common_model->send_mail($value['email'],$subject,$html);
				}
			}
		}
	}
	
	public function check_disput_reply12(){
		$today = date('Y-m-d H:i:s');
		//$today = date('Y-m-d H:i:s');
		//$newTime = date('Y-m-d H:i:s',strtotime($today.' +59 min'));
		$newTime2 = date('Y-m-d H:i:s',strtotime($today.' +59 second'));
		
		//$sql = "select tbl_dispute.ds_id, (select dct_id from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$newTime2."') and DATE(end_time) >= DATE('".$newTime."')) as dct_id from tbl_dispute where ds_status = 0 and (select count(dct_id) from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$newTime2."') and DATE(end_time) >= DATE('".$newTime."')) > 0";
		
		$sql = "select tbl_dispute.ds_id, (select dct_id from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$today."')) as dct_id from tbl_dispute where ds_status = 0 and (select count(dct_id) from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$today."')) > 0";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			foreach($query->result_array() as $key => $value){
				
				//echo '<pre>';print_r($value);echo '</pre>';die;
				
				$conversation = $this->common_model->get_single_data('disput_conversation_tbl',array('dct_id'=>$value['dct_id']));
				$disput = $this->common_model->get_single_data('tbl_dispute',array('ds_id'=>$value['ds_id']));
				if($conversation['message_to']==$disput['ds_buser_id']){
					$favorId = $disput['ds_puser_id'];
					$massage = 'Dispute is resolved because homeowner do not reply of dispute.';
				} else {
					$favorId = $disput['ds_buser_id'];
					$massage = 'Dispute is resolved because tradesman do not reply of dispute.';
				}
				
				$milestone = $this->common_model->get_single_data('tbl_milestones',array('id'=>$disput['mile_id']));
					
				$job_id = $milestone['post_id'];

				$tradesman = $disput['ds_buser_id'];
					
				$homeowner = $disput['ds_puser_id'];
					
				$dispute_ids = $disput['ds_id'];
					
				$mile_id = $disput['mile_id'];

				$run = $this->common_model->update_data('disput_conversation_tbl',array('dct_id'=>$value['dct_id']),array('dct_isfinal'=>1));	
					
				if($run){
						
					$bid_update['status']=6;  
						
					$where = "id = '".$mile_id."' and status = '5'";
						
					$this->common_model->update('tbl_milestones',$where,$bid_update);
						
					$disput_update['ds_status']=1;
					$disput_update['ds_favour']=$favorId;

					$run1 = $this->common_model->update('tbl_dispute',array('ds_id'=>$dispute_ids),$disput_update);
						
					$home = $this->common_model->GetColumnName('users',array('id'=>$homeowner),array('f_name','id','l_name','email','trading_name','u_wallet'));
					
					$trades = $this->common_model->GetColumnName('users',array('id'=>$tradesman),array('f_name','id','l_name','email','trading_name','u_wallet','withdrawable_balance'));
					
					$favo = $this->common_model->GetColumnName('users',array('id'=>$favorId),array('f_name','l_name','email','trading_name','u_wallet'));
					
					$openedBy = $this->common_model->GetColumnName('users',array('id'=>$disput['disputed_by']),array('f_name','l_name','email','trading_name','u_wallet'));
					
					$amount = $milestone['milestone_amount'];
					
					$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time','commision'));
					
					$get_job_post = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$milestone['post_id']),array('title'));
							
					if($tradesman==$favorId){
								
						$commision=$setting['commision'];
								
						$get_post_job = $this->common_model->GetColumnName('tbl_jobpost_bids',array('id'=>$milestone['bid_id']),array('paid_total_miles','bid_amount','id','bid_by','job_id','posted_by','job_id','job_id'));
					
						
								
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
									
							/*$insertn['nt_userId']=$get_post_job['bid_by'];
								
							$insertn['nt_message']='Congratulation this project has been completed successfully.<a href="'.site_url().'profile/'.$homeowner.'">'.$home['f_name'].' '.$home['l_name'].'</a> has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed.Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
								
							$insertn['nt_satus']=0;
							$insertn['nt_apstatus']=2;
							$insertn['nt_create']=date('Y-m-d H:i:s');
							$insertn['nt_update']=date('Y-m-d H:i:s');   
							$insertn['job_id']=$get_post_job['job_id'];
							$insertn['posted_by']=$get_post_job['posted_by'];
							$run2 = $this->common_model->insert('notification',$insertn);*/
									
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
							
							
							$subject = 'Congratulations on Completing the Job: '.$post_title;
			
							$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “'.$post_titlepost_title.'”! Your milestone payments has now been released and can be withdrawn. </p>';
							$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for '.$home['f_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
							
							$html .= '<div style="text-align:center"><a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';
							
							$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$runs1=$this->common_model->send_mail($trades['email'],$subject,$html);
									
							$insertn1['nt_userId']=$get_post_job['posted_by'];
							$insertn1['nt_message']='Congratulation this project has been completed successfully. You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
											
							$insertn1['nt_satus']=0;
							$insertn1['nt_apstatus']=2;
							$insertn1['nt_create']=date('Y-m-d H:i:s');
							$insertn1['nt_update']=date('Y-m-d H:i:s');   
							$insertn1['job_id']=$get_post_job['job_id'];
							$insertn1['posted_by']=$get_post_job['bid_by'];
							$this->common_model->insert('notification',$insertn1);

							$insertn2['nt_userId']=$get_post_job['bid_by'];
							$insertn2['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">'.$home['f_name'].' '.$home['l_name'].'.</a>';
											
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
							
					$runss1 = $this->common_model->update_data('users',array('id'=>$favorId),$update1);
						
					$jon_name = $this->common_model->update_data('users',array('id'=>$favorId),$update1);
							
					$transactionid = md5(rand(1000,999).time());
					$tr_message= 'Dispute team has resolved the <a href="'. site_url('dispute/'.$mile_id.'/'.$job_id).'">'.$milestone['milestone_name'].' milestone dispute</a> in favour of you and £'.$amounts.' has been credited in your wallet</b>';
					$data1 = array(
						'tr_userid'=>$favorId, 
						'tr_amount'=>$amounts,
						'tr_type'=>1,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
					);
					$this->common_model->insert('transactions',$data1);
					
					$insertn4['nt_userId']=$home['id'];
					$insertn4['nt_message']='Milestone payment dispute closed & decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
							
					$insertn4['nt_satus']=0;
					$insertn4['nt_apstatus']=0;
					$insertn4['nt_create']=date('Y-m-d H:i:s');
					$insertn4['nt_update']=date('Y-m-d H:i:s');   
					$insertn4['job_id']=$job_id;
					$insertn4['posted_by']=0;
					$this->common_model->insert('notification',$insertn4);
					
					$insertn5['nt_userId']=$trades['id'];
					$insertn5['nt_message']='Milestone payment dispute closed & decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
							
					$insertn5['nt_satus']=0;
					$insertn5['nt_apstatus']=0;
					$insertn5['nt_create']=date('Y-m-d H:i:s');
					$insertn5['nt_update']=date('Y-m-d H:i:s');   
					$insertn5['job_id']=$job_id;
					$insertn5['posted_by']=0;
					$this->common_model->insert('notification',$insertn5);
							
							
					$subject ="Milestone payment dispute has been automatically closed, Job: ".$get_job_post['title'];
			
					$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically! </p>';
					
					if($conversation['message_to']==$tradesman){
						$ename = 'you didn\'t';
					} else {
						$ename = 'homeowner does\'t';
					}
					
					$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">The case which homeowner '.$openedBy['f_name'].' opened concerning a milestone payment to you has automatically closed because '.$ename.' respond before '.date('d M Y h:i:s A',strtotime($conversation['end_time'])).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Dispute Reason: '.$disput['dct_msg'].'</p>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->common_model->send_mail($trades['email'],$subject,$contant);
					
					$contant = '<p style="margin:0;padding:10px 0px">Milestone dispute closed automatically! </p>';
					
					if($conversation['message_to']==$homeowner){
						$ename = 'you didn\'t';
					} else {
						$ename = 'trademen does\'t';
					}
					
					$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$home['f_name'].',</p>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">The case which '.$openedBy['f_name'].' opened concerning a milestone payment to you has automatically closed because '.$ename.' respond before '.date('d M Y',strtotime($conversation['end_time'])).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
					
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Dispute Reason: '.$disput['dct_msg'].'</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->common_model->send_mail($home['email'],$subject,$contant);
							
					//$this->release_milestone($job_id,$dispute_finel_user);
				}
			}
		}
	}
	
	public function send_disput_reply_reminder(){
		
		$today = date('Y-m-d H:i:s');
		$newTime = date('Y-m-d H:i:s',strtotime($today.' +1 day'));
		
		$sql = "select tbl_dispute.ds_id, (select dct_id from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$newTime."')) as dct_id from tbl_dispute where ds_status = 0 and (select count(dct_id) from disput_conversation_tbl where disput_conversation_tbl.dct_disputid = tbl_dispute.ds_id and is_reply_pending=1 and DATE(end_time) <= DATE('".$newTime."')) > 0";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			foreach($query->result_array() as $key => $value){
				
				
				$conversation = $this->common_model->get_single_data('disput_conversation_tbl',array('dct_id'=>$value['dct_id']));
				
				//echo '<pre>';print_r($conversation);echo '</pre>';
				
				$dispute_ids = $value['ds_id'];
				
				$user_id = $conversation['message_to'];
				
				$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$user_id,'type'=>4,'reference_id'=>$dispute_ids),array('last_date','id'));
				
				if($last_email_records==false){
				
					$disput = $this->common_model->get_single_data('tbl_dispute',array('ds_id'=>$value['ds_id']));
					$milestone = $this->common_model->get_single_data('tbl_milestones',array('id'=>$disput['mile_id']));
					
					if($conversation['message_to']==$disput['ds_buser_id']){
						$favorId = $disput['ds_puser_id'];
					} else {
						$favorId = $disput['ds_buser_id'];
					}
					
					$job_id = $milestone['post_id'];
					
					$mile_id = $disput['mile_id'];
				
					$favo = $this->common_model->GetColumnName('users',array('id'=>$favorId),array('f_name','l_name','type','trading_name'));
					
					$userdata = $this->common_model->GetColumnName('users',array('id'=>$user_id),array('f_name','l_name','email','type'));
					
					$get_job_post = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$job_id),array('title'));
					
					$mile_data = $this->common_model->GetColumnName('tbl_milestones',array('id'=>$mile_id),array('milestone_amount'));
					
					if($userdata['type']==1){
					
						$subject = "Reminder: Your reply to ".$favo['f_name']." ".$favo['l_name']." response on the Milestone Payment Dispute is required.";
						
						$html = '<p style="margin:0;padding:10px 0px">Your reply to '.$favo['f_name'].' '.$favo['l_name'].' response is required!</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Hi '.$userdata['f_name'].',</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$favo['f_name'].' '.$favo['l_name'].' has responded to your claim on the milestone payment dispute, but have not yet got your reply on their viewpoint. </p>';
						
						$html .= '<p style="margin:0;padding:5px 0px">Job: '.$get_job_post['title'].'</p>';
						$html .= '<p style="margin:0;padding:5px 0px">Milestone Dispute Amount: £'.$mile_data['milestone_amount'].'</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Your participation is essential to the claims process. If we don\'t receive a response from you before '.date('d-m-Y H:i:s',strtotime($conversation['end_time'])).' this case will be closed and decided in the '.$favo['f_name'].' favour. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
						
						$html .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View & Respond Now</a></div><br>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$runs1=$this->common_model->send_mail($userdata['email'],$subject,$html);
					
					} else {
						
						$subject = "Reminder: Your reply to ".$favo['trading_name']." response on the Milestone Payment Dispute is required.";
						
						$html = '<p style="margin:0;padding:10px 0px">Your reply to '.$favo['trading_name'].' response is required!</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Hi '.$userdata['f_name'].',</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$favo['trading_name'].' has responded to your claim on the milestone payment dispute, but have not yet got your reply on their viewpoint.</p>';
						
						$html .= '<p style="margin:0;padding:0px 0px">Job: '.$get_job_post['title'].'</p>';
						$html .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$mile_data['milestone_amount'].'</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Your participation is essential to the claims process. If we don\'t receive a response from you before '.date('d-m-Y H:i:s',strtotime($conversation['end_time'])).'  this case will be closed and decided in the '.$favo['trading_name'].'  favour. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
						
						$html .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View & Respond Now</a></div><br>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$runs1=$this->common_model->send_mail($userdata['email'],$subject,$html);
						
					}
					
					$this->common_model->insert('last_email_records',array('user'=>$user_id,'type'=>4,'reference_id'=>$dispute_ids,'last_date'=>date('Y-m-d H:i:s')));
					
				}
				
			}
		}
	}
	
	public function send_miles_notifications(){
		die;
		$bids = $this->common_model->GetColumnName('tbl_jobpost_bids',array('miles_noti_status_to_home'=>0,'status'=>7),array('update_date','posted_by','id','miles_noti_status_by_trades','job_id'),true);
		
		$current = date('Y-m-d H:i:s');

		foreach($bids as $bid){
			
			$check =  $this->common_model->GetColumnName('tbl_milestones',array('bid_id'=>$bid['id'],'status >='=>1),array('id'));
			
			
			if($check==false){
			
				if($bid['miles_noti_status_by_trades']==1){
					$dbtime = date('Y-m-d H:i:s',strtotime($current.' - 3 hour'));
				} else {
					$update['miles_noti_status_by_trades'] = 1;
					$dbtime = date('Y-m-d H:i:s',strtotime($current.' - 1 hour'));
				}
				
				if(strtotime($dbtime) >= strtotime($bid['update_date'])){
					
					$has_email_noti = $this->common_model->check_email_notification($bid['posted_by']);
						
					if($has_email_noti){
						
						$post_data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$bid['job_id']),array('title'));
						
						$subject = "Release milestone";
					
						$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Release milestone</p><p style="margin:0;padding:10px 0px">Release the milestone for the job <a href="'.site_url().'payments/?post_id='.$bid['job_id'].'"> '.$post_data['title'].'</a>.<p><a href="'.site_url().'reviews/?post_id='.$bid['job_id'].'">click here</a> to release milestone now.</p></p><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$bid['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job now</a></div>';
						
						$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html);
					}
					
					$update['update_date'] = date('Y-m-d H:i:s');
					
					$run2 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$bid['id']),$update);
				}
			} else {
				$run2 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$bid['id']),array('miles_noti_status_to_home'=>1,'update_date'=>date('Y-m-d H:i:s')));
			}
			
		}
	}

  public function auto_upgrade_plan(){
    $today = date('Y-m-d'); //Y-m-d 23:
	
    $today = date('Y-m-d',strtotime($today.' +5 minutes'));
		
		$myfile = fopen("cronFiles/".$today."-auto_upgrade_plan.txt", "w") or die("Unable to open file!");
		$currentTime = date('Y-m-d H:i:s');
		$txt = ' / '.$currentTime;
		$txt .= date('Y-m-d H:i:s',strtotime($currentTime.' +5 minutes'));
		fwrite($myfile, $txt);
		fclose($myfile);

		
    // $plans = $this->common_model->newgetRows('user_plans',"auto_update = 1 and DATE(up_enddate) < DATE('".$today."')");
    $this->db->query("SET sql_mode = ''");
    $plans = $this->db->where("auto_update", 1);
    //$this->db->where('up_user', 11);
    $this->db->where('DATE(up_enddate)  <', $today);
    $this->db->order_by('up_id', 'desc');
    $this->db->group_by('up_user');
    $plans = $this->db->get('user_plans');
    $plans = $plans->result_array();

		//echo '<pre>'; 
		//echo '<pre>'; print_r($plans); exit();
    if(count($plans)>0){
      require_once('application/libraries/stripe-php-7.49.0/init.php');
			$secret_key = $this->config->item('stripe_secret');
			
			\Stripe\Stripe::setApiKey($secret_key);

      foreach($plans as $key => $value){

      	// echo '<pre>'; print_r($value);  continue;
				
				$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$value['up_user'],'type'=>21),array('last_date','id','reference_id'));
			
				$today = date('Y-m-d');
				
				$check = false;
						
				if($last_email_records){
					$update_date = date('Y-m-d',strtotime($last_email_records['last_date'].' +2 day'));
					if(strtotime($today) >= strtotime($update_date) && $last_email_records['reference_id'] < 3){
						$check = true;
					}
				} else {
					$check = true;
				}
				
				if($check){
					
					$card = false;
					$cards = $this->common_model->GetColumnName("save_cards", array("user_id" => $value['up_user'],'status'=>1,'exp_year >='=>date('Y')),'',true,'id','desc');
					//echo '<pre>';
					
					foreach($cards as $cardRow){
						$exp = date('Y-m',strtotime($cardRow['exp_year'].'-'.$cardRow['exp_month']));
						if(strtotime($exp) >= strtotime(date('Y-m'))){
							$card['customer_id'] = $cardRow['customer_id'];
							$card['payment_method'] = $cardRow['payment_method'];
							break;
						}
						
					}
					
					if(!$card){
						$billing_details = $this->common_model->get_single_data("billing_details", array("user_id" => $value['up_user']));
						if($billing_details && !empty($billing_details['stripe_data'])){
							$stripe_data = unserialize($billing_details['stripe_data']);
							if(!empty($stripe_data)){
								//print_r($billing_details);
								$card['customer_id'] = $stripe_data['customerID'];
								$card['payment_method'] = $stripe_data['payment_method'];
							}
						}
					}
					
			
				
				
					

					$user_data = $this->common_model->GetColumnName('users',array('id'=>$value['up_user']),array('f_name','l_name','email','id','u_wallet'));
					
					//print_r($value) ;
					//print_r($user_data) ;
					

					$plan_detail = $this->common_model->get_single_data('tbl_package',array('id'=>$value['up_plan']));
					
					$error2 = false;
					$error = false;

					if($card && $user_data){
						
						try {
							$response = \Stripe\PaymentIntent::create([
								'amount' => $plan_detail['amount']*100,
								'currency' => 'gbp',
								'customer' => $card['customer_id'],
								'description' => 'Subscription auto renewed',
								'payment_method' => $card['payment_method'],
								'off_session' => true,
								'confirm' => true,
							]);

							$chargeJson = $response->jsonSerialize();

							if($chargeJson['status'] == 'succeeded'){
								// Order details
								$amount = $plan_detail['amount'];
								$currency = 'GBP';
								$txnID = md5(rand(1000,999).time());
								$status = 1;

								$traId = md5(rand(1000,999).time());
								$traId = $chargeJson['id'];
								if($plan_detail['reward'] == 1){
									$wallet = $user_data['u_wallet'] + $plan_detail['reward_amount'];
									$this->common_model->update('users',array('id'=>$user_data['id']),array('u_wallet'=>$wallet));
									//insert in transactions history
									$insert['tr_userid'] = $user_data['id'];
									$insert['tr_message'] = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].' has been renewed and you have been rewarded <i class="fa fa-gbp"></i>'.$plan_detail['reward_amount'].' of '.$plan_detail['package_name']. 'plan.';
									$insert['tr_amount'] = $plan_detail['amount'];
									$insert['tr_transactionId'] = $traId;
									$insert['tr_status'] = $status;
									$insert['tr_reward']=1;
									$insert['tr_plan']=$plan_detail['id'];
									$insert['tr_paid_by']='Stripe';
								}else{
									$insert['tr_userid'] = $user_data['id'];
									$insert['tr_message'] = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].' has been renewed';
									$insert['tr_amount'] = $plan_detail['amount'];
									$insert['tr_transactionId'] = $traId;
									$insert['tr_status'] = $status;
									$insert['tr_plan']=$plan_detail['id'];
									$insert['tr_paid_by']='Stripe';
								}

								$run = $this->common_model->insert('transactions',$insert);

								$insert2['up_planName'] = $plan_detail['package_name'];
								$insert2['up_amount'] = $plan_detail['amount'];

								if($plan_detail['unlimited_limited']==0){
									$bid = $plan_detail['bids_per_month']; 
									$up_bid = trim($bid,' bids')*1;
									
									//$insert2['up_bid'] = $up_bid + $value['up_bid'];
									$insert2['up_bid'] = $up_bid;
									$insert2['bid_type'] = 1;
								}else{
									$insert2['up_bid'] = 'Unlimited';
									$insert2['bid_type'] = 2;
								}

								$insert2['up_startdate'] = $today;
								$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_startdate']. '+ '.$plan_detail['validation_type']));
								$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_enddate']. '- 1 day'));
								$insert2['up_status'] = 1;
								//$insert2['up_used_bid'] = 0;
								$insert2['auto_renewed'] = 1;
								//$insert2['total_sms'] = $plan_detail['total_notification'] + $value['total_sms'];
								$insert2['total_sms'] = $plan_detail['total_notification'];
								//$insert2['used_sms_notification'] = 0;
								$insert2['up_transId'] = $traId;
								
								$run2 = $this->common_model->update('user_plans',array('up_id'=>$value['up_id']),$insert2);
								
								
								$store = '1';//0
								$store .= '&'.$plan_detail['package_name'];//1
								$store .= '&'.$insert2['up_startdate'];//2
								$store .= '&'.$insert2['up_enddate'];//3
								$store .= '&'.$insert2['up_amount'];//4
								$store .= '&'.$insert2['up_transId'];//5
								$store .= '&'.$user_data['id'];//6
								$store .= '&'.$value['up_plan'];//7
								$store .= '&Monthly membership plan renewed!';//8
								
								$inv = $this->common_model->insert('invoice',array('data'=>$store));

								// $nt_message = 'Monthly subscription plan renewed. <a target="_blank" href="'.site_url().'view-invoice/'.$inv.'">View invoice!</a>';
								$nt_message = 'Monthly subscription plan renewed. <a href='.base_url('subscription-plan').'>View plan</a>';
								$this->common_model->insert_notification($user_data['id'],$nt_message);

								$subject = "Your Membership Plan has been renewed.";
								$html = '<p style="margin:0;padding:10px 0px">Hi '.$user_data['f_name'] .',</p>';
								$html .= '<p style="margin:0;padding:10px 0px">Monthly membership plan renewed!</p>';
								$html .= '<p style="margin:0;padding:10px 0px">Your Tradespeoplehub monthly subscription plan has been renewed. There´s nothing more you need to do other than to continue using our service to grow your business.</p>';
								$html .= '<p style="margin:0;padding:10px 0px">Now maybe a good time to upgrade to a higher plan so you can enjoy more awesome features.</p>';
								$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

								$sent = $this->common_model->send_mail($user_data['email'],$subject,$html);
								
								$this->common_model->delete(array('user'=>$value['up_user'],'type'=>21),'last_email_records');
							}
						} catch(\Stripe\Exception\CardException $e) {
							
							$error2 = $e->getError()->code;
							//echo 'Message is:' . $e->getError()->message . '\n';
							
						} catch (\Stripe\Exception\RateLimitException $e) {
							
							$error2 = $e->getError()->code;
							
						} catch (\Stripe\Exception\InvalidRequestException $e) {
							
							$error2 = $e->getError()->code;
							
						} catch (\Stripe\Exception\AuthenticationException $e) {
							
							$error2 = $e->getError()->code;
							
						} catch (\Stripe\Exception\ApiConnectionException $e) {
							
							$error2 = $e->getError()->code;
							
						} catch (\Stripe\Exception\ApiErrorException $e) {
							
							$error2 = $e->getError()->code;
							
						} catch (Exception $e) {
							
							$error2 = $e->getError()->code;
							
						}
						if ($error2 && !empty($error2)) {
							
							$subject = "Your Monthly Plan Renewal was Unsuccessful.";
							$html = '<p style="margin:0;padding:10px 0px">Please act now to keep your subscription.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_data['f_name'] .',</p>';
							$html .= '<p style="margin:0;padding:10px 0px">After several attempts, we are still unable to renew your Tradespeople Hub monthly subscription plan, due to incorrect payment information associated with your card.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">Perhaps you received a new card from your bank, or your card has expired. Because of this, your account is now past due.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">Be sure to provide this information immediately so there will be no interruption to your membership. Don’t risk losing your access to the UK most innovative platform for trade jobs.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">Please take a moment to renew your billing information.</p>';
							$html .= '<a href="'.site_url().'billing-info/?verify=1" style="margin-left: 25%; background-color:#fe8a0f;color:#fff;padding:5px 15px; text-align:center; line-height:25px; border-radius:3px; font-size:12px; text-decoration:none">Update Payment Info </a>';
							$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

							$sent = $this->common_model->send_mail($user_data['email'], $subject, $html);

							$nt_message = 'Unable to renew your monthly subscription plan. <a href="'.site_url().'billing-info/?verify=1">Please update your card!</a>';
							$this->common_model->insert_notification($user_data['id'],$nt_message);
							
							if($last_email_records){
								$reference_id = $last_email_records['reference_id']+1;
								$this->common_model->update_data('last_email_records', array('id'=>$last_email_records['id']), array('last_date'=>date('Y-m-d H:i:s'),'reference_id'=>$reference_id+1));
							} else {
								$this->common_model->insert('last_email_records',array('user'=>$value['up_user'],'type'=>21,'reference_id'=>1,'last_date'=>date('Y-m-d H:i:s')));
							}
						}
					}
					
					
				
				}
				
				
			}
    }
  }

	public function send_payment_verification_remiders(){
		die;
		$where = "type = 1 and u_email_verify = 1 and (select count(id) from billing_details where billing_details.user_id = users.id) = 0";
		
		$users = $this->common_model->GetColumnName('users',$where,array('f_name','l_name','email'),true);
		foreach($users as $key => $value){
			$name = $value['f_name'].' '.$value['l_name'];
			$email = $value['email'];
			
			$subject = "Verify your payment";
			
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Verify your payment</p>
			<p style="margin:0;padding:10px 0px">Hello '.$name.', this is mail to inform you that your payment method documents are still unverified.</p>
			<p style="margin:0;padding:10px 0px">For the better experience with Tradespeople Hub	 verify your payment method as soon as possible and enjoy your free trial.</p>';
			
			$this->common_model->send_mail($email,$subject,$html);						
		}		
	}

  public function send_document_verification_remiders(){
    
		//$where = "type = 1 and u_email_verify = 1 and (is_phone_verified = 0 or u_status_insure = 0 or u_status_add = 0 or u_id_card_status = 0)";
		$where = "type = 1 and free_trial_taken = 0 and u_wallet = 0 and is_pay_as_you_go = 0 and u_id_card_status = 0 and u_email_verify = 1";
		

    $users = $this->common_model->GetColumnName('users',$where,array('id','f_name','l_name','email','is_phone_verified','u_email_verify','u_status_insure','u_status_add','u_id_card_status'),true);

    foreach($users as $key => $value){
			
			$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$value['id'],'type'=>24),array('last_date','id','reference_id'));
			
				$today = date('Y-m-d');
				
				$check = false;
						
				if($last_email_records){
					$update_date = date('Y-m-d',strtotime($last_email_records['last_date'].' +7 day'));
					if(strtotime($today) >= strtotime($update_date) && $last_email_records['reference_id'] < 12){
						$check = true;
					}
				} else {
					$check = true;
				}
				
				if($check){
				
				
				
				
				$name = $value['f_name'];
				$email = $value['email'];

				$subject = "Reminder- Verify Your Account";

				$html = '<p style="margin:0;padding:10px 0px">Finish Verifying Your Account</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$name.',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">You have not yet finished verifying your Tradespeople Hub account. Once verified, you will start winning more works.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Verification is a short and straightforward process, which confirms your identity and contact information.  </p>';

				$html .= '<p>Finish Verifying your  Account by: </p>';

				//if($value['u_id_card_status']==0){
					$html .= '<p>Uploading your proof of ID: <a href="'.site_url().'dashboard" style="background-color:#fe8a0f;color:#fff;padding:5px 15px;text-align:center;line-height:12px;border-radius:3px;font-size:12px;text-decoration:none;float: right;">Click here to verify now.</a></p>';
				//}

				//if($value['u_status_add']==0){
					$html .= '<p>Uploading proof of address: <a href="'.site_url().'dashboard" style="background-color:#fe8a0f;color:#fff;padding:5px 15px;text-align:center;line-height:12px;border-radius:3px;font-size:12px;text-decoration:none;float: right;">Click here to verify now.</a></p>';
				//}

				//if($value['is_phone_verified']==0){
					$html .= '<p>Confirming phone number: <a href="'.site_url().'users/verify_phone" style="background-color:#fe8a0f;color:#fff;padding:5px 15px;text-align:center;line-height:12px;border-radius:3px;font-size:12px;text-decoration:none;float: right;">Click here to verify now.</a></p>';
				//}

				//if($value['u_status_insure']==0){
					$html .= '<p>Uploading Public Liability Insurance: <a href="'.site_url().'dashboard" style="background-color:#fe8a0f;color:#fff;padding:5px 15px;text-align:center;line-height:12px;border-radius:3px;font-size:12px;text-decoration:none;float: right;">Click here to verify now.</a></p>';
				//}
				
				$i = 1;
				
				/*if($value['u_email_verify']==0){
					
					$html .= '<p>'.$i.'. Email address: <a href="'.site_url().'email-verify" style="background-color:#fe8a0f;color:#fff;padding:5px 15px;text-align:center;line-height:12px;border-radius:3px;font-size:12px;text-decoration:none">Click here to verify now.</a></p>';
					
				}*/

				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($email, $subject, $html);
				
			 
				if($last_email_records){
					$reference_id = $last_email_records['reference_id']+1;
					$this->common_model->update_data('last_email_records', array('id'=>$last_email_records['id']), array('last_date'=>date('Y-m-d H:i:s'),'reference_id'=>$reference_id+1));
				} else {
					$this->common_model->insert('last_email_records',array('user'=>$value['id'],'type'=>24,'reference_id'=>1,'last_date'=>date('Y-m-d H:i:s')));
				}
			}
    }
  }

	public function send_mail_to_repost(){
		$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('closed_date'));
		
		$posts = $this->common_model->get_open_projects('tbl_jobs');
		
		if(count($posts) >= 0){
			foreach($posts as $list) {
				
				$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$list['userid'],'type'=>5,'reference_id'=>$list['job_id']),array('id'),true);
				
				if(count($last_email_records) < 3){
			
					$datesss= date('Y-m-d', strtotime($list['c_date']. ' + '.$setting['closed_date'].' days'));
					
					if(date('Y-m-d') > $datesss){
						
						$show_budget = '';
						$show_budget_text = '';
						if($this->show_budget==1){
							if($list['budget'] > 0){
								$show_budget .= '£'.$list['budget'];
								$show_budget_text = 'Budget';
							}
							
							if($list['budget2'] > 0){
								$show_budget .= ' - £'.$list['budget2'];
							}
							$show_budget .= ' GBP';
						}
					
						$homeOwner = $this->common_model->get_single_data('users',array('id'=>$list['userid']));
						
						$subject = "We currently can't find local tradespeople to quote your job: “".$list['title']."”"; 
							
						$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
		
						$html .= '<p style="margin:0;padding:10px 0px">Sorry we couldn\'t at this time get local tradespeople to quote your job.</p>';
						
						$html .= '<p style="margin:0;padding:0px 0px">Job title: '.$list['title'].'</p>';
						if($show_budget){
						$html .= '<p style="margin:0;padding:0px 0px">Your budget: '.$show_budget.'</p>';
						}
						
						$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can edit your post, increase the budget and re-post it. By increasing the budget, you will be able to attract more skilled tradespeople.</p>';
						
						$html .= '<br><div style="text-align:center"><a href="'.site_url().'my-posts?re-post='.$list['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit / Re-post</a></div>';
						
						$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$this->common_model->send_mail($homeOwner['email'],$subject,$html);
						
						$this->common_model->insert('last_email_records',array('user'=>$list['userid'],'type'=>5,'reference_id'=>$list['job_id'],'last_date'=>date('Y-m-d H:i:s')));
						
						/*echo 'Create Date: ' . date('d-m-Y',strtotime($list['c_date'])) . '<br>';
						echo 'Expired On: ' . date('d-m-Y',strtotime($datesss . '<br>';
						echo 'Job Id: ' . $list['job_id'] . '<br>';
						echo 'Job Title: ' . $list['title'] . '<br>';
						echo 'Login Id: ' . $homeOwner['email'] . '<br><hr>';*/
					}
				}
			}
		}
	}
	
	public function disput_remider(){
		
		$today = date('Y-m-d');
		
		$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time','commision'));
		
		$newTime1 = date('Y-m-d',strtotime($today.' -1 days'));
		$newTime2 = date('Y-m-d',strtotime($today.' -2 days'));
		$newTime3 = date('Y-m-d',strtotime($today.' -3 days'));
		
		$get_all_job = $this->common_model->get_all_data('tbl_dispute',array('ds_status'=>0));
		
		if(count($get_all_job) > 0){
		
			foreach($get_all_job as $key => $row){
				
				$dipute_by = $row['disputed_by'];
				
				$dipute_to = ($dipute_by==$row['ds_buser_id'])?$row['ds_puser_id']:$row['ds_buser_id']; 
				 
				$create_date = date('Y-m-d',strtotime($row['ds_create_date']));
				
				$replyTime = date('Y-m-d',strtotime($create_date.' +'.$setting['waiting_time'].' days'));
				
				$check = $this->common_model->get_single_data('disput_conversation_tbl',array('dct_disputid'=>$row['ds_id'],'dct_userid'=>$dipute_to));
				
				if($check==false){
					
					$DisputeBy=$this->common_model->GetColumnName('users',array('id'=>$dipute_by),array('f_name','l_name','email','trading_name','u_wallet'));
					
					$DisputeTo=$this->common_model->GetColumnName('users',array('id'=>$dipute_to),array('f_name','l_name','email','trading_name','u_wallet','type'));
					
					$milestone = $this->common_model->GetColumnName('tbl_milestones',array('id'=>$row['mile_id']),array('post_id','milestone_amount','milestone_name'));
					
					$job_id = $milestone['post_id'];
					
					$get_job_post = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$job_id),array('title'));
					
					if($newTime1 == $create_date){
						
						
					} else if($newTime2 == $create_date){
						
						if($DisputeTo['type']==1){
						
							$subject ="Reminder: Your response to the Milestone Payment Dispute is required.";
				
							//$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
							
							$contant = '<p style="margin:0;padding:10px 0px">Reminder - Your Milestone Payment to '.$DisputeBy['f_name'].' is being Disputed and requires your response!</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$DisputeTo['f_name'].',</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$DisputeBy['f_name'].' opened a dispute on your Milestone payment.</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$milestone['milestone_amount'].'</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Dispute Reason: '.$row['ds_comment'].'</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Your participation is essential to the claims process. If we don\'t receive a response from you before '.date('d M Y h:i:s A',strtotime($replyTime)).' this case will be closed and decided in the '.$DisputeBy['f_name'].' favour.</p>';
							
							$contant .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View & Respond Now</a></div><br>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within '.date('d M Y h:i:s A',strtotime($replyTime)).' will result in closing this case and deciding in the '.$DisputeBy['f_name'].'.  Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p><br>';
							
							
							$contant .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';

							$this->common_model->send_mail($DisputeTo['email'],$subject,$contant);
							
						} else {
							
							$subject ="Reminder: Your response to the Milestone Payment Dispute is required.";
			
							//$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
							
							$contant = '<p style="margin:0;padding:10px 0px">Your Milestone Payment to '.$DisputeBy['trading_name'].' is being Disputed and requires your response!</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$DisputeTo['f_name'].',</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$DisputeBy['trading_name'].' opened a dispute on your Milestone payment.</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$milestone['milestone_amount'].'</p>';
							
							//$contant .= '<p style="margin:0;padding:10px 0px">Dispute Reason: '.$row['ds_comment'].'</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Your participation is essential to the claims process. If we don\'t receive a response from you before '.date('d M Y h:i:s A',strtotime($replyTime)).' this case will be closed and decided in favour of '.$DisputeBy['trading_name'].'. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
							
							$contant .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View & Respond Now</a></div><br>';
							
						
							$contant .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

							$this->common_model->send_mail($DisputeTo['email'],$subject,$contant);
						}
						
					} else if($newTime3 == $create_date){
						
						if($DisputeTo['type']==1){
						
							$subject = "Final Reminder: Action required for Milestone Payment Dispute, “".$get_job_post['title']."”";
				
							//$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
							
							$contant = '<p style="margin:0;padding:10px 0px">Reminder - Your Milestone Payment is being Disputed</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$DisputeTo['f_name'].',</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$DisputeBy['f_name'].' opened a dispute on the Milestone payment.</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$milestone['milestone_amount'].'</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Dispute Reason: '.$row['ds_comment'].'</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Your participation is essential to the claims process. If we don\'t receive a response from you before '.date('d M Y h:i:s A',strtotime($replyTime)).' this case will be closed and decided in the '.$DisputeBy['f_name'].' favour.</p>';
							
							$contant .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div><br>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p><br>';
							
							
							$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

							$this->common_model->send_mail($DisputeTo['email'],$subject,$contant);
						
						} else {
							$subject = "Reminder: Your response to the Milestone Payment Dispute is required.";
				
							//$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
							
							$contant = '<p style="margin:0;padding:10px 0px">Your Milestone Payment to '.$DisputeBy['trading_name'].' is being Disputed and requires your response!</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$DisputeTo['f_name'].',</p>';
							
							$contant .= '<p style="margin:0;padding:10px 0px">We previously notified you that '.$DisputeBy['trading_name'].' opened a dispute on your Milestone payment.</p>';
							
							$contant .= '<p style="margin:0;padding:0px 0px">Job: '.$get_job_post['title'].'</p>';
							$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$milestone['milestone_amount'].'</p>';
							
							
							$contant .= '<p style="margin:0;padding:10px 0px">Your participation and response is essential to the claims process. If we don\'t receive a response from you before '.date('d M Y h:i:s A',strtotime($replyTime)).' this case will be closed and decided in favour of '.$DisputeBy['trading_name'].'. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
							
							$contant .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View & Respond Now</a></div><br>';
							
							
							
							$contant .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

							$this->common_model->send_mail($DisputeTo['email'],$subject,$contant);
						}
					}
				}
			}
		}
	}
	
	public function check_disput_reply(){
		$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time','commision'));
		
	
		$today = date('Y-m-d H:i:s');
		
		$newTime = date('Y-m-d H:i:s',strtotime($today.' -'.$setting['waiting_time'].' days'));
		
		$get_all_job = $this->common_model->get_all_data('tbl_dispute',array('ds_status'=>0));
		
		if(count($get_all_job) > 0){
		
			foreach($get_all_job as $key => $row){
				
				$dipute_by = $row['disputed_by'];
				
				$dipute_to = ($dipute_by==$row['ds_buser_id'])?$row['ds_puser_id']:$row['ds_buser_id']; 
				
				$create_date = date('Y-m-d H:i:s',strtotime($row['ds_create_date']));
				
				$replyTime = date('Y-m-d H:i:s',strtotime($create_date.' +'.$setting['waiting_time'].' days'));
				
				$check = $this->common_model->get_single_data('disput_conversation_tbl',array('dct_disputid'=>$row['ds_id'],'dct_userid'=>$dipute_to));
				
				if($check==false){
					
					$milestone = $this->common_model->get_single_data('tbl_milestones',array('id'=>$row['mile_id']));
					
					if($newTime > $create_date){
						
						$job_id = $milestone['post_id'];

						$tradesman = $row['ds_buser_id'];
						
						$homeowner = $row['ds_puser_id'];
						
						$dispute_ids = $row['ds_id'];
						
						$dispute_finel_user = $dipute_by;
						
						$home=$this->common_model->get_userDataByid($homeowner);
						$trades=$this->common_model->get_userDataByid($tradesman);
						$favo=$this->common_model->get_userDataByid($dispute_finel_user);
						
						$mile_id = $row['mile_id'];
						
						if($dipute_by==$tradesman){
							$massage = 'Dispute resolved as '.$home['f_name'].' failed to respond within four days.';
						} else {
							$massage = 'Dispute resolved as  '.$trades['f_name'].' failed to respond within four days.';
						}
						
						$insert['dct_disputid']=$dispute_ids;
						$insert['dct_userid']=0;
						$insert['dct_msg']=$massage;
						$insert['dct_isfinal']=1;
						$insert['mile_id']=$mile_id;	

						$run = $this->common_model->insert('disput_conversation_tbl',$insert);	
						
						if($run){
							
							$bid_update['status']=6;  
							
							$where="id = '".$mile_id."' and status = '5'";
							
							$this->common_model->update('tbl_milestones',$where,$bid_update);
							
							
							$disput_update['ds_status']=1;
							$disput_update['ds_favour']=$dispute_finel_user;

							$run1 = $this->common_model->update('tbl_dispute',array('ds_id'=>$dispute_ids),$disput_update);
							
							$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$milestone['post_id']));
								
							$amount = $milestone['milestone_amount'];
								
							if($trades['id']==$dispute_finel_user){
									
								$commision=$setting['commision'];
									
								$get_post_job = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$milestone['bid_id']));
						
								
									
								$pamnt = $get_post_job['paid_total_miles'];
								$final_amount = $pamnt + $amount;
									
								$sql3 = "update tbl_jobpost_bids set paid_total_miles = '".$final_amount."' where id = '".$milestone['bid_id']."'";
								$this->db->query($sql3);


								$total = ($amount*$commision)/100;
								
								$amounts = $amount-$total;
									
								$u_wallet=$trades['u_wallet'];
								
								$update1['u_wallet']=$u_wallet+$amounts;
								
							
								$this->common_model->update('tbl_milestones',array('id'=>$mile_id),array('is_dispute_to_traders'=>1));
									
								if($final_amount >= $get_post_job['bid_amount']) {
										
									$runss12 = $this->common_model->update_data('tbl_jobs',array('job_id'=>$milestone['post_id']),array('status'=>5));
										
									$runss123 = $this->common_model->update_data('tbl_jobpost_bids',array('id'=>$get_post_job['id']),array('status'=>4));
										
									$post_title=$get_job_post['title'];
										
									/*$insertn['nt_userId']=$get_post_job['bid_by'];
									
									$insertn['nt_message']='Congratulation this project has been completed successfully.<a href="'.site_url().'profile/'.$home['id'].'">'.$home['f_name'].' '.$home['l_name'].'</a> has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed.Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
									
									$insertn['nt_satus']=0;
									$insertn['nt_apstatus']=2;
									$insertn['nt_create']=date('Y-m-d H:i:s');
									$insertn['nt_update']=date('Y-m-d H:i:s');   
									$insertn['job_id']=$get_post_job['job_id'];
									$insertn['posted_by']=$get_post_job['posted_by'];
									$run2 = $this->common_model->insert('notification',$insertn);*/
										
									
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
									$insertn2['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">'.$home['f_name'].' '.$home['l_name'].'.</a>';
												
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
							$tr_message= 'Super Admin has resolved the <a href="'. site_url('dispute/'.$mile_id.'/'.$job_id).'">'.$milestone['milestone_name'].' milestone dispute</a> in favour of you and £'.$amounts.' has been credited in your wallet</b>';
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
							$this->common_model->insert('transactions',$data1);
							
							$insertn4['nt_userId']=$home['id'];
							$insertn4['nt_message']='Milestone payment dispute closed & decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
									
							$insertn4['nt_satus']=0;
							$insertn4['nt_apstatus']=0;
							$insertn4['nt_create']=date('Y-m-d H:i:s');
							$insertn4['nt_update']=date('Y-m-d H:i:s');   
							$insertn4['job_id']=$job_id;
							$insertn4['posted_by']=0;
							$this->common_model->insert('notification',$insertn4);
							
							$insertn5['nt_userId']=$trades['id'];
							$insertn5['nt_message']='Milestone payment dispute closed & decided. <a href="'.site_url('dispute/'.$mile_id.'/'.$job_id).'">View outcome!</a>';
									
							$insertn5['nt_satus']=0;
							$insertn5['nt_apstatus']=0;
							$insertn5['nt_create']=date('Y-m-d H:i:s');
							$insertn5['nt_update']=date('Y-m-d H:i:s');   
							$insertn5['job_id']=$job_id;
							$insertn5['posted_by']=0;
							$this->common_model->insert('notification',$insertn5);
							
							if($home['id']==$dispute_finel_user){
								
								$subject ="Milestone payment dispute has been automatically closed, Job: ".$get_job_post['title'];
				
								$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
							
								$contant .= '<p style="margin:0;padding:10px 0px">The case which '.$home['f_name'].' opened concerning a milestone payment to you has automatically closed because you didn\'t respond before '.date('d M Y h:i:s A',strtotime($replyTime)).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
								
								$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
								$contant .= '<p style="margin:0;padding:0px 0px">Dispute Reason: '.$massage.'</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

								$this->common_model->send_mail($trades['email'],$subject,$contant);
								
								$subject = "Milestone payment dispute opened by you has been closed automatically, Job: ".$get_job_post['title'];
								
								$contant = '<p style="margin:0;padding:10px 0px">Milestone dispute opened by you closed automatically!</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$home['f_name'].',</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">The milestone payment dispute which you opened against '.$trades['trading_name'].' has been closed automatically and decided in your favour as '.$trades['trading_name'].' didn\'t respond before '.date('d M Y',strtotime($replyTime)).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
								
								$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
								$contant .= '<p style="margin:0;padding:0px 0px">Dispute Reason: '.$massage.'</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

								$this->common_model->send_mail($home['email'],$subject,$contant);
								
							} else {
								
								$subject ="Milestone payment dispute has been automatically closed, Job: ".$get_job_post['title'];
				
								$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone dispute closed automatically!</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$trades['f_name'].',</p>';
							
								$contant .= '<p style="margin:0;padding:10px 0px">The case which you opened concerning a milestone payment to you has automatically closed because '.$home['f_name'].' didn\'t respond before '.date('d M Y h:i:s A',strtotime($replyTime)).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
								
								$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
								$contant .= '<p style="margin:0;padding:0px 0px">Dispute Reason: '.$massage.'</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

								$this->common_model->send_mail($trades['email'],$subject,$contant);
								
								$subject ="Milestone payment dispute opened by ".$trades['trading_name']." has been closed automatically, Job: ".$get_job_post['title'];
								
								$contant = '<p style="margin:0;padding:10px 0px">Milestone dispute opened by '.$trades['trading_name'].' closed automatically!</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">Hi '.$home['f_name'].',</p>';
								
								$contant .= '<p style="margin:0;padding:10px 0px">The milestone payment dispute which '.$trades['trading_name'].' opened against you has been closed automatically and decided in '.$trades['trading_name'].' favour as you didn\'t respond before '.date('d M Y',strtotime($replyTime)).'. Any funds associated with this payment, that were previously made available, are now unavailable.</p>';
								
								$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £'.$amount.'</p>';
								$contant .= '<p style="margin:0;padding:0px 0px">Dispute Reason: '.$massage.'</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
								$contant .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

								$this->common_model->send_mail($home['email'],$subject,$contant);
								
							}
							
							
								
							//$this->release_milestone($job_id,$dispute_finel_user);
						}
					}
				
				}
			}
		}
	}
	
	public function update_awarded_jobremider(){

		$this->update_ticket_status();
		
		$today = date('Y-m-d H:i:s');
		
		$newTime = date('Y-m-d',strtotime($today.' -3 hour'));
		
		$get_all_job = $this->common_model->get_all_data('tbl_jobs',array('status'=>4,'awarded_to != '=>0));
	
		if(count($get_all_job) > 0){
			foreach($get_all_job as $key => $row){
			
				$bid_data = $this->common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$row['job_id'],'status'=>3,'bid_by'=>$row['awarded_to']));
			
				if($bid_data){
					
					$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$row['awarded_to'],'type'=>1,'reference_id'=>$row['job_id']),array('last_date','id'));
					
					$check = false;
					
					if($last_email_records){
						$update_date = date('Y-m-d H:i:s',strtotime($last_email_records['last_date'].' +3 hour'));
						if(strtotime($today) >= strtotime($update_date)){
							$check = true;
						}
					} else {
						
						$update_date = date('Y-m-d H:i:s',strtotime($row['update_date']));
					
						if($newTime >= $update_date){
						
							$check = true;
							
						}
					}
					
					//$check = true;//for testing only
					
					if($check){
						if($bid_data['hiring_type']==1){
							
							$tradeMen = $this->common_model->GetColumnName('users',array('id'=>$row['awarded_to']),array('f_name','l_name','email','trading_name'));
							
							$home = $this->common_model->GetColumnName('users',array('id'=>$bid_data['posted_by']),array('f_name','l_name','email','trading_name'));
							
							$subject = "You're hired: Acceptance Reminder: ".$home['f_name']." is still waiting";
			
							$html = '<p style="margin:0;padding:10px 0px">Accept/reject the work offer!</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">Hi '.$tradeMen['f_name'].',</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">This follow-up message is to remind you that the direct job offer and hire by '.$home['f_name'].' is still waiting for your acceptance or rejection.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the job by clicking below buttons.</p>';
							
							$html .= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept Job</a> &nbsp; <a href="'.site_url().'proposals/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reject Job </a></div>';
							
							$html .= '<p style="margin:0;padding:10px 0px">If you have any question regarding the offer, don\'t hesitate to contact '.$home['f_name'].' through the chat section of the job page.</p>';
							$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$runs1=$this->common_model->send_mail($tradeMen['email'],$subject,$html);
							
						}	else {
							
							$tradeMen = $this->common_model->GetColumnName('users',array('id'=>$row['awarded_to']),array('f_name','l_name','email','trading_name'));
							
							$home = $this->common_model->GetColumnName('users',array('id'=>$bid_data['posted_by']),array('f_name','l_name','email','trading_name'));
							
							$subject = "Reminder to Accept Job Offer,  ".$home['f_name']."  is still waiting for your Acceptance:  Job “".$row['title']."”";
			
							$html .= '<p style="margin:0;padding:10px 0px">Hi '.$tradeMen['f_name'].',</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">This follow-up message is to remind you that the job offer “'.$row['title'].'” by '.$home['f_name'].' is still waiting for you to be accepted or rejected.</p>';
							
							$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the job by clicking below buttons.</p>';
							
							$html .= '<br><div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept Job</a> &nbsp; <a href="'.site_url().'proposals/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reject Job </a></div><br>';
							
							$html .= '<p style="margin:0;padding:10px 0px">If you have any question regarding the offer, don\'t hesitate to contact '.$home['f_name'].' through the chat section of the job page.</p>';
							$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$runs1=$this->common_model->send_mail($tradeMen['email'],$subject,$html);
							
						}	
						
						if($last_email_records){
							$this->common_model->update_data('last_email_records', array('id'=>$last_email_records['id']), array('last_date'=>date('Y-m-d H:i:s')));
						} else {
							$this->common_model->insert('last_email_records',array('user'=>$row['awarded_to'],'type'=>1,'reference_id'=>$row['job_id'],'last_date'=>date('Y-m-d H:i:s')));
						}
					}
				}
			}
		}
	}
	
	public function update_awarded_job(){
		
		$setting = $this->common_model->get_coloum_value('admin',array('id'=>1),array('waiting_time_accept_offer'));
		
		//$reminder_day = $setting
		
		$today = date('Y-m-d');
		
		$newTime = date('Y-m-d',strtotime($today.' -'.$setting['waiting_time_accept_offer'].' days'));
		//$newTime2 = date('Y-m-d',strtotime($today.' -'.$setting['waiting_time'].' days'));
		
		$get_all_job = $this->common_model->get_all_data('tbl_jobs',array('status'=>4,'awarded_to != '=>0));
		if(count($get_all_job) > 0){
			foreach($get_all_job as $key => $row){

				$bid_data = $this->common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$row['job_id'],'status'=>3,'bid_by'=>$row['awarded_to']));
			
				if($bid_data){
					
					$update_date = date('Y-m-d',strtotime($row['awarded_time']));
					
					if($newTime > $update_date){
						
						$homeOwner = $this->common_model->get_single_data('users',array('id'=>$row['userid']));
		
						$tradeMen = $this->common_model->get_single_data('users',array('id'=>$row['awarded_to']));
						
						if($bid_data['total_milestone_amount'] > 0){
	
							$update2['u_wallet']=$homeOwner['u_wallet']+$bid_data['total_milestone_amount'];
							$update2['spend_amount']=$homeOwner['spend_amount']-$bid_data['total_milestone_amount'];
						
							$runss1 = $this->common_model->update('users',array('id'=>$row['userid']),$update2);
							
							$transactionid = md5(rand(1000,999).time());
							
							$tr_message = '£'.$bid_data['total_milestone_amount'].' has been credited to your wallet.  <a href="'.site_url().'profile/'.$tradeMen['id'].'">'.$tradeMen['trading_name'].'</a> had not accept your proposal for <a href="'.site_url().'details/?post_id='.$row['job_id'].'">'.$row['title'].'</a>';
						 
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

						// $insertn['nt_message'] = 'Your <a href="'.site_url().'details/?post_id='.$row['job_id'].'">job offer</a> has expired as '.$tradeMen['trading_name'].' failed to respond.';
						$insertn['nt_message'] = $tradeMen['trading_name'] . ' didn´t respond to your offer. Post the job <a href="' .site_url('post-job') .'" >here.</a>';
								
						$insertn['nt_userId']=$homeOwner['id'];
						$insertn['nt_satus']=0;
						$insertn['nt_create']=date('Y-m-d H:i:s');
						$insertn['nt_update']=date('Y-m-d H:i:s');
						$insertn['job_id']=$bid_data['job_id'];
						$insertn['posted_by']=$homeOwner['id'];
						$insertn['nt_apstatus']=3;
							
						$this->common_model->insert('notification',$insertn);	
						
						$insertn2['nt_message'] = 'Your job offer has expired as you failed to respond.</a>';
						
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
						
						if($row['direct_hired']==1){
							$this->common_model->delete($where_array1,'tbl_jobs');
						} else {
							$this->common_model->update('tbl_jobs',$where_array1,$update);
						}
						
						//echo $this->db->last_query();
						
						$this->common_model->delete(array('id'=>$bid_data['id']),'tbl_jobpost_bids'); 
						$this->common_model->delete(array('bid_id'=>$bid_data['id']),'tbl_milestones'); 

						$subject = "Job Offer expired: ".$tradeMen['trading_name']." didn't respond to “".$row['title']."”"; 
						
						$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
		
						$html .= '<p style="margin:0;padding:10px 0px">Your job offer to '.$tradeMen['trading_name'].' expired today because they didn\'t respond.</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Job: '.$row['title'].'</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can award the job to another tradesperson or increase your budget to attract more skilled tradespeople.</p>';
						
						$html .= '<br><div style="text-align:center"><a href="'.site_url().'my-posts" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit Budget</a> &nbsp; &nbsp; <a href="'.site_url().'proposals/?post_id='.$bid_data['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Award</a></div>';
						
						$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$this->common_model->send_mail($homeOwner['email'],$subject,$html);
						
					}
					
				}
				
				
				
				
				
			}
		}
	}

  public function send_weekly_job_post(){
    $this->send_job_post('weekly');
  }

  public function send_daily_job_post(){
    $this->send_job_post('daily');
  }

  public function send_job_post($frequency){
    /* Send daily job post to unverified accounts */
		
		$whereJob = "(tbl_jobs.status=1 or tbl_jobs.status=2 or tbl_jobs.status=3 or tbl_jobs.status=8) and tbl_jobs.direct_hired != 1 and tbl_jobs.is_delete=0";
		//echo "this";die;
    if($frequency == 'daily'){
			$whereJob .= " and tbl_jobs.c_date >= '".date("Y-m-d 00:00:00")."'";
    
		}else{
			
      $monday = date('Y-m-d 00:00:00', strtotime("last Monday"));
      //$sunday = date('Y-m-d 23:59:59', strtotime("next Sunday -7 day"));
			
			$whereJob .= " and tbl_jobs.c_date >= '".$monday."'";
			
			//$whereJob .= " and tbl_jobs.c_date <= '".$sunday."'";
    }
		
    $jobs = $this->get_jobs($whereJob);
    //print_r($jobs);die;
    if(count($jobs) > 0){
      //$whereUser['u_wallet'] = 0;
      $whereUser['free_trial_taken'] = 0;
      $whereUser['is_pay_as_you_go'] = 0;
      $whereUser['type'] = 1;
      $whereUser['u_email_verify'] = 1;
      //$whereUser['id'] = 11;

      /* For testing */
     // $whereUser['email LIKE'] = 'hakim.webwiders@gmail.com';
      /* For testing */
			
			$show_budget_text = '';
			
			if($this->show_budget==1){
				$show_budget_text = 'Budget';
			}
			
			

      $columns = ['id', 'f_name', 'l_name', 'email' , 'category'];
      $users = $this->common_model->GetColumnName('users', $whereUser, $columns, true);

		//print_r($users);die;	
      if($frequency == 'daily'){
        $subject = "New ".$jobs[0]['cat_name']." Job Posted: ".$jobs[0]['city'].": Start your Free Trial Today!";
      }else{
        $subject = "Your Weekly Job Post Roundup - Start your Free Trial Today!";
      }
      
			//echo $jobList;
			//echo '<pre>';print_r($users);
		//print_r($jobs);die;	 
      foreach($users as $key => $user){
      	
      		//echo $user['email']; die;
	        $html = '';

	        $checkJoBdata = false;
	        /*$checkExist['user_id'] = $user['id'];
	        $checkExist['type'] = ($frequency == 'daily') ? 1 : 2;
	        $checkExist['created >='] = date("Y-m-d 00:00:00");
	        $checkExist['is_sent'] = 1;
	        $isExist = $this->common_model->GetColumnName('daily_email_records', $checkExist);
	        if(!$isExist){*/
	          $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
	          if($frequency == 'daily'){
	            $html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p>';
	          }else{
	            $html .= '<p style="margin:0;padding:10px 0px">Here are jobs that were posted near you this week</p>';
	          }

	          $jobList = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
			      <tr>
			        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
			        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">'.$show_budget_text.'</td>
			      </tr>';

			      $userCat = explode(',', $user['category']);
			      //echo $user['id'];
			      	//print_r($userCat); die();
			      foreach($jobs as $job){
			      	if(in_array($job['cat_id'], $userCat)){

			      		$jobList .= $this->job_email_body($job,$frequency);
	          			$checkJoBdata = true;
			      	}
			  		
			        
			        if($frequency == 'daily') break;


			      }

			$jobList .= '</table>';
			 $html .= $jobList;
		
	          $html .= '<br><br><p style="margin:0;padding:10px 0px">Start your free trial & get this job for Free! <a href="' .site_url() .'dashboard" style="background-color:#4a86e8;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none;float:right;">Start Free Trial</a></p>';

	          //print_r($jobList); die;
	          if($checkJoBdata){$this->common_model->send_mail($user['email'], $subject, $html);}
	          
						
						
						/*$insert['user_id'] = $user['id'];
	          $insert['type'] = ($frequency == 'daily') ? 1 : 2;
	          $insert['email'] = $user['email'];
	          $insert['subject'] = $subject;
	          $insert['created'] = date("Y-m-d H:i:s");

	          if($this->common_model->send_mail($user['email'], $subject, $html)){
	          // if($this->common_model->send_mail('rahim.webwiders@gmail', $subject, $html)){
	            $insert['is_sent'] = 1;
	          }
	          $this->common_model->insert('daily_email_records', $insert);*/
	        //}
	      
      
      }
    }
  }

  public function job_email_body($job,$frequency=null){
		
		$show_budget = '';
		$show_budget_text = '';
		if($this->show_budget==1){
			if($job['budget'] > 0){
				$show_budget .= '£'.$job['budget'];
				$show_budget_text = 'Budget';
			}
			
			if($job['budget2'] > 0){
				$show_budget .= ' - £'.$job['budget2'];
			}
			$show_budget .= ' GBP';
		}
		
    $return = '
      <tr>
        <td style="border:1px solid #E1E1E1; padding:10px 15px; width: 75%; vertical-align: top;">';
					if($frequency=='daily'){
						
						$return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">'.$job['cat_name'].' in '.$job['city'].'</h4>';
						
					} else if($frequency=='weekly'){
						
						$return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">Category :  '.$job['cat_name'].'</h4>';
						
					} else {
						
						$return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">Category :  '.$job['cat_name'].'</h4>';
						
					}
          $return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">Job title: ' .$job['title'] .'</h4>
          <p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">
            Description: ' .$job['description'] .'
          </p>
          
        </td>
        <td style="border:1px solid #E1E1E1; padding:10px 15px; width: 25%;  vertical-align: top;">';
					if($show_budget){
          $return .= '<h4 style="font-size:18px; margin: 0; margin-bottom: 8px; color: #333;">'.$show_budget.'</h4>';
					}
          $return .= '<a href="' .site_url() .'proposals?post_id=' .$job['job_id'] .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a>
        </td>
      </tr>';
			
			return $return;
  }

  public function send_missing_profile_reminder(){
    $dateCondition = date("Y-m-d", strtotime('-3 Day'));
		$today = date("Y-m-d");
		$where = "(profile IS NULL or profile = '') and cdate <= '".$dateCondition."' and type = 1 and u_email_verify = 1";
		//$where = "(profile IS NULL or profile = '') and type = 1";
		
    $users = $this->common_model->GetColumnName('users', $where, array('id','email','f_name','id'),true);

    $subject = 'Update your Profile';
		
    foreach($users as $user){
			
			$html = '';
			
			$last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$user['id'],'type'=>22),array('last_date','id','reference_id'));
			
				$today = date('Y-m-d');
				
				$check = false;
						
				if($last_email_records){
					$update_date = date('Y-m-d',strtotime($last_email_records['last_date'].' +7 day'));
					if(strtotime($today) >= strtotime($update_date) && $last_email_records['reference_id'] < 12){
						$check = true;
					}
				} else {
					$check = true;
				}
				
				if($check){
			
				
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Get featured on our directory and category by updating and professionalism your profile page with a picture, business description, Portfolio, Trade qualification and Public insurance if any.</p>';
				
				$html .= '<br><div style="text-align:center"><a href="'.site_url().'dashboard" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Update Your Profile</a></div><br>';
				
				$html .= '<p style="margin:0;padding:10px 0px">When you quote a job, we provide the homeowner your quote, including your profile. So it is important your profile is up to date with a profile picture and so on. Also completed profiles can attract the likelihood that the homeowner hires you directly.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
				
				if($this->common_model->send_mail($user['email'], $subject, $html)){
          $insert['is_sent'] = 1;
        } else {
					$insert['is_sent'] = 0;
				}
				
				/*if($isExist){
					
					$this->common_model->update_data('daily_email_records', array('id'=>$isExist['id']), array('created'=>date('Y-m-d H:i:s')));
					
				} else {
					
					$insert['user_id'] = $user['id'];
					$insert['type'] = 3;
					$insert['email'] = $user['email'];
					$insert['subject'] = $subject;
					$insert['created'] = date('Y-m-d H:i:s');
					
					$this->common_model->insert('daily_email_records',$insert);
					
				}*/

				if($last_email_records){
				$reference_id = $last_email_records['reference_id']+1;
				$this->common_model->update_data('last_email_records', array('id'=>$last_email_records['id']), array('last_date'=>date('Y-m-d H:i:s'),'reference_id'=>$reference_id+1));
			} else {
				$this->common_model->insert('last_email_records',array('user'=>$user['id'],'type'=>22,'reference_id'=>1,'last_date'=>date('Y-m-d H:i:s')));
			}
      }
    }
  }

  public function send_missing_document_reminder(){
    $today = date("Y-m-d");
    $dateCondition = date("Y-m-d", strtotime('-3 Day'));
    $where['u_id_card_status'] = 0;
    $where['cdate <='] = $dateCondition;
    $where['type'] = 1;
		$where['u_email_verify'] = 1;
		$where['u_wallet'] = 0;
    $where['free_trial_taken'] = 0;
    $where['is_pay_as_you_go'] = 0;
		
		$users = $this->common_model->GetColumnName('users', $where, array('id','email','f_name','id'),true);

    $subject = 'Please Upload your ID and Proof of Address Documents';
		//echo '<pre>'; print_r($users); die;
    foreach($users as $user){
      $html = '';

     $last_email_records = $this->common_model->GetColumnName('last_email_records',array('user'=>$user['id'],'type'=>23),array('last_date','id','reference_id'));
			
				$today = date('Y-m-d');
				
				$check = false;
						
				if($last_email_records){
					$update_date = date('Y-m-d',strtotime($last_email_records['last_date'].' +7 day'));
					if(strtotime($today) >= strtotime($update_date) && $last_email_records['reference_id'] < 12){
						$check = true;
					}
				} else {
					$check = true;
				}
				
				if($check){
        
        $html .= '<p style="margin:0;padding:10px 0px">Please Upload your ID and Proof of address.</p>';
				
        $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
				
        $html .= '<p style="margin:0;padding:10px 0px">You have not yet uploaded your ID and Proof of Address to Tradespeople Hub. You will not be able to gain full access to our service if your account is not fully verified. Verifying your identity is a precaution we take to keep homeowners safe.</p>';
        $html .= '<p style="margin:0;padding:10px 0px">The easiest way to do this is to take a picture of your driving license and a recent bank/utility statement with your phone and upload it to your account. Only our administrators will be able to see your confidential documents.</p>';
				
				$html .= '<div style="text-align:center"><a href="'.site_url().'dashboard" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Upload ID and Proof of Address</a></div>';
				
        $html .= '<p style="margin:0;padding:10px 0px">Once your account is fully verified, you will have full access to our service.</p>';
        $html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you are unsure how to verify your account or have any specific questions using our service.</p>';
				
        if($this->common_model->send_mail($user['email'], $subject, $html)){
          $insert['is_sent'] = 1;
        } else {
					$insert['is_sent'] = 0;
				}
				
				
				
				
				if($last_email_records){
				$reference_id = $last_email_records['reference_id']+1;
				$this->common_model->update_data('last_email_records', array('id'=>$last_email_records['id']), array('last_date'=>date('Y-m-d H:i:s'),'reference_id'=>$reference_id+1));
			} else {
				$this->common_model->insert('last_email_records',array('user'=>$user['id'],'type'=>23,'reference_id'=>1,'last_date'=>date('Y-m-d H:i:s')));
			}
      }
    }
		
	}

  public function get_jobs($whereJob = false){
    $join[0][0] = 'category';
    $join[0][1] = 'tbl_jobs.category = category.cat_id';
    $join[0][2] = 'left';
    $join[1][0] = 'users';
    $join[1][1] = 'tbl_jobs.userid = users.id';
    $join[1][2] = 'left';
    $join[2][0] = 'category AS subcategory';
    $join[2][1] = 'tbl_jobs.subcategory = subcategory.cat_id';
    $join[2][2] = 'left';
    $select = 'tbl_jobs.job_id, tbl_jobs.title, tbl_jobs.city, tbl_jobs.description, tbl_jobs.budget, tbl_jobs.post_code, category.cat_id, category.cat_name, users.id, users.county, subcategory.cat_id AS subcategory_id, subcategory.cat_name AS subcategory_name';

    
    return $this->common_model->join_records('tbl_jobs', $join, $whereJob, $select);
  }

  public function send_weekly_jobs(){
    /* Send jobs on every Saturday to verified tradesman */
		
		$whereJob = "(tbl_jobs.status=1 or tbl_jobs.status=2 or tbl_jobs.status=3 or tbl_jobs.status=8) and tbl_jobs.direct_hired != 1 and tbl_jobs.is_delete=0";
		
    $whereJob .= " and c_date >= '".date('Y-m-d 00:00:00', strtotime("last Saturday"))."'"; 
		$show_budget_text = '';
		if($this->show_budget==1){
			$show_budget_text = 'Budget';
		}
    
    $jobs = $this->get_jobs($whereJob);
    if(count($jobs) > 0){
      
			//$whereUser['u_wallet !='] = 0;
      //$whereUser['free_trial_taken !='] = 0;
      $whereUser['type'] = 1;
      $whereUser['u_email_verify'] = 1;
      $columns = ['id', 'f_name', 'l_name', 'email'];
      $users = $this->common_model->GetColumnName('users', $whereUser, $columns, true);
      if(count($users)>0){
        $jobList = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">'.$show_budget_text.'</td>
      </tr>';
        foreach($jobs as $job){
          $jobList .= $this->job_email_body($job,'weekly');
        }
				$jobList .= '</table>';
      }
      $subject = 'Your Weekly Job Post Roundup - Quote now!';
			
      foreach($users as $user){
				$html = '';
        $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
        $html .= '<p style="margin:0;padding:10px 0px">Here are jobs that were posted near you this week</p><br>';
        $html .= $jobList;
				$html .= '<br><br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
        $sent = $this->common_model->send_mail($user['email'], $subject, $html);
        
      }
    }
  }
  	

  public function test_function(){    
  }

  public function autoWithdrawOrderCancellation(){
  	$allServiceOrder = $this->common_model->get_all_data('service_order');
  	$setting = $this->common_model->GetColumnName('admin', array('id' => 1));
  	$today = date('Y-m-d');
  	
  	if(!empty($allServiceOrder)){
  		foreach($allServiceOrder as $list){
  			$newTime = '';
  			$readableTime = date('jS F Y', strtotime($list['status_update_time'] . ' +' . $setting['waiting_time'] . ' days'));
				$service = $this->common_model->GetSingleData('my_services',['id'=>$list['service_id']]);
				$get_users=$this->common_model->get_single_data('users',array('id'=>$list['user_id']));
				$get_users1=$this->common_model->get_single_data('users',array('id'=>$service['user_id']));
				$newTime = date('Y-m-d',strtotime($list['status_update_time'].' +'.$setting['waiting_time'].' days'));

				/*------------Order Cancel Itself------------*/
				if($list['status'] == 'cancelled' && $list['is_cancel'] == 2){
					if($today >= $newTime){
						$update2['u_wallet']=$get_users['u_wallet']+$list['price'];	
						$runss1 = $this->common_model->update('users',array('id'=>$list['user_id']),$update2);

						$insertn['nt_userId'] = $list['user_id'];
						$insertn['nt_message'] = 'Your order has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn['nt_satus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $id;
						$insertn['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn);

						$insertn1['nt_userId'] = $get_users1['id'];
						$insertn1['nt_message'] = 'Your order has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn1['nt_satus'] = 0;
						$insertn1['nt_create'] = date('Y-m-d H:i:s');
						$insertn1['nt_update'] = date('Y-m-d H:i:s');
						$insertn1['job_id'] = $id;
						$insertn1['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn1);

						$transactionid = md5(rand(1000,999).time());
					  $tr_message='£'.$list['price'].' has been credited to your wallet for order number '.$list['order_id'].' on date '.date('d-m-Y h:i:s A').'.';
					  $data1 = array(
							'tr_userid'=>$list['user_id'], 
					  	'tr_amount'=>$list['price'],
						  'tr_type'=>1,
					  	'tr_transactionId'=>$transactionid,
					  	'tr_message'=>$tr_message,
					  	'tr_status'=>1,
					  	'tr_created'=>date('Y-m-d H:i:s'),
					  	'tr_update' =>date('Y-m-d H:i:s')
						);
						$run1 = $this->common_model->insert('transactions',$data1);	

						$od['is_cancel'] = 1;
						$od['status'] = 'cancelled';		
						$od['reason'] = '';
						$od['status_update_time'] = date('Y-m-d H:i:s');
						$run = $this->common_model->update('service_order',array('id'=>$list['id']),$od);

						/*Manage Order History*/
					  $insert1 = [
				      'user_id' => $list['user_id'],
				      'is_cancel' => 1,
				      'service_id' => $list['service_id'],
				      'order_id' => $list['id'],
				      'status' => 'cancelled'
				    ];
				    $this->common_model->insert('service_order_status_history', $insert1);

				    $insert2['sender'] = 0;
						$insert2['receiver'] = 0;
						$insert2['order_id'] = $list['id'];
						$insert2['status'] = 'cancelled';
						$insert2['is_cancel'] = 1;
						$insert2['description'] = 'Your order has been cancelled itself due to not responsed before '.$readableTime;
						$run = $this->common_model->insert('order_submit_conversation', $insert2);

						/*---------Mail Code---------*/

						for($i=1; $i<=2;$i++){
							$uesrName = $i ==1 ? $get_users['f_name'].' '.$get_users['l_name'] : $get_users1['trading_name'];
							$uesrEmail = $i ==1 ? $get_users['email'] : $get_users1['email'];

							$subject1 = "Your order has been cancelled itself!"; 
							$content1= 'Hi '.$uesrName.', <br><br>';
							$content1.='Your order has been cancelled itself due to not responsed before '.$readableTime.'<br><br>';
							$content1.='Order number: '.$list['order_id'].'<br>';
							$content1.='Order amount: £'.$list['price'].'<br>';
							$content1.='<div style="text-align:center"><a href="'.site_url().'order-tracking/'.$list['id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Order</a></div><br>';

							$content1.='Visit our Homeowner help page or contact our customer services if you have any specific questions using our services';
							$this->common_model->send_mail($uesrEmail,$subject1,$content1);	
						}
					}
				}

				/*------------Order Cancel Itself If Order Is Not Delivered Before Delivery Date------------*/
				/*if($list['status'] == 'active'){
					$statusHistory = $this->common_model->GetSingleData('service_order_status_history',['order_id'=>$list['id'],'status'=>'active']);

					$delivery_date = '';
					$delivery_date1 = '';
					
					if(!empty($statusHistory)){
						$days = $package_data[$order['package_type']]['days'];
						$currentDate = new DateTime($statusHistory['created_at']);			
						$currentDate->modify("+$days days");
						$delivery_date = $currentDate->format('Y-m-d');
						$delivery_date1 = $currentDate->format('D jS F');
					}

					if($today > $delivery_date){
						$update2['u_wallet']=$get_users['u_wallet']+$list['price'];	
						$runss1 = $this->common_model->update('users',array('id'=>$list['user_id']),$update2);

						$insertn['nt_userId'] = $list['user_id'];
						$insertn['nt_message'] = 'Your order has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn['nt_satus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $id;
						$insertn['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn);

						$insertn1['nt_userId'] = $get_users1['id'];
						$insertn1['nt_message'] = 'Your order has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn1['nt_satus'] = 0;
						$insertn1['nt_create'] = date('Y-m-d H:i:s');
						$insertn1['nt_update'] = date('Y-m-d H:i:s');
						$insertn1['job_id'] = $id;
						$insertn1['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn1);

						$transactionid = md5(rand(1000,999).time());
					  $tr_message='£'.$list['price'].' has been credited to your wallet for order number '.$list['order_id'].' on date '.date('d-m-Y h:i:s A').'.';
					  $data1 = array(
							'tr_userid'=>$list['user_id'], 
					  	'tr_amount'=>$list['price'],
						  'tr_type'=>1,
					  	'tr_transactionId'=>$transactionid,
					  	'tr_message'=>$tr_message,
					  	'tr_status'=>1,
					  	'tr_created'=>date('Y-m-d H:i:s'),
					  	'tr_update' =>date('Y-m-d H:i:s')
						);
						$run1 = $this->common_model->insert('transactions',$data1);	

						$od['is_cancel'] = 1;
						$od['status'] = 'cancelled';		
						$od['reason'] = '';
						$od['status_update_time'] = date('Y-m-d H:i:s');
						$run = $this->common_model->update('service_order',array('id'=>$list['id']),$od);

						//Manage Order History
					  $insert1 = [
				      'user_id' => $list['user_id'],
				      'is_cancel' => 1,
				      'service_id' => $list['service_id'],
				      'order_id' => $list['id'],
				      'status' => 'cancelled'
				    ];
				    $this->common_model->insert('service_order_status_history', $insert1);

				    $insert2['sender'] = 0;
						$insert2['receiver'] = 0;
						$insert2['order_id'] = $list['id'];
						$insert2['status'] = 'cancelled';
						$insert2['is_cancel'] = 1;
						$insert2['description'] = 'Your order has been cancelled itself due to not delivered before '.$delivery_date1;
						$run = $this->common_model->insert('order_submit_conversation', $insert2);

						//---------Mail Code---------
						for($i=1; $i<=2;$i++){
							$uesrName = $i ==1 ? $get_users['f_name'].' '.$get_users['l_name'] : $get_users1['trading_name'];
							$uesrEmail = $i ==1 ? $get_users['email'] : $get_users1['email'];

							$subject1 = "Your order has been cancelled itself!"; 
							$content1= 'Hi '.$uesrName.', <br><br>';
							$content1.='Your order has been cancelled itself due to not delivered before '.$delivery_date1.'<br><br>';
							$content1.='Order number: '.$list['order_id'].'<br>';
							$content1.='Order amount: £'.$list['price'].'<br>';
							$content1.='<div style="text-align:center"><a href="'.site_url().'order-tracking/'.$list['id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Order</a></div><br>';

							$content1.='Visit our Homeowner help page or contact our customer services if you have any specific questions using our services';
							$this->common_model->send_mail($uesrEmail,$subject1,$content1);	
						}
					}
				}*/

				/*------------Order Complete Itself------------*/
				$completeTime = '';
				if($list['status'] == 'delivered'){
					if($today >= $newTime){
						$insertn['nt_userId'] = $list['user_id'];
						$insertn['nt_message'] = 'Your order has been completed itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn['nt_satus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $id;
						$insertn['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn);

						$insertn1['nt_userId'] = $get_users1['id'];
						$insertn1['nt_message'] = 'Your order has been completed itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
						$insertn1['nt_satus'] = 0;
						$insertn1['nt_create'] = date('Y-m-d H:i:s');
						$insertn1['nt_update'] = date('Y-m-d H:i:s');
						$insertn1['job_id'] = $id;
						$insertn1['posted_by'] = $list['user_id'];
						$run2 = $this->common_model->insert('notification',$insertn1);

						$od['status'] = 'completed';		
						$od['reason'] = '';
						$od['status_update_time'] = date('Y-m-d H:i:s');
						$run = $this->common_model->update('service_order',array('id'=>$list['id']),$od);

						/*Manage Order History*/
					  $insert1 = [
				      'user_id' => $list['user_id'],
				      'service_id' => $list['service_id'],
				      'order_id' => $list['id'],
				      'status' => 'completed'
				    ];
				    $this->common_model->insert('service_order_status_history', $insert1);

				    $insert2['sender'] = 0;
						$insert2['receiver'] = 0;
						$insert2['order_id'] = $list['id'];
						$insert2['status'] = 'completed';
						$insert2['description'] = 'Your order has been completed itself due to not responsed before '.$readableTime;
						$run = $this->common_model->insert('order_submit_conversation', $insert2);

						/*---------Mail Code---------*/

						for($i=1; $i<=2;$i++){
							$uesrName = $i ==1 ? $get_users['f_name'].' '.$get_users['l_name'] : $get_users1['trading_name'];
							$uesrEmail = $i ==1 ? $get_users['email'] : $get_users1['email'];

							$subject1 = "Your order has been completed itself!"; 
							$content1= 'Hi '.$uesrName.', <br><br>';
							$content1.='Your order has been completed itself due to not responsed before '.$readableTime.'<br><br>';
							$content1.='Order number: '.$list['order_id'].'<br>';
							$content1.='Order amount: £'.$list['price'].'<br>';
							$content1.='<div style="text-align:center"><a href="'.site_url().'order-tracking/'.$list['id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Order</a></div><br>';

							$content1.='Visit our Homeowner help page or contact our customer services if you have any specific questions using our services';
							$this->common_model->send_mail($uesrEmail,$subject1,$content1);	
						}
					}
				}

				/*------------Dispute Cancel Itself------------*/
				if($list['status'] == 'disputed' && $list['is_cancel'] == 5){
					$disputeData = $this->common_model->GetSingleData('tbl_dispute',['dispute_type'=>2,'ds_job_id'=>$list['id']]);

					$checkOtherUserReply = $this->common_model->GetColumnName('disput_conversation_tbl', array('dct_disputid' => $disputeData['ds_id'], 'dct_userid' => $disputeData['dispute_to']), ['dct_created'], false, 'dct_id', 'asc');

					if($today >= $newTime && empty($checkOtherUserReply)){						

						if(!empty($disputeData)){
							$favId = $disputeData['disputed_by'] == $get_users['id'] ? $get_users['id'] : $get_users1['id'];
							
							$disput_update['ds_status'] = 1;
							$disput_update['ds_favour'] = $favId;

							$run1 = $this->common_model->update('tbl_dispute',array('ds_id'=>$disputeData['ds_id']),$disput_update);

							if($run1){
								$home=$this->common_model->get_userDataByid($get_users['id']);
								$trades=$this->common_model->get_userDataByid($get_users1['id']);
								$favo=$this->common_model->get_userDataByid($favId);

								$amount = $list['price'];
								$get_commision=$this->common_model->get_single_data('admin',array('id'=>1));		
								$commision=$get_commision['commision'];

								if($trades['id']==$favId){
									$total = ($amount*$commision)/100;				
									$amounts = $amount-$total;									
									$u_wallet=$trades['u_wallet'];

									$withdrawable_balance=$trades['withdrawable_balance'];
									$update1['withdrawable_balance']=$withdrawable_balance+$amounts;
									$runss1 = $this->common_model->update('users',array('id'=>$get_users1['id']),$update1);
								}else{
									$u_wallet=$home['u_wallet'];
									$update1['u_wallet']=$u_wallet+$amount;
									$runss1 = $this->common_model->update('users',array('id'=>$get_users['id']),$update1);
								}

								$insertn['nt_userId'] = $list['user_id'];
								$insertn['nt_message'] = 'Your order dispute has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
								$insertn['nt_satus'] = 0;
								$insertn['nt_create'] = date('Y-m-d H:i:s');
								$insertn['nt_update'] = date('Y-m-d H:i:s');
								$insertn['job_id'] = $id;
								$insertn['posted_by'] = $list['user_id'];
								$run2 = $this->common_model->insert('notification',$insertn);

								$insertn1['nt_userId'] = $get_users1['id'];
								$insertn1['nt_message'] = 'Your order dispute has been cancelled itself <a href="'.site_url().'order-tracking/'.$list['id'].'">View Order!</a>';
								$insertn1['nt_satus'] = 0;
								$insertn1['nt_create'] = date('Y-m-d H:i:s');
								$insertn1['nt_update'] = date('Y-m-d H:i:s');
								$insertn1['job_id'] = $id;
								$insertn1['posted_by'] = $list['user_id'];
								$run2 = $this->common_model->insert('notification',$insertn1);

								$transactionid = md5(rand(1000,999).time());
							  $tr_message='£'.$list['price'].' has been credited to your wallet for order number '.$list['order_id'].' on date '.date('d-m-Y h:i:s A').'.';
							  $data1 = array(
									'tr_userid'=>$list['user_id'], 
							  	'tr_amount'=>$list['price'],
								  'tr_type'=>1,
							  	'tr_transactionId'=>$transactionid,
							  	'tr_message'=>$tr_message,
							  	'tr_status'=>1,
							  	'tr_created'=>date('Y-m-d H:i:s'),
							  	'tr_update' =>date('Y-m-d H:i:s')
								);
								$run1 = $this->common_model->insert('transactions',$data1);	

								$od['is_cancel'] = 8;
								$od['status'] = 'completed';
								$od['reason'] = '';
								$od['status_update_time'] = date('Y-m-d H:i:s');
								$run = $this->common_model->update('service_order',array('id'=>$list['id']),$od);

								/*Manage Order History*/
							  $insert1 = [
						      'user_id' => $list['user_id'],
						      'is_cancel' => 8,
						      'service_id' => $list['service_id'],
						      'order_id' => $list['id'],
						      'status' => 'disputed_cancelled'
						    ];
						    $this->common_model->insert('service_order_status_history', $insert1);

						    $insert2['sender'] = 0;
								$insert2['receiver'] = 0;
								$insert2['order_id'] = $list['id'];
								$insert2['status'] = 'disputed_cancelled';
								$insert2['is_cancel'] = 8;
								$insert2['description'] = 'Your order dispute has been cancelled itself due to not respond before '.$newTime;
								$run = $this->common_model->insert('order_submit_conversation', $insert2);

								/*---------Mail Code---------*/

								for($i=1; $i<=2;$i++){
									$uesrName = $i ==1 ? $get_users['f_name'].' '.$get_users['l_name'] : $get_users1['trading_name'];
									$uesrEmail = $i ==1 ? $get_users['email'] : $get_users1['email'];

									$subject1 = "Your order has been cancelled itself!"; 
									$content1= 'Hi '.$uesrName.', <br><br>';
									$content1.='Your order dipsute has been cancelled itself due to not delivered before '.$newTime.'<br><br>';
									$content1.='Order number: '.$list['order_id'].'<br>';
									$content1.='Order amount: £'.$list['price'].'<br>';
									$content1.='<div style="text-align:center"><a href="'.site_url().'order-tracking/'.$list['id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Order</a></div><br>';

									$content1.='Visit our Homeowner help page or contact our customer services if you have any specific questions using our services';
									$this->common_model->send_mail($uesrEmail,$subject1,$content1);	
								}
							}
						}
					}
				}
  		}
  	}
  }
}