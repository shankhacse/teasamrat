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
        
    
    $("#trnsporterdo").click(function(){
                       $("#frmgoodsRcv").submit();
			
		});

});
function updateRecvDo(transDoRecvId,Serial){
       
    // var load = "#loading"+Serial;
        // $(load).show();
        var basepath = $("#basepath").val();
        var jShortageKg ="#txtShortKg"+Serial;
        var shortage = $(jShortageKg).val();
        var jChallan = "#txtChallan"+Serial;
        var challan = $(jChallan).val();
        var jChallanDt = "#challan"+Serial;
        var ChallanDt = $(jChallanDt).val();
        
        var jIsStock = "#chkStock"+Serial;
        if($(jIsStock).prop("checked") == true){
            isStock = 'Y';
            
        }else{
            isStock = 'N';
            $(jShortageKg).val('');
            $(jChallan).val('');
            $(jChallanDt).val('');
        }
	//alert();

    $.ajax({
        url: basepath + "doproductrecv/updateDoReceived",
        type: 'post',
        data: {ShortageKg: shortage,Challan:challan,ChallanDate:ChallanDt,trnsDo:transDoRecvId,IsStk:isStock},
        success: function(data) {
            //called when successful
           // $('#ajaxphp-results').html(data);
         // window.location.href = basepath+'doproductrecv';
        },
        
        complete: function(){
          $( "#dialog-message" ).dialog({
                                    modal: true,
                                    height: 250,
                                    width: 300,
                                    buttons: {
                                    Ok: function() {
                                    $( this ).dialog( "close" );
                                    }
                                    }
                                    });
          
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
}

/*
$(function() {
$( "#dialog-message" ).dialog({
modal: true,
buttons: {
Ok: function() {
$( this ).dialog( "close" );
}
}
});
});*/
