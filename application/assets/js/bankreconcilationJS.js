// JS bankreconcilationJS

$(document).ready(function(){
	var basepath = $("#basepath").val();
	var session_strt_date = $('#startyear').val();
	var session_end_date = $('#endyear').val();
	var mindate = '01-04-' + session_strt_date;
	var maxDate = '31-03-' + session_end_date;
	   

	$('.datepicker').datepicker({
	    dateFormat: 'dd-mm-yy',
	    minDate: mindate,
	    maxDate: maxDate
	});



	


	$(document).on("click","#showBankReconsilation",function(){
		if(validateBankReconcilation())
		{
			var bankAccID = $("#bankAccID").val();
			var frmDt = $("#fromDt").val();
			var toDt = $("#toDt").val();


			$("#loaderChq").css("display","block");
			$("#details").css("display","none");
			/*************Ajax**********/
			$.ajax({
				type: "POST",
				url: basepath+'bankreconciliation/getBankReconcilationList',
				dataType: "html",
				data: {bankAccID:bankAccID,frmDt:frmDt,toDt:toDt},
				success: function (result) {
					$("#loaderChq").css("display","none");
					$("#details").css("display","block");
					$("#details").html(result);
				}, 
				error: function (jqXHR, exception) {
				  var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
				   // alert(msg);  
				}
			}); /*end ajax call*/
			/*************Ajax**********/


		}
	});

	$(document).on("keyup",".clearDate",function(){
        var dtID = $(this).attr('id');
      	var IDString = dtID.split('_');

      	var DtDay = 0
      	var month = 0
      	var year = 0

      	var dateVal = $("#"+dtID).val();
      	var datenull = dateVal.replace('dd/mm/yyyy', "");
        var dtStr = dateVal.split('/');
        var days = dtStr[0];
        DtDay = days.replace('m', "");
        month = dtStr[1];
        year = dtStr[2];



		if(DtDay>31 || month>12 || datenull=="")
        {
        	$("#"+dtID).css("background","#ff7a70");
        	$("#"+dtID).attr("title","Invalid Date");
        	$("#clearBtn_"+IDString[1]).css("display","none");
        }
        else
        {
        	$("#"+dtID).css("background","");
        	$("#"+dtID).attr("title","");
        	$("#clearBtn_"+IDString[1]).css("display","");
        }
	});


	$(document).on("click",".clear_chq",function(){
			var accid = $("#bankAccID").val();
			var fadte = $("#fromDt").val();
			var tdate = $("#toDt").val();
		var vmid = $(this).data('vmid');
		var clearDt = $("#clearDate_"+vmid).val();

		$("#chqclerloader_"+vmid).css("display","block"); 
		$("#clearBtn_"+vmid).css({"display":"none"});
		$("#clearBtnEdit_"+vmid).css("display","none"); 
	
		/*************Ajax**********/
			$.ajax({
				type: "POST",
				url: basepath+'bankreconciliation/updateChequeInfo',
				dataType: "json",
				contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
				data: {vmid:vmid,clearDt:clearDt,accid:accid,fadte:fadte,tdate:tdate},
				success: function (result) {
					if(result.msg_status=="1")

					{	$("#chqclerloader_"+vmid).css("display","none"); 
						//$("#clearBtn_"+vmid).html("Edit <span class='glyphicon glyphicon-edit'></span>");
						$("#clearBtn_"+vmid).css({"display":"none"});
						$("#clearBtnEdit_"+vmid).css("display","block"); 
						$("#cancelBtn_"+vmid).css("display","block"); 
						$("#clearDate_"+vmid).attr('readonly',true);
						$("#clearDate_"+vmid).attr('disabled',true);
						$("#opBalance").text(result.opBalance);
						$("#closingBalance").text(result.closingBalance);
						$("#statusicon_"+vmid).html("<span class='glyphicon glyphicon-ok' style='font-size:20px;color:#07B127;'></span>");

					}
				}, 
				error: function (jqXHR, exception) {
				  var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
				   // alert(msg);  
				}
			}); /*end ajax call*/
			/*************Ajax**********/
	});



	// Cancel
	$(document).on("click",".cancel_me",function(){
		var accid = $("#bankAccID").val();
		var fadte = $("#fromDt").val();
		var tdate = $("#toDt").val();
		var vmid = $(this).data('vmid');
		var vdate = $(this).data('vdate');
		
		$("#chqclerloader_"+vmid).css("display","block"); 
		$("#clearBtn_"+vmid).css({"display":"none"});
		$("#clearBtnEdit_"+vmid).css("display","none"); 
	
		/*************Ajax**********/
			$.ajax({
				type: "POST",
				url: basepath+'bankreconciliation/cancelChequeInfo',
				dataType: "json",
				contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
				data: {vmid:vmid,accid:accid,fadte:fadte,tdate:tdate},
				success: function (result) {
					if(result.msg_status=="1")
					{
						$("#chqclerloader_"+vmid).css("display","none"); 
						//$("#clearBtn_"+vmid).html("Edit <span class='glyphicon glyphicon-edit'></span>");
						$("#clearBtn_"+vmid).css({"display":"block","background":"#fc6529"});
						$("#clearBtn_"+vmid).html("Clear Now <span class='glyphicon glyphicon-circle-arrow-right'></span>");
						$("#cancelBtn_"+vmid).css("display","none"); 
						$("#clearDate_"+vmid).removeAttr('readonly disabled');
						$("#clearDate_"+vmid).css('background','');
						$("#opBalance").text(result.opBalance);
						$("#closingBalance").text(result.closingBalance);
						$("#statusicon_"+vmid).html("<span class='glyphicon glyphicon-remove' style='font-size:20px;color:#FC1921;'></span>");
						$("#clearDate_"+vmid).val(vdate);
					}
				}, 
				error: function (jqXHR, exception) {
				  var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
				   // alert(msg);  
				}
			}); /*end ajax call*/
			/*************Ajax**********/
	});	

	
	$(document).on("click",".paginate_button",function(){
		 $(".clearDate").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	});


	$(document).on("click",".edit_chq_clr_btn",function(){
		var vmid = $(this).data('vmidedit');
		var btnmode = $(this).data('btnmode');
			$("#clearDate_"+vmid).removeAttr('readonly disabled');
			$("#clearDate_"+vmid).focus();
			$("#clearDate_"+vmid).css("background","");
			$("#clearBtnEdit_"+vmid).css("display","none"); 
			$("#cancelBtn_"+vmid).css("display","none"); 
			$("#clearBtn_"+vmid).html("Update <span class='glyphicon glyphicon-refresh'></span>");
			$("#clearBtn_"+vmid).css({
								"display":"block",
								"background":"#058dc3",
								"width":"100%"
								});
	});



	/*-------------------------PDF Statement-------------------*/
	
	$("#getpdfbnkstatemnt").click(function(){

		if(validateBankReconcilation())
		{
			 $("#bankRecStatementForm").submit();
		}
        
       
        
    });
    



});


function validateBankReconcilation()
{
	var bankAccID = $("#bankAccID").val();
	var frmDt = $("#fromDt").val();
	var toDt = $("#toDt").val();

	$("#bankAccID,#fromDt,#toDt").removeClass("glowing-border");

	if(bankAccID=="0")
	{
		$("#bankAccID").addClass("glowing-border");
		return false;
	}
	if(frmDt=="")
	{
		$("#fromDt").addClass("glowing-border");
		return false;
	}
	if(toDt=="")
	{
		$("#toDt").addClass("glowing-border");
		return false;
	}
	return true;
}