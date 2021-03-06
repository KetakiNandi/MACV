$( document ).ready(function() {	
    if(ClickFlagV==2)
     {
      SalesPerformanceValueZoom();
       document.getElementById('SPV2').disabled = true;
    }
    else
         {
          
          $('#SPV2').click(function(d){
            
                SalesPerformanceValueZoom();
              
             });  
          }
});

function SalesPerformanceValueZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

	//console.log("ssssssssssssssss",zone)

     var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = 800 - margin.left - margin.right,
      height = 350 - margin.top - margin.bottom

    //var x = d3.scale.ordinal()
      //  .rangeRoundBands([0, width/3], .1);

  var x = d3.scale.ordinal().rangeBands([0, width], .1);

    var y = d3.scale.linear()
        .range([height, 0]);

    var y1 = d3.scale.linear().range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
       .orient("bottom")
       .tickFormat(d3.time.format("%b-%Y"));

    var yAxis = d3.svg.axis();

 
  var div = d3.select("body").append("div").attr("class", "toolTipZoom");

  var div1 = d3.select("body").append("div").attr("class", "tooltip1");

  var commaFormat = d3.format(',');

  var line = d3.svg.line()
    .x(function(d) { return x(d.Month); })
    .y(function(d) {
      //console.log("ssssssssssssssssssss",JSON.stringify(d.Amo))
     return y1(d.Amo); });


  
  var svg = d3.select("#SPVZ").append("svg")
        .attr("id","SPVRZ")
        .attr("width", 780)
        .attr("height", 495)
        .append("g")
        .attr("transform", "translate(" + 40 + "," + 80 + ")");

  var data=[];

  var links;
  var links1;

   //var SPV=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SalesPerformanceValue.php"); 

   //var SPVL=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SalesPerformanceValueASP.php"); 

   if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

          links=(SPV+"?param=");
          links1=(SPVL+"?param=");
          //console.log("333",links1);
        }
    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SPV+"?zoneparam="+zone);
          links1=(SPVL+"?zoneparam="+zone);
         // console.log("111",links1);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && state && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?Stateparam="+state);
          links1=encodeURI(SPVL+"?Stateparam="+state);
          //console.log("222",links1);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && city && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?Cityparam="+city);
          links1=encodeURI(SPVL+"?Cityparam="+city);
          d3.select("#SPVRZ").remove();
    }
     else if(startDate === undefined && endDate === undefined && zone === undefined && sourceSite && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?Siteparam="+sourceSite);
          links1=encodeURI(SPVL+"?Siteparam="+sourceSite);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && promoname && state === undefined && city===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?ProNameparam="+promoname);
          links1=encodeURI(SPVL+"?ProNameparam="+promoname);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && catgory && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?categoryparam="+catgory);
          links1=encodeURI(SPVL+"?categoryparam="+catgory);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && emp && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?EmpIdparam="+emp);
          links1=encodeURI(SPVL+"?EmpIdparam="+emp);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && yesno && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?YesNoparam="+yesno);
          links1=encodeURI(SPVL+"?YesNoparam="+yesno);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && subcat && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?SubCatparam="+subcat);
          links1=encodeURI(SPVL+"?SubCatparam="+subcat);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && itemcode && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=encodeURI(SPV+"?itemcodeparam="+itemcode);
          links1=encodeURI(SPVL+"?itemcodeparam="+itemcode);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && POSType && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=encodeURI(SPV+"?POSTypeparam="+POSType);
          links1=encodeURI(SPVL+"?POSTypeparam="+POSType);
         // console.log(links);
          d3.select("#SPVRZ").remove();
    }
        else{
          links=encodeURI(SPV+"?startDate="+startDate+"&endDate="+endDate);
          links1=encodeURI(SPVL+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#SPVRZ").remove();
        }

 d3.json(links, function(Arraydata) {

  d3.json(links1, function(user) {

    //console.log("ssssssssss",Arraydata.length);
    //console.log("WWWW",user.length);

    if(Arraydata.length!=0 && user.length!=0)

    { Arraydata.forEach(function (d) {
      user.forEach(function (e){
        if(d.Month==e.Month){

          data.push({
                  Month:d.Month,
                  Count:d.Amount,
                  Amo:e.Amount/e.QTN,
                 });
              }
         });
    });

     //console.log("ssssssssss",JSON.stringify(data))


  var fmt = d3.time.format.utc("%b-%Y").parse;

  var fmt1 = d3.time.format.utc("%b-%Y");

  var datefmt = d3.time.format("%d-%b-%y");

    data.forEach(function(d) {
        d.Month = fmt(d.Month);
        d.Count = +d.Count;
        d.Amo = +d.Amo;

       });

     

data.sort(sortByDateAscending);

  function sortByDateAscending(a,b){
  return new Date(a.Month)-new Date(b.Month);
  }

data.forEach(function(d) {
        d.Month = fmt1(d.Month);
        d.Count = +d.Count;
         d.Amo = +d.Amo;

       });

//var currentMonth = (new Date).getMonth();
// var currentQuarter = Math.floor(((currentMonth + 11) / 3) % 4) + 1;


//console.log("ssssssssss",JSON.stringify(data))
     x.domain(data.map(function(d) { return d.Month;}));
     y.domain([0, d3.max(data, function(d) {return d.Count; })]);

     y1.domain([0, d3.max(data, function(d) { return Math.max(d.Amo); })]);

     var yaxis = svg.append("g")
        .attr("class", "y axis")
        //.call(d3.svg.axis().scale(y).orient("left"))
        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.1em")
        .attr("dy", "-.1em")
        .attr("fill",'#ffff');
        

    var xaxis = svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + 300 + ")")
        .call(d3.svg.axis().scale(x).orient("bottom"))
        .selectAll("text")
        .style("text-anchor", "end")
        .style("font-size", "10px")
        .attr("dx", "-.1em")
        .attr("dy", "-.1em")
        .attr("transform", function(d) { return "rotate(-35)" });



     svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.Month); })
        .attr("width", x.rangeBand())
        .attr("y", function(d) { return y(d.Count); })
        .attr("height", function(d) { return height - y(d.Count); })
         .on("mousemove", function(d){
          //console.log("!!!",d);
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Month +"<br/>"+"Amounts: " +commaFormat(d.Count)+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });

      var linegraph = svg.selectAll("path.line").data([data], function(d) { return d.Month; });
    
          linegraph.attr('d', line).style("opacity", 1.0);
              
          linegraph.enter().append("path")
                  .attr("class", "line")
                  .attr("d", line);

                  //console.log("ssssssssss",JSON.stringify(data))

      svg.selectAll("dot")  
        .data(data)     
        .enter().append("circle")  
        .attr("fill","orange")             
        .attr("r", 5)   
        .attr("cx", function(d) { return x(d.Month); })     
        .attr("cy", function(d) { return y1(d.Amo); })   
        .on("mouseover", function(d) { 
       // console.log(d.Month);   
            div1.transition()    
                .duration(200)    
                .style("opacity", .5);    
           div1.style("left", d3.event.pageX+10+"px");
              div1.style("top", d3.event.pageY-25+"px");
              div1.style("display", "inline-block");
              div1.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Month +"<br/>"+"ASP: " +d.Amo.toFixed(2)+"</span>");             
            })          
        .on("mouseout", function(d) {   
            div1.transition()    
                .duration(500)    
                .style("opacity", 0); 
        });
	
svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Month)+20; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .style("font-weight","bold")
  .text(function(d) { 
  if(d.Count >=100000)
  {
    return (dollarFormatterL(d.Count));
  }

  else 
    {
      return (dollarFormatterK(d.Count));
      }});	

     }
     else{

     // alert("No Data Available for Selected Criteria");
     }
});

  });

 function dollarFormatterK(n) {
  n = Math.round(n);
  var result = n;
  if (Math.abs(n) > 1000) {
    result = Math.round(n/1000)+'K';
  }

  return result;
}

function dollarFormatterL(n) {
  n = Math.round(n);
  var result = n;
  if (Math.abs(n) > 100000) {
    result = Math.round(n/100000)+'L';
  }
  return result;
}  

}
