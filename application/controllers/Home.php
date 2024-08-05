<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->helper('cookie');
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020','0','1','2','3','4','5','6','7','8','9','@','www','http://','https://','.com','.uk','.co.uk','.gov.uk','.me.uk','.ac.uk','.org.uk','.Itd.uk','.mod.uk ','.mil.uk','.net.uk','.nic.uk','.nhs.uk','.pic.uk','.sch.uk','.pic.uk:','.info','.io','.cloud','.online','.ai','.net','.org');
		error_reporting(0);
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
	
	public function testing(){
		echo GetUserUniqueId();
		
		/*$data = $this->common_model->GetAllData('users',false,'id','asc');
		echo '<pre>';
		print_r($data);
	

		$unique_id = 100000;
		// echo '<pre>';
		foreach($data as $row){
			print_r($row);
			$unique_id++;
			$update = [];
			$update['unique_id'] = $unique_id;
			
			$this->common_model->update_data('users',['id'=>$row['id']],$update);
		}*/
	}
    
  public function index(){
  	$pageData = [];
    $pageData['customer_rev'] = $this->common_model->get_customer_reviews();
    $pageData['all_services']=$this->common_model->get_all_service('my_services',8);
    $pageData['all_categoty']=$this->common_model->get_parent_category('service_category',0,1);

    $this->load->view('site/index', $pageData);
  }
	
	public function check_email_verified(){
		
		$id = $this->session->userdata('user_id');
		$check = $this->common_model->GetColumnName('users',array('id'=>$id),array('u_email_verify'));
		
		if($check && $check['u_email_verify']==1){
			$json['status'] = 1;
		} else {
			$json['status'] = 0;
		}
		
		echo json_encode($json);
	}

	public function fund_request_form($user_id=null,$id=null,$token=null) {
		
		$page['status'] = 0;
		
		$data = $this->common_model->get_single_data('homeowner_fund_withdrawal',array('id'=>$id,'token'=>$token));
		
		if($data){
			$page['status'] = 1;
			$page['data'] = $data;
			$page['isExist'] = $isExist;
		} else {
			$page['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
		}
		
    $this->load->view('site/fund_request_form',$page);
  }
	
	public function submit_fund_request_form() {
		
		$this->form_validation->set_rules('id','id','trim|required');
		
		$id = $this->input->post('id');
		
		$checking = true;
		
		$check = $this->common_model->GetColumnName('homeowner_fund_withdrawal', array('id' => $id),array('pay_method','user_id'));
		
		if($check['pay_method']=='Bank Transfer'){
		
			$this->form_validation->set_rules('account_holder_name','account holder name','trim|required');
			$this->form_validation->set_rules('bank_name','bank name','trim|required');
			$this->form_validation->set_rules('account_number','account number','trim|required');
			$this->form_validation->set_rules('short_code','sort code','trim|required');
			
		} else if($check['pay_method']=='Paypal'){
			$this->form_validation->set_rules('paypal_id','paypal id','trim|required|valid_email');
		} else {
			$this->form_validation->set_rules('name','name','trim|required');
			$this->form_validation->set_rules('card_number','card number','trim|required');
			//$this->form_validation->set_rules('card_exp_month','card expiry month','trim|required');
			//$this->form_validation->set_rules('card_exp_year','card expiry year','trim|required');
			//$this->form_validation->set_rules('card_cvc','cvc/cvv','trim|required');
			$this->form_validation->set_rules('postcode','postcode','trim|required');
			$this->form_validation->set_rules('address','address','trim|required');
		}
		
		
		if($this->form_validation->run()){
			
			if($check['pay_method']=='Bank Transfer'){
			$insert['account_holder_name'] = $this->input->post('account_holder_name');
			$insert['bank_name'] = $this->input->post('bank_name');
			$insert['account_number'] = $this->input->post('account_number');
			$insert['short_code'] = $this->input->post('short_code');
			
			} else if($check['pay_method']=='Paypal'){
				$data['paypal_id'] = $this->input->post('paypal_id');
				$data['updated_at'] = date("Y-m-d H:i:s");
				
				$isExist = $this->common_model->get_single_data('billing_details', array('user_id' => $check['user_id']));
				
				if($isExist){
				$run = $this->common_model->update('billing_details',array('id' => $isExist['id']), $data);
				}else{
					$data['user_id'] = $check['user_id'];
					$data['created_at'] = date("Y-m-d H:i:s");
					$run = $this->common_model->insert('billing_details', $data);
				}
				
			} else {
				
				$postal_code = $this->input->post('postcode');
				//$postal_code = str_replace(" ","",$postal_code);
				$check_postcode = $this->common_model->check_postalcode($postal_code);
				if($check_postcode['status']==1){
				
					$data['name'] = $this->input->post('name');
					$data['card_number'] = $this->input->post('card_number');
					//$data['card_exp_month'] = $this->input->post('card_exp_month');
					//$data['card_exp_year'] = $this->input->post('card_exp_year');
					//$data['card_cvc'] = $this->input->post('card_cvc');
					$data['postcode'] = $this->input->post('postcode');
					$data['address'] = $this->input->post('address');
					$data['updated_at'] = date("Y-m-d H:i:s");

					$isExist = $this->common_model->get_single_data('billing_details', array('user_id' => $check['user_id']));
					
					if($isExist){
						$run = $this->common_model->update('billing_details',array('id' => $isExist['id']), $data);
					}else{
						$data['user_id'] = $check['user_id'];
						$data['created_at'] = date("Y-m-d H:i:s");
						$run = $this->common_model->insert('billing_details', $data);
					}
				} else {
					$checking = false;
					$json['status'] = 0;
					$json['msg'] = '<p class="alert alert-danger">Please enter valid UK postcode</p>';
				}
			}
			if($checking){
				$insert['is_admin_read'] = 0;
				$insert['status'] = 3;
				
				$insert['update_date'] = date('Y-m-d H:i:s');
				
				$run = $this->common_model->update_data('homeowner_fund_withdrawal',array('id'=>$id),$insert);
				if($run){
					$json['status'] = 1;
					$this->session->set_flashdata('msg','<div class="alert alert-success">Request has been sent successfully.</div>');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
			}
			
		
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}
		echo json_encode($json);
		
  }
	
	public function about(){
		$this->load->view('site/about');
	}
	public function view_affiliate(){
		$data['affilateMeata'] = $this->common_model->get_single_data('other_content',array('id'=>5));
		$this->load->view('site/view_affiliate', $data);
	}
	public function invoice(){
		$this->load->view('site/invoice');
	}
	
	public function proposals(){
		$this->load->view('site/proposals');
	}
	
	public function find_tradesmen(){
		
		$this->load->view('site/find-tradesmen' , $data);
	}
	
	public function check_postcode(){
		
		$post_code = $this->input->post('post_code');
			
		$post_code = str_replace(" ","",$post_code);
		
		$check_postcode = $this->common_model->check_postalcode($post_code);
		
		if($check_postcode['status']==1){
			$json['status'] = 1;
			$json['longitude'] = $check_postcode['longitude'];
			$json['latitude'] = $check_postcode['latitude'];
		} else {
			$json['status'] = 0;
		}
		
		echo json_encode($json);
	}
	
	public function advice_centre(){
		$this->load->view('site/advice-centre');
	}
	
	public function tradesman_start(){
		$this->load->view('site/tradesman-start');
	}
	
	public function project_detail(){
		$this->load->view('site/project-detail');
	}

  public function login(){
  	if($this->session->userdata('user_id')){
			if($this->session->userdata('type')==3){
				redirect('affiliate-dashboard');
			} else {
				redirect('dashboard');
			}
      
    }else{
      $this->load->view('site/login');
    }
  }
	public function affiliate_login(){
    if($this->session->userdata('user_id')){
			if($this->session->userdata('type')==3){
				redirect('affiliate-dashboard');
			} else {
				redirect('dashboard');
			}
      
    }else{
    	$data['affilateMeataLogin'] = $this->common_model->get_single_data('other_content',array('id'=>5));
      $this->load->view('site/affiliate-login', $data);
    }
  }
	

	public function find_jobs(){
		$data['all_jobs']=$this->common_model->get_all_job_posts('tbl_jobs');
		$this->load->view('site/search_post',$data);
	}
	
	public function logout(){
		$this->session->sess_destroy();
		//echo 'sfsd';
		delete_cookie('type');
		delete_cookie('user_id');
		delete_cookie('email');
		delete_cookie('u_name');
		delete_cookie('unique_id');
		redirect('login');
	}

  public function signup_step1(){
    if($this->session->userdata('user_id')){
      redirect('dashboard');
    }else{
	 		$result['country']=$this->common_model->newgetRows('tbl_region',array('is_delete'=>0));
	 		$result['settings'] = $this->common_model->get_all_data('admin');
	 		$protocol = $this->input->server('REQUEST_SCHEME');
			$host = $this->input->server('HTTP_HOST');
			$uri = $this->input->server('REQUEST_URI');

			$fullUrl = $protocol . '://' . $host . $uri;

			$this->session->set_userdata('referred_link',$fullUrl);
      $this->load->view('site/signup-step1',$result);
    }
  }

	public function get_city(){
		$data_set=$this->common_model->newgetRows('tbl_city',array('county_id'=>$_REQUEST['val']));
		if($data_set)
		{
				$json['cities'] = '<option value="">Select City</option>';
		foreach($data_set as $city){
		$json['cities'] .= '<option value="'.$city['id'].'">'.$city['city_name'].'</option>';
		}

		}
		else
		{
			$json['cities'] .= '<option value="">No city found</option>';
		}
	
		echo json_encode($json);
	}

  public function get_subcategories(){
    $data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$_REQUEST['val'],'is_delete'=>0));
		
		$cate_data = $this->common_model->get_single_data('category',array('cat_id'=>$_REQUEST['val']));
		
		$json['label']='What type of '.$cate_data['cat_name'].' work do you need?';
		if ($cate_data['cat_ques'] != '') {
			$json['label']=$cate_data['cat_ques'];
		}
		// $json['label']='What type of '.$cate_data['cat_name'].' work do you need?';
		
		
    if($data_set){
      $json['status']=1;
      $json['subcategory']='<div class="row">';
      foreach($data_set as $subcategory){
				
        $json['subcategory'] .= '<div class="col-sm-6"><div class="radio-how"><label><input type="radio" name="subcategory" onchange="return changesub($(this).val())" id="subcategory'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'">'.$subcategory['cat_name'].'<span class="outside"><span class="inside"></span></span></label></div></div>';
      }
      $json['subcategory'].='</div>';
    }
    else{
			$json['status']=0;
      $json['subcategory'] .= '<p class="alert alert-danger">No subcategories found for this category.</p>';
    }

    echo json_encode($json);
}

	public function get_subcategories_sub2(){
    $data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$_REQUEST['val'],'is_delete'=>0));
		
		$cate_data = $this->common_model->get_single_data('category',array('cat_id'=>$_REQUEST['val']));
		
		$json['label']='What type of '.$cate_data['cat_name'].' work do you need?';
		if ($cate_data['cat_ques'] != '') {
			$json['label']=$cate_data['cat_ques'];
		}
    if($data_set){
			$json['status']=1;
      $json['subcategory']='<div class="row">';
      foreach($data_set as $subcategory){
        $json['subcategory'] .= '<div class="col-sm-6"><div class="radio-how"><label><input type="radio" name="subcategory_2" onchange="return changesub_sub($(this).val())" id="subcategory_sub'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'">'.$subcategory['cat_name'].'<span class="outside"><span class="inside"></span></span></label></div></div>';
      }
      $json['subcategory'].='</div>';
    }
    else{
			$json['status']=0;
      $json['subcategory'] .= '<p class="alert alert-danger">No subcategories found for this category.</p>';
    }

    echo json_encode($json);
}

	public function get_subcategories_sub3(){
    $data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$_REQUEST['val'],'is_delete'=>0));
		
		$cate_data = $this->common_model->get_single_data('category',array('cat_id'=>$_REQUEST['val']));
		
		$json['label']='What type of '.$cate_data['cat_name'].' work do you need?';
		if ($cate_data['cat_ques'] != '') {
			$json['label']=$cate_data['cat_ques'];
		}
    if($data_set){
			$json['status']=1;
      $json['subcategory']='<div class="row">';
      foreach($data_set as $subcategory){

        $json['subcategory'] .= '<div class="col-sm-6"><div class="radio-how"><label><input type="radio" name="subcategory_3" onchange="return changesub_sub_sub($(this).val())" id="subcategory_sub_sub'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'">'.$subcategory['cat_name'].'<span class="outside"><span class="inside"></span></span></label></div></div>';
      }
      $json['subcategory'].='</div>';
    }
    else{
			$json['status']=0;
      $json['subcategory'] .= '<p class="alert alert-danger">No subcategories found for this category.</p>';
    }

    echo json_encode($json);
}

	public function get_subcategory() {
		$data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$_REQUEST['val'],'is_delete'=>0));
		if($data_set) {
			$json['subcategory']=' <label for="email"> Sub Category:</label><div class="row">';
			foreach($data_set as $subcategory){
				$json['subcategory'] .= '<div class="col-sm-6"><input type="radio" name="subcategory" id="subcategory'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'">'.$subcategory['cat_name'].'</div>';
			}
			$json['subcategory'].='</div>';
		} else {
			$json['subcategory'] .= '<p class="alert alert-danger">No subcategories found for this category.</p>';
		}
	
		echo json_encode($json);
	}  
	
	public function how_it_work(){
		$this->load->view('site/how-it-works');

	}
	
	public function how_it_work_tradesmen(){
		$this->load->view('site/how_it_work_tradesmen');

	}
	
	public function faq(){
		$this->load->view('site/FAQ');
	}
	
	public function tradesman_support(){
		$this->load->view('site/tradesman-support');
	}
	
	public function tradesman_help(){
		$data['setting']=$this->common_model->get_all_data('admin');
		$this->load->view('site/tradesman-help', $data);
	}
	
	public function testimonial(){
		$this->load->view('site/testimonial');
	}

	public function affiliate(){
		$this->load->view('site/affiliate');
	}
	
	public function contact(){
		$this->load->view('site/contact');
	}
	
	public function blog(){
		$data['home']=$this->common_model->get_single_data('home_content',array('id'=>1));
		$data['blogs']=$this->common_model->newgetRows('tbl_blogs','','b_id');
		$this->load->view('site/blog',$data);
	}

  public function blog_detail($id=null){
    $data['blogDetail']=$this->common_model->get_single_data('tbl_blogs',array('slug'=>$id));
		
		if($id && $data['blogDetail']){
			
			$data['related'] = $this->common_model->get_all_data('tbl_blogs',null,'b_id','desc',5);
			
			$this->load->view('site/blog_detail',$data);
		} else {
			redirect('blog');
		}
  }

	public function homeowner_support(){
		$this->load->view('site/homeowner-support');
	}
	
	public function homeowner_help_centre(){
		$this->load->view('site/homeowner-help-centre');
	}
	
	public function live_leads(){
		$this->load->view('site/live-leads');
	}
	
	public function advice_guides(){
		$this->load->view('site/advice-guides');
	}
	
	public function hiring_advice(){
		$this->load->view('site/hiring-advice');
	}

	public function private_policy(){
		$this->load->view('site/private-policy');
	}
	
	public function privacy_policy(){
		$this->load->view('site/privacy-policy');
	}
	
	public function cookie_policy(){
		$this->load->view('site/cookie_policy');
	}
	
	public function terms_and_conditions(){
			$this->load->view('site/terms_and_conditions');
	}

	public function categories(){
		$page['all_category']=$this->common_model->get_all_data('category','');
		$this->load->view('site/category',$page);
	}

  public function category_detail($cat_name=null,$cate_id=null){

    // FIND_IN_SET
    $page['all_category']=$this->common_model->get_all_data('category','');

    $where = "where type = 1  and u_email_verify = 1";
    $keyword=$_REQUEST['search'];
		
		
    if(isset($_REQUEST['amount1']) && !empty($_REQUEST['amount1'])){
      $where .= " and hourly_rate >= '".$_REQUEST['amount1']."'";
    }
    if(isset($_REQUEST['amount2']) && !empty($_REQUEST['amount2'])){
      $where .= " and hourly_rate <= '".$_REQUEST['amount2']."'";
    }
    
    if(isset($_REQUEST['rating']) && !empty($_REQUEST['rating'])){
      $where .= " and average_rate >= '".$_REQUEST['rating']."'";
			
    }

    /*if(isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])){
      $where .= " and FIND_IN_SET(".$_REQUEST['category_id'].", category)";
    }*/

    if(isset($cate_id) && !empty($cate_id)){
      $where .= " and FIND_IN_SET(".$cate_id.", category)";
    }
    if(isset($_REQUEST['location']) && !empty($_REQUEST['location'])){
      $where .= " and (users.e_address like '%".$_REQUEST['location']."%' || users.county like '%".$_REQUEST['location']."%' || users.city like '%".$_REQUEST['location']."%' || users.postal_code like '%".$_REQUEST['location']."%')";
			
    }

    if($this->session->userdata('user_id')){
      $user = $this->common_model->get_coloum_value('users',array('id'=>$this->session->userdata('user_id')),array('postal_code'));
      //$postal_code = str_replace(" ","",$user['postal_code']);
      $where .= " and postal_code = '".$user['postal_code']."'";
    }

    if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])){
      $where .= " and ((select cat_name from category where category.cat_id in (users.category)) like '%".$_REQUEST['search']."%' || (select region_name from tbl_region where tbl_region.id = users.county) like '%".$_REQUEST['search']."%' || (select city_name from tbl_city where tbl_city.id = users.city) like '%".$_REQUEST['search']."%' || f_name  like '%".$_REQUEST['search']."%' || l_name  like '%".$_REQUEST['search']."%' || about_business  like '%".$_REQUEST['search']."%' || postal_code  like '%".$_REQUEST['search']."%' || profile_summary  like '%".$_REQUEST['search']."%' || professional_head  like '%".$_REQUEST['search']."%' || company  like '%".$_REQUEST['search']."%' || e_address  like '%".$_REQUEST['search']."%')";
			
		
    }
		
		
   
		$sql = "select * from users ".$where." order by id desc";
		
    $query=$this->db->query($sql);
    $page['get_users_cat']=$query->result_array();

    $page['category_details']=$this->common_model->get_single_data('category',array('cat_id'=>$cate_id),'cat_id');
    $this->load->view('site/category_details',$page);
  }

  public function signup_step2($id=null) {
    if($this->session->userdata('user_id')){
      redirect('dashboard');
    }else{
      $data['category']=$this->common_model->newgetRows('category',array('is_delete'=>0,'cat_parent'=>0),'cat_id',true);
      $this->load->view('site/signup-step2',$data);
    }
  }

  public function signup_step3($id=null) {
    if($this->session->userdata('signup_step2')) {
      $this->load->view('site/signup-step3');
    } else {
      redirect('dashboard');
    }
  }

  public function signup_step4($id=null) {
    if($this->session->userdata('signup_step2')) {
    	if($this->session->userdata('signup_step1')){
				$signup_step1 = $this->session->userdata('signup_step1');
				$signup_step2 = $this->session->userdata('signup_step2');
				$insert = array_merge($signup_step1, $signup_step2);
				$existUser = $this->common_model->get_single_data('users', array('email' => $insert['email']));

				if(empty($existUser)){
					$insert['u_token'] = md5(rand(1000,9999).time());
					$insert['cdate']=date('Y-m-d H:i:s');
					$insert['unique_id']=time();
					$setting = $this->common_model->get_single_data('admin',array('id'=>1));
					$insert['free_trial_taken'] = $setting['payment_method'] == 0 ? 1 : 0;
					
					$referred_by = false;

					if($this->session->userdata('referred_by'))
					{
						$referred_by = $this->session->userdata('referred_by');
						$insert['referral_code'] = $referred_by;
					}
					
					$run = $this->common_model->insert('users', $insert);
					
					if($referred_by){					
						$referred_link = $this->session->userdata('referred_link');
						$users = $this->db->where('unique_id', $referred_by)->get('users')->row();
						$referal_data = array(
							'user_id'=> $run,
							'user_type'=> 1,
							'referred_by'=> $users->id,
							'referred_type'=> $users->type,
							'referred_link'=> $referred_link
						);
						$this->db->insert('referrals_earn_list',$referal_data); 
					} 

					$this->session->set_userdata('type', $insert['type']);
					$this->session->set_userdata('email', $insert['email']);
					$this->session->set_userdata('u_name', $insert['trading_name']);
					$this->session->set_userdata('user_logIn', true);
					$this->session->set_userdata('user_id', $run);

					$this->session->unset_userdata('signup_step1');
					$this->session->unset_userdata('referred_by');
					$this->session->unset_userdata('referred_link');
				}
			}
      $this->load->view('site/signup-step4');
    } else {
      redirect('dashboard');
    }
  }

  public function signup_step5($id=null) {
    if($this->session->userdata('signup_step4')) {
      $this->load->view('site/signup-step5');
    } else {
      redirect('dashboard');
    }
  }
 
	public function signup_step6($id=null) {
		if($this->session->userdata('user_id')) {
			$this->load->view('site/signup-step6');
		} else {
			redirect('dashboard');
		}	
	}

  public function signup_step7($id=null) {
  	
		
    if($this->session->userdata('user_id')) {
      $user_id = $this->session->userdata('user_id');
			
      $user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
			
      if($user_data && $user_data['is_phone_verified'] != 1){
				
				$code = rand(1000,9999);
				
				$msg = "Your verification code is: ".$code." \r\n Tradespeoplehub.co.uk";
				
				$this->common_model->update("users",array('id'=>$user_data['id']),array('phone_code'=>$code));
				
		
				
				$this->load->model('send_sms');
		
				$this->send_sms->send($user_data['phone_no'],$msg);
				
        $this->load->view('site/signup-step7');
      }else{
        redirect('dashboard');
      }
    } else {
      redirect('dashboard');
    }
  }
	
  public function signup_step8($id=null) {
    if($this->session->userdata('user_id')) {
    	$setting=$this->common_model->get_all_data('admin');
			if($setting[0]['payment_method'] == 0){
				redirect('dashboard');
			}

      require_once('application/libraries/stripe-php-7.49.0/init.php');
			$secret_key = $this->config->item('stripe_secret');
			$email = $this->session->userdata('email');			
			\Stripe\Stripe::setApiKey($secret_key);			
			
			$customer = \Stripe\Customer::create(['email' => $email]);
			
			$intent = \Stripe\SetupIntent::create([
				'customer' => $customer->id
			]);
			
			$pagedata['intent'] = $intent;
			$pagedata['customerID'] = $customer->id;
			
			
      $this->load->view('site/signup-step8',$pagedata);
    } else {
      redirect('dashboard');
    }
  }

  public function signup_step9($id=null) {
    if($this->session->userdata('user_id')) {
      $this->load->view('site/signup-step9');
    } else {
      redirect('dashboard');
    }
  }

	public function submit_signup(){
		
		// Include library file
		/*require_once('application/libraries/VerifyEmail.php'); 
		$VerifyEmail = new VerifyEmail();
		$VerifyEmail->setStreamTimeoutWait(20);
		//$VerifyEmail->Debug= TRUE; 
		$VerifyEmail->Debugoutput= 'html'; 
		$VerifyEmail->setEmailFrom(EMAIL_ID);*/
		
		$email = $this->input->post('email'); 
		
		/*$check_email = true;
		
		require_once('application/libraries/EmailVerify.class.php'); 
		
		$verify = new EmailVerify();
		
		if($verify->verify_formatting($email)){
			$check_email = false;
		}
		
		if($verify->verify_domain($email)){
			$check_email = false;
		}*/
		
		if(1==1){ 
		//if($VerifyEmail->check($email)){ 
		//if($check_email){ 
		
			$this->form_validation->set_rules('f_name','First Name','required');
			$this->form_validation->set_rules('l_name','Last Name','required');
			$this->form_validation->set_rules('trading_name','Trading Name','required');
			$this->form_validation->set_rules('postal_code','Postcode','required');
			$this->form_validation->set_rules('locality','City','required');
			$this->form_validation->set_rules('e_address','Address','required');
			// $this->form_validation->set_rules('country','country','required');
		
			$this->form_validation->set_rules('distance','distance','required');
			$this->form_validation->set_rules('phone_no','Phone number','required|integer|is_unique[users.phone_no]',array('is_unique'=>'This phone number is already registered'));
			$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]',array('is_unique'=>'This email is already registered'));
			$this->form_validation->set_rules('password','Password','required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');


			if ($this->form_validation->run()==false) {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			}else{
				$postal_code = $this->input->post('postal_code');
				$postal_code = str_replace(" ","",$postal_code);
				$check_postcode = $this->common_model->check_postalcode($postal_code);
				if($check_postcode['status']==1){
					$insert['type'] = $this->input->post('type');
					$insert['f_name'] = $this->input->post('f_name');
					$insert['l_name'] = $this->input->post('l_name');
					$insert['trading_name'] = $this->input->post('trading_name');
					$insert['postal_code'] = $this->input->post('postal_code');
					$insert['latitude'] = $this->input->post('latitude');
					$insert['longitude'] = $this->input->post('longitude');
					$insert['city'] = $this->input->post('locality');
					$insert['e_address'] = $this->input->post('e_address');
//					$insert['county'] = $this->input->post('country');
					$insert['max_distance'] = $this->input->post('distance');
					$insert['phone_no'] = $this->input->post('phone_no');
					$insert['email'] = $this->input->post('email');
					$insert['password']=$this->input->post('password');
					$insert['unique_id']=GetUserUniqueId();
					$insert['unique_id1']=time();
					$this->session->set_userdata('referred_type',1);
					$referred_by = false;
					if(isset($_POST['referred_by']) && !empty($this->input->post('referred_by' )))
					{
						$check = $this->common_model->GetSingleData('users',['unique_id'=>$_POST['referred_by']]);
						if($check)
						{
							$referred_by = $this->input->post('referred_by');
							$this->session->set_userdata('referred_by',$referred_by);
						} else {
							$json['status'] = 10;
							echo json_encode($json);
							exit; 
						}
						
					}
					$this->session->set_userdata('signup_step1',$insert);					
					$json['status'] = 1;
				} else {
					$json['status'] = 2;
				}
			}
		}else{ 
			$json['status'] = 3; 
		} 
		echo json_encode($json);
	}

	public function submit_homeowner_signup(){
		$this->form_validation->set_rules('f_name','First Name','required');
		$this->form_validation->set_rules('l_name','Last Name','required');
		$this->form_validation->set_rules('postal_code','Postcode','required');
		//$this->form_validation->set_rules('locality','City','required');
		//$this->form_validation->set_rules('e_address','Address','required');
		//$this->form_validation->set_rules('country','country','required');
	
		$this->form_validation->set_rules('phone_no','Phone number','required|integer|is_unique[users.phone_no]',array('is_unique'=>'This phone number is already registered'));
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]',array('is_unique'=>'This email is already registered'));
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		
		if ($this->form_validation->run()==false) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
			$postal_code = $this->input->post('postal_code');
			$postal_code = str_replace(" ","",$postal_code);
			$check_postcode = $this->common_model->check_postalcode($postal_code);
			if($check_postcode['status']==1){
				
				$post_code1 = $this->input->post('postal_code');
				$check_postcode = $this->common_model->check_postalcode($post_code1);

				// if($check_postcode['status']==1)
				 // {		
				$longitude = $check_postcode['longitude'];
				$latitude  = $check_postcode['latitude'];
				$primary_care_trust  = $check_postcode['primary_care_trust'];
				$address  = $check_postcode['address'];
				$country  = $check_postcode['country'];
				
				$insert['type'] = 2;
				$insert['f_name'] = $this->input->post('f_name');
				$insert['l_name'] = $this->input->post('l_name');
				$insert['postal_code'] = $this->input->post('postal_code');
				$insert['latitude'] = $this->input->post('latitude');
				$insert['longitude'] = $this->input->post('longitude');
				$insert['city'] = $primary_care_trust;
				$insert['county'] = $country;
				//$insert['e_address'] = $this->input->post('e_address');
				//$insert['county'] = $this->input->post('country');
				$insert['phone_no'] = $this->input->post('phone_no');
				$insert['email'] = $this->input->post('email');
				$insert['password']=$this->input->post('password');				
				$insert['u_token'] = md5(rand(1000,9999).time());
				$insert['cdate']=date('Y-m-d H:i:s');
				$insert['unique_id']=GetUserUniqueId();
				$insert['unique_id1']=time();	

				$referred_by = false;
				if(isset($_POST['referred_by']) && !empty($this->input->post('referred_by' )))
				{
					$check = $this->common_model->GetSingleData('users',['unique_id'=>$_POST['referred_by']]);
					if($check)
					{
						$referred_by = $this->input->post('referred_by');
					} else {
						$json['status'] = 10;
						echo json_encode($json);
						exit; 
					}
					
				} else {
					$referred_by = $this->session->userdata('referred_by');
					$insert['referral_code'] = $referred_by;
				}			
				
				$run = $this->common_model->insert('users', $insert);

				if($run){
					
					// $referred_type = $this->input->post('referred_type');
					if($referred_by){
						
						$referred_link = $this->session->userdata('referred_link');

						$users = $this->db->where('unique_id', $referred_by)->get('users')->row();
						$referal_data = array(
							'user_id'=> $run,
							'user_type'=> 2,
							'referred_by'=> $users->id,
							'referred_type'=> $users->type,
							'referred_link'=> $referred_link
						);
						$this->db->insert('referrals_earn_list',$referal_data);
					}
					
					$time = time();
					$degit = substr($time,-5);
					$json['status'] = 1;
					
					$this->session->set_userdata('type', $insert['type']);
					$this->session->set_userdata('email', $insert['email']);
					$this->session->set_userdata('user_logIn', true);
					$this->session->set_userdata('user_id', $run);
					$this->session->set_userdata('homeowner_signup', true);
					$this->session->set_userdata('unique_id', $insert['unique_id']);

					$this->input->set_cookie('type',$insert['type'],43200*60);
					$this->input->set_cookie('user_id',$run,43200*60);
					$this->input->set_cookie('email',$insert['email'],43200*60);
					$this->input->set_cookie('unique_id',$insert['unique_id'],43200*60);
					$get_name = $insert['f_name'].''.$insert['l_name'];
					$this->input->set_cookie('u_name',$get_name,43200*60);
					/* Send email */
          // $subject = "Verify your Email Address - Tradespeoplehub.co.uk";
					// $this->send_verification_email($insert['email'], $subject, false, $insert['u_token']);
          $subject = "Thank you for Signing up to Tradespeoplehub.co.uk.";
					$this->send_how_it_works_email($insert['email'], $insert['f_name'], $subject);

				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
			} else {
				$json['status'] = 2;
			}
		}
 
		echo json_encode($json); 
	}	
	public function submit_affiliater_signup(){
		$this->form_validation->set_rules('f_name','First Name','required');
		$this->form_validation->set_rules('l_name','Last Name','required');
		// $this->form_validation->set_rules('postal_code','Postcode','required');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]',array('is_unique'=>'This email is already registered'));

		$this->form_validation->set_rules('e_address','Address','required');
		$this->form_validation->set_rules('country','Country','required');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('confirm_password','Password','required|min_length[6]');
		$this->form_validation->set_rules('traffic_source','Traffic source','required|min_length[6]');

		if ($this->form_validation->run()==false) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			if($confirm_password == $password){
						$insert['type'] = 3;
						$insert['f_name'] = $this->input->post('f_name');
						$insert['l_name'] = $this->input->post('l_name');
						// $insert['postal_code'] = $this->input->post('postal_code');
						// $insert['latitude'] = $this->input->post('latitude');
						// $insert['longitude'] = $this->input->post('longitude');
						// $insert['city'] = $this->input->post('city');
						$insert['e_address'] = $this->input->post('e_address');
						$insert['county'] = $this->input->post('country');
						// $insert['phone_no'] = $this->input->post('phone_no');
						$insert['email'] = $this->input->post('email');
						$insert['password']=$this->input->post('password');				
						$insert['u_token'] = md5(rand(1000,9999).time()); 
						$insert['cdate']=date('Y-m-d H:i:s');
						$insert['unique_id']=GetUserUniqueId();
						$insert['unique_id1']=time();				
						
						$run = $this->common_model->insert('users', $insert);

						$traffic_source = $this->input->post('traffic_source');
						$data=array(
							'user_id'=>$run,
							'traffic_source'=>$traffic_source
						);
						$this->db->insert('marketers_account_info',$data);
						if($run){
							$time = time();
							$degit = substr($time,-5);
							$json['status'] = 1;
							
							$this->session->set_userdata('type', $insert['type']);
							$this->session->set_userdata('email', $insert['email']);
							$this->session->set_userdata('user_logIn', true);
							$this->session->set_userdata('user_id', $run);
							$this->session->set_userdata('unique_id', $insert['unique_id']);


							$this->input->set_cookie('type',$insert['type'],43200*60);
							$this->input->set_cookie('user_id',$run,43200*60);
							$this->input->set_cookie('email',$insert['email'],43200*60);
							$this->input->set_cookie('unique_id',$insert['unique_id'],43200*60);
							$get_name = $insert['f_name'].''.$insert['l_name'];
							$this->input->set_cookie('u_name',$get_name,43200*60);
							
		          $subject = "Thank you for Signing up to Tradespeoplehub.co.uk.";
							$this->send_how_it_works_email_marketer($insert['email'], $insert['f_name'], $subject);

						} else {
							$json['status'] = 0;
							$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
						}
					}
			else{
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger">Password and Confirm password Should be Matched</div>';
			}
		}
		echo json_encode($json);
	}

	public function marketer_email_verify(){
     $result['setting']=$this->common_model->get_all_data('admin');
    if($this->session->userdata('user_id')){
			
				$result = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			
      if($result['u_email_verify'] == 1){
				
					return redirect('dashboard'); die;
      }else{
		
				$id = $this->session->userdata('user_id');
				$update['u_token'] = md5(time().rand());
        $update['u_email_verify'] = 0;
        $run = $this->common_model->update('users',array('id'=>$id),$update);
        if($run){
						
					/*$subject = "Verify your Email Address - Tradespeoplehub.co.uk";

					$html = "<p style='margin:0;font-size:20px;padding-bottom:5px;color:#2875d7'>Please verify your email address.</p>
						<p style='margin:0;padding:10px 0px'>Thanks for registering for Tradespeoplehub's affiliate program! To finish your sign up, please verify your email address by clicking the button below.</p>";

					$html.='<div style="text-align:center"><a href="'.site_url().'email-verified/'.$id.'/'.$update['u_token'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify Email Address</a></div>';
					$sent = $this->common_model->send_mail_verifyemail($result['email'],$subject,$html);*/

					$code = rand(1000,9999);
		     	$emailVerified= $this->common_model->update('users',array('id' => $id ),array('email_code'=>$code , 'email_code_sent_time' => date('Y-m-d H:i:s')));

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
									<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub affiliate program! To finish your sign up, please verify your email address using below code on the verification page.</p>
									<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';

					$this->common_model->send_mail($result['email'],"Verify your Email Address - Tradespeoplehub.co.uk",$html);
				}
        $this->load->view('site/emailverify',$result);
      }
    }else{
      return redirect('login'); die;
    }
  }




  public function submit_signup2() {
    $this->form_validation->set_rules('category[]','Category','required');
    $this->form_validation->set_rules('subcategory[]','Subategory','required');
    if($this->form_validation->run()==false){
      $json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
    } else {
    	$categories = $this->input->post('category');
    	$subcategories = $this->input->post('subcategory');
      $insert['category'] = implode(',',$categories);
      $insert['subcategory'] =  implode(',',$subcategories) ;
      // foreach($categories as $parent)
      // {

      // 	$subcat = $this->common_model->GetAllData('category' , array('cat_parent' => $parent));
      // 	foreach($subcat as $row)
      // 	{
      // 		array_push($subcategories, $row['cat_id']);
      // 	}
      	
      	
      // }
      // //print_r($subcategories);print_r($categories);die();
      // $insert['subcategory'] = implode(',',$subcategories);
      //print_r($insert);die();
      $this->session->set_userdata('signup_step2', $insert);
      $json['status'] = 1;
    }
    echo json_encode($json);
  }

  public function submit_signup4() {
    $this->form_validation->set_rules('about_business','About Bussiness','required');
    $is_qualification = $this->input->post('is_qualification');
    if($is_qualification == '1'){
      $this->form_validation->set_rules('qualification', 'Qualification', 'required');
      $is_qualification = 1;
    }
    $insurance_liability = $this->input->post('insurance_liability');
    if($insurance_liability == 'yes'){
      $this->form_validation->set_rules('insurance_amount', 'Insurance Amount', 'required');
      $this->form_validation->set_rules('insurance_date', 'Insurance Date', 'required');
    }
    if($this->form_validation->run()==false){
      $json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
    } else {
			
			$about_business = $this->input->post('about_business');
			$qualification = $this->input->post('qualification');
			
			$check_contact = true;
			
			foreach ($this->words as $url) {
				
				if (strpos($about_business, $url) !== FALSE) {
					$check_contact = false;
					$status = 2; break;
				}
				
				if(!in_array($url,['0','1','2','3','4','5','6','7','8','9'])){
					if ($is_qualification==1 && strpos($qualification, $url) !== FALSE) {
						$check_contact = false;
						$status = 3; break;
					}	
				}
			}
			
			$json['status'] = $status;
			
			if($check_contact){
				
				$insert11['about_business'] = $about_business;
				$insert11['is_qualification'] = $is_qualification;
				$insert11['insurance_liability'] = $insurance_liability;
				$insert11['qualification'] = $qualification;
				$insert11['insurance_amount'] = $this->input->post('insurance_amount');
				$insert11['insurance_date'] = $this->input->post('insurance_date');
				
				/*$signup_step1 = $this->session->userdata('signup_step1');
				$signup_step2 = $this->session->userdata('signup_step2');
				$insert = array_merge($signup_step1, $signup_step2);*/

				$insert['about_business'] = $this->input->post('about_business');
				$insert['is_qualification'] = $is_qualification;
				$insert['insurance_liability'] = $insurance_liability;
				$insert['qualification'] = $qualification;
				$insert['insurance_amount'] = $this->input->post('insurance_amount');
				$insert['insurance_date'] = $this->input->post('insurance_date');
				
				$insert['u_token'] = md5(rand(1000,9999).time());
				$insert['cdate']=date('Y-m-d H:i:s');
				$insert['unique_id']=GetUserUniqueId();

				$setting = $this->common_model->get_single_data('admin',array('id'=>1));
				$insert['free_trial_taken'] = $setting['payment_method'] == 0 ? 1 : 0;
				
				if($this->session->userdata('user_logIn')){
					
					$run = $this->session->userdata('user_id');
					$this->common_model->update('users',array('id'=>$run),$insert11);
					
				} else {
					
					$referred_by = false;

					// if (isset($insert['referred_by']) && $insert['referred_by']) {
					// 	$referred_by = $this->input->post('referred_by');
					// } else if($this->session->userdata('referred_by')){
					// 	$referred_by = $this->session->userdata('referred_by');
					// }
					if($this->session->userdata('referred_by'))
					{
						$referred_by = $this->session->userdata('referred_by');
						$referred_link = $this->session->userdata('referred_link');
						$insert['referral_code'] = $referred_by;
					    
					}
					
					$run = $this->common_model->insert('users', $insert);
					
					// $referred_type = $this->input->post('referred_type');
					if($referred_by){
						
						$users = $this->db->where('unique_id', $referred_by)->get('users')->row();
						$referal_data = array(
							'user_id'=> $run,
							'user_type'=> 1,
							'referred_by'=> $users->id,
							'referred_type'=> $users->type,
							'referred_link'=> $referred_link
						);
						$this->db->insert('referrals_earn_list',$referal_data); 
					} 
					 	
					$time = time();
					$degit = substr($time,-5);
				
					$this->common_model->update('users',array('id'=>$run),array('unique_id'=>$run.$degit));
					
					$this->session->set_userdata('type', $insert['type']);
					$this->session->set_userdata('email', $insert['email']);
					$this->session->set_userdata('u_name', $insert['trading_name']);
					$this->session->set_userdata('user_logIn', true);
					$this->session->set_userdata('user_id', $run);
					$this->session->set_userdata('unique_id', $run.$degit);

					$this->input->set_cookie('type',$insert['type'],43200*60);
					$this->input->set_cookie('user_id',$run,43200*60);
					$this->input->set_cookie('email',$insert['email'],43200*60);
					$this->input->set_cookie('unique_id',$run.$digit,43200*60);
					$get_name = $insert['f_name'].''.$insert['l_name'];
					$this->input->set_cookie('u_name',$get_name,43200*60);

					$this->session->unset_userdata('signup_step1');
					$this->session->unset_userdata('referred_by');
					$this->session->unset_userdata('referred_type');
					//$this->session->unset_userdata('signup_step2');
					//$this->session->unset_userdata('signup_step4');
					$this->session->unset_userdata('signup_step5');
					$this->session->set_userdata('signup', true);
					if(isset($insert['email_code'])) {
						$code = $insert['email_code'];
					} else {
						$code = rand(1000,9999);
		     		$emailVerified= $this->common_model->update('users',array('id'=>$run ),array('email_code'=>$code , 'email_code_sent_time' => date('Y-m-d H:i:s')));
					}
					// $code = isset($insert['email_code'])?$insert['email_code']:rand(1000,9999);
					/* Send email */
					$this->send_verification_email($insert['email'], "Verify your Email Address - Tradespeoplehub.co.uk", false, $insert['u_token'], $code);
				}
				
				$this->session->set_userdata('signup_step4', $insert11);
				
				$json['status'] = 1;
				
			}
    }
    echo json_encode($json);
  }

  public function submit_signup5() {
    /* Not required anymore */
    $this->form_validation->set_rules('work_history','Work history','required');
    if($this->form_validation->run()==false){
      $json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
    } else {
      $insert['work_history'] = $this->input->post('work_history');

      $json['status'] = 1;
    }
    echo json_encode($json);
  }

  public function submit_signup6() {
    $update['qualification'] = $this->input->post('qualification');
    $run = $this->common_model->update('users',array('id'=>$user_id),$update);
    $json['status'] = 1;
    echo json_encode($json);
  }

  public function submit_signup7() {
		
    $verification_code = $this->input->post('verification_code');
		
		$user_id = $this->session->userdata('user_id');
		
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		
    if($verification_code == $user_data['phone_code']){
			
      $update['is_phone_verified'] = 1;
      $run = $this->common_model->update('users', array('id' => $user_id), $update);
			
			$subject = "Phone number verified successfully";
			
			$html = '<P style="margin:0;padding:10px 0px">Hi '.$user_data['f_name'].'</P>';
			$html .= '<P style="margin:0;padding:10px 0px">Your  Phone number has been verified successfully.</P>';
			$html .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$sent = $this->common_model->send_mail($user_data['email'],$subject,$html);
			
      $json['status'] = 1;
    }else{
      $json['status'] = 0;
    }
    echo json_encode($json);
  }

  public function submit_signup8() {
    if($this->session->userdata('signup')){
      //$this->session->unset_userdata('signup');
    }
    $user_id = $this->session->userdata('user_id');
    $update['selected_plan'] = $this->input->post('plan_type');
    $run = $this->common_model->update('users',array('id'=>$user_id),$update);
    $json['status'] = 1;
    echo json_encode($json);
  }

  public function submit_signup9() {
			$payment_method = $this->input->post('payment_method');
			$customerID = $this->input->post('customerID');
			// $card_id = $this->input->post('card_id');
			// $card_u_name = $this->input->post('card_u_name');
			$user_id = $this->session->userdata('user_id');
			$email = $this->session->userdata('email');
			$cardDetail = GetCardDetailByApi($payment_method);

			$saveCard['u_name'] = $cardDetail['card_u_name'];
			$saveCard['payment_method'] = $payment_method;
			$saveCard['country'] = $cardDetail['country'];

			$saveCard['exp_year'] = $cardDetail['exp_year'];
			$saveCard['exp_month'] = $cardDetail['exp_month'];
			$saveCard['last4'] = $cardDetail['last4'];
			$saveCard['brand'] = $cardDetail['brand'];
			$saveCard['updated_at'] = date('Y-m-d H:i:s');

			$check =  $this->common_model->get_single_data('save_cards', ['payment_method'=> $payment_method, 'country'=>$cardDetail['country'], 'exp_year'=>$cardDetail['exp_year'], 'exp_month'=>$cardDetail['exp_month'], 'last4'=>$cardDetail['last4'], 'brand'=>$cardDetail['brand']]);
			if($check){
				$this->session->set_flashdata('message','<div class="alert alert-danger">This card already used by an other customer!</div>');
				$json['status'] = 1;
    		echo json_encode($json); exit();

			}else{
				$saveCard['customer_id'] = $customerID;
				$saveCard['user_id'] = $user_id;
				$saveCard['email'] = $email;
				$this->common_model->insert('save_cards',$saveCard);
			}





		/*$postal_code = $this->input->post('postcode');
		$postal_code = str_replace(" ","",$postal_code);
		$check_postcode = $this->common_model->check_postalcode($postal_code);
		if($check_postcode['status']==1){*/
		
			// $user_id = $this->session->userdata('user_id');
			
			// $isExist = $this->common_model->get_single_data('billing_details', array('user_id' => $user_id));
			
			// $customerID = $this->input->post('customerID');
			// $payment_method = $this->input->post('payment_method');
			
			// $stripe_data['customerID'] = $customerID;
			// $stripe_data['payment_method'] = $payment_method;
			
			// $serialize = serialize($stripe_data);
			
			// $data['name'] = $this->input->post('name');
			//$data['card_number'] = $this->input->post('card_number');
			//$data['card_exp_month'] = $this->input->post('card_exp_month');
			//$data['card_exp_year'] = $this->input->post('card_exp_year');
			//$data['card_cvc'] = $this->input->post('card_cvc');
			//$data['postcode'] = $this->input->post('postcode');
			//$data['address'] = $this->input->post('address');
			// $data['stripe_data'] = $serialize;
			// $data['is_payment_verify'] = 1;
			// $data['updated_at'] = date("Y-m-d H:i:s");

			// if($isExist){
			// 	$run = $this->common_model->update('billing_details',array('id' => $isExist['id']), $data);
			// }else{
			// 	$data['user_id'] = $user_id;
			// 	$data['created_at'] = date("Y-m-d H:i:s");
			// 	$run = $this->common_model->insert('billing_details', $data);
			// }
			
			$user_data = $this->common_model->GetColumnName('users',array('id'=>$user_id),array('f_name','email','u_token','free_trial_taken','is_pay_as_you_go'));
			
			$plan_id = $this->input->post('plan_id');
			
			if($plan_id && !empty($plan_id)){
				$plan_detail = $this->common_model->get_single_data('tbl_package',array('id'=>$plan_id));
				
				if($plan_detail){
				
					$traId = time().rand();
					
					$insert2['up_user'] = $user_id;
					$insert2['up_plan'] = $plan_id;
					$insert2['up_planName'] = $plan_detail['package_name'];
					
				
					$bid = $plan_detail['free_bids_per_month']; 
					$insert2['up_bid'] = trim($bid,' bids');
					$insert2['bid_type'] = 1;
					
				
					$insert2['up_startdate'] = date('Y-m-d');
					$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_startdate']. '+ '.$plan_detail['free_plan_exp']));
					$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_enddate']. '- 1 day'));
					$insert2['total_sms'] = $plan_detail['free_sms'];
					$insert2['up_used_bid'] = 0;
					$insert2['used_sms_notification'] = 0;
					$insert2['up_status'] = 1;
					$insert2['up_transId'] = $traId;
					
					$run2 = $this->common_model->insert('user_plans',$insert2);
					
					if($run2){
						
						$this->common_model->update('users',array('id' => $user_id), array('free_trial_taken'=>1));
						
						$this->common_model->delete(array('up_user'=>$user_id,'up_id != '=>$run2),'user_plans');
						
						
						
						$this->session->set_flashdata('success1123','<p class="alert alert-success">Your subscription plan has been activated successfully. You can now start winning jobs. Don´t also forget to verify your account.</p>');
					}
				}
			} else {
				$this->session->set_flashdata('success1123','<p class="alert alert-success">Your card information updated successfully.</p>');
			}
			
			if($user_data['free_trial_taken']==0 and $user_data['is_pay_as_you_go']==0){
				$this->send_membership_welcome_email($user_data['email'],$user_data['f_name'], $user_data['u_token'],$plan_detail['amount']);
			}
			
			$json['status'] = 1;
		
    echo json_encode($json);
  }

  public function select_pay_as_you_go() {
		$user_id = $this->session->userdata('user_id');
		
		$user_data = $this->common_model->GetColumnName('users',array('id'=>$user_id),array('f_name','email','u_token','is_pay_as_you_go','free_trial_taken'));
		
    $this->common_model->update('users',array('id' => $user_id), array('free_trial_taken'=>0,'is_pay_as_you_go'=>1));
			
		
		if($user_data['free_trial_taken']==0 and $user_data['is_pay_as_you_go']==0){
			$this->send_pay_as_you_go_welcome_email($user_data['email'],$user_data['f_name'], $user_data['u_token']);
		}
	
		redirect('wallet');
  }

	public function email_verified($id,$token) {
		if($id && $token){
			$data = $this->common_model->get_userDataByid($id);
			if($data){
				if($data['u_email_verify'] == 0){
					if($data['u_token'] == $token){
						
						$update['u_email_verify'] = 1;
						$run = $this->common_model->update('users',array('id'=>$id),$update);
						if($run) {
							
							$this->session->set_flashdata('msg','<div class="alert alert-success">Your email has been verified successfully.</div>');
							
							$subject = "Email verified successfully";
			
							$html = '<P style="margin:0;padding:10px 0px">Hi '.$data['f_name'].'</P>';
							$html .= '<P style="margin:0;padding:10px 0px">Your email address has successfully been verified.</P>';
							$html .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
							
							$sent = $this->common_model->send_mail($data['email'],$subject,$html);
							
							if($this->session->userdata('user_id')){
								if($data['type']==3){
									redirect('dashboard');
								}
								if($data['free_trial_taken']==1 || $data['is_pay_as_you_go']==1){
									redirect('dashboard');
								} else {
									redirect('signup-step8');
								}
							} else {
								redirect('login');
							}
							
						}else{
							
							$this->session->set_flashdata('msg','<div class="alert alert-danger">Server not responding, please try again later!</div>');
							redirect('email-verify');
							
						}
					} else {
						$this->session->set_flashdata('msg','<div class="alert alert-danger">User not authorized or link is expired!</div>');
						redirect('email-verify');
					}
				} else {
					$this->session->set_flashdata('msg','<div class="alert alert-success">Your account is already verified, You can access your account!</div>');
					redirect('email-verify');
				}
			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">User not authorized or link is expired!</div>');
				redirect('email-verify');
			}
		} else {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">User not authorized or invalid token code!</div>');
			redirect('email-verify');
		}
	}
	
	public function submit_email_verify() {
		$verification_code = $this->input->post('verification_code');
		
		$user_id = $this->session->userdata('user_id');
		
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		$lastThreeHours = date('Y-m-d H:i:s', strtotime('-3 hours')); 
		$currentDateTime =  date('Y-m-d H:i:s');
		if (($user_data['email_code_sent_time'] >= $lastThreeHours) && ($user_data['email_code_sent_time'] <= $currentDateTime)){

		// if($lastThreeHours >= $user_data['email_code_sent_time']) {
	    if($verification_code == $user_data['email_code'] ){
	    	$update['u_email_verify'] = 1;
				$run = $this->common_model->update('users',array('id'=>$user_id),$update);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Your email has been verified successfully.</div>');
									
				$subject = "Email verified successfully";

				$html = '<P style="margin:0;padding:10px 0px">Hi '.$data['f_name'].'</P>';
				$html .= '<P style="margin:0;padding:10px 0px">Your email address has successfully been verified.</P>';
				$html .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$sent = $this->common_model->send_mail($user_data['email'],$subject,$html);
				
				if($this->session->userdata('user_id')){
					if($data['type']==3){
						$json['url'] = 'dashboard';
					}
					if($data['free_trial_taken']==1 || $data['is_pay_as_you_go']==1){
						$json['url'] = 'dashboard';
					} else {
						$json['url'] = 'signup-step8';
					}
				} else {
					$json['url'] = 'login';
				}
				 $json['status'] = 1;
			}else{
	      $json['status'] = 0;
	      $json['message'] = "Wrong Security Code";
	    }
	  } else {
	  	$json['status'] = 0;
	    $json['message'] = "Security Code was Expired. Please resend again.";
	  }
    echo json_encode($json);
	}

  public function email_verify(){
	  $result['setting']=$this->common_model->get_all_data('admin');
    if($this->session->userdata('user_id')){
			
			$result = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			
      if($result['u_email_verify'] == 1){
			  if($result['setting'][0]['payment_method'] == 0){
				  return redirect('dashboard'); die;
			  }else{
			  	//$this->session->userdata('signup')
					if($data['free_trial_taken']==0 && $data['is_pay_as_you_go']==0){
						return redirect('billing-info'); die;
					} else {
						return redirect('dashboard'); die;
					}	
			  }				
      }else{
		
				$id = $this->session->userdata('user_id');
				$update['u_token'] = md5(time().rand());
        $update['u_email_verify'] = 0;
        $run = $this->common_model->update('users',array('id'=>$id),$update);

        if($run){
        	if($result['email_code'] == '' ){
						$subject = "Verify your Email Address - Tradespeoplehub.co.uk";
						$code = rand(1000,9999);
				
						$this->common_model->update("users",array('id'=>$id),array('email_code'=>$code, 'email_code_sent_time' => date('Y-m-d H:i:s')));
					
						$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
							<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p>
							<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
						try{
							$sent = $this->common_model->send_mail_verifyemail($result['email'],$subject,$html);
						}catch(Exception $e){
							$result['errMsg'] = $e->getMessage();
						}
					}
					$this->load->view('site/emailverify',$result);
				}
      }
    }else{
      return redirect('login'); die;
    }
  }

  public function resend_verification_link() {
    if($this->session->userdata('user_logIn')){
      $id = $this->session->userdata('user_id');
      $userdata = $this->common_model->get_userDataByid($id);
      if($userdata['u_email_verify'] == 1){
        $json['status'] = 3;
      }else{
        $code = rand(1000,9999);
        $update['u_token'] = md5(time().rand());
        $update['u_email_verify'] = 0;
        $update['email_code'] = $code;
        $update['email_code_sent_time'] = date('Y-m-d H:i:s');

        $run = $this->common_model->update('users',array('id'=>$id),$update);
        if($run){
						
         $subject = "Verify your Email Address - Tradespeoplehub.co.uk";
					
         if($userdata['type']==3){

	         	$html = "<p style='margin:0;font-size:20px;padding-bottom:5px;color:#2875d7'>Please verify your email address.</p>
							<p style='margin:0;padding:10px 0px'>Thanks for registering for Tradespeoplehub's affiliate program! To finish your sign up, please verify your email address using below code on the verification page.</p>";

						 $html.='<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
						// $html.='<div style="text-align:center"><a href="'.site_url().'email-verified/'.$id.'/'.$update['u_token'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify Email Address</a></div>';
         }else{
	         	$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
							<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p>
							<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
         }
          $sent = $this->common_model->send_mail_verifyemail($userdata['email'],$subject,$html);
          
					
          $json['status'] = ($sent) ? 1 : 0;
        }
      }
    }else{
      $json['status'] = 0;
    }
    echo json_encode($json);
  }

 	public function change_verification_email() {
	    if($this->session->userdata('user_logIn')){
	      	$id = $this->session->userdata('user_id');
	      	$userdata = $this->common_model->get_userDataByid($id);
	     	if($userdata['u_email_verify'] == 1){
	        	$json['status'] = 3;
				
	      	}else{

	      		$email = $this->input->post('email');
	      		$check = $this->common_model->get_single_data('users',array('email'=>$email,'id !='=>$id));
	      		
	      		if(!empty($check))
	      		{
	      			$json['status'] = 4;
					
	      		} else {
	      			$code = rand(1000,9999);
	      			$update['u_token'] = md5(time().rand());
		        	$update['u_email_verify'] = 0;
		        	$update['email'] = $email;	        
		        	$update['email_code'] = $code;
		        	$update['email_code_sent_time'] = date('Y-m-d H:i:s');      
		        	$run = $this->common_model->update('users',array('id'=>$id),$update);
		        	if($run){	
		        		$this->session->set_userdata('email',$email);						
		        		$this->input->set_cookie('email',$email,43200*60);						
		        		$this->session->set_userdata('u_email_verify',0);						
		         		$subject = "Verify your Email Address - Tradespeoplehub.co.uk";
							
		         		if($userdata['type']==3){
			         		$html = "<p style='margin:0;font-size:20px;padding-bottom:5px;color:#2875d7'>Please verify your email address.</p>
									<p style='margin:0;padding:10px 0px'>Thanks for registering for Tradespeoplehub's affiliate program! To finish your sign up, please verify your email address by using below code on the verification page.</p>";

								$html.='<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
		         		}else{
			         		$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
									<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p>
									<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
		         		}
		          		$sent = $this->common_model->send_mail_verifyemail($userdata['email'],$subject,$html);
		          
						if($sent)
						{
							$json['status'] = 1;
							$this->session->set_flashdata('msg','<div class="alert alert-success">Verification code has been sent successfully, please check your email</div>');
							
						} else {
							$json['status'] = 0;
							
						}	
		          		
		        	}
	      		}
	        
	      	}
	    }else{
	      	$json['status'] = 0;
	      	
	    }
	    echo json_encode($json);
  	}

  public function login_form() {
		$this->form_validation->set_rules("email","Email address","required|valid_email");
		$this->form_validation->set_rules("password","Password", "required");

		if ($this->form_validation->run()==false) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		} else {
			$u_password = $this->input->post("password");
			$u_email = $this->input->post("email");
			
			$data = $this->common_model->get_single_data('users',array('email'=>$u_email,'password'=>$u_password));

			if($data) {
				if($data['status']==1) {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Your account is blocked by Super Admin!</div>';
				
				}elseif($data['delete_request'] == 2){
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Your account is deleted!</div>';
				}else{
					$this->session->set_userdata('user_logIn',true);
					$this->session->set_userdata('type',$data['type']);
					$this->session->set_userdata('user_id',$data['id']);
					$this->session->set_userdata('email',$data['email']);
					$this->session->set_userdata('unique_id',$data['unique_id']);
					$get_name=$data['f_name'].' '.$data['l_name'];
					$this->session->set_userdata('u_name',$get_name);

					$this->input->set_cookie('type',$data['type'],43200*60);
					$this->input->set_cookie('user_id',$data['id'],43200*60);
					$this->input->set_cookie('email',$data['email'],43200*60);
					$this->input->set_cookie('unique_id',$data['unique_id'],43200*60);
					$this->input->set_cookie('u_name',$get_name,43200*60);

					$job_id=$this->input->post('job_id');
					if($job_id){
						$update['userid']=$data['id'];
						$update['status']=1;
						$run = $this->common_model->update('tbl_jobs',array('job_id'=>$job_id),$update);
					}
					
					$json['id'] = $data['id'];
					$json['status'] = 1;
					
					$redirectUrl = false;
					
					if($data['type']==2){
						$redirectUrl = base_url('my-account');
					} else if($data['type']==3){
						$redirectUrl = base_url('affiliate-dashboard');
					}
					// $json['redirectUrl'] = (isset($_POST['redirectUrl']) && !empty($_POST['redirectUrl'])) ? base64_decode($_POST['redirectUrl']) : false;
					$json['redirectUrl'] = $redirectUrl;
					$json['user_id']=$this->session->set_userdata('user_id',$data['id']);

				}
			
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Username or password invalid!</div>';
			}
	
		}	
		echo json_encode($json);
	}
	
  public function notifications(){
		$this->load->view('site/notifications');
	}
	
  public function memberships(){
		$this->load->view('site/membership');
	}

	public function membership_plans(){
		if(!$this->session->userdata('user_id')){
			redirect('login');
		}else{
			$data['setting'] = $this->common_model->get_single_data('admin',array('id'=>1));
			$data['user_plans']=$this->common_model->get_user_plans();
			//echo $this->db->last_query();
			//print_r($data['user_plans']);
			$data['logged_user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));

			$setting = $this->common_model->get_single_data('admin',array('id'=>1));

			$data['logged_user_profile']['free_trial_taken'] = !empty($setting) && $setting['payment_method'] == 1 ? 1 : 0;
			$data['logged_user_profile']['is_pay_as_you_go'] = !empty($setting) && $setting['payment_method'] == 1 ? 1 : 0;
			
			if($data['logged_user_profile']['free_trial_taken']==1){			
				$this->load->view('site/member-plan',$data);
			} else {
				redirect('billing-info');
			}
		}
	}

	public function pay_as_you_go() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$data['user_plans']=$this->common_model->get_user_plans();
			$this->load->view('site/pay_as_you_go',$data);
		}
	}
		
	public function subscription_plan() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$setting=$this->common_model->get_all_data('admin');
			if($setting[0]['payment_method'] == 0){
				redirect('dashboard');
			}
			$data['user_plans']=$this->common_model->get_user_plans();
			$this->load->view('site/membership',$data);
		}
	}

	public function project_name(){
		$this->load->view('site/project-name');
	}
	
	public function files() {
		$this->load->view('site/files');
	}
	
	public function task(){
		$this->load->view('site/task');
	}
	
	public function reviews(){
		$this->load->view('site/reviews');
	}
	
	public function payments() {
		$this->load->view('site/payment-inner');
	}
	
	public function account(){
		$this->load->view('site/account');
	}
	
	public function forgot_password() {
		if($this->session->userdata('user_id')) {
			redirect('dashboard');
		} else {
			 	$this->load->view('site/forgot-password');
		}
	
	}
	
	public function forget_pass() {
		$this->form_validation->set_rules("email", "Email address", "required|valid_email");
		if ($this->form_validation->run()==false) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		} else {
			$u_email = $this->input->post("email");
			$data = $this->common_model->get_single_data('users',array('email'=>$u_email));
			
			if($data) {
				if($data['status']==0){
					$json['status'] = 1;
					
					$u_name = $data['f_name'].' '.$data['l_name'];

					$subject = Project.": Forget Password!"; 
					$contant= 'Hello, '.$u_name.' <br><br>';
					$contant .='<p class="text-center">This is an automated message . If you did not recently initiate the Forgot Password process, please disregard this email.<p>';

					$contant .='<p class="text-center">You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p>';
	 
					$contant .='<p class="text-center">Password: <b>'.$data['password'].'</b></p>';
						
					$run = $this->common_model->send_mail($data['email'],$subject,$contant);
					
					$json['status'] = ($run) ? 1 : 0;
					
					$json['msg'] = '<div class="alert alert-danger">Something went wrong!</div>';
				} else {
					$json['status'] = 3;
				}
			} else {
				$json['status'] = 2;
			}
		}
		echo json_encode($json);
	}	
	
	public function trust_verification() {
		$this->load->view('site/trust');
	}
	
	public function contact_request() {
		$insert['type']=$this->input->post('type');
		$insert['status']=0;
		$insert['first_name'] = $this->input->post('first_name');
		$insert['last_name'] = $this->input->post('last_name');
		$insert['email'] = $this->input->post('email');
		$insert['phone_no'] = $this->input->post('phone_no');
		$insert['message']=$this->input->post('message');
		$insert['cdate'] = date('Y-m-d h:i:s');

         $secret = '6Lfvi7IZAAAAAKBz-pfuyr59kazGNIIHCiKElr1d';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_REQUEST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
    if($responseData->success)
     { 

		$result1=$this->common_model->insert('contact_request',$insert);
		if($result1){
		
			$sub='New contact Request';
			$message=$this->input->post('message');
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New Contact Request</b></p><p>Details are given below : </p><p><b>Name : </b>".$insert['first_name'].' '.$insert['last_name']."</p><p><b>Email ID : </b>".$insert['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p><p><b>Message : </b>".$message."</p>";
			$result=$this->common_model->send_mail($to,$sub,$body);
			$json['status'] = 1;
			$json['msg'] = '<div class="alert alert-success">Thank you for your enquiry, we will contact you soon..</div>';
			$json['button']='Submit';

		} else {
			$json['status'] = 0;

			$json['msg'] = '<div class="alert alert-danger">Something went wrong.</div>';
		}
	}else
        {
            //$errMsg = 'Robot verification failed, please try again.';
           $json['status'] = 2;
           $json['button']='Submit';
           $json['msg'] = '<div class="text text-danger">Please verify that you are not a robot.</div>';
        }
		
		echo json_encode($json); 
	
	}
 
  public function post_job(){
    $data['category'] = $this->common_model->get_parent_category('category');
		$data['country']=$this->common_model->newgetRows('tbl_region',array('is_delete'=>0));
    $this->load->view('site/job_post_page',$data);
  }

  public function signup() {
		$result['country']=$this->common_model->newgetRows('tbl_region',array('is_delete'=>0));
    $this->load->view('site/homeowner_signup',$result);
  } 
  public function affiliate_signup() { 
  	$result['affilateMeataSignup'] = $this->common_model->get_single_data('other_content',array('id'=>5));
  	// print_r($result['affilateMeataSignup']); exit;
		$result['country']=$this->common_model->get_countries(); 
    $this->load->view('site/affiliaters_signup',$result);
  }

	public function signup_homeowner($id) {
		$this->form_validation->set_rules('f_name','First Name','required');
		$this->form_validation->set_rules('l_name','Last Name','required');
		$this->form_validation->set_rules('phone_no','Phone number','required|integer|is_unique[users.phone_no]',array('is_unique'=>'This phone number is already registered'));
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]',array('is_unique'=>'This email is already registered'));
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('checkboxes','Terms and Conditions','required');
		//$this->form_validation->set_rules('county_id','County','required');
		//$this->form_validation->set_rules('city','City','required');	
		if($this->form_validation->run()==false){
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
		} else {
			
			$post_code1 = $this->input->post('post_code');
			$check_postcode = $this->common_model->check_postalcode($post_code1);

			// if($check_postcode['status']==1)
			 // {		
			$longitude = $check_postcode['longitude'];
			$latitude  = $check_postcode['latitude'];
			$primary_care_trust  = $check_postcode['primary_care_trust'];
			$address  = $check_postcode['address'];
			$country  = $check_postcode['country'];
			$code = rand(1000,9999);
			$insert['type'] = 2;
			$insert['f_name'] = $this->input->post('f_name');
			$insert['l_name'] = $this->input->post('l_name');
			$insert['phone_no'] = $this->input->post('phone_no');
			$insert['email'] = $this->input->post('email');
			$insert['password']=$this->input->post('password');		
			$insert['country'] = $country;
			$insert['city'] = $primary_care_trust;
			$insert['email_code'] = $code;
			$insert['email_code_sent_time'] = date('Y-m-d H:i:s');
			$insert['postal_code'] = $this->input->post('postcode');
			$insert['u_token'] = md5(rand(1000,9999).time());
			$insert['cdate']=date('Y-m-d H:i:s');
			$run = $this->common_model->insert('users',$insert);	
			if($run){
				$this->session->set_userdata('user_logIn',true);
				$this->session->set_userdata('user_id',$run);
				$this->session->set_userdata('type',$insert['type']);
				$this->session->set_userdata('email',$insert['email']);
				 $get_name=$insert['f_name'].' '.$insert['l_name'];
				$this->session->set_userdata('u_name',$get_name);
				$subject = "Verify your Email Address - Tradespeoplehub.co.uk"; 
				$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
				<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p>
				<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div>
				<p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>
				';
		
				$json['sf'] = $this->common_model->send_mail($this->session->userdata('email'),$subject,$contant);

				$json['msg']=$this->session->set_flashdata('msg','<div class="alert alert-success">Your registration has been done successfully, We have sent verification code to your email!</div>');
				$get_job=$this->common_model->get_last_job();
		
				$job_id=$get_job[0]['id'];

			$update['userid']=$run;
			$update['status']=0;
	
				$run = $this->common_model->update('tbl_jobs',array('job_id'=>$job_id),$update);
				$json['status'] = 1;
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong please try again later.</div>';
			}
		}
		echo json_encode($json);
	}
	
	public function search() {
		$keyword=$this->input->post('categoryid');
		$category_details=$this->common_model->get_category_detailsbyname($keyword);
		if($category_details) {
		 	$cat_id=$category_details[0]['cat_id'];
			$sql = "SELECT u.* from users u where u.`f_name` LIKE '%".$keyword."%' or u.`l_name` LIKE '%".$keyword."%' or u.`email` LIKE '%".$keyword."%' or u.phone_no LIKE '%".$keyword."%' or u.password LIKE '%".$keyword."%' or u.about_business LIKE '%".$keyword."%' or `postal_code` LIKE '%".$keyword."%' or `primary_lang` LIKE '%".$keyword."%' or `secondary_lang` LIKE '%".$keyword."%' or `hourly_rate` LIKE '%".$keyword."%' or `profile_summary` LIKE '%".$keyword."%' or `professional_head` LIKE '%".$keyword."%' or `company` LIKE '%".$keyword."%' or `insurance_liability` LIKE '%".$keyword."%' or `insured_by` LIKE '%".$keyword."%' or FIND_IN_SET(".$cat_id.",category)";
			$query=$this->db->query($sql);
			$page['get_users_cat']=$query->result_array();
		
			$this->load->view('site/category_details',$page);
	 } else {
			$sql1 = "SELECT u.* from users u where u.`f_name` LIKE '%".$keyword."%' or u.`l_name` LIKE '%".$keyword."%' or u.`email` LIKE '%".$keyword."%' or u.phone_no LIKE '%".$keyword."%' or u.password LIKE '%".$keyword."%' or u.about_business LIKE '%".$keyword."%' or `postal_code` LIKE '%".$keyword."%' or `primary_lang` LIKE '%".$keyword."%' or `secondary_lang` LIKE '%".$keyword."%' or `hourly_rate` LIKE '%".$keyword."%' or `profile_summary` LIKE '%".$keyword."%' or `professional_head` LIKE '%".$keyword."%' or `company` LIKE '%".$keyword."%' or `insurance_liability` LIKE '%".$keyword."%' or `insured_by` LIKE '%".$keyword."%'";
			$query1=$this->db->query($sql1);
			$page['get_users_cat']=$query1->result_array();
		
			$this->load->view('site/category_details',$page);

		}
	
		
	}

  public function test_function(){
    
		echo '<pre>';
		$data = $this->common_model->check_postalcode('BR53AZ');
		print_r($data);
		echo '</pre>';
  }
 
	
  public function save_payment_info(){
		$data = serialize($this->input->post('data'));
		$user_id = $this->session->userdata('user_id');
		
		$insert['data'] = $data;
		$insert['user_id'] = ($user_id) ? $user_id : 0;
		
		$this->common_model->insert('payment_data',$insert);
	}
 
	public function createPaymentIntent($amount,$type=null){
		
		require_once('application/libraries/stripe-php-7.49.0/init.php');
		
    header('Content-Type: application/json');
		$secret_key = $this->config->item('stripe_secret');
		$email = $this->session->userdata('email');
		
		
		$statement_descriptor = 'Diposit in wallet';
		
		if($type==2){
			$statement_descriptor = 'Subscription renewed';
		} else if($type==9){
			$statement_descriptor = 'Buy addon';
		}
		
		\Stripe\Stripe::setApiKey($secret_key);
		try {
			
			$checkCustomer = $this->common_model->GetColumnName('save_cards',['email'=>$email],array('customer_id'));
			
			if($checkCustomer && $checkCustomer['customer_id']){
				$customer_id = $checkCustomer['customer_id'];
			} else {
				$customer = \Stripe\Customer::create(['email' => $email]);
				$customer_id = $customer->id;
			}
		
			
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => $amount*1*100,
				'currency' => 'GBP',
				'customer' => $customer_id,
				'description' => $statement_descriptor,
				'setup_future_usage' => 'off_session',
				'payment_method_types'=>['card'],
				'payment_method_options' => [
					"card" => [
						"request_three_d_secure" => "any"
					]
				 ]
			]);
			
			
			$output = array(
					'status' => 1, 
					'customerID' => $customer_id,
					'clientSecret' => $paymentIntent->client_secret
				);
			
		} catch (Error $e) {
			
			$output = array(
				'status' => 0, 
				'msg' => $e->getMessage()
			);
			
		}
		
		echo json_encode($output);
		
  }

  public function send_verification_email($to, $subject, $from = false, $token, $code){
		
    $user_id = $this->session->userdata('user_id');

    $html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Please verify your email address.</p>
		<p style="margin:0;padding:10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p>
		<div style="text-align:center"><a href="javascript:void(0);" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">'.$code.'</a></div><p style="margin:0;padding:10px 0px">The code will expire three hours after the email was sent.</p>';
		
		return $sent = $this->common_model->send_mail($to,$subject,$html);

  }

  public function send_pay_as_you_go_welcome_email($to, $f_name, $token){
		
    $user_id = $this->session->userdata('user_id');
		
		$subject = "Thank you for Signing up to Tradespeoplehub.co.uk";
		
    $html = '<p style="margin:0;padding:10px 0px">Hi '.$f_name.'!</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">Welcome to TradespeopleHub!</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local jobs.</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have access to the core functionality you need to build your business with us.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Pay as you Go Plan</p>';
    
		$html .= '<p style="margin:0;padding:10px 0px">With pay as you go option, you can add credit on your wallet and use it at any time you wish to enjoy our service. </p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Changing to Subscription Plan:</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">If you would like to switch to the monthly plan, log in to your account and click on the “Upgrade tab” link in the upper left-hand corner.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Tradespeoplehub provides access to over 100K jobs posted by homeowners.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Here are a few steps of what we require you to do to start winning and doing those jobs.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Complete your profile</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Get the homeowner to know you by completing your profile page. Tradespeople that did this have seen 30% more success. So, give yourself a head start by uploading your photo and images of your past projects.</p>';
		
    $html .= '<div style="text-align:center"><a href="'.site_url().'edit-profile" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Complete profile</a></div>';
		
		$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Verify account</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Quickly verify your account, phone number, ID, address, and even public insurance cover to help build trust in the Tradespeople Hub community.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">To verify your account, upload a copy of your proof of address document and ID on to-do list part of your account. We accept UK/EU valid driving license or passport as proof of ID.</p>';
		
		$html .= '<div style="text-align:center"><a href="'.site_url().'email-verified/'.$user_id.'/'.$token.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify account now</a></div>';
		
		$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Start winning & doing jobs.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">We will begin to send you job leads in your area if we have not started already. When homeowners post a new job on TradespeopleHub which is within your selected distance of travelling, we will send you an email and text message with a link to view and quote the post.</p>';
		
		$html .= '<div style="text-align:center"><a href="'.site_url().'find-jobs" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View job leads</a></div>';
		
		$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
	
		return $sent = $this->common_model->send_mail($to,$subject,$html);
  }

  public function send_membership_welcome_email($to, $f_name, $token, $price){
    $user_id = $this->session->userdata('user_id');

    $subject = "Thank you for Signing up to Tradespeoplehub.co.uk";

    $html = '<p style="margin:0;padding:10px 0px">Hi '.$f_name.'!</p>';

    $html .= '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Welcome to TradespeopleHub!</p>';

    $html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local jobs.</p>';

    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to build your business with us.</p>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Free Trial</p>';

    $html .= '<p style="margin:0;padding:10px 0px">Your first 30 days of unlimited access to Tradespeoplehub are free. The first subscription payment, for £'.$price.', will be processed in 30 days.</p>';

    $html .= '<p style="margin:0;padding:10px 0px">Your subscription will automatically renew at the same rates unless you cancel before the end of the billing period.</p>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Changing Your Subscription Plan:</p>';

    $html .= '<p style="margin:0;padding:10px 0px">If you would like to downgrade or upgrade plan, log in to your account and click on the “Your Subscription” link in the membership management tab of your account. Then click on the “Change plan”</p>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Pay as you Go Plan</p>';

    $html .= '<p style="margin:0;padding:10px 0px">If you would like to switch to pay as you go plan, log in to your account and click on the “Pay as you go” link in the upper left-hand corner.</p>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Tradespeoplehub provides access to over 10K jobs.</p>';

    $html .= '<p style="margin:0;padding:10px 0px">Here are a few steps of what we require you to do to start winning and doing those jobs.</p>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Complete your profile</p>';

    $html .= '<p style="margin:0;padding:10px 0px">Get the homeowner to know you more by completing your profile page. Tradespeople that did this have seen 30% more success. So, give yourself a head start by uploading your photo and images of your past projects.</p>';

    $html .= '<div style="text-align:center"><a href="'.site_url().'edit-profile" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Complete profile</a></div>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Verify account</p>';

    $html .= '<p style="margin:0;padding:10px 0px">To verify your account, upload a copy of your proof of address document and ID on to-do list part of your account. We accept UK/EU valid driving license or passport as proof of ID.</p>';

    $html .= '<div style="text-align:center"><a href="'.site_url().'email-verified/'.$user_id.'/'.$token.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify account now</a></div>';

    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Start winning & doing jobs.</p>';

    $html .= '<p style="margin:0;padding:10px 0px">We will begin to send you job leads in your area if we have not started already. When homeowners post a new job on TradespeopleHub which is within your selected distance of travelling, we will send you an email and text message with a link to view and quote the post.</p>';

    $html .= '<div style="text-align:center"><a href="'.site_url().'find-jobs" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View job leads</a></div>';

    $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you are unsure how to verify your account or have any specific questions using our service.</p>';

    return $sent = $this->common_model->send_mail($to,$subject,$html);
		
  }

  public function cost_guides(){
  	$data['home']=$this->common_model->get_single_data('home_content',array('id'=>1));
    $data['costGuides'] = $this->common_model->get_all_data('cost_guides', array('is_deleted !=' => 1));
    $this->load->view('site/cost_guides', $data);
  }

  public function cost_guide_detail($id=null){
		
    $data['costGuide'] = $this->common_model->get_single_data('cost_guides', array('slug' => $id));
		if($id && $data['costGuide']){
			$data['costGuides'] = $this->common_model->get_all_data('cost_guides', array('is_deleted !=' => 1),'id','desc',5);
			$this->load->view('site/cost_guide_detail', $data);
		} else {
			redirect('cost-guides');
		}
  }

  public function before_register(){
  	$data['settings']=$this->common_model->get_all_data('admin');
    $this->load->view('site/register',$data);
  }
  
  private function send_how_it_works_email($to, $username, $subject){
    $html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7"><b> Welcome to Tradespeople Hub! </b></p>';
    $html .= '<p style="margin:0;padding:10px 0px">Hi ' .$username .',</p>';
    $html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local tradespeople.</p>';
    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to get local trade professionals to do any job around your home.</p>';
    $html .='<div style="text-align:center"><a href="' .site_url('how-it-work') .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">See how it works</a></div>';
    $html .= '<br><br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
    return $this->common_model->send_mail($to, $subject, $html);
  }


