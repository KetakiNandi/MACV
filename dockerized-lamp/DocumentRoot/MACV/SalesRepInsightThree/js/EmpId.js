$( document ).ready(function() {

  	Macv_EmpId();
  
  });


function Macv_EmpId(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){

// d3.json("http://localhost/MACV/SalesRepInsight/data/empID.php", function(data) {

var msg = document.getElementById("DESTROY").value;
var links;

var Zone;
var city;
var EmpID;
var Division;
var state;
var SourceSite;
var globalSelectedValuesEmp;
var globalSelectedValuesEmp1;

// var pEmpId=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/empID.php");

if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  
  {

    links=(pEmpId+"?param="+msg);


    }

 else if((spzone)&& Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {

       links=(pEmpId+"?zoneparam="+spzone);

    }

else if(spzone === undefined && Sstate  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
       links=(pEmpId+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity   && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  {
  links=(pEmpId+"?Cityparam="+scity);

  }

  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)

  {

    links=(pEmpId+"?EmpIdparam="+Semp);
    //console.log(links)
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)

{

  links=(pEmpId+"?Siteparam="+SSite);

  //console.log(links)

}

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{

  links=(pEmpId+"?categoryparam="+Scate);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{

  links=(pEmpId+"?SubCatparam="+subcat);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{

  links=(pEmpId+"?itemcodeparam="+itemcode);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
{

  links=(pEmpId+"?POSTypeparam="+POSType);
 // console.log(links);

}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType=== undefined && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
{

  links=(pEmpId+"?startDate="+startDate+"&endDate="+endDate);
 // console.log(links);

}
else
{

links=(pEmpId+"?ProNameparam="+prname);
//console.log(links);

}

var startDateParam;
  var endDateParam;


d3.json(links,function(error, json) {
var sessionFlag=0;
	if(json.dateParam)
	 {
	 	 startDateParam = json.dateParam.stDate;
    endDateParam = json.dateParam.endDate;

		sessionFlag=1;
		var data = json.data;

		data.forEach(function(d) { 

		        d.EmpID = d.EmpID;
		        d.EmpName =d.EmpName;

		      });
		data.push({
       		 EmpName:"All"
      		})
	  }
	  else
	  {
	  	startDateParam = "01-Jan-17";
   endDateParam = "31-Dec-17";
	       var data=json;
		data.forEach(function(d) { 

		        d.EmpID = d.EmpID;
		        d.EmpName =d.EmpName;

		      });
	        data.push({
       		 EmpName:"All"
      		})
	
          }



data.sort(function(a, b){
    if(a.EmpName < b.EmpName) return -1;
    if(a.EmpName > b.EmpName) return 1;
    return 0;
});

var stDate;
var endDate;
var zone;
var promo;
var SourceSite;
var catgory;

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
    var END;
    var Start1;

d3.select("#MacDEid").html("");

var signal = d3.select('#MacDEid');
    //var signalName = ["Please Select", "Temperature", "Pressure", "Load"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('height','220px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(data).enter()
      .append('option').attr("value", function(d){return d.EmpID;})
      .text(function(d) {
        return d.EmpName;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'185px')
      .on('click', function(d) {
        var s = signalOptions.filter(function(d) {
          // console.log(d);
          // console.log(s);
          // console.log(this.selected);
          return this.selected;
        });
        // if (s.nodes().length >= 2) {
        //   signalOptions.filter(function() {
        //       return !this.selected
        //     })
        //     .property('disabled', true);
        // } else {
        //   signalOptions.property('disabled', false);
        // }
      });

    d3.select('#someButton7').on("click", function(d){
    var v = signalOptions.filter(function(d) {
          if(this.selected)
          {//console.log(this.value);
            selectedValues.push(this.value);
          return this.selected;
        }
        }).data();
        if(selectedValues=="All"){
          //console.log(startDateParam,endDateParam);
            //location.reload();
          PoSperformance(startDateParam,endDateParam);
    PoSperformanceZoom(startDateParam,endDateParam);
    Macv_Zone(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_State(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_City(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_POSType(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,startDateParam,endDateParam);
    Macv_SourceSite(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_Category(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_Promoname(zone,state,scity,emp,SSite,Scate,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_EmpId(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
      
  if(ClickFlagV=="2")
         {
      globalStDate1 = startDateParam;
            globalEndDate1 = endDateParam;
            WeekendMonth(startDateParam,endDateParam);

     WeekendMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(startDateParam,endDateParam);}

             $('#SPV1').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              //console.log("WWWW",startDateParam,endDateParam);
             WeekendQuarter(startDateParam,endDateParam);
               });

             $('#SPV2').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              WeekendMonth(startDateParam,endDateParam);
             WeekendMonthZoom(startDateParam,endDateParam);
               });  
         }

       if(ClickFlag=="0")
       {
    globalStDate1 = startDateParam;
            globalEndDate1 = endDateParam;
          WeekDayMonth(startDateParam,endDateParam);
  WeekDayMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(startDateParam,endDateParam);}
            $('#SPV3').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              //console.log("WWWW",startDateParam,endDateParam);
              WeekDayQuarter(startDateParam,endDateParam);
               }); 
            $('#SPV4').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              WeekDayMonth(startDateParam,endDateParam);
              WeekDayMonthZoom(startDateParam,endDateParam);
               }); 
     }
          
    }
          else if(selectedValues.indexOf('All')>-1){
   	  if(sessionFlag==1)
  	  {
		  Macv_SourceSite(Zone,state,city,selectedValues);
		  Macv_Category(Zone,state,city,selectedValues);
		  Macv_Promoname(Zone,state,city,selectedValues);
		  Macv_POSType(Zone,state,city,selectedValues);
		  PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		  PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		  
		  if(ClickFlagV=="2")
		 {
		    globalSelectedValuesEmp1 = selectedValues;
		    WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);

		   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV1').disabled)

		    {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}

		     $('#SPV1').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		     WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });

		     $('#SPV2').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		     WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });  
		 }

	       if(ClickFlag=="0")
	       {
		  globalSelectedValuesEmp = selectedValues;
		  WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV3').disabled)

		    {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}
		    $('#SPV3').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		      WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
		    $('#SPV4').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		      WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
	         }
	       }
		else{
		
		   Macv_Zone(Zone,state,city,selectedValues);
		  Macv_State(Zone,state,city,selectedValues);
		  Macv_City(Zone,state,city,selectedValues);
		  Macv_SourceSite(Zone,state,city,selectedValues);
		  Macv_Category(Zone,state,city,selectedValues);
		  Macv_Promoname(Zone,state,city,selectedValues);
		  Macv_POSType(Zone,state,city,selectedValues);		  
		  PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		  PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		 
			if(ClickFlagV=="2")
			 {
				globalSelectedValuesEmp1 = selectedValues;
			    WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);

			   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			    if(document.getElementById('SPV1').disabled)

			    {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}

			     $('#SPV1').click(function(){
			      if(selectedValues.length == 0)
				selectedValues = globalSelectedValuesEmp1 ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			     WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			       });

			     $('#SPV2').click(function(){
			      if(selectedValues.length == 0)
				selectedValues = globalSelectedValuesEmp1 ;
			      WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			     WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			       });  
			 }

		       if(ClickFlag=="0")
		       {
			  globalSelectedValuesEmp = selectedValues;
			  WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			    if(document.getElementById('SPV3').disabled)

			    {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}
			    $('#SPV3').click(function(){
			      if(selectedValues.length == 0)
				selectedValues = globalSelectedValuesEmp ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			       }); 
			    $('#SPV4').click(function(){
			      if(selectedValues.length == 0)
				selectedValues = globalSelectedValuesEmp ;
			      WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			      WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
			       }); 
		     }

		}
		}
		else
   		 {
		  
		   if(sessionFlag==1)
  	  	{
		  Macv_SourceSite(Zone,state,city,selectedValues);
		  Macv_Category(Zone,state,city,selectedValues);
		  Macv_Promoname(Zone,state,city,selectedValues);
		  Macv_POSType(Zone,state,city,selectedValues);
		  PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		  PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		 
		  if(ClickFlagV=="2")
		 {
		    globalSelectedValuesEmp1 = selectedValues;
		    WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);

		   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV1').disabled)

		    {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}

		     $('#SPV1').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		     WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });

		     $('#SPV2').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		     WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });  
		 }

	       if(ClickFlag=="0")
	       {
		  globalSelectedValuesEmp = selectedValues;
		  WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV3').disabled)

		    {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}
		    $('#SPV3').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		      WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
		    $('#SPV4').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		      WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
	         }
	       }
		else{

		  Macv_Zone(Zone,state,city,selectedValues);
		  Macv_State(Zone,state,city,selectedValues);
		  Macv_City(Zone,state,city,selectedValues);
		  Macv_SourceSite(Zone,state,city,selectedValues);
		  Macv_Category(Zone,state,city,selectedValues);
		  Macv_Promoname(Zone,state,city,selectedValues);
		  Macv_POSType(Zone,state,city,selectedValues);		  
		  PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		  PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
		 

		if(ClickFlagV=="2")
		 {
			globalSelectedValuesEmp1 = selectedValues;
		    WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);

		   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV1').disabled)

		    {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}

		     $('#SPV1').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		     WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });

		     $('#SPV2').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp1 ;
		      WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		     WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       });  
		 }

	       if(ClickFlag=="0")
	       {
		  globalSelectedValuesEmp = selectedValues;
		  WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		    if(document.getElementById('SPV3').disabled)

		    {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);}
		    $('#SPV3').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
		      WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
		    $('#SPV4').click(function(){
		      if(selectedValues.length == 0)
			selectedValues = globalSelectedValuesEmp ;
		      WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		      WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,promo,catgory,selectedValues);
		       }); 
	    	 }

    		}
	   }
  selectedValues = [];
   });
    
 });

}