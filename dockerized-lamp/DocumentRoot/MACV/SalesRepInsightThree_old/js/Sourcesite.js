$( document ).ready(function() {

  	Macv_SourceSite();
  
  });


function Macv_SourceSite(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType){

var msg = document.getElementById("DESTROY").value;
 //console.log(itemcode);
  var state;
  var city;
  var EmpID;
  var Zone;
  var globalSelectedValuesSSite;
  var globalSelectedValuesSSite1;


//var pSsite=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/SouceSite.php");


if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(pSsite+"?param="+msg);
    }
else if((spzone) && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(pSsite+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(pSsite+"?Stateparam="+Sstate);
    }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(pSsite+"?Cityparam="+scity);
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp  && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(pSsite+"?EmpIdparam="+Semp);
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(pSsite+"?Siteparam="+SSite);
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(pSsite+"?categoryparam="+Scate);
  }
  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat  && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(pSsite+"?SubCatparam="+subcat);
  }
  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode  && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined)
  {
    links=(pSsite+"?itemcodeparam="+itemcode);
  }
 else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType  && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined)
  {
    links=(pSsite+"?POSTypeparam="+POSType);
  //console.log(links);
  }
else
  {
    links=(pSsite+"?ProNameparam="+prname);
  }
  


d3.json(links,function(error, data) {


    data.forEach(function(d) { 
    
    d.SourceSite = d.SourceSite;

});

 data.push({
        SourceSite:"All"
      })

d3.select("#MacDPN").html("");

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


var signal = d3.select('#MacDPN');
    //var signalName = ["Please Select", "Temperature", "Pressure", "Load"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('overflow-x', 'scroll')
      .style('height','75px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(data).enter()
      .append('option')
      .text(function(d) {
        return d.SourceSite;
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

    d3.select('#someButton4')
      .on('click', function(d) {
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
          //alert(selectedValues);
              Macv_Zone(Zone,state,city,EmpID,selectedValues);
              Macv_State(Zone,state,city,EmpID,selectedValues);
              Macv_City(Zone,state,city,EmpID,selectedValues);
              Macv_Category(Zone,state,city,EmpID,selectedValues);
              Macv_Promoname(Zone,state,city,EmpID,selectedValues);
              Macv_EmpId(Zone,state,city,EmpID,selectedValues);
	      Macv_POSType(Zone,state,city,EmpID,selectedValues);
              PoSperformance(stDate,endDate,zone,state,city,selectedValues);
              PoSperformanceZoom(stDate,endDate,zone,state,city,selectedValues); 
	     
             
 	if(ClickFlagV=="2")
         {
	   globalSelectedValuesSSite1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,state,city,selectedValues);

	   WeekendMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,state,city,selectedValues);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,state,city,selectedValues);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite1 ;
              WeekendMonth(stDate,endDate,Zone,state,city,selectedValues);
             WeekendMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesSSite = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,state,city,selectedValues);
	WeekDayMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,state,city,selectedValues);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,state,city,selectedValues);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite ;
              WeekDayMonth(stDate,endDate,Zone,state,city,selectedValues);
              WeekDayMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
               }); 
     }
 

      }else
      {
            Macv_Zone(Zone,state,city,EmpID,selectedValues);
            Macv_State(Zone,state,city,EmpID,selectedValues);
            Macv_City(Zone,state,city,EmpID,selectedValues);
            Macv_Category(Zone,state,city,EmpID,selectedValues);
            Macv_Promoname(Zone,state,city,EmpID,selectedValues);
            Macv_EmpId(Zone,state,city,EmpID,selectedValues); 
	    Macv_POSType(Zone,state,city,EmpID,selectedValues);         
            PoSperformance(stDate,endDate,zone,state,city,selectedValues);
            PoSperformanceZoom(stDate,endDate,zone,state,city,selectedValues); 
            WeekDayMonth(stDate,endDate,zone,state,city,selectedValues);
            WeekDayMonthZoom(stDate,endDate,zone,state,city,selectedValues);  
	   

	if(ClickFlagV=="2")
         {
		globalSelectedValuesSSite1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,state,city,selectedValues);

	   WeekendMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,state,city,selectedValues);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,state,city,selectedValues);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite1 ;
              WeekendMonth(stDate,endDate,Zone,state,city,selectedValues);
             WeekendMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesSSite = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,state,city,selectedValues);
	WeekDayMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,state,city,selectedValues);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,state,city,selectedValues);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesSSite ;
              WeekDayMonth(stDate,endDate,Zone,state,city,selectedValues);
              WeekDayMonthZoom(stDate,endDate,Zone,state,city,selectedValues);
               }); 
     }
 

      }
        selectedValues = [];
      
      });

      });

}
