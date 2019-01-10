<script src="<?php echo base_url(); ?>application/assets/js/consignee.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
<style type="text/css">
  
  .error-border{
    border:1px solid red;
  }
   .custom-select {
        position: relative;
        width: 298px;
        height:25px;
        line-height:10px;
        font-size: 9px;


    }
    .custom-select a {
        display: block;
        width: 298px;
        height: 25px;
        padding: 8px 6px;
        color: #000;
        text-decoration: none;
        cursor: pointer;
        font-family: "Open Sans",helvetica,arial,sans-serif;
        font-size: 9px;
    }
    .custom-select div ul li.active {
        display: block;
        cursor: pointer;
        font-size: 9px;

    }
    .custom-select input {
        width: 275px;
        font-family: "Open Sans",helvetica,arial,sans-serif;
        font-size: 9px;
    }
</style>
<meta charset="utf-8"/>
 <h2><font color="#5cb85c"><?php echo $header['mode'];?> Consignee</font></h2>
 <form class="form-horizontal" method="post" name="ConsigneeForm" id="ConsigneeForm"  >
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">Consignee Name:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="consignee_name" placeholder="Enter consignee name" name="consignee_name" value="<?php if($header['mode']=="Edit"){echo $header['consigneedata']->consignee_name;}?>">
      <input type="hidden" name="consigneeId" id="consigneeId" value="<?php if($header['mode']=="Edit"){echo $header['consigneeId'];}else{echo "0";}?>" />
    </div>
  </div>




  
  <div class="form-group">
    <label class="control-label col-sm-2" for="address">Address :</label>
    <div class="col-sm-6">
		<textarea id="address" name="address" class="form-control" rows="3"><?php if($header['mode']=="Edit"){echo $header['consigneedata']->address;}?></textarea>
	</div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="state">Sate :</label>
    <div class="col-sm-6">
      <select class="form-control" name="state" id="state" >
					<option value=0>--Select--</option>
					<?php foreach ($header['states'] as $content) : ?>
                 			<option value="<?php echo $content->id; ?>"
                        <?php if($header['mode']=="Edit"){if($header['consigneedata']->state_id==$content->id){echo "selected";}else{echo "";}}?>
                        ><?php echo $content->state_name; ?></option>
    				 <?php endforeach; ?>
	  </select>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="name">GISTIN:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="gstin" placeholder="Enter GISTIN" name="gstin" value="<?php if($header['mode']=="Edit"){echo $header['consigneedata']->gstin;}?>">
      
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="customer">Customer</label>
    <div class="col-sm-6">
       <select class="form-control" name="customer" id="customer" >
        <option value=0>--Select--</option>
        <?php foreach ($header['customerlist'] as $content) : ?>
                    <option value="<?php echo $content['customerId']; ?>"
                      <?php if($header['mode']=="Edit"){if($header['consigneedata']->customer_id==$content['customerId']){echo "selected";}else{echo "";}}?>
                      ><?php echo $content['name']; ?></option>
           <?php endforeach; ?>
        </select> 


    </div>
  </div>
  
 <span id="msg"></span>
 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-success" id="SaveBtnConsignee">Submit</button>
    </div>
  </div>
</form>
 

                    


    
    
