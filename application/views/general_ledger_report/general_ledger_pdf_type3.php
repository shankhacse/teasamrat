<html>
    <head>
        <title>General Ledger Report</title>
        <style>
            .demo {
		border:0px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
        .demo th {
		border:0px solid #C0C0C0;
		padding:4px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:0px solid #C0C0C0;
		padding:6px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;		
		
	}
        .table_head{
            height:45px;
            border:none;
        }
        .break{
            page-break-after: always;
        }
        </style>
    </head>
    <body>
       
        <table width="100%" class="">
               <tr>
                   <td align="center">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                </tr>
        </table>
        <table width="100%" class="">
               <tr>
                   <td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:bold;"><?php echo $accountname;?></span></td>
               </tr>
        </table>
        
        
       <table width="100%">
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        
       <table width="100%">
           <tr>
               <td width="50%" align="left">
                   <table >
                        <tr>
                            <td align="left"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Print Date : <?php echo date('d-m-Y');?></span></td>
                        </tr>
                    </table>
               </td>
               <td width="35%" align="right">
                   <table>
                        <tr>
                            <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
                        </tr>
                        <tr>
                            <td align="center"><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
                        </tr>
                   </table>
               </td>
           </tr>
        </table>
        <div style="padding:4px"></div>
        <div style="padding:4px"></div>
       
		<table width="100%" class="demo" border="">
			<tr>
               <th>Date</th>
               <th align="left">Particulars</th>
               <th align="left">Type</th>
               <th align="left">Voucher No</th>
               <th align="right">Debit</th>
               <th align="right">Credit</th>
           </tr>
		  
		   		<?php if($generalledger){
                       $totalDebit = 0;
                       $totalCredit = 0;
					  foreach($generalledger as $ledger_report_type2){ 
				?>
                 <tr>
					<td><?php echo date("d-m-Y", strtotime($ledger_report_type2['VchDate']));  ?> </td>
					<td>
                    
                    <?php
                       if($ledger_report_type2['VchAccountDetailsAccountName']!=""){ 
                        $accountsName = explode(",",$ledger_report_type2['VchAccountDetailsAccountName']);
                        $accountsTags = explode(",",$ledger_report_type2['VchAccountDetailscrdrtag']);
                        $accountsAmount = explode(",",$ledger_report_type2['VchAccountDetailsAmount']);
                        $arrayCount = count($accountsName);
                    ?>
                        <table style="border: 1px solid #E6E6E6;font-size:10px;">
                        <?php for($i=0;$i<$arrayCount;$i++){ 
                          if ($accountsAmount[$i]!='' && $accountsAmount[$i]!=0) {
                          
                          ?>
                            <tr>
                                <td> <?php echo($accountsName[$i]); ?> </td>
                                <td align="right"> 
                                <?php 
                                   if($accountsTags[$i]=="Y"){echo("Dr");}else{echo("Cr");} 
                                ?>
                                </td>
                                <td align="right"> <?php echo($accountsAmount[$i]); ?> </td>
                            </tr>
                        <?php }}
                         ?>
                        </table>
                    <?php } ?>
                    </td>	
					<td><?php echo($ledger_report_type2['VchType']);?></td>
					<td><?php echo($ledger_report_type2['vchNumber']); ?> </td>
					<td align="right"><?php echo($ledger_report_type2['debitamount']); ?> </td>
					<td align="right"><?php echo($ledger_report_type2['creditamount']); ?> </td>
                </tr>
				<?php
                    $totalDebit = $totalDebit + $ledger_report_type2['debitamount'];
                    $totalCredit = $totalCredit + $ledger_report_type2['creditamount'];
                    $closingBalance =0;
                    $closingBalance = $totalDebit - $totalCredit ;
				 }
				} 
				?>
		   <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="left"></td>
               <td align="right">
               <?php if($totalDebit!=0){?>
                            <hr><strong>
                            <?php 
                                
                                echo ($totalDebit!=0?number_format($totalDebit,2):"" ); 
                            ?></strong>
               <?php } ?>
               </td>
               <td align="right">
               <?php if($totalCredit!=0){?>
               <hr><strong>
               <?php echo ($totalCredit!=0?number_format($totalCredit,2):"" );  ?>
               </strong>
               <?php }?>
               </td>
           </tr>
           <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="left">
               <?php 
                    if($closingBalance<0){
                        
                        echo("Cr Closing" );
                    }else{
                        echo("Dr Closing" );
                    }
                ?>
               </td>
               <td align="right">
                <?php 
                    if($closingBalance<0){
                        $DrclosingBalance = $closingBalance * (-1);
                        echo("<strong>".number_format($DrclosingBalance,2)."</strong>");
                    }else{
                        echo("");
                    }
                ?>
               </td>
               <td align="right">
               <?php 
                    if($closingBalance>0){
                        echo("<strong>".number_format($closingBalance,2)."</strong>");
                    }else{
                        echo("");
                    }
                ?>
               </td>
           </tr>
           <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>

               <td align="right">
               <hr><strong>
               <?php if($closingBalance<0){ 
                        $sumcrdr = ($totalDebit +($closingBalance)) ;
                        if($sumcrdr<0){ $sumcrdr = $sumcrdr * (-1);}
                        echo(number_format($sumcrdr,2));
                    }else{
                        echo(number_format($totalDebit,2));
                    }?>
                <hr> </strong>                   
               </td>
               
               <td align="right">
               <hr><strong>
                    <?php if($closingBalance>0){ 
                        $sumcrdr = $totalCredit + $closingBalance;
                        if($sumcrdr<0){ $sumcrdr = $sumcrdr * (-1);}
                        echo(number_format($sumcrdr,2));
                    }else{
                        echo(number_format($totalCredit,2));
                    }?>
                    </strong>
                <hr>    
               </td>

           </tr>
		
		</table>
                
    </body>
</html>