<!-- Table goes in the document BODY -->
<?php if($groupStock){ 

 if($divnumber%2==0)
    {
        $tr_style= "odd_tr";
    }
    else
    {
        $tr_style= "even_tr";
    }

?>
<div class="gardenTeaSaleDiv" id="stockDetail_<?php echo($divnumber);?>">
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
        <td>Discount</td>
        <td>Delivery <br>Charge</td>
        <td>Taxable</td>
        <td>CGST</td>
        <td>SGST</td>
        <td>IGST</td>
        <td>HSN</td>
        <td>Action
            <img src="<?php echo base_url(); ?>application/assets/images/error-AB.png" title="Delete" id="delTable" 
                 onclick="deleteTable(<?php echo($divnumber);?>);" style=" cursor: pointer;"/>
        </td>
    </tr>
    <?php foreach ($groupStock as $rows){ ?>
        <tr class="<?php echo $tr_style; ?>">
            <td title="Invoice">
                <?php echo($rows['Invoice']); ?>
                <input type="hidden" id="BagDtlId_<?php echo($rows['PbagDtlId']); ?>" name="txtBagDtlId[]" value="<?php echo($rows['PbagDtlId']); ?>"/>
                <input type="hidden" id="purDtlId" name="txtpurchaseDtl[]" value="<?php echo($rows['purchaseDtl']);?>"/>
                <input type="hidden" id="txtnetinBag" name="txtnetinBag[]" value="<?php echo($rows['BagNet']); ?>"/>
            </td>
            <td title="Group"><?php echo($rows['Group']); ?></td>
            <td title="Grade"><?php echo($rows['Grade']); ?></td>
            <td title="Garden"><?php echo($rows['Garden']); ?></td>
            <td align="right" title="Bag in Stock" class="highlight-gardensale">
                <?php echo($rows['Numberofbags']);?>
                <input type="hidden" id="NumberOfBags_<?php echo($rows['PbagDtlId']); ?>" name="txtNumberOfBags[]" value="<?php echo($rows['Numberofbags']);?>"/>
            
            </td>
            <td align="right" title="Net(Kgs)">
                <?php echo($rows['kgperbag']);?>
                 <input type="hidden" id="hdnetBag_<?php echo($rows['PbagDtlId']);?>" name="hdnetBag" value="<?php echo($rows['kgperbag']); ?>"/>
            
            </td>
            <td align="right" title="Cost Of Tea">
                <?php  echo($rows['pricePerBag']);?>
                <input type="hidden" id="hdpriceperbag_<?php echo($rows['PbagDtlId']);?>" name="hdpriceperbag" value="<?php echo($rows['pricePerBag']);?>"/>
            </td>
            <td align="right" title="Stock in Kgs">
                <?php echo($rows['NetBags']);?>
            </td>
            <td align="center" title="No of Sale bag">
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
            
             <td align="right"  title="Kgs">
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" readonly="readonly" value="" style="border: 1px solid #008000; color: #480091; width: 70px;border-radius:5px; text-align: right;"/>
            </td>       
            
            <!--blended cost-->
            <td align="center" title="Rate">
                <input type="text" id="txtrate_<?php echo($rows['PbagDtlId']);?>" name="txtrate[]"  class="rate"
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
           <td title="Amount">
               <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="" readonly="readonly"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" />
           </td>
           <td title="Discount">
               <input type="text" id="txtdiscount_<?php echo($rows['PbagDtlId']); ?>" name="txtdiscount[]" value="" onkeypress="checkNumeric(this);"
                      class="discount"  style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" placeholder="discount" />
           </td>
            <td title="Delivery Charge">
               <input type="text" id="txtDelivery_<?php echo($rows['PbagDtlId']); ?>" name="txtDelivery[]" value="" onkeypress="checkNumeric(this);"
                      class="deliverycharge"  style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" placeholder="Delivery Charge" />
            </td>
           <td title="Taxable">
               <input type="text" class="taxableamount" id="txtTotalRowAmt_<?php echo($rows['PbagDtlId']); ?>" name="txtTotalRowAmt[]" value="" placeholder="amount"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" readonly="readonly"/>
           </td>
           
            
            <!--blended cost-->
           
        
            <td title="CGST">
                <!--cgst rate-->
                <select name="cgst[]" id="cgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($cgstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text" readonly="readonly"  id="cgstAmt_<?php echo($rows['PbagDtlId']); ?>" name="cgstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="cgstAmt small_input">
            </td>            
            
            <td title="SGST">
                <select name="sgst[]" id="sgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($sgstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text" readonly="readonly" id="sgstAmt_<?php echo($rows['PbagDtlId']); ?>" name="sgstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="sgstAmt small_input">
            </td>
            
            <td title="IGST">
                <select name="igst[]" id="igst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($igstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                 <input type="text" readonly="readonly" id="igstAmt_<?php echo($rows['PbagDtlId']); ?>" name="igstAmt[]" style="width: 100px;margin-top:4px;margin-bottom: 12px;"  class="igstAmt small_input">
            
            
            </td>
            <td title="HSN">
                <input type="text" id="HSN_<?php echo($rows['PbagDtlId']); ?>" name="HSN[]" style="width: 50px;" class="HSN small_input" placeholder="HSN">
            </td>
            
            
            

            

        </tr>
    <?php }?>
    
</table>
    <div style="padding-top: 10px;"></div>
</div>

<?php } ?>
<script>
 
function checkNumeric(obj)
{
     if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

}

</script>


