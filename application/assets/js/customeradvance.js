/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".customeradvance").addClass( " active " );  



var basepath = $("#basepath").val();           


    
    
    
});


function delCustomerAdvance(id,voucher)
{
	$("#voucher_no-info").text(voucher);
	$("#dialog-confirm-cusadv").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
				$(this).dialog("close");	
				$("#del_ca_Icon").css("display","none");

				var basepath = $("#basepath").val();
				$.ajax({
					type: 'POST',
					url: basepath + "customeradvance/delCustomerAdvance",
					data:{"cusadvid":id,"voucher":voucher},
					dataType:'json',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
					success: function (data) 
					{

						/*
						if(data=="OK")
						{
							
							$("#voucher_no-afterdlt").text(voucher);
							$("#dialog-confirm-delete").dialog({
								resizable: false,
								height: 140,
								modal: true,
								buttons: {
								"Ok": function(){
									$(this).dialog("close");	
									location.reload();
									}
								}
							});
							
						}
						if(data=="FK")
						{
							//alert("This voucher is used.");
							$("#dialog-used-vouchr").dialog({
								resizable: false,
								height: 140,
								modal: true,
								buttons: {
								"Ok": function(){
									$(this).dialog("close");	
									return false;
									}
								}
							});
							
						}
						if(data=="ERROR")
						{
							alert("There is some problem please try again later.");
							return false;
						}
						*/

						$("#custadvanceResponse").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                        });


						if(data.ERROR==1)
						{
							$("#custadvanceResponseData").text(data.MSG);
							$(".ca_body").css({
								'background':'#ff5050',
								'color':'#FFF'
							});
							$(".ca_footer").css({
								'margin-top':'0px',
								'border-top':'0px solid red',
								'background': '#f0f0f0'
							});

							$(".ca_btn").css({
								'color':'#FFF',
								'background': '#f54545'
							});

							$("#del_ca_Icon").css("display","inline-block");
						}
						if(data.ERROR==0)
						{
							$("#custadvanceResponseData").text(data.MSG);
							$(".ca_body").css({
								'background':'#32b088',
								'color':'#FFF'
							});
							$(".ca_footer").css({
								'margin-top':'0px',
								'border-top':'0px solid red',
								'background': '#f0f0f0'
							});

							$(".ca_btn").css({
								'color':'#FFF',
								'background': '#32b088'
							});
							$('#ca_close_btn').attr("onclick", "location.reload()");

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