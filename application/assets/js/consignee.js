$(document).ready(function(){

     

	var basepath = $("#basepath").val();
$(".custom-select").customselect(); 
$(document).on('click','#SaveBtnConsignee',function(e){
	
			e.preventDefault();
			var formData = $("#ConsigneeForm" ).serialize();
			formData = decodeURI(formData);
			console.log(formData);
			
		if(validation()){	
			
			$("#saveMsgModal").hide();
		$.ajax({
				type: "POST",
				url: basepath+'consignee/saveConsignee',
				dataType: "json",
				contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
				data: {formDatas:formData},
				success: function (result) {
					if(result.msg_status==1)
					{
						
					
						alert(result.msg_data);
						$("#ConsigneeForm")[0].reset();
						window.location.href=basepath+'consignee';
						//location.reload();
						
					}
					if(result.msg_status==0)
					{
						

							alert(result.msg_data);
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
		}
		
	});


	});



function validation()
{
	var consignee_name = $("#consignee_name").val();
	var state = $("#state").val();
	var customer = $("#customer").val();

	
	var error = "";
	$(".course-validation-err").text(error);
	
	$("#consignee_name,#state,#customer").removeClass("error-border");
	
	if(consignee_name=="")
	{ 
		
		$("#consignee_name").addClass('error-border');
		return false;
	}
	if(state=="0")
	{ 
		
		$("#state").addClass('error-border');
		return false;
	}
	if(customer=="0")
	{ 
		
		$("#customer").addClass('error-border');
		return false;
	}

	
	
	return true;
}