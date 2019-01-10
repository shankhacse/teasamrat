/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".vendoradvance").addClass( " active " );  

var basepath = $("#basepath").val();           

    
});
//Document End




function delVendorAdvance(id,voucher)
{
	$("#voucher_no-info").text(voucher);
	$("#dialog-confirm-cusadv").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
				$(this).dialog("close");	
				var basepath = $("#basepath").val();

				$("#del_va_Icon").css("display","none");

				$.ajax({
					type: 'POST',
					url: basepath + "vendoradvance/delVendorAdvance",
					data:{"venadvid":id,"voucher":voucher},
					dataType:'json',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
					success: function(data) 
					{
						$("#vendoradvanceResponse").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                        });


						if(data.ERROR==1)
						{
							$("#vendoradvanceResponseData").text(data.MSG);
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

							$("#del_va_Icon").css("display","inline-block");
						}
						if(data.ERROR==0)
						{
							$("#vendoradvanceResponseData").text(data.MSG);
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
							$('#va_close_btn').attr("onclick", "location.reload()");

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
