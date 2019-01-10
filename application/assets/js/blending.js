/**
*@add blending [addBlendingJS.js]
*@08/09/2015 
*/
$(document).ready(function(){
    
 $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".blending").addClass( " active " );   
  var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    
 $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });   
    
 var basepath = $("#basepath").val();           
 $(".viewBlend").click(function(){
        var blendId=$(this).attr('id');
        var DtlId = blendId.split('_');
        var bl_id =DtlId[1]; 
        
         $.ajax(
                 {
                            type: 'POST',
                            dataType : 'html',
                            url: basepath + "blending/detailView",
                            data: {blendId:bl_id},
                            success: function(data) {
                                $("#dtlRslt").html(data);
                                
                                 $("#blend-Detail").dialog({
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
        
 });
 
 
  $('#exampleTable').dataTable( {
        "aoColumns": [
            null,
            { "sType": "date-uk" },
            null,
            null,
            null
        ]
    });
 
 

   
     $(document).on("click","#print_blending_register",function() {     
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
     // alert("test");
         if(startdate==""){
           $('#startdate').addClass("glowing-border");
           $('#enddate').removeClass("glowing-border");
            return false;
        }
         if(enddate==""){
          $('#enddate').addClass("glowing-border");
          $('#startdate').removeClass("glowing-border");
            return false;
        }
        else{
       $("#frmblendingReg").submit();
        }
       
     
    });
 
});



// For Date Sorting
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-uk-pre": function ( a ) {
    var ukDatea = a.split('-');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
},

"date-uk-asc": function ( a, b ) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-uk-desc": function ( a, b ) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );







// document load

