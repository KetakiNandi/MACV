module.exports = function(app, db) {
  app.post('/SRInsightsP', (req, res) => {
  console.log(req.body);
    db.collection('AA').insert(req.body, function (err, result) {
      if (err)
         res.send('Error');
      else
        res.send('Success');

  	}); 
  });
  app.get('/SRInsightsG', (req, res) => {
    
	db.collection('BB', function(err, collection) {
             collection.find().toArray(function(err, items) {
                 console.log(items);
                 res.send(items);
             });
         });
   });

}; 