private function send_how_it_works_email_marketer($to, $username, $subject){
		if($this->session->userdata('type')==3){
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7"><b> Welcome to Tradespeople Hub! </b></p>';
	    $html .= '<p style="margin:0;padding:10px 0px">Hi ' .$username .',</p>';
	    $html .= "<p style='margin:0;padding:10px 0px'>Thank you for signing up to Tradespeoplehub's affiliate program.</p>";
	    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to earn up to £1000 per month.</p>';
	    $html .= '<br><br><p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';
		}else{
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7"><b> Welcome to Tradespeople Hub! </b></p>';
	    $html .= '<p style="margin:0;padding:10px 0px">Hi ' .$username .',</p>';
	    $html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local tradespeople.</p>';
	    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to get local trade professionals to do any job around your home.</p>';
	    $html .='<div style="text-align:center"><a href="' .site_url('marketers') .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">See how it works</a></div>';
	    $html .= '<br><br><p style="margin:0;padding:10px 0px">Visit our Marketer help page or contact our customer services if you have any specific questions using our service.</p>';
		}
    
    return $this->common_model->send_mail($to, $subject, $html);
    
  }
 	public function update_device_id()
 	{
 		$update['user_id'] = $this->session->userdata('user_id');
 		$update['device_id'] = $device_id = $this->input->post('device_id');
 		
 		$delete = $this->common_model->delete(['device_id'=>$device_id],'web_notification');
 		
 		$run = $this->common_model->insert('web_notification',$update);
 		
 	}

 	public function update_phone(){
	  $user_id = $this->session->userdata('user_id');
	  $user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
	  if($user_data && $user_data['is_phone_verified'] != 1){
	  	$phone_no = $this->input->post('phone_no');
	  	$existNo = $this->common_model->get_single_data('users', array('phone_no' => $phone_no));
			if(!empty($existNo)){
				echo 2; exit;				
			}
		  $code = rand(1000,9999);
		  $msg = "Your verification code is: ".$code." \r\n Tradespeoplehub.co.uk";
		  $this->common_model->update("users",array('id'=>$user_data['id']),array('phone_no'=>$phone_no,'phone_code'=>$code));
		  $this->load->model('send_sms');
		  $this->send_sms->send($phone_no,$msg);
		  echo 1; exit;
	  }else{
		  echo 0; exit;
	  }
  }

  public function codeResend(){
		$user_id = $this->session->userdata('user_id');
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		if($user_data){
			$code = rand(1000,9999);
			$msg = "Your verification code is: ".$code." \r\n Tradespeoplehub.co.uk";
			$this->common_model->update("users",array('id'=>$user_data['id']),array('phone_code'=>$code));
			$this->load->model('send_sms');
			$this->send_sms->send($user_data['phone_no'],$msg);
			echo 1; exit;
		}else{
			echo 0; exit;
		}
	}

	public function services(){
		$data['all_services']=$this->common_model->get_all_service('my_services',0);
		$data['categories_data']=$this->getHirarchicalCategoryData();
		$this->load->view('site/all_services',$data);
	}

	public function serviceDetail($slug=""){
		$data['service_details'] = $this->common_model->get_service_details('my_services',$slug);

		$data['is_detail'] = 1;
		if($data['service_details']['status'] != 'active'){
			redirect('/');
		}

		$sId = $data['service_details']['id'];
		$uId = $data['service_details']['user_id'];

		$sDetails = $this->common_model->get_service_details('my_services',$sId);

		$category = $data['service_details']['category'];

		$ip_address = $this->input->ip_address();
		$existViewed = $this->common_model->GetSingleData('recently_viewed_service',['ip_address'=>$ip_address,'service_id'=>$sId]);

		if(empty($existViewed)){
			$insert['ip_address'] = $ip_address;
			$insert['service_id'] = $sId;
			$this->common_model->insert('recently_viewed_service', $insert);		
		}

		$recentlyViews = $this->common_model->get_all_data('recently_viewed_service', array('ip_address' => $ip_address,'service_id !='=>$sId),array(),array(), array(),'service_id');

		$exIds = [0];

		if(!empty($recentlyViews)){
			foreach($recentlyViews as $rview){
				$exIds[] = $rview['service_id'];
			}
		}

		$peopleViews = $this->common_model->get_all_data('recently_viewed_service', array('ip_address !=' => $ip_address),array(),array(), array(),'service_id');

		$exPids = [0];

		if(!empty($peopleViews)){
			foreach($peopleViews as $rview){
				$exPids[] = $rview['service_id'];
			}
		}		

		$data['browse_history']=$this->common_model->getServiceByCategoriesId(($category ?? 0),1,$exIds);
		$data['people_history']=$this->common_model->getServiceByCategoriesId(($category ?? 0),1,$exPids);

		$data['service_images']=$this->common_model->get_service_image('service_images',$sId);
		$data['service_availability'] = $this->common_model->GetSingleData('service_availability',['service_id'=>$sId]);
		$data['service_faqs'] = $this->common_model->get_all_data('service_faqs',['service_id'=>$sId]);
		$data['extra_services'] = $this->common_model->get_all_data('tradesman_extra_service',['service_id'=>$sId]);
		$data['service_rating'] = $this->common_model->getRatingsWithUsers($sId,3);
		$data['service_user'] = $this->common_model->GetSingleData('users',['id'=>$uId]);
		$data['user_profile'] = $this->common_model->get_all_data('user_portfolio',['userid'=>$uId],'','',5);
		$data['rating_percentage'] = $data['service_details']['average_rating'] * 100 / 5;

		$data['package_data'] = !empty($data['service_details']['package_data']) ? json_decode($data['service_details']['package_data']) : [];

		$attributesArray = [];
		foreach ($data['package_data'] as $value) {
		    if (isset($value->attributes)) {
		        $attributesArray = array_merge($attributesArray, $value->attributes);
		    }
		}
		$attributesArray = array_unique($attributesArray);

		$data['attributes'] = $this->common_model->getAttributes($attributesArray);

		$this->load->view('site/service_details',$data);
	}

	public function loadMoreReviews() {
    $service_id = $this->input->post('service_id');
    $limit = $this->input->post('limit');
    $offset = $this->input->post('offset');
    $reviews = $this->common_model->getRatingsWithUsers($service_id, $limit, $offset);
    echo json_encode($reviews);
	}

	public function categoryDetail($slug='', $slug2='', $slug3=''){
		if($slug2 == "" && $slug3 == ""){
			$category = $this->common_model->GetSingleData('service_category',['slug'=>$slug]);
			$step = 1;
		}
		if($slug2 != "" && $slug3 == ""){
			$category = $this->common_model->GetSingleData('service_category',['slug'=>$slug2]);
			$step = 2;
		}
		if($slug3 != ""){
			$category = $this->common_model->GetSingleData('service_category',['slug'=>$slug3]);
			$step = 3;
		}

		if(empty($category)){
			redirect('/');
		}

		$ip_address = $this->input->ip_address();

		$recentlyViews = $this->common_model->get_all_data('recently_viewed_service', array('ip_address' => $ip_address),array(),array(), array(),'service_id');

		$exIds = [];

		if(!empty($recentlyViews)){
			foreach($recentlyViews as $rview){
				$exIds[] = $rview['service_id'];
			}
		}

		$peopleViews = $this->common_model->get_all_data('recently_viewed_service', array('ip_address !=' => $ip_address),array(),array(), array(),'service_id');

		$exPids = [0];

		if(!empty($peopleViews)){
			foreach($peopleViews as $rview){
				$exPids[] = $rview['service_id'];
			}
		}

		$data['breadcrumb'] = $this->common_model->get_breadcrumb('service_category',($category['cat_id'] ?? 0));
		$data['category_details'] = $category;
		$data['services']=$this->common_model->getServiceByCategoriesId(($category['cat_id'] ?? 0),$step);
		$data['browse_history']=$this->common_model->getServiceByCategoriesId(($category['cat_id'] ?? 0),$step,$exIds);
		$data['people_history']=$this->common_model->getServiceByCategoriesId(($category['cat_id'] ?? 0),$step,$exPids);
		$data['step'] = $step;

		$data['categories_data']=$this->getHirarchicalCategoryData();
		$data['faqs'] = $this->common_model->get_faqs('category_faqs',($category['cat_id'] ?? 0));
		$data['first_chiled_categories'] = $this->common_model->getAllChiledCat('service_category',($category['cat_id'] ?? 0));
		$this->load->view('site/home_category_details',$data);
	}

	public function getHirarchicalCategoryData(){
		$allCategory = $this->common_model->get_parent_category('service_category');
		$hirarchicalData = [];
		foreach($allCategory as $data){
			$categoryId = $data['cat_id'] ?? 0;
			if(!$categoryId){
				continue;
			}
			$cData = $this->common_model->getAllChiledCat('category',$categoryId);
			$chileds = [];
			foreach($cData as $chiledData){
				$categoryId = $chiledData['cat_id'] ?? 0;
				if(!$categoryId){
					continue;
				}
				$chiledData['chiled'] = $this->common_model->getAllChiledCat('category',$categoryId); 
				$chileds[] = $chiledData;
			}
			$data['chiled'] = $chileds;
			$hirarchicalData[] = $data;
		}
		return $hirarchicalData;
	}

	public function checkout(){
		$this->load->view('site/checkout');
	}
}