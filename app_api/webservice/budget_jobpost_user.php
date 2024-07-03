<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}
 	

	$budget_arr = array();

	//-------------------------- get county --------------------------
	// echo "SELECT cat_id, cat_name, slug, cat_parent, cat_description, description, cat_image, meta_title, meta_description FROM category WHERE cat_parent=$cat_parent and is_delete=0 and is_activate=1 order by cat_name asc";
	$getbudget=$mysqli->prepare("SELECT id, amount1, amount2 FROM job_amount");
	$getbudget->execute();
	$getbudget->store_result();
	$getbudget_count=$getbudget->num_rows;  //0 1	
	if($getbudget_count > 0){
		$getbudget->bind_result($id, $amount1, $amount2);
		while ($getbudget->fetch()) {
			$budget_arr[] = array(
				'id'=>$id, 
				'amount1'=>$amount1, 
				'amount2'=>$amount2, 
				'status'=>false,
				'other'=>false,			
			);
		}
	}

	if(empty($budget_arr)){
		$budget_arr = "NA";
	} 
 
	$record=array('success'=>'true','msg'=>$data_found,'budget_arr'=>$budget_arr); 
	jsonSendEncode($record);

?>