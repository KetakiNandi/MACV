$( document ).ready(function() {

  	Macv_State();
  
  });


function Macv_State(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){

  //console.log(spzone,Sstate,scity,Semp ,Scate);
  var msg = document.getElementById("DESTROY").value;

var links;
var Zone;
var city;
var EmpID;
var globalSelectedValuesState;
var globalSelectedValuesState1;

//var pState=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/State.php");



if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
   {
      links=(pState+"?param="+msg);
   }

else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pState+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
       links=(pState+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
        links=(pState+"?Cityparam="+scity);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=(pState+"?EmpIdparam="+Semp);
    }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
   {
      links=(pState+"?Siteparam="+SSite);
   }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && Scate  && SSite === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(pState+"?categoryparam="+Scate);
   }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && subcat  && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  {
  links=(pState+"?SubCatparam="+subcat);
  }
  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && itemcode  && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  {
  links=(pState+"?itemcodeparam="+itemcode);
  }
   else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && POSType  && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
  {
  links=(pState+"?POSTypeparam="+POSType);
  //console.log("@@@@",links);
  }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && POSType=== undefined  && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
  {
  links=(pState+"?startDate="+startDate+"&endDate="+endDate);
  //console.log("@@@@",links);
  }
else
{
   links=(pState+"?ProNameparam="+prname)
   //console.log("@@@@",links);
}





