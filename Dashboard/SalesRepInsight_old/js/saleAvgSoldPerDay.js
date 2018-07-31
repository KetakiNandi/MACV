$( document ).ready(function() {	

    render_avgSoldPerDay();

});

function render_avgSoldPerDay(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode){

  console.log(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode);

   var margin = {top: 40, right: 20, bottom: 30, left: 20},
      width = 800 - margin.left - margin.right,
      height = 100 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width/2],.2);

    var y = d3.scale.linear()
        .range([height/2, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis();

   

var div = d3.select("body").append("div").attr("class", "toolTip");


    var svg = d3.select("#SAQP").append("svg")
        .attr("id","SUPC")
        .attr("width", 400)
        .attr("height", 200)
        .append("g")
        .attr("transform", "translate(" + 10 + "," + 130 + ")");
    
    //svg.call(tip);

     var links;

     var SAQPDLink = encodeURI("http://localhost/MACV/SalesRepInsight/data/saleAvgQtnPerDay.php");

     if (startDate === undefined && endDate === undefined && zone === undefined && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined) {

      links=encodeURI(SAQPDLink+"?param=");
     }
     else if(startDate === undefined && endDate === undefined && zone && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?zoneparam="+zone);
          console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && state && zone===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?Stateparam="+state);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && city && zone===undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?Cityparam="+city);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?Siteparam="+sourceSite);
          //console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
     else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?categoryparam="+catgory);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && emp && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?EmpIdparam="+emp);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && yesno && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?YesNoparam="+yesno);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && subcat && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined)
    {
          links=(SAQPDLink+"?SubCatparam="+subcat);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if(startDate === undefined && endDate === undefined && itemcode && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
    {
          links=(SAQPDLink+"?itemcodeparam="+itemcode);
         // console.log("@@@",links);
          d3.select("#SUPC").remove();
    }
    else if((startDate && endDate) && itemcode===undefined && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined)
    {
          links=(SAQPDLink+"?param=");
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
            //console.log("$$$$$");
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
            //console.log("%%%",d.count);
            d.count =+(d.count/diffDays);
          }
    });

    data.sort(function(a, c) { return c.count - a.count; });

    //console.log("ffffff",JSON.stringify(data));

    x.domain(data.map(function(d) { 
        return d.PosCode;}));
    y.domain([0, d3.max(data, function(d) { 
      return (d.count); })]);

 var xaxis = svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + 30+ ")")
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

        //SalesPerformanceValue(stDate,endDate,zone,state,city,d.PosName);
        CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,d.PosName);
        SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,d.PosName);
        CustomerDetailsFilled(stDate,endDate,zone,state,city,d.PosName);
        render_Tachievement(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,d.PosName);
        PoSperformance(stDate,endDate,zone,state,city,d.PosName);
        SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,d.PosName);

         if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,d.PosName);
         }
         else{
            SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,d.PosName);
       }

        if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,d.PosName);
         }
         else{
            SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,d.PosName);
       }

     });
   }
   else
   {
    alert("No Data Available for Selected Criteria");
   }

  });
}
