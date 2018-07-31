$( document ).ready(function() {

  	Macv_POSType();
  
  });


function Macv_POSType(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode){

  //console.log(spzone);

//d3.json("http://localhost/MACV/SalesRepInsight/data/city.php",function(data){

  var links;
  var Zone;
  var state;
  var EmpID;

// var pCity=encodeURI("http://localhost/MACV/SalesRepInsight/data/POSType.php");


// if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//         links=(pCity+"?param=");
//     }
// else if((spzone) && Sstate === undefined  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//       links=(pCity+"?zoneparam="+spzone);
//       //console.log(links);
//     }

// else if(spzone === undefined && Sstate && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//         links=(pCity+"?Stateparam="+Sstate);
//     }

// else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//        links=(pCity+"?Cityparam="+scity);
//     }
// else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp  && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//         links=(pCity+"?EmpIdparam="+Semp);
//     }

// else if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//       links=(pCity+"?Siteparam="+SSite);
//     }
// else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined)
//     {
//       links=(pCity+"?categoryparam="+Scate);
//     }
// else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined)
//     {
//       links=(pCity+"?SubCatparam="+subcat);
//     }
//     else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined)
//     {
//       links=(pCity+"?itemcodeparam="+itemcode);
//     }
// else
//   {
//     links=(pCity+"?ProNameparam="+prname)
//   }


// d3.json(links,function(error, data) {


//       data.forEach(function(d) { 
    
//             d.CIty = d.CIty;
//       });



// data.sort(function(a, c) { return c.count - a.count; });


d3.select("#MacPT1").html("");

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

var signal = d3.select('#MacPT1');
    var signalName = ["COCO", "FOFO"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('height','75px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(signalName).enter()
      .append('option')
      .text(function(d) {
        return d;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'62px')
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

    d3.select('#someButton3')
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
       //Macv_EmpId(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_State(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Zone(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_SourceSite(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Category(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Promoname(Zone,state,this.options[this.selectedIndex].value,EmpID);

//         //SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_avgSoldPerDay(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CustomerDetailsFilled(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_Tachievement(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         PoSperformance(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,this.options[this.selectedIndex].value);

//         if(ClickFlagV=="2")
//          {
//             SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceValueQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }

//         if(ClickFlag=="0")
//          {
//             render_avgsession(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceQtnQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }
      }else
      {
        //Macv_EmpId(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_State(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Zone(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_SourceSite(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Category(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Promoname(Zone,state,this.options[this.selectedIndex].value,EmpID);

//         //SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_avgSoldPerDay(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CustomerDetailsFilled(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_Tachievement(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         PoSperformance(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,this.options[this.selectedIndex].value);

//         if(ClickFlagV=="2")
//          {
//             SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceValueQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }

//         if(ClickFlag=="0")
//          {
//             render_avgsession(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceQtnQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }
      }
        selectedValues = [];
      
      });

// var select = d3.select('#MacDC')
//     .append('select')
//     .attr('class','MacdivZ')
//     .on("change", function(d){
//         Macv_EmpId(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_State(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Zone(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_SourceSite(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Category(Zone,state,this.options[this.selectedIndex].value,EmpID);
//         Macv_Promoname(Zone,state,this.options[this.selectedIndex].value,EmpID);

//         //SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_avgSoldPerDay(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         CustomerDetailsFilled(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         render_Tachievement(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseContributionValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         PoSperformance(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//         SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,this.options[this.selectedIndex].value);

//         if(ClickFlagV=="2")
//          {
//             SalesPerformanceValue(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceValueQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }

//         if(ClickFlag=="0")
//          {
//             render_avgsession(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//          }
//          else{
//             SalesPerformanceQtnQuarter(stDate,endDate,zone,state,this.options[this.selectedIndex].value);
//        }

//       });

//  var selectUI = select
//              .selectAll("option")
//              .data(data)
//              .enter()
//              .append("option")
//              //.attr("value", function(d){return d.CIty;})
//              .text(function(d){return d.CIty;}).style("font-weight","bold").style("font-family",'Open Sans')
//              .call(wrap, 50);
             
   // });


}
