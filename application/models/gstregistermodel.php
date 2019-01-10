<?php

class gstregistermodel extends CI_Model{
	
 /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
            
    public function getGSTRegister($fromDt,$toDt,$usedFor,$compID,$yearID){
            $data = [];
            $sql = "SELECT 
                    voucher_master.id AS voucherMaterID,
                    voucher_master.voucher_number,
                    voucher_master.voucher_date,
                     voucher_master.transaction_type
                      FROM voucher_master
                      INNER JOIN voucher_detail
                      ON voucher_master.`id` = voucher_detail.`voucher_master_id`
                      WHERE 
                      voucher_detail.`account_master_id` IN 
                      (SELECT gstmaster.`accountId` FROM gstmaster 
                       /*INNER JOIN voucher_detail ON gstmaster.`accountId` = voucher_detail.`account_master_id`*/
                       WHERE gstmaster.companyid = ".$compID." AND gstmaster.`usedfor`='".$usedFor."'
                      ) 
                      AND voucher_master.`voucher_date` BETWEEN '".$fromDt."' AND '".$toDt."'
                      AND voucher_master.`transaction_type` IN ('PR','JV','RP','SP')
                      GROUP BY voucher_master.`id`
                      ORDER BY voucher_master.`voucher_date`";
        
        $query = $this->db->query($sql);

       

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) 
            {
              //$data[] = $rows;
              $data[] = array(
                 "voucherData" => $rows,
                 "cgstAmt" => $this->getGSTAmt($rows->voucherMaterID,'CGST','I'),
                 "sgstAmt" => $this->getGSTAmt($rows->voucherMaterID,'SGST','I'),
                 "igstAmt" => $this->getGSTAmt($rows->voucherMaterID,'IGST','I'),
                 "partyDataDtl" => $this->getTotalTaxAmountWithGST($rows->voucherMaterID,'N') // is_debit = 'N'
              );
              
              
            }

           
        }
         return $data;
        
    }
    
  
    public function getGSTAmt($mastreID,$gstType,$usefor)
    {
      $gstAmount = 0;
      $sql ="SELECT  sum(voucher_detail.voucher_amount) as voucher_amount  FROM voucher_detail
              INNER JOIN `gstmaster`
              ON gstmaster.`accountId` = voucher_detail.`account_master_id`
              AND gstmaster.`gstType` = '".$gstType."'
              AND gstmaster.`usedfor` ='".$usefor."'
              WHERE
              voucher_detail.`voucher_master_id` =".$mastreID;
         $query = $this->db->query($sql);

          if($query->num_rows()>0){
              $rows=$query->row();
              $gstAmount =$rows->voucher_amount;
          }
          return $gstAmount;
    }
    
    public function getTotalTaxAmountWithGST($mastreID,$is_debit)
    {
      //$totalTaxableAmt = 0;
      $data = array();

      $sql ="SELECT * FROM voucher_detail
              INNER JOIN `account_master`
              ON `account_master`.`id` = voucher_detail.`account_master_id`
              WHERE
              voucher_detail.is_debit = '".$is_debit."'
              AND voucher_detail.`voucher_master_id` =".$mastreID;
         $query = $this->db->query($sql);
         //echo $this->db->last_query();
          if($query->num_rows()>0){
              $rows=$query->row();
              

              $data = array(
                "totalTaxAmt" => $rows->voucher_amount,
                "partyName" => $rows->account_name
              );
          }
         return $data;
    }
    
	

/* Gst output Report created on 10.01.2019 */

  public function getGSTRegisterOutput($fromDt,$toDt,$usedFor,$compID,$yearID){
            $data = [];
            $sql = "SELECT 
                    voucher_master.id AS voucherMaterID,
                    voucher_master.voucher_number,
                    voucher_master.voucher_date,
                     voucher_master.transaction_type
                      FROM voucher_master
                      INNER JOIN voucher_detail
                      ON voucher_master.`id` = voucher_detail.`voucher_master_id`
                      WHERE 
                      voucher_detail.`account_master_id` IN 
                      (SELECT gstmaster.`accountId` FROM gstmaster 
                       /*INNER JOIN voucher_detail ON gstmaster.`accountId` = voucher_detail.`account_master_id`*/
                       WHERE gstmaster.companyid = ".$compID." AND gstmaster.`usedfor`='".$usedFor."'
                      ) 
                      AND voucher_master.`voucher_date` BETWEEN '".$fromDt."' AND '".$toDt."'
                      AND voucher_master.`transaction_type` IN ('SL','RS','JV')
                      GROUP BY voucher_master.`id`
                      ORDER BY voucher_master.`voucher_date`";
        
        $query = $this->db->query($sql);

       #echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) 
            {
              //$data[] = $rows;
              $data[] = array(
                 "voucherData" => $rows,
                 "cgstAmt" => $this->getGSTAmt($rows->voucherMaterID,'CGST','O'),
                 "sgstAmt" => $this->getGSTAmt($rows->voucherMaterID,'SGST','O'),
                 "igstAmt" => $this->getGSTAmt($rows->voucherMaterID,'IGST','O'),
                 "partyDataDtl" => $this->getTotalTaxAmountWithGST($rows->voucherMaterID,'Y') // is_debit = 'N'
              );
              
              
            }

           
        }
         return $data;
        
    }



}// end of class