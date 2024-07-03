<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}
 	if(empty($_GET['cat_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
 	
    $cat_parent			 	    =	$_GET['cat_id'];
    $job_id = 0;
    if(isset($_GET['job_id'])){
		$job_id =$_GET['job_id'];
    }
    $category_ids = array();
    if($job_id>0){
    	$where='job_id='.$job_id;
		$category_i  =   getSingleData('subcategory_1','tbl_jobs',$where);
		if(!is_null($category_i)){
			$category_ids = explode(",",$category_i);
		}
    }

	$cat_arr = array();

	//-------------------------- get county --------------------------
	// echo "SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=$cat_parent and is_delete=0 and is_activate=1 order by cat_name asc";
	$getCounty=$mysqli->prepare("SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=? and is_delete=0 and is_activate=1 order by cat_name asc");
	$getCounty->bind_param("i",$cat_parent);
	$getCounty->execute();
	$getCounty->store_result();
	$getCounty_count=$getCounty->num_rows;  //0 1	
	if($getCounty_count > 0){
		$getCounty->bind_result($cat_id, $cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);
		
		while ($getCounty->fetch()) {
			$status1 = false;
		if(in_array($cat_id, $category_ids)){
			$status1 = true;
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
				'status'=>$status1,
			);
		}
	}

	if(empty($cat_arr)){
		$cat_arr = "NA";
	} 
 
	$record=array('success'=>'true','msg'=>$data_found,'cat_arr'=>$cat_arr,'category_ids'=>$category_ids); 
	jsonSendEncode($record);

?>