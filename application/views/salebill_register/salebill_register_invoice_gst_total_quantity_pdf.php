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
        </style>
    </head>
    <body>

        <table width="100%">
            <tr><td align="center"><b>Sales Register (Finish Product Sale)</b></td></tr>
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
				<th style="font-size:12px;">Product</th>
                <th style="font-size:12px;">Quantity</th>
                <th style="font-size:12px;">Rate</th>
                <th style="font-size:12px;">Discount</th>
                <th style="font-size:12px;">Taxable</th>
                <th style="font-size:12px;">CGST Amt</th>
                <th style="font-size:12px;">SGST Amt</th>
                <th style="font-size:12px;">IGST Amt</th>
                <th style="font-size:12px;">Total GST</th>
                
              
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

            $previousproduct="";
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
                $totalgstByproduct=0;
                $billtotbyproduct=0;
                $start=0;
                $GrandTotalQuantity=0;
                $GrandTotalRate=0;
                $GrandTotalDistount=0;
                $GrandTotalTaxable=0;
                $GrandTotalCgst=0;
                $GrandTotalSgst=0;
                $GrandTotalIgst=0;
                $GrandTotalgst=0;
                $GrandTotalBillAmount=0;

				
                foreach ($resultSalebill as $row) {
					
			

                     if($lastproductid!=$row['productPacketId']){
                        if($start!=0){
                    ?>
                    <tr>
                      <td ><?php
                      echo $previousproduct; ?></td>
                    
                      <td style="text-align: right;"><?php echo number_format($qtyCntByProduct,2);
                                                $GrandTotalQuantity=$GrandTotalQuantity+$qtyCntByProduct;
                                                $qtyCntByProduct=0;
                                                $lnCount = $lnCount+1;
                      ?></td>
                     <td style="text-align: right;"><?php echo number_format($rateCntByproduct,2);
                                    $GrandTotalRate=$GrandTotalRate+$rateCntByproduct;
                                    $rateCntByproduct=0;
                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($discountCountByproduct,2);
                                    $GrandTotalDistount=$GrandTotalDistount+$discountCountByproduct;
                                    $discountCountByproduct=0;


                     ?> </td>
                     <td style="text-align: right;"><?php echo number_format($taxableByproduct,2);
                                    $GrandTotalTaxable=$GrandTotalTaxable+$taxableByproduct;
                                    $taxableByproduct=0;
                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($cgstamtByproduct,2);
                                $GrandTotalCgst=$GrandTotalCgst+$cgstamtByproduct;
                                $cgstamtByproduct=0;
                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($sgstamtByproduct,2);
                                $GrandTotalSgst=$GrandTotalSgst+$sgstamtByproduct;
                                $sgstamtByproduct=0;

                     ?></td>
                     <td style="text-align: right;"><?php  if ($igstamtByproduct>0) {
                             echo number_format($igstamtByproduct,2);
                        }
                                $GrandTotalIgst=$GrandTotalIgst+$igstamtByproduct;
                                $igstamtByproduct=0;

                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($totalgstByproduct,2);

                                        $GrandTotalgst=$GrandTotalgst+$totalgstByproduct;
                                        $totalgstByproduct=0;
                     ?></td>

                    </tr>
                        <?php }?>
                   
                    <?php
                    $start=1;

                     }?>
                     <?php 

                        $qtyCntByProduct=$qtyCntByProduct+$row['quantity'];
                        $rateCntByproduct=$rateCntByproduct+$row['rate'];
                        $rowdiscount=($row['quantity']*$row['rate'])-$row['taxableamount'];
                        $discountCountByproduct=$discountCountByproduct+$rowdiscount;
                        $taxableByproduct=$taxableByproduct+$row['taxableamount'];
                        $cgstamtByproduct=$cgstamtByproduct+$row['cgstamount'];
                        $sgstamtByproduct=$sgstamtByproduct+$row['sgstamount'];
                        $igstamtByproduct=$igstamtByproduct+$row['igstamount'];
                        $totalgstByproduct=$totalgstByproduct+$row['cgstamount']+$row['sgstamount']+$row['igstamount'];
                        
                        $billtotbyproduct= $billtotbyproduct+$row['grandTotalAmt'];
                        ?>
                
                    <?php ?>
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

                              

                       <?php }?>
                    
                    
                    
                    <?php
                    $lastproductid=$row['productPacketId'];
                    $previousproduct=$row['finalProduct'];
                }
            } else {
                ?>
                <tr>
                    
					<td>No data found....!!!</td>
					<td>&nbsp;</td>
				
				</tr>
            <?php } ?>
		

                <tr>
                     <td ><?php
                      echo $previousproduct;?></td>
                      
                      <td style="text-align: right;"><?php echo number_format($qtyCntByProduct,2);
                                                $GrandTotalQuantity=$GrandTotalQuantity+$qtyCntByProduct;
                                                $qtyCntByProduct=0;
                      ?></td>
                     <td style="text-align: right;"><?php echo number_format($rateCntByproduct,2);
                                    $GrandTotalRate=$GrandTotalRate+$rateCntByproduct;
                                    $rateCntByproduct=0;
                     ?></td>
                      <td style="text-align: right;"><?php echo number_format($discountCountByproduct,2);
                                    $GrandTotalDistount=$GrandTotalDistount+$discountCountByproduct;
                                    $discountCountByproduct=0;

                     ?> </td>
                      <td style="text-align: right;"><?php echo number_format($taxableByproduct,2);
                                    $GrandTotalTaxable=$GrandTotalTaxable+$taxableByproduct;
                                    $taxableByproduct=0;
                     ?></td>
                      <td style="text-align: right;"><?php echo number_format($cgstamtByproduct,2);
                                $GrandTotalCgst=$GrandTotalCgst+$cgstamtByproduct;
                                $cgstamtByproduct=0;
                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($sgstamtByproduct,2);
                                $GrandTotalSgst=$GrandTotalSgst+$sgstamtByproduct;
                                $sgstamtByproduct=0;

                     ?></td>
                       <td style="text-align: right;"><?php
                        if ($igstamtByproduct>0) {
                             echo number_format($igstamtByproduct,2);
                        }
                       
                                $GrandTotalIgst=$GrandTotalIgst+$igstamtByproduct;
                                $igstamtByproduct=0;

                     ?></td>
                     <td style="text-align: right;"><?php echo number_format($totalgstByproduct,2);

                                        $GrandTotalgst=$GrandTotalgst+$totalgstByproduct;
                                        $totalgstByproduct=0;
                     ?></td>
                      

                    </tr>

                     <tr>
                     <td  style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: center;">Grand Total </td>
                      
                      <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalQuantity,2);
                                               
                                                
                      ?></td>
                     <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalRate,2);
                                               
                                                
                      ?></td>
                     <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalDistount,2);?></td>
                     <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalTaxable,2);?></td>
                      <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalCgst,2);?></td>
                      <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalSgst,2);?></td>
                     <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php 
                     if ($GrandTotalIgst>0) {
                        echo number_format($GrandTotalIgst,2);
                     }
                     ?></td>
                     <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo number_format($GrandTotalgst,2);?></td>

                    </tr>
        </table>
		
		


    </body>
</html>