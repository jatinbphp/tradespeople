<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LocationLocalCategory extends CI_Model{
    
    function __construct() {
        // Set table name
        $this->table = 'location_local_category';
        // Set orderable column fields
        $this->column_order = array(null, 'cat_name','title','description','keyword','meta','footer_description','slug','location');
        // Set searchable column fields
        $this->column_search = array('cat_name','keyword','description',);
        // Set default order
        $this->order = array('cat_id' => 'asc');
    }
    
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData,$main=false){
        $this->_get_datatables_query($postData,$main);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /*
     * Count all records
     */
   public function countAll($main=false){
        $this->db->from($this->table);
				
		      if($main){
					$my_where['cat_parent'] = 0;
                    $this->db->where($my_where);
				}
		
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData,$main=false){
        $this->_get_datatables_query($postData,$main);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData,$main=false){
         
        $this->db->from($this->table);
				
			if($main){
					$my_where['cat_parent'] = 0;
                    $this->db->where($my_where);
				}
				
        
				
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if(isset($postData['search']['value'])){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

}