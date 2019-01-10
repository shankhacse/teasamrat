<html>
    <head>
        <title>Purchase Register - Group Wise</title>
        <style>
            .demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
        .demo th {
		border:1px solid #C0C0C0;
		padding:4px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:22px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:6px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:21px;		
		
	}
        .break{
            page-break-after: always;
        }
        </style>
    </head>
    <body>
        
        <table width="100%">
            <tr><td align="center"><b>Purchase Register - Group Wise</b></td></tr>
			 <tr><td align="center" style="font-size:13px;">Period - <?php echo date('d-m-Y',strtotime($fromDt));?> To <?php echo date('d-m-Y',strtotime($endDate));?></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        
        <table width="100%" class="">
               <tr>
                    <td align="left">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                    <td align=right>
                         <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                             Print Date : &nbsp;<?php echo($printDate); ?>
                         </span>
                    </td>
                </tr>
        </table>
        
        <div style="padding:4px"></div>
         <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;"><?php echo "Group : ".$group; ?></span>
        <table width="100%" class="demo">
        <tr>
            <th>Invoice No</th>
            <th>Invoice Dt</th>
            <th>Vendor</th>
            <th>Sale</th>
            <th>Bag</th>
			<th>Net Wt.</th>
            <th>Tea Value</th>
            <th>Brokerage</th>
            <th>TB charge</th>
            <th>Service Tax</th>
            <th>TAX</th>
            <th>Stamp</th>
            <th>TOTAL</th>
        </tr>

            <?php
                
            $lncount=1;
            $totalAmt = 0;
			$totalBag = 0;
			$totalWeight = 0;
			$totalTeaVal = 0;
			$totalTBCharg = 0;
			$totalBrokerage = 0;
			$totalServiceTax = 0;
			$totalStamp = 0;
			$totalVatAmt = 0;
            $grandTotal = 0;
			
            
            if ($search_purchase_register) {
                foreach ($search_purchase_register as $row) {
				
					$totalAmt = $totalAmt+$row['purchaseData']->total; 
					//$totalBag = $totalBag+$row['bagDtl']['actualBag'];
					//$totalWeight = $totalWeight+$row['bagDtl']['totalkgs'];
					$totalTeaVal = $totalTeaVal+$row['purchaseData']->tea_value;
					//$totalTBCharg = $totalTBCharg+$row['purchaseDtl']['totalTBCharges'];
					$totalBrokerage = $totalBrokerage+$row['purchaseData']->brokerage;
					$totalServiceTax = $totalServiceTax+$row['purchaseData']->service_tax;
					$totalStamp = $totalStamp+$row['purchaseDtl']['totalStamp'];
					//$totalVatAmt = $totalVatAmt+$row['purchaseDtl']['totalTaxAmt'];
				
				
                    ?>
                    <tr>
                        <td> <?php  echo $row['purchaseData']->purchase_invoice_number; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($row['purchaseData']->purchase_invoice_date));?></td>
                        <td> <?php echo $row['purchaseData']->vendor_name;?></td>
                        <td> <?php  echo $row['purchaseData']->sale_number;?></td>
                        <td> <?php  echo $row['bagDtlData']['totalBags'];?></td>
                        <td> <?php  echo $row['bagDtlData']['totalKgs'];?></td>
                        <td align="right"><?php echo $row['purchaseData']->tea_value;?></td>
                        <td align="right"><?php echo $row['purchaseData']->brokerage;?></td>
                        <td align="right"><?php echo number_format($row['purchaseData']->totalTbCharges,2);?></td>
                        <td align="right"><?php echo $row['purchaseData']->service_tax;?></td>
                        <td>
							<?php if($row['purchaseData']->total_cst>0){echo "CST : ".$row['purchaseData']->total_cst;}
								  if($row['purchaseData']->total_vat>0){echo "VAT : ".$row['purchaseData']->total_vat;} ?>
						</td>
                        <td align="right"><?php echo $row['purchaseData']->stamp;?></td>
                        <td align="right"><?php echo $row['purchaseData']->total;?></td>
                    </tr>
                    <?php 
                        $grandTotal = $grandTotal + $row['purchaseData']->total; 
                        $lncount = $lncount+1;
                        if($lncount>15){
                    ?>
					<!--
                    <tr>
                        <td><b>Total</b></td>
                        <td colspan="12" align="right"><?php //echo number_format($totalAmt,2);?></td>
                    </tr> -->
                  
                    </table>
                    <div class="break"></div>
                    <?php $lncount=1; ?>
                    <table width="100%">
                        <tr><td align="center"><b>Purchase Register - Group Wise</b></td></tr>
						 <tr><td align="center" style="font-size:13px;">Period - <?php echo date('d-m-Y',strtotime($fromDt));?> To <?php echo date('d-m-Y',strtotime($endDate));?></td></tr>
                    </table>

                    <div style="padding:2px 0 5px 0;"></div>
                    <table width="100%" class="">
                        <tr>
                            <td align="left">
                                <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                                    <?php echo($company); ?> <br/>
                                    <?php echo($companylocation) ?>
                                </span>
                            </td>
                            <td align=right>
                                <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                                     Print Date : &nbsp;<?php echo($printDate); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="demo">
          <tr>
              <th>Invoice No</th>
            <th>Invoice Dt</th>
            <th>Vendor</th>
            <th>Sale</th>
            <th>Bag</th>
			<th>Net Wt.</th>
            <th>Tea Value</th>
            <th>Brokerage</th>
            <th>TB charge</th>
            <th>Service Tax</th>
            <th>TAX</th>
            <th>Stamp</th>
            <th>TOTAL</th>
          </tr>
                    
                    
                    
                        <?php } ?>
                    <?php
                    
                    
                }
            } else {
                ?>
                <tr>
                    <td colspan="13" align="center">No data found....!!!</td>
                </tr>
            <?php } ?>
			
                 <tr>
                     <td colspan="6" align="left"><b>Grand Total</b></td>
					
					 <td align="right"><b><?php echo number_format($totalTeaVal); ?></b></td>
					 <td align="right"><b><?php echo number_format($totalBrokerage,2); ?></b></td>
					 <td></td>
					 <td align="right"><b><?php echo number_format($totalServiceTax,2); ?></b></td>
					 <td></td>
					 <td></td>
					 <td align="right"><b><?php echo number_format($totalAmt,2); ?></b></td>
					
					
                 </tr> 
        </table>
                
    </body>
</html>