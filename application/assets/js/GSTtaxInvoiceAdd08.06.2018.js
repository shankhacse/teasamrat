/**
 *@add blending [addBlendingJS.js]
 *@08/09/2015 
 */
$(document).ready(function() {
    $(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".taxinvoice").addClass(" active ");
	
	// Adding Css to grid table
	
	$(".gridtable").css({
		"margin-bottom":"10px",
		"border-bottom":"3px solid #18661f"
	});

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    var divSerialNumber = 0;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
    
      $("#customer,#placeofsupply").customselect();
    
    
    /*added by mithilesh on 09-03-2016*/
 $("#saleBillDate").change(function(){
     var saleBilldate = $("#saleBillDate").val();
     $("#taxInvoiceDate").val(saleBilldate);
 });/*----end--*/

    $("#addnewDtlDiv").click(function() {
        divSerialNumber = divSerialNumber + 1;
        $.ajax({
            url: basepath + "GSTtaxinvoice/createDetails",
            type: 'post',
            data: {divSerialNumber: divSerialNumber},
            success: function(data) {
                $(".salebillDtl").append(data);
            },
            complete: function() {
                // $("#stock_loader").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });
   
   $("#saveSaleBill").click(function(){
      
      if(getValidation()){
          
          if(detailValidationRow()){
           
           var formData = $("#frmSaleBill").serialize();
           var mode=$("#txtModeOfoperation").val();
           var SaleBillId = $("#hdSalebillid").val();//sale bill id for add and edit.
           $('#stock_loader').show();
           $('#saveSaleBill').hide();
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "GSTtaxinvoice/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,salebillid:SaleBillId},
            success: function(data) {
                if(data==1){
							if(mode=="Add"){
                                        $( "#sale_bil_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'GSTtaxinvoice';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
							}
							if(mode=="Edit")
							{
								$( "#sale_bil_upd_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'GSTtaxinvoice';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
							}
                           }else{
                                        $( "#salebil_error_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                           }
            },
            complete: function(data) {
                 $("#stock_loader").hide();
                 $('#saveSaleBill').show();
                 
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });

          
          }
           /*
          else{
          
           $( "#salebil_detail_validation_fail" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
          }
          */
          
      }
       
   });





 $("#saleBillDate").change(function() {
       var Adddays=0;
      
       var creditDays = $('#creditdays').val();
        //  var creditDt= $.trim(creditDays);
        if(creditDays==""){
            Adddays=0;
        }else{
            Adddays = creditDays
        }
      
       

        var saledate = $("#saleBillDate").val().split("-");
        var sale = saledate[1] + '/' + saledate[0] + '/' + saledate[2];
        dtNextWeek = new Date(sale);
        dtNextWeek.setDate(dtNextWeek.getDate() + parseInt(Adddays));
        var month = dtNextWeek.getMonth() + parseFloat(1);
        if (month < 9)
        {
            month = '0' + month;
        }

        var promtdate = dtNextWeek.getDate() + '/' + month + '/' + dtNextWeek.getFullYear();
        $('#txtDueDate').val(promtdate);
     });

 /*@method getCreditDaysFromCustomer
  * 15-06-2016
  * By : Mithilesh
  */
 
 $(document).on('change','.customer',function(){
    var customerId = $("#customer").val();
    
     $.ajax({
            url :  basepath + "GSTtaxinvoice/getCreditDaysFromCustomer",
            type: "POST",
            dataType:'json',
            data : {customerId:customerId},
            success: function(data)
            {
               $("#creditdays").val(data.credit_days);
              
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });    
        
     
    
 });
 
 
 $(document).on('blur','.customer',function(){
        getDueDate();
 });
 
 
 
  $(document).on('blur','.salebillNo',function(){
    var SaleBillNo = $("#txtSaleBillNo").val();
    
    
     $.ajax({
            url :  basepath + "GSTtaxinvoice/checkExistingSaleBillNo",
            type: "POST",
            dataType:'json',
            data : {SaleBillNo:SaleBillNo},
            success: function(data)
            {
            if(data==1){
                
                 $( "#check_salebill_no" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     $("#txtSaleBillNo").val("");
                                                     $("#txtTaxInvoiceNo").val("");
                                                    $( this ).dialog( "close" );
                                                     $("#txtSaleBillNo").focus();
                                                   
                                                }
                                              }
                                            });
            }
              
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });   
    
 });
 
 
 // Due Date
 
  


     $(document).on('blur','#txtSaleBillNo',function(){
        
         var salebillNo = $("#txtSaleBillNo").val();
        
         $("#txtTaxInvoiceNo").val(salebillNo);
     });



    $(document).on('keyup', ".packet", function() {
        var packetId = $(this).attr('id');
        var detailIdarr = packetId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getQuantity(master_id, detail_id);
        getAmount(master_id, detail_id);
        resetGstTax(master_id, detail_id);
		
		getDetailDiscountAmount(master_id,detail_id);
		var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
		getTaxableamount($(this).attr("id"),parseFloat(discount));
		
        callAllTotalFunction();

    });

    $(document).on('keyup', ".net", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getQuantity(master_id, detail_id);
        getAmount(master_id, detail_id);
        resetGstTax(master_id, detail_id);
		
		getDetailDiscountAmount(master_id,detail_id);
		var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
		getTaxableamount($(this).attr("id"),parseFloat(discount));
        
        callAllTotalFunction();
    });


    $(document).on('keyup', ".rate", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getAmount(master_id, detail_id);
        resetGstTax(master_id, detail_id);
		getDetailDiscountAmount(master_id,detail_id);
		
		getDetailDiscountAmount(master_id,detail_id);
		var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
		getTaxableamount($(this).attr("id"),parseFloat(discount));
		
        callAllTotalFunction();

    });

    $(document).on('change', ".finalProduct", function() {
        
        var productPacketId=$(this).val();
        
        
        var id = $(this).attr('id');
        var detailIdarr = id.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];
        var txtHSNId="#txtHSNNumber_"+master_id+"_"+detail_id;
        var txtRateId="#txtDetailRate_"+master_id+"_"+detail_id;
        var txtNetId="#txtDetailNet_"+master_id+"_"+detail_id;
        var txtDetailAmt="#txtDetailAmount_"+master_id+"_"+detail_id;
        $.ajax({
            url :  basepath + "GSTtaxinvoice/get_final_product_rate",
            type: "POST",
            dataType:'json',
            data : {productId:productPacketId},
            success: function(data)
            {
               
                $(txtRateId).val(data.sale_rate);
                $(txtNetId).val(data.net_kgs);
                $(txtHSNId).val(data.hsn_code);
				
                getAmount(master_id, detail_id);
                resetGstTax(master_id, detail_id);
				
				
				getDetailDiscountAmount(master_id,detail_id);
				var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
				getTaxableamount(id,parseFloat(discount));
				
				callAllTotalFunction();
					
                //data - response from server
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });    
    });


    $("#txtDiscountPercentage").keyup(function() {
        callAllTotalFunction();
    });

    $("#txtDeliveryChg").keyup(function() {
        callAllTotalFunction();
    });

    $('input[name="rateType"]:radio').click(function() {
        
        var rateType ="";
        var rate = $("input[type='radio'][name='rateType']:checked");

        if (rate.length > 0) {
             rateType = rate.val();
            if(rateType=="V"){
                $("#divVat").css("display", "block");
                $("#divCst").css("display", "none");
            }else{
                $("#divVat").css("display", "none");
                $("#divCst").css("display", "block");
            }
        }

         callAllTotalFunction();
    });
  
   $("#vat").change(function(){
        callAllTotalFunction();
   });
   
    $("#cst").change(function(){
        callAllTotalFunction();
   });
   $("#txtRoundOff").keyup(function(){
        callAllTotalFunction() ;
   });

    $(document).on('click', ".del", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        //console.log("divID :"+master_id+"-"+detail_id);
        var div_identification_id = "#salebillDetails_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        
       // getAmount(master_id, detail_id);
        callAllTotalFunction();

    });


$(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '.net', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '.packet', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
$(document).on('keyup', '.discrate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
$(document).on('blur','.discount',function(){
    console.log($(this).attr("id"));
    getTaxableamount($(this).attr("id"),$(this).val());
    getDiscountAmount();
    getTaxAmount();
    callAllTotalFunction();
});

// get discount by discount rate
$(document).on('blur','.discrate',function(){
    console.log($(this).attr("id"));
	
	var discrateId = $(this).attr('id');
    var detailIdarr = discrateId.split('_');
    var master_id = detailIdarr[1];
    var detail_id = detailIdarr[2];
	
    getDetailDiscountAmount(master_id,detail_id);
	var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
	getTaxableamount($(this).attr("id"),parseFloat(discount));
    getDiscountAmount();
    getTaxAmount();
    callAllTotalFunction();
     reCalculateGSTAmount($(this).attr("id"));
   /*  getTaxableamount($(this).attr("id"),$(this).val());
    getDiscountAmount();
    getTaxAmount();
    callAllTotalFunction(); */
});


// get discount by discount rate
$(document).on('blur','.deliverycharge',function(){
    console.log($(this).attr("id"));
  
  var Id = $(this).attr('id');
  var detailIdarr = Id.split('_');
  var master_id = detailIdarr[1];
  var detail_id = detailIdarr[2];
  var taxablewithdeliverCharg = 0;
  var delivery_chrg = 0;

  var discount = $("#txtDiscount_"+master_id+"_"+detail_id).val() || 0;
  getTaxableamount($(this).attr("id"),parseFloat(discount));

  delivery_chrg = parseFloat($("#txtDelivery_"+master_id+"_"+detail_id).val() || 0);
  var taxable =  parseFloat($("#txtTaxableAmt_"+master_id+"_"+detail_id).val() || 0);
  taxablewithdeliverCharg = parseFloat(taxable)+parseFloat(delivery_chrg);
  $("#txtTaxableAmt_"+master_id+"_"+detail_id).val(taxablewithdeliverCharg.toFixed(2));

    getTaxableamount($(this).attr("id"),parseFloat(discount));
    getDiscountAmount();
    getTaxAmount();
    callAllTotalFunction();
    reCalculateGSTAmount($(this).attr("id"));
   
});


$(document).on('change','.cgst',function(){
    console.log($(this).attr("id"));
    var cgstRateId = $(this).val();
    var amt = getGSTTaxAmount(cgstRateId,$(this).attr("id"),"CGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#cgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalCGST();
    callAllTotalFunction();
});

//sgst
$(document).on('change','.sgst',function(){
    console.log($(this).attr("id"));
    var sgstRateId = $(this).val();
    var amt = getGSTTaxAmount(sgstRateId,$(this).attr("id"),"SGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#sgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalSGST();
    callAllTotalFunction();
});

//IGST
$(document).on('change','.igst',function(){
    console.log($(this).attr("id"));
    var igstRateId = $(this).val();
    var amt = getGSTTaxAmount(igstRateId,$(this).attr("id"),"IGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#igstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
       // getTotalIGST();
       callAllTotalFunction();
});

$("#txtFreight").blur(function(){
 
     callAllTotalFunction();
     
});
$("#txtInsurance").blur(function(){
    callAllTotalFunction();
});
$("#txtPckFrw").blur(function(){
    callAllTotalFunction();
});



});

//******************************User Defined Function for salebill ******************************//

function reCalculateGSTAmount(jQueryId)
{

   
    var arr = jQueryId.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 

  var id = "_"+masterId+"_"+detailId;

  var cgstAmt = 0;
  var sgstAmt = 0;
  var igstAmt = 0;

  var cgstrateid = $("#cgst"+id).val() || 0;
  var sgstrateid = $("#sgst"+id).val() || 0;
  var igstrateid = $("#igst"+id).val() || 0;

  /*alert(cgstrateid);
  alert(sgstrateid);
  alert(igstrateid);*/


    cgstAmt = getGSTTaxAmount(cgstrateid,jQueryId,"CGST");
    sgstAmt = getGSTTaxAmount(sgstrateid,jQueryId,"SGST");
    igstAmt = getGSTTaxAmount(igstrateid,jQueryId,"IGST");


    $("#cgstAmt"+id).val(cgstAmt.toFixed(2)); 
    $("#sgstAmt"+id).val(sgstAmt.toFixed(2)); 
    $("#igstAmt"+id).val(igstAmt.toFixed(2)); 

   callAllTotalFunction();

}


function resetGstTax(masterId,detailId){
   var disStr = ("#txtDiscount"+"_"+masterId+"_"+detailId);
   $(disStr).val("");
   var taxableStr =("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
   $(taxableStr).val("");
     
    var str1 = ("#cgst"+"_"+masterId+"_"+detailId);
    $(str1).val("0");
    var str2 = ("#cgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val("");
    
    var str3 = ("#sgst"+"_"+masterId+"_"+detailId);
    $(str3).val("0");
    var str4 = ("#sgstAmt"+"_"+masterId+"_"+detailId);
    $(str4).val("");
    
    var str5 = ("#igst"+"_"+masterId+"_"+detailId);
    $(str5).val("0");
    var str6 = ("#igstAmt"+"_"+masterId+"_"+detailId);
    $(str6).val("");
    callAllTotalFunction();
    
}


function getGSTTaxAmount(gstId,jQueryId,type){
    var gstRateId = gstId;
    var arr = jQueryId.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
    var taxableAmount = $(str2).val()||0;
    var basepath = $("#basepath").val();
    
    var taxAmount = 0;
    //console.log(basepath + "GSTtaxinvoice/getAmount");
    $.ajax({
            url :  basepath + "GSTtaxinvoice/getAmount",
            type: "POST",
            dataType:'json',
            data : {gstId:gstRateId,taxableamount:taxableAmount,type:type},
    success: function(result) {
       
      taxAmount =result.amt ;
    },
    async:false
  });
    
   
   return taxAmount;  
    
}

// Cal discount Amount
function getDetailDiscountAmount(masterId,detailId){
	var itemTotalAmt =0;
    var taxableAmount =0;
	var rowAmount = 0;
	var discountAmt = 0;
	
    
    var discRateId = ("#txtDiscountRate"+"_"+masterId+"_"+detailId);
	var rowAmtId = ("#txtDetailAmount"+"_"+masterId+"_"+detailId);
	rowAmount = $(rowAmtId).val() || 0;
	var discountRate = $(discRateId).val() || 0;
	discountAmt = parseFloat(rowAmount)*parseFloat(discountRate)/100;
	$("#txtDiscount"+"_"+masterId+"_"+detailId).val(discountAmt.toFixed(2));
}

function getTaxableamount(discountid,values){
    var arr = discountid.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2];
    var itemTotalAmt =0;
    var taxableAmount =0;
    var deliverycharg = 0;
    
    var str = ("#txtDetailAmount"+"_"+masterId+"_"+detailId);
    itemTotalAmt = $(str).val()||0;

    deliverycharg = $("#txtDelivery"+"_"+masterId+"_"+detailId).val() || 0;
    
    taxableAmount = parseFloat(itemTotalAmt) - parseFloat(values||0) + parseFloat(deliverycharg); // deliverycharg added on 23.04.2018

    var str2 = ("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(taxableAmount.toFixed(2));
    
}
function getValidation(){
   

    var saleBillDate = $("#saleBillDate").val();
    var customerId = $("#customer").val();

    $("#saleBillDate,#customer").removeClass('glowing-border');
    $("#frmSaleBill #customer_td .custom-select").removeClass('custom_err');

    if(saleBillDate=='')
    {
        $("#saleBillDate").addClass('glowing-border');
        return false;
    }
    if(customerId==0)
    {
          $("#frmSaleBill #customer_td .custom-select").addClass('custom_err');
          return false;
    }
    // if(saleBillNo==''){$("#txtSaleBillNo").addClass('glowing-border');return false;}
    if(getNumberofDetails()<=0)
    {
      alert("Add detail data");
      return false;
    }
 
    return true;
}




function detailValidationRow()
{
    var isValid = true;

    $(".finalProduct").removeClass("custom_err");
    $(".pacQty").removeClass("custom_err");
    $(".amount").removeClass("custom_err");

    $(".cgst").removeClass("custom_err");
    $(".sgst").removeClass("custom_err");
    $(".igst").removeClass("custom_err");

    $('select[name^="finalproduct"]').each(function() {
      
      var attr_id = $(this).attr('id');
      var idsplit1 = attr_id.split("_");
    
      // Product Validation ---------------------------------------------
      var finalproduct = "#finalproduct_"+idsplit1[1]+"_"+idsplit1[2];
      selectedproduct = parseFloat(($(this).val() == 0 ? 0 : $(this).val()));
      if(selectedproduct==0)
      {
        $(finalproduct).addClass("custom_err");
        isValid =  false;
      }

      // Quantity Validation ---------------------------------------------
      var qtyID = "#txtDetailQuantity_"+idsplit1[1]+"_"+idsplit1[2];
      var qty = parseFloat(($(qtyID).val() == ""||0.00? "" : $(qtyID).val()));
      if(isNaN(qty)) {qty = 0;}
     
      if(qty<=0)
      {
         $(qtyID).addClass("custom_err");
         isValid =  false;
      }


      // Amount Validation ---------------------------------------------
      var amtID = "#txtDetailAmount_"+idsplit1[1]+"_"+idsplit1[2];
      var amount = parseFloat(($(amtID).val() == "" || 0.00? "" : $(amtID).val()));
       if(isNaN(amount)) {amount = 0;}
      if(amount<=0)
      {
         $(amtID).addClass("custom_err");
         isValid =  false;
      }

      // GST Validation ---------------------------------------------
      var cgst = "#cgst_"+idsplit1[1]+"_"+idsplit1[2];
      var sgst = "#sgst_"+idsplit1[1]+"_"+idsplit1[2];
      var igst = "#igst_"+idsplit1[1]+"_"+idsplit1[2];

        var cgstVal = $(cgst).val();
        var sgstVal = $(sgst).val();
        var igstVal = $(igst).val();


       if(cgstVal==0 && sgstVal==0 && igstVal==0)
       {
           $(cgst).addClass("custom_err");
           $(sgst).addClass("custom_err");
           $(igst).addClass("custom_err");
           isValid =  false;
       }

       else if (igstVal==0 && (cgstVal!=0 && sgstVal==0))
       {
           $(sgst).addClass("custom_err");
           isValid = false;
       }
       else if(igstVal==0 && (cgstVal==0 && sgstVal!=0))
       {
           $(cgst).addClass("custom_err");
            isValid = false;
       }
       else if(igstVal!=0 && (cgstVal==0 && sgstVal!=0) )
       {
           $(sgst).addClass("custom_err");
            isValid = false;
       }
       else if(igstVal!=0 && (cgstVal!=0 && sgstVal==0) )
       {
           $(cgst).addClass("custom_err");
            isValid = false;
       }
       else if(igstVal!=0 && cgstVal!=0 && sgstVal!=0) 
       {
           $(cgst).addClass("custom_err");
           $(sgst).addClass("custom_err");
           $(igst).addClass("custom_err");
            isValid = false;
       }

    });

    if(isValid)
    {
      return true
    }
    else
    {
      return false;
    }

  //  return isValid;
}



/*
function detailvalidation (){
     if(!getProductValidation()){
        $( "#salebil_detail_error" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
    
      if(!getQtyValidation()){
        $( "#salebil_detail_error" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
     if(!getAmountValidation()){
        $( "#salebil_detail_error" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
     return true;
}
*/


/*******/
function getNumberofDetails(){
    var numberofDetails=0;
    $('section.salebillDtl').each(
        function() {
          numberofDetails=(($(this).find('.taxinvoicedetails')).length);
        }
      );
      return numberofDetails;
}


function getProductValidation (){
    
    var selectedproduct;
    var flag=0;
     $('select[name^="finalproduct"]').each(function() {
         
        selectedproduct = parseFloat(($(this).val() == 0 ? 0 : $(this).val()));
       //console.log(selectedproduct);
        if(selectedproduct==0){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 function getQtyValidation(){
      var flag=0;
      $('input[name^="txtDetailQuantity"]').each(function() {
         
        var qty = parseFloat(($(this).val() == ""||0.00? "" : $(this).val()));
       //console.log(selectedproduct);
        if(qty==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 function getAmountValidation(){
      var flag=0;
      $('input[name^="txtDetailAmount"]').each(function() {
         
        var amount = parseFloat(($(this).val() == "" || 0.00? "" : $(this).val()));
       //console.log(selectedproduct);
        if(amount==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 
 
 

/**
 * @function getQuantity
 * @param {type} masterId
 * @param {type} detailId
 * @returns {int}
 */

function getQuantity(masterId, detailId) {
    var Qauntity = 0;
    var numberofpacket = 0;
    var netinpacket = 0;

    numberofpacket = parseFloat($("#txtDetailPacket_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailPacket_" + masterId + "_" + detailId).val());
    netinpacket = parseFloat($("#txtDetailNet_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailNet_" + masterId + "_" + detailId).val());

    Qauntity = parseFloat(numberofpacket * netinpacket);

    $("#txtDetailQuantity_" + masterId + "_" + detailId).val(Qauntity.toFixed(2));
    return Qauntity.toFixed(2);
}
/**
 * @function getAmount
 * @param {type} masterId
 * @param {type} detailId
 * @returns {getAmount.amount|Number}
 */
function getAmount(masterId, detailId) {
    var amount = 0;
    var rate = 0;
    var quantity = 0;
    rate = parseFloat($("#txtDetailRate_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailRate_" + masterId + "_" + detailId).val());
    quantity = parseFloat($("#txtDetailQuantity_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailQuantity_" + masterId + "_" + detailId).val());

    amount = parseFloat(rate * quantity);

    $("#txtDetailAmount_" + masterId + "_" + detailId).val(amount.toFixed(2));

    return amount.toFixed(2);
}

////////////////////////////Total Calculation/////////////////////////////
function callAllTotalFunction() {
    getTotalPacket();
    getTotalQty();
    getTotalAmount();
    getDiscountAmount();
    getTaxAmount();
    getTotalCGST();
    getTotalSGST();
    getTotalIGST();
    totalTaxIncludedAmount();
    getGrandTotal();

}

function getTotalPacket() {
    var totalPacket = 0;
    var packet = 0;

    $('input[name^="txtDetailPacket"]').each(function() {
        var qty = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalPacket = parseFloat(totalPacket + qty);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalPacket").val(totalPacket.toFixed(2));
    return totalPacket.toFixed(2);
}
function getTotalQty() {
    var totalQty = 0;
    var net = 0;

    $('input[name^="txtDetailQuantity"]').each(function() {
        net = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalQty = parseFloat(totalQty + net);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalQty").val(totalQty.toFixed(2));
    return totalQty.toFixed(2)

}
function getTotalAmount() {
    var totalAmount = 0;
    var amount = 0;
    $('input[name^="txtDetailAmount"]').each(function() {
        amount = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalAmount = parseFloat(totalAmount + amount);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalAmount").val(totalAmount.toFixed(2));
    return totalAmount.toFixed(2);

}

function getDiscountAmount() {
   /* var totalamount = 0;
    var discountRate = 0;
    var discountAmount = 0;
    totalamount = parseFloat(getTotalAmount());
    discountRate = parseFloat($("#txtDiscountPercentage").val() == "" ? 0 : $("#txtDiscountPercentage").val());

    discountAmount = parseFloat((totalamount * discountRate) / 100);

    $("#txtDiscountAmount").val(discountAmount.toFixed(2));

    return discountAmount.toFixed(2);*/
    var totalDiscountAmount =0;
    $('.discount').each(function(){
        totalDiscountAmount = totalDiscountAmount + parseFloat($(this).val()||0);
    });
    
    $("#txtDiscountAmount").val(totalDiscountAmount.toFixed(2));
}
/**
 * @name getTaxAmount
 * @returns {undefined}
 * @description vatrate or cstrate on tax
 */
function getTaxAmount() {
   /* var TaxRate = 0;
    var discountAmount = 0;
    var deliveryChgs=0;
    var amountAfterDiscount = 0;
    var totalAmount = 0;
    var TaxAmount = 0;
    var rateType = "";
    var rate = $("input[type='radio'][name='rateType']:checked");

    if (rate.length > 0) {
        rateType = rate.val();
    }
    if (rateType == "V") {
        TaxRate =parseFloat($("#vat option:selected").text()=='Select'?0:$("#vat option:selected").text());
    } else {
        TaxRate =parseFloat($("#cst option:selected").text()=='Select'?0:$("#cst option:selected").text());
    }
    deliveryChgs=parseFloat($("#txtDeliveryChg").val()==""?0:$("#txtDeliveryChg").val());
    totalAmount = parseFloat(getTotalAmount());
    discountAmount = parseFloat(getDiscountAmount());
    amountAfterDiscount = parseFloat(totalAmount - discountAmount + deliveryChgs);
    TaxAmount = parseFloat((amountAfterDiscount * TaxRate) / 100);

    $("#txtTaxAmount").val(TaxAmount.toFixed(2));*/
    //txtTaxableAmount
    
    var totalTaxableAmt =0;
    
    $('.taxableamount').each(function(){
       
        totalTaxableAmt = totalTaxableAmt + parseFloat($(this).val()||0);
    });
    $("#txtTaxableAmount").val(totalTaxableAmt.toFixed(2));
    return totalTaxableAmt.toFixed(2);
}

function getTotalCGST(){
    var totalCGSTAmount =0;
    $(".cgstAmt").each(function(){
        totalCGSTAmount = totalCGSTAmount + parseFloat($(this).val()||0);
    });
    $("#txtTotalCGST").val(totalCGSTAmount.toFixed(2));
}
function getTotalSGST(){
    var totalSGSTAmt=0;
    $(".sgstAmt").each(function(){
        totalSGSTAmt =totalSGSTAmt + parseFloat($(this).val()||0);
    });
    $("#txtTotalSGST").val(totalSGSTAmt.toFixed(2));
}
function getTotalIGST(){
    var totalIGSTAmt=0;
    $(".igstAmt").each(function(){
        totalIGSTAmt =totalIGSTAmt + parseFloat($(this).val()||0);
    });
    $("#txtTotalIGST").val(totalIGSTAmt.toFixed(2));
}


function totalTaxIncludedAmount(){
    var taxableAmount = $("#txtTaxableAmount").val()||0;
    var cgstamount =  $("#txtTotalCGST").val()||0;
    var sgstamount = $("#txtTotalSGST").val()||0;
    var igstamount = $("#txtTotalIGST").val()||0;
    
    var totalTaxIncludedAmount = parseFloat(taxableAmount)+ parseFloat(cgstamount) + parseFloat(sgstamount) + parseFloat(igstamount);
    $("#txtTotalIncldTaxAmt").val(totalTaxIncludedAmount.toFixed(2));
    return totalTaxIncludedAmount;
    
}

function getGrandTotal(){
    var totalGSTIncludedamount=0;
    var freightCharges = $("#txtFreight").val()||0;
    var insurance = $("#txtInsurance").val()||0;
    var pkgfrwd =$("#txtPckFrw").val()||0;
    var roundoff=0;
    var grandTotal = 0;
    
     roundoff = parseFloat($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val());
    
    totalGSTIncludedamount = parseFloat(totalTaxIncludedAmount());
    grandTotal = (parseFloat(totalGSTIncludedamount) + parseFloat(freightCharges)+ parseFloat(insurance)+parseFloat(pkgfrwd))+(roundoff);
    
    $("#txtGrandTotal").val(grandTotal.toFixed(2));
    return grandTotal.toFixed(2);
    
    
}



function getDueDate(){
    
     var Adddays=0;
      
       var creditDays = $('#creditdays').val();
        //  var creditDt= $.trim(creditDays);
        if(creditDays==""){
            Adddays=0;
        }else{
            Adddays = creditDays
        }
      
       

        var saledate = $("#saleBillDate").val().split("-");
        var sale = saledate[1] + '/' + saledate[0] + '/' + saledate[2];
        dtNextWeek = new Date(sale);
        dtNextWeek.setDate(dtNextWeek.getDate() + parseInt(Adddays));
        var month = dtNextWeek.getMonth() + parseFloat(1);
        if (month < 9)
        {
            month = '0' + month;
        }

        var promtdate = dtNextWeek.getDate() + '-' + month + '-' + dtNextWeek.getFullYear();
        $('#txtDueDate').val(promtdate);
    
}

function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
} 


//******************************User Defined Function for salebill ******************************//    











///////////////////old/////////////////////





        