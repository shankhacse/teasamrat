<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tax Invoice Cum Challan</title>

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
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:11px;		
		
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
</style>
</style>


</head>
    

<body>
    <table width="100%">
        <tr>
            <td width="25%"></td>
            <td width="40%" align="center"> <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">TAX INVOICE CUM CHALLAN</span></td>
            <td width="30%" align="right"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;"> ORIGINAL BUYER'S COPY</span></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($headerview['Company']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
         <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; "><?php echo($headerview['CompanyLocation']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
        
    </table>
    
    <table width="100%" class="headerdemo">
         <tr>
             <td width="40%" valign="top">
                 <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['Customer']); ?></font></br>
                 <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['CustomerAddress']); ?></font></br>
                 <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Vat Number: <?php echo($headerview['VatNumber']); ?></font>
             </td>
            <td width="30%" align="center">
                
            </td>
            <td width="30%" align="right">
                <table  width="100%">
                    <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">SALE BILL NO:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['SaleBillNo']); ?></td>
                    </tr>
                    
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">DATE:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['SaleBillDate']); ?></td>
                    </tr>
                    
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">TAX INVOICE NO:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['TaxInvoiceNumber']); ?></td>
                    </tr>
                    
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">DATE:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['TaxInvoiceDate']); ?></td>
                    </tr>
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">DUE DATE:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['DueDate']); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

 

    <table width="100%" class="demo" >
        <th align="left">Description</th>
        <th align="center">Packing</th>
        <th align="right">Quantity</th>
<th align="right">Rate</th>
<th align="right">Amount</th>

<?php foreach ($dtlview as $value ){ ?>
<tr>
		<td height="23"><?php echo($value['ProductDescription']);?></td>
                <td><div align="center"><?php echo($value['Packet']);?> X <?php echo($value['PacketNet']);?></div></td>
                <td><div align="right"><?php echo($value['Quantity']);?></div></td>
                <td><div align="right"><?php echo($value['Rate']);?></div></td>
                <td><div align="right"><?php echo($value['Amount']);?></div></td>
        
</tr>
<?php } ?>
<th>&nbsp;</th>
<th align="right"><?php echo($headerview['TotalPacket']); ?></th>
<th align="right"><?php echo($headerview['TotalQty']); ?></th>
<th>&nbsp;</th>
<th align="right"><?php echo($headerview['TotalAmount']); ?></th>
</table>
<div align="right">
    <table width="31%" class="small_demo">
    <tr>
      <td>Discount</td>
      <td>@<?php echo($headerview['DiscountRate']); ?>  %</td>
      <td><div align="right"><?php echo($headerview['DiscountAmount']); ?></div></td>
    </tr>

    <tr>
      <td>Delivery Chgs.</td>
      <td>&nbsp;</td>
      <td><div align="right"><?php echo($headerview['DeliveryChgs']); ?></div></td>
    </tr>
        
    <tr>
      <td><?php echo(($headerview['TaxRateType']=="V"?"VAT":"CST")); ?></td>
      <td>&nbsp;</td>
      <td><div align="right"><?php echo($headerview['TaxAmount']); ?></div></td>
    </tr>
    <tr>
      <td>Round Off</td>
      <td>&nbsp;</td>
      <td><div align="right"><?php echo($headerview['RoundOff']); ?></div></td>
    </tr>
  </table>
</div>
<table width="100%" class="demo">
  
    <th align="left">&#2352 <?php echo($amountinword); ?>&nbsp;ONLY
    </th>
    <th>Total :<th>
    <th align="right"><?php echo($headerview['GrandTotal']); ?></th>
  
  <tr>
    <td>Interest @12% per annum will be charged on overdue bills</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="demo">
  <tr>
    <td width="30%">W.B.V.A.T - 19470546064  C.S.T -19470546258</td>
    <td width="70%"><div align="right">For TEA SAMRAT</div></td>
  </tr>
  <tr>
    <td><div align="justify">We hereby certify that food mentioned in this invoice is warrented to 
    	be the nature and quality it purports to be
    </div></td>
      <td align="right" valign="bottom">Authourised Signatory</td>
  </tr>
</table>


</body>
</html>
