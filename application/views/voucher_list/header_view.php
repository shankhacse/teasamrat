<script src="<?php echo base_url(); ?>application/assets/js/voucherlisting.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style>
    #frmvoucherlist{
       // color:green;
       font-size:14px;
    }
    .form_style{
        width:200px;
        border:1px solid green;
        border-radius:4px ;
    }
    .select_styl{
        width:200px;
        border:1px solid green;
         border-radius:4px ;
    }
     .custom-select {
    position: relative;
   width: 363px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 363px;
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
    font-size: 11px;
}


.custom-select input {
    width: 330px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 11px;
    height: 34px;
}
  
.save{
width: 44%;
float: left;
margin-top: 42px;
margin-left: 20px;
font-family: Georgia;
color: #624343;
font-size: 15px;
background: #ffffff;
padding: 5px 5px 5px 5px;
text-decoration: none;
box-shadow: 0px 0px 0px 0px #ccc;
border: 1px solid #878787;
background: #ECECEC;
  }
  
   
</style>

<h1><font color="#5cb85c" style="font-size:28px;">Voucher List</font></h1>
<?php $uptoReportDt = getReportDate(); ?>
 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;height:295px;">
      <form id="frmvoucherlist" name="frmvoucherlist" method="post" action="<?php echo base_url(); ?>voucherlist/getvoucherRegister"  target="_blank">
      <table width="100%" align="center">
          <tr> 
              <td>From Date </td>
              <td>:&nbsp;</td>
              <td> 
				<input type="text" name="fromdate" class="datepicker form_style" id="fromdate" value="<?php echo date('d-m-Y',strtotime($bodycontent['fiscalStartDt'])); ?>" /> 
			  </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
              <td>To Date</td>
              <td>:&nbsp;</td>
			  <td>
				<input type="text" name="todate" id="todate" class="datepicker form_style" value="<?php echo $uptoReportDt; ?>" />
			  </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
            <tr>
                <td>Transaction Type </td>   <td>:&nbsp;</td>
              <td> 
                  <select id="purchasetype" name="purchasetype"  class="select_styl">
                      <option value="ALL">Select</option>
                      <option value="PUR">  Purchase</option>
                      <option value="GV"> General</option>
                      <option value="JV"> Journal</option>
                      <option value="CN"> Contra</option>
                      <option value="SALE">  Sale</option>
                      <option value="VADV">Vendor - Advance</option>
                      <option value="CADV">Customer - Advance</option>
                      <option value="PY"> Vendor - Payment</option>
                      <option value="RC"> Customer - Receipt</option>
                     
                  </select> 
              </td>
           </tr>
          
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
          <tr>
                <td>Account </td>   
                <td>:&nbsp;</td>
              <td> 
                    <select id="account" name="account" class='custom-select'>
                        <option value="0">Select</option>
                        <?php if($bodycontent["accountList"]){
                              foreach ($bodycontent["accountList"] as $row){
                        ?>
                         <option value="<?php echo($row['accId']);?>" > <?php echo($row['accname']); ?> </option>
                        <?php 
                            }
                          }
                         ?>
                   </select>
              </td>
           </tr>
      </table>
         
      </form>
    
    <span class="buttondiv">
      <div class="save" id="showvoucherlist" align="center" style="cursor:pointer;"> Show </div></span>
      <div class="save" id="voucherRegisterPDF" align="center" style="cursor:pointer;"> PDF </div></span>
    </section>
  
 </div>
 
 
 <!--Voucher Listing Area-->
 
 
 
 <div class="vouchrlistTabl" id="vouchrlistTabl">
    
    
     <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id='loader' style=" position: absolute;
    margin: auto;
    top: 50%;
    left: 0;
    right: 0;
    bottom: 0;display:none;"/>
    
     <div id="details"  style="display:none; width:100%;height:100%;" title="Detail">

 </div>

</div>
 
 