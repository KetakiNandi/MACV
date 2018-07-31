$( document ).ready(function() {

  	Macv_EmpId();
  
  });


function Macv_EmpId(spzone,Sstate,scity,Semp,SSite,Scate,prname,subcat,itemcode,POSType){

// d3.json("http://localhost/MACV/SalesRepInsight/data/empID.php", function(data) {

var links;

var Zone;
var city;
var EmpID;
var Division;
var state;
var SourceSite;


 var pEmpId=encodeURI("http://localhost/MACV/SalesRepInsight/data/empID.php");




if (spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  
  {

    links=(pEmpId+"?param=");


    }

 else if((spzone)&& Sstate === undefined && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {

       links=(pEmpId+"?zoneparam="+spzone);

    }

else if(spzone === undefined && Sstate  && scity === undefined && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
       links=(pEmpId+"?Stateparam="+Sstate);
    }
else if(spzone === undefined && Sstate === undefined && scity   && Semp === undefined && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
  {
  links=(pEmpId+"?Cityparam="+scity);

  }

  else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp && SSite === undefined && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)

  {

    links=(pEmpId+"?EmpIdparam="+Semp);
    //console.log(links)
  }

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite  && Scate === undefined && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)

{

  links=(pEmpId+"?Siteparam="+SSite);

  //console.log(links)

}

else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && Scate && prname === undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
{

  links=(pEmpId+"?categoryparam="+Scate);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && subcat && prname === undefined && Scate===undefined && itemcode===undefined && POSType===undefined)
{

  links=(pEmpId+"?SubCatparam="+subcat);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && itemcode && prname === undefined && Scate===undefined && subcat===undefined && POSType===undefined)
{

  links=(pEmpId+"?itemcodeparam="+itemcode);


}
else if(spzone === undefined && Sstate === undefined && scity === undefined  && Semp === undefined && SSite === undefined && POSType && prname === undefined && Scate===undefined && subcat===undefined && itemcode===undefined)
{

  links=(pEmpId+"?POSTypeparam="+POSType);
 // console.log(links);

}
else
{

links=(pEmpId+"?ProNameparam="+prname);

}


d3.json(links,function(error, data) {

        data.forEach(function(d) { 

                d.EmpID = d.EmpID;
                d.EmpName =d.EmpName;

              });


data.sort(function(a, b){
    if(a.EmpName < b.EmpName) return -1;
    if(a.EmpName > b.EmpName) return 1;
    return 0;
});

var stDate;
var endDate;
var zone;
var promo;
var SourceSite;
var catgory;

d3.select("#MacDEid").html("");

var svg = d3.select("#MacDEid")
   .selectAll("foreignObject")
   .data(data).enter()
   .append("foreignObject")
   .append("xhtml:body")
   .attr("class", "bforeign")
   //.attr("fill", "green")
   .html(function(d) {
    if(d.EmpName != "#N/A")
   { //console.log(d.EmpName);
return "<form><input type=checkbox class=che  id=check ><span><button class=Macd >" + d.EmpName + "</button></span> </form>";
}
})
 
 .on("click", function(d){

  Macv_Zone(Zone,state,city,d.EmpID);
  Macv_State(Zone,state,city,d.EmpID);
  Macv_City(Zone,state,city,d.EmpID);
  Macv_SourceSite(Zone,state,city,d.EmpID);
  Macv_Category(Zone,state,city,d.EmpID);
  Macv_Promoname(Zone,state,city,d.EmpID);
  Macv_POSType(Zone,state,city,d.EmpID);
  //SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  //render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
 // render_avgSoldPerDay(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  CategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  SubCategorywisePerformanceQuantity(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  CustomerDetailsFilled(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
   CategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  SubCategorywisePerformanceQuantityZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  CustomerDetailsFilledZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);  
  //PoSperformance(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
  
	if(ClickFlagV=="2")
         {
            SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
	    SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
            if(document.getElementById('SPV1').disabled)

            {SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);}

             $('#SPV1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceValueQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
               });

             $('#SPV2').click(function(){
              
              SalesPerformanceValue(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
               SalesPerformanceValueZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
               });  
         }

         if(ClickFlag=="0")
         {
            render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
	    render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
            if(document.getElementById('SPQ1').disabled)

            {SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);}
            $('#SPQ1').click(function(){
              
              //console.log("WWWW",startDate.format('DD-MMM-YY'),endDate.format('DD-MMM-YY'));
              SalesPerformanceQtnQuarter(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
               }); 
            $('#SPQ2').click(function(){
              
              render_avgsession(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
              render_avgsessionZoom(stDate,endDate,zone,state,city,SourceSite,promo,catgory,d.EmpID);
               }); 
       }
  
	$('input.che').on('change', function() {
    $('input.che').not(this).prop('checked', false);  
    });


   });
    
 });

}
