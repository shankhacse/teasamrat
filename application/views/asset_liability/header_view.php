<script src="<?php echo base_url(); ?>application/assets/js/assetliablity.js"></script> 
<style>
    #frmsaletaxregister{
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
   
</style>




 <h1><font color="#5cb85c" style="font-size:28px;">Balance Sheet </font></h1>
<?php $uptoReportDt = getReportDate(); ?>
 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form id="assetliabReg" name="assetliabReg" method="post" action="<?php echo base_url(); ?>assetliablities/assetliablitypdf"  target="_blank">
      <table width="70%" align="center">
          <tr> 
              <td>From Date </td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="fromdate" class=" form_style" id="fromdate" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($bodycontent['fiscalStartDt']));?>" readonly="true" /> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
              <td>To Date</td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="todate" id="todate" class="datepicker form_style" autocomplete="off" value="<?php echo $uptoReportDt; ?>"/> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
      </form>
    
 <!-- <span class="buttondiv"><div class="save" id="showsaletaxregister" align="center" style="cursor:pointer;"> Show </div></span> -->
  
  <br>
  
   <span class="buttondiv"><div class="save" id="showassetliablity" align="center" style="cursor:pointer;"> Pdf </div></span> 
  </section>
  
 </div>
 
 
 <!---------------------Voucher Listing Area-------------------------->
 
 

 