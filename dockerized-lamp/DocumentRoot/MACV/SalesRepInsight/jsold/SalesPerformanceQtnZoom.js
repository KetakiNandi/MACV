$( document ).ready(function() {

  if(ClickFlag==0)
     {
      //console.log("222");
      render_avgsessionZoom();
       document.getElementById('SPQ2').disabled = true;
    }
    else
         {
          
          $('#SPQ2').click(function(d){
            
                render_avgsessionZoom();
              
             });  
          }
});

function render_avgsessionZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

	//console.log("WWWWWW$$$$$",startDate)

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = 800 - margin.left - margin.right,
      height = 350 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1);

    var y = d3.scale.linear()
        .range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
       .orient("bottom")
       .tickFormat(d3.time.format("%b-%Y"));

    var yAxis = d3.svg.axis();
   
  var div = d3.select("body").append("div").attr("class", "toolTipZoom");

  //$("#SPQ").html('');
  
  var svg = d3.select("#SPQZ").append("svg")
        .attr("id","ASUZ")
        .attr("width", 820)
        .attr("height", 495)
        .append("g")
        .attr("transform", "translate(" + 40 + "," + 80 + ")");

 //var SPQ=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SalesPerformanceQtn.php"); 

   if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined){

          links=(SPQ+"?param=");
        }
    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?zoneparam="+zone);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (state) && zone === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?Stateparam="+state);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (city) && zone === undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?Cityparam="+city);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (sourceSite) && zone === undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?Siteparam="+sourceSite);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (promoname) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?ProNameparam="+promoname);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (catgory) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?categoryparam="+catgory);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (emp) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?EmpIdparam="+emp);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (yesno) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?YesNoparam="+yesno);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (subcat) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?SubCatparam="+subcat);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (itemcode) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=encodeURI(SPQ+"?itemcodeparam="+itemcode);
         // console.log(links);
          d3.select("#ASUZ").remove();
    }
    else if(startDate === undefined && endDate === undefined && (POSType) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=encodeURI(SPQ+"?POSTypeparam="+POSType);
         //console.log(links);
          d3.select("#ASUZ").remove();
    }
        else{
          links=encodeURI(SPQ+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#ASUZ").remove();
        }   

 d3.json(links, function(data) {

  if(data.length!=0)
{
  var fmt = d3.time.format.utc("%b-%Y").parse;

  var fmt1 = d3.time.format.utc("%b-%Y");

  var datefmt = d3.time.format("%d-%b-%y");

     data.forEach(function(d) {
        d.Month = fmt(d.Month);
        d.Count = +d.Count;

       });

     

data.sort(sortByDateAscending);

  function sortByDateAscending(a,b){
  return new Date(a.Month)-new Date(b.Month);
  }

data.forEach(function(d) {
        d.Month = fmt1(d.Month);
        d.Count = +d.Count;

       });

//console.log(JSON.stringify(data));
    
     x.domain(data.map(function(d) { return d.Month;}));
     y.domain([0, d3.max(data, function(d) {return d.Count; })]);

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
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Month +"<br/>"+"QTY: " +d.Count+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });



svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Month)+10; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .style("font-weight","bold")
  .style("font-size", "10px")
  .text(function(d) { return (dollarFormatterK(d.Count)); });


}
else{

//  alert("No Data Available for Selected Criteria");
}


  });

 function dollarFormatterK(n) {
  n = Math.round(n);
  var result = n;
  if (Math.abs(n) > 1000) {
    result = Math.round(n/1000)+'K';
  }
  return result;
}
  

}

