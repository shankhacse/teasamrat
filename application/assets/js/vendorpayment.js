$(document).ready(function(){
    
    $( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
    $( ".vendorpayment").addClass( " active " );  

    
    
   var basepath = $("#basepath").val();
    
    $(document).on("click",".paymentDetails",function(){
        
       var vendorPaymentId = $(this).attr("id");
        $.ajax({
                type: 'POST',
                url: basepath + "vendorpayment/getDetailsOfInvoice",
                data: {
                    "vendorpaymentId":vendorPaymentId,
                },
                dataType:'html',
                success: function (data) {
                    
                    //alert(data);
                    $("#detailInvoice").html(data);
                        $( "#dialog-detail-view" ).dialog({
                            modal: true,
                            height:310,
                            width:550,
                            
                            buttons: {
                              Ok: function() {
                                $( this ).dialog( "close" );
                              }
                            }
                          });
                }
            });
        
    });
    
    
});




function delVendorPayment(id,voucher)
{
    $("#voucher_no-info").text(voucher);
    $("#dialog-confirm-vendor-payment").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");    
                var basepath = $("#basepath").val();
                $("#del_vp_Icon").css("display","none");
                $.ajax({
                    type: 'POST',
                    url: basepath + "vendorpayment/delVendorPayment",
                    data:{"vendorpaymentID":id,"voucherno":voucher},
                    dataType:'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                    success: function(data) 
                    {
                        $("#vendorpaymentResponse").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                        });


                        if(data.ERROR==1)
                        {
                            $("#vendorpaymentResponseData").text(data.MSG);

                            $(".va_body").css({
                                'background':'#ff5050',
                                'color':'#FFF'
                            });

                            $(".va_footer").css({
                                'margin-top':'0px',
                                'border-top':'0px solid red',
                                'background': '#f0f0f0'
                            });

                            $(".va_btn").css({
                                'color':'#FFF',
                                'background': '#f54545'
                            });

                            $("#del_vp_Icon").css("display","none");
                        }
                        if(data.ERROR==0)
                        {
                            $("#vendorpaymentResponseData").text(data.MSG);
                            $(".va_body").css({
                                'background':'#32b088',
                                'color':'#FFF'
                            });
                            $(".va_footer").css({
                                'margin-top':'0px',
                                'border-top':'0px solid red',
                                'background': '#f0f0f0'
                            });

                            $(".va_btn").css({
                                'color':'#FFF',
                                'background': '#32b088'
                            });
                            $('#vp_close_btn').attr("onclick", "location.reload()");

                        }
                    }
                }); 
                    
                    
            },
            Cancel: function() {
                $(this).dialog("close");
             }
        }
    });
    
    
}
