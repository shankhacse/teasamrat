<html>
    <head>
        <title>Debtors Outstanding</title>
        <style>
            .demo {
    border:1px solid #C0C0C0;
    border-collapse:collapse;
    padding:3px;
  }
        .demo th {
    border:1px solid #C0C0C0;
    padding:4px;
    background:#F0F0F0;
    font-family:Verdana, Geneva, sans-serif;
    font-size:12px;
    font-weight:bold;
  }
  .demo td {
    border:1px solid #C0C0C0;
    padding:4px;
    font-family:Verdana, Geneva, sans-serif;
    font-size:12px;   
    
  }
        .table_head{
            height:45px;
            border:none;
        }
        .break{
            page-break-after: always;
        }
        </style>
    </head>
    <body>
       
        <table width="100%" class="">
               <tr>
                   <td align="center">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                </tr>
        </table>
       <table width="100%">
           <tr><td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Debtors Outstanding List</span></td></tr>
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        
       <table width="100%">
           <tr>
               <td width="50%" align="left">
                   <table >
                        <tr>
                            <td align="left"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Print Date : <?php echo date('d-m-Y');?></span></td>
                        </tr>
                    </table>
               </td>
               <td width="35%" align="right">
                   <table>
                        <tr>
                            <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
                        </tr>
                        <tr>
                            <td align="center"><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
                        </tr> 
                   </table>
               </td>
           </tr>
        </table>
        
        
        
        <div style="padding:4px"></div>
        
       
        <div style="padding:4px"></div>
       
       <table width="100%" class="demo">
           
           <!-- <tr>
               <th align="left">Bill No</th>
               <th align="right">Bill Dt</th>
               <th align="right">Bill Amt</th>
               <th align="right">Vch No</th>
               <th align="right" width="15%">Vch Dt</th>
               <th align="left" width="12%">Vch Type</th>
               <th align="left" width="10%">Amount </th>
               <th align="right">Due</th>
               
           </tr> -->
           <tr>
               <th rowspan="2" align="center">Bill No</th>
               <th rowspan="2" align="center">Bill Dt</th>
               <th rowspan="2" align="center" width="15%">Bill Amt</th>
               <th colspan="5">Payment And Adjustment</th>
               
               
               
           </tr>
           <tr>
            <th align="center">Vch No</th>
            <th align="center" width="12%">Vch Dt</th>
               <th align="center" width="10%">Vch Type</th>
               <th align="center" width="15%">Amount </th>
               <th align="center" width="15%">Due</th>
           </tr>
           
           <?php 
           
               /*echo "<pre>";
               print_r($creditorsoutstanding);
               echo "</pre>";*/
              $start=0; 
              $customertotalstart=0; 
              $previusbillno="";
              $customerAccountId=0;
              $billamt=0;
              $amount=0;
              $due=0;

              $billamtbyinvoice=0;
              $amountbyinvoice=0;
              $duebtinvoice=0;

              $grandTotalbillamt=0;
              $gtandTotalamount=0;
              $gndtotaldue=0;

              $billamtbycustomer=0;
              $amountbycustomer=0;
              $arraysize=count($debitoroutstanding);
              $count=0;
             
              $vbillLas=0;
              $vamtlast=0;
              $ltvdue=0;
               $vdue=0;
               foreach($debitoroutstanding as $debitor_due){ 
                $count++;

                      // Total Calculation Row
                  if ( $start!=0 && $debitor_due->invoiceNumber!=$previusbillno) { $start=1;
                      $due=0;
                      
                   ?>

                    <tr style="font-weight:bold;">
                      <td colspan="2" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;"><?php 
                      echo "Bill Total & Due : "; ?></td><td align="right"><?php echo number_format($previusbillamt,2)?></td>
                      <td colspan="3">
                        <?php //echo "Previous:".$previusbillamt;
                       
                        ?>


                      </td>
                      <td align="right"><?php echo number_format($amount,2);?></td>
                      <td align="right"><?php $due=$previusbillamt-$amount;
                                        if ($due>0) {
                                          echo number_format($due,2);
                                        }
                                         
                                          ?></td>
                    </tr><?php 
                    $billamtbycustomer=$billamtbycustomer+$previusbillamt;
                     $amountbycustomer=$amountbycustomer+$amount;

                    $billamtbyinvoice=$billamtbyinvoice+$previusbillamt;
                   
                    $amountbyinvoice=$amountbyinvoice+$amount;
                     $amount=0;
                  }
                  // Vendor Total

                  if ($customertotalstart!=0 && $customerAccountId!=$debitor_due->customerAcId) {  $customertotalstart=1;?>

          <tr>
         <td colspan="2" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;">Customer Total :</td>
          <td align="right" style="font-weight:bold;"><?php echo number_format($billamtbycustomer,2);?></td>
           <td colspan="3" > </td>
                        
                        <td align="right" style="font-weight:bold;"><?php echo number_format($amountbycustomer,2);?></td>
                        <td align="right" style="font-weight:bold;"><?php 

                        $vdue=$billamtbycustomer-$amountbycustomer;
                              if ($vdue>0) {
                                echo number_format($billamtbycustomer-$amountbycustomer,2);
                              }
                        ?></td>

             </tr><?php 
                    if ($count!=$arraysize) {

                      $billamtbycustomer=0;
                    $amountbycustomer=0;
                    }
                    
                  }?>
                

                   <?php   
                      

                   if ($customerAccountId!=$debitor_due->customerAcId) {
                       
                   ?>
                  <tr>
                      <td colspan="8" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;"><?php //echo $creditor_due->vendorAcId;
                      echo $debitor_due->customerName; ?></td>

                    </tr>
                    <?php }?>

                   <tr>
                
                   <?php if($debitor_due->invoiceNumber!=$previusbillno){

                   ?>
                     <td align="left"><?php echo $debitor_due->invoiceNumber;?></td>
                     <td align="right"><?php echo date("d-m-Y",strtotime($debitor_due->invoiceDate));?></td>
                     <td align="right"><?php echo $debitor_due->totalAmount;?></td>
                      <?php 
                      $start++;
                      $customertotalstart++;
                    }else{?>
                      <td align="left" style="">&nbsp;</td>
                      <td align="left" style="">&nbsp;</td>
                      <td align="left" style="">&nbsp;</td>
                      <?php } ?>


                    
                     <td align="left"><?php echo $debitor_due->voucherNumber;?></td>
                     <td align="left"><?php echo ($debitor_due->voucherDate == "" ? NULL : date('d-m-Y',strtotime($debitor_due->voucherDate)) );?></td>
                     <td align="left"><?php  
                     if($debitor_due->transactionType=='RC'){echo "Receipt";}elseif($debitor_due->transactionType=='CADV'){echo "Adjustment";}elseif ($debitor_due->transactionType=='RJV') {
                      echo "Journal";}
                     ?></td>
                     <td align="right"><?php echo $debitor_due->paidAmount;?></td>
                     <td align="right"></td>
                     
                   </tr>

     
              
           <?php    $previusbillamt=$debitor_due->totalAmount;
                    $previusbillno=$debitor_due->invoiceNumber;
                    $customerAccountId=$debitor_due->customerAcId;
                    $amount=$amount+$debitor_due->paidAmount;
                    
         } ?>
         


               <tr style="font-weight:bold;">
                     <td colspan="2" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;"><?php 
                     echo "Bill Total & Due : "; ?></td><td align="right"><?php echo number_format($previusbillamt,2);?></td>
                     <td colspan="3">
                       <?php //echo "Previous:".$previusbillamt;
                       //echo "<br>Amount:".$amount?>
             
             
                     </td>
                     <td align="right"><?php echo number_format($amount,2);?></td>
                     <td align="right"><?php $due=$previusbillamt-$amount;
                                          if ($due>0) {
                                         echo number_format($due,2);
                                       }?></td>
                         </tr> 


           <tr>
         <td colspan="2" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;">Customer Total :</td>
          <td align="right" style="font-weight:bold;"><?php  $vbillLast=$billamtbycustomer+$previusbillamt;
                                                            echo number_format($vbillLast,2)?></td>
           <td colspan="3" > </td>
                        
                        <td align="right" style="font-weight:bold;"><?php $vamtlast= $amountbycustomer+$amount;echo number_format($vamtlast,2);?></td>
                        <td align="right" style="font-weight:bold;"><?php 

                            $billamtbycustomer=$vbillLast-$vamtlast;
                            if ($billamtbycustomer>0) {
                              
                              echo number_format($billamtbycustomer,2);
                            }
                        ?></td>

                    </tr>

         <tr style="font-weight:bold;">
                      <td colspan="2" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:12px;font-weight:bold;"><?php 


                      $grandTotalbillamt=$billamtbyinvoice+$previusbillamt;
                      $gtandTotalamount=$amountbyinvoice+$amount;
                      echo "Grand Total : "; ?></td><td align="right" style="background:#F0F0F0;font-size:12px;font-weight:bold;"><?php echo number_format($grandTotalbillamt,2); ?></td>
                      <td colspan="3">
                        <?php ?>


                      </td>
                      <td align="right" style="background:#F0F0F0;font-size:12px;font-weight:bold;"><?php echo number_format($gtandTotalamount,2); ?></td>
                      <td align="right" style="background:#F0F0F0;font-size:12px;font-weight:bold;"><?php 
                                          $gndtotaldue=$grandTotalbillamt-$gtandTotalamount;
                                          if ($gndtotaldue>0) {

                                           echo number_format($gndtotaldue,2);
                                          }
                                          ?></td>
       </tr>
           
           </table>
           
           
         <div class="break"></div>
    
       
   
        
                
    </body>
</html>