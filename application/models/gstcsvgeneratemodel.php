<?php 
class gstcsvgeneratemodel extends CI_Model
{
	public function getCSVData($csvType,$fromdt,$todt,$company,$year,$statecode)
	{
		$data = array();
		
		if($csvType=="B2CS")
		{
			$call_procedure = "CALL sp_AllSaleCSV_B2CS('".$csvType."','".$fromdt."','".$todt."',$company,$year,$statecode)";
		}
		else
		{
			$call_procedure = "CALL sp_B2B_Sale_CSV('".$csvType."','".$fromdt."','".$todt."',$company,$year,$statecode)";
		}
		
		//echo "Call Procedure ".$call_procedure;
		
		$query = $this->db->query($call_procedure);
		  
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = $rows;
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
		
	}
}