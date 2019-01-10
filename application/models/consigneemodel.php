<?php

class consigneemodel extends CI_Model{


	 public function getCustomerList() {
        $data=array();
        $session_data = sessiondata_method();
        $this->db->select('customer.id as customerId,
			    customer.customer_name,
                            customer.telephone,
                            customer.address,
                            customer.pin_number,
                            state_master.state_name,
                            customer.account_master_id as amid,
                            account_opening_master.id as aomid,
                            account_opening_master.opening_balance');
        $this->db->from('customer');
        $this->db->join('account_master', 'customer.account_master_id = account_master.id', 'INNER');
        $this->db->join('account_opening_master', 'account_master.id = account_opening_master.account_master_id', 'LEFT');
        $this->db->join('state_master', 'customer.state_id = state_master.id', 'LEFT');
        $this->db->where('account_master.company_id', $session_data['company']);
        $this->db->group_by('customer.id');
        $this->db->order_by("customer_name", "asc");



        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $data[] =array( 
                               "customerId"=> $rows->customerId,
                               "name"=>$rows->customer_name,
                               "customeracid"=>$rows->amid
                    );
            }
            return $data;
        } else {
            return $data;
        }
    }
 


	function getStates()
	{
		$sql = "SELECT * FROM `state_master` ORDER BY state_name ASC ";
		$query = $this->db->query($sql);
		return ($query->result());
	}

	function insertConsignee($value)
	{
		$this->db->trans_begin();
		$this->db->insert('consignee_master', $value);
		$insert = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		return  $insert;
	}



	public function getConsigneeList($companyid,$yearid)
	{
		$where = array(
			
			"consignee_master.`companyid`"=>$companyid,
			"consignee_master.`yearid`"=>$yearid
		);
		$data = array();
		$this->db->select(" 
							`consignee_master`.`id`,
							`consignee_master`.`consignee_name`,
							`consignee_master`.`gstin`,
							`state_master`.`state_name`,
							`customer`.`customer_name`,
							`consignee_master`.`address`
						")
				->from('consignee_master')
				->join('customer','customer.id=consignee_master.customer_id','INNER')
				->join('state_master','state_master.id=consignee_master.state_id','INNER')
				->where($where);
		
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}



	public function getConsigneeById($consigneeid)
	{   $data=[];
		$where = array(
			
			"consignee_master.`id`"=>$consigneeid
			
		);
		$data = array();
		$this->db->select("*")
				->from('consignee_master')
				->where($where);
		
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}


	function updateConsignee($upd_data,$upd_where)
	{
	 
    	$this->db->trans_begin();
		$this->db->where($upd_where);
         $this->db->update('consignee_master',$upd_data); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
   	 
	}

	function deleteConsignee($value)
 	 {
		  $this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('consignee_master'); 
		
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

	
 }//end of class