<?php
class balancesheetmodel extends CI_Model {
    
    public function getLiablitiesData($compny,$year,$fiscalSdt,$toDate,$frmDate)
	{
		 $data = array();
         $call_procedure = "CALL usp_GetLiabilities($compny,$year,"."'".$fiscalSdt."'".","."'".$toDate."'".","."'".$frmDate."'".")";
		
         $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                // $data[] = $rows;
				$data[] = array(
					"GroupDescription" => $rows->GroupDescription,
					"AccountName" => $rows->AccountName,
					"Liabilities" => $rows->Liabilities
					
				);
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
	

	public function getAssetData($compny,$year,$fiscalSdt,$toDate,$frmDate)
	{
		 $data = array();
         $call_procedure = "CALL usp_GetAssets($compny,$year,"."'".$fiscalSdt."'".","."'".$toDate."'".","."'".$frmDate."'".")";
		
         $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 //$data[] = $rows;
				 
				$data[] = array(
					"GroupDescription" => $rows->GroupDescription,
					"AccountName" => $rows->AccountName,
					"Asset" => $rows->Asset
				);
				 
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
   

    

   
}

?>