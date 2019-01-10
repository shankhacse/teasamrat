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
       
       <table width="100%" class="demo" border="1">
           <tr>
               <th>Date</th>
               <th align="left">Particulars</th>
               <th align="left">Vch Type</th>
               <th align="left">Voucher No</th>
               <th align="right">Debit</th>
               <th align="right">Credit</th>
           </tr>
		   
		   <?php 
			if(sizeof($generalledger)){
				$totalDebitAmt = 0;
				$totalCreditAmt = 0;
				$lnCount=1;
				foreach($generalledger as $ledger_report_type2)
				{
					$accountDesc = explode("~",$ledger_report_type2['account']);
					$accTagDesc = explode("~",$ledger_report_type2['accounttag']);
					
					$detailAmtDesc = [];
					if($ledger_report_type2['totalDebit']>0)
					{
						$detailAmtDesc = explode("~",$ledger_report_type2['dbt_string']);
					}
					if($ledger_report_type2['totalCredit']>0)
					{
						$detailAmtDesc = explode("~",$ledger_report_type2['crdt_string']);
					}
				?>
				 <tr>
				   <td style="vertical-align:top;"><?php echo date("d-m-Y",strtotime($ledger_report_type2['voucherdate'])); ?></td>
				   <td style="vertical-align:top;">
					<table style="width:100%;margin-top:0px;">
					<?php  
						$acc ="";
						for($dtl=0;$dtl<sizeof($accountDesc);$dtl++)
						{
							$acc = $accountDesc[$dtl];
							$dtlAmt = $detailAmtDesc[$dtl];
							if($acc=="Opening Balance")
							{
								$dtlAmt = "";
							}
							if($detailAmtDesc[$dtl]>0 OR $acc=="Opening Balance"){
						?>
						<tr>
							<td style="width:60%;vertical-align:top;" ><?php echo $accountDesc[$dtl]; ?></td>
							<td style="width:20%;text-align:right;"><?php if($detailAmtDesc[$dtl]>0){ echo number_format($dtlAmt,2);}else{echo "";} ?></td>
							<td style=""><?php echo $accTagDesc[$dtl]; ?></td>
							
						</tr>
					<?php
							}
						$lnCount+=1;
						
						///
						if($lnCount>=35)
						{
							//echo('<div class="break"></div>');
				            $lnCount = 1; 
							
							/*echo('<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">');
							echo($company); echo('<br/>');
							echo($companylocation); 
							echo('</span>');*/
						}
						///
						
						}
						
					?>
					</table>
				   </td>
				   <td style="vertical-align:top;"><strong><?php echo $ledger_report_type2['transtype']; ?></strong></td>
				   <td style="vertical-align:top;"><?php echo $ledger_report_type2['vouchernumber']; ?></td>
				   <td style="vertical-align:top;text-align:right;"><strong><?php if($ledger_report_type2['totalDebit']>0){echo number_format($ledger_report_type2['totalDebit'],2);} ?></strong></td>
				   <td style="vertical-align:top;text-align:right;"><strong><?php if($ledger_report_type2['totalCredit']>0){echo number_format($ledger_report_type2['totalCredit'],2);} ?></strong></td>
			   </tr>
			<?php
				
				$lnCount+=1;
				if($lnCount>=35)
				{ ?>
				
				</table>
               <!-- <div class="break"></div>-->
				<?php $lnCount = 1; ?>

<!--				
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
        
        
        
			<div style="padding:4px"></div>-->
			<table width="100%" class="demo" border="1">
			   <!--<tr>
				   <th>Date</th>
				   <th align="left">Particulars</th>
				   <th align="left">Vch Type</th>
				   <th align="left">Voucher No</th>
				   <th align="right">Debit</th>
				   <th align="right">Credit</th>
			   </tr>-->
			<?php
				}
				
				$totalDebitAmt+= $ledger_report_type2['totalDebit'];
				$totalCreditAmt+= $ledger_report_type2['totalCredit'];
				
				$differenceAmt = $totalDebitAmt-$totalCreditAmt;
				$absdifferenceAmt=abs($differenceAmt);
				if($differenceAmt>0){$lastbalance = $totalDebitAmt;}
				else{$lastbalance = $totalCreditAmt;}
				
					if($differenceAmt>0)
					{
						$tag = "Dr";
					}
					elseif($differenceAmt==0) 
					{
						$tag="";
					}
					else
					{
						$tag="Cr";
					}
				
				
				}
			}
		   ?>
           
		   
		    <tr>
             
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalDebitAmt==0){echo "";}else{echo number_format($totalDebitAmt,2);}?></td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalCreditAmt==0){echo "";}else{echo number_format($totalCreditAmt,2);}?></td>
           </tr>
		   
		   <tr>
              
               <td><?php echo $tag;?></td>
               <td>Closing Balance</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <?php 
                        if($tag=="Dr"){ 
                           
               ?>
               <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                        <?php } else{
                            
                            ?>
                <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                        <?php } ?>
           
               
           </tr>
		   <tr>
              
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>

               <td align="right" style="border-bottom:1px solid #CCC;"><?php echo number_format($lastbalance,2);?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($lastbalance,2);?></td>
                        
           
               
           </tr>
           
       </table>
                
    </body>
</html>