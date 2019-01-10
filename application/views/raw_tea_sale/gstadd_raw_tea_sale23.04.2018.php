<script src="<?php echo base_url(); ?>application/assets/js/gstRawteaSaleEditJS.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<!-- Table goes in the document BODY -->

<style>
 .custom-select {
    position: relative;
    width: 238px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    
 
}
.custom-select a {
  display: block;
  width: 238px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 9px;
   
}



.custom-select input {
    width: 221px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}

.small_input
{
  background-color : #EEEEEE;
  border: 1px solid #008000;
  border-radius:5px;
  text-align: right;
}
.odd_tr
{
  background: #edfff1 !important;
  border-bottom: 2px solid #0c6826;
  box-shadow: 6px 0px 0px #217731;
 
}

.even_tr
{
 background: #fbfbfb !important;
 border-bottom: 2px solid #E9793C;
 box-shadow: 6px 0px 0px #E96541;
}
</style>
    
<h2><font color="#5cb85c">Add Garden Tea(Sale)</font></h2>
<form action="" method="post" id="frmAddRawsaleTea">
<div id="purchaseMaster" align="center">
<table class="masterTable" width="80%" align="center">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and blending Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtrawTeaSaleMastId" id="txtrawTeaSaleMastId" value="<?php echo ($header['rawteasaleMastId']);?>"/>
    <input type="hidden" name="txthdVoucherMastId" id="txthdVoucherMastId" value="<?php echo $bodycontent['rawteasaleMastData']['voucher_master_id'];?>"/>
    </td>
  </tr>
   <tr>
       <td width="10%">Invoice No</td>
       <td width="20%">
           <input type="text" name="invoice_no" id="invoice_no" class="invoice_no" 
                  value="<?php echo $bodycontent['rawteasaleMastData']['invoice_no']?>" style="width:240px;" readonly="readonly" />
       </td>
       <td width="10%">Sale Date</td>
       <td width="20%"><input type="text" class="datepicker" name="saleDt" id="saleDt" 
                              value="<?php echo $bodycontent['rawteasaleMastData']['saleDate']?>"/>
       </td>
        
   </tr>
   <tr>
      <td width="10%">Customer</td>
        <td width="20%">
            <select name="customer" id="customer" class='custom-select'> 
                <option value="0">Select</option>
                <?php foreach ($header['customerlist'] as $content) : ?>
                <option value="<?php echo $content->vid; ?>" 
                    <?php if($bodycontent['rawteasaleMastData']['customer_id']==$content->vid){echo('selected');}else{echo('');}?>>
                    <?php echo $content->customer_name; ?>
                </option>
                <?php endforeach; ?>
            </select>
             <div id="customer_err" style="margin-left: 245px;margin-top:-18px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
        </td>
        <td width="20%">Vehichle No</td>
        <td width="20%"><input type="text" name="vehichleno" id="vehichleno" 
                               Value="<?php echo $bodycontent['rawteasaleMastData']['vehichleno']?>"/></td>
   </tr>
  <tr>
      <td>Place of supply</td>
      <td>
		<!--
          <input type="text" id="txtplaceofsupply" name="txtplaceofsupply" 
                 value="<?php echo $bodycontent['rawteasaleMastData']['placeofsupply']?>" style="width:240px;"/>-->
				 
					<?php if($header['mode']=="Add"){?>
						<select name="txtplaceofsupply" id="txtplaceofsupply" class="custom-select">
							<?php foreach($header['statelist'] as $state_list)
							{?>
								<option value="<?php echo $state_list['state_code'];?>" <?php if($state_list['state_code']==19){echo "selected";}else{echo "";}?>><?php echo $state_list['state_name']; ?></option>
							<?php } ?>
						</select>
					<?php }else{ ?>
					
						<select name="txtplaceofsupply" id="txtplaceofsupply" class="custom-select">
							<?php foreach($header['statelist'] as $state_list)
							{?>
								<option value="<?php echo $state_list['state_code'];?>" <?php if($state_list['state_code']==$bodycontent['rawteasaleMastData']['state_code']){echo "selected";}else{echo "";}?>><?php echo $state_list['state_name']; ?></option>
							<?php } ?>
						</select>
					
					
					<?php } ?>
					
		</td>
      <td>&nbsp;</td>      
      <td>&nbsp;</td>

  </tr>
