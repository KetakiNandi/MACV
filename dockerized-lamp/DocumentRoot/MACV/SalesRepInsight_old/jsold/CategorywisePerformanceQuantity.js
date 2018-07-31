$( document ).ready(function() {
  CategorywisePerformanceQuantity();
});

function remove(property, num, arr) {
    for (var i in arr) {
        if (arr[i][property] == num)
            arr.splice(i, 1);
    }
}

function CategorywisePerformanceQuantity(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){
        //console.log("1111",itemcode );
var msg = document.getElementById("DESTROY").value;
        var colorRange = d3.scale.category20();
        var color = d3.scale.ordinal().range(colorRange.range());
        var width = 410,
             height =400,
             radius=160;

        var arc = d3.svg.arc().outerRadius(radius - 100).innerRadius(radius - 50);
        var outerArc = d3.svg.arc().innerRadius(radius - 60).outerRadius(radius - 60);

        var svg = d3.select("#NZEI").append("svg")
        .attr("id","NZEIR")
        .attr("width", width)
        .attr("height", 300)
        .append("g")
        .attr("transform", "translate(" + 240 + "," + 180 + ")");

        svg.append("g").attr("class", "slices");
        svg.append("g").attr("class", "labelName");
        svg.append("g").attr("class", "lines");

        var div = d3.select("body").append("div").attr("class", "toolTip");

        var links;
        var allRevenue=0;

        var city;
      var EmpID;
      var Division;
      var state;
      var SourceSite;
      var prname;
      var Zone;

        
        var pie = d3.layout.pie().value(function(d) { 
        return d.Revenue; });

        var otherEmpState="";
        var otherEmpStateRevenue=0;
        var links;

//var CWPQ=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/CategorywisePerformanceQuantity.php");

if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory=== undefined && promoname=== undefined  && yesno === undefined && (startDate && endDate) && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
    links=encodeURI(CWPQ+"?startDate="+startDate+"&endDate="+endDate);
    // console.log(links);
      d3.select("#NZEIR").remove();
   }

else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

    links=(CWPQ+"?param="+msg);

      }
else if((zone) && state === undefined && city === undefined && emp === undefined && sourceSite === undefined && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(CWPQ+"?zoneparam="+zone);
	//console.log("ZONE",links);
      d3.select("#NZEIR").remove();
    }

