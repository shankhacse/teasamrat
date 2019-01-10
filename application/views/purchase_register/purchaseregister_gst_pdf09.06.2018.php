<html>
    <head>
        <title>Purchase Register GST</title>
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
            <tr><td align="center"><b>Purchase Register GST</b></td></tr>
         
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
                    <td align="right">
                         <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                             Print Date : &nbsp;<?php echo($printDate); ?>
                         </span>
                    </td>
                </tr>
        </table>
        
        <div style="padding:4px"></div>
		<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
		<?php echo $for_period; ?>
		</span><br>
		
		<?php if($vendor){?>
		<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
		<?php echo "Vendor : ".$vendor;?>
		</span><br>
		<?php } ?>
		
		<?php if($sale_no!=""){?>
		<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
		<?php echo "Sale No : ".$sale_no;?>
		</span><br>
		<?php } ?>
		
		<?php if($purchasetype!=""){?>
		<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
		<?php echo "Purchase Type : ".$purchasetype;?>
		</span><br>
		<?php } ?>
		
		<?php if($purchasearea!=""){?>
		<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
		<?php echo "Purchase Area : ".$purchasearea; ?>
		</span><br>
		<?php } ?>
		
        <div style="padding:4px"></div>
        
		
        <table width="100%" class="demo">
			<tr>
				<th>Bill No</th>
				<th>Bill Dt</th>
				<th>Vendor</th>
				<th>Sale</th>
				<th>Bag</th>
				<th>Net Wt.</th>
				<th>Taxable</th>
				<th>CGST</th>
				<th>SGST</th>
				<th>IGST</th>
				<th>Tot GST</th>
				<th>R/O</th>
				<th>Bill Amt</th>
			</tr>

            <?php
                
            $lncount=1;
            $totalAmt = 0;
			$totalBag = 0;
			$totalWeight = 0;
			$totalTeaVal = 0;
			$grandTotal = 0;
			
			$grandTotalTaxable = 0;
			$grandTotalCGST = 0;
			$grandTotalSGST = 0;
			$grandTotalIGST = 0;
			$grandTotalGST = 0;
			$grandTotalBillAmt = 0;
			
            if ($search_purchase_register) {
				
				$totalRowGST = 0;
				$pageTotalTaxable = 0;
				$pageTotalCGST = 0;
				$pageTotalSGST = 0;
				$pageTotalIGST = 0;
				$pageTotalGST = 0;
				$pageTotalRoundOff = 0;
				$pageTotalBillAmt = 0;
				
                foreach ($search_purchase_register as $row) {
					$totalAmt = $totalAmt+$row['total']; 
					
					$pageTotalTaxable+= $row['purchaseDtl']['gst_taxable'];
					$pageTotalCGST+= $row['purchaseDtl']['cgst_amt'];
					$pageTotalSGST+= $row['purchaseDtl']['sgst_amt'];
					$pageTotalIGST+= $row['purchaseDtl']['igst_amt'];
					$pageTotalRoundOff+= $row['round_off']; 
					$pageTotalBillAmt+= $row['total'];
					
					$totalRowGST =  $row['purchaseDtl']['cgst_amt']+$row['purchaseDtl']['sgst_amt']+$row['purchaseDtl']['igst_amt'];
					
                    ?>
                    <tr>
                        <td> <?php  echo $row['purchase_invoice_number'];?></td>
                        <td><?php echo date("d-m-Y",strtotime($row['purchase_invoice_date']));?></td>
                        <td> <?php echo $row['vendor_name'];?></td>
                        <td> <?php  echo $row['sale_number'];?></td>
                        <td align="right"><?php echo $row['bagDtl']['actualBag'];?></td>
                        <td align="right"><?php echo number_format($row['bagDtl']['totalkgs'],2);?></td>
                        <td align="right"><?php echo number_format($row['purchaseDtl']['gst_taxable'],2);?></td>
                        <td align="right"><?php echo number_format($row['purchaseDtl']['cgst_amt'],2);?></td>
                        <td align="right"><?php echo number_format($row['purchaseDtl']['sgst_amt'],2);?></td>
                        <td align="right"><?php echo number_format($row['purchaseDtl']['igst_amt'],2);?></td>
                        <td align="right"><?php echo number_format($totalRowGST,2);?></td>
                        <td align="right"><?php echo number_format($row['round_off'],2);?></td>
                        <td align="right"><?php echo number_format($row['total'],2);?></td>
                    </tr>
                    <?php 
                        $grandTotal = $grandTotal + $row['total']; 
                        $lncount = $lncount+1;
                        if($lncount>18){
                    ?>
					
                    <tr>
                        <td colspan="6" align="left"><b>Page Total</b></td>
                        <td align="right"><b><?php echo number_format($pageTotalTaxable,2);?></b></td>
                        <td align="right"><b><?php echo number_format($pageTotalCGST,2);?></b></td>
                        <td align="right"><b><?php echo number_format($pageTotalSGST,2);?></b></td>
                        <td align="right"><b><?php echo number_format($pageTotalIGST,2);?></b></td>
                        <td align="right"><b><?php echo number_format(($pageTotalCGST+$pageTotalSGST+$pageTotalIGST),2);?></b></td>
                        <td align="right"><b><?php echo number_format($pageTotalRoundOff,2);?></b></td>
						<td align="right"><b><?php echo number_format($pageTotalBillAmt,2);?></b></td>
                    </tr> 
					
                    </table>
                    <div class="break"></div>
                    <?php $lncount=1; ?>
                    <table width="100%">
                        <tr><td align="center"><b>Purchase Register GST</b></td></tr>
                     
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
						<th>Bill No</th>
						<th>Bill Dt</th>
						<th>Vendor</th>
						<th>Sale</th>
						<th>Bag</th>
						<th>Net Wt.</th>
						<th>Taxable</th>
						<th>CGST</th>
						<th>SGST</th>
						<th>IGST</th>
						<th>Tot GST</th>
						<th>R/O</th>
						<th>Bill Amt</th>
					  </tr>
                    
                    
                    
                        <?php } ?>
                    <?php
                    
				
					$grandTotalTaxable+= $row['purchaseDtl']['gst_taxable'];
					$grandTotalCGST+= $row['purchaseDtl']['cgst_amt'];
					$grandTotalSGST+= $row['purchaseDtl']['sgst_amt'];
					$grandTotalIGST+= $row['purchaseDtl']['igst_amt'];
					$grandTotalRoundOff+= $row['round_off'];
					$grandTotalBillAmt+= $row['total'];;
                    
                }
            } else {
                ?>
                <tr>
                    <td colspan="13" align="center">No data found....!!!</td>
                </tr>
            <?php } ?>
				
                <tr>
                     <td colspan="6" align="left"><b>Grand Total</b></td>
					 <td align="right"><b><?php echo number_format($grandTotalTaxable,2); ?></b></td>
					 <td align="right"><b><?php echo number_format($grandTotalCGST,2); ?></b></td>
					 <td align="right"><b><?php echo number_format($grandTotalSGST,2); ?></b></td>
					 <td align="right"><b><?php echo number_format($grandTotalIGST,2); ?></b></td>
					 <td align="right"><b><?php echo number_format(($grandTotalCGST+$grandTotalSGST+$grandTotalIGST),2); ?></b></td>
					 <td align="right"><b><?php echo number_format($grandTotalRoundOff,2); ?></b></td>
					 <td align="right"><b><?php echo number_format($grandTotalBillAmt,2); ?></b></td>
				</tr> 
        </table>
                
    </body>
</html>