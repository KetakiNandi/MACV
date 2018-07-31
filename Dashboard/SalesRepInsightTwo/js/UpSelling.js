$( document ).ready(function() {

	   SalesPersonWiseUpsellingQnt();
});

function SalesPersonWiseUpsellingQnt(startDate,endDate,zone,state,city,SSite,prname,Scate,Semp,yesno,subcat,itemcode,POSType)

      {
var msg = document.getElementById("DESTROY").value;
       // console.log(startDate,endDate,zone,state,city,SSite,prname,Scate,Semp,yesno,subcat,itemcode);
      var margin = { top: 40, right: 10, bottom: 10, left: 50 },
          width = 440 - margin.left - margin.right,
          height = 170 - margin.top - margin.bottom;

      var percentage = function(d) { return d["percentage"]; };
      // var PoSName = function(d) { return d["PoSName"]; };
       var SourceSite = function(d) { return d["SourceSite"]; };




      var colorScale = d3.scale.category20c();
      var color = function(d) { return d.children ? colorScale(d["Group"]) : null; }

      var treemap = d3.layout.treemap()
          .size([width, height])
          .sticky(true)
          .value(percentage,SourceSite);
	

          d3.select("#SPUSQ").html("");
      var div = d3.select("#SPUSQ").append("div")
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
          .text("Sales Person Name:  "+d["demographics"]["Group"]);
        d3.select("#infotip #percentage")
          .text("Quantity:  "+dollarFormatter(d["percentage"]));
        
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

//d3.json("http://localhost/MACV/SalesRepInsight/data/SalesPersonWiseContributionValue.php", function(error, data) {

var Cvalue=encodeURI("http://localhost/MACV/SalesRepInsightTwo/data/SalesPersonWiseUpSellingQtn.php");



if (zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(Cvalue+"?param="+msg);
      //console.log("ddddddddddd",links);
   }

else if((zone)&& state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
      links=(Cvalue+"?zoneparam="+zone);
    }

else if(zone === undefined && state && city === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
       links=(Cvalue+"?Stateparam="+state);

       
    }
else if(zone === undefined && state === undefined && city  && Semp === undefined && SSite === undefined  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=(Cvalue+"?Cityparam="+city);
    }
else if(zone === undefined && state === undefined && city === undefined  && Semp && SSite === undefined  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=(Cvalue+"?EmpIdparam="+Semp);
    }

else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
   {
      links=(Cvalue+"?Siteparam="+SSite);
   }

else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && Scate  && prname === undefined && startDate === undefined && endDate === undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(Cvalue+"?categoryparam="+Scate);

 // console.log("ddddddddddd",links);
  }
  else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && yesno  && prname === undefined && startDate === undefined && endDate === undefined && Scate===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(Cvalue+"?YesNoparam="+yesno);

 // console.log("ddddddddddd",links);
  }
  else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && subcat  && prname === undefined && startDate === undefined && endDate === undefined && Scate===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(Cvalue+"?SubCatparam="+subcat);

 // console.log("ddddddddddd",links);
  }
   else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && prname  && subcat === undefined && startDate === undefined && endDate === undefined && Scate===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(Cvalue+"?ProNameparam="+prname);

 // console.log("ddddddddddd",links);
  }
  else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && itemcode  && subcat === undefined && startDate === undefined && endDate === undefined && Scate===undefined && yesno===undefined && prname===undefined && POSType===undefined)
  {
  links=(Cvalue+"?itemcodeparam="+itemcode);

  //console.log("ddddddddddd",links);
  }
  else if(zone === undefined && state === undefined && city === undefined  && Semp === undefined && SSite === undefined  && POSType  && subcat === undefined && startDate === undefined && endDate === undefined && Scate===undefined && yesno===undefined && prname===undefined && itemcode===undefined)
  {
  links=(Cvalue+"?POSTypeparam="+POSType);

  //console.log("ddddddddddd",links);
  }
else
{
   links=encodeURI(Cvalue+"?startDate="+startDate+"&endDate="+endDate);
}


d3.json(links,function(error, data) {

if(data.length!=0)
{
data.sort(function(a, c) { return c.UniqueItemCodeCount - a.UniqueItemCodeCount; });


var groupings = {}
  groupData(groupings, data, "demographics");
  var trees = [];
  for(group in groupings){
    var children = [];
    var children2 = [];
     var children3 = [];
    for(type in groupings[group]){
      var elm = groupings[group][type];
      //var elm1 = groupings[group][type];
      var elm2 = groupings[group][type];

      
      elm["percentage"] = elm["demographics"]["percentage"];
      //elm1["PoSName"] = elm1["demographics"]["PoSName"];
      elm2["SourceSite"] = elm2["demographics"]["SourceSite"];


      
      children3.push(elm2);
      children.push(elm);
     // children2.push(elm1);
       
    }
      trees.push({"children": children,"children": children3,"Group": group});
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
          
          render_Tachievement(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
          //PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d["demographics"]["SalespersonId"]);
         
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
 // }


function position() {
  this.style("left", function(d) {return d.x + "px"; })
      .style("top", function(d) {return d.y + "px"; })
      .style("width", function(d) { return Math.max(0, d.dx) + "px";})
      .style("height", function(d) {
         return Math.max(0, d.dy) + "px"; 
      
 });
}
function dollarFormatter(n) {
      n = Math.round(n);
      var result = n;
      if (Math.abs(n) > 100000) {
        result = Math.round(n/100000) + 'L';
      }
      return  result;
    }

}
