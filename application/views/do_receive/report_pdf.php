<style>
    table.minimalistBlack {
  border: 0px solid #000000;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 0.25px solid #000000;
  padding: 3px 2px;
}
table.minimalistBlack tbody td {
  font-size: 11px;
}
table.minimalistBlack thead {
  background: #CFCFCF;
  background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  border-bottom: 0px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 10px;
  font-weight: bold;
  color: #000000;
  text-align: left;
}
table.minimalistBlack tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #000000;
  border-top: 0px solid #000000;
}
table.minimalistBlack tfoot td {
  font-size: 14px;
}
</style>
<table>
    <tr>
        <th style="text-align: center"><?php echo($company);?></th>
    </tr>
    <tr>
        <th style="text-align: center"> <?php echo($companylocation);?></th>
    </tr>
    <tr>
        <th style="text-align: center"> <?php echo($transporter);?></th>
    </tr>
</table>
<?php //echo($transporter);?>
<table>
    <thead>
        <tr>
            <th>Transporter wise inward challan <?php echo(" From ".$from ." To ".$todt); ?></th>
            
        </tr>
        
    </thead>
    <tbody>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </tbody>    
</table>
<table class="minimalistBlack">
<thead>
<tr>
        <th>Challan</th>
        <th>Challan Dt.</th>
        <th>Garden</th>
        <th>Do.Number</th>
        <th>Invoice</th>
        <th>Grade</th>
        <th>Bags</th>
        <th>Net</th>
        
        
</tr>
</thead>
<tbody>
 
         
                                 <?php if($data){
                                     $sl=0; 
                                     $totalNumaberOfBags=0;
                                     $totalNetWeight=0;
                                     foreach ($data as $content){
                                           $sl=$sl+1;
                                           ?>
                                            <tr>
                                                <td>
                                                    <?php echo($content['chalanNumber']); ?>
                                                    
                                                    </td>
                                                 <td>
                                                   <?php echo($content['chalanDate']); ?>
                                                 </td>

                                                <td>
                                                   <?php echo($content['garden_name']); ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo($content['do']);?>
                                                </td>
                                                
                                                
                                                <td>
                                                   <?php echo($content['invoice_number']); ?>
                                                </td>
                                                <td>
                                                    <?php echo($content['grade']);?>
                                                </td>
                                                <td style="text-align: right;">
                                                   
                                                 <?php if($content['Bags']){ 
                                                     $totalNewWeight=0;
                                                     $totalBagsCount=0;
                                                     foreach($content['Bags'] as $value){
                                                         $totalNewWeight=$totalNewWeight + ($value->no_of_bags * $value->net);
                                                         $totalBagsCount =$totalBagsCount + $value->no_of_bags;
                                                      ?>
                                
<!--                                                        <tr>
                                                            <td><?php echo($value->bagtype);?></td>
                                                            <td><?php echo($value->no_of_bags);?></td>
                                                            <td>X</td>
                                                            <td><?php echo($value->net);?></td>
                                                        </tr>-->
                                                        <?php 

                                                        }
                                                        $totalNumaberOfBags=$totalNumaberOfBags+$totalBagsCount;
                                                        
                                                        echo ($totalBagsCount);
                                                        } 
                                                        ?>
                           
                                                </td>
                                                
                                                <td style="text-align: right;">
                                                    <?php 
                                                    $totalNetWeight=$totalNetWeight+$totalNewWeight;
                                                    echo($totalNewWeight);
                                                        //echo ('xxxxx');
                                                    ?>
                                                </td>
                                                
                                                
                                               
                                                 
                                              
                                                
                                            </tr>
                                 <?php 
                                       
                                       }
                                       
                                       }
                                 ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    Total :
                                                </td>
                                                <td style="text-align: right;">
                                                    <span style="color:#360; font-size:12px ; font-weight:bold">
                                                    <?php echo($totalNumaberOfBags); ?>
                                                    </span>
                                                </td>
                                                <td style="text-align: right;">
                                                    <span style="color:#360; font-size:12px ; font-weight:bold">
                                                    <?php echo($totalNetWeight); ?>
                                                        </span>
                                                </td>
                                            </tr>                       
    </tbody>                                              
    </table>






