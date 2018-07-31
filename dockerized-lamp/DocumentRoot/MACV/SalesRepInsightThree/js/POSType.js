$( document ).ready(function() {

  	Macv_POSType();
  
  });


function Macv_POSType(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,startDate,endDate){

  //console.log(spzone);

//d3.json("http://localhost/MACV/SalesRepInsight/data/city.php",function(data){

  var msg = document.getElementById("DESTROY").value;

  var links;
  var Zone;
  var state;
  var EmpID;

 //var POSType=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/POSType.php");


if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
        links=(POSType+"?param="+msg);
    }
else if((spzone) && Sstate === undefined  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
      links=(POSType+"?zoneparam="+spzone);
      //console.log(links);
    }

else if(spzone === undefined && Sstate && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
        links=encodeURI(POSType+"?Stateparam="+Sstate);
        //console.log(links);
    }

else if(spzone === undefined && Sstate === undefined && scity && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
       links=encodeURI(POSType+"?Cityparam="+scity);
       //console.log(links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp  && SSite === undefined && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
        links=encodeURI(POSType+"?EmpIdparam="+Semp);
        //console.log(links);
    }

else if (spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite && Scate === undefined  && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
      links=encodeURI(POSType+"?Siteparam="+SSite);
      //console.log(links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
      links=encodeURI(POSType+"?categoryparam="+Scate);
     // console.log("%%%",links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
    {
      links=encodeURI(POSType+"?SubCatparam="+subcat);
      //console.log(links);
    }
else if(spzone === undefined && Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && subcat=== undefined && prname === undefined && Scate===undefined && itemcode===undefined && (startDate && endDate))
    {
      links=encodeURI(POSType+"?startDate="+startDate+"&endDate="+endDate);
      //console.log(links);
    }
 else
  {
    links=(POSType+"?ProNameparam="+prname)
    //console.log(links);
  }


d3.json(links,function(error, json) {

var sessionFlag=0;
	if(json.dateParam)
	 {
		sessionFlag=1;
    startDateParam = json.dateParam.stDate;
    endDateParam = json.dateParam.endDate;
		var data = json.data;
	      data.forEach(function(d) { 
	    
		    d.PosType = d.PosType;
	      });

		data.push({
			PosType:"All"
		      })
	}
	else{
	 var data=json;
    startDateParam = "01-Jan-17";
   endDateParam = "31-Dec-17";
	data.forEach(function(d) { 
	    
		    d.PosType = d.PosType;
	      });

		data.push({
			PosType:"All"
		      })
	}

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

var Sstate;
    var scity;
    var Semp;
   // var SSite;
    var Scate;
    var prname;
    var CatQtn;
    var subcat;
    var emp;
    var state;
    var itemcode;
    var spImp;
    var POSType;
    var END;
    var Start1;

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
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'80px')
      .on('click', function(d) {
        var s = signalOptions.filter(function(d) {
          // console.log(d);
          // console.log(s);
          // console.log(this.selected);
          return this.selected;
        });
        // if (s.nodes().length >= 2) {
        //   signalOptions.filter(function() {
        //       return !this.selected
        //     })
        //     .property('disabled', true);
        // } else {
        //   signalOptions.property('disabled', false);
        // }
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
          //console.log(startDateParam,endDateParam);
       PoSperformance(startDateParam,endDateParam);
        PoSperformanceZoom(startDateParam,endDateParam);
        Macv_Zone(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
        Macv_State(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_City(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_POSType(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,startDateParam,endDateParam);
    Macv_SourceSite(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_Category(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_Promoname(zone,state,scity,emp,SSite,Scate,subcat,itemcode,POSType,startDateParam,endDateParam);
    Macv_EmpId(zone,state,scity,SSite,emp,Scate,prname,subcat,itemcode,POSType,startDateParam,endDateParam);
      
  if(ClickFlagV=="2")
         {
      globalStDate1 = startDateParam;
            globalEndDate1 = endDateParam;
            WeekendMonth(startDateParam,endDateParam);

           WeekendMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV1').disabled)

            {WeekendQuarter(startDateParam,endDateParam);}

             $('#SPV1').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              //console.log("WWWW",startDateParam,endDateParam);
             WeekendQuarter(startDateParam,endDateParam);
               });

             $('#SPV2').click(function(){
              if(startDateParam.length == 0)
                  startDateParam = globalStDate1 ;

                if(endDateParam.length == 0)
                  endDateParam = globalEndDate1 ;
              WeekendMonth(startDateParam,endDateParam);
             WeekendMonthZoom(startDateParam,endDateParam);
               });  
         }

       if(ClickFlag=="0")
       {
               globalStDate1 = startDateParam;
            globalEndDate1 = endDateParam;
          WeekDayMonth(startDateParam,endDateParam);
          WeekDayMonthZoom(startDateParam,endDateParam);
            if(document.getElementById('SPV3').disabled)

            {WeekDayQuarter(startDateParam,endDateParam);}
            $('#SPV3').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              //console.log("WWWW",startDateParam,endDateParam);
              WeekDayQuarter(startDateParam,endDateParam);
               }); 
            $('#SPV4').click(function(){
               if(startDateParam.length == 0)
      startDateParam = globalStDate ;

    if(endDateParam.length == 0)
      endDateParam = globalEndDate ;
              WeekDayMonth(startDateParam,endDateParam);
              WeekDayMonthZoom(startDateParam,endDateParam);
               }); 
     }
          
    
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
          PoSperformance(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues);        
          PoSperformanceZoom(stDate,endDate,zone,state,city,SSite,Promo,Category,EmpID,yesno,SubCat,selectedValues)
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
