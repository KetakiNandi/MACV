var express = require('express');
var kafka = require('kafka-node');
var app = express();
//var server = require('http').Server(app);
var io = require('socket.io-client');
var fs = require('fs');

var bodyParser = require('body-parser')
app.use( bodyParser.json() );       // to support JSON-encoded bodies
app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
  });

       

//var dataStreamFinal='';

var socket = io.connect('http://localhost:3001', {reconnect: true});
var HighLevelProducer;


socket.on('connect', function (socket1) {
    console.log('Connected!');
    
});



socket.on('news', function (data) {
//socket.emit('my other event', { my: data });
//dataStreamFinal = '[' + JSON.stringify(data) + ']';
//console.log(dataStreamFinal);
console.log("1111");
var payloads = [
        { topic: 'TutorialTopic', messages: JSON.stringify(data)}
    ];
console.log("2222");
HighLevelProducer = kafka.HighLevelProducer,
        client = new kafka.KafkaClient(),
        producer = new HighLevelProducer(client);
	
console.log("3333");
producer.on('error', function (err) {
    console.log('Producer is in error state');
    console.log(err);
})
producer.on('ready', function () {
        console.log("4444");
        producer.send(payloads, function (err, data) {
 
        //console.log("PRODUCER",data);
    });
});


 });
	

  //  });  

/*var Producer = kafka.Producer,
    client = new kafka.KafkaClient(),
    producer = new Producer(client);

producer.on('ready', function () {
    console.log('Producer is ready');
});*/



app.get('/',function(req,res){
    res.json({greeting:'Kafka Producer'})
});

/*app.post('/sendMsg',function(req,res){
    var sentMessage = JSON.stringify(req.body.message);
    payloads = [
        { topic: req.body.topic, messages:sentMessage , partition: 0 }
    ];
    producer.send(payloads, function (err, data) {
            res.json(data);
    });
    
})*/

app.listen(5001,function(){
    console.log('Kafka producer running at 5001')
}) 
/*
Consumer = kafka.Consumer,
    //client = new kafka.KafkaClient(),
    consumer = new Consumer(client,
        [{ topic: 'TutorialTopic', offset: 0}],
        {
            autoCommit: false
        }
    );

consumer.on('message', function (message) {
    console.log(message);
});

consumer.on('error', function (err) {
    console.log('Error:',err);
})

consumer.on('offsetOutOfRange', function (err) {
    console.log('offsetOutOfRange:',err);
})
*/	
