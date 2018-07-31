$( document ).ready(function() {
	
    WeekendComparedZoom();
});

function WeekendComparedZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,POSType){

 var msg = document.getElementById("DESTROY").value;
var margin = {top: 40, right:70, bottom:40, left: 20},
        width = 600 - margin.left - margin.right,
        height = 300 - margin.top - margin.bottom;




var x0 = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var x1 = d3.scale.ordinal();

var y = d3.scale.linear()
    .range([height, 0]);

var color = d3.scale.ordinal()
    .range(["#DFF5F7", "#1E90FF"]);



var xAxis = d3.svg.axis()
    .scale(x0)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(d3.format(".2s"));

var divTooltip = d3.select("body").append("div").attr("class", "toolTipZoom");


var svg = d3.select("#WeekendZom").append("svg")
     .attr("id","WeekendDayComZoR")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.bottom + "," + margin.top + ")");

var dataset=[];

var links;
var link1;


//var WEMUZoomri1=encodeURI("http://localhost/MACV/SalesRepInsightThree/data/WeekendPos18.php"); 

//var WEMUZoomri11=encodeURI("http://localhost/MACV/SalesRepInsightThree/data/WeekendMonth.php"); 


if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
    catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined){

          links=(WEMUZoomri1+"?param="+msg);

          link1=(WEMUZoomri11+"?param="+msg);


          //console.log(links);
        }


    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?zoneparam="+zone);

      link1=(WEMUZoomri11+"?zoneparam="+zone);

     // console.log("zone",links);
      //console.log("zone1",link1);

      d3.select("#WeekendDayComZoR").remove();

  }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state && city === undefined  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?Stateparam="+state);
      link1=(WEMUZoomri11+"?Stateparam="+state);



    d3.select("#WeekendDayComZoR").remove();
    }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?Cityparam="+city);
      link1=(WEMUZoomri11+"?Cityparam="+city);

   d3.select("#WeekendDayComZoR").remove();

    }

  else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?Siteparam="+sourceSite);
      link1=(WEMUZoomri11+"?Siteparam="+sourceSite);

     d3.select("#WeekendDayComZoR").remove();

    }

 

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?ProNameparam="+promoname);
      link1=(WEMUZoomri11+"?ProNameparam="+promoname);

     d3.select("#WeekendDayComZoR").remove();
  }

 else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?categoryparam="+catgory);
      link1=(WEMUZoomri11+"?categoryparam="+catgory);

      d3.select("#WeekendDayComZoR").remove();

    }

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?EmpIdparam="+emp);
      link1=(WEMUZoomri11+"?EmpIdparam="+emp);

	d3.select("#WeekendDayComZoR").remove();

    }

    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?YesNoparam="+yesno);
      link1=(WEMUZoomri11+"?YesNoparam="+yesno);
    
          d3.select("#WeekendDayComZoR").remove();
        
        }

    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat && POSType=== undefined)
    {

      links=(WEMUZoomri1+"?SubCatparam="+subcat);
      link1=(WEMUZoomri11+"?SubCatparam="+subcat);


     d3.select("#WeekendDayComZoR").remove();

    }
    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType)
    {

      links=(WEMUZoomri1+"?POSTypeparam="+POSType);
      link1=(WEMUZoomri11+"?POSTypeparam="+POSType);


     //console.log("dddddddddddddddddddddddd",links)
    		d3.select("#WeekendDayComZoR").remove();

    }



    else
    {
       links=encodeURI(WEMUZoomri1+"?startDate="+startDate+"&endDate="+endDate);
      links1=encodeURI(WEMUZoomri11+"?startDate="+startDate+"&endDate="+endDate);

	d3.select("#WeekendDayComZoR").remove();

    } 

  d3.json(links, function(data1) {
  d3.json(link1, function(data2) {

  data1.forEach(function (d) {
   data2.forEach(function (e){
       if(d.Month==e.Month){
             dataset.push({
                  label:d.Month,
                  Year_2018:d.Quantity,
                  Year_2017:e.Quantity,
             
                 });
              }
         });
    });

  //Sort Month

allMonths = ['Jan','Feb','Mar', 'Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

dataset.sort(function(a,b){
    return allMonths.indexOf(a.label) - allMonths.indexOf(b.label);
    })

var options = d3.keys(dataset[0]).filter(function(key) { return key !== "label"; });

dataset.forEach(function(d) {
    d.valores = options.map(function(name) { 

      return {name: name, value: +d[name]}; });
});

x0.domain(dataset.map(function(d) { return d.label; }));
x1.domain(options).rangeRoundBands([0, x0.rangeBand()]);
y.domain([0, d3.max(dataset, function(d) { return d3.max(d.valores, function(d) { return d.value; }); })]);

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

var bar = svg.selectAll(".bar")
    .data(dataset)
    .enter().append("g")
    .attr("class", "rect")
    .attr("transform", function(d) { return "translate(" + x0(d.label) + ",0)"; });

bar.selectAll("rect")
    .data(function(d) { return d.valores; })
    .enter().append("rect")
    .attr("width", x1.rangeBand())
    .attr("x", function(d) { return x1(d.name); })
    .attr("y", function(d) { return y(d.value); })
    .attr("value", function(d){return d.name;})
    .attr("height", function(d) { return height - y(d.value); })
    .style("fill", function(d) { return color(d.name); });

bar
    .on("mousemove", function(d){
        divTooltip.style("left", d3.event.pageX+10+"px");
        divTooltip.style("top", d3.event.pageY-25+"px");
        divTooltip.style("display", "inline-block");
        var x = d3.event.pageX, y = d3.event.pageY
        var elements = document.querySelectorAll(':hover');
        l = elements.length
        l = l-1
        elementData = elements[l].__data__
        divTooltip.html((" Bill Date Month"+" : "+d.label)+"<br>"+elementData.name+"<br>"+"Quantity"+" : "+elementData.value);
    });
bar
    .on("mouseout", function(d){
        divTooltip.style("display", "none");
    });


    bar.selectAll("text")
  .data(function(d) { 
    return d.valores; })
      .enter().append("text")
      .attr("class","barstext")
      .attr("x", function(d) { return x1(d.name)+10; })
      .attr("y",function(d) { return y(d.value)-10; })
      .style("fill","white")
      .style("font-weight","bold")
      .style("font-size", "10px")
      .text(function(d){return dollarFormatterK (d.value);})


    var rectangle =svg.append("rect").attr("x", 240).attr("y", -20).attr("width", 10).attr("height", 10).style("fill","#DFF5F7");
    var rectangle2 =svg.append("rect").attr("x", 290).attr("y", -20).attr("width", 10).attr("height", 10).style("fill","#1E90FF");
    svg.append("text").style("fill", "black").attr("x", 260).attr("y", -13).attr("class", "textsize1").style("fill","#fff").text("2018");  
    svg.append("text").style("fill", "black").attr("x", 310).attr("y", -13).attr("class", "textsize1").style("fill","#fff").text("2017");
    svg.append("text").style("fill", "black").attr("x", 210).attr("y", -13).attr("class", "textsize1").style("fill","#fff").text("Year");


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
