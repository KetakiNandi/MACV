$( document ).ready(function() {

  	Macv_City();
  
  });


function Macv_City(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){

  //console.log(spzone);

  var msg = document.getElementById("DESTROY").value;

//d3.json("http://localhost/MACV/SalesRepInsight/data/city.php",function(data){

  var links;
  var Zone;
  var state;
  var EmpID;

//var pCity=encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/city.php");


if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
        links=(pCity+"?param="+msg);
    }
else if((spzone) && Sstate === undefined  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?zoneparam="+spzone);
      //console.log(links);
    }

else if(spzone === undefined && Sstate && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
        links=(pCity+"?Stateparam="+Sstate);
    }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
       links=(pCity+"?Cityparam="+scity);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp  && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
        links=(pCity+"?EmpIdparam="+Semp);
    }

else if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?Siteparam="+SSite);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?categoryparam="+Scate);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?SubCatparam="+subcat);
    }
    else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?itemcodeparam="+itemcode);
    }
    else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
      links=(pCity+"?POSTypeparam="+POSType);
      //console.log(links);
    }
    else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && POSType=== undefined && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
    {
      links=(pCity+"?startDate="+startDate+"&endDate="+endDate);
      //console.log(links);
    }
else
  {
    links=(pCity+"?ProNameparam="+prname)
  }


d3.json(links,function(error, data) {


      data.forEach(function(d) { 
    
            d.CIty = d.CIty;
      });

 data.push({
        CIty:"All"
      })

//data.sort(function(a, c) { return c.count - a.count; });


d3.select("#MacDC").html("");

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

var signal = d3.select('#MacDC');
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
        return d.CIty;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'150px')
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

    d3.select('#someButton2')
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
        
           Macv_State(Zone,state,selectedValues,EmpID);
           Macv_Zone(Zone,state,selectedValues,EmpID);
           Macv_SourceSite(Zone,state,selectedValues,EmpID);
           Macv_Category(Zone,state,selectedValues,EmpID);
           KIOSK(stDate,endDate,zone,state,selectedValues);          
	   SalesPerformanceQtnCompared(stDate,endDate,zone,state,selectedValues);
	   SalesPerformanceValueCompared(stDate,endDate,zone,state,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,selectedValues);
      }else
      {
           Macv_State(Zone,state,selectedValues,EmpID);
           Macv_Zone(Zone,state,selectedValues,EmpID);
           Macv_SourceSite(Zone,state,selectedValues,EmpID);
           Macv_Category(Zone,state,selectedValues,EmpID);
           KIOSK(stDate,endDate,zone,state,selectedValues);          
	   SalesPerformanceQtnCompared(stDate,endDate,zone,state,selectedValues);
           SalesPerformanceValueCompared(stDate,endDate,zone,state,selectedValues);
	SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,selectedValues);
	SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,selectedValues);     
 }
        selectedValues = [];
      
      });
            
    });


}
