<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
  table.fixedHeader-floating{position:fixed !important;background-color:white}table.fixedHeader-floating.no-footer{border-bottom-width:0}table.fixedHeader-locked{position:absolute !important;background-color:white}@media print{table.fixedHeader-floating{display:none}}

</style>
<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
  <thead bgcolor="#a6a6a6">
    <tr  class="table_tr">
      <th colspan="11" align="right">
          <span class="label label-primary" style="background: #f26039;">Opening Balance : &#x20B9; <span id="opBalance"> <?php echo $BankReconcilationOP['openingBalance']; ?></span></span> 
     
        <span class="label label-primary" style="background: #f26039;">Closing Balance : &#x20B9; <span id="closingBalance"> <?php echo $BankReconcilationOP['closingBalance']; ?></span></span> 
      </th>
    </tr> 
    <tr>
         <th width="5%">#</th>
         <th width="15%">Voucher No</th>
         <th width="15%">Voucher Dt</th>
         <th width="15%">Cheque No</th>
         <th width="15%">Date</th>
         <th width="15%">Cheque To/From</th>
         <th width="5%">Debit</th>
         <th width="5%">Credit</th>
         <th>Clear Dt.</th>
         <th>Action</th>
         <th>Status</th>
    </tr>   
     
  </thead>



  <tbody>
  <?php
  $sl = 1;
    foreach ($BankReconcilationList as $key => $value) {

      $isdebit = $value['ListData']->is_debit;
      if($isdebit=="Y")
      {
        $credit_amt = "";
        $debit_amt = $value['ListData']->voucher_amount;
      }
      if($isdebit=="N")
      {
        $debit_amt = "";
        $credit_amt = $value['ListData']->voucher_amount;
      }

      $account_info = "";
      foreach($value['detailData'] as $detail_data)
      {
        $account_info.= $detail_data->account_name.",";
      }

      // clear status
      $status_icon = "";
      $btn_txt = "";
      if($value['ListData']->is_chq_clear=="Y")
      {
        $status_icon = "<span class='glyphicon glyphicon-ok' style='font-size:20px;color:#07B127;'></span>";
        $input_readonly = "readonly='true' disabled='true' ";
        $input_bg = "background:#BDBDBD;";

      /*  $btn_txt = "Edit <span class='glyphicon glyphicon-edit' ></span>";
        $btn_style="background:#2b8448;width:100%";
        $input_readonly = "readonly='true' disabled='true' ";
        $input_bg = "background:#BDBDBD;";
        $btnmode = "Edit";*/

         $btn_style="display:none;";
         $edit_style="display:block;";
         $clearDt = $value['ListData']->chq_clear_on;
      }
      else
      {
        $status_icon = "<span class='glyphicon glyphicon-remove' style='font-size:20px;color:#FC1921;'></span>";
        $input_readonly = "";
        $input_bg = "";

      /*  $btn_txt = "Clear Now <span class='glyphicon glyphicon-circle-arrow-right'></span>";
        $btn_style="background:#fc6529;width:100%";
        $input_readonly = "";
        $input_bg = "";
        $btnmode = "Clear";*/

         $btn_style="display:block;";
         $edit_style="display:none;";
         $clearDt = $value['ListData']->voucher_date;
      }

     ?>

    <tr>
      <td><?php echo $sl++;?></td>
      <td><?php echo $value['ListData']->voucher_number;?></td>
      <td><?php echo date('d-m-Y',strtotime($value['ListData']->voucher_date));?></td>
      <td><?php echo $value['ListData']->cheque_number;?></td>
      <td><?php echo date('d-m-Y',strtotime($value['ListData']->cheque_date));?></td>
      <td><?php echo rtrim($account_info,',');?></td>
      <td><?php echo $debit_amt;?></td>
      <td><?php echo $credit_amt;?></td>
      <td>
         <input id="clearDate_<?php echo $value['ListData']->voucher_master_id;?>" class="clearDate form_style" placeholder="mm/dd/yyyy" style="width:100px;border:1px solid #4D6C43; border-radius: 4px; <?php echo $input_bg; ?>" value="<?php echo date('d/m/Y',strtotime($clearDt)); ?>" <?php echo $input_readonly; ?>/>
      </td>
      <td>

     <!-- Clear Button -->
       <button id="clearBtn_<?php echo $value['ListData']->voucher_master_id;?>" type="submit" class="btn btn-default btn-xs custom_clear_btn clear_chq" data-vmid=<?php echo $value['ListData']->voucher_master_id;?>  style="width:100%; <?php echo $btn_style; ?>">
         Clear Now <span class='glyphicon glyphicon-circle-arrow-right'></span>
       </button>
        
       <!-- Edit Button -->
       <button title="Edit" id="clearBtnEdit_<?php echo $value['ListData']->voucher_master_id;?>" class="btn btn-default btn-xs custom_clear_btn edit_chq_clr_btn" data-vmidedit=<?php echo $value['ListData']->voucher_master_id;?> " style="background:#2b8448;width:100%; <?php echo $edit_style; ?>">
          Edit <span class='glyphicon glyphicon-edit' ></span>
       </button>

      
       <!-- Cancel Button -->
       <button id="cancelBtn_<?php echo $value['ListData']->voucher_master_id;?>" type="submit" class="btn btn-default btn-xs custom_clear_btn cancel_me" data-vmid=<?php echo $value['ListData']->voucher_master_id;?> data-vdate=<?php echo date('d/m/Y',strtotime($value['ListData']->voucher_date)); ?>  style="width:100%; background: #e04697;margin-top:8px;<?php echo $edit_style; ?>">
         Cancel <span class='glyphicon glyphicon-remove-circle'></span>
       </button>
      
      <img src="<?php echo base_url(); ?>application/assets/images/loadergifchq.gif" alt="" style="width:70%;display: none;" id="chqclerloader_<?php echo $value['ListData']->voucher_master_id; ?>" class="chqLoader"  >
        
      </td>
      <td align="center">
        <span id="statusicon_<?php echo $value['ListData']->voucher_master_id; ?>"><?php echo $status_icon; ?></span>
      </td>
    </tr>

   <?php  
    }

  ?>    
  </tbody>
</table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/fixedHeader.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/inputmaskJS.js"></script>
<script>
$( document ).ready(function() {
   
    var table = $('#example').DataTable();

     $(".clearDate").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});
</script>


