<html>
    <head>
        <title>Blending Register</title>
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
            <tr><td align="center"><b>Blending Register</b></td></tr>
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

        <table  class="demo" width="100%" style="font-family:Verdana, Geneva, sans-serif;">

             <tr>
               <th rowspan="2" align="center">Blend Ref</th>
               <th rowspan="2" align="center">Blending Date</th>
               <th rowspan="2" align="center" width="15%">Product</th>
               <th colspan="4">In Kgs.</th>
               
               
               
           </tr>
           <tr>
            <th align="center" width="12%">Qty</th>
            <th align="center" width="12%">Cons</th>
            <th align="center" width="10%">Excess</th>
            <th align="center" width="10%">Short</th>
               
           </tr>


            <?php

           /* echo "<pre>";
            print_r($resultBlending);
            echo "</pre>";*/
        			
           if(!empty($resultBlending)){
             $lnCount = 1;
				
                foreach ($resultBlending as $row) {
					
					
					
                ?>
                    <tr>
						
                        <td style="font-size:11px;"><?php echo $row['blending_ref']; ?></td>
                        <td style="font-size:11px;"><?php echo date('d-m-Y',strtotime($row['blending_date'])); ?></td>
                        <td ><?php echo $row['product']; ?></td>
                        <td align="right"><?php echo $row['blendKgs']; ?></td>
                        <td align="right"><?php echo $row['blendCons']; ?></td>
                        <?php 
                            $blendKgs=$row['blendKgs'];
                            $blendCons=$row['blendCons'];
                           // echo number_format($balance);
                            ?>
                        <td align="right"> 
                                    <?php 
                                            if ($blendKgs>$blendCons) {
                                              $balance=$blendKgs-$blendCons;
                                              echo number_format($balance,2);
                                            }

                                    ?>

                        </td>
						<td align="right"> 
                            <?php 
                                            if ($blendCons>$blendKgs) {
                                              $balance=$blendCons-$blendKgs;
                                              echo number_format($balance,2);
                                            }

                                    ?>

                        </td>
						
                    </tr>
                   <?php $lnCount = $lnCount+1;?>

                     <?php if($lnCount>30){?>
                    </table>
                        
                        <div class="break"></div>
                      <?php $lnCount=1; ?>
                        
                        <table width="100%">
                                        <tr><td align="center"><b>Blending Register</b></td></tr>
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
                                       <th rowspan="2" align="center">Blend Ref</th>
                                       <th rowspan="2" align="center">Blending Date</th>
                                       <th rowspan="2" align="center" width="15%">Product</th>
                                       <th colspan="4">In Kgs.</th>
                                       
                                       
                                       
                                   </tr>
                                   <tr>
                                    <th align="center" width="12%">Qty</th>
                                    <th align="center" width="12%">Cons</th>
                                    <th align="center" width="10%">Excess</th>
                                    <th align="center" width="10%">Short</th>
                                       
                                   </tr>


                       <?php }?>




                        
            <?php } 

        }else{   ?>



        <tr>
                   
                    
                    <td style="text-align: center;" colspan="7">No data found....!!!</td>
                  
                </tr>

   <?php     }

       ?>

             
			
        </table>
		
		


    </body>
</html>