<?php 

?>

 <select id="sel_consignee" name="sel_consignee" class="customer" >
		<option value="">Select</option>
		<?php
				foreach ($consigneetList as  $value) { ?>

				<option value="<?php echo $value->id; ?>"><?php echo $value->consignee_name; ?></option>

					<?php	}
					?>

</select> 

