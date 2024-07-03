<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}



$county_arr = array();
//-------------------------- get county --------------------------
$getCounty=$mysqli->prepare("SELECT `id`, `region_name` FROM `tbl_region` WHERE is_delete=0");
$getCounty->execute();
$getCounty->store_result();
$getCounty_count=$getCounty->num_rows;  //0 1	
if($getCounty_count > 0){
	$getCounty->bind_result($id, $county_name);
	while ($getCounty->fetch()) {
		$county_arr[] = array(
			'id'=>$id, 
			'county_name'=>$county_name, 
			'status'=>false,
		);
	}
}	

if(empty($county_arr)){
	$county_arr = "NA";
} 


$cat_arr = array();

//-------------------------- get county --------------------------
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
			'subcat_arr'=>$subcat_arr
		);
	}
}

if(empty($cat_arr)){
	$cat_arr = "NA";
} 

$record=array('success'=>'true','msg'=>$data_found,'county_arr'=>$county_arr,'cat_arr'=>$cat_arr); 
jsonSendEncode($record);

?>