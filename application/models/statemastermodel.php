<?php

class statemastermodel extends CI_Model {

	public function getStateList()
	{
		$data = array();
		$sql = "SELECT * FROM state_master ORDER BY state_name";
		$query = $this->db->query($sql);
		
	//	echo $this->db->last_query();
		
        if($query->num_rows() > 0) 
		{
            foreach ($query->result() as $rows) 
			{
                $data[] = array(
                    "state_id"=>$rows->id,
                    "state_name"=>$rows->state_name,
                    "state_code"=>$rows->state_code
                );
            }
			return $data;
        }
		else 
		{
            return $data;
        }
	}

}