var startDateParam;
var endDateParam;
  d3.json(links,function(error, json) {

  if(json.dateParam)
  {
    startDateParam = json.dateParam.stDate;
    endDateParam = json.dateParam.endDate;
      var data = json.data;
    data.forEach(function(d) { 
       d.State = d.State;
      
      });
    data.push({
      State:"All"
    })
  }
  else
  {
   startDateParam = "01-Jan-17";
   endDateParam = "31-Dec-17";
  var data=json;
  data.forEach(function(d) { 
       d.State = d.State;
      
      });
    data.push({
      State:"All"
    })
  }
     data.sort(function(a, c) { return c.count - a.count; });

      d3.select("#MacDS").html("");

      function wrap(text, width) {
        text.each(function() {
        var text = d3.select(this),
        words = text.text().split(/\s+/).reverse(),
        word,
        line = [],
        lineNumber = 0, //<-- 0!
        lineHeight = 1.2, // ems
        x = text.attr("x"), //<-- include the x!
        y = text.attr("y"),
        dy = text.attr("dy") ? text.attr("dy") : 0; //<-- null check
        tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");
        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            /*if (tspan.node().getComputedTextLength() > width) {
                line.pop();
                tspan.text(line.join(" "));
                line = [word];
                tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }*/
        }
    });
}

var stDate;
var endDate;
var zone;

var  globalStDate;
    var  globalEndDate;
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
    var globalStDate1;
    var globalEndDate1;



var signal = d3.select('#MacDS');
    //var signalName = ["Please Select", "Temperature", "Pressure", "Load"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('height','75px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(data).enter()
      .append('option')
      .text(function(d) {
        return d.State;
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

    d3.select('#someButton1')
      .on('click', function(d) {
        var v = signalOptions.filter(function(d) {
          if(this.selected)
          {//console.log(this.value);
            selectedValues.push(this.value);
          return this.selected;
        }
        }).data();
        //alert(selectedValues);
        //Macv_State(this.value,state,city,EmpID);
        if(selectedValues=="All"){
          //console.log(selectedValues);
           // location.reload();

        CategorywisePerformanceQuantity(startDateParam,endDateParam,zone,Sstate,scity,SSite,Semp,Scate,prname,CatQtn);
        CategorywisePerformanceQuantityZoom(startDateParam,endDateParam,zone,Sstate,scity,SSite,Semp,Scate,prname,CatQtn);

        SubCategorywisePerformanceQuantity(startDateParam,endDateParam,zone,state,scity,SSite,emp);
        SubCategorywisePerformanceQuantityZoom(startDateParam,endDateParam,zone,state,scity,SSite,emp);
        CustomerDetailsFilled(startDateParam,endDateParam,zone,state,scity,SSite,emp);
        CustomerDetailsFilledZoom(startDateParam,endDateParam,zone,state,scity,SSite,emp);
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
            SalesPerformanceValue(startDateParam,endDateParam);
      SalesPerformanceValueZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(startDateParam,endDateParam);}

             $('#SPV1').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              SalesPerformanceValueQuarter(startDateParam,endDateParam);
               });

             $('#SPV2').click(function(){
        if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;

              
              SalesPerformanceValue(startDateParam,endDateParam);
         SalesPerformanceValueZoom(startDateParam,endDateParam);
              
               });  
         }
         
      if(ClickFlag=="0")
         {
      globalStDate = startDateParam;
      globalEndDate = endDateParam; 
            render_avgsession(startDateParam,endDateParam);
    render_avgsessionZoom(startDateParam,endDateParam);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(startDateParam,endDateParam);}
            $('#SPQ1').click(function(){
              if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;          
              SalesPerformanceQtnQuarter(startDateParam,endDateParam);
               }); 
            $('#SPQ2').click(function(){
              if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              render_avgsession(startDateParam,endDateParam);
        render_avgsessionZoom(startDateParam,endDateParam);
              
               }); 
       }
          }
          else if(selectedValues.indexOf('All')>-1){
               Macv_EmpId(Zone,selectedValues,city,EmpID);
               Macv_City(Zone,selectedValues,city,EmpID);
               Macv_SourceSite(Zone,selectedValues,city,EmpID);
               Macv_Category(Zone,selectedValues,city,EmpID);
               Macv_Promoname(Zone,selectedValues,city,EmpID);
               Macv_POSType(Zone,selectedValues,city,EmpID);
               CategorywisePerformanceQuantity(stDate,endDate,zone,selectedValues);
               SubCategorywisePerformanceQuantity(stDate,endDate,zone,selectedValues);
               CustomerDetailsFilled(stDate,endDate,zone,selectedValues);
	             CategorywisePerformanceQuantityZoom(stDate,endDate,zone,selectedValues);
               SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,selectedValues);
               CustomerDetailsFilledZoom(stDate,endDate,zone,selectedValues);
              
     if(ClickFlagV=="2")
         {
	     globalSelectedValuesState1 = selectedValues;
            SalesPerformanceValue(stDate,endDate,zone,selectedValues);
	     SalesPerformanceValue(stDate,endDate,zone,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,selectedValues);}

             $('#SPV1').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesState1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,selectedValues);
               });

             $('#SPV2').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesState1 ;
              SalesPerformanceValue(stDate,endDate,zone,selectedValues);
               SalesPerformanceValueZoom(stDate,endDate,zone,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
		globalSelectedValuesState = selectedValues;
            render_avgsession(stDate,endDate,zone,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,selectedValues);}
            $('#SPQ1').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesState ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,selectedValues);
               }); 
            $('#SPQ2').click(function(){
            if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesState ;  
              render_avgsession(stDate,endDate,zone,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,selectedValues);
               }); 
       }
          }
          else{

           Macv_EmpId(Zone,selectedValues,city,EmpID);
           Macv_City(Zone,selectedValues,city,EmpID);
          // Macv_Zone(Zone,selectedValues,city,EmpID);
           Macv_SourceSite(Zone,selectedValues,city,EmpID);
           Macv_Category(Zone,selectedValues,city,EmpID);
           Macv_Promoname(Zone,selectedValues,city,EmpID);
           Macv_POSType(Zone,selectedValues,city,EmpID);
          // render_avgSoldPerDay(stDate,endDate,zone,selectedValues);
           CategorywisePerformanceQuantity(stDate,endDate,zone,selectedValues);
           SubCategorywisePerformanceQuantity(stDate,endDate,zone,selectedValues);
           CustomerDetailsFilled(stDate,endDate,zone,selectedValues);
	         CategorywisePerformanceQuantityZoom(stDate,endDate,zone,selectedValues);
               SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,selectedValues);
               CustomerDetailsFilledZoom(stDate,endDate,zone,selectedValues);

          // render_Tachievement(stDate,endDate,zone,selectedValues);
          // SalesPersonWiseContributionQuantity(stDate,endDate,zone,selectedValues);
          // SalesPersonWiseContributionValue(stDate,endDate,zone,selectedValues);
          // PoSperformance(stDate,endDate,zone,selectedValues);
         //  SalesPersonWiseUpsellingQnt(stDate,endDate,zone,selectedValues);

             if(ClickFlagV=="2")
         {
	    globalSelectedValuesState1 = selectedValues;
            SalesPerformanceValue(stDate,endDate,zone,selectedValues);
	   SalesPerformanceValueZoom(stDate,endDate,zone,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,selectedValues);}

             $('#SPV1').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesState1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,selectedValues);
               });

             $('#SPV2').click(function(){
             if(selectedValues.length == 0)
		 selectedValues = globalSelectedValuesState1 ;
              SalesPerformanceValue(stDate,endDate,zone,selectedValues);
               SalesPerformanceValueZoom(stDate,endDate,zone,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
		globalSelectedValuesState = selectedValues;
            render_avgsession(stDate,endDate,zone,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,selectedValues);}
            $('#SPQ1').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesState ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,selectedValues);
               }); 
            $('#SPQ2').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesState ;
              render_avgsession(stDate,endDate,zone,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,selectedValues);
               }); 
       }

          }
        selectedValues = [];
      });
 
});

}
