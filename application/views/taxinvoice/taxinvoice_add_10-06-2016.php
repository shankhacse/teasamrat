<script src="<?php echo base_url(); ?>application/assets/js/taxInvoiceAdd.js"></script>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#003399;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #CCFFCC;
}
</style>
<form id="frmSaleBill" name="frmSaleBill" method="post">
<section id="loginBox" style="height: 220px;">
<table width="100%" border="0">
  <tr>
    <td><label>Sale Bill No.</label>&nbsp;</td>
    <td>
        <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>"/>
        <input type="hidden" id="hdSalebillid" name="hdSalebillid" value="<?php echo($header['salebillno']); ?>"/>
        <input type="text"  id="txtSaleBillNo" name="txtSaleBillNo" value="<?php echo($bodycontent['taxInvoiceMaster']['saleBillNo']); ?>" placeholder="Auto: Don't Type" readonly/>
      
    </td>
    <td>&nbsp;</td>
    <td><label>Date</label>&nbsp;</td>
    <td><input type="text" name="saleBillDate" id="saleBillDate" class="datepicker" value="<?php //echo($bodycontent['taxInvoiceMaster']['salebilldate']); 
    if($bodycontent['taxInvoiceMaster']['salebilldate']){echo $bodycontent['taxInvoiceMaster']['salebilldate'];}else{echo date('d-m-Y');}
    ?>"/></td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>Tax Invoice No.</label>&nbsp;</td>
    <td><input type="text"  id="txtTaxInvoiceNo" name="txtTaxInvoiceNo" value="<?php echo($bodycontent['taxInvoiceMaster']['taxinvoice']); ?>" placeholder="Auto: Don't Type" readonly/></td>
    <td>&nbsp;</td>
    <td><label>Date</label>&nbsp;</td>
    <td><input type="text" name="taxInvoiceDate" id="taxInvoiceDate" class="datepicker" value="<?php echo($bodycontent['taxInvoiceMaster']['taxinvoicedate']); ?>" /></td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>Due Date</label>&nbsp;</td>
    <td><input type="text"  id="txtDueDate" name="txtDueDate" value="<?php echo($bodycontent['taxInvoiceMaster']['duedate']); ?>" class="datepicker" /></td>
    <td>&nbsp;</td>
    <td><label>Customer</label>&nbsp;</td>
    <td>
    	<select id="customer" name="customer">
        	<option value="0">Select</option>
            <?php foreach($header['customer'] as $rows){?>
                <option value="<?php echo($rows['customerId']); ?>" <?php if($bodycontent['taxInvoiceMaster']['customerid']==$rows['customerId']){echo('selected');}else{echo('');} ?>><?php echo($rows['name']); ?></option>
            <?php } ?>
        </select>
    </td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  			<td colspan="5">
            	<span class="buttondiv">
          				<div class="save" id="addnewDtlDiv" align="center">Add Details</div>
      			</span>
            </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->

             
