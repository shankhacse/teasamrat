$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".stockwithtransporter").addClass( " active " );
});

$(function(){
    var basepath =  $("#basepath").val();
     var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 var mindate = '01-04-'+session_strt_date;
	 var maxDate = '31-03-'+session_end_date ;
	 
	 var currentDate = new Date();
         var dtPickerClassId = '';
         
         
 $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
    

/*$('#doRcvTable').dataTable({
"fnDrawCallback":function(){ $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
});
});   */
        
  /*
   * @date 19-01-2016
   * @author Mithilesh
   */
    
    $("#trnsporter").click(function(){
        var basepath =  $("#basepath").val();
        var transporterid = $("#transporterid option:selected").val();
        var warehouseid = $("#warehouseid option:selected").val();
        var fdate = $("#fdate").val();
        var tdate = $("#tdate").val();
        
        if(transporterid=="0"){
            alert("Select Transporter Name");
            return false;
        }
        if(fdate!="" && tdate=="")
        {
          alert("Select To Date");
            return false;
        }
        if(fdate=="" && tdate!="")
        {
          alert("Select From Date");
            return false;
        }
          
        else{
           // alert(transporterid);
        
        console.log(transporterid);
        
         $("#details").css("display", "block"); 
          $("#loader").show();
        $.ajax({
            type: "POST",
            url: basepath + "stockwithtransporter/liststockwithtransporter",
            data: {transporterid:transporterid,warehouseid:warehouseid,fdate:fdate,tdate:tdate},
            dataType: 'html',
            success: function(data) {
                $('#details').html(data);
             
            },
          complete:function(){
                 $("#loader").hide();
                        
            },
            error: function(e) {
               console.log(e.message);
            }

        });
    }
    });
    
    /*
     * @date 19-01-2016
     * @author Mithilesh
     */
    
      $("#gstRegisterPDF").click(function(){
        var fdate = $("#fdate").val();
        var tdate = $("#tdate").val();

            $("#fdate,#tdate").removeClass("glowing-border");
            if(fdate=="")
            {
                $("#fdate").addClass("glowing-border");
                return false;
            }
            if(tdate=="")
            {
                $("#tdate").addClass("glowing-border");
                return false;
            }
            $("#frmGstRegister").submit();
    
         });
         
         
    /*
     * @date 10.01.2019
     * @author shankha
     */
    
      $("#gstRegisteroutputPDF").click(function(){
        var fdate = $("#fdate").val();
        var tdate = $("#tdate").val();

            $("#fdate,#tdate").removeClass("glowing-border");
            if(fdate=="")
            {
                $("#fdate").addClass("glowing-border");
                return false;
            }
            if(tdate=="")
            {
                $("#tdate").addClass("glowing-border");
                return false;
            }
            $("#frmGstRegisteroutput").submit();
    
         });
    
    
    });

