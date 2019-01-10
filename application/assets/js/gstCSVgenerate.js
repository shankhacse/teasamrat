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
    
	
	$(document).on('click','.generateCSV',function(e){
		e.preventDefault();
		var fdate = $("#fromdate").val();
		var tdate = $("#todate").val();
		var format = $(this).val();
		
		
		if(fdate=="")
		{
			alert("Enter From Date");
			$("#fromdate").focus();
			return false;
		}
		if(tdate=="")
		{
			alert("Enter To Date");
			$("#todate").focus();
			return false;
		}
		
		$("#loader").css("display","block");
			$.ajax({
				type:'POST',
				url: basepath + "gstcsvgenerate/generateCSV",
				dataType: "html",
				data:{format:format,fdate:fdate,tdate:tdate},
				success:function(res)
				{
					$("#loader").css("display","none");
					$("#csv_details").html(res);
					
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
				  //  alert(msg);  
				}
			});
		
	});
	
	
});