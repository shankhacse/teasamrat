
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Purchase Register (GST)</title>

        <style>
            .demo {
                border:1px solid #C0C0C0;
                border-collapse:collapse;
                padding:5px;
            }
            .demo th {
                border:1px solid #C0C0C0;
                padding:5px;
                background:#F0F0F0;
                font-family:Verdana, Geneva, sans-serif;
                font-size:12px;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:5px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:11px;		

            }
            .small_demo {
                border:1px solid;
                padding:2px;
            }
            .small_demo td {
                //border:1px solid;
                padding:2px;
                width: auto;
                font-family:Verdana, Geneva, sans-serif; 
                font-size:11px; font-weight:bold;
            }


            .headerdemo {
                border:1px solid #C0C0C0;
                padding:2px;
            }

            .headerdemo td {
                //border:1px solid #C0C0C0;
                padding:2px;
            }
            .demo_font{
                font-family:Verdana, Geneva, sans-serif;
                font-size:11px;	
            }
			
			 .break{
            page-break-after: always;
        }
        </style>



    </head>
    <body>

<table width="100%" class="" style="border:1px solid #FFF;">
  <tr>
    <td  align="center">
    <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">PURCHASE REGISTER<br>
      For Period <?php echo $forperiod; ?></span>
      </td>
  </tr>
  <tr >
    <td align="right"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">Date : <?php echo date("d-m-Y"); ?></span></td>
  </tr>
</table>
<table >
  <tr>
    <td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $company; ?></span></td>
  </tr>
  <tr>
    <td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $companylocation; ?></span></td>
  </tr>
</table>

    <table width="100%" class="demo" style="margin-top:10px;">
        <tr>
            <th>#</th>
            <th align="left">Bill No</th>
            <th align="left">Bill Date</th>
            <!--<th align="left">Vendor</th>-->
            <th align="right">Taxable</th>
            <th align="right">CGST</th>
            <th align="right">SGST</th>
            <th align="right">IGST</th>
            <th align="right" width="10%">Tot GST</th>
            <th align="right">R/O</th>
            <th align="right">Bill Amt</th>
        </tr>
		<?php
				
			$vendorWisePurchase=array();
			foreach($purchaseRegister as $value ) {
				$vendorWisePurchase[$value['vendorId']][] = $value;
			}
			
			$lnCount = 0;
			
			if($vendorWisePurchase)
			{
			
				$vendorName = "";
				$k=0;
				$totalRoundOff = 0;
				$totalAmount = 0;
				$totalTaxable = 0;
                $totalcgst = 0;
                $totalsgst = 0;
                $totaligst = 0;
                $totalgst = 0;
				$totalAmount = 0;
										
				foreach($vendorWisePurchase as $grpwise_data){
					
					 $vendorName =  $grpwise_data[$k]['vendorname'];
					 
				
					
					$grpRoundOff = 0;
					$grpTotalAmt = 0;
					$grpTaxable = 0;
					$grpCGST = 0;
					$grpSGST = 0;
					$grpIGST = 0;
					$grpGST = 0;
					$grpBillAmt = 0;
				?>

				
				<tr>
                    <td align="left" colspan="10" style="font-weight:bold;"><?php echo $vendorName; ?></td>
                </tr>
					
					
				<?php
					$i=1;
					$lnCount+=1;
					
					foreach($grpwise_data as $purchase_reg)
					{ 
						
						if (is_null($purchase_reg['roundoff']))
                        {
                            $roundoff =0;
                        }
                        else
                        {
                            $roundoff = $purchase_reg['roundoff'];
                        }
						
						$totalRoundOff+= $roundoff;
						$totalTaxable+= $purchase_reg['taxableamount'];
						$totalcgst+= $purchase_reg['cgstamount'];
						$totalsgst+= $purchase_reg['sgstamount'];
						$totaligst+= $purchase_reg['igstamount'];
						$totalgst+= $purchase_reg['gstincludedamt'];
						$totalAmount+= $purchase_reg['billtotal'];
					
					
					
					
						$grpRoundOff+= $roundoff;
						$grpTaxable+= $purchase_reg['taxableamount'];
						$grpCGST+= $purchase_reg['cgstamount'];
						$grpSGST+= $purchase_reg['sgstamount'];
						$grpIGST+= $purchase_reg['igstamount'];
						$grpGST+= $purchase_reg['gstincludedamt'];
						$grpBillAmt+= $purchase_reg['billtotal'];
					?>
						
						<tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $purchase_reg['BillNo']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($purchase_reg['BillDate'])); ?></td>
                           <!-- <td><?php echo $purchase_reg['vendorname']; ?></td>-->
                            <td align="right"><?php echo $purchase_reg['taxableamount']; ?></td>
                            <td align="right"><?php echo $purchase_reg['cgstamount']; ?></td>
                            <td align="right"><?php echo $purchase_reg['sgstamount']; ?></td>
                            <td align="right"><?php echo $purchase_reg['igstamount']; ?></td>
                            <td align="right" width="10%"><?php echo $purchase_reg['gstincludedamt']; ?></td>
                            <td align="right"><?php echo $purchase_reg['roundoff']; ?></td>
                            <td align="right"><?php echo $purchase_reg['billtotal']; ?></td>
                        </tr>	

					
						
				<?php
					$lnCount++;
					if($lnCount>=26)
					{ 
						
					?>
					
                    </table>
					
                    <div class="break"></div>
                    <?php $lnCount=1; ?>
					
					<table width="100%" class="" style="border:1px solid #FFF;">
						  <tr>
							<td  align="center">
							<span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">PURCHASE REGISTER<br>
							  For Period <?php echo $forperiod; ?></span>
							  </td>
						  </tr>
						  <tr >
							<td align="right"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">Date : <?php echo date("d-m-Y"); ?></span></td>
						  </tr>
					</table>
						<table >
						  <tr>
							<td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $company; ?></span></td>
						  </tr>
						  <tr>
							<td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $companylocation; ?></span></td>
						  </tr>
						</table>

							<table width="100%" class="demo" style="margin-top:10px;">
								<tr>
									<th>#</th>
									<th align="left">Bill No</th>
									<th align="left">Bill Date</th>
									<!--<th align="left">Vendor</th>-->
									<th align="right">Taxable</th>
									<th align="right">CGST</th>
									<th align="right">SGST</th>
									<th align="right">IGST</th>
									<th align="right" width="10%">Tot GST</th>
									<th align="right">R/O</th>
									<th align="right">Bill Amt</th>
								</tr>
					<?php	
						
					}
					
					
					} // 2nd foreach end 
				?>
					
				
				<tr>
                    <td colspan="3">Group Total</td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpTaxable; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpCGST; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpSGST; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpIGST; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpGST; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo number_format($grpRoundOff,2); ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $grpBillAmt; ?></td>
                    
                </tr>

					
					
					
			<?php		
					
					
				}?>
				
				<tr>
                    <td colspan="3">Total </td>
                    <td align="right" style="font-weight:bold;"><?php echo $totalTaxable; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $totalcgst; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $totalsgst; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $totaligst; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $totalgst; ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo number_format($totalRoundOff,2); ?></td>
                    <td align="right" style="font-weight:bold;"><?php echo $totalAmount; ?></td>
                    
                </tr>
		<?php		
			}
			
		?>
            </table>

		

    </body>
</html>