<?php
class profitlossmodel extends CI_Model {
    
    public function getExpenditureData($compny,$year,$fiscalSdt,$toDate,$frmDate)
	{
		 $data = array();
         $call_procedure = "CALL usp_GetExpenditure($compny,$year,"."'".$fiscalSdt."'".","."'".$toDate."'".","."'".$frmDate."'".")";
		
         $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                // $data[] = $rows;
				$data[] = array(
					"GroupDescription" => $rows->GroupDescription,
					"AccountName" => $rows->AccountName,
					"Expenditure" => $rows->Expenditure,
					"TotalExpenditure" => $rows->TotalExpenditure,
					"Total" => $rows->Total
				);
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
	

	public function getIncomeData($compny,$year,$fiscalSdt,$toDate,$frmDate)
	{
		 $data = array();
         $call_procedure = "CALL usp_GetIncome($compny,$year,"."'".$fiscalSdt."'".","."'".$toDate."'".","."'".$frmDate."'".")";
		
         $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 //$data[] = $rows;
				 
				$data[] = array(
					"GroupDescription" => $rows->GroupDescription,
					"AccountName" => $rows->AccountName,
					"Income" => $rows->Income,
					"TotalIncome" => $rows->TotalIncome,
					"Total" => $rows->Total
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