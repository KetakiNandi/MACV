$( document ).ready(function() {

  	Macv_Zone();
  
  });


function Macv_Zone(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){

  //console.log(spzone,Sstate,scity,Semp);

	  var msg = document.getElementById("DESTROY").value;

  var zoneArray=[];

  var state;
  var city;
  var EmpID;

  //var All='';

//d3.json("http://localhost/MACV/SalesRepInsight/data/Zone.php",function(data){

   var links;

//var pZone=encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/Zone.php");


if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined) {

    links=(pZone+"?param="+msg);

      }
else if((spzone) && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pZone+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {

    links=(pZone+"?Stateparam="+Sstate);

    //console.log("sssssssss",links);
      
  }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  {

    links=(pZone+"?Cityparam="+scity);

    //console.log("city",links)
}

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp  && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{

  links=(pZone+"?EmpIdparam="+Semp);

  //console.log("ddddd",links);

}

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
  links=(pZone+"?Siteparam="+SSite);

}

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
links=(pZone+"?categoryparam="+Scate);

//console.log("ddddd",links);
}
 else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
links=(pZone+"?SubCatparam="+subcat);

//console.log("ddddd",links);
} 
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
links=(pZone+"?itemcodeparam="+itemcode);

//console.log("ddddd",links);
} 
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
{
links=(pZone+"?POSTypeparam="+POSType);

//console.log("ddddd",links);
} 
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType=== undefined && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
{
links=(pZone+"?startDate="+startDate+"&endDate="+endDate);

//console.log("ddddd",links);
} 
  else
  {
    links=(pZone+"?ProNameparam="+prname);

   // console.log("ddddd",links);
    
    }


  d3.json(links,function(error, data) {
  
  data.forEach(function(d) { 
     d.Zone = d.Zone;
    
    });
  data.push({
    Zone:"All"
  })

   // console.log(JSON.stringify(data));

data.sort(function(a, c) { return c.count - a.count; });

d3.select("#MacDZ").html("");

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
               // tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }*/
        }
    });
}

//console.log("233",ClickFlag);
var stDate;
var endDate;

 var signal = d3.select('#MacDZ');
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
        return d.Zone;
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

    d3.select('#someButton')
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
        Macv_State(selectedValues,state,city,EmpID);
        Macv_City(selectedValues,state,city,EmpID);        
        Macv_SourceSite(selectedValues,state,city,EmpID);
        Macv_Category(selectedValues,state,city,EmpID);        
	Macv_POSType(selectedValues,state,city,EmpID);
        KIOSK(stDate,endDate,selectedValues);
        SalesPerformanceQtnCompared(stDate,endDate,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,selectedValues);
	 SalesPerformanceQtnComparedZoom(stDate,endDate,selectedValues);
        SalesPerformanceValueComparedZoom(stDate,endDate,selectedValues);
      }else
      {
        Macv_State(selectedValues,state,city,EmpID);
        Macv_City(selectedValues,state,city,EmpID);        
        Macv_SourceSite(selectedValues,state,city,EmpID);
        Macv_Category(selectedValues,state,city,EmpID);       
	Macv_POSType(selectedValues,state,city,EmpID);
        KIOSK(stDate,endDate,selectedValues); 
        SalesPerformanceQtnCompared(stDate,endDate,selectedValues);
	SalesPerformanceValueCompared(stDate,endDate,selectedValues);
	 SalesPerformanceQtnComparedZoom(stDate,endDate,selectedValues);
        SalesPerformanceValueComparedZoom(stDate,endDate,selectedValues);
           
      }
        selectedValues = [];
      
      });
    });

}
