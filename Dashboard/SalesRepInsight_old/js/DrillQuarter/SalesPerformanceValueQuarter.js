$( document ).ready(function() {  

    SalesPerformanceValueQuarter();
});

function SalesPerformanceValueQuarter(startDate,endDate){

  console.log("ssssssssssssssss",startDate,endDate)

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width =250- margin.left - margin.right,
      height = 150 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width/2], .1);

    var y = d3.scale.linear()
        .range([height/2, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
       .orient("bottom");

    var yAxis = d3.svg.axis();
  var commaFormat = d3.format(',');
  
   
  var div = d3.select("body").append("div").attr("class", "toolTip");
  
  var svg = d3.select("#SPVQ").append("svg")
        .attr("id","SPVQR")
        .attr("width", 150)
        .attr("height", 200)
        .append("g")
        .attr("transform", "translate(" + 30 + "," + 70 + ")");
    

 var SPVQ=encodeURI("http://localhost/MACV/SalesRepInsight/data/SalesPerformanceValueQuarter.php");

  if (startDate === undefined && endDate === undefined) {

    links=(SPVQ+"?param=");

      }
      else{
         links=encodeURI(SPVQ+"?startDate="+startDate+"&endDate="+endDate);
          console.log(links);
          d3.select("#SPVQR").remove();
      }

      d3.json(links, function(data) {

     data.forEach(function(d) {
        d.Quarter = (d.Quarter);
        d.Count = +d.Amount;

       });


     data.sort(function(a, b){
    if(a.Quarter < b.Quarter) return -1;
    if(a.Quarter > b.Quarter) return 1;
    return 0;
});




     x.domain(data.map(function(d) { return d.Quarter;}));
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
        .attr("transform", "translate(0," + 100 + ")")
        .call(d3.svg.axis().scale(x).orient("bottom"))
        .selectAll("text")
        .style("text-anchor", "end")
        .style("font-size", "8px")
        .attr("dx", "-.1em")
        .attr("dy", "-.1em")
        .attr("transform", function(d) { return "rotate(-35)" });

     svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.Quarter); })
        .attr("width", x.rangeBand())
        .attr("y", function(d) { return y(d.Count); })
        .attr("height", function(d) { return height - y(d.Count); })
         .on("mousemove", function(d){
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Quarter +"<br/>"+"Amount: " + commaFormat(d.Count)+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });



svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Quarter)+20; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .style("font-weight","bold")
  .text(function(d) { return (dollarFormatterK(d.Count)); });





  });

 function dollarFormatterK(n) {
  n = Math.round(n);
  var result = n;
  if (Math.abs(n) > 100000) {
    result = Math.round(n/100000)+'L';
  }
  return result;
}
  

}
