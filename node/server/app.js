'use strict';

var express = require('express');
var app = express();

/**
 *  Allows third party clients to connect to the socket server
 */
app.use(function(request, response, next) {
    response.setHeader('Access-Control-Allow-Origin', '*');
    next();
});

var server = require('http').createServer(app);
var io = require('socket.io').listen(server);

server.on('upgrade', function(req, socket, head) {
    console.log('upgrading');
    socket.write('HTTP/1.1 101');
    
});

/**
 *  Have our server listen on port 3000
 */
var port = process.env.PORT || 3000;
server.listen(port, function(){
    console.log('Server listening on port %d', port);
});

/**
 *  Server static assets out of the `public` directory
 */
app.use(express.static('public'));

/**
 *  Send the `public/index.html` to the browser
 */
app.get('/', function(req, res){
    res.sendfile('public/index.html');
});

var socket;

app.on('upgrade', function(req, sock) {
    console.log('upgrading....');
    socket = sock;
    socket.write('hello');
});


var clients = {};

/**
 *  Watch for connections
 */
io.sockets.on('connection', function(socket){
    console.log('Client connected with id: ' + socket.id);

    socket.on('register', function(data){
        //register client
        if(clients[data.username] && clients[data.username].sockets instanceof Array){
            //If a user is already registered with one or many sockets/clients
            //just push socket id to array of sockets
            clients[data.username].sockets.push(socket.id);
        }else{
            //if it is the first socket/client and an array and push socket id
            clients[data.username] = { sockets:[]};
            clients[data.username].sockets.push(socket.id);
        }
        console.log('register', clients);
    });


    socket.on('broadcast',function(data){
        console.log("Broadcast data");
        console.log(data);
        socket.broadcast.emit('feed', {
            message: data
        });
    });

    socket.on('upgrade',function(data){
        socket.write('HTTP/1.1 101');
    });

    socket.on('disconnect',function(data){
        console.log("client disconnected :" + data);
    });
});
