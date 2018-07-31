module.exports = function(app, db) {
  app.post('/SRInsightsP', (req, res) => {
  //console.log(req.body.TimeStamp);
  var today_date = new Date(Number(req.body.TimeStamp));
  var everyday_date = new Date(Number(req.body.date));
  //console.log(today_date.toISOString());
  //req.body.TimeStamp = start_date.toISOString();
  var dbdoc = req.body;
  dbdoc.TimeStamp = new Date(today_date.toISOString());
  dbdoc.date = new Date(everyday_date.toISOString());  
  //console.log(dbdoc);
  var colName = req.body.ColName;
  delete req.body.ColName;
    db.collection(colName).insert(req.body, function (err, result) {
      if (err)
         res.send('Error');
      else
        res.send('Success');

  	}); 
  });
  app.get('/SRInsightsG', (req, res) => {
    
	db.collection('BB', function(err, collection) {
             collection.find().toArray(function(err, items) {
                 //console.log(items);
                 res.send(items);
             });
         });
   });

}; 
