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
            <tr><td align="center"><b>Purchase Register(GST) - Group Wise</b></td></tr>
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
        <table width="100%" class="demo" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
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
			$grandTotalTaxable = 0;
			$grandTotalCGST = 0;
			$grandTotalSGST = 0;
			$grandTotalIGST = 0;
			$grandTotalGST = 0;
			$grandTotalRoundOff = 0;
			$grandTotalBillAmt = 0;
			$grandTotalBag = 0;
			$grandTotalNetWt = 0;
			
			if(sizeof($search_purchase_register)>0)
			{
				$lnCont = 1;
				
				$totalgst = 0;
				
				$pageTotalTaxable = 0;
				$pageTotalCGST = 0;
				$pageTotalSGST = 0;
				$pageTotalIGST = 0;
				$pageTotalGST = 0;
				$pageTotalBillAmt = 0;
				$pageTotalRoundOff = 0;
				$pageTotalBag = 0;
				$pageTotalNetWt = 0;
				

				foreach($search_purchase_register as $purchase_reg_groupwise)
				{
				$totalgst = $purchase_reg_groupwise['purchaseData']->cgstAmt+$purchase_reg_groupwise['purchaseData']->sgstAmt+$purchase_reg_groupwise['purchaseData']->igstAmt;
				
				$pageTotalTaxable+= $purchase_reg_groupwise['purchaseData']->taxableAmt;
				$pageTotalCGST+= $purchase_reg_groupwise['purchaseData']->cgstAmt;
				$pageTotalSGST+= $purchase_reg_groupwise['purchaseData']->sgstAmt;
				$pageTotalIGST+= $purchase_reg_groupwise['purchaseData']->igstAmt;
				$pageTotalGST+=  $totalgst;
				$pageTotalRoundOff+= $purchase_reg_groupwise['purchaseData']->round_off;
				$pageTotalBillAmt+= $purchase_reg_groupwise['purchaseData']->total;
				
				$pageTotalBag+= $purchase_reg_groupwise['bagDtlData']['totalBags'];
				$pageTotalNetWt+= $purchase_reg_groupwise['bagDtlData']['totalKgs'];
				
			?>
			
			<tr>
				<td><?php echo $purchase_reg_groupwise['purchaseData']->purchase_invoice_number; ?></td>
				<td><?php echo date('d-m-Y',strtotime($purchase_reg_groupwise['purchaseData']->purchase_invoice_date)); ?></td>
				<td><?php echo $purchase_reg_groupwise['purchaseData']->vendor_name; ?></td>
				<td><?php echo $purchase_reg_groupwise['purchaseData']->sale_number; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['bagDtlData']['totalBags']; ?></td>
				<td align="right"><?php echo number_format($purchase_reg_groupwise['bagDtlData']['totalKgs'],2); ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->taxableAmt; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->cgstAmt; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->sgstAmt; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->igstAmt; ?></td>
				<td align="right"><?php echo $totalgst; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->round_off; ?></td>
				<td align="right"><?php echo $purchase_reg_groupwise['purchaseData']->GST_gstincldamt; ?></td>
			</tr>
				
				
				
			<?php
				$lnCont = $lnCont+1;
				if($lnCont>18)
				{ ?>
					<tr>
						<td colspan="4"><b>Page Total</b></td>
						<td><b><?php echo number_format($pageTotalBag); ?></b></td>
						<td><b><?php echo number_format($pageTotalNetWt,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalTaxable,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalCGST,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalSGST,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalIGST,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalGST,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalRoundOff,2); ?></b></td>
						<td><b><?php echo number_format($pageTotalBillAmt,2); ?></b></td>
					</tr>
				</table>
				<div class="break"></div>
			<?php $lnCont = 1; ?>
			<table width="100%">
            <tr><td align="center"><b>Purchase Register(GST) - Group Wise</b></td></tr>
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
        <table width="100%" class="demo" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
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
				}
				
				$grandTotalBag+= $purchase_reg_groupwise['bagDtlData']['totalBags'];
				$grandTotalNetWt+= $purchase_reg_groupwise['bagDtlData']['totalKgs'];
				
				$grandTotalTaxable+= $purchase_reg_groupwise['purchaseData']->taxableAmt;
				$grandTotalCGST+= $purchase_reg_groupwise['purchaseData']->cgstAmt;
				$grandTotalSGST+= $purchase_reg_groupwise['purchaseData']->sgstAmt;
				$grandTotalIGST+= $purchase_reg_groupwise['purchaseData']->igstAmt;
				$grandTotalGST+=  $totalgst;
				$grandTotalRoundOff+= $purchase_reg_groupwise['purchaseData']->round_off;
				$grandTotalBillAmt+= $purchase_reg_groupwise['purchaseData']->total;
				
				}

			?>
				
			<tr>
				<td colspan="4"><b>Grand Total</b></td>
				<td><b><?php echo number_format($grandTotalBag); ?></b></td>
				<td><b><?php echo number_format($grandTotalNetWt,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalTaxable,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalCGST,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalSGST,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalIGST,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalGST,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalRoundOff,2); ?></b></td>
				<td><b><?php echo number_format($grandTotalBillAmt,2); ?></b></td>
			</tr>	
		<?php		
			}
		?>
         
        </table>
                
    </body>
</html>