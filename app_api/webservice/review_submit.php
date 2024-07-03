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
if(empty($_GET['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$user_id	 =	    $_GET['user_id'];
$job_id		 =	    $_GET['job_id'];
$posted_by   = 		$_GET['posted_by'];
$bid_by      =  	$_GET['bid_by'];
$rt_rate     =      $_GET['rt_rate'];
$rt_comment  =      $_GET['rt_comment'];

if($user_id==$posted_by){
 	$userid1=$posted_by;
 	$bid_by1=$bid_by;
}else{
 	$userid1=$bid_by;
 	$bid_by1=$posted_by;
}

$add_rating = $mysqli->prepare("INSERT INTO `rating_table`(`rt_rateBy`, `rt_rateTo`,  `rt_jobid`, `rt_rate`, `rt_comment`, `rt_create`) VALUES (?,?,?,?,?,?)");
$add_rating->bind_param('ssssss',$userid1,$bid_by1,$job_id,$rt_rate,$rt_comment,date('Y-m-d H:i:s'));
$add_rating->execute();
$add_ratingcount=$mysqli->affected_rows;
if($add_ratingcount<=0){
	$record=array('success'=>'true', 'msg' =>array("Something went worng","Something went worng")); 
	jsonSendEncode($record); 
}
 
$check_user_all	=	$mysqli->prepare("SELECT total_reviews,u_wallet,spend_amount from users where id=?");
$check_user_all->bind_param("i",$bid_by1);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($total_reviews,$u_wallet,$spend_amount);
$check_user_all->fetch();
$avg_rate = getRatingAverage($bid_by1);
$total_reviews = $total_reviews+1;

// update==============================
$update_useer = $mysqli->prepare("UPDATE `users` SET total_reviews=?,average_rate=?  WHERE id=?");
$update_useer->bind_param("ssi",$total_reviews,$avg_rate,$bid_by1);	
$update_useer->execute();
$update_useer_affect_row=$mysqli->affected_rows;
if($update_useer_affect_row<=0){
	// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
	// jsonSendEncode($record);
}

$record=array('success'=>'true','msg'=>array("Review added successfully")); 
jsonSendEncode($record);