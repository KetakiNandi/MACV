$( document ).ready(function() {

  	Macv_Category();
  
  });


function Macv_Category(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){
  //console.log(itemcode);

//d3.json("http://localhost/MACV/SalesRepInsight/data/Category.php",function(data){

  var msg = document.getElementById("DESTROY").value;

var links;
var Zone;
var city;
var EmpID;
var SourceSite;
var state;


  //var pCategory=encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/Category.php");



if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)

    {
      links=(pCategory+"?param="+msg);
    }

else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {

    links=(pCategory+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
    {
       links=(pCategory+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
   {

   links=(pCategory+"?Cityparam="+scity);
    
   }

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
   {

   links=(pCategory+"?EmpIdparam="+Semp);
    
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
  
  {
    links=(pCategory+"?Siteparam="+SSite);
  }

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
  links=(pCategory+"?categoryparam="+Scate);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
  links=encodeURI(pCategory+"?SubCatparam="+subcat);
  //console.log(links);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
{
  links=encodeURI(pCategory+"?itemcodeparam="+itemcode);
  //console.log(links);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
{
  links=encodeURI(pCategory+"?POSTypeparam="+POSType);
 // console.log(links);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType=== undefined && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
{
  links=encodeURI(pCategory+"?startDate="+startDate+"&endDate="+endDate);
 // console.log(links);
}
else 
{

links=encodeURI(pCategory+"?ProNameparam="+prname);
//console.log(links);

}

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


d3.json(links,function(error, json) {

var sessionFlag=0;
	if(json.dateParam)
	 {
		sessionFlag=1;
		var data = json.data;
    		data.forEach(function(d) { 
             d.Division = d.Division;
          });

	data.push({
        Division:"All"
      })
     }
else{
	var data=json;
	data.forEach(function(d) { 
    
             d.Division = d.Division;
          });

	data.push({
        Division:"All"
      })
}
        d3.select("#MacDPG").html("");

var stDate;
var endDate;
var zone;
var promo;


var signal = d3.select('#MacDPG');
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
        return d.Division;
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

    d3.select('#someButton5')
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

         //document.getElementById('someButton6').disabled = false;

		if(sessionFlag==1)
		{
			  // Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
			   KIOSK(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
		           SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
				 SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
				 SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
			   
                 }
		else{
			  // Macv_Zone(Zone,state,city,EmpID,SourceSite,selectedValues);
			 //  Macv_State(Zone,state,city,EmpID,SourceSite,selectedValues);
			 //  Macv_City(Zone,state,city,EmpID,SourceSite ,selectedValues);
			 //  Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
			   KIOSK(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
                           SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
			     SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
			 SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
		}
      }else
      {

        // document.getElementById('someButton6').disabled = false;
	   if(sessionFlag==1)
	   {
		   
		  // Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
		   KIOSK(stDate,endDate,zone,state,city,SourceSite,selectedValues);
		   SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
                   SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);		   
		 SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
		 SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);

	   }
	else{
		 //  Macv_Zone(Zone,state,city,EmpID,SourceSite,selectedValues);
		  // Macv_State(Zone,state,city,EmpID,SourceSite,selectedValues);
		  // Macv_City(Zone,state,city,EmpID,SourceSite ,selectedValues);
		  // Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
		   KIOSK(stDate,endDate,zone,state,city,SourceSite,selectedValues);
		   SalesPerformanceQtnCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
                   SalesPerformanceValueCompared(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);		   
		  SalesPerformanceQtnComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
		 SalesPerformanceValueComparedZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	}
      }
        selectedValues = [];
      
      });

        });


}
