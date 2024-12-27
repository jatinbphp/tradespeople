<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->db->query("set sql_mode = ''");
		$this->load->model('common_model');
		$this->load->helper('url');
		
		$this->perPage = 10;
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020');

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

	public function user_list_refresher(){
		
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('type');
		
		if($user_id) {
			$json['status']=1;
			
			$type = $this->session->userdata('type');
			$chat_list = $this->common_model->get_chat_list($user_id);
			$total_unread = $this->common_model->GetColumnName('chat',array('receiver_id'=>$user_id,'is_read'=>0),array('count(id) as total'));

			// echo '<pre>';
			// print_r($chat_list);
			// exit;
			
			$json['count'] = $total_unread['total'];
			
			$list = '';			
			
			if($chat_list) {
				foreach($chat_list as $row) {
					if($row['post_id']) {
						$rid = ($row['sender_id']==$user_id)?$row['receiver_id']:$row['sender_id'];

						$serviceName = '';
						if($row['type'] == 'service'){
							$service = $this->common_model->GetSingleData('my_services',['id'=>$row['post_id']]);	
							if(!empty($service)){
								$totalChr = strlen($service['service_name']);
								if($totalChr > 22 ){
									$sname = substr($service['service_name'], 0, 21).'...';		
								}else{
									$sname = $service['service_name'];
								}
								$serviceUrl = base_url().'service/'.$service['slug'];
								$serviceName = '<span class="time" style="display:block; font-size:12px;">'.$sname.'</span>';	
							}
						}
					
						$get_job_details=$this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$row['post_id']),array('job_id','title','project_id','direct_hired','awarded_to'));
					
						$sender = $this->common_model->get_single_data('users',array('id'=>$rid));
					
						if($type == 1){					
							$showName = $sender['f_name'].' '.$sender['l_name'];
							$get_plan_bids=$this->common_model->get_single_data('user_plans',array('up_user'=>$user_id,'up_status'=>1),'up_id');	
				
							$get_chat_paid=$this->common_model->get_single_data('chat_paid',array('user_id'=>$user_id,'post_id'=>$row['post_id']));
										
							if($get_job_details['direct_hired']==0 || ($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) || $get_chat_paid){						
								$onclick = 'get_chat_onclick('.$rid.','.$row['post_id'].');showdiv();';						
							} else {						
								$onclick = 'pay_chat_first('.$rid.','.$row['post_id'].',1);';						
							}
						} else {					
							$showName = $sender['trading_name'];						
							$onclick = 'get_chat_onclick('.$rid.','.$row['post_id'].');showdiv();';
						}
					 
						if($get_job_details['direct_hired']==1){
							$tradesman = $this->common_model->GetColumnName('users',array('id'=>$get_job_details['awarded_to']),array('trading_name'));
							$jobName = 'Work for '.$tradesman['trading_name'];
						} else {
							$jobName = $get_job_details['title'];
						}
					
						if(strlen($jobName) > 30){
							$jobName = substr($jobName,0,30).'...';
						}

						$itemName = $row['type'] == 'service' ? $serviceName : '<span class="time" style="display:block; font-size:12px;">'.$jobName.'</span>';
									 
						$unread = $this->common_model->get_unread_by_sid_rid($user_id,$rid,$row['post_id']);
					
						$unread = ($unread[0]['total']>0) ? '('.$unread[0]['total'].')' : '';
					
						$list .= '<li class="other-message">
											<a href="javascript:void(0);" onclick="'.$onclick.'">
												<div class="message-data">';
												
													if($sender['profile']) {
														$list .= '<img src="'.site_url().'img/profile/'.$sender['profile'].'" alt="">';							
													} else {
														$list .= '<img src="'.site_url().'img/profile/dummy_profile.jpg" alt="">';
													}
													
													$list .= '<div class="message me-message">
														<span class="message-data-name">'.$showName.' '.$unread.'</span>
														'.$itemName.'
													</div>
												</div>
											</a>
										</li>';
					}
				}
			} else  {
				$list .= '<div class="alert alert-warning">We did not find any records!</div>';
			}	
			$json['list'] = $list;
		} else {
			$json['status']=0;
		}
		echo json_encode($json);
	}

	public function get_chats1() {
		$json['data']='';
		$serviceName = !empty($_REQUEST['serviceName']) ? '<span>Service: '.$_REQUEST['serviceName'].'</span>' : '';
		if($this->session->userdata('type')==1) {
		
			$user_id=$this->session->userdata('user_id');
			
			$job_data = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post']));
			
			$get_plan_bids=$this->common_model->get_user_bids('user_plans',$user_id);
			
			$get_chat_paid=$this->common_model->get_single_data('chat_paid',array('user_id'=>$this->session->userdata('user_id'),'post_id'=>$_REQUEST['post']));
			
			if($job_data['direct_hired']==0 || ($get_plan_bids && $get_plan_bids[0]['up_status']==1 && strtotime($get_plan_bids[0]['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids[0]['valid_type']==1) || $get_chat_paid){
				
				$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
				
				$userid=$this->session->userdata('user_id');
				
				$get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['post']);

				if($get_users['profile']) {
					$us_profile=$get_users['profile'];
				} else {
					$us_profile="dummy_profile.jpg";
				}
				
				$json['q2'] = $this->db->last_query();

				$json['userdetail'] = 	'';

				$json['userdetail'] .= 	'<h4 class="mine_headr"><span id="image11"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span>'.$serviceName.'<a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername11" style="color:#fff;">'.$get_users['f_name'].' '.$get_users['l_name'].'</span></a></h4>';
				
				$json['data']='';
				
				if($get_chats) {
					foreach ($get_chats as $row) { 
					
						$get_time=$this->common_model->time_ago($row['create_time']); 
						$get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

						if($get_user_details['profile']) {
							$u_profile=$get_user_details['profile'];
						} else {
							$u_profile="dummy_profile.jpg";
						}
							
						if($row['receiver_id']==$userid) {
							$update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
						}
						
						$json['data'].='';
						if($row['sender_id']==$userid) {
							$json['data'].='<li class="my-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span class="time">'.$get_time.'</span></div></div></li>';

						} else{
		
							$json['data'].='<li class="other-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><span class="time">'.$get_time.'</span></div></div></li>';
						}
					 
					}

				}else {
					$json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
				}
				

				$json['status']=1;
			
			} else {
				
				$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
				$userid=$this->session->userdata('user_id');
			
				if($get_users['profile']) {
					$us_profile=$get_users['profile'];
				} else {
					$us_profile="dummy_profile.jpg";
				}
					$json['q2'] = $this->db->last_query();

					$json['userdetail'] =   '';
			
					$json['userdetail'] .=  '<h4 class="mine_headr">
					<span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span>'.$serviceName.'<a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$get_users['f_name'].' '.$get_users['l_name'].'</span></a></h4>';
					$json['status']=0;
					$json['data'] .= '<div class="alert alert-warning">To start chat please buy a plan.</div><div class="row"><div class="col-sm-4"></div><div class="col-sm-4"><a href="#" data-target="#chat_payment_model" data-toggle="modal" class="btn btn-primary">Buy Now</a></div><div class="col-sm-4"></div></div>';
			}
				
			
		} else {
			$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
			$userid=$this->session->userdata('user_id');
			$get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['post']);
	
			if($get_users['profile'])  {
				$us_profile=$get_users['profile'];
			} else {
				$us_profile="dummy_profile.jpg";
			}
			
			$json['q2'] = $this->db->last_query();

			$json['userdetail'] = 	'';
	
			$json['userdetail'] .= 	'<h4 class="mine_headr">
      <span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span><a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$get_users['f_name'].' '.$get_users['l_name'].'</span></a></h4>';
			$json['data']='';
    
			if($get_chats) {
    	foreach ($get_chats as $row) {

    		$get_time=$this->common_model->time_ago($row['create_time']); 
    		$get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

				if($get_user_details['profile']) {
					$u_profile=$get_user_details['profile'];
				} else {
					$u_profile="dummy_profile.jpg";
				}
                   
				if($row['receiver_id']==$userid) {
					$update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
				}
				$json['data'].='';
				if($row['sender_id']==$userid) {
					$json['data'].='<li class="my-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span class="time">'.$get_time.'</span></div></div></li>';

				} else {
			
					$json['data'].='<li class="other-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><span class="time">'.$get_time.'</span></div></div></li>';
				}
             
			}

			}else {
				$json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
			}


			$json['status']=1;
		}

		echo json_encode($json);
	}

	public function get_chats() {
		$json['data']='';
		$serviceUrl = '#';

		// if(!empty($_REQUEST['serviceName'])){
		// 	$service_details = $this->common_model->get_service_details('my_services',$_REQUEST['serviceName']);
		// 	$totalChr = strlen($service_details['service_name']);
		// 	if($totalChr > 22 ){
		// 		$sname = substr($service_details['service_name'], 0, 21).'...';		
		// 	}else{
		// 		$sname = $service_details['service_name'];
		// 	}
		// 	$serviceUrl = base_url().'service/'.$service_details['slug'];
		// }		

		// $serviceName = !empty($_REQUEST['serviceName']) ? '<span style="display:block; font-size:12px;"><a href="'.$serviceUrl.'" style="color:#fff; font-size:12px;">'.$sname.'</a></span>' : 'test';

		// $order_id = !empty($_REQUEST['lastOrder']) ? '<span style="display:block">Order: '.$_REQUEST['lastOrder'].'</span>' : '';

		$order_id = '';

		if($this->session->userdata('type')==1) {
			
			$user_id=$this->session->userdata('user_id');
			
			$job_data = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post']));
			
			$get_plan_bids=$this->common_model->get_single_data('user_plans',array('up_user'=>$user_id,'up_status'=>1),'up_id');
			
			$get_chat_paid=$this->common_model->get_single_data('chat_paid',array('user_id'=>$this->session->userdata('user_id'),'post_id'=>$_REQUEST['post']));

			$settings = $this->common_model->get_all_data('admin');

			if($settings[0]['payment_method'] == 1){
				if($job_data['direct_hired']==0 || ($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) || $get_chat_paid){
				
					$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));

					$uName = $get_users['type'] == 1 ? $get_users['trading_name'] : $get_users['f_name'].' '.$get_users['l_name'];

					$uName = $get_users['type'] == 1 ? $get_users['trading_name'] : $get_users['f_name'].' '.$get_users['l_name'];

					$userid=$this->session->userdata('user_id');
					$get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['post']);

					if($get_users['profile']) {
						$us_profile=$get_users['profile'];
					} else {
						$us_profile="dummy_profile.jpg";
					}
						
					$json['q2'] = $this->db->last_query();

					$json['userdetail'] = 	'';

					$serviceName = '';
					$lastChat = end($get_chats);
					if($lastChat['type'] == 'service'){
						$service = $this->common_model->GetSingleData('my_services',['id'=>$lastChat['post_id']]);	
						if(!empty($service)){
							$totalChr = strlen($service['service_name']);
							if($totalChr > 22 ){
								$sname = substr($service['service_name'], 0, 21).'...';		
							}else{
								$sname = $service['service_name'];
							}
							$serviceUrl = base_url().'service/'.$service['slug'];
							$serviceName = '<span style="display:block; font-size:12px;"><a href="'.$serviceUrl.'" style="color:#fff; font-size:12px;">'.$sname.'</a></span>';	
						}							
					}					

					$json['userdetail'] .= '<h4 class="mine_headr"><span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span><span><a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$uName.'</span></a>'.$serviceName.'</span></h4>';
					$json['data']='';
				
					if($get_chats) {
						foreach ($get_chats as $row) {
							/*Make Custom Offer Design*/
							$get_time=$this->common_model->time_ago($row['create_time']); 
							$serviceDiv = $this->makeDiv($row,0,$get_time);
							$serviceDiv1 = $this->makeDiv($row,1,$get_time);

							$dNone = !empty($serviceDiv) ? 'hidden' : '';
							$dNone1 = !empty($serviceDiv1) ? 'hidden' : '';
							
							$get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

							if($get_user_details['profile']) {
								$u_profile=$get_user_details['profile'];
							} else {
								$u_profile="dummy_profile.jpg";
							}
							
							if($row['receiver_id']==$userid) {
								$update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
							}
							
							$json['data'].='';
										
							if($row['sender_id']==$userid) {
								$json['data'].='<li class="my-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv1.'</span><span class="time '.$dNone1.'">'.$get_time.'</span></div></div></li>';

							} else {
					
								$json['data'].='<li class="other-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['trading_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv.'</span><span class="time '.$dNone.'">'.$get_time.'</span></div></div></li>';
							}								 
						}
					}else {
						$json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
					}
					$json['status']=1;
				} else {
					$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
					$uName = $get_users['type'] == 1 ? $get_users['trading_name'] : $get_users['f_name'].' '.$get_users['l_name'];
					$userid=$this->session->userdata('user_id');
				
					if($get_users['profile']) {
						$us_profile=$get_users['profile'];
					} else {
						$us_profile="dummy_profile.jpg";
					}
					$json['q2'] = $this->db->last_query();

					$json['userdetail'] =   '';
				
					$json['userdetail'] .=  '<h4 class="mine_headr"><span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span><span><a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$uName.'</span></a>'.$serviceName.'</span></h4>';
					$json['status']=0;
					$json['data'] .= '<div class="alert alert-warning">To start chat please buy a plan.</div><div class="row"><div class="col-sm-4"></div><div class="col-sm-4"><a href="javascript:void(0);" data-target="#chat_payment_model" data-toggle="modal" class="btn btn-primary">Buy Now</a></div><div class="col-sm-4"></div></div>';
				}
			}else{
				$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
				$uName = $get_users['type'] == 1 ? $get_users['trading_name'] : $get_users['f_name'].' '.$get_users['l_name'];
				$userid=$this->session->userdata('user_id');
				$get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['post']);
		
				if($get_users['profile']) {
					$us_profile=$get_users['profile'];
				} else {
					$us_profile="dummy_profile.jpg";
				}
					
				$json['q2'] = $this->db->last_query();

				$json['userdetail'] = 	'';

				$serviceName = '';
				$lastChat = end($get_chats);
				if($lastChat['type'] == 'service'){
					$service = $this->common_model->GetSingleData('my_services',['id'=>$lastChat['post_id']]);	
					if(!empty($service)){
						$totalChr = strlen($service['service_name']);
						if($totalChr > 22 ){
							$sname = substr($service['service_name'], 0, 21).'...';		
						}else{
							$sname = $service['service_name'];
						}
						$serviceUrl = base_url().'service/'.$service['slug'];
						$serviceName = '<span style="display:block; font-size:12px;"><a href="'.$serviceUrl.'" style="color:#fff; font-size:12px;">'.$sname.'</a></span>';	
					}							
				}

				$json['userdetail'] .= 	'<h4 class="mine_headr"><span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span><span><a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$uName.'</span></a>'.$serviceName.'</span></h4>';
				$json['data']='';
			
				if($get_chats) {
					foreach ($get_chats as $row) {
						/*Make Custom Offer Design*/
						$get_time = $this->common_model->time_ago($row['create_time']); 
						$serviceDiv = $this->makeDiv($row,0,$get_time);
						$serviceDiv1 = $this->makeDiv($row,1,$get_time);

						$dNone = !empty($serviceDiv) ? 'hidden' : '';
						$dNone1 = !empty($serviceDiv1) ? 'hidden' : '';
						
						$get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

						if($get_user_details['profile']) {
							$u_profile=$get_user_details['profile'];
						} else {
							$u_profile="dummy_profile.jpg";
						}
						
						if($row['receiver_id']==$userid) {
							$update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
						}
						
						$json['data'].='';
									
						if($row['sender_id']==$userid) {
							$json['data'].='<li class="my-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv1.'</span><span class="time '.$dNone1.'">'.$get_time.'</span></div></div></li>';
						} else {				
							$json['data'].='<li class="other-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['trading_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv.'</span><span class="time '.$dNone.'">'.$get_time.'</span></div></div></li>';
						}							 
					}
				}else {
					$json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
				}
				$json['status']=1;
			}
		} else {
			$get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
			$uName = $get_users['type'] == 1 ? $get_users['trading_name'] : $get_users['f_name'].' '.$get_users['l_name'];
			$userid=$this->session->userdata('user_id');
			$get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['post']);
	
			if($get_users['profile'])  {
				$us_profile=$get_users['profile'];
			} else {
				$us_profile="dummy_profile.jpg";
			}
				
			$json['q2'] = $this->db->last_query();

			$json['userdetail'] = 	'';

			$serviceName = '';
			$lastChat = end($get_chats);
			if($lastChat['type'] == 'service'){
				$service = $this->common_model->GetSingleData('my_services',['id'=>$lastChat['post_id']]);	
				if(!empty($service)){
					$totalChr = strlen($service['service_name']);
					if($totalChr > 22 ){
						$sname = substr($service['service_name'], 0, 21).'...';		
					}else{
						$sname = $service['service_name'];
					}
					$serviceUrl = base_url().'service/'.$service['slug'];
					$serviceName = '<span style="display:block; font-size:12px;"><a href="'.$serviceUrl.'" style="color:#fff; font-size:12px;">'.$sname.'</a></span>';	
				}
			}

			$json['userdetail'] .= 	'<h4 class="mine_headr"><span id="image"><a href="'.site_url().'profile/'.$get_users['id'].'"><img src="'.site_url().'img/profile/'.$us_profile.'"></a></span><span><a href="'.site_url().'profile/'.$get_users['id'].'"><span id="chatername" style="color:#fff;">'.$uName.'</span></a>'.$serviceName.'</span></h4>';
			$json['data']='';
	
			if($get_chats){
				foreach ($get_chats as $row) {
					/*Make Custom Offer Design*/
					$get_time = $this->common_model->time_ago($row['create_time']); 
					$serviceDiv = $this->makeDiv($row,0,$get_time);
					$serviceDiv1 = $this->makeDiv($row,1,$get_time);

					$dNone = !empty($serviceDiv) ? 'hidden' : '';
					$dNone1 = !empty($serviceDiv1) ? 'hidden' : '';
					
					$get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

					if($get_user_details['profile']){
						$u_profile=$get_user_details['profile'];
					} else {
						$u_profile="dummy_profile.jpg";
					}
					
					if($row['receiver_id']==$userid) {
						$update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
					}
					$json['data'].='';
					
					if($row['sender_id']==$userid) {
						$json['data'].='<li class="my-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['f_name'].' '.$get_user_details['l_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv1.'</span><span class="time '.$dNone1.'">'.$get_time.'</span></div></div></li>';
					} else {		
						$json['data'].='<li class="other-message"><div class="message-data"><a href="'.site_url().'profile/'.$get_user_details['id'].'"><img src="'.site_url().'img/profile/'.$u_profile.'" width="60" height="60"></a><div class="message me-message"><span class="message-data-name">'.$get_user_details['trading_name'].'</span><span class="Messsagee">'.$row['mgs'].'</span><br><span>'.$serviceDiv.'</span><span class="time '.$dNone.'">'.$get_time.'</span></div></div></li>';
					}					 
				}
			}else {
				$json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
			}

			$json['status']=1;
		}
		
		echo json_encode($json);
	}
	
	function send_msg() {
		if($this->input->post('post_ids')) {
			$post_id=$this->input->post('post_ids');
		} else if($this->input->post('post_id')) {
			$post_id=$this->input->post('post_id');
		}
		
		$userid=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('type');
		$chat_type=$this->input->post('chat_type');
		$receiver=$this->input->post('rid');

		$words=$this->words;
		$msg=$this->input->post('ch_msg');
		$msg1=strtolower($this->input->post('ch_msg'));

		$singleChat = $this->common_model->get_single_chat($userid, $receiver);

		$cType = !empty($singleChat) ? $singleChat->type : 'post';

		foreach ($words as $url) {
			if (strpos($msg1, $url) !== FALSE) { 
				$insert['type']=$cType;
				$insert['post_id']=$post_id;
				$insert['sender_id']=$userid;
				$insert['receiver_id']=$receiver;
				$insert['mgs']='<i class="fa fa-ban" aria-hidden="true" style="color:red;"></i> This message has been deleted by admin.';
				$insert['is_read']=0;
				$insert['create_time']=date('Y-m-d H:i:s');
				$run = $this->common_model->insert('chat',$insert);
				$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
				
				if($run) {
					$notArr = [];
					$notArr['title'] = $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message';
					$notArr['message'] = $insert['mgs'];
					$notArr['link'] = site_url().'proposals/?post_id='.$post_id;
					$notArr['user_id'] = $receiver;
					$notArr['behalf_of'] = $user_id;
					$this->common_model->AndroidNotification($notArr);

					$OneSignalNoti = [];
					$OneSignalNoti['title'] = $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message';;
					$OneSignalNoti['message'] = $insert['mgs'];
					$OneSignalNoti['is_customer'] = ($user_type==1) ? true : false; // if sender is tradesmen then notification goes to customer 
					$OneSignalNoti['user_id'] = $receiver;
					/*$OneSignalNoti['pushdata']['message_type'] = 'chat';
					$OneSignalNoti['pushdata']['link'] = site_url().'proposals/?post_id='.$post_id; //in pushdata array you can send any data
					$OneSignalNoti['pushdata']['sender'] = $userid;
					$OneSignalNoti['pushdata']['receiver'] = $receiver;
					$OneSignalNoti['pushdata']['job_id'] = $post_id;*/

					$OneSignalNoti['pushdata']['action'] = 'chat_msg';
					$OneSignalNoti['pushdata']['other_user_id'] = $receiver;
					$OneSignalNoti['pushdata']['user_id'] = $userid;
					$OneSignalNoti['pushdata']['action_id'] = $post_id;

					//print_r($OneSignalNoti);
					$return = $this->common_model->OneSignalNotification($OneSignalNoti);
					//print_r($return);

					$insertn = [];
					$insertn['nt_userId']=$receiver;
					$insertn['nt_message']= $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
					$insertn['nt_satus']=0;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');
					$insertn['job_id']=$post_id;
					$insertn['posted_by']=$userid;
					$insertn['action']=$OneSignalNoti['pushdata']['action'];
					$insertn['action_id']=$OneSignalNoti['pushdata']['action_id'];
					$insertn['action_json']=json_encode($OneSignalNoti['pushdata']);
					$run2 = $this->common_model->insert('notification',$insertn);

					$json['status']=1;
				} else {
					$json['status']=0;
				}
				echo json_encode($json);
				return true;
			}
		}
		
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		//$reciever_users=$this->common_model->get_single_data('users',array('id'=>$receiver));
		
		$check_last = $this->common_model->GetColumnName('chat',array("post_id"=>$post_id,"receiver_id" =>$receiver),array('create_time'),null,'id');
		
		if($check_last==false){
			
			$link = site_url()."proposals?post_id=".$post_id.'&chat='.$userid;
			$respSL = file_get_contents('https://cutt.ly/api/api.php?key=69d958cf7b30dd3bef9485886a1d820bdcd57&short='.$link);
			$respSLJ = json_decode($respSL);
			$shortLink = $respSLJ->url->shortLink;
			
			$has_sms_noti = $this->common_model->check_sms_notification($receiver);
			
			if($has_sms_noti){
					
				$sms = $get_users['f_name']." is interested in your quote and would like to discuss it with you. Chat now \r\n".$shortLink." \r\n \r\n Tradespeoplehub.co.uk";
				
				$this->load->model('send_sms'); 
				//$this->send_sms->send_india($has_sms_noti['phone_no'],$sms);
				$this->send_sms->send($has_sms_noti['phone_no'],$sms);
				
				$this->common_model->update('user_plans',array('up_user'=>$receiver),array('used_sms_notification'=>$has_sms_noti['used_sms_notification']));
				
			} 
			
			$has_email_noti = $this->common_model->check_email_notification($receiver);
						
			if($has_email_noti){				
				if($has_email_noti['type']==1){
					$user_namess = $get_users['f_name'];
					$subject = "New Messages from ".$user_namess;
				
					$html = '<p style="margin:0;padding:10px 0px">'.$msg.'</p><div style="text-align:center"><a href="'.$link.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div><br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
					
				} else {
					
					$user_namess = $get_users['trading_name'];
					
					$subject = "New Messages from ".$user_namess;
				
					$html = '<p style="margin:0;padding:10px 0px">'.$msg.'</p>';
					
					$html .= '<br><div style="text-align:center"><a href="'.$link.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div>';
					
					$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
				}				

				try{
					$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html,null,$user_namess.' via Tradespeoplehub');

					// $file = 'logFile.txt';
					// $handle = fopen($file, 'a');
					// $data = date('Y-m-d h:i:s').'-----'.$has_email_noti['email']."\n";
					// if (fwrite($handle, $data) === false) {
					//     die('Could not write to file');
					// }
					// fclose($handle);
				}catch(Exception $e){
					// $file = 'errorLogFile.txt';
					// $handle = fopen($file, 'a');
					// $data = date('Y-m-d h:i:s').'-----'."Error In send chat msg===>".$e->getMessage();
					// if (fwrite($handle, $data) === false) {
					//     die('Could not write to file');
					// }
					// fclose($handle);
				}
			}
		}
		
		$insert['post_id']=$post_id;
		$insert['type']=$cType;
		$insert['sender_id']=$userid;
		$insert['receiver_id']=$receiver;
		$insert['mgs']=$msg;
		$insert['is_read']=0;
		$insert['type']= !empty($chat_type) ? $chat_type : 'post';
		$insert['create_time']=date('Y-m-d H:i:s');
		$run = $this->common_model->insert('chat',$insert);
		
		$insertn['nt_userId']=$receiver;
		
		if($get_users['trading_name']){
			$insertn['nt_message']= $get_users['trading_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
      		$notArr['message'] = $get_users['trading_name'].' has sent you a message.';
    	}else{
      		$insertn['nt_message']= $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
      		$notArr['message'] = $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message.';
    	}
		
		

		$notArr['title'] = 'New Chat Message';
		
		$notArr['link'] = site_url().'proposals/?post_id='.$post_id;
		$notArr['user_id'] = $receiver;
		$notArr['behalf_of'] = $userid;
		$this->common_model->AndroidNotification($notArr);

		$OneSignalNoti = [];
		$OneSignalNoti['title'] = $notArr['message'];
		$OneSignalNoti['message'] = $msg;
		$OneSignalNoti['is_customer'] = ($user_type==1) ? true : false; // if sender is tradesmen then notification goes to customer 
		$OneSignalNoti['user_id'] = $receiver;
		/*$OneSignalNoti['pushdata']['message_type'] = 'chat';
		$OneSignalNoti['pushdata']['link'] = site_url().'proposals/?post_id='.$post_id; //in pushdata array you can send any data
		$OneSignalNoti['pushdata']['sender'] = $userid;
		$OneSignalNoti['pushdata']['receiver'] = $receiver;
		$OneSignalNoti['pushdata']['job_id'] = $post_id;*/
		$OneSignalNoti['pushdata']['action'] = 'chat_msg';
		$OneSignalNoti['pushdata']['other_user_id'] = $receiver;
		$OneSignalNoti['pushdata']['user_id'] = $userid;
		$OneSignalNoti['pushdata']['action_id'] = $post_id; 
		//print_r($OneSignalNoti);
		$return = $this->common_model->OneSignalNotification($OneSignalNoti);
		//print_r($return);

		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['job_id']=$post_id;
		$insertn['posted_by']=$userid;
		$insertn['action']=$OneSignalNoti['pushdata']['action'];
		$insertn['action_id']=$OneSignalNoti['pushdata']['action_id'];
		$insertn['action_json']=json_encode($OneSignalNoti['pushdata']);
		$run2 = $this->common_model->insert('notification',$insertn);

		if($run) {
			$json['status']=1;
		} else {
			$json['status']=0;
		}
		echo json_encode($json);
    return false;
	}	
	
	function get_unread_msg_count(){
		$userid=$this->session->userdata('user_id');
		$post_id=$this->input->post('post');
		$rid=$this->input->post('rid');
		$get_unread_msg=$this->common_model->get_unread_msg($userid,$post_id,$rid);
		if($get_unread_msg)
		{
				$json['count']=count($get_unread_msg);
				$json['status']=1;		
		}
		else
		{
			$json['status']=0;	
		}
		$json['q2'] = $this->db->last_query();
		echo json_encode($json);
	}

	public function get_inbox_unread_msg_count(){
		$userid=$this->input->post('bid_by');
		$post_id=$this->input->post('post');
		$rid=$this->input->post('rid');
		$get_unread_msg=$this->common_model->get_unread_msg($rid,$post_id,$userid);
		if($get_unread_msg)
		{
				$json['count']=count($get_unread_msg);
				$json['status']=1;		
		}
		else
		{
			$json['status']=0;	
		}
		$json['q2'] = $this->db->last_query();
		echo json_encode($json);
	}
	
	public function inbox() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$where = "where sender_id=".$this->session->userdata('user_id')."";	
			$data['users']=$this->common_model->get_job_users('tbl_jobpost_bids',$this->session->userdata('user_id'));
			$this->load->view('site/inbox',$data);
		}
	}

	public function get_chat_users_list(){
		$chat_list=$this->common_model->get_chat_list($this->session->userdata('user_id'));
		if($chat_list) {
			$json['data'] = '';
			foreach($chat_list as $row) { 
				$get_job_details=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$row['post_id']));
				$rid = ($row['sender_id']==$this->session->userdata('user_id'))?$row['receiver_id']:$row['sender_id'];
				$sender = $this->common_model->get_single_data('users',array('id'=>$rid)); 
				$unread=$this->common_model->get_unread_by_sid_rid($this->session->userdata('user_id'),$rid,$row['post_id']);
				if($sender['profile'])
		    {
		    	$u_profile=$sender['profile'];
		    }
		    else
		    {
		    	$u_profile="dummy_profile.jpg";
		    }

		    $serviceName = '';
				if($row['type'] == 'service'){
					$service = $this->common_model->GetSingleData('my_services',['id'=>$row['post_id']]);	
					if(!empty($service)){
						$totalChr = strlen($service['service_name']);
						if($totalChr > 22 ){
							$sname = substr($service['service_name'], 0, 21).'...';		
						}else{
							$sname = $service['service_name'];
						}
						$serviceUrl = base_url().'service/'.$service['slug'];
						$serviceName = '<span style="display:block; font-size:12px;"><a href="'.$serviceUrl.'" style="color:#fff; font-size:12px;">'.$sname.'</a></span>';	
					}							
				}

				$itemName = $row['type'] == 'service' ? $serviceName : $get_job_details['title'];

				$json['data'] .= '  <div class="chat_list"><div class="chat_people">
              <div class="chat_img">   <img src="'.site_url().'img/profile/'.$u_profile.'" alt=""></div>
                  <div class="chat_ib">
              <h5 id="vote_buttons"><b><p style="color: black" onclick="get_chat_onclick1('.$rid.','.$row['post_id'].');">'. $sender['f_name'].' '.$sender['l_name'].'</p></b> </h5>
                <p>'.$itemName.'</p>
              </div>
              ';
				if($unread[0]['total']>0) {
					$json['data'] .= '<span class="count_un_msg'.$row['post_id'].'">'.$unread[0]['total'].'</span>';
				}else{
					$json['data'] .= '<span class="count_un_msg'.$row['post_id'].'"></span>';
				}
				$json['data'] .= '</div></div>';
				$json['status'] = 1; 
			} 
		} else {
			$json['status'] = 0;
		}
		echo json_encode($json);
	}

  public function get_inbox_chat() {
    $get_users=$this->common_model->get_single_data('users',array('id'=>$_REQUEST['id']));
    $userid=$this->session->userdata('user_id');
    $get_chats=$this->common_model->get_all_chats($_REQUEST['id'],$userid,$_REQUEST['job_id']);

    if($get_users['profile']){
      $us_profile=$get_users['profile'];
    }else{
      $us_profile="dummy_profile.jpg";
    }
    $json['q2'] = $this->db->last_query();
    $json['data']='';
    if($get_chats){
      foreach ($get_chats as $row) {
        $get_time=$this->common_model->time_ago($row['create_time']); 
        $get_user_details=$this->common_model->get_single_data('users',array('id'=>$row['sender_id']));

        if($get_user_details['profile']){
          $u_profile=$get_user_details['profile'];
        }else{
          $u_profile="dummy_profile.jpg";
        }
        if($row['receiver_id']==$userid){
          $update_chat = $this->common_model->update('chat',array('id'=>$row['id']),array('is_read'=>1));
        }
        $json['data'].='';
        if($row['sender_id']==$userid){
          $json['data'].='<a href="#">
            <div class="outgoing_msg">
              <div class="outgoing_msg_img"> 
                <img src="'.site_url().'img/profile/'.$u_profile.'" alt="">
              </div>
              <div class="sent_msg">
                <p>'.$row['mgs'].'</p>
                <span class="time_date">'.$get_time.'</span>
              </div>
            </div>
          </a>';
        }else{
          $json['data'].='<a href="#">
            <div class="incoming_msg">
              <div class="incoming_msg_img"> 
                <img src="'.site_url().'img/profile/'.$u_profile.'" alt="">
              </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>'.$row['mgs'].'</p>
                  <span class="time_date">'.$get_time.'</span>
                </div>
              </div>
            </div>
          </a>';
        }
      }
    }else{
      $json['data'] .= '<div class="alert alert-warning">No messages found.</div>';
    }

    $json['status']=1;
    echo json_encode($json);
  }

	public function send_msg_inbox(){
		$post_id=$this->input->post('post_id');
		$userid=$this->session->userdata('user_id');
		$receiver=$this->input->post('rid');

		$words=$this->words;
		$msg=$this->input->post('ch_msg1');
		$msg1=strtolower($this->input->post('ch_msg1'));
		foreach ($words as $url) {
			if (strpos($msg1, $url) !== FALSE) { 
				$insert['post_id']=$post_id;
				$insert['sender_id']=$userid;
				$insert['receiver_id']=$receiver;
				$insert['mgs']='<i class="fa fa-ban" aria-hidden="true" style="color:red;"></i> This message has been deleted by admin.';
				$insert['is_read']=0;
				$insert['create_time']=date('Y-m-d H:i:s');
				$run = $this->common_model->insert('chat',$insert);
				$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
				$insertn['nt_userId']=$receiver;
		
				$insertn['nt_message']= $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
				
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$post_id;
				$insertn['posted_by']=$userid;
				$run2 = $this->common_model->insert('notification',$insertn);
				if($run) {
					$json['status']=1;
				} else {
					$json['status']=0;
				}
				echo json_encode($json);
				return true;

				$insert['post_id']=$post_id;
				$insert['sender_id']=$userid;
				$insert['receiver_id']=$receiver;
				$insert['mgs']=$msg;
				$insert['is_read']=0;
				$insert['create_time']=date('Y-m-d H:i:s');
				$run = $this->common_model->insert('chat',$insert);
				$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
				$insertn['nt_userId']=$receiver;
				
				$insertn['nt_message']= $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
				
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$post_id;
				$insertn['posted_by']=$userid;
				$run2 = $this->common_model->insert('notification',$insertn);
				if($run) {
					$json['status']=1;
				} else {
					$json['status']=0;
				}
				echo json_encode($json);
				return false;

			}
		}
		
		
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		
		$check_last = $this->common_model->GetColumnName('chat',array("post_id"=>$post_id,"receiver_id" =>$receiver),array('create_time'),null,'id');
		
		if($check_last==false){
			
			$link = site_url()."proposals?post_id=".$post_id.'&chat='.$userid;
			$respSL = file_get_contents('https://cutt.ly/api/api.php?key=69d958cf7b30dd3bef9485886a1d820bdcd57&short='.$link);
			$respSLJ = json_decode($respSL);
			$shortLink = $respSLJ->url->shortLink;
			
			$has_sms_noti = $this->common_model->check_sms_notification($receiver);
			
			if($has_sms_noti){
					
				$sms = $get_users['f_name']." is interested in your quote and would like to discuss it with you. Chat now \r\n".$shortLink." \r\n \r\n Tradespeoplehub.co.uk";
				
				$this->load->model('send_sms'); 
				//$this->send_sms->send_india($has_sms_noti['phone_no'],$sms);
				$this->send_sms->send($has_sms_noti['phone_no'],$sms);
				
				$this->common_model->update('user_plans',array('up_user'=>$receiver),array('used_sms_notification'=>$has_sms_noti['used_sms_notification']));
				
			} 
			
			$has_email_noti = $this->common_model->check_email_notification($receiver);
						
			if($has_email_noti){
				
				$subject = "New Messages from ".$get_users['f_name'];
				
				$html = '<p style="margin:0;padding:10px 0px">'.$msg.'</p><div style="text-align:center"><a href="'.$link.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div><br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
				
			$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html,null,$get_users['f_name'].' via Tradespeoplehub');
			}
		}
	
		$insert['post_id']=$post_id;
		$insert['sender_id']=$userid;
		$insert['receiver_id']=$receiver;
		$insert['mgs']=$this->input->post('ch_msg1');
		$insert['is_read']=0;
		$insert['create_time']=date('Y-m-d H:i:s');
		$run = $this->common_model->insert('chat',$insert);
		
		$insertn['nt_userId']=$receiver;
		
		$insertn['nt_message']= $get_users['f_name'].' '.$get_users['l_name'].' has sent you a message. <a href="'.site_url().'proposals/?post_id='.$post_id.'&chat='.$userid.'">View & Reply!</a>';
		
		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['job_id']=$post_id;
		$insertn['posted_by']=$userid;
		$run2 = $this->common_model->insert('notification',$insertn);
		
		if($run) {
			$json['status']=1;
		} else {
			$json['status']=0;
		}
		echo json_encode($json);
	}
	
	public function pay_chat() {
		$post_id=$_REQUEST['post'];
		$rid=$_REQUEST['id'];
			
		$get_commision=$this->common_model->get_single_data('admin',array('id'=>1));
			
		$credit_amount=$get_commision['credit_amount'];
			
		$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			
		$get_post_user=$this->common_model->get_single_data('users',array('id'=>$rid));
		$settings = $this->common_model->get_all_data('admin');

		if($settings[0]['payment_method'] == 1){
			
			if($get_users['u_wallet'] >= $credit_amount) {
					
				$update['u_wallet']=$get_users['u_wallet']-$credit_amount;
				$runs = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$update);

				$transactionid = md5(rand(1000,999).time());
				$tr_message='£'.$credit_amount.' has been debited to your wallet for responding to '.$get_post_user['f_name'].' '.$get_post_user['l_name'].' private job offer';
					
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
									 
				$insertn['nt_userId']=$this->session->userdata('user_id');
				$insertn['nt_message']='£'.$credit_amount.' has been debited to your wallet responding to '.$get_post_user['f_name'].' '.$get_post_user['l_name'].' private job offer';
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$post_id;
				$insertn['posted_by']=$rid;
				$run2 = $this->common_model->insert('notification',$insertn);

				$data1 = array(
					'user_id'=>$this->session->userdata('user_id'), 
					'post_id'=>$post_id,
					'posted_by'=>$rid
				);
				$run1 = $this->common_model->insert('chat_paid',$data1);
				
				if($runs) {
					$json['status']=1;
				}

			} else {
				$json['wallet']=$get_users['u_wallet'];
				$json['status']=2;
				$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
			}
		}else{
			$json['status']=1;
		}
		echo json_encode($json);
	}

  /*
  Function not required
  public function admin() {
    $where['receiver_id'] = $this->session->userdata('user_id');
    $adminChats = $this->common_model->newgetRows('admin_chats', $where);
    $pageData['chats'] = $adminChats;
    if(!empty($adminChats)){
      $whereChatDetails['admin_chat_id'] = $adminChats[0]['id'];
      $adminChatDetails = $this->common_model->newgetRows('admin_chat_details', $whereChatDetails);
      $pageData['adminChatDetails'] = $adminChatDetails;
    }

    $this->load->view('site/message_center_view', $pageData);
  }
  */

  public function support(){
    $this->check_login();

    $whereUnread['receiver_id'] = $this->session->userdata('user_id');
    $updateRead['is_read'] = 1;
    $this->common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['user_id'] = $this->session->userdata('user_id');
    $adminChats = $this->common_model->newgetRows('admin_chats', $where);
    $pageData['adminChats'] = $adminChats;
    $pageData['logged_in_user'] = $where['user_id'];
    $pageData['receiverData']['f_name'] = 'Support';
    $pageData['receiverData']['l_name'] = 'Team';
    $pageData['receiverData']['id'] = 0;
    $pageData['admin_chat_id'] = 0;

    $this->load->view('site/support_center_view', $pageData);
  }

  public function details(){
    $this->check_login();
    $this->session->unset_userdata('admin_chat_id');

    $whereUnread['receiver_id'] = $this->session->userdata('user_id');
    $updateRead['is_read'] = 1;
    $this->common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['user_id'] = $this->session->userdata('user_id');
    $adminChats = $this->common_model->newgetRows('admin_chats', $where);
    $pageData['logged_in_user'] = $where['user_id'];
    $pageData['receiverData']['f_name'] = 'Support';
    $pageData['receiverData']['l_name'] = 'Team';
    $pageData['receiverData']['id'] = 0;
    $pageData['admin_chat_id'] = 0;
    if(!empty($adminChats)){
      $whereChatDetails['admin_chat_id'] = $adminChats[0]['id'];
      $pageData['admin_chat_id'] = $whereChatDetails['admin_chat_id'];
      $pageData['chatDetails'] = $this->common_model->newgetRows('admin_chat_details', $whereChatDetails);
    }else{
      /* Admin not started chat yet. */
    }
    $this->session->set_userdata('admin_chat_id', $pageData['admin_chat_id']);

    $this->load->view('site/message_center_details_view', $pageData);
  }

  public function send_message(){
    $response['status'] = 0;
    $sender_id = $this->session->userdata('user_id');
    $admin_chat_id = $this->input->post('admin_chat_id');
    $insert['message'] = $this->input->post('message');
    $insert['receiver_id'] = $this->input->post('receiver_id');
    $insert['sender_id'] = $sender_id;
    $insert['is_read'] = 0;
    $insert['create_time'] = date("Y-m-d H:i:s");
    $insert['admin_chat_id'] = $admin_chat_id;
    $insert['is_admin'] = 0;
    if($admin_chat_id == 0){
      $insertAdminChat['user_id'] = $insert['sender_id'];
      $insertAdminChat['admin_id'] = $insert['receiver_id'];
      $insertAdminChat['ticket_id'] = uniqid();
      $insertAdminChat['created'] = date("Y-m-d H:i:s");
      $insert['admin_chat_id'] = $this->common_model->insert('admin_chats', $insertAdminChat);
      if($insert['admin_chat_id']){

        /* Notification */
        $insertNotification['nt_userId'] = $insert['sender_id'];
        $insertNotification['nt_message'] = 'You´ve created a new support ticket. <a href="'.site_url().'Support/details/' .$insert['admin_chat_id'] .'"> Click Here </a> to view the message.';
        $insertNotification['nt_satus'] = 0;
        $insertNotification['nt_apstatus'] = 0;
        $insertNotification['nt_create'] = date('Y-m-d H:i:s');
        $insertNotification['nt_update'] = date('Y-m-d H:i:s');
        $insertNotification['posted_by'] = $sender_id;
        $this->common_model->insert('notification', $insertNotification);
        /* Notification */

        if($this->common_model->insert('admin_chat_details', $insert)){
          $response['status'] = 1;
          $response['responseMessage'] = 'Message sent successfully.';
          $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissible">' .$response['responseMessage'] .'</div>');
        }
      }
    }else{
      $admin_chat_id = $this->common_model->insert('admin_chat_details', $insert);
      if($admin_chat_id){

        $response['status'] = 1;
        $response['responseMessage'] = 'Message sent successfully.';
        $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissible">' .$response['responseMessage'] .'</div>');
      }
    }
    $this->session->set_userdata('admin_chat_id', $insert['admin_chat_id']);
    $response['admin_chat_id'] = $insert['admin_chat_id'];

    // $this->send_chat_notification($to);

    echo json_encode($response);
  }

  private function send_chat_notification($to){
    $subject = '';
    $content = '';
    $content .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

    $this->common_model->send_mail($to, $subject, $content);
  }

  public function check_login() {
    if(!$this->session->userdata('user_logIn')){
      redirect('login');
    }
  }

  // public function refresh_messages_old(){
  //   $response['status'] = 0;
  //   $response['admin_chat_id'] = $this->session->userdata('admin_chat_id');
  //   $response['messages'] = '';
  //   $response['totalMessages'] = 0;
  //   $newContent = '';

  //   $messages = $this->common_model->get_all_data('admin_chat_details', array('admin_chat_id' => $response['admin_chat_id']));
  //   if(!empty($messages)){
  //     $response['totalMessages'] = count($messages);
  //     foreach($messages as $message){
  //       $profile = 'img/profile/';
  //       if($message['is_admin'] != 1){
  //         $profile .= ($message['profile']) ? $message['profile'] : 'dummy_profile.jpg';
  //       }else{
  //         $profile .= 'admin-img.png';
  //       }
  //       $content .= '<div class="dis-section" >
  //         <div class="row">
  //           <div class="col-sm-12">
  //             <div class="dis_div chan_dess">
  //               <div class="user-imge"> 
  //                 <img src="' .site_url($profile) .'">
  //               </div>
  //               <div class="panel panel-default panel-final">';
  //       if($message['is_admin'] == 1){
  //         $content .= '<div class="panel-heading">
  //             <b>Support Team:</b>
  //           </div>';
          
  //       }
  //       $content .= '<div class="panel-body">
  //                   <p class="text_uuu">
  //                     ' .$message['message'] .'
  //                   </p>
  //                 </div>
  //               </div>
  //             </div>
  //           </div>
  //         </div>
  //       </div>';
  //     /* New design */
  //     $messageTime = $this->common_model->time_ago($message['create_time']); 
  //     if($message['is_admin'] != 1){
  //         $newContent .='<a href="#">
  //           <div class="outgoing_msg">
  //             <div class="outgoing_msg_img"> 
  //               <img src="' .site_url($profile) .'" alt="">
  //             </div>
  //             <div class="sent_msg">
  //               <p>' .$message['message'] .'</p>
  //               <span class="time_date">'.$messageTime.'</span>
  //             </div>
  //           </div>
  //         </a>';
  //       }else{
  //         $newContent .='<a href="#">
  //           <div class="incoming_msg">
  //             <div class="incoming_msg_img"> 
  //               <img src="' .site_url($profile) .'" alt="">
  //             </div>
  //             <div class="received_msg">
  //               <div class="received_withd_msg">
  //                 <p>' .$message['message'] .'</p>
  //                 <span class="time_date">'.$messageTime.'</span>
  //               </div>
  //             </div>
  //           </div>
  //         </a>';
  //       }
  //     }
  //     $response['messages'] = $content;
  //     $response['newMessages'] = $newContent;
  //   }

  //   echo json_encode($response);
  // }


  public function refresh_messages(){
  	$user_id = $this->session->userdata('user_id');
    $response['status'] = 0;
    $response['admin_chat_id'] = $this->session->userdata('admin_chat_id');
    $response['messages'] = '';
    $response['totalMessages'] = 0;
    $newContent = '';
    $content = '';
    $messages = $this->common_model->get_all_data('admin_chat_details', array('admin_chat_id' => $response['admin_chat_id']));
	
		$sender_profile = $this->common_model->GetColumnName('users',array('id'=>$user_id),array('profile'));

		if(!empty($sender_profile['profile'])){
			$profile = base_url('img/profile/'.$sender_profile['profile']);
		}else{
				$profile = base_url('img/profile/dummy_profile.jpg');
		}
    if(!empty($messages)){
    	$response['totalMessages'] = count($messages);
    	$content = '<div class="dis-section" >';
    	foreach($messages as $message){ 
    		if($message['sender_id'] == $user_id){
		        $content .= '<div class="row">
		          <div class="col-sm-12">
		            <div class="dis_div chan_dess">
		              <div class="user-imge"> 
		                <img src="'.$profile.'">
		              </div>
		              <div class="panel panel-default panel-final">
		                <div class="panel-body"><p class="text_uuu">'.$message['message'].'</p>
		                </div>
		                <div class="panel-heading">
		                  <h3>'.date('d-M-Y h:i:s A',strtotime($message['create_time'])).'</h3>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>';

		    }else{
		    	$content.= '<div class="row">
		          <div class="col-sm-12">
		            <div class="dis_div chan_dess">
		              <div class="user-imge"> 
		                <img src="'.site_url('img/profile/admin-img.png').'">
		              </div>
		              <div class="panel panel-default panel-final">
		                <div class="panel-heading">
		                  <b>Support Team:</b>
		                </div>
		                <div class="panel-body">
		                  <p class="text_uuu">'.$message['message'].'</p>
		                </div>
		                <div class="panel-heading">
		                  <h3>'.date('d-M-Y h:i:s A',strtotime($message['create_time'])).'</h3>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>';
		    }
    	}
		$content.= '</div>';
	    $response['messages'] = $content;
    }
    echo json_encode($response);
  }

  public function makeDiv($row, $isTrades = 0, $get_time){
  	$serviceDiv = '';
  	$userid=$this->session->userdata('user_id');
  	if($row['type'] == 'service'){
			$order = $this->common_model->GetSingleData('service_order',['id'=>$row['offer_id']]);
			$service = $this->common_model->GetSingleData('my_services',['id'=>$order['service_id']]);

			if(!empty($order) && $order['status'] == 'offer_created' && $order['is_accepted'] == 0){
				$description = substr($order['description'], 0, 50);
				$serviceName = $service['service_name'];
				$price = '£'.number_format($order['price'],2);
				$oIds = str_replace(' ','', substr($order['order_id'],1));
				$route1 = site_url().'order-tracking/'.$order['id'];
				$route2 = site_url().'serviceCheckout?offer='.$oIds;

				$btn = '<a href="javascript:void(0)" data-url="'.$route2.'" class="btn btn-warning accept-offer-chat-btn" onclick="acceptCustomOffer(this)">Accept Offer</a>';

				if($isTrades == 1){
					$btn = '<a href="javascript:void(0)" data-oid="'.$order['id'].'" class="btn btn-warning accept-offer-chat-btn" onclick="withdrawCustomOffer(this)">Withdraw Offer</a>';
				}

				$attributesArray = [];
				if(!empty($order['offer_includes_ids'])){
					$attributes = json_decode($order['offer_includes_ids'], true);
					foreach ($attributes as $key => $value) {
						if(!empty($value)){
							foreach($value as $v){
								$attributesArray[] = $v;
							}
						}
					}
				}

				$cls1 = 'message-order-box';
				$cls2 = '';

				if($isTrades == 1){
					$cls1 = 'message-order-box2';
					$cls2 = 'text-left';
				}

				$attributesArray = array_unique($attributesArray);
				
				$selectedAttr = '';
				if(!empty($attributesArray) && count($attributesArray) > 0){
					$attributesList = $this->common_model->getAttributes($attributesArray);
					foreach($attributesList as $list){
						$selectedAttr .= '<span class="custom-attributes"><i class="fa fa-check"></i> '.$list['attribute_name'].'</span>';
					}
				}
				
				$serviceDiv = '<div class="'.$cls1.'">
												<div class="message-order-description">
												<span class="name">'.$serviceName.'</span>
												<span class="price pull-right">'.$price.'</span>
											</div>
											<!--<div class="description">'.$description.'</div>-->
											<div class="your-offer '.$cls2.'">Your Offer Includes</div>
											<div class="delivery-rights">
												<span class="custom-attributes"><i class="fa fa-clock-o"></i> '.$order['delivery'].' Days Delivery</span>
											</div>
											<div class="delivery-attributes '.$cls2.'">
												'.$selectedAttr.'
											</div>
											<div class="offer-btn">
												<a href="'.$route1.'">View Offer</a>
												'.$btn.'												
											</div>
											<div class="offer-time">
												<span class="time">'.$get_time.'</span>
											</div>
											</div>';	
			}								
		}
		return $serviceDiv;
  }
}
