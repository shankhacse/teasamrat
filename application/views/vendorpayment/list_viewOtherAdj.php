<script src="<?php echo base_url(); ?>application/assets/js/vendorpayment.js"></script> 
<style type="text/css">
    .modal.in .modal-dialog 
    {
        -webkit-transform: translate(0, calc(50vh - 50%));
        -ms-transform: translate(0, 50vh) translate(0, -50%);
        -o-transform: translate(0, calc(50vh - 50%));
        transform: translate(0, 50vh) translate(0, -50%);
    }
</style>

 <h2><font color="#5cb85c">Vendor Bill Adj.(TDS/Delivery Charge...)</font></h2>
 <div class="stats">
 
    <p class="stat">
        <a href="<?php echo base_url(); ?>vendorpaymentotheradj/addVendorPayment" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a>
    </p>
    <p class="stat">
        <a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
    </a>
    </p>
    
</div>
 <div id="dialog-detail-view" title="Bill details">
 
            <div id="detailInvoice">
     
            </div>
     
 </div>
 
 <div id="popupdiv">
     <table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Voucher</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Credit</th>
            <th>Vendor</th>
            <th>Action</th>
    </thead>
    <tbody>
       <?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
        <tr>
            <td><?php echo($content['voucher_number']);?></td>
            <td><?php echo($content['dateofpayment']);?></td>
            <td><?php echo($content['totalpaidamount']);?></td>
            <td><?php echo($content['credit_account']);?></td>
            <td><?php echo($content['vendor_name']);?></td>
            <td> 
                <a href="<?php echo base_url(); ?>vendorpayment/addVendorPayment/id/<?php echo($content['vendorPaymentId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>

                <a href="javascript:;" class="showtooltip" title="Delete" >
                  <img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="del_vp_Icon" title="" alt="" width="20" height="20" onclick="delVendorPayment(<?php echo ($content['vendorPaymentId']); ?>,'<?php echo $content['voucher_number']; ?>')" />
                </a>

                <img src="<?php echo base_url(); ?>application/assets/images/view_small.png" id="<?php echo($content['vendorPaymentId']); ?>" class="paymentDetails" title="view adjust" alt="" style="cursor: pointer;"/>
                
            </td>

        </tr>
      <?php endforeach; 
     else: ?>
         <tr> 
             <td>&nbsp;</td>
             <td> &nbsp;</td>
             <td> No</td>
             <td> Data Found..</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             
            
         
         </tr>
    <?php
    endif; 
    ?>
    </tbody>
     </table>
    
 </div>


<div id="dialog-confirm-vendor-payment" title="Delete" style="display: none;">
  <p style="padding:8px;">
  Voucher : <span id="voucher_no-info"></span> will be permanently deleted.<br>Do you Want to continue...</p>
</div>

<div class="modal fade" id="vendorpaymentResponse" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body va_body" id="vendorpaymentResponseData" style="font-family: verdana;font-size:17px;">
        
      </div>
      <div class="modal-footer va_footer" id="" style="">
        <button type="button" class="btn btn-secondary va_btn" data-dismiss="modal"  id="vp_close_btn">Close</button>
      </div>
    </div>
  </div>
</div>