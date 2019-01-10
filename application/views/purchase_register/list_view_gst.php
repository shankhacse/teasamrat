<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
    <th>Bill No</th>
	<th>Bill Dt</th>
	<th>Vendor</th>
	<th>Sale</th>
	<th>Bag</th>
	<th>Net Wt.</th>
	<th>Taxable</th>
	<th>CGST</th>
	<th>SGST</th>
	<th>IGST</th>
	<th>Tot GST</th>
	<th>R/O</th>
	<th>Bill Amt</th>
</thead>
<tbody>

    <?php
    if ($search_purchase_register) {
        foreach ($search_purchase_register as $row) {
		   $totalRowGST =  $row['purchaseDtl']['cgst_amt']+$row['purchaseDtl']['sgst_amt']+$row['purchaseDtl']['igst_amt'];
            ?>
            <tr>
                <td> <?php  echo $row['purchase_invoice_number'];?></td>
                <td><?php echo date("d-m-Y",strtotime($row['purchase_invoice_date']));?></td>
                <td> <?php echo $row['vendor_name'];?></td>
                <td> <?php  echo $row['sale_number'];?></td>
                <td align="right"><?php echo $row['bagDtl']['actualBag'];?></td>
                <td align="right"><?php echo number_format($row['bagDtl']['totalkgs'],2);?></td>
                <td align="right"><?php echo number_format($row['purchaseDtl']['gst_taxable'],2);?></td>
                <td align="right"><?php echo number_format($row['purchaseDtl']['cgst_amt'],2);?></td>
                <td align="right"><?php echo number_format($row['purchaseDtl']['sgst_amt'],2);?></td>
                <td align="right"><?php echo number_format($row['purchaseDtl']['igst_amt'],2);?></td>
                <td align="right"><?php echo number_format($totalRowGST,2);?></td>
                <td align="right"><?php echo number_format($row['round_off'],2);?></td>
                <td align="right"><?php echo number_format($row['total'],2);?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="13" align="center">No data found....!!!</td>
        </tr>
    <?php } ?>
</tbody>
</table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>












    
    
