<!DOCTYPE html>



<html>
    <head>
        <head>
        <meta charset='UTF-8'>

        <title>GST Register</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
       <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
        <style>
	.demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	.demo th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:22px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:20px;		
		
	}
        .small_demo {
		border:1px solid;
		padding:2px;
	}
	.small_demo td {
		//border:1px solid;
		padding:2px;
                width: auto;
                font-family:Verdana, Geneva, sans-serif; 
                font-size:11px; font-weight:bold;
	}
        
        
	.headerdemo {
		border:1px solid #C0C0C0;
		padding:2px;
	}
	
	.headerdemo td {
		//border:1px solid #C0C0C0;
		padding:2px;
	}
        .break{
            page-break-after: always;
        }
</style>
      
  </head>
  <body>




      <table width="100%">
          <tr>
              <td width="25%"></td>
              <td width="40%" align="center"> <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">GST Register(Input)</td>
              <td width="20%"></td>
          </tr>
      </table>
      <table width="100%">
          <tr>
              <td width="25%"></td>
              <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($company);?></font></td>
              <td width="30%" align="right"></td>
          </tr>
          <tr>
              <td width="25%"></td>
              <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; "><?php echo ($companylocation); ?></font></td>
              <td width="30%" align="right"></td>
          </tr>
          <tr>
              <td width="35%"></td>
              <td width="35%"></td>
              <td align="center" width="20%"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">Date: <?php echo($printDate); ?></font></td>

          </tr>



      </table>

       <table width="100%" style="font-weight:bold;font-family:verdana;font-size:11px;">
         
          
          <?php if($dateRange){ ?>
          <tr>
              <td width="100">For The Period : </td>
              <td><?php echo $dateRange; ?></td>
          </tr>
          <?php } ?>
      </table>


      <table width="100%" class="demo" >

        <tr>
		  <th>Sl</th>
          <th>Date</th>
          <th>Vendor</th>
          <th>Vch Type</th>
          <th>Vch No</th>
          <th>Taxable</th>
          <th>CGST</th>
          <th>SGST</th>
          <th>IGST</th>
		  <th>Total Gst</th>
          <th>Bill Amt</th>
        </tr>

        <?php 
          if($gstRegisterData)
          {
            $i=1;
            $totalCGST = 0;
            $totalSGST = 0;
            $totalIGST = 0;
            $totaltaxableAmt = 0;
            foreach($gstRegisterData as $gst_register)
            {
                $transType ="";
                $trantype = $gst_register['voucherData']->transaction_type;
                if($trantype=="PR" OR $trantype == "RP" OR $trantype== "SP")
                {
                  $transType = "Purchase";
                }
                elseif($trantype=="JV")
                {
                   $transType = "Journal";
                }
                else
                {
                    $transType = "";
                }

                $taxableAmt = $gst_register['partyDataDtl']['totalTaxAmt']- ($gst_register['cgstAmt']+$gst_register['sgstAmt']+$gst_register['igstAmt']);
             ?>

        <tr>
			<td><?php echo $i;?></td>
            <td><?php echo date('d-m-Y',strtotime($gst_register['voucherData']->voucher_date )); ?></td>
            <td><?php echo $gst_register['partyDataDtl']['partyName']; ?></td>
            <td><?php echo $transType ; ?></td>
            <td><?php echo $gst_register['voucherData']->voucher_number ; ?></td>
             
            <td align="right"><?php echo number_format($taxableAmt,2) ; ?></td>
            <td align="right"><?php echo number_format($gst_register['cgstAmt'],2) ; ?></td>
            <td align="right"><?php echo number_format($gst_register['sgstAmt'],2) ; ?></td>
            <td align="right"><?php echo number_format($gst_register['igstAmt'],2) ; ?></td>
			<td align="right"><?php echo number_format($gst_register['cgstAmt']+$gst_register['sgstAmt']+$gst_register['igstAmt'],2) ; ?></td>
            <td align="right"><?php echo number_format($gst_register['partyDataDtl']['totalTaxAmt'],2) ; ?></td>
        </tr>

        <?php

            $i++;

            $totalCGST+= $gst_register['cgstAmt'];
            $totalSGST+= $gst_register['sgstAmt'];
            $totalIGST+= $gst_register['igstAmt'];
			$totalGST +=($gst_register['cgstAmt'] + $gst_register['sgstAmt'] + $gst_register['igstAmt']);
            $totaltaxableAmt+= $taxableAmt;
            }
            

          }
        ?>
        

        <tr>
          <td colspan="5"></td>
          <td><b><?php echo number_format($totaltaxableAmt,2) ; ?></b></td>
          <td><b><?php echo number_format($totalCGST,2) ; ?></b></td>
          <td><b><?php echo number_format($totalSGST,2) ; ?></b></td>
          <td><b><?php echo number_format($totalIGST,2) ; ?></b></td>
		  
		  <td><b><?php echo number_format($totalGST,2) ; ?></b></td>
		  
          <td><b><?php echo number_format(($totaltaxableAmt+$totalCGST+$totalSGST+$totalIGST),2) ; ?></b></td>
          
        </tr>

</table>

</body>
</html>