</table>
    
</div>
    <div style="padding-top: 25px;padding-bottom: 25px;"></div>
<div class="well well-large">
<table width="100%" border="0">
  <tr>
    <td>
        <select style=" width: 200px;" id="dropdown-garden">
            <option value="0">--Select Garden--</option>
            <?php foreach ($header['garden'] as $content){ ?>
            <option value="<?php echo($content->id); ?>" > <?php echo($content->garden_name) ?></option>
            <?php } ?>
        </select>
    </td>
    <td>
        <div id="drpInvoice">
        
             <select style=" width: 200px;" id="dropdown-invoice">
                <option value="0">--Select Invoice--</option>
             </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgInvoice" style="display:none"/>
         </div> 
        
    </td>
    <td>
        <div id="drpLot">
            <select style=" width: 200px;" id="dropdown-lot">
            <option value="ALL">--Select Lot--</option>
            </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgLot" style="display:none"/>
        </div>    
    </td>
    <td>
        <div id="drpGrade">
            <select style=" width: 200px;" id="dropdown-grade">
             <option value="0">--Select Grade--</option>
            </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgGrade" style="display:none"/>
        </div>    
    </td>
    
    <td> <img src="<?php echo base_url(); ?>application/assets/images/view.png" title="Show" id="viewStock" style=" cursor: pointer;"/></td>
  </tr>
</table>
    
</div>
<!-- massage for exist id in table-->
<div id="dialog-for-id-in-table" title="Raw Tea Sale" style="display:none;">
       <span> This combination already in table. </span>
</div>
    
<!--details will be added here-->

