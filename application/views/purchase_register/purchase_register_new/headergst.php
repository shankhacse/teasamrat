<script src="<?php echo base_url(); ?>application/assets/js/purchaseregister.js"></script>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <h1 style="font-size:26px;"><font color="#5cb85c">Purchase Register(GST)</font></h1>
        </div>
    </div>
    <div class="row" style="width:50%;margin:0 auto;">
     
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Purchase Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo base_url(); ?>purchaseregnew/getGSTPurchaseRegister" method="post"  target="_blank">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fromdate">From:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" id="fromdate"  name="fromdate" placeholder="From Date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="todate">To :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" id="todate" name="todate" placeholder="To Date">
                            </div>
                        </div>
						
						<?php 
							/*echo "<pre>";
							print_r($header['vendor']);
							echo "</pre>";*/
						?>
						 <div class="form-group">
                            <label class="control-label col-sm-2" for="todate">Vendor :</label>
                            <div class="col-sm-8">
                                   <select name="drp_vendor[]" id="drp_vendor" multiple="multiple" >
										<?php foreach ($header['vendor'] as $content) : ?>
											<option value="<?php echo $content->vid; ?>"><?php echo $content->vendor_name; ?></option>
										<?php endforeach; ?>
									</select>
									
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Generate PDF</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
     
</div>
<script>
/*
$(document).ready(function(){

//$( ".purchaseregister").addClass( " active " );
 $('#drp_vendor').multipleSelect();
 

 
 
});*/

</script>