/**
*@add blending [addBlendingJS.js]
*@08/09/2015 
*/
$(document).ready(function(){
    
$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".GSTtaxinvoice").addClass( "active " );   
    
    
    
 var basepath = $("#basepath").val();           
/* $(".viewfinishpacket").click(function(){
        var blendId=$(this).attr('id');
        var DtlId = blendId.split('_');
        var bl_id =DtlId[1]; 
        
         $.ajax(
                 {
                            type: 'POST',
                            dataType : 'html',
                            url: basepath + "finishproduct/detailView",
                            data: {finishprodid:bl_id},
                            success: function(data) {
                                $("#dtlRslt").html(data);
                                
                                 $("#finish_product-detail").dialog({
                                                        resizable: false,
                                                        height: 250,
                                                        width:500,
                                                        modal: true,
                                                        buttons: {
                                                            "Ok": function() {
                                                                
                                                                $(this).dialog("close");
                                                            }
                                                        }
                                                    });
                            },
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
                        });
        
 });*/
   
 
 
});
// document load


// salebii
function delSaleBillGST(id,salebillno)
{
    $("#salebill_no_info").text(salebillno);
    $("#dialog-confirm-salebill").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");    
                var basepath = $("#basepath").val();

                $("#delsalebill_gst").css("display","none");

                $.ajax({
                    type: 'POST',
                    url: basepath + "GSTtaxinvoice/delSaleBillGST",
                    data:{"salebillID":id,"salebillno":salebillno},
                    dataType:'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                    success: function(data) 
                    {
                        $("#salebillResponse").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                        });



                        if(data.ERROR==1)
                        {
                            var errMsg = "";
                            errMsg+="<h2 style='font-size:20px;color:#FFF;'>"+data.MSG.textHead+"</h2>";

                            if(data.MSG.custAdjustErr.length>0)
                            {
                                 errMsg+="<p> "+data.MSG.custAdjustErr+"</p>";
                            }
                            if(data.MSG.custReceiptErr.length>0)
                            {
                                 errMsg+="<p> "+data.MSG.custReceiptErr+"</p>";
                            }


                            $("#salebillResponseData").html(errMsg );
                            $(".sb_body").css({
                                'background':'#ff5050',
                                'color':'#FFF'
                            });
                            $(".sb_footer").css({
                                'margin-top':'0px',
                                'border-top':'0px solid red',
                                'background': '#f0f0f0'
                            });

                            $(".sb_btn").css({
                                'color':'#FFF',
                                'background': '#f54545'
                            });

                            $("#delsalebill_gst").css("display","inline-block");
                        }
                        if(data.ERROR==2)
                        {
                            $("#salebillResponseData").text(data.MSG);
                            $(".sb_body").css({
                                'background':'#ff5050',
                                'color':'#FFF'
                            });
                            $(".sb_footer").css({
                                'margin-top':'0px',
                                'border-top':'0px solid red',
                                'background': '#f0f0f0'
                            });

                            $(".sb_btn").css({
                                'color':'#FFF',
                                'background': '#f54545'
                            });

                            $("#delsalebill_gst").css("display","inline-block");
                        }
                        if(data.ERROR==0)
                        {   


                            $("#salebillResponseData").text(data.MSG);
                            $(".sb_body").css({
                                'background':'#32b088',
                                'color':'#FFF'
                            });
                            $(".sb_footer").css({
                                'margin-top':'0px',
                                'border-top':'0px solid red',
                                'background': '#f0f0f0'
                            });

                            $(".sb_btn").css({
                                'color':'#FFF',
                                'background': '#32b088'
                            });
                            $('#sb_close_btn').attr("onclick", "location.reload()");

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

