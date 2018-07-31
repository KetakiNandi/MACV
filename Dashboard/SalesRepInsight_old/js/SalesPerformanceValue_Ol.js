$( document ).ready(function() {	

    SalesPerformanceValue();
});

function SalesPerformanceValue(spzone,Sstate,scity,Semp,SSite,Scate,prname){

	//console.log("ssssssssssssssss",startDate,endDate)

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = 800 - margin.left - margin.right,
      height = 150 - margin.top - margin.bottom

    //var x = d3.scale.ordinal()
      //  .rangeRoundBands([0, width/3], .1);

  var x = d3.scale.ordinal().rangeBands([0, width/3], .1);

    var y = d3.scale.linear()
        .range([height/2, 0]);

    var y1 = d3.scale.linear().range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
       .orient("bottom")
       .tickFormat(d3.time.format("%b-%Y"));

    var yAxis = d3.svg.axis();

  
   
  var div = d3.select("body").append("div").attr("class", "toolTip");

  var commaFormat = d3.format(',');

/*
  var valueline = d3.svg.line()
  .x(function (d) { return x(d.Month) + x.rangeBand()/2; })
  .y(function (d) { return y(d.Amo); });*/

  var line = d3.svg.line()
    .x(function(d) { return x(d.Month); })
    .y(function(d) {
      console.log("ssssssssssssssssssss",JSON.stringify(d.Amo))
     return y1(d.Amo); });


  
  var svg = d3.select("#SPV").append("svg")
        .attr("id","SPVR")
        .attr("width", 400)
        .attr("height", 200)
        .append("g")
        .attr("transform", "translate(" + 30 + "," + 40 + ")");





  var data=[];
    

 //d3.json("http://localhost/MACV/SalesRepInsight/data/SalesPerformanceValue.php", function(data) {

  var SPVURL=encodeURI("http://localhost/MACV/SalesRepInsight/data/SalesPerformanceValue.php");

if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined) 
    {
      links=(SPVURL+"?param=");
    }
else if((spzone) && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined)
    {
      links=(SPVURL+"?zoneparam="+spzone);
      d3.select("#SPVR").remove();
    }

else if(spzone === undefined && Sstate  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined)
    {

    links=(SPVURL+"?Stateparam="+Sstate);
    d3.select("#SPVR").remove();
  }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined)
  {

    links=(SPVURL+"?Cityparam="+scity);
      d3.select("#SPVR").remove();
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp  && SSite === undefined && Scate === undefined && prname === undefined)
  {

    links=(SPVURL+"?EmpIdparam="+Semp);
    d3.select("#SPVR").remove();
}

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined)
{
  links=(SPVURL+"?Siteparam="+SSite);
  d3.select("#SPVR").remove();
}

else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined)
{
links=(SPVURL+"?categoryparam="+Scate);

console.log("ssssssssssss",links);

  d3.select("#SPVR").remove();

}
  
else
  {
    links=(SPVURL+"?ProNameparam="+prname);

      d3.select("#SPVR").remove();
   }
  
d3.json(links,function(error, Arraydata) {

//
  d3.json("http://localhost/MACV/SalesRepInsight/data/SalesPerformanceValueASP.php", function(user) {

    Arraydata.forEach(function (d) {
      user.forEach(function (e){
        if(d.Month==e.Month){

          data.push({
                  Month:d.Month,
                  Count:d.Amount,
                  Amo:e.ASP,
                 });
              }
         });
    });

//console.log("ssssssssss",JSON.stringify(data))


  var fmt = d3.time.format.utc("%b-%Y").parse;

  var fmt1 = d3.time.format.utc("%b-%Y");

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
        .attr("transform", "translate(0," + 100 + ")")
        .call(d3.svg.axis().scale(x).orient("bottom"))
        .selectAll("text")
        .style("text-anchor", "end")
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
              div.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Month +"<br/>"+"Amounts: " +commaFormat(d.Count)+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });


//
/*
svg.selectAll("dot")    
          .data(data)         
          .enter().append("circle")
          .attr("fill","#de825d")                             
          .attr("r", 5)       
          .attr("cx", function(d) {return x(d.Month); })       
          .attr("cy", function(d) { return y(d.uniqueUser); })  
          .on("mouseover", function(d) {      
        div.transition()        
           .duration(200)      
          .style("opacity", .7);      
        div.html("Avg comment Count: "+(d.commentCount) + "<br/>User Count: "+ (d.uniqueUser).toFixed(2)+"%")  
          .style("left", (d3.event.pageX) + "px")     
          .style("top", (d3.event.pageY - 28) + "px");    
            })                  
          .on("mouseout", function(d) {       
         div.transition()        
          .duration(500)      
          .style("opacity", 0);}); 


*/

//





var linegraph = svg.selectAll("path.line").data([data], function(d) { return d.Month; });
    
linegraph.attr('d', line).style("opacity", 1.0);
    
linegraph.enter().append("path")
        .attr("class", "line")
        .attr("d", line);



/*
svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Month)+20; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .text(function(d) { return (dollarFormatterK(d.Count)); });*/



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
  

}
