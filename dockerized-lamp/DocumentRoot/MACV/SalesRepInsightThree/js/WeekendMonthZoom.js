$( document ).ready(function() {
if(ClickFlagV==2)
     {
     	WeekendMonthZoom();
      document.getElementById('SPV2').disabled = true;
    }
    else
         {
          
          $('#SPV2').click(function(d){
          WeekendMonthZoom();
              
             });  
          }

});

function WeekendMonthZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,POSType){
 var msg = document.getElementById("DESTROY").value;

 var margin = {top: 40, right: 20, bottom: 30, left: 20},
      width = 1100 - margin.left - margin.right,
      height = 300 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width/2],.2);

    var y = d3.scale.linear()
        .range([80, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis();

   

var div = d3.select("body").append("div").attr("class", "toolTipZoom");
 
$("#WEENDID").html('');

    var svg = d3.select("#WEENDID").append("svg")
        .attr("id","WEENDIDR")
        .attr("width", 880)
        .attr("height", 400)
        .append("g")
        .attr("transform", "translate(" + 130 + "," + 140 + ")");

var links;
//var WEMQZUri=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/WeekendMonth.php");  


if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
    catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined){

          links=(WEMQZUri+"?param="+msg);

          console.log(links);
        }


    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?zoneparam="+zone);
    //d3.select("#WDMR").remove();
  }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state && city === undefined  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?Stateparam="+state);
    //d3.select("#WDMR").remove();
    }

     else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city  && sourceSite === undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?Cityparam="+city);
   //d3.select("#WDMR").remove();

    }

  else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?Siteparam="+sourceSite);
    //d3.select("#WDMR").remove();

    }

 

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?ProNameparam="+promoname);
      //d3.select("#WDMR").remove();
  }

 else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?categoryparam="+catgory);
      //d3.select("#WDMR").remove();

    }

else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp && yesno=== undefined && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?EmpIdparam="+emp);
      //d3.select("#WDMR").remove();

    }

    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno && subcat=== undefined && POSType=== undefined)
    {

      links=(WEMQZUri+"?YesNoparam="+yesno);

          //d3.select("#WDMR").remove();

    }
    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat && POSType=== undefined)
    {

      links=(WEMQZUri+"?SubCatparam="+subcat);

     //d3.select("#WDMR").remove();

    }
    else if(startDate === undefined && endDate === undefined  && zone === undefined && state  === undefined && city === undefined  && sourceSite=== undefined && promoname=== undefined && 
      catgory=== undefined && emp=== undefined && yesno=== undefined && subcat=== undefined && POSType)
    {

      links=(WEMQZUri+"?POSTypeparam="+POSType);

     //console.log("dddddddddddddddddddddddd",links)
     //d3.select("#WDMR").remove();

    }
 else
    {
       links=encodeURI(WEMQZUri+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          //d3.select("#WDMR").remove();
    } 




/*
 if (startDate=== undefined && endDate === undefined){
      links=(WEMQZUri+"?param=");
        }
  else
    {
       links=encodeURI(WEMQZUri+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#WEMR").remove();
    }
   */ 
  d3.json(links, function(data) {
    
   var fmt = d3.time.format.utc("%b-%Y").parse;

  var fmt1 = d3.time.format.utc("%b-%Y");

  var datefmt = d3.time.format("%d-%b-%y");

    data.forEach(function(d) {
        d.Month = fmt(d.Month);
        d.Quantity = +d.Quantity;


       });

     

data.sort(sortByDateAscending);

  function sortByDateAscending(a,b){
  return new Date(a.Month)-new Date(b.Month);
  }

data.forEach(function(d) {
        d.Month = fmt1(d.Month);
        d.Quantity = +d.Quantity;


       });


//======end========

//console.log(JSON.stringify(data));
    
     x.domain(data.map(function(d) { return d.Month;}));
     y.domain([0, d3.max(data, function(d) {return d.Quantity; })]);

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
        .attr("x", function(d) { return x(d.Month); })
        .attr("width", x.rangeBand())
        .attr("y", function(d) { return y(d.Quantity); })
        .attr("height", function(d) { return (height/2 - y(d.Quantity)); })
        .on("mousemove", function(d){
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Month: " +d.Month +"<br/>"+"QTY: " +d.Quantity+"</span>");           
          })
      .on("mouseout", function(d){
              div.style("display", "none");
          });



svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Month)+10; })
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
