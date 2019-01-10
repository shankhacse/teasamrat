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
                $start=0;
                $GrandTotalQuantity=0;
				
                foreach ($resultSalebill as $row) {
					
			

                     if($lastproductid!=$row['productPacketId']){
                        if($start!=0){
                    ?>
                    <tr>
                      <td ><?php
                      echo $previousproduct; ?></td>
                    
                      <td style="text-align: right;"><?php echo $qtyCntByProduct;
                                                $GrandTotalQuantity=$GrandTotalQuantity+$qtyCntByProduct;
                                                $qtyCntByProduct=0;
                                                $lnCount = $lnCount+1;
                      ?></td>
                    

                    </tr>
                        <?php }?>
                   
                    <?php
                    $start=1;

                     }?>
                     <?php 

                        $qtyCntByProduct=$qtyCntByProduct+$row['quantity'];
                              echo $row['quantity'];
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
                      
                      <td style="text-align: right;"><?php echo $qtyCntByProduct;
                                                $GrandTotalQuantity=$GrandTotalQuantity+$qtyCntByProduct;
                                                $qtyCntByProduct=0;
                      ?></td>
                      

                    </tr>

                     <tr>
                     <td  style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: center;">Total Quantity</td>
                      
                      <td style="background:#F0F0F0;font-family:Verdana, Geneva, sans-serif;font-size:10px;font-weight:bold;text-align: right;"><?php echo $GrandTotalQuantity;
                                               
                                                
                      ?></td>
                      

                    </tr>
        </table>
		
		


    </body>
</html>