const app = require('http').createServer(handler)
const MongoClient    = require('mongodb').MongoClient;
const port = 3001;
var path = require('path');
var assert = require('assert');
const io = require('socket.io')(app);
var fs = require('fs');
/*const config = require('./db');

MongoClient.connect(config.DB, function(err, db) {
    if(err) {
        console.log('database is not connected')
    }
    else {
        console.log('connected!!')
    }
});*/

io.on('connection', function (socket){
   console.log('connection');

  socket.emit('news', { hello: 'Ketaki587586666' });
  socket.on('my other event', function (data) {
           console.log(data);
         });

});

function handler (req, res) {
  fs.readFile(__dirname + '/index.html',
  function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }
    res.writeHead(200);
    res.end(data);
  });
}

//For LYK Android Data
var url = 'mongodb://localhost:27017/SRI';

MongoClient.connect(url, function(err, db) {
  console.log("Connected correctly to server.");
  require('./app/SocketRoutes')(io, db);
  app.listen(port, () => {
  console.log('We are live on ' + port);
	});
});
