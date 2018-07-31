var request = require('request');
var requestsa = require('superagent');
var http = require('http');

//Lets configure and request
//var serverurl = 'http://localhost:8090/productreview/rest';
var serverurl = 'http://demo.reverieinc.com/parabola/transliterateSimpleJSON';
var xauthtoken;
	requestsa
	   .post(serverurl)
	   .send({
			"inArray": [
				"Kolkata",
				"Bengaluru",
			],
		"REV-APP-ID": "com.suryaprabha.logisticsclient",
		"REV-API-KEY": "LihDFND1t1GfGuIzpYFzeISJ2NVlEHfxtK3e",
		"domain": 9,
		"language": "hindi",
		"originLanguage": "hindi",
		"webSdk": 0
		})
	   .set('Content-Type', 'application/json; charset=UTF-8')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });

/*

request({
    url: serverurl+'/getCategories', //URL to hit
    method: 'POST', //Specify the method
    headers: { //We can define headers too
        'X-Username': '9963236611',
        'X-Password': 'master'
    }
}, function(error, response, body){
    if(error) {
        console.log(error);
    } else {
	//getProductTypesByCategory                                                                
	//getBrandsByProductType                                                                     
	//getSeriesByBrand
	// db.series.find({$and:[{"category.categoryname":"Smart Phones"},{"producttype.producttype":"Android"},{"brand.brandname":"LG"}]}).count();
        console.log(response.statusCode, response.headers['x-auth-token']);
	xauthtoken = response.headers['x-auth-token'];
	//testResult(serverurl+'/getMainCategories/',xauthtoken);	
	// Output -> '["Mobiles","Computers","Home Appliances","Camera,Audio,Video"]'

	//testResult(serverurl+'/getCategoriesByMainCategory/Mobiles',xauthtoken);	
	// Output -> '[{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},{"categoryid":"11","categoryname":"Feature Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991478}]'

	//testResult(serverurl+'/getProductTypesByCategory/26600014169190527208284991468',xauthtoken);	
	// Output -> '["Android","Windows","IOS","Nokia OS"]'

	//testResult(serverurl+'/getBrandsByProductType/Android',xauthtoken);	
	// Output -> '["LG","Lenovo","Asus","Lava","Sony","Micromax","Intex","Samsung","HTC","Honor","Motorola","Mi","Alcatel","Spice","OnePlus","Karbonn"]'
	
	//testResult(serverurl+'/getSeriesByBrand/Smart Phones/Android/Spice',xauthtoken);
	// Output -> [{"brand":{"brandid":null,"brandname":"Spice","category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014408998200166509215558,"product":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014372104712019090109728,"productid":"60","productname":"Spice Dream Uno Mi-498","score":null},"producttype":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014390551456092799662668,"product":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014372104712019090109728,"productid":"60","productname":"Spice Dream Uno Mi-498","score":null},"producttype":"Android","producttypeid":null}},"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014408998200166509216830,"product":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014372104712019090109728,"productid":"60","productname":"Spice Dream Uno Mi-498","score":null},"producttype":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014390551456092799662668,"product":{"category":{"categoryid":"1","categoryname":"Smart Phones","fileName":null,"fileupload":null,"id":26600014169190527208284991468},"fileName":null,"fileupload":null,"id":26600014372104712019090109728,"productid":"60","productname":"Spice Dream Uno Mi-498","score":null},"producttype":"Android","producttypeid":null},"seriesid":null,"seriesname":"Dream Uno Mi-498"}]

	testResult(serverurl+'/getProductScore/26600014372104712019090109669',xauthtoken);
	//'{"pdto":{"id":null,"categoryid":26600014169190527208284991468,"productid":"1","productname":"LG Nexus 5","score":"111.40500328099802","filename":null},"ascore":[{"attribute":"Additional Features","score":168.75,"type":"A"},{"attribute":"Bluetooth","score":93.75,"type":"A"},{"attribute":"Brand","score":225.0,"type":"A"},{"attribute":"Call Features","score":161.11111,"type":"A"},{"attribute":"Form","score":99.03846,"type":"A"},{"attribute":"Front Facing Camera","score":100.0,"type":"A"},{"attribute":"Graphics","score":108.333336,"type":"A"},{"attribute":"Important Apps","score":126.27119,"type":"A"},{"attribute":"In the Box","score":253.125,"type":"A"},{"attribute":"Internal","score":50.0,"type":"A"},{"attribute":"Internet Features","score":116.666664,"type":"A"},{"attribute":"Memory","score":100.0,"type":"A"},{"attribute":"Model ID","score":66.666664,"type":"A"},{"attribute":"Model Name","score":106.14035,"type":"A"},{"attribute":"Music Player","score":90.0,"type":"A"},{"attribute":"Navigation Technology","score":133.33333,"type":"A"},{"attribute":"NFC","score":100.0,"type":"A"},{"attribute":"Operating Freq","score":64.28571,"type":"A"},{"attribute":"OS","score":115.46392,"type":"A"},{"attribute":"Other Camera Features","score":105.0,"type":"A"},{"attribute":"Other Display Features","score":85.18519,"type":"A"},{"attribute":"Phone Book Memory","score":50.0,"type":"A"},{"attribute":"Preinstalled Browser","score":66.666664,"type":"A"},{"attribute":"Processor","score":93.13725,"type":"A"},{"attribute":"Rear Camera","score":112.06896,"type":"A"},{"attribute":"Resolution","score":100.0,"type":"A"},{"attribute":"Sensors","score":87.5,"type":"A"},{"attribute":"SIM Type","score":100.0,"type":"A"},{"attribute":"Size","score":94.117645,"type":"A"},{"attribute":"SMS Memory","score":-0.0,"type":"A"},{"attribute":"Sound Enhancement","score":205.0,"type":"A"},{"attribute":"Standby Time","score":100.0,"type":"A"},{"attribute":"Talk Time","score":243.75,"type":"A"},{"attribute":"Touch Screen","score":140.0,"type":"A"},{"attribute":"Type","score":200.0,"type":"A"},{"attribute":"USB Connectivity","score":50.0,"type":"A"},{"attribute":"Video Player","score":100.0,"type":"A"},{"attribute":"Warranty Summary","score":153.75,"type":"A"},{"attribute":"Weight","score":-62.5,"type":"A"},{"attribute":"Wifi","score":150.0,"type":"A"}],"fscore":[]}'



	//testResult(serverurl+'/getCategoriesByMainCategory/Computers',xauthtoken);	
	//testResult(serverurl+'/getCategories',xauthtoken);
	//testResult(serverurl+'/getCategoryById/26600014169190527208284991477',xauthtoken);
	//testResult(serverurl+'/getProductsByCategory/26600014169190527208284991478',xauthtoken);
	//testResult(serverurl+'/getAllProducts',xauthtoken);
	//testResult(serverurl+'/getProductTypesByCategory/26600014169190527208284991477',xauthtoken);
	//testResult(serverurl+'/getProductTypesByProduct/26600014372104712019090110991',xauthtoken);
	//testResult(serverurl+'/getAllProductTypes',xauthtoken);
	//testResult(serverurl+'/getAllBrands',xauthtoken);
	//testResult(serverurl+'/getBrandsByCategory/26600014169190527208284991478',xauthtoken);
	//testResult(serverurl+'/getBrandsByProduct/26600014372104712019090110991',xauthtoken);
	//testResult(serverurl+'/getAllSeries',xauthtoken);
	//testResult(serverurl+'/getSeriesByCategory/26600014169190527208284991478',xauthtoken);
	//testResult(serverurl+'/getSeriesByProduct/26600014372104712019090109672',xauthtoken); 
	//testResult(serverurl+'/getSeriesByProductType/26600014390551456092799662609',xauthtoken);
	


	
	/*
	
	requestsa
	   .post(serverurl+'/insertComment')
	   .send({"categoryid":"1","productid":"4","producttypeid":"3","userid":"1","reviewid":"2","subject":"ffgffgffg","text":"sdsdss"})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	


	requestsa
	   .post(serverurl+'/followReviewByReviewID')
	   .send({"userid":"1","reviewid":"2"})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	
	requestsa
	   .post(serverurl+'/insertDiscussion')
	   .send({"categoryid":"2","productid":"1","producttypeid":"2","userid":"1","subject":"New Discussion","text":"good one"})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });

	  requestsa
	   .post(serverurl+'/followDiscussionByDiscussionID')
	   .send( {"userid":"1","discussionid":"1"})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	requestsa
	   .post(serverurl+'/redeemReward')
	   .send( {"userid":"1","rewardcatalogid":"1","debitcredit":"debit","reason":"nothing","redeemaddress":"some address","redeemaddressoncheque":"same","points":60})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	
	requestsa
	   .post(serverurl+'/register')
	   .send( {
		"username":"96101001","name":"pix1","displayname":"pixeltech1","gender":"male","email":"pix@gmail.com",
		"rewardimage":"sdsdsds","deviceid":"01","devicemodel":"02","deviceosversion":"aaaaa","address":"some addrs",
		"secretquestion":"none","secretanswer":"none","password":"admin","location":"dddd","gcmMPushToken":"123"
		} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });//Error	
	
	requestsa
	   .post(serverurl+'/insertReview/1')
	   .send( {"categoryid":"1","productid":"4","producttypeid":"3","userid":"1","subject":"ffgffgffg","text":"sdsdss"} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });//Error
	requestsa
	   .post(serverurl+'/insertDiscussionComment')
	   .send({"categoryid":"2","productid":"1","producttypeid":"1","userid":"1","discussionid":"1","subject":"New Discussion comment","text":"good discussion comment"})
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });// Error	

	
	requestsa
	   .post('http://52.26.5.8:8080/product/register')
	   .send( {"username":"9610000006","name":"pix","displayname":"pixeltech4","gender":"male","email":"pix@gmail.com",
		"rewardimage":"sdsdsds","deviceid":"01","devicemodel":"02","deviceosversion":"aaaaa","address":"some addrs",
		"secretquestion":"none","secretanswer":"none","password":"admin","location":"dddd","gcmMPushToken":"123"
		} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	

	requestsa
	   .post('http://52.26.5.8:8080/product/rest/insertReview')
	   .send( {"categoryid":"1","productid":"1","producttypeid":"2","userid":"9600022890",
		"subject":"insert review thru rest","text":" is success?"} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });
	
	requestsa
	   .post('http://52.26.5.8:8080/product/rest/insertReview')
	   .send( {"categoryid":"1","productid":"1","producttypeid":"2","userid":"9600022890",
		"subject":"insert review thru rest","text":" is success?"} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });*/
/*
requestsa
	   .post('http://52.26.5.8:8080/product/rest/insertDiscussionComment')
	   .send( {"categoryid":"1","productid":"1","producttypeid":"1","userid":"user","discussionid":"1","subject":"New Discussion comment","text":"good discussion comment"} )
	   .set('X-Auth-Token', xauthtoken)
	   .set('Accept', 'application/json')
	   .end(function(err, res){
	     if (res.ok) {
	       console.log('got ' + JSON.stringify(res.body));
	     } else {
	       console.log('Oh no! error ' + res.text);
	     }
	   });


	
	
    }
});

function testResult(totalURL,authtoken)
{
	request({
	    url: totalURL, //URL to hit
	    method: 'GET', //Specify the method
	    headers: { //We can define headers too
		'X-Auth-Token': authtoken
	    }
	}, function(error, response, body){
	    if(error) {
		console.log(error);
	    } else {
		console.log(response.statusCode, response.body);
	    }
	});
}

*/

