$( document ).ready(function() {  

   consecutive3DaySaleZero();
});


function consecutive3DaySaleZero(startDate,endDate){
	
	//var ArrayData=[];

var links;
 
//var dtopdown=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/consecutive3DaySaleZero.php");
/*
    
		if (startDate === undefined && endDate === undefined) {

          links=(dtopdown+"?param=");

          //console.log("Ddddddddd",links);

         
        }
        else{
          links=(dtopdown+"?startDate="+startDate+"&endDate="+endDate);
          
        }

  
	d3.json(links, function(error, ArrayData) {



ArrayData.sort(sortByDateAscending);

    function sortByDateAscending(a,b){
       return new Date(a.Date)-new Date(b.Date);
    		}

function tabulate(Arraydata, columns) {

		d3.select("#CDSZ").html("");
		var table = d3.select('#CDSZ').append('table')
		var thead = table.append('thead')
		var	tbody = table.append('tbody');

		// append the header row
		thead.append('tr')
		  .selectAll('th')
		  .data(columns).enter()
		  .append('th')
		  .text(function (column) { return column; });

		var rows = tbody.selectAll('tr')
		  .data(Arraydata)
		  .enter()
		  .append('tr');

		// create a cell in each row for each column
		var cells = rows.selectAll('td')
		  .data(function (row) {
		  	return columns.map(function (column) {
		    return {column: column, value: row[column]};
		    });

			})
		  .enter()
		  .append('td')
		  .text(function (d) { 
            return d.value; });
		  	return table;
		}
	// render the table(s)
	
	tabulate(ArrayData, ['Date','Source Site','Employee Name']);

});
*/

var svgContainer = d3.select("#CDSZ").append("svg")
                                     .attr("width", 600)
                                     .attr("height", 200)
                                     .style("fill","#EEE");

 
 //Draw the Rectangle
 var rectangle = svgContainer.append("rect")
                             .attr("x", 50)
                             .attr("y", 20)
                            .attr("width", 550)
                            .attr("height", 60);

      svgContainer.append("text")         
    			  .style("fill", "black")   
    			  .attr("x", 80)           
    			  .attr("y", 40)    
    			  .style("font-size", "14px")
       			  .text("No Staff Found With Zero Sales for 3 Consecutive Days for Year:2017-2018");     



}