<section id="loginBox">
    <div id="dialog-for-no-stock" title="Raw Tea Sale" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/out-of-stock.png" />
           Out of stock. </span>
    </div>
    
    <div id="dialog-for-noDtl" title="Raw Tea Sale" style="display:none;">
       <span> 
           Please select data for sale.
       </span>
    </div>
    <!--detail table-->
    <?php 
    
    if($bodycontent['rawteasaleDtlData']){
      ?>
    <table class="CSSTableGenerator" >
        <tr>
            <td>Invoice</td>
            <td>Group</td>
            <td>Grade</td>
            <td>Garden</td>
            <td>Bag in Stock</td>
            <td>net(Kgs)</td>
            <td>Cost Of Tea</td>
            <td>Stock in Kgs.</td>
            <td>No of Sale bag</td>
            <td>Kgs</td>
            <td>Rate</td>
            <td>Amount</td>
            <td>Disc</td>
            <td>Taxable</td>
            <td>CGST</td>
            <td>SGST</td>
            <td>IGST</td>
            <td>HSN</td>
            

        </tr>
        <?php 
        $i = 0;
        foreach ($bodycontent['rawteasaleDtlData'] as $rows) {
           $i++;

            if($i%2==0)
            {
                $tr_style= "odd_tr";
            }
            else
            {
                 $tr_style= "even_tr";
            }
         ?>
            <tr class="<?php echo $tr_style; ?>">
                <td title="Invoice" >
                    <?php echo($rows['Invoice']); ?>
                    <input type="hidden" id="BagDtlId_<?php echo($rows['PbagDtlId']); ?>" name="txtBagDtlId[]" value="<?php echo($rows['PbagDtlId']); ?>"/>
                    <input type="hidden" id="purDtlId" name="txtpurchaseDtl[]" value="<?php echo($rows['purchaseDtl']); ?>"/>
                    <input type="hidden" id="txtnetinBag" name="txtnetinBag[]" value="<?php echo($rows['BagNet']); ?>"/>
                </td>
                <td title="Group" ><?php echo($rows['Group']); ?></td>
                <td title="Grade" ><?php echo($rows['Grade']); ?></td>
                <td title="Garden" ><?php echo($rows['Garden']); ?></td>
                <td title="Bag in Stock" align="right">
                     <p id="NumberOfBagsTxt_<?php echo($rows['PbagDtlId']); ?>"><?php echo($rows['Numberofbags']); ?></p>
                    <input type="hidden" id="NumberOfBags_<?php echo($rows['PbagDtlId']); ?>" name="txtNumberOfBags[]" value="<?php echo($rows['Numberofbags']); ?>"/>

                </td>
                <td  title="net(Kgs)" align="right"><?php echo($rows['kgperbag']); ?></td>

                <td align="right" title="Cost Of Tea">
                    <?php echo($rows['pricePerBag']); ?>
                    <input type="hidden" id="hdpriceperbag_<?php echo($rows['PbagDtlId']); ?>" name="hdpriceperbag" value="<?php echo($rows['pricePerBag']); ?>"/>

                </td><!-- rate-->

                <td align="right" title="Stock in Kgs">
                    <?php echo($rows['NetBags']); ?>
                    <input type="hidden" id="hdnetBag_<?php echo($rows['PbagDtlId']); ?>" name="hdnetBag" value="<?php echo($rows['kgperbag']); ?>"/>
                </td>

                <td align="center" title="No of Sale bag">
                    <input type="hidden" id="hdTxtBlended_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendBag" value="<?php echo($rows['saleBagNo']); ?>"/>
                    <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                           style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px; text-align: right;" value="<?php echo($rows['saleBagNo']); ?>" onkeypress="checkNumeric(this);"/>
                </td>

                <td align="right" title="Kgs">
                    <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" readonly="readonly" value="<?php echo($rows['saleKgs']); ?>" style="border: 1px solid #008000; color: #480091; width: 70px;border-radius:5px; text-align: right;"/>
                </td>

                <td align="center" title="Rate">
                    <input type="hidden" id="hdTxtrate_<?php echo($rows['PbagDtlId']); ?>" name="txtRate" value="<?php echo($rows['rate']); ?>"/>
                    <input type="text" id="txtrate_<?php echo($rows['PbagDtlId']); ?>" name="txtrate[]" class="rate" 
                           style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px; text-align: right;" value="<?php echo($rows['rate']); ?>" onkeypress="checkNumeric(this);"/>
                </td>

                <!--blended cost-->
                <td title="Amount">
                    <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="<?php echo($rows['amt']); ?>" readonly="readonly"
                           style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" />
                </td>
                <!--blended cost-->

                <!-- GST area-->
                <td title="Discount">
                 <input type="text" id="txtdiscount_<?php echo($rows['PbagDtlId']); ?>" name="txtdiscount[]" 
                        value="<?php echo($rows['gstdiscount']); ?>" 
                        onkeypress="checkNumeric(this);"
                        class="discount"  
                        style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" 
                        placeholder="discount" />
                </td>
                <td title="Taxable">
                  <input type="text" class="taxableamount" id="txtTotalRowAmt_<?php echo($rows['PbagDtlId']); ?>" name="txtTotalRowAmt[]" 
                                   value="<?php echo($rows['gstTaxableamount']); ?>" placeholder="amount"
                                   style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" 
                                   readonly="readonly"/>
                </td>
                

           
            <td title="CGST">
                <!--cgst rate-->
                <select name="cgst[]" id="cgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($bodycontent['cgstrate'] as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>" <?php if($row['id']==$rows["cgstRateId"]){echo("selected");}?>>
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text" readonly="readonly"  id="cgstAmt_<?php echo($rows['PbagDtlId']); ?>" 
                       value="<?php echo($rows["cgstamt"]); ?>"
                       name="cgstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="cgstAmt small_input">
            </td>            
            
            <td title="SGST">
                <select name="sgst[]" id="sgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($bodycontent['sgstrate'] as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>" <?php if($row['id']==$rows["sgstRateId"]){echo("selected");}?>>
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text" readonly="readonly" 
                       id="sgstAmt_<?php echo($rows['PbagDtlId']); ?>" 
                       value="<?php echo($rows["sgstamt"]); ?>"
                       name="sgstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="sgstAmt small_input">
            </td>
            
            <td title="IGST">
                <select name="igst[]" id="igst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($bodycontent['igstrate'] as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>" <?php if($row['id']==$rows["igstRateId"]){echo("selected");}?>>
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                 <input type="text" readonly="readonly" 
                        value="<?php echo($rows["igstamt"]); ?>"
                        id="igstAmt_<?php echo($rows['PbagDtlId']); ?>" name="igstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="igstAmt small_input">
            
            
            </td>
            <td title="HSN">
                <input type="text" id="HSN_<?php echo($rows['PbagDtlId']); ?>"
                       value="<?php echo($rows["HSN"]); ?>"
                       name="HSN[]" 
                       style="width: 50px;" class="HSN small_input" placeholder="HSN">
            </td>
        </tr>
            <!--GST area-->
        <?php } ?>

    </table>
    
    <?php } ?>
    
    
    <!--detail table-->
        
    <div id='stockDiv' >
              <div id="stock_loader" style="display:none; margin-left:450px;">
              <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
              </div>
    </div>
    
