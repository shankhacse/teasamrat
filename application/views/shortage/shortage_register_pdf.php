<html>
    <head>
        <title>Shortage Register</title>
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
            <tr><td align="center"><b>Shortage Register</b></td></tr>
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
               <th rowspan="2" align="left">Purchase <br> Invoice</th>
               <th rowspan="2" align="right">Garden<br> Invoice</th>
               <th rowspan="2" align="center">Grade</th>
               <th colspan="3">Received</th>
               <th colspan="4">Shortage </th>
               <th colspan="4">Return </th>
               
               
           </tr>
           <tr>
               <th align="right" >Total Bags</th>
               <th align="right" >Net</th>
               <th align="left"  >Total Kgs.</th>

               <th align="right" >Total Bags</th>
               <th align="right" >Net</th>
               <th align="left"  >Total Kgs.</th>
               <th align="left"  >Challan No</th>

               <th align="right" >Total Bags</th>
               <th align="right" >Net</th>
               <th align="left"  >Total Kgs.</th>
               <th align="left"  >Challan No</th>
         
              
           </tr>


            <?php

           /* echo "<pre>";
            print_r($resultBlending);
            echo "</pre>";*/
        			
           if(!empty($resultshortage)){
             $lnCount = 1;
				     $transporterid=0;
                foreach ($resultshortage as $row) {
					
					
					       if($transporterid!=$row['transportid']){
                ?>
                   <tr>
                     <td colspan="14" style="font-weight:bold;"><?php echo $row['transportername'];?></td>
                   </tr>
                  <?php }?>
                    <tr>
						
                        <td style="font-size:11px;"><?php echo $row['purchase_invoice_number'] ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['invoice_number']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['grade'];?></td>

                        <td align="right" style="font-size:11px;"><?php echo $row['parent_no_of_bags'] ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['parent_net']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['parent_no_of_bags']*$row['parent_net'];?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['no_of_bags']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['shortkg']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['no_of_bags']*$row['shortkg']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $row['challanno']; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $returnbags=$row['return_row']->no_of_bags; ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $returnnet=$row['return_row']->net; ?></td>
                        <td align="right" style="font-size:11px;"><?php 
                                                                  $totalreturn=$returnbags*$returnnet;
                                                                  if($totalreturn>0){
                                                                    echo $totalreturn;
                                                                  }

                                                                  ?></td>
                        <td align="right" style="font-size:11px;"><?php echo $returnbags=$row['return_row']->challanno; ?></td>
                     
                    
						
                    </tr>
                   <?php $lnCount = $lnCount+1;?>

                     <?php if($lnCount>30){?>
                    </table>
                        
                        <div class="break"></div>
                      <?php $lnCount=1; ?>
                        
                        <table width="100%">
                                        <tr><td align="center"><b>Shortage Register</b></td></tr>
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
                                       <th align="right" >Total Bags</th>
                                       <th align="right" >Net</th>
                                       <th align="left"  >Total Kgs.</th>

                                       <th align="right" >Total Bags</th>
                                       <th align="right" >Net</th>
                                       <th align="left"  >Total Kgs.</th>
                                       <th align="left"  >Challan No</th>

                                       <th align="right" >Total Bags</th>
                                       <th align="right" >Net</th>
                                       <th align="left"  >Total Kgs.</th>
                                       <th align="left"  >Challan No</th>
                                 
                                      
                                   </tr>
                                  


                       <?php 

                     

                     }?>



                 
                        
            <?php 
                   $transporterid=$row['transportid'];
          } 

        }else{   ?>



        <tr>
                   
                    
                    <td style="text-align: center;" colspan="14">No data found....!!!</td>
                  
                </tr>

   <?php     }

       ?>

             
			
        </table>
		
		


    </body>
</html>