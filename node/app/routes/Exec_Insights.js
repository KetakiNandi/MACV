module.exports = function(app, db) {
  app.post('/execInsightsP', (req, res) => {
    db.collection('OrderData').insert(req.body, function (err, result) {
      if (err)
         res.send('Error');
      else
        res.send('Success');

  	}); 
  });
  app.get('/execInsightsG', (req, res) => {
    
	db.collection('OrderData', function(err, collection) {
             collection.find().toArray(function(err, items) {
                 console.log(items);
                 res.send(items);
             });
         });
   });

}; 
