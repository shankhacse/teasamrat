<!DOCTYPE html>
<html>

    <head>
        <meta charset='UTF-8'>

        <title>Voucher Register</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
       <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
        
       <style>
  .demo {
    border:0px solid #C0C0C0;
    border-collapse:collapse;
    padding:5px;
  }
  .demo th {
    border:1px solid #C0C0C0;
    padding:5px;
    background:#F0F0F0;
    font-family:Verdana, Geneva, sans-serif;
    font-size:14px;
    font-weight:bold;
  }
  .demo td {
    border:0px solid #C0C0C0;
    padding:5px;
    font-family:Verdana, Geneva, sans-serif;
    font-size:13px;   
    
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
                font-size:13px; font-weight:bold;
  }
        
        
  .headerdemo {
    border:1px solid #C0C0C0;
    padding:2px;
  }
  
  .headerdemo td {
    //border:1px solid #C0C0C0;
    padding:2px;
  }
        .break{
            page-break-after: always;
        }

    .row_bottom 
    {
        border-bottom:1px solid #000;
    }
</style>
    </head>
    
    <body>
        
         <table width="100%">
            <tr><td align="center"><b>Voucher Register</b></td></tr>
            <tr><td align="center" style="font-size:13px;">Period - <?php echo date('d-m-Y',strtotime($fromDate));?> To <?php echo date('d-m-Y',strtotime($toDate));?></td></tr>
        </table>

        <div id="page-wrap">
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
                             Print Date : &nbsp;<?php echo(date("d-m-Y")); ?>
                         </span>
                    </td>
                </tr>
        </table>
        <div style="padding:8px 0px 8px 0px"></div>

        <?php if($transtype!=""){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Type : ".$transtype;?>
        </span><br>
        <?php } ?>

        <?php if($accountname){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Account : ".$accountname;?>
        </span><br>
        <?php } ?>
        
        
        
       

            
               <table id="example" class="demo"  style="width:100%;">
                <tr>
                    <th>Sl.</th>
                    <th>Voucher No.</th>
                    <th>Voucher Date</th>
                    <th >Narration</th>
                    <th>Voucher<br>Type</th>
                    <th align="left">Detail</th>
                </tr>
        
            <tbody>
           <?php if($voucherlist){
               $j=1;
               $lnCount =1;
               foreach($voucherlist as $content){
                ?>
                <tr style="border-bottom: 2px solid #323232 !important;">
                        <td style="vertical-align:top;"><?php echo $j++;?></td>
                        <td style="vertical-align:top;"><?php echo $content['voucher_number']?></td>
                        <td style="vertical-align:top;"><?php echo $content['VoucherDate']?></td>
                        <td width="10%" style="vertical-align:top;"><?php echo $content['narration']?></td>
                        <td style="vertical-align:top;">
                            <?php $purType= $content['transaction_type'];
                                    if($purType=="PR"){
                                        echo "Purchase";
                                    }
                                    if($purType=="CN"){
                                        echo "Contra";
                                    }
                                    if($purType=="GV"){
                                        echo "General";
                                    }
                                    if($purType=="JV"){
                                        echo "Journal";
                                    }
                                     if($purType=="SL"){
                                        echo "Sale";
                                    }
                            ?>
                            
                        
                        </td>
                        <td>
                            <table width="100%">
                             
                            <tr>
                                 <td><b>A/C Description </b></td>
                                 <td align="right"><b>Amount</b></td>
                                 <td><b>Dr/Cr</b></td>
                             </tr>
                             <?php if($content['voucherDtl']){
                                 foreach($content['voucherDtl'] as $value){
                                 ?>
                             
                             <tr>
                                 <td><?php echo $value->account_name;?></td>
                                 <td align="right"><?php echo $value->voucher_amount;?></td>
                                 <td><?php $dbCr= $value->drCr;if($dbCr=="Y"){echo "Dr";}else{echo "Cr";}?></td>
                             </tr>
                            
                             <?php 

                             $lnCount+=1; 


                             if($lnCount>22)
                             { ?>

                                </table>
                            </td>
                            </tr>
                            </table>

                                <div class="break"></div>
                                <?php $lnCount = 1; ?>
                                 <table width="100%">
                                    <tr><td align="center"><b>Voucher Register</b></td></tr>
                                    <tr><td align="center" style="font-size:13px;">Period - <?php echo date('d-m-Y',strtotime($fromDate));?> To <?php echo date('d-m-Y',strtotime($toDate));?></td></tr>
                                 </table>

                                <div id="page-wrap">
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
                                                     Print Date : &nbsp;<?php echo(date("d-m-Y")); ?>
                                                 </span>
                                            </td>
                                        </tr>
                                </table>
                                <div style="padding:8px 0px 8px 0px"></div>

        <?php if($transtype!=""){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Type : ".$transtype;?>
        </span><br>
        <?php } ?>

        <?php if($accountname){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Account : ".$accountname;?>
        </span><br>
        <?php } ?>
        
            <table id="example" class="demo"  style="width:100%;">
                <tr>
                    <th>Sl.</th>
                    <th>Voucher No.</th>
                    <th>Voucher Date</th>
                    <th >Narration</th>
                    <th>Voucher<br>Type</th>
                    <th align="left">Detail</th>
                </tr>
        
            <tbody>
                 <tr style="border-bottom: 2px solid #323232 !important;">
                        <td style="vertical-align:top;"></td>
                        <td style="vertical-align:top;"></td>
                        <td style="vertical-align:top;"></td>
                        <td width="10%" style="vertical-align:top;"></td>
                        <td style="vertical-align:top;"></td>
                        <td>
                            <table width="100%">
                             
                            <tr>
                                 <td><b>A/C Description </b></td>
                                 <td align="right"><b>Amount</b></td>
                                 <td><b>Dr/Cr</b></td>
                            </tr>   
                            <?php
                             }


                            }}?>
                         </table>
                            
                        </td>
                        
                        
                </tr>

        
               <?php 
               $lnCount+=1;

               if($lnCount>22)
               { ?>
                
                </table>
                <div class="break"></div>
            <?php $lnCount = 1; ?>
                        <table width="100%">
            <tr><td align="center"><b>Voucher Register</b></td></tr>
            <tr><td align="center" style="font-size:13px;">Period - <?php echo date('d-m-Y',strtotime($fromDate));?> To <?php echo date('d-m-Y',strtotime($toDate));?></td></tr>
        </table>

        <div id="page-wrap">
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
                             Print Date : &nbsp;<?php echo(date("d-m-Y")); ?>
                         </span>
                    </td>
                </tr>
        </table>
        <div style="padding:8px 0px 8px 0px"></div>

        <?php if($transtype!=""){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Type : ".$transtype;?>
        </span><br>
        <?php } ?>

        <?php if($accountname){?>
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
        <?php echo "Account : ".$accountname;?>
        </span><br>
        <?php } ?>
        
        
        
       

            
               <table id="example" class="demo"  style="width:100%;">
                <tr>
                    <th>Sl.</th>
                    <th>Voucher No.</th>
                    <th>Voucher Date</th>
                    <th >Narration</th>
                    <th>Voucher<br>Type</th>
                    <th align="left">Detail</th>
                </tr>
        
            <tbody>
            <?php 
               }
            }
           } ?>
        
         
    </tbody>                                              
    </table>


        </div>

    </body>

</html>