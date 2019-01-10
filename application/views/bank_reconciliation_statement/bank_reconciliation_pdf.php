<html>
    <head>
        <title>Bank Reconciliation Statement</title>
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
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:6px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:11px;		
		
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
       
	   <table width="100%">
            <tr><td align="center"><b>Bank Reconciliation Statement</b><br><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        <table width="25%" align="right">
            <tr>
                <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
            </tr>
            <tr>
                <td><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
            </tr>
        </table>
        
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
                             Print Date : &nbsp;<?php echo date('d-m-Y'); ?>
                         </span>
                    </td>
                </tr>
        </table>
        
        <div style="padding:4px"></div>
        <table width="100%" class="demo">
        	<tr>
        		<th>Date</th>
        		<th>Voucher No</th>
        		<th>Cheque No</th>
        		<th>Date</th>
        		<th>Payee/Payer's</th>
        		<th>Amount</th>
        		<th>Total</th>
        	</tr>
        	<tr>
        		<td align="left" colspan="4"><strong>Balance As Per Bank Book</strong></td>
        		<td align="right" colspan="3"><strong><?php echo abs($AsBankBookStatement['closingBalance'])." ".$AsBankBookStatement['BalanceTag']; ?></strong></td>
        	</tr>

			
			<!--ADD : NOT PRESENTED/ENCASHED-->
        	<tr>
        		<th colspan="7" align="left">ADD : NOT PRESENTED/ENCASHED</th>
        	</tr>

			<?php 
				$creditTotal = 0;
				foreach($AddNotEncashed as $add_not_encashed){ 
					$creditTotal+=$add_not_encashed['ListData']->voucher_amount;
					$account_info = "";
				    foreach($add_not_encashed['detailData'] as $detail_data)
				    {
				       $account_info.= $detail_data->account_name.",";
				    }
				?>

				<tr>
					<td><?php echo date('d-m-Y',strtotime($add_not_encashed['ListData']->voucher_date)); ?></td>
					<td><?php echo $add_not_encashed['ListData']->voucher_number; ?></td>
					<td><?php echo $add_not_encashed['ListData']->cheque_number; ?></td>
					<td><?php echo $add_not_encashed['ListData']->cheque_date; ?></td>
					<td><?php echo rtrim($account_info,','); ?></td>
					<td align="right"><?php echo $add_not_encashed['ListData']->voucher_amount; ?></td>
					<td><?php echo ""; ?></td>
				</tr>
			<?php
				}
			?>
				<tr>
					<td colspan="6"><strong>SUB TOTAL</strong></td>
					<td align="right"><strong><?php echo number_format($creditTotal,2); ?></strong></td>
				</tr>



			<!--MINUS : NOT PRESENTED/ENCASHED-->
			<tr>
        		<th colspan="7" align="left">MINUS : NOT PRESENTED/ENCASHED</th>
        	</tr>

			<?php 
				$debitTotal = 0;
				foreach($MinusNotEncashed as $minus_not_encashed){ 
					$debitTotal+=$minus_not_encashed['ListData']->voucher_amount;

						$account_info_dr = "";
					    foreach($minus_not_encashed['detailData'] as $detail_data_dr)
					    {
					       $account_info_dr.= $detail_data_dr->account_name.",";
					    }
					?>

				<tr>
					<td><?php echo date('d-m-Y',strtotime($minus_not_encashed['ListData']->voucher_date)); ?></td>
					<td><?php echo $minus_not_encashed['ListData']->voucher_number; ?></td>
					<td><?php echo $minus_not_encashed['ListData']->cheque_number; ?></td>
					<td><?php echo date('d-m-Y',strtotime($minus_not_encashed['ListData']->cheque_date)); ?></td>
					<td><?php echo rtrim($account_info_dr,','); ?></td>
					<td align="right"><?php echo $minus_not_encashed['ListData']->voucher_amount; ?></td>
					<td><?php echo ""; ?></td>
				</tr>
			<?php
				}
			?>
				<tr>
					<td colspan="6"><strong>SUB TOTAL</strong></td>
					<td align="right"><strong><?php echo number_format($debitTotal,2); ?></strong></td>
				</tr>
			<!--MINUS : NOT PRESENTED/ENCASHED END-->


			<tr>
        		<td align="left" colspan="4">Balance As Per Bank Statement</td>
        		<td align="right" colspan="3"><strong><?php 
        			$closingBalance = $AsBankBookStatement['closingBalance'];
        			$total_credit = $creditTotal;
        			$total_debit = $debitTotal;

        			$balance_tag ="";
        			$balance = $closingBalance + $total_credit - $total_debit;
        			if($balance>0)
        			{
        				$balance_tag = "DR";
        			}
        			else
        			{
        				$balance_tag = "CR";
        			}

        			echo abs($balance)." ".$balance_tag;
        		 ?></strong></td>
        	</tr>

		</table>

        

    </body>
</html>


<?php 

	

?>