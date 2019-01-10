<?php
class bankreconcilationmodel extends CI_Model 
{

    public function getBankAc($cmpny)
    {
        $sql="SELECT `account_master`.`id` AS acountId,
                `group_master`.`id` AS groupMasterId,
                `account_master`.`account_name`
                FROM account_master
                INNER JOIN `group_master`
                ON `group_master`.`id`=`account_master`.`group_master_id`
                WHERE `group_master`.`group_name` = 'Bank Balance' AND account_master.company_id=".$cmpny." ORDER BY account_name";

        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]=array(
                   "acountId"=>$rows->acountId,
                   "account_name"=>$rows->account_name
                );
            }

        return $data;
        }
        else{
            return $data=array();
        }
    }

    public function getBankReconcilationList($bankAccID,$frmDt,$toDt,$company,$yearid)
    {
        $data=array();
        $sql ="SELECT * FROM voucher_detail
                INNER JOIN voucher_master
                ON voucher_master.`id` = voucher_detail.`voucher_master_id`
                WHERE 
                voucher_detail.`account_master_id`=".$bankAccID."
                AND voucher_master.`voucher_date` BETWEEN '".$frmDt."' AND '".$toDt."' AND voucher_master.company_id=".$company." ORDER
                BY voucher_master.voucher_date,voucher_master.voucher_number";

        $query =$this->db->query($sql);
        if($query->num_rows()> 0){
            foreach ($query->result() as $rows){
                $data[]= array(
                    'ListData' => $rows, 
                    'detailData' => $this->getVoucherDetail($rows->voucher_master_id,$rows->account_master_id)
                );
            }

        return $data;
        }
        else{
            return $data=array();
        }
    }

    function getOpeningBalanceBankReconciliation($accID,$year,$comp,$fdate,$tdate)
    {
        $call_procedure = "CALL usp_closingBalanceBankReconciliation(".$accID.",".$year.",".$comp.",'".$fdate."','".$tdate."')";
        $query = $this->db->query($call_procedure);
      
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                             
                
                    $data = array(
                        "openingBalance" => $rows->Opening,
                        "closingBalance" => $rows->Balance
                    );
               
                
            }
           return $data;
        } 
        
        else {
            return $data;
        }

    }

     function getClosingAsBankBook($accID,$year,$comp,$fdate,$tdate)
    {
        $call_procedure = "CALL usp_closingAsBankBook(".$accID.",".$year.",".$comp.",'".$fdate."','".$tdate."')";
        $query = $this->db->query($call_procedure);
      
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                             
                
                    $data = array(
                        "openingBalance" => $rows->Opening,
                        "closingBalance" => $rows->Balance,
                        "BalanceTag" => $rows->BalanceTag
                    );
               
                
            }
           return $data;
        } 
        
        else {
            return $data;
        }

    }

   

    public function updateChequeInfo($vmid,$data)
    {
        try {

              $this->db->trans_begin();
              $this->db->where('id', $vmid);
              $this->db->update('voucher_master', $data); 

              if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                } 
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotEncashed($accID,$year,$comp,$fdate,$tdate,$isdebit)
    {
        $data = array();
        $Sql = "SELECT VD.`id` AS voucherDtlID,
                VD.`voucher_amount`,
                VD.`is_debit`,
                VD.`account_master_id`,
                VM.`id` AS vouchermasterID,
                VM.`voucher_number`,
                VM.`voucher_date`,
                VM.`cheque_number`,
                VM.`cheque_date`,
                VM.`chq_clear_on`,
                VM.`is_chq_clear`
                FROM 
                voucher_detail VD 
                INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id 
                WHERE VD.is_debit = '".$isdebit."' 
                AND VM.`voucher_date` BETWEEN '".$fdate."' AND '".$tdate."'
                AND VM.`company_id` = ".$comp."
                AND VD.`account_master_id` =".$accID."
                AND VM.`chq_clear_on` IS NULL ORDER BY VM.voucher_date,VM.voucher_number";

        $query = $this->db->query($Sql);
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $rows) {
                   $data[]= array(
                    'ListData' => $rows, 
                    'detailData' => $this->getVoucherDetail($rows->vouchermasterID,$rows->account_master_id)
                );
            }
           return $data;
        } 
        else {
            return $data;
        }


    }

    public function getVoucherDetail($vmID,$accID)
    {
        $data = array();
        $sql = "SELECT * FROM
                    voucher_detail
                    INNER JOIN account_master
                    ON account_master.`id` = voucher_detail.`account_master_id`
                    WHERE voucher_detail.`voucher_master_id` =".$vmID." AND voucher_detail.`account_master_id` <>".$accID;
                  

        $query =$this->db->query($sql);
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows){
                $data[]= $rows;
            }
            return $data;
        }
        else
        {
            return $data=array();
        }

    } 

}

?>