$( document ).ready(function() {  
   KIOSK();
});


function KIOSK(startDate,endDate,zone,state,city,sourceSite,catgory,POSType){

var links;
var links1;
var FinaldataGreen=[];
var FinaldataBlue=[];
var FinaldataRed=[];

var msg = document.getElementById("DESTROY").value;
 
//var kioskcounturl=encodeURI("http://13.228.26.230/MACV/SalesRepInsightThree/data/consecutive3DaySaleZero.php");

	if (startDate === undefined && endDate === undefined && zone === undefined && state===undefined && city === undefined && sourceSite===undefined && catgory===undefined && POSType===undefined) {

      links=encodeURI(kioskcounturl+"?param="+msg);
      links1=encodeURI(kioskamturl+"?param="+msg);
//      console.log("@@@",links);
//	console.log("@@@",links1);
     }
     else if(startDate === undefined && endDate === undefined && zone && state===undefined && city === undefined && sourceSite===undefined && catgory===undefined && POSType===undefined)
    {
          links=encodeURI(kioskcounturl+"?zoneparam="+zone);
	  links1=encodeURI(kioskamturl+"?zoneparam="+zone);
         //console.log("@@@",links);
          
    }
    else if(startDate === undefined && endDate === undefined && state && zone===undefined && city === undefined && sourceSite===undefined && catgory===undefined && POSType===undefined)
    {
          links=encodeURI(kioskcounturl+"?Stateparam="+state);
          links1=encodeURI(kioskamturl+"?Stateparam="+state);
         // console.log("@@@",links);
         //d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
    }
    else if(startDate === undefined && endDate === undefined && city && zone===undefined && state === undefined && sourceSite===undefined && catgory===undefined && POSType===undefined)
    {
          links=encodeURI(kioskcounturl+"?Cityparam="+city);
          links1=encodeURI(kioskamturl+"?Cityparam="+city);
         // console.log("@@@",links);
         // d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
    }
    else if(startDate === undefined && endDate === undefined && sourceSite && zone===undefined && state === undefined && city===undefined && catgory===undefined && POSType===undefined)
    {
          links=encodeURI(kioskcounturl+"?Siteparam="+sourceSite);
	  links1=encodeURI(kioskamturl+"?Siteparam="+sourceSite);
         // console.log("@@@",links);
         // d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
    }
     else if(startDate === undefined && endDate === undefined && catgory && zone===undefined && state === undefined && city===undefined && sourceSite===undefined && POSType===undefined)
    {
          links=encodeURI(kioskcounturl+"?categoryparam="+catgory);
	  links1=encodeURI(kioskamturl+"?categoryparam="+catgory);
         //  console.log("@@@",links);
	 //  console.log("@@@",links1);
         // d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
    }
   
    else if((POSType) && zone===undefined && state === undefined && city===undefined && sourceSite===undefined && catgory===undefined && startDate === undefined && endDate === undefined)
    {
          links=encodeURI(kioskcounturl+"?POSTypeparam="+POSType);
	  links1=encodeURI(kioskamturl+"?POSTypeparam="+POSType);
         // console.log("@@@",links);
         // d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
    }
     else{
        links=encodeURI(kioskcounturl+"?startDate="+startDate+"&endDate="+endDate);
	links1=encodeURI(kioskamturl+"?startDate="+startDate+"&endDate="+endDate);
        //console.log("@@@",links);
         // d3.select("#KIOSKGREEN").remove();
	 // d3.select("#KIOSKBLUE").remove();
	 // d3.select("#KIOSKRED").remove();
     }

d3.select("#KIOSKGREEN").html("");
d3.select("#KIOSKBLUE").html("");
d3.select("#KIOSKRED").html("");

	d3.json(links1, function(error, TotalAmt) {
	  d3.json(links, function(error, TotalCount) {

//	   TotalCount.sort(function(a, c) { return c.Count - a.Count; });
	   //console.log(JSON.stringify(TotalCount));
//	   var MaxCount = d3.entries(TotalCount)[0];
	   var MaxCount = TotalCount.length;
	 // console.log(MaxCount.value.Count);
	   var SumOfAmt = d3.nest()
		.rollup(function(v) { 
		 return {
		  total: d3.sum(v, function(d) { return d.Amount; })};
		}).entries(TotalAmt);
	   // console.log(SumOfAmt.total);
            var AvgAmt = (SumOfAmt.total/MaxCount);
	   // console.log(AvgAmt);
            var TwentyPercentOfAvgAmt = ((AvgAmt*20)/100); 
	  // console.log(AvgAmt+TwentyPercentOfAvgAmt);
           var AvgPlusTwentyPercent =AvgAmt+TwentyPercentOfAvgAmt;
	   TotalAmt.forEach(function(e,i) {
    		if(e.Amount >=AvgPlusTwentyPercent)
		{
			FinaldataGreen.push({'PosCode': e.PosCode,'PosName':e.PosName,'AVG':e.Amount});
			if(FinaldataGreen.length!=0)
			{
			   function tabulateGreen(FinaldataGreen, columns) {
				d3.select("#KIOSKGREEN").html("");
				var table = d3.select('#KIOSKGREEN').append('table')
				var thead = table.append('thead')
				var	tbody = table.append('tbody');

				// append the header row
				thead.append('tr')
				  .selectAll('th')
				  .data(columns).enter()
				  .append('th')
				  .text(function (column) { return column; });

				var rows = tbody.selectAll('tr')
				  .data(FinaldataGreen)
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
	
			tabulateGreen(FinaldataGreen, ['PosCode','PosName','AVG']);
		      }
		      else
			{
			alert("Green KIOSK Data is not available for Selected Criteria");
			}
		}
		else if(e.Amount >=AvgAmt && e.Amount <AvgPlusTwentyPercent)
		{
		 	FinaldataBlue.push({'PosCode': e.PosCode,'PosName':e.PosName,'AVG':e.Amount});
			if(FinaldataBlue.length!=0)
			{
			   function tabulateBlue(FinaldataBlue, columns) {

				d3.select("#KIOSKBLUE").html("");
				var table = d3.select('#KIOSKBLUE').append('table')
				var thead = table.append('thead')
				var	tbody = table.append('tbody');

				// append the header row
				thead.append('tr')
				  .selectAll('th')
				  .data(columns).enter()
				  .append('th')
				  .text(function (column) { return column; });

				var rows = tbody.selectAll('tr')
				  .data(FinaldataBlue)
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
	
			tabulateBlue(FinaldataBlue, ['PosCode','PosName','AVG']);
		    }
		    else
		    {
			alert("Blue KIOSK Data is not available for Selected Criteria");
		    }
		}
	   	else{
			FinaldataRed.push({'PosCode': e.PosCode,'PosName':e.PosName,'AVG':e.Amount});
			if(FinaldataRed.length!=0)
			{
				function tabulateRed(FinaldataRed, columns) {

				d3.select("#KIOSKRED").html("");
				var table = d3.select('#KIOSKRED').append('table')
				var thead = table.append('thead')
				var	tbody = table.append('tbody');

				// append the header row
				thead.append('tr')
				  .selectAll('th')
				  .data(columns).enter()
				  .append('th')
				  .text(function (column) { return column; });

				var rows = tbody.selectAll('tr')
				  .data(FinaldataRed)
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
	
			tabulateRed(FinaldataRed, ['PosCode','PosName','AVG']);
		     }
		     else
		      {
			alert("Red KIOSK Data is not available for Selected Criteria");
			}
		}	
		
	   });
	//console.log(JSON.stringify(Finaldata));

});

});

}
