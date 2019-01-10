$(document).ready(function() {

    var basepath =  $("#basepath").val();
    
	var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
	var mindate = '01-04-'+session_strt_date;
	var maxDate = '31-03-'+session_end_date ;
	 
	 var currentDate = new Date();
     var dtPickerClassId = '';
         
         
         $('.datepicker').each(function(){
                $(this).datepicker({
								dateFormat: 'dd-mm-yy', 
								minDate: mindate,
								maxDate: maxDate
					});
			});
      $("#showdo").click(function(){
                       $("#frmunrealeased").submit();
			
		});

});
function updateDoReleased(pdtlId,Serial){
    var basepath = $("#basepath").val();
	var pdtlIds = pdtlId;
	var serialId = Serial;
	var jdo_no= "#txt_do"+serialId;
	var deliveryorder =$(jdo_no).val();
	var jdo_date = "#do_reli_date"+serialId;
	var do_date = $(jdo_date).val();
	
	//alert();

    $.ajax({
        url: basepath + "unreleaseddo/updateDo",
        type: 'post',
        data: {donumber: deliveryorder, doDate:do_date,purchaseDetailsId:pdtlIds},
        success: function(data) {
            //called when successful
           // $('#ajaxphp-results').html(data);
           window.location.href = basepath+'unreleaseddo';
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
}
