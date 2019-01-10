<script src="<?php echo base_url(); ?>application/assets/js/bankreconcilationJS.js"></script> 


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
    .custom_clear_btn
    {
      background: #fc6529;
      color: #FFF;
      border: none;

    }
    .custom_clear_btn:hover
    {
      background: #fc6529;
      color: #FFF;
      border: none;
    }
    .table_tr
    {
      color:#FFF;
      background:#e4e4e4;
   
    }
    .table_tr th
    {
     font-family: verdana;
      font-size: 16px;
      text-align: right;
    }
   
   .chqLoader
   {
    margin-left: auto;
    margin-right:auto;
    display: block;
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

<h1><font color="#5cb85c" style="font-size:28px;">Bank Reconciliation Statement</font></h1>
<div id="adddiv">

	<?php $uptoReportDt = getReportDate(); ?>

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form method="post" name="bankRecStatementForm" id="bankRecStatementForm" action="<?php echo base_url(); ?>bankreconciliationstatement/getPdf" target="_blank">
        <table width="70%" align="center" >
           <tr> 
                <td>Bank </td>
                <td>:&nbsp;</td>
                <td>
                   <select name="bankAccID" id="bankAccID" class="datepicker form_style" >
                    <option value="0">Select</option>
                    <?php 
                      foreach ($bodycontent['bankAccountList'] as $key => $value) 
                      { ?>
                      
                      <option value="<?php echo $value['acountId'];?>"><?php echo $value['account_name']; ?></option>  
                <?php     
                      }
                    ?>
                   </select>
                </td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr> 
                <td>From Date </td>
                <td>:&nbsp;</td>
                <td>
  				        <input type="text" name="fromDt" class="datepicker form_style" id="fromDt" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($bodycontent['fiscalStartDt'])); ?>" readonly /> 
  			       </td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td>To Date</td>
                <td>:&nbsp;</td>
                <td>
  				        <input type="text" name="toDt" id="toDt" class="datepicker form_style" autocomplete="off" value="<?php echo $uptoReportDt; ?>" /> 
                </td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        </table>
          <span class="buttondiv"><div class="save" id="getpdfbnkstatemnt" align="center" style="cursor:pointer;"> Get PDF </div></span> 
      </form>
    
   
  <br>
  
  </section>
  
 </div>
 


 