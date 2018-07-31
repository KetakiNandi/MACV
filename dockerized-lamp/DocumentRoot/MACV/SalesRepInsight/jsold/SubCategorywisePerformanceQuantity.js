$( document ).ready(function() {
  SubCategorywisePerformanceQuantity();
});

function remove(property, num, arr) {
    for (var i in arr) {
        if (arr[i][property] == num)
            arr.splice(i, 1);
    }
}

function SubCategorywisePerformanceQuantity(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,itemcode,POSType){
        //console.log("$$$$$$$$$",startDate,endDate);
var msg = document.getElementById("DESTROY").value;
        var colorRange = d3.scale.category20();
        var color = d3.scale.ordinal().range(colorRange.range());
        var width = 450,
             height =300,
             radius=160;

        var arc = d3.svg.arc().outerRadius(radius - 100).innerRadius(radius - 50);
        var outerArc = d3.svg.arc().innerRadius(radius - 60).outerRadius(radius - 60);

        var svg = d3.select("#SCPQ").append("svg")
        .attr("id","SCPQR")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + 240 + "," + 180  + ")");

        svg.append("g").attr("class", "slices");
        svg.append("g").attr("class", "labelName");
        svg.append("g").attr("class", "lines");

        var div = d3.select("body").append("div").attr("class", "toolTip");

        var links;
        var allRevenue=0;
        var pie = d3.layout.pie().value(function(d) { 
        return d.Revenue; });

        var otherEmpState="";
        var otherEmpStateRevenue=0;
        var links;

            //var subzone=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/SubCategorywisePerformanceQuantity.php");

            if (city === undefined && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined){
                links=(subzone+"?param="+msg);
            }
            else if((zone) && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
            {
                links=(subzone+"?zoneparam="+zone);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#SCPQR").remove();
           }
            else if((city) && emp === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
            {
                links=(subzone+"?Cityparam="+city);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#SCPQR").remove();
           }
           else if((emp) && city === undefined && state===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
            {
                links=(subzone+"?EmpIdparam="+emp);
                //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
               d3.select("#SCPQR").remove();
           }
           else if((state) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
             {
                links=(subzone+"?Stateparam="+state);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
            else if((sourceSite) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
             {
                links=(subzone+"?Siteparam="+sourceSite);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
               else if((catgory) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && sourceSite===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
             {
                links=(subzone+"?categoryparam="+catgory);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
               else if((yesno) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && itemcode===undefined && POSType===undefined)
             {
                links=(subzone+"?YesNoparam="+yesno);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
                else if((promoname) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && yesno===undefined && sourceSite===undefined && catgory===undefined && itemcode===undefined && POSType===undefined)
             {
                links=(subzone+"?ProNameparam="+promoname);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
               else if((itemcode) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && yesno===undefined && sourceSite===undefined && catgory===undefined && promoname===undefined && POSType===undefined)
             {
                links=(subzone+"?itemcodeparam="+itemcode);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
                else if((POSType) && city === undefined && emp===undefined && startDate===undefined && endDate===undefined && zone===undefined && state===undefined && yesno===undefined && sourceSite===undefined && catgory===undefined && promoname===undefined && itemcode===undefined)
             {
                links=(subzone+"?POSTypeparam="+POSType);
               // console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
                d3.select("#SCPQR").remove();
               }
            else
            {
            links=encodeURI(subzone+"?startDate="+startDate+"&endDate="+endDate);
            //console.log("EEEEEEEEEEEEEEEEEEEEEEEEEE",links);
            d3.select("#SCPQR").remove();
            }

        d3.json(links,function(error,data){

          if(data.length!=0)
          {
          //var abc=data;
         // console.log("@@@@@@",JSON.stringify(data));
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


    //remove('Category', 'All', data);

    var stDate;
    var endDate;
    var zone;
    var state;
    var city;
    var promo;
    var SourceSite;
    var catgory;
    var emp;
    var yesno;
    var Zone;
    var EmpID;

    var slice = svg.select(".slices").selectAll("path.slice")
            .data(pie(data), function(d){

     return d.data.Category });

        slice.enter()
            .insert("path")
            .style("fill", function(d) { 
              if(d.data.Category==="Polarized")
              {
              return "#1f93ff";
              }
              else if(d.data.Category==="Islay")
              {
                return "#8ad4eb";
              }
              else if(d.data.Category==="Fashion")
                {
                return "#e0c31f";
              }
              else if(d.data.Category==="Cara")
                {
                return "#f0c311";
              }
              else if(d.data.Category==="Calvay")
                {
                return "#fc6360";
              }
              else if(d.data.Category==="Black Isle")
                {
                return "#637173";
              }
              else if(d.data.Category==="Skye")
                {
                return "#3599b8";
              }
              else if(d.data.Category==="Signature")
                {
                return "#a66a99";
              }
              else if(d.data.Category==="Power Lens")
                {
                return "#cf3634";
              }
              else if(d.data.Category==="Ball Pen")
                {
                return "#debfbf";
              }
              else if(d.data.Category==="Packing Material")
                {
                return "#38ffff";
              }
              else if(d.data.Category==="YELLOW LENS")
                {
                return "#a181a6";
              }
              else if(d.data.Category==="Sunglasses Case")
                {
                return "#9ee362";
              }
               })              
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
            Macv_Zone(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_State(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_City(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_SourceSite(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_Promoname(Zone,state,city,EmpID,SourceSite,catgory,d.data.Category);
            Macv_EmpId(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_Category(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            Macv_POSType(Zone,state,city,EmpID,SourceSite,catgory,promo,d.data.Category);
            //SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
           // render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
           // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            //SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
	     CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            //SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,d.data.Category);
           // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
           // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
           // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
           // PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            //SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);

            if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
	   SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
              SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
               });  
         }

         if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
	   render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
              render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,emp,yesno,d.data.Category);
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
                pos[0] = radius *.60* (midAngle(d) < Math.PI ? 1.1 : -1.1);
        
    
    var percent = (d.endAngle - d.startAngle)/(2*Math.PI)*100
         if(percent<5){
         //console.log(percent)
         pos[1] += i*15
         }
          return "translate("+ pos +")";
        })
        .text(function(d) { 
          if(d.data.Category!="YELLOW LENS" && d.data.Category!="Ball Pen" && d.data.Category!="Black Isle")
          {return d.data.Category;}
           })
        .attr("fill", function(d,i) { return "White"; })
       // .attr("text-anchor", 'left')
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
                if(d.data.Category!="YELLOW LENS" && d.data.Category!="Ball Pen" && d.data.Category!="Black Isle")
                {return d.data.Revenue;}
              })
              .enter()
              .append("polyline")
              .attr("points", function(d,i) {
                var pos = outerArc.centroid(d);
                    pos[0] = radius * .75 * (midAngle(d) < Math.PI ? 1 : -1);
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
                  .attr("stroke", function(d,i) { return "red"; })
                  .style("stroke-width", "2px");

          function midAngle(d) {
                  return d.startAngle + (d.endAngle - d.startAngle)/2;
              } 
            }
            else{
              alert("SubCategory Wise Perf-Qtn Data is Not Available for Selected Criteria");
            }
          }); 

    function dollarFormatter(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 100000) {
        result = Math.round(n/100000) + 'L';
      }
      return '₹' + result;
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
