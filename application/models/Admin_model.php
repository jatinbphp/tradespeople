<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model{
	
	function get_transaction_history($table){
		$this->db->select("$table.*,user_tbl.f_name,user_tbl.l_name");
		$this->db->order_by("$table.id", "desc");
		$this->db->join("user_tbl", "user_tbl.id = $table.user_id");
        $query = $this->db->get($table);
        return $query->result_array();
    }
    /*
	
	function check_email_availablity()
  {
        $email_address = $this->input->post('email');
        $this->db->where('email', $email_address);
       $result = $this->db->get('user_tbl');

       if($result->num_rows() > 0){   
        return false;
      }else{
       return true;
    }
	
  } */
    function check_email_availablity($email)
  {
        $this->db->where('email', $email);
       $result = $this->db->get('users');

       if($result->num_rows() > 0){   
        return $result->row_array();
      }else{
        //return $result->row_array();
       return 0;
    } 
  
  }
  function get_parent_cat($id)
  {
      $result=array();
    $sql="SELECT * from category where cat_parent='$id' and is_delete=0";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }
    function get_parent_cates($table,$id)
  {
      $result=array();
    $sql="SELECT * from $table where cat_id='$id' and is_delete=0";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }
  function get_parent_cates1($table,$id)
  {
      $result=array();
    $sql="SELECT * from $table where cat_id='$id' ";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }
  function get_all_category()
  {
      $result=array();
    $sql="SELECT * from category order by cat_id desc";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }
  function get_trades_request()
  {
    $result=array();
    $sql="SELECT * from contact_request where type=1 order by id desc";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }
  function get_home_request()
  {
      $result=array();
    $sql="SELECT * from contact_request where type=2 order by id desc";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }

  function get_marketer_request()
  {
    $result=array();
    $sql="SELECT * from contact_request where type=3 order by id desc";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }

	function get_user_rewards()
  {
    $result=array();
    $sql="SELECT * from transactions where tr_reward=1 order by tr_id desc";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    return $result;
  }

}
	?>