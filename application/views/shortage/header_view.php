<script src="<?php echo base_url(); ?>application/assets/js/shortage.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
<style>
 .custom-select {
    position: relative;
    width: 238px;
    height:25px;
    line-height:10px;
    font-size: 12px;
    
 
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
  font-size: 12px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 12px;
   
}



.custom-select input {
    width: 221px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
</style>



 <h1><font color="#5cb85c">Short Adjustment</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
      <form id="frmBagDtls" name="frmBagDtls" method="post" action="<?php echo base_url(); ?>shortageadjustment"  >
      <table>
          <tr>
              <td>Purchase :&nbsp;</td>
              <td>
                  <select id="invoice" name="invoice" class='custom-select'>
                      
                      <option value="0">Select</option>
                     <?php if($bodycontent['purchaseInvoice']){ 
                         foreach($bodycontent['purchaseInvoice'] as $content){
                         ?>
                            
                                <option value="<?php echo($content->id); ?>" <?php if($content->id==$bodycontent['selected_inpoice']){echo("selected=selected");} ?>><?php echo($content->purchase_invoice_number); ?></option>
                      
                      <?php } }?>
                  </select>
              </td>
          </tr>
          
           <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
          
          
          
          
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="drpTransporter" name="drpTransporter">
                      <option value="0">Select</option>
                      <?php if($bodycontent['transporterlist']){ 
     foreach ($bodycontent['transporterlist'] as $content) {
                      ?>
                      <option value="<?php echo($content->id) ?>" <?php if($content->id==$bodycontent['selected_transporter']){echo("selected=selected");} ?>><?php echo($content->name); ?></option>
                     
                      <?php 
                         }
                      }
                      ?>
                  </select>
              </td>
          </tr>
          
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
      </form>
    
  <span class="buttondiv"><div class="save" id="shortage" align="center"> Show </div></span>
  </section>
  
 </div>
 
 
 <div id="popupdiv"  style="<?php if($bodycontent['invoiceBagDtls']){echo("display:block;");}else{echo("display:none;");}?>" title="Detail">
     <table id="example" class="display" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Invoice</th>
        <th>Do.No</th>
        <th>Bag</th>
        <th>No.Of Bags</th>
        <th>Actual Bags</th>
        <th>Net</th>
        <th>Challan No</th>
        <th>Challan Date</th>
        <th>Action</th>
        
    </thead>
    <?php    
    $serial =1;
    foreach ($bodycontent['invoiceBagDtls'] as $content)
        {?>
    <tr>
        <td>
            <?php echo($serial);?>
            <input type="hidden" id="purDtlId_<?php echo($serial);?>" value="<?php echo($content["pDtlId"]);?>"/>
            <input type="hidden" id="purMst_<?php echo($serial);?>" value="<?php echo($content["pMstId"]);?>"/>
            <input type="hidden" id="purBagDtl_<?php echo($serial);?>" value="<?php echo($content["pBagDtlId"]);?>"/>
            
            <input type="hidden" id="parentBagId_<?php echo($serial);?>" value="<?php echo($content["parent_bag_id"]);?>"/>
            
        </td>
         <td><?php echo($content["invoice_number"]);?></td>
          <td><?php echo($content["DeliveryOrderNo"]);?></td>
           <td><?php echo($content["bagtype"]); ?></td>
            <td>
                <?php echo($content["no_of_bags"]); ?>
                <input type="hidden" id="noShortBag_<?php echo($serial);?>" value="<?php echo($content["no_of_bags"]); ?>"/>
            </td>
             <td>
                 <?php echo($content["actual_bags"]); ?>
                 <input type="hidden" id="txtActual_<?php echo($serial);?>" value="<?php echo($content["actual_bags"]); ?>"/>
             </td>
              <td>
                  <?php echo($content["net"]); ?>
                  <input type="hidden" id="txtnet_<?php echo($serial); ?>" value="<?php echo($content["net"]); ?>"/>
                  <input type="hidden" id="txtShortKgs_<?php echo($serial); ?>" value="<?php echo($content["shortkg"]);?>"/>
              </td>
              <td>
                  <?php echo ($content["challanno"]); ?>
                  <input type="hidden" id="challanNo_<?php echo($serial);?>" value="<?php echo($content["challanno"]);?>"/>
              </td>
              <td>
                  <?php echo ($content["chalandate"]); ?>
                  <input type="hidden" id="challanDate_<?php echo($serial);?>" value="<?php echo($content["chalandate"]);?>"/>
              </td>
              <td>
                  <?php if($content["bagtypeid"]!=3 && $content["bagtypeid"]!=4){ ?>
                  <img onclick="openShortage(<?php echo $content["pBagDtlId"] ?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/short.png" title="Short" style="cursor: pointer; cursor: hand;"/>
				  
				  <?php if($content["Returnable"]==1){?>
						
							<img src="<?php echo base_url(); ?>application/assets/images/Return.png" class="rtrnBtn" Title="Return" style="cursor: pointer;" id="<?php echo($content["pBagDtlId"]); ?>"/>
				  <?php }?>
				  
				  
                  <?php }else{ 
				  if($content["bagtypeid"]!=4)
				  {
				  ?>
				  
                  <img onclick="updateShortage(<?php echo $content["pBagDtlId"] ?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" title="Edit" style="cursor: pointer; cursor: hand;"/>
				  
                  <img onclick="deleteShortage(<?php echo ($content["pBagDtlId"]);?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;"/>
                  <?php 
				  }else{?>
				  <img src="<?php echo base_url(); ?>application/assets/images/error-AB.png" 
				  title="RedespatchDelete" style="cursor: pointer;" id="<?php echo ($content["pBagDtlId"]);?>" class="returndel"/>
				  
				  <?PHP
				  }
				  }
				  
				  ?>
              </td>
    </tr>
    <?php 
        $serial++;
        }
        ?>
    
   
    </table>
    
	

 </div>
 
 <div id="dialog_return" title="Return" style="display:none;">
	<table cellspacing="4" width="100%" style="margin-left:5px; margin-top:5px;">
         <tr>
             <td>Bag(Return)</td>
             <td><input type="text" id="txtRetnoofbags" value=""   disabled class="groupOfTexbox"/></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td>Net(Kgs.)</td>
             <td><input type="text" id="txtRetNetKg" value=""  disabled class="groupOfTexbox"/></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td>Challan No.</td>
             <td><input type="text" id="txtRetchallanno" value="" class="groupOfTextbox" /></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
          <tr>
             <td>Challan Date</td>
             <td><input type="text" id="txtRetchallandate" value="" class="groupOfTextbox datepicker" /></td>
         </tr>
     </table>
 
 </div>
 
 
 <div id="dialog_shortage" title="Shortage" style="display:none;">
     <table cellspacing="4" width="100%" style="margin-left:5px; margin-top:5px;">
         <tr>
             <td>No.of Bags</td>
             <td><input type="text" id="txtnoofbags" value="" class="groupOfTexbox"/></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td>short(Kgs.)</td>
             <td><input type="text" id="txtshortage" value="" class="groupOfTexbox"/></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td>Challan No.</td>
             <td><input type="text" id="challanno" value="" class="groupOfTextbox" /></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
          <tr>
             <td>Challan Date</td>
             <td><input type="text" id="challandate" value="" class="groupOfTextbox datepicker" /></td>
         </tr>
     </table>
     
</div>
 
 <div id="dialog-confirm-shortage" title="Delete" style="display:none;">
  <p> These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
 
 
