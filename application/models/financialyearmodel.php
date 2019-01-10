<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class financialyearmodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function financialyearlist()
	{

	   $this -> db -> select('*');
	   $this -> db -> from('financialyear');
           $this-> db -> order_by('end_date','desc');
	
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
	
	
	function checkIsCurrentAccYear($currdate){
		
		$isCurrAccYear = true;
		$sql = "SELECT * FROM financialyear  WHERE  financialyear.`end_date` > '".$currdate."'";
		$query = $this->db->query($sql);
	   
	   
		
		//echo $this->db->last_query();
		
	   if($query -> num_rows() > 0)
	   {
		$isCurrAccYear = false;
		
	   }
	   return $isCurrAccYear;
	}
	
}
?>