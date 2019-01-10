<!--<script src="<?php echo base_url(); ?>application/assets/js/gstaddPurchaseDtlJS.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/gstpurchaseManageJs.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/gstaddPurchaseJS.js"></script> -->
<script src="<?php echo base_url(); ?>application/assets/js/gstAddSingleDtlJS.js"></script> 
<!-- CSS goes in the document HEAD or added to your external stylesheet -->
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
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #CCFFCC;
}
 .save{
    background: #179b14;
    width: 50%;
    margin-left: auto;
    margin-right: auto;
    border-bottom: 3px solid #7a7a7a;
    box-shadow: none;
    color:#FFF;
  }
   .save:hover
   {
     background: #179b14;
    width: 50%;
    margin-left: auto;
    margin-right: auto;
    border-bottom: 3px solid #7a7a7a;
  }
</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Add Purchase Details(GST)</font></h2>

<form name="purchaseInvoiceDetailSingle" id="purchaseInvoiceDetailSingle" method="post" action="#">
<div id="purchaseMaster" align="center">
    <input type="hidden" name="txtPmasterId" id="PmasterId" value="<?php echo($header['pmstId']); ?>"/>
    <input type="hidden" name="txtPurchaseType" id="PurchaseType" value="<?php echo($header['purchasetype']['from_where']); ?>"/>
    <input type="hidden" name="voucherMastId" id="voucherMastId" value="<?php echo($header['vocherdata']['voucherMastId']); ?>"/>
    <input type="hidden" name="vendorId" id="vendorId" value="<?php echo($header['vocherdata']['vendor_id']); ?>"/>
</div>


