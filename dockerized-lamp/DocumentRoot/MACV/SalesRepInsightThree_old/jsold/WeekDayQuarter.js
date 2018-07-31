$( document ).ready(function() {


  if(ClickFlag==0)
     {

      $('#SPV3').click(function(){
        
        document.getElementById('SPV3').disabled = true;
        document.getElementById('SPV4').disabled = false;
        document.getElementById('WeekDayten').style.visibility = 'hidden';
        WeekDayQuarter();

               }); 

       $('#SPV4').click(function(d){
       $("#WDM").html('');
        WeekDayMonth();
        document.getElementById('SPV4').disabled = true;
        document.getElementById('SPV3').disabled = false;
        document.getElementById('WeekDayten').style.visibility = 'visible';
             });   
      
    }

    else
    {

    }

});

function WeekDayQuarter(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,POSType){

  console.log("dddddffffffffffffffffffffffffffffffffff",startDate,endDate,zone)
var msg = document.getElementById("DESTROY").value;

 var margin = {top: 40, right: 20, bottom: 30, left: 20},
      width = 900 - margin.left - margin.right,
      height = 300 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width/2],.2);

    var y = d3.scale.linear()
        .range([80, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis();

   

var div = d3.select("body").append("div").attr("class", "toolTip");

$("#WDM").html('');
    var svg = d3.select("#WDM").append("svg")
       // .attr("id","WDMRR")
       .attr("width", 480)
        .attr("height", 220)
        .append("g")
        .attr("transform", "translate(" + 40 + "," + 40 + ")");


  var links;


//var WEMQUri=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/WeekDayQuarter.php");  


 
if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
    catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined){

          links=(WEMQUri+"?param="+msg);

        }


    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?zoneparam="+zone);
//  console.log(links);
    d3.select("#WDMR").remove();
  }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state && city === undefined  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?Stateparam="+state);
    d3.select("#WDMR").remove();
    }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?Cityparam="+city);
   d3.select("#WDMR").remove();

    }

  else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?Siteparam="+sourceSite);
    d3.select("#WDMR").remove();

    }

 

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?ProNameparam="+promoname);
      d3.select("#WDMR").remove();
  }

 else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?categoryparam="+catgory);
      d3.select("#WDMR").remove();

    }

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?EmpIdparam="+emp);
      d3.select("#WDMR").remove();

    }

    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQUri+"?YesNoparam="+yesno);

          d3.select("#WDMR").remove();

    }
    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat && POSType=== undefined)
    {

      links=(WEMQUri+"?SubCatparam="+subcat);

     d3.select("#WDMR").remove();

    }
    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType)
    {

      links=(WEMQUri+"?POSTypeparam="+POSType);

     //console.log("dddddddddddddddddddddddd",links)
     d3.select("#WDMR").remove();

    }



    else
    {
       links=encodeURI(WEMQUri+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#WDMR").remove();
    }

/*
  if (startDate=== undefined && endDate === undefined){

          links=(WEMQUri+"?param=");
        }
  else
    {
       links=encodeURI(WEMQUri+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#WEMR").remove();
    }*/
    
  d3.json(links, function(data) {

    data.forEach(function(d){
       d.Quarter=d.Quarter;
      d.Quantity =d.Quantity

    });

     //Sort Quarter
data.sort(function(a, b){
    if(a.Quarter < b.Quarter) return -1;
    if(a.Quarter > b.Quarter) return 1;
    return 0;
});

//======end========

 

//console.log(JSON.stringify(data));

var staticMax=10000;
    
     x.domain(data.map(function(d) { return d.Quarter;}));
     //y.domain([0, d3.max(data, function(d) {return d.Quantity; })]);

  y.domain([0, d3.max(data, function (d) { return d.Quantity > staticMax ? d.Quantity : staticMax; }) ]);

    
    
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
        .attr("transform", "translate(0," + 120 + ")")
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
        .attr("x", function(d) { return x(d.Quarter); })
        .attr("width", x.rangeBand())
        .attr("y", function(d) { return y(d.Quantity); })
        .attr("height", function(d) { return (height/2 - y(d.Quantity)); })
        .on("mousemove", function(d){
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Bill Date Quarter: " +d.Quarter +"<br/>"+"QTY: " +d.Quantity+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });



svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Quarter)+30; })
  .attr("y", function(d) { return y(d.Quantity)-10; })
  .style("fill","white")
  .style("font-weight","bold")
  .style("font-size", "10px")
  .text(function(d) { return (dollarFormatterK(d.Quantity)); });



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
