const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);

io.sockets.on('connection', function (socket) {
  console.log("user connected");
  socket.on('join', (data, callback) => {
    socket.join(data.room);
    console.log("room joined");
    console.log(data.room);
    callback && callback();
  });
  socket.on('sendMessage', (data, callback) => {
    //io.sockets.in(data.room).emit('recieveMessage', data);
    io.to(data.room).emit('recieveMessage', data);
    // io.sockets.in(message.room).emit('message', message.message);
    console.log("message", data);
    callback && callback();
  });
});

const server = http.listen(8080, function () {
  console.log('listening on *:8080');
});