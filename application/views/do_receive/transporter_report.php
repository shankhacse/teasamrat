<script>
$(document).ready(function(){
    $('#date_form,#date_to').datepicker({
        dateFormat: 'dd-mm-yy',
     
});
});
</script>
<h1><font color="#5cb85c">Transporter Report</font></h1>
<section id="loginBox" style="width:600px;">
    <div class="row">
     <div class="col-md-12">
         <form action="<?php echo(base_url());?>doproductrecv/generateTransStock" method="post" target="_blank">
     <table>
        
        <tr>
            <td>From</td>
            <td>&nbsp;</td>
            <td><input type="text" class="textStyle datepicker" id="date_form" name="date_form"  autocomplete="false"></td>
        
            <td>To</td>
            <td>&nbsp;</td>
            <td> <input type="text" class=" textStyle datepicker" id="date_to" name="date_to" autocomplete="false"></td>
        </tr>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td>Transporter</td>
            <td>&nbsp;</td>
            <td>
                <select class="" id="transporter" name="transporter">
                      <option value="">--Select--</option>
                      <?php if($bodycontent['transporterlist']){
                         
                          foreach($bodycontent['transporterlist'] as $rows){?>
                      <option value="<?php echo $rows->id; ?>" <?php if($rows->id==$bodycontent['selected_transporter']){echo("selected=selected");}?>><?php echo($rows->name);?></option>
                      
                         <?php
                             }
                          }
                          ?>
                  </select>
            </td>
            <td></td>
            <td></td>
            <td></td>
            
        </tr>
        <tr>
            <td colspan="4">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <button type="submit" class="btn btn-success btn-md">Generate PDF</button>
            </td>
            <td>
                
            </td>
        </tr>
    </table>
    </form>      
    </div>
    </div>
 </section>
