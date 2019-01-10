<?php

class closingtransferfinishproductmodel extends CI_Model {

public function getCurrentYear($currentYearId) {
        $data = array();
        $sql = "SELECT `financialyear`.`year`,`financialyear`.`id` ,financialyear.end_date FROM `financialyear` 
                WHERE `financialyear`.`id`=" . $currentYearId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data = array(
                "year" => $row->year,
                "currentyearid" => $row->id,
                "end_date" => $row->end_date,
                "next_year" => $this->nextAccountingYear($row->id, $row->end_date),
            );
        }
        return $data;
    }

    public function nextAccountingYear($id, $lastdate) {
        $nextyeardate = date('Y-m-d', strtotime('+1 day', strtotime($lastdate)));
        $sql = " SELECT `financialyear`.`year`,`financialyear`.`id`,DATE_FORMAT(`financialyear`.`end_date`,'%d-%m-%Y') AS end_date FROM 
            `financialyear`  WHERE `financialyear`.`start_date`='" . $nextyeardate . "'";
        $nextyear = "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nextyear = array("nextYear" => $row->year, "nextId" => $row->id);
        }
        return $nextyear;
    }


        public function transferClosingFinishProductStock($fDt,$tDt,$companyId,$yearId,$nxtyearId){
        $data=array();
        
   
        $call_procedure ="CALL sp_closingfinishproducttransfer('".$fDt."','".$tDt."',".$companyId.", ".$yearId.",".$nxtyearId.")";
		//echo $call_procedure;
        //exit;
        $query = $this->db->query($call_procedure);
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[]=array(
                          "id"=>$rows->id,
                          "finalProduct"=>$rows->finalProduct,
                          "closing_balance"=>$rows->opening_balance
                );
            }
           
          
            return $data;
        }  else {
            return $data;
        }
       
    }

	

} //end of class