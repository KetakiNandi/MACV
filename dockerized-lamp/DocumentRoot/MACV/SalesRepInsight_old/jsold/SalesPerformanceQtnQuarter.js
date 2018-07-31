$( document ).ready(function() {

	if(ClickFlag==0)
     {
      $('#SPQ1').click(function(){
          
              document.getElementById('SPQ1').disabled = true;
              document.getElementById('SPQ2').disabled = false;
		document.getElementById('CDFZ11').style.visibility = 'hidden';
              SalesPerformanceQtnQuarter();
             
               }); 

               $('#SPQ2').click(function(d){
                $("#SPQ").html('');
                render_avgsession();
                document.getElementById('SPQ2').disabled = true;
                document.getElementById('SPQ1').disabled = false;
	        document.getElementById('CDFZ11').style.visibility = 'visible';
             });   
      
    }
    else
         {

            

          }
	

});

function SalesPerformanceQtnQuarter(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

	//console.log("SalesPerformanceQtnQuarter")
var msg = document.getElementById("DESTROY").value;
    var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width =400- margin.left - margin.right,
      height = 150 - margin.top - margin.bottom

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width/3], .1);

    var y = d3.scale.linear()
        .range([height/2, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
       .orient("bottom");

    var yAxis = d3.svg.axis();
   
  var div = d3.select("body").append("div").attr("class", "toolTip");

  $("#SPQ").html('');
  
  var svg = d3.select("#SPQ").append("svg")
        .attr("id","SPQQR")
        .attr("width", 250)
        .attr("height", 200)
        .append("g")
        .attr("transform", "translate(" + 80 + "," + 50 + ")");


//var SPQQ=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SalesPerformanceQtnQuarter.php"); 

    if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined){

          links=(SPQQ+"?param="+msg);
        }
    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?zoneparam="+zone);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (state) && zone === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?Stateparam="+state);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (city) && zone === undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?Cityparam="+city);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (sourceSite) && zone === undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?Siteparam="+sourceSite);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (promoname) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?ProNameparam="+promoname);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (catgory) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?categoryparam="+catgory);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (emp) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?EmpIdparam="+emp);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (yesno) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?YesNoparam="+yesno);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (subcat) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?SubCatparam="+subcat);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (itemcode) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=encodeURI(SPQQ+"?itemcodeparam="+itemcode);
         // console.log(links);
          d3.select("#ASU").remove();
    }
    else if(startDate === undefined && endDate === undefined && (POSType) && zone === undefined && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=encodeURI(SPQQ+"?POSTypeparam="+POSType);
          //console.log(links);
          d3.select("#ASU").remove();
    }
        else{
          links=encodeURI(SPQQ+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#ASU").remove();
        }   
  var fmt = d3.time.format.utc("%d-%b-%Y").parse;

  var fmt1 = d3.time.format.utc("%b-%Y");

  var datefmt = d3.time.format("%d-%b-%y");

 d3.json(links, function(data) {

 // console.log(JSON.stringify(data));

     data.forEach(function(d) {
        d.Quarter = (d.Quarter);
        d.Count = +d.Quantity;
        //d.dateperDay = fmt(d.dateperDay);

       });

    // console.log(JSON.stringify(data));
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
        .attr("y", function(d) { return y(d.Count); })
        .attr("height", function(d) { return height - y(d.Count); })
        .on("mousemove", function(d){
              div.style("left", d3.event.pageX+10+"px");
              div.style("top", d3.event.pageY-25+"px");
              div.style("display", "inline-block");
              div.html("<span style='color:#ffffff'>" +"Bill Date Month: " +d.Quarter +"<br/>"+"QTY: " +d.Count+"</span>");           
          })
        .on("mouseout", function(d){
              div.style("display", "none");
          })
        .on("click", function(d){
      
       // var date1 = new Date(d.Month);
       // var firstDay = new Date(date1.getFullYear(), date1.getMonth(), 1);
       // var lastDay = new Date(date1.getFullYear(), date1.getMonth() + 1, 0);
        //console.log("111",datefmt(firstDay));
        //console.log("222",datefmt(lastDay));
        if(d.Quarter=="Qtr1")
        {
          if(ClickFlagV=="2")
         {
            SalesPerformanceValue("01-Jan-17","31-Mar-17");
            SalesPerformanceValueZoom("01-Jan-17","31-Mar-17");

            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter("01-Jan-17","31-Mar-17");}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter("01-Jan-17","31-Mar-17");
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue("01-Jan-17","31-Mar-17");
              SalesPerformanceValueZoom("01-Jan-17","31-Mar-17");
              
               });  
         }
          SalesPerformanceValue("01-Jan-17","31-Mar-17");
          //render_avgSoldPerDay("01-Jan-17","31-Mar-17");
          CategorywisePerformanceQuantity("01-Jan-17","31-Mar-17");
          SubCategorywisePerformanceQuantity("01-Jan-17","31-Mar-17");
          CustomerDetailsFilled("01-Jan-17","31-Mar-17");
	   CategorywisePerformanceQuantityZoom("01-Jan-17","31-Mar-17");
          SubCategorywisePerformanceQuantityZoom("01-Jan-17","31-Mar-17");
          CustomerDetailsFilledZoom("01-Jan-17","31-Mar-17");
         // render_Tachievement("01-Jan-17","31-Mar-17");
         // SalesPersonWiseContributionQuantity("01-Jan-17","31-Mar-17");
          //SalesPersonWiseContributionValue("01-Jan-17","31-Mar-17");
          //PoSperformance("01-Jan-17","31-Mar-17");
          //SalesPersonWiseUpsellingQnt("01-Jan-17","31-Mar-17");
        }
        else if(d.Quarter=="Qtr2")
        {
          if(ClickFlagV=="2")
         {
            SalesPerformanceValue("01-Apr-17","30-Jun-17");
            SalesPerformanceValueZoom("01-Apr-17","30-Jun-17");

            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter("01-Apr-17","30-Jun-17");}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter("01-Apr-17","30-Jun-17");
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue("01-Apr-17","30-Jun-17");
              SalesPerformanceValueZoom("01-Apr-17","30-Jun-17");
              
               });  
         }
          SalesPerformanceValue("01-Apr-17","30-Jun-17");
          //render_avgSoldPerDay("01-Apr-17","30-Jun-17");
          CategorywisePerformanceQuantity("01-Apr-17","30-Jun-17");
          SubCategorywisePerformanceQuantity("01-Apr-17","30-Jun-17");
          CustomerDetailsFilled("01-Apr-17","30-Jun-17");
	  CategorywisePerformanceQuantityZoom("01-Apr-17","30-Jun-17");
          SubCategorywisePerformanceQuantityZoom("01-Apr-17","30-Jun-17");
          CustomerDetailsFilledZoom("01-Apr-17","30-Jun-17");
         // render_Tachievement("01-Apr-17","30-Jun-17");
          //SalesPersonWiseContributionQuantity("01-Apr-17","30-Jun-17");
          //SalesPersonWiseContributionValue("01-Apr-17","30-Jun-17");
          //PoSperformance("01-Apr-17","30-Jun-17");
         // SalesPersonWiseUpsellingQnt("01-Apr-17","30-Jun-17");
         }
         else if(d.Quarter=="Qtr3")
        {
          if(ClickFlagV=="2")
         {
            SalesPerformanceValue("01-Jul-17","30-Sep-17");
            SalesPerformanceValueZoom("01-Jul-17","30-Sep-17");

            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter("01-Jul-17","30-Sep-17");}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter("01-Jul-17","30-Sep-17");
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue("01-Jul-17","30-Sep-17");
              SalesPerformanceValueZoom("01-Jul-17","30-Sep-17");
              
               });  
         }
          SalesPerformanceValue("01-Jul-17","30-Sep-17");
          //render_avgSoldPerDay("01-Jul-17","30-Sep-17");
          CategorywisePerformanceQuantity("01-Jul-17","30-Sep-17");
          SubCategorywisePerformanceQuantity("01-Jul-17","30-Sep-17");
          CustomerDetailsFilled("01-Jul-17","30-Sep-17");
	  CategorywisePerformanceQuantityZoom("01-Jul-17","30-Sep-17");
          SubCategorywisePerformanceQuantityZoom("01-Jul-17","30-Sep-17");
          CustomerDetailsFilledZoom("01-Jul-17","30-Sep-17");

          //render_Tachievement("01-Jul-17","30-Sep-17");
          //SalesPersonWiseContributionQuantity("01-Jul-17","30-Sep-17");
          //SalesPersonWiseContributionValue("01-Jul-17","30-Sep-17");
          //PoSperformance("01-Jul-17","30-Sep-17");
          //SalesPersonWiseUpsellingQnt("01-Jul-17","30-Sep-17");
        }
        else if(d.Quarter=="Qtr4")
        {
          if(ClickFlagV=="2")
         {
            SalesPerformanceValue("01-Oct-17","31-Dec-17");
            SalesPerformanceValueZoom("01-Oct-17","31-Dec-17");

            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter("01-Oct-17","31-Dec-17");}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter("01-Oct-17","31-Dec-17");
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue("01-Oct-17","31-Dec-17");
              SalesPerformanceValueZoom("01-Oct-17","31-Dec-17");
              
               });  
         }
          SalesPerformanceValue("01-Oct-17","31-Dec-17");
          //render_avgSoldPerDay("01-Oct-17","31-Dec-17");
          CategorywisePerformanceQuantity("01-Oct-17","31-Dec-17");
          SubCategorywisePerformanceQuantity("01-Oct-17","31-Dec-17");
          CustomerDetailsFilled("01-Oct-17","31-Dec-17");
	   CategorywisePerformanceQuantityZoom("01-Oct-17","31-Dec-17");
          SubCategorywisePerformanceQuantityZoom("01-Oct-17","31-Dec-17");
          CustomerDetailsFilledZoom("01-Oct-17","31-Dec-17");
          //render_Tachievement("01-Oct-17","31-Dec-17");
          //SalesPersonWiseContributionQuantity("01-Oct-17","31-Dec-17");
          //SalesPersonWiseContributionValue("01-Oct-17","31-Dec-17");
         // PoSperformance("01-Oct-17","31-Dec-17");
          //SalesPersonWiseUpsellingQnt("01-Oct-17","31-Dec-17");
        }
  });
        

svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Quarter)+20; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .style("font-size", "10px")
  .style("font-weight", "bold")
  .text(function(d) { return (dollarFormatterK(d.Count)); });

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
