$(document).ready(function() {

var startDate;
var endDate;

date1();

});

function date1(){

    var zone;
    var Sstate;
    var scity;
    var Semp;
    var SSite;
    var Scate;
    var prname;
    var CatQtn;
    var subcat;
    var emp;
    var state;
    var itemcode;
    var spImp;
    var POSType;
    var globalStDate;
    var globalEndDate;
    var globalStDate1;
    var globalEndDate1;
    var END;
    var Start1;

    // set default dates
	var start = new Date(new Date().setYear("01/01/2017"));
	// set end date to max one year period:
	var end = new Date(new Date().setYear(start.getFullYear()+1));

	$('#fromDate').datepicker({
	    dateFormat: 'mm/dd/yyyy',
	    startDate : '01-01-2017',
	    endDate   : '03-31-2018',
	    autoclose: true
	}).on('changeDate', function(){
	    END = $('#toDate').datepicker('setStartDate', new Date($(this).val()));
	}); 

	$('#toDate').datepicker({
	    format: 'mm/dd/yyyy',
	    startDate : '01-01-2017',
	    endDate   : '03-31-2018',
	    autoclose: true
	}).on('changeDate', function(){
	     Start1 = $('#fromDate').datepicker('setEndDate', new Date($(this).val()));
	});

	function formatDate(date) {
	  var monthNames = [
	    "Jan", "Feb", "Mar",
	    "Apr", "May", "Jun", "Jul",
	    "Aug", "Sep", "Oct",
	    "Nov", "Dec"
	  ];

	  var day = date.getDate();
	  var monthIndex = date.getMonth();
	  var year = date.getFullYear();
	  var yeartwodigit = year.toString();

	  return day + '-' + monthNames[monthIndex] + '-' + yeartwodigit.substring(2, 4);
	}


   $('#saveBtn').click(function(){
              
        PoSperformance(formatDate(Start1.getDate()),formatDate(END.getDate()));
        PoSperformanceZoom(formatDate(Start1.getDate()),formatDate(END.getDate()));
        Macv_Zone(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
        Macv_State(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_City(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_POSType(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_SourceSite(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_Category(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_Promoname(zone,state,scity,emp,SSite,Scate,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
	Macv_EmpId(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,formatDate(Start1.getDate()),formatDate(END.getDate()));
      
	if(ClickFlagV=="2")
         {
	    globalStDate1 = formatDate(Start1.getDate());
            globalEndDate1 = formatDate(END.getDate());
            WeekendMonth(formatDate(Start1.getDate()),formatDate(END.getDate()));

	   WeekendMonthZoom(formatDate(Start1.getDate()),formatDate(END.getDate()));
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(formatDate(Start1.getDate()),formatDate(END.getDate()));}

             $('#SPV1').click(function(){
              if(formatDate(Start1.getDate()).length == 0)
                  formatDate(Start1.getDate()) = globalStDate1 ;

                if(formatDate(END.getDate()).length == 0)
                  formatDate(END.getDate()) = globalEndDate1 ;
              //console.log("WWWW",formatDate(Start1.getDate()),formatDate(END.getDate()));
             WeekendQuarter(formatDate(Start1.getDate()),formatDate(END.getDate()));
               });

             $('#SPV2').click(function(){
              if(formatDate(Start1.getDate()).length == 0)
                  formatDate(Start1.getDate()) = globalStDate1 ;

                if(formatDate(END.getDate()).length == 0)
                  formatDate(END.getDate()) = globalEndDate1 ;
              WeekendMonth(formatDate(Start1.getDate()),formatDate(END.getDate()));
             WeekendMonthZoom(formatDate(Start1.getDate()),formatDate(END.getDate()));
               });  
         }

       if(ClickFlag=="0")
       {
	  globalStDate1 = formatDate(Start1.getDate());
            globalEndDate1 = formatDate(END.getDate());
          WeekDayMonth(formatDate(Start1.getDate()),formatDate(END.getDate()));
	WeekDayMonthZoom(formatDate(Start1.getDate()),formatDate(END.getDate()));
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(formatDate(Start1.getDate()),formatDate(END.getDate()));}
            $('#SPV3').click(function(){
               if(formatDate(Start1.getDate()).length == 0)
		  formatDate(Start1.getDate()) = globalStDate ;

		if(formatDate(END.getDate()).length == 0)
		  formatDate(END.getDate()) = globalEndDate ;
              //console.log("WWWW",formatDate(Start1.getDate()),formatDate(END.getDate()));
              WeekDayQuarter(formatDate(Start1.getDate()),formatDate(END.getDate()));
               }); 
            $('#SPV4').click(function(){
               if(formatDate(Start1.getDate()).length == 0)
		  formatDate(Start1.getDate()) = globalStDate ;

		if(formatDate(END.getDate()).length == 0)
		  formatDate(END.getDate()) = globalEndDate ;
              WeekDayMonth(formatDate(Start1.getDate()),formatDate(END.getDate()));
              WeekDayMonthZoom(formatDate(Start1.getDate()),formatDate(END.getDate()));
               }); 
     }

    });

}
