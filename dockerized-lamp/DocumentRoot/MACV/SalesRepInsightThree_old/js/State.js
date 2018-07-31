$( document ).ready(function() {

  	Macv_State();
  
  });


function Macv_State(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType){

  //console.log(spzone,Sstate,scity,Semp ,Scate);
	var msg = document.getElementById("DESTROY").value;

var links;
var Zone;
var city;
var EmpID;
var globalSelectedValuesState;
var globalSelectedValuesState1;


//var pState=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/State.php");

if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(pState+"?param="+msg);
   }

else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(pState+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
       links=(pState+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=(pState+"?Cityparam="+scity);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=(pState+"?EmpIdparam="+Semp);
    }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(pState+"?Siteparam="+SSite);
   }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && Scate  && SSite === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(pState+"?categoryparam="+Scate);
   }
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && subcat  && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(pState+"?SubCatparam="+subcat);
  }
  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && itemcode  && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined)
  {
  links=(pState+"?itemcodeparam="+itemcode);
  }
   else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && POSType  && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined)
  {
  links=(pState+"?POSTypeparam="+POSType);
  //console.log("@@@@",links);
  }
else
{
   links=(pState+"?ProNameparam="+prname)
   //console.log("@@@@",links);
}



d3.json(links,function(error, data) {

 data.forEach(function(d) { 
    
    d.State = d.State;

});

data.push({
    State:"All"
  })
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
            location.reload();
          }
          else if(selectedValues.indexOf('All')>-1){
               Macv_EmpId(Zone,selectedValues,city,EmpID);
               Macv_City(Zone,selectedValues,city,EmpID);
               Macv_Zone(Zone,selectedValues,city,EmpID);
               Macv_SourceSite(Zone,selectedValues,city,EmpID);
               Macv_Category(Zone,selectedValues,city,EmpID);
               Macv_Promoname(Zone,selectedValues,city,EmpID);
	       Macv_POSType(Zone,selectedValues,city,EmpID);
               PoSperformance(stDate,endDate,zone,selectedValues);
               PoSperformanceZoom(stDate,endDate,zone,selectedValues);
               WeekDayMonth(stDate,endDate,zone,selectedValues);
               WeekDayMonthZoom(stDate,endDate,zone,selectedValues);
	       
	 if(ClickFlagV=="2")
         {
	    globalSelectedValuesState1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,selectedValues,city);

	        WeekendMonthZoom(stDate,endDate,Zone,selectedValues,city);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,selectedValues,city);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,selectedValues,city);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState1 ;
              WeekendMonth(stDate,endDate,Zone,selectedValues,city);
             WeekendMonthZoom(stDate,endDate,Zone,selectedValues,city);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesState = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,selectedValues,city);
	WeekDayMonthZoom(stDate,endDate,Zone,selectedValues,city);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,selectedValues,city);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,selectedValues,city);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState ;
              WeekDayMonth(stDate,endDate,Zone,selectedValues,city);
              WeekDayMonthZoom(stDate,endDate,Zone,selectedValues,city);
               }); 
     }
	


          }
          else{

           Macv_EmpId(Zone,selectedValues,city,EmpID);
           Macv_City(Zone,selectedValues,city,EmpID);
           Macv_Zone(Zone,selectedValues,city,EmpID);
           Macv_SourceSite(Zone,selectedValues,city,EmpID);
           Macv_Category(Zone,selectedValues,city,EmpID);
           Macv_Promoname(Zone,selectedValues,city,EmpID);
	   Macv_POSType(Zone,selectedValues,city,EmpID);
           PoSperformance(stDate,endDate,zone,selectedValues);
           PoSperformanceZoom(stDate,endDate,zone,selectedValues);

           WeekDayMonth(stDate,endDate,zone,selectedValues);
           WeekDayMonthZoom(stDate,endDate,zone,selectedValues);
	   
	 if(ClickFlagV=="2")
         {
	    globalSelectedValuesState1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,selectedValues,city);

	   WeekendMonthZoom(stDate,endDate,Zone,selectedValues,city);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,selectedValues,city);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,selectedValues,city);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState1 ;
              WeekendMonth(stDate,endDate,Zone,selectedValues,city);
             WeekendMonthZoom(stDate,endDate,Zone,selectedValues,city);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesState = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,selectedValues,city);
	WeekDayMonthZoom(stDate,endDate,Zone,selectedValues,city);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,selectedValues,city);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,selectedValues,city);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesState ;
              WeekDayMonth(stDate,endDate,Zone,selectedValues,city);
              WeekDayMonthZoom(stDate,endDate,Zone,selectedValues,city);
               }); 
     }



          }
        selectedValues = [];
      });
 
});

}
