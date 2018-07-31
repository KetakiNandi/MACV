const express        = require('express');
//const mysqlConnect   = require('./app/routes/MySQLConnect.js');
const bodyParser     = require('body-parser');
const app            = express();
const port = 3000;
var path = require('path');

var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'admin',
  database : 'ReachOutDB' 
});


app.get('/getComment', (req, res) => {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
  res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,contenttype'); // If needed
  res.setHeader('Access-Control-Allow-Credentials', true); 
  var sql = "Select comment from comment";
	connection.query(sql, function(err, rows) {
      if (err) {
            return res.send(400, 'Couldnt get a connection');
            connection.end();
        }      
                 //console.log(rows);
        res.send(rows);
        //connection.end();
      });
   });
  

//var assert = require('assert');
//For LYK Android Data
//var url = 'mongodb://localhost:27017/AnalyticsDataDB';

//For REACHOUT ExecutiveInsights Data
//var url = 'mongodb://localhost:27017/ExecutiveInsights1';

//app.use(bodyParser.json());
//app.use(bodyParser.urlencoded({ extended: true }));
//console.log(mysqlConnect);
/*mysqlConnect.connect(function(err, db) {
 // assert.equal(null, err);
  console.log("Connected correctly to server.");
  console.log(db);
  require('./app/routes')(app, db);*/
  app.listen(port, () => {
  console.log('We are live on ' + port);
	});
//});