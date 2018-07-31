$( document ).ready(function() {
  CustomerDetailsFilledZoom();
});

function remove(property, num, arr) {
    for (var i in arr) {
        if (arr[i][property] == num)
            arr.splice(i, 1);
    }
}

function CustomerDetailsFilledZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,subcat,itemcode){
        //console.log("EEEEEEEEEEEEEEEE",pros,prosEmpId );

        var colorRange = d3.scale.category20();

        var color = d3.scale.ordinal().range(colorRange.range());

        var width = 750,
             height =495,
             radius=250;

        // var width = 150,
        //      height =230,
        //      radius=100;

        var arc = d3.svg.arc().outerRadius(radius - 200).innerRadius(radius - 50);
        var outerArc = d3.svg.arc().innerRadius(radius - 60).outerRadius(radius - 60);

        var svg = d3.select("#CDFZ").append("svg")
        .attr("id","CDFRZ")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + 420 + "," + 240  + ")");
        //.attr("transform", "translate(" + 70 + "," + 100  + ")");


        svg.append("g").attr("class", "slices");
        svg.append("g").attr("class", "labelName");
        svg.append("g").attr("class", "lines");

        var div = d3.select("body").append("div").attr("class", "toolTipZoom");

        var links;
        var allRevenue=0;
        var pie = d3.layout.pie().value(function(d) { 
        return d.Revenue; });

        var otherEmpState="";
        var otherEmpStateRevenue=0;
        var links;

            var szone=encodeURI("http://localhost/MACV/SalesRepInsight/data/CustomerDetailsFilled.php");

            if (city === undefined && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined){
                links=(szone+"?param=");
            }
            else if((zone) && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined)
            {
                links=(szone+"?zoneparam="+zone);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#CDFRZ").remove();
           }
            else if((city) && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined)
            {
                links=(szone+"?Cityparam="+city);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#CDFRZ").remove();
           }
           else if((emp) && city === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined)
            {
                links=(szone+"?EmpIdparam="+emp);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#CDFRZ").remove();
           }
           else if((state) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined)
             {
                links=(szone+"?Stateparam="+state);
                d3.select("#CDFRZ").remove();
               }
               else if((sourceSite) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && catgory===undefined && subcat===undefined && itemcode===undefined)
             {
                links=(szone+"?Siteparam="+sourceSite);
                d3.select("#CDFRZ").remove();
               }
                else if((catgory) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && sourceSite===undefined && subcat===undefined && itemcode===undefined)
             {
                links=(szone+"?categoryparam="+catgory);
                d3.select("#CDFRZ").remove();
               }
               else if((subcat) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && itemcode===undefined)
             {
                links=(szone+"?SubCatparam="+subcat);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#CDFRZ").remove();
               }
                else if((promoname) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && itemcode===undefined)
             {
                links=(szone+"?ProNameparam="+promoname);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#CDFRZ").remove();
               }
                else if((itemcode) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && promoname===undefined)
             {
                links=(szone+"?itemcodeparam="+itemcode);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#CDFRZ").remove();
               }
            else
            {
            links=(szone+"?startDate="+startDate+"&endDate="+endDate);
            d3.select("#CDFRZ").remove();
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
            if(d.Category==city)
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

    var stDate;
    var endDate;
    var zone;
    var state;
    var city;
    var promo;
    var SourceSite;
    var catgory;
    var emp;

    var slice = svg.select(".slices").selectAll("path.slice")
            .data(pie(data), function(d){

     return d.data.Category });

        slice.enter()
            .insert("path")
            .style("fill", function(d) { 
              if(d.data.Category==="Yes")
              {return "#00ff40";}
              else{
                return "#ff0800";
              } })
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
              //console.log(d);
                div.style("left", d3.event.pageX+10+"px");
                div.style("top", d3.event.pageY-25+"px");
                div.style("display", "inline-block");
                div.html("CustomerDetails: "+" "+(d.data.Category)+"<br>"+"Count of Bill No: "+dollarFormatterL(d.data.Revenue) +"("+((d.data.Revenue)*100/data1.total).toFixed(2)+"%"+")" );
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
            //SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            //render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
           // CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
            SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);

            if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
         }
         else{
            SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
       }

             if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
         }
         else{
            SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
       }
        });

        slice.exit()
            .remove();

    var text = svg.select(".labelName").selectAll("text")
            .data(pie(data), function(d){ return d.data.Category });


           text.enter().append("text")
                .attr("transform", function(d,i){
                var pos = outerArc.centroid(d);
                pos[0] = radius *.80* (midAngle(d) < Math.PI ? 1.1 : -1.1);
        
    
    var percent = (d.endAngle - d.startAngle)/(2*Math.PI)*100
         if(percent<5){
         //console.log(percent)
         pos[1] += i*15
         }
          return "translate("+ pos +")";
        })
        .text(function(d) { return d.data.Category; })
        .attr("fill", function(d,i) { return "White"; })
        //.attr("text-anchor", 'right')
        .attr("font-weight", 'bold')
        .attr("font-size", '10px')
        .attr("dx", function(d){
        var ac = midAngle(d) < Math.PI ? 0:-10
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
                    pos[0] = radius * .80 * (midAngle(d) < Math.PI ? 1 : -1);
                 var o=   outerArc.centroid(d)
         var percent = (d.endAngle -d.startAngle)/(2*Math.PI)*100
               if(percent<5){
               //console.log(percent)
               o[1] 
               pos[1] += i*15
               }
                return [arc.centroid(d),[o[0],pos[1]] , pos];
                  }).style("fill", "none")
                  //.attr('stroke','grey')
                  //.attr("stroke", function(d,i) { return "red"; })
                  .style("stroke-width", "2px");

          function midAngle(d) {
                  return d.startAngle + (d.endAngle - d.startAngle)/2;
              } 
            }
            else{

              alert("No Data Available for Selected Criteria");
            }
          }); 

    function dollarFormatter(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 1000) {
        result = Math.round(n/1000) + 'k';
      }
      return result;
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