</section>
 <section id="loginBox">
   <table width="100%" border="0"   class="table-condensed">
  <tr>
    <td>Total Sale Bag</td>
    <td>
        <input type="text" id="txtTotalSaleBag" name="txtTotalSaleBag" 
               value="<?php echo $bodycontent['rawteasaleMastData']['total_sale_bag']?>" 
               style="text-align:right;" readonly="readonly"/>
    </td>
    <td>CGST</td>
    <td>
        <input type="text" id="txtTotalCGST" name="txtTotalCGST"  readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['totalCGST']?>" style="text-align:right;"/> 
    </td>
  </tr>
  <tr>
    <td>Total Sale(Kgs)</td>
    <td>
        <input type="text" id="txtSaleOutKgs" name="txtSaleOutKgs" readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['total_sale_qty']?>" style="text-align:right;"/>
    </td>
    <td>SGST</td>
    <td>
        <input type="text" id="txtTotalSGST" name="txtTotalSGST"  readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['totalSGST']?>" style="text-align:right;"/>
    </td>
  </tr>
  
  <tr>
    <td>Total Amount</td>
    <td>
        <input type="text" id="txtTotalSalePrice" name="txtTotalSalePrice" readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['totalamount']?>" style="text-align:right;"/>
    </td>
    <td>IGST</td>
    <td>
        <input type="text" id="txtTotalIGST" name="txtTotalIGST"  readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['totalIGST']?>" style="text-align:right;"/>
    </td>
  </tr>
  <tr>
    <td>Discount</td>
    <td>
        <input type="text" id="txtDiscountAmount" name="txtDiscountAmount" readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['discountAmount']?>" style="text-align:right;"/>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td>Taxable Amount</td>
      <td>
          <input type="text" id="txtGstTaxableAmt" name="txtGstTaxableAmt" readonly="readonly"
                 value="<?php echo $bodycontent['rawteasaleMastData']['gstTaxableAmount']?>" style="text-align:right;"/>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  <tr>
      <td>Tax(GST)Incl.</td>
      <td>
          <input type="text" id="txtTotalIncldTaxAmt" name="txtTotalIncldTaxAmt" readonly="readonly"
                 value="<?php echo $bodycontent['rawteasaleMastData']['gstTaxincludedAmt']?>" style="text-align:right;"/>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  
  
  
  <tr>
    <td>Round off</td>
    <td>
        <input type="text" id="txtRoundOff" name="txtRoundOff" 
               value="<?php echo $bodycontent['rawteasaleMastData']['roundoff']?>" style="text-align:right;"/>
    </td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  
  <tr>
    <td>Total</td>
    <td><input type="text" id="txtGrandTotal" name="txtGrandTotal" readonly="readonly"
               value="<?php echo $bodycontent['rawteasaleMastData']['grandtotal']?>" style="text-align:right;"/></td>
    <td></td>
    <td></td>
  </tr>
  
  
</table>
</section>
    

    
    
    
   <div id="dialog-new-save" title="Raw Tea Sale" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Raw Tea Sale" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Raw Tea Sale" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
<div id="check_rawtea_invoiceno"  style="display:none" title="Raw Tea Sale">
    <span>This Invoice No already exist</span>
</div>
    
<!-- Details HTML dynamically added here-->



<span class="buttondiv">
          <div class="save" id="saveRawsaleTea" align="center" style="display:block;">Save</div>
</span>
     
</form>

