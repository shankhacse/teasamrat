<?php

class creditorsoutstandingmodel extends CI_Model {
    
    
     public function getCreditorOutstandingList($year,$compny,$in_vendor,$frmDate,$toDate){
     
      
         $data = array();
         $call_procedure = "CALL usp_CreditorDue($year,$compny,'".$in_vendor."',"."'".$frmDate."'".","."'".$toDate."'".")";
              
         
       
      
       
         
       //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
          $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                 $data[] = array(
                       "accountId"=>$rows->AccountId,
                        "accountname"=>$rows->AccountDescription,
                        "opening"=>$rows->Opening,
                        "debitAmt"=>$rows->DebitAmount,
                        "creditAmt"=>$rows->CreditAmount,
                        "balance"=>$rows->Balance,
                        "balancetag"=>$rows->BalanceTag
                      );
               
                
            }
         
            return $data;
        } 
        
        else {
            return $data;
        }
        
    }
    


    
    

    public function getCreditorOutstandingDetail($fromDate,$toDate,$vendor,$companyId,$yearId){
            $data= [];
            if(strlen($vendor)>0)
            {
                $call_procedure = "CALL SP_GetAllVendorBillPurchase('".$fromDate."','".$toDate."','".$vendor."',".$companyId.")";
            }
          

            $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $rows) 
                {   $data[]=$rows;
                     
                      /*$data [] = array(
                        "MasterDats" => $rows,
                        "paymentVouchers" => $this->getPaymentVoucherData($rows->vendorbillMasterId),
                      );*/
               
                }

            }

            return $data;
        }

        public function getPaymentVoucherData($vendorbillmasterID)
        {
            echo "VendorBillMaster ".$vendorbillmasterID."<br>";

            $data=[];
            if($vendorbillmasterID>0)
            {
                $querySql = "SELECT * from vendorbillpaymentdetail 
                        INNER JOIN vendorbillpaymentmaster
                        ON vendorbillpaymentmaster.vendorPaymentId = vendorbillpaymentdetail.vendorpaymentid
                        INNER JOIN voucher_master
                        ON voucher_master.id = vendorbillpaymentmaster.voucherId
                        WHERE 
                        vendorbillpaymentdetail.vendorBillMaster =".$vendorbillmasterID;
                 $query = $this->db->query($querySql);
                 echo $this->db->last_query();
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $rows) {


                  $data[] = $rows;
                  
                    }
                }
            }

              

            return $data;
        }

    
    
    
     public function getAccountingPeriod($yearid){
        $data = array();
         $sql="SELECT * FROM financialyear WHERE financialyear.id=".$yearid;
         $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                 $data=array(
                     "start_date"=>$rows->start_date,
                     "end_date"=>$rows->end_date
                 );
                          
                }
                return $data;
         }else{
              return $data;
         }
         
         
    }
    
}
?>