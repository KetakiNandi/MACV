$( document ).ready(function() {

  	Macv_Category();
  
  });


function Macv_Category(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType){
  //console.log(itemcode);

//d3.json("http://localhost/MACV/SalesRepInsight/data/Category.php",function(data){


var links;
var Zone;
var city;
var EmpID;
var SourceSite;
var state;


  var pCategory=encodeURI("http://localhost/MACV/SalesRepInsight/data/Category.php");



if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)

    {
      links=(pCategory+"?param=");
    }

else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {

    links=(pCategory+"?zoneparam="+spzone);
    }

else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
       links=(pCategory+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {

   links=(pCategory+"?Cityparam="+scity);
    
   }

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {

   links=(pCategory+"?EmpIdparam="+Semp);
    
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  
  {
    links=(pCategory+"?Siteparam="+SSite);
  }

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
{
  links=(pCategory+"?categoryparam="+Scate);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined)
{
  links=encodeURI(pCategory+"?SubCatparam="+subcat);
  //console.log(links);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined)
{
  links=encodeURI(pCategory+"?itemcodeparam="+itemcode);
  //console.log(links);
}
else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined)
{
  links=encodeURI(pCategory+"?POSTypeparam="+POSType);
 // console.log(links);
}
else 
{

links=(pCategory+"?ProNameparam="+prname);

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


d3.json(links,function(error, data) {

    data.forEach(function(d) { 
    
             d.Division = d.Division;
          });

	data.push({
        Division:"All"
      })

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
        //alert(selectedValues);
           Macv_Zone(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_State(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_City(Zone,state,city,EmpID,SourceSite ,selectedValues);
           Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_Promoname(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_EmpId(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_POSType(Zone,state,city,EmpID,SourceSite,selectedValues);
           // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	    CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);

           // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);

             if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
              SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               }); 
       }
      }else
      {
           Macv_Zone(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_State(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_City(Zone,state,city,EmpID,SourceSite ,selectedValues);
           Macv_SourceSite(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_Promoname(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_EmpId(Zone,state,city,EmpID,SourceSite,selectedValues);
           Macv_POSType(Zone,state,city,EmpID,SourceSite,selectedValues);
          //  render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	     CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);

           // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
           // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);

            if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
              SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,selectedValues);
               }); 
       }
      }
        selectedValues = [];
      
      });

        });


}
