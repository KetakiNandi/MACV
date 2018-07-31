$( document ).ready(function() {	

    render_avgSoldPerDay();

});

function render_avgSoldPerDay(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

  //console.log(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode);
var msg = document.getElementById("DESTROY").value;
   var margin = {top: 40, right: 20, bottom: 30, left: 20},
      width = 900 - margin.left - margin.right,
      height = 200 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, 580],.2);

    var y = d3.scale.linear()
        .range([100, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis();

   

var div = d3.select("body").append("div").attr("class", "toolTip");


    var svg = d3.select("#SAQP").append("svg")
        .attr("id","SUPC")
        .attr("width", 580)
        .attr("height", 180)
        .append("g")
        .attr("transform", "translate(" + 10 + "," + 10 + ")");
    
    //svg.call(tip);http://13.228.24.255/

     var links;
      var startDateParam;
     var endDateParam;

     //var SAQPDLink = encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/saleAvgQtnPerDay.php");

     if (startDate === undefined && endDate === undefined && zone === undefined && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

      links=encodeURI(SAQPDLink+"?param="+msg);
      // console.log("@@@",links);
     }
     else if(startDate === undefined && endDate === undefined && zone && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?zoneparam="+zone);
         //console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && state && zone===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?Stateparam="+state);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && city && zone===undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?Cityparam="+city);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?Siteparam="+sourceSite);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
     else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?categoryparam="+catgory);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && emp && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?EmpIdparam="+emp);
          console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && yesno && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?YesNoparam="+yesno);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && subcat && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?SubCatparam="+subcat);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && itemcode && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?itemcodeparam="+itemcode);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if((startDate && endDate) && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=(SAQPDLink+"?param=");
          console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if((POSType) && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && startDate === undefined && endDate === undefined)
    {
          links=(SAQPDLink+"?POSTypeparam="+POSType);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
     else{
        links=encodeURI(SAQPDLink+"?ProNameparam="+promoname);
        //console.log("@@@",links);
        d3.select("#SUPC").remove();
     }

     var parseDate = d3.time.format("%d-%b-%y").parse;
     var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
     var firstDate = new Date(startDate);
     var secondDate = new Date(endDate);
    // console.log("1111",firstDate);
    // console.log("222",secondDate);

    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));

    //console.log("$$$",diffDays);

  d3.json(links, function(json) {

   if(json.length!=0)
   {
   if(json.dateParam)
	{
	      startDateParam = json.dateParam.stDate;
	      endDateParam = json.dateParam.endDate;
		//  console.log("1111",startDateParam);
		 // console.log("2222",endDateParam);

	       var firstDateSession = new Date(startDateParam);
	      var secondDateSession = new Date(endDateParam);
	    // console.log("1111",firstDateSession);
	    // console.log("222",secondDateSession);

	    var diffDaysSession = Math.round(Math.abs((firstDateSession.getTime() - secondDateSession.getTime())/(oneDay)));

	    //console.log("$$$",diffDaysSession);
	     
	    var data=json.data;

	    data.forEach(function(d){
           d.PosName=d.PosName;
          if(d.PosCode=='QRILQRIL029')
                {
                    d.PosCode = "QRIL029";
                }
         

	//if(startDateParam && endDateParam && zone)
         // {
           // console.log("$$$$$",d.count);
            d.count =+(d.count/diffDaysSession);
	   // console.log("*******");
            
         // }      
    });

      }
   else{

    var data=json;

    data.forEach(function(d){
      d.PosName=d.PosName;
          if(d.PosCode=='QRILQRIL029')
                {
                    d.PosCode = "QRIL029";
                }
          /*if(startDate === undefined && endDate === undefined)
            {
              d.QtnPerDay =+(d.QtnPerDay/365);
            }
          else*/ 

          if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
          //  console.log("$$$$$",d);
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
          {
           //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory && emp===undefined && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp && yesno===undefined && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
           else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno && subcat===undefined)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else if((firstDate && secondDate) && startDate===undefined && endDate===undefined && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat)
          {
            //console.log("$$$$$");
            d.count =+(d.count/365);
            
          }
          else {
            //console.log("$$$",diffDays);
            //console.log("%%%",d.QtnPerDay);
            d.count =+(d.count/diffDays);
          }
    });
}

    data.sort(function(a, c) { return c.count - a.count; });

    //console.log("ffffff",JSON.stringify(data));

    x.domain(data.map(function(d) { 
        return d.PosCode;}));
//    y.domain([0, d3.max(data, function(d) { return (d.count); })]);

var staticMax=60;
  y.domain([0, d3.max(data, function (d) { return d.count > staticMax ? d.count : staticMax; }) ]);


 var xaxis = svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + 130+ ")")
        .call(d3.svg.axis().scale(x).orient("bottom"))
        .selectAll("text")
        .style("text-anchor", "end")
        .style("font-size", "8px")
        .attr("dx", "-.1em")
        .attr("dy", ".35em")
        .attr("transform", function(d) { return "rotate(-45)" });

        var stDate;
        var endDate;
        var zone;
        var state;
        var city;
        var Zone;
        var EmpID;

     svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.PosCode); })
        .attr("width", x.rangeBand())
        .attr("y", function(d) {return y(d.count); })
        .attr("height", function(d) { return height - y(d.count); })
        .on("mousemove", function(d){
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Pos Code: " +d.PosCode +"<br/>"+"Qtn Per Day: " +(d.count).toFixed(2)+"<br/>"+"Pos Name: "+d.PosName+ "</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          })
      .on("click", function(d){
        //console.log(d.PosName);
        Macv_Zone(Zone,state,city,EmpID,d.PosName);
        Macv_State(Zone,state,city,EmpID,d.PosName);
        Macv_City(Zone,state,city,EmpID,d.PosName);
        Macv_Category(Zone,state,city,EmpID,d.PosName);
        Macv_Promoname(Zone,state,city,EmpID,d.PosName);
        Macv_EmpId(Zone,state,city,EmpID,d.PosName);
        Macv_SourceSite(Zone,state,city,EmpID,d.PosName);
	Macv_POSType(Zone,state,city,EmpID,d.PosName);

        //SalesPerformanceValue(stDate,endDate,zone,state,city,d.PosName);
        
        render_Tachievement(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,d.PosName);
       // PoSperformance(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,d.PosName);

        
     });


 svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.PosCode)+07; })
  .attr("y", function(d) { return y(d.count)-03; })
  .style("fill","white")
  .style("font-weight","bold")
  .style("font-size", "10px")
  .text(function(d) { return (Math.round(d.count)); });
   }
   else
   {
    alert("Sales-Avg Qtn Sold/Day Data is Not Available for Selected Criteria");
   }

  });
}
