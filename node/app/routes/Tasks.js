/*module.exports = function(app, db) {
  app.get('/getComment', (req, res) => {
  //var sql = mysql.format("Select comment from comment");
	/*db.query("Select comment from comment", function(err, rows, fields) {
    console.log(err);
      if (err) {
            db.end();
            return res.send(400, 'Couldnt get a connection');
        }      
                 console.log(rows);
                 res.send(rows);
                 db.end();
             });
   });
   console.log(db);
}; 
*/