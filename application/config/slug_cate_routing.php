<?php
$my_my_sq_li_con = mysqli_connect("localhost","root","","tradespeoplehub");

$my_my_route_sql = "select slug from category where is_delete = 0";

$my_my_route_run = mysqli_query($my_my_sq_li_con,$my_my_route_sql);

if(mysqli_num_rows($my_my_route_run)>0){
	while($my_my_route_row = mysqli_fetch_assoc($my_my_route_run)){
		$route[$my_my_route_row['slug']]='search/find_tradesman/$1';
		$route['find-jobs/'.$my_my_route_row['slug']]='search/index/$1';
	}
}


$my_my_route_sql = "select slug from local_category";

$my_my_route_run = mysqli_query($my_my_sq_li_con,$my_my_route_sql);

if(mysqli_num_rows($my_my_route_run)>0){
	while($my_my_route_row = mysqli_fetch_assoc($my_my_route_run)){
		$route[$my_my_route_row['slug']]='search/find_tradesman/$1';
		//$route['find-jobs/'.$my_my_route_row['slug']]='search/index/$1';
	}
}

?>