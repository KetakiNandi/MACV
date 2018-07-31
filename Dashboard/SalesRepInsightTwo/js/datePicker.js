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
          endDate: '01/01/2017',
          autoclose:true,
          minDate: '01/01/2017',
          maxDate: '12/31/2017',
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

    //Set the initial state of the picker label
    $('#reportrange span').html(moment().subtract('days', 29).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));

   $('#saveBtn').click(function(){
       
        render_avgSoldPerDay(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        render_avgSoldPerDayZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));

        
        render_Tachievement(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,spImp);
        render_TachievementZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'),zone,state,scity,SSite,spImp);

        SalesPersonWiseContributionQuantity(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        SalesPersonWiseContributionQuantityZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        SalesPersonWiseContributionValue(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));

       SalesPersonWiseContributionValueZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
       // PoSperformance(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        SalesPersonWiseUpsellingQnt(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
         SalesPersonWiseUpsellingQntZoom(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        Macv_Zone(zone,state,scity,spImp,SSite,Scate,prname,subcat,itemcode,POSType,startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));

        //});

    });

}
