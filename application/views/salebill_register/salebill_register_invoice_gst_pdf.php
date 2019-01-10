<html>
    <head>
        <title>Salebill Register </title>
        <style>
            .demo {
                //border:1px solid #C0C0C0;
                border-collapse:collapse;
                padding:5px;
            }
            .demo th {
                //border:1px solid #C0C0C0;
                padding:4px;
                background:#F0F0F0;
                font-family:Verdana, Geneva, sans-serif;
                font-size:10pt !important;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:4px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:10pt !important;		

            }
            .break{
                page-break-after: always;
            }
			.th_formt{
				font-size:10px;
			}
            .tdstyle{background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-weight:bold!important;text-align:right;}
        </style>
    </head>
    <body>

        <table width="100%">
            <tr><td align="center"><b>Sales Register (Finish Product Sale)*</b></td></tr>
            <tr><td align="center"><b><?php echo "(".date('d-m-Y',strtotime($fdate))." - ".date('d-m-Y',strtotime($tdate)).")";?></b></td></tr>
        </table>

        <div style="padding:2px 0 5px 0;"></div>

        <table width="100%" class="">
            <tr>
                <td align="left">
                    <span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
                        <?php echo($company); ?> <br/>
                        <?php echo($companylocation) ?>
                    </span>
                </td>
                <td align="right">
                    <span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
                        Print Date : &nbsp;<?php echo($printDate); ?>
                    </span>
                </td>
            </tr>
        </table>

        <div style="padding:4px"></div>

        <table  class="demo" width="100%">

            <tr>
				<th style="font-size:12px;">Customer</th>
                <th style="font-size:12px;">Bill No</th>
                <th style="font-size:12px;">Bill Dt</th>
                <th style="font-size:12px;">Qty</th>
                <th style="font-size:12px;">Rate</th>
                <th style="font-size:12px;">Discount</th>
                <th style="font-size:12px;">Taxable</th>
				<th style="font-size:12px;">CGST Amt.</th>
				<th style="font-size:12px;">SGST Amt.</th>
				<th style="font-size:12px;">IGST Amt.</th>
				<th style="font-size:12px;">Total GST</th>
				<th style="font-size:12px;">Bill Total</th>
			</tr>


            <?php
			$grandTotalAmt = 0;
			$totalAmountSum = 0;
			$totalDiscountSum = 0;
			$totalTaxable = 0;
			$totalCGSTSum = 0;
			$totalSGSTSum = 0;
			$totalIGSTSum = 0;
			$totalQtySum = 0;
            $lastproductid=0;
            if ($resultSalebill) {
                $lnCount = 1;
                $grandTotalAmt = 0;
                $qtyCntByProduct=0;
                $rateCntByproduct=0;
                $discountCountByproduct=0;
                $taxableByproduct=0;
                $cgstamtByproduct=0;
                $sgstamtByproduct=0;
                $igstamtByproduct=0;
                $billtotByproduct=0;
                $totalgstByproduct=0;
                $start=0;

				
                foreach ($resultSalebill as $row) {
					$rowdiscount=0;
					/*$totalQtySum = $totalQtySum+$row['totalQty'];
					$totalCGSTSum = $totalCGSTSum+$row['totalCGST'];
					$totalSGSTSum = $totalSGSTSum+$row['totalSGST'];
					$totalIGSTSum = $totalIGSTSum+$row['totalIGST'];
					$totalDiscountSum = $totalDiscountSum+$row['gstDiscountAmt'];
					$totalTaxable = $totalTaxable+$row['gstTaxableAmt'];
					$totalAmountSum = $totalAmountSum+$row['totalAmount'];
					$grandTotalAmt = $grandTotalAmt+$row['grandTotalAmt'];*/

                     if($lastproductid!=$row['productPacketId']){
                        if($start!=0){
                    ?>
                    <tr style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;">
                      <td colspan="2"></td>
                      <td class="tdstyle" >Total</td>
                      <td class="tdstyle"><?php echo number_format($qtyCntByProduct,2); $qtyCntByProduct=0; ?></td>
                      <td class="tdstyle"><?php echo number_format($rateCntByproduct,2);$rateCntByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($discountCountByproduct,2);$discountCountByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($taxableByproduct,2);$taxableByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($cgstamtByproduct,2);$cgstamtByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($sgstamtByproduct,2);$sgstamtByproduct=0;?></td>
                     <td class="tdstyle"><?php 
                      if ($igstamtByproduct>0) {
                          echo number_format($igstamtByproduct,2);$igstamtByproduct=0;
                      }
                     ?></td>
                      <td class="tdstyle"><?php echo number_format($totalgstByproduct,2);$totalgstByproduct=0;?></td>
                      <td class="tdstyle" > </td>

                    </tr>
                        <?php }?>
                     <tr>
                      <td colspan="12" style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;border-top:3px solid #fff;"><?php
                      echo $row['finalProduct']; ?></td>

                    </tr>
                    <?php
                    $start=1;

                     }?>
                    <tr>
						<td style="font-size:11px;"><input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--" . $row['salebillID']."--".$row['saleType']; ?>" /><?php echo $row['customerName']; ?></td>
                        <td style="font-size:11px;"><?php echo $row['saleBillNo']; ?></td>
                        <td style="font-size:11px;"><?php echo date('d-m-Y',strtotime($row['saleBillDate'])); ?></td>
                        <td align="right"><?php 

                        $qtyCntByProduct=$qtyCntByProduct+$row['quantity'];
                              echo $row['quantity'];
                        ?>
                            
                        </td>
                        <td align="right"><?php 
                            $rateCntByproduct=$rateCntByproduct+$row['rate'];  echo $row['rate'];?></td>
                        <td align="right"><?php
                            $rowdiscount=($row['quantity']*$row['rate'])-$row['taxableamount'];
                            $discountCountByproduct=$discountCountByproduct+$rowdiscount;
                            if ($rowdiscount>0) {
                               echo number_format($rowdiscount,2);
                            }
                        ?></td>
						<td align="right"><?php 
                        $taxableByproduct=$taxableByproduct+$row['taxableamount'];

                        echo $row['taxableamount'];?></td>
						<td align="right"><?php 
                        $cgstamtByproduct=$cgstamtByproduct+$row['cgstamount'];
                        echo $row['cgstamount'];?></td>
						<td align="right"><?php 

                        $sgstamtByproduct=$sgstamtByproduct+$row['sgstamount'];
               
                        echo $row['sgstamount'];?></td>
						<td align="right"><?php 
                         $igstamtByproduct=$igstamtByproduct+$row['igstamount'];
                        echo $row['igstamount'];?></td>
						<td align="right"><?php  
                        $totalgstByproduct=$totalgstByproduct+$row['cgstamount']+$row['sgstamount']+$row['igstamount'];
                        echo $row['cgstamount']+$row['sgstamount']+$row['igstamount'];?></td>
						<td align="right"><?php 
                                 $billtotbyproduct= $billtotbyproduct+$row['grandTotalAmt'];

                                 echo $row['grandTotalAmt'];
                        ?></td>
                    </tr>
                    <?php $lnCount = $lnCount+1;?>
                    <?php if($lnCount>22){?>
                    </table>
                        
                        <div class="break"></div>
                      <?php $lnCount=1; ?>
                        
                        <table width="100%">
                                        <tr><td align="center"><b>Salebill Register (Finish Product Sale)</b></td></tr>
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

                                    <table  class="demo" width="100%">

                                    <tr>
										<th style="font-size:12px;">Customer</th>
										<th style="font-size:12px;">Bill No</th>
										<th style="font-size:12px;">Bill Dt</th>
										<th style="font-size:12px;">Qty</th>
                                        <th style="font-size:12px;">Rate</th>
                                        <th style="font-size:12px;">Discount</th>
										<th style="font-size:12px;">Taxable</th>
										<th style="font-size:12px;">CGST Amt.</th>
										<th style="font-size:12px;">SGST Amt.</th>
										<th style="font-size:12px;">IGST Amt.</th>
										<th style="font-size:12px;">Total GST</th>
										<th style="font-size:12px;">Bill Total</th>
									</tr>

                       <?php }?>
                    
                    
                    
                    <?php
                    $lastproductid=$row['productPacketId'];
                }
            } else {
                ?>
                <tr>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>No data found....!!!</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
            <?php } ?>
			<!-- <tr>
                <td colspan="3" style="font-size:12px;font-weight:bold;">Grand Total </td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalQtySum ,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalTaxable ,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalCGSTSum ,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalSGSTSum ,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalIGSTSum ,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalCGSTSum+$totalSGSTSum+$totalIGSTSum,2); ?></td>
                <td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($grandTotalAmt,2); ?></td>
            </tr> -->

             <tr style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;">
                      <td colspan="2"></td>
                      <td class="tdstyle" >Total</td>
                      <td class="tdstyle"><?php echo number_format($qtyCntByProduct,2); $qtyCntByProduct=0; ?></td>
                      <td class="tdstyle"><?php echo number_format($rateCntByproduct,2);$rateCntByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($discountCountByproduct,2);$discountCountByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($taxableByproduct,2);$taxableByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($cgstamtByproduct,2);$cgstamtByproduct=0;?></td>
                      <td class="tdstyle"><?php echo number_format($sgstamtByproduct,2);$sgstamtByproduct=0;?></td>
                      <td class="tdstyle"><?php 
                      if ($igstamtByproduct>0) {
                          echo number_format($igstamtByproduct,2);$igstamtByproduct=0;
                      }
                     ?></td>
                      <td class="tdstyle"><?php echo number_format($totalgstByproduct,2);$totalgstByproduct=0;?></td>
                      <td class="tdstyle" >  </td>

                    </tr>
        </table>
		
		


    </body>
</html>