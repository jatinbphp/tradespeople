<?php

include '../con1.php';
    
if(empty($_GET['user_id'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

$user_id = $_GET['user_id'];
 
$check_bank_all=$mysqli->prepare("SELECT first_name,last_name,bank_name,user_account,user_routing,ssn_number,dob_day,dob_month,dob_year,user_token_id FROM stripe_bank_master WHERE user_id=? and delete_flag ='0'");
$check_bank_all->bind_param("i",$user_id);
$check_bank_all->execute();
$check_bank_all->store_result();
$check_bank_all_num=$check_bank_all->num_rows;
if($check_bank_all_num>0){
    $check_bank_all->bind_result($first_name,$last_name,$bank_name,$user_account,$user_routing,$ssn_number,$dob_day,$dob_month,$dob_year,$user_token_id);
    while($check_bank_all->fetch()){
    
    $bank_array[]=array('first_name'=>$first_name,'last_name'=>$last_name,'bank_name'=>$bank_name,'user_account'=>$user_account,'user_routing'=>$user_routing,'ssn_number'=>$ssn_number,'dob_day'=>$dob_day,'dob_month'=>$dob_month,'dob_year'=>$dob_year,'user_token_id'=>$user_token_id);
    
    }	
}

if(empty($bank_array)){
	$bank_array='NA';
}

$record=array('success'=>'true', 'msg' =>array('data found'), 'bank_arr'=>$bank_array);
	echo json_encode($record);
	return false;


?>