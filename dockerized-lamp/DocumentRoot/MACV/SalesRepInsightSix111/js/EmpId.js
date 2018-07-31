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


 //var pEmpId=encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/empID.php");

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


d3.json(links,function(error, json) {
var sessionFlag=0;
	if(json.dateParam)
	 {
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
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'148px')
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
          //console.log(selectedValues);
            location.reload();
          }
          else if(selectedValues.indexOf('All')>-1){
  	  if(sessionFlag==1)
 	 {
	  Macv_SourceSite(Zone,state,city,selectedValues);
	  Macv_Category(Zone,state,city,selectedValues);
	  Macv_Promoname(Zone,state,city,selectedValues);
	  Macv_POSType(Zone,state,city,selectedValues);
	WeekendDayCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekendComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	Macv_WeekDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	
	}
	else
	{
	  Macv_Zone(Zone,state,city,selectedValues);
	  Macv_State(Zone,state,city,selectedValues);
	  Macv_City(Zone,state,city,selectedValues);
	  Macv_SourceSite(Zone,state,city,selectedValues);
	  Macv_Category(Zone,state,city,selectedValues);
	  Macv_Promoname(Zone,state,city,selectedValues);
	  Macv_POSType(Zone,state,city,selectedValues);
	  
	WeekendDayCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekendComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	Macv_WeekDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	}

    }
    else{
	  if(sessionFlag==1)
 	 {
	  Macv_SourceSite(Zone,state,city,selectedValues);
	  Macv_Category(Zone,state,city,selectedValues);
	  Macv_Promoname(Zone,state,city,selectedValues);
	  Macv_POSType(Zone,state,city,selectedValues);
	WeekendDayCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekendComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	Macv_WeekDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	 
	}
	else
	{
	  Macv_Zone(Zone,state,city,selectedValues);
	  Macv_State(Zone,state,city,selectedValues);
	  Macv_City(Zone,state,city,selectedValues);
	  Macv_SourceSite(Zone,state,city,selectedValues);
	  Macv_Category(Zone,state,city,selectedValues);
	  Macv_Promoname(Zone,state,city,selectedValues);
	  Macv_POSType(Zone,state,city,selectedValues);
	  
	WeekendDayCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekendComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	WeekComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	Macv_WeekDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,catgory,selectedValues);
	 

   	}
     }
 selectedValues = [];
	
   });
    
 });

}
