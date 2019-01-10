<script src="<?php echo base_url(); ?>application/assets/js/consignee.js"></script> 

 <h2><font color="#5cb85c">Consignee List</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>consignee/addConsignee" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>consignee" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>
 <div class="row">
     <div class="col-lg-12">
         &nbsp;
     </div>
 </div>

  <?php 
/*echo "<pre>";
print_r($bodycontent);
echo "</pre>";*/
  ?>
 <div class="container-fluid">
    <table class="table table-bordered table-condensed" id="example">
    <thead>
      <tr>
        <th>Consign Name</th>
        <th>Address</th>
        <th>State</th>
        <th>GISTIN</th>
        <th>Customer Name</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bodycontent as $row) {?>
            <tr>
             <td><?php echo $row->consignee_name; ?></td>
             <td><?php echo $row->address; ?></td>
             <td><?php echo $row->state_name;?></td>
             <td><?php echo $row->gstin;?></td>
             <td><?php echo $row->customer_name;?></td>
            <td>
                 <a href="<?php echo base_url(); ?>consignee/addConsignee/id/<?php echo $row->id; ?>" class="btn btn-info btn-xs" role="button">Edit</a>
               
                 
             </td> 
            </tr>
        
        
       <?php } ?>
    </tbody>
  </table>
 </div>