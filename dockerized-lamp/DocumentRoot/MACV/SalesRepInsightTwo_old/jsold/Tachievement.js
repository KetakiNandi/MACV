$( document ).ready(function() {

    render_Tachievement();
});

function render_Tachievement(startDate,endDate,zone,state,city,sourceSite,promoname,catgory,emp,yesno,subcat,itemcode,POSType){

    //console.log(spzone,spcity,spImp,dateofday);
var msg = document.getElementById("DESTROY").value;
    var margin = {top: 50, right: 20, bottom: 30, left: 10},
        width = 690 - margin.left - margin.right,
        height = 200 - margin.top - margin.bottom;

    var x = d3.scale.ordinal().rangeRoundBands([0, width]);
    var y = d3.scale.linear().range([height, 0]);

    var xAxis = d3.svg.axis().scale(x).orient("bottom");

    var yAxis = d3.svg.axis();

    var valueline = d3.svg.line()
        .x(function(d) { return x(d.SourceSite); })
        .y(function(d) { return y(d.Actual); });

    var div = d3.select("body").append("div")	
        .attr("class", "tooltip2")				
        .style("opacity", 0);

    d3.select("#TA").html("");

    var svg = d3.select("#TA")
        	.append("svg")
    	    .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
        	.append("g")
            .attr("transform","translate(" + margin.left + "," + margin.top + ")");

    var links;

   // var targetlink = encodeURI("http://13.228.26.230/MACV/SalesRepInsightTwo/data/Tachievement.php");

    if (zone === undefined && city === undefined &&   emp === undefined && state === undefined && startDate === undefined && endDate === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined) {

        links=encodeURI(targetlink+"?param="+msg);
        //console.log(links);
    }
    else if((emp) && (zone === undefined) && (city === undefined) && (state === undefined) && startDate === undefined && endDate === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
    	links=encodeURI(targetlink+"?EmpIdparam="+emp);

    }
    else if((zone) && (emp === undefined) && (city === undefined) && (state === undefined) && startDate === undefined && endDate === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)   
    {     
      links=encodeURI(targetlink+"?zoneparam="+zone);
      //	console.log(links);
    }  
    else if((city) && emp === undefined &&   zone === undefined && state === undefined && startDate === undefined && endDate === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
       links=encodeURI(targetlink+"?cityparam="+city);
        //d3.select("#TACH").remove();
    }
    else if((state) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && sourceSite===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?Stateparam="+state);
    }
    else if((sourceSite) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && promoname===undefined && catgory===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?Siteparam="+sourceSite);
    }
    else if((catgory) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && promoname===undefined && sourceSite===undefined && yesno===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?categoryparam="+catgory);
    }
     else if((yesno) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && subcat===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?YesNoparam="+yesno);
    }
    else if((subcat) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && promoname===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?SubCatparam="+subcat);
        //console.log(links);
    }
     else if((promoname) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && itemcode===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?ProNameparam="+promoname);
        //console.log(links);
    }
    else if((itemcode) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && promoname===undefined && POSType===undefined)
    {
        links=encodeURI(targetlink+"?itemcodeparam="+itemcode);
        //console.log(links);
    }
     else if((POSType) && emp === undefined &&   zone === undefined && city === undefined && startDate === undefined && endDate === undefined && state===undefined && subcat===undefined && sourceSite===undefined && catgory===undefined && yesno===undefined && promoname===undefined && itemcode===undefined)
    {
        links=encodeURI(targetlink+"?POSTypeparam="+POSType);
        //console.log(links);
    }
    else
    {
        links=encodeURI(targetlink+"?startDate="+startDate+"&endDate="+endDate);
       // console.log(links);
        d3.select("#Ras").remove();  
    }

    var finaldata=[];
 
        d3.json(links, function(json) {

            //console.log(json.length);

            if(json.length!=0)
            {

            var data=json;
        
                data.forEach(function(d) {

                    d.SourceSite = d.SourceSite;
                    d.Actual = +d.Actual;

                });
        data.sort(function(a,c){
            return c.Actual -a.Actual
        });  
  
 // console.log(JSON.stringify(data));

 // if(finaldata.length == 0){

        x.domain(data.map(function(d) { return d.SourceSite; }));
        y.domain([0, d3.max(data, function(d) { return d.Actual; })]);
      
        var pathvar=svg.append("path")
            .attr("class", "line")
            .attr("d", valueline(data));

        pathvar.attr("class", "in-range");

        svg.selectAll("dot")    
             .data(data)         
             .enter().append("circle")
             .attr("fill","#de825d")
             .attr("stroke","white")    
             .attr("stroke-width","7px;")                                
             .attr("r", 5)      
             .attr("cx", function(d) { return x(d.SourceSite); })
             .attr("cy", function(d) { return y(d.Actual); })     
             .on("mouseover", function(d) {     
                div.transition()        
                    .duration(200)      
                    .style("opacity", .9);      
                div.html(" SourceSite: " + (d.SourceSite) +"<br/>" + " Actual: " + (d.Actual.toFixed(2))+"% <br/> Target: 100 %") 
                    .style("left", (d3.event.pageX) + "px")     
                    .style("top", (d3.event.pageY - 28) + "px");    
                })                  
            .on("mouseout", function(d) {       
                div.transition()        
                    .duration(500)      
                    .style("opacity", 0);   
            });

       
        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")");
            //.call(xAxis);
   /* }
    else {

        x.domain(d3.extent(finaldata, function(d) { return d.ImpId; }));
        y.domain([0, d3.max(finaldata, function(d) { return d.Actual; })]);
      
        var pathvar=svg.append("path")
            .attr("class", "line")
            .attr("d", valueline(finaldata));

        pathvar.attr("class", "in-range");

        svg.selectAll("dot")    
             .data(finaldata)          
             .enter().append("circle")
             .attr("fill","#de825d")
             .attr("stroke","white")    
             .attr("stroke-width","7px;")                                
             .attr("r", 5)      
             .attr("cx", function(d) { return x(d.ImpId); })
             .attr("cy", function(d) { return y(d.Actual); })     
             .on("mouseover", function(d) {     
                div.transition()        
                    .duration(200)      
                    .style("opacity", .9);      
                div.html(" Sales Rep ID: Emp " + (d.ImpId) +"<br/>" + " Actual: " + (d.Actual) + " <br/>" + " Target: "+ (d.SRT)) 
                    .style("left", (d3.event.pageX) + "px")     
                    .style("top", (d3.event.pageY - 28) + "px");    
                })                  
            .on("mouseout", function(d) {       
                div.transition()        
                    .duration(500)      
                    .style("opacity", 0);   
            });
      
        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")");
            //.call(xAxis);
    }*/
}
else{

    alert("PoS Target Achievements Data is Not Available for Selected Criteria");
}
   });  
}

