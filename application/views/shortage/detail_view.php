<script src="<?php echo base_url(); ?>application/assets/js/shortage.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style>
    .textStyle{
        width:310px;
        border:1px solid green;
        border-radius:5px;
       // margin-right:13%;
        
    }
    .selectedStyle{
          width:310px;
        border:1px solid green;
        border-radius:5px;
    }
    
    .custom-select {
    position: relative;
    width: 305px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    border:1px solid green;
    border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 305px;
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
    width: 275px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
    
</style>


<h1><font color="#5cb85c" style="font-size:26px;">Short Adjustment Register</font></h1>

<div id="adddiv">
    
    
      <form id="frmshortReg" method="post" action="<?php echo base_url(); ?>shortageadjustment/getshortageRegisterPdf"  >
		<section id="loginBox" style="width:650px;">
			<table cellspacing="4" cellpadding="0" class="tablespace" align="center" >
				<tr>
					<td scope="row" >Start Date <span style="color:red;">*</span></td>
					<td><input type="text" class="datepicker textStyle" id="startdate" name="startdate" 
						value="<?php echo date('d-m-Y',strtotime($bodycontent['fiscalStartDt'])); ?>"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td scope="row" >End Date <span style="color:red;">*</span> </td>
					<td>
						<input type="text" class="datepicker textStyle" id="enddate" name="enddate" 
						value="<?php echo date('d-m-Y',strtotime($bodycontent['fiscalEndtDt'])); ?>" />
						
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			
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
                  <select id="drpTransporter" name="drpTransporter" class='custom-select'>
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
				
			
						
			</table>
				<br/>
				<!-- <span class="buttondiv"><div class="save" id="salebill_register" align="center" style="cursor:pointer;">Show SaleBill Register</div></span> -->
				<br>
				<span class="buttondiv"><div class="save" id="print_short_register" align="center"  style="cursor:pointer;background: #42c95f;color: #fff;"> Pdf </div></span>
				<p style="margin-top:15px;text-align:center; color:red;">* Fields are mandetory</p>
        </section>
      </form>	
  
 </div>
  





<div class="">
    
    
     <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id='loader' style=" position: absolute;
    margin: auto;
    top: 50%;
    left: 0;
    right: 0;
    bottom: 0;display:none;"/>
    
     <div id="details"  style="display:none; width:100%;height:100%;" title="Detail">

 </div>

</div>
