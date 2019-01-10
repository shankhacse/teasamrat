<script src="<?php echo base_url(); ?>application/assets/js/stockwithtransporter.js"></script> 
<style>
  .buttondiv
  {
    width: 25% !important;
    float: left;
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
    height: 320px;
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
<h1 style="font-size:26px;"><font color="#5cb85c">Stock with Transporter</font></h1>

 <div id="adddiv">
 <form id="frmStockWithTrns" method="post" action="<?php echo base_url(); ?>stockwithtransporter/getStockWithTransPrint"  target="_blank">
  <section id="loginBox" style="">
    <!--  <form id="frmgoodsRcv" name="frmgoodsRcv" method="post" action="<?php echo base_url(); ?>doproductrecv"  >-->
      <table>
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="transporterid" name="transporterid" class="boder_inp">
                      <option value="0" >Select</option>
                      <?php if($bodycontent['transporterlist']){
                         
                          foreach($bodycontent['transporterlist'] as $rows){?>
                      <option value="<?php echo $rows->id; ?>" <?php if($rows->id==$bodycontent['selected_transporter']){echo("selected=selected");}?>><?php echo($rows->name);?></option>
                      
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
          
          <tr>
              <td>Warehouse :&nbsp;</td>
              <td>
                  <select id="warehouseid" name="warehouseid" class="boder_inp">
                      <option value="0" >Select</option>
                      <?php if($bodycontent['warehouselist']){
                         
                          foreach($bodycontent['warehouselist'] as $warehouse_list){?>
                          <option value="<?php echo $warehouse_list->id; ?>" ><?php echo($warehouse_list->name);?></option>
                      
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

          <tr>
              <td>From Date :&nbsp;</td>
              <td>
                  <input type="text" name="fdate" id="fdate" class="datepicker boder_inp">
              </td>
          </tr>

           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
              <td>To Date :&nbsp;</td>
              <td>
                  <input type="text" name="tdate" id="tdate" class="datepicker boder_inp">
              </td>
          </tr>
          
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>From date and To Date is Transportation date</td>
          </tr>

           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

      </table>
         
     <!-- </form>-->
    
  <span class="buttondiv" style="margin-left:60px;"><div class="save" id="trnsporter" align="center"> Show </div></span>

  <span class="buttondiv"><div class="save" id="stkwithtransporter" align="center"> Print </div></span>

  <span class="buttondiv"><div class="save" id="stckwithtransporterPdf" align="center">Pdf</div></span>
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
