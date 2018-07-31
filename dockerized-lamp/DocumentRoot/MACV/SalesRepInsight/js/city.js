$( document ).ready(function() {


  	Macv_City();
  
  });


function Macv_City(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType,startDate,endDate){

  //console.log(spzone);

//d3.json("http://localhost/MACV/SalesRepInsight/data/city.php",function(data){

  var msg = document.getElementById("DESTROY").value;
  var links;
  var Zone;
  var state;
  var EmpID;
  var globalSelectedValuesCity;
  var globalSelectedValuesCity1;

//var pCity=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/city.php");


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


var startDateParam;
var endDateParam;
  d3.json(links,function(error, json) {

  if(json.dateParam)
  {
    startDateParam = json.dateParam.stDate;
    endDateParam = json.dateParam.endDate;
      var data = json.data;
    data.forEach(function(d) { 
       d.CIty = d.CIty;
      
      });
    data.push({
      CIty:"All"
    })
  }
  else
  {
   startDateParam = "01-Jan-17";
   endDateParam = "31-Dec-17";
  var data=json;
  data.forEach(function(d) { 
       d.CIty = d.CIty;
      
      });
    data.push({
      CIty:"All"
    })
  }

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
        //alert(selectedValues);
           Macv_EmpId(Zone,state,selectedValues,EmpID);
        //   Macv_State(Zone,state,selectedValues,EmpID);
          // Macv_Zone(Zone,state,selectedValues,EmpID);
           Macv_SourceSite(Zone,state,selectedValues,EmpID);
           Macv_Category(Zone,state,selectedValues,EmpID);
           Macv_Promoname(Zone,state,selectedValues,EmpID);
           Macv_POSType(Zone,state,selectedValues,EmpID);
         //  render_avgSoldPerDay(stDate,endDate,zone,state,selectedValues);
           CategorywisePerformanceQuantity(stDate,endDate,zone,state,selectedValues);
           SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,selectedValues);
           CustomerDetailsFilled(stDate,endDate,zone,state,selectedValues);
	    CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,selectedValues);
           SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,selectedValues);
           CustomerDetailsFilledZoom(stDate,endDate,zone,state,selectedValues);
          // render_Tachievement(stDate,endDate,zone,state,selectedValues);
          // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,selectedValues);
          // SalesPersonWiseContributionValue(stDate,endDate,zone,state,selectedValues);
           // PoSperformance(stDate,endDate,zone,state,selectedValues);
            //SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,selectedValues);

             if(ClickFlagV=="2")
         {
	    globalSelectedValuesCity1 = selectedValues;
            SalesPerformanceValue(stDate,endDate,zone,state,selectedValues);
	    SalesPerformanceValueZoom(stDate,endDate,zone,state,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,selectedValues);}

             $('#SPV1').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesCity1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,selectedValues);
               });

             $('#SPV2').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesCity1 ;
              SalesPerformanceValue(stDate,endDate,zone,state,selectedValues);
              SalesPerformanceValueZoom(stDate,endDate,zone,state,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
	   globalSelectedValuesCity = selectedValues;
            render_avgsession(stDate,endDate,zone,state,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,state,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,selectedValues);}
            $('#SPQ1').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesCity ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,selectedValues);
               }); 
            $('#SPQ2').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesCity ;
              render_avgsession(stDate,endDate,zone,state,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,state,selectedValues);
               }); 
       }


      }else
      {
           Macv_EmpId(Zone,state,selectedValues,EmpID);
          // Macv_State(Zone,state,selectedValues,EmpID);
          // Macv_Zone(Zone,state,selectedValues,EmpID);
           Macv_SourceSite(Zone,state,selectedValues,EmpID);
           Macv_Category(Zone,state,selectedValues,EmpID);
           Macv_Promoname(Zone,state,selectedValues,EmpID);
           Macv_POSType(Zone,state,selectedValues,EmpID);
          // render_avgSoldPerDay(stDate,endDate,zone,state,selectedValues);
           CategorywisePerformanceQuantity(stDate,endDate,zone,state,selectedValues);
           SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,selectedValues);
           CustomerDetailsFilled(stDate,endDate,zone,state,selectedValues);
	    CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,selectedValues);
           SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,selectedValues);
           CustomerDetailsFilledZoom(stDate,endDate,zone,state,selectedValues);
        //   render_Tachievement(stDate,endDate,zone,state,selectedValues);
      //     SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,selectedValues);
    //       SalesPersonWiseContributionValue(stDate,endDate,zone,state,selectedValues);
  //          PoSperformance(stDate,endDate,zone,state,selectedValues);
//            SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,selectedValues);

             if(ClickFlagV=="2")
         {
	    globalSelectedValuesCity1 = selectedValues;
            SalesPerformanceValue(stDate,endDate,zone,state,selectedValues);
	    SalesPerformanceValueZoom(stDate,endDate,zone,state,selectedValues);

            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,selectedValues);}

             $('#SPV1').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesCity1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,selectedValues);
               });

             $('#SPV2').click(function(){
               if(selectedValues.length == 0)
                  selectedValues = globalSelectedValuesCity1 ;
              SalesPerformanceValue(stDate,endDate,zone,state,selectedValues);
              SalesPerformanceValueZoom(stDate,endDate,zone,state,selectedValues);
               });  
         }

         if(ClickFlag=="0")
         {
	    globalSelectedValuesCity = selectedValues;
            render_avgsession(stDate,endDate,zone,state,selectedValues);
	    render_avgsessionZoom(stDate,endDate,zone,state,selectedValues);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,selectedValues);}
            $('#SPQ1').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesCity ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,selectedValues);
               }); 
            $('#SPQ2').click(function(){
              if(selectedValues.length == 0)
		  selectedValues = globalSelectedValuesCity ;
              render_avgsession(stDate,endDate,zone,state,selectedValues);
              render_avgsessionZoom(stDate,endDate,zone,state,selectedValues);
               }); 
       }
      }
        selectedValues = [];
      
      });
             
    });


}
