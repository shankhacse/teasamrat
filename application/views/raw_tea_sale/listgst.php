<script src="<?php echo base_url(); ?>application/assets/js/gstaddRawTeaSale.js"></script> 
<style type="text/css">
    .modal.in .modal-dialog 
    {
        -webkit-transform: translate(0, calc(50vh - 50%));
        -ms-transform: translate(0, 50vh) translate(0, -50%);
        -o-transform: translate(0, calc(50vh - 50%));
        transform: translate(0, 50vh) translate(0, -50%);
    }
</style>
 <h1><font color="#5cb85c" style="font-size:24px;">Garden Tea Sale List</font></h1>
 <div class="stats">
 
        <p class="stat"><a href="<?php echo base_url(); ?>gstrawteasale/addRawTeaSale" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Invoice No</th>
            <th>Sale Date</th>
            <th>Customer</th>
            <th>Total Sale (Bag)</th>
            <th>Total Sale Qty</th>
            <th>Total Amount</th>
            <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
         <tr>

             <td><?php echo($content['invoice_no']);?></td>
             <td><?php echo($content['saleDate']);?></td>
             <td><?php echo($content['customer_name']);?></td>
             <td align="right"><?php echo($content['total_sale_bag']);?></td>
             <td align="right"><?php echo($content['total_sale_qty']);?></td>
             <td align="right"><?php echo($content['grandtotal']);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>gstrawteasale/addRawTeaSale/id/<?php echo($content['rawteaSaleMastId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editRwTeasale" title="" alt=""/>
                 </a>
                 
                 <!-- <a href="<?php echo base_url(); ?>rawteasale/printrawTeaSale/rawteasalemastid/<?php echo($content['rawteaSaleMastId']); ?>" class="showtooltip" title="Print" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/print_sheet.png" id="prnSaleBill"  title="Print" alt="Print"/>
                 </a>-->
                 
               <a href="<?php echo base_url(); ?>gstrawteasale/getpdfRawTeaSale/rawteaSaleMastid/<?php echo($content['rawteaSaleMastId']); ?>" class="showtooltip" title="Print" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/pdf.png" id="prnRwTeasale"  title="Print" alt="Print" width="20" height="20"/>
               </a>
				
				<!--
               <a href="javascript:;" class="showtooltip" title="Delete" >
                  <img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="delrawsalebill_gst" title="" alt="" width="20" height="20" onclick="delRawTeaSaleBillGST(<?php echo ($content['rawteaSaleMastId']); ?>,'<?php echo $content['invoice_no']; ?>')" />
                </a>
				-->

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
             <td> &nbsp;</td>
            
         
         </tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>

 </div>



 <div id="dialog-confirm-salebill" title="Delete" style="display: none;">
  <p style="padding:8px; font-size:13px;">
  Invoice No : <span id="salebill_no_info" style="font-weight:700;color:red;"></span> will be permanently deleted.<br>Do you Want to continue...</p>
</div>


<div class="modal fade" id="rawteaSaleResponse" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body sb_body" id="rawteaSaleResponseData" style="font-family: verdana;font-size:17px;">
        
      </div>
      <div class="modal-footer sb_footer" id="" style="">
        <button type="button" class="btn btn-secondary sb_btn" data-dismiss="modal"  id="sb_close_btn">Close</button>
      </div>
    </div>
  </div>
</div>