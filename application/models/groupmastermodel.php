<?php

class groupmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function groupmasterlist()
	{
       $this -> db -> select   ('group_name.id as gid,
								group_name.name as gname,
								group_master.is_special,
								subgroup_name.id as sgid,
								subgroup_name.name as sgname,
								group_category.id as cid,
								group_master.id as gmid,
								group_master.group_name as gmname');
	   $this -> db -> from('group_master');
	   $this->db->join('group_category', 'group_master.group_category_id = group_category.id','INNER');
	   $this->db->join('group_name', 'group_category.group_name_id = group_name.id','INNER');
	   $this->db->join('subgroup_name', 'group_category.sub_group_name_id = subgroup_name.id','INNER');
	   $this->db->order_by('group_master.group_name');

	
	   $query = $this -> db -> get();
	
	   if($query -> num_rows() > 0)
	   {
		
		 foreach($query->result() as $rows){
			$data[] = $rows;
		 }
			return $data;
	   }
	   else
	   {
		 return false;
	   }
    }


    // Getting Groups without Sundry Debtors,Sundry Creditors
    public function grouplistWithoutDebtors()
	{
	   $debtors_id  = array(1,2);
       $this -> db -> select('group_name.id as gid,
								group_name.name as gname,
								group_master.is_special,
								subgroup_name.id as sgid,
								subgroup_name.name as sgname,
								group_category.id as cid,
								group_master.id as gmid,
								group_master.group_name as gmname');
	   $this -> db -> from('group_master');
	   $this->db->join('group_category', 'group_master.group_category_id = group_category.id','INNER');
	   $this->db->join('group_name', 'group_category.group_name_id = group_name.id','INNER');
	   $this->db->join('subgroup_name', 'group_category.sub_group_name_id = subgroup_name.id','INNER');
	   $this->db->where_not_in('group_master.id', $debtors_id);
	   $this->db->order_by('group_master.group_name');

	
	   $query = $this -> db -> get();
	
	   if($query -> num_rows() > 0)
	   {
		
		 foreach($query->result() as $rows){
			$data[] = $rows;
		 }
			return $data;
	   }
	   else
	   {
		 return false;
	   }
    }
	
/*	function checkExistance($value)
	{
		
		 $this -> db -> select('*');
	   	 $this -> db -> from('group_master');
		 $this -> db -> where('group_category_id', $value['group_category_id']);
	  		 
		 $count =  $this->db->count_all_results();	
		 return $count;
	}*/
	
	function add($value)
	{
			
			$this->db->trans_begin();
			$this->db->insert('group_master', $value);
			$insertpatient = $this->db->insert_id();
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
			}
			return  $insertpatient;
		
	}
	
	function modify($value)
	{
	 if (isset($value['id'])) {
		 
		 
		
			$this->db->trans_begin();
			$this->db->where('id', $value['id']);
			$this->db->update('group_master',$value); 
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
			}
			return 0;
		
   	 }
	}
	
	function delete($value)
 	 {
		$this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('group_master'); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		
		$errorno = $this->db->_error_number();
		if($errorno > 0)
		{
			return 0;	
		}
		else
		{
			return 1;	
		}
 	 }

 	 public function getGroupnameById($groupID){
 	 	$row = [];
 	 	$query = $this->db->select("*")->from('group_master')->where('group_master.id',$groupID)->get();

 	 	 if($query->num_rows()>0){
            $row = $query->row();
           }
           return $row;

 	 }


	
}
?>