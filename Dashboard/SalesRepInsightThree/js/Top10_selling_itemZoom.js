$( document ).ready(function() {

	   PoSperformanceZoom();
});

function PoSperformanceZoom(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,POSType)
      {
        //console.log(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat);
      var margin = { top: 40, right: 10, bottom: 10, left: 100 },
          width = 810 - margin.left - margin.right,
          height = 480 - margin.top - margin.bottom;

      var percentage = function(d) { return d["percentage"]; };
       var PoSName = function(d) { return d["PoSName"]; };

      var colorScale = d3.scale.category20c();
      var color = function(d) { return d.children ? colorScale(d["Group"]) : null; }

      var treemap = d3.layout.treemap()
          .size([width, height])
          .sticky(true)
          .value(percentage,PoSName);
	

          d3.select("#TopSZ").html("");
      var div = d3.select("#TopSZ").append("div")
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
          .text("Item Code:  "+d["demographics"]["Group"]);
        d3.select("#infotip #percentage")
          .text("QTY :  "+d["percentage"]);
         d3.select("#infotip #PoSName")
          .text("First SubCategory: "+d["PoSName"]);

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
var links;
      var ToptenSell=encodeURI("http://localhost/MACV/SalesRepInsightThree/data/Top10SellingItem.php"); 

   if (startDate === undefined && endDate === undefined && zone===undefined && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined) {

          links=(ToptenSell+"?param=");
        }
    else if(startDate === undefined && endDate === undefined && zone && state===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=(ToptenSell+"?zoneparam="+zone);
    }
    else if(startDate === undefined && endDate === undefined && state && zone===undefined && city === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=(ToptenSell+"?Stateparam="+state);
    }
     else if(startDate === undefined && endDate === undefined && city && zone===undefined && state === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=(ToptenSell+"?Cityparam="+city);
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state === undefined && city===undefined && promoname===undefined && catgory===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?Siteparam="+sourceSite);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && emp===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?categoryparam="+catgory);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && emp && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && subcat===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?EmpIdparam="+emp);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && yesno && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && subcat===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?YesNoparam="+yesno);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && subcat && zone===undefined && state === undefined && city===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?SubCatparam="+subcat);
        //console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && promoname && zone===undefined && state === undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && POSType===undefined)
    {
        links=encodeURI(ToptenSell+"?ProNameparam="+promoname);
       // console.log("111",links);
    }
    else if(startDate === undefined && endDate === undefined && POSType && zone===undefined && state === undefined && city===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && emp===undefined && yesno===undefined && promoname===undefined)
    {
        links=encodeURI(ToptenSell+"?POSTypeparam="+POSType);
       // console.log("111",links);
    }
        else{
          links=encodeURI(ToptenSell+"?startDate="+startDate+"&endDate="+endDate);
          //console.log("111",links);
         // d3.select("#SalesPWCQ").remove();
        }

d3.json(links, function(error, data1) {

  if(data1.length!=0)
  {

var data=[];
  var counter=1;
    for(var i=0;i<data1.length;i++){
       var fdata = (data1[i].Group);
        var fdata2 = (data1[i].percentage);
        var fdata3 = (data1[i].PoSName);

         data.push({Group:fdata,percentage:fdata2,PoSName:fdata3});


      if(counter==10)
      {
        counter=0
          break;
      }

        counter++;
    }


 //console.log("ggggggggg",JSON.stringify(Arrray));

var groupings = {}
  groupData(groupings, data, "demographics");
  var trees = [];
  for(group in groupings){
    var children = [];
    var children2 = [];
    for(type in groupings[group]){
      var elm = groupings[group][type];
      var elm1 = groupings[group][type];

      
      elm["percentage"] = elm["demographics"]["percentage"];
      elm1["PoSName"] = elm1["demographics"]["PoSName"];

      

      children.push(elm);
      children2.push(elm1);
    }
    trees.push({"children": children,"children": children2,
                "Group": group});
  }

  //console.log("treeee",trees);

  var root = {"children": trees};

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
    var subcat;

  var node = div.datum(root).selectAll(".node")
      .data(treemap.nodes)
    .enter().append("div")
      .attr("class", "node")
      .call(position)
      .style("background", color)
      .on("mousemove", mousemove)
      .on("mouseout", mouseout)
      .on("click", function(d){
        //console.log(d["demographics"]["Group"]);
          Macv_Zone(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          Macv_State(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          Macv_City(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          Macv_SourceSite(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          Macv_Category(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          Macv_Promoname(zone,state,city,emp,SourceSite,catgory,subcat,d["demographics"]["Group"]);
          Macv_EmpId(zone,state,city,emp,SourceSite,catgory,promo,subcat,d["demographics"]["Group"]);
          
         
});

  node.append("text")
      .classed("overlaidText",true)
      .text(function(d) {

        //console.log("ssssssssssss",d["Group"]);


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
  }


function position() {
  this.style("left", function(d) {return d.x + "px"; })
      .style("top", function(d) {return d.y + "px"; })
      .style("width", function(d) { return Math.max(0, d.dx) + "px";})
      .style("height", function(d) {
         return Math.max(0, d.dy) + "px"; 
      
 });
}

