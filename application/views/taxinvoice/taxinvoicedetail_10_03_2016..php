
 
<div id="salebillDetails_0_<?php echo($divnumber); ?>" class="taxinvoicedetails">
            <table width="100%" class="gridtable">
                        <tr>
                        <td width="30%">
                            <select name="finalproduct[]" id="finalproduct_0_<?php echo($divnumber); ?>" style="width:200px;" class="finalProduct"> 
                        <option value="0">Select Product</option>
                        <?php foreach($finalproduct as $rows){?>
                        <option value="<?php echo($rows['productPacketId']);?>">
                            <?php echo($rows['finalproduct']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                        <td width="10%">
                            <input type="text" class="packet" id="txtDetailPacket_0_<?php echo($divnumber); ?>" name="txtDetailPacket[]" value="" placeholder="Packet" onkeyup="checkNumeric(this);"/></td>
                        <td width="10%"><input type="text" class="net" id="txtDetailNet_0_<?php echo($divnumber); ?>" name="txtDetailNet[]" value="" placeholder="Net(Kg)" onkeyup="checkNumeric(this);"/></td>
                        <td width="10%"><input type="text" class="pacQty" id="txtDetailQuantity_0_<?php echo($divnumber); ?>" name="txtDetailQuantity[]"  placeholder="Quantity(Kg)" readonly/></td>
                        <td width="10%"><input type="text" class="rate" id="txtDetailRate_0_<?php echo($divnumber); ?>" name="txtDetailRate[]" placeholder="Rate" /></td>
                        <td width="10%"><input type="text" class="amount" id="txtDetailAmount_0_<?php echo($divnumber); ?>" name="txtDetailAmount[]" placeholder="Amount" readonly/></td>
                        <td width="20%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_0_<?php echo($divnumber); ?>" />
                        </td>
                        </tr>
            </table>
    </div>


<script>


    




</script>