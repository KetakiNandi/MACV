$( document ).ready(function() {

	   SalesPersonWiseContributionQuantity();
});

function SalesPersonWiseContributionQuantity(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType)
      {
var msg = document.getElementById("DESTROY").value;
      var margin = { top: 40, right: 10, bottom: 10, left: 40 },
          width = 450 - margin.left - margin.right,
          height = 170 - margin.top - margin.bottom;

      var percentage = function(d) { return d["percentage"]; };
       var PoSName = function(d) { return d["PoSName"]; };
       var SourceSite = function(d) { return d["SourceSite"]; };

      var colorScale = d3.scale.category20c();
      var color = function(d) { return d.children ? colorScale(d["Group"]) : null; }

      var treemap = d3.layout.treemap()
          .size([width, height])
          .sticky(true)
          .value(percentage,PoSName,SourceSite);
	

          d3.select("#SPWCQ").html("");
      var div = d3.select("#SPWCQ").append("div").attr("id","SalesPWCQ")
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
          .text("QTY:  "+d["percentage"]);
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

      var SPWCQ=encodeURI("http://localhost/MACV/SalesRepInsightTwo/data/SalesPersonWiseContributionQuantity.php"); 

   if (startDate === undefined && endDate === undefined && zone===undefined && state===undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

          links=(SPWCQ+"?param="+msg);
        }
    else if(startDate === undefined && endDate === undefined && zone && state===undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?zoneparam="+zone);
    }
    else if(startDate === undefined && endDate === undefined && state && zone===undefined && city===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?Stateparam="+state);
    }
    else if(startDate === undefined && endDate === undefined && city && zone===undefined && state===undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?Cityparam="+city);
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state===undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?Siteparam="+sourceSite);
    }
     else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state===undefined && city===undefined && promoname===undefined && sourceSite===undefined && emp===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?categoryparam="+catgory);
    }
     else if(startDate === undefined && endDate === undefined && emp && zone===undefined && state===undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?EmpIdparam="+emp);
    }
    else if(startDate === undefined && endDate === undefined && yesno && zone===undefined && state===undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?YesNoparam="+yesno);
    }
    else if(startDate === undefined && endDate === undefined && subcat && zone===undefined && state===undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?SubCatparam="+subcat);
    }
     else if(startDate === undefined && endDate === undefined && promoname && zone===undefined && state===undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?ProNameparam="+promoname);
    }
    else if(startDate === undefined && endDate === undefined && itemcode && zone===undefined && state===undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && promoname===undefined && POSType===undefined)
    {
        links=encodeURI(SPWCQ+"?itemcodeparam="+itemcode);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && POSType && zone===undefined && state===undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && promoname===undefined && itemcode===undefined)
    {
        links=encodeURI(SPWCQ+"?POSTypeparam="+POSType);
        //console.log("111",links);
    }
        else{
          links=encodeURI(SPWCQ+"?startDate="+startDate+"&endDate="+endDate);
          //console.log("111",links);
         // d3.select("#SalesPWCQ").remove();
        }

d3.json(links, function(error, data) {

  if(data.length!=0)
  {

/*var data=[];
  var counter=1;
    for(var i=0;i<data1.length;i++){
       var fdata = (data1[i].Group);
        var fdata2 = (data1[i].percentage);
        var fdata3 = (data1[i].PoSName);

         data.push({Group:fdata,percentage:fdata2,PoSName:fdata3});


      if(counter==100)
      {
        counter=0
          break;
      }

        counter++;
    }
*/

 //console.log("ggggggggg",JSON.stringify(Arrray));

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
       // console.log(d["demographics"]["SalespersonId"]);
          Macv_Zone(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_State(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_City(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_SourceSite(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_Category(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_Promoname(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_EmpId(Zone,state,city,d["demographics"]["SalespersonId"]);
          Macv_POSType(Zone,state,city,d["demographics"]["SalespersonId"]);
          //SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          //CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          //SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          //CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
         // PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);

});


  node.append("text")
      .classed("overlaidText",true)
      .text(function(d) {return d["Group"]})
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



function position() {
  this.style("left", function(d) {return d.x + "px"; })
      .style("top", function(d) {return d.y + "px"; })
      .style("width", function(d) { return Math.max(0, d.dx) + "px";})
      .style("height", function(d) {
         return Math.max(0, d.dy) + "px"; 
      
 });
}


}
