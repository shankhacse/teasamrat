<script src="<?php echo base_url(); ?>application/assets/js/gstregister.js"></script> 
<style>
  .buttondiv
  {
    width: 25% !important;
   // float: left;
    margin-left: 2%;
  }
  section#loginBox {
    background-color: rgb(249, 249, 249);
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 4px;
    box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
    margin: 40px auto;
    padding: 51px;
    width: 500px;
    clear: both !important;
    height: 196px;
    font-family:verdana;
    font-size: 11px;
}
.save {
  color: #292929;
  background: #d6eae2;
  padding: 5px 5px 5px 5px;
  text-decoration: none;
  box-shadow: 0px 0px 0px 0px #ccc;
  border: 1px solid #6c7771;
  font-family: verdana;
  font-size: 12px;

}
.boder_inp
{
  width: 100%;
  height: 28px;
  border: 1px solid #526b5e;
  border-radius: 4px;
}
</style>
<h1 style="font-size:26px;"><font color="#5cb85c">GST Register(Input)</font></h1>

 <div id="adddiv">
 <form id="frmGstRegister" method="post" action="<?php echo base_url(); ?>gstregister/getGSTRegister"  target="_blank">
  <section id="loginBox" style="">

      <table style="width:80%;">
          

          <tr>
              <td>From Date</td>
              <td>
                  <input type="text" name="fdate" id="fdate" class="datepicker boder_inp">
              </td>
          </tr>

           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
              <td>To Date </td>
              <td>
                  <input type="text" name="tdate" id="tdate" class="datepicker boder_inp">
              </td>
          </tr>
          
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

         
      </table>
         
 
    
    <!--
  <span class="buttondiv" style="margin-left:60px;"><div class="save" id="trnsporter" align="center"> Show </div></span>

  <span class="buttondiv"><div class="save" id="stkwithtransporter" align="center"> Print </div></span>
-->
  <span class="buttondiv"><div class="save" id="gstRegisterPDF" align="center">Pdf</div></span>
  </section>
  
 </div>
 </form>

 
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
