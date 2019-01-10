<script src="<?php echo base_url(); ?>application/assets/js/journalVoucher.js"></script>
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
#narration{
    resize:none;
}
#addnewDtlDiv{
    cursor:pointer;
}
.debitcredit{
    width:80px;
    height:25px;
}
.branch{
    width:191px;
}
.subledger{
   width:250px; 
    height:25px;
}
.acHead{
     width:330px; 
      height:25px;
}
.textStyle{
    border:1px solid green;
    border-radius:5px;
}
.selectStyle{
    border-top:1px solid green;
    border-left:1px solid green;
    border-bottom:1px solid green;
    border-radius:5px;
}


.ui-widget-content {
    border: 0px solid #aaaaaa;
    background: #fff;
    color: #222222;
}

.ui-widget-header {

    border: 0px solid #a6a6a6;
    background: #78AB46;
    #background-image: -webkit-linear-gradient(top, #CCFFCC, #5cb85c);
    color: #fff;
    #font-weight: bold;
    height: 36px;
    #border-radius: 20px;
    line-height: 36px;
    #text-indent: 68px !important;
    padding-left: 7px;

}

.ui-icon, .ui-widget-content .ui-icon {

    background-image: url("../images/ui-icons_222222_256x240.png");

}
</style>


<?php 
	$entryDt = getEntryDate();
    $modeType=$header['mode'];
    if($modeType=='Add'){?>
<h1><font color="#5cb85c" style="font-size:22px;">Journal Voucher Add</font></h1>
    <?php }elseif($modeType=="Edit"){?>
<h1><font color="#5cb85c" style="font-size:22px;">Journal Voucher Edit</font></h1>
    <?php }?>

<form id="frmJournalVoucher" name="frmJournalVoucher" method="post">
<section id="loginBox" style="height:300px;" >
<table width="100%" border="0">
  <tr style="display:none;">
        <td>
            <input type="text" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>" readonly=""/>
           <input type="text" id="voucherMasterId" name="voucherMasterId" value="<?php echo($header['voucherMasterId']);?>" readonly=""/>
           <input type="text" id="serialNo" name="serialNo" value="<?php echo($bodycontent['journalVouchermaster']['serial_number']);?>" readonly=""/>
        </td>
        <td style="display:none;">&nbsp;</td>
   </tr>

   <tr>
       <td>Voucher No:</td>
       <td><input type="text" name="voucherNo" id="voucherNo" value="<?php echo $bodycontent['journalVouchermaster']['voucher_number'];?>" class="textStyle" style="width:190px;" readonly=""/></td>
       <td>Voucher Date:</td>
       <td><input type="text" name="voucherDate" id="voucherDate" class="datepicker textStyle" value="<?php //echo $bodycontent['journalVouchermaster']['voucher_date'];
       if($bodycontent['journalVouchermaster']['voucher_date']){echo $bodycontent['journalVouchermaster']['voucher_date'];}else{echo $entryDt;}
       ?>" readonly /></td>
      
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
     
       <td>Cheque No:</td>
       <td><input type="text" name="chqNo" id="chqNo" class="textStyle" value="<?php echo $bodycontent['journalVouchermaster']['cheque_number']?>" style="width:190px;"/></td>
       <td>Cheque Date:</td>
       <td>
          <?php if($header['mode']=="Edit"){ ?>
            <input type="text" name="chqDate" id="chqDate" value="<?php echo $bodycontent['journalVouchermaster']['cheque_date']?>" class="datepicker textStyle" readonly />
          <?php }else{ ?>
            <input type="text" name="chqDate" id="chqDate" value="<?php echo $entryDt; ?>" class="datepicker textStyle" readonly />
          <?php } ?>
        </td>
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
       
       
       <td>Branch</td>
       <td>
           <select name="branchid" id="branchid" class="branch selectStyle">
               <option value="0">Select</option>
              <?php foreach($header['branchlist'] as $rows){?>
                <option value="<?php echo($rows['id'])?>" <?php if( $rows['id']==$bodycontent['journalVouchermaster']['branchid']){echo("selected='selected'");}else{echo('');}?>><?php echo($rows['branch']); ?></option>
            <?php } ?>
           </select>
         </td>
          <td>Narration:</td>
       <td>
           <textarea id="narration" name="narration" cols="18" rows="" class="textStyle"><?php echo $bodycontent['journalVouchermaster']['narration']?></textarea>
       </td>
   </tr>
    <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>

 <tr>
  	<td colspan="6">
            <span class="buttondiv"><div class="save" id="addnewDtlDiv" align="center">Add Voucher Details</div></span>
        </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->


             
