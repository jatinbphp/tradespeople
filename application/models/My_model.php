<?php
class My_model extends CI_Model {
	function insert_entry($table, $data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	function alldata_count($table, $where) {
		$query = $this->db->get_where($table, $where);
		return $query->num_rows();
	}
	function common_delete($table, $where) {
		$this->db->where($where);
		return $this->db->delete($table);
	}
	function alldata($table) {
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function alldataorder($table,$order_by,$orderby_field) {
		 
		if (!empty($order_by) && !empty($orderby_field)) 
		{
			$this->db->order_by($orderby_field, $order_by);
		}
		$query = $this->db->get($table);
		return $query->result_array();
	}


	function update_entry($table_name, $data, $where) {
		return $this->db->update($table_name, $data, $where);
	}
	
	function get_entry_by_data($table_name, $single = false, $data = array(), $select = "", $order_by = '', $orderby_field = '', $limit = '', $offset = 0, $group_by = '') 
	{
		
		if (!empty($select)) {
			$this->db->select($select);
		}

		if (empty($data)) { 
			$id = $this->input->post('id');
			if (!$id)
				return false;
				$data = array('id' => $id);
			}
			if (!empty($group_by)) {
				$this->db->group_by($group_by);
			}
			if (!empty($limit)) {
				$this->db->limit($limit, $offset);
			}
			if (!empty($order_by) && !empty($orderby_field)) {
				$this->db->order_by($orderby_field, $order_by);
			}
			
			$query = $this->db->get_where($table_name, $data);
			$res = $query->result_array();

			//echo $this->db->last_query(); exit;

			if (!empty($res)) {

				if ($single)
					return $res[0];
				else
					return $res;
			} else
				return false;
	} 
	public function get_data_by_join($table, $table2, $where, $table1_column, $table2_column, $limit = '', $order_column = '', $order_by = 'DESC', $select_columns = '', $is_single_record = false, $group_by = '', $join_by = '', $offset = '')
	{
		if (!empty($select_columns)) {
			$this->db->select($select_columns);
		} else {
			$this->db->select('*');
		}

		$this->db->from($table);
		$this->db->join($table2, $table . '.' . $table1_column . '=' . $table2 . '.' . $table2_column, $join_by);
		$this->db->where($where);
		if (!empty($limit)) {
			if (!empty($offset)) {
				$this->db->limit($limit, $offset);
			} else {
				$this->db->limit($limit);
			}
		}
		if (!empty($order_column)) {
			$this->db->order_by($order_column, $order_by);
		}

		if (!empty($group_by)) {
			$this->db->group_by($group_by);
		}

		$query = $this->db->get();
		if ($query->num_rows() > 0) {

			if ($is_single_record) {
				$rs = $query->result_array();
				return $rs[0];
			} else {
				return $query->result_array();
			}
		} else {
			return false;
		}
	}

	function alldata_custom($table, $where) {
		$this->db->where($where);
		$query = $this->db->get($table);
		return $query;
	}
		function send_emails($toz,$sub,$body)
	{
		$to =$toz;	
		$from = EMAIL_ID;
		$headers ="From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$subject =$sub;
		$msg = '<body style="margin:0px;">						<table style="background-color:#f8f8f8;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%" bgcolor="#f8f8f8">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">					</td>					<td  style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;background:#ffffff;display:block;margin:0 auto!important;max-width:600px;width:600px;padding:0" width="600" valign="top">					<div style="display:block;margin:0 auto;max-width:600px;padding:0;background:#ffffff">					<div>					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:10px 0 10px 0;color:#ffffff;margin-top:20px;width:100%;border-bottom:none;background-color:#083b66;margin-bottom:30px" width="100%" valign="top" bgcolor="#f8f8f8">					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="center">					<img src="'.base_url().'asset/site/img/logo.png" style="max-width:100%;margin:6px 0 0 21px;" width="140"></td>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="right"> </td>					</tr>					</tbody>					</table>					</td>					</tr>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">	<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:30px" valign="top">'.$body.'
										<br>
										
										</td>					</tr>					</tbody>					</table>								</td>					</tr>					</tbody>					</table>					</div>					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr style="display:block;margin:0 auto; background:#083b66;color:#ffffff;margin-top:20px;font-size:16px"><td style="width:100%"><p style="text-align: center;padding-top: 12px;"> © Copyright 2019 Outboxmaster. All Rights Reserved. 
</p>	</td>				<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;width:50%" width="50%" valign="top">					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>								<tr><td></td></tr>		</tbody>					</table>					</td>					</tr>					</tbody>					</table>					</div>					</td>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">					</td>					</tr>					</tbody>					</table>					</body>';
		if(mail($to,$subject,$msg,$headers))
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
	}
	
	public function SendEmail($to_email,$subject,$body){
	
		$from_email='info@bluediamondresearch.com';
                 //$to_email=$this->input->post('email');
		$this->email->from($from_email, 'outboxmaster'); 
		$this->email->to($to_email);  
		$this->email->subject($subject); 
		$this->email->message(
		 '<body style="margin:0px;">						<table style="background-color:#f8f8f8;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%" bgcolor="#f8f8f8">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">					</td>					<td  style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;background:#ffffff;display:block;margin:0 auto!important;max-width:600px;width:600px;padding:0" width="600" valign="top">					<div style="display:block;margin:0 auto;max-width:600px;padding:0;background:#ffffff">					<div>					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:10px 0 10px 0;color:#ffffff;margin-top:20px;width:100%;border-bottom:none;background-color:#083b66;margin-bottom:30px" width="100%" valign="top" bgcolor="#f8f8f8">					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="center">					<img src="'.base_url().'asset/site/img/logo.png" style="max-width:100%;margin:6px 0 0 21px;" width="140"></td>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="right"> </td>					</tr>					</tbody>					</table>					</td>					</tr>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">	<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:30px" valign="top">'.$body.'
										<br>
										
										</td>					</tr>					</tbody>					</table>								</td>					</tr>					</tbody>					</table>					</div>					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>					<tr style="display:block;margin:0 auto; background:#083b66;color:#ffffff;margin-top:20px;font-size:16px"><td style="width:100%"><p style="text-align: center;padding-top: 12px;"> © Copyright 2019 Outboxmaster. All Rights Reserved. 
</p>	</td>				<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;width:50%" width="50%" valign="top">					<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">					<tbody>								<tr><td></td></tr>		</tbody>					</table>					</td>					</tr>					</tbody>					</table>					</div>					</td>					<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">					</td>					</tr>					</tbody>					</table>					</body>'
		 );
		 if($this->email->send()){
			 return 1;  
		 }else{
            return 0;
		 }		    
		   
		
	}
	public function get_all_category($table)
	{
		$query=$this->db->query("Select * from $table where is_delete=0");
      return $query->result_array();
	}
	public function get_all_category1($table)
	{
				$query=$this->db->query("Select * from $table where is_delete=0 order by cat_id asc");
      return $query->result_array();
	}


	
	
	public function get_unread_support_msg_count($userType=''){
		$queries1_count =0;
		$queries2_count =0;
		if($userType==3){
			$queries = $this->db->query("SELECT admin_chat_details.sender_id , admin_chat_details.is_read FROM `admin_chat_details` join users on users.id = admin_chat_details.sender_id where users.type=$userType and admin_chat_details.is_read=0 and admin_chat_details.is_admin=0");
			if($queries->num_rows() > 0){
	        	$d= $queries->result_array();
				return count($d);
	        }
		}else{
			$queries1 = $this->db->query("SELECT admin_chat_details.sender_id , admin_chat_details.is_read FROM `admin_chat_details` join users on users.id = admin_chat_details.sender_id where users.type=1 and admin_chat_details.is_read=0 and admin_chat_details.is_admin=0");
			if($queries1->num_rows() > 0){
	        	$d1= $queries1->result_array();
				$queries1_count = count($d1);
	        }
			$queries2 = $this->db->query("SELECT admin_chat_details.sender_id , admin_chat_details.is_read FROM `admin_chat_details` join users on users.id = admin_chat_details.sender_id where users.type=2 and admin_chat_details.is_read=0 and admin_chat_details.is_admin=0");
			if($queries2->num_rows() > 0){
	        	$d2= $queries2->result_array();
	        	$queries2_count = count($d2);
	        }
	    	return $queries1_count+$queries2_count;
		}
	}
}   
?>