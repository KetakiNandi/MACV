$( document ).ready(function() { 

	if(ClickFlagV==2)
     {
      $('#SPV1').click(function(){
          
              document.getElementById('SPV1').disabled = true;
              document.getElementById('SPV2').disabled = false;
	      document.getElementById('SPVZ11').style.visibility = 'hidden';
              SalesPerformanceValueQuarter();
             
               }); 

               $('#SPV2').click(function(d){
                $("#SPV").html('');
                SalesPerformanceValue();
                document.getElementById('SPV2').disabled = true;
                document.getElementById('SPV1').disabled = false;
		document.getElementById('SPVZ11').style.visibility = 'visible';
             });   
      
    }
    else
         {

            

          }

});

function SalesPerformanceValueQuarter(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

//  console.log("ssssssssssssssss",POSType)
var msg = document.getElementById("DESTROY").value;
    var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width =300- margin.left - margin.right,
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

  $("#SPV").html('');
  
  var svg = d3.select("#SPV").append("svg")
        .attr("id","SPVQR")
        .attr("width", 300)
        .attr("height", 200)
        .append("g")
        .attr("transform", "translate(" + 80 + "," + 70 + ")");
    

 //var SPVQ=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SalesPerformanceValueQuarter.php");

 if (startDate === undefined && endDate === undefined && zone === undefined && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

          links=(SPVQ+"?param="+msg);
          //console.log("333",links1);
        }
    else if(startDate === undefined && endDate === undefined && zone && state === undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=(SPVQ+"?zoneparam="+zone);
         // console.log("111",links1);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && state && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?Stateparam="+state);
          //console.log("222",links1);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && city && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?Cityparam="+city);
          d3.select("#SPVR").remove();
    }
     else if(startDate === undefined && endDate === undefined && zone === undefined && sourceSite && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?Siteparam="+sourceSite);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && promoname && state === undefined && city===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?ProNameparam="+promoname);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && catgory && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?categoryparam="+catgory);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && emp && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?EmpIdparam="+emp);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && yesno && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?YesNoparam="+yesno);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && subcat && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?SubCatparam="+subcat);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
    else if(startDate === undefined && endDate === undefined && zone === undefined && itemcode && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
          links=encodeURI(SPVQ+"?itemcodeparam="+itemcode);
         // console.log(links);
          d3.select("#SPVR").remove();
    }
     else if(startDate === undefined && endDate === undefined && zone === undefined && POSType && state === undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
          links=encodeURI(SPVQ+"?POSTypeparam="+POSType);
          //console.log(links);
          d3.select("#SPVR").remove();
    }
        else{
          links=encodeURI(SPVQ+"?startDate="+startDate+"&endDate="+endDate);
          //console.log(links);
          d3.select("#SPVR").remove();
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
        .style("font-size", "10px")
	.style("font-weight", "bold")
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
          })
      .on("click", function(d){
       // var date1 = new Date(d.Month);
       // var firstDay = new Date(date1.getFullYear(), date1.getMonth(), 1);
       // var lastDay = new Date(date1.getFullYear(), date1.getMonth() + 1, 0);
        //console.log("111",datefmt(firstDay));
        //console.log("222",datefmt(lastDay));
        //SalesPerformanceValue(startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
        //render_avgsession(datefmt(firstDay),datefmt(lastDay));
         if(d.Quarter=="Qtr1")
         {
//            render_avgSoldPerDay("01-Jan-17","31-Mar-17");
            CategorywisePerformanceQuantity("01-Jan-17","31-Mar-17");
            SubCategorywisePerformanceQuantity("01-Jan-17","31-Mar-17");
            CustomerDetailsFilled("01-Jan-17","31-Mar-17");
	     CategorywisePerformanceQuantityZoom("01-Jan-17","31-Mar-17");
            SubCategorywisePerformanceQuantityZoom("01-Jan-17","31-Mar-17");
            CustomerDetailsFilledZoom("01-Jan-17","31-Mar-17");
  //          render_Tachievement("01-Jan-17","31-Mar-17");
    //        SalesPersonWiseContributionQuantity("01-Jan-17","31-Mar-17");
      //      SalesPersonWiseContributionValue("01-Jan-17","31-Mar-17");
        //    PoSperformance("01-Jan-17","31-Mar-17");
          //  SalesPersonWiseUpsellingQnt("01-Jan-17","31-Mar-17");

             if(ClickFlag=="0")
         {
            render_avgsession("01-Jan-17","31-Mar-17");
	    render_avgsessionZoom("01-Jan-17","31-Mar-17");
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter("01-Jan-17","31-Mar-17");}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter("01-Jan-17","31-Mar-17");
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession("01-Jan-17","31-Mar-17");
	      render_avgsessionZoom("01-Jan-17","31-Mar-17");
              
               }); 
       }
         }
         else if(d.Quarter=="Qtr2")
         {

         // render_avgSoldPerDay("01-Apr-17","30-Jun-17");
            CategorywisePerformanceQuantity("01-Apr-17","30-Jun-17");
            SubCategorywisePerformanceQuantity("01-Apr-17","30-Jun-17");
            CustomerDetailsFilled("01-Apr-17","30-Jun-17");
	     CategorywisePerformanceQuantityZoom("01-Apr-17","30-Jun-17");
            SubCategorywisePerformanceQuantityZoom("01-Apr-17","30-Jun-17");
            CustomerDetailsFilledZoom("01-Apr-17","30-Jun-17");

           // render_Tachievement("01-Apr-17","30-Jun-17");
           // SalesPersonWiseContributionQuantity("01-Apr-17","30-Jun-17");
           // SalesPersonWiseContributionValue("01-Apr-17","30-Jun-17");
           // PoSperformance("01-Apr-17","30-Jun-17");
           // SalesPersonWiseUpsellingQnt("01-Apr-17","30-Jun-17");

             if(ClickFlag=="0")
         {
            render_avgsession("01-Apr-17","30-Jun-17");
	    render_avgsessionZoom("01-Apr-17","30-Jun-17");
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter("01-Apr-17","30-Jun-17");}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter("01-Apr-17","30-Jun-17");
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession("01-Apr-17","30-Jun-17");
	      render_avgsessionZoom("01-Apr-17","30-Jun-17");
              
               }); 
       }


         }
         else if(d.Quarter=="Qtr3")
         {

         // render_avgSoldPerDay("01-Jul-17","30-Sep-17");
            CategorywisePerformanceQuantity("01-Jul-17","30-Sep-17");
            SubCategorywisePerformanceQuantity("01-Jul-17","30-Sep-17");
            CustomerDetailsFilled("01-Jul-17","30-Sep-17");
	    CategorywisePerformanceQuantityZoom("01-Jul-17","30-Sep-17");
            SubCategorywisePerformanceQuantityZoom("01-Jul-17","30-Sep-17");
            CustomerDetailsFilledZoom("01-Jul-17","30-Sep-17");
           // render_Tachievement("01-Jul-17","30-Sep-17");
           // SalesPersonWiseContributionQuantity("01-Jul-17","30-Sep-17");
          //  SalesPersonWiseContributionValue("01-Jul-17","30-Sep-17");
          //  PoSperformance("01-Jul-17","30-Sep-17");
          //  SalesPersonWiseUpsellingQnt("01-Jul-17","30-Sep-17");

              if(ClickFlag=="0")
         {
            render_avgsession("01-Jul-17","30-Sep-17");
	    render_avgsessionZoom("01-Jul-17","30-Sep-17");
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter("01-Jul-17","30-Sep-17");}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter("01-Jul-17","30-Sep-17");
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession("01-Jul-17","30-Sep-17");
	      render_avgsessionZoom("01-Jul-17","30-Sep-17");
              
               }); 
       }
         }
         else if(d.Quarter=="Qtr4")
         {

           // render_avgSoldPerDay("01-Oct-17","31-Dec-17");
            CategorywisePerformanceQuantity("01-Oct-17","31-Dec-17");
            SubCategorywisePerformanceQuantity("01-Oct-17","31-Dec-17");
            CustomerDetailsFilled("01-Oct-17","31-Dec-17");
	     CategorywisePerformanceQuantityZoom("01-Oct-17","31-Dec-17");
            SubCategorywisePerformanceQuantityZoom("01-Oct-17","31-Dec-17");
            CustomerDetailsFilledZoom("01-Oct-17","31-Dec-17");
           // render_Tachievement("01-Oct-17","31-Dec-17");
           // SalesPersonWiseContributionQuantity("01-Oct-17","31-Dec-17");
           // SalesPersonWiseContributionValue("01-Oct-17","31-Dec-17");
           // PoSperformance("01-Oct-17","31-Dec-17");
           // SalesPersonWiseUpsellingQnt("01-Oct-17","31-Dec-17");

            if(ClickFlag=="0")
         {
            render_avgsession("01-Oct-17","31-Dec-17");
	    render_avgsessionZoom("01-Oct-17","31-Dec-17");
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter("01-Oct-17","31-Dec-17");}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter("01-Oct-17","31-Dec-17");
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession("01-Oct-17","31-Dec-17");
              render_avgsessionZoom("01-Oct-17","31-Dec-17");
               }); 
       }
         }
  });



svg.selectAll("text.bar")
  .data(data)
  .enter().append("text")
  .attr("text-anchor", "middle")
  .attr("x", function(d) { return x(d.Quarter)+10; })
  .attr("y", function(d) { return y(d.Count)-10; })
  .style("fill","white")
  .style("font-weight","bold")
  .style("font-size", "10px")
  .text(function(d) { return (dollarFormatterK(d.Count)); });





  });

 function dollarFormatterK(n) {
  n = Math.round(n);
  var result = n;
  if (Math.abs(n) > 100000) {
    result = Math.round(n/100000)+'L';
  }
else if(Math.abs(n) < 99999 || Math.abs(n)>999)
{
 result = Math.round(n/1000)+'K';

}

  return result;
}
  

}
