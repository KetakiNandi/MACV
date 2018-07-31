const express        = require('express');
const MongoClient    = require('mongodb').MongoClient;
const bodyParser     = require('body-parser');
const app            = express();
const port = 3000;
var path = require('path');
var assert = require('assert');
//For LYK Android Data
//var url = 'mongodb://localhost:27017/AnalyticsDataDB';

//For REACHOUT ExecutiveInsights Data
var url = 'mongodb://localhost:27017/FFF';
var url1 = 'mongodb://localhost:27017/SRI';

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

MongoClient.connect(url, function(err, db) {
  //assert.equal(null, err);
  console.log("Connected correctly to server.");
  require('./app/routes')(app, db);
  app.listen(port, () => {
  console.log('We are live on ' + port);
	});
});

MongoClient.connect(url1, function(err, db) {
  //assert.equal(null, err);
  console.log("Connected correctly to server.");
  require('./app/routesMACV')(app, db);
//  app.listen(port, () => {
  console.log('We are live on ' + port);
	});
//});