else if(zone === undefined && state  && city === undefined && emp === undefined && sourceSite === undefined && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {

    links=(CWPQ+"?Stateparam="+state);
   // console.log("city",links)
    
    d3.select("#NZEIR").remove();
  }

else if(zone === undefined && state === undefined && city && emp === undefined && sourceSite === undefined && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {

    links=(CWPQ+"?Cityparam="+city);
      d3.select("#NZEIR").remove();

    //console.log("city",links)
}

else if(zone === undefined && state === undefined && city === undefined  && emp  && sourceSite === undefined && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
{

  links=(CWPQ+"?EmpIdparam="+emp);
    d3.select("#NZEIR").remove();

  //console.log("ddddd",links);

}

else if(zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite  && promoname===undefined && catgory===undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
{
  links=(CWPQ+"?Siteparam="+sourceSite);

    d3.select("#NZEIR").remove();

}

else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory && promoname === undefined && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
{
links=(CWPQ+"?categoryparam="+catgory);
 // console.log("ddddd",links);
  d3.select("#NZEIR").remove();

//console.log("ddddd",links);
}
  
else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory=== undefined && promoname  && yesno === undefined && startDate=== undefined && endDate=== undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(CWPQ+"?ProNameparam="+promoname);

      d3.select("#NZEIR").remove();
   }

/*
   else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory=== undefined && subcat  && yesno === undefined && startDate=== undefined && endDate=== undefined && promoname===undefined && itemcode===undefined && POSType===undefined)
  {
    links=(CWPQ+"?SubCatparam="+subcat);

      d3.select("#NZEIR").remove();
   }

   else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory=== undefined && itemcode  && yesno === undefined && startDate=== undefined && endDate=== undefined && promoname===undefined && subcat===undefined && POSType===undefined)
  {
    links=(CWPQ+"?itemcodeparam="+itemcode);
    //console.log(links);
      d3.select("#NZEIR").remove();
   }
   else if (zone === undefined && state === undefined && city === undefined  && emp === undefined && sourceSite === undefined && catgory=== undefined && POSType  && yesno === undefined && startDate=== undefined && endDate=== undefined && promoname===undefined && subcat===undefined && itemcode===undefined)
  {
    links=(CWPQ+"?POSTypeparam="+POSType);
    //console.log(links);
      d3.select("#NZEIR").remove();
   }
*/
   else
   {

    links=encodeURI(CWPQ+"?YesNoparam="+yesno);

    //console.log(links);

      d3.select("#NZEIR").remove();

   }
        d3.json(links,function(error,data){

          if(data.length!=0)
          {
            data.forEach(function(d){
            if(d.Category=='All')
                {
                    allRevenue = d.Revenue;
                }
                });
            
        data.forEach(function(d){
            if(d.Category==zone)
            {
                otherEmpStateRevenue =allRevenue - d.Revenue;
                data.push({
                    Category: 'Other EmpStates',
                    Revenue: otherEmpStateRevenue
                });
            }
        });


  var data1 = d3.nest()
    .rollup(function(v) { 
   return {
    total: d3.sum(v, function(d) { return d.Revenue; })};
  }).entries(data);


    remove('Category', 'All', data);

    var desig;
    var emp;
    var startDate;
    var endDate;

    var slice = svg.select(".slices").selectAll("path.slice")
            .data(pie(data), function(d){

     return d.data.Category });

            var Zone;
            var city;
            var EmpID;
            var SourceSite;
            var state;
            var stDate;
            var endDate;
            var zone;
            var promo;

        slice.enter()
            .insert("path")
            .style("fill", function(d) { return color(d.data.Category); })
            .attr("class", "slice");

        slice
            .transition().duration(1000)
            .attrTween("d", function(d) {

                this._current = this._current || d;
                var interpolate = d3.interpolate(this._current, d);
                this._current = interpolate(0);
                return function(t) {
                    return arc(interpolate(t));
                };
            })
        slice
            .on("mousemove", function(d){
                div.style("left", d3.event.pageX+10+"px");
                div.style("top", d3.event.pageY-25+"px");
                div.style("display", "inline-block");
                div.html("Category:"+" "+(d.data.Category)+"<br>"+"QTY:"+d.data.Revenue +"("+((d.data.Revenue)*100/data1.total).toFixed(2)+"%"+")" );
            });
        slice
            .on("mouseout", function(d){
                div.style("display", "none");
            })
        slice.on("click", function(d){
            //console.log("CIRCLE",d.data.EmpState);
            if(d.data.Category == "Other EmpStates")
            {
                return;
            }
            //spzone,Sstate,scity,Semp,SSite,Scate,prname
            Macv_Zone(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_State(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_City(Zone,state,city,EmpID,SourceSite ,d.data.Category);
           Macv_SourceSite(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_Promoname(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_EmpId(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_Category(Zone,state,city,EmpID,SourceSite,d.data.Category);
           Macv_POSType(Zone,state,city,EmpID,SourceSite,d.data.Category);
            //SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
           // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            //CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,this.options[this.selectedIndex].value);
            SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            
	     SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
             if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
             SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
               SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
               });  
         }

         if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
	    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
              render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,d.data.Category);
               }); 
       }

        });

        slice.exit()
            .remove();

    var text = svg.select(".labelName").selectAll("text")
            .data(pie(data), function(d){ return d.data.Category });


           text.enter().append("text")
                .attr("transform", function(d,i){
                var pos = outerArc.centroid(d);
                pos[0] = radius *.50* (midAngle(d) < Math.PI ? 1.1 : -1.1);
        
    
    var percent = (d.endAngle - d.startAngle)/(2*Math.PI)*100
         if(percent<7){
         //console.log(percent)
         pos[1] += i*15
         }
          return "translate("+ pos +")";
        })
        .text(function(d) { return d.data.Category; })
        .attr("fill", function(d,i) { return "White"; })
        //.attr("text-anchor", 'left')
        .attr("font-weight", 'bold')
        .attr("font-size", '10px')
        .attr("dx", function(d){
        var ac = midAngle(d) < Math.PI ? 0:-50
                return ac
        }).attr("dy", 5 )
       
        function midAngle(d){
            return d.startAngle + (d.endAngle - d.startAngle)/2;
        }

        text.exit()
            .remove();

        svg.selectAll("polyline")
              .data(pie(data), function(d) {
                return d.data.Revenue;
              })
              .enter()
              .append("polyline")
              .attr("points", function(d,i) {
                var pos = outerArc.centroid(d);
                    pos[0] = radius * .55 * (midAngle(d) < Math.PI ? 1 : -1);
                 var o=   outerArc.centroid(d)
         var percent = (d.endAngle -d.startAngle)/(2*Math.PI)*100
               if(percent<7){
               //console.log(percent)
               o[1] 
               pos[1] += i*15
               }
                return [arc.centroid(d),[o[0],pos[1]] , pos];
                  }).style("fill", "none")
                  //.attr('stroke','grey')
                  .attr("stroke", function(d,i) { return "red"; })
                  .style("stroke-width", "2px");

          function midAngle(d) {
                  return d.startAngle + (d.endAngle - d.startAngle)/2;
              } 
            }
            else{

              alert("Category Wise Perf-Qtn Data is Not Available for Selected Criteria");
            }
          }); 

    function dollarFormatter(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 100000) {
        result = Math.round(n/100000) + 'L';
      }
      return  result;
    }

    function dollarFormatterL(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 100000) {
        result = Math.round(n/100000);
      }
      return result;
    }
}
