var app = require('http').createServer(handler)
var io = require('socket.io')(app);
var fs = require('fs');

app.listen(8085);

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

io.on('connection', function (socket) {
  // socket.emit('news', { hello: 'world' });
  // socket.on('my other event', function (data) {
  //   console.log(data);
  // });
  setInterval(function(){
        socket.emit('date', {'date': new Date()});
    }, 1000);
});



// const mongo = require('mongodb').MongoClient;
// const client = require('socket.io').listen(3006).sockets;

// // Connect to mongo
// mongo.connect('mongodb://127.0.0.1/SRI', function(err, db){
//     if(err){
//         throw err;
//     }

//     console.log('MongoDB connected...');

//     // Connect to Socket.io
//     client.on('connection',   function(socket){
//         let chat = db.collection('SalesperformanceValue');

//         // Create function to send status
//         sendStatus = function(s){
//             socket.emit('status', s);
//         }

//         // Get chats from mongo collection
//         chat.find().limit(2).sort({_id:1}).toArray(function(err, res){
//             if(err){
//                 throw err;
//             }

//             // Emit the messages
//            // console.log('RESPONSE',res);
//             socket.emit('output', res);

//         });



        // Handle input events
        // socket.on('input', function(data){
        //     let name = data.name;
        //     let message = data.message;

        //     // Check for name and message
        //     if(name == '' || message == ''){
        //         // Send error status
        //         sendStatus('Please enter a name and message');
        //     } else {
        //         // Insert message
        //         chat.insert({name: name, message: message}, function(){
        //             client.emit('output', [data]);

        //             // Send status object
        //             sendStatus({
        //                 message: 'Message sent',
        //                 clear: true
        //             });
        //         });
        //     }
        // });

        // Handle clear
        // socket.on('clear', function(data){
        //     // Remove all chats from collection
        //     chat.remove({}, function(){
        //         // Emit cleared
        //         socket.emit('cleared');
        //     });
        // });
    //});
//});