<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_model extends CI_Model{
	
	public function get_rating($params = array())
	{
		//print_r($params);
		$where = "where rt_rateTo = '".$params['search']['userid']."'";
		
		$limtss = "";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limtss = " LIMIT ".$params['start'].", ".$params['limit'];
		}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limtss = " LIMIT ".$params['limit'];
		}
		
		$sql = "SELECT * FROM rating_table ".$where." order by tr_id desc ".$limtss;
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		return ($query->num_rows() > 0)?$query->result_array():array();
	}
	public function getRows($params = array())
	{
		//print_r($params);
		
		$comm_query=$this->db->query("SELECT closed_date FROM `admin` where id=1");
		$get_commision = $comm_query->row_array();
		
		$closed_date=$get_commision['closed_date'];
				
		$today = date('Y-m-d');
				
		$datesss= date('Y-m-d', strtotime($today. ' - '.$closed_date.' days'));
		
		$where = "where (tbl_jobs.status=1 or tbl_jobs.status=2 or tbl_jobs.status=3 or tbl_jobs.status=8) and tbl_jobs.direct_hired != 1 and tbl_jobs.is_delete=0 and DATE(c_date) > DATE('".$datesss."')";
		if(isset($params['search']['amount1']) && !empty($params['search']['amount1'])){
			$where .= " and budget >= '".$params['search']['amount1']."'";
		}
		if(isset($params['search']['amount2']) && !empty($params['search']['amount2'])){
			$where .= " and budget <= '".$params['search']['amount2']."'";
		}

		if(isset($params['search']['category_id']) && !empty($params['search']['category_id'])){
			//$where .= " and FIND_IN_SET(".$params['search']['category_id'].", tbl_jobs.category)";
			$where .= " and tbl_jobs.category = ".$params['search']['category_id']; 
		}	
		if(isset($params['search']['city']) && !empty($params['search']['city'])){
			$where .= " and tbl_jobs.city = '".$params['search']['city']."'";
		}
		if(isset($params['search']['location']) && !empty($params['search']['location'])){
		
			$location = $params['search']['location']; 
			$where .= " and (users.county like '%".$location."%' || users.city like '%".$location."%')";
		}	
		if(isset($params['search']['search1']) && !empty($params['search']['search1'])){
			
			$search1 = $params['search']['search1']; 
			$where .= " and ((select count(cat_id) from category where (category.cat_id in (tbl_jobs.category) OR category.cat_id in (tbl_jobs.subcategory)) and cat_name like '%".$search1."%') > 0 || title  like '%".$search1."%' || description  like '%".$search1."%' || budget  like '%".$search1."%' || e_address  like '%".$search1."%' || post_code  like '%".$search1."%')"; 
		}

		$limtss = "";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			
				//$this->db->limit($params['limit'],$params['start']);
				$limtss = " LIMIT ".$params['start'].", ".$params['limit'];

				
		}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
				//$this->db->limit($params['limit']);
				$limtss = " LIMIT ".$params['limit'];
		}
		//$sql = "SELECT * FROM tbl_jobs JOIN users ON (users.id = tbl_jobs.userid) JOIN tbl_region ON (tbl_region.id = users.county)  ".$where." order by tbl_jobs.job_id desc ".$limtss;
		$sql = "SELECT * FROM tbl_jobs JOIN users ON (users.id = tbl_jobs.userid) ".$where." order by tbl_jobs.job_id desc ".$limtss;
		$query=$this->db->query($sql);
		// echo $this->db->last_query();
		return ($query->num_rows() > 0)?$query->result_array():array();
		
	}
	public function getJobCities()
	{
		$this->db->select('city')->distinct("city");
		$this->db->where("city !=", '');
		$query = $this->db->get('tbl_jobs');
		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		}
	}
	
	public function get_tradesmem($params = array())
	{
		//print_r($params);
		$where = "where type = 1 and status = 0 and u_email_verify = 1";
		
		if(isset($params['search']['amount1']) && !empty($params['search']['amount1'])){
			$where .= " and hourly_rate >= '".$_REQUEST['amount1']."'";
		}
		if(isset($params['search']['amount2']) && !empty($params['search']['amount2'])){
			$where .= " and hourly_rate <= '".$_REQUEST['amount2']."'";
		}

		if(isset($params['search']['rating']) && !empty($params['search']['rating'])){
			$where .= " and average_rate >= '".$_REQUEST['rating']."'"; 
		}	
		if(isset($params['search']['cate_id']) && !empty($params['search']['cate_id'])){
			$main = $this->common_model->GetSingleData('category' , array('cat_id' =>$params['search']['cate_id'] ));
			if ($main['cat_parent'] == 0 ) {
				$where .= " and FIND_IN_SET(".$params['search']['cate_id'].", category) ";
			}
			else
			{
				$where .= " and FIND_IN_SET(".$main['cat_parent'].", category) ";
			}
			
		}	
		if(isset($params['search']['location']) && !empty($params['search']['location'])){
			$where .= " and (users.e_address like '%".$params['search']['location']."%' || users.county like '%".$params['search']['location']."%' || users.city like '%".$params['search']['location']."%' || users.postal_code like '%".$params['search']['location']."%')";
		}
		if(isset($params['search']['city_name']) && !empty($params['search']['city_name'])){
			$where .= " and users.city like '%".$params['search']['city_name']."%'";
		}
		if(isset($params['search']['search']) && !empty($params['search']['search'])){
			$where .= " and ((select count(cat_id) from category where (category.cat_id in (users.category) OR category.cat_id in (users.subcategory)) and cat_name like '%".$_REQUEST['search']."%') > 0 || (select count(id) from tbl_region where tbl_region.id = users.county and region_name like '%".$_REQUEST['search']."%') > 0 || (select count(id) from tbl_city where tbl_city.id = users.city and city_name like '%".$_REQUEST['search']."%') > 0 || f_name  like '%".$_REQUEST['search']."%' || l_name  like '%".$_REQUEST['search']."%' || trading_name  like '%".$_REQUEST['search']."%' || about_business  like '%".$_REQUEST['search']."%' || postal_code  like '%".$_REQUEST['search']."%' || profile_summary  like '%".$_REQUEST['search']."%' || professional_head  like '%".$_REQUEST['search']."%' || company  like '%".$_REQUEST['search']."%' || e_address  like '%".$_REQUEST['search']."%')";
		}
		
		/*if($this->session->userdata('user_id')){
      $user = $this->common_model->get_coloum_value('users',array('id'=>$this->session->userdata('user_id')),array('postal_code'));
      //$postal_code = str_replace(" ","",$user['postal_code']);
      $where .= " and postal_code = '".$user['postal_code']."'";
    }*/

		$limtss = "";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			
				$limtss = " LIMIT ".$params['start'].", ".$params['limit'];

		}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			
				$limtss = " LIMIT ".$params['limit'];
		}
		
		
		$sql = "select * from users ".$where." order by (select tr_id from rating_table where rating_table.rt_rateTo = users.id order by tr_id desc limit 1) desc ".$limtss;

		$query=$this->db->query($sql);
		
		return ($query->num_rows() > 0)?$query->result_array():array();
		
	}

}