<!------ GST Invoice Details ---------->
<?php $divnumber = 999;?>
<div id="dtlDiv_<?php echo($divnumber); ?>">
    <table class="gridtable" width="100%">
                    <tr>
                        <td>Lot</td>
                        <td><input type="text" id="txtLot_<?php echo($divnumber);?>" name="txtLot" class="lotNumber" value=""/></td>
                        <td>DO</td>
                        <td><input type="text" id="txtDo_<?php echo($divnumber);?>" name="txtDo" value=""/></td>
                        <td>Do Date</td>
                        <td><input type="text" id="txtDoDate_<?php echo($divnumber);?>" name="txtDoDate" class="datepicker" value=""/></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice</td>
                        <td><input type="text" id="txtInvoice_<?php echo($divnumber);?>" name="txtInvoice" class="invoice" value=""/></td>
                        <td>
                            <!-- Stamp-->
                        </td>
                        <td>
                           <!-- <input type="text" id="txtStamp_<?php echo($divnumber);?>" name="txtStamp[]" value="" class="clsstamp"/>-->
                        </td>
                        <td>Gross</td>
                        <td><input type="text" id="txtGross_<?php echo($divnumber);?>" name="txtGross" value=""/></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>GP No.</td>
                        <td><input type="text" id="txtGpnumber_<?php echo($divnumber);?>" name="txtGpnumber" value=""/></td>
                        <td>Gp Date</td>
                        <td><input type="text" id="txtGpDate_<?php echo($divnumber);?>" name="txtGpDate" class="datepicker" value=""/></td>
                    </tr>
                     <tr>
                        <td>Price/Kgs</td>
                        <td>
                            <input type="text" id="txtPrice_<?php echo($divnumber);?>" name="txtPrice" class="price" value="" />
                                <!-- Trans Cost-->
                            <!--<input type="text" id="transCost_<?php echo($divnumber);?>" name="transCost[]" class="transCost" value="<?php echo $transcost;?>"/>-->
                        </td>
                        <td>Group</td>
                        <td>
                           
                            <select id="drpGroup_<?php echo($divnumber);?>" name="drpgroup" class="teagroup">
                                <option value="0">Select</option>    
                                <?php foreach ($header['teagroup'] as $teaGrp){ ?>
                                <option value="<?php echo($teaGrp->id);?>"><?php echo($teaGrp->group_code);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Location</td>
                        <td>
                            <select id="drpLocation_<?php echo($divnumber);?>" name="drplocation" <?php if($purchaseType!='SB'){echo('disabled');}else{echo('');}?> class="location">
                                <option value="0">Select</option>    
                                <?php foreach ($header['location'] as $location){ ?>
                                <option value="<?php echo($location->lid);?>"><?php echo($location->location);?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Garden</td>
                        <td>
                            <select id="drpGarden_<?php echo($divnumber); ?>" name="drpGarden" class="garden">
                                <option value="0">Select</option>    
                                <?php foreach ($header['garden'] as $garden){ ?>
                                <option value="<?php echo($garden->id);?>"><?php echo($garden->garden_name);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Grade</td>
                        <td>
                            <select id="drpGrade_<?php echo($divnumber);?>" name="drpGrade" class="grade">
                                <option value="0">Select</option>    
                                <?php foreach ($header['grade'] as $grade){ ?>
                                <option value="<?php echo($grade->id);?>"><?php echo($grade->grade);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Warehouse</td>
                        <td>
                            <select id="drpWarehouse_<?php echo($divnumber);?>" name="drpWarehouse" class="wrhouse">
                                <option value="0">Select</option>    
                               <?php foreach ($header['warehouse'] as $warehouse){ ?>
                                <option value="<?php echo($warehouse->id);?>"><?php echo($warehouse->name);?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    
                    
                </table>
                <table class="gridtable" width="100%" id="tableNormal_<?php echo($divnumber);?>" >
                    <tr>
                        <td colspan="4" align="center"><strong>Normal</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" id="txtNormalBagid" name="txtNormalBagid" class="normalBagId" value="<?php echo($divnumber);?>"/>
                            <input type="hidden" id="txtNormalBagTypeId" name="txtNormalBagTypeId" value="1"/>
                        </td>
                       
                        <td><input type="text" id="txtNumOfNormalBag_<?php echo($divnumber);?>" name="txtNumOfNormalBag" class="txtNumOfNormalBag" value=""/>[Bags]</td>
                        <td><input type="text" id="txtNumOfNormalNet_<?php echo($divnumber);?>" name="txtNumOfNormalNet" class="txtNumOfNormalNet" value=""/>[Kgs/bag]</td>
                        <td><input type="text" id="txtNumOfNormalChess_<?php echo($divnumber);?>" name="txtNumOfNormalChess" value=""/></td>
                    </tr>
                </table>
                 <table class="gridtable" width="100%" id="sampleBag_<?php echo($divnumber);?>">
                    <tr>
                        <td colspan="4" align="center">
                            <strong>Sample</strong>
                            <img src="<?php echo base_url(); ?>application/assets/images/add_sample.jpg" id="<?php echo($divnumber); ?>" class="samplebag"/>
                            <input type="hidden" name="txtSampleBagPurID[]" value="<?php echo($divnumber);?>"/><!--hidden div number for details save-->
                        </td>
                    </tr>
                    
                </table>
                <table class="gridtable" width="100%">
                    <tr>
                        <td>
                            Tea value
                            <input type="text" readonly="" id="DtltotalValue_<?php echo($divnumber);?>" name="DtltotalValue" value="" placeholder="Total tea value "/> 
                        </td>
                        <td>
                            Discount
                            <input type="text" class="DtlDiscount" id="DtlDiscountValue_<?php echo($divnumber);?>" name="DtlDiscountValue" value="" placeholder="Discount"/> 
                        </td>
                        <td colspan="2">
                            Taxable
                            <input type="text" readonly="" class="txtTaxableAmt" id="DtlTaxableValue_<?php echo($divnumber);?>" name="DtlTaxableValue" value="" placeholder="Taxable"/> 
                        </td>
                        


                    </tr>
                    <tr>
                        <td>
                            <!--cgstrate-->
                            <select name="cgst" id="cgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($bodycontent['cgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="cgstAmt_0_<?php echo($divnumber); ?>" name="cgstAmt" style="width: 90px;" class="cgstAmt" readonly >
                        </td>                   
                        <td>
                            <select name="sgst" id="sgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($bodycontent['sgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="sgstAmt_0_<?php echo($divnumber); ?>" name="sgstAmt" style="width: 90px;" class="sgstAmt" readonly >
                            
                        </td>
                        
                        <td colspan="2">
                            <select name="igst" id="igst_0_<?php echo($divnumber); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($bodycontent['igstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="igstAmt_0_<?php echo($divnumber); ?>" name="igstAmt" style="width: 90px;" class="igstAmt" readonly >
                            
                        </td>
                    </tr>
                    <tr>
                        
                        <td>Net amount</td>
                        <td>
                          <input type="text" id="txtdtlnetamount_<?php echo($divnumber);?>" name="txtdtlnetamount" class="txtdtlnetamount" value=""/>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                     
                        <tr>
                            <td>Total Weight</td>
                            <td>
                                <input type="text" readonly="" id="DtltotalWeight_<?php echo($divnumber);?>" class="dtlTotalWght" name="DtltotalWeight" value=""/></td>
                            <td></td>
                            <td>
                                <!--<input type="text" readonly="" id="DtltotalValue_<?php echo($divnumber);?>" name="DtltotalValue[]" value=""/>-->
                            </td>
                        </tr>
                        <tr>
                            <td>Total Bags</td>
                            <td><input type="text" readonly="" id="DtltotalBags_<?php echo($divnumber);?>" class="dtlTotalBags" name="DtltotalBags" value=""/></td>
                            <td>Tea Cost/Kg</td>
                            <td><input type="text" readonly="" id="DtlteaCost_<?php echo($divnumber);?>" class="DtlteaCost" name="DtlteaCost" value=""/></td>
                        </tr>
                </table>
				
				
				<div style="padding-top: 0.25cm;">
                <table width="100%">
                    <tr>
                        <td align="center" > 
                            <span class="buttondiv" style="width:50%;margin:0 auto;">
                               <button class="save" id="addinvocesingle" align="center" type="submit" style="cursor:pointer;width: 30%;display:block;">Add</button>
							</span>
                            
                       </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                         <td>
                             &nbsp;
                            
                        </td>
                    </tr>
                </table>
                </div>    
				
				
        </div> 

<!----- END Invoice details ------------>

</form>




<p style="width:300px;text-align:center;margin:0 auto;background: red;padding: 5px;color: #FFF;border-radius: 4px;display:none;" id="singledtlerror">

</p>


<div class="buttondiv" style="width:20%;margin:0 auto;clear:both;" id="btn_back_info" >
    <a href="<?php echo base_url()?>gstpurchaseinvoice/addPurchaseInvoice/id/<?php echo($header['pmstId']); ?>" class="save" id="addinvocesingle" align="center" style="cursor:pointer;padding: 8px 18px;color: #DEDEDE;">Go To Edit</a>
	
	<a href="<?php echo base_url()?>gstpurchaseinvoice" class="save" id="addinvocesingle" align="center" style="cursor:pointer;padding: 8px 18px;color: #DEDEDE;">Go To List</a>
</div>




<!-- modal dialog--div-->

<!-- modal dialog--div-->




