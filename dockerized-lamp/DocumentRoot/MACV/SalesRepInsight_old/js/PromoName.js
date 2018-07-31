$( document ).ready(function() {

    document.getElementById('someButton6').disabled = true;
 


  	Macv_Promoname();
  
  });


function Macv_Promoname(spzone,Sstate,scity,Semp,SSite,Scate,subcat,itemcode,POSType,startDate,endDate){

  //console.log(POSType);

  var msg = document.getElementById("DESTROY").value;

      //d3.json("http://localhost/MACV/SalesRepInsight/data/promoName.php",function(data){

      var links;
      var Zone;
      var city;
      var EmpID;
      var Division;
      var state;
      var SourceSite;
      var globalSelectedValuesPromo;
      var globalSelectedValuesPromo1;

      //var pName=encodeURI("http://13.228.26.230/MACV/SalesRepInsight/data/promoName.php");



      if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined) {

          links=encodeURI(pName+"?param="+msg);
          //console.log("promoname",links);

         }

       else if((spzone)&& Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
          {

             links=encodeURI(pName+"?zoneparam="+spzone);



            }

      else if(spzone === undefined && Sstate && scity === undefined  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
          {
             links=encodeURI(pName+"?Stateparam="+Sstate);

               //console.log(links);

           
          }
      else if(spzone === undefined && Sstate === undefined && scity  && Semp === undefined && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
        {

        links=encodeURI(pName+"?Cityparam="+scity);

        }

      else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp  && SSite === undefined  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?EmpIdparam="+Semp);
        //console.log(links);
      }

      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && SSite  && Scate === undefined && subcat===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?Siteparam="+SSite);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && subcat  && Scate === undefined && SSite===undefined && itemcode===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?SubCatparam="+subcat);
       // console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && itemcode  && Scate === undefined && SSite===undefined && subcat===undefined && POSType===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?itemcodeparam="+itemcode);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && POSType  && Scate === undefined && SSite===undefined && subcat===undefined && itemcode===undefined && startDate===undefined && endDate===undefined)
      {
        links=encodeURI(pName+"?POSTypeparam="+POSType);
        //console.log(links);

      }
      else if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined  && POSType=== undefined  && Scate === undefined && SSite===undefined && subcat===undefined && itemcode===undefined && (startDate && endDate))
      {
        links=encodeURI(pName+"?startDate="+startDate+"&endDate="+endDate);
        //console.log(links);

      }
      else
      {

      links=encodeURI(pName+"?categoryparam="+Scate);
      //console.log(links);
      }

      d3.json(links,function(error, json) {

	var sessionFlag=0;
//	console.log(JSON.stringify(json));
	if(json.dateParam)
	 {
		sessionFlag=1;
		var data = json.data;
		if(data!=null)
		{
			  data.forEach(function(d) { 
			  
			  d.PromoName = d.PromoName;
			  d.PromoNo = d.PromoNo;

		      });

			 data.push({
			PromoName:"All"
		      })
		}
		else{
		alert("PromoNames are Not Available for Selected Criteria");
		}
	  }
	else{
			 var data=json;
		if(data.length!=0)
			{
			 data.forEach(function(d) { 
			  
			  d.PromoName = d.PromoName;
			  d.PromoNo = d.PromoNo;

		      });

			 data.push({
			PromoName:"All"
		      })
		}
		else{
		alert("PromoNames are  Not Available for Selected Criteria");
		}

	}

      //data.sort(function(a, c) { return c.count - a.count; });


      d3.select("#MacDPRN").html("");

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


var signal = d3.select('#MacDPRN');
    //var signalName = ["Please Select", "Temperature", "Pressure", "Load"];
    var signalSelect = signal
      .append('select')
      .attr('class', 'select')
      .attr('multiple', '')
      .style('overflow-x', 'scroll')
      .style('height','75px');

    var selectedValues = [];
    var signalOptions = signalSelect
      .selectAll('option')
      .data(data).enter()
      .append('option').attr("value", function(d){return d.PromoNo;})
      .text(function(d) {
        return d.PromoName;
      }).style("font-weight","bold").style("font-family",'Open Sans').style("width",'177px')
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

    d3.select('#someButton6')
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
		 if(sessionFlag==1)
			{
			    //Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    //Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    //Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			   // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			      if(ClickFlagV=="2")
			 {
			    globalSelectedValuesPromo1 = selectedValues;
			    SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPV1').disabled)

			    {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}

			     $('#SPV1').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });

			     $('#SPV2').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });  
			 }

			 if(ClickFlag=="0")
			 {
				globalSelectedValuesPromo = selectedValues;
			    render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPQ1').disabled)

			    {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}
			    $('#SPQ1').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
			    $('#SPQ2').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
		       }
			}
			else{

			 /*   Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);*/
			    Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   /* Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,selectedValues);*/
			    CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			   // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			      if(ClickFlagV=="2")
			 {
			     globalSelectedValuesPromo1 = selectedValues;
			    SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPV1').disabled)

			    {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}

			     $('#SPV1').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });

			     $('#SPV2').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });  
			 }

			 if(ClickFlag=="0")
			 {
				globalSelectedValuesPromo = selectedValues;
			    render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPQ1').disabled)

			    {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}
			    $('#SPQ1').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
			    $('#SPQ2').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
		       }
		}
      }else
      {
			if(sessionFlag==1)
			{
			    //Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    //Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			    //Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			   // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			   // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			     // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			      if(ClickFlagV=="2")
			 {
			    globalSelectedValuesPromo1 = selectedValues;
			    SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPV1').disabled)

			    {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}

			     $('#SPV1').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });

			     $('#SPV2').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });  
			 }

			 if(ClickFlag=="0")
			 {
			     globalSelectedValuesPromo = selectedValues;
			    render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPQ1').disabled)

			    {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}
			    $('#SPQ1').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
			    $('#SPQ2').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
		       }
			}
			else{

			  Macv_Zone(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_Category(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_EmpId(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_SourceSite(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_City(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_State(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			  Macv_POSType(Zone,state,city,EmpID,SourceSite,Division,selectedValues);
			 // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			  CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			  SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			  CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			 // render_Tachievement(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			 // SalesPersonWiseContributionQuantity(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			 // SalesPersonWiseContributionValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // PoSperformance(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			   // SalesPersonWiseUpsellingQnt(stDate,endDate,zone,state,city,SourceSite,selectedValues);

			    if(ClickFlagV=="2")
			 {
			     globalSelectedValuesPromo1 = selectedValues;
			    SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPV1').disabled)

			    {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}

			     $('#SPV1').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });

			     $('#SPV2').click(function(){
			      if(selectedValues.length == 0)
                                  selectedValues = globalSelectedValuesPromo1 ;
			      SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       });  
			 }
			 if(ClickFlag=="0")
			 {
				globalSelectedValuesPromo = selectedValues;
			    render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			    if(document.getElementById('SPQ1').disabled)

			    {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);}
			    $('#SPQ1').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
			      SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			       }); 
			    $('#SPQ2').click(function(){
			      if(selectedValues.length == 0)
				  selectedValues = globalSelectedValuesPromo ;
			      render_avgsession(stDate,endDate,zone,state,city,SourceSite,selectedValues);
			      render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,selectedValues);              
			       }); 
		       }
		}
      }
        selectedValues = [];
      
      });
      
          });

}
