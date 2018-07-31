$( document ).ready(function() {

	   SalesPersonWiseContributionValue();
});

function SalesPersonWiseContributionValue(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode)
      {
      var margin = { top: 40, right: 10, bottom: 10, left: 10 },
          width = 400 - margin.left - margin.right,
          height = 180 - margin.top - margin.bottom;

      var percentage = function(d) { return d["percentage"]; };
       var PoSName = function(d) { return d["PoSName"]; };
       var SourceSite = function(d) { return d["SourceSite"]; };




      var colorScale = d3.scale.category20c();
      var color = function(d) { return d.children ? colorScale(d["Group"]) : null; }

      var treemap = d3.layout.treemap()
          .size([width, height])
          .sticky(true)
          .value(percentage,PoSName,SourceSite);
	

          d3.select("#SPWCV").html("");
      var div = d3.select("#SPWCV").append("div").attr("id","SalesPWCV")
          .style("position", "relative")
          .style("width", (width + margin.left + margin.right) + "px")
          .style("height", (height + margin.top + margin.bottom) + "px")
          .style("left", margin.left + "px")
          .style("top", margin.top + "px");

          //console.log("Raju my freiends");

      var mousemove = function(d) {
        var xPosition = d3.event.pageX + 5;
        var yPosition = d3.event.pageY + 5;

        d3.select("#infotip")
          .style("left", xPosition + "px")
          .style("top", yPosition + "px");
        d3.select("#infotip #heading")
          .text("Salesperson:  "+d["demographics"]["Group"]);
        d3.select("#infotip #percentage")
          .text("Amount:  "+dollarFormatter(d["percentage"]));
         d3.select("#infotip #PoSName")
          .text("City: "+d["PoSName"]);
          d3.select("#infotip #SourceSite")
          .text("SourceSite: "+d["SourceSite"]);


        d3.select("#infotip").classed("hidden", false);
      };

      var mouseout = function() {
        d3.select("#infotip").classed("hidden", true);
      };
    var groupData = function(groupings, data, key){
        data.forEach(function(d){
          if(!groupings[d["Group"]]) {
            groupings[d["Group"]] = {};
          }
          if(!groupings[d["Group"]][d["Type"]]) {
         groupings[d["Group"]][d["Type"]] = {};
          }
          groupings[d["Group"]][d["Type"]][key] = d;
        });
      }

      var SPWCV=encodeURI("http://localhost/MACV/SalesRepInsight/data/SalesPersonWiseContributionValue.php"); 

   if (startDate === undefined && endDate === undefined && zone===undefined && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined) {

          links=(SPWCV+"?param=");
        }
    else if(startDate === undefined && endDate === undefined && zone && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?zoneparam="+zone);
        //console.log("222",links);
    }
     else if(startDate === undefined && endDate === undefined && state && zone===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?Stateparam="+state);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && city && zone===undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?Cityparam="+city);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?Siteparam="+sourceSite);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?categoryparam="+catgory);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && emp && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?EmpIdparam="+emp);
        //console.log("222",links);
    }
     else if(startDate === undefined && endDate === undefined && yesno && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?YesNoparam="+yesno);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && subcat && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?SubCatparam="+subcat);
        //console.log("222",links);
    }
     else if(startDate === undefined && endDate === undefined && promoname && zone===undefined && state === undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined)
    {
        links=(SPWCV+"?ProNameparam="+promoname);
        //console.log("222",links);
    }
    else if(startDate === undefined && endDate === undefined && itemcode && zone===undefined && state === undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && promoname===undefined)
    {
        links=(SPWCV+"?itemcodeparam="+itemcode);
        //console.log("222",links);
    }
        else{
          links=encodeURI(SPWCV+"?startDate="+startDate+"&endDate="+endDate);
         // console.log("222",links);
        //  d3.select("#SalesPWCV").remove();
        }

d3.json(links, function(error, data) {

  if(data.length!=0){

var groupings = {}
  groupData(groupings, data, "demographics");
  var trees = [];
  for(group in groupings){
    var children = [];
    var children2 = [];
     var children3 = [];
    for(type in groupings[group]){
      var elm = groupings[group][type];
      var elm1 = groupings[group][type];
      var elm2 = groupings[group][type];

      
      elm["percentage"] = elm["demographics"]["percentage"];
      elm1["PoSName"] = elm1["demographics"]["PoSName"];
      elm2["SourceSite"] = elm2["demographics"]["SourceSite"];


      
      children3.push(elm2);
      children.push(elm);
      children2.push(elm1);
       
    }
    trees.push({"children": children,"children": children3,"children": children2,
                "Group": group});
  }

  //console.log("treeee",trees);

  var root = {"children": trees};

  var stDate;
  var endDate;
  var zone;
  var promo;
  var SourceSite;
  var catgory;
  var Zone;
  var state;
  var city;

var node = div.datum(root).selectAll(".node")
      .data(treemap.nodes)
    .enter().append("div")
      .attr("class", "node")
      .call(position)
      .style("background", color)
      .on("mousemove", mousemove)
      .on("mouseout", mouseout)
      .on("click", function(d){
        //console.log(d["demographics"]["SalespersonId"]);
          Macv_Zone(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_State(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_City(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_SourceSite(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_Category(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_Promoname(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_EmpId(Zone,state,city,d["demographics"]["SalespersonId"]);
          
          SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);

           if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
         }
         else{
            SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
       }

          if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
         }
         else{
            SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
       }
});


  node.append("text")
      .classed("overlaidText",true)
      .text(function(d) {

//console.log("ddddddddddddddddddd",d);
       return d["Group"]})
      .call(middletext);
function middletext(text) {
  text.attr("x", function(d) { return x(d.x + d.dx / 2); })
      .attr("y", function(d) { return y(d.y + d.dy / 2); });
    }
  }
  else{

    alert("No Data Available for Selected Criteria");
  }
    });
  //}

  function dollarFormatter(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 100000) {
        result = Math.round(n/100000) + 'L';
      }
      return  result;
    }


function position() {
  this.style("left", function(d) {return d.x + "px"; })
      .style("top", function(d) {return d.y + "px"; })
      .style("width", function(d) { return Math.max(0, d.dx) + "px";})
      .style("height", function(d) {
         return Math.max(0, d.dy) + "px"; 
      
 });

}
}