<?php
class accountmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function accountlist($session_data)
	{
        
        /*
       $this -> db -> select('account_master.id AS amid,
			     account_master.group_master_id,
			     account_master.account_name,
			     account_master.is_special,
			     account_opening_master.id AS aomid,
			     account_opening_master.opening_balance,financialyear.year,
                 group_master.group_name');
	   $this -> db -> from('account_master');
       $this->db->join('account_opening_master', 'account_opening_master.account_master_id = account_master.id AND account_opening_master.financialyear_id='. $session_data['yearid'],'LEFT');
	   $this->db->join('group_master', 'account_master.group_master_id = group_master.id','LEFT');
       $this->db->join('financialyear','account_opening_master.financialyear_id = financialyear.id');
	   $this->db->where('account_master.company_id', $session_data['company']);
       $this->db->order_by('account_master.account_name', "asc");
	   */
	   
	   $this -> db -> select('account_master.id AS amid,
			     account_master.group_master_id,
			     account_master.account_name,
			     account_master.is_special,
			     account_opening_master.id AS aomid,
			     account_opening_master.opening_balance,
				 group_master.group_name');
	   $this -> db -> from('account_master');
       $this->db->join('account_opening_master', 'account_opening_master.account_master_id = account_master.id AND account_opening_master.financialyear_id='. $session_data['yearid'],'LEFT');
	   $this->db->join('group_master', 'account_master.group_master_id = group_master.id','LEFT');
      // $this->db->join('financialyear','financialyear.id= 8');
	   $this->db->where('account_master.company_id', $session_data['company']);
       $this->db->order_by('account_master.account_name', "asc");

       
	   $query = $this -> db -> get();
	   //echo $this->db->last_query();
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

    public function getAccountExist($name,$cmpny)
    {
            
        $this->db->select('account_master.id as aid,account_master.account_name');
        $this->db->from('account_master');
     	$this->db->where('account_master.account_name', $name);
        $this->db->where('account_master.company_id', $cmpny);
        $query = $this->db->get();

        //echo $this->db->last_query();

        if($query->num_rows()>0)
        {
           return 1;
        }
        else
        {
           return 0;
        }
    }


    public function getAutoCompltAccount($term,$comp)
        {
             $data =array();

             $this->db->select('account_master.account_name');
             $this->db->from('account_master');
             $this->db->like('account_name', $term, 'after');
             $this->db->where('account_master.company_id',$comp);

             $query = $this->db->get();

            //
            //echo $this->db->last_query();

             if($query->num_rows()>0){
                 foreach ($query->result() as $rows) {
                     $data[]= $rows->account_name;
                     //$data['id']=$rows->vid;
                 }
                 return $data;
             }else{
                 return $data;
             }
        }

	
	function add($value)
	{
		$this->db->trans_begin();
		
		$datamaster = array('account_name' =>$value['account_name'],'group_master_id' =>$value['group_master_id'],'is_special' =>$value['is_special'],'company_id'=>$value['company_id']);
		$this->db->insert('account_master', $datamaster); 
	 	$insertmaster = $this->db->insert_id();
		
			if($value['opening_balance'] != '')
			{
				$datadetail = array('account_master_id' =>$insertmaster,'opening_balance' =>$value['opening_balance'],'company_id' =>$value['company_id'],'financialyear_id' =>$value['financialyear_id']);
				$this->db->insert('account_opening_master', $datadetail); 
				$insertdetail = $this->db->insert_id();
			}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		return  $insertdetail;
	}
	
	public function modify($value)
	{
		
		if (isset($value['id'])) {
		
		$session = sessiondata_method();
    	$this->db->trans_begin();
		$companyId = $session['company'];
		$yearId = $session['yearid'];

		if($value['group_master_id'] ==1 || $value['group_master_id']==2){
			
			$datamaster = array(
			'account_name' =>$value['account_name'],
			'is_special' =>$value['is_special']);

		}
		else{
			
			$datamaster = array(
			'account_name' =>$value['account_name'],
			'group_master_id' =>$value['group_master_id'],
			'is_special' =>$value['is_special']);

		}
		
		$this->db->where('id',$value['id']);
      	$this->db->update('account_master',$datamaster); 

		$delarray=array("company_id"=>$companyId,"financialyear_id"=>$yearId,"account_master_id"=>$value['id']);
		$this->db->where($delarray);
		$this->db->delete("account_opening_master");

		$datadetail = array(
							'account_master_id' =>$value['id'],
							'opening_balance' =>$value['opening_balance'],
							'company_id' =>$companyId,
							'financialyear_id' =>$yearId);
		$this->db->insert('account_opening_master', $datadetail);

     	/*$datadetail = array('opening_balance' =>$value['opening_balance']);
		$this->db->where('id', $value['accblnceid']);
		$this->db->update('account_opening_master', $datadetail); */


		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
   	 }
	}
	
	function delete($value)
 	 {

    //  $exists = $this->checkExistance($value['parentid']);
	
	  	$this->db->trans_begin();
		 
		  
		  $this->db->where('id', $value['childid']);
		  $this->db->delete('account_opening_master'); 
	 
	 	  $this->db->where('account_master_id', $value['parentid']);
		  $this->db->delete('customer'); 
		  
		   $this->db->where('account_master_id', $value['parentid']);
		  $this->db->delete('vendor'); 
		  
		  $this->db->where('id', $value['parentid']);
		  $this->db->delete('account_master'); 
		  
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
	 
	 function checkExistance($id)
	 {
		 $this -> db -> select('*');
	   	 $this -> db -> from('vendor');
		 $this -> db -> where('account_master_id', $id);
	  
		 
		 $count =  $this->db->count_all_results();	
		 return $count;
		 
	 }
	
}
?>