<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ExportImport extends CI_Controller {
	
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
	
	public function export($type){
		
		$seleceted_users = (isset($_REQUEST['seleceted_users']) && !empty($_REQUEST['seleceted_users']))?$_REQUEST['seleceted_users']:'';

		if($type==1){
			$filename = "tradesman_" . date('Y-m-d') . ".csv";
			
			$fields = array('ID', 'First Name', 'Last Name', 'Trading Name', 'Phone No', 'Email', 'Address', 'Country', 'City', 'Postal Code','Profile Image', 'Wallet Amount', 'About Bussiness');
			
		} else {
			$filename = "homeowners_" . date('Y-m-d') . ".csv";
			
			$fields = array('ID', 'First Name', 'Last Name', 'Phone No', 'Email', 'Address', 'Country', 'City', 'Postal Code','Profile Image', 'Wallet Amount');
		}
		
		$delimiter = ","; 
		
		$f = fopen('php://memory', 'w'); 
		fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		
		
		
		
		fputcsv($f, $fields, $delimiter); 
		
		$where = "type = '".$type."'";
		
		if($seleceted_users && count($seleceted_users)){
			$where .= " and id in (".$seleceted_users.")";
		}
		
		$users = $this->Common_model->get_all_data('users',$where,'id');
		
		if(count($users) > 0){
			foreach($users as $row){
	
				$image = ($row['profile'])?site_url().'img/profile/'.$row['profile']:'';
				
				if($type==1){
					
				$lineData = array($row['unique_id'], $row['f_name'], $row['l_name'], $row['trading_name'], $row['phone_no'], $row['email'], $row['e_address'], $row['county'], $row['city'], $row['postal_code'], $image, $row['u_wallet'], strip_tags($row['about_business']));
				
				}else{
					
				$lineData = array($row['unique_id'], $row['f_name'], $row['l_name'], $row['phone_no'], $row['email'], $row['e_address'], $row['county'], $row['city'], $row['postal_code'], $image, $row['u_wallet']);
					
				}
				
        fputcsv($f, $lineData, $delimiter); 
			}
		}
		
		fseek($f, 0);
		
		 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		// Output all remaining data on a file pointer 
		fpassthru($f); 
		 
		// Exit from file 
		exit();
		
		
		
	}
}