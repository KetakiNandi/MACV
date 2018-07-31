$( document ).ready(function() {  

   consecutive3DaySaleZero();
});


function consecutive3DaySaleZero(startDate,endDate){
	
	//var ArrayData=[];

var links;
 
var dtopdown=encodeURI("http://localhost/MACV/SalesRepInsightThree/data/consecutive3DaySaleZero.php");

    
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



}
