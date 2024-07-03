
<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	
	$bid_id     				= $_GET['bid_id'];
	$key = 'created_by=858';
					$where = 'id=527';
					$update_milestone1_affect_row = updatesingledata($key, 'tbl_milestones', $where);
echo $update_milestone1_affect_row;