module.exports = function(app, db) {
  app.post('/notes', (req, res) => {
    db.collection('SnappyData1').insert(req.body, function (err, result) {
      if (err)
         res.send('Error');
      else
        res.send('Success');

  	});
   
  });
  app.get('/notesall', (req, res) => {
    
	db.collection('SnappyData', function(err, collection) {
             collection.find().toArray(function(err, items) {
                 console.log(items);
                 res.send(items);
             });
         });
   });

}; 
