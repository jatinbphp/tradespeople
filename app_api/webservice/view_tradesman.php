<?php	

	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';

if(!$_GET){
$record=array('success'=>'false', 'msg' =>$msg_get_method); 
jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
jsonSendEncode($record); 
}
if(empty($_GET['tradesman_id'])){
$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
jsonSendEncode($record); 
}
$trades_man = array();
$userid			   	    =	$_GET['user_id'];
$tradesman_id			 =	$_GET['tradesman_id'];


//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();
//-------------------------------------------------------------------------

	
//----------------------------trades man----------------------------------------------------------------------
$trades_man=array();
$gettradesman=$mysqli->prepare("SELECT id,f_name,l_name,profile,about_business,e_address FROM users  where id=?");
$gettradesman->bind_param("i",$tradesman_id);
$gettradesman->execute();
$gettradesman->store_result();
$gettradesman_count=$gettradesman->num_rows;  //0 1	
if($gettradesman_count > 0){
$gettradesman->bind_result($id, $f_name, $l_name, $profile,$about_business,$e_address);
while ($gettradesman->fetch()) {
	$portfolio=getPortfolio($id);
	$trades_man = array(
		'id'=>$id, 
		'f_name'=>$f_name, 
		'l_name'=>$l_name, 
		'profile'=>$profile, 
		'about_business'=>$about_business,
		'address'=>$e_address,
		'portfolio'=>$portfolio

		
	);
}
}

$rating_arr=array();
$rating_arr=getReview($tradesman_id);
//------------------------------------------------------------------------------------------------------------
if(empty($trades_man)){
$trades_man = "NA";
} 
if(empty($rating_arr)){
$rating_arr = "NA";
} 



	$record=array('success'=>'true','msg'=>$data_found,'tradesman_arr'=>$trades_man,'rating_arr'=>$rating_arr); 

	jsonSendEncode($record);



?>