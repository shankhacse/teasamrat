<script src="<?php echo base_url(); ?>application/assets/js/gstCSVgenerate.js"></script> 

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
	
	
	.b1
	{
		background: #2399C4;
		border: 1px solid #2399C4;
		width:100px;
	}

	.b3
	{
		background: #0EA23F;
		border: 1px solid #0EA23F;
		width:100px;
	}

	.b2
	{
		background: #EE6422;
		border: 1px solid #EE6422;
		width:100px;
	}
   
</style>




 <h1><font color="#5cb85c" style="font-size:28px;">Generate CSV</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form id="gstcsvgenerateForm" name="gstcsvgenerateForm" method="post" >
      <table width="70%" align="center">
          <tr> 
              <td>From Date </td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="fromdate" class="datepicker form_style" id="fromdate" /> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
              <td>To Date</td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="todate" id="todate" class="datepicker form_style"/> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
		  <tr>
			<td colspan="4" align="center">
				
				<button id="b2bCSV" class="btn btn-primary b1 generateCSV" value="B2B"> <img src="<?php echo base_url();?>application/assets/images/csv_icon.png" width="20" height="20"/> B2B</button>
				
				
				<button id="b2bCSV" class="btn btn-primary b2 generateCSV" value="B2CL"><img src="<?php echo base_url();?>application/assets/images/csv_icon.png" width="20" height="20"/> B2CL</button>
				
				
				<button id="b2bCSV" class="btn btn-primary b3 generateCSV" value="B2CS"><img src="<?php echo base_url();?>application/assets/images/csv_icon.png" width="20" height="20"/> B2CS</button>
				
				
			</td>
		  </tr>
	  </table>
    </form>
  </section>
 </div>
 

 
 
 
 <div class="csvgenerateTable" id="csvgenerateTable">
    
    
    <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id='loader' style=" position: absolute;
    margin: auto;
    top: 25%;
    left: 0;
    right: 0;
    bottom: 0;display:none;z-index:9999"/>
    
    <div id="csv_details"  style=" width:100%;height:100%;" title="Detail">

	</div>

</div>
 
 