$( document ).ready(function() {

  	Macv_POSType();
  
  });


function Macv_POSType(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode){

  //console.log(spzone);

var msg = document.getElementById("DESTROY").value;
//d3.json("http://localhost/MACV/SalesRepInsight/data/city.php",function(data){

  var links;
  var Zone;
  var state;
  var EmpID;

// var POSType=encodeURI("http://13.228.26.230//MACV/SalesRepInsightThree/data/POSType.php");


if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
    {
        links=(POSType+"?param="+msg);
    }
else if((spzone) && Sstate === undefined  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
    {
      links=(POSType+"?zoneparam="+spzone);
      //console.log(links);
    }

else if(spzone === undefined && Sstate && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
    {
        links=encodeURI(POSType+"?Stateparam="+Sstate);
        //console.log(links);
    }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined)
    {
       links=encodeURI(POSType+"?Cityparam="+scity);
       //console.log(links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp  && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined)
    {
        links=encodeURI(POSType+"?EmpIdparam="+Semp);
        //console.log(links);
    }

else if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined)
    {
      links=encodeURI(POSType+"?Siteparam="+SSite);
      //console.log(links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined)
    {
      links=encodeURI(POSType+"?categoryparam="+Scate);
     // console.log("%%%",links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined)
    {
      links=encodeURI(POSType+"?SubCatparam="+subcat);
      //console.log(links);
    }
    else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined)
    {
      links=(POSType+"?itemcodeparam="+itemcode);
      //console.log(links);
    }
 else
  {
    links=(POSType+"?ProNameparam="+prname)
    //console.log(links);
  }


d3.json(links,function(error, data) {


      data.forEach(function(d) { 
    
            d.PosType = d.PosType;
      });

data.push({
        PosType:"All"
      })

data.sort(function(a, c) { return c.count - a.count; });

//console.log(JSON.stringify(data));
d3.select("#MacPT1").html("");

function wrap(text, width) {
        text.each(function() {
        var text = d3.select(this),
        words = text.text().split(/\s+/).reverse(),
        word,
        line = [],
        lineNumber = 0, //<-- 0!
        lineHeight = 1.2, // ems
        x = text.attr("x"), //<-- include the x!
        y = text.attr("y"),
        dy = text.attr("dy") ? text.attr("dy") : 0; //<-- null check
        tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");
        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            /*if (tspan.node().getComputedTextLength() > width) {
                line.pop();
                tspan.text(line.join(" "));
                line = [word];
                tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }*/
        }
    });
}

var stDate;
var endDate;
var zone;
var city;
var SSite;
var Category;
var Promo;
var SubCat;
var itemcode;
var yesno;
var EmpID;
var state;

var signal = d3.select('#MacPT1');
    //var signalName = ["COCO", "FOFO"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('height','75px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(data).enter()
      .append('option')
      .text(function(d) {
        return d.PosType;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'62px')
      .on('click', function(d) {
        var s = signalOptions.filter(function(d) {
          // console.log(d);
          // console.log(s);
          // console.log(this.selected);
          return this.selected;
        });
       
      });

    d3.select('#someButton3')
      .on('click', function(d) {
        var v = signalOptions.filter(function(d) {
          if(this.selected)
          {//console.log(this.value);
            selectedValues.push(this.value);
          return this.selected;
        }
        }).data();
        if(selectedValues=="All"){
          //console.log(selectedValues);
            location.reload();
          }
          else if(selectedValues.indexOf('All')>-1){
        //alert(selectedValues);

       	   Macv_EmpId(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_State(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Zone(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_SourceSite(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Category(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Promoname(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
	   Macv_City(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
//PoSperformance(stDate,endDate,Zone,state,city,SourceSite,promo,emp,SubCat,itemcode,selectedValues);
	PoSperformance(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);				
	PoSperformanceZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues)
	Macv_WeekDay(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	WeekendDayCompared(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);

	 WeekendComparedZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
        WeekComparedZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	 if(ClickFlagV=="2")
         {
            WeekendMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);

	   WeekendMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               });

             $('#SPV2').click(function(){
              
              WeekendMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
             WeekendMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {

          WeekDayMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	WeekDayMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);}
            $('#SPV3').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               }); 
            $('#SPV4').click(function(){
              
              WeekDayMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
              WeekDayMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               }); 
     }
	
		
          
      }else
      {
           Macv_EmpId(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_State(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Zone(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_SourceSite(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Category(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
           Macv_Promoname(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
	   Macv_City(Zone,state,city,EmpID,SSite,Category,Promo,SubCat,itemcode,selectedValues);
	// PoSperformance(stDate,endDate,Zone,state,city,SourceSite,promo,emp,SubCat,itemcode,selectedValues);
	//PoSperformanceZoom(stDate,endDate,Zone,state,city,SourceSite,promo,emp,SubCat,itemcode,selectedValues);
	PoSperformance(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);				
	PoSperformanceZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	Macv_WeekDay(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
        WeekendDayCompared(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	 WeekendComparedZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
        WeekComparedZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);


 if(ClickFlagV=="2")
         {
            WeekendMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);

	   WeekendMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
             WeekendQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               });

             $('#SPV2').click(function(){
              
              WeekendMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
             WeekendMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               });  
         }

       if(ClickFlag=="0")
       {

          WeekDayMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
	WeekDayMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);}
            $('#SPV3').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              WeekDayQuarter(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               }); 
            $('#SPV4').click(function(){
              
              WeekDayMonth(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
              WeekDayMonthZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);
               }); 
     }



          }
        selectedValues = [];
      
      });
            
    });


}
