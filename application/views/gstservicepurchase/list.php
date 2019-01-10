<script src="<?php echo base_url(); ?>application/assets/js/GSTservicePurchase.js"></script>
<style type="text/css">
    .modal.in .modal-dialog 
    {
        -webkit-transform: translate(0, calc(50vh - 50%));
        -ms-transform: translate(0, 50vh) translate(0, -50%);
        -o-transform: translate(0, calc(50vh - 50%));
        transform: translate(0, 50vh) translate(0, -50%);
    }
</style>
<h2><font color="#5cb85c">(GST) Service purchase</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>gstservicepurchase/gstServicePurchaseAdd" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>gstservicepurchase" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>
 <div class="row">
     <div class="col-lg-12">
         &nbsp;
     </div>
 </div>

  
<div class="container-fluid">
    <table class="table table-bordered table-condensed" id="example">

    <thead bgcolor="#CCCCCC">
         
          <th>Invoice No.</th>
          <th>Invoice Date</th>
          <th>Vendor</th>
          <th>Amount</th>
          <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
       
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
         <tr>
            
             <td><?php echo $content['invoice_no'];?>
                 <input type="hidden" name="RawMaterialpurchaseId" value="<?php echo $content['rawMatPurchMastId'];?>" />
             </td>
             <td><?php echo $content['InvoiceDate'];?></td>
             <td><?php echo $content['vendor_name'];?></td>
             <td ><?php echo $content['invoice_value'];?></td>
             <td>
                 <a href="<?php echo base_url(); ?>gstservicepurchase/gstServicePurchaseAdd/id/<?php echo($content['rawMatPurchMastId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
                
                 <a href="javascript:;" class="showtooltip" title="Delete" >
                  <img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="del_Purch_servc" title="" alt="" width="20" height="20" onclick="delServicePurchase(<?php echo ($content['rawMatPurchMastId']); ?>,'<?php echo $content['invoice_no']; ?>')" />
                 </a>

             </td>
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
           
           
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
          
         </tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>
</div>
     

<div id="dialog-confirm-servpurch" title="Delete" style="display: none;">
    <p style="padding:8px; font-size:13px;">
    Voucher : <span id="purch_no_info" style="font-weight:700;color:red;"></span> will be permanently deleted.<br>Do you Want to continue...</p>
</div>


<div class="modal fade" id="servPurchaseResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body sb_body" id="servPurchaseResponseData" style="font-family: verdana;font-size:17px;">
        
      </div>
      <div class="modal-footer sb_footer" id="" style="">
        <button type="button" class="btn btn-secondary sb_btn" data-dismiss="modal"  id="sp_close_btn">Close</button>
      </div>
    </div>
  </div>
</div>

