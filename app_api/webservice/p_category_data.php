<?php	

	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';

	

	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}

 	$page_name = "NA";
 	if(isset($_GET['page_name'])){
 		$page_name = $_GET['page_name'];
 	}
	$check_flag = 'NA';
	if(isset($_GET['check_flag'])){
 		$check_flag = $_GET['check_flag'];
 	}
	
	$b1 = 0;
	if(isset($_GET['b1'])){
 		$b1 = $_GET['b1'];
 	}
	$b2 = 0;
	if(isset($_GET['b2'])){
 		$b2 = $_GET['b2'];
 	}


$budget_arr = array();
$custom_budget=true;
if($check_flag!='NA'){
	//-------------------------- get county --------------------------
	$getbudget=$mysqli->prepare("SELECT id, amount1, amount2 FROM job_amount");
	$getbudget->execute();
	$getbudget->store_result();
	$getbudget_count=$getbudget->num_rows;  //0 1	
	if($getbudget_count > 0){
		$getbudget->bind_result($id, $amount1, $amount2);
		while ($getbudget->fetch()) {
			$status = false;
			if($b1==$amount1 && $b2==$amount2){
				$status=true;
				$custom_budget=false;
			}
			$budget_arr[] = array(
				'id'=>$id, 
				'amount1'=>$amount1, 
				'amount2'=>$amount2, 
				'type'=>'static',
				'status'=>$status,
			);
		}
	}
}













	$cat_arr = array();
	//-------------------------- get county --------------------------

	if($page_name!='NA'){
		$cat_arr1 = explode(",",$_GET['cat_id']);
		$subcat_id1 = explode(",",$_GET['subcat_id']);
		$getCounty=$mysqli->prepare("SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=0 and is_delete=0 and is_activate=1 order by cat_name asc");
		$getCounty->execute();
		$getCounty->store_result();
		$getCounty_count=$getCounty->num_rows;  //0 1	
		if($getCounty_count > 0){
			$getCounty->bind_result($cat_id, $cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);
			while ($getCounty->fetch()) { 
				$subcat_arr = array();
				$get_sub_cat=$mysqli->prepare("SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=$cat_id and is_delete=0 and is_activate=1 order by cat_name asc");
				$get_sub_cat->execute();
				$get_sub_cat->store_result();
				$get_sub_cat_count=$get_sub_cat->num_rows;  //0 1	
				$sub_cat_other_arr = array();
				if($get_sub_cat_count > 0){
					$get_sub_cat->bind_result($sub_cat_id, $sub_cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);
					while ($get_sub_cat->fetch()) {
						$status1 = false;
						if(in_array($sub_cat_id, $subcat_id1)){
							$status1 = true;
						}
						$subcat_nameee = trim($sub_cat_name);
						if(strtolower($subcat_nameee)=='other' || strtolower($subcat_nameee)=='others'){
							$sub_cat_other_arr = array(
								'sub_cat_id'=>$sub_cat_id, 
								'sub_cat_name'=>$sub_cat_name, 
								'slug'=>$slug, 
								'cat_parent'=>$cat_parent, 
								'cat_description'=>$cat_description, 
								'cat_image'=>$cat_image, 
								'meta_title'=>$meta_title, 
								'meta_description'=>$meta_description, 
								'status'=>$status1,
							);
						}
						if(strtolower($subcat_nameee)!='other' && strtolower($subcat_nameee)!='others'){
							$subcat_arr[] = array(
								'sub_cat_id'=>$sub_cat_id, 
								'sub_cat_name'=>$sub_cat_name, 
								'slug'=>$slug, 
								'cat_parent'=>$cat_parent, 
								'cat_description'=>$cat_description, 
								'cat_image'=>$cat_image, 
								'meta_title'=>$meta_title, 
								'meta_description'=>$meta_description, 
								'status'=>$status1,
							);
						}
					}
				}
				
				if(!empty($sub_cat_other_arr)){
					$subcat_arr[] = $sub_cat_other_arr;
				}

				$status = false;
				if(in_array($cat_id, $cat_arr1)){
					$status = true;
				}
				 
				$cat_arr[] = array(
					'cat_id'=>$cat_id, 
					'cat_name'=>$cat_name, 
					'slug'=>$slug, 
					'cat_parent'=>$cat_parent, 
					'cat_description'=>$cat_description, 
					'cat_image'=>$cat_image, 
					'meta_title'=>$meta_title, 
					'meta_description'=>$meta_description, 
					'status'=>$status,
					'subcat_arr'=>$subcat_arr,
				);
			}
		}
	}else{
		$getCounty=$mysqli->prepare("SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=0 and is_delete=0 and is_activate=1 order by cat_name asc");
		$getCounty->execute();
		$getCounty->store_result();
		$getCounty_count=$getCounty->num_rows;  //0 1	
		if($getCounty_count > 0){
			$getCounty->bind_result($cat_id, $cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);

			while ($getCounty->fetch()) {
				$cat_arr[] = array(
					'cat_id'=>$cat_id, 
					'cat_name'=>$cat_name, 
					'slug'=>$slug, 
					'cat_parent'=>$cat_parent, 
					'cat_description'=>$cat_description, 
					'cat_image'=>$cat_image, 
					'meta_title'=>$meta_title, 
					'meta_description'=>$meta_description, 
					'status'=>false,
				);
			}
		}
	}


	if(empty($cat_arr)){
		$cat_arr = "NA";
	} 
	if(empty($budget_arr)){
		$budget_arr = "NA";
	} 

	$record=array('success'=>'true','msg'=>$data_found,'cat_arr'=>$cat_arr,'budget_arr'=>$budget_arr,'custom_budget'=>$custom_budget); 
	jsonSendEncode($record);
?>