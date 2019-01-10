<?php

class voucherlistmodel extends CI_Model {
    
    /*
    public function getVoucherList($vdata){
        $fromdt = $vdata['from_date'];
        $todt = $vdata['to_date'];
        $ptype = $vdata['ptype'];
        $session = sessiondata_method();
        if($ptype=="ALL"){
        $whereClause = " WHERE `voucher_master`.`voucher_date` BETWEEN '".$fromdt."' AND '".$todt."' AND voucher_master.company_id=".$session['company'];
        }else{
             $whereClause = " WHERE 
                        `voucher_master`.`transaction_type`='".$ptype."'
                        AND `voucher_master`.`voucher_date` BETWEEN '".$fromdt."' AND '".$todt."' AND voucher_master.company_id=".$session['company'];
        }
        
           $sql = " SELECT 
                `voucher_master`.id,
                `voucher_master`.`voucher_number`,
                 DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
                `voucher_master`.`narration`,
                `voucher_master`.`transaction_type`
                 FROM `voucher_master`".$whereClause." ORDER BY `voucher_master`.`voucher_date` DESC";
                
        
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "id"=>$rows->id,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "narration"=>$rows->narration,
                    "transaction_type"=>$rows->transaction_type,
                    "voucherDtl"=>$this->getVoucherDetaildata($rows->id)
                    
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    */

     public function getVoucherList($vdata){
        $session = sessiondata_method();
        $fromdt = $vdata['from_date'];
        $todt = $vdata['to_date'];
        $ptype = $vdata['ptype'];
        $account = $vdata['accid'];
        
        $whereTranType = "";
        $whereAccID = "";

        if($ptype!="ALL")
        {
          if($ptype=="PUR")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('PR','RP','SP')";
          }
          elseif($ptype=="SALE")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('SL','RS')";
          }
          elseif($ptype=="GV")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('GV')";
          }
          elseif($ptype=="JV")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('JV')";
          }
          elseif($ptype=="CN")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('CN')";
          }
          elseif($ptype=="VADV")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('VADV')";
          }
          elseif($ptype=="CADV")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('CADV')";
          }
          elseif($ptype=="PY")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('PY','PJV')";
          }
          elseif($ptype=="RC")
          {
            $whereTranType = " AND `voucher_master`.`transaction_type` IN ('RC')";
          }

          
        }

        if($account>0)
        {
          $whereAccID = " AND `voucher_detail`.`account_master_id`=".$account;
        }

            $sql = "SELECT 
                    voucher_master.`id` AS vmasterID,
                    voucher_master.`voucher_number`,
                    DATE_FORMAT(`voucher_master`.`voucher_date`,'%d-%m-%Y') AS VoucherDate,
                    voucher_master.`transaction_type`,
                    voucher_master.`vouchertype`,
                    voucher_master.`narration`
                    FROM voucher_detail 
                    INNER JOIN voucher_master
                    ON voucher_master.`id` = voucher_detail.`voucher_master_id`
                    WHERE 
                    voucher_master.`voucher_date` BETWEEN '".$fromdt."' AND '".$todt."'
                    AND voucher_master.`company_id` = ".$session['company']." 
                    AND voucher_master.`year_id`=".$session['yearid']." ".$whereTranType." ".$whereAccID."
                    GROUP BY voucher_detail.`voucher_master_id`
                    ORDER BY voucher_master.`voucher_date`";
                
        
        
        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "id"=>$rows->vmasterID,
                   // "voucherDtlId"=>$rows->voucherDtlId,
                    "voucher_number"=>$rows->voucher_number,
                    "VoucherDate"=>$rows->VoucherDate,
                    "narration"=>$rows->narration,
                    "transaction_type"=>$rows->transaction_type,
                    "voucherDtl"=>$this->getVoucherDetaildata($rows->vmasterID)
                );
            }

          return $data;
        }
        else{
            return $data=array();
        }
    }
    
    
     public function getVoucherDetaildata($vouchmastId){
        $sql="SELECT 
            `account_master`.`account_name`,
            `voucher_detail`.`voucher_amount`,
            `voucher_detail`.`is_debit` AS drCr
             FROM `voucher_detail`
             INNER JOIN `account_master`
             ON `account_master`.`id`=`voucher_detail`.`account_master_id`
             WHERE `voucher_detail`.`voucher_master_id`='".$vouchmastId."'";
          $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data[] = $rows;
                }


                return $data;
            } else {
                return $data;
            }
        
    }
    
    
    
}

?>