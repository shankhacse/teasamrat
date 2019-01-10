$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".vendoradvance").addClass( " active " );  
    
    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    
     $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate,
        onSelect: function(dateText,inst){
          $("#cheqdt").val(dateText);
        }
        
    });
    //chqDt
     $('.chqDt').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
        
    });

    $(document).on('keyup','#dateofadvance',function(){
      $("#cheqdt").val($(this).val()); 
    });
    
     $("#vendoradvance").customselect();
    
    $('#paymentamount').keypress(function(event){
       return isNumber(event, this);
    })
   

      $(document).on('change', "#cashorbank", function() {
       var accountId = $("#cashorbank").val();
       var checqno = $("#hidenChqno").val();
       var checqdate = $("#hidenChqdate").val();
       var mode = $("#mode").val();
        
       $.ajax({
            url: basepath + "generalvoucher/getAccountGroup",
            type: 'post',
            data: {accountId:accountId},
            success: function(data){
              if(data==1){
                  $("#cheqno").attr("disabled","disabled");
                     $("#cheqno").val(" ");
                  $("#cheqdt").attr("disabled","disabled");
                    $("#cheqdt").val(" ");
              }else{
                  $("#cheqno").removeAttr("disabled");
                   $("#cheqno").val(checqno);
                  $("#cheqdt").removeAttr("disabled");
                  if(mode=="Edit")
                  {
                    $("#cheqdt").val(checqdate);
                  }
                  else
                  {
                    $("#cheqdt").val($("#dateofadvance").val());
                  }
                  
              }
                
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
   


  $('#saveVendorAdvance').click(function(){
  if (checkAdjusmentExist()) {
        
        if(getValidation()){
            
              var formData = $("#addvendorAdvance").serialize();
              var modeop= $('#mode').val();
              formData = decodeURI(formData);
              console.log(formData);
              $("#saveVendorAdvance").css("display","none");
              $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: basepath + "vendoradvance/SaveVendorAdvance",
                        data: {formDatas: formData,mode:modeop},
                        success: function(data) {

                            if (data == 1) {
                                $("#dialog-new-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            window.location.href = basepath +'vendoradvance';
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                            } else {
                                $("#dialog-error-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            $(this).dialog("close");
                                             $("#saveVendorAdvance").css("display","block");
                                        }
                                    }
                                });
                            }
                        },
                        complete: function() {
                        },
                        error: function(e) {
                            //called when there is an error
                            console.log(e.message);
                        }
                    });
            
        }else{
            $("#dialog-validationError").dialog({
                                    resizable: false,
                                    height: 200,
                                    width:400,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                              $(this).dialog("close");
                                        }
                                    }
                                });
            
            
        }

    }//check adjusment 
        
        
    });
    
    
});
//----------------------------------------------------------//
function getValidation(){
    var voucherDate = $("#dateofadvance").val();
    var cashorbank=$("#cashorbank").val();
    var paymentamount =$('#paymentamount').val();
    var vendor = $('#vendoradvance').val();
    if(voucherDate==""){ return false;}
    if(cashorbank==""){return false;}
    if(paymentamount==""){return false;}
    if(vendor==""){return false;}
    
    return true;
    
}
function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    


// add on 07.04.2018 by shankha
function checkAdjusmentExist(){
 
    var basepath = $("#basepath").val();
   
    var vendoradvanceId = $("#vendoradvanceId").val();
    
    var payment_type_hidden = $("#payment_type_hidden").val(); 
    var payment_type = $('input[name=payment_type]:checked').val();
   
   // alert(vendoradvanceId);
  
    //alert(payment_type_hidden);
    //alert(payment_type);
 
      //exit;


     var isValid=true;
   $(".adjusment-validation-err").text('');
   if (payment_type_hidden!="" && payment_type_hidden!=payment_type && payment_type=="RC" ) {
        $.ajax({ 
            type: "POST",
            url: basepath + "vendoradvance/checkExistAdjusmentRecord",
            data: {vendoradvanceId:vendoradvanceId},
            dataType: 'html',
            success: function(data) {

               if(data==1){
              //alert("invalid"); 
              isValid=false;
             
               $(".adjusment-validation-err").text("Delete adjusment record first against voucher no!");   
                 }else{
                  // alert("valid");  
                   isValid=true;  
                 }


              },
       async:false 
        
});

    }
          return isValid;

}
//end of working