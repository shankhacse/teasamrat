<html>
    <head>
        <title>Balance Sheet</title>
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
            <tr><td align="center"><b>Balance Sheet</b><br><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
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
				<th colspan="10" align="left">Liability</th>
			</tr>
			<?php 
				
				$ln_count = 0;
				
				$liablity_grp_desc = "";
				$liablity_group = "";
				$liablity_group_sum = 0;
				$total_liablity = 0;
				
				foreach($LiablitiesData as $liablity_data)
				{
				
				$total_liablity+= $liablity_data['Liabilities'];	
				$liablity_group_sum = 0;
				if($liablity_grp_desc!=$liablity_data['GroupDescription'])
				{
					$liablity_group_sum = $LiablitiesSum[$liablity_data['GroupDescription']];
					$liablity_group = $liablity_data['GroupDescription'];
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
						<td colspan="2" align="left"><b><?php echo $liablity_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($liablity_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$liablity_group = "";
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
				<td><?php echo $liablity_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($liablity_data['Liabilities'],2); ?></td>
			</tr>
			
			<?php
		
			$liablity_grp_desc = $liablity_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Liablity</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($total_liablity,2); ?></b></td>
			</tr>
                
        </table>
        <div style="padding:4px"></div> 
		
		<table width="100%" class="demo">
			<tr class="table_head">
				<th colspan="10" align="left">Asset</th>
			</tr>
			<?php 
				$ln_count = $ln_count+1;
				
				$asset_grp_desc = "";
				$asset_group = "";
				$asset_group_sum = 0;
				$total_asset = 0;
				
				foreach($AssetData as $asset_data)
				{
				$total_asset+= $asset_data['Asset'];
				$asset_group_sum = 0;
				if($asset_grp_desc!=$asset_data['GroupDescription'])
				{
					$asset_group_sum = $AssetSum[$asset_data['GroupDescription']];
					$asset_group = $asset_data['GroupDescription'];
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
						<td colspan="2" align="left"><b><?php echo $asset_group; ?></b></td>
						<td colspan="1" align="right"><b><?php echo number_format($asset_group_sum,2); ?></b></td>
					</tr>
				
			<?php
				}
				else
				{
					$asset_group = "";
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
				<td><?php echo $asset_data['AccountName']; ?></td>
				<td align="right"><?php echo number_format($asset_data['Asset'],2); ?></td>
			</tr>
			
			<?php
			//$total_income = $asset_data['Income'];
			$asset_grp_desc = $asset_data['GroupDescription'];
			}
			$ln_count = $ln_count+1;
			?>
			
			<tr style="background:#f8f8f8;font-weight: bold;">
				<td colspan="2" align="left"><b>Total Asset</b></td>
				<td colspan="1" align="right"><b><?php echo number_format($total_asset,2); ?></b></td>
			</tr>
                
        </table>
		
		<div style="padding:4px"></div> 
		<?php
		
			$total_liablty = abs($total_liablity);
			$total_ast = abs($total_asset);
			
			$tag = "";
			$diff_amount = 0;
			
		
			if($total_ast>$total_liablty)
			{
				$tag = "Profit";
				$diff_amount = $total_ast -$total_liablty;
			}
			elseif($total_ast<$total_liablty)
			{
				$tag = "Loss";
				$diff_amount = $total_liablty-$total_ast;
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