<section id="loginBox" class="groupvoucherDtl">
    
  
    <?php if($bodycontent['journalVoucherDtl']){
    
     foreach ($bodycontent['journalVoucherDtl'] as $content){
    ?>
    
    <div id="generalVoucher_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" class="generalVoucher">
            <table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                        <tr>
                        <td width="10%">
                            <select name="debitcredit[]" id="debitcredit_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="debitcredit selectStyle"> 
                                <option value="0">A/c Tag</option>
                                <option value="Dr" <?php if($content['is_debit']=='Y'){echo('selected');}else{echo('');} ?>>Dr</option>
                                <option value="Cr" <?php if($content['is_debit']=='N'){echo('selected');}else{echo('');} ?>>Cr</option>
                            </select>
                        </td>
                        <td width="40%"> 
                            <select name="acHead[]" id="acHead_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="acHead selectStyle"> 
                                <option value="0">Select A/c Name</option>
                                <?php foreach($header['accounthead'] as $row){?>
                                <option value="<?php echo $row['acountId'];?>" <?php if($content['accountId']==$row['acountId']){echo("selected");}else{echo('');} ?>><?php echo $row['account_name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td width="30%">
                             <select name="subledger[]" id="subledger_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="subledger selectStyle"> 
                                <option value="0">Select Subledger</option>
                                <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>" <?php if($content['subLedgerId']==$row['subledgerid']){echo("selected");}else{echo('');} ?>><?php echo $row['subledger']?></option>
                                <?php }?>
                                
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amountDtl[]" id="amountDtl_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" value="<?php echo($content['VouchrDtlAmt']);?>" class="amountDtl textStyle" placeholder="Amount" style="height:25px;text-align:right;" onkeyup="checkNumeric(this);"/>
                        </td>
                        <td width="10%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" />
                        </td>
                        </tr>
            </table>
    </div>
    <?php }
}
?>
</section>

<div id="salebil_detail_error" style="display:none" title="contraVoucher">
    <span>Invalid row in detail..</span>
</div>


<!-- <div id="save_voucher_detail_data"  style="display:none" title="journalVoucher">
    <span>Data successfully saved.</span>   
</div>
<div id="show_voucher_no"  style="display:none" title="contraVoucher">
    <span>Voucher Number:<?php echo($header['Voucherno']);?> </span>   
</div>
 -->
 <div id="save_voucher_detail_data"  style="display:none" title="journalVoucher">
    &nbsp;<span id="msg_gv" style="margin-top: 5px;"></span><br>
    <a id="printpdf" href="" target="_blank" style="padding:2%;text-decoration:none;outline-style: none;">
      <button class="label label-default" style="margin-top:10px;padding: 3%;font-weight: 400;background: #1ca164;font-size: 12px;border:0;margin-top:40px;margin-bottom:5px;"><i class="fa fa-print" aria-hidden="true"></i>
 Print </button> </a> 

    <button type="button" class="btn btn-default" style="float: right;margin-right: 10px;padding: 1%;margin-top:40px;height: 30px;font-weight: 400;background: #1ca164;margin-bottom:5px;background: #e17c71;margin-bottom: 5px;border: 0;color: #fff;"
 data-dismiss="modal" onclick="redirectMe('<?php echo base_url()?>','journalvoucher');" >Close</button>
</div>


<!--detail data will be added here -->
<section id="loginBox" style="width: 650px; height: 100px;">
<table width="100%" border="0"   class="table-condensed">
    <tr>
        <td>Total Debit</td>
        <td><input type="text" name="totalDebit" id="totalDebit" class="textStyle" value="<?php echo number_format($bodycontent['totalDbtAmt']['totalDebtAmt'],2); ?>" style="text-align:right;" readonly=""</td>
   
     
        <td>Total Credit</td>
        <td><input type="text" name="totalCredit" id="totalCredit" class="textStyle" value="<?php echo number_format($bodycontent['totalCreditAmt']['totalCreditAmt'],2); ?>" style="text-align:right;" readonly=""</td>
    </tr>
    
</table>


</section>

<span class="buttondiv">
<div class="save" id="journalVoucher" align="center">Save</div>
 <div id="stock_loader" style="display:none; margin-left:450px;">
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
 </div>
</span
</form>
