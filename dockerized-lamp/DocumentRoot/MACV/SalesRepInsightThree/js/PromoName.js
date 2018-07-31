$( document ).ready(function() {

//    document.getElementById('someButton6').disabled = true;
 


  	Macv_Promoname();
  
  });


function Macv_Promoname(spzone,Sstate,scity,Semp,SSite,Scate,subcat,itemcode,POSType,startDate,endDate){

 var msg = document.getElementById("DESTROY").value;

      var links;
      var Zone;
      var city;
      var EmpID;
      var Division;
      var state;
      var SourceSite;


     // var pName=encodeURI("http://localhost/MACV/SalesRepInsight/data/promoName.php");

if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined) {

          links=encodeURI(pName+"?param="+msg);
          //console.log("promoname",links);

         }

       else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
          {

             links=encodeURI(pName+"?zoneparam="+spzone);



            }

      else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
          {
             links=encodeURI(pName+"?Stateparam="+Sstate);

               //console.log(links);

           
          }
      else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
        {

        links=encodeURI(pName+"?Cityparam="+scity);

        }

      else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp  && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?EmpIdparam="+Semp);
        //console.log(links);
      }

      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && SSite  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?Siteparam="+SSite);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && subcat  && Scate === undefined && SSite===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?SubCatparam="+subcat);
       // console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && itemcode  && Scate === undefined && SSite===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?itemcodeparam="+itemcode);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && POSType  && Scate === undefined && SSite===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?POSTypeparam="+POSType);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && POSType=== undefined  && Scate === undefined && SSite===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
      {
        links=encodeURI(pName+"?startDate="+startDate+"&endDate="+endDate);
        //console.log(links);

      }
      else
      {

      links=encodeURI(pName+"?categoryparam="+Scate);
      //console.log(links);
      }
var startDateParam;
  var endDateParam;

      d3.json(links,function(error, json) {

	var sessionFlag=0;
	//console.log(JSON.stringify(json));

	if(json.dateParam)
	 {
    startDateParam = json.dateParam.stDate;
    endDateParam = json.dateParam.endDate;

		sessionFlag=1;
		var data = json.data;
			  data.forEach(function(d) { 
			  
			  d.PromoName = d.PromoName;
			  d.PromoNo = d.PromoNo;

		      });

			 data.push({
			PromoName:"All"
		      })
	  }
	else{
    startDateParam = "01-Jan-17";
   endDateParam = "31-Dec-17";
			 var data=json;
			 data.forEach(function(d) { 
			  
			  d.PromoName = d.PromoName;
			  d.PromoNo = d.PromoNo;

		      });

			 data.push({
			PromoName:"All"
		      })

	}

      //data.sort(function(a, c) { return c.count - a.count; });


      d3.select("#MacDTPRN").html("");

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
          
        }
    });
}

var stDate;
var endDate;
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
    var END;
    var Start1;


var signal = d3.select('#MacDTPRN');
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
      .append('option').attr("value", function(d){return d.PromoNo;})
      .text(function(d) {
        return d.PromoName;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'185px')
      .on('click', function(d) {
        var s = signalOptions.filter(function(d) {
          // console.log(d);
          // console.log(s);
          // console.log(this.selected);
          return this.selected;
        });
       
      });

   d3.select('#someButton6')
      .on('click', function(d) {
        var v = signalOptions.filter(function(d) {
          if(this.selected)
          {//console.log(this.value);
            selectedValues.push(this.value);
          return this.selected;
        }
        }).data();
        if(selectedValues=="All"){
          //console.log(startDateParam,endDateParam);
            //location.reload();

             PoSperformance(startDateParam,endDateParam);
    PoSperformanceZoom(startDateParam,endDateParam);
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
            WeekendMonth(startDateParam,endDateParam);

     WeekendMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(startDateParam,endDateParam);}

             $('#SPV1').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              //console.log("WWWW",startDateParam,endDateParam);
             WeekendQuarter(startDateParam,endDateParam);
               });

             $('#SPV2').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              WeekendMonth(startDateParam,endDateParam);
             WeekendMonthZoom(startDateParam,endDateParam);
               });  
         }

       if(ClickFlag=="0")
       {
    globalStDate1 = startDateParam;
            globalEndDate1 = endDateParam;
          WeekDayMonth(startDateParam,endDateParam);
  WeekDayMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(startDateParam,endDateParam);}
            $('#SPV3').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              //console.log("WWWW",startDateParam,endDateParam);
              WeekDayQuarter(startDateParam,endDateParam);
               }); 
            $('#SPV4').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              WeekDayMonth(startDateParam,endDateParam);
              WeekDayMonthZoom(startDateParam,endDateParam);
               }); 
     }
          
    
          }
          else if(selectedValues.indexOf('All')>-1){
        //alert(selectedValues);
            Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
	    Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
           PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues); 
	  
	
	if(ClickFlagV=="2")
         {
	    globalSelectedValuesPromo1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);

	   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo1 ;
              WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
             WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesPromo = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
	WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo ;
              WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
              WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               }); 
     }
           
  
 
      }else
      {
          Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
          Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
          Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
          Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
          Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
          Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
	   Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
            PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
         PoSperformanceZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);  
	 

	if(ClickFlagV=="2")
         {
	    globalSelectedValuesPromo1 = selectedValues;
            WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);

	   WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);}

             $('#SPV1').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo1 ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               });

             $('#SPV2').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo1 ;
              WeekendMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
             WeekendMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {
	  globalSelectedValuesPromo = selectedValues;
          WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
	WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);}
            $('#SPV3').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo ;
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               }); 
            $('#SPV4').click(function(){
              if(selectedValues == 0)
		selectedValues = globalSelectedValuesPromo ;
              WeekDayMonth(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
              WeekDayMonthZoom(stDate,endDate,Zone,state,city,SourceSite,selectedValues);
               }); 
     }

        
 
      }
        selectedValues = [];
      
      });

          });

}
