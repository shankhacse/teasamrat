<html>
    <head>
        <title>ProfitLoss</title>
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
       
	   <table width="100%">
            <tr><td align="center"><b>Profit & Loss</b><br><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
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
			<tr class="table_head">
				<th colspan="10" align="left">Expenditure</th>
			</tr>
			<?php 
				
				$ln_count = 0;
				
				$expenditure_grp_desc = "";
				$expenditure_group = "";
				$expenditure_group_sum = 0;
				$total_expenditure = 0;
				
				foreach($expenditureData as $expediture_data)
				{
				
				$total_expenditure+= $expediture_data['Expenditure'];	
				$expenditure_group_sum = 0;
				if($expenditure_grp_desc!=$expediture_data['GroupDescription'])
				{
					$expenditure_group_sum = $expenditureSum[$expediture_data['GroupDescription']];
					$expenditure_group = $expediture_data['GroupDescription'];
					$ln_count = $ln_count+1;
					
					// Line count check
				if($ln_count>30)
				{ ?>
				</table>
				<div class="break"></div>
                <?php $ln_count = 1; 
					echo $profitLossHeader;
				?>
				 
			<?php
				} // end of line count check
				
			?>
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left"><b><?php echo $expenditure_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($expenditure_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$expenditure_group = "";
				}
				$ln_count = $ln_count+1;
				
				// Line count check
				if($ln_count>30)
				{ ?>
				</table>
				<div class="break"></div>
                <?php $ln_count = 1; 
				echo $profitLossHeader;
				?>
				
			<?php
				} // end of line count check
				
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $expediture_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($expediture_data['Expenditure'],2); ?></td>
			</tr>
			
			<?php
		
			$expenditure_grp_desc = $expediture_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Expenditure</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($total_expenditure,2); ?></b></td>
			</tr>
                
        </table>
        <div style="padding:4px"></div> 
		
		<table width="100%" class="demo">
			<tr class="table_head">
				<th colspan="10" align="left">Income</th>
			</tr>
			<?php 
				$ln_count = $ln_count+1;
				
				$income_grp_desc = "";
				$income_group = "";
				$income_group_sum = 0;
				$total_income = 0;
				
				foreach($incomeData as $income_data)
				{
				$total_income+= $income_data['Income'];
				$income_group_sum = 0;
				if($income_grp_desc!=$income_data['GroupDescription'])
				{
					$income_group_sum = $incomeSum[$income_data['GroupDescription']];
					$income_group = $income_data['GroupDescription'];
					$ln_count = $ln_count+1;
					// Line count check
				if($ln_count>30)
				{ ?>
				</table>
				<div class="break"></div>
                <?php $ln_count = 1; 
				echo $profitLossHeader;
				?>
				
			<?php
				} // end of line count check
				
			?>
					
					<tr style="background:#e3e3e3;font-weight: bold;">
						<td colspan="2" align="left"><b><?php echo $income_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($income_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$income_group = "";
				}
				$ln_count = $ln_count+1;
				
				// Line count check
				if($ln_count>30)
				{ ?>
				</table>
				<div class="break"></div>
                <?php $ln_count = 1;
				echo $profitLossHeader;
				?>
				
			<?php
				} // end of line count check
				
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $income_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($income_data['Income'],2); ?></td>
			</tr>
			
			<?php
			//$total_income = $income_data['Income'];
			$income_grp_desc = $income_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Income</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($income_data['Total'],2); ?></b></td>
			</tr>
                
        </table>
		
		<div style="padding:4px"></div> 
		<?php
			$tag = "";
			$diff_amount = 0;
			
		
			if($total_income>$total_expenditure)
			{
				$tag = "Profit";
				$diff_amount = $total_income -$total_expenditure;
			}
			elseif($total_income<$total_expenditure)
			{
				$tag = "Loss";
				$diff_amount = $total_expenditure-$total_income;
			}
			else
			{
				$tag = "";
				$diff_amount = "";
			}
			
			$ln_count = $ln_count+1;
		?>
		
		
		<table width="100%" class="demo" style="font-weight:bold;">
			<tr>
				<td align="left"><?php echo $tag ;?></td>
				<td align="right"><?php echo number_format($diff_amount,2); ?> </td>
			
				
			</tr>
		</table>
		
    </body>
</html>


<?php 

	

?>