<section id="loginBox" class="salebillDtl">
<?php if($bodycontent['taxInvoiceDetail']){
    
     foreach ($bodycontent['taxInvoiceDetail'] as $content){
    ?>
    
    <div id="salebillDetails_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" class="taxinvoicedetails">
            <table width="100%" class="gridtable">
                        <tr>
                        <td width="30%">
                        <select name="finalproduct[]" id="finalproduct_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" style="width:200px;"> 
                        <option value="0">Select Product</option>
                        <?php foreach($header['finalproduct'] as $rows){?>
                        <option value="<?php echo($rows['productPacketId']);?>" <?php if($content['productpacketid']==$rows['productPacketId']){echo("selected");}else{echo('');} ?>>
                            <?php echo($rows['finalproduct']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                        <td width="10%">
                            <input type="text" class="packet" id="txtDetailPacket_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailPacket[]" value="<?php echo($content['packingbox']);?>" placeholder="Packet"/></td>
                        <td width="10%"><input type="text" class="net" id="txtDetailNet_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailNet[]" value="<?php echo($content['packingnet']);?>" placeholder="Net(Kg)"/></td>
                        <td width="10%"><input type="text" class="pacQty" id="txtDetailQuantity_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailQuantity[]" value="<?php echo($content['quantity']);?>" placeholder="Quantity(Kg)" readonly/></td>
                        <td width="10%"><input type="text" class="rate" id="txtDetailRate_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailRate[]" value="<?php echo($content['rate']);?>" placeholder="Rate"/></td>
                        <td width="10%"><input type="text" class="amount" id="txtDetailAmount_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailAmount[]" value="<?php echo($content['amount']);?>" placeholder="Amount" readonly/></td>
                        <td width="20%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" />
                        </td>
                        </tr>
            </table>
    </div>
<?php }
}
?>
</section>

<div id="sale_bil_save_dilg"  style="display:none" title="Taxinvoice">
    <span>Data successfully save.</span>
</div>
<div id="salebil_error_save_dilg" style="display:none" title="Taxinvoice">
    <span>Fail to save the data.</span>
</div>

<div id="salebil_detail_error" style="display:none" title="Taxinvoice">
    <span>Invalid row in detail..</span>
</div>
<div id="salebil_detail_validation_fail" style="display:none" title="Taxinvoice">
    <span>Validation Fail..</span>
</div>



<!--detail data will be added here -->
<section id="loginBox" style="width: 690px; height: 320px;">
<table width="100%" border="0"   class="table-condensed">
  <tr>
    <td>Total Packet</td>
    <td><input type="text" id="txtTotalPacket" name="txtTotalPacket" value="<?php echo($bodycontent['taxInvoiceMaster']['totalpacket']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Quantity</td>
    <td><input type="text" id="txtTotalQty" name="txtTotalQty" value="<?php echo($bodycontent['taxInvoiceMaster']['totalquantity']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Total Amount</td>
    <td><input type="text" id="txtTotalAmount" name="txtTotalAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['totalamount']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Discount</td>
    <td><input type="text" name="txtDiscountPercentage" id="txtDiscountPercentage" value="<?php echo($bodycontent['taxInvoiceMaster']['discountRate']); ?>" />(%) </td>
    <td>Amount</td>
    <td><input type="text" id="txtDiscountAmount" name="txtDiscountAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['discountAmount']); ?>"/></td>
  </tr>

  <tr>
    <td>Delivery Chgs</td>
    <td><input type="text" name="txtDeliveryChg" id="txtDeliveryChg" value="<?php echo($bodycontent['taxInvoiceMaster']['deliveryChgs']); ?>" /></td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td>
        [Vat]<input type="radio" name="rateType" <?php if($header['mode']=='Add'){echo("checked=checked");} ?> id="rateType" value="V" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='V'){echo("checked=checked");} ?>>
        [CST]<input type="radio" name="rateType"  id="rateType" value="C" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='C'){echo("checked=checked");} ?>> 
    </td>
    <td>
        <div id="divVat" <?php if($header['mode']=='Add'){echo('style="display:block"');} ?>  <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='V'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	Vat <select id="vat" name="vat">
	            	<option value="0">Select</option>
                        <?php foreach ($header['vatpercentage'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>" <?php if($bodycontent['taxInvoiceMaster']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->vat_rate); ?></option>
                        <?php } ?>
                </select>
        </div>
        <div id="divCst" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='C'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	CST <select name="cst" id="cst">
            	<option value="0">Select</option>
                <?php foreach ($header['cstRate'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>"<?php if($bodycontent['taxInvoiceMaster']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->cst_rate); ?></option>
                <?php } ?>
                
            </select>
        </div>	
    </td>
    <td>Tax Amount</td>
    <td><input type="text" id="txtTaxAmount" name="txtTaxAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['taxamount']); ?>"/></td>
  </tr>
  
  <tr>
    <td>Round off</td>
    <td><input type="text" id="txtRoundOff" name="txtRoundOff" value="<?php echo($bodycontent['taxInvoiceMaster']['roundoff']); ?>"/></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  
  <tr>
    <td>Total</td>
    <td><input type="text" id="txtGrandTotal" name="txtGrandTotal" value="<?php echo($bodycontent['taxInvoiceMaster']['grandtotal']); ?>"/></td>
    <td></td>
    <td></td>
  </tr>
  
  
</table>


</section>

<span class="buttondiv">
<div class="save" id="saveSaleBill" align="center">Save</div>
 <div id="stock_loader" style="display:none; margin-left:450px;">
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
 </div>
</span>
</form>

