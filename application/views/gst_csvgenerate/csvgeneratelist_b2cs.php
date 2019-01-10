<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css" />
<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
   <th>Type</th>
   <th>Place Of Supply</th>
   <th>Rate</th>
   <th>Taxable Value</th>
   <th>Cess Amount</th>
   <th>E-Commerce GSTIN</th>
</thead>
<tbody>
	
	<?php 
	if($csvGenerateData){
		foreach($csvGenerateData as $csv_data){ ?>
		
		<tr>
			
			<td><?php echo $csv_data->invoiceType; ?></td>
			<td><?php echo $csv_data->placeOfSupply; ?></td>
			<td><?php echo $csv_data->gstRate; ?></td>
			<td><?php echo $csv_data->taxableValue; ?></td>
			<td><?php echo $csv_data->cessAmt; ?></td>
			<td><?php echo $csv_data->eCommerceGISTN; ?></td>
			
		</tr>
			
<?php	}
		
	}
?>
	
	
</tbody>
</table>

<script>
$(document).ready(function() {
    $('#example').DataTable({
		 "ordering": false,
			dom: 'Bfrtip',
			
            buttons: ['copy','csv','excel','pdf','print'],
			 escapeChar: '"',
        });
	
} );
</script>












    
    
