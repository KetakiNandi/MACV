$(document).ready(function() {

var startDate;
var endDate;

date1();

});

function date1(){

var today = new Date();

    $('#reportrange').daterangepicker(
       {
          startDate: '01/01/2017',
          endDate: '12/31/2017',
          autoclose:true,
          minDate: '01/01/2017',
          maxDate: '03/31/2018',
          dateLimit: { days: 365 },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            // 'Today': [moment(), moment()],
             //'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
             //'Last 7 Days': [moment().subtract('days', 6), moment()],
             //'Last 30 Days': [moment().subtract('days', 29), moment()],
             //'This Month': [moment().startOf('month'), moment().endOf('month')],
             //'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'DD/MM/YYYY',
          separator: ' to ',
          locale: {
              applyLabel: 'Submit',
              fromLabel: 'From',
              toLabel: 'To',
              customRangeLabel: 'Custom Range',
              daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
              monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
              firstDay: 1
          }
       },
       function(start, end) {
        //console.log("Callback has been called!");
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
         startDate = start;
         endDate = end;    

       }
    );

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


    //Set the initial state of the picker label
    $('#reportrange span').html(moment().subtract('days', 29).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));

   $('#saveBtn').click(function(){
        
        CategorywisePerformanceQuantity(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,Sstate,scity,SSite,Semp,Scate,prname,CatQtn);
        CategorywisePerformanceQuantityZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,Sstate,scity,SSite,Semp,Scate,prname,CatQtn);

        SubCategorywisePerformanceQuantity(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,emp);
        SubCategorywisePerformanceQuantityZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,emp);


        CustomerDetailsFilled(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,emp);
        CustomerDetailsFilledZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,emp);
	Macv_Zone(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        Macv_State(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_City(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_POSType(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_SourceSite(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_Category(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_Promoname(zone,state,scity,emp,SSite,Scate,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	Macv_EmpId(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));

        if(ClickFlagV=="2")
         {
	    globalStDate1 = startDate;
            globalEndDate1 = endDate;
            SalesPerformanceValue(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	    SalesPerformanceValueZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));}

             $('#SPV1').click(function(){
              if(startDate.length == 0)
                  startDate = globalStDate1 ;

                if(endDate.length == 0)
                  endDate = globalEndDate1 ;

              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
               });

             $('#SPV2').click(function(){
	      if(startDate.length == 0)
                  startDate = globalStDate1 ;

                if(endDate.length == 0)
                  endDate = globalEndDate1 ;

              
              SalesPerformanceValue(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	       SalesPerformanceValueZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              
               });  
         }

         if(ClickFlag=="0")
         {
	    globalStDate = startDate;
	    globalEndDate = endDate; 
            render_avgsession(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		render_avgsessionZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));}
            $('#SPQ1').click(function(){
              if(startDate.length == 0)
		  startDate = globalStDate ;

		if(endDate.length == 0)
		  endDate = globalEndDate ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
               }); 
            $('#SPQ2').click(function(){
              if(startDate.length == 0)
		  startDate = globalStDate ;

		if(endDate.length == 0)
		  endDate = globalEndDate ;
              render_avgsession(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
	      render_avgsessionZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              
               }); 
       }

    });

}
