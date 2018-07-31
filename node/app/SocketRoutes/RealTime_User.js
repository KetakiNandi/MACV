//"use strict";
module.exports = function(io, db) {
  io.on('connection',   function(socket){
        let colname = db.collection('SalesperformanceValue');
        // Create function to send status
        sendStatus = function(s){
            socket.emit('status', s);
        }
        // Get chats from mongo collection
        colname.find().limit(20).sort({_id:1}).toArray(function(err, res){
            if(err){
                throw err;
            }

        //Emit the messages
        //console.log('RESPONSE',res);
        // socket.emit('output', res);
        //setInterval(function(){
        //  socket.emit('output',res);
        //}, 1000);
        //    setInterval(function(){
        //     socket.emit('date', {'date': new Date()});
        // }, 1000);
         socket.emit('news', { hello: 'world' });
         socket.on('my other event', function (data) {
           console.log(data);
         });

        });

    });